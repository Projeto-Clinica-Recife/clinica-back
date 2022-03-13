<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Agender;
use App\Models\AgenderProtocol;
use App\Models\QueryPatient;

class AgendersSeeder extends Seeder
{
    public function run(){
        Agender::factory()->count(2)->create([
            'doctor_id' => 2,
            'patient_id' => 1
        ])->each(function($agender){
            $protocol_id = rand(1,10);
            DB::table('agender_protocols')
            ->insert([
                'agender_id' => $agender->id,
                'status' => 'waiting',
                'protocol_id' => $protocol_id,
            ]);
        });
        Agender::factory()->count(2)->create([
            'doctor_id' => 3,
            'patient_id' => 2,
        ])->each(function($agender){
            $protocol_id = rand(1,10);
            DB::table('agender_protocols')
            ->insert([
                'agender_id' => $agender->id,
                'status' => 'finished',
                'protocol_id' => $protocol_id,
            ]);
        })->each(function($agender_protocol){
            QueryPatient::factory()
            ->create([
            'doctor_id' => 3,
            'patient_id' => 2,
            'agender_protocol_id' => $agender_protocol->id,
        ]);
        });;
    }
}