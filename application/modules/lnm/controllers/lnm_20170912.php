<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lnm extends MY_Controller {


	public function __construct(){
        parent::__construct();
				$this->load->module('app');
				$this->app->cek_permit();
    }

	public function index()
	{
		$this->cek_build_access(explode(',',USER_GMF_LNM));
		$arCmb=array(
			array('name'=>'curency','url'=>'app/curency'),
			array('name'=>'pbth','url'=>'app/pbth')
		);
		$data['js_cmb']=$this->app->dropdown_kendo($arCmb);

		$this->template->title(lang('title_lnm'));
		$this->template->build('lnm/lnm_view',$data);
	}

	function edit_assign(){
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
			'pbth'					 		=> $pbth,
			'curency'						=> $curency,
			'asigmen_date'			=> date('Y-m-d'),
			'service_charges'		=> $service,
			'freight_charges'		=> $freight,
			'transport_charges'	=> $transport,
			'dg_charges'				=> $dg,
			'cgx_charges'				=> $cgx,
			'curency_carges'		=> $curency_crg,
			'cgk_charges'				=> $cgk,
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

			if($total <=0){
				$out['messages'] = lang('msg_sls_nozero');
				break;
			}

			if($request_id==''){
				$out['messages'] = 'Galat Sistem';
				break;
			}

			$filter['request_id'] = $request_id;
			//$filter['sales_id IS NULL']=NULL;
			$res = $this->mod_sls->assign($data,$filter);
			if($res){
				$out['status']=TRUE;
				$out['messages']= lang('msg_sls_asgedit_ok').' <b>'.$request_id.'</b>';
				break;
			}
		}while(FALSE);
		echo json_encode($out);
	}

}
