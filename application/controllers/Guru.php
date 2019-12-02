<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends CI_Controller 
{
	/** @var breadcrumb */
	private $breadcrumb;

	/**
     * GuruController constructor.
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
		$this->load->library('Excel');

		/** @load Model **/
		$this->load->model('Guru_model');

		/** @set bredcrumb **/
		$this->breadcrumb = array(
			'<li class="breadcrumb-item">Administrative</li>',
			'<li class="breadcrumb-item active">Guru</li>'
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
		$this->template->load('app','core/guru');
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
		if($this->form_validation->run('guru/tambah')) {
			$data = [
				'id_sekolah'		=> user()->sekolah_id,
				'nip'				=> $this->input->post('nip'),
				'nama'				=> $this->input->post('nama'),
			];

			$this->Guru_model->save($data);
			$respond['status'] 	= 1;
			$respond['pesan']	= 'Data guru berhasil disimpan';
		}
		else {
			$respond['status']	= 0;
			$respond['pesan']	= validation_errors();
		}

		echo json_encode($respond);
	}

	/**
	 * Update data
	 *
	 * @method post
	 * @access public
	 * @return json
	 */
	public function update()
	{
		if($this->form_validation->run('guru/edit')) {
			$data = [
				'nip'				=> $this->input->post('nip'),
				'nama'				=> $this->input->post('nama'),
			];
			$id = $this->input->post('id');
			$this->Guru_model->update('id',$id,$data);
			$respond['status'] 	= 1;
			$respond['pesan']	= 'Data guru berhasil ubah';
		}
		else {
			$respond['status']	= 0;
			$respond['pesan']	= validation_errors();
		}

		echo json_encode($respond);
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
					$this->Guru_model->delete('id', $kunci);
				}
			}

			$respon['status'] = 1;
			$respon['pesan'] = 'Data guru berhasil dihapus';
		} else {
			$respon['status'] = 0;
			$respon['pesan'] = validation_errors();
		}

		echo json_encode($respon);
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
 		$data['data'] = 0;

 		if(!empty($id)) {
 			$query = $this->Guru_model->get_by_kolom('id',$id);
 			if($query->num_rows() > 0) {
 				$query = $query->row();
 				$data = [
 					'data'	=> 1,
 					'id'	=> $query->id,
 					'nip'	=> $query->nip,
 					'nama'	=> $query->nama
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
		$table 			= 'guru';
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
	 * Get datatable 
	 *
	 * @method get $id_sekolah
	 * @return view
	 */

	public function guru_sekolah($id_sekolah)
	{
		$data['id_sekolah'] = $id_sekolah;
		$this->template->load('app','core/guru_list',$data);
	}
	/**
	 * Get datatable 
	 *
	 * @method get ajax_request
	 * @return view
	 */
	public function lister($id_sekolah)
	{
		$table 			= 'guru';
		$primaryKey		= 'id';
		$columns		= array(
			array( 'db' => 'id', 'dt' => 'id'),
			array(
				'db'=> 'nip',
				'dt' => 'nip'
			),
			array(
				'db'=> 'nama',
				'dt' => 'nama'
			)
		);

		$sql_details = array(
			'user'	=> $this->db->username,
			'pass'	=> $this->db->password,
			'db'	=> $this->db->database,
			'host'	=> $this->db->hostname
		);
				
		$where = "id_sekolah = '$id_sekolah'";
		echo json_encode(
			SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $where)
		);
	}
	/**
	 * Show upload guru view
	 * @return
	 */
	public function upload()
	{
		$this->template->load('app','core/guru_upl');
	}

	public function import()
	{
		$jumlah_guru = $this->db->get_where('guru')->num_rows();
    
    	$status=array();  
    
		$importdata = $_REQUEST['data'];
		$date   = new DateTime;
    
    	$fileName = $_FILES['import']['name'];
		$config['upload_path'] = './uploads/files/';
		$config['file_name'] = $fileName;
		$config['allowed_types'] = 'xls|xlsx';
		$config['overwrite'] = TRUE; 
    	$this->load->library('upload');
    
    	$this->upload->initialize($config);
		if(!$this->upload->do_upload('import')){
			$status['type'] = 'error';
			$status['text'] = $this->upload->display_errors();
			$status['title'] = 'Upload file error!';
			echo json_encode($status);
			exit();
    	}
    
		$inputFileName = './uploads/files/'.$fileName;
		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			$worksheetTitle = $worksheet->getTitle();
			$highestRow = $worksheet->getHighestRow(); // e.g. 10
			$highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    	}
    
		$nrColumns = ord($highestColumn) - 64;
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();
		$status['highestColumn'] = $highestColumn;
		$status['highestRow'] = $highestRow;
		$status['sheet'] = $sheet;
    	$status['nrColumns'] = $nrColumns;
    
		if($highestColumn == 'C') { // Import data guru
			$row = $objPHPExcel->getActiveSheet()->getRowIterator(1)->current();
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false);
			foreach ($cellIterator as $k=>$cell) {
				$key[] = $cell->getValue();
			}
			for ($row = 2; $row <= $highestRow; ++ $row) {
				$val = array();
				for ($col = 0; $col < $highestColumnIndex; ++ $col) {
					$cell = $worksheet->getCellByColumnAndRow($col, $row);
					$val[] = $cell->getValue();
				}
				$i=0;
				foreach($val as $k=>$v){
					$InsertData[] = array(
						"$key[$i]"=> $v
						);
					$i++;
				}
				$flat = call_user_func_array('array_merge', $InsertData);
				$masukkan[] = $flat;
			}
			$jumlah_data_import = count($masukkan);
			$sum=0;
			$data_sudah_ada = array();
      		$gagal_insert_user = array();
      
			foreach($masukkan as $k=>$v){
      			$a = $this->db->get_where('guru',['nip' => $v['NIP']])->result();
      			$sum+=count($a);
      
				if(!$a){
					$nip 		= $v['NIP'];
        			$nama 		= $v['Nama Lengkap'];
        			$this->db->insert('guru',
        			[
          				'nip'  		  => $nip,
          				'nama'        => $nama,
          				'id_sekolah'  => user()->sekolah_id,
        			]);
				} else {
					$data_sudah_ada[] .= 'Data sudah ada';
				}
			}
			$jml_data_sudah_ada = count($data_sudah_ada);
			$kolom = ($highestRow - 1);
			$disimpan = ($kolom - $sum);
			$ditolak = ($kolom - $jml_data_sudah_ada);
			$status['text']	= '<table width="100%" class="table table-bordered">
				<tr>
					<td class="text-center">Jumlah data</td>
					<td class="text-center">Status</td>
				</tr>
				<tr>
					<td>'.$disimpan.'</td>
					<td><span class="badge badge-success">sukses disimpan</span></td>
				<tr>
					<td>'.$jml_data_sudah_ada.'</td>
					<td><span class="badge badge-danger">data sudah ada</span></td>
				</tr>
				</table>';
      		$status['type'] = 'success';
      		$status['title'] = 'Import data sukses!';
    	} else {
      		$status['type'] = 'error';
      		$status['text'] = 'Format Import tidak sesuai. Silahkan download template yang telah disediakan.';
      		$status['title'] = 'Import Data Gagal!';
    	}
    	unlink($inputFileName);
		echo json_encode($status);
	}

}