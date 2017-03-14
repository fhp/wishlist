<?php

use Wenslijst\Pages\VisitorsPage;
use Wenslijst\Pages\WenslijstPage;
use Wenslijst\Pages\LoginPage;

Route::any('/', function () {
    return new WenslijstPage();
})->name('home');


Route::any('/login', function () {
	return new LoginPage();
})->name('login');

Route::any('/logout', function () {
	Auth::logout();
	return redirect()->route("home");
})->name('logout');


Route::any('/visitors', function () {
    return new VisitorsPage();
})->middleware('auth')->name("visitorList");
