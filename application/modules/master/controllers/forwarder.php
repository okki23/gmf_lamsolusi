<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forwarder extends MY_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->module('app');
		$this->app->cek_permit();
    }

	public function index()
	{
		$this->cek_build_access(array(ALLOWED_USER,USER_GMF));

		$this->template->title(lang('titile_fwd'));
		$this->template->build('master/forwarder_view');
	}

	function proses(){
		$out['status'] = FALSE;
		$id 	='';
		$mode 	='';
		$res	= FALSE;

		if($this->input->post('id') !=''){
			$id = $this->input->post('id');
			$mode='edit';
		}else{
			$mode='add';
			$this->load->module('app');
			$id = $this->app->getAutoId('id_forwarder','lam_forwarder','FWD');
		}

		$salutasi = $this->input->post('salutatsion');
		$firt_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$cp = $salutasi.'|'.$firt_name.'|'.$last_name;

		$data=array(
			'id_forwarder'=>$id,
			'nama_forwrder'=>$this->input->post('nama'),
			'cp'=>$cp,
			'phone'=>$this->input->post('phone'),
			'email'=>$this->input->post('email'),
			'country'=>$this->input->post('country'),
			'alamat'=>$this->input->post('alamat')
		);
		do{
			if($id==''){
				$out['messages']='Gagal mendapatkan ID Forwarder';
				break;
			}

			if($this->input->post('country')==''){
				$out['messages']='Please select Country';
				break;
			}

			$this->load->model('master/forwarder_model','mod_fwd');
			if($mode=='add')
				$res = $this->mod_fwd->add($data);
			else{
				unset($data['id_forwarder']);
				$filter['id_forwarder']=$id;
				$res = $this->mod_fwd->edit($data,$filter);
			}


			$out['status'] = $res;
			if($res)
				$out['messages'] = 'Data Berhasil diproses dengan ID <b>'.$id.'</b>';
			else
				$out['messages']='Gagal Memproses Data';

		}while(FALSE);

		echo json_encode($out);
	}

	function hapus(){
		$this->load->model('master/forwarder_model','mod_fwd');
		$id = explode(',',$this->input->post('id'));

		$filter['id_forwarder IN("'.implode('","',$id).'")']=NULL;
		$this->mod_fwd->hapus($filter);
	}

	function get(){
		$res 	= array();
		$filter = array();
		$this->load->model('master/forwarder_model','mod_fwd');

		if($this->input->post('id') !='')
			$filter['id_forwarder IN("'.implode('","',explode(',',$this->input->post('id'))).'")']=NULL;

		$res = $this->mod_fwd->get($filter);

		echo json_encode(array('data'=>$res));
	}
}
