<?php
class Lnm_model extends CI_Model {

	var $tbl_request = 'shipment_request';

	public function __construct(){
        parent::__construct();
		$this->db_main = $this->load->database('default',TRUE);
    }

}
