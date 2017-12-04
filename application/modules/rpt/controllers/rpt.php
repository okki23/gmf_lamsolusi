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
	
	function request(){
		$this->cek_build_access(array(USER_GMF));

		$this->template->title('Report Request');

		$this->template->build('rpt/rpt_request');
	}
	
	function request_submit(){
		$res['res'] =array(
			'type'=>$this->input->post('type'),
			'cb_normal'=>$this->input->post('cb_normal'),
			'cb_aog'=>$this->input->post('cb_aog'),
			'im_date_start'=>$this->input->post('im_date_start'),
			'im_date_end'=>$this->input->post('im_date_end'),
			'ata_date_start'=>$this->input->post('ata_date_start'),
			'ata_date_end'=>$this->input->post('ata_date_end'),
			'cb_incoming'=>$this->input->post('cb_incomin  g'),
			'cb_outgoing'=>$this->input->post('cb_outgoing'),
			'leanse_date_start'=>$this->input->post('leanse_date_start'),
			'leanse_date_end'=>$this->input->post('leanse_date_end'),
			'date_start'=>$this->input->post('date_start'),
			'date_end'=>$this->input->post('date_end')
		);
		$msg = '';
		$htm = '';
		do{
			if($this->input->post('type')=='-1')
				$msg= lang('msg_rpt_blank_service');
			
			/* if($this->input->post('type')=="IMPORT,EXPORT" && $this->input->post('cb_ata')==FALSE && $this->input->post('cb_atd')==FALSE)
				$msg= lang('msg_rpt_date_type_import'); */
			if($this->input->post('date_start') =='' || $this->input->post('date_end')=='')
				$msg= lang('msg_rpt_date_type_import');
		}while(FALSE);
	
		if($msg !=''){
			$htm .='<div class="alert alert-info">';
			$htm .='<strong>Info!</strong> '.$msg;
			$htm .='</div>';
			
			echo $htm;
		}else
			$this->load->view('rpt/rpt_request_detail',$res);
	}
	
	function request_submit_get(){
		$this->load->model('rpt/rpt_model','mod_rpt');
		
		$res 	 				= array();
		$filter 	 			= array();
		$type 				= explode(",",$this->input->post('type'));
		$sv_level_aog 	= $this->input->post('cb_aog');
		$sv_level_norml	= $this->input->post('cb_normal');
		$date_start		= $this->input->post('date_start');
		$date_end			= $this->input->post('date_end');
		
		do{  
			$filter['request_type IN("'.implode('","',$type).'")']= NULL;
			$filter['request_date BETWEEN "'.$date_start.'" AND "'.$date_end.'" '] = NULL;
			
			if($this->input->post('type') =='IMPORT,EXPORT'){
				 
				if($sv_level_aog !='false' && $sv_level_norml !='false')
					$filter['shp_pririty IN("AOG","Normal")'] = NULL;
				else if($sv_level_aog !='false')
					$filter['shp_priority'] = $sv_level_aog;
				else if($sv_level_norml !='false')
					$filter['shp_priority'] = $sv_level_norml;
			}
			
			if($this->input->post('type') =='PACKAGING')
				$res = $this->mod_rpt->get_req_packaging($filter);
			else
				$res = $this->mod_rpt->get_req_export_import($filter);
				
			if($this->input->post('type') =='IMPORT,EXPORT' || $this->input->post('type') =='CUSTOM CLEARANCE'){	
		 			 
			foreach($res as $key=>$row){
				
					$filter_x['m.reference']=$row->request_id;
					$filter_x['i.part_number']=$row->part_number;
					$res_x = $this->mod_rpt->cek_awb($filter_x);
					if(count($res_x) > 0){
						$res[$key]->awb = $res_x[0]->awb;
						$res[$key]->eta = $res_x[0]->eta_date;
						$res[$key]->etd = $res_x[0]->etd_date;
						//$res[$key]->atd = $res_x[0]->atd_date;
						$res[$key]->sp_number = $res_x[0]->sp_id;
					}
				}
			}
			
			if($this->input->post('type') =='CUSTOM CLEARANCE'){	
				$this->load->model('shipment/shipment_model','mod_shp');
				foreach($res as $key=>$row){
					$filter_y['sp_id']=$row->sp_number;
					$res_y = $this->mod_shp->get_sp($filter_y);
					if(count($res_y) > 0){
						$res[$key]->sp_date = $res_y[0]->sp_date;
					}
				}
			}
			
			
		}while(FALSE);
		echo json_encode(array('data'=>$res));
	}

}
