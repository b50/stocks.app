<?php

use Illuminate\Database\Seeder;

class MoneyTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('money')->delete();
        \App\Models\Money::create([
            'client_id' => '3',
            'value' => 1345443.43
        ]);
        \App\Models\Money::create([
            'client_id' => '4',
            'value' => 23439223.32,
        ]);
        \App\Models\Money::create([
            'client_id' => '5',
            'value' => 4433439223.32,
        ]);
    }

}