<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include '../cek-akses.php'; 

header("Content-type: application/vnd-ms-excel"); 
header("Content-Disposition: attachment; filename=Export-Category-Parent-The-Executive.xls");
?>

<table id="example" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
                <th>Parent ID</th>
                <th>Child ID</th>
                <th>Title</th>
        </tr>
    </thead>

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
    <?php endwhile;?>
    </tbody>
    
</table>