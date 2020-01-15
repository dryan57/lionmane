<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->insert([
            'created_at' =>now(),
            'updated_at' =>now(),
            'first_name' =>'Bryan',
            'last_name' => 'Alvarado',
            'nick_name' => 'dryan57',
            'dob' => '1988-12-28',
            'gender' => 1,
            'image' => '',
            'active' => 1,
        ]);
        DB::table('contacts')->insert([
            'created_at' =>now(),
            'updated_at' =>now(),
            'first_name' =>'Ramberto',
            'last_name' => 'Roca',
            'nick_name' => 'RRoca',
            'dob' => '1990-10-05',
            'gender' => 1,
            'image' => '',
            'active' => 1,
        ]);
    }
}
