<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sync extends MY_Controller {
	
	public function __construct(){
        parent::__construct();
		
    }
	
	/* 
	* awb_status = Open/Clear
	*/
	
	function index(){
		
		$count 	= 0;
		$awb 	= array();
		$res 	= $this->find_fee_awb();
		if($res >0){
			foreach($res as $row_awb)
				$awb[] = $row_awb->awb;
				
			$match=$this->find_sinc_awb($awb);
			if($match >0){
				foreach($match as $row){
					$filter = $row->awb;
					$data	= array(
						'awb_status' =>$row->awb_status,
						'bc_no' =>$row->bc_no,
						'bc_date' =>$row->bc_date
					);
					$count += $this->sync_data($filter,$data);
					if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])!='xmlhttprequest')
						fwrite(STDOUT, "Info   -> AWB Number ".$filter.PHP_EOL); //print "Info   -> AWB Number ".$filter;
				}
				if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest')
					echo json_encode(array('messages'=>$count.' AWB Berhasil dicocokkan'));
				else
					fwrite(STDOUT, "Suskses -> ".$count.PHP_EOL); //print "Suskses -> ".$count;
			}else
				if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest')
					echo json_encode(array('messages'=>'INFO: Titak dapat menemukan awb pada server'));
				else
					exit('ERROR: Titak dapat menemukan awb pada server');
		}else
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest')
				echo json_encode(array('messages'=>'INFO: Semua Awb sudah Clear'));
			else
				exit('ERROR: Semua Awb sudah Clear');
	}
	
	function find_fee_awb(){
		$this->load->model('sync/sync_model','mod_sync');
		$res = $this->mod_sync->get();
		return $res;
	}
	
	function find_sinc_awb($awb){
		$this->load->model('sync/sync_model','mod_sync');		
		$filter['awb_no IN("'.implode('","',$awb).'")']=NULL;
		$res = $this->mod_sync->cek($filter);
		return $res;
	}
	
	function sync_data($id,$data){
		$this->load->model('sync/sync_model','mod_sync');
		$filter['awb']=$id;
		$res = $this->mod_sync->update($filter,$data);
		
		if($res)
			return 1;
		else 
			return 0;
	}
	
}