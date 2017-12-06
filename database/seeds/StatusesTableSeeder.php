<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            'name'          =>  'Pending Approval',
            'is_comment'    => 1
        ]);
        DB::table('statuses')->insert([
            'name'          =>  'Approved',
            'is_comment'    => 1
        ]);
        DB::table('statuses')->insert([
            'name'          =>  'Draft',
            'is_post'       => 1
        ]);
        DB::table('statuses')->insert([
            'name'          =>  'Published',
            'is_post'       => 1
        ]);
        DB::table('statuses')->insert([
            'name'          =>  'Schedule',
            'is_post'       => 1
        ]);
    }
}
