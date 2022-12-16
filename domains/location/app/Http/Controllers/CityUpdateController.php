<?php

namespace Domains\Location\Http\Controllers;

use App\Http\Controllers\Controller;
use Domains\Location\Http\Requests\CityUpdateRequest;
use Domains\Location\Http\Resources\CityResource;
use Domains\Location\Repositories\CityRepository;
use Illuminate\Http\JsonResponse;

class CityUpdateController extends Controller
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
     * @param  CityUpdateRequest  $request  Coming HTTP request object
     * @param  CityRepository  $repository  City repository
     * @return CityResource|JsonResponse
     */
    public function __invoke(CityUpdateRequest $request, CityRepository $repository): CityResource|JsonResponse
    {
        $data = $request->validated();

        $city = $repository->update($data['city'], $data);

        return new CityResource($city);
    }
}
