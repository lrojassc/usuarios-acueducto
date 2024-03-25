<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Subscription;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;

class GeneratePdfController extends Controller
{
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
                $descripcion_facturas_pendientes = $facturas_pendientes >= 1 ? 'SALDO PENDIENTE' : '';
                $imprimir_invoices[$key_user][$key_service] = [
                    'usuario' => $user->name,
                    'valor_total_facturas' => $suma_total_facturas,
                    'facturas_pendientes' => $facturas_pendientes,
                    'valor_ultima_factura' => $value_last_invoice,
                    'descripcion_ultima_factura' => $descripcion_ultima_factura,
                    'descripcion_facturas_pendientes' => $descripcion_facturas_pendientes,
                    'mes_facturado' => $mes_facturado
                ];
            }

        }

        $pdf = PDF::loadView('pdf.payment', compact('imprimir_invoices'));
        $pdf->setPaper('A4');
        return $pdf->stream('prueba.pdf');
    }
}
