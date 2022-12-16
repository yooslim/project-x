<?php

namespace Domains\Location\Http\Controllers;

use App\Http\Controllers\Controller;
use Domains\Location\Http\Requests\CityShowRequest;
use Domains\Location\Exceptions\CityNotFoundException;
use Domains\Location\Http\Requests\DistanceCalculatorRequest;
use Domains\Location\Http\Resources\CityResource;
use Domains\Location\Repositories\CityRepository;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Exception;

class DistanceCalculatorController extends Controller
{
    /**
     * This will calculate the distance beteen two cities
     *
     * @param  DistanceCalculatorRequest  $request  Coming HTTP request object
     * @param  CityRepository  $repository  City repository
     * @return JsonResponse
     */
    public function __invoke(DistanceCalculatorRequest $request, CityRepository $repository): JsonResponse
    {
        try {
            $data = $request->validated();

            $distance = $repository->distance($data['origin'], $data['destination'], $data['unit']);

            return response()->json([
                'distance' => $distance,
                'unit' => $data['unit'],
            ]);
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
