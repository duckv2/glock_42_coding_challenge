<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Gun;
use App\Models\Inventory;
use App\Models\User;

class AccountService {
    public function __construct(private User $user) {}

    // Anonymises user's data:
    // Changes 'email', 'name', 'password' every inventory name,
    // and every serial number to '###'
    public function deleteAccount() {
        $guns = $this->getGuns();
        $guns->each(function ($gun) {
            $gun->update([
                'serial_number' => '###',
            ]);
        });

        $inventories = $this->getInventories();
        $inventories->each(function ($inventory) {
            $inventory->update([
                'name' => '###',
            ]);
        });

        $this->user->tokens()->delete();

        $this->user->update([
            'name' => '###',
            'password' => '###',
            'email' => "###{$this->user->id}"
        ]);
    }

    private function getInventories() {
        return Inventory::where('user_id', $this->user->id)->get();
    }

    private function getInventoryIds() {
        $inventories = $this->getInventories();

        return $inventories->map(function ($inv) {
            return $inv->id;
        })->toArray();
    }

    private function getGuns() {
        $inventoryIds = $this->getInventoryIds();
        return Gun::whereIn('inventory_id', $inventoryIds)->get();
    }
}
