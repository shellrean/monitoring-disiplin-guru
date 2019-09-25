<?php
/**
 * Manages the kelas model
 *
 * @copyright 2018-2019 ICT43.
 * @license GPL-2.0-only
 * @package Kelas_model
 * @since 1.0
 */


class Kelas_model extends CI_Model
{
	/** @var table **/
	private $table = 'kelas';
 
	/**
	 * Get all data from table
	 *
	 * @access public
	 * @return object
	 * @param integer $sekolah_id
	 */
	public function get_by_sekolah($sekolah_id,$tingkat=null)
	{
		$this->db->from($this->table)
				 ->where('sekolah_id',$sekolah_id);
		if($tingkat != null) {
			$this->db->where('tingkat',$tingkat);
		}
		return $this->db->get();
	}

	/**
	 * Get all data from table
	 *
	 * @access public
	 * @return object
	 * @param integer $sekolah_id
	 */
	public function get_by_kolom_sekolah($sekolah_id,$kolom, $isi) 
	{
		return $this->db->get_where($this->table,['sekolah_id' => $sekolah_id, $kolom => $isi]);
	}
}