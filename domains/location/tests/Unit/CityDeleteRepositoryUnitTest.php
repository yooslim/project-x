<?php

namespace Domains\Location\Tests\Unit;

use Domains\Location\Exceptions\CityNotFoundException;
use Domains\Location\Models\City;
use Domains\Location\Repositories\CityRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CityDeleteRepositoryUnitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if repository delete throws no exception.
     *
     * @return void
     */
    public function test_that_city_repository_delete_throws_no_exception_when_correct_uuid(): void
    {
        $city = City::factory(1)->create()->first();

        $repository = new CityRepository();
        $repository->delete($city->uuid);

        $this->assertDatabaseMissing('cities', ['uuid' => $city->uuid]);
    }

    /**
     * Test if repository delete throws an exception when valid uuid but missing in database.
     *
     * @return void
     */
    public function test_that_city_repository_delete_throws_error_when_wrong_uuid(): void
    {
        $repository = new CityRepository();

        $this->expectException(CityNotFoundException::class);

        $repository->delete('53f157ac-33b6-4218-91ad-092efc984d50');
    }

    /**
     * Test if repository delete throws error when invalid uuid format.
     *
     * @return void
     */
    public function test_that_city_repository_delete_throws_error_when_invalid_uuid_format(): void
    {
        $repository = new CityRepository();

        $this->expectException(\Illuminate\Database\QueryException::class);

        $repository->delete('test');
    }
}
