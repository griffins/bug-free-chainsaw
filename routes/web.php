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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {	
	return redirect()->route('match');
});

Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth', 'namespace' => "\App\Http\Controllers"], function () {
    Route::get('/match', 'MatchController@index')->name('match');
    Route::get('/match/ended', 'MatchController@ended')->name('match.ended');
    Route::any('/match/dryrun', 'MatchController@dryrun')->name('match.dryrun');
    Route::group(['prefix' => 'user'], function () {
        Route::resource('user', 'UserController', ['except' => ['show']]);
        Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
        Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
        Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
    });
});
