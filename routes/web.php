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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'Admin\HomeController@index')->name('home');

Route::group(
    [
        "as"            =>  "admin.company.",
        "prefix"        =>  "company",
        "namespace"     =>  "Admin",
    ],
    function() {
        Route::get('/',
            [
                "uses"  => "CompanyController@index",
                "as"    => "home",
            ]
        );
        Route::get('/create',
            [
                "uses"  =>  "CompanyController@create",
                "as"    =>  "create"
            ]
        );
        Route::post('/create',
            [
                "uses"  => "CompanyController@store",
            ]
        );
        Route::get('/edit/{id}',
            [
                "uses"  => "CompanyController@edit",
                "as"    => "edit"
            ]
        );
        Route::post('/edit/{id}',
            [
                "uses"  => "CompanyController@update",
            ]
        );
        Route::get('/delete/{id}',
            [
                "uses"  => "CompanyController@destroy",
                "as"    => "delete"
            ]
        );
    }
);
