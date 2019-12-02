<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller
{
	/** @var breadcrumb */
	private $breadcrumb;

	/**
     * ReportController constructor.
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
		$this->load->model('Sekolah_model');

		/** @set bredcrumb **/
		$this->breadcrumb = array(
			'<li class="breadcrumb-item active">Report</li>'
		);
		$this->template->set('breadcrumb',$this->breadcrumb);
	}

	/**
	 * Show our dashboard for report page
	 *
	 * @access public
	 */
	public function index()
	{
		$this->template->load('app','core/report');
	}

	/**
	 * Get datatable 
	 *
	 * @method get ajax_request
	 * @return json
	 */
	public function data()
	{
		$table 			= '';
		$primaryKey		= 'id';
		$columns		= array(
			array( 'db' => 'id', 'dt' => 'id'),
			array( 'db' => 'nama', 'dt' => 'nama'),
			array( 'db' => 'nip', 'dt' => 'nip'),
			array(
				'db'=> 'id',
				'dt' => 'aksi',
				'formatter' => function($d) {
					return '<button type="button" onclick="edit(\''.$d.'\')" class="btn btn-success btn-sm">Edit</button>';
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
		
		$sekolah_id = user()->sekolah_id;
		$where = "id_sekolah = '$sekolah_id'";
		echo json_encode(
			SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where)
		);
	}

	/**
	 * Download report today
	 *
	 * @return header
	 */
	public function harian()
	{
		$m_pdf = new \Mpdf\Mpdf();
		$date = date('Y-m-d', time());

		$data['qry'] = $this->db->get_where('lapor',['tanggal' => $date,'sekolah_id' => user()->sekolah_id])->result();

		// echo json_encode($data['qry']);
		$data['date'] = $date;
		$data['sekolah'] = $this->Sekolah_model->get_by_kolom('id',user()->sekolah_id)->row();
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

}