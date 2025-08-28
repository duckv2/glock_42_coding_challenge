<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class InventoryData extends Data
{
    public function __construct(
        public string $name,
    ) {}
}
