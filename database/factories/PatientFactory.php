<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(){
        return [
            'nome' => $this->faker->name,
            'data_nascimento' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'cpf' => $this->faker->numberBetween(11),
            'rg' => $this->faker->numberBetween(11),
            'telephone' => $this->faker->e164PhoneNumber,
            'email' => $this->faker->unique()->email,
            'cep' => $this->faker->postcode,
            'rua' => $this->faker->streetName,
            'numero' => $this->faker->numberBetween($min = 1, $max = 100),
            'bairro' => $this->faker->text(50),
            'cidade' => $this->faker->city,
            'estado' => $this->faker->state,
            'complemento' => $this->faker->streetSuffix,
            'profession' => $this->faker->realText(rand(10,20)),
            'signature' => $this->faker->text(15),
        ];
    }
}