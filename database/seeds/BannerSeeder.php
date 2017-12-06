<?php

use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('banners')->insert([
		    'title_lang_key' => 'title-banners-1',
		    'url' => 'some-url',
	    ]);
    }
}
