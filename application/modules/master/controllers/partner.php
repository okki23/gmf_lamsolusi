<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partner extends MY_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->module('app');
		$this->app->cek_permit();
    }

	public function index()
	{
		$this->cek_build_access(array(USER_GMF,USER_SADMIN));

		$this->template->title(lang('titile_ptr'));
		$this->template->build('master/partner_view');
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
			$id = $this->app->getAutoId('id_partner','lam_partner','PTR');
		}

		$data=array(
			'id_partner'=>$id,
			'nama_partner'=>$this->input->post('nama'),
			'cp'=>$this->input->post('cp'),
			'phone'=>$this->input->post('phone'),
			'email'=>$this->input->post('email'),
			'country'=>$this->input->post('country'),
			'alamat'=>$this->input->post('alamat')
		);
		do{
			if($id==''){
				$out['messages']='Gagal mendapatkan ID Partner';
				break;
			}

			if($this->input->post('country')==''){
				$out['messages']='Please select Country';
				break;
			}

			$this->load->model('master/partner_model','mod_ptr');
			if($mode=='add')
				$res = $this->mod_ptr->add($data);
			else{
				unset($data['id_partner']);
				$filter['id_partner']=$id;
				$res = $this->mod_ptr->edit($data,$filter);
			}


			$out['status'] = $res;
			if($res)
				$out['messages'] = 'Data Berhasil diproses';
			else
				$out['messages']='Gagal Memproses Data';

		}while(FALSE);

		echo json_encode($out);
	}

	function get(){
		$res 	= array();
		$filter = array();
		$this->load->model('master/partner_model','mod_ptr');

		if($this->input->post('id') !='')
			$filter['id_partner IN("'.implode('","',explode(',',$this->input->post('id'))).'")']=NULL;

		$res = $this->mod_ptr->get($filter);

		echo json_encode(array('data'=>$res));
	}

	function hapus(){
		$this->load->model('master/partner_model','mod_ptr');
		$id = explode(',',$this->input->post('id'));

		$filter['id_partner IN("'.implode('","',$id).'")']=NULL;
		$this->mod_ptr->hapus($filter);
	}


}
