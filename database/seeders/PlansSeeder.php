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
            'description' => 'Semestral',
            'period' => 1,
            'value' => 1500,
            'status' => 'active',
        ]);
        DB::table('plans')->insert([
            'description' => 'Trimestral',
            'period' => 3,
            'value' => 2750,
            'status' => 'active',
        ]);
    }
}