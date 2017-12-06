<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(MetaTypesSeeder::class);
        $this->call(LanguagesValueSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(ICOPaymentTypeSeeder::class);
        $this->call(ICOPaymentOptionsSeeder::class);
        $this->call(ProjectOtherSeeder::class);
    }
}
