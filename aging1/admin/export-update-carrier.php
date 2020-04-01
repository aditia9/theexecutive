<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include '../cek-akses.php'; 

header("Content-type: application/vnd-ms-excel"); 
header("Content-Disposition: attachment; filename=Export-Carrier-The-Executive.xls");
?>

<table id="example" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Carrier</th>
            <th>Province</th>
            <th>City</th>
            <th>Price</th>
        </tr>
    </thead>

    <tbody>
    <?php
    	$id = $_GET['carrier'];
        $sql = "SELECT a.entity_id, a.rate, b.name, c.default_name, d.name as carrier
            FROM hypework_shipping_rates a 
            LEFT JOIN hypework_shipping_city b ON b.entity_id = a.city_id 
            LEFT JOIN directory_country_region c ON c.region_id = a.region_id 
            LEFT JOIN hypework_shipping_carrier d ON d.entity_id = a.Carrier_id 
            WHERE d.status = 1 and d.entity_id = $id ORDER BY c.default_name DESC";
        $query = $db->query($sql);
        while ($row = $query->fetch_assoc()) :
    ?>
        <tr>
            <td><?php echo $row['entity_id'];?></td>
            <td><?php echo $row['carrier'];?></td>
            <td><?php echo $row['default_name'];?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['rate']; ?></td>
        </tr>
    <?php endwhile;?>
    </tbody>
    
</table>