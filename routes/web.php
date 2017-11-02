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
    // for($r=0; $r<$rows; $r++) {
    // 	for($c=0; $c<$columns; $c++) {
    // 		$board[$r][$c]['color'] = 'red';
    // 	}
    // }
    return redirect()->route('restart');

});


Route::get('game/{id}/drop/{column}', 'GameController@drop');

Route::get('game/{id}', 'GameController@game')->name('game');

Route::get('/restart', 'GameController@restart')->name('restart');









