<?php

namespace App\Services;

use App\Dto\CreateUserDto;
use App\Dto\LoginDto;
use App\Dto\RegistrationDto;
use App\Exceptions\NotFoundException;
use App\Exceptions\UnauthorizedException;
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
            'access_token' => $user->createToken('user')->accessToken,
            'user' => $user->toArray()
        ];
    }

    /**
     * @throws UnauthorizedException|NotFoundException
     */
    public function login(LoginDto $dto): array
    {
        $user = $this->repository->findByPhone($dto->phone);

        if (null === $user) {
            throw new NotFoundException('User not found');
        }

        if (! Hash::check($dto->password, $user->getAuthPassword())) {
            throw new UnauthorizedException('Unauthorized');
        }

        return [
            'access_token' => $user->createToken('user')->accessToken
        ];
    }
}
