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