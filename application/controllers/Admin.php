<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//NOTE that it extends application, not CI_CONTROLLER

class Admin extends Application {
	function __construct(){
		parent::__construct();
	}


	public function index()
	{
		session_start();
		$this->data['pagebody'] = 'Admin'; //setting view to use
		$this->data['title'] = 'Bot Card Collector Admin'; //Changing nav bar to show page title
		if(isset($_SESSION['loggedIn']) && isset($_SESSION['username'])){
			if($_SESSION['loggedIn'] == true){
				if($this->players->get_player_admin($_SESSION['username'])){
					$this->data['pagebody'] = 'Admin'; //setting view to use

					if($this->status->get_state() == "0"){
						$this->data['registerButton'] = "<input type='submit' value='Register App'/>";
					}
					else{
						$this->data['registerButton'] = "<div class='button'>Cannot register yet!</div>";
					}

					$players = $this->players->all();
					$rows = "";
					foreach($players as $player){
						$playerData["player"] = $player["player"];
						$playerData["admin"] = "<form action='/Admin/Adminify/". $player["player"] . "' method='POST'><input type='submit' value='Make Admin'/></form>";
						if($player['admin'] == 1){
							$playerData["admin"] = "<div>ADMIN</div>";
						}
						$rows .= $this->parser->parse('admin-row', (array) $playerData, true);
					}
					//Setting all the created data to their appropriate placeholders
					$this->data['tableData'] = $rows;

				}
				else{
					$this->data['pagebody'] = 'error_403';
				}
			}
			else{
				$this->data['pagebody'] = 'error_403';
			}
		}
		else{
			$this->data['pagebody'] = 'error_403';
		}

		$this->Render();


	}

	public function register(){
		session_start();
		$this->data['pagebody'] = 'Admin'; //setting view to use
		$this->data['title'] = 'Bot Card Collector Admin'; //Changing nav bar to show page title
		if(isset($_SESSION['loggedIn']) && isset($_SESSION['username'])){
			if($_SESSION['loggedIn'] == true){
				if($this->players->get_player_admin($_SESSION['username'])){

					//getting posted data from HTML form
					$team = $this->input->post('team', TRUE);
					$name = $this->input->post('name', TRUE);
					$password = $this->input->post('password', TRUE);

					//setting up the POST request to the server
					$url = 'http://botcards.jlparry.com/register';
					$data = array('team' => $team, 'name' => $name, 'password' => $password);

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

					//loading the xml
					$xml = simplexml_load_string($result);

					//if there is an error XML node:
					if(count($xml->message) > 0){
						$output = "<input type='submit' value='Register App'/><div class='button'>Error: ". $xml->message . "</div>";
					}
					//else if there is a team XML node:
					else if(count($xml->team) > 0){
						$output = "<div class='button'>Registered! Team: ". $xml->team . "</div>";

						$_SESSION['team'] = $xml->team->__toString();
						$_SESSION['token'] = $xml->token->__toString();
					}
					else{
						$output = "<input type='submit' value='Register App'/><div class='button'>Error: Unhandled return data!</div>";
					}

					$players = $this->players->all();
					$rows = "";
					foreach($players as $player){
						$playerData["player"] = $player["player"];
						$playerData["admin"] = "<form action='/Admin/Adminify/". $player["player"] . "' method='POST'><input type='submit' value='Make Admin'/></form>";
						if($player['admin'] == 1){
							$playerData["admin"] = "<div>ADMIN</div>";
						}
						$rows .= $this->parser->parse('admin-row', (array) $playerData, true);
					}

					//Setting all the created data to their appropriate placeholders
					$this->data['registerButton'] = $output;
					$this->data['tableData'] = $rows;
				}
				else{
					$this->data['pagebody'] = 'error_403';
				}
			}
			else{
				$this->data['pagebody'] = 'error_403';
			}
		}
		else{
			$this->data['pagebody'] = 'error_403';
		}

	$this->Render();

	}

	public function Adminify($playerName){
		session_start();
		if(isset($_SESSION['loggedIn']) && isset($_SESSION['username'])){
			if($_SESSION['loggedIn'] == true){
				if($this->players->get_player_admin($_SESSION['username'])){
					$this->players->adminify_player($playerName);

				}
			}

		}
		session_write_close();
		$this->index();

	}

	public function Delete($playerName){
		session_start();
		if(isset($_SESSION['loggedIn']) && isset($_SESSION['username'])){
			if($_SESSION['loggedIn'] == true){
				if($this->players->get_player_admin($_SESSION['username'])){
					$this->players->delete_player($playerName);
				}
			}
		}
		session_write_close();
		$this->index();
	}
}
