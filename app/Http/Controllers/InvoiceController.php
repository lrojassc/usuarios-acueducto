<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class InvoiceController extends Controller
{

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

        //return $users;
        return view('invoice.create', ['data_users' => $data_users]);
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
        $invoice->description = $request->descriptionInvoice;
        $invoice->status = 'PENDIENTE';
        $invoice->concept = $request->conceptInvoice;
        $invoice->user_id = $request->userInvoice;

        $invoice->save();

        return redirect()->route('invoice.list');
    }

    public function createMassive() {
        $users = User::all();
        $months = [
            '01' => 'ENERO', '02' => 'FEBRERO', '03' => 'MARZO', '04' => 'ABRIL', '05' => 'MAYO', '06' => 'JUNIO',
            '07' => 'JULIO', '08' => 'AGOSTO', '09' => 'SEPTIEMBRE', '10' => 'OCTUBRE', '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE'
        ];
        $current_month = $months[date('m')];

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
}
