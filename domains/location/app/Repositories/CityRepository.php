<?php

namespace Domains\Location\Repositories;

use App\Contracts\RepositoryInterface;
use Domains\Location\Exceptions\CityNotFoundException;
use Domains\Location\Models\City;
use Illuminate\Contracts\Pagination\Paginator;

class CityRepository implements RepositoryInterface
{
    /**
     * Retrieve all instances of city, with pagination
     *
     * @param  int  $perPage  How many city per page to be displayed
     * @return Paginator
     */
    public function all(int $perPage = 10): Paginator
    {
        return City::paginate($perPage);
    }

    /**
     * Store an instance of city
     *
     * @param  array  $data  Validated data of current entity
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return City::create($data);
    }

    /**
     * Get one instance of city, by using its unique uuid
     *
     * @param  string|int  $identifier  Unique identifier, could be id or uuid
     * @return mixed
     * @throws CityNotFoundException
     */
    public function get(string|int $identifier): mixed
    {
        $city = City::whereUuid($identifier)->first();

        if (!$city) throw new CityNotFoundException();

        return $city;
    }

    /**
     * Update an instance of city, by using its unique uuid
     *
     * @param  string|int  $identifier  Unique identifier, could be id or uuid
     * @param  array  $data  Validated data of city
     * @return mixed
     * @throws CityNotFoundException
     */
    public function update(string|int $identifier, array $data): mixed
    {
        $city = $this->get($identifier);

        $city->update($data);

        return $city;
    }

    /**
     * Delete one instance of city, by using its unique uuid
     *
     * @param  string|int  $identifier  Unique identifier, could be id or uuid
     * @return void
     * @throws CityNotFoundException
     */
    public function delete(string|int $identifier): void
    {
        $this->get($identifier)->delete();
    }
}
