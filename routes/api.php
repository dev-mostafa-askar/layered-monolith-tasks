<?php

use App\Http\Controllers\API\V1\Auth\AuthUserController;
use App\Http\Controllers\API\V1\TaskController;
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

    $route->prefix('tasks')->middleware('auth:api')->group(function () use ($route) {
        $route->get('/', [TaskController::class, 'index']);
        $route->post('/', [TaskController::class, 'create']);
        $route->put('/{id}', [TaskController::class, 'update']);
        $route->patch('/{id}', [TaskController::class, 'updateTaskStatus']);
        $route->delete('/{id}', [TaskController::class, 'delete']);
    });
});
