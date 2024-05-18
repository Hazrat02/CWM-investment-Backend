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
    Route::get('payment', [FrontendController::class,'payment_method'])->name('payment');
    Route::post('deposit', [FrontendController::class,'deposit']);
    Route::post('kyc', [FrontendController::class,'kyc']);
    Route::get('transaction', [FrontendController::class,'transaction']);
    Route::get('work', [workController::class,'work']);
    Route::post('work.store', [workController::class,'workstor']);
    Route::post('contact.store', [workController::class,'contact_store']);
    Route::post('leads.store', [workController::class,'leads_store']);
    Route::post('useredit', [userController::class,'userEdit']);
    Route::post('user/edit', [FrontendController::class,'user_edit']);





    // admin
    Route::post('payment.store', [adminController::class,'payment_method_create']);
    Route::post('admin.deposit', [adminController::class,'admin_deposit']);
    Route::post('transfer', [adminController::class,'transfer']);
    Route::get('contact.us', [adminController::class,'contact_us']);
    Route::get('leads', [adminController::class,'leads']);
    Route::post('work.create', [adminController::class,'work_store']);
    Route::get('all.user', [adminController::class,'all_user']);
    Route::get('user.details/{id}', [adminController::class,'user_details']);
    Route::get('user.delete/{id}', [adminController::class,'user_delete']);
    Route::post('payment.edit', [adminController::class,'payment_edit']);
    Route::post('work.edit', [adminController::class,'work_edit']);
    Route::match(['put', 'patch'],'kyc.edit/{id}', [adminController::class,'kyc_edit']);
    Route::match(['put', 'patch'],'transaction.edit/{id}', [adminController::class,'transaction_edit']);
  

});
