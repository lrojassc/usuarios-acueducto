<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static where(string $string, $user_id)
 * @method static find($id)
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
     * Relación uno a muchos (inversa) con subscription
     *
     * @return BelongsTo
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo('App\Models\Subscription');
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

}
