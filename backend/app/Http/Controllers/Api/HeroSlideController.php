<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HeroSlideController extends Controller
{
    public function index(): JsonResponse
    {
        $slides = HeroSlide::active()->orderBy('order')->get();

        return response()->json([
            'data' => $slides,
        ]);
    }

    public function adminIndex(): JsonResponse
    {
        $slides = HeroSlide::orderBy('order')->get();

        return response()->json([
            'data' => $slides,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|string|max:255',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);

        $slide = HeroSlide::create($validated);

        return response()->json([
            'message' => 'Hero slide created successfully',
            'data' => $slide,
        ], 201);
    }

    public function show(HeroSlide $heroSlide): JsonResponse
    {
        return response()->json([
            'data' => $heroSlide,
        ]);
    }

    public function update(Request $request, HeroSlide $heroSlide): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'sometimes|required|string|max:255',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);

        $heroSlide->update($validated);

        return response()->json([
            'message' => 'Hero slide updated successfully',
            'data' => $heroSlide,
        ]);
    }

    public function destroy(HeroSlide $heroSlide): JsonResponse
    {
        $heroSlide->delete();

        return response()->json([
            'message' => 'Hero slide deleted successfully',
        ]);
    }
}
