<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function list()
    {
        $payments = Payment::all();
        return view('payment.list', compact('payments'));
    }

    public function show(Payment $payment)
    {
        return view('payment.show', compact('payment'));
    }

    public function payment(Request $request, Invoice $invoice)
    {
        $value_invoice = str_replace(["$", "."], '', $invoice->value);
        $value_payment = $request->paymentValue;
        $abono_factura = $value_invoice - $value_payment;

        if ($value_payment <= $value_invoice) {
            $request->validate([
                'paymentValue' => ['required', 'numeric']
            ]);

            if ($abono_factura < $value_invoice) {
                $status_invoice = $abono_factura === 0 ? 'PAGADA' : 'PAGO PARCIAL';
                $invoice->value = $abono_factura;
                $invoice->status = $status_invoice;
                $invoice->save();

                $payment = new Payment();
                $payment->value = $request->paymentValue;
                $payment->description = $request->paymentDescription;
                $payment->method = 'EFECTIVO';
                $payment->invoice_id = $invoice->id;

                $payment->save();
            }
            return redirect()->route('invoice.list');
        } else {

            return redirect()->route('invoice.show', ['invoice' => $invoice->id])->with('error', 'El valor del pago no puede ser mayor al de la factura');
        }

    }
}
