<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserTableSeeder::class);
        $this->call(KeyValueTableSeeder::class);
        $this->call(AnnouncementTableSeeder::class);
        $this->call(EmployeeClientTableSeeder::class);
        $this->call(BoughtStocksTableSeeder::class);
        $this->call(SoldStocksTableSeeder::class);
        $this->call(FavoriteStocksTableSeeder::class);
        $this->call(StockNotesTableSeeder::class);
        $this->call(MoneyTableSeeder::class);

        Model::reguard();
    }
}
