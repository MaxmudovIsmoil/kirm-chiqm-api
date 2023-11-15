<?php

namespace App\Dto;

readonly class RegistrationDto
{
    public function __construct(
        public string $name,
        public string $phone,
        public string $password
    ) {}
}
