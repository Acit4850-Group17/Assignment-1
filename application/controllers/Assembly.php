<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//NOTE that it extends application, not CI_CONTROLLER

class Assembly extends Application {
	function __construct(){
		parent::__construct();
	}


	public function index()
	{
		//Starts session
		session_start();
		$this->data['pagebody'] = 'assembly'; //setting view to use
		$this->data['title'] = 'Bot Assembler'; //Changing nav bar to show page title

		//Redirects if the session is not started or if the loggedin variable is set to false
		if(ISSET($_SESSION['loggedIn'])){
				if($_SESSION['loggedIn'] == true){

				//prints out all the collected cards a player has using CSS to format it
				//as a table
				$table = "";
				$collection = $this->collections->collection_by_player($_SESSION['username']);
				foreach($collection as $row){
					$currentRow = "<div class='botpiece' data-token='" . $row['Token'] . "'>" .
												"<img src='/assets/images/" . $row['Series'] . $row['SubSeries'] . "-" . $row['CardPosition'] . ".jpeg' alt='Bot piece'>" .
												"<div class='botsubtitle'>" . $row['Series'] . $row['SubSeries'] . "-" . $row['CardPosition'] . "</div>" .
												"</div>";
					$table .= $currentRow;
				}

				//Setting placeholder values to the created list
				$this->data['inventory_table'] = '<h3>Collection of Bots: </h3>' . $table;
				$this->Render();
			}
			else{
				redirect('/');
			}
		}
		else{
			redirect('/');
		}
		session_write_close();
	}

	//function that is used by an ajax call (redirected in routes.php) to
	//use the collections model to get a single card via it's token
	//Only returns the row if the card belongs to the user signed in
	public function get_collection_by_token(){
		session_start();
		$pieceToken = $this->input->post('token', TRUE);
		$currentPiece = $this->collections->collection_by_token($pieceToken);

		if($currentPiece['Player'] == $_SESSION['username']){
			$currentPiece['message'] = 'success';
			echo json_encode($currentPiece, JSON_FORCE_OBJECT);
		}
		else{
			$error['message'] = "failure";
			echo json_encode($error, JSON_FORCE_OBJECT);
		}

	}

}
