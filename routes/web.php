<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReferralController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::post('/referral/generate', [ReferralController::class, 'generate']);
    Route::post('/referral/register', [ReferralController::class, 'register']);
});
