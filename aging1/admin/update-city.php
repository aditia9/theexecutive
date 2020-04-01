<?php
// memanggil file config.php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include '../cek-akses.php'; 

//index.php
$message = '';

if(isset($_POST["upload"]))
{
 if($_FILES['product_file']['name'])
 {
  $filename = explode(".", $_FILES['product_file']['name']);
  if(end($filename) == "csv")
  {
   $handle = fopen($_FILES['product_file']['tmp_name'], "r");
   while($data = fgetcsv($handle))
   {
    $carrier    = mysqli_real_escape_string($db, $data[0]);
    $kecamatan  = mysqli_real_escape_string($db, $data[1]);  
    $kabupaten  = mysqli_real_escape_string($db, $data[2]);  
    $kata     = ucfirst($carrier).', '.ucfirst($kecamatan).' '.ucfirst($kabupaten);

    $query = $db->query("SELECT name FROM hypework_shipping_city where name = '$kata'");


    if($qty == 0){
      $status = 0;
    }else{
      $status = 1;
    }

    // $query = "UPDATE cataloginventory_stock_item SET qty = $qty, is_in_stock = $status WHERE product_id = $product_id";
    // mysqli_query($db, $query);
    // $query2 = "UPDATE catalog_product_index_price SET price=$harga, final_price=$harga, min_price=$harga, max_price=$harga, tier_price=$harga WHERE entity_id = $product_id";
    // mysqli_query($db, $query2);
    // $query3 = "UPDATE catalog_product_entity_decimal SET value=$harga WHERE entity_id = $product_id AND attribute_id = 77";
    // mysqli_query($db, $query3);
   }
   fclose($handle);
   header("location: update.php?updation=1");
  }
  else
  {
   $message = '<label class="text-danger">Please Select CSV File only</label>';
  }
 }
 else
 {
  $message = '<label class="text-danger">Please Select File</label>';
 }
}

if(isset($_GET["updation"]))
{
 $message = '<label class="text-success">Product Updation Done</label>';
}
?>

<!DOCTYPE html>
<html>
 <head>
  <title>Update City</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
  <br />
  <div class="container">
   <h2 align="center">Update City Courier Theexecutive</a></h2>
   <br />
   <form method="post" enctype='multipart/form-data'>
    <p><label>Please Select File(Only CSV Formate)</label>
    <input type="file" name="product_file" /></p>
    <br />
    <input type="submit" name="upload" class="btn btn-info" value="Upload" />
   </form>
   <br />
   <?php echo $message; ?>
   <h3 align="center">Update City</h3>
   <br />
   <br />
   <div class="table-responsive">
    <table class="table table-bordered table-striped">
     <tr>
      <th>Courier ID</th>
      <th>Kecamatan</th>
      <th>Kabupaten/Kota</th>
     </tr>
     <?php
      $sql = $db->query("SELECT name FROM  hypework_shipping_city");
      while($row = mysqli_fetch_array($sql)){ 
      $pecah = explode(",", $row['name']);
      echo"
      <tr>
       <td>8</td>
       <td>$pecah[0]</td>
       <td>$pecah[1]</td>
      </tr>
      ";
     }
     ?>
    </table>
   </div>
  </div>
 </body>
</html>