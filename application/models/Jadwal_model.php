<?php
/**
 * Manages the jadwal model
 *
 * @copyright 2018-2019 ICT43.
 * @license GPL-2.0-only
 * @package Jadwal_model
 * @since 1.0
 */


class Jadwal_model extends CI_Model
{

	/** @var table **/
	private $table = 'jadwal';

	/**
	 * Insert data to table
	 * 
	 * @access public
	 * @return boolean
	 * @param array $data
	 */
	public function save($data) 
	{
		$this->db->insert($this->table,$data);
		return true;
	}

	/**
	 * Get all the data selected by sekolah
	 *
	 * @access public
	 * @return object
	 * @param integer $sekolah_id
	 */
	public function get_all($sekolah_id)
	{
		return $this->db->get_where($this->table,['sekolah_id' => $sekolah_id]);
	}

	/**
	 * Get all the data selected by guru
	 *
	 * @access public
	 * @return object
	 * @param integer $guru_id
	 */
	public function get_by_guru($guru_id)
	{
		return $this->db->get_where($this->table,['guru_id' => $guru_id]);
	}
	
	/**
	 * Delete data in table 
	 * 
	 * @access public
	 * @param string $kolom
	 * @param string $isi
	 */
	public function delete($kolom, $isi)
	{
		$this->db->where($kolom,$isi)->delete($this->table);
		return true;
	}
}