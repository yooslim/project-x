<?php

namespace Domains\Location\Tests\Unit;

use Domains\Location\Repositories\CityRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;

class CityStoreRepositoryUnitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if city can be stored when user is authenticated
     *
     * @return void
     */
    public function test_that_cities_can_be_stored(): void
    {
        $repository = new CityRepository();

        $this->assertDatabaseCount('cities', 0);

        $repository->store([
            'name' => 'Test city',
            'lat' => 9.56,
            'long' => 1.258,
        ]);

        $this->assertDatabaseCount('cities', 1);
    }

    /**
     * Test that city cant be stored when name is invalid
     *
     * @return void
     */
    public function test_city_cant_be_stored_when_name_is_invalid(): void
    {
        $repository = new CityRepository();

        $this->expectException(InvalidArgumentException::class);

        foreach ([null, []] as $name) {
            $repository->store([
                'name' => $name,
                'lat' => 9.56,
                'long' => 1.258,
            ]);
        }
    }

    /**
     * Test that city cant be stored when latitude and longitude are invalid
     *
     * @return void
     */
    public function test_city_cant_be_stored_when_coordinates_are_invalid(): void
    {
        $repository = new CityRepository();

        $this->expectException(InvalidArgumentException::class);

        $dataset = [
            ['long' => null, 'lat' => 1.25],
            ['long' => 4.25, 'lat' => null],
            ['long' => null, 'lat' => null],
            ['long' => [], 'lat' => 1.25],
            ['long' => -90., 'lat' => -180],
        ];

        foreach ($dataset as $coordinates) {
            $repository->store([
                'name' => 'Test city',
                'lat' => $coordinates['lat'],
                'long' => $coordinates['long'],
            ]);
        }
    }
}
