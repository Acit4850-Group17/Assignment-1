<?php
class Series extends MY_Model {

	//constructor as good practice
	function __construct(){
		parent::__construct("http://botcards.jlparry.com/data/series");

	}

	// Returns all series
	// Where clause removes the first header row
	function all(){
		$return = $this->get_all();

		return $return;
	}

	//returns a single series based on it's id number/code
	function series_by_id($id){

		$return = $this->get_limited("code", $id);

		return $return;
	}
}
