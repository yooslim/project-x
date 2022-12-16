<?php

namespace Domains\Location\Http\Controllers;

use App\Http\Controllers\Controller;
use Domains\Location\Exceptions\CityNotFoundException;
use Domains\Location\Http\Requests\CityDeleteRequest;
use Domains\Location\Repositories\CityRepository;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Exception;

class CityDeleteController extends Controller
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
     * This will delete the selected city
     *
     * @param  CityDeleteRequest  $request  Coming HTTP request object
     * @param  CityRepository  $repository  City repository
     * @return JsonResponse
     */
    public function __invoke(CityDeleteRequest $request, CityRepository $repository): JsonResponse
    {
        try {
            $data = $request->validated();

            $repository->delete($data['city']);

            return response()->json([
                'message' => trans('location::response.The city that you have selected has been successfull deleted')
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
