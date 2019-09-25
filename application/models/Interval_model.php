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
				 ->where('sekolah_id',$sekolah_id)
				 ->order_by('dari');
		return $this->db->get();
	}

	public function save($data)
	{
		$this->db->insert('seling',$data);
		return true;
	}

	/**
	 * Get data selected by kolom
	 *
	 * @access public
	 * @return object
	 * @param string $kolom
	 * @param string $isi
	 */
	public function get_by_kolom($kolom, $isi) 
	{
		return $this->db->get_where('seling',[$kolom => $isi]);
	}

	/**
	 * Delete selected by kolom
	 *
	 * @access public
	 * @return object
	 * @param string $kolom
	 * @param string $isi
	 */
	public function delete($kolom,$isi)
    {
        $this->db->where($kolom, $isi)
                 ->delete('seling');
    }

    /**
	 * Update table
	 *
	 * @access public
	 * @param string $kolom,
	 * @param string $isi,
	 * @param array $data
	 */
	public function update($kolom,$isi,$data)
	{
		$this->db->where($kolom,$isi)
				->update('seling',$data);
		return true;
	}


}