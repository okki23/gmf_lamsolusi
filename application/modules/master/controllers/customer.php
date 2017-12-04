<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends MY_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->module('app');
		$this->app->cek_permit();
    }

	public function index()
	{
		$this->cek_build_access(array(ALLOWED_USER,USER_GMF));

		$this->template->title(lang('titile_cst'));
		$this->template->build('master/customer_view');
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
			$id = $this->app->getAutoId('id_customer','lam_customer','CST');
		}

		$salutasi = $this->input->post('salutatsion');
		$firt_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$cp = $salutasi.'|'.$firt_name.'|'.$last_name;

		$data=array(
			'id_customer'=>$id,
			'nama_customer'=>$this->input->post('nama'),
			'cp'=>$cp,
			'phone'=>$this->input->post('phone'),
			'email'=>$this->input->post('email'),
			'country'=>$this->input->post('country'),
			'alamat'=>$this->input->post('alamat'),
			'cust_type'=>$this->input->post('cust_type'),
			'npwp'=>$this->input->post('npwp')
		);
		do{
			if($id==''){
				$out['messages']='Gagal mendapatkan ID Customer';
				break;
			}

			if($this->input->post('country')==''){
				$out['messages']='Please select Country';
				break;
			}

			$this->load->model('customer/customer_model','mod_cust');
			if($mode=='add')
				$res = $this->mod_cust->add($data);
			else{
				unset($data['id_customer']);
				$filter['id_customer']=$id;
				$res = $this->mod_cust->edit($data,$filter);
			}


			$out['status'] = $res;
			if($res)
				$out['messages'] = 'Data Berhasil diproses, ID '.$id;
			else
				$out['messages']='Gagal Memproses Data';

		}while(FALSE);

		echo json_encode($out);
	}

	function hapus(){
		$this->load->model('customer/customer_model','mod_cust');
		$id = explode(',',$this->input->post('id'));

		$filter['id_customer IN("'.implode('","',$id).'")']=NULL;
		$this->mod_cust->hapus($filter);
	}

	function get(){
		$res 	= array();
		$filter = array();
		$this->load->model('customer/customer_model','mod_cust');

		if($this->input->post('id') !='')
			$filter['id_customer IN("'.implode('","',explode(',',$this->input->post('id'))).'")']=NULL;

		$res = $this->mod_cust->get($filter);

		echo json_encode(array('data'=>$res));
	}

}
