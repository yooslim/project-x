<?php

namespace Domains\Location\Tests\Feature;

use Domains\Location\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CityShowFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that city show api returns the right result with the right structure
     * when a valid uuid is provided
     *
     * @return void
     */
    public function test_that_city_show_api_returns_right_result_when_correct_uuid()
    {
        $city = City::factory(1)->create()->first();

        $response = $this->get(route('cities.show', [
            'city' => $city->uuid,
        ]));

        $response->assertStatus(200)
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
     * Test that city show api returns not found error code when uuid is valid
     * but missing from database
     *
     * @return void
     */
    public function test_that_city_show_api_returns_404_when_wrong_uuid()
    {
        $response = $this->get(route('cities.show', [
            'city' => '53f157ac-33b6-4218-91ad-092efc984d50',
        ]));

        $response->assertStatus(404)
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * Test that city show api returns bad request when invalid uuid format
     *
     * @return void
     */
    public function test_that_city_show_api_returns_400_when_invalid_uuid_format()
    {
        $response = $this->get(route('cities.show', [
            'city' => 'test',
        ]));

        $response->assertStatus(400)
            ->assertJsonStructure([
                'message',
            ]);
    }
}
