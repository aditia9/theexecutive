<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include '../cek-akses.php'; 

header("Content-type: application/vnd-ms-excel"); 
header("Content-Disposition: attachment; filename=Export-Tarik-Stock-The-Executive.xls");
?>

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

    <tbody>
    <?php
        $sql = "SELECT b.product_id, a.sku, e.value, b.qty, c.price, d.rule_id, f.discount_amount
                FROM catalog_product_entity a 
                LEFT JOIN cataloginventory_stock_item b ON b.product_id = a.entity_id 
                LEFT JOIN catalog_product_index_price c ON c.entity_id = a.entity_id 
                LEFT JOIN catalogrule_product d ON d.product_id = a.entity_id 
                LEFT JOIN catalog_product_entity_varchar e ON e.entity_id = a.entity_id 
                LEFT JOIN catalogrule f ON f.rule_id = d.rule_id 
                WHERE a.type_id != 'configurable' AND c.customer_group_id = 3 AND d.customer_group_id = 0 AND e.attribute_id = 73 
                AND e.store_id = 0 ORDER BY b.qty DESC";
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
    <?php endwhile;?>
    </tbody>
    
</table>