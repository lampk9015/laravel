<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

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
    return new JsonResponse([
        'status'  => 'Success',
        'message' => Response::$statusTexts[Response::HTTP_OK],
        'data'    => $request->user(),
    ], Response::HTTP_OK);
});

Route::middleware('auth:sanctum')->get('/messages', function (Request $request) {
    return new JsonResponse([
        'status'  => 'Success',
        'message' => Response::$statusTexts[Response::HTTP_OK],
        'data'    => [],
    ], Response::HTTP_OK);
});
