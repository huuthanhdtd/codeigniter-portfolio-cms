<?php

class Picasa extends Controller {

	function Picasa()
	{
		parent::Controller();
	}

	function index()
	{
		$data['title'] = "Google Picasa example";
		$data['tag'] = "dog";
		$this->load->view('picasa_v', $data);
	}
}