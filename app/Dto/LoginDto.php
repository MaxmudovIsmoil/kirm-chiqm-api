<?php

namespace App\Dto;

readonly class LoginDto
{
    public function __construct(
        public string $phone,
        public string $password
    )
    {}

}
