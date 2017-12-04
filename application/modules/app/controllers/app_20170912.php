<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App extends MY_Controller {

	public function __construct(){
        parent::__construct();
				$this->db_main = $this->load->database('default',TRUE);
				$this->lang->load('language', 'english');
    }

	public function index()
	{
		redirect('dashboard/index');
	}

	function dropdown_kendo($data){
		/*
			$data['name']
			$data['url']
		*/
		$res['cmbRequest'] = json_decode(json_encode($data));
		return $this->load->view('app/dropdown_js',$res,TRUE);
	}

	function country(){
		$data=array(
			array('id'=>'AD', 'text'=>'Andorran'),
			array('id'=>'AE', 'text'=>'Utd.Arab Emir.'),
			array('id'=>'AF', 'text'=>'Afghanistan'),
			array('id'=>'AG', 'text'=>'Antigua/Barbuda'),
			array('id'=>'AI', 'text'=>'Anguilla'),
			array('id'=>'AL', 'text'=>'Albania'),
			array('id'=>'AM', 'text'=>'Armenia'),
			array('id'=>'AN', 'text'=>'Dutch Antilles'),
			array('id'=>'AO', 'text'=>'Angola'),
			array('id'=>'AQ', 'text'=>'Antarctica'),
			array('id'=>'AR', 'text'=>'Argentina'),
			array('id'=>'AS', 'text'=>'Samoa, America'),
			array('id'=>'AT', 'text'=>'Austria'),
			array('id'=>'AU', 'text'=>'Australia'),
			array('id'=>'AW', 'text'=>'Aruba'),
			array('id'=>'AZ', 'text'=>'Azerbaijan'),
			array('id'=>'BA', 'text'=>'Bosnia-Herz.'),
			array('id'=>'BB', 'text'=>'Barbados'),
			array('id'=>'BD', 'text'=>'Bangladesh'),
			array('id'=>'BE', 'text'=>'Belgium'),
			array('id'=>'BF', 'text'=>'Burkina Faso'),
			array('id'=>'BG', 'text'=>'Bulgaria'),
			array('id'=>'BH', 'text'=>'Bahrain'),
			array('id'=>'BI', 'text'=>'Burundi'),
			array('id'=>'BJ', 'text'=>'Benin'),
			array('id'=>'BL', 'text'=>'Blue'),
			array('id'=>'BM', 'text'=>'Bermuda'),
			array('id'=>'BN', 'text'=>'Brunei Daruss.'),
			array('id'=>'BO', 'text'=>'Bolivia'),
			array('id'=>'BR', 'text'=>'Brazil'),
			array('id'=>'BS', 'text'=>'Bahamas'),
			array('id'=>'BT', 'text'=>'Bhutan'),
			array('id'=>'BV', 'text'=>'Bouvet Islands'),
			array('id'=>'BW', 'text'=>'Botswana'),
			array('id'=>'BY', 'text'=>'Belarus'),
			array('id'=>'BZ', 'text'=>'Belize'),
			array('id'=>'CA', 'text'=>'Canada'),
			array('id'=>'CC', 'text'=>'Coconut Islands'),
			array('id'=>'CD', 'text'=>'Dem. Rep. Congo'),
			array('id'=>'CF', 'text'=>'CAR'),
			array('id'=>'CG', 'text'=>'Rep.of Congo'),
			array('id'=>'CH', 'text'=>'Switzerland'),
			array('id'=>'CI', 'text'=>"Cote d'Ivoire"),
			array('id'=>'CK', 'text'=>'Cook Islands'),
			array('id'=>'CL', 'text'=>'Chile'),
			array('id'=>'CM', 'text'=>'Cameroon'),
			array('id'=>'CN', 'text'=>'China'),
			array('id'=>'CO', 'text'=>'Colombia'),
			array('id'=>'CR', 'text'=>'Costa Rica'),
			array('id'=>'CS', 'text'=>'Serbia/Monten.'),
			array('id'=>'CU', 'text'=>'Cuba'),
			array('id'=>'CV', 'text'=>'Cape Verde'),
			array('id'=>'CX', 'text'=>'Christmas Islnd'),
			array('id'=>'CY', 'text'=>'Cyprus'),
			array('id'=>'CZ', 'text'=>'Czech Republic'),
			array('id'=>'DE', 'text'=>'Germany'),
			array('id'=>'DJ', 'text'=>'Djibouti'),
			array('id'=>'DK', 'text'=>'Denmark'),
			array('id'=>'DM', 'text'=>'Dominica'),
			array('id'=>'DO', 'text'=>'Dominican Rep.'),
			array('id'=>'DZ', 'text'=>'Algeria'),
			array('id'=>'EC', 'text'=>'Ecuador'),
			array('id'=>'EE', 'text'=>'Estonia'),
			array('id'=>'EG', 'text'=>'Egypt'),
			array('id'=>'EH', 'text'=>'West Sahara'),
			array('id'=>'ER', 'text'=>'Eritrea'),
			array('id'=>'ES', 'text'=>'Spain'),
			array('id'=>'ET', 'text'=>'Ethiopia'),
			array('id'=>'EU', 'text'=>'European Union'),
			array('id'=>'FI', 'text'=>'Finland'),
			array('id'=>'FJ', 'text'=>'Fiji'),
			array('id'=>'FK', 'text'=>'Falkland Islnds'),
			array('id'=>'FM', 'text'=>'Micronesia'),
			array('id'=>'FO', 'text'=>'Faroe Islands'),
			array('id'=>'FR', 'text'=>'France'),
			array('id'=>'GA', 'text'=>'Gabon'),
			array('id'=>'GB', 'text'=>'United Kingdom'),
			array('id'=>'GD', 'text'=>'Grenada'),
			array('id'=>'GE', 'text'=>'Georgia'),
			array('id'=>'GF', 'text'=>'French Guayana'),
			array('id'=>'GH', 'text'=>'Ghana'),
			array('id'=>'GI', 'text'=>'Gibraltar'),
			array('id'=>'GL', 'text'=>'Greenland'),
			array('id'=>'GM', 'text'=>'Gambia'),
			array('id'=>'GN', 'text'=>'Guinea'),
			array('id'=>'GP', 'text'=>'Guadeloupe'),
			array('id'=>'GQ', 'text'=>'Equatorial Guin'),
			array('id'=>'GR', 'text'=>'Greece'),
			array('id'=>'GS', 'text'=>'S. Sandwich Ins'),
			array('id'=>'GT', 'text'=>'Guatemala'),
			array('id'=>'GU', 'text'=>'Guam'),
			array('id'=>'GW', 'text'=>'Guinea-Bissau'),
			array('id'=>'GY', 'text'=>'Guyana'),
			array('id'=>'HK', 'text'=>'Hong Kong'),
			array('id'=>'HM', 'text'=>'Heard/McDon.Isl'),
			array('id'=>'HN', 'text'=>'Honduras'),
			array('id'=>'HR', 'text'=>'Croatia'),
			array('id'=>'HT', 'text'=>'Haiti'),
			array('id'=>'HU', 'text'=>'Hungary'),
			array('id'=>'ID', 'text'=>'Indonesia'),
			array('id'=>'IE', 'text'=>'Ireland'),
			array('id'=>'IL', 'text'=>'Israel'),
			array('id'=>'IN', 'text'=>'India'),
			array('id'=>'IO', 'text'=>'Brit.Ind.Oc.Ter'),
			array('id'=>'IQ', 'text'=>'Iraq'),
			array('id'=>'IR', 'text'=>'Iran'),
			array('id'=>'IS', 'text'=>'Iceland'),
			array('id'=>'IT', 'text'=>'Italy'),
			array('id'=>'JM', 'text'=>'Jamaica'),
			array('id'=>'JO', 'text'=>'Jordan'),
			array('id'=>'JP', 'text'=>'Japan'),
			array('id'=>'KE', 'text'=>'Kenya'),
			array('id'=>'KG', 'text'=>'Kyrgyzstan'),
			array('id'=>'KH', 'text'=>'Cambodia'),
			array('id'=>'KI', 'text'=>'Kiribati'),
			array('id'=>'KM', 'text'=>'Comoros'),
			array('id'=>'KN', 'text'=>'St Kitts&Nevis'),
			array('id'=>'KP', 'text'=>'North Korea'),
			array('id'=>'KR', 'text'=>'South Korea'),
			array('id'=>'KW', 'text'=>'Kuwait'),
			array('id'=>'KY', 'text'=>'Cayman Islands'),
			array('id'=>'KZ', 'text'=>'Kazakhstan'),
			array('id'=>'LA', 'text'=>'Laos'),
			array('id'=>'LB', 'text'=>'Lebanon'),
			array('id'=>'LC', 'text'=>'St. Lucia'),
			array('id'=>'LI', 'text'=>'Liechtenstein'),
			array('id'=>'LK', 'text'=>'Sri Lanka'),
			array('id'=>'LR', 'text'=>'Liberia'),
			array('id'=>'LS', 'text'=>'Lesotho'),
			array('id'=>'LT', 'text'=>'Lithuania'),
			array('id'=>'LU', 'text'=>'Luxembourg'),
			array('id'=>'LV', 'text'=>'Latvia'),
			array('id'=>'LY', 'text'=>'Libya'),
			array('id'=>'MA', 'text'=>'Morocco'),
			array('id'=>'MC', 'text'=>'Monaco'),
			array('id'=>'MD', 'text'=>'Moldova'),
			array('id'=>'MG', 'text'=>'Madagascar'),
			array('id'=>'MH', 'text'=>'Marshall Islnds'),
			array('id'=>'MK', 'text'=>'Macedonia'),
			array('id'=>'ML', 'text'=>'Mali'),
			array('id'=>'MM', 'text'=>'Burma'),
			array('id'=>'MN', 'text'=>'Mongolia'),
			array('id'=>'MO', 'text'=>'Macau'),
			array('id'=>'MP', 'text'=>'N.Mariana Islnd'),
			array('id'=>'MQ', 'text'=>'Martinique'),
			array('id'=>'MR', 'text'=>'Mauretania'),
			array('id'=>'MS', 'text'=>'Montserrat'),
			array('id'=>'MT', 'text'=>'Malta'),
			array('id'=>'MU', 'text'=>'Mauritius'),
			array('id'=>'MV', 'text'=>'Maldives'),
			array('id'=>'MW', 'text'=>'Malawi'),
			array('id'=>'MX', 'text'=>'Mexico'),
			array('id'=>'MY', 'text'=>'Malaysia'),
			array('id'=>'MZ', 'text'=>'Mozambique'),
			array('id'=>'NA', 'text'=>'Namibia'),
			array('id'=>'NC', 'text'=>'New Caledonia'),
			array('id'=>'NE', 'text'=>'Niger'),
			array('id'=>'NF', 'text'=>'Norfolk Islands'),
			array('id'=>'NG', 'text'=>'Nigeria'),
			array('id'=>'NI', 'text'=>'Nicaragua'),
			array('id'=>'NL', 'text'=>'Netherlands'),
			array('id'=>'NO', 'text'=>'Norway'),
			array('id'=>'NP', 'text'=>'Nepal'),
			array('id'=>'NR', 'text'=>'Nauru'),
			array('id'=>'NT', 'text'=>'NATO'),
			array('id'=>'NU', 'text'=>'Niue'),
			array('id'=>'NZ', 'text'=>'New Zealand'),
			array('id'=>'OM', 'text'=>'Oman'),
			array('id'=>'OR', 'text'=>'Orange'),
			array('id'=>'PA', 'text'=>'Panama'),
			array('id'=>'PE', 'text'=>'Peru'),
			array('id'=>'PF', 'text'=>'Frenc.Polynesia'),
			array('id'=>'PG', 'text'=>'Pap. New Guinea'),
			array('id'=>'PH', 'text'=>'Philippines'),
			array('id'=>'PK', 'text'=>'Pakistan'),
			array('id'=>'PL', 'text'=>'Poland'),
			array('id'=>'PM', 'text'=>'St.Pier,Miquel.'),
			array('id'=>'PN', 'text'=>'Pitcairn Islnds'),
			array('id'=>'PR', 'text'=>'Puerto Rico'),
			array('id'=>'PS', 'text'=>'Palestine'),
			array('id'=>'PT', 'text'=>'Portugal'),
			array('id'=>'PW', 'text'=>'Palau'),
			array('id'=>'PY', 'text'=>'Paraguay'),
			array('id'=>'QA', 'text'=>'Qatar'),
			array('id'=>'RE', 'text'=>'Reunion'),
			array('id'=>'RO', 'text'=>'Romania'),
			array('id'=>'RU', 'text'=>'Russian Fed.'),
			array('id'=>'RW', 'text'=>'Rwanda'),
			array('id'=>'SA', 'text'=>'Saudi Arabia'),
			array('id'=>'SB', 'text'=>'Solomon Islands'),
			array('id'=>'SC', 'text'=>'Seychelles'),
			array('id'=>'SD', 'text'=>'Sudan'),
			array('id'=>'SE', 'text'=>'Sweden'),
			array('id'=>'SG', 'text'=>'Singapore'),
			array('id'=>'SH', 'text'=>'Saint Helena'),
			array('id'=>'SI', 'text'=>'Slovenia'),
			array('id'=>'SJ', 'text'=>'Svalbard'),
			array('id'=>'SK', 'text'=>'Slovakia'),
			array('id'=>'SL', 'text'=>'Sierra Leone'),
			array('id'=>'SM', 'text'=>'San Marino'),
			array('id'=>'SN', 'text'=>'Senegal'),
			array('id'=>'SO', 'text'=>'Somalia'),
			array('id'=>'SR', 'text'=>'Suriname'),
			array('id'=>'ST', 'text'=>'S.Tome,Principe'),
			array('id'=>'SV', 'text'=>'El Salvador'),
			array('id'=>'SY', 'text'=>'Syria'),
			array('id'=>'SZ', 'text'=>'Swaziland'),
			array('id'=>'TC', 'text'=>'Turksh Caicosin'),
			array('id'=>'TD', 'text'=>'Chad'),
			array('id'=>'TF', 'text'=>'French S.Territ'),
			array('id'=>'TG', 'text'=>'Togo'),
			array('id'=>'TH', 'text'=>'Thailand'),
			array('id'=>'TJ', 'text'=>'Tajikistan'),
			array('id'=>'TK', 'text'=>'Tokelau Islands'),
			array('id'=>'TL', 'text'=>'East Timor'),
			array('id'=>'TM', 'text'=>'Turkmenistan'),
			array('id'=>'TN', 'text'=>'Tunisia'),
			array('id'=>'TO', 'text'=>'Tonga'),
			array('id'=>'TP', 'text'=>'East Timor'),
			array('id'=>'TR', 'text'=>'Turkey'),
			array('id'=>'TT', 'text'=>'Trinidad,Tobago'),
			array('id'=>'TV', 'text'=>'Tuvalu'),
			array('id'=>'TW', 'text'=>'Taiwan'),
			array('id'=>'TZ', 'text'=>'Tanzania'),
			array('id'=>'UA', 'text'=>'Ukraine'),
			array('id'=>'UG', 'text'=>'Uganda'),
			array('id'=>'UM', 'text'=>'Minor Outl.Isl.'),
			array('id'=>'UN', 'text'=>'United Nations'),
			array('id'=>'US', 'text'=>'USA'),
			array('id'=>'UY', 'text'=>'Uruguay'),
			array('id'=>'UZ', 'text'=>'Uzbekistan'),
			array('id'=>'VA', 'text'=>'Vatican City'),
			array('id'=>'VC', 'text'=>'St. Vincent'),
			array('id'=>'VE', 'text'=>'Venezuela'),
			array('id'=>'VG', 'text'=>'Brit.Virgin Is.'),
			array('id'=>'VI', 'text'=>'Amer.Virgin Is.'),
			array('id'=>'VN', 'text'=>'Vietnam'),
			array('id'=>'VU', 'text'=>'Vanuatu'),
			array('id'=>'WF', 'text'=>'Wallis,Futuna'),
			array('id'=>'WS', 'text'=>'Samoa'),
			array('id'=>'YE', 'text'=>'Yemen'),
			array('id'=>'YT', 'text'=>'Mayotte'),
			array('id'=>'ZA', 'text'=>'South Africa'),
			array('id'=>'ZM', 'text'=>'Zambia'),
			array('id'=>'ZW', 'text'=>'Zimbabwe'),
		);

		echo json_encode(array('data'=>$data));
	}

	function request_status(){
		$data=array(
			array('id'=>'1', 'text'=>'Open'),
			array('id'=>'2', 'text'=>'Cost Assigned'),
			array('id'=>'3', 'text'=>'Reject by Customer'),
			array('id'=>'4', 'text'=>'Approve Price'),
			array('id'=>'5', 'text'=>'Reject by GMF')
		);

		echo json_encode(array('data'=>$data));
	}

	function copa_status(){
		$data=array(
			array('id'=>'yes', 'text'=>'Locked'),
			array('id'=>'no', 'text'=>'Unlocked')
		);

		echo json_encode(array('data'=>$data));
	}

	function actifity_type(){
		$data=array(
			array('id'=>'actifity one', 'text'=>'actifity one'),
			array('id'=>'actifity two', 'text'=>'actifity two')
		);

		echo json_encode(array('data'=>$data));
	}

	function port(){
		$res=array();
		$this->db_main->select('port_id as id, port_country as country, port_name')
			->from('portlist');
		$resx = $this->db_main->get();
		$res = $resx->result();
		echo json_encode(array('data'=>$res));
	}

	function uom(){
		$calback= $_GET['callback'];
		$text ='';
		if(isset($_GET['filter'])) {
			$filter = $_GET['filter'];

			if(isset($_GET['filter']['filters'][0]['value']))
				$text = $filter['filters'][0]['value'];
		}
		$res=array();
		$this->db_main->select('uom as id, CONCAT(uom_desc," (", uom,")") as uom',FALSE)
			->from('uom');
		if($text !='')
			$this->db_main->like('uom_desc',$text);
		$this->db_main->order_by('uom_desc','ASC');
		$resx = $this->db_main->get();
		$res = $resx->result();
		echo $calback."(".json_encode($res).")";
	}

	function incoterm(){
		$row = $this->config->item('incoterm');
		foreach($row as $k=>$v){
			$res[$k]['id']= $v;
			$res[$k]['text']= $v;
		}

		echo json_encode(array('data'=>$res));
	}

	function shipmentmode(){
		$row = $this->config->item('shipment_mode');
		foreach($row as $k=>$v){
			$res[$k]['id']= $v;
			$res[$k]['text']= $v;
		}

		echo json_encode(array('data'=>$res));
	}

	function salutasi(){
		$row = $this->config->item('salutation');
		foreach($row as $k=>$v){
			$res[$k]['id']= $v;
			$res[$k]['text']= $v;
		}

		echo json_encode(array('data'=>$res));
	}



	function requestType(){
		$row = $this->config->item('request_type');
		foreach($row as $k=>$v){
			$res[$k]['id']= $v;
			$res[$k]['text']= $v;
		}

		echo json_encode(array('data'=>$res));
	}

	function petugas(){
		$data=array(
			array('id'=>USER_SADMIN, 'text'=>'Super Admin'),
			array('id'=>USER_GMF, 'text'=>'Admin GMF'),
			array('id'=>USER_GMF_RECEIVING, 'text'=>'Receiving'),
			array('id'=>USER_GMF_IMPORT, 'text'=>'Import'),
			array('id'=>USER_SALES, 'text'=>'Sales'),
			array('id'=>USER_PARTNER, 'text'=>'Forwarder'),
			array('id'=>USER_CUSTOMER, 'text'=>'Customer'),
			array('id'=>USER_GMF_LNM, 'text'=>'LNM'),
			array('id'=>USER_GMF_FINANCE, 'text'=>'Finance'),
		);

		echo json_encode(array('data'=>$data));
	}

	function getAutoId($fields,$table,$inisial){
		$query 	= $this->db_main->query('SELECT MAX('.$fields.') as max from '.$table);
		$result = current($query->result());
		$number = 0;
		$imax	= 9;
		$tmp  	= "";

		if($result->max !='')
			$number = substr($result->max, strlen($inisial));

		$number ++;
		$number = strval($number);
		for($i=1; $i<=($imax-strlen($inisial)-strlen($number)); $i++) {
			$tmp=$tmp."0";
		}

		return $inisial.$tmp.$number;
	}

	function cek_permit(){
		$app = $this->config->item('app');
		$this->db_main->select('id_petugas,sessionid,UNIX_TIMESTAMP(NOW()) dtimenow,UNIX_TIMESTAMP(dtimeexpired) dtimeexpired');
		$this->db_main->where('id_petugas',$this->session->userdata('user').$app);
		$stmt = $this->db_main->get('session');

		if ($stmt->num_rows() <=0){
			echo '<script type="text/javascript">
					alert("Sesi anda telah berakhir, Silakan Login kembali...");
					window.location.href = "'.site_url('user/log/out').'"; </script>';
		}

	}

	function set_barcode($kode='notext')
	{
		$this->zend->load('Zend/Barcode');
		return Zend_Barcode::render('code128', 'image', array('text'=>$kode), array());
	}

	function set_pdf($html=''){
		$this->fpdf->SetFont('Arial','B',18);
		$this->fpdf->WriteHTML($html);
		echo $this->fpdf->Output('sp.pdf','I');
	}

	function curency(){
		$data=array(
			array('id'=>'Rp.', 'text'=>'Rupiah – Indonesia')
		);

		echo json_encode(array('data'=>$data));
	}

	function shp_priority(){
		$data=array(
			array('id'=>'Normal', 'text'=>'Normal'),
			array('id'=>'AOG', 'text'=>'AOG')
		);

		echo json_encode(array('data'=>$data));
	}

	function packaging(){
		$calback= $_GET['callback'];
		$data=array(
			array('id'=>'Carton', 'packaging'=>'Carton'),
			array('id'=>'Loose', 'packaging'=>'Loose'),
			array('id'=>'Wooden Box', 'packaging'=>'Wooden Box'),
			array('id'=>'Others ', 'packaging'=>'Others')
		);

		echo $calback."(".json_encode($data).")";
	}

	function category_packaging(){
		$calback= $_GET['callback'];
		$data=array(
			array('id'=>'DG', 'cat_packaging'=>'DG'),
			array('id'=>'Non DG', 'cat_packaging'=>'Non DG')
		);

		echo $calback."(".json_encode($data).")";
	}

	// function packaging(){
	// 	$calback= $_GET['callback'];
	// 	$text ='';
	// 	if(isset($_GET['filter'])) {
	// 		$filter = $_GET['filter'];
	//
	// 		if(isset($_GET['filter']['filters'][0]['value']))
	// 			$text = $filter['filters'][0]['value'];
	// 	}
	// 	$data=array(
	// 		array('id'=>'Carton', 'text'=>'Carton'),
	// 		array('id'=>'Loose', 'text'=>'Loose'),
	// 		array('id'=>'Wooden Box', 'text'=>'Wooden Box'),
	// 		array('id'=>'Others ', 'text'=>'Others')
	// 	);
	// 	echo $calback."(".json_encode($res).")";
	// }

	function pbth(){
		$data=array(
			array('id'=>'No', 'text'=>'No'),
			array('id'=>'Yes', 'text'=>'Yes')
		);

		echo json_encode(array('data'=>$data));
	}

	function send_mail($mail_to,$mail_sbj,$mail_msg,$priority=FALSE){
		$config = $this->config->item('mail_account');
		if($priority)
			$config['priority'] = 1;

		$this->email->initialize($config);
		$this->email->from('lamsolusi25@gmail.com', 'GMF LOGISTIK - Mail System');
		$this->email->to($mail_to);
		$this->email->set_newline("\r\n");
		$this->email->subject($mail_sbj);
		$this->email->message($mail_msg);
		$this->email->send();
		$this->email->clear(TRUE);
	}

	function csm_mail_read(){
		$file = FCPATH.'/mailcsm.text';
		if (file_exists($file)){
			$text 	= file_get_contents($file);
			$textur = str_replace(PHP_EOL, '', $text);

		}
		return $textur;
	}

	function csm_mail_update(){
		$out['status'] = FALSE;
		$file 	= FCPATH.'/mailcsm.text';
		$text 	= $this->input->post('csm_email');
		if (file_exists($file)){
				file_put_contents($file,$text);
				$out['status'] 	= TRUE;
				$out['messages'] = 'Data Berhasil Disimpan';
		}else
				$out['messages'] = 'Gagal Memproses Data';

		echo json_encode($out);
	}

	function setings(){
		$data['csm_email'] = $this->csm_mail_read();

		$this->template->title(lang('titile_cfg'));
		$this->template->build('app/setings_view',$data);
	}

	public function upload() {
		$config['upload_path']          = FCPATH.'uploads/';
    $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';
		$data['status'] = FALSE;
		$this->load->library('upload', $config);

    if ($this->upload->do_upload('file')){
			$upload_data = $this->upload->data();
      $data['file'] = $upload_data['file_name'];
			$data['status'] = TRUE;
		}

		echo json_encode($data);
  }

	function remove_file(){
		$data = $this->input->post('filenamenew');
		print_r($data);
	}

}
