<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{

    protected static string $password;

    private int $value_subscription = 700000;

    /**
     * @var array|string[]
     */
    private array $monthsNumber = [
        '01' => 'ENERO', '02' => 'FEBRERO', '03' => 'MARZO', '04' => 'ABRIL', '05' => 'MAYO', '06' => 'JUNIO',
        '07' => 'JULIO', '08' => 'AGOSTO', '09' => 'SEPTIEMBRE', '10' => 'OCTUBRE', '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE'
    ];

    /**
     * Listar usuarios
     *
     */
    public function list() {
        $users = User::all();

        return view('user.list', compact('users'));
    }

    /**
     * Renderizar vista que muestra formulario de creación de usuario
     *
     */
    public function create() {
        return view('user.create', ['user' => new User()]);
    }

    /**
     * Crear nuevo usuario, incluida suscripción y factura
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse {
        $request->validate([
            'userName' => ['required', 'string'],
            'userDocumentNumber' => ['required', 'numeric', 'digits_between:7,12'],
            'userEmail' => ['nullable'],
            'userPhoneNumber' => ['required', 'numeric', 'digits:10'],
            'userOldCode' => ['nullable'],
            'userAddress' => ['required', 'string'],
            'userCity' => ['required', 'string'],
            'userMunicipality' => ['required', 'string'],
        ]);

        $user = new User();

        $user->name = $request->userName;
        $user->document_type = $request->userDocumentType;
        $user->document_number = $request->userDocumentNumber;
        $user->email = $request->userEmail;
        $user->phone_number = $request->userPhoneNumber;
        $user->address = $request->userAddress;
        $user->city = $request->userCity;
        $user->municipality = $request->userMunicipality;
        $user->old_code = $request->userOldCode;
        $user->password = static::$password ??= Hash::make($request->userDocumentNumber);
        $user->paid_subscription = 'DEBE';
        $user->status = 'ACTIVO';

        if ($user->save()) {
            $subscription = new Subscription();
            $user_id = $user::all()->last()->id;
            $subscription->service = 'Residencial 1';
            $subscription->user_id = $user_id;

            if ($subscription->save()) {
                $invoice = new Invoice();
                $invoice->value = $this->value_subscription;
                $invoice->description = 'Suscripción al servicio de acueducto';
                $invoice->year_invoiced = date('Y');
                $invoice->month_invoiced = $this->monthsNumber[date('m')];
                $invoice->concept = 'SUSCRIPCION';
                $invoice->status = 'PENDIENTE';
                $invoice->user_id = $user_id;
                $invoice->save();
            }
        }

        return redirect()->route('user.list');
    }

    public function edit(User $user) {
        return view('user.show', ['mode' => 'edit'], compact('user'));
    }

    /**
     * Ver información detallada del usuario
     *
     * @param User $user
     * @param Invoice $invoice
     *
     */
    public function show(User $user, Invoice $invoice) {
        $invoices_by_user = User::find($user->id())->invoices;
        $services_by_user = User::find($user->id())->services;
        $total_invoices = $this->getTotalInvoices($invoices_by_user);
        $total_facturas = $total_invoices['total_valor_pendiente'] + $total_invoices['total_pagos_realizados'];

        return view('user.show', [
            'mode' => 'show',
            'user' => $user,
            'invoices' => $invoices_by_user,
            'services' => $services_by_user,
            'total_invoices' => '$' . number_format(num: $total_invoices['total_valor_pendiente'], thousands_separator: '.'),
            'total_pagos_realizados' => '$' . number_format(num: $total_invoices['total_pagos_realizados'], thousands_separator: '.'),
            'total_facturas' => '$' . number_format(num: $total_facturas, thousands_separator: '.')
        ]);
    }

    /**
     * Actualizar información del usuario
     *
     * @param Request $request
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'editUserName' => ['required', 'string'],
            'editUserPhoneNumber' => ['required', 'numeric'],
            'editUserAddress' => ['required', 'string']
        ]);

        $user->name = $request->editUserName;
        $user->email = $request->editUserEmail;
        $user->phone_number = $request->editUserPhoneNumber;
        $user->address = $request->editUserAddress;
        $user->old_code = $request->editUserOldCode;
        $user->active_services = $request->editActiveServices;

        $user->save();

        return redirect()->route('user.list');
    }

    /**
     * Importar datos de tabla excel
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function import(Request $request): RedirectResponse
    {
        $file = $request->file('import_file_users');
        Excel::import(new UsersImport, $file);
        return redirect()->route('user.list')->with('success', 'Usuarios importados exitosamente');
    }


    /**
     * Obtener el total de facturas y sus saldos correspondientes
     *
     * @param $invoices_by_user
     *
     * @return array
     */
    public function getTotalInvoices($invoices_by_user): array
    {
        $payment = new Payment();
        $total_valor_pendiente = 0;
        $total_pagos_realizados = 0;

        foreach ($invoices_by_user as $invoice) {
            $value_invoice_pendiente = (int)str_replace(["$", "."], '', $invoice->value);
            $total_valor_pendiente += $value_invoice_pendiente;

            $payments = Invoice::find($invoice->id)->payments;
            $pago_realizado = $payment->getTotalPayment($payments);
            $total_pagos_realizados += $pago_realizado;
        }

        $total_invoices['total_valor_pendiente'] = $total_valor_pendiente;
        $total_invoices['total_pagos_realizados'] = $total_pagos_realizados;

        return $total_invoices;
    }
}
