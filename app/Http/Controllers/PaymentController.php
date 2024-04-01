<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function list()
    {
        $payments = Payment::all();
        foreach ($payments as $key => $payment) {
            $invoice = $payment->invoice;
            $user = User::find($invoice->user_id)[0];
            $subscription = $invoice->subscription;

            $payments[$key]->setAttribute('format_value', '$' . number_format(num: $payment->value, thousands_separator: '.'));
            $payments[$key]->setAttribute('invoice', $invoice);
            $payments[$key]->setAttribute('user', $user);
            $payments[$key]->setAttribute('subscription', $subscription);
        }
        return view('payment.list', compact('payments'));
    }

    /**
     * Mostrar información del pago realizado
     *
     * @param Payment $payment
     */
    public function show(Payment $payment)
    {
        $invoice = $payment->invoice;
        $user = User::find($invoice->user_id)[0];
        $subscription = $invoice->subscription;

        $payment->setAttribute('format_value', '$' . number_format(num: $payment->value, thousands_separator: '.'));
        $payment->setAttribute('invoice', $invoice);
        $payment->setAttribute('user', $user);
        $payment->setAttribute('subscription', $subscription);

        return view('payment.show', compact('payment'));
    }

    /**
     * Pagos realizados
     *
     * @param Request $request
     * @param Invoice $invoice
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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

                // Si paga completamente la factura de la suscripcion su estado pasa a PAGADA
                if ($status_invoice === 'PAGADA') {
                    $user = new User();
                    $invoice_user = $invoice::find($invoice->id)->user_id;
                    $data_user = $user::find($invoice_user['id']);
                    $data_user->paid_subscription = $status_invoice;
                    $data_user->save();
                }
            }
            return redirect()->route('invoice.list');
        } else {

            return redirect()->route('invoice.show', ['invoice' => $invoice->id])->with('error', 'El valor del pago no puede ser mayor al de la factura');
        }

    }
}
