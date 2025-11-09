<?php

use App\Http\Controllers\Api\ActivitiesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\BalanceController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| All endpoints for the Multi-Branch Accounting System (JWT-Protected)
|--------------------------------------------------------------------------
*/

// ----------------------------
// 🔐 AUTHENTICATION ROUTES
// ----------------------------
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']); // create new user
    Route::post('login', [AuthController::class, 'login']);       // login -> token

    // protected by jwt.auth middleware
    Route::middleware('auth:api')->group(function () {
        Route::get('profile', [AuthController::class, 'profile']); // get user info
        Route::post('logout', [AuthController::class, 'logout']);  // invalidate token
        Route::post('refresh', [AuthController::class, 'refresh']); // refresh token
    });
});

// ----------------------------
// 🏢 BRANCH ROUTES
// ----------------------------
Route::middleware('auth:api')->prefix('branches')->group(function () {
    Route::get('/', [BranchController::class, 'index']);      // admin: all | user: own branch
    Route::get('/{id}', [BranchController::class, 'show']);   // view single branch

    // Admin only routes
    Route::middleware('role:admin')->group(function () {
        Route::post('/', [BranchController::class, 'store']);     // create branch
        Route::put('/{id}', [BranchController::class, 'update']); // update branch
        Route::delete('/{id}', [BranchController::class, 'destroy']); // delete branch
    });
});


// ----------------------------
// 💰 BALANCE ROUTES (Read-only)
// ----------------------------
Route::middleware('auth:api')->prefix('balances')->group(function () {
    Route::get('/', [BalanceController::class, 'index']);  // admin: all | user: own branch
    Route::get('/{id}', [BalanceController::class, 'show']);
});

// ----------------------------
// 🗂 CATEGORY ROUTES
// ----------------------------
Route::middleware('auth:api')->prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{id}', [CategoryController::class, 'show']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::put('/{id}', [CategoryController::class, 'update']);
    Route::delete('/{id}', [CategoryController::class, 'destroy']);
});

// ----------------------------
// 💸 TRANSACTION ROUTES
// ----------------------------
Route::middleware('auth:api')->prefix('transactions')->group(function () {
    Route::get('/', [TransactionController::class, 'index']);      // admin: all | user: own branch
    Route::get('/{id}', [TransactionController::class, 'find']);   // get single or by user id
    Route::post('/', [TransactionController::class, 'store']);     // create
    Route::put('/{id}', [TransactionController::class, 'update']); // update
    Route::delete('/{id}', [TransactionController::class, 'destroy']); // delete
});


// ----------------------------
// 📊 ACTIVITY LOG ROUTES (Admin Only)
// ----------------------------

Route::middleware('auth:api', 'role:admin')->prefix('activities')->group(function () {
    Route::get('/', [ActivitiesController::class, 'index']);
    Route::get('/{id}', [ActivitiesController::class, 'show']);
});
