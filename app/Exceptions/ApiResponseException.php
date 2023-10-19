<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponseException extends Exception
{
    public function report()
    {
        //
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'errors' => [
                [
                    'code' => 422,
                    'title' => $this->getMessage()
                ]
            ]
        ]);
    }
}
