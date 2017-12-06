<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name_lang_key'       => 'user-first-name_1',
            'last_name_lang_key'        => 'user-last-name_1',
            'email'                     => 'admin@cms.loc',
            'url'                       => 'admin-main',
            'password'                  => bcrypt('admin'),
            'is_active'                 => 1,
            'is_admin'                  => 1,
        ]);
        DB::table('users')->insert([
            'first_name_lang_key'       => 'user-first-name_2',
            'last_name_lang_key'        => 'user-last-name_2',
            'email'                     => 'author1@cms.loc',
	        'url'                       => 'author-first',
            'password'                  => bcrypt('author1'),
            'is_active'                 => 1,
        ]);
        DB::table('users')->insert([
            'first_name_lang_key'       => 'user-first-name_3',
            'last_name_lang_key'        => 'user-last-name_3',
            'email'                     => 'author2@cms.loc',
	        'url'                       => 'author-second',
            'password'                  => bcrypt('author2'),
            'is_active'                 => 1,
        ]);
    }
}
