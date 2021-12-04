<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\UserInformation;
use App\Models\User;
use App\Models\Patient;

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
            'name' => 'Gil',
            'email' => 'admin@gmail.com',
            'cpf' => '987654321',
            'password' => Hash::make('1234'),
        ])->each(function($user){
            UserInformation::factory()->count(1)->create([
                'telephone' => '987654321',
                'user_id' => $user->id,
            ]);
        });

        User::factory()->count(1)->create([
            'name' => 'Ana',
            'email' => 'ana@gmail.com',
            'cpf' => '2134667895',
            'type_user' => 'doctor',
            'password' => Hash::make('1234'),
        ])->each(function($user){
            UserInformation::factory()->count(1)->create([
                'telephone' => '74856966854',
                'user_id' => $user->id,
            ]);
        });

        User::factory()->count(1)->create([
            'name' => 'Herbet',
            'email' => 'doctor@gmail.com',
            'cpf' => '12345678912',
            'type_user' => 'doctor',
            'password' => Hash::make('1234'),
        ])->each(function($user){
            UserInformation::factory()->count(1)->create([
                'user_id' => $user->id,
                'crm' => '789456',
            ]);
        });

        User::factory()->count(1)->create([
            'name' => 'Ana',
            'email' => 'reception@gmail.com',
            'cpf' => '98745633215',
            'type_user' => 'reception',
            'password' => Hash::make('1234'),
        ])->each(function($user){
            UserInformation::factory()->count(1)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
