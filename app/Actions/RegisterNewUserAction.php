<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTOs\NewUserDTO;
use App\Exceptions\ApiResponseException;
use App\Models\User;
use Throwable;

final class RegisterNewUserAction
{
    /**
     * @throws ApiResponseException
     */
    public function __invoke(NewUserDTO $data)
    {
        if (User::query()->where('email', $data->email)->exists()) {
            throw new ApiResponseException('Этот email уже зарегистрирован!');
        }

        try {
            $user = User::query()->create([
                'name' => $data->name,
                'email' => $data->email,
                'password' => bcrypt($data->password),
            ]);
        } catch (Throwable $e) {
            throw new ApiResponseException('Ошибка при регистрации (' . $e->getMessage() . ').' );
        }

        return $user;
    }
}