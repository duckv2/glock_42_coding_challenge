<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

class GunData extends Data
{
    public function __construct(
        public int $inventory_id,
        public string $caliber,
        public string $name,
        public string $serial_number
    ) {}
}
