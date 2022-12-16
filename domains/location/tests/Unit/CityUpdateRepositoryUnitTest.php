<?php

namespace Domains\Location\Tests\Unit;

use Domains\Location\Models\City;
use Domains\Location\Repositories\CityRepository;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;

class CityUpdateRepositoryUnitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if city can be updated
     *
     * @return void
     */
    public function test_that_cities_can_be_updated(): void
    {
        $city = City::factory(1)->create()->first();

        $repository = new CityRepository();

        $this->assertDatabaseCount('cities', 1);

        $newName = Str::random(55);
        $repository->update($city->uuid, [
            'name' => $newName,
            'lat' => 9.56,
            'long' => 1.258,
        ]);

        $this->assertDatabaseCount('cities', 1);

        $this->assertEquals($newName, $city->fresh()->name);
    }

    /**
     * Test that city cant be updated when name is invalid
     *
     * @return void
     */
    public function test_city_cant_be_updated_when_name_is_invalid(): void
    {
        $city = City::factory(1)->create()->first();

        $repository = new CityRepository();

        $this->expectException(InvalidArgumentException::class);

        foreach ([null, []] as $name) {
            $repository->update($city->uuid, [
                'name' => $name,
                'lat' => 9.56,
                'long' => 1.258,
            ]);
        }
    }

    /**
     * Test that city cant be updated when latitude and longitude are invalid
     *
     * @return void
     */
    public function test_city_cant_be_updated_when_coordinates_are_invalid(): void
    {
        $city = City::factory(1)->create()->first();

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
            $repository->update($city->uuid, [
                'name' => 'Test city',
                'lat' => $coordinates['lat'],
                'long' => $coordinates['long'],
            ]);
        }
    }
}
