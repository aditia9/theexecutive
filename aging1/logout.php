<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include 'cek-akses.php';

unset($_SESSION['tipe_user']); 
unset($_SESSION['user_id']);
unset($_SESSION['my_user_agent']);

session_destroy();
setcookie(session_name(), '', time() - 3600);
header("Location: /");
