
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analisa extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('Sekolah_model');

		$this->load->library('Ssp');
	}
	
	public function index()
	{
		$this->template->load('app','core/analisa');
	}

	public function data()
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
					return '<a href="'.base_url('analisa/harian/'.$d).'" class="btn btn-success btn-sm" target="_blank">Report hari ini</a>'.
						'<button onclick="periode(\''.$d.'\')" class="btn btn-primary btn-sm mx-1" target="_blank">Report periode</button>';
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

	public function harian($id)
	{
		$m_pdf = new \Mpdf\Mpdf();
		$date = date('Y-m-d', time());

		$data['qry'] = $this->db->get_where('lapor',['tanggal' => $date,'sekolah_id' => $id])->result();

		// echo json_encode($data['qry']);
		$data['date'] = $date;
		$data['sekolah'] = $this->Sekolah_model->get_by_kolom('id',$id)->row();
		$pdfFilePath = 'Report_'.$date.'.pdf';

		$wm = base_url() . 'public/img/logo-dki.png';
		$m_pdf->SetWatermarkImage($wm);
		$m_pdf->showWatermarkImage = true;
		$m_pdf->SetHTMLFooter('<b style="font-size:8px;"><i>Report '.todate($date).'<i></b>');
		$m_pdf->AddPage('L');
		$r_header = $this->load->view('cetak/r_header',$data,true);
		$m_pdf->WriteHTML($r_header);

		$r_main = $this->load->view('cetak/r_main',$data,true);
		$m_pdf->WriteHTML($r_main);

		$r_footer=$this->load->view('cetak/r_footer', $data, true);
    	$m_pdf->WriteHTML($r_footer);
    	$m_pdf->Output($pdfFilePath,'I'); 
	}

	public function periode($id,$dari,$sampai)
	{
		$m_pdf = new \Mpdf\Mpdf();
		$date = date('Y-m-d', time());
		$data['dari'] = $dari;
		$data['sampai'] = $sampai;

		$this->db->where('tanggal >=', $dari);
		$this->db->where('tanggal <=', $sampai);
		$this->db->where('sekolah_id',$id);

		$data['qry'] = $this->db->get('lapor')->result();

		$data['date'] = $date;
		$data['sekolah'] = $this->Sekolah_model->get_by_kolom('id',$id)->row();
		$pdfFilePath = 'Report_'.$date.'.pdf';

		$wm = base_url() . 'public/img/logo-dki.png';
		$m_pdf->SetWatermarkImage($wm);
		$m_pdf->showWatermarkImage = true;
		$m_pdf->SetHTMLFooter('<b style="font-size:8px;"><i>Report '.todate($date).'<i></b>');
		$m_pdf->AddPage('L');
		$r_header = $this->load->view('cetak/r_header',$data,true);
		$m_pdf->WriteHTML($r_header);

		$r_main = $this->load->view('cetak/r_main_periode',$data,true);
		$m_pdf->WriteHTML($r_main);

		$r_footer=$this->load->view('cetak/r_footer', $data, true);
    	$m_pdf->WriteHTML($r_footer);
    	$m_pdf->Output($pdfFilePath,'I'); 
	}
}