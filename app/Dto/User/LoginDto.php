<?php

namespace App\Dto\User;

readonly class LoginDto
{
    public function __construct(
        public string $phone,
        public string $password
    )
    {}

}
