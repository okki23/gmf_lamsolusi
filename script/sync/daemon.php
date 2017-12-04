<?php
// Make sure it's run from CLI
if(php_sapi_name() != 'cli' && !empty($_SERVER['REMOTE_ADDR'])) exit("Access Denied.");	

// Please configure this
$url = "http://ec2-54-169-207-187.ap-southeast-1.compute.amazonaws.com/logistik/";

fclose(fopen($url."/index.php/sync/index/", "r"));

?>
