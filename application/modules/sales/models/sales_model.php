<?php
class Sales_model extends CI_Model {

	var $table = 'sales';
	var $act_tbl = 'salesact';
	var $act_recal = 'salesact_recall';
	var $asign_tbl = 'shipment_request';
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

	function sendto_lnm($data,$filter){
		$this->db_main->where($filter);
		$this->db_main->update(
			$this->asign_tbl,$data
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
		$this->db_main->select('id_sales as id, nama_sales as sales, phone, email, country,alamat')
			->from($this->table);
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->get();

		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}

	function get_act($filter=FALSE){
		$this->db_main->select('actifity_id as id, actifity_start as date,customer_id, type,status,remark, "" as cst_name',FALSE)
			->from($this->act_tbl);
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->get();

		//echo $this->db_main->last_query();
		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}


	function assign($data,$filter){
		$this->db_main->where($filter);
		$this->db_main->update(
			$this->asign_tbl,$data
		);

		if($this->db_main->affected_rows()> 0)
			return TRUE;
		else
			return FALSE;
	}

	function acktifity_add($data){
		$this->db_main->insert(
			$this->act_tbl,$data
		);

		if($this->db_main->affected_rows()> 0)
			return TRUE;
		else
			return FALSE;
	}

	function acktifity_edit($data,$filter){
		$this->db_main->where($filter);
		$this->db_main->update(
			$this->act_tbl,$data
		);

		if($this->db_main->affected_rows()> 0)
			return TRUE;
		else
			return FALSE;
	}

	function acktifity_hapus($filter){
		$this->db_main->where($filter);
		$this->db_main->delete($this->act_tbl);
	}

	function add_act_sub($data){
		$this->db_main->insert(
			$this->act_recal,$data
		);

		if($this->db_main->affected_rows()> 0)
			return TRUE;
		else
			return FALSE;
	}

	function get_actifity_sub($filter=array()){
		$this->db_main->select('*',FALSE)
			->from($this->act_recal);
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->get();

		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}


}
