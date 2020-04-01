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
    $product_id = mysqli_real_escape_string($db, $data[0]); 
    $category_id = mysqli_real_escape_string($db, $data[1]); 

    $query = "INSERT INTO catalog_category_product_index (category_id, product_id, position, is_parent, store_id, visibility) VALUES($category_id, $product_id, 0, 1, 1, 4)";
    mysqli_query($db, $query);
    $query2 = "INSERT INTO catalog_category_product_index (category_id, product_id, position, is_parent, store_id, visibility) VALUES($category_id, $product_id, 0, 1, 2, 4)";
    mysqli_query($db, $query2);

    $query3 = "INSERT INTO catalog_category_product (category_id, product_id, position) VALUES($category_id, $product_id, 0)";
    mysqli_query($db, $query3);
   }
   fclose($handle);
   header("location: category.php?updation=1");
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

?>

<!DOCTYPE html>
<html>
 <head>
  <title>Change Category</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
  <br />
  <div class="container">
   <h2 align="center">Chage Category Theexecutive</a></h2>
   <br />
   <form method="post" enctype='multipart/form-data'>
    <p><label>Please Select File(Only CSV Formate)</label>
    <input type="file" name="product_file" /></p>
    <br />
    <input type="submit" name="upload" class="btn btn-info" value="Upload" />
   </form>
   <br />
   <?php echo $message; ?>
  </div>
 </body>
</html>