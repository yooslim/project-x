<?php

namespace Domains\Location\Http\Controllers;

use App\Http\Controllers\Controller;
use Domains\Location\Http\Requests\CityIndexRequest;
use Domains\Location\Http\Resources\CityResource;
use Domains\Location\Repositories\CityRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CityIndexController extends Controller
{
    /**
     * How many cities to list per page
     *
     * @const
     */
    const ITEMS_PER_PAGE = 10;

    /**
     * This will show a collection of cities
     *
     * @param  CityIndexRequest  $request  Coming HTTP request object
     * @param  CityRepository  $repository  City repository
     * @return CityResource|JsonResponse
     */
    public function __invoke(CityRepository $repository): ResourceCollection|JsonResponse
    {
        $cities = $repository->all(static::ITEMS_PER_PAGE);

        return CityResource::collection($cities);
    }
}
