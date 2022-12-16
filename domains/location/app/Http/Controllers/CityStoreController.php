<?php

namespace Domains\Location\Http\Controllers;

use App\Http\Controllers\Controller;
use Domains\Location\Http\Requests\CityStoreRequest;
use Domains\Location\Http\Resources\CityResource;
use Domains\Location\Repositories\CityRepository;
use Illuminate\Http\JsonResponse;

class CityStoreController extends Controller
{
    /**
     * Object Constructor, requires authentication through sanctum
     *
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * This will show a resource of the selected city
     *
     * @param  CityStoreRequest  $request  Coming HTTP request object
     * @param  CityRepository  $repository  City repository
     * @return CityResource|JsonResponse
     */
    public function __invoke(CityStoreRequest $request, CityRepository $repository): CityResource|JsonResponse
    {
        $data = $request->validated();

        $city = $repository->store($data);

        return new CityResource($city);
    }
}
