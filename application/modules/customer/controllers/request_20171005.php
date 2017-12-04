<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Request extends MY_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->module('app');
		$this->app->cek_permit();
    }

	public function index()
	{
		$this->cek_build_access(array(USER_SADMIN,USER_CUSTOMER,USER_SALES,USER_GMF_LNM));
		$arCmb=array(
			array('name'=>'incoterm','url'=>'app/incoterm'),
			array('name'=>'shipment_mode','url'=>'app/shipmentmode'),
			array('name'=>'request_type','url'=>'app/requestType'),
			array('name'=>'curency','url'=>'app/curency'),
			array('name'=>'pbth','url'=>'app/pbth'),
			array('name'=>'shipment_priority','url'=>'app/shp_priority')
		);
		$data['js_cmb']=$this->app->dropdown_kendo($arCmb);
		$this->template->title('Request Creation');
		$this->template->build('customer/request_view',$data);
	}


	function request_item(){
		$res 	= array();
		$id 	= $this->input->post('id');
		$uom	= array();

		if($id !=''){
			$this->load->model('customer/customer_model','mod_cust');
			$filter['request_id']=$id;
			$res = $this->mod_cust->reqeuestitem_get($filter);
			foreach($res as $key=>$val){
				$uom = current($this->mod_cust->get_uom(array('uom'=>$val->uom)));
				$res[$key]->uom = array('id'=>$uom->uomid, 'uom'=>$uom->uomid);
				$res[$key]->packaging = array('id'=>$val->packaging, 'packaging'=>$val->packaging);
				$res[$key]->cat_packaging = array('id'=>$val->goods_category, 'cat_packaging'=>$val->goods_category);
			}
		}

		echo json_encode(array('data'=>json_decode(json_encode($res))));
	}


	function proses(){
		$out['status'] = FALSE;
		$this->load->model('customer/customer_model','mod_cust');
		$pos_id 	= $this->input->post('id');
		$cur_id		= ($pos_id !='')?$pos_id : $this->app->getAutoId('request_id','lam_shipment_request','REQ');
		$mod		= ($pos_id !='')?'edit':'add';
		$weigh 		= 0;
		$foother 	= array();
		$ar_origin 		 = explode('-',$this->input->post('origin'));
		$ar_dest 			 = explode('-',$this->input->post('destination'));
		$ar_partner 	 = explode('-',$this->input->post('partner'));
		$req_mode 		 = array('IMPORT','EXPORT','DOMESTIC DISTRIBUTION');
		$req_type			 = $this->input->post('request_type');
		$user_req			 = $this->session->userdata('user');
		$ata 					 = $this->input->post('ata');
		$file 				 = $this->input->post('upload_file');
		$eid 					 = $this->input->post('eid');
		$eod 					 = $this->input->post('eod');
		$incoterm 		 = $this->input->post('incoterm');
		$shipment_mode = $this->input->post('shipment_mode');
		$req_date 		 = $this->input->post('date');
		$special_req 	 = $this->input->post('special_request');
		$shp_priority  = $this->input->post('shipment_priority');
		$shp_from			 = $this->input->post('shp_from');
		$shp_to				 = $this->input->post('shp_to');
		$payment_repo  = $this->input->post('paymen_res');
		$exsec_date		 = $this->input->post('eksec_date');
		$awb_number 	 = $this->input->post('awb');
		$req_des 			 = $this->input->post('request_desc');
		$cpo 					 = $this->input->post('cpo');
		$pbth 				= $this->input->post('pbth');

		do{
			if($req_type==''){
				$out['messages']='Please select Request Type';
				break;
			}

			if($req_type =='IMPORT' && $ar_partner[0] ==''){
				$out['messages']='Shiper Name can not be empty';
				break;
			}

			if(in_array($req_type,$req_mode) && $ar_origin[0] ==''){
				$out['messages']='Port Origin can not be empty';
				break;
			}

			if(in_array($req_type,$req_mode) &&  $ar_dest[0] ==''){
				$out['messages']='Port Destination can not be empty';
				break;
			}

			if($ar_origin[0] ==$ar_dest[0] && in_array($req_type,$req_mode)){
				$out['messages']='Port Origin should not be the same as Port Destination';
				break;
			}

			if(in_array($req_type,$req_mode) && $shipment_mode ==''){
				$out['messages']='Shipment Mode can not be empty';
				break;
			}

			if($req_type=='IMPORT' && $shp_priority ==''){
				$out['messages']='Shipment Priority can not be empty';
				break;
			}

			if(in_array($req_type,$req_mode)  && $incoterm ==''){
				$out['messages']='Incoterm can not be empty';
				break;
			}

			if($req_type =='EXPORT' && $ar_partner[0]=='' || $req_type =='DOMESTIC DISTRIBUTION' && $ar_partner[0]==''){
				$out['messages']='Consignee Name can not be empty';
				break;
			}

			if($req_type=='WAREHOUSE LEASE' && $eid==''){
				$out['messages']='Estimased Incoming Date can not be empty';
				break;
			}

			if($req_type=='WAREHOUSE LEASE' && $eod==''){
				$out['messages']='Estimased Outgoing  Date can not be empty';
				break;
			}

			if($req_type=='CUSTOM CLEARANCE' && $awb_number==''){
				$out['messages']='Awb Number can not be empty';
				break;
			}

			if($req_type=='CUSTOM CLEARANCE' && $awb_number==''){
				$out['messages']='Awb Number can not be empty';
				break;
			}

			if($req_type=='CUSTOM CLEARANCE' && $ata==''){
				$out['messages']='Estimate Time Arrival can not be empty';
				break;
			}



			if(in_array($req_type, $req_mode)){
				$hider=array(
					'request_id'=> $cur_id,
					'customer_id'=> $this->session->userdata('limit_id'),
					'partner_id'=> $ar_partner[0],
					'petugas_id'=> $user_req,
					'port_origin'=> $ar_origin[0],
					'port_dest'=> $ar_dest[0],
					'inco_term'=> $incoterm,
					'weight'=> $weigh,
					'status'=> 1,
					'pbth'=> 'No',
					'cpo'=> $cpo,
					'shipment_mode'=> $shipment_mode,
					'request_date'=> $req_date,
					'special_request'=> $special_req,
					'request_type'=> $req_type
				);

				if($req_type=='IMPORT')
					$hider['shp_priority'] = $shp_priority;

				if($pbth=='Yes' && $req_type=='IMPORT'){
					unset($hider['status']);
					unset($hider['pbth']);

					$hider['pbth'] ='Yes';
					$hider['status'] = 4;

					$hider['service_charges'] = 0;
					$hider['freight_charges'] = 0;
					$hider['transport_charges'] = 0;
					$hider['dg_charges'] = 0;
					$hider['cgx_charges'] = 0;
					$hider['curency_carges'] = 0;
					$hider['cgk_charges'] = 0;
					$hider['origin_charges'] = 0;
					$hider['destination_charges'] = 0;
					$hider['warehouse_charge'] = 0;
					$hider['packaging_charge'] = 0;
					$hider['fumigation_charge'] = 0;
					$hider['duty_charges'] = 0;
					$hider['allin_charges'] = 0;
					$hider['curency'] = 'IDR';
				}

			}else{
				$hider=array(
					'request_id'=> $cur_id,
					'customer_id'=> $this->session->userdata('limit_id'),
					'request_type'=> $req_type,
					'request_date'=> $req_date,
					'petugas_id'=> $user_req,
					'status'=> 1,
					'req_desc'=> $req_des
				);

				if($req_type=='INTERNAL DISTRIBUTION'){
					$hider['shp_from'] 		= $shp_from;
					$hider['shp_to']			= $shp_to;
					$hider['payment_res'] = $payment_repo;
					$hider['exsec_date']	= $exsec_date;
				}

				if($req_type=='WAREHOUSE LEASE'){
					$hider['eid'] = $eid;
					$hider['eod'] = $eod;
				}

				if($req_type=='CUSTOM CLEARANCE'){
					$hider['awb'] = $awb_number;
					$hider['ata'] = $ata;
					$hider['awb_file'] = $file;
				}

			}



			if($mod=='add'){
				$res = $this->mod_cust->reqeuest_add($hider);
			}

			if($mod=='edit'){
				unset($hider['request_id']);
				$filter['request_id']=$cur_id;
				$res = $this->mod_cust->request_edit($hider,$filter);
			}

			if($res==FALSE){
				$out['messages']='Gagal Memproses data';
				break;
			}

			if($res){
				$out['status']=TRUE;
				$out['messages']='Request berhasil diproses dengan id request <b>'.$cur_id.'</b>';
				$this->session->set_userdata(array('reqid'=>$cur_id));
				if($mod=='add')
					$this->request_notify($cur_id,$req_type);
				break;
			}

		}while(FALSE);

		echo json_encode($out);
	}

	function proses_item(){
		$this->load->model('customer/customer_model','mod_cust');
		$requestId 	= $this->session->userdata('reqid');
		$row_item 	= json_decode(json_encode(($this->input->post('models'))));
		$row_add	= array();

		foreach($row_item as $k=>$row){
			$part_number 	= isset($row->part_number)?$row->part_number:'';
			$part_desc 	= isset($row->part_desc)?$row->part_desc:'';
			$qty 				= isset($row->qty)?$row->qty:'';
			$uom 			= isset($row->uom->uom)?$row->uom->uom:'';
			$weight 			= isset($row->weight)?$row->weight:'0';
			$dimensi			= isset($row->dimensi)?$row->dimensi:'';
			$ponumber		= isset($row->ponumber)?$row->ponumber:'';
			$remark			= isset($row->remark)?$row->remark:'';
			$acregis			= isset($row->acregis)?$row->acregis:'';
			$paymentres	= isset($row->paymentres)?$row->paymentres:'';
			$value_of_goods= isset($row->value_of_goods)?$row->value_of_goods:'';
			$curency		= isset($row->curency)?$row->curency:'';
			$packaging		= isset($row->packaging->packaging)?$row->packaging->packaging:'';
			$cat_packaging= isset($row->cat_packaging->cat_packaging)?$row->cat_packaging->cat_packaging:'';

			$row_addx['request_id'] 		= $requestId;
			$row_addx['part_number'] 		= $part_number;
			$row_addx['part_desc'] 		= $part_desc;
			$row_addx['qty'] 					= $qty;
			$row_addx['uom'] 				= $uom;
			$row_addx['weight'] 			= $weight;
			$row_addx['dimensi'] 			= $dimensi;
			$row_addx['ponumber'] 		= $ponumber;
			$row_addx['remaark'] 			= $remark;
			$row_addx['acregis'] 			= $acregis;
			$row_addx['paymentres']		= $paymentres;
			$row_addx['value_of_goods']	= $value_of_goods;
			$row_addx['curency'] 			= $curency;
			$row_addx['packaging'] 		= $packaging;
			$row_addx['goods_category']= $cat_packaging;


			array_push($row_add,$row_addx);
		}

		$where['request_id']=$requestId;
		$this->mod_cust->reqeuestitem_delete($where);

		$this->mod_cust->reqeuestitem_add($row_add);
		$this->session->unset_userdata('reqid');
	}

	function proses_item_dua(){
		$this->load->model('customer/customer_model','mod_cust');
		$requestId 	= $this->session->userdata('reqid');
		$row_item 	= json_decode(json_encode(($this->input->post('models'))));
		$row_add	= array();
		foreach($row_item as $k=>$row){
			$part_number = isset($row->part_number)?$row->part_number:'';
			$part_desc = isset($row->part_desc)?$row->part_desc:'';
			$qty = isset($row->qty)?$row->qty:'0';
			$uom = isset($row->uom->uom)?$row->uom->uom:'';
			$cemical = isset($row->cemical->cemical)?$row->cemical->cemical:'';
			$remark = isset($row->remark)?$row->remark:'';

			$row_addx['request_id'] 	= $requestId;
			$row_addx['part_number'] 	= $part_number;
			$row_addx['part_desc'] 		= $part_desc;
			$row_addx['dimensi'] 			= $dimensi;
			$row_addx['qty'] 					= $qty;
			$row_addx['uom'] 					= $uom;
			$row_addx['remaark'] 			= $remark;
			$row_addx['material_type']= $cemical;

			array_push($row_add,$row_addx);
		}

		$where['request_id']=$requestId;
		$this->mod_cust->reqeuestitem_delete($where);

		$this->mod_cust->reqeuestitem_add($row_add);
		$this->session->unset_userdata('reqid');
	}

	function get(){
		$this->load->model('customer/customer_model','mod_cust');
		$res 		= array();
		$filter 	= array();
		$fitem 		= array();
		$resItem 	= array();
		$free_user 	= array(USER_SADMIN,USER_GMF,USER_SALES,USER_GMF_LNM);
		$id 		= ($this->input->post('id') !='')?$this->input->post('id'):'';
		$level 		= $this->session->userdata('level');

		if(!in_array($this->session->userdata('level'),$free_user))
			$filter['customer_id']=$this->session->userdata('limit_id');

		if($this->input->post('id') !=''){
			$filter['request_id IN("'.implode('","',explode(',',$this->input->post('id'))).'")']=NULL;
		}

		if($level ==USER_CUSTOMER && $id =='')
			$filter['status']=1;

		if($level==USER_SALES && $id =='')
			$filter['status in ("1","2","3","6")']=NULL;

			if($level==USER_GMF_LNM)
				$filter['status in ("6")']=NULL;

		$res = $this->mod_cust->request_get($filter);
		$res = array_merge($res,$this->mod_cust->request_get2($filter));

		if($this->input->post('id') !=''){
			foreach($res as $key=>$row){
				$fitem['request_id']=$row->id;
				$res[$key]->item = $this->mod_cust->reqeuestitem_get($fitem);
			}
		}

		echo json_encode(array('data'=>$res));
	}

	function reject(){
		$id = explode(',',$this->input->post('id'));
		$this->load->model('customer/customer_model','mod_cust');
		$out['status']=FALSE;
		$cek_stat = true;

		do{

			foreach($id as $c_id){
				$cek = $this->mod_cust->request_status($c_id);
				if($cek==false){
					$cek_stat = false;
					$rekId = $c_id;
					break;
				}
			}

			if($cek_stat==false){
				$out['messages'] ='Reject gagal, Cek status Request Id ('.$rekId.')';
				break;
			}

			$data		= array('status'=>4);
			$filter['request_id IN("'.implode('","',$id).'")']=NULL;
			$res = $this->mod_cust->request_edit($data,$filter);
			if($res){
				$out['status']=TRUE;
				$out['messages'] = 'Request Id ('.implode(',',$id).') Berhasil di reject';
			}else
				$out['messages'] = 'Gagal Mereject Data';

		}while(FALSE);

		echo json_encode($out);
	}

	private function request_notify($reqeust_id,$jenis){
		$mail_to 	= $this->config->item('mail_notify_csm');

		$data['jenis_transaksi'] = $jenis;
		$data['request_no'] 	 = $reqeust_id;
		$data['proses_user'] 	 = $this->session->userdata('limit_id');
		$data['proses_user_name']= str_replace('|',' ',$this->session->userdata('real_name'));

		$mail_sbj 	= 'GMF SYSTEM - Notify request id '.$reqeust_id;
		$mail_msg	= $this->load->view('app/mail_templates_sales_notify',$data,TRUE);

		$this->app->send_mail($mail_to,$mail_sbj,$mail_msg,TRUE);
	}



	/* function add_items(){
		$out['status'] =FALSE;
		$item = $this->input->post('item');
		$weigh= $this->input->post('weight_item');
		$res  = ($this->session->userdata('requestItem') !='')?$this->session->userdata('requestItem') : array();
		$dataId = count($res);

		do{
			/if($item==''){
				$out['messages'] ='No Item to add';
				break;
			}

			if(!is_numeric($weigh)) {
				$out['messages'] ='Weight : Please insert number only';
				break;
			}

			if($item==''){
				$out['messages'] ='Weight harus diisi';
				break;
			}

			if($dataId > 0){
				$data[]=array(
					'id'=>$dataId,
					'item'=> $item,
					'weigh'=>$weigh
				);
				foreach($res as $value){
					$dsx['id']=$value['id'];
					$dsx['item']=$value['item'];
					$dsx['weigh']=$value['weigh'];

					array_push($data,$dsx);
				}
				$this->session->unset_userdata('requestItem');

				$this->session->set_userdata(array('requestItem'=>$data));
			}else{
				$data[$dataId]=array(
					'id'=>$dataId,
					'item'=> $item,
					'weigh'=>$weigh
				);
				$this->session->set_userdata(array('requestItem'=>$data));
			}
			$out['status'] =TRUE;
		}while(FALSE);
		echo json_encode($out);
	} */
}
