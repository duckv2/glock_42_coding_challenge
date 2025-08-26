<?php

namespace App\Http\Controllers;

use App\Models\Gun;
use Illuminate\Http\Request;
use App\Services\UserService;

class GunController
{
    public function index(Request $request)
    {
        $userService = new UserService($request->user());
        $inventory = $userService->getInventory();

        $guns = Gun::where('inventory_id', $inventory->id)->get();

        return response()->json([...$guns]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'caliber' => 'required',
            'name' => 'required',
            'serial_number' => 'required'
        ]);

        $userService = new UserService($request->user());
        $inventory = $userService->getInventory();

        $gun = Gun::create([
            'inventory_id' => $inventory->id,
            'name' => $request->name,
            'caliber' => $request->caliber,
            'serial_number' => $request->serial_number
        ]);

        return response()->json([
            'id' => $gun->id,
            'inventory_id' => $gun->inventory_id,
            'caliber' => $gun->caliber,
            'name' => $gun->name,
            'serial_number' => $gun->serial_number,
            'created_at' => $gun->created_at,
            'updated_at' => $gun->updated_at
        ]);
    }

    public function show(Request $request, int $id)
    {
        $userService = new UserService($request->user());
        $gun = Gun::where('id', $id)->first();

        // Check if the gun exists and if the user owns the gun
        if ($gun && $userService->userOwnsGun($gun)) {
            return response()->json([
                'id' => $gun->id,
                'caliber' => $gun->caliber,
                'name' => $gun->name,
                'serial_number' => $gun->serial_number
            ]);
        }

        return response()->json([
            'code' => 400,
            'message' => 'Invalid gun id.'
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'caliber' => 'required',
            'name' => 'required',
            'serial_number' => 'required'
        ]);

        $userService = new UserService($request->user());
        $gun = Gun::where('id', $id)->first();

        // Check if the gun exists and if the user owns the gun
        if ($gun && $userService->userOwnsGun($gun)) {
            $gun->update([
                'caliber' => $request->caliber,
                'name' => $request->name,
                'serial_number' => $request->serial_number
            ]);

            return response()->json([
                'id' => $gun->id,
                'inventory_id' => $gun->inventory_id,
                'caliber' => $gun->caliber,
                'name' => $gun->name,
                'serial_number' => $gun->serial_number,
                'updated_at' => $gun->updated_at
            ]);
        }

        return response()->json([
            'code' => 400,
            'message' => 'Invalid gun id.'
        ]);
    }

    public function destroy(Request $request, int $id)
    {
        $userService = new UserService($request->user());
        $gun = Gun::where('id', $id)->first();

        // Check if the gun exists and if the user owns the gun
        if ($gun && $userService->userOwnsGun($gun)) {
            $gun->delete();

            return response()->json([
                'message' => 'Gun deleted successfully.'
            ]);
        }

        return response()->json([
            'code' => 400,
            'message' => 'Invalid gun id.'
        ]);
    }
}
