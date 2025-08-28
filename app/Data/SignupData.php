<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

class SignupData extends Data
{
    public function __construct(
        public string $email,
        public string $name,
        public string $password,
        public string $password_confirmation
    ) {}
}
