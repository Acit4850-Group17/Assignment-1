<?php
class Series extends CI_Model {


	
	//constructor as good practice
	function __construct(){
		
		parent::__construct();
		
	}
	
	// Returns all series
	// Where clause removes the first header row
	function all(){
		$query = $this->db->query("SELECT * from series;");
		return $query->result_array();
	}
	
	//returns a single series based on it's id number
	function series_by_id($id){
		$query = $this->db->query("SELECT * FROM series WHERE Series = $id");
		return $query->row_array();
	}
}
