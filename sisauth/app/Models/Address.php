<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['user_id','logradouro', 'numero', 'bairro', 'complemento', 'cep'];

    // Relationship to User model
    public function user()
    {
        return $this->belongsToMany(User::class, 'address_user');
    }
}
