<?php
class Rpt_model extends CI_Model {

	var $table 			= 'customer';
	var $tbl_req 		= 'shipment_request';
	var $tbl_req_item 	= 'shipment_item';
	var $tbl_port		= 'portlist';
	public function __construct(){
        parent::__construct();
		$this->db_main = $this->load->database('default',TRUE);
    }

	function rpt_request($filter=FALSE){
		$this->db_main->select('r.status, r.request_id as id, r.request_type, l.port_name as origin_name , l.port_name as dest_name, r.inco_term, r.cpo, r.shipment_mode, r.special_request',FALSE)
			->from($this->tbl_req.' r')
			->join($this->tbl_port.' l','l.port_id=r.port_origin')
			->join($this->tbl_port.' z','z.port_id=r.port_dest');
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$this->db_main->order_by('r.request_id','DESC');
		$res=$this->db_main->get();

		//echo $this->db_main->last_query();
		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}

	function rpt_request2($filter=FALSE){
		$req_type = array('WAREHOUSE LEASE','CUSTOM CLEARANCE','PACKAGING','INTERNAL DISTRIBUTION');
		$this->db_main->select('r.status, r.request_id as id, r.request_type,
			"" as origin_name , "" as dest_name, r.inco_term,
			r.cpo, r.shipment_mode, r.special_request, req_desc',FALSE)
			->from($this->tbl_req.' r');
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$this->db_main->where_in('r.request_type',$req_type);
		$this->db_main->order_by('r.request_id','DESC');
		$res=$this->db_main->get();
		//echo $this->db_main->last_query();
		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}

	function rpt_request_item($filter=FALSE){
		$this->db_main->select('*',FALSE)
			->from($this->tbl_req_item);
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->get();

		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}

}
