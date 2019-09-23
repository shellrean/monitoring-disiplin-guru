<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends CI_Controller 
{
	/** @var breadcrumb */
	private $breadcrumb;

	/**
     * JadwalController constructor.
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
		$this->load->model('Jadwal_model');
		$this->load->model('Guru_model');
		$this->load->model('Interval_model');
		$this->load->model('Kelas_model');

		/** @set bredcrumb **/
		$this->breadcrumb = array(
			'<li class="breadcrumb-item active">Jadwal</li>'
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
		$data['guru'] = $this->Guru_model->get_all(user()->sekolah_id)->result();

		$this->template->load('app','core/jadwal',$data);
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
		if($this->form_validation->run('jadwal/tambah')) {
			$data = [
				'sekolah_id'		=> user()->sekolah_id,
				'hari_id'			=> $this->input->post('hari_id'),
				'seling_id'			=> $this->input->post('seling_id'),
				'kelas_id'			=> $this->input->post('kelas_id'),
				'guru_id'			=> $this->input->post('guru_id')
			];

			$this->Jadwal_model->save($data);
			$respond['status'] 	= 1;
			$respond['pesan']	= 'Jadwal berhasil ditambahkan';
		}
		else {
			$respond['status'] = 0;
			$respond['pesan'] = validation_errors();
		}

		echo json_encode($respond);
	}

	/**
	 * Show edit page
	 *
	 * @access public
	 */
	public function edit($id)
	{
		$guru = $this->Guru_model->get_by_id($id)->row();
		$data['hari'] = $this->Interval_model->get_all()->result();
		$data['jadwal'] = $this->Jadwal_model->get_by_guru($id)->result();
		$data['interval'] = $this->Interval_model->get_interval(user()->sekolah_id)->result();
		$data['kelas'] = $this->Kelas_model->get_by_sekolah(user()->sekolah_id)->result();

		$data['guru'] = $guru;

		$this->template->load('app','core/jadwal_edit',$data);
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
					$this->Jadwal_model->delete('id', $kunci);
				}
			}

			$respon['status'] = 1;
			$respon['pesan'] = 'Jadwal berhasil dihapus';
		} else {
			$respon['status'] = 0;
			$respon['pesan'] = validation_errors();
		}

		echo json_encode($respon);
	}

	/**
	 * Datatable
	 *
	 * @access public
	 */
	public function data($id_guru)
	{
		$table 			= 'jadwal';
		$primaryKey		= 'id'; 
		$columns		= array(
			array( 'db' => 'id', 'dt' => 0),
			array( 
				'db' => 'hari_id', 
				'dt' => 1,
				'formatter' => function($d) {
					return hari($d);
				}
			),
			array( 
				'db' => 'seling_id', 
				'dt' => 2,
				'formatter' => function($d) {
					return '<span class="badge badge-success">'.seling($d,'dari').'</span>
					<span class="badge badge-danger">'.seling($d,'sampai').'</span>';
				}
			),
			array( 
				'db' => 'kelas_id', 
				'dt' => 3,
				'formatter' => function($d) {
					return kelas($d);
				}
			),
			array(
				'db'=> 'id',
				'dt' => 4,
				'formatter' => function($d) {
					return anchor('oke/oke','Edit','class="btn btn-success btn-sm"');
				}
			),
			array(
				'db' =>'id',
				'dt'  => 5,
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
		
		$where = "guru_id = '$id_guru'";

		echo json_encode(
			SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where)
		);
	}
}