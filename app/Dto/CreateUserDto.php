<?php

namespace App\Dto;

readonly class CreateUserDto
{
    public function __construct(
        public string $name,
        public string $phone,
        public string $password
    ) {}
}
