<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index(): JsonResponse
    {
        $items = MenuItem::active()
            ->with('category')
            ->orderBy('order')
            ->get();

        return response()->json([
            'data' => $items,
        ]);
    }

    public function featured(): JsonResponse
    {
        $items = MenuItem::active()
            ->featured()
            ->with('category')
            ->orderBy('order')
            ->get();

        return response()->json([
            'data' => $items,
        ]);
    }

    public function adminIndex(Request $request): JsonResponse
    {
        $query = MenuItem::with('category');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $items = $query->orderBy('order')->get();

        return response()->json([
            'data' => $items,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:menu_categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:menu_items,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);

        $item = MenuItem::create($validated);

        return response()->json([
            'message' => 'Menu item created successfully',
            'data' => $item->load('category'),
        ], 201);
    }

    public function show(MenuItem $menuItem): JsonResponse
    {
        return response()->json([
            'data' => $menuItem->load('category'),
        ]);
    }

    public function update(Request $request, MenuItem $menuItem): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => 'sometimes|required|exists:menu_categories,id',
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:menu_items,slug,' . $menuItem->id,
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);

        $menuItem->update($validated);

        return response()->json([
            'message' => 'Menu item updated successfully',
            'data' => $menuItem->load('category'),
        ]);
    }

    public function destroy(MenuItem $menuItem): JsonResponse
    {
        $menuItem->delete();

        return response()->json([
            'message' => 'Menu item deleted successfully',
        ]);
    }
}
