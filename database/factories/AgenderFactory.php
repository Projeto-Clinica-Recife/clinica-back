<?php

namespace Database\Factories;

use App\Models\Agender;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgenderFactory extends Factory
{
    protected $model = Agender::class;

    public function definition(){
        return [
            'date' => date('Y-m-d', strtotime('+4 days')),
            'hour' => $this->faker->time(),
        ];
    }
}