<?php

namespace App\Http\Controllers;

use App\Services\GunService;
use Illuminate\Http\Request;

class GunController
{
    public function index(Request $request)
    {
        $gunService = new GunService($request->user());

        return response()->json($gunService->getUserGuns());
    }

    public function store(Request $request)
    {
        $request->validate([
            'caliber' => 'required',
            'name' => 'required',
            'serial_number' => 'required'
        ]);

        $gunService = new GunService($request->user());
        $gunData = $gunService->addGun([
            'name' => $request->name,
            'caliber' => $request->caliber,
            'serial_number' => $request->serial_number
        ]);

        return response()->json($gunData);
    }

    public function show(Request $request, int $id)
    {
        $gunService = new GunService($request->user());
        if ($gunService->userHasGun($id)) {

            return response()->json($gunService->getGunData($id));
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

        $gunService = new GunService($request->user());

        if ($gunService->userHasGun($id)) {
            $gunData = $gunService->updateGun($id, [
                'caliber' => $request->caliber,
                'name' => $request->name,
                'serial_number' => $request->serial_number
            ]);

            return response()->json($gunData);
        }

        return response()->json([
            'code' => 400,
            'message' => 'Invalid gun id.'
        ]);
    }

    public function destroy(Request $request, int $id)
    {
        $gunService = new GunService($request->user());

        if ($gunService->userHasGun($id)) {
            $gunService->removeGun($id);

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
