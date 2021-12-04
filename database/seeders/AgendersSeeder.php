<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Agender;
use App\Models\AgenderProtocol;

class AgendersSeeder extends Seeder
{
    public function run(){
        // Agender::factory()->count(2)->create([
        //     'doctor_id' => 2,
        //     'patient_id' => 1
        // ])->each(function($agender){
        //     $number = \Illuminate\Support\Str::random(1);
        //     DB::table('agender_protocols')
        //     ->insert([
        //         'agender_id' => $agender->id,
        //         'status' => 'finished',
        //         'protocol_id' => 5,
        //     ]);
        // });
    }
}