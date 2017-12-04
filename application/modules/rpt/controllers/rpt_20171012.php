<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rpt extends MY_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->module('app');
		$this->app->cek_permit();
    }

	public function index()
	{
		$this->cek_build_access(array(USER_GMF,USER_CUSTOMER,USER_SALES));

		$this->template->title('Tracking Request');

		//if($this->session->userdata('level')==USER_CUSTOMER)
			$this->template->build('rpt/rpt_view');
	}


	function customer(){
		$data['tgl_req_start'] = $this->input->post('tgl_req_start');
		$data['tgl_req_end'] = $this->input->post('tgl_req_end');
		$data['status'] = $this->input->post('status');

		$res['res'] = $data;
		$this->load->view('rpt/rpt_customer',$res);
	}

	function customer_get(){
		$this->load->model('rpt/rpt_model','mod_rpt');
		$date_start = $this->input->post('tgl_req_start');
		$date_end	= $this->input->post('tgl_req_end');
		$req_status	= $this->input->post('status');

		$filter['r.request_date BETWEEN "'.$date_start.'" AND "'.$date_end.'"'] = NULL;

		if($req_status !='-1')
			$filter['r.status']=$req_status;

		if($this->session->userdata('level')==USER_CUSTOMER)
			$filter['r.customer_id']= $this->session->userdata('limit_id');

		$res = $this->mod_rpt->rpt_request($filter);
		$res = array_merge($res,$this->mod_rpt->rpt_request2($filter));
		echo json_encode(array('data'=>$res));
	}

	function customer_detail(){
		$res['res'] =array(
			'id'=>$this->input->post('id')
		);
		$this->load->view('rpt/rpt_customer_detail',$res);
	}

	function customer_detail_get(){
		$this->load->model('rpt/rpt_model','mod_rpt');
		$id = $this->input->post('id');

		$filter['request_id'] = $id;

		$res = $this->mod_rpt->rpt_request_item($filter);
		echo json_encode(array('data'=>$res));
	}

}
