<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cctv extends CI_Controller 
{
	/** @var breadcrumb */
	private $breadcrumb;
 
	/**
     * GuruController constructor.
     *
     * @throws
     */
	public function __construct() 
	{
		parent::__construct(); 

		is_login();
		
		/** @load Library **/ 
		$this->load->library('Ssp');
		$this->load->library('form_validation');

		/** @load Model **/
		$this->load->model('Kelas_model');
		$this->load->model('Cctv_model');

		/** @set bredcrumb **/
		$this->breadcrumb = array(
			'<li class="breadcrumb-item">Administrative</li>',
			'<li class="breadcrumb-item active">Cctv</li>'
		);
		$this->template->set('breadcrumb',$this->breadcrumb);
	}

	/**
	 * Show our dashboard for guru page
	 *
	 * @access public
	 */
	public function index()
	{
		$data['kelas'] = $this->Kelas_model->get_by_sekolah(user()->sekolah_id)->result();
		$this->template->load('app','core/cctv',$data);
	}

	/** 
	 * Insert data into table
	 * 
	 * @method post
	 * @access public
	 * @return json
	 */
	public function store()
	{
		if($this->form_validation->run('cctv/tambah')) {
			$data = [
				'sekolah_id'		=> user()->sekolah_id,
				'nama_cctv'			=> $this->input->post('nama_cctv'),
				'username' 			=> $this->input->post('username'),
				'password'			=> $this->input->post('password'),
				'link_desktop'				=> $this->input->post('link_desktop'),
				'link_mobile'		=> $this->input->post('link_mobile'),
			];

			$this->Cctv_model->save($data);
			$respond['status'] 	= 1;
			$respond['pesan']	= 'Data cctv berhasil disimpan';
		}
		else {
			$respond['status']	= 0;
			$respond['pesan']	= validation_errors();
		}

		echo json_encode($respond);
	}

	/** 
	 * Insert data into table
	 * 
	 * @method post
	 * @access public
	 * @return json
	 */
	public function update()
	{
		if($this->form_validation->run('cctv/tambah')) {
			$data = [
				'nama_cctv'			=> $this->input->post('nama_cctv'),
				'username'			=> $this->input->post('username'),
				'password'			=> $this->input->post('password'),
				'link_desktop'		=> $this->input->post('link_desktop'),
				'link_mobile'				=> $this->input->post('link_mobile'),
			];
			$id = $this->input->post('id');
			$this->Cctv_model->update('id',$id,$data);
			$respond['status'] 	= 1;
			$respond['pesan']	= 'Data cctv berhasil diubah';
		}
		else {
			$respond['status']	= 0;
			$respond['pesan']	= validation_errors();
		}

		echo json_encode($respond);
	}

	/**
	 * Delete data from table
	 *
	 * @method post
	 * @access public
	 * @return json
	 */
	public function destroy()
	{
		$data_id = $this->input->post('edit-data-id', TRUE);
		$this->form_validation->set_rules('edit-data-id[]', 'Data','required|strip_tags');

		if($this->form_validation->run() == TRUE) {
			foreach($data_id as $kunci => $isi) {
				if($isi == "on" ) {
					$this->Cctv_model->delete('id', $kunci);
				}
			}

			$respon['status'] = 1;
			$respon['pesan'] = 'Data cctv berhasil dihapus';
		} else {
			$respon['status'] = 0;
			$respon['pesan'] = validation_errors();
		}

		echo json_encode($respon);
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
 			$query = $this->Cctv_model->get_by_kolom('id',$id);
 			if($query->num_rows() > 0) {
 				$query = $query->row();
 				$data = [
 					'data'		=> 1,
 					'id'		=> $query->id,
 					'nama_cctv'	=> $query->nama_cctv,
 					'username'	=> $query->username,
 					'password'	=> $query->password,
 					'link_desktop'	=> $query->link_desktop,
 					'link_mobile' => $query->link_mobile
 				];
 			}
 		}

 		echo json_encode($data);
	}

	/**
	 * Get datatable 
	 *
	 * @method get ajax_request
	 * @return json
	 */
	public function data()
	{
		$table 			= 'cctv';
		$primaryKey		= 'id';
		$columns		= array(
			array( 'db' => 'id', 'dt' => 'id'),
			array( 'db' => 'nama_cctv', 'dt' => 'nama_cctv'),
			array( 'db' => 'username', 'dt' => 'username'),
			array( 'db' => 'password', 'dt' => 'password'),
			array( 
				'db' => 'link_mobile',
				'dt' => 'link_mobile',
				'formatter' => function($d) {
					return '<a target="_blank" href="'.$d.'">Lihat</a>';
				}
			),
			array( 
				'db' => 'link_desktop',
				'dt' => 'link_desktop',
				'formatter' => function($d) {
					return '<a target="_blank" href="'.$d.'">Lihat</a>';
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
		
		$sekolah_id = user()->sekolah_id;
		$where = "sekolah_id = '$sekolah_id'";
		echo json_encode(
			SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where)
		);
	}

	public function pantau($sekolah_id)
	{
		$data['kelas'] = $this->Cctv_model->get_by_kolom('sekolah_id',$sekolah_id)->result();
		if(user()->role_id != 1) {
			if($sekolah_id != user()->sekolah_id) {
				echo 'Controller access is forbidden.';
			}
			else {
				$this->template->load('app','core/pantau_cctv', $data);
			}
		}
		else {
			$this->template->load('app','core/pantau_cctv',$data);
		}
	}

	public function list_pantau($sekolah_id)
	{
		if(user()->role_id != 1) {
			if($sekolah_id != user()->sekolah_id) {
				echo 'Controller access is forbidden.';
			}
			else {
				$table 			= 'cctv';
				$primaryKey		= 'id';
				$columns		= array(
					array( 'db' => 'id', 'dt' => 'id'),
					array(
						'db'=> 'kelas_id',
						'dt' => 'kelas',
						'formatter' => function($d) {
							return kelas($d);
						}
					),
					array(
						'db'=> 'link',
						'dt' => 'aksi',
						'formatter' => function($d) {
							return '<a href="'.$d.'"" class="btn btn-sm btn-success">Lihat</a>';
						}
					)
				);

				$sql_details = array(
					'user'	=> $this->db->username,
					'pass'	=> $this->db->password,
					'db'	=> $this->db->database,
					'host'	=> $this->db->hostname
				);
				
				$where = "sekolah_id = '$sekolah_id'";
				echo json_encode(
					SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where)
				);
			}
		}
		else {
			$table 			= 'cctv';
			$primaryKey		= 'id';
			$columns		= array(
				array( 'db' => 'id', 'dt' => 'id'),
				array(
					'db'=> 'kelas_id',
					'dt' => 'kelas',
					'formatter' => function($d) {
						return kelas($d);
					}
				),
				array(
					'db'=> 'link',
					'dt' => 'aksi',
					'formatter' => function($d) {
						return '<button data-link="'.$d.'"" class="btn btn-sm btn-success" onclick="show()">Lihat</button>';
					}
				)
			);

			$sql_details = array(
				'user'	=> $this->db->username,
				'pass'	=> $this->db->password,
				'db'	=> $this->db->database,
				'host'	=> $this->db->hostname
			);
				
			$where = "sekolah_id = '$sekolah_id'";
			echo json_encode(
				SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where)
			);
		}
	}

}