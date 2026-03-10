<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::apiResource('loans', LoanController::class);

Route::patch('/loans/{id}/return', [LoanController::class, 'returnLoan']);
