<?php
class Players extends CI_Model {

	//constructor as good practice
	function __construct(){

		parent::__construct();

	}

	//Returns all players
	//Where clause removes header row
	function all(){
		$query = $this->db->query("SELECT player, peanuts, admin, avatarURI FROM players;");
		return $query->result_array();
	}

	//Returns single player where the argument name is found
	function player_by_name($playerName){
		$query = $this->db->query("SELECT player, peanuts FROM players WHERE player = '$playerName';");
		return $query->row_array();
	}
	//Returns a single players peanutes based on player name
	function get_player_peanuts($playerName){
		$query = $this->db->query("SELECT player, peanuts FROM players WHERE player = '$playerName';");
		$value = $query->result_array();
		return $value[0]['peanuts'];
	}

	function set_player_peanuts($playerName, $peanuts){
		$query = $this->db->query("UPDATE players SET peanuts = $peanuts WHERE player = '$playerName';");
		return $query;
	}

	function create_player($player, $password, $avatarURI){
		$passEncrypt = password_hash($password, PASSWORD_DEFAULT);
		$query = $this->db->query("INSERT INTO players (player, password, avatarURI) VALUES ('$player', '$passEncrypt', '$avatarURI')");
		return $query;
	}

	function check_player_credential($player, $password){
		$query = $this->db->query("SELECT player, password FROM players WHERE player = '$player';");
		$result = $query->row_array();
		return password_verify($password, $result['password']);

	}

	function get_player_admin($playerName){
		$query = $this->db->query("SELECT admin FROM players WHERE player = '$playerName';");
		$value = $query->row_array();
		$return = false;
		if($value['admin'] == "1"){
			$return = true;
		}

		return $return;

	}

	function delete_player($playerName){
		$query = $this->db->query("DELETE FROM players WHERE player = '$playerName';");
		return $query;
	}

	function adminify_player($playerName){
		$query = $this->db->query("UPDATE players SET admin = 1 WHERE player = '$playerName';");
		return $query;
	}
}
