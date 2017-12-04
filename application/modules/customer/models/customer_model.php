<?php
class customer_model extends CI_Model {

	var $table 			= 'customer';
	var $tbl_sales		= 'sales';
	var $tbl_req 		= 'shipment_request';
	var $tbl_req_item 	= 'shipment_item';
	var $tbl_petugas 	= 'petugas';
	var $tbl_uom 	= 'uom';
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
		$this->db_main->select('npwp,cust_type,id_customer as id, nama_customer as customer, cp, phone, email, country,alamat')
			->from($this->table);
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->get();

		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}

	function request_get($filter){
		$this->db_main->select('cgk_charges,origin_charges, destination_charges, warehouse_charge,packaging_charge, fumigation_charge, duty_charges, allin_charges,
				eid,eod,ata, awb_file,exsec_date,payment_res, shp_to, shp_from, shp_priority, IFNULL(r.user_notes,"") as user_notes,r.curency,r.awb, curency, "" as forwarder_name,forwarder_id,
				service_charges, freight_charges, transport_charges, dg_charges,cgx_charges,curency_carges,
				request_type,request_date as date, status, req_desc,
				request_id as id, partner_id as partner,p.nama_partner,
				port_origin,l.port_name as origin_name, port_dest,z.port_name as dest_name,
				inco_term, weight,cpo,shipment_mode,special_request',FALSE)
			->from($this->tbl_req.' r')
			->join('portlist l','l.port_id=r.port_origin')
			->join('portlist z','z.port_id=r.port_dest')
			->join('partner p', 'p.id_partner=r.partner_id');
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$this->db_main->order_by('request_date','DESC');
		$res=$this->db_main->get();

		//echo $this->db_main->last_query();

		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}

	function request_get2($filter){
		$req_type = array('WAREHOUSE LEASE','CUSTOM CLEARANCE','PACKAGING','INTERNAL DISTRIBUTION');
		$this->db_main->select('cgk_charges,origin_charges, destination_charges, warehouse_charge,packaging_charge, fumigation_charge, duty_charges, allin_charges,
				eid,eod,ata,awb_file,exsec_date,shp_from, payment_res, shp_to, shp_priority, IFNULL(r.user_notes,"") as user_notes,r.curency,r.awb, curency, "" as forwarder_name,forwarder_id,
				service_charges, freight_charges, transport_charges, dg_charges,cgx_charges,curency_carges,
				request_type,request_date as date, status, req_desc,
				request_id as id, partner_id as partner,"" as nama_partner,
				port_origin,"" as origin_name, port_dest,"" as dest_name,
				inco_term, weight,cpo,shipment_mode,special_request',FALSE)
			->from($this->tbl_req.' r');
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$this->db_main->where_in('request_type',$req_type);
		$this->db_main->order_by('request_date','DESC');
		$res=$this->db_main->get();

		//echo $this->db_main->last_query();

		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}

	function reqeuest_add($data){
		$this->db_main->insert(
			$this->tbl_req,$data
		);

		if($this->db_main->affected_rows()> 0)
			return TRUE;
		else
			return FALSE;
	}


	function request_edit($data,$filter){
		$this->db_main->where($filter);
		$this->db_main->update(
			$this->tbl_req,$data
		);
		//echo $this->db_main->last_query();
		//if($this->db_main->affected_rows()> 0)
			return TRUE;
		//else
		//	return FALSE;
	}


	function reqeuestitem_add($data){
		$this->db_main->insert_batch(
			$this->tbl_req_item,$data
		);

		if($this->db_main->affected_rows()> 0)
			return TRUE;
		else
			return FALSE;
	}


	function reqeuestitem_edit($data,$filter){
		$this->db_main->where($filter);
		$this->db_main->update(
			$this->tbl_req_item,$data
		);
		if($this->db_main->affected_rows()> 0)
			return TRUE;
		else
			return FALSE;
	}

	function reqeuestitem_get($filter=FALSE){
		$this->db_main->select('*')
			->from($this->tbl_req_item);
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->get();

		//echo $this->db_main->last_query();
		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}

	function reqeuestitem_delete($filter){
		$this->db_main->where($filter);
		$this->db_main->delete($this->tbl_req_item);
	}

	function request_status($id){
		$this->db_main->select('status')
			->from($this->tbl_req)
			->where('request_id',$id);
		$rsx = $this->db_main->get();
		$row = current($rsx->result());

		if($row->status == 1 || $row->status == 2)
			return TRUE;
		else
			return FALSE;
	}

	function customer_request($filter=FALSE){
		$this->db_main->select('r.request_type, r.request_id, p.nama_petugas,
			c.id_customer, c.cp, c.email as email_customer, p.email as email_petugas')
			->from($this->tbl_req.' r')
			->join($this->table.' c','r.customer_id=c.id_customer')
			->join($this->tbl_petugas.' p','r.petugas_id=p.id_petugas' );
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->get();


		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();

	}

	function get_uom($filter=FALSE){
		$this->db_main->select('uom as uomid, CONCAT(uom_desc," (", uom,")") as uomlabel',FALSE)
			->from($this->tbl_uom);
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->get();

		//echo $this->db_main->last_query();
		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}

}
