<?php

use Illuminate\Database\Seeder;

class ICOPaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ico_payment_type')->insert([
            'name' => 'bitcoin',
            'short_name' => 'btc',
            'link' => '19uUpwR8ksfTE5mK1NCicf4jdfA5F3c9wW'
        ]);

        DB::table('ico_payment_type')->insert([
            'name' => 'ethereum',
            'short_name' => 'eth',
            'link' => '0x633458c3f6aa11e795e3d8323c0a058ede92b9c2'
        ]);
    }
}
