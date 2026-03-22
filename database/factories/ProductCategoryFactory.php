<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductCategory>
 */
class ProductCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'branch_id' => Branch::query()->inRandomOrder()->value('id'),
            'name' => $this->faker->unique()->randomElement([
                'Hair Care',
                'Skin Care',
                'Nail Products',
                'Beauty Tools',
                'Retail Items',
            ]),
            'description' => $this->faker->sentence(),
            'status' => true,
        ];
    }
}
