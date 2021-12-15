<?php

namespace Database\Factories;

use App\Models\QueryPatient;
use Illuminate\Database\Eloquent\Factories\Factory;

class QueryPatientFactory extends Factory
{
    protected $model = QueryPatient::class;

    public function definition(){
        return [
            'protocols' => $this->faker->text,
            'plaint' => $this->faker->text,
            'observation' => $this->faker->text,
        ];
    }
}