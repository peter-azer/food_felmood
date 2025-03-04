<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FoodTypeController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\RestaurantBranchController;
use App\Http\Controllers\VisitorActionController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\NewsletterController;

//get user data
Route::get('/user', function (Request $request) {
    $user = $request->user();
    return response()->json([
        "user" => $user,
        "role" => $user->getRoleNames()
    ]);
})->middleware(['auth:sanctum', 'role:admin']);

//login routes for owner and data entry
Route::post('/login', [AuthController::class, 'login']);

//register new user as owner or data entry
Route::post('/register', [AuthController::class, 'register'])->middleware(['auth:sanctum', 'role:owner']);

// guest front-end routes
Route::prefix('guest')->group(function () {

    //food types routes
    Route::get('/food-types', [FoodTypeController::class, 'index']); #DONE
    Route::get('/food-types/{id}', [FoodTypeController::class, 'show']); #DONE

    //area routes
    Route::get('/areas', [AreaController::class, 'index']); #DONE
    Route::get('/area/{id}', [AreaController::class, 'show']); #DONE

    //restaurant routes
    Route::get('/restaurants', [RestaurantController::class, 'index']); #DONE
    Route::get('/restaurant/{id}', [RestaurantController::class, 'show']); #DONE
    Route::get('/restaurants/branches', [RestaurantBranchController::class, 'index']); #DONE
    Route::get('/restaurants/branches/{id}', [RestaurantBranchController::class, 'show']); #DONE
    #show restaurant branches based on area and food type
    Route::post('/restaurant/search', [RestaurantController::class, 'search']);
    Route::get('/restaurant/recommended', [RestaurantController::class, 'recommended']);

    //blogs routes
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/blog/{id}', [BlogController::class, 'show']);

    //contact us route
    Route::post('/contact-us', [ContactUsController::class, 'store']);

    //newsletter subscribe route
    Route::post('/newsletter', [NewsletterController::class, 'store']);

    //actions routes
    Route::post('/actions', [VisitorActionController::class, 'store']);
});

// dashboard routes
Route::middleware(['auth:sanctum', 'role:owner', 'role:data entry'])->prefix('owner')->group(function () {

    //food types routes
    Route::get('/food-types', [FoodTypeController::class, 'index']);
    Route::get('/food-type/{id}', [FoodTypeController::class, 'show']);
    Route::post('/food-type', [FoodTypeController::class, 'store']);
    Route::put('/food-type/{id}', [FoodTypeController::class, 'update']);
    Route::delete('/food-type/{id}', [FoodTypeController::class, 'destroy']);

    //area routes
    Route::get('/areas', [AreaController::class, 'index']);
    Route::get('/area/{id}', [AreaController::class, 'show']);
    Route::post('/area', [AreaController::class, 'store']);
    Route::put('/area/{id}', [AreaController::class, 'update']);
    Route::delete('/area/{id}', [AreaController::class, 'destroy']);

    //restaurant routes
    Route::get('/restaurants', [RestaurantController::class, 'index']);
    Route::get('/restaurant/{id}', [RestaurantController::class, 'show']);
    Route::post('/restaurant', [RestaurantController::class, 'store']);
    Route::put('/restaurant/{id}', [RestaurantController::class, 'update']);
    Route::delete('/restaurant/{id}', [RestaurantController::class, 'destroy']);

    //restaurant branches routes
    Route::get('/restaurants/branches', [RestaurantBranchController::class, 'index']);
    Route::get('/restaurant/branch/{id}', [RestaurantBranchController::class, 'show']);
    Route::post('/restaurant/branch', [RestaurantBranchController::class, 'store']);
    Route::put('/restaurant/branch/{id}', [RestaurantBranchController::class, 'update']);
    Route::delete('/restaurant/branch/{id}', [RestaurantBranchController::class, 'destroy']);

    //blogs routes
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/blog/{id}', [BlogController::class, 'show']);
    Route::post('/blog', [BlogController::class, 'store']);
    Route::put('/blog/{id}', [BlogController::class, 'update']);
    Route::delete('/blog/{id}', [BlogController::class, 'destroy']);

    //actions routes
    Route::get('/actions', [VisitorActionController::class, 'index']);
    Route::get('/action/{id}', [VisitorActionController::class, 'show']);
    Route::delete('/action/{id}', [VisitorActionController::class, 'destroy']);

    //contact us routes
    Route::get('/contact-us', [ContactUsController::class, 'index']);
    Route::get('/contact-us/{id}', [ContactUsController::class, 'show']);
    Route::delete('/contact-us/{id}', [ContactUsController::class, 'destroy']);

    //newsletter routes
    Route::get('/newsletters', [NewsletterController::class, 'index']);
    Route::get('/newsletter/{id}', [NewsletterController::class, 'show']);
    Route::delete('/newsletter/{id}', [NewsletterController::class, 'destroy']);
});
