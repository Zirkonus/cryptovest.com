<?php

use Illuminate\Database\Seeder;

class LanguagesValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('language_values')->insert([
		    'language_id'   => 1,
		    'key' => 'user-first-name_1',
		    'value' => 'Admin',
	    ]);
	    DB::table('language_values')->insert([
		    'language_id'   => 1,
		    'key' => 'user-last-name_1',
		    'value' => 'Main',
	    ]);
	    DB::table('language_values')->insert([
		    'language_id'   => 1,
		    'key' => 'user-first-name_2',
		    'value' => 'Author',
	    ]);
	    DB::table('language_values')->insert([
		    'language_id'   => 1,
		    'key' => 'user-last-name_2',
		    'value' => 'First',
	    ]);
	    DB::table('language_values')->insert([
		    'language_id'   => 1,
		    'key' => 'user-first-name_3',
		    'value' => 'Author',
	    ]);
	    DB::table('language_values')->insert([
		    'language_id'   => 1,
		    'key' => 'user-last-name_3',
		    'value' => 'Second',
	    ]);
    }
}
