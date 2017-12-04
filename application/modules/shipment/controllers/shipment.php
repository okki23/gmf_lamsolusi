<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shipment extends MY_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->module('app');
		$this->app->cek_permit();
    }

	public function index()
	{
		$this->cek_build_access(array(USER_PARTNER,USER_GMF,USER_GMF_RECEIVING,USER_GMF_IMPORT));

		$this->template->title(lang('titile_srq'));
		$this->template->build('shipment/request_view');
	}


	function get(){
		$res 	= array();
		$filter = array();
		$fitem = array();
		$resItem = array();
		$this->load->model('customer/customer_model','mod_cust');
		$this->load->model('master/forwarder_model','mod_fwd');


		$free_user = array(USER_SADMIN,USER_GMF,USER_SALES,USER_GMF_RECEIVING,USER_GMF_IMPORT);

		if(!in_array($this->session->userdata('level'),$free_user))
			$filter['customer_id']=$this->session->userdata('limit_id');

		if($this->input->post('id') !=''){
			$filter['request_id IN("'.implode('","',explode(',',$this->input->post('id'))).'")']=NULL;
		}

		$filter['forwarder_id IS NULL'] = NULL;
		$filter['status']=4;

		$res = $this->mod_cust->request_get($filter);
		$fwd = $this->mod_fwd->get();

		foreach($res as $key=>$row){
			foreach($fwd as $rfwd){
				if($rfwd->id ==$row->forwarder_id)
					$res[$key]->forwarder_name = $rfwd->nama_forwrder;
			}
		}

		if($this->input->post('id') !=''){
			foreach($res as $key=>$row){
				$fitem['request_id']=$row->id;
				$res[$key]->item = $this->mod_cust->reqeuestitem_get($fitem);
			}
		}

		echo json_encode(array('data'=>$res));
	}

	function proses(){
		$this->load->model('customer/customer_model','mod_cust');
		$requestid = explode(',',$this->input->post('requestid_all'));
		$forwarder = explode('-',$this->input->post('forwarder'));
		$out['status'] =FALSE;
		$data = array( 'forwarder_id'=>$forwarder[0] );
		do{

			if($forwarder==''){
				$out['messages'] = lang('msg_shp_fwdnull');
				break;
			}

			if($requestid==''){
				$out['messages'] = lang('msg_shp_requestid');
				break;
			}

			$where['request_id IN("'.implode('","',explode(',',$this->input->post('requestid_all'))).'")']=NULL;
			$where['status']=4;
			$res = $this->mod_cust->request_edit($data,$where);
			$out['status'] = $res;
			if($res)
				$out['messages'] = lang('msg_process_ok');
			else
				$out['messages']= lang('msg_process_no');
		}while(FALSE);
		echo json_encode($out);
	}

	function generatesp(){
		$this->cek_build_access(array(USER_PARTNER,USER_GMF,USER_GMF_RECEIVING,USER_GMF_IMPORT));

		$this->template->title(lang('title_gsp'));
		$this->template->build('shipment/sp_view');
	}

	function get_awb_sp(){
		$res = ($this->session->userdata('awbrow') !='')?$this->session->userdata('awbrow') :array();
		echo json_encode(array('data'=>$res));
	}

	function add_awb_sp(){
		$this->load->model('shipment/shipment_model','mod_shp');
		$awb 	= $this->input->post('awb');
		$res  	= ($this->session->userdata('awbrow') !='')?$this->session->userdata('awbrow') : array();
		$dataId = count($res);
		$out['status']=FALSE;
		$no		= 0;
		do{
			if($awb ==''){
				$out['messages'] = lang('msg_shp_awb');
				break;
			}

			$filter['awb']=$awb;
			$row = $this->mod_shp->cek_awb($filter);
			if(count($row) <=0){
				$out['messages'] = lang('msg_shp_awbnotfound');
				break;
			}

			$row = current($row);
			if($row->sp_id !=''){
				$out['messages'] = lang('msg_shp_awbsend');
				break;
			}

			$where['request_id IN ("'.implode('","',explode(",",$row->reference)).'")'] =NULL;
			$res_x = $this->mod_shp->request_type($where,TRUE);
			if($res_x->request_type !='EXPORT' && $res_x->request_type !='DOMESTIC DISTRIBUTION'){
				if($row->awb_status =='Open'){
					$out['messages'] = lang('msg_shp_awbin_open');
					break;
				}

				if($row->bc_date =='' || $row->bc_date =='null'){
					$out['messages'] = 'BC Date masih dalam proses';
					break;
				}

				if($row->bc_no =='' || $row->bc_no =='null'){
					$out['messages'] = 'BC Number masih dalam proses';
					break;
				}
			}

			if($dataId > 0){
				$data[]=array(
					'no'=>$no++,
					'awb'=>$row->awb,
					'ata_date'=> $row->ata_date,
					'bc_number'=>$row->bc_no,
					'bc_date'=>$row->bc_date
				);
				foreach($res as $value){
					$dsx['no']=$no++;
					$dsx['awb']=$value['awb'];
					$dsx['ata_date']=$value['ata_date'];
					$dsx['bc_number']=$value['bc_number'];
					$dsx['bc_date']=$value['bc_date'];

					array_push($data,$dsx);
				}
				$this->session->unset_userdata('awbrow');

				$this->session->set_userdata(array('awbrow'=>$data));
			}else{
				$data[$dataId]=array(
					'no'=>$no,
					'awb'=>$row->awb,
					'ata_date'=> $row->ata_date,
					'bc_number'=>$row->bc_no,
					'bc_date'=>$row->bc_date
				);
				$this->session->set_userdata(array('awbrow'=>$data));
			}

			$out['status']	=TRUE;
			$out['messages']= 'Data berhasil disimpan';
		}while(FALSE);
		echo json_encode($out);
	}


	function delete_awb_sp(){
		$row = $this->session->userdata('awbrow');
		$delId = $this->input->post('id');
		$no		= 0;
		$data = array();

		foreach($row as $k=>$v)
			if($k ==$delId)
				unset($row[$k]);


		if (count($row) >0){
			foreach ($row as $key => $value) {
				$data[]=array(
					'no'=>$no++,
					'awb'=> $value['awb'],
					'ata_date'=> $value['ata_date'],
					'bc_number'=> $value['bc_number'],
					'bc_date'=> $value['bc_date']
				);
			}
		}
		$this->session->unset_userdata('awbrow');
		$this->session->set_userdata(array('awbrow'=>$data));
		$out['status']	= TRUE;

		echo json_encode($out);
	}

	function generatesp_add(){
		$this->load->model('shipment/shipment_model','mod_shp');
		$spid 			= $this->app->getAutoId('sp_id',"lam_shipment_sp",'SPO');
		$out['status']	=FALSE;
		$awb_row 		= $this->session->userdata('awbrow');
		//$awb_in 		= array();

		$data = array(
			'sp_id' => $spid,
			'date' => $this->input->post('date'),
			'periode_ata' => $this->input->post('ata'),
			'delivery_to' => $this->input->post('delivery'),
			'status' => 1
		);

		do{
			if($this->input->post('date')==''){
				$out['messages']='SP Date haru diisi ';
				break;
			}

			$res = $this->mod_shp->sp_add($data);
			$out['status']	=$res;
			if($res){
				$out['messages']= lang('msg_process_ok').'  No. <b>'.$spid.'</b>';
				$out['spid']=$spid;
				$data_detail = array('sp_id'=>$spid);
				foreach($awb_row as $row)
					$awb_in[] = $row['awb'];

				$filter['awb IN("'.implode('","',$awb_in).'")']=NULL;
				$this->mod_shp->edit($data_detail,$filter);
				$this->session->unset_userdata('awbrow');
			}else
				$out['messages']=lang('msg_process_no');

		}while(FALSE);
		echo json_encode($out);
	}

	function get_sp(){
		$this->load->model('shipment/shipment_model','mod_shp');
		$res=$this->mod_shp->get_sp();
		echo json_encode(array('data'=>$res));
	}

	function sp_confirm(){
		$this->load->model('shipment/shipment_model','mod_shp');
		$id = $this->input->post('id');

		$filter['sp_id']=$id;
		$res = $this->mod_shp->get($filter);
		echo json_encode(array('data'=>$res));
	}

	function sp_confirm_proses(){
		$this->load->model('shipment/shipment_model','mod_shp');
		$awbid = $this->input->post('spcek_awbid');
		$spid  = $this->input->post('sp_id');
		$out['status']   = FALSE;
		do{
			if(!$awbid){
				$out['messages'] = lang('msg_validate_awab');
				break;
			}

			$data_uncek = array('sp_cek'=>0);
			$data_cek 	= array('sp_cek'=>1);

			$filter['sp_id']=$spid;
			$this->mod_shp->edit($data_uncek,$filter);

			$filter['awb IN("'.implode('","',$awbid).'")']=NULL;
			$this->mod_shp->edit($data_cek,$filter);

			$filterSP['sp_cek'] = 0;
			$filterSP['sp_id']	= $spid;
			$res_cek = $this->mod_shp->get($filterSP);

			if(count($res_cek) <= 0){
				$this->mod_shp->sp_edit(
					array('status'=>'2'),
					array('sp_id'=>$spid)
				);
			}else{
				$res_notify= $this->mod_shp->notify_approve($awbid);
				foreach($res_notify as $row){
					$mail_to 	= $row->email;

					//$data['awb_number'] 	= '';
					$data['request_no'] 	 		= $row->req_id;
					$data['proses_user'] 	 	= $this->session->userdata('user');
					$data['proses_user_name']= str_replace('|',' ',$this->session->userdata('real_name'));

					$mail_sbj 	= 'GMF SYSTEM - Notify Reciving Request Id ('.$row->req_id.')';
					$mail_msg	= $this->load->view('app/mail_templates_notive_recive',$data,TRUE);

					$this->app->send_mail($mail_to,$mail_sbj,$mail_msg,TRUE);
				}
			}
			

			$out['status']   = TRUE;
		}while(FALSE);
		echo json_encode($out);
	}

	function sp_enc(){
		$this->load->library('encrypt');
		echo  $this->encrypt->encode($this->input->post('id'));
	}

	function sp_print(){
		$this->load->library('encrypt');
		$this->load->model('shipment/shipment_model','mod_shp');
		$sp_id =  $this->encrypt->decode($this->uri->segment(3));

		$sp_filter['sp_id']=$sp_id;
		$res_sp = current($this->mod_shp->get_sp($sp_filter));

		$date=date_create($res_sp->date);

		$awb_filter['sp_id']=$sp_id;

		$data['sp_no'] 		= $sp_id;
		$data['sp_date'] 	= date_format($date,"d F Y");
		$data['ata'] 		= $res_sp->periode_ata;
		$data['to'] 		= $res_sp->delivery_to;
		$data['awb'] 		= $this->mod_shp->get($awb_filter);

		$this->load->view('shipment/sp_print',$data);
	}

	function shipment_item(){
		$this->load->model('shipment/shipment_model','mod_shp');
		$awb_in = explode(',',$this->input->post('id'));

		$filter['awb IN("'.implode('","',$awb_in).'")']=NULL;
		$res=$this->mod_shp->get_shipment_item($filter);

		foreach($res as $key=>$value){
			//$where['request_id IN ("'.implode('","',explode(",",$value->reference)).'")'] =NULL;
			$where['request_id IN ("'.implode('","',explode(",",$value->request_id)).'")'] =NULL;
			//print_r($where);
			$res_x = $this->mod_shp->request_type($where,TRUE);
			$res[$key]->type = $res_x->request_type;
			unset($where);
		}

		echo json_encode(array('data'=>$res));
	}

	function shipment_cek_status_sp(){
		$this->load->model('shipment/shipment_model','mod_shp');
		$id 		= $this->input->post('spid');
		$status = 'FALSE';

		$filter['sp_id'] 	= $id;
		$filter['status'] = 1;
		$res = $this->mod_shp->get_sp($filter);

		if(count($res) > 0)
			$status='TRUE';

		echo $status;
	}

	function getClearAwb(){
		$res = array();
		$filter = array();
		$this->load->model('shipment/shipment_model','mod_shp');


		$filter['sp_id is NULL'] = NULL;
		$filter['awb_status = "Clear"'] = NULL;

		$res = $this->mod_shp->get($filter);

		foreach($res as $key=>$value){
			$where['request_id IN ("'.implode('","',explode(",",$value->reference)).'")'] =NULL;
			$res_x = $this->mod_shp->request_type($where,TRUE);
			$res[$key]->type = $res_x->request_type;

			if($res_x->request_type=='EXPORT' || $res_x->request_type=='DOMESTIC DISTRIBUTION'){
				if($res[$key]->ata_date !='-' && $res[$key]->atd_date !='-' && $res[$key]->flight_schadule !='-')
					unset($res[$key]);
			}

			unset($where);
		}
		echo json_encode(array('data'=>$res));
	}

}
