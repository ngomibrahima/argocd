<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::check()){
        return redirect()->route('auth.starter');
    }else {
        return redirect()->route('auth.login-form');
    }
});

Route::group(['middleware' => 'auth'], function () {
    //Accueil
    Route::get('accueil', [\App\Http\Controllers\AuthController::class, 'starter'])->name('auth.starter');

    Route::group(['middleware' => 'isAdmin'], function () {
        /**
         * Nature
         */
        Route::get('natures', [\App\Http\Controllers\NatureController::class, 'index'])->name('natures.index');
        Route::post('natures/store', [\App\Http\Controllers\NatureController::class, 'store'])->name('natures.store');
        Route::post('natures/{slug}/update', [\App\Http\Controllers\NatureController::class, 'update'])->name('natures.update');
        Route::get('natures/{slug}/destroy', [\App\Http\Controllers\NatureController::class, 'destroy'])->name('natures.destroy');

        /**
         * Cadeau
         */
        Route::get('declarations', [\App\Http\Controllers\CadeauController::class, 'index'])->name('cadeau.index');
        Route::post('declaration/{id}/reponse-admin', [\App\Http\Controllers\CadeauController::class, 'update'])->name('cadeau.update');
    });

    Route::group(['middleware' => 'isSuperAdmin'], function () {
        /**
         * Gestion utilisateur
         */
        Route::get('utilisateurs', [\App\Http\Controllers\AuthController::class, 'usersList'])->name('auth.users-list');
        Route::post('utilisateurs', [\App\Http\Controllers\AuthController::class, 'createUser'])->name('auth.create-user');
        Route::get('utilisateurs/{id}/supprimer', [\App\Http\Controllers\AuthController::class, 'deleteUser'])->name('auth.delete-user');
    });



    /**
     * Cadeau
     */

    Route::post('declarations', [\App\Http\Controllers\CadeauController::class, 'store'])->name('cadeau.store');
    Route::get('declaration/{id}', [\App\Http\Controllers\CadeauController::class, 'show'])->name('cadeau.show');
    Route::get('mes-declarations', [\App\Http\Controllers\CadeauController::class, 'mesDeclarations'])->name('cadeau.mesDeclarations');



    Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');

});

/**
 * Auth
 */
Route::get('connexion', [\App\Http\Controllers\AuthController::class, 'loginForm'])->name('auth.login-form');
Route::post('connexion', [\App\Http\Controllers\AuthController::class, 'login'])->name('auth.login');
Route::get('connexion/email-verification', [\App\Http\Controllers\AuthController::class, 'verifyTokenForm'])->name('auth.verify-token-form');
Route::post('connexion/email-verification', [\App\Http\Controllers\AuthController::class, 'verifyToken'])->name('auth.verify-token');



