<?php

class User_model extends CI_Model
{
	public $table = 'user';

 	public function save($data) 
    {
        $this->db->insert($this->table,$data);
        return true;
    }
	public function get_datatable($start, $rows, $kolom, $isi)
    {
		$this->db->where('('.$kolom.' LIKE "%'.$isi.'%" AND role_id != 1)')
                 ->from($this->table)
				 ->order_by($kolom)
                 ->limit($rows, $start);
        return $this->db->get();
	}
    
    public function get_datatable_count($kolom, $isi)
    {
		$this->db->select('COUNT(*) AS hasil')
                 ->where('('.$kolom.' LIKE "%'.$isi.'%")')
                 ->from($this->table);
        return $this->db->get();
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
}