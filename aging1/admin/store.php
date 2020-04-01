<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include '../cek-akses.php'; 
?>
<html>
<head>
    <title>Store xlsx</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="../buttons/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
</head>

<body>

        <a href="/admin/index.php" class="btn btn-success btn-xs">Back</a>
    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Availability</th>
                <th>Condition</th>
                <th>Title</th>
                <th>Title English</th>
                <th>Title Translate</th>
                <th>Description</th>
                <th>Link</th>
                <th>Image Link</th>
                <th>Price</th>
                <th>Gtin</th>
                <th>MPN</th>
                <th>Brand</th>
                <th>Item Group Id</th>                
                <th>Item Group Id Translate</th>                
                <th>Google Product Category</th>                
                <th>size</th>                
                <th>color</th>
                <th>color Translate</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Availability</th>
                <th>Condition</th>
                <th>Title</th>
                <th>Title English</th>
                <th>Title Translate</th>
                <th>Description</th>
                <th>Link</th>
                <th>Image Link</th>
                <th>Price</th>
                <th>Gtin</th>
                <th>MPN</th>
                <th>Brand</th>
                <th>Item Group Id</th>                
                <th>Item Group Id Translate</th>                
                <th>Google Product Category</th>                
                <th>size</th>                
                <th>color</th>
                <th>color Translate</th>
            </tr>
        </tfoot>
        <tbody>
        <?php
        $sql = "SELECT a.entity_id, a.sku, b.product_id, b.is_in_stock, c.value as name, f.value as warna, g.value as deskripsi
        FROM catalog_product_entity a 
        LEFT JOIN cataloginventory_stock_item b ON b.product_id = a.entity_id 
        LEFT JOIN catalog_product_entity_varchar c ON c.entity_id = a.entity_id 
        LEFT JOIN catalog_product_entity_int e ON e.entity_id = a.entity_id 
        LEFT JOIN eav_attribute_option_value f ON f.option_id = e.value
        LEFT JOIN catalog_product_entity_text g ON g.entity_id = a.entity_id
        WHERE b.product_id != 'NULL' AND c.attribute_id = 73 AND c.store_id = 0
        AND e.attribute_id = 93 AND f.store_id = 0 AND g.attribute_id = 76 AND g.store_id = 0 ORDER BY a.entity_id DESC LIMIT 100";


        $query = $db->query($sql);
        while($row = $query->fetch_assoc()):
            $id      = $row['entity_id'];
            $sku     = substr($row['sku'], 0, -1);
            $explode = explode("-", $row['name']);

            if(strlen($row['sku']) == 11){
                $sku = $row['sku'];
                $id  = $row['entity_id']-1;

                $sql4 = $db->query("SELECT b.rule_price FROM catalog_product_entity a
                    LEFT JOIN catalogrule_product_price b ON b.product_id = a.entity_id WHERE b.product_id = $id AND b.rule_price != 0");
                $row4 = mysqli_fetch_array($sql4);
            }else{
                $sku = substr($row['sku'], 0, -1);

                $sql4 = $db->query("SELECT b.rule_price FROM catalog_product_entity a
                    LEFT JOIN catalogrule_product_price b ON b.product_id = a.entity_id WHERE b.product_id = $id AND b.rule_price != 0");
                $row4 = mysqli_fetch_array($sql4);
            }

            if($row['deskripsi'] == '' && $row['deskripsi'] == NULL){
                $desc = $explode[0];
            }else{
                $desc = htmlspecialchars($row['deskripsi']);
            }

            if($row['is_in_stock'] == 0){
                $available = 'out of stock';
            }else{
                $available = 'in stock';
            }

            $sql2 = $db->query("SELECT b.value FROM catalog_product_entity a
                LEFT JOIN catalog_product_entity_varchar b ON b.entity_id = a.entity_id WHERE b.attribute_id = 119 AND a.sku = $sku");
            $row2 = mysqli_fetch_array($sql2);

            $sql3 = $db->query("SELECT b.value FROM catalog_product_entity a
                LEFT JOIN catalog_product_entity_varchar b ON b.entity_id = a.entity_id WHERE b.attribute_id = 87 AND a.sku = $sku");
            $row3 = mysqli_fetch_array($sql3);


            if(ucwords(strtolower($explode[0])) == 'Long Pants 1'){
                $link  = 'http://theexecutive.co.id/catalog/product/view/id/153706/s/long-pants-1-lprbsc516o005-black/';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/2/1/21635_4.jpg';
            }else{
                $link  = 'http://theexecutive.co.id/'.$row2['value'].'.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product'.$row3['value'];
            }

            if(substr($row4['rule_price'], 0, -2) == 0){
                $harga = 0;
            }else{
                $harga = substr($row4['rule_price'], 0, -2);
            }

            if(ucwords(strtolower($desc)) == ''){
                $desc = ucwords(strtolower($explode[0]));
            }else{
                $desc = ucwords(strtolower($desc));
            }
        ?>
            <tr>
                <td><?php echo $row['sku'];?></td>
                <td><?php echo $available;?></td>
                <td><?php echo 'new'?></td>
                <td><?php echo ucwords(strtolower($explode[0]));?></td>
                <td><?php echo 'The Executive '.ucwords(strtolower($explode[0]));?></td>
                <td><?php echo 'The Executive '.$googletranslate;?></td>
                <td><?php echo $desc;?></td>
                <td><?php echo $link;?></td>
                <td><?php echo $image;?></td>
                <td><?php echo $harga. ' IDR';?></td>
                <td><?php echo ''?></td>
                <td><?php echo ''?></td>
                <td><?php echo 'Executive Online'?></td>
                <td><?php echo ucwords(strtolower($explode[0]));?></td>
                <td><?php echo $googletranslate;?></td>
                <td><?php echo 1604;?></td>
                <td><?php echo ucwords(strtolower($explode[1]));?></td>
                <td><?php echo ucwords(strtolower($row['warna']));?></td>
                <td><?php echo $colortranslate;?></td>
            </tr>
        <?php endwhile;?>
        </tbody>
    </table>
    <script type="text/javascript" src="../assets/js/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" src="../assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../buttons/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.13/filtering/row-based/range_dates.js"></script>
    <script type="text/javascript" src="../buttons/js/buttons.html5.min.js"></script>        
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script>

    $(document).ready(function() {
       $('#example').DataTable(
      {
        'iDisplayLength': 1000,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]});
        
 
      // Add event listeners to the two range filtering inputs
      $('#min').keyup( function() { table.draw(); } );
      $('#max').keyup( function() { table.draw(); } );
    });
    </script>

</body>
</html>