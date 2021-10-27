<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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

        $types_users = [
            'admin',
            'doctor',
            'reception',
        ];

        foreach ($types_users as $type){
            DB::table('types_users')->insert([
                'type' => $type,
            ]);
        }
        // $this->call('UsersTableSeeder');
    }
}
