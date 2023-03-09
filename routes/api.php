<?php

use App\Http\Controllers\API\AUTH\AuthController;
use App\Http\Controllers\API\PengeluaranController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/pengeluaran', [PengeluaranController::class, 'index']);
    Route::post('/pengeluaran/create', [PengeluaranController::class, 'store']);
    Route::put('/pengeluaran/edit/{id}', [PengeluaranController::class, 'update']);
    Route::delete('/pengeluaran/delete/{id}', [PengeluaranController::class, 'delete']);
});

Route::post('/register' , [AuthController::class, 'register']);
Route::post('/login' , [AuthController::class, 'login']);
