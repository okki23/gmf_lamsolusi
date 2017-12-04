<?php
class Shipment_model extends CI_Model {

	var $table_req = 'shipment_request';
	var $table_reqitem = 'shipment_item';
	var $maintenace = 'shipment_maintenance';
	var $maintenace_item = 'shipment_maintenance_item';
	var $sp = 'shipment_sp';
	public function __construct(){
        parent::__construct();
		$this->db_main = $this->load->database('default',TRUE);
    }

	function add($data){
		$this->db_main->insert(
			$this->maintenace,$data
		);

		if($this->db_main->affected_rows()> 0)
			return TRUE;
		else
			return FALSE;
	}

	function add_item($data){
		$this->db_main->insert_batch(
			$this->maintenace_item,$data
		);

		if($this->db_main->affected_rows()> 0)
			return TRUE;
		else
			return FALSE;
	}

	function get_shipment_item($filter=array()){
		$this->db_main->select('*',FALSE)
			->from($this->maintenace_item.' r');
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->get();
		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}


	function get($filter=array()){
		$this->db_main->select('r.awb, r.forwarder_id, r.reference, IFNULL(r.eta_date,"-") as eta_date, "" as type,
								IFNULL(r.etd_date,"-") as etd_date,IFNULL(r.estimate_flight_schadule,"-") as estimate_flight_schadule,
								IFNULL(r.ata_date,"-") as ata_date,IFNULL(r.atd_date,"-") as atd_date,
								IFNULL(r.flight_schadule,"-") as flight_schadule,
								IFNULL(r.bc_no,"-") as bc_no, IFNULL(r.bc_date,"-") as bc_date,
								r.port_origin, r.port_dest,r.awb_status, r.sp_cek, r.sp_id,
								l.port_name as origin_name, port_dest,z.port_name as dest_name',FALSE)
			->from($this->maintenace.' r')
			->join('portlist l','l.port_id=r.port_origin')
			->join('portlist z','z.port_id=r.port_dest');
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
		$this->db_main->select('awb,sp_id,ata_date,bc_no,bc_date,awb_status,reference')
			->from($this->maintenace);
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->limit(1)->get();
		//echo $this->db_main->last_query();
		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}

	function request_get($filter){
		$this->db_main->select('request_type,request_id as id, l.port_name as origin_name, port_dest,z.port_name as dest_name,shipment_mode',FALSE)
			->from($this->table_req.' r')
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

	function edit($data,$filter){
		$this->db_main->where($filter);
		$this->db_main->update(
			$this->maintenace,$data
		);
		if($this->db_main->affected_rows()> 0)
			return TRUE;
		else
			return FALSE;
	}

	function get_sp($filter=array()){
		$this->db_main->select('*',FALSE)
			->from($this->sp);
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->get();
		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}

	function sp_add($data){
		$this->db_main->insert(
			$this->sp,$data
		);

		if($this->db_main->affected_rows()> 0)
			return TRUE;
		else
			return FALSE;
	}

	function sp_edit($data,$filter){
		$this->db_main->where($filter);
		$this->db_main->update(
			$this->sp,$data
		);
		if($this->db_main->affected_rows()> 0)
			return TRUE;
		else
			return FALSE;
	}


	function tracking($filter){
		$this->db_main->select('m.port_origin,l.port_name as origin_name, m.port_dest,
				z.port_name as dest_name, m.awb, m.ata_date, m.atd_date,
				m.flight_schadule,"" as special_request',FALSE)
			->from($this->maintenace.' m')
			->join('portlist l','l.port_id=m.port_origin')
			->join('portlist z','z.port_id=m.port_dest');
			//->join($this->table_req.' r','r.request_id=m.request_id');

		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$this->db_main->group_by('m.awb');
		$res=$this->db_main->get();
		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}

	function sum_sending_item($filter,$value=FALSE){
		if($value)
			$this->db_main->select('item_id,request_id,sum(qty) as qty',FALSE);
		else
			$this->db_main->select('IFNULL(SUM(qty),0) AS total_qty',FALSE);

		$this->db_main->from($this->maintenace_item);
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		if($value) $this->db_main->group_by('item_id');
		$res = $this->db_main->get();
		if($value){
			return $res->result();
		}else{
			$total = current($res->result());
			return $total->total_qty;
		}
	}

	function sum_request_item($filter,$value=FALSE){
		if($value)
			$this->db_main->select('*',FALSE);
		else
			$this->db_main->select('IFNULL(SUM(qty),0) AS total_qty',FALSE);

		$this->db_main->from($this->table_reqitem);
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res = $this->db_main->get();
		if($value)
			return $res->result();
		else{
			$total = current($res->result());
			return $total->total_qty;
		}
	}

	function request_type($filter,$row = FALSE){
		$this->db_main->select('request_type',FALSE)
				 ->from($this->table_req);
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$this->db_main->group_by('request_type');
		//echo $this->db_main->last_query();
		if($row)
			$this->db_main->limit(1);

		$res = $this->db_main->get();

		if($row)
			return current($res->result());
		else
			return $res->num_rows();
	}

	function get_maintenance_fild($filter,$fild){
		$this->db_main->select("'".$fild."'",FALSE)
			->from($this->maintenace.' r');
		if($filter !=FALSE && count($filter)>0)
			$this->db_main->where($filter);
		$res=$this->db_main->get();
		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}
	
	function notify_approve($awb){
		$this->load->module('app');
		$filter_awb  = 'awb IN("'.implode('","',$awb).'")';
		$sub_query  = "SELECT p.nama_petugas,p.email,GROUP_CONCAT(r.request_id) as req_id FROM lam_petugas p ";
		$sub_query .= "JOIN lam_shipment_request r ON r.petugas_id=p.id_petugas ";
		$sub_query .= "WHERE r.request_id IN( ";
		$sub_query .= "SELECT TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(B.reference, ',', NS.n), ',', -1)) as req_number ";
		$sub_query .= "from ( select 1 as n union all  select 2 union all  select 3 union all  select 4 union all  select 5 union all  select 6 union all  select 7 union all
							 select 8 union all select 9 union all select 10 ) NS ";
		$sub_query .= "inner join lam_shipment_maintenance B ON NS.n <= CHAR_LENGTH(B.reference) - CHAR_LENGTH(REPLACE(B.reference, ',', '')) + 1
							 where ".$filter_awb;
		$sub_query .= ") group by p.id_petugas";
		
		$res = $this->db_main->query($sub_query,FALSE);
		
		if($res->num_rows() > 0)
			return $res->result();
		else
			return array();
	}

}
