<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, string $string1)
 */
class Payment extends Model
{
    use HasFactory;

    public function invoice(): BelongsTo
    {
        return $this->belongsTo('App\Models\Invoice');
    }

    public function getTotalPayment($invoice_id)
    {
        $payments = $this->getPaymentsByInvoiceId($invoice_id);
        $total_payment = 0;
        foreach ($payments as $payment) {
            $payment_value = $payment->value;
            $total_payment += $payment_value;
        }
        return $total_payment;
    }

    public function getPaymentsByInvoiceId(string $invoice_id)
    {
        return Payment::where('invoice_id', $invoice_id)->get();
    }
}
