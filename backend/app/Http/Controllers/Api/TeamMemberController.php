<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function index(): JsonResponse
    {
        $members = TeamMember::active()->orderBy('order')->get();

        return response()->json([
            'data' => $members,
        ]);
    }

    public function adminIndex(): JsonResponse
    {
        $members = TeamMember::orderBy('order')->get();

        return response()->json([
            'data' => $members,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'required|string|max:255',
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);

        $member = TeamMember::create($validated);

        return response()->json([
            'message' => 'Team member created successfully',
            'data' => $member,
        ], 201);
    }

    public function show(TeamMember $teamMember): JsonResponse
    {
        return response()->json([
            'data' => $teamMember,
        ]);
    }

    public function update(Request $request, TeamMember $teamMember): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'position' => 'sometimes|required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'sometimes|required|string|max:255',
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);

        $teamMember->update($validated);

        return response()->json([
            'message' => 'Team member updated successfully',
            'data' => $teamMember,
        ]);
    }

    public function destroy(TeamMember $teamMember): JsonResponse
    {
        $teamMember->delete();

        return response()->json([
            'message' => 'Team member deleted successfully',
        ]);
    }
}
