<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Request extends MY_Controller {
	public function __construct(){
        parent::__construct();
		$this->load->module('app');
		$this->app->cek_permit();
    }

	public function index()
	{
		$this->cek_build_access(array(USER_PARTNER));

		$this->template->title(lang('title_shp'));
		$this->template->build('shipment/shipment_request_view');
	}

	function getReference(){
		$this->load->model('shipment/shipment_model','mod_shp');
		$limit 	= $this->session->userdata('limit_id');

		$filter['status != 7'] = NULL;
		$filter['forwarder_id = "'.$limit.'"'] =NULL;
		$res = $this->mod_shp->request_get($filter);

		echo json_encode(array('data'=>$res));
	}

}
