<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\MassiveInvoice;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    /**
     * @var array|string[]
     */
    private array $monthsDetails = [
        'ENERO' => 'ENERO', 'FEBRERO' => 'FEBRERO', 'MARZO' => 'MARZO', 'ABRIL' => 'ABRIL',
        'MAYO' => 'MAYO', 'JUNIO' => 'JUNIO', 'JULIO' => 'JULIO', 'AGOSTO' => 'AGOSTO', 'SEPTIEMBRE' => 'SEPTIEMBRE',
        'OCTUBRE' => 'OCTUBRE', 'NOVIEMBRE' => 'NOVIEMBRE', 'DICIEMBRE' => 'DICIEMBRE'
    ];

    /**
     * @var array|string[]
     */
    private array $monthsNumber = [
        '01' => 'ENERO', '02' => 'FEBRERO', '03' => 'MARZO', '04' => 'ABRIL', '05' => 'MAYO', '06' => 'JUNIO',
        '07' => 'JULIO', '08' => 'AGOSTO', '09' => 'SEPTIEMBRE', '10' => 'OCTUBRE', '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE'
    ];

    private int $valueInvoice = 10000;

    /**
     * Lista todas las facturas
     *
     */
    public function list()
    {
        $invoices = Invoice::all();
        //return $invoices;
        return view('invoice.list', compact('invoices'));
    }


    /**
     * Mostrar formulario para crear una factura
     *
     */
    public function create()
    {
        $user = new User();
        $data_users = $user->getDocumentAndName();

        $current_month = $this->monthsNumber[date('m')];

        // Eliminar del listado de meses, el mes actual para que no se repita en el select
        unset($this->monthsDetails[$current_month]);

        //return $users;
        return view('invoice.create', ['data_users' => $data_users, 'months' => $this->monthsDetails, 'current_month' => $current_month]);
    }

    /**
     * Validar información de factura y generar
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'valueInvoice' => ['required', 'numeric'],
            'descriptionInvoice' => ['required', 'string']
        ]);

        $invoice = new Invoice();
        $invoice->value = $request->valueInvoice;
        $invoice->year_invoiced = date('Y');
        $invoice->month_invoiced = $request->monthInvoice;
        $invoice->description = $request->descriptionInvoice;
        $invoice->status = 'PENDIENTE';
        $invoice->concept = $request->conceptInvoice;
        $invoice->user_id = $request->userInvoice;
        $invoice->subscription_id = $request->serviceUser;

        $invoice->save();

        return redirect()->route('invoice.list');
    }

    /**
     * Create monthly invoices for all users automatically
     *
     * @return RedirectResponse
     */
    public function createMassive(): RedirectResponse
    {
        $user_model = new User();
        $users = $user_model::where('status', 'ACTIVO')->get();
        $massive_invoice = new MassiveInvoice();

        $current_month = $this->monthsNumber[date('m')];
        $message_type = 'error';
        $message = 'No se pueden volver a generar el masivo de facturas del mes de ' . $current_month;

        $last_massive_invoice = $massive_invoice::all()->last();
        $last_month_massive_invoice = $last_massive_invoice?->month;

        $users_without_invoices = $this->getUsersWithoutInvoices($users, $current_month);
        if ($last_month_massive_invoice === NULL || $last_month_massive_invoice != $current_month) {
            foreach ($users_without_invoices as $user) {
                $services_by_user = $user->services;
                foreach ($services_by_user as $service) {
                    $invoice = new Invoice();
                    $invoice->value = $user->full_payment === 'SI' ? $this->valueInvoice : $this->valueInvoice/2;
                    $invoice->description = 'Servicio acueducto ' . $service->service;
                    $invoice->year_invoiced = date('Y');
                    $invoice->month_invoiced = $current_month;
                    $invoice->concept = 'MENSUALIDAD';
                    $invoice->status = 'PENDIENTE';
                    $invoice->user_id = $user->id;
                    $invoice->subscription_id = $service->id;

                    $invoice->save();
                }
            }

            $massive_invoice->year = date('Y');
            $massive_invoice->month = $current_month;
            $massive_invoice->status = 'GENERADO';
            $massive_invoice->save();

            $message_type = 'success';
            $message = 'Se acaba de generar el masivo de facturas del mes de ' . $current_month;
        }
        return redirect()->route('invoice.list')->with($message_type, $message);
    }

    public function show(Invoice $invoice, Payment $payment)
    {
        $payments = $invoice::find($invoice->id)->payments;
        $pago_realizado = $payment->getTotalPayment($payments);
        $payment_total = '$' . number_format(num: $pago_realizado, thousands_separator: '.') ?? '$0';

        return view('invoice.show', compact('invoice', 'payments', 'payment_total'));
    }

    /**
     * Generate N number of invoices by user
     *
     * @param User $user
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function createInvoicesByUser(User $user, Request $request): RedirectResponse
    {
        $months_data = $request->post();
        $current_year = date('Y') !== $request->year ? date('Y') : $request->year;

        unset($months_data['_token'], $months_data['year']);

        $message_type = 'error';
        $message = 'Debe seleccionar por lo menos un mes';
        if (!empty($months_data)) {
            foreach ($months_data as $month) {
                $invoice = new Invoice();

                $invoice->value = 10000;
                $invoice->description = 'Servicio de agua mensual';
                $invoice->year_invoiced = $current_year;
                $invoice->month_invoiced = $month;
                $invoice->concept = 'MENSUALIDAD';
                $invoice->status = 'PENDIENTE';
                $invoice->user_id = $user->id;
                $invoice->save();
            }
            $message_type = 'success';
            $message = 'Se acaban de generar facturas para pago adelantado';
        }
        return redirect()->route('user.show', $user->id)->with($message_type, $message);
    }

    /**
     * Get all users without invoices.
     *
     * @param $users
     * @param $current_month
     *
     * @return array
     */
    public function getUsersWithoutInvoices($users, $current_month):array
    {
        $invoice = new Invoice();
        $usuarios_por_facturar = [];
        foreach ($users as $user) {
            $mesActualYaFacturado = true;
            $invoices = $invoice::where(['user_id' => $user->id, 'month_invoiced' => $current_month, 'concept' => 'MENSUALIDAD'])->get();
            foreach ($invoices as $factura) {
                $mesActualYaFacturado = $factura['month_invoiced'] !== $current_month;
            }

            if ($mesActualYaFacturado) {
                $usuarios_por_facturar[] = $user;
            }
        }
        return $usuarios_por_facturar;
    }

}
