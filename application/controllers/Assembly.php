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
				if($collection != ""){
					foreach($collection as $row){
						$currentRow = "<div class='botpiece' data-token='" . $row['token'] . "'>" .
													"<img src='/assets/images/" . $row['piece'] . ".jpeg' alt='Bot piece'>" .
													"<div class='botsubtitle'>" . $row['piece'] . "</div>" .
													"</div>";
						$table .= $currentRow;
					}
				}
				else{
					$table .= "<h2>This player has no bots</h2>";
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
	public function select_bot(){
		session_start();
		$pieceToken = $this->input->post('token', TRUE);

		$currentPiece = $this->collections->collection_by_token($pieceToken);
		$currentPiece = array_shift($currentPiece);

		if($currentPiece['player'] == $_SESSION['username']){
			$currentPiece['message'] = 'success';
			echo json_encode($currentPiece, JSON_FORCE_OBJECT);
		}
		else{
			$error['message'] = "failure";
			echo json_encode($error, JSON_FORCE_OBJECT);
		}

	}

	public function buy_bot(){
		session_start();
		echo $_SESSION['team'];
		echo  $_SESSION['token'];
		echo $_SESSION['username'];
		if(ISSET($_SESSION['team'], $_SESSION['token'], $_SESSION['username'])){

			$team = $_SESSION['team'];
			$token = $_SESSION['token'];
			$username = $_SESSION['username'];

			//using code found in Admin.php for base
			$url = 'http://botcards.jlparry.com/buy';
			$data = array('team' => $team, 'token' => $token, 'player' => $username);

			$options = array(
				'http' => array(
					'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
					'method'  => 'POST',
					'content' => http_build_query($data)
				)
			);
			//opening up the connection
			$context  = stream_context_create($options);
			//getting results
			$result = file_get_contents($url, false, $context);
			//if an error with the connection
			if ($result === FALSE) { /* Handle error */ }
			print_r ($result);
			//loading the xml
			$xml = simplexml_load_string($result);

		}

	}


}
