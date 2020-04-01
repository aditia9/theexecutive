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
            <th>Status</th>
            <th>Link Image</th>
            <th>Date Active</th>
        </tr>
    </thead>

    <tbody>
    <?php
        $sql = "SELECT a.entity_id, a.created_at, b.product_id, a.sku, e.value, b.qty, b.is_in_stock, c.price, d.rule_id, f.discount_amount, e.value
            FROM catalog_product_entity a 
            LEFT JOIN cataloginventory_stock_item b ON b.product_id = a.entity_id 
            LEFT JOIN catalog_product_index_price c ON c.entity_id = a.entity_id 
            LEFT JOIN catalogrule_product d ON d.product_id = a.entity_id 
            LEFT JOIN catalog_product_entity_varchar e ON e.entity_id = a.entity_id 
            LEFT JOIN catalogrule f ON f.rule_id = d.rule_id 
            LEFT JOIN catalog_product_entity_int g ON g.entity_id = a.entity_id 
            WHERE a.type_id != 'configurable' AND c.customer_group_id = 3 AND e.attribute_id = 87 
            AND e.store_id = 0 AND g.attribute_id = 97 AND g.store_id = 0 AND g.value = 1 ORDER BY g.entity_id DESC";
        $query = $db->query($sql);
        while ($row = $query->fetch_assoc()) :
            $diskon = $row['discount_amount'];
            $price  = str_replace('.0000', '', $row['price']);
            $entity = $row['entity_id'];
            $calcu  = $price * $diskon / 100;
            $result = $price - $calcu;

            if($row['is_in_stock'] == 0){
                $available = 'Tidak Aktif';
            }else{
                $available = 'Aktif';
            }

        $sql2 = $db->query("SELECT value FROM catalog_product_entity_varchar WHERE attribute_id = 73 AND entity_id = $entity");
        $row2 = mysqli_fetch_array($sql2);
    ?>
        <tr>
            <td><?php echo $row['product_id'];?></td>
            <td><?php echo $row['sku'];?></td>
            <td><?php echo $row2['value'];?></td>
            <td><?php echo $result; ?></td>
            <td><?php echo $price; ?></td>
            <td><?php echo str_replace('.0000', '', $row['qty']);?></td>
            <td><?php echo $available;?></td>
            <td><?php echo 'http://theexecutive.co.id/pub/media/catalog/product'.$row['value'];?></td>
            <td><?php echo $row['created_at'];?></td>
        </tr>
    <?php endwhile;?>
    </tbody>
    
</table>