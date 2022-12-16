<?php

namespace Domains\Location\Tests\Unit;

use Domains\Location\Exceptions\CityNotFoundException;
use Domains\Location\Models\City;
use Domains\Location\Repositories\CityRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CityGetRepositoryUnitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if repository get returns the right object.
     *
     * @return void
     */
    public function test_that_city_repository_get_returns_json_object_when_correct_uuid(): void
    {
        $city = City::factory(1)->create()->first();

        $repository = new CityRepository();
        $repo_city = $repository->get($city->uuid);

        $this->assertEquals($city->id, $repo_city->id);
    }

    /**
     * Test if repository get throws an exception when valid uuid but missing in database.
     *
     * @return void
     */
    public function test_that_city_repository_get_throws_error_when_wrong_uuid(): void
    {
        $repository = new CityRepository();

        $this->expectException(CityNotFoundException::class);

        $repository->get('53f157ac-33b6-4218-91ad-092efc984d50');
    }

    /**
     * Test if repository get returns the right object.
     *
     * @return void
     */
    public function test_that_city_repository_get_throws_error_when_invalid_uuid_format(): void
    {
        $repository = new CityRepository();

        $this->expectException(\Illuminate\Database\QueryException::class);

        $repository->get('test');
    }
}
