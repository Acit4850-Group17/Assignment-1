<?php
class Transactions extends MY_Model {


	//constructor as good practice
	function __construct(){

		parent::__construct("http://botcards.jlparry.com/data/transactions");

	}

	//Returns all transactions in descending order by post date
	//Where clause removes the title row
	function all(){
		$return = $this->get_all();
		return $return;
	}

	//gets all transactions for a single player
	function transactions_by_player($playerName){
		$name = strtolower($playerName);
		$return = $this->get_limited("player", $name);
		return $return;
	}

	// gets all transactions of a type
	// can be either 'sell' or 'buy'
	function transactions_by_type($type){
		$return = $this->get_limited("trans", $type);
		return $return;
	}
}
