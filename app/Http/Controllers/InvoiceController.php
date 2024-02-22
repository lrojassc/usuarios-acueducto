<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
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
        $invoice->month_invoiced = $request->monthInvoice;
        $invoice->description = $request->descriptionInvoice;
        $invoice->status = 'PENDIENTE';
        $invoice->concept = $request->conceptInvoice;
        $invoice->user_id = $request->userInvoice;

        $invoice->save();

        return redirect()->route('invoice.list');
    }

    public function createMassive(): RedirectResponse
    {
        $users = User::all();
        $current_month = $this->monthsNumber[date('m')];

        foreach ($users as $user) {
            $invoice = new Invoice();

            $invoice->value = 10000;
            $invoice->description = 'Servicio de agua mes - ' . $current_month;
            $invoice->month_invoiced = $current_month;
            $invoice->concept = 'MENSUALIDAD';
            $invoice->status = 'PENDIENTE';
            $invoice->user_id = $user->id;

            $invoice->save();
        }

        return redirect()->route('invoice.list');
    }

    public function show(Invoice $invoice)
    {
        return view('invoice.show', compact('invoice'));
    }

}