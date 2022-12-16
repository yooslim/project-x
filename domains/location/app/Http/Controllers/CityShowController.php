<?php

namespace Domains\Location\Http\Controllers;

use App\Http\Controllers\Controller;
use Domains\Location\Http\Requests\CityShowRequest;
use Domains\Location\Exceptions\CityNotFoundException;
use Domains\Location\Http\Resources\CityResource;
use Domains\Location\Repositories\CityRepository;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Exception;

class CityShowController extends Controller
{
    /**
     * This will show a resource of the selected city
     *
     * @param  CityShowRequest  $request  Coming HTTP request object
     * @param  CityRepository  $repository  City repository
     * @return CityResource|JsonResponse
     */
    public function __invoke(CityShowRequest $request, CityRepository $repository): CityResource|JsonResponse
    {
        try {
            $data = $request->validated();

            $city = $repository->get($data['city']);

            return new CityResource($city);
        } catch (CityNotFoundException $e) {
            return response()->json([
                'message' => trans('location::response.oups'),
            ], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json([
                'message' => trans('location::response.oups'),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
