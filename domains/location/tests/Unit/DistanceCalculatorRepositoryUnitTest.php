<?php

namespace Domains\Location\Tests\Unit;

use Domains\Location\Exceptions\CityNotFoundException;
use Domains\Location\Models\City;
use Domains\Location\Repositories\CityRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DistanceCalculatorRepositoryUnitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if repository get returns the right object.
     *
     * @return void
     */
    public function test_that_distance_calculator_repository_return_what_is_expected(): void
    {
        $cities = City::factory(2)->create();

        $repository = new CityRepository();
        $result = $repository->distance($cities->first()->uuid, $cities->last()->uuid, 'meters');

        $this->assertIsFloat($result);
    }
}
