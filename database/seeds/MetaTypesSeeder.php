<?php

use Illuminate\Database\Seeder;

class MetaTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('meta_types')->insert([
		    'type'   => 'property',
		    'type_value' => 'og:title',
	    ]);
	    DB::table('meta_types')->insert([
		    'type'   => 'property',
		    'type_value' => 'og:description',
	    ]);
	    DB::table('meta_types')->insert([
		    'type'   => 'property',
		    'type_value' => 'article:tag',
	    ]);
    }
}
