<?php

class User_model extends CI_Model {

	var $table = 'petugas';
	var $jenis = '';

	function __construct(){
		parent::__construct();
		$this->jenis = explode(',',ALLOWED_USER);
		$this->app = $this->config->item('app');
		$this->db = $this->load->database('default',TRUE);
	}

	function get($username,$password){
		$this->db->where('id_petugas',$username);
		$this->db->where('password_petugas',$password);
		$this->db->where_in('jenis_petugas',$this->jenis);
		$stmt = $this->db->get($this->table);

		if ($stmt->num_rows() > 0){
			return $stmt;
		}else{
			return FALSE;
		}
	}

	function add($data){
		$this->db->insert(
			$this->table,$data
		);

		if($this->db->affected_rows()> 0)
			return TRUE;
		else
			return FALSE;
	}

	function get_all($filter){
		$this->db->select('id_petugas as id, email, id_alias as alias, nama_petugas,
			CASE
				WHEN jenis_petugas = "'.USER_SADMIN.'" THEN "Super Admin"
				WHEN jenis_petugas = "'.USER_GMF.'" THEN "Admin GMF"
				WHEN jenis_petugas = "'.USER_SALES.'" THEN "Sales"
				WHEN jenis_petugas = "'.USER_PARTNER.'" THEN "Partner"
				WHEN jenis_petugas = "'.USER_CUSTOMER.'" THEN "Customer"
				WHEN jenis_petugas = "'.USER_GMF_RECEIVING.'" THEN "Receiving"
				WHEN jenis_petugas = "'.USER_GMF_IMPORT.'" THEN "Import"
				WHEN jenis_petugas = "'.USER_GMF_LNM.'" THEN "LNM"
				ELSE jenis_petugas END
			AS jenis_petugas, jenis_petugas as jenis_id,
			IF(status_petugas=1,"Aktif","Non Aktif") as status_petugas,company_name,
			0 as logged',FALSE)
			->from($this->table);
		if($filter !=FALSE && count($filter)>0)
			$this->db->where($filter);
		$res =$this->db->get();
		$arr = $res->result();

		$rlog = $this->db->get('session');


		if($res->num_rows() > 0){
			foreach($arr as $k=>$row){
				$arr[$k]->id = $row->id;
				$arr[$k]->alias = $row->alias;
				$arr[$k]->nama_petugas = $row->nama_petugas;
				$arr[$k]->status_petugas = $row->status_petugas;
				$arr[$k]->jenis_petugas = $row->jenis_petugas;
				$arr[$k]->company_name = $row->company_name;
				foreach($rlog->result() as $crow){
					if($crow->id_petugas == $row->id.$this->app)
					$arr[$k]->logged = 1;
				}
			}
			return $arr;
		}else
			return array();
	}

	function edit($data,$filter){
		$this->db->where($filter);
		$this->db->update(
			$this->table,$data
		);

		if($this->db->affected_rows()> 0)
			return TRUE;
		else
			return FALSE;
	}

	function get_id($id){
		$this->db->where('id_petugas',$id);
		$stmt = $this->db->get($this->table);
		if ($stmt->num_rows() > 0){
			return $stmt;
		}else{
			return FALSE;
		}
	}

	function change_password($id, $password){
		$data = array(
			'password_petugas'=>md5($password),
		);

		return $this->db->update($this->table,$data,array('id_petugas'=>$id));
	}

	function update_last_login($username){
		$data = array(
			'password_transaksi'=>$this->session->userdata('session_id'),
			'lastlogin'=>date('Y-m-d H:i:s'),
			//'id_alias'=>$this->input->ip_address(),
			'user_agent'=>$this->session->userdata('user_agent')
		);
		$this->db->where_in('jenis_petugas',$this->jenis);
		$this->db->where(array('id_petugas' => $username.$this->app, 'status_petugas'=>1));
		return $this->db->update($this->table,$data);
	}

	function session_log($username){
		$stmt = $this->get_session_log($username);
		$session = $stmt!==FALSE?$stmt->row()->sessionid:$this->session->userdata('session_id');

		return $this->db->query('INSERT INTO '.$this->db->dbprefix('session').'(id_petugas,sessionid,user_agent,dtimelogin,dtimeexpired)
		VALUES("'.$username.$this->app.'","'.$session.'","'.$this->session->userdata('user_agent').'",NOW(),DATE_ADD(NOW(),INTERVAL '.$this->config->item('sess_expiration').' SECOND))
		ON DUPLICATE KEY UPDATE id_petugas="'.$username.$this->app.'",sessionid="'.$this->session->userdata('session_id').'",user_agent="'.$this->session->userdata('user_agent').'",dtimeexpired=DATE_ADD(NOW(),INTERVAL '.$this->config->item('sess_expiration').' SECOND)');
	}

	function session_destroy($username){
		$this->db->where('id_petugas',$username.$this->app);
		return $this->db->delete('session');
	}

	function get_session_log($username){
		$this->db->select('id_petugas,sessionid,UNIX_TIMESTAMP(NOW()) dtimenow,UNIX_TIMESTAMP(dtimeexpired) dtimeexpired');
		$this->db->where('id_petugas',$username.$this->app);
		$stmt = $this->db->get('session');

		if ($stmt->num_rows() > 0){
			return $stmt;
		}else{
			return FALSE;
		}
	}

	function hapus($filter){
		$this->db->where($filter);
		$this->db->delete($this->table);
	}

	function clear($filter){
		$this->db->where($filter);
		$this->db->delete('session');
	}
}
