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

use Wenslijst\Http\PageFlowException;
use Wenslijst\Pages\AddPresentPage;
use Wenslijst\Pages\WenslijstPage;
use Wenslijst\Pages\LoginPage;

Route::any('/', function () {
    return new WenslijstPage();
})->name('home');


Route::any('/login', function () {
	try {
		return new LoginPage();
	} catch (PageFlowException $e) {
		return $e->response();
	}
})->name('login');

Route::any('/logout', function () {
	Auth::logout();
	return redirect()->route("home");
})->name('logout');


Route::any('/add', function () {
    return new AddPresentPage();
})->middleware('auth')->name("addPresent");
