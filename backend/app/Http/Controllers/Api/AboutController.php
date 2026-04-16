<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function show(): JsonResponse
    {
        $about = About::first();

        return response()->json([
            'data' => $about,
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'founded_year' => 'nullable|integer',
            'experience_years' => 'nullable|integer',
        ]);

        $about = About::firstOrCreate([]);
        $about->update($validated);

        return response()->json([
            'message' => 'About content updated successfully',
            'data' => $about,
        ]);
    }
}
