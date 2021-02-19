<?php

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
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function(){
    Route::get('/cashier', 'Cashier\CashierController@index');
    Route::get('/cashier/getMenuByCategory/{category_id}', 'Cashier\CashierController@getMenuByCategory');
    Route::get('/cashier/getTable', 'Cashier\CashierController@getTables');
    Route::post('/cashier/orderFood',  'Cashier\CashierController@orderFoods');
    Route::get('/cashier/getSaleDetail/{table_id}', 'Cashier\CashierController@getSaleDetailsByTable');
    Route::post('/cashier/confirmOrderStatus', 'Cashier\CashierController@confirmOrderStatus');
    Route::post('/cashier/deleteSaleDetail', 'Cashier\CashierController@deleteSaleDetail');
    Route::post('/cashier/savePayment', 'Cashier\CashierController@savePayment');
    Route::get('/cashier/showReceipt/{sale_id}', 'Cashier\CashierController@showReceipt');
    Route::post('/cashier/increaseQuantity', 'Cashier\CashierController@increaseQuantity');
    Route::post('/cashier/decreaseQuantity', 'Cashier\CashierController@decreaseQuantity');
});

Route::middleware(['auth', 'VerifyAdmin'])->group(function(){
    Route::get('/management', function(){
        return view("management.index");
    });
    Route::resource('/management/category', 'Management\CategoryController');
    Route::resource('/management/menu', 'Management\MenuController');
    Route::resource('/management/table', 'Management\TableController');
    Route::resource('/management/user', 'Management\UserController');
    Route::resource('/report', 'Report\ReportController');
    Route::get('/report/show', 'Report\ReportController@show');
});
