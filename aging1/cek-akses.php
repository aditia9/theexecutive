<?php
session_start();

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php';

if(!isset($_SESSION['my_user_agent']) || ($_SESSION['my_user_agent']!=md5($_SERVER['HTTP_USER_AGENT']))){
	//user belum login
	$__tipe_user = 'guest';
}else{
	$__tipe_user = $_SESSION['tipe_user'];
}
