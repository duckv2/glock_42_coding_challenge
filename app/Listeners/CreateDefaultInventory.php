<?php

namespace App\Listeners;

use App\Events\UserSignup;
use App\Models\Inventory;

class CreateDefaultInventory
{
    public function __construct() {}

    public function handle(UserSignup $event): void
    {
        Inventory::create([
            'user_id' => $event->user->id,
            'name' => 'default'
        ]); 
    }
}
