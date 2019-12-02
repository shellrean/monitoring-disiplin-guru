<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();

		is_login();
		$this->load->model('User_model');
		$this->load->model('Sekolah_model');
		$this->load->library('form_validation');
		$this->load->library('Ssp');
	}

	public function index()
	{
		$breadcrumb = array(
			'<li class="breadcrumb-item">Data master</li>',
			'<li class="breadcrumb-item active">Data user</li>'
		);
		$this->template->set('breadcrumb',$breadcrumb);
		$data['sekolah'] = $this->Sekolah_model->get_all()->result();
		$this->template->load('app','user/index',$data);
	}
	public function store() 
	{
		if($this->form_validation->run('user')) {
			$data = [
				'username'		=> $this->input->post('username'),
				'password'		=> password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'name'			=> $this->input->post('name'),
				'role_id'		=> $this->input->post('role_id'),
				'is_active'		=> $this->input->post('is_active'),
				'slug'			=> uniqid(),
				'sekolah_id'	=> $this->input->post('sekolah_id')
			];
			$this->User_model->save($data);
			$status['status'] = 1;
			$status['pesan'] = 'Data user berhasil disimpan';
		} else {
			$status['status'] = 0;
            $status['pesan'] = validation_errors();
		}
       
        
        echo json_encode($status);
	}
	/**
	 * Show the selected row
	 *
	 * @method get ajax_request
	 * @param integer $id
	 * @return json
	 */
	public function show($id=null) 
	{
 		$data['data'] = 0;

 		if(!empty($id)) {
 			$query = $this->User_model->get_by_kolom('id',$id);
 			if($query->num_rows() > 0) {
 				$query = $query->row();
 				$data = [
 					'data'	=> 1,
 					'id'	=> $query->id,
 					'sekolah_id'	=> $query->sekolah_id,
 					'username'	=> $query->username,
 					'name'	=> $query->name,
 					'is_active' => $query->is_active,
 					'role_id'	=> $query->role_id
 				];
 			}
 		}

 		echo json_encode($data);
	}


	public function data()
	{
		$table 			= 'user';
		$primaryKey		= 'id';
		$columns		= array(
			array( 'db' => 'id', 'dt' => 'id'),
			array( 'db' => 'username', 'dt' => 'username'),
			array( 'db' => 'name', 'dt' => 'name'),
			array( 
				'db' => 'is_active', 
				'dt' => 'status',
				'formatter' => function($d) {
					return status($d);
				}
			),
			array(
				'db' => 'role_id',
				'dt' => 'role',
				'formatter' => function($d) {
					if($d == 2) {
						$res = '<span class="badge badge-success">Piket</span>';
					}
					elseif($d == 3) {
						$res = '<span class="badge badge-primary">Kepsek</span>';
					}
					return $res;
				}	
			),
			array( 
				'db' => 'sekolah_id', 
				'dt' => 'sekolah',
				'formatter' => function($d) {
					return sekolah($d);
				}
			),
			array(
				'db'=> 'id',
				'dt' => 'aksi',
				'formatter' => function($d) {
					return '<button type="button" onclick="edit(\''.$d.'\')" class="btn btn-success btn-sm">Edit</button>';
				}
			),
			array(
				'db' =>'id',
				'dt'  => 'check',
				'formatter' => function ($d) {
					return '<input type="checkbox" name="edit-data-id['.$d.']" >';
				}
			)
		);

		$sql_details = array(
			'user'	=> $this->db->username,
			'pass'	=> $this->db->password,
			'db'	=> $this->db->database,
			'host'	=> $this->db->hostname
		);
		
		$where = "role_id != '1'";
		echo json_encode(
			SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,$where)
		);

	}

	/**
	 * Update data
	 *
	 * @method post
	 * @access public
	 * @return json
	 */
	public function update()
	{
		if($this->form_validation->run('user/edit')) {
			$data = [
				'sekolah_id'		=> $this->input->post('sekolah_id'),
				'username'			=> $this->input->post('username'),
				'name'				=> $this->input->post('name'),
				'is_active'			=> $this->input->post('is_active'),
				'role_id'			=> $this->input->post('role_id'),
			];
			$id = $this->input->post('id');
			$this->User_model->update('id',$id,$data);
			$respond['status'] 	= 1;
			$respond['pesan']	= 'Data user berhasil ubah';
		}
		else {
			$respond['status']	= 0;
			$respond['pesan']	= validation_errors();
		}

		echo json_encode($respond);
	}

	public function profile()
	{
		/** @set bredcrumb **/
		$this->breadcrumb = array(
			'<li class="breadcrumb-item active">Profile</li>',
		);
		$this->template->set('breadcrumb',$this->breadcrumb);	
		$this->template->load('app','user/profile');
	}

	public function update_profile()
	{
		$data = [
			'username' => $this->input->post('username'),
			'name'		=> $this->input->post('name')
		];
		$password = $this->input->post('password');

		if($password != null || $password !='') {
			$data['password'] = password_hash($password, PASSWORD_DEFAULT);
		}

		$id = user()->id;
		$this->User_model->update('id',$id,$data);
		$respond['status'] 	= 1;
		$respond['pesan']	= 'Profile berhasil ubah';

		echo json_encode($respond);
	}

	public function destroy()
	{
		$data_id = $this->input->post('edit-data-id', TRUE);
		$this->form_validation->set_rules('edit-data-id[]', 'Data','required|strip_tags');

		if($this->form_validation->run() == TRUE) {
			foreach($data_id as $kunci => $isi) {
				if($isi == "on" ) {
					$this->User_model->delete('id', $kunci);
				}
			}

			$respon['status'] = 1;
			$respon['pesan'] = 'Data user berhasil dihapus';
		} else {
			$respon['status'] = 0;
			$respon['pesan'] = validation_errors();
		}

		echo json_encode($respon);
	}

	public function log()
	{
		$this->template->load('app','user/log');
	}

	public function log_data()
	{
		$table 			= 'log_akses';
		$primaryKey		= 'id';
		$columns		= array(
			array( 'db' => 'id', 'dt' => 'id'),
			array( 'db' => 'created', 'dt' => 'waktu'),
			array( 'db' => 'status', 'dt' => 'status'),
			array(
				'db'=> 'code',
				'dt' => 'code',
				'formatter' => function($d) {
					if ($d == 1) {
						$des = "<span class='badge badge-success'>Success</span>";
					}
					elseif($d == 2) {
						$des = "<span class='badge badge-danger'>Error</span>";
					}
					return $des;
				}
			)
		);

		$sql_details = array(
			'user'	=> $this->db->username,
			'pass'	=> $this->db->password,
			'db'	=> $this->db->database,
			'host'	=> $this->db->hostname
		);
		
		$where = "user_id = ".user()->id;

		echo json_encode(
			SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,$where)
		);
	}
}