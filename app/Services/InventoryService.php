<?php

declare(strict_types=1);

use App\Models\Inventory;
use App\Models\User;

class InventoryService {
    public function __construct(private User $user) {}

    public function createInventory(string $name) {
        $inventory = Inventory::create([
            'user_id' => $this->user->id,
            'name' => $name
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

    // The only thing that can currently be updated is
    // the inventory's name
    public function updateInventory(int $id, string $name) {
        $inventory = Inventory::find($id);

        $inventory->update([
            'name' => $name,
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
