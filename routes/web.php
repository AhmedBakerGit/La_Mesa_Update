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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', function () { return redirect('login'); });

Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function(){
  Route::get('/', function () { return redirect('admin/login'); });
  
  Route::middleware('auth')->group(function() {
    Route::get('login', 'LoginController@index')->name('login');
    Route::post('login/submit', 'LoginController@authenticate')->name('login.submit');
    Route::get('register', 'RegisterController@index')->name('register');
    Route::post('register/submit', 'RegisterController@submit')->name('register.submit');
    Route::get('logout', 'LoginController@logout')->name('logout');


    Route::get('restaurants', 'RestaurantController@index')->name('restaurants');
    Route::post('restaurants/submit', 'RestaurantController@submit')->name('restaurants.submit');

    Route::get('restcontent/{id}', 'RestContectController@index')->name('restcontent');

    Route::get('staff', 'StaffController@index')->name('staff');
    
    Route::get('sales', 'SalesController@index')->name('sales');   
  });
});

Route::prefix('/ajax/admin')->name('ajax.admin.')->namespace('Admin')->group(function() {
  Route::post('restaurants/{id}', 'RestaurantController@getRestInfo');
  Route::post('restaurants/{id}/delete', 'RestaurantController@delete');

  Route::get('restcontent/{id}/getTable', 'RestContectController@getTable');
  Route::post('restcontent/{id}/addTable', 'RestContectController@addTable');
  Route::get('restcontent/{id}/getMenuAll', 'RestContectController@getMenuAll');
  Route::post('restcontent/{id}/getMenuOne', 'RestContectController@getMenuOne');
  Route::post('restcontent/{id}/menuSubmit', 'RestContectController@menuSubmit');
  Route::post('restcontent/{id}/deleteMenu', 'RestContectController@deleteMenu');

  Route::get('staff/getAll', 'StaffController@getAll');
  Route::post('staff/getOne', 'StaffController@getOne');
  Route::post('staff/submit', 'StaffController@submit');
  Route::post('staff/delete', 'StaffController@delete');
  
});

Route::get('login', 'StaffAuth\LoginController@index')->name('login');
Route::post('login/submit', 'StaffAuth\LoginController@authenticate')->name('login.submit');
Route::get('checkstaff', 'StaffAuth\LoginController@checkstaff');
Route::get('logout', 'StaffAuth\LoginController@logout')->name('logout');

Route::prefix('/manager')->name('manager.')->namespace('Manager')->group(function(){
  Route::get('/', function () { return redirect('manager/orders'); });
  
  Route::middleware(['staff.login', 'staff.manager'])->group(function() {
    Route::get('orders', 'OrderController@index')->name('orders');
    Route::get('staffs', 'StaffController@index')->name('staffs');
    Route::get('menu', 'MenuController@index')->name('menu');
    Route::get('request', 'RequestController@index')->name('request');
    Route::get('bills', 'BillController@index')->name('bills');
  });
  
});


Route::prefix('/ajax/manager')->name('ajax.manager.')->namespace('Manager')->group(function() {
  Route::get('staff/getAll', 'StaffController@getAll');
  Route::post('staff/getOne', 'StaffController@getOne');
  Route::post('staff/submit', 'StaffController@submit');
  Route::post('staff/delete', 'StaffController@delete');
  
  Route::get('getMenuAll', 'MenuController@getMenuAll');
  Route::get('getMenuAvailable', 'MenuController@getMenuAvailable');
  Route::post('changeAvailable', 'MenuController@changeAvailable');
});

Route::prefix('/cashier')->name('cashier.')->namespace('Cashier')->group(function(){
  Route::get('/', function () { return redirect('cashier/orders'); });
  
  Route::middleware(['staff.login', 'staff.cashier'])->group(function() {
    Route::get('orders', 'OrderController@index')->name('orders');
    Route::get('menu', 'MenuController@index')->name('menu');
    Route::get('request', 'RequestController@index')->name('request');
    Route::get('bills', 'BillController@index')->name('bills');
  });
});

Route::prefix('/ajax/cashier')->name('ajax.cashier.')->group(function() {
  
  Route::get('getMenuAll', 'Manager\MenuController@getMenuAll');
  Route::post('changeAvailable', 'Manager\MenuController@changeAvailable');
  Route::post('checkManagerCredentials', 'Cashier\OrderController@checkManagerCredentials');
});

Route::prefix('/kitchen')->name('kitchen.')->namespace('Kitchen')->group(function(){
  Route::get('/', function () { return redirect('kitchen/orders'); });
  
  Route::middleware(['staff.login', 'staff.kitchen'])->group(function() {
    Route::get('orders', 'OrderController@index')->name('orders');
    Route::get('menu', 'MenuController@index')->name('menu');
  });
});

Route::prefix('/ajax/kitchen')->name('ajax.kitchen.')->group(function() {
  
  Route::get('getMenuAll', 'Manager\MenuController@getMenuAll');
  Route::post('changeAvailable', 'Manager\MenuController@changeAvailable');
});

Route::prefix('/mobile')->namespace('Mobile')->group(function() {
  Route::get('checkRestaurant', 'MobileController@checkRestaurant');
  Route::get('getMenus', 'MobileController@getMenus');
  Route::get('exit', 'MobileController@exit');
});