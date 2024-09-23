<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

// Register
    Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'store']);

// Login
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);

// Logout
    Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Liste User
    Route::get('/users',[\App\Http\Controllers\Auth\UserController::class,'index']);

// Delete user
    Route::delete('/users/{id}', [\App\Http\Controllers\Auth\UserController::class, 'destroy']);

// Update user
    Route::put('/users/{id}', [\App\Http\Controllers\Auth\RegisterController::class, 'update']);

// Client
Route::resource('clients', \App\Http\Controllers\ClientController::class);

// gestion de Projet
Route::resource('projects', \App\Http\Controllers\ProjectController::class);

// Gestion des milestones
Route::resource('milestones', \App\Http\Controllers\MilestoneController::class);


//Paiement

// routes/api.php
Route::get('/payments', [PaymentController::class, 'index']);
Route::get('/payments/{id}', [PaymentController::class, 'show']);
Route::post('/payments', [PaymentController::class, 'store']);
Route::put('/payments/{id}', [PaymentController::class, 'update']);
Route::delete('/payments/{id}', [PaymentController::class, 'destroy']);


// web.php ou api.php
Route::post('/projects/{id}/reminder', [ProjectController::class, 'sendReminder']);

