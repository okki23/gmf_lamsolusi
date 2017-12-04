<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('User_model', 'mod_user', TRUE);
	}

	public function index(){
		if (in_array($this->session->userdata('level'),explode(',',ALLOWED_USER))){
			redirect(site_url('dashboard'));
		}
		
		if($this->input->post('username')){
			$username = $this->input->post('username');
			$password = strtolower($this->input->post('password'));
			$pbth 	   = 'No';
			
			if (trim($username)!='' && trim($password)!=''){
				$user = $this->mod_user->get($username,md5($password));
				if ($user != FALSE){
					$user = $user->row();
					if($user->status_petugas>0){
						$sess_log = $this->mod_user->get_session_log($username);
						$is_ok = FALSE;
						if ($sess_log === FALSE) $is_ok = TRUE;
						else{
							$sess_log = $sess_log->row();
							if($sess_log->dtimenow>$sess_log->dtimeexpired) $is_ok = TRUE;
						}
						if($is_ok){
							if(substr($user->id_alias,0,3) == 'CST'){
								$this->load->model('customer/customer_model','mod_cst');
								$res = $this->mod_cst->get(
										array('id_customer'=>$user->id_alias)
									);
								$cus = current($res);
								if($cus->cust_type == 'Internal')
									$pbth = 'Yes';
							}
								
							$data = array(
								'user' =>$username, 
								'limit_id' =>$user->id_alias,
								'real_name' =>$user->nama_petugas, 
								'level' => $user->jenis_petugas,
								'pbth'=>$pbth
							);
							$this->session->set_userdata($data);
							$this->mod_user->session_log($username);
							
							redirect(site_url('user/log'));
						}else{
							$this->session->set_flashdata('alert_type', 'danger');
							$this->session->set_flashdata('alert_message', 'Maaf, Anda tidak diijinkan masuk lebih dari satu tempat.');
							redirect(site_url('user/log'));
						}
					}
				}
			}
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_message', 'Maaf, username dan atau password Anda salah');
			redirect(site_url('user/log'));
		}
		
		$this->template->set_layout('login')->build('user/login');
	}
	
	function update(){
		$username = $this->session->userdata('user');
		if($username!='')
			$this->mod_user->session_log($username);
	}
	
	function out(){
		$this->load->driver('cache');
		$this->cache->clean();
		$username = $this->session->userdata('user');
		$this->session->sess_destroy();
		$this->mod_user->session_destroy($username);
		redirect(site_url('user/log'), 'refresh');
	}
}

