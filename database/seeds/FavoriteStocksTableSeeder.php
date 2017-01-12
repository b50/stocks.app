<?php

use Illuminate\Database\Seeder;

class FavoriteStocksTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('favorite_stocks')->delete();
        \App\Models\FavoriteStock::create([
            'user_id' => 1,
            'symbol' => 'MS',
        ]);
        \App\Models\FavoriteStock::create([
            'user_id' => 1,
            'symbol' => 'MSFT',
        ]);
        \App\Models\FavoriteStock::create([
            'user_id' => 1,
            'symbol' => 'GOOG',
        ]);
    }

}