<?php

use Illuminate\Database\Seeder;

class ProjectOtherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ico_category')->insert([
            'name' => 'Other',
            'is_active' => 1,
            'is_other' => 1
        ]);
        DB::table('ico_platform')->insert([
            'name' => 'Other',
            'is_active' => 1,
            'is_other' => 1
        ]);
    }
}
