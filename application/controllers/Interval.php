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
			'<li class="breadcrumb-item active">Interval</li>'
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
		$data['datas'] = $this->Interval_model->get_interval(user()->sekolah_id)->result();
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
				'dari'				=> $this->input->post('dari'),
				'sampai'			=> $this->input->post('sampai')
			];

			$this->Interval_model->save($data);

			redirect('interval');
		}
		
	}

	/**
	 * Insert data into table
	 *
	 * @method post
	 * @access public
	 * @return boolean
	 */
	public function update()
	{
		if($this->form_validation->run('interval/tambah')) {
			$data = [
				'dari'				=> $this->input->post('dari'),
				'sampai'			=> $this->input->post('sampai')
			];

			$id = $this->input->post('id');
			$this->Interval_model->update('id',$id,$data);

			redirect('interval');
		}
		else {
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
	public function destroy($id = null)
	{	
		$this->Interval_model->delete('id',$id);
		redirect('interval');
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
		$data['data'] = 0;

 		if(!empty($id)) {
 			$query = $this->Interval_model->get_by_kolom('id',$id);
 			if($query->num_rows() > 0) {
 				$query = $query->row();
 				$data = [
 					'data'	=> 1,
 					'id'	=> $query->id,
 					'dari'	=> $query->dari,
 					'sampai'	=> $query->sampai
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
		
	}
}