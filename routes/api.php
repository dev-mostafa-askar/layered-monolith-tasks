<?php

use App\Http\Controllers\API\V1\Auth\AuthUserController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function (Router $route) {
    $route->prefix('auth')->group(function () use ($route) {
        $route->post('/sign-in', [AuthUserController::class, 'signIn']);
        $route->post('/sign-up', [AuthUserController::class, 'signUp']);
    });
});
