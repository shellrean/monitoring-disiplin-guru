<?php
/**
 * Manages the guru model
 *
 * @copyright 2018-2019 ICT43.
 * @license GPL-2.0-only
 * @package Guru_model
 * @since 1.0
 */


class Guru_model extends CI_Model
{
	/** @var table **/
	private $table = 'guru';

	/**
	 * Get all data from table
	 *
	 * @access public
	 * @return object
	 * @param integer $sekolah_id
	 */
	public function get_all($sekolah_id)
	{
		$this->db->from($this->table)
				 ->where('id_sekolah',$sekolah_id);
		return $this->db->get();

	}

	/**
	 * Get guru data select from id
	 *
	 * @access public
	 * @return object
	 * @param integer $guru_id
	 */
	public function get_by_id($guru_id)
	{
		return $this->db->get_where($this->table,['id' => $guru_id]);
	}

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