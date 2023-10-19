<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Http\Requests\RegisterFormRequest;
use App\Traits\Makeable;

final class NewUserDTO
{
    use Makeable;

    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
    ) {
    }

    public static function fromRequest(RegisterFormRequest $request): NewUserDTO
    {
        return self::make(...$request->only(['name', 'email', 'password']));
    }
}
