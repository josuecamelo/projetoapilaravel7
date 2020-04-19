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

Route::group(['prefix' => 'v1'], function () {
    Route::group(['middleware' => 'cors'], function () {
        Route::group(['middleware' => 'jwt.auth'], function () {

        });

        //obter token
        Route::post('login', 'Api\AuthController@login');

        //para atualizar o token
        Route::post('refresh_token', function () {
            try {
                $token = JWTAuth::parseToken()->refresh();
                return response()->json([
                    'success' => true,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                ]);
            } catch (JWTException $exception) {
                return response()->json(['error' => 'token_invalid'], 400);
            }
        });
    });
});
