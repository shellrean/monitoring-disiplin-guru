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
		
		$this->load->library('Ssp');
		$this->load->library('form_validation');

		$this->load->model('Guru_model');


		$this->breadcrumb = array(
			'<li class="breadcrumb-item">Data master</li>',
			'<li class="breadcrumb-item active">Data guru</li>'
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
					return anchor('oke/oke','Edit','class="btn btn-success btn-sm"');
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

		echo json_encode(
			SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
		);
	}	

}