<?php
class Collections extends CI_Model {

	//constructor as good practice
	function __construct(){

		parent::__construct();

	}

	//Returns all collected robots in descending order by post date
	// Where clause removes header row
	function all(){
		$query = $this->db->query(" SELECT Series,
									SUBSERIES,
									CardPosition,
									Player,
									Token,
									Datetime
									FROM collections ORDER BY Datetime DESC;");

		return $query->result_array();
	}

	//returns all collected robots for a single player ordered by date, descending (most recent to least)
	function collection_by_player($playerName){
		$query = $this->db->query(" SELECT Series,
									SubSeries,
									CardPosition,
									Player,
									Token,
									Datetime
									FROM collections
									WHERE Player = '$playerName' ORDER BY Datetime DESC;");
		return $query->result_array();
	}

	//returns a count of the players cards
	function get_player_equity($playerName){
		$query = $this->db->query("SELECT COUNT(*) AS Equity FROM collections WHERE player = '$playerName'");
		$value = $query->result_array();
		return $value[0]['Equity'];
	}

	//returns all distinct players in the collections table
	function get_players(){
		$query = $this->db->query("SELECT distinct(Player) FROM collections;");
		return $query->result_array();
	}

	//returns a single card based on it's token
	function collection_by_token($token){
		$query = $this->db->query("SELECT * FROM collections WHERE Token = '$token';");
		return $query->row_array();
	}



}
