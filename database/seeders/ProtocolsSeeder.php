<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProtocolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('protocols')->insert([
            'descricao' => 'Protocolo acelerador metabólico'
        ]);
        DB::table('protocols')->insert([
            'descricao' => 'Protocolo hipertrofia'
        ]);
        DB::table('protocols')->insert([
            'descricao' => 'Protocolo l-carnitina '
        ]);
        DB::table('protocols')->insert([
            'descricao' => 'Protocolo Vitamina D'
        ]);
        DB::table('protocols')->insert([
            'descricao' => 'Protocolo Vitamina B12'
        ]);
        DB::table('protocols')->insert([
            'descricao' => 'Protocolo imunidade'
        ]);
        DB::table('protocols')->insert([
            'descricao' => 'Protocolo glutationa'
        ]);
        DB::table('protocols')->insert([
            'descricao' => 'Protocolo nandrolona '
        ]);
        DB::table('protocols')->insert([
            'descricao' => 'Protocolo Testosterona'
        ]);
        DB::table('protocols')->insert([
            'descricao' => 'Protocolo HMB'
        ]);
       
    }
}
