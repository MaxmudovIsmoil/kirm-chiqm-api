<?php

namespace App\Services;

use App\Dto\User\CreateUserDto;
use App\Dto\User\LoginDto;
use App\Dto\User\RegistrationDto;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnauthorizedException;
use App\Http\Resources\UserLoginResource;
use App\Repository\UserRepository;
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

        return [
            'access_token' => $user->createToken('user')->plainTextToken,
            'user' => new UserLoginResource($user)
        ];
    }


}
