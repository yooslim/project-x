<?php

namespace App\Contracts;

use Illuminate\Contracts\Pagination\Paginator;

interface RepositoryInterface
{
    /**
     * Retrieve all instances of current entity, with pagination
     *
     * @param  int  $perPage  How many item per page to be displayed
     * @return Paginator
     */
    public function all(int $perPage = 10): Paginator;

    /**
     * Store an instance of current entity
     *
     * @param  array  $data  Validated data of current entity
     * @return mixed
     */
    public function store(array $data): mixed;

    /**
     * Get one instance of current entity, by using its unique identifier
     *
     * @param  string|int  $identifier  Unique identifier, could be id or uuid
     * @return mixed
     * @throws \App\Contracts\Exceptions\EntityNotFoundException
     */
    public function get(string|int $identifier): mixed;

    /**
     * Update an instance of current entity, by using its unique identifier
     *
     * @param  string|int  $identifier  Unique identifier, could be id or uuid
     * @param  array  $data  Validated data of current entity
     * @return mixed
     * @throws \App\Contracts\Exceptions\EntityNotFoundException
     */
    public function update(string|int $identifier, array $data): mixed;

    /**
     * Delete one instance of current entity, by using its unique identifier
     *
     * @param  string|int  $identifier  Unique identifier, could be id or uuid
     * @return void
     * @throws \App\Contracts\Exceptions\EntityNotFoundException
     */
    public function delete(string|int $identifier): void;
}
