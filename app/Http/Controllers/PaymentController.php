<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function payment(Request $request, Invoice $invoice)
    {
        $request->validate([
            'paymentValue' => ['required', 'numeric']
        ]);

        $value_invoice = str_replace(array("$", "."), '', $invoice->value);
        $value_payment = $request->paymentValue;

        $abono_factura = $value_invoice - $value_payment;

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
    }
}
