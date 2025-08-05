<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ParentController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\ClassController;
use App\Http\Controllers\Api\ClassRegistrationController;
use App\Http\Controllers\Api\SubscriptionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Parents API
Route::get('/parents', [ParentController::class, 'index']);
Route::post('/parents', [ParentController::class, 'store']);
Route::get('/parents/{parent}', [ParentController::class, 'show']);

// Students API
Route::get('/students', [StudentController::class, 'index']);
Route::post('/students', [StudentController::class, 'store']);
Route::get('/students/{student}', [StudentController::class, 'show']);

// Classes API
Route::post('/classes', [ClassController::class, 'store']);
Route::get('/classes', [ClassController::class, 'index']);

// Class Registrations API
Route::post('/classes/{class}/register', [ClassRegistrationController::class, 'store']);

// Subscriptions API
Route::post('/subscriptions', [SubscriptionController::class, 'store']);
Route::get('/subscriptions/{subscription}', [SubscriptionController::class, 'show']);
Route::patch('/subscriptions/{subscription}/use', [SubscriptionController::class, 'use']);