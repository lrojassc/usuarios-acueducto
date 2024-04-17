<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

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
                $codigo_facturas_pendientes = 'No. ';
                $id_last_invoice = '';
                $debe_suscripcion = FALSE;
                $desc_subscripcion = '';

                $invoices_by_subscription = $subscription_model->find($service->id)->invoices;
                foreach ($invoices_by_subscription as $key_invoice => $invoice) {

                    // Comprobar si debe accion de agua
                    if ($invoice->concept === 'SUSCRIPCION' && $invoice->status !== 'PAGADA') {
                        $debe_suscripcion = TRUE;
                        $desc_subscripcion = 'Valor pendiente ' . $invoice->value;
                    }

                    if ($invoice->status !== 'PAGADA' && $invoice->status !== 'INACTIVO') {
                        $count_invoice_active++;
                        $suma_total_facturas += (int) str_replace(["$", "."], '', $invoice->value);
                        $value_last_invoice = (int) str_replace(["$", "."], '', $invoice->value);
                        $descripcion_ultima_factura = $invoice->description;
                        $mes_facturado = $invoice->month_invoiced;
                        $codigo_facturas_pendientes .= $invoice->id . ' - ';
                        $id_last_invoice = $invoice->id;
                    }
                }
                $facturas_pendiente = rtrim($codigo_facturas_pendientes, '- ');

                $facturas_pendientes = $count_invoice_active - 1;
                $observacion = $facturas_pendientes >= 1 ? 'Por favor realice el pago de forma inmediata'
                    : 'Felicitaciones usted se encuentra al día';

                $imprimir_invoices[] = [
                    'usuario' => $user->name,
                    'direccion' => $user->address . ' - ' . $user->city,
                    'codigo_usuario' => $user->id,
                    'servicio' => $service->service,
                    'valor_total_facturas' => '$' . number_format(num: $suma_total_facturas, thousands_separator: '.'),
                    'atrasos' => $facturas_pendientes,
                    'valor_ultima_factura' => '$' . number_format(num: $value_last_invoice, thousands_separator: '.'),
                    'descripcion_ultima_factura' => $descripcion_ultima_factura,
                    'observacion' => $observacion,
                    'periodo' => 'Del 01 al 30 de ' . $mes_facturado,
                    'facturas_pendientes' => $facturas_pendiente,
                    'id_ultima_factura' => $id_last_invoice,
                    'fecha_limite_pago' => 'Hasta el 25 de ' . $this->monthsNumber[date("m", strtotime("+1 month"))],
                    'debe_suscripcion' => $debe_suscripcion,
                    'descripcion_suscripcion' => $desc_subscripcion
                ];
            }

        }

        $pdf = PDF::loadView('pdf.payment', compact('imprimir_invoices'));
        $pdf->setPaper('legal');
        return $pdf->stream('masivo_facturas.pdf');
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
        return $pdf->stream('pago.pdf');
    }

    public function generateAccountStatusByUser(User $user): \Illuminate\Http\Response
    {
        $invoices_by_user = Invoice::where('user_id', $user->id())->where('status', '!=', 'INACTIVO')->get();
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
        return $pdf->stream('estado_cuenta_usuario.pdf');
    }
}
