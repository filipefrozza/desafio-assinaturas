<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssinaturaController;
use App\Http\Controllers\FaturaController;

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

Route::group(['middleware' => ['auth:api', 'permission']], function () {
    Route::get('users', [UserController::class, 'list'])->name('users.index');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/info', [UserController::class, 'info'])->name('users.info');
    Route::get('users/{id}/assinaturas', [UserController::class, 'show_assinaturas'])->name('users.show.assinaturas');
    Route::get('users/{id}/faturas', [UserController::class, 'show_faturas'])->name('users.show.faturas');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
    
    Route::get('assinaturas', [AssinaturaController::class, 'list'])->name('assinaturas.index');
    Route::post('assinaturas', [AssinaturaController::class, 'store'])->name('assinaturas.store');
    Route::get('assinaturas/info', [AssinaturaController::class, 'info'])->name('assinaturas.info');
    Route::get('assinaturas/{id}/faturas', [AssinaturaController::class, 'show_faturas'])->name('assinaturas.show.faturas');
    Route::put('assinaturas/{id}', [AssinaturaController::class, 'update'])->name('assinaturas.update');
    Route::delete('assinaturas/{id}', [AssinaturaController::class, 'destroy'])->name('assinaturas.destroy');
    Route::get('assinaturas/{id}', [AssinaturaController::class, 'show'])->name('assinaturas.show');
    
    Route::get('faturas', [FaturaController::class, 'list'])->name('faturas.index');
    Route::post('faturas', [FaturaController::class, 'store'])->name('faturas.store');
    Route::get('faturas/info', [FaturaController::class, 'info'])->name('faturas.info');
    Route::put('faturas/{id}', [FaturaController::class, 'update'])->name('faturas.update');
    Route::delete('faturas/{id}', [FaturaController::class, 'destroy'])->name('faturas.destroy');
    Route::get('faturas/{id}', [FaturaController::class, 'show'])->name('faturas.show');
    
    
    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionsController::class);
});

Route::post("login", [UserController::class, 'login']);
