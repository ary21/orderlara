<?php

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/customers', 'CustomerController');

Route::resource('/orders', 'OrderController');
Route::get('/orders/getcustomer/{id}', 'OrderController@getcustomer');
Route::get('/orders/details/{id}', 'OrderController@detail');
