<?php

use App\Http\Controllers\AuthController;
use App\Mail\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

// Route::get('/test',function(){
//     Mail::to('aya@ecommarce.com')->send(
//         new EmailVerification()
//     );
//  return 'done';
//     // return new \App\Mail\EmailVerification();
// });



Route::post('/register', [AuthController::class,  'register']);
Route::get('/verify-email/{token}', [AuthController::class, 'verifyMail']);
Route::post('/login', [AuthController::class,  'login']);
Route::post('/logout', [AuthController::class,  'logout'])->middleware('auth:sanctum');
