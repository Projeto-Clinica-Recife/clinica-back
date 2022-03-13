<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ProtocolsSeeder;
use Database\Seeders\UsersSeeder;
use Database\Seeders\PatientsSeeder;
use Database\Seeders\AgendersSeeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call(UsersSeeder::class);
        $this->call(ProtocolsSeeder::class);
        // $this->call(PatientsSeeder::class);
        // $this->call(AgendersSeeder::class);
        // $this->call(PlansSeeder::class);
    }
}
