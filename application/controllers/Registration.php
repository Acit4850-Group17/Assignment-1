<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//NOTE that it extends application, not CI_CONTROLLER

class Registration extends Application {
	function __construct(){
		parent::__construct();
	}


	public function index()
	{

		$this->data['pagebody'] = 'Registration'; //setting view to use
		$this->data['title'] = 'Bot Card Collector'; //Changing nav bar to show page title
		$this->data["error"] = " ";

		$this->Render();
	}

	public function signup(){
		$username = $this->input->post('username', TRUE);
		$password = $this->input->post('password', TRUE);

		$config['upload_path'] = './assets/uploads/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '100';
		$config['max_width']  = '256';
		$config['max_height']  = '256';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload("avatar"))
		{

			$error = $this->upload->display_errors();
			$this->data['pagebody'] = 'Registration'; //setting view to use
			$this->data['title'] = 'Bot Card Collector'; //Changing nav bar to show page title
			$this->data["error"] = "<p>There was an error with the upload process</p>";
			$this->Render();
		}
		else
		{
			$data = $this->upload->data();
			$this->players->create_player($username, $password, "/assets/uploads/" . $data["file_name"]);
			redirect('/');
		}


	}

}
