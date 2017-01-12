<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// Only authenticated users.
Route::group(['middleware' => 'auth'], function () {
    // Only Admins or Employees.
    Route::group(['middleware' => 'group:Admin,Employee'], function () {
        Route::get('bought-stocks', 'StockController@boughtStocks');
        Route::get('sold-stocks', 'StockController@soldStocks');
        Route::post('stocks/favorite', 'StockController@favorite');
        Route::post('stocks/search/{query}', 'StockController@search');
        Route::get('stocks/{symbol}', 'StockController@show');
        Route::post('stocks/{symbol}', 'StockController@show');
        Route::post('stocks/{symbol}/buy', 'StockController@buy');
        Route::post('stocks/{symbol}/sell', 'StockController@sell');
        Route::post('stocks/{symbol}/note', 'StockController@saveNote');
        Route::get('users/{userId}/sold', 'UserStocksController@sold');
        Route::get('users/{userId}/bought', 'UserStocksController@bought');
        Route::get('', 'HomeController@index');
        Route::resource('announcements', 'AnnouncementsController');
        // Only admins.
        Route::group(['middleware' => 'group:Admin'], function() {
            Route::get('edit-eotm', 'EOTMController@edit');
            Route::post('edit-eotm', 'EOTMController@update');
            Route::resource('users/{userId}/client','EmployeeClientController');
        });
    });
    Route::get('auth/logout', 'Auth\AuthController@getLogout');
    Route::resource('users', 'UsersController');
});

// Authentication routes.
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');

