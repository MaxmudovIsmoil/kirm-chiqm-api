<?php

namespace App\Http\Controllers;

use App\Dto\LoginDto;
use App\Dto\RegistrationDto;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        public AuthService $service
    ) {}

    public function list()
    {
        return 'user';
    }
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws UnauthorizedException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->service->login(new LoginDto(
            phone: $request->get('phone'),
            password: $request->get('password')
        ));

        return response()->success($result);
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->service->register(new RegistrationDto(
            name: $request->get('name'),
            phone: $request->get('phone'),
            password: $request->get('password')
        ));

        return response()->success($result);
    }
}
