<?php

namespace App\Services;

use App\Models\Gun;
use App\Models\User;
use App\Services\UserService;

class GunService {
    private UserService $userService;

    public function __construct(User $user) {
        $this->userService = new UserService($user);
    }

    public function getUserGuns() {
        $inventory = $this->userService->getInventory();

        $guns = Gun::where('inventory_id', $inventory->id)->get();
        return [...$guns];
    }

    public function addGun(
        $gunData,
    ) {
        $inventory = $this->userService->getInventory();

        $gun = Gun::create([
            'inventory_id' => $inventory->id,
            'name' => $gunData['name'],
            'caliber' => $gunData['caliber'],
            'serial_number' => $gunData['serial_number']
        ]);

        return [
            'id' => $gun->id,
            'inventory_id' => $gun->inventory_id,
            'caliber' => $gun->caliber,
            'name' => $gun->name,
            'serial_number' => $gun->serial_number,
            'created_at' => $gun->created_at,
            'updated_at' => $gun->updated_at
        ];
    }

    // Checks if the gun exists and if the user owns the gun
    public function userHasGun(int $gunId): bool {
        $gun = Gun::where('id', $gunId)->first();

        return $gun && $this->userService->userOwnsGun($gun);
    }

    public function getGunData(int $gunId) {
        $gun = Gun::where('id', $gunId)->first();

        return [
            'id' => $gun->id,
            'caliber' => $gun->caliber,
            'name' => $gun->name,
            'serial_number' => $gun->serial_number
        ];
    }

    public function updateGun(int $gunId, $newData) {
        $gun = Gun::where('id', $gunId)->first();

        $gun->update([
            'caliber' => $newData['caliber'],
            'name' => $newData['name'],
            'serial_number' => $newData['serial_number']
        ]);

        return [
            'id' => $gun->id,
            'inventory_id' => $gun->inventory_id,
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
