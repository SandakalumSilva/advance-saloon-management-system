<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Product;
use App\Models\ProductCategory;
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
     */
    public function definition(): array
    {
        $products = [
            'Shampoo - Herbal',
            'Shampoo - Anti Dandruff',
            'Conditioner - Smooth & Shine',
            'Hair Oil - Coconut',
            'Hair Oil - Herbal',
            'Hair Serum',
            'Hair Spray',
            'Hair Gel',
            'Hair Wax',
            'Face Wash',
            'Face Cleanser',
            'Facial Kit - Gold',
            'Facial Kit - Diamond',
            'Body Lotion',
            'Body Scrub',
            'Nail Polish',
            'Nail Remover',
            'Cuticle Oil',
            'Makeup Foundation',
            'Makeup Compact Powder',
            'Lipstick - Matte',
            'Lip Gloss',
            'Eye Liner',
            'Mascara',
            'Bleach Cream',
            'Wax - Honey',
            'Wax - Chocolate',
            'Pedicure Kit',
            'Manicure Kit',
        ];

        return [
            'branch_id' => Branch::query()->inRandomOrder()->value('id'),
            'product_category_id' => ProductCategory::query()->inRandomOrder()->value('id'),
            'name' => $this->faker->randomElement($products),
            'sku' => strtoupper($this->faker->unique()->bothify('PRD###')),
            'description' => $this->faker->sentence(),
            'selling_price' => $this->faker->randomFloat(2, 300, 15000),
            'cost_price' => $this->faker->randomFloat(2, 100, 10000),
            'stock_qty' => $this->faker->numberBetween(0, 100),
            'commission_type' => 'percentage',
            'commission_value' => 3.00,
            'status' => true,
        ];
    }
}
