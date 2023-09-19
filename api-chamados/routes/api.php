<?php

use App\Http\Controllers\ArquivosChamadosController;
use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum', 'ability:cliente,colaborador,admin')->group(function () {
    Route::resource('/chamados', ChamadoController::class);

    Route::get('/arquivo-chamado/download/{arquivo_id}', [ArquivosChamadosController::class, 'download']);
    Route::delete('/arquivo-chamado/delete/{arquivo_id}', [ArquivosChamadosController::class, 'delete']);
    Route::post('/arquivo-chamado/upload', [ArquivosChamadosController::class, 'upload']);
    
    Route::resource('/users', UserController::class);
});

Route::post('/login', [UserController::class, 'login']);
