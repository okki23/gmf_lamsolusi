<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->db_server = $this->load->database('server', TRUE); 
	}
	
	protected function cek_build_access($level){
		if (!in_array($this->session->userdata('level'),(array)$level)){
			redirect(site_url('user/log'));
		}
	}
	
	protected function cek_view_access($level){
		if (!in_array($this->session->userdata('level'),(array)$level)){
			$this->output->set_status_header('401');
			echo '{"status":false,"message":"Restricted Access"}';
			return false;
		}
		return true;
	}
}