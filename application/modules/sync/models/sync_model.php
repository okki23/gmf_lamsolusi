<?php
class Sync_model extends CI_Model {
	
	var $main_maintenace = 'shipment_maintenance';
	var $sinc_awb 		= 'awb';

	public function __construct(){
        parent::__construct();
		$this->db_main = $this->load->database('default',TRUE);
		$this->db_sync = $this->load->database('server',TRUE);
    }

	function get(){
		$this->db_main->select('awb,awb_status,bc_no,bc_date')
			->from($this->main_maintenace)
			->where('awb_status','Open');
		$res=$this->db_main->get();
		
		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}
	
	function cek($filter=array()){
		$this->db_sync->select('awb_no as awb,status_awb as awb_status,bc_no,bc_date')
			->from($this->sinc_awb);
			
		if($filter !=FALSE && count($filter)>0)
			$this->db_sync->where($filter);
		
		$res=$this->db_sync->get();
		
		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}
	
	function update($filter,$data){
		$this->db_main->where($filter);
		$this->db_main->update(
			$this->main_maintenace,$data
		);
		if($this->db_main->affected_rows()> 0)
			return TRUE;
		else
			return FALSE;
	}
	
}