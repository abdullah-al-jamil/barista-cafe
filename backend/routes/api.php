<?php

use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\HeroSlideController;
use App\Http\Controllers\Api\MenuCategoryController;
use App\Http\Controllers\Api\MenuItemController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\TeamMemberController;
use App\Http\Controllers\Api\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

Route::prefix('public')->group(function () {
    Route::get('/hero-slides', [HeroSlideController::class, 'index']);
    Route::get('/about', [AboutController::class, 'show']);
    Route::get('/team', [TeamMemberController::class, 'index']);
    Route::get('/menu', [MenuItemController::class, 'index']);
    Route::get('/menu/featured', [MenuItemController::class, 'featured']);
    Route::get('/menu/categories', [MenuCategoryController::class, 'index']);
    Route::get('/menu/categories/{menuCategory}', [MenuCategoryController::class, 'show']);
    Route::get('/menu/{menuItem}', [MenuItemController::class, 'show']);
    Route::get('/testimonials', [TestimonialController::class, 'index']);
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::post('/testimonials', [TestimonialController::class, 'store']);
});

Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
    
    Route::get('/hero-slides', [HeroSlideController::class, 'adminIndex']);
    Route::post('/hero-slides', [HeroSlideController::class, 'store']);
    Route::get('/hero-slides/{heroSlide}', [HeroSlideController::class, 'show']);
    Route::put('/hero-slides/{heroSlide}', [HeroSlideController::class, 'update']);
    Route::delete('/hero-slides/{heroSlide}', [HeroSlideController::class, 'destroy']);
    
    Route::get('/about', [AboutController::class, 'show']);
    Route::put('/about', [AboutController::class, 'update']);
    
    Route::get('/team', [TeamMemberController::class, 'adminIndex']);
    Route::post('/team', [TeamMemberController::class, 'store']);
    Route::get('/team/{teamMember}', [TeamMemberController::class, 'show']);
    Route::put('/team/{teamMember}', [TeamMemberController::class, 'update']);
    Route::delete('/team/{teamMember}', [TeamMemberController::class, 'destroy']);
    
    Route::get('/menu-categories', [MenuCategoryController::class, 'adminIndex']);
    Route::post('/menu-categories', [MenuCategoryController::class, 'store']);
    Route::get('/menu-categories/{menuCategory}', [MenuCategoryController::class, 'show']);
    Route::put('/menu-categories/{menuCategory}', [MenuCategoryController::class, 'update']);
    Route::delete('/menu-categories/{menuCategory}', [MenuCategoryController::class, 'destroy']);
    
    Route::get('/menu-items', [MenuItemController::class, 'adminIndex']);
    Route::post('/menu-items', [MenuItemController::class, 'store']);
    Route::get('/menu-items/{menuItem}', [MenuItemController::class, 'show']);
    Route::put('/menu-items/{menuItem}', [MenuItemController::class, 'update']);
    Route::delete('/menu-items/{menuItem}', [MenuItemController::class, 'destroy']);
    
    Route::get('/testimonials', [TestimonialController::class, 'adminIndex']);
    Route::put('/testimonials/{testimonial}/approve', [TestimonialController::class, 'approve']);
    Route::put('/testimonials/{testimonial}/reject', [TestimonialController::class, 'reject']);
    Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy']);
    
    Route::get('/reservations', [ReservationController::class, 'adminIndex']);
    Route::put('/reservations/{reservation}', [ReservationController::class, 'update']);
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy']);
});
