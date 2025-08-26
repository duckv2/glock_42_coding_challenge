<?php

namespace App\Services;

use App\Models\Gun;
use App\Models\Inventory;
use App\Models\User;

class UserService {
    private User $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function getInventory(): Inventory {
        return Inventory::where('user_id', $this->user->id)->first();
    }

    public function userOwnsGun(Gun $gun): bool {
        $inventory = $this->getInventory();
        return $gun->inventory_id == $inventory->id;
    }
}
