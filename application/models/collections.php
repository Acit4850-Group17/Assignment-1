<?php
class Collections extends MY_Model {

	//constructor as good practice
	function __construct(){
		parent::__construct("http://botcards.jlparry.com/data/certificates");
	}

	//Returns all collected robots in descending order by post date
	// Where clause removes header row
	function all(){
		$return = $this->get_all();
		return $return;
	}

	//returns all collected robots for a single player ordered by date, descending (most recent to least)
	function collection_by_player($playerName){
		$name = strtolower($playerName);
		//should probably also filter by agent in case two players have the same name
		$return = $this->get_limited("player", $name);
		return $return;
	}

	//returns a count of the players cards
	function get_player_equity($playerName){
		$name = strtolower($playerName);
		$return = $this->get_limited("player", $name);
		if($return != ""){
			$value = count($return);
		}
		else{
			$value = 0;
		}
		return $value;
	}

	//returns all distinct players in the collections table
	function get_players(){
		$return = $this->get_all();
		$players;
		foreach($return as $piece){
			$players[] = $piece["player"];
		}
		return array_unique($players);
	}

	//returns a single card based on it's token
	function collection_by_token($token){
		$return = $this->get_limited("token", $token);
		return $return;
	}



}
