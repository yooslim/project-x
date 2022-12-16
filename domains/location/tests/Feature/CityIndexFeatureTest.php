<?php

namespace Domains\Location\Tests\Feature;

use Domains\Location\Http\Controllers\CityIndexController;
use Domains\Location\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CityIndexFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that city index api returns the right result with the right structure
     *
     * @return void
     */
    public function test_that_city_index_api_returns_right_result()
    {
        $city = City::factory(1)->create()->first();

        $response = $this->get(route('cities.index'));

        $response->assertStatus(200);

        $this->assertTrue(isset($response->decodeResponseJson()['data']));
        $this->assertTrue(isset($response->decodeResponseJson()['meta']));
        $this->assertTrue(isset($response->decodeResponseJson()['links']));

        if (isset($response->decodeResponseJson()['data'])) {
            $data = $response->decodeResponseJson()['data'];

            $this->assertTrue(is_array($data));

            if (is_array($data)) {
                foreach ($data as $city) {
                    $this->assertArrayHasKey('uuid', $city);
                    $this->assertArrayHasKey('name', $city);
                    $this->assertArrayHasKey('coordinates', $city);
                }
            }
        }
    }

    /**
     * Test that cities listing returns an empty list when empty database
     *
     * @return void
     */
    public function test_that_city_index_api_returns_empty_list_when_empty_database()
    {
        $response = $this->get(route('cities.index'));

        $response->assertStatus(200);

        $this->assertTrue(isset($response->decodeResponseJson()['data']));
        $this->assertTrue(isset($response->decodeResponseJson()['meta']));
        $this->assertTrue(isset($response->decodeResponseJson()['links']));

        if (isset($response->decodeResponseJson()['data'])) {
            $data = $response->decodeResponseJson()['data'];

            $this->assertTrue(is_array($data));

            if (is_array($data)) {
                $this->assertCount(0, $data);

                foreach ($data as $city) {
                    $this->assertArrayHasKey('uuid', $city);
                    $this->assertArrayHasKey('name', $city);
                    $this->assertArrayHasKey('coordinates', $city);
                }
            }
        }
    }

    /**
     * Test that city index api allows to paginate through result
     *
     * @return void
     */
    public function test_that_city_index_api_allow_user_to_paginate_through_result()
    {
        $total = 40;
        City::factory($total)->create()->first();

        // Generate the necessary pages to paginate through all cities
        $pages = floor($total / CityIndexController::ITEMS_PER_PAGE);

        $config = [];

        for ($i = 1; $i <= $pages; $i++) {
            $previous = $i - 1 < 1 ? null : $i - 1;
            $next = $i + 1 > $pages ? null : $i + 1;

            $config[$i] = ['next'  => $next, 'previous' => $previous];
        }

        foreach ($config as $page => $pagination) {
            $response = $this->get(route('cities.index', [
                'page' => $page,
            ]));

            $response->assertStatus(200);

            $this->assertTrue(isset($response->decodeResponseJson()['data']));
            $this->assertTrue(isset($response->decodeResponseJson()['meta']));
            $this->assertTrue(isset($response->decodeResponseJson()['links']));

            if (isset($response->decodeResponseJson()['meta'])) {
                $meta = $response->decodeResponseJson()['meta'];

                $this->assertEquals($meta['total'], $total);
                $this->assertEquals($meta['per_page'], CityIndexController::ITEMS_PER_PAGE);
            }

            if (isset($response->decodeResponseJson()['links'])) {
                $links = $response->decodeResponseJson()['links'];

                if ($links['prev'] !== $pagination['previous']) {
                    $this->assertStringEndsWith($pagination['previous'], $links['prev']);
                }

                if ($links['next'] !== $pagination['next']) {
                    $this->assertStringEndsWith($pagination['next'], $links['next']);
                }
            }
        }
    }
}
