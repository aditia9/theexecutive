<html>
    <head>
    </head>

</html>
<?php
require 'config.php'; 
error_reporting(E_ALL && ~E_NOTICE);
if (!isset($_SERVER[HTTP_REFERER]))
{
    ?>
    <script type="text/javascript">document.location="/"</script>
<?php
   
}

// define variables and set to empty values
$to = "wahyudi.ecommerce@delamibrands.com";
$email = $_POST['email'];
$namacust = $_POST['namacustomer'];
$noorder= $_POST['noorder'];
$totalorder  = $_POST['totalorder'];
$refund = $_POST['refund'];
$alasan = $_POST['alasan'];
$namarek= $_POST['namarekening'];
$norek  = $_POST['norek'];
$namabank = $_POST['namabank'];
$cabang = $_POST['cabang'];
$message = "Hai ".$namacust.", Anda telah submit form refund, kami akan segera proses pengembalian dana setelah barang kami terima.  Nomor Order Anda ".$noorder. ", Jumlah ".$totalorder. ", Alasan Refund ".$alasan;
$message2 = "This is Customer Request Refund ".$noorder. ", Nama Customer " .$namacust.", Jumlah ".$totalorder. ", Alasan Refund ".$alasan.", Nomor Rekening : ".$norek. ", Bank : ".$namabank.", Cabang : ".$cabang. ", Atas Nama : ".$namarek;
$subject = "Form Refund";
$sql = "INSERT INTO refund (email,nama_customer,noorder,total_order,refund,alasan,nama_rekening,norek,nama_bank,cabang,date) VALUES ('$email','$namacust','$noorder',$totalorder,$refund,'$alasan','$namarek','$norek','$namabank','$cabang',now())";
$query = $db->query($sql);
//$sql1= "INSERT INTO sales_order_status_history (parent_id, is_customer_notified, is_visible_on_front, comment, status, entity_name) VALUES ('$noorder', '1','1', 'Proses Return Request', 'return_pending', 'order')";
//$query = $db->query($sql1);
//$sql2= "update sales_order set status='return_pending' where entity_id=$noorder";
$query = $db->query($sql2);
$headers = "From:" . $email;
$headers2 = "From:" . $to;
mail($to,$subject,$message2,$headers);
mail($email,$subject,$message,$headers2); // sends a copy of the message to the sender
if ($query->connect_error) {
	die('Oops!! Sorry : ' . $query->connect_error);
} 
else
    {
            echo "<p align='center'> <font color=black  size='12pt'>Mail Sent. Thank you " . $namacust . ", we will contact you shortly.</font> </p>" ;
             
			echo "<br>What a nice day!".$noorder;

    }


?>