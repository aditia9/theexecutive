<?php
// memanggil file config.php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include '../cek-akses.php'; 
?>
<html>
<head>
    <title>Data Awaiting Bank Transfer</title>
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
                <th>Tanggal</th>
                <th>ID Order</th>
		<th>Status</th>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Qty</th>
                <th>Amount</th>
                <th>Metode Pembayaran</th>
                <th>Customer Name</th>
                <th>Customer Email</th>
                <th>Receiver's name</th>
                <th>Address</th>
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
                <th>Tanggal</th>
                <th>ID Order</th>
		<th>Status</th>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Qty</th>
                <th>Amount</th>
                <th>Metode Pembayaran</th>
                <th>Customer Name</th>
                <th>Customer Email</th>
                <th>Receiver's name</th>
                <th>Address</th>
                <th>City</th>
                <th>Province</th>
                <th>Country</th>
                <th>Postal Code</th>
                <th>Phone Number</th>
            </tr>
        </tfoot>
        <tbody>
        <?php
        $sql = "SELECT distinct sog.entity_id, sog.increment_id, sog.grand_total, sog.payment_method, sog.created_at, sog.customer_email, sog.shipping_name, 
        sog.customer_name, sog.status, soa.street, soa.city, SUBSTRING_INDEX(soa.city, ',', -1) as city1, soa.postcode, soa.telephone, soa.region, a.order_id, 
        a.sku, a.qty_ordered, a.name as productname
            FROM sales_order_item AS a 
            LEFT JOIN sales_order_item AS b on ((a.order_id = b.order_id) and (a.sku=b.sku) and (b.parent_item_id is null))
            LEFT JOIN sales_order_grid sog ON sog.entity_id=a.order_id
            LEFT JOIN sales_order_address soa ON sog.entity_id=soa.parent_id
            WHERE (a.parent_item_id is not null) AND sog.payment_method IN('ipay88_cc','banktransfer','prismalink_vabca','cashondelivery') 
            AND sog.status IN('pending_payment','pending','paymentconfirmationreceive') AND sog.created_at BETWEEN NOW() - INTERVAL 5 DAY AND NOW()";
        $query = $db->query($sql);
        $noUrut=0;
        while ($row = $query->fetch_assoc()) :
            if($row['payment_method'] == 'ipay88_cc'){
                $keterangan = 'Credit Card';
            }else if($row['payment_method'] == 'banktransfer'){
                $keterangan = 'Transfer Bank';
            }else if($row['payment_method'] == 'prismalink_vabca'){
                $keterangan = 'Virtual Account';
            }else if($row['payment_method'] == 'cashondelivery'){
                $keterangan = 'COD';
            }   
        $noUrut++ ?>
            <tr>
                <td><?php echo $noUrut; ?></td>
                <td><?php echo $row['created_at'];?></td>
                <td><?php echo $row['increment_id'];?></td>
               	<td><?php echo $row['status']; ?></td>
		<td><?php echo $row['productname'];?></td>
                <td><?php echo $row['sku'];?></td>
                <td><?php echo number_format($row['qty_ordered'],0,",","");?></td>
                <td><?php echo number_format($row['grand_total'],0,",","");?></td>
                <td><?php echo $keterangan; ?></td>
                <td><?php echo $row['customer_name'];?></td>
                <td><?php echo $row['customer_email'];?></td>
                <td><?php echo $row['shipping_name'];?></td>
                <td><?php echo $row['street'].', '.$row['city'];?></td>
                <td><?php echo $row['city1'];?></td>
                <td><?php echo $row['region'];?></td>
                <td><?php echo "Indonesia";?></td>
                <td><?php echo $row['postcode'];?></td>
                <td><?php echo $row['telephone'];?></td>
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
