<?php

use Illuminate\Database\Seeder;
use App\Stock;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        Stock::create([
            'user_id' => '1',
            'item_name' => 'Gundam HG',
            'item_price_in' => 100000,
            'item_price_out' => 135000,
            'item_stock' => 20

        ]);
        Stock::create([
            'user_id' => '1',
            'item_name' => 'Gundam MG',
            'item_price_in' => 340000,
            'item_price_out' => 45000,
            'item_stock' => 10

        ]);
        Stock::create([
            'user_id' => '1',
            'item_name' => 'Gundam RG',
            'item_price_in' => 640000,
            'item_price_out' => 82000,
            'item_stock' => 10

        ]);
        Stock::create([
            'user_id' => '1',
            'item_name' => 'Lego Star Wars',
            'item_price_in' => 300000,
            'item_price_out' => 35000,
            'item_stock' => 10
        ]);
    }
}
