<?php

namespace Database\Factories;

use App\Models\QueryPatient;
use Illuminate\Database\Eloquent\Factories\Factory;

class QueryPatientFactory extends Factory
{
    protected $model = QueryPatient::class;

    public function definition(){
        return [
            'protocols' => $this->faker->text(100),
            'plaint' => $this->faker->text(100),
            'observation' => $this->faker->text(50),
        ];
    }
}