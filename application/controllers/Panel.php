<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		is_login();
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