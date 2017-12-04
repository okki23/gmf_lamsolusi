<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales extends MY_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->module('app');
		$this->app->cek_permit();
    }

	public function index()
	{
		$this->cek_build_access(array(USER_SALES,USER_GMF,USER_SADMIN));
		$data['act_type'] = $this->config->item('service');

		$this->template->title(lang('title_act'));
		$this->template->build('sales/sales_view',$data);
	}

	function acktifity_proses(){
		$this->load->model('sales/sales_model','mod_sls');
		$out['status'] = FALSE;
		$id 	='';
		$mode 	='';
		$res	= FALSE;
		$ar_cusid= explode('-',$this->input->post('customer'));

		if($this->input->post('id') !=''){
			$id = $this->input->post('id');
			$mode='edit';
		}else{
			$mode='add';
			$this->load->module('app');
			$id = $this->app->getAutoId('actifity_id','lam_salesact','ACT');
		}

		$data=array(
			'actifity_id'=>$id,
			'sales_id'=>$this->session->userdata('limit_id'),
			'customer_id'=>$ar_cusid[0],
			'type'=>$this->input->post('actifity'),
			'status'=>1,
			'remark'=>$this->input->post('remarks'),
			'actifity_start'=>$this->input->post('date')
		);

		do{
			if($id==''){
				$out['messages']= lang('msg_sls_nocusid');
				break;
			}

			if($this->input->post('actifity')==''){
				$out['messages']=lang('msg_sls_noact');
				break;
			}


			if($mode=='add')
				$res = $this->mod_sls->acktifity_add($data);
			else{
				unset($data['actifity_id']);
				$filter['actifity_id']=$id;
				$res = $this->mod_sls->acktifity_edit($data,$filter);
			}


			$out['status'] = $res;
			if($res)
				$out['messages'] = lang('msg_process_ok');
			else
				$out['messages']=lang('msg_process_no');

		}while(FALSE);

		echo json_encode($out);
	}

	function acktifity_get(){
		$res = array();
		$this->load->model('sales/sales_model','mod_sls');
		$this->load->model('customer/customer_model','mod_cst');
		$sales_id = $this->session->userdata('limit_id');
		$user_type = $this->session->userdata('level');
		$user_free = array(USER_SADMIN,USER_GMF);

		if(!in_array($user_type,$user_free) && $user_type==USER_SALES)
			$filter['sales_id']=$sales_id;
		//$filter['status']=1;

		if($this->input->post('id') !='')
			$filter['actifity_id']=$this->input->post('id');

		$act = $this->mod_sls->get_act($filter);
		$cst_ar = $this->mod_cst->get();

		foreach($act as $k=>$actifity){
			foreach($cst_ar as $customer)
				if($customer->id==$actifity->customer_id)
					$act[$k]->cst_name = $customer->customer;
			$act[$k]->status =($act[$k]->status==1)?'Open':'Close';
		}

		echo json_encode(array('data'=>$act));
	}

	function assign(){
		$this->load->model('sales/sales_model','mod_sls');
		$request_id = $this->input->post('id');
		$service		= $this->input->post('service_charges');
		$freight		= $this->input->post('freight_charges');
		$transport	= $this->input->post('transport_charges');
		$dg					= $this->input->post('dg_charges');
		$cgx				= $this->input->post('cgx_charges');
		$curency_crg= $this->input->post('curency_carges');
		$curency		= $this->input->post('curency');
		$pbth 			= $this->input->post('pbth');
		$cgk				= $this->input->post('cgk_handling');
		$origin			= $this->input->post('origin_charge');
		$destination= $this->input->post('dest_charges');
		$warehouse	= $this->input->post('warehouse_charge');
		$packaging	= $this->input->post('packaging_charge');
		$fumigation	= $this->input->post('fumigation_charge');
		$duty_tax		= $this->input->post('duty_charge');
		$allin			= $this->input->post('allin_charge');



		$out['status']= FALSE;

		$data = array(
			'sales_id'					=> $this->session->userdata('limit_id'),
			'status'				 		=> 2,
			//'pbth'					 		=> $pbth,
			'curency'						=> $curency,
			'asigmen_date'			=> date('Y-m-d'),
			'service_charges'		=> $service,
			'freight_charges'		=> $freight,
			'transport_charges'	=> $transport,
			'dg_charges'			=> $dg,
			'cgx_charges'			=> $cgx,
			'curency_carges'		=> $curency_crg,
			'cgk_charges'			=> $cgk,
			'origin_charges'		=> $origin,
			'destination_charges'=> $destination,
			'warehouse_charge' 	=> $warehouse,
			'packaging_charge'	=> $packaging,
			'fumigation_charge'	=> $fumigation,
			'duty_charges'			=> $duty_tax,
			'allin_charges'			=> $allin
		);

		do{

			$total = ($service+0)+ ($freight+0)+ ($transport+0) + ($dg+0) + ($cgx+0);
			$total += ($curency_crg+0) + ($cgk+0) + ($origin+0) + ($destination+0);
			$total += ($warehouse+0)+ ($packaging+0)+ ($fumigation+0);
			$total += ($duty_tax+0)+ ($allin+0);

			if($total <=0 && $pbth=='No'){
				$out['messages'] = lang('msg_sls_nozero');
				break;
			}

			if($curency=='' || $curency=='-1'|| $curency=='0'){
				$out['messages'] = lang('msg_sls_curency');
				break;
			}


			if($request_id==''){
				$out['messages'] = 'Galat Sistem';
				break;
			}

			$filter['request_id'] = $request_id;
			$res = $this->mod_sls->assign($data,$filter);
			if($res){
				$out['status']=TRUE;
				$out['messages']=lang('msg_sls_asign_ok').' <b>'.$request_id.'</b>';
				$this->notify_assign($request_id);
				break;
			}
		}while(FALSE);
		echo json_encode($out);
	}

	function edit_assign(){
		$this->load->model('sales/sales_model','mod_sls');
		$request_id = $this->input->post('id');
		$service	= $this->input->post('service_charges');
		$freight	= $this->input->post('freight_charges');
		$transport	= $this->input->post('transport_charges');
		$dg			= $this->input->post('dg_charges');
		$cgx		= $this->input->post('cgx_charges');
		$curency_crg= $this->input->post('curency_carges');
		$curency	= $this->input->post('curency');
		$pbth 		= $this->input->post('pbth');
		$cgk				= $this->input->post('cgk_handling');
		$origin			= $this->input->post('origin_charge');
		$destination= $this->input->post('dest_charges');
		$warehouse	= $this->input->post('warehouse_charge');
		$packaging	= $this->input->post('packaging_charge');
		$fumigation	= $this->input->post('fumigation_charge');
		$duty_tax		= $this->input->post('duty_charge');
		$allin			= $this->input->post('allin_charge');

		$out['status']= FALSE;

		$data = array(
			'sales_id'				=> $this->session->userdata('limit_id'),
			'status'					=> 2,
			'service_charges'		=> $service,
			'freight_charges'		=> $freight,
			'transport_charges'	=> $transport,
			'dg_charges'			=> $dg,
			'pbth'						=> $pbth,
			'cgx_charges'			=> $cgx,
			'curency_carges'		=> $curency_crg,
			'curency'				=> $curency,
			'asigmen_date'			=> date('Y-m-d'),
			'cgk_charges'			=> $cgk,
			'origin_charges'		=> $origin,
			'destination_charges'=> $destination,
			'warehouse_charge' 	=> $warehouse,
			'packaging_charge'	=> $packaging,
			'fumigation_charge'	=> $fumigation,
			'duty_charges'			=> $duty_tax,
			'allin_charges'			=> $allin
		);

		do{

			$total = ($service+0)+ ($freight+0)+ ($transport+0) + ($dg+0) + ($cgx+0);
			$total += ($curency_crg+0) + ($cgk+0) + ($origin+0) + ($destination+0);
			$total += ($warehouse+0)+ ($packaging+0)+ ($fumigation+0);
			$total += ($duty_tax+0)+ ($allin+0);

			if($total <=0 && $pbth=='No'){
				$out['messages'] = lang('msg_sls_nozero');
				break;
			}

			if($curency=='' || $curency=='-1'|| $curency=='0'){
				$out['messages'] = lang('msg_sls_curency');
				break;
			}
			
			if($request_id==''){
				$out['messages'] = 'Galat Sistem';
				break;
			}

			$filter['request_id'] = $request_id;
			$res = $this->mod_sls->assign($data,$filter);
			if($res){
				$out['status']=TRUE;
				$out['messages']= lang('msg_sls_asgedit_ok').' <b>'.$request_id.'</b>';
				break;
			}
		}while(FALSE);
		echo json_encode($out);
	}

	function acktifity_delete(){
		$this->load->model('sales/sales_model','mod_sls');
		$id = explode(',',$this->input->post('id'));

		$filter['actifity_id IN("'.implode('","',$id).'")']=NULL;
		$this->mod_sls->acktifity_hapus($filter);
		echo json_encode(array('status'=>TRUE));
	}

	function acktifity_item_proses(){
		$out['status']= FALSE;
		$this->load->model('sales/sales_model','mod_sls');
		$act_id = $this->input->post('act_id_onsub');
		$time = str_replace(' ', '',$this->input->post('hours'));
		$data=array(
			'actifity_id' 	=> $act_id,
			'actifity_date' => $this->input->post('date'),
			'description'  	=> $this->input->post('actifity'),
			'actifity_time' => $time
		);

		do{
			$res = $this->mod_sls->add_act_sub($data);

			$out['status'] = $res;
			if($res){
				$out['status']=TRUE;
				$out['messages']='Follow Up Activity <b>'.$act_id.'</b> berhasil disimpan.';
				break;
			}
		}while(FALSE);
		echo json_encode($out);
	}

	function acktifity_close(){
		$id = $this->input->post('id');
		$this->load->model('sales/sales_model','mod_sls');
		$out['status']= FALSE;
		do{
			$filter['actifity_id IN("'.implode('","',explode(',',$id)).'")']=NULL;
			$res = $this->mod_sls->acktifity_edit(
						array('status'=> 2 ),$filter
					);

			$out['status'] = $res;
			if($res){
				$out['status']	= TRUE;
				$out['messages']='Activity <b>'.$id.'</b> berhasil diproses.';
				break;
			}else
				$out['messages']='Activity <b>'.$id.'</b> sudah di close.';
		}while(FALSE);
		echo json_encode($out);
	}


	function actifity_sub_table(){
		$res['res'] =array(
			'id'=>$this->input->post('id')
		);
		$this->load->view('sales/sales_subact',$res);
	}

	function actifity_sub(){
		$this->load->model('sales/sales_model','mod_sls');

		$filter['actifity_id']=$this->input->post('id');
		$res = $this->mod_sls->get_actifity_sub($filter);
		echo json_encode(array('data'=>$res));
	}

	private function notify_assign($request_id){
		$this->load->model('customer/customer_model','mod_cust');
		$this->load->model('sales/sales_model','mod_sales');

		$where['r.request_id']=$request_id;
		$res	 	= current($this->mod_cust->customer_request($where));
		$res_sales	= current($this->mod_sales->get( array('id_sales'=>$this->session->userdata('limit_id'))));

		$data['jenis_transaksi'] = $res->request_type;
		$data['customer'] 		 = str_replace('|',' ',$res->nama_petugas);
		$data['request_no'] 	 = $res->request_id;

		$data['proses_user_name']= str_replace('|',' ',$res_sales->sales);
		$data['sales_email'] 	 = $res_sales->email;
		$data['proses_user'] 	 = $res_sales->id;
		$data['sales_phone'] 	 = $res_sales->phone;

		$mail_to 	= $res->email_petugas;
		$mail_sbj 	= 'GMF SYSTEM - Notify request id '.$res->request_id;
		$mail_msg	= $this->load->view('app/mail_templates_customer_notify',$data,TRUE);

		$this->app->send_mail($mail_to,$mail_sbj,$mail_msg);
	}

	function send_lnm(){
		$out['status']= FALSE;
		$req_id = $this->input->post('id');
		$this->load->model('sales/sales_model','mod_sales');

		do{
			$filter['request_id'] = $req_id;
			$data['status'] = 6;
			$res = $this->mod_sales->sendto_lnm($data,$filter);

			if($res){
					$out['status'] = TRUE;
					$out['messages'] = lang('msg_asg_lnm_sucess');
					$this->lnm_notify($req_id);
			}else
				$out['messages'] = lang('msg_asg_lnm_failed');

		}while (FALSE);

		echo json_encode($out);
	}

	private function lnm_notify($reqeust_id){
		$this->load->model('user/user_model','mod_petugas');
		$res = $this->mod_petugas->get_all(
			array('jenis_petugas'=>USER_GMF_LNM)
		);
		$mail_to = array();
		foreach($res as $row){
			$mail_to[]=$row->email;
		}

		//$mail_to 	= $this->config->item('mail_notify_csm');
		//$data['jenis_transaksi'] = $jenis;
		$data['request_no'] 	 = $reqeust_id;
		$data['proses_user'] 	 = $this->session->userdata('limit_id');
		$data['proses_user_name']= str_replace('|',' ',$this->session->userdata('real_name'));
		$mail_sbj 	= 'GMF SYSTEM - Notify request Id.'.$reqeust_id;
		$mail_msg	= $this->load->view('app/mail_templates_lnm_notify',$data,TRUE);

		$this->app->send_mail($mail_to,$mail_sbj,$mail_msg);
	}




}
