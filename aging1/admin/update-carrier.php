<?php
// memanggil file config.php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include '../cek-akses.php'; 

$message = '';
if(isset($_POST["upload"])) {
 if($_FILES['product_file']['name']){
  $filename = explode(".", $_FILES['product_file']['name']);
  if(end($filename) == "csv"){
   $handle = fopen($_FILES['product_file']['tmp_name'], "r");
   while($data = fgetcsv($handle)){
    $id      = mysqli_real_escape_string($db, $data[0]);
    $kurir   = mysqli_real_escape_string($db, $data[1]);
    $prov    = mysqli_real_escape_string($db, $data[2]);
    $city    = mysqli_real_escape_string($db, $data[3]);
    $rate    = mysqli_real_escape_string($db, $data[4]);  
    $date    = date('Y-m-d H:i:s');

    if($id!=""){
      $query = "UPDATE hypework_shipping_rates SET rate = $rate WHERE entity_id = $id";
      mysqli_query($db, $query);  
    }else{
          $update   = $db->query("SELECT region_id FROM directory_country_region WHERE default_name = '$prov'");
          $rows     = mysqli_fetch_array($update);
          $idregion = $rows['region_id'];
          $update2  = $db->query("SELECT entity_id FROM hypework_shipping_carrier WHERE name = '$kurir'");
          $rows2    = mysqli_fetch_array($update2);
          $idkurir  = $rows2['entity_id'];
          
        $insertqty = "INSERT into hypework_shipping_city (region_id, name, created_at, updated_at) VALUES('$idregion', '$city', '$date', '$date')";
        mysqli_query($db, $insertqty);

          $update   = $db->query("SELECT entity_id FROM hypework_shipping_city WHERE region_id = '$idregion' AND name = '$city'");
          $data     = mysqli_fetch_array($update);
          $idcity   = $data['entity_id'];

        $insert = "INSERT into hypework_shipping_rates (carrier_id, region_id, city_id, district_id, subdistrict_id, rate, created_at, updated_at) 
        VALUES('$idkurir', '$idregion', '$idcity', '0', '0', '$rate', '$date', '$date')";
        mysqli_query($db, $insert);  
    }

   }
   fclose($handle);
   header("location: update-carrier.php");
  }else{
   $message = '<label class="text-danger">Please Select CSV File only</label>';
  }
 }else{
  $message = '<label class="text-danger">Please Select File</label>';
 }
}

if(isset($_GET["updation"])){
 $message = '<label class="text-success">Product Updation Done</label>';
}


if(isset($_POST["btn_carrier"])) {
    $id = $_POST['carrier'];
    $sql3 = "SELECT a.entity_id, a.rate, b.name, c.default_name, d.name as carrier
        FROM hypework_shipping_rates a 
        LEFT JOIN hypework_shipping_city b ON b.entity_id = a.city_id 
        LEFT JOIN directory_country_region c ON c.region_id = a.region_id 
        LEFT JOIN hypework_shipping_carrier d ON d.entity_id = a.Carrier_id 
        WHERE d.status = 1 and d.entity_id = $id ORDER BY c.default_name DESC LIMIT 100";
    $query3 = $db->query($sql3);    
}else{
    $id =  1;
    $sql3 = "SELECT a.entity_id, a.rate, b.name, c.default_name, d.name as carrier
        FROM hypework_shipping_rates a 
        LEFT JOIN hypework_shipping_city b ON b.entity_id = a.city_id 
        LEFT JOIN directory_country_region c ON c.region_id = a.region_id 
        LEFT JOIN hypework_shipping_carrier d ON d.entity_id = a.Carrier_id 
        WHERE d.status = 1 and d.entity_id = $id ORDER BY c.default_name DESC LIMIT 100";
    $query3 = $db->query($sql3);     
}
?>

<!DOCTYPE html>
<html>
 <head>
  <title>Update Rate Carrier</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
  <br />
  <div class="container">
   <h2 align="center">Update Rate Carrier Theexecutive</a></h2>
   <br />
   <form method="post" enctype='multipart/form-data'>
    <p><label>Please Select File(Only CSV Formate)</label>
    <input type="file" name="product_file" /></p>
    <br />
    <input type="submit" name="upload" class="btn btn-success" value="Upload" />
   </form>
   <br />
   <?php echo $message; ?>
   <br />
   <div class="table-responsive">

   <form method="post" enctype='multipart/form-data'>
    <div class="form-group">
      <select class="form-control" id="carrier" name="carrier">
        <option>-- Select Carrier --</option>
        <?php
          $sql2 = "SELECT entity_id, name FROM hypework_shipping_carrier WHERE status = 1";
          $query2 = $db->query($sql2);     
           while($row = mysqli_fetch_array($query2)){
            echo"<option value=".$row['entity_id'].">".strtoupper($row['name'])."</option>";
           }
        ?>
      </select><br>
    <input type="submit" name="btn_carrier" class="btn btn-info" value="Search" />
    <a href="/admin/export-update-carrier.php?carrier=<?php echo $id; ?>" class="btn btn-warning btn-md">Export Data ke Excel</a>
    </div>
  </form>

    <table class="table table-bordered table-striped">
     <tr>
          <th>No</th>
          <th>Carrier</th>
          <th>State/Province</th>
          <th>City</th>
          <th>Price</th>
     </tr>
     <?php
     while($row = mysqli_fetch_array($query3))
     {
      echo '
      <tr>
       <td>'.$row["entity_id"].'</td>
       <td>'.strtoupper($row["carrier"]).'</td>
       <td>'.$row["default_name"].'</td>
       <td>'.$row["name"].'</td>
       <td>'.$row["rate"].'</td>
      </tr>
      ';
     }
     ?>
    </table>
   </div>
  </div>
 </body>
</html>