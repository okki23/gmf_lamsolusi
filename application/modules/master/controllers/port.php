<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Port extends MY_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->module('app');
		$this->app->cek_permit();
    }

	public function index()
	{
		$this->cek_build_access(array(ALLOWED_USER,USER_GMF));

		$this->template->title(lang('title_port'));
		$this->template->build('master/port_view');
	}

  function get(){
    $res 	= array();
		$filter = array();
		$this->load->model('master/port_model','mod_port');

		if($this->input->post('id') !='')
			$filter['port_id IN("'.implode('","',explode(',',$this->input->post('id'))).'")']=NULL;

		$res = $this->mod_port->get($filter);

		echo json_encode(array('data'=>$res));
  }

	function proses(){
		$port_id       = $this->input->post('id');
		$port_name     = $this->input->post('nama');
		$port_country  = $this->input->post('country');
		$out['status'] = FALSE;
		$mode 				 = ($this->input->post('edit_id')!='')?'edit':'add';
		$res					 = FALSE;


			$data=array(
				'port_id'=>strtoupper($port_id),
				'port_country'=>$port_country,
				'port_name'=>$port_name
			);

			do{
				if($port_id =='' ){
					$out['messages']='Port ID can not be empty';
					break;
				}

				if($port_country==''){
					$out['messages']='Please select Country';
					break;
				}

				if($port_name==''){
					$out['messages']='Pprt Name can not be empty';
					break;
				}

				$this->load->model('master/port_model','mod_prt');
				if($mode=='add')
					$res = $this->mod_prt->add($data);
				else{
					unset($data['port_id']);
					$filter['port_id']=$port_id;
					$res = $this->mod_prt->edit($data,$filter);
				}


				$out['status'] = $res;
				if($res)
					$out['messages'] = lang('msg_process_ok');
				else
					$out['messages']= lang('msg_process_no');

			}while(FALSE);

			echo json_encode($out);
	}

	function hapus(){
		$this->load->model('master/port_model','mod_prt');
		$id = explode(',',$this->input->post('id'));

		$filter['port_id IN("'.implode('","',$id).'")']=NULL;
		$this->mod_prt->hapus($filter);
	}

}
