<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Interval extends CI_Controller
{
	/** @var breadcrumb **/
	private $breadcrumb;

	/**
	 * JadwalController constructor
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
		$this->load->model('Interval_model');

		/** @set bredcrumb **/
		$this->breadcrumb = array(
			'<li class="breadcrumb-item">Administrative</li>',
			'<li class="breadcrumb-item active">Jadwal</li>'
		);
		$this->template->set('breadcrumb', $this->breadcrumb);
	}

	/**
	 * Show our dashboard for jadwal page
	 * 
	 * @access public
	 */
	public function index()
	{
		$data['datas'] = $this->db->get('hari')->result();
		$this->template->load('app','core/interval',$data);
	}

	/**
	 * Insert data into table
	 *
	 * @method post
	 * @access public
	 * @return boolean
	 */
	public function store()
	{
		if($this->form_validation->run('interval/tambah')) {
			$data = [
				'sekolah_id'		=> user()->sekolah_id,
				'hari_id'			=> $this->input->post('hari_id'),
				'dari'				=> $this->input->post('dari'),
				'sampai'			=> $this->input->post('sampai')
			];

			$this->Interval_model->save($data);

			redirect('interval');
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
	public function show($id = null) 
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
		
	}
}