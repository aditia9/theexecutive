<?php
$dbhost = 'localhost';
$dbuser = 'developm_magento';
$dbpass = 'magento123!';
$dbname = 'developm_magento';
 
/** koneksi ke database */
$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
 
// check koneksi
if ($db->connect_error) {
	die('Oops!! Terjadi error : ' . $db->connect_error);
}
?>