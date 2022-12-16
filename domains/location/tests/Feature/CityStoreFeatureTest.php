<?php

namespace Domains\Location\Tests\Feature;

use Domains\Authentication\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CityStoreFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that city store api insert correctly data and returns the right result
     *
     * @return void
     */
    public function test_that_city_store_api_persist_data_and_returns_right_result()
    {
        $this->assertDatabaseCount('cities', 0);

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->post(route('cities.store'), [
            'name' => 'Test city',
            'lat' => 2.65,
            'long' => 1.25,
        ], [
            'Accept' => 'application/json',
        ]);

        $this->assertDatabaseCount('cities', 1);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'uuid',
                'name',
                'coordinates' => [
                    'lat',
                    'long',
                ],
            ]);
    }

    /**
     * Test that cities store returns error when invalid name
     *
     * @return void
     */
    public function test_that_city_store_api_returns_error_when_invalid_name()
    {
        $this->assertDatabaseCount('cities', 0);

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        foreach ([null, []] as $name) {
            $response = $this->post(route('cities.store'), [
                'name' => $name,
                'lat' => 2.65,
                'long' => 1.25,
            ], [
                'Accept' => 'application/json',
            ]);

            $response->assertStatus(400)
                ->assertJsonStructure([
                    'message',
                ]);
        }

        $this->assertDatabaseCount('cities', 0);
    }

    /**
     * Test that cities store returns error when invalid coordinates
     *
     * @return void
     */
    public function test_that_city_store_api_returns_error_when_invalid_coordinates()
    {
        $this->assertDatabaseCount('cities', 0);

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $dataset = [
            ['long' => null, 'lat' => 1.25],
            ['long' => 4.25, 'lat' => null],
            ['long' => null, 'lat' => null],
            ['long' => [], 'lat' => 1.25],
            ['long' => -90., 'lat' => -180],
        ];

        foreach ($dataset as $coordinates) {
            $response = $this->post(route('cities.store'), [
                'name' => 'Test city',
                'lat' => $coordinates['lat'],
                'long' => $coordinates['long'],
            ], [
                'Accept' => 'application/json',
            ]);

            $response->assertStatus(400)
                ->assertJsonStructure([
                    'message',
                ]);
        }

        $this->assertDatabaseCount('cities', 0);
    }

    /**
     * Test that cities store returns error when user is not authenticated
     *
     * @return void
     */
    public function test_that_city_store_api_returns_error_when_user_is_not_authenticated()
    {
        $this->assertDatabaseCount('cities', 0);

        $response = $this->post(route('cities.store'), [
            'name' => 'Test city',
            'lat' => 1.25,
            'long' => 3.54,
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);

        $this->assertDatabaseCount('cities', 0);
    }
}
