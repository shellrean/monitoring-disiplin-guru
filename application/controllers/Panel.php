<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		is_login();

		/** @load Library **/
		$this->load->library('Ssp');
		$this->load->library('form_validation');


		$this->load->model('Jadwal_model');
		$this->load->model('Lapor_model');
	}

	public function index()
	{
		$this->template->load('app','admin/index');
	}

	public function dashboard()
	{

		$sekolah_id = user()->sekolah_id;

		$day = date('N', time());
		
		$this->db->group_by('seling_id');
		$data = $this->Jadwal_model->get_by_day($sekolah_id, $day)->result();
		
		$data['data'] = $data;

		
		$this->template->load('app','admin/dashboard',$data);

	}

	public function store()
	{
		$lapor_id = $this->input->post('lapor_id');

		if($lapor_id !== "0") {
			$date = date('Y-m-d', time());
			$data = [
				'status'		=> $this->input->post('status'),
				'keterangan' => $this->input->post('keterangan')
			];

			alertsuccess('message','Berhasil mengubah data');
			$this->db->update('lapor',$data,['id' => $lapor_id]);
			redirect('dashboard');
		}
		elseif ($lapor_id == "0") {
			$date = date('Y-m-d', time());
			$data = [
				'sekolah_id'	=> user()->sekolah_id,
				'tanggal'		=> $date,
				'jadwal_id'		=> $this->input->post('jadwal_id'), 
				'status'		=> $this->input->post('status'),
				'keterangan' => $this->input->post('keterangan')
			];

			alertsuccess('message','Berhasil menyimpan data');
			$this->db->insert('lapor',$data);
			redirect('dashboard');
		}
		else {
			alerterror('message','Error');
			redirect('dashboard');
		}
		
	}

	public function get()
	{
		$date = date('Y-m-d', time());
		$jadwal_id = $this->input->post('jadwal_id');

		$cek = $this->db->get_where('lapor',['sekolah_id' => user()->sekolah_id, 'tanggal' => $date, 'jadwal_id' => $jadwal_id])->row();

		if($cek) {
			$res['status']	= $cek->status;
			$res['keterangan'] = $cek->keterangan;
			$res['lapor_id'] = $cek->id;
		}

		else {
			$res['status']= 0;
			$res['keterangan'] = ' ';
			$res['lapor_id'] = 0;
		}
		echo json_encode($res);

	}

	public function data()
	{
		$table 			= 'lapor';
		$primaryKey		= 'id';
		$columns		= array(
			array( 'db' => 'id', 'dt' => 'id'),
			array( 
				'db' => 'sekolah_id', 
				'dt' => 'sekolah',
				'formatter' => function($d) {
					return sekolah($d);
				}
			),
			array( 
				'db' => 'jadwal_id', 
				'dt' => 'jadwal',
				'formatter' => function($d) {
					$dat = $this->db->get_where('jadwal',['id' => $d])->row();
					if (is_object($dat)) {
						$res = '<span class="badge badge-success mx-1">'.seling($dat->seling_id,'dari').'</span><span class="badge badge-danger">'.seling($dat->seling_id,'sampai').'</span>';
					}
					else {
						$res = '<span class="badge badge-success mx-1">deleted</span><span class="badge badge-danger">deleted</span>';
					}
					return $res;
					
				}
			),
			array( 
				'db' => 'status', 
				'dt' => 'status',
				'formatter' => function($d) {
					if($d == '0') {
						$red = '<i class="icon-close text-danger"></i>';
					} 
					elseif($d == '2') {
						$red = '<i class="icon-clock text-warning"></i>';
					}
					elseif($d == '3') {
						$red = '<i class="icon-close text-info"></i>';
					}
					elseif($d == '4') {
						$red = '<i class="icon-close text-warning"></i>';
					}
					elseif($d == '5') {
						$red = '<i class="icon-close text-success"></i>';
					}
					else {
						$red = '<i class="icon-check text-success"></i>';
					}
					return $red;
				}
			),
			array( 'db' => 'keterangan','dt' => 'keterangan'),
			array( 
				'db' => 'jadwal_id', 
				'dt' => 'kelas',
				'formatter' => function($d) {
					$dat = $this->db->get_where('jadwal',['id' => $d])->row();
					if (is_object($dat)) {
						$res  =  kelas($dat->kelas_id);
					}
					else {
						$res = 'deleted';

					}
					return $res;
				}
			),
			array( 
				'db' => 'jadwal_id', 
				'dt' => 'guru',
				'formatter' => function($d) {
					$dat = $this->db->get_where('jadwal',['id' => $d])->row();
					if (is_object($dat)) {
						$res = guru($dat->guru_id);
					}
					else {
						$res = "deled";
					}
					return $res;
				}
			)
		);

		$sql_details = array(
			'user'	=> $this->db->username,
			'pass'	=> $this->db->password,
			'db'	=> $this->db->database,
			'host'	=> $this->db->hostname
		);
		$date = date('Y-m-d', time());
		$where = "tanggal = '$date'";
		echo json_encode( 
			SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where)
		); 
	}

	public function data_kepsek()
	{
		$table 			= 'lapor';
		$primaryKey		= 'id';
		$columns		= array(
			array( 'db' => 'id', 'dt' => 'id'),
			array( 
				'db' => 'jadwal_id', 
				'dt' => 'jadwal',
				'formatter' => function($d) {
					$dat = $this->db->get_where('jadwal',['id' => $d])->row();
					if (is_object($dat)) {
						$res = '<span class="badge badge-success mx-1">'.seling($dat->seling_id,'dari').'</span><span class="badge badge-danger">'.seling($dat->seling_id,'sampai').'</span>';
					}
					else {
						$res = '<span class="badge badge-success mx-1">deleted</span><span class="badge badge-danger">deleted</span>';
					}
					return $res;
					
				}
			),
			array( 
				'db' => 'status', 
				'dt' => 'status',
				'formatter' => function($d) {
					if($d == '0') {
						$red = '<i class="icon-close text-danger"></i>';
					} 
					elseif($d == '2') {
						$red = '<i class="icon-clock text-warning"></i>';
					}
					elseif($d == '3') {
						$red = '<i class="icon-close text-info"></i>';
					}
					elseif($d == '4') {
						$red = '<i class="icon-close text-warning"></i>';
					}
					elseif($d == '5') {
						$red = '<i class="icon-close text-success"></i>';
					}
					else {
						$red = '<i class="icon-check text-success"></i>';
					}
					return $red;
				}
			),
			array( 'db' => 'keterangan','dt' => 'keterangan'),
			array( 
				'db' => 'jadwal_id', 
				'dt' => 'kelas',
				'formatter' => function($d) {
					$dat = $this->db->get_where('jadwal',['id' => $d])->row();
					if (is_object($dat)) {
						$res  =  kelas($dat->kelas_id);
					}
					else {
						$res = 'deleted';

					}
					return $res;
				}
			),
			array( 
				'db' => 'jadwal_id', 
				'dt' => 'guru',
				'formatter' => function($d) {
					$dat = $this->db->get_where('jadwal',['id' => $d])->row();
					if (is_object($dat)) {
						$res = guru($dat->guru_id);
					}
					else {
						$res = "deled";
					}
					return $res;
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
		$date = date('Y-m-d', time());
		$where = "tanggal = '$date' AND sekolah_id = '$sekolah_id'";
		echo json_encode( 
			SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where)
		);
	}

	public function guru()
	{
		$this->template->load('app','admin/guru');
	}

	public function data_guru()
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
					return '<a href="'.base_url('guru/guru_sekolah/'.$d).'" class="btn btn-success btn-sm">Lihat daftar guru</a>';
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

	public function home()
	{
		$this->template->load('app','admin/home');
	}
}