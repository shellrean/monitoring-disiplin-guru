<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller 
{

	public function index()
	{
		$this->template->load('app','admin/index');
	}

	public function dashboard()
	{
		$this->template->load('app','admin/dashboard');
	}

}