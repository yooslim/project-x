<?php

namespace Domains\Location\Tests\Feature;

use Domains\Location\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DistanceCalculatorFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that distance calculator returns the expected response
     *
     * @return void
     */
    public function test_that_distance_calculator_returns_the_expected_response()
    {
        $cities = City::factory(2)->create();

        $response = $this->get(route('cities.distance', [
            'origin' => $cities->first()->uuid,
            'destination' => $cities->last()->uuid,
        ]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'distance',
                'unit',
            ]);
    }

    /**
     * Test that distance between the same point is zero
     *
     * @return void
     */
    public function test_that_distance_between_the_same_point_is_zero()
    {
        $city = City::factory(1)->create()->first();

        $response = $this->get(route('cities.distance', [
            'origin' => $city->uuid,
            'destination' => $city->uuid,
        ]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'distance',
                'unit',
            ])->assertJsonFragment([
                'distance' => 0,
            ]);
    }

    /**
     * Test that api returns error in case of invalid cities uuids
     *
     * @return void
     */
    public function test_that_api_returns_error_in_case_of_invalid_cities_uuids()
    {
        $city = City::factory(1)->create()->first();

        $dataset = [
            ['origin' => ' ', 'destination' => $city->uuid],
            ['origin' => 'dsfsdf', 'destination' => $city->uuid],
            ['origin' => $city->uuid, 'destination' => '5s54d'],
        ];

        foreach ($dataset as $set) {
            $response = $this->get(route('cities.distance', [
                'origin' => $set['origin'],
                'destination' => $set['destination'],
            ]));

            $response->assertStatus(400)
                ->assertJsonStructure([
                    'message',
                ]);
        }
    }

    /**
     * Test that api returns error in case of wrong cities uuids
     *
     * @return void
     */
    public function test_that_api_returns_error_in_case_of_wrong_cities_uuids()
    {
        $city = City::factory(1)->create()->first();

        $dataset = [
            ['origin' => '53f157ac-33b6-4218-91ad-092efc984d50', 'destination' => $city->uuid],
        ];

        foreach ($dataset as $set) {
            $response = $this->get(route('cities.distance', [
                'origin' => $set['origin'],
                'destination' => $set['destination'],
            ]));

            $response->assertStatus(404)
                ->assertJsonStructure([
                    'message',
                ]);
        }
    }
}
