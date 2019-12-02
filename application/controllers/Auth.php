<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Admin_model');
		$this->load->library('form_validation');

		$this->load->library('user_agent');
	}
	public function index()
	{ 
		$this->_cek_login();
		if(!$this->form_validation->run('auth')) {

			$this->load->view('auth/login');
		} else {
			$this->_login();
		}

	}

	private function _login()
	{
		# validate user login
		$login = $this->Admin_model->login();
		
		# if the function teturn false
		if(!$login) {
			alerterror('message','Username/Password salah');
			redirect('auth');
		} else {
			if($login == 1) {
				redirect('panel');
			} 
			elseif($login == 2) {
				redirect('dashboard');
			}
			else {
				redirect('home');
			}
		}

	}

	public function logout()
	{
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('role_id');
		$this->session->unset_userdata('slug');
		$this->session->unset_userdata('user_unapp_identifer');
		alertsuccess('message','Logout berhasil');
		redirect('auth');
	}

	private function _cek_login()
	{
		$identifer = $this->session->has_userdata('user_unapp_identifer');
		$role = $this->session->userdata('role_id');

		if($identifer && $identifer != null) {
			  # check type role of the user
	          if ($role == 1) {

	            redirect('panel');
	            
	          } elseif($role == 2) {

	            redirect('dashboard');
	            
	          }
	          else {
	          	redirect('home');
	          }
		}
	}
}
