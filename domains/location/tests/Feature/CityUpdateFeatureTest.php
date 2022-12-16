<?php

namespace Domains\Location\Tests\Feature;

use Domains\Authentication\Models\User;
use Domains\Location\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CityUpdateFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that city update api insert correctly data and returns the right result
     *
     * @return void
     */
    public function test_that_city_update_api_persist_data_and_returns_right_result()
    {
        $city = City::factory(1)->create()->first();

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $this->assertDatabaseCount('cities', 1);

        $newName = Str::random(55);
        $response = $this->put(route('cities.update', [
            'city' => $city->uuid,
        ]), [
            'name' => $newName,
            'lat' => 2.65,
            'long' => 1.25,
        ], [
            'Accept' => 'application/json',
        ]);

        $this->assertDatabaseCount('cities', 1);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'uuid',
                'name',
                'coordinates' => [
                    'lat',
                    'long',
                ],
            ]);

        $this->assertEquals($newName, $city->fresh()->name);
    }

    /**
     * Test that cities update returns error when invalid name
     *
     * @return void
     */
    public function test_that_city_update_api_returns_error_when_invalid_name()
    {
        $city = City::factory(1)->create()->first();

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $this->assertDatabaseCount('cities', 1);

        foreach ([null, []] as $name) {
            $response = $this->put(route('cities.update', [
                'city' => $city->uuid,
            ]), [
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

        $this->assertDatabaseCount('cities', 1);
    }

    /**
     * Test that cities update returns error when invalid coordinates
     *
     * @return void
     */
    public function test_that_city_update_api_returns_error_when_invalid_coordinates()
    {
        $city = City::factory(1)->create()->first();

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $this->assertDatabaseCount('cities', 1);

        $dataset = [
            ['long' => null, 'lat' => 1.25],
            ['long' => 4.25, 'lat' => null],
            ['long' => null, 'lat' => null],
            ['long' => [], 'lat' => 1.25],
            ['long' => -90., 'lat' => -180],
        ];

        foreach ($dataset as $coordinates) {
            $response = $this->put(route('cities.update', [
                'city' => $city->uuid,
            ]), [
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

        $this->assertDatabaseCount('cities', 1);
    }

    /**
     * Test that cities update returns error when user is not authenticated
     *
     * @return void
     */
    public function test_that_city_store_api_returns_error_when_user_is_not_authenticated()
    {
        $city = City::factory(1)->create()->first();

        $this->assertDatabaseCount('cities', 1);

        $response = $this->put(route('cities.update', [
            'city' => $city->uuid,
        ]), [
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

        $this->assertDatabaseCount('cities', 1);
    }
}
