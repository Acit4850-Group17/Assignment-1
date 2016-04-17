<?php

/**
 * core/MY_Model.php
 *
 * A base class for any CSV based models, since accessors are the
 * identical programatically between them
 *
 * ------------------------------------------------------------------------
 */

class MY_Model extends CI_Model {

	protected $_url; //location of the CSV on the server

	//Basic constructor that sets the URL for the csv
	function __construct($url) {
        parent::__construct();
        $this->_url = $url;
    }

	//Function that gets all values and returns them as an associative
	//array, with the column headers being the index value for each row
	function get_all(){

		$return;
		$count = 0;

		$definition;
		//Check if the handle can open
		if (($handle = fopen($this->_url, "r")) !== FALSE) {
			//If the handle opened, go through each line as a csv file
		    while (($data = fgetcsv($handle, ",")) !== FALSE) {
				//the first row defines the table
				if($count == 0){
					$definition = $data;
				}
				//all other rows use the definition to assign values
				else{
					$tempRow;
					foreach($definition as $key=>$field){
						$tempRow[$field] = $data[$key];
					}
					$return[$count] = $tempRow;
				}
				$count++;
			}
		}
		fclose($handle);
		return $return;
	}

	//Function that gets all values and returns them as an associative
	//array, with the column headers being the index value for each row
	// that ALSO limits a field by a single value (since almost all our more
	// complex queries involved just a single criterion)
	function get_limited($limitField, $val){
		$return;
		$count = 0;

		$definition;
		//Check if the handle can open
		if (($handle = fopen($this->_url, "r")) !== FALSE) {
			//If the handle opened, go through each line as a csv file
		    while (($data = fgetcsv($handle, ",")) !== FALSE) {

				//the first row defines the table
				if($count == 0){
					$definition = $data;
				}

				else{
					//prepares a temp row using the definition
					$tempRow;
					foreach($definition as $key=>$field){
						$tempRow[$field] = $data[$key];
					}
					//applies logic to the temp row to see if it should select it
					if($tempRow[$limitField] == $val){
						$return[$count] = $tempRow;
					}
				}
				$count++;
			}
			if(!ISSET($return)){
				$return = "";
			}
		}
		fclose($handle);

		return $return;

	}
}


/* End of file MY_Controller.php */
/* Location: application/core/MY_Controller.php */
