<?php
class Transactions extends CI_Model {
	
	
	//constructor as good practice
	function __construct(){
		
		parent::__construct();
		
	}
	
	//Returns all transactions in descending order by post date
	//Where clause removes the title row
	function all(){
		$query = $this->db->query("SELECT * FROM transactions ORDER BY DateTime DESC;");
		
		return $query->result_array();
	}
	
	//gets all transactions for a single player
	function transactions_by_player($playerName){
		$query = $this->db->query("SELECT * FROM transactions WHERE Player = '$playerName';");
		return $query->result_array();
	}
	
	// gets all transactions of a type
	// can be either 'sell' or 'buy'
	function transactions_by_type($type){
		$query = $this->db->query("SELECT * FROM transactions WHERE Trans = '$type';");
		return $query->result_array();
	}
}
