<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include '../cek-akses.php'; 
$idproduct=$_POST['id_product'];
$transdate = date('Y-m-d H:i:s');
$sql="UPDATE ps_product SET date_add='$transdate' WHERE id_product=$idproduct";
$query = $db->query($sql);
if ($query){
    echo "<script>alert('Update Berhasil Boss')
    location.replace('/admin/ubahtanggal.html')</script>";
        }
 else
 {
    echo "<script>alert('Update Gagal Boss')
    location.replace('/admin/ubahtanggal.html')</script>";
}
?>