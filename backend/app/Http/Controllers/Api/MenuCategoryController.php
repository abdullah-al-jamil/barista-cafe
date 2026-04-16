<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuCategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = MenuCategory::active()
            ->with(['items' => function ($query) {
                $query->active()->orderBy('order');
            }])
            ->orderBy('order')
            ->get();

        return response()->json([
            'data' => $categories,
        ]);
    }

    public function adminIndex(): JsonResponse
    {
        $categories = MenuCategory::withCount('items')->orderBy('order')->get();

        return response()->json([
            'data' => $categories,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:menu_categories,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);

        $category = MenuCategory::create($validated);

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category,
        ], 201);
    }

    public function show(MenuCategory $menuCategory): JsonResponse
    {
        $menuCategory->load(['items' => function ($query) {
            $query->active()->orderBy('order');
        }]);

        return response()->json([
            'data' => $menuCategory,
        ]);
    }

    public function update(Request $request, MenuCategory $menuCategory): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:menu_categories,slug,' . $menuCategory->id,
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);

        $menuCategory->update($validated);

        return response()->json([
            'message' => 'Category updated successfully',
            'data' => $menuCategory,
        ]);
    }

    public function destroy(MenuCategory $menuCategory): JsonResponse
    {
        if ($menuCategory->items()->exists()) {
            return response()->json([
                'message' => 'Cannot delete category with menu items. Please delete or reassign items first.',
            ], 422);
        }

        $menuCategory->delete();

        return response()->json([
            'message' => 'Category deleted successfully',
        ]);
    }
}
