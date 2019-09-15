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
	public function tambah()
	{
		if($this->form_validation->run('user')) {
			$data = [
				'username'		=> $this->input->post('username'),
				'password'		=> password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'name'			=> $this->input->post('name'),
				'role_id'		=> 2,
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
	public function get_datatable()
	{
		$search = "";
		$start = 0;
		$rows = 0;

		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}

		$start = $this->get_start();
		$rows = $this->get_rows();

		$query = $this->User_model->get_datatable($start, $rows, 'name', $search);
		$iFilteredTotal = $query->num_rows();
		
		$iTotal= $this->User_model->get_datatable_count('name', $search)->row()->hasil;

		$output = array(
			"sEcho" => intval($_GET['sEcho']),
	        "iTotalRecords" => $iTotal,
	        "iTotalDisplayRecords" => $iTotal,
	        "aaData" => array()
	    );

	    $i=$start;
		$query = $query->result();
	    foreach ($query as $temp) {			
			$record = array();
            
			$record[] = ++$i;
            $record[] = $temp->username;
            $record[] = $temp->name;
            $record[] = $temp->is_active;
            $record[] = $temp->sekolah_id;

            $record[] = '<button type="button" onclick="edit(\''.$temp->id.'\')" class="btn btn-success btn-sm">Edit</button>';
            $record[] = '<input type="checkbox" name="edit-data-id['.$temp->id.']" >';

			$output['aaData'][] = $record;
		}

		echo json_encode($output);

	}

	public function get_start() {
		$start = 0;
		if (isset($_GET['iDisplayStart'])) {
			$start = intval($_GET['iDisplayStart']);

			if ($start < 0)
				$start = 0;
		}

		return $start;
	}

	public function get_rows() {
		$rows = 10;
		if (isset($_GET['iDisplayLength'])) {
			$rows = intval($_GET['iDisplayLength']);
			if ($rows < 5 || $rows > 500) {
				$rows = 10;
			}
		}

		return $rows;
	}


}