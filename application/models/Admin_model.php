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
	          ];
	          $this->session->set_userdata($data);

	          return $user->role_id;
	          
	        } else {
	          return false;
	        }
	      } else {
	        return false;
	      }

	    } else {
	      return false;
	    }
	}
}