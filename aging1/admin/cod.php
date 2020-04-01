<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include '../cek-akses.php'; 
?>
<html>
<head>
    <title>Payment Cash On Delivery The Executive</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="../buttons/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
</head>

<body>

    <a href="/aging1/admin/index.php" class="btn btn-success btn-xs">Back</a>
    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>NO</th>
                <th>Brand</th>
                <th>No Order</th>
                <th>Order Date</th>
                <th>Customer Name</th>
                <th>Brand</th>
                <th>SKU</th>
                <th>Article-Color-Size</th>
                <th>Qty</th>
                <th>Amount</th>
                <th>Tag Price Ecomm</th>
                <th>reduction ecomm</th>
                <th>voucher ecomm</th>
                <th>Net Amount</th>                
                <th>Shipping Cost</th>                
                <th>Logistik</th>                
                <th>Payment</th>                
                <th>Card Type</th>
                <th>CC No</th>
                <th>Bank</th>
                <th>Receiver's name</th>
                <th>Address 1</th>
                <th>City</th>
                <th>Province</th>
                <th>Country</th>
                <th>Postal Code</th>
                <th>Phone Number</th>

            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>NO</th>
                <th>Brand</th>
                <th>No Order</th>
                <th>Order Date</th>
                <th>Customer Name</th>
                <th>Brand</th>
                <th>SKU</th>
                <th>Article-Color-Size</th>
                <th>Qty</th>
                <th>Amount</th>
                <th>Tag Price Ecomm</th>
                <th>reduction ecomm</th>
                <th>voucher ecomm</th>
                <th>Net Amount</th>                
                <th>Shipping Cost</th>                
                <th>Logistik</th>                
                <th>Payment</th>                
                <th>Card Type</th>
                <th>CC No</th>
                <th>Bank</th>
                <th>Receiver's name</th>
                <th>Address 1</th>
                <th>Address 2</th>
                <th>City</th>
                <th>Province</th>
                <th>Country</th>
                <th>Postal Code</th>
                <th>Phone Number</th>
            </tr>
        </tfoot>
        <tbody>
        <?php
        $sql = "SELECT distinct sog.entity_id, sog.increment_id, sog.grand_total, sog.created_at, sog.billing_name, sog.shipping_information, 
        LEFT(sog.shipping_information,LOCATE(' ',sog.shipping_information) - 1) as kurir, sog.shipping_and_handling, sog.shipping_name,
        soa.street, soa.city, SUBSTRING_INDEX(soa.city, ',', -1) as city1, soa.postcode, soa.telephone, soa.region,
        a.order_id, a.sku, a.qty_ordered, a.name as productname, b.price, b.base_price, b.base_original_price, b.base_original_price-b.price AS discount, 
        b.discount_amount AS 'DiscountAmount', b.price - b.discount_amount as net_amount, so.base_discount_amount as diskonkupon
        FROM sales_order_item AS a 
        LEFT JOIN sales_order_item AS b on ((a.order_id = b.order_id) and (a.sku=b.sku) and (b.parent_item_id is null))
        LEFT JOIN sales_order_grid sog ON sog.entity_id=a.order_id
        LEFT JOIN sales_order_address soa ON sog.entity_id=soa.parent_id
        LEFT JOIN sales_order so ON a.order_id=so.entity_id
        WHERE (a.parent_item_id is null) and sog.payment_method='cashondelivery' and soa.address_type='shipping' and  sog.status !='canceled' and 
        sog.created_at BETWEEN NOW() - INTERVAL 8 DAY AND NOW()";

// SELECT distinct sog.entity_id, sog.increment_id, sog.grand_total, sog.created_at, sog.billing_name, sog.shipping_information, 
// LEFT(sog.shipping_information,LOCATE(' ',sog.shipping_information) - 1) as kurir, sog.shipping_and_handling, sog.shipping_name,
// soa.street, soa.city, SUBSTRING_INDEX(soa.city, ',', -1) as city1, soa.postcode, soa.telephone, soa.region,
// a.order_id, a.sku, a.qty_ordered, a.name as productname, b.price, b.base_price, b.base_original_price, b.base_original_price-b.price AS discount, 
// b.discount_amount AS 'DiscountAmount', 
// b.price - b.discount_amount as net_amount, so.base_discount_amount as diskonkupon
// FROM sales_order_item AS a 
// LEFT JOIN sales_order_item AS b on ((a.order_id = b.order_id) and (a.sku=b.sku) and (b.parent_item_id is null))
// LEFT JOIN sales_order_grid sog ON sog.entity_id=a.order_id
// LEFT JOIN sales_order_address soa ON sog.entity_id=soa.parent_id
// LEFT JOIN sales_order so ON a.order_id=so.entity_id
// WHERE (a.parent_item_id is not null) and sog.payment_method='cashondelivery' and sog.status !='canceled' and 
// sog.created_at BETWEEN NOW() - INTERVAL 13 DAY AND NOW()

        $query = $db->query($sql);
        $noUrut=1;
        while($row = $query->fetch_assoc()):
            $kode  = $row['entity_id'];
            $sql2  = $db->query("SELECT order_id FROM sales_order_item WHERE order_id = $kode and parent_item_id != ''");
            $count = mysqli_num_rows($sql2);
            
            if($row['diskonkupon'] <= 0){
                $diskon = str_replace("-","",$row['diskonkupon'])/$count;
            }else{
                $diskon = str_replace("-","",$row['DiscountAmount'])/$count;
            }
        ?>
            <tr>
                <td><?php echo $noUrut; ?></td>
                <td><?php echo "700000";?></td>
                <td><?php echo $row['increment_id'];?></td>
                <td><?php echo $row['created_at'];?></td>
                <td><?php echo $row['billing_name'];?></td>
                <td><?php echo "The Executive";?></td>
                <td><?php echo $row['sku'];?></td>
                <td><?php echo $row['productname'];?></td>
                <td><?php echo number_format($row['qty_ordered'],0,",","");?></td>
                <td><?php echo number_format($row['grand_total'],0,",","");?></td>
                <td><?php echo number_format($row['base_original_price'],0,",","");?></td>
                <td><?php echo number_format($row['discount'],0,",","");?></td>
                <td><?php echo number_format($diskon,0,",","");?></td>
                <td><?php echo number_format($row['net_amount'],0,",","");?></td>
                <td><?php echo number_format($row['shipping_and_handling'],0,",","");?></td>
                <td><?php echo "COD";?></td>
                <td><?php echo "T";?></td>
                <td><?php echo "";?></td>
                <td><?php echo "";?></td>
                <td><?php echo "";?></td>
                <td><?php echo $row['shipping_name'];?></td>
                <td><?php echo $row['street'].', '.$row['city'];?></td>
                <td><?php echo $row['city1'];?></td>
                <td><?php echo $row['region'];?></td>
                <td><?php echo "Indonesia";?></td>
                <td><?php echo $row['postcode'];?></td>
                <td><?php echo $row['telephone'];?></td>

            </tr>
        <?php $noUrut++; endwhile;?>
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
