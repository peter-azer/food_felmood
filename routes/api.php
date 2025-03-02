<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
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
Route::prefix('guest')->group(function (){

});
// owner and dashboard routes
Route::middleware('role:owner')->prefix('owner')->group(function (){
    
});
// data entry and forms routs
Route::middleware('role:data entry')->prefix('data')->group(function (){
    
});