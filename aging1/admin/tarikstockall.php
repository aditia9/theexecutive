<?php
// memanggil file config.php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include '../cek-akses.php'; 
?>

<html>
<head>
    <title>Data Aging The Executive</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../buttons/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
</head>

<body>
<a href="/aging1/admin/index.php" class="btn btn-success btn-md">Back</a>
<a href="/aging1/admin/export_tarikstockall.php" class="btn btn-info btn-md">Export Data ke Excel</a>

    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>SKU</th>
                <th>Title</th>
                <th>Discount Price</th>
                <th>Price</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>SKU</th>
                <th>Title</th>
                <th>Discount Price</th>
                <th>Price</th>
                <th>Stock</th>
            </tr>
        </tfoot>
        <tbody>
        <?php

            $sql = "SELECT b.product_id, a.sku, e.value, b.qty, c.price, d.rule_id, f.discount_amount
            FROM catalog_product_entity a 
            LEFT JOIN cataloginventory_stock_item b ON b.product_id = a.entity_id 
            LEFT JOIN catalog_product_index_price c ON c.entity_id = a.entity_id 
            LEFT JOIN catalogrule_product d ON d.product_id = a.entity_id 
            LEFT JOIN catalog_product_entity_varchar e ON e.entity_id = a.entity_id 
            LEFT JOIN catalogrule f ON f.rule_id = d.rule_id 
            LEFT JOIN catalog_product_entity_int g ON g.entity_id = a.entity_id 
            WHERE a.type_id != 'configurable' AND c.customer_group_id = 3 AND d.customer_group_id = 0 AND e.attribute_id = 73 
            AND e.store_id = 0 AND g.attribute_id = 97 AND g.store_id = 0 AND g.value = 1 ORDER BY g.entity_id DESC";
            $query = $db->query($sql);
            while ($row = $query->fetch_assoc()) :
                $diskon = $row['discount_amount'];
                $price  = str_replace('.0000', '', $row['price']);
                $calcu  = $price * $diskon / 100;
                $result = $price - $calcu;
        ?>
            <tr>
                <td><?php echo $row['product_id'];?></td>
                <td><?php echo $row['sku'];?></td>
                <td><?php echo $row['value'];?></td>
                <td><?php echo $result; ?></td>
                <td><?php echo $price; ?></td>
                <td><?php echo str_replace('.0000', '', $row['qty']);?></td>
            </tr>
        <?php 
            endwhile;
        ?>
        </tbody>
    </table>

    <script type="text/javascript" src="../assets/js/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" src="../assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../buttons/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="../buttons/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script>
    $(document).ready(function() {
       $('#example').DataTable(
      {
        'iDisplayLength': 1000,
        dom: 'Bfrtip'
        });
    });
    </script>
</body>
</html>
