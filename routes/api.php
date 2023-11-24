<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\admin\adminController;
use App\Http\Controllers\Frontend\userController;
use App\Http\Controllers\Frontend\workController;
use App\Models\User;
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


Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login'])->name('login');
    Route::post('forgetcode', [AuthController::class,'sendForgetEmail'])->name('sendForgetEmail');
    Route::post('register', [AuthController::class,'register'])->name('register');
    Route::post('logout', [AuthController::class,'logout'])->name('logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', [AuthController::class,'me']);
    Route::post('forget', [AuthController::class,'forget']);

});

Route::group([

    'middleware' => ['api'],
    'namespace' => 'App\Http\Controllers',
   

], function ($router) {

    //all_user
    Route::get('ask', [FrontendController::class,'ask']);
    Route::get('payment', [FrontendController::class,'payment_method'])->name('payment');
    Route::post('deposit', [FrontendController::class,'deposit']);
    Route::post('kyc', [FrontendController::class,'kyc']);
    Route::get('transaction', [FrontendController::class,'transaction']);
    Route::get('vip', [FrontendController::class,'vip']);
    Route::get('work', [workController::class,'work']);
    Route::post('work.store', [workController::class,'workstor']);
    Route::post('useredit', [userController::class,'userEdit']);
    Route::get('reffer.user', [userController::class,'reffer_details']);





    // admin
    Route::post('payment.store', [adminController::class,'payment_method_create']);
    Route::post('vip.store', [adminController::class,'vip_store']);
    Route::post('vipunlock.store', [adminController::class,'vipunlock_store']);
    Route::post('work.create', [adminController::class,'work_store']);
    Route::post('ask.store', [adminController::class,'ask_store']);
    Route::get('all.user', [adminController::class,'all_user']);
    Route::get('user.delete/{id}', [adminController::class,'user_delete']);
    Route::delete('vip/delete/{id}', [adminController::class,'vip_delete']);
    Route::delete('work.delete/{id}', [adminController::class,'work_delete']);
    Route::delete('ask.delete/{id}', [adminController::class,'ask_delete']);
    Route::delete('payment.delete/{id}', [adminController::class,'payment_delete']);
    Route::delete('unlock.delete/{id}', [adminController::class,'unlock_delete']);
    Route::post('user/edit', [FrontendController::class,'user_edit']);
    Route::post('payment.edit', [adminController::class,'payment_edit']);
    // Route::match(['put', 'patch'],'user/edit', [FrontendController::class,'user_edit']);
    Route::match(['put', 'patch'],'vip.edit/{id}', [adminController::class,'vip_edit']);
    Route::match(['put', 'patch'],'work.edit/{id}', [adminController::class,'work_edit']);
    Route::match(['put', 'patch'],'ask.edit/{id}', [adminController::class,'ask_edit']);
    Route::match(['put', 'patch'],'transaction.edit/{id}', [adminController::class,'transaction_edit']);
  

});
