<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index() {

    }

    public function drop($id, $column) {
    	
    	// error_log("in the drop function");
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
			
			// Did anyonne win?
			$isWon = $this->checkBoard($board);

			if($isWon) {
				$game->message = $game->players[$game->turn%2] . " won!";
				$game->in_progress = false;

			} 

			if($game-> turn === 42) {
				$game->message = "It's a draw!";
				$game->in_progress = false;
			}
				// Increment the Turn, Store Board, and Save Game
					//Increment turn
				$game -> turn++;
					//JSON encode
				$game -> board = json_encode($board);
					//Save
				$game -> save();
		}
		// Redraw the board
		return redirect()->route('game', ['id' => $id]);
	}

	//PRIVATE because only used/called here in controller
	public function checkBoard($board) {
		// $board is a 2-dimensional array

		// $wins is the set of lines on the board that represent wins
		$wins = [
			[ [0,0], [0,1], [0,2], [0,3] ],
			[ [1,0], [1,1], [1,2], [1,3] ]
		];

		$game_over = false;


		for ($i=0; $i<count($wins) && !$game_over; $i++) {
			// $wins[$i] = an array of coordinates

			// error_log("Checking... \$wins[" . $i . "]");
			// error_log(print_r($wins[$i], TRUE));

			$game_over = $this->compareLine(
				$board[ $wins[$i][0][0] ][ $wins[$i][0][1] ],
				$board[ $wins[$i][1][0] ][ $wins[$i][1][1] ],
				$board[ $wins[$i][2][0] ][ $wins[$i][2][1] ],
				$board[ $wins[$i][3][0] ][ $wins[$i][3][1] ]
			);	
		}
		return $game_over;
	}

	private function compareLine($a, $b, $c, $d) {
		return  $a !=='' && $a === $b && $a === $c && $a === $d;
	}

	public function game($id) {

		$game = \App\Game::find($id);

		$game_id = $id;
		$turn = $game -> turn;
		$rows = $game -> rows;
		$columns = $game -> columns;
		$board = json_decode($game->board);
		$in_progress = $game -> in_progress;
		$message = $game->message;
		
		// $players = ['Red', 'Blue'];
		$currentPlayer = $game -> players[$turn % 2];
		
	    // var_dump($board);
	    return view('board', compact('game_id','currentPlayer', 'turn', 'board', 'rows', 'columns', 'in_progress','message'));
	}

	

	public function restart() {
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
	}

}


