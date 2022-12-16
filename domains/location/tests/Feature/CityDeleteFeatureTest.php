<?php

namespace Domains\Location\Tests\Feature;

use Domains\Authentication\Models\User;
use Domains\Location\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CityDeleteFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that city delete api returns the right result with the right structure
     * when a valid uuid is provided
     *
     * @return void
     */
    public function test_that_city_delete_api_returns_right_result_when_correct_uuid()
    {
        $city = City::factory(1)->create()->first();

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->delete(route('cities.delete', [
            'city' => $city->uuid,
        ]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * Test that city delete api returns not found error code when uuid is valid
     * but missing from database
     *
     * @return void
     */
    public function test_that_city_delete_api_returns_404_when_wrong_uuid()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->delete(route('cities.delete', [
            'city' => '53f157ac-33b6-4218-91ad-092efc984d50',
        ]));

        $response->assertStatus(404)
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * Test that city delete api returns not found error code when uuid is valid
     * but missing from database
     *
     * @return void
     */
    public function test_that_city_delete_api_returns_400_when_invalid_uuid_format()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->delete(route('cities.delete', [
            'city' => 'test',
        ]));

        $response->assertStatus(400)
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * Test that city delete api returns not found error code when uuid is valid
     * but missing from database
     *
     * @return void
     */
    public function test_that_city_delete_api_returns_401_when_user_is_not_authenticated()
    {
        $city = City::factory(1)->create()->first();

        $response = $this->delete(route('cities.delete', [
            'city' => $city->uuid,
        ]), [], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }
}
