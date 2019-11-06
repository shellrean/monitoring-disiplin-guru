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
	 * Get data selected by kolom
	 *
	 * @access public
	 * @return object
	 * @param string $kolom
	 * @param string $isi
	 */
	public function get_by_kolom($kolom, $isi) 
	{
		return $this->db->get_where($this->table,[$kolom => $isi]);
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
		if($kolom == 'id') {
			$this->db->where('jadwal_id',$isi)->delete('lapor');
		}
		
		$this->db->where($kolom,$isi)->delete($this->table);
		return true;
	}

	/**
	 * Jadwal exist
	 *
	 * @access public
	 * @param 
	 */
	public function jadwal_exists($hari,$seling,$kelas)
	{
		$this->db->where([
			'hari_id'	=> $hari,
			'seling_id'	=> $seling,
			'kelas_id'	=> $kelas
		]);

		$query = $this->db->get($this->table);

		if($query->num_rows() > 0) {
			return true;
		}
		else {
			return false;
		}
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
				->update($this->table,$data);
		return true;
	}

	/**
	 * Get jadwal by day
	 *
	 * @access public 
	 * @param int $sekolah_id
	 * @param int $day
	 */
	public function get_by_day($sekolah_id,$day,$seling=false) 
	{
		$where = [
			'sekolah_id'	=> $sekolah_id,
			'hari_id'		=> $day
		];
		if($seling) {
			$where['seling_id'] = $seling;
			$this->db->order_by('kelas_id');
		}
		$this->db->order_by('seling_id','ASC');
		$this->db->where($where);
		return $this->db->get($this->table);
	}


}