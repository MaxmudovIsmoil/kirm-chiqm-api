<?php

namespace App\Http\Controllers;

use App\Dto\User\LoginDto;
use App\Dto\User\RegistrationDto;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct(
        public AuthService $service
    ) {}


    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws NotFoundException
     * @throws UnauthorizedException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->service->login(new LoginDto(
                phone: $request->phone,
                password: $request->password
            ));

            return response()->success(data:$result, code: 200);
        }
        catch (NotFoundException $e) {
            return response()->fail(error: $e->getMessage(), code: $e->getCode());
        }
        catch (UnauthorizedException $e) {
            return response()->fail(error: $e->getMessage(), code: $e->getCode());
        }
    }


    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->service->register(new RegistrationDto(
            name: $request->get('name'),
            phone: $request->get('phone'),
            password: $request->get('password')
        ));

        return response()->success(data:$result, code: 201);
    }

    public function refreshToken(Request $request)
    {
        return response()->success(data: $this->service->refreshToken($request), code: 401);
    }

    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();
        Auth::guard('web')->logout();

        return response()->success(['message' => 'Logged out successfully']);
    }


    public function profile()
    {
        return response()->success($this->service->profile());
    }
}
