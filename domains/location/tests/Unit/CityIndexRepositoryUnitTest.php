<?php

namespace Domains\Location\Tests\Unit;

use Domains\Location\Models\City;
use Domains\Location\Repositories\CityRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CityIndexRepositoryUnitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if cities can be listed with city repository
     *
     * @return void
     */
    public function test_that_cities_can_be_listed(): void
    {
        $original_cities = City::factory(40)->create();

        $repository = new CityRepository();
        $cities = collect($repository->all(40)->items());

        foreach ($original_cities as $city) {
            $this->assertContains($city->id, $cities->pluck('id'));
        }
    }

    /**
     * Test if cities listing repository returns a paginated object.
     *
     * @return void
     */
    public function test_that_cities_returns_a_paginated_object(): void
    {
        City::factory(40)->create();

        $repository = new CityRepository();

        $this->assertInstanceOf(Paginator::class, $repository->all(10));
    }

    /**
     * Test if cities listing repository returns the exact number of item per page as asked.
     *
     * @return void
     */
    public function test_that_cities_returns_the_exact_number_of_cities_as_asked(): void
    {
        City::factory(40)->create();

        $repository = new CityRepository();

        $this->assertCount(10, $repository->all(10));
        $this->assertCount(15, $repository->all(15));
        $this->assertCount(20, $repository->all(20));
        $this->assertCount(40, $repository->all(50));
    }

    /**
     * Test if cities listing repository returns and empty object when no cities in database.
     *
     * @return void
     */
    public function test_that_cities_returns_an_empty_object_when_no_city_in_database(): void
    {
        $repository = new CityRepository();

        $this->assertCount(0, $repository->all(10));
    }
}
