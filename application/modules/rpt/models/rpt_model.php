<?php
class Rpt_model extends CI_Model {

	var $table 				= 'customer';
	var $tbl_req 			= 'shipment_request';
	var $tbl_req_item 	= 'shipment_item';
	var $tbl_port			= 'portlist';
	var $maintenace 		= 'shipment_maintenance';
	var $maintenace_item = 'shipment_maintenance_item';
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
	
	function get_req_export_import($filter=FALSE){
		$this->db_main->select('r.customer_id, if(r.pbth="Yes","PBTH","Other") as payment_trm, r.request_id, r.request_type, r.shp_priority,
		r.port_origin,r.awb as awb_custom, r.ata, r.port_dest, i.ponumber, "-" as awb, "-" as eta, "-" as etd, "-" as sp_date, i.part_number,i.part_desc, i.acregis,
		(service_charges+freight_charges+transport_charges+dg_charges+cgx_charges+curency_carges+cgk_charges+origin_charges+destination_charges+warehouse_charge+packaging_charge+fumigation_charge+duty_charges+allin_charges) as price_asign,
		r.status, "-" as sp_number,i.paymentres,i.curency, r.eid,r.eod, i.dimensi,i.weight,r.exsec_date,r.shp_from,r.shp_to',FALSE)
			->from($this->tbl_req." r")
			->join($this->tbl_req_item." i",'i.request_id=r.request_id');
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->get();
	
		//echo $this->db_main->last_query();
		
		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}
	
	function cek_awb($filter){
		$this->db_main->select('m.awb,m.sp_id,m.eta_date,m.etd_date,m.ata_date,m.awb_status,m.reference')
			->from($this->maintenace.' m')
			->join($this->maintenace_item.' i','m.awb=i.awb');
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->limit(1)->get();
		//echo $this->db_main->last_query();
		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}
	
	function get_req_packaging($filter){
		$this->db_main->select('r.*, r.payment_res as paymentres')
			->from($this->tbl_req." r");
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->get();
		
		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}


}
