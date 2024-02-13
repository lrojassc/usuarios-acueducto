<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static paginate()
 * @method static find($id)
 * @method static orderBy(string $string, string $string1)
 */
class User extends Model
{
    use HasFactory;

    protected function name(): Attribute
    {
        return Attribute::make(
            // Implementando metodo flecha y funciona igual que la de abajo, esto es de php 8
            get: fn (string $value) => ucwords($value),

            // Mutadores
            set: function($value) {
                return strtolower($value);
            }
        );
    }

    /**
     * Relación uno a mucho
     *
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany('App\Models\Invoice');
    }
}
