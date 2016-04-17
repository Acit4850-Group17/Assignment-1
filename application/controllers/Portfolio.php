<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//NOTE that it extends application, not CI_CONTROLLER

class Portfolio extends Application {
	function __construct(){
		parent::__construct();
	}


	public function index($name)
	{

		$this->data['pagebody'] = 'portfolio'; //setting view to use
		$this->data['title'] = 'Portfolio'; //Changing nav bar to show page title

		$table1 = "";
		$collection = $this->collections->collection_by_player($name);
                $table2 = "";
                $transaction =  $this->transactions->transactions_by_player($name);

                if ($collection != "") {

                    foreach($collection as $row){
											$currentRow = "<div class='botpiece'>" .
																		"<img src='/assets/images/" . $row['piece'] . ".jpeg' alt='Bot piece'>" .
																		"<div class='botsubtitle'>" . $row['piece'] . "</div>" .
																		"</div>";


											$table1 .= $currentRow;
					}

                    $this->data['inventory_table'] = '<h3>Collection of Bots: </h3>' . $table1;
					if($transaction != ""){
	                    foreach($transaction as $row){
										  	switch ($row['trans']){
													case "sell":
														$currentVerb = "sold";
														break;
													case "buy":
														$currentVerb = "bought";
														break;
													default:
														$currentVerb = "DEFAULT";
												}
							$table2 .= '<div>' . $row['player'] . ' ' . $currentVerb . ' a series ' . $row['series'] . ' at ' . $row['datetime'] . '<br></div>';
	                    }
					}

                    $this->data['activity_feed'] = '<h3>Activity Feed: </h3>' . $table2;


                } else {
                    $string = ('This person does not exist within the game.');
                    $this->data['inventory_table'] = $string;
                    $this->data['activity_feed'] = "No Activity";

                }
			$allPlayers = $this->players->all();
			$otherPlayers = "<h3>Other Players</h3><select id='selectPortfolio'>";
			foreach ($allPlayers as $row){
				$otherPlayers .= "<option value='". $row['player'] ."'>". $row['player'] . "</option>";
			}
			$otherPlayers .= "</select>";
			$this->data['other_players'] = $otherPlayers;

			$this->Render();
	}

}
