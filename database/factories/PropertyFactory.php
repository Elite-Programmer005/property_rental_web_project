<?php

namespace Database\Factories;

use App\Models\Property;  // ADD THIS IMPORT
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Property::class;  // CRITICAL: This line links factory to model

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(3),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'price' => $this->faker->numberBetween(500, 5000),
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'bathrooms' => $this->faker->numberBetween(1, 3),
            'area_sqft' => $this->faker->numberBetween(500, 3000),
            'type' => $this->faker->randomElement(['house', 'apartment', 'condo']),
            'status' => 'available',
            'latitude' => $this->faker->latitude(24, 37),
            'longitude' => $this->faker->longitude(67, 77),
            'user_id' => 2, // Landlord ID
        ];
    }
}