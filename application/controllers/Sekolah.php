<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sekolah extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();

		is_login();
		$this->load->model('Sekolah_model');
		$this->load->library('form_validation');
		$this->load->library('Ssp');
	}

	public function index()
	{
		$breadcrumb = array(
			'<li class="breadcrumb-item">Data master</li>',
			'<li class="breadcrumb-item active">Data sekolah</li>'
		);
		$this->template->set('breadcrumb',$breadcrumb);
		$this->template->load('app','sekolah/index');
	}

	public function store()
	{
		if($this->form_validation->run('sekolah/tambah')) {
			$data = [
				'nama_sekolah'		=> $this->input->post('nama_sekolah'),
				'alamat_sekolah'	=> $this->input->post('alamat_sekolah')
			];
			$this->Sekolah_model->save($data);
			$status['status'] = 1;
			$status['pesan'] = 'Data sekolah berhasil disimpan';
		} else {
			$status['status'] = 0;
            $status['pesan'] = validation_errors();
		}
       
        
        echo json_encode($status);
	}
	public function update()
	{
		if($this->form_validation->run('sekolah/tambah')) {
			$data = [
				'nama_sekolah'		=> $this->input->post('nama_sekolah'),
				'alamat_sekolah'	=> $this->input->post('alamat_sekolah')
			];
			$id = $this->input->post('id');
			$this->Sekolah_model->update('id',$id,$data);
			$status['status'] = 1;
			$status['pesan'] = 'Data sekolah berhasil diubah';
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
		$rows = 10;
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$search = $_GET['sSearch'];
		}

		$start = $this->get_start();
		$rows = $this->get_rows();

		$query = $this->Sekolah_model->get_datatable($start, $rows, 'nama_sekolah', $search);
		$iFilteredTotal = $query->num_rows();
		
		$iTotal= $this->Sekolah_model->get_datatable_count('nama_sekolah', $search)->row()->hasil;

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
            $record[] = $temp->nama_sekolah;
            $record[] = $temp->alamat_sekolah;

            $record[] = '<button type="button" onclick="edit(\''.$temp->id.'\')" class="btn btn-success btn-sm">Edit</button>';
            $record[] = '<input type="checkbox" name="edit-data-id['.$temp->id.']" >';

			$output['aaData'][] = $record;
		}

		echo json_encode($output);
	}

	public function destroy()
	{
		$data_id = $this->input->post('edit-data-id', TRUE);
		$this->form_validation->set_rules('edit-data-id[]', 'Data','required|strip_tags');
		if($this->form_validation->run() == TRUE){
		foreach($data_id as $kunci => $isi) {
			if($isi == "on") {
				$this->Sekolah_model->delete('id',$kunci);
			}
		}

		$status['status'] = 1;
            $status['pesan'] = 'Data sekolah berhasil dihapus';
		}else{
			$status['status'] = 0;
            $status['pesan'] = validation_errors();
        }
         echo json_encode($status);   
	}

	public function show($id=null) {
		$data['data'] = 0;

		if(!empty($id)) {
			$query = $this->Sekolah_model->get_by_kolom('id',$id);
			if($query->num_rows() > 0) {
				$query = $query->row();
				$data['data' ]  = 1;
				$data['id']	= $query->id;
				$data['nama_sekolah'] = $query->nama_sekolah;
				$data['alamat_sekolah'] = $query->alamat_sekolah;
			}
		}

		echo json_encode($data);
	}

	public function edit()
	{
		if($this->form_validation->run('sekolah/tambah')) {
			$data = [
				'nama_sekolah' 		=> $this->input->post('nama_sekolah'),
				'alamat_sekolah'	=> $this->input->post('alamat_sekolah'),
			];

			$id = $this->input->post('id');

			$this->Sekolah_model->update('id', $id, $data);

			$status['status'] = 1;
			$status['pesan'] = 'Data sekolah berhasil diubah';
		} else {
			$status['status'] = 0;
			$status['pesan'] = validation_errors();
		}

		echo json_encode($status);
	}

	function get_start() {
		$start = 0;
		if (isset($_GET['iDisplayStart'])) {
			$start = intval($_GET['iDisplayStart']);

			if ($start < 0)
				$start = 0;
		}

		return $start;
	}

	function get_rows() {
		$rows = 10;
		if (isset($_GET['iDisplayLength'])) {
			$rows = intval($_GET['iDisplayLength']);
			if ($rows < 5 || $rows > 500) {
				$rows = 10;
			}
		}

		return $rows;
	}


	public function cctv()
	{
		$this->template->load('app','core/cctv_sekolah');
	}

	public function cctv_data() 
	{
		$table 			= 'sekolah';
		$primaryKey		= 'id';
		$columns		= array(
			array( 'db' => 'id', 'dt' => 'id'),
			array( 'db' => 'nama_sekolah', 'dt' => 'sekolah'),
			array(
				'db'=> 'id',
				'dt' => 'aksi',
				'formatter' => function($d) {
					return '<a href="'.base_url('cctv/pantau/').$d.'"" class="btn btn-sm btn-success">Pantau</a>';
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