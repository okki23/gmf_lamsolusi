<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales extends MY_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->module('app');
		$this->app->cek_permit();
    }

	public function index()
	{
		$this->cek_build_access(array(USER_SADMIN,USER_GMF));

		$this->template->title(lang('titile_sls'));
		$this->template->build('master/sales_view');
	}

	function get(){
		$res 	= array();
		$filter = array();
		$this->load->model('sales/sales_model','mod_sales');

		if($this->input->post('id') !='')
			$filter['id_sales IN("'.implode('","',explode(',',$this->input->post('id'))).'")']=NULL;

		$res = $this->mod_sales->get($filter);

		echo json_encode(array('data'=>$res));
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
			$id = $this->app->getAutoId('id_sales','lam_sales','SLS');
		}

		$data=array(
			'id_sales'=>$id,
			'nama_sales'=>$this->input->post('nama'),
			'phone'=>$this->input->post('phone'),
			'email'=>$this->input->post('email'),
			'country'=>$this->input->post('country'),
			'alamat'=>$this->input->post('alamat')
		);
		do{
			if($id==''){
				$out['messages']='Gagal mendapatkan ID Sales';
				break;
			}

			if($this->input->post('country')==''){
				$out['messages']='Please select Country';
				break;
			}

			$this->load->model('sales/sales_model','mod_sales');
			if($mode=='add')
				$res = $this->mod_sales->add($data);
			else{
				unset($data['id_sales']);
				$filter['id_sales']=$id;
				$res = $this->mod_sales->edit($data,$filter);
			}


			$out['status'] = $res;
			if($res)
				$out['messages'] = 'Data Berhasil diproses';
			else
				$out['messages']='Gagal Memproses Data';

		}while(FALSE);

		echo json_encode($out);
	}


	function hapus(){
		$this->load->model('sales/sales_model','mod_sales');
		$id = explode(',',$this->input->post('id'));

		$filter['id_sales IN("'.implode('","',$id).'")']=NULL;
		$this->mod_sales->hapus($filter);
	}
}
