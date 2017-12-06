<?php

use Illuminate\Database\Seeder;

class ICOPaymentOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ico_payment_options')->insert([
            'ico_payment_type_id' => 1,
            'payment_key' => 'normal',
            'price' => 0.4
        ]);
        DB::table('ico_payment_options')->insert([
            'ico_payment_type_id' => 1,
            'payment_key' => 'silver',
            'price' => 0.1
        ]);
        DB::table('ico_payment_options')->insert([
            'ico_payment_type_id' => 1,
            'payment_key' => 'gold',
            'price' => 0.2
        ]);
        DB::table('ico_payment_options')->insert([
            'ico_payment_type_id' => 2,
            'payment_key' => 'normal',
            'price' => 5.94
        ]);
        DB::table('ico_payment_options')->insert([
            'ico_payment_type_id' => 2,
            'payment_key' => 'silver',
            'price' => 1.485
        ]);
        DB::table('ico_payment_options')->insert([
            'ico_payment_type_id' => 2,
            'payment_key' => 'gold',
            'price' => 2.97
        ]);
    }
}
