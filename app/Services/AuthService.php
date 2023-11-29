<?php

namespace App\Services;

use App\Dto\User\CreateUserDto;
use App\Dto\User\LoginDto;
use App\Dto\User\RegistrationDto;
use App\Enums\TokenAbility;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Http\Resources\UserLoginResource;
use App\Repository\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    public function __construct(
        public UserRepository $repository,
    ) {}

    /**
     * @param RegistrationDto $dto
     * @return array
     */
    public function register(RegistrationDto $dto): array
    {
        $password = Hash::make($dto->password);

        $user = $this->repository->create(new CreateUserDto(
            name: $dto->name,
            phone: $dto->phone,
            password: $password
        ));

        return [
            'access_token' => $user->createToken('user')->plainTextToken,
            'user' => $user->toArray()
        ];
    }


    public function login(LoginDto $dto): array
    {
        $user = $this->repository->findByPhone($dto->phone);


        if ($user === null) {
            throw new NotFoundException(message:'User not found', code:404);
        }

        if (! Hash::check($dto->password, $user->getAuthPassword())) {
            throw new UnauthorizedException(message:'Unauthorized', code:401);
        }

        $expiresAt = Carbon::now()->addMinutes(config('sanctum.expiration'));
        $expiresRt = Carbon::now()->addMinutes(config('sanctum.rt_expiration'));

        $accessToken = $user->createToken('access_token', [TokenAbility::ACCESS_API->value], $expiresAt);
        $refreshToken = $user->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], $expiresRt);

        return [
            'access_token' => $accessToken->plainTextToken,
            'refresh_token' => $refreshToken->plainTextToken,
            'user' => new UserLoginResource($user)
        ];
    }


    public function refreshToken(Request $request)
    {
        $expiresAt = Carbon::now()->addMinutes(config('sanctum.expiration'));
        $access_token = $request->user()->createToken('access_token', [TokenAbility::ACCESS_API->value], $expiresAt);

        return [
            'access_token' => $access_token->plainTextToken
        ];
    }


    public function profile()
    {
        return ['user' => new UserLoginResource(auth()->user())];
    }
}
