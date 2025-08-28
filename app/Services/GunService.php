<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\GunData;
use App\Models\Gun;
use App\Models\Inventory;
use App\Models\User;

class GunService {
    public function __construct(private User $user) {}

    private function getInventories() {
        return Inventory::where('user_id', $this->user->id)->get();
    }

    // Returns an array of IDs of inventories the user owns
    private function getInventoryIds() {
        $inventories = $this->getInventories();

        return $inventories->map(function ($inv) {
            return $inv->id;
        })->toArray();
    }

    private function gunInfo(Gun $gun) {
        $inventory = Inventory::find($gun->inventory_id);
        return [
            ...$gun->toArray(),
            'inventory_name' => $inventory->name,
        ];
    }

    public function getUserGuns() {
        $inventoryIds = $this->getInventoryIds();
        $gunEntries = Gun::whereIn('inventory_id', $inventoryIds)->get();

        $guns = $gunEntries->map(function ($entry) {
            return $this->gunInfo($entry);
        });

        return [...$guns];
    }

    public function addGun(
        GunData $gunData,
    ) {
        $inventory = Inventory::find($gunData->inventory_id);

        $gun = Gun::create([
            'inventory_id' => $inventory->id,
            ...$gunData->toArray()
        ]);

        return [
            'id' => $gun->id,
            'inventory_id' => $gun->inventory_id,
            'inventory_name' => $inventory->name,
            'caliber' => $gun->caliber,
            'name' => $gun->name,
            'serial_number' => $gun->serial_number,
            'created_at' => $gun->created_at,
            'updated_at' => $gun->updated_at
        ];
    }

    private function userOwnsGun(Gun $gun): bool {
        return in_array($gun->inventory_id, $this->getInventoryIds());
    }

    // Checks if the gun exists and if the user owns the gun
    public function userHasGun(int $gunId): bool {
        $gun = Gun::where('id', $gunId)->first();

        return $gun && $this->userOwnsGun($gun);
    }

    public function getGunData(int $gunId) {
        $gun = Gun::where('id', $gunId)->first();
        $inventory = Inventory::find($gun->inventory_id);

        return [
            'id' => $gun->id,
            'caliber' => $gun->caliber,
            'name' => $gun->name,
            'serial_number' => $gun->serial_number,
            'inventory_id' => $inventory->id,
            'inventory_name' => $inventory->name,
        ];
    }

    public function updateGun(int $gunId, GunData $gunData) {
        $gun = Gun::where('id', $gunId)->first();
        $gun->update($gunData->toArray());

        $inventory = Inventory::find($gunData->inventory_id);

        return [
            'id' => $gun->id,
            'inventory_id' => $gun->inventory_id,
            'inventory_name' => $inventory->name,
            'caliber' => $gun->caliber,
            'name' => $gun->name,
            'serial_number' => $gun->serial_number,
            'updated_at' => $gun->updated_at
        ];
    }

    public function removeGun(int $gunId) {
        $gun = Gun::where('id', $gunId)->first();
        $gun->delete();
    }
}
