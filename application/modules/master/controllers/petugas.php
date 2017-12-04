<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Petugas extends MY_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->module('app');
		$this->app->cek_permit();
    }
	
	public function index()
	{
		$this->cek_build_access(array(ALLOWED_USER,USER_GMF));
		
		$this->template->title('User Management');
		$this->template->build('master/petugas_view');
	}
	
	function get(){
		$res 	= array();
		$filter = array();
		$this->load->model('user/user_model','mod_user');
		
		if($this->input->post('id') !='')
			$filter['id_petugas IN("'.implode('","',explode(',',$this->input->post('id'))).'")']=NULL;
		
		$res = $this->mod_user->get_all($filter);
		
		echo json_encode(array('data'=>$res));
	}
	
	function hapus(){
		$this->load->model('user/user_model','mod_user');
		$id = explode(',',$this->input->post('id'));
		
		$filter['id_petugas IN("'.implode('","',$id).'")']=NULL;
		$this->mod_user->hapus($filter);
	}
	
	
	function clear(){
		$this->load->model('user/user_model','mod_user');
		$id 	= explode(',',$this->input->post('id'));
		$app 	= $this->config->item('app');
		foreach($id as $k=>$cId)
			$id[$k] = $cId.$app;
		
		$filter['id_petugas IN("'.implode('","',$id).'")']=NULL;
		$this->mod_user->clear($filter);
	}
	
	function proses(){
		$this->load->model('user/user_model','mod_user');
		$fx_alias   = '';
		$fx_name   	= '';
		$ptg_id 	= $this->input->post('uname');
		$jenis_ptg	= $this->input->post('jenis');
		$mode 		= $this->input->post('mode');
		$email 		= $this->input->post('email');
		$pswd		= md5($this->input->post('password'));
		$joinDate	= date('Y-m-d H:i:s');
		$timeDate 	= strtotime($joinDate);
		$expdDate	= strtotime("+7 day", $timeDate);
		$expDate 	= date('Y-m-d', $expdDate);
		$out['status'] = FALSE;
		$salutasi 	= $this->input->post('salutatsion');
		$first_name	= $this->input->post('first_name');
		$last_name 	= $this->input->post('last_name');
		$ptg_name	= $salutasi."|".$first_name."|".$last_name;
		if($this->input->post('alias') !=''){
			$cst_alias	= explode('-',$this->input->post('alias'));
			$fx_alias	= (count($cst_alias >0))? $cst_alias[0]:NULL;
			$fx_name	= (count($cst_alias >0))? $cst_alias[1]:NULL;
		}
		
		$data=array(
			'id_petugas'=>$ptg_id,
			'id_alias'=>$fx_alias,
			'password_petugas'=>$pswd,
			'nama_petugas'=> $ptg_name,
			'company_name'=> $fx_name,
			'email'=> $email,
			'jenis_petugas'=> $jenis_ptg,
			'expired_password'=> $expDate,
			'created_date'=> $joinDate,
			'status_petugas'=> 1
		);
		
		do{
			$cekp = $this->mod_user->get_id($ptg_id);
			if($cekp !=FALSE && $mode=='add'){
				$out['messages'] ='Username Sudah digunakan';
				break;
			}
			
			if($mode=='add')
				$res = $this->mod_user->add($data);
			else{
				unset($data['id_petugas']);
				unset($data['status_petugas']);
				if($this->input->post('password') =='')
					unset($data['password_petugas']);
				$filter['id_petugas']=$ptg_id;
				$res = $this->mod_user->edit($data,$filter);
			}
			
			$out['status'] = $res;
			if($res)
				$out['messages'] = 'Data Berhasil diproses dengan ID '.$ptg_id;
			else
				$out['messages']='Gagal Memproses Data';
			
		}while(FALSE);
		echo json_encode($out);
	}
}
