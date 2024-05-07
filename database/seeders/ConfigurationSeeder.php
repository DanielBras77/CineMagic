<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("Configuration parameters");
        DB::table('configuration')->insert([
            'ticket_price' => 9.00,
            'registered_customer_ticket_discount' => 1.00,
        ]);
    }
}
