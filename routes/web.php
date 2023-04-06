<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscribedController;
use App\Http\Controllers\CaixaController;

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

Route::middleware("authaccess")->group(function () {
    //inscritos
    Route::get('/inscritos', [SubscribedController::class, 'index']);
    Route::get('/inscritos/lista', [SubscribedController::class, 'list']);
    Route::get('/inscritos/details/{id}', [SubscribedController::class, 'detail']);
    Route::get('/inscritos/changeStatus/{id}', [SubscribedController::class, 'changeStatus']);
    Route::put('/inscritos/saveChangeStatus', [SubscribedController::class, 'saveChangeStatus']);
    Route::get('/inscritos/export', [SubscribedController::class, 'export']);

    Route::get('/addpayment', [CaixaController::class, 'addPayment']);
    Route::post('/payment', [CaixaController::class, 'savePayment']);

    Route::get('/financas', [CaixaController::class, 'index']);
    Route::get('/financas/lista', [CaixaController::class, 'list']);
    Route::get('/financas/create', [CaixaController::class, 'create']);
    Route::post('/financas/store', [CaixaController::class, 'store']);
});

//login 
Route::get('/', [UserController::class, 'login'])->name('login');
Route::post('/handleLogin', [UserController::class, 'handleLogin']);
Route::get('/logout', [UserController::class, 'logout']);
