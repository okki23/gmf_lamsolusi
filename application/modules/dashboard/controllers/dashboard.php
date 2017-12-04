<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {


	public function __construct(){
        parent::__construct();
				$this->load->module('app');
				$this->app->cek_permit();
    }

	public function index()
	{
		$this->cek_build_access(explode(',',ALLOWED_USER));
 
		$userId 	= $this->session->userdata('limit_id');
		$customer	= array();
		$admin		= array();
		//var_dump($datax);
		//echo "<hr>";
		if($this->session->userdata('level')==USER_CUSTOMER){
			$customer['open_request'] = $this->onpen_request($userId);
			$customer['approve_request'] = $this->approved_request($userId);
			$customer['mothly_request'] = $this->mothly_request($userId);
			$customer['rejected_request'] = $this->reject_request($userId);
		}
	
		if($this->session->userdata('level')==USER_PARTNER){
				$customer['open_request'] = $this->onpen_request($userId);
		}
		if($this->session->userdata('level')==USER_GMF){
			$admin['dist_request'] = $this->distribute_request();
			$admin['open_awb'] = $this->awb_open_stat();
			$admin['open_sp'] = $this->awb_open_sp();
			$admin['aktif_user'] = $this->aktif_user();
			$admin['mothly_request'] = $this->all_request();
			$admin['rejected_request'] = $this->reject_request();
		}

		if($this->session->userdata('level')==USER_SALES){
			$admin['approve_request'] = $this->onpen_request();
			$admin['open_act'] = $this->sales_open_act($userId);
		}


		$this->template->title('Dashboard');
		if($this->session->userdata('level')==USER_CUSTOMER)
			$this->template->build('dashboard/dashboard_customer',$customer);
		elseif($this->session->userdata('level')==USER_GMF)
			$this->template->build('dashboard/dashboard_admin',$admin);
		elseif($this->session->userdata('level')==USER_SALES)
			$this->template->build('dashboard/dashboard_sales',$admin);
		else
			$this->template->build('dashboard/dashboard');
	}

	function onpen_request($uid=null){
		$this->load->model('dashboard/dashboard_model','mod_dash');
		$where=array();

		$custom_fild ="count(IFNULL(customer_id,0)) as total";
		if($this->session->userdata('level') ==USER_CUSTOMER && $uid!=null)
			$where['customer_id'] = $uid;
		$where['status'] = 1;

		$res = current($this->mod_dash->count_request($custom_fild,$where));
		return $res->total;
	}

	function approved_request($uid=null){
		$this->load->model('dashboard/dashboard_model','mod_dash');
		$where=array();

		$custom_fild ="count(IFNULL(customer_id,0)) as total";
		if($this->session->userdata('level') ==USER_CUSTOMER && $uid!=null)
			$where['customer_id'] = $uid;
		$where['status'] = 2;

		$res = current($this->mod_dash->count_request($custom_fild,$where));
		return $res->total;
	}

	function mothly_request($uid=null){
		$this->load->model('dashboard/dashboard_model','mod_dash');
		$where=array();

		$custom_fild ="count(IFNULL(customer_id,0)) as total";
		if($this->session->userdata('level') ==USER_CUSTOMER && $uid!=null)
			$where['customer_id'] = $uid;
		$where['request_date BETWEEN "'.date('Y-m').'-01" AND "'.date('Y-m').'-31" '] =NULL;

		$res = current($this->mod_dash->count_request($custom_fild,$where));
		return $res->total;
	}

	function all_request($uid=null){
		$this->load->model('dashboard/dashboard_model','mod_dash');
		$where=array();

		$custom_fild ="count(IFNULL(customer_id,0)) as total";
		if($this->session->userdata('level') ==USER_CUSTOMER && $uid!=null)
			$where['customer_id'] = $uid;
		//$where['request_date BETWEEN "'.date('Y-m').'-01" AND "'.date('Y-m').'-31" '] =NULL;

		$res = current($this->mod_dash->count_request($custom_fild,$where));
		return $res->total;
	}

	function reject_request($uid=null){
		$this->load->model('dashboard/dashboard_model','mod_dash');
		$where=array();

		$custom_fild ="count(IFNULL(customer_id,0)) as total";
		if($this->session->userdata('level') ==USER_CUSTOMER && $uid!=null)
			$where['customer_id'] = $uid;
		$where['status'] = 3;

		$res = current($this->mod_dash->count_request($custom_fild,$where));
		return $res->total;
	}

	function distribute_request(){
		$this->load->model('dashboard/dashboard_model','mod_dash');
		$where=array();

		$custom_fild ="count(IFNULL(customer_id,0)) as total";
		$where['request_type IN("IMPORT","EXPORT","DOMESTIC DISTRIBUTION")']=NULL;
		$where['sales_id !="" '] =NULL;
		$where['status'] =4;
		$where['forwarder_id IS NULL OR forwarder_id ="" '] = NULL;

		$res = current($this->mod_dash->count_request($custom_fild,$where));
		return $res->total;
	}

	function awb_open_stat(){
		$this->load->model('dashboard/dashboard_model','mod_dash');
		$where=array();

		$custom_fild ="count(IFNULL(awb,0)) as total";
		$where['awb_status'] = 'Open';

		$res = current($this->mod_dash->count_awb($custom_fild,$where));
		return $res->total;
	}

	function awb_open_sp(){
		$this->load->model('dashboard/dashboard_model','mod_dash');
		$where=array();

		$custom_fild ="count(IFNULL(sp_id,0)) as total";
		$where['status'] = 1;

		$res = current($this->mod_dash->count_sp($custom_fild,$where));
		return $res->total;
	}

	function aktif_user(){
		$this->load->model('dashboard/dashboard_model','mod_dash');
		$where=array();

		$custom_fild ="count(IFNULL(id_petugas,0)) as total";

		$res = current($this->mod_dash->aktif_user($custom_fild,$where));
		return $res->total;
	}

	function sales_open_act($userId){
		$this->load->model('dashboard/dashboard_model','mod_dash');
		$where=array();

		$custom_fild ="count(IFNULL(actifity_id,0)) as total";
		$where['sales_id'] = $userId;
		$where['status'] = 1;
		$res = current($this->mod_dash->sales_act($custom_fild,$where));
		return $res->total;
	}

}
