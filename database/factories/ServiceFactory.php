<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $services = [
            'Basic Hair Cut',
            'Layer Hair Cut',
            'Hair Trim',
            'Hair Wash & Blow Dry',
            'Hair Straightening',
            'Hair Rebonding',
            'Hair Coloring',
            'Hair Highlights',
            'Keratin Treatment',
            'Scalp Treatment',
            'Facial - Basic',
            'Facial - Gold',
            'Facial - Diamond',
            'Clean Up Facial',
            'Threading - Eyebrow',
            'Threading - Full Face',
            'Waxing - Full Arms',
            'Waxing - Full Legs',
            'Waxing - Underarms',
            'Manicure',
            'Pedicure',
            'Spa Pedicure',
            'Spa Manicure',
            'Bridal Makeup',
            'Party Makeup',
            'Hair Styling',
            'Hair Spa',
            'Head Massage',
            'Foot Massage',
        ];

        return [
            'branch_id' => Branch::query()->inRandomOrder()->value('id'),
            'service_category_id' => ServiceCategory::query()->inRandomOrder()->value('id'),
            'name' => $this->faker->randomElement($services) . ' ' . $this->faker->numberBetween(1, 50),
            'code' => strtoupper($this->faker->unique()->bothify('SRV###')),
            'description' => $this->faker->sentence(),
            'duration_minutes' => $this->faker->randomElement([15, 30, 45, 60, 90, 120]),
            'price' => $this->faker->randomFloat(2, 500, 10000),
            'cost' => $this->faker->randomFloat(2, 100, 5000),
            'commission_type' => 'percentage',
            'commission_value' => 10.00,
            'status' => true,
        ];
    }
}
