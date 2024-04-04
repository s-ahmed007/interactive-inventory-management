<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    private $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page');
            $inventories = Inventory::select('id', 'name', 'description')
                ->latest()
                ->paginate($perPage);

            return $this->response(true, 'inventory', $inventories);
        } catch (\Exception $e) {
            return $this->response(false, 'Something went wrong', null, [], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->response(false, 'Please provide valid data', null, $validator->errors(), 422);
        }

        $data = $request->only('name', 'description');

        try {
            $results = $this->inventoryService->createOrUpdate($data);
            return $this->response(true, 'Created successfully', $results);
        } catch (\Exception $e) {
            return $this->response(false, 'Something went wrong!', null, [], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'nullable',
        ]);
        if ($validator->fails()) {
            return $this->response(false, 'Please provide valid data', null, $validator->errors(), 422);
        }
        $data = $request->only('name', 'description');

        try {
            $results = $this->inventoryService->createOrUpdate($data, $inventory);
            return $this->response(true, 'Updated successfully', $results);
        } catch (\Exception $e) {
            return $this->response(false, 'Something went wrong!', null, [], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        try {
            $this->inventoryService->delete($inventory);
            return $this->response(true, 'Deleted successfully');
        } catch (\Exception $e) {
            return $this->response(false, 'Something went wrong!', null, [], 404);
        }
    }
}
