<?php
class Partner_model extends CI_Model {
	
	var $table = 'partner';
	public function __construct(){
        parent::__construct();
		$this->db_main = $this->load->database('default',TRUE);
    }

	function add($data){
		$this->db_main->insert(
			$this->table,$data
		);
		
		if($this->db_main->affected_rows()> 0)
			return TRUE;
		else
			return FALSE;
	}
	
	function edit($data,$filter){
		$this->db_main->where($filter);
		$this->db_main->update(
			$this->table,$data
		);
		
		if($this->db_main->affected_rows()> 0)
			return TRUE;
		else
			return FALSE;
	}
	
	function hapus($filter){
		$this->db_main->where($filter);
		$this->db_main->delete($this->table);
	}
	
	function get($filter=FALSE){
		$this->db_main->select('id_partner as id, nama_partner as partner, cp,phone,email,country, alamat')
			->from($this->table);
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->get();
		
		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}
	
}