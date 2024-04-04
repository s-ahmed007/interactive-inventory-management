<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryItem;
use App\Services\InventoryItemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryItemController extends Controller
{

    private $inventoryItemService;

    public function __construct(InventoryItemService $inventoryItemService)
    {
        $this->inventoryItemService = $inventoryItemService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Inventory $inventory)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $data['items'] = InventoryItem::select('id', 'name', 'image', 'quantity', 'description')
                ->where('inventory_id', $inventory->id)
                ->latest()
                ->paginate($perPage);

            $data['inventory'] = $inventory->only('id', 'name');

            return $this->response(true, 'Item list', $data);
        } catch (\Exception $e) {
            return $this->response(false, 'Something went wrong!', null, [], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Inventory $inventory)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'quantity' => 'required|integer',
            'image' => 'required|image|max:2048',
            'description' => 'nullable',
        ]);
        if ($validator->fails()) {
            return $this->response(false, 'Please provide valid data', null, $validator->errors(), 422);
        }
        $data = $request->only(['name', 'quantity', 'image', 'description']);
        $data['inventory_id'] = $inventory->id;

        try {
            $item = $this->inventoryItemService->createOrUpdate($data);
            return $this->response(true, 'Created successfully', $item);
        } catch (\Exception $e) {
            return $this->response(false, 'Something went wrong!', null, [], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryItem $inventoryItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory, InventoryItem $inventoryItem)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'quantity' => 'required',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable',
        ]);
        if ($validator->fails()) {
            return $this->response(false, 'Please provide  data', null, $validator->errors(), 422);
        }
        $data = $request->only(['name', 'description', 'image', 'description']);

        try {
            $inventoryItem = $this->inventoryItemService->createOrUpdate($data, $inventoryItem);
            return $this->response(true, 'Updated successfully', $inventoryItem);
        } catch (\Exception $e) {
            return $this->response(false, 'Something went wrong!', null, [], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory, InventoryItem $inventoryItem)
    {
        try {
            $this->inventoryItemService->delete($inventoryItem);
            return $this->response(true, 'Deleted successfully');
        } catch (\Exception $e) {
            return $this->response(false, 'Something went wrong!', null, [], 404);
        }
    }
}
