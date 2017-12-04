<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('encrypt')){
	function encrypt($str, $key) {
		if(strlen($key)==0) die('Gagal encrypt! Security key tidak boleh kosong.');
		$sz = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		$str = pkcs5_pad($str, $sz);
		$key = hex2bin($key);    
	 
		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, "", MCRYPT_MODE_CBC, "");
	 
		mcrypt_generic_init($td, $key, "awerfvb5koplku65");
		$encrypted = mcrypt_generic($td, $str);
	 
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
	 
		return bin2hex($encrypted);
	}
}
if ( ! function_exists('decrypt')){
	function decrypt($code, $key) {
		if(strlen($key)==0) die('Gagal decrypt! Security key tidak boleh kosong.');
		if($code=='') return '';
		$key = hex2bin($key);
		$code = hex2bin($code);

		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, "", MCRYPT_MODE_CBC, "");

		mcrypt_generic_init($td, $key, "awerfvb5koplku65");
		$decrypted = mdecrypt_generic($td, $code);

		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);

		return utf8_encode(pkcs5_unpad($decrypted));
	}
}
if ( ! function_exists('pkcs5_pad')){
	function pkcs5_pad ($text, $blocksize){
		$pad = $blocksize - (strlen($text) % $blocksize);
		return $text . str_repeat(chr($pad), $pad);
	}
}
if ( ! function_exists('pkcs5_unpad')){
	function pkcs5_unpad($text){
		$pad = ord($text{strlen($text)-1});
		if ($pad > strlen($text)) return false;
		if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;
		return substr($text, 0, -1 * $pad);
	}
}
if ( ! function_exists('hex2bin')){
	function hex2bin($hexdata) {
		$bindata = "";

		for ($i = 0; $i < strlen($hexdata); $i += 2) {
			$bindata .= chr(hexdec(substr($hexdata, $i, 2)));
		}

		return $bindata;
	}
}