<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Brand;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
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
            'title' => $this->faker->company(),
            'thumbnail' => (random_int(0,1) === 0) ? $this->faker->picsum('/images/products') : null
        ];
    }
}
