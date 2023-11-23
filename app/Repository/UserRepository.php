<?php

namespace App\Repository;

use App\Dto\User\CreateUserDto;
use App\Models\User;

readonly class UserRepository
{
    public function __construct(
        public User $model,
    ) {}


    public function create(CreateUserDto $dto): User
    {
        return $this->model->create([
            'name' => $dto->name,
            'phone' => $dto->phone,
            'password' => $dto->password
        ]);
    }

    /**
     * @param string $phone
     * @return User|null
     */
    public function findByPhone(string $phone)
    {
         return $this->model->wherePhone($phone)->first();
    }

}
