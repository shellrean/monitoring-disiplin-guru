<?php
/**
 * Manages the interval model
 *
 * @copyright 2018-2019 ICT43.
 * @license GPL-2.0-only
 * @package Interval_model
 * @since 1.0
 */


class Interval_model extends CI_Model
{
	/** @var table **/
	private $table = 'hari';

	public function get_all()
	{
		$this->db->from($this->table); 
		return $this->db->get();
	}

	public function get_interval($sekolah_id)
	{
		$this->db->from('seling')
				 ->where('sekolah_id',$sekolah_id);
		return $this->db->get();
	}

	public function save($data)
	{
		$this->db->insert('seling',$data);
		return true;
	}


}