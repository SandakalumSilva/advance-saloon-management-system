<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ServiceCategory>
 */
class ServiceCategoryFactory extends Factory
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
                'Hair Cut',
                'Hair Color',
                'Facial',
                'Massage',
                'Nail Care',
                'Bridal',
            ]),
            'description' => $this->faker->sentence(),
            'status' => true,
        ];
    }
}
