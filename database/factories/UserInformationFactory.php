<?php

namespace Database\Factories;

use App\Models\UserInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserInformationFactory extends Factory
{
    protected $model = UserInformation::class;

    public function definition(){
        return[
            'telephone' => $this->faker->numberBetween(1,20),
        ];
    }
}

