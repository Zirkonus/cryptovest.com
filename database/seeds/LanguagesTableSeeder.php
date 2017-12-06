<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert([
            'country_code'      => 'EN',
            'language_code'     => 'EN',
            'name'              => 'English',
            'is_active'         => 1,
            'is_english'        => 1,
            'is_main'           => 1
        ]);
    }
}
