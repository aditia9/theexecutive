<?php
// memanggil file config.php
require 'config.php';
?>
<html>
<head>
	<title>Data COD The Executive</title>
	<link rel="stylesheet" type="text/css" href="assets/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="buttons/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>

<body>

        <a href="http://aging.theexecutive.co.id" class="btn btn-success btn-xs">Back</a>
	<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>NO</th>
                <th>Tgl</th>
                <th>ID Order</th>
                <th>Nama</th>
                <th>Total Paid</th>
                <th>Promo</th>
                <th>Product Name</th>
                <th>Harga</th>
                <th>SKU</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>NO</th>
                <th>Tgl</th>
                <th>ID Order</th>
                <th>Nama</th>
                <th>Total Paid</th>
                <th>Promo</th>
                <th>Product Name</th>
                <th>Harga</th>
                <th>SKU</th>
            </tr>
        </tfoot>
        <tbody>
        <?php
        $sql = "select d.id_order_detail, o.id_order, o.id_customer, o.total_discounts, c.firstname, c.lastname, o.total_paid, d.product_name, d.product_quantity_discount, d.product_reference, o.date_add
FROM ps_orders o LEFT JOIN ps_order_detail d
ON o.id_order = d.id_order  
INNER JOIN ps_customer c 
ON o.id_customer = c.id_customer
left JOIN ps_order_history h
ON o.id_order = h.id_order
WHERE h.id_order_state=18 AND 
o.date_add BETWEEN NOW() - INTERVAL 30 DAY AND NOW() ORDER BY d.id_order_detail DESC";
        $query = $db->query($sql);
        $noUrut=0;
        while ($row = $query->fetch_assoc()) :
        $noUrut++ ?>
        	<tr>
                        <td><?php echo $noUrut; ?></td>
        		<td><?php echo $row['date_add'];?></td>
        		<td><?php echo $row['id_order'];?></td>
        		<td><?php echo $row['firstname'].' '.$row['lastname'];?></td>
        		<td><?php echo $row['total_paid'];?></td>
        		<td><?php echo $row['total_discounts'];?></td>
        		<td><?php echo $row['product_name'];?></td>
        		<td><?php echo $row['product_quantity_discount'];?></td>
        		<td><?php echo $row['product_reference'];?></td>
        	</tr>
        <?php endwhile;?>
        </tbody>
    </table>
	<script type="text/javascript" src="assets/js/jquery-3.0.0.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="buttons/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.13/filtering/row-based/range_dates.js"></script>
        <script type="text/javascript" src="buttons/js/buttons.html5.min.js"></script>        
	<script type="text/javascript" src="js/bootstrap.js"></script>
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