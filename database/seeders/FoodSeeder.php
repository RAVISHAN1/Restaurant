<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $description = 'Veniam debitis quaerat officiis quasi cupiditate quo, quisquam velit, magnam voluptatem repellendus sed eaque';

        $data = [
            [
                'category'        => 'Main Dish',
                'name'            => 'Rice',
                'price'           => 100,
                'description'     => $description,
            ],
            [
                'category'        => 'Main Dish',
                'name'            => 'Rotty',
                'price'           => 20,
                'description'     => $description,
            ],
            [
                'category'        => 'Main Dish',
                'name'            => 'Noodles',
                'price'           => 150,
                'description'     => $description,
            ],
            [
                'category'        => 'Side Dish',
                'name'            => 'Wadai',
                'price'           => 45,
                'description'     => $description,
            ],
            [
                'category'        => 'Side Dish',
                'name'            => 'Dhal Curry',
                'price'           => 75,
                'description'     => $description,
            ],
            [
                'category'        => 'Side Dish',
                'name'            => 'Fish Curry',
                'price'           => 120,
                'description'     => $description,
            ],
            [
                'category'        => 'Dessert',
                'name'            => 'Watalappam',
                'price'           => 40,
                'description'     => $description,
            ],
            [
                'category'        => 'Dessert',
                'name'            => 'Jelly',
                'price'           => 20,
                'description'     => $description,
            ],
            [
                'category'        => 'Dessert',
                'name'            => 'Pudding',
                'price'           => 25,
                'description'     => $description,
            ],
        ];

        Food::insertOrIgnore($data);
    }
}
