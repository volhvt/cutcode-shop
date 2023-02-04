<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->words(2, true)),
            'thumbnail' => (random_int(0,1) === 0)
                ? $this->faker->picsum('/images/products')
                : null,
            'price' => $this->faker->numberBetween(500, 100000),
            'brand_id' => Brand::query()->inRandomOrder()->value('id')
        ];
    }
}
