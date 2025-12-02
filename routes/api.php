<?php

use App\Http\Controllers\AuthController;
use \App\Http\Controllers\OcrController;
use App\Http\Controllers\ReceiptController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/ocr/extract', [OcrController::class, 'extract'])->middleware('auth:sanctum');

Route::apiResource('receipts', ReceiptController::class)->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
