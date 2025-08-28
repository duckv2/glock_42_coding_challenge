<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data\GunData;
use App\Services\GunService;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GunController
{
    public function index(Request $request)
    {
        $gunService = new GunService($request->user());

        return response()->json($gunService->getUserGuns());
    }

    public function store(GunData $gunData)
    {
        $inventoryService = new InventoryService(Auth::user());
        if (!$inventoryService->userHasInventory($gunData->inventory_id)) {
            return [
                'code' => 404,
                'message' => 'Invalid inventory id'
            ];
        }

        $gunService = new GunService(Auth::user());
        $gunResponse = $gunService->addGun($gunData);

        return response()->json($gunResponse);
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

    public function update(GunData $gunData, int $id)
    {
        $inventoryService = new InventoryService(Auth::user());
        if (!$inventoryService->userHasInventory($gunData->inventory_id)) {
            return [
                'code' => 404,
                'message' => 'Invalid inventory id'
            ];
        }

        $gunService = new GunService(Auth::user());

        if ($gunService->userHasGun($id)) {
            $gunResponse = $gunService->updateGun($id, $gunData);

            return response()->json($gunResponse);
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
