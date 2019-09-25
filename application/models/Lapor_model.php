<?php
/**
 * Manages the lapor model
 *
 * @copyright 2018-2019 ICT43.
 * @license GPL-2.0-only
 * @package lapor_model
 * @since 1.0
 */


class Lapor_model extends CI_Model
{
	/** @var table **/
	private $table = 'lapor';

	/**
	 * Select data
	 * 
	 * @access public
	 * @return boolean
	 * @param strin $data
	 */
	public function get_by_date_id($sekolah_id, $date, $jadwal_id) 
	{
		$where = [
			'sekolah_id' 	=> user()->sekolah_id, 
			'tanggal' 		=> $date, 
			'jadwal_id' 	=> $jadwal_id
		];
		return $this->db->get_where('lapor',$where);
	}
}
