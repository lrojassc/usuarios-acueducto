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

    /**
     * Relación uno a mucho
     *
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany('App\Models\Invoice');
    }

    /**
     * Relación uno a muchos
     *
     * @return HasMany
     */
    public function services(): HasMany
    {
        return $this->hasMany('App\Models\Subscription');
    }

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
     * @return array
     */
    public function getDocumentAndName(): array
    {
        $data_user = [];

        $users = User::all();
        foreach ($users as $user) {
            $data_user[] = [
                'id' => $user->id,
                'name' => $user->name
            ];
        }
        return $data_user;
    }

    public function id(): string {
        return $this->id;
    }

    public function getLastUser()
    {
        return User::all()->last();
    }
}
