<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static where(string $string, $user_id)
 */
class Invoice extends Model
{
    use HasFactory;

    /**
     * Relación uno a muchos (inversa)
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Relación uno a muchos
     *
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany('App\Models\Payment');
    }

    /**
     * @return Attribute
     */
    protected function value(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => '$' . number_format(num: $value, thousands_separator: '.')
        );
    }

    protected function userId(): Attribute
    {
        return Attribute::make(
            get: function ($id) {
                $user = User::find($id);
                return ['name' => $user->name, 'id' => $user->id];
            }
        );
    }

    /**
     * @param $user_id
     *
     * @return array
     */
    public function getInvoicesByUser($user_id): array
    {
        $invoices_by_user = Invoice::where('user_id', $user_id)->get();
        $invoices = [];
        $total_invoices = 0;

        foreach ($invoices_by_user as $key => $invoice) {
            $value_invoice = (int)str_replace(["$", "."], '', $invoice['value']);
            $total_invoices += $value_invoice;
            $invoices[$key] = [
                'id' => $invoice['id'],
                'value' => $invoice['value'],
                'description' => $invoice['description'],
                'month_invoiced' => $invoice['month_invoiced'],
                'concept' => $invoice['concept'],
                'status' => $invoice['status'],
            ];

            $payment = Payment::where('invoice_id', $invoice['id'])->get();
            $invoices['total_invoices'] = $total_invoices;
        }
        return $invoices;
    }
}
