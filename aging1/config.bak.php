<?php
if(!defined('__NOT_DIRECT')){
	//mencegah akses langsung ke file ini
	die('Akses langsung tidak diizinkan!');
}

define('BASE_URL', '/'); 
//koneksi database
define('DB_HOST','theexecutive.co.id');
define('DB_USER','theexecu_shop');
define('DB_PASS', 'Delami@123#');
define('DB_NAME' ,'theexecu_magentoori');
$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);