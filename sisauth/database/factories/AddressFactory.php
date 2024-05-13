<?php

// AddressFactory.php
namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            'user_id' => null,  // Deixe null como padrão
            'logradouro' => $this->faker->streetAddress,
            'numero' => $this->faker->buildingNumber,
            'bairro' => $this->faker->city,
            'complemento' => $this->faker->secondaryAddress,
            'cep' => $this->faker->postcode
        ];
    }
}
