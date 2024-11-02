<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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

Route::middleware('auth:sanctum', 'role:admin')->get('/admin', function (Request $request) {
    // return $request->user();
    return response ()->json(['message'=> 'Welcome Admin!!']);
});


Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->put('/profile', [AuthController::class, 'updateprofil']);

Route::middleware(['auth:sanctum', 'role:admin'])->delete('mydelete/{id}', [AuthController::class, 'deleteuser']);
Route::middleware(['auth:sanctum', 'role:admin'])->get('/showall', [AuthController::class, 'index']);