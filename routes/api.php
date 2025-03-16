<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Laravel\Passport\Passport;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;


// Register Passport routes
Route::group(['prefix' => 'oauth'], function () {
    Route::post('token', [
        'uses' => 'Laravel\Passport\Http\Controllers\AccessTokenController@issueToken',
        'as' => 'passport.token',
    ]);

    Route::get('tokens', [
        'uses' => 'Laravel\Passport\Http\Controllers\AuthorizedAccessTokenController@forUser',
        'as' => 'passport.tokens.index',
    ]);

    Route::delete('tokens/{token_id}', [
        'uses' => 'Laravel\Passport\Http\Controllers\AuthorizedAccessTokenController@destroy',
        'as' => 'passport.tokens.destroy',
    ]);
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('users', UserController::class);
    Route::apiResource('projects', ProjectController::class);


    Route::apiResource('attributes', AttributeController::class);
    Route::post('projects/{project}/attributes', [ProjectController::class, 'setAttributes']);
    Route::get('projects/{project}/attributes', [ProjectController::class, 'getAttributes']);

});
