<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

/* configurasi user permission */
define('ALLOWED_USER','10,20,21,22,23,30,40,50,24');
define('USER_SADMIN',10);
define('USER_GMF',20);
define('USER_GMF_RECEIVING',21);
define('USER_GMF_IMPORT',22);
define('USER_GMF_LNM',23);
define('USER_GMF_FINANCE',24);
define('USER_SALES',30);
define('USER_CUSTOMER',40);
define('USER_PARTNER',50);

/* configurasi sistem aplikasi */
$config['version'] 		= '1.0.0';
$config['app'] 			= 'logistik';
$config['usexpired'] 	= 90; //day
$config['shipment_mode']= array('Air','Land','Sea');
$config['incoterm']		= array('CFR','CIF','CPT','CIP');
$config['request_type']	= array('IMPORT','EXPORT','DOMESTIC DISTRIBUTION','WAREHOUSE LEASE','CUSTOM CLEARANCE','PACKAGING','INTERNAL DISTRIBUTION');
$config['salutation']	= array('Mr.','Mrs.','Ms.');



$file 	= FCPATH.'/mailcsm.text';
$text 	= file_get_contents($file);
$textur = str_replace(PHP_EOL, '', $text);

$config['mail_account']= Array( 'protocol' => 'smtp', 'smtp_host' => 'ssl://smtp.googlemail.com', 'smtp_port' => 465, 'smtp_user' => 'lamsolusi25@gmail.com', 'smtp_pass' => '1qaz2wsx3ed', 'mailtype'  => 'html', 'charset'   => 'iso-8859-1', 'wordwrap' => TRUE);
$config['mail_notify_csm'] = explode(',',$textur);//array('lesmanasata@gmail.com','lesmana@lamsolusi.com');

/* configurasi menu */
$config['list_menu'] = array(
	'dashboard/index'=>array('Dashboard',array(USER_GMF_FINANCE,USER_GMF_LNM,USER_PARTNER,USER_SADMIN,USER_GMF,USER_SALES,USER_CUSTOMER,USER_GMF_RECEIVING,USER_GMF_IMPORT)),
	'lnm/index'=>array('Assign Price',array(USER_GMF_LNM)),
	'master/master'=>array('Master Data',array(USER_SADMIN,USER_GMF),
		array(
			'master/customer'=>array('Customer Database',array(USER_SADMIN,USER_GMF)),
			'master/partner'=>array('Customer Partner',array(USER_SADMIN,USER_GMF)),
			'master/forwarder'=>array('Forwarder Management',array(USER_SADMIN,USER_GMF)),
			'master/sales'=>array('Sales Management',array(USER_SADMIN,USER_GMF)),
			'master/petugas'=>array('User Management',array(USER_SADMIN,USER_GMF)),
			'master/port'=>array('Maintenance Port',array(USER_SADMIN,USER_GMF)),
			'app/setings'=>array('App Setings',array(USER_SADMIN,USER_GMF)),
		),
	),
	'customer/customer'=>array('Customer',array(USER_CUSTOMER,USER_SALES),
		array(
			'customer/request'=>array('Request Creation',array(USER_CUSTOMER,USER_SALES)),
			'customer/approve'=>array('Request Approve',array(USER_CUSTOMER)),
			'customer/tracking'=>array('Tracking Shipment',array(USER_CUSTOMER)),
			'rpt/index'=>array('Request Report',array(USER_CUSTOMER,USER_SALES)),
		),
	),
	'sales/index'=>array('Sales Activity',array(USER_SALES)),
	'shipment/index'=>array('Shipment',array(USER_GMF,USER_PARTNER,USER_GMF_RECEIVING,USER_GMF_IMPORT),
		array(
			'shipment/index'=>array('Shipment Request',array(USER_GMF,)),
			'shipment/request'=>array('Open Request',array(USER_PARTNER)),
			'shipment/maintenance'=>array('Shipment Maintenance',array(USER_PARTNER)),
			'shipment/monitoring'=>array('Shipment Monitoring',array(USER_GMF,USER_PARTNER,USER_GMF_IMPORT)),
			'shipment/generatesp'=>array('Generate SP',array(USER_GMF,USER_GMF_RECEIVING,USER_GMF_IMPORT)),
		),
	),
	'finance/index'=>array('Finance',array(USER_GMF_FINANCE),
		array(
			'finance/index'=>array('COPA',array(USER_GMF_FINANCE)),
			'finance/copa'=>array('Lock / Unlock COPA',array(USER_GMF_FINANCE)),
		),
	),
	'tools/index'=>array('Tools',array(USER_SADMIN),
		array(
			'tools/session'=>array('User Monitoring',array(USER_SADMIN))
		),
	),
);
