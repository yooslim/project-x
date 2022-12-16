<?php

namespace Domains\Location\Database\Factories;

use Faker\Generator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domains\Location\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Use french city names
        $faker = new Generator();
        $faker->addProvider(new \Faker\Provider\fr_FR\Address($faker));

        return [
            'name' => $faker->departmentName,
            'lat' => fake()->latitude(),
            'long' => fake()->longitude(),
        ];
    }
}
