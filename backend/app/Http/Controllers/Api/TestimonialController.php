<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(): JsonResponse
    {
        $testimonials = Testimonial::approved()->orderByDesc('rating')->get();

        return response()->json([
            'data' => $testimonials,
        ]);
    }

    public function adminIndex(): JsonResponse
    {
        $testimonials = Testimonial::orderByDesc('created_at')->get();

        return response()->json([
            'data' => $testimonials,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'content' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'image' => 'nullable|string|max:255',
        ]);

        $testimonial = Testimonial::create([
            ...$validated,
            'rating' => $validated['rating'] ?? 5,
            'is_approved' => false,
            'is_active' => true,
        ]);

        return response()->json([
            'message' => 'Testimonial submitted successfully. It will be reviewed before publishing.',
            'data' => $testimonial,
        ], 201);
    }

    public function approve(Testimonial $testimonial): JsonResponse
    {
        $testimonial->update(['is_approved' => true]);

        return response()->json([
            'message' => 'Testimonial approved successfully',
            'data' => $testimonial,
        ]);
    }

    public function reject(Testimonial $testimonial): JsonResponse
    {
        $testimonial->update(['is_approved' => false]);

        return response()->json([
            'message' => 'Testimonial rejected successfully',
            'data' => $testimonial,
        ]);
    }

    public function destroy(Testimonial $testimonial): JsonResponse
    {
        $testimonial->delete();

        return response()->json([
            'message' => 'Testimonial deleted successfully',
        ]);
    }
}
