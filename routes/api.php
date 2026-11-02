<?php

use App\Http\Controllers\User\ChatbotController;
use App\Http\Controllers\User\VietQRController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::match(['get', 'post'], '/chat', [ChatbotController::class, 'chat']);
Route::get('/chat/history', [ChatbotController::class, 'history']);

// VietQR Webhook & Order Realtime Status Polling
Route::post('/vietqr/transaction-sync', [VietQRController::class, 'handleTransactionSync']);
Route::get('/order/check-status/{order_id}', [VietQRController::class, 'checkOrderStatus']);

