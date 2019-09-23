<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller
{
	/** @var breadcrumb **/
	private $breadcrumb;

	/**
	 * KelasController constructor
	 *
	 * @throws
	 */
	public function __construct()
	{
		parent::__construct();

		is_login();

		/** @load library **/
		$this->load->library('Ssp');
		$this->load->library('form_validation');

		/** @load model **/
		$this->load->model('Kelas_model');

		/** @set breadcrumb **/
		$this->breadcrumb = array(
			'<li class="breadcrumb-item">Administrative</li>',
			'<li class="breadcrumb-item active">Kelas</li>'
		);
		$this->template->set('breadcrumb',$this->breadcrumb);
	}

	/**
	 * Show our dashboard for kelas page
	 *
	 * @access public
	 */
	public function index()
	{
		$this->template->load('app','core/kelas');
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
		if($this->form_validation->run('kelas/tambah')) {

		}
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
		$table 			= 'kelas';
		$primaryKey		= 'id';
		$columns		= array(
			array( 'db' => 'id', 'dt' => 'id'),
			array( 'db' => 'nama', 'dt' => 'nama'),
			array( 'db' => 'tingkat', 'dt' => 'tingkat'),
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