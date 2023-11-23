<?php

namespace App\Dto\Debtor;

readonly class CreateDebtorDto
{
    public function __construct(
        public string $name,
        public string $phone,
        public string $status,
    ) {}
}
