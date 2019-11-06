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
				'kelas_id'			=> $this->input->post('kelas_id'),
				'link'				=> $this->input->post('link'),
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
				'kelas_id'			=> $this->input->post('kelas_id'),
				'link'				=> $this->input->post('link'),
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
 					'kelas_id'	=> $query->kelas_id,
 					'link'		=> $query->link
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
			array( 'db' => 'link','dt' => 'link'),
			array(
				'db'=> 'kelas_id',
				'dt' => 'kelas',
				'formatter' => function($d) {
					return kelas($d);
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
				$this->template->load('app','core/pantau_cctv');
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