<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monitoring extends MY_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->module('app');
		$this->app->cek_permit();
    }

	public function index()
	{
		$this->cek_build_access(array(USER_PARTNER,USER_GMF,USER_GMF_RECEIVING,USER_GMF_IMPORT));

		$this->template->title(lang('title_mnts'));
		$this->template->build('shipment/monitoring_view');
	}


	function get(){
		$res = array();
		$filter = array();
		$this->load->model('shipment/shipment_model','mod_shp');

		if($this->input->post('spID') !=false || $this->input->post('spID') != '')
			$filter['sp_id'] = $this->input->post('spID');
		else{
			$filter['sp_id is NULL'] = NULL;
		}

		if($this->input->post('awbid') !=false || $this->input->post('awbid') !='')
			$filter['awb'] = $this->input->post('awbid');
		$res = $this->mod_shp->get($filter);


		foreach($res as $key=>$value){
			$where['request_id IN ("'.implode('","',explode(",",$value->reference)).'")'] =NULL;
			$res_x = $this->mod_shp->request_type($where,TRUE);
			$res[$key]->type = $res_x->request_type;
			unset($where);
		}
		echo json_encode(array('data'=>$res));
	}


	function proses(){
		$this->load->model('shipment/shipment_model','mod_shp');
		$id= $this->input->post('id');
		$bc_no = $this->input->post('bc_no');
		$bc_date = $this->input->post('bc_date');
		$status = $this->input->post('status');
		$out['status'] =FALSE;

		$data=array(
			'bc_no'=>$bc_no,
			'awb_status'=>$status,
			'bc_date'=>$bc_date
		);

		do{
			if($bc_no==''){
				$out['messages']=lang('msg_mnt_bcno');
				break;
			}

			if($bc_date==''){
				$out['messages']=lang('msg_mnt_bcdate');
				break;
			}

			$filter['awb']= $id;
			$res = $this->mod_shp->edit($data,$filter);

			$out['status']=$res;
			if($res){
				$out['messages']=lang('msg_process_ok');
				break;
			}else
				$out['messages']=lang('msg_process_no');

		}while(FALSE);
		echo json_encode($out);
	}

	function proses_ata(){
		$this->load->model('shipment/shipment_model','mod_shp');
		$id= $this->input->post('id');
		$ata_date = $this->input->post('ata_date');
		$atd_date = $this->input->post('atd_date');
		$flight_schadule = $this->input->post('flight');
		$out['status'] =FALSE;

		$data=array(
			'ata_date'=>$ata_date,
			'atd_date'=>$atd_date,
			'flight_schadule'=>$flight_schadule
		);

		do{
			if($ata_date==''){
				$out['messages']=lang('msg_mnt_ata');
				break;
			}

			if($atd_date==''){
				$out['messages']=lang('msg_mnt_atd');
				break;
			}

			$filter['awb']= $id;
			$res = $this->mod_shp->edit($data,$filter);

			$out['status']=$res;
			if($res){
				$out['messages']=lang('msg_process_ok');
				break;
			}else
				$out['messages']=lang('msg_process_no');

		}while(FALSE);
		echo json_encode($out);
	}

	function get_awb_detail(){
		$res['res'] =array(
			'id'=>$this->input->post('id')
		);
		$this->load->view('shipment/maintenance_item',$res);
	}

	function get_awb(){
		$res['res'] =array(
			'spID'=>$this->input->post('spID')
		);
		$this->load->view('shipment/maintenance_awb_table',$res);
	}
}
