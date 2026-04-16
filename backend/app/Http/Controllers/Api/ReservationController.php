<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'guests' => 'required|integer|min:1|max:20',
            'message' => 'nullable|string|max:1000',
        ]);

        $reservation = Reservation::create($validated);

        return response()->json([
            'message' => 'Reservation submitted successfully. We will contact you shortly to confirm.',
            'data' => $reservation,
        ], 201);
    }

    public function adminIndex(): JsonResponse
    {
        $reservations = Reservation::orderByDesc('date')->orderByDesc('time')->get();

        return response()->json([
            'data' => $reservations,
        ]);
    }

    public function update(Request $request, Reservation $reservation): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'sometimes|required|in:pending,confirmed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $reservation->update($validated);

        return response()->json([
            'message' => 'Reservation updated successfully',
            'data' => $reservation,
        ]);
    }

    public function destroy(Reservation $reservation): JsonResponse
    {
        $reservation->delete();

        return response()->json([
            'message' => 'Reservation deleted successfully',
        ]);
    }
}
