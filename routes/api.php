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
Route::post('/login', [AuthController::class, 'login']); #DONE

//register new user as owner or data entry
Route::post('/register', [AuthController::class, 'register'])
    ->middleware(['auth:sanctum', 'role:owner']); #DONE

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
    Route::post('/restaurants/search', [RestaurantController::class, 'search']); #DONE
    Route::get('/restaurants/recommended', [RestaurantController::class, 'recommended']); #DONE

    //blogs routes
    Route::get('/blogs', [BlogController::class, 'index']); #DONE
    Route::get('/blog/{id}', [BlogController::class, 'show']); #DONE

    //contact us route
    Route::post('/contact-us', [ContactUsController::class, 'store']); #DONE

    //newsletter subscribe route
    Route::post('/newsletter', [NewsletterController::class, 'store']); #DONE

    //actions routes
    Route::post('/actions', [VisitorActionController::class, 'store']); #DONE
});

// dashboard routes
Route::middleware(['auth:sanctum', 'role:owner|data entry'])->prefix('dashboard')->group(function () {

    //food types routes
    Route::post('/food-type', [FoodTypeController::class, 'store']); #DONE
    Route::put('/food-type/{id}', [FoodTypeController::class, 'update']); #DONE
    Route::delete('/food-type/{id}', [FoodTypeController::class, 'destroy']); #DONE

    //area routes
    Route::post('/area', [AreaController::class, 'store']); #DONE
    Route::put('/area/{id}', [AreaController::class, 'update']); #DONE
    Route::delete('/area/{id}', [AreaController::class, 'destroy']); #DONE

    //restaurant routes
    Route::post('/restaurant', [RestaurantController::class, 'store']); #DONE
    Route::put('/restaurant/{id}', [RestaurantController::class, 'update']); #DONE
    Route::delete('/restaurant/{id}', [RestaurantController::class, 'destroy']); #DONE

    //restaurant branches routes
    Route::post('/restaurant/branch', [RestaurantBranchController::class, 'store']); #DONE
    Route::put('/restaurant/branch/{id}', [RestaurantBranchController::class, 'update']); #DONE
    Route::delete('/restaurant/branch/{id}', [RestaurantBranchController::class, 'destroy']); #DONE

    //blogs routes
    Route::post('/blog', [BlogController::class, 'store']); #DONE
    Route::put('/blog/{id}', [BlogController::class, 'update']); #DONE
    Route::delete('/blog/{id}', [BlogController::class, 'destroy']); #DONE

    //actions routes
    Route::get('/actions', [VisitorActionController::class, 'index']); #DONE
    Route::get('/action/{id}', [VisitorActionController::class, 'show']); #DONE
    Route::delete('/action/{id}', [VisitorActionController::class, 'destroy']); #DONE

    //contact us routes
    Route::get('/contact-us', [ContactUsController::class, 'index']); #DONE
    Route::get('/contact-us/{id}', [ContactUsController::class, 'show']); #DONE
    Route::delete('/contact-us/{id}', [ContactUsController::class, 'destroy']); #DONE

    //newsletter routes
    Route::get('/newsletters', [NewsletterController::class, 'index']); #DONE
    Route::delete('/newsletter/{id}', [NewsletterController::class, 'destroy']); #DONE
});
