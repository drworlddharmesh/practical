<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{

    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_name' => $this->faker->name(),
            'stock' => $this->faker->numberBetween(1, 1000),
            'shop_id' => Shop::inRandomOrder()->first()->id,
            'price' => $this->faker->randomFloat(2, 0, 10000),
            'video' => $this->faker->image('public/storage/images', 640, 480, null, false),
        ];
    }
}
