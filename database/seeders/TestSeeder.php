<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
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
        $this->call(PatientsSeeder::class);
        $this->call(AgendersSeeder::class);
        $this->call(PlansSeeder::class);
    }
}
