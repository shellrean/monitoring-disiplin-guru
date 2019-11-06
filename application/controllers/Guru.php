<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends CI_Controller 
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
		$this->load->model('Guru_model');

		/** @set bredcrumb **/
		$this->breadcrumb = array(
			'<li class="breadcrumb-item">Administrative</li>',
			'<li class="breadcrumb-item active">Guru</li>'
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
		$this->template->load('app','core/guru');
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
		if($this->form_validation->run('guru/tambah')) {
			$data = [
				'id_sekolah'		=> user()->sekolah_id,
				'nip'				=> $this->input->post('nip'),
				'nama'				=> $this->input->post('nama'),
			];

			$this->Guru_model->save($data);
			$respond['status'] 	= 1;
			$respond['pesan']	= 'Data guru berhasil disimpan';
		}
		else {
			$respond['status']	= 0;
			$respond['pesan']	= validation_errors();
		}

		echo json_encode($respond);
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
		if($this->form_validation->run('guru/tambah')) {
			$data = [
				'nip'				=> $this->input->post('nip'),
				'nama'				=> $this->input->post('nama'),
			];
			$id = $this->input->post('id');
			$this->Guru_model->update('id',$id,$data);
			$respond['status'] 	= 1;
			$respond['pesan']	= 'Data guru berhasil ubah';
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
					$this->Guru_model->delete('id', $kunci);
				}
			}

			$respon['status'] = 1;
			$respon['pesan'] = 'Data guru berhasil dihapus';
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
 			$query = $this->Guru_model->get_by_kolom('id',$id);
 			if($query->num_rows() > 0) {
 				$query = $query->row();
 				$data = [
 					'data'	=> 1,
 					'id'	=> $query->id,
 					'nip'	=> $query->nip,
 					'nama'	=> $query->nama
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
		$table 			= 'guru';
		$primaryKey		= 'id';
		$columns		= array(
			array( 'db' => 'id', 'dt' => 'id'),
			array( 'db' => 'nama', 'dt' => 'nama'),
			array( 'db' => 'nip', 'dt' => 'nip'),
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
		$where = "id_sekolah = '$sekolah_id'";
		echo json_encode(
			SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where)
		);
	}	
	/**
	 * Get datatable 
	 *
	 * @method get $id_sekolah
	 * @return view
	 */

	public function guru_sekolah($id_sekolah)
	{
		$data['id_sekolah'] = $id_sekolah;
		$this->template->load('app','core/guru_list',$data);
	}
	/**
	 * Get datatable 
	 *
	 * @method get ajax_request
	 * @return view
	 */
	public function list($id_sekolah)
	{
		$table 			= 'guru';
		$primaryKey		= 'id';
		$columns		= array(
			array( 'db' => 'id', 'dt' => 'id'),
			array(
				'db'=> 'nip',
				'dt' => 'nip'
			),
			array(
				'db'=> 'nama',
				'dt' => 'nama'
			)
		);

		$sql_details = array(
			'user'	=> $this->db->username,
			'pass'	=> $this->db->password,
			'db'	=> $this->db->database,
			'host'	=> $this->db->hostname
		);
				
		$where = "id_sekolah = '$id_sekolah'";
		echo json_encode(
			SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where)
		);
	}

}