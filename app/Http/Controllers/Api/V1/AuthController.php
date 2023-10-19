<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\RegisterNewUserAction;
use App\DTOs\NewUserDTO;
use App\Exceptions\ApiResponseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Throwable;

class AuthController extends Controller
{
    /**
     * @throws ApiResponseException
     */
    public function register(RegisterFormRequest $request, RegisterNewUserAction $registerAction): UserResource
    {
        $user = $registerAction(NewUserDTO::fromRequest($request));

        auth()->login($user);

        return new UserResource($user);
    }

    public function login(LoginFormRequest $request): UserResource|JsonResponse
    {
        if (!auth()->attempt($request->validated())) {
            return response()->json([
                'errors' => [
                    [
                        'code' => 401,
                        'title' => "Пользователя с таким логином/паролем не существует"
                    ]
                ]
            ]);
        }

        return new UserResource(auth()->user());
    }

    /**
     * @throws ApiResponseException
     */
    public function logout(): JsonResponse
    {
        try {
            auth()->guard('web')->logout();
        } catch (Throwable $e) {
            throw new ApiResponseException('Ошибка выхда из учетной записи (' . $e->getMessage() . ').' );
        }

        return response()->json([
            'data' => [
                'status' => true,
                'message' => "Успешный выход из учетной записи"
            ]
        ]);
    }
}
