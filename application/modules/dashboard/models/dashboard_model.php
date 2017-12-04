<?php
class Dashboard_model extends CI_Model {
	
	var $tbl_request = 'shipment_request';
	var $tbl_maintenance = 'shipment_maintenance';
	var $tbl_sp = 'shipment_sp';
	var $tbl_session = 'session';
	var $tbl_sales_act = 'salesact';
	public function __construct(){
        parent::__construct();
		$this->db_main = $this->load->database('default',TRUE);
    }

	function count_request($custom_fild,$filter=array()){
		$this->db_main->select($custom_fild,FALSE)
			->from($this->tbl_request);
			
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->get();
		
		//echo $this->db_main->last_query()."<br>";
		return $res->result();
		
	}
	
	function count_awb($custom_fild,$filter=array()){
		$this->db_main->select($custom_fild,FALSE)
			->from($this->tbl_maintenance);
			
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->get();
		
		//echo $this->db_main->last_query();
		return $res->result();
	}
	
	function count_sp($custom_fild,$filter=array()){
		$this->db_main->select($custom_fild,FALSE)
			->from($this->tbl_sp);
			
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->get();
		
		//echo $this->db_main->last_query();
		return $res->result();
	}
	
	function aktif_user($custom_fild,$filter=array()){
		$this->db_main->select($custom_fild,FALSE)
			->from($this->tbl_session);
			
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->get();
		
		//echo $this->db_main->last_query();
		return $res->result();
	}
	
	
	
	function sales_act($custom_fild,$filter=array()){
		$this->db_main->select($custom_fild,FALSE)
			->from($this->tbl_sales_act);
			
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->get();
		
		//echo $this->db_main->last_query();
		return $res->result();
	}
}