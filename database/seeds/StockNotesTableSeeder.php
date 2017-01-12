<?php

use App\Models\StockNote;
use Illuminate\Database\Seeder;

class StockNotesTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('stock_notes')->delete();

        StockNote::create([
            'symbol' => 'MS',
            'note' => 'Invest in ms.'
        ]);
    }

}