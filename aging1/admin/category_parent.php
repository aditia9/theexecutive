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
<a href="/admin/index.php" class="btn btn-success btn-md">Back</a>
<a href="/admin/export_category_parent.php" class="btn btn-info btn-md">Export Data ke Excel</a>

    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Parent ID</th>
                <th>Child ID</th>
                <th>Title</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>SKU</th>
                <th>Title</th>
            </tr>
        </tfoot>
        <tbody>
        <?php

            $sql = "SELECT a.parent_id, a.product_id, b.value 
           	FROM catalog_product_super_link a
           	LEFT JOIN catalog_product_entity_varchar b ON b.entity_id = a.product_id WHERE b.attribute_id = 73 ORDER BY a.product_id DESC";
            $query = $db->query($sql);
            while ($row = $query->fetch_assoc()) :
        ?>
            <tr>
                <td><?php echo $row['parent_id'];?></td>
                <td><?php echo $row['product_id'];?></td>
                <td><?php echo $row['value'];?></td>
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