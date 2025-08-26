<?php

namespace App\Http\Controllers;

use App\Models\Gun;
use App\Models\Inventory;
use Illuminate\Http\Request;

class GunController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $inventory = Inventory::where('user_id', $user->id)->first();

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

        $user = $request->user();
        $inventory = Inventory::where('user_id', $user->id)->first();

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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
