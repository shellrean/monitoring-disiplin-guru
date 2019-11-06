<?php

class Admin_model extends CI_Model 
{
	/**
	 * Cek the user login info
	 *
	 * @return boolean 
	 */
	public function login()
	{
		$browser = $this->agent->browser();
  		$browser_version = $this->agent->version();
	  	$os = $this->agent->platform();
  		$ip_address = $this->input->ip_address();

		$username = $this->input->post('username');
	    $password = $this->input->post('password');

	    $user = $this->db->get_where('user', ['username' => $username])->row();

	    if ($user) {
	      
	      # check is user active ?
	      if ($user->is_active == 1) {

	        # verify if user find
	        if (password_verify($password, $user->password)) {

	          # make identifer for session 
	          $identifer = uniqid(); 
	          
	          # set all session data and take it in array
	          $data = [
	            'username' => $user->username,
	            'role_id'  => $user->role_id,
	            'slug'     => $user->slug,
	            'user_unapp_identifer' => $identifer,
	            'flatform' => $os,
	          ];

	          log_akses($user->id, 'Login |'.$browser.' v'.$browser_version.'|'.$os.'|'.$ip_address, 1);

	          $this->session->set_userdata($data);

	          return $user->role_id;
	          
	        } else {
	          log_akses($user->id, 'Mencoba login |'.$browser.' v'.$browser_version.'|'.$os.'|'.$ip_address,2);
	          return false;
	        }
	      } else {
	      	log_akses($user->id, 'Mencoba login |'.$browser.' v'.$browser_version.'|'.$os.'|'.$ip_address,2);
	        return false;
	      }

	    } else {
	      return false;
	    }
	}
}