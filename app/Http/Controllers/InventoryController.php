<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data\InventoryData;
use App\Services\InventoryService;
use Illuminate\Support\Facades\Auth;

class InventoryController
{
    private function getInvService(): InventoryService {
        return new InventoryService(Auth::user());
    }

    public function index()
    {
        return response()->json(
            $this->getInvService()->getUserInventories()
        );
    }

    public function store(InventoryData $inventoryData)
    {
        return response()->json(
            $this->getInvService()->createInventory($inventoryData)
        );
    }

    public function show(int $id)
    {
        $invService = $this->getInvService();

        if ($invService->userHasInventory($id)) {
            return response()->json(
                $invService->getUserInventory($id)
            );
        }

        return [
            'code' => 404,
            'message' => 'Invalid inventory id.'
        ];
    }

    public function update(InventoryData $invData, int $id)
    {
        $invService = $this->getInvService();

        if ($invService->userHasInventory($id)) {
            return response()->json(
                $invService->updateInventory($id, $invData)
            );
        }

        return [
            'code' => 404,
            'message' => 'Invalid inventory id.'
        ];
    }

    public function destroy(int $id)
    {
        $invService = $this->getInvService();

        if ($invService->userHasInventory($id)) {
            $invService->deleteInventory($id);

            return [
                'code' => 200,
                'message' => 'Inventory deleted successfully'
            ];
        }

        return [
            'code' => 404,
            'message' => 'Invalid inventory id.'
        ];
    }
}
