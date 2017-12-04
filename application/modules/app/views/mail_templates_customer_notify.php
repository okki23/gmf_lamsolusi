<?php 
	$isi='Dear '.$customer.' <br><br> Berikut ini adalah informasi request yang telah terjadi di sistem Logistik GMF :<br><br>';
	$isi=$isi.'Tanggal, Jam&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: '.date("d F Y H:i:s").'<br>';
	$isi=$isi.'Jenis Request&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: '.$jenis_transaksi.' <br>';
	$isi=$isi.'No Request&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: '.$request_no.' <br>';
	
	$isi=$isi.'Id Sales Pemroses&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: '.$proses_user.'<br>';
	$isi=$isi.'Nama Sales Pemroses&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: '.$proses_user_name.'<br>';
	$isi=$isi.'Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Sukses<br><br>';

	$isi=$isi.'Semoga informasi ini dapat bermanfaat bagi anda. <br>';
	$isi=$isi.'Untuk informasi lebih lanjut, silakan menghubungi kami melalui telepon '.$sales_phone.' <br>';
	$isi=$isi.'atau email '.$sales_email.' <br><br>';
						
	$isi=$isi.'Dengan senang hati kami akan melayani anda. <br><br>';
	$isi=$isi.'Terima kasih. <br><br>';
	$isi=$isi.'Hormat Kami, <br>';
	$isi=$isi.'GMF Mail System<br><br>';
	$isi=$isi.'Email ini dihasilkan oleh komputer dan tidak perlu dijawab kembali<br>ke alamat email di atas.';
	$isi='<div style="font-family: Fixed Width,lucida console;">'.$isi.'</div>';
	echo $isi;
?>