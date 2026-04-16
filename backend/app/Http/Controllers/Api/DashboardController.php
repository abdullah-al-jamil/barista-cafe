<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\MenuCategory;
use App\Models\Reservation;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function stats(): JsonResponse
    {
        $menuItems = MenuItem::count();
        $categories = MenuCategory::count();
        $pendingReservations = Reservation::pending()->count();
        $pendingTestimonials = Testimonial::pending()->count();

        return response()->json([
            'data' => [
                'menu_items' => $menuItems,
                'categories' => $categories,
                'pending_reservations' => $pendingReservations,
                'pending_testimonials' => $pendingTestimonials,
            ],
        ]);
    }
}
