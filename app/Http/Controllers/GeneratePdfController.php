<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;

class GeneratePdfController extends UserController
{

    /**
     * Generar facturas a cobrar por mes actual con deuda si tiene
     *
     * @return \Illuminate\Http\Response
     */
    public function generateMassiveInvoicePdf(): \Illuminate\Http\Response
    {
        $user_model = new User();
        $subscription_model = new Subscription();
        $active_users = $user_model::where('status', 'ACTIVO')->get();

        $imprimir_invoices = [];
        foreach ($active_users as $key_user => $user) {
            $services_by_user = $user->find($user->id)->services;

            $mes_facturado = '';
            foreach ($services_by_user as $key_service => $service) {
                $count_invoice_active = 0;
                $suma_total_facturas = 0;
                $value_last_invoice = 0;
                $descripcion_ultima_factura = '';

                $invoices_by_subscription = $subscription_model->find($service->id)->invoices;
                foreach ($invoices_by_subscription as $key_invoice => $invoice) {
                    if ($invoice->status !== 'PAGADA') {
                        $count_invoice_active++;
                        $suma_total_facturas += (int) str_replace(["$", "."], '', $invoice->value);
                        $value_last_invoice = (int) str_replace(["$", "."], '', $invoice->value);
                        $descripcion_ultima_factura = $invoice->description;
                        $mes_facturado = $invoice->month_invoiced;
                    }
                }

                $facturas_pendientes = $count_invoice_active - 1;
                $observacion = $facturas_pendientes >= 1 ? 'Por favor realice el pago de forma inmediata'
                    : 'Felicitaciones usted se encuentra al día';

                $imprimir_invoices[] = [
                    'usuario' => $user->name,
                    'direccion' => $user->address . ' - ' . $user->city,
                    'codigo' => $user->id,
                    'servicio' => $service->service,
                    'valor_total_facturas' => '$' . number_format(num: $suma_total_facturas, thousands_separator: '.'),
                    'atrasos' => $facturas_pendientes,
                    'valor_ultima_factura' => '$' . number_format(num: $value_last_invoice, thousands_separator: '.'),
                    'descripcion_ultima_factura' => $descripcion_ultima_factura,
                    'observacion' => $observacion,
                    'periodo' => $mes_facturado
                ];
            }

        }

        $pdf = PDF::loadView('pdf.payment', compact('imprimir_invoices'));
        $pdf->setPaper('A4');
        return $pdf->stream('prueba.pdf');
    }

    /**
     * Generar informe de pago realizado
     *
     * @param Payment $payment
     *
     * @return \Illuminate\Http\Response
     */
    public function generateStatusPayment(Payment $payment)
    {
        $invoice = $payment->invoice;
        $user = User::find($invoice->user_id)[0];
        $subscription = $invoice->subscription;

        $pdf = PDF::loadView('pdf.status_payment',
            [
                'payment' => $payment,
                'invoice' => $invoice,
                'user' => $user,
                'subscription' => $subscription,
                'format_value' => '$' . number_format(num: $payment->value, thousands_separator: '.')
            ]);
        $pdf->setPaper([0,0,530,400]);
        return $pdf->stream('prueba.pdf');
    }

    public function generateAccountStatusByUser(User $user): \Illuminate\Http\Response
    {
        $invoices_by_user = User::find($user->id())->invoices;
        $total_invoices = $this->getTotalInvoices($invoices_by_user);

        // Agregar descripcion del servicio
        foreach ($invoices_by_user as $key => $invoice) {
            $invoices_by_user[$key]->setAttribute('service_description', $invoice->subscription->service);
        }

        $pdf = PDF::loadView('pdf.account_status_by_user',
            [
                'user' => $user,
                'info_total_invoices' => $total_invoices,
                'invoices' => $invoices_by_user
            ]
        );

        $pdf->setPaper('A4');
        return $pdf->stream('prueba.pdf');
    }
}
