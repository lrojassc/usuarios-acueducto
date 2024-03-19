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

    /**
     * Relación uno a muchos (inversa)
     *
     * @return BelongsTo
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo('App\Models\Invoice');
    }

    public function getTotalPayment($payments)
    {
        $total_payment = 0;
        foreach ($payments as $payment) {
            $payment_value = $payment->value;
            $total_payment += $payment_value;
        }
        return $total_payment;
    }
}
