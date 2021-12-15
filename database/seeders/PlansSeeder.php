<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Agender;
use App\Models\AgenderProtocol;

class PlansSeeder extends Seeder
{
    public function run(){
        DB::table('plans')->insert([
            'description' => 'CONSULTA AVULSA',
            'period' => 0,
            'value' => 600,
            'status' => 'active',
        ]);
        DB::table('plans')->insert([
            'description' => 'PLANO TRIMESTRAL',
            'period' => 3,
            'value' => 1800,
            'status' => 'active',
        ]);
        DB::table('plans')->insert([
            'description' => 'PLANO SEMESTRAL',
            'period' => 6,
            'value' => 3600,
            'status' => 'active',
        ]);
        DB::table('plans')->insert([
            'description' => 'PLANO ANUAL',
            'period' => 3,
            'value' => 6600,
            'status' => 'active',
        ]);
    }
}