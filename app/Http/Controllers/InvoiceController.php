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
        $invoice->user_id = $request->userInvoice;

        $invoice->save();

        return redirect()->route('invoice.list');
    }

    public function createMassive() {
        $users = User::all();

        foreach ($users as $user) {
            $invoice = new Invoice();

            $invoice->value = 10000;
            $invoice->description = 'Servicio mes: ' . 'Febrero';
            $invoice->status = 'PENDIENTE';
            $invoice->user_id = $user->id;

            $invoice->save();
        }

        return redirect()->route('invoice.list');
    }
}
