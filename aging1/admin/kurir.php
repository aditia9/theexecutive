<?php
$server     = "localhost";
$username   = "theexecu_shop";
$password   = "Delami@123#";
$database   = "theexecu_magentoback";

$db = mysqli_connect($server, $username, $password, $database);
if(mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>
<html>
<head>
	<title>Kurir The Executive</title>
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
                <th>No Order</th>
                <th>No Increment</th>
                <th>Qty</th>
                <th>Total Harga</th>
                <th>Kurir</th>
                <th>Berat (Kg)</th>
                <th>Ongkos Kirim</th>

            </tr>
        </thead>
        <tfoot>
            <tr>
                 <th>NO</th>
                <th>No Order</th>
                <th>No Increment</th>
                <th>Qty</th>
                <th>Total Harga</th>
                <th>Kurir</th>
                <th>Berat (Kg)</th>
                <th>Ongkos Kirim</th>
            </tr>
        </tfoot>
        <tbody>
        <?php
        $sql = $db->query("SELECT entity_id, total_qty_ordered, increment_id, grand_total, shipping_description, round(total_qty_ordered)/2 as equiv_shipping_qty, shipping_amount 
            FROM sales_order WHERE status = 'preperation_in_progress' and created_at BETWEEN NOW() - INTERVAL 5 DAY AND NOW()");
            $noUrut=0;
            while ($row = mysqli_fetch_array($sql)){
            $noUrut++;
        ?>
        	<tr>
                <td><?php echo $noUrut; ?></td>
        	<td><?php echo $row['entity_id'];?></td>
                <td><?php echo $row['increment_id'];?></td>
        	<td><?php echo number_format($row['total_qty_ordered']);?></td>
        	<td><?php echo number_format($row['grand_total'],0,",","");?></td>
                <td><?php echo $row['shipping_description'];?></td>
                <td><?php echo substr($row['equiv_shipping_qty'], 0, -3);?></td>
                <td><?php echo number_format($row['shipping_amount'],0,",","");?></td>

        	</tr>
        <?php } ?>
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
 
 
