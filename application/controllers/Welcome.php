<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//NOTE that it extends application, not CI_CONTROLLER

class Welcome extends Application {
	function __construct(){
		parent::__construct();
	}


	public function index()
	{

		//Setting up the game status
		$gameStatus = '<h1>Game is <b>ACTIVE!</b></h1>';

		//Code to print out all known series with values and descriptions
		$series = $this->series->all();
		$seriesCollection = "<h3>Known Series: </h3>";
		foreach($series as $row){
			$seriesCollection .= "<div>Series " . $row['Series'] . ": " . $row['Description'] . ", with a value of " . $row['Value'] ." peanuts</div>";
		}

		$this->data['pagebody'] = 'Welcome'; //setting view to use
		$this->data['title'] = 'Bot Card Collector'; //Changing nav bar to show page title

		//Code to create a list of all the players and their status (peanuts and equity)
		$list = "";
		$players = $this->collections->get_players();
		foreach($players as $player) {
			$equity = $this->collections->get_player_equity($player['Player']);
			$peanuts = $this->players->get_player_peanuts($player['Player']);
			$list .= "<div><a href='/portfolio/" . $player['Player'] . "'>Player " . $player['Player'] . "</a>: Equity: " . ($equity + $peanuts) . ", Peanuts: " . $peanuts . "</div>";
		}

		//Setting all the created data to their appropriate placeholders
		$this->data['GameStatus'] = '<h3>Game Status: </h3>' . $gameStatus;
		$this->data['Series'] = $seriesCollection;
		$this->data['EquityTable'] = '<h3>Players: </h3>' . $list;
		$this->Render();
		//$this->findCardSet();

	}

}
