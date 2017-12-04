<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance extends MY_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->module('app');
		$this->app->cek_permit();
    }

	public function index()
	{
		$this->cek_build_access(array(USER_GMF,USER_PARTNER));

		$this->template->title(lang('title_shp'));
		$this->template->build('shipment/maintenance_view');
	}

	function add(){
		$this->load->model('shipment/shipment_model','mod_shp');
		$out['status'] = FALSE;
		$awb_no 		= $this->input->post('awb');
		$reference		= $this->input->post('reference');
		$ata_date		= $this->input->post('date_ata');
		$atd_date		= $this->input->post('date_atd');
		$kilo_colli		= $this->input->post('kilo_colli');
		$port_origin	= explode('-',$this->input->post('origin'));
		$port_dest		= explode('-',$this->input->post('destination'));
		$flight_schadule= $this->input->post('schadule');
		$res			= FALSE;
		$detail			= array();
		$data=array(
			'awb'=> $awb_no,
			'reference'=> $reference,
			'kilo_colli'=> $kilo_colli,
			'forwarder_id'=> $this->session->userdata('limit_id'),
			'eta_date'=> $ata_date,
			'etd_date'=> $atd_date,
			'port_origin'=> $port_origin[0],
			'port_dest'=> $port_dest[0],
			'estimate_flight_schadule'=> $flight_schadule
		);

		$data_update = array('awb'=>$awb_no);

		do{

			if($awb_no==''){
				$out['messages'] = lang('msg_shp_awb');
				break;
			}

			$filter['awb']=$awb_no;
			$cres = $this->mod_shp->get($filter);
			if(count($cres)>0){
				$out['messages'] = lang('msg_shp_awbinuse');
				break;
			}

			if($port_origin[0] ==''){
				$out['messages'] = lang('msg_shp_origin');
				break;
			}

			if($port_dest[0] ==''){
				$out['messages'] = lang('msg_shp_dest');
				break;
			}

			if($port_origin[0] == $port_dest[0]){
				$out['messages'] = lang('msg_shp_origindest');
				break;
			}

			if(!isset($_POST['item_id'])){
				$out['messages'] = lang('msg_shp_noitem');
				break;
			}

			$item_cek 	= TRUE;
			$reqid_full = array();
			foreach ($_POST['part_number'] as $key=>$name) {
			  if(isset($_POST['item_id'][$key])){
					$qar['item_id'] 	 = $_POST['item_id'][$key];
					$qar['request_id'] = $_POST['request_id'][$key];

					$qty_send 			= $this->mod_shp->sum_sending_item($qar);
					$qty_send_total = $qty_send + $_POST['qty'][$key];
					$qty_requst 		= $this->mod_shp->sum_request_item($qar);
					$qty_bonus			= $_POST['bonus'][$key];

					if($qty_send_total > $qty_requst && $qty_bonus =='no'){
						$item_cek = FALSE;
						$reqid_full[] = $_POST['request_id'][$key].'-'.$_POST['item_id'][$key];
					}
					  $detailX['item_id'] 		= $_POST['item_id'][$key];
					  $detailX['awb'] 				= $awb_no;
					  $detailX['request_id'] 	= $_POST['request_id'][$key];
					  $detailX['part_number']	= $_POST['part_number'][$key];
					  $detailX['part_desc'] 	= $_POST['part_desc'][$key];
					  $detailX['qty'] 				= $_POST['qty'][$key];
					  $detailX['weight'] 			= $_POST['weight'][$key];
					  $detailX['uom'] 				= $_POST['uom'][$key];
					  $detailX['dimensi']			= $_POST['dimensi'][$key];

					  array_push($detail,$detailX);
			  }
			}

			if(!$item_cek){
				$item = implode(",",$reqid_full);
				$out['messages'] =lang('msg_shp_oferqty').", ".$item;
				break;
			}

			$res = $this->mod_shp->add($data);
			$out['status']=$res;

			if($res){
				$out['messages'] =  lang('msg_shp_proses_ok').' <b>'.$awb_no.'</b>';
				$this->mod_shp->add_item($detail);

				$ar_cekDone = explode(',',$reference);
				foreach ($ar_cekDone as $key => $value) {
					$this->cek_isdone_request($value);
				}
				/* $this->load->model('customer/customer_model','mod_cust');
				$where['request_id IN("'.implode('","',explode(',',$reference)).'")']=NULL;
				$this->mod_cust->request_edit($data_update,$where); */
			}else
				$out['messages'] = lang('msg_shp_proses_no').' <b>'.$awb_no.'</b>';

		}while(false);
		echo json_encode($out);
	}

	function cek_isdone_request($request_id){
		$this->load->model('shipment/shipment_model','mod_shp');
		$this->db_cek = $this->load->database('default',TRUE);
		$req_clear = 0;

		$where['request_id'] = $request_id;
		$res_req = $this->mod_shp->sum_request_item($where,TRUE);
		$res_send = $this->mod_shp->sum_sending_item($where,TRUE);

		foreach($res_req as $key=>$val){
			foreach ($res_send as $record) {
				if($val->item_id == $record->item_id && $val->qty <= $record->qty)
					$req_clear++;
			}
		}

		$data = array('status'=>7);
		if(count($res_req) <= $req_clear){
			$this->load->model('customer/customer_model','mod_cust');
			$this->mod_cust->request_edit(
				array('status'=>7),
				array('request_id'=>$request_id)
			);
		}
	}

	function getReference(){
		$this->load->model('shipment/shipment_model','mod_shp');
		$limit 	= $this->session->userdata('limit_id');
		$origin = explode('-',$this->input->post('origin'));
		$desti  = explode('-',$this->input->post('destination'));

		$filter['port_origin'] = $origin[0];
		$filter['port_dest'] = $desti[0];
		$filter['status != 7'] = NULL;
		$filter['forwarder_id = "'.$limit.'"'] =NULL;
		$res = $this->mod_shp->request_get($filter);

		echo json_encode(array('data'=>$res));
	}

	function referenceItem(){
		$status = TRUE;
		$this->load->model('customer/customer_model','mod_cust');
		$this->load->model('shipment/shipment_model','mod_shp');
		$id = $this->input->post('id');

		$where['request_id IN("'.implode('","',explode(',',$id)).'")']=NULL;
		do{
			$cek = $this->mod_shp->request_type($where);
			if($cek > 1){
				$status = FALSE;
				$out['messages'] = lang('msg_shp_cek_ref');
				break;
			}

		}while (FALSE);

		$out['status'] = $status;
		if($status)
			$out['data'] = $this->mod_cust->reqeuestitem_get($where);

		echo json_encode($out);
	}


}
