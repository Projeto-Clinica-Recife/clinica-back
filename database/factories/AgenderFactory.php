<?php

namespace Database\Factories;

use App\Models\Agender;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgenderFactory extends Factory
{
    protected $model = Agender::class;

    public function definition(){
        return [
            'date' => $this->faker->dateTimeBetween('now', '+7 day'),
            'hour' => $this->faker->time(),
        ];
    }
}