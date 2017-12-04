<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->cek_build_access(explode(',',ALLOWED_USER));
	}

	public function index(){
		redirect(site_url('dashboard'));
	}
	
	function password(){
		$pass_new = $this->input->post('t_password_new');
		$pass_cnf = $this->input->post('t_password_confirm');
		$pass_old = $this->input->post('t_password_old');
		
		if($pass_new){
			if($pass_new==$pass_cnf){
				$this->load->model('user_model','mod_user');
				$id = $this->session->userdata('user');
				
				$user = $this->mod_user->get_id($id);
				if ($user != FALSE){
					$rs = $user->row();
					if(md5($pass_old)==$rs->password_petugas){
						$this->mod_user->change_password($id, $pass_new);
						$this->session->set_flashdata('alert_type', 'success');
						$this->session->set_flashdata('alert_message', 'Password baru berhasil disimpan.');
					}else{
						$this->session->set_flashdata('alert_type', 'danger');
						$this->session->set_flashdata('alert_message', 'Password lama tidak sesuai.');
					}
				}else{
					$this->session->set_flashdata('alert_type', 'danger');
					$this->session->set_flashdata('alert_message', 'Gagal merubah password user. User ID tidak ditemukan.');
				}
			}else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_message', 'Password Konfirmasi tidak sesuai dengan Password Baru.');
			}
			redirect(site_url('user/password'), 'refresh');
		}
		
		$this->template->title('Ganti Password');
		$this->template->build('password');
	}
}

