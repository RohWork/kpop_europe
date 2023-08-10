<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// alert만
function alert_only($msg, $exit=TRUE){
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=\"utf-8\">";
	echo "<script type='text/javascript' charset='utf-8'> alert( decodeURI('". $msg."')); </script>";
	if($exit) exit;
}

// alert 띄우고 창닫기
function alert_close($msg){
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=\"utf-8\">";
	echo "<script type='text/javascript' charset='utf-8'> alert( decodeURI('".$msg."')); window.close(); </script>";
	exit;
}

// alert 띄우고 이동
function alert_move($msg, $geturl, $exit=TRUE){
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=\"utf-8\">";
	echo "<script type='text/javascript' charset='utf-8'> alert( decodeURI('".$msg."'));location.href='".$geturl."'; </script>";
	if($exit) exit;
}

// alert 띄우고 뒤로 이동
function alert_back($msg, $exit=TRUE){
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=\"utf-8\">";
	echo "<script type='text/javascript' charset='utf-8'> alert( decodeURI('".$msg."'));history.back();</script>";
	if ($exit) exit;
}