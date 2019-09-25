<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('Kelas_model');
	}

	public function index()
	{
		$this->template->load('app','admin/index');
	}

	public function dashboard()
	{
		$sekolah_id = user()->sekolah_id;


		// $data['t10'] = $this->Kelas_model->get_by_kolom_sekolah($sekolah_id, 'tingkat', 10)->result();
		// $data['t11'] = $this->Kelas_model->get_by_kolom_sekolah($sekolah_id, 'tingkat', 11)->result();
		// $data['t12'] = $this->Kelas_model->get_by_kolom_sekolah($sekolah_id, 'tingkat', 12)->result();

		$date = date('N', time());
		$this->db->group_by('seling_id');
		$data['data'] = $this->db->get_where('jadwal',['sekolah_id' => $sekolah_id, 'hari_id' => $date])->result();
		$this->template->load('app','admin/dashboard',$data);

		// $date = date('N', time());
		// $try = $this->db->get_where('jadwal',['sekolah_id' => $sekolah_id, 'hari_id' => $date])->result();

		// foreach($try as $t) {
		// 	$apa['seling'] = $this->db->get_where('seling',['id' => $t->seling_id])->row();
		// 	$apa['kelas'] = $this->db->get_where('kelas',['id' => $t->kelas_id])->row();
		// }
		// // $try  = $this->db->get_where('seling',['dari' => $date])->result();

		// echo json_encode($apa);

		// $this->db->where('dari <', $date);
		// $try = $this->db->get('seling')->result();

		// var_dump($try);
		


		 // $now = new DateTime();
   //  $startdate = new DateTime("2014-11-20");
   //  $enddate = new DateTime("2020-01-20");

   //  if($startdate <= $now && $now <= $enddate) {
   //      echo "Yes";
   //  }else{
   //      echo "No";
   //  }
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

			$this->db->update('lapor',$data,['id' => $lapor_id]);
			redirect('dashboard');
		}
		else {
			$date = date('Y-m-d', time());
			$data = [
				'sekolah_id'	=> user()->sekolah_id,
				'tanggal'		=> $date,
				'jadwal_id'		=> $this->input->post('jadwal_id'),
				'status'		=> $this->input->post('status'),
				'keterangan' => $this->input->post('keterangan')
			];

			$this->db->insert('lapor',$data);
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
		$res['jadwal_id'] = $jadwal_id;
		echo json_encode($res);

	}


}