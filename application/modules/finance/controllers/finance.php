<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Finance extends MY_Controller {


	public function __construct(){
        parent::__construct();
				$this->load->module('app');
				$this->app->cek_permit();
    }

	public function index()
	{
		$this->cek_build_access(array(USER_GMF,USER_GMF_FINANCE));

		$this->template->title(lang('title_copa'));
		$this->template->build('finance/finance_view');
	}

	function copa(){
		$this->cek_build_access(array(USER_GMF_FINANCE));
		$combo = array(
			array('name'=>'status', 'url'=>'app/copa_status'),
			array('name'=>'req_type', 'url'=>'app/requestType'),
		);

		$data['js_dropdown'] = $this->app->dropdown_kendo($combo);
		$this->template->title(lang('title_copa'));
		$this->template->build('finance/lockcopa_view',$data);
	}

	function copa_table(){
		$data['filter'] = array(
			'type' => $this->input->post('filter'),
			'req_number' => $this->input->post('req_number'),
			'req_type' => $this->input->post('req_type'),
			'status' => $this->input->post('status')
		);
		$this->load->view('finance/copa_table',$data);
	}

	function get_unlock_copa(){
		$this->load->model('finance/finance_model','mod_fnc');
		$where["status >= 4 AND status !=6"] = NULL;
		$where['r.copa_lock'] = 'no';
		$res = $this->mod_fnc->req_copa($where);

		echo json_encode(array('data'=>$res));
	}

	function get_copa(){
		$this->load->model('finance/finance_model','mod_fnc');
		$type 		= $this->input->post('type');
		$req_no 	= $this->input->post('req_number');
		$req_type = $this->input->post('req_type');
		$req_stat = $this->input->post('status');

		if($type == 'f_satu'){
			$where['r.request_id']=$req_no;
		}else{
		 	if($req_type !='-1' and $req_type !='')
		 		$where['r.request_type'] = $req_type;

			if($req_stat !='-1' and $req_stat !='')
				$where['r.copa_lock'] = $req_stat;
		}

		$where["status >= 4 AND status !=6"] = NULL;
		$res = $this->mod_fnc->req_copa($where);

		echo json_encode(array('data'=>$res));
	}

	function copa_edit(){
		$this->load->model('finance/finance_model','mod_fnc');
		$filter['request_id IN("'.implode('","',explode(',',$this->input->post('id'))).'")']=NULL;
		if($this->input->post('type')=='unlock')
			$data['copa_lock'] = 'no';
		else
			$data['copa_lock'] = 'yes';

		$this->mod_fnc->edit($data,$filter);

		echo lang('msg_process_ok');
	}

	function set_copa(){
		$this->load->model('finance/finance_model','mod_fnc');
		$row_item 	= json_decode(json_encode(($this->input->post('models'))));

		foreach($row_item as $k=>$row){
			$filter['request_id'] = $row->request_id;
			$data['copa']= ($row->copa >0)?$row->copa:0;
			$this->mod_fnc->copa_set($data,$filter);
			unset($filter['request_id']);
			unset($data['copa']);
		}
	}
}
