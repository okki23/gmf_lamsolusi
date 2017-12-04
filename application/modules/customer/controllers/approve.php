<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Approve extends MY_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->module('app');
		$this->app->cek_permit();
    }

	public function index()
	{
		$this->cek_build_access(array(USER_SADMIN,USER_CUSTOMER));
		$arCmb=array(
			array('name'=>'incoterm','url'=>'app/incoterm'),
			array('name'=>'shipment_mode','url'=>'app/shipmentmode')
		);
		$data['js_cmb']=$this->app->dropdown_kendo($arCmb);

		$this->template->title('Approve');
		$this->template->build('customer/approve_view',$data);
	}

	function get(){
		$res 	= array();
		$filter = array();
		$this->load->model('customer/customer_model','mod_cust');
		$free_user = array(USER_SADMIN,USER_GMF,USER_SALES);

		if(!in_array(USER_CUSTOMER,$free_user))
			$filter['customer_id']=$this->session->userdata('limit_id');

		$filter['status']=2;

		if($this->input->post('id') !='')
			$filter['request_id IN("'.implode('","',explode(',',$this->input->post('id'))).'")']=NULL;


		$res = $this->mod_cust->request_get($filter);
		$res = array_merge($res,$this->mod_cust->request_get2($filter));

		echo json_encode(array('data'=>$res));
	}

	function proses(){
		$this->load->model('customer/customer_model','mod_cust');
		$id 			= $this->input->post('id');
		$out['status'] 	= FALSE;

		$data=array(
			'approve_date'=>date('Y-m-d'),
			'status'=> 4,
			'user_notes'=> $this->input->post('note')
		);
		
		do{
			if($id==''){
				$out['mesages'] = 'Galat sistem id is null';
				break;
			}

			$filter['request_id'] = $id;
			$res = $this->mod_cust->request_edit($data,$filter);

			if($res){
				$out['status']=TRUE;
				$out['messages']='Request id <b>'.$id.'</b> successfully Approveed';
				break;
			}
		}while(false);

		echo json_encode($out);
	}

	function reject(){
		$this->load->model('customer/customer_model','mod_cust');
		$id 				= $this->input->post('id');
		$out['status'] 	= FALSE;

		$data=array(
			'approve_date'=>date('Y-m-d'),
			'status'=> 3,
			'user_notes'=> $this->input->post('note'),
			'service_charges'=>0,
			'freight_charges'=>0,
			'transport_charges'=>0,
			'dg_charges'=>0,
			'cgx_charges'=>0,
			'curency_carges'=>0,
			'cgk_charges'=>0,
			'origin_charges'=>0,
			'destination_charges'=>0,
			'warehouse_charge'=>0,
			'packaging_charge'=>0,
			'fumigation_charge'=>0,
			'duty_charges'=>0,
			'allin_charges'=>0
		);
		
		
		
		do{
			if($id==''){
				$out['mesages'] = 'Galat sistem id is null';
				break;
			}

			$filter['request_id'] = $id;
			$res = $this->mod_cust->request_edit($data,$filter);

			if($res){
				$out['status']=TRUE;
				$out['messages']='Data berhasil disimpan.';
				break;
			}
		}while(false);

		echo json_encode($out);
	}

}
