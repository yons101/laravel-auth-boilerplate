<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

Route::post('/password/email', 'PasswordController@sendResetLinkEmail');
Route::post('/password/reset', 'PasswordController@reset');


Route::get('/email/resend', 'EmailVerificationController@resend')->name('verification.resend')->middleware(['auth:api']);
Route::get('/email/verify/{id}/{hash}', 'EmailVerificationController@verify')->name('verification.verify');

Route::get('/email/verify', function () {
    dd('Please verify your email');
})->middleware(['auth:api'])->name('verification.notice');

Route::get('/verified-test', function () {
    dd('You are verified');
})->middleware(['auth:api', 'verified']);
