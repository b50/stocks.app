<?php

use App\Models\BoughtStock;
use Illuminate\Database\Seeder;

class BoughtStocksTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('bought_stocks')->delete();
        BoughtStock::create([
            'id' => 1,
            'employee_id' => 1,
            'client_id' => '3',
            'amount' => 300,
            'bought' => 504.90,
            'symbol' => 'MSFT',
            'updated_at' => 0,
            'created_at' => new DateTime("2 weeks ago")
        ]);
        BoughtStock::create([
            'id' => 2,
            'employee_id' => 1,
            'client_id' => '4',
            'amount' => 10,
            'bought' => 508.90,
            'symbol' => 'MSFT',
            'updated_at' => 0,
            'created_at' => new DateTime("2 weeks ago")
        ]);
        BoughtStock::create([
            'id' => 3,
            'employee_id' => 1,
            'client_id' => '4',
            'amount' => 10,
            'bought' => 720.31,
            'symbol' => 'GOOG',
            'updated_at' => 0,
            'created_at' => new DateTime("1 hour ago")
        ]);
    }

}