<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail']);

