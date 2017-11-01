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

    // var_dump($board);
    return redirect()->route('restart');

});


Route::get('game/{id}/drop/{column}', function($id, $column) {
	
	// Get the current game
	$game = \App\Game::find($id);
		//JSON decode
	$board = json_decode($game->board);

	// Put checker in column
	$placed_checker = false;
	for($i=0;$i<$game->rows;$i++){
		if ($board[$i][$column] === '') {
			$board[$i][$column] = $game->players[$game->turn %2];
			$placed_checker = true;
			break;
		}
	}

	if ($placed_checker) {
		
		// Check for Win

		// Increment the turn, Store board, and save
			//Increment turn
		$game -> turn++;
			//JSON encode
		$game -> board = json_encode($board);
			//Save
		$game -> save();
	}
	

	// Redraw the board
	return redirect()->route('game', ['id' => $id]);
	$placed_checker = false;

});

Route::get('game/{id}', function($id) {

	$game = \App\Game::find($id);

	$game_id = $id;
	$turn = $game -> turn;
	$rows = $game -> rows;
	$columns = $game -> columns;
	$board = json_decode($game->board);
	
	// $players = ['Red', 'Blue'];
	$currentPlayer = $game -> players[$turn % 2];
	
    // var_dump($board);
    return view('board', compact('game_id','currentPlayer', 'turn', 'board', 'rows', 'columns'));

})->name('game');

Route::get('/restart', function() {
	// TODO: End the old game 
	// ??? Set in_progress to false ?? 
	// Not safe to do until we have user logins

	// Make a new game
	$game = new \App\Game;
		//Start turns at 1
	$game -> turn = 1;
		//Start with empty board
	$board = [];
		//Build new board
		for($r=0; $r<$game -> rows; $r++) {
    		for($c=0; $c<$game -> columns; $c++) {
    			$board[$r][$c] = '';
    		}
    	}
    	//Board in games table is equal to the board we just build
    $game->board = json_encode($board);


	$game -> save();
	// $id = $game['id'];
	// $game -> turn = 1;
	$id = $game -> id;

	// Redirect to the board
	return redirect()->route('game', ['id' => $id]);
})->name('restart');







