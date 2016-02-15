<?php
class Players extends CI_Model {

	//constructor as good practice
	function __construct(){

		parent::__construct();

	}

	//Returns all players
	//Where clause removes header row
	function all(){
		$query = $this->db->query("SELECT * FROM players;");
		return $query->result_array();
	}

	//Returns single player where the argument name is found
	function player_by_name($playerName){
		$query = $this->db->query("SELECT * FROM players WHERE Player = '$playerName';");
		return $query->row_array();
	}
	//Returns a single players peanutes based on player name
	function get_player_peanuts($playerName){
		$query = $this->db->query("SELECT * FROM players WHERE Player = '$playerName';");
		$value = $query->result_array();
		return $value[0]['Peanuts'];
	}
}
