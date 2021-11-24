<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ProtocolsSeeder;
use Database\Seeders\UsersSeeder;
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
    }
}
