<?php

namespace Domains\Location\Http\Controllers;

use App\Http\Controllers\Controller;
use Domains\Location\Exceptions\CityNotFoundException;
use Domains\Location\Http\Requests\CityUpdateRequest;
use Domains\Location\Http\Resources\CityResource;
use Domains\Location\Repositories\CityRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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
        try {
            $data = $request->validated();

            $repository->update($data['city'], $data);

            return response()->json([
                'message' => trans('location::response.The city that you have selected has been successfull updated'),
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
