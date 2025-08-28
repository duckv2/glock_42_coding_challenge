<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\InventoryData;
use App\Models\Inventory;
use App\Models\User;

class InventoryService {
    public function __construct(private User $user) {}

    public function getUserInventories() {
        $inventories = Inventory::where('user_id', $this->user->id)->get();
        return [...$inventories];
    }

    public function getUserInventory(int $id) {
        $inventory = Inventory::find($id);

        return [
            'id' => $inventory->id,
            'name' => $inventory->name,
            'created_at' => $inventory->created_at,
            'updated_at' => $inventory->updated_at,
        ];
    }

    public function createInventory(InventoryData $inventoryData) {
        $inventory = Inventory::create([
            'user_id' => $this->user->id,
            'name' => $inventoryData->name,
        ]);

        return [
            'id' => $inventory->id,
            'name' => $inventory->name,
            'created_at' => $inventory->created_at
        ];
    }

    private function userOwnsInventory(Inventory $inventory) {
        return $inventory->user_id == $this->user->id;
    }

    // Checks if the inventory exists and if the user owns it
    public function userHasInventory(int $id) {
        $inventory = Inventory::find($id);

        return $inventory && $this->userOwnsInventory($inventory);
    }

    public function updateInventory(int $id, InventoryData $inventoryData) {
        $inventory = Inventory::find($id);

        $inventory->update([
            'name' => $inventoryData->name,
        ]);

        return [
            'id' => $inventory->id,
            'name' => $inventory->name,
            'updated_at' => $inventory->updated_at
        ];
    }

    public function deleteInventory(int $id) {
        $inventory = Inventory::find($id);
        $inventory->delete();
    }
}
