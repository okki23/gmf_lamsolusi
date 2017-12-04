<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tracking extends MY_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->module('app');
		$this->app->cek_permit();
    }
	
	public function index()
	{
		$this->cek_build_access(array(USER_GMF,USER_CUSTOMER));
		
		$this->template->title('Tracking Request');
		$this->template->build('customer/tracking_view');
	}
	
	function get(){
		$data['filter'] = $this->input->post('filter');
		$res['res'] =$data;
		$this->load->view('customer/tracking_table',$res);
	}
	
	function by_request(){
		$this->load->model('shipment/shipment_model','mod_shp');
		$res	= array();
		$fiter 	= $this->input->post('filter');
		
		$where['m.awb ="'.$fiter.'" OR m.reference like "%'.$fiter.'%"'] =NULL;
		
		//if($this->session->userdata('level')==USER_CUSTOMER)
			//$where['r.customer_id'] =$this->session->userdata('limit_id');
		
		if($fiter !='')
			$res = $this->mod_shp->tracking($where);
		
		
		echo json_encode(array('data'=>$res));
	}
}
