<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class UpdateGunData extends Data
{
    public function __construct(
        public ?string $caliber,
        public ?string $name,
        public ?string $serial_number
    ) {}
}
