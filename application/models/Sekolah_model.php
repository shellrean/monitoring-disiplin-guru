<?php

class Sekolah_model extends CI_Model
{
	public $table = 'sekolah';

    public function save($data) 
    {
        $this->db->insert($this->table,$data);
        return true;
    }
	public function get_datatable($start, $rows, $kolom, $isi)
    {
		$this->db->where('('.$kolom.' LIKE "%'.$isi.'%")')
                 ->from($this->table)
				 ->order_by($kolom)
                 ->limit($rows, $start);
        return $this->db->get();
	}

    public function get_all(){
        $this->db->from($this->table)
                 ->order_by('nama_sekolah', 'ASC');
        return $this->db->get();
    }
    
    public function get_datatable_count($kolom, $isi)
    {
		$this->db->select('COUNT(*) AS hasil')
                 ->where('('.$kolom.' LIKE "%'.$isi.'%")')
                 ->from($this->table);
        return $this->db->get();
	}

    public function delete($kolom,$isi)
    {
        if($kolom == 'id') {
            $this->db->where('id_sekolah',$isi)
                    ->delete('guru');
            $this->db->where('sekolah_id',$isi)
                    ->delete('jadwal');
            $this->db->where('sekolah_id',$isi)
                    ->delete('jadwal');
            $this->db->where('sekolah_id',$isi)
                    ->delete('kelas');
            $this->db->where('sekolah_id',$isi)
                    ->delete('lapor');
            $this->db->where('sekolah_id',$isi)
                    ->delete('seling');
            $this->db->where('sekolah_id',$isi)
                    ->delete('user');
        }
        $this->db->where($kolom, $isi)
                 ->delete($this->table);
    }

    function get_by_kolom($kolom, $isi){
        $this->db->select('id,nama_sekolah,alamat_sekolah')
                 ->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }

    function update($kolom, $isi, $data){
        $this->db->where($kolom, $isi)
                 ->update($this->table, $data);
    }

}