<?php
// memanggil file config.php
require 'config.php';
?>
<html>
<head>
	<title>Data Aging The Executive</title>
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
                <th>ARTICLE</th>
                <th>SKU</th>
                <th>QTY</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>NO</th>
                <th>ARTICLE</th>
                <th>SKU</th>
                <th>QTY</th>
            </tr>
        </tfoot>
        <tbody>
        <?php
        $sql = "select d.product_name, d.product_reference, d.product_quantity FROM 
		(
                select id_order, MAX(id_order_state) as id_order_state from ps_order_history p 
                GROUP BY id_order
		) p INNER JOIN ps_order_detail d
			on p.id_order = d.id_order
		where p.id_order_state = 10";
        $query = $db->query($sql);
        $noUrut=0;
        while ($row = $query->fetch_assoc()) :
        $noUrut++;
        ?>
        	<tr>
                        <td><?php echo $noUrut; ?></td>
        		<td><?php echo $row['product_name'];?></td>
        		<td><?php echo $row['product_reference'];?></td>
        		<td><?php echo $row['product_quantity'];?></td>
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
        ]
        });
	});
	</script>

</body>
</html>