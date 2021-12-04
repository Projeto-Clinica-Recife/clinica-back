<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\UserInformation;
use App\Models\User;

class PatientsSeeder extends Seeder
{
    public function run(){
        DB::table('patients')->insert([
            'nome' => 'Herbet',
            'email' => 'herbet@gmail.com',
            'rg' => '12345678912',
            'cpf' => '12345658591',
            'dispatcher' => 'SSP',
            'data_nascimento' => '2021-05-05',
            'cep' => '48904755',
            'rua' => 'Flor de Juá',
            'numero' => '180',
            'bairro' =>  'Angari',
            'cidade' => 'Juazeiro',
            'estado' => 'BA',
            'complemento' => 'Casa',
            'ponto_referencia' => 'No',
            'nationality' => 'Brasileiro',
            'profession' => 'Pedreiro',
            'marital_status' => 'Solteiro',
            'contracted_plan' => 'Premium',
            'signature' => 'rqewefewdwfewwe',
        ]);
    }
}