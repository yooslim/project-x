<?php

namespace Domains\Authentication\Http\Controllers;

use App\Http\Controllers\Controller;
use Domains\Authentication\Exceptions\UserNotFoundException;
use Domains\Authentication\Exceptions\WrongCrendentialsException;
use Domains\Authentication\Http\Requests\LoginRequest;
use Domains\Authentication\Repositories\UserRepository;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request, UserRepository $repository)
    {
        $data = $request->validated();

        try {
            $token = $repository->getToken($data['email'], $data['password']);

            return response()->json([
                'token' => $token->plainTextToken
            ], Response::HTTP_CREATED);
        } catch (UserNotFoundException | WrongCrendentialsException $e) {
            return response()->json([
                'message' => trans('Make sure you have provided valid credentials')
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
