<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\UserInformation;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::factory()->count(1)->create([
            'email' => 'admin@gmail.com',
            'cpf' => '987654321',
            'password' => Hash::make('1234'),
        ])->each(function($user){
            UserInformation::factory()->count(1)->create([
                'telephone' => '987654321',
                'user_id' => $user->id,
            ]);
        });
    }
}
