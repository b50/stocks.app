<?php

use App\Models\SoldStock;
use Illuminate\Database\Seeder;

class SoldStocksTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('sold_stocks')->delete();
        SoldStock::create([
            'employee_id' => 1,
            'client_id' => '3',
            'amount' => 50,
            'sold' => 504.90,
            'from' => 502.90,
            'symbol' => 'MSFT',
            'updated_at' => 0,
            'created_at' => new DateTime("7 weeks ago")
        ]);
        SoldStock::create([
            'employee_id' => 1,
            'client_id' => '4',
            'amount' => 3444,
            'sold' => 55.69,
            'from' => 30.55,
            'symbol' => 'MS',
            'updated_at' => 0,
            'created_at' => new DateTime("5 weeks ago")
        ]);
        SoldStock::create([
            'employee_id' => 1,
            'client_id' => '4',
            'amount' => 2444,
            'sold' => 31.32,
            'from' => 32.25,
            'symbol' => 'MS',
            'updated_at' => 0,
            'created_at' => new DateTime("3 weeks ago")
        ]);
        SoldStock::create([
            'employee_id' => 1,
            'client_id' => '4',
            'amount' => 11,
            'sold' => 730.50,
            'from' => 690.21,
            'symbol' => 'GOOG',
            'updated_at' => 0,
            'created_at' => new DateTime("1 hour ago")
        ]);
    }

}