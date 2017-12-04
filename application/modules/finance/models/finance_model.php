<?php
class Finance_model extends CI_Model {

	var $tbl_cust = 'customer';
	var $tbl_sales = 'sales';
	var $tbl_request = 'shipment_request';

	public function __construct(){
        parent::__construct();
		$this->db_main = $this->load->database('default',TRUE);
    }

	function req_copa($filter=FALSE){
			$totalcost = 'r.service_charges + r.freight_charges + r.transport_charges + r.dg_charges + r.cgx_charges + r.curency_carges';
			$totalcost .= '+ r.cgk_charges + r.origin_charges + r.destination_charges + r.warehouse_charge + r.packaging_charge';
			$totalcost .= '+ r.fumigation_charge + r.duty_charges + r.allin_charges';

			$this->db_main->select('ifnull(r.copa_lock,"no") as copa_lock, pbth, r.curency,r.request_id,r.request_type,r.copa,request_date, IFNULL(('.$totalcost.'),0) as total_cost ',FALSE)
					->from($this->tbl_request.' r');
			if($filter !=FALSE && count($filter)>0)
				$this->db_main->where($filter);
			$res=$this->db_main->get();

			//echo $this->db_main->last_query();
			if($res->num_rows() > 0)
				return $res->result();
			else
				return array();
	}

	function copa_set($data,$filter){
		$this->db_main->where($filter);
		$this->db_main->update(
			$this->tbl_request,$data
		);
		if($this->db_main->affected_rows()> 0)
			return TRUE;
		else
			return FALSE;
	}

	function edit($data,$filter){
		$this->db_main->where($filter);
		$this->db_main->update(
			$this->tbl_request,$data
		);

		if($this->db_main->affected_rows()> 0)
			return TRUE;
		else
			return FALSE;
	}
}
