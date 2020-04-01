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
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/bootstrap.js"></script>
</head>

<body>
        <a href="/admin/index.php" class="btn btn-success btn-xs">Back</a>
	<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>NO</th>
                <th>ID</th>
                <th>Article Name</th>
                <th>SKU</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Date Add</th>
                <th>Aging</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>NO</th>
                <th>ID</th>
                <th>Article Name</th>
                <th>SKU</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Date Add</th>
                <th>Aging</th>
            </tr>
        </tfoot>
        <tbody>
        <?php
        $sql = "select p.id_product, pl.name, pa.reference, p.price, pa.quantity, p.date_add,DATEDIFF( CURRENT_DATE( ) , p.date_add ) AS JUMLAH_HARI
FROM ps_product p
inner JOIN ps_product_attribute pa on (p.id_product = pa.id_product)
inner JOIN ps_product_lang pl on (p.id_product = pl.id_product)
WHERE pl.id_lang=1
ORDER BY p.date_add DESC";
        $query = $db->query($sql);
        $no=0;
        while ($row = $query->fetch_assoc()) :
        $no++;?>
        	<tr>
        		<td><?php echo $no;?></td>
        		<td><?php echo $row['id_product'];?></td>
        		<td><?php echo $row['name'];?></td>
        		<td><?php echo $row['reference'];?></td>
        		<td><?php echo floor ($row['price']);?></td>
                <td><?php echo $row['quantity'];?></td>                
                <td><?php echo $row['date_add'];?></td>
                <td><?php echo $row['JUMLAH_HARI'];?></td>
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
        <script type="text/javascript" src="../buttons/js/buttons.html5.min.js"></script>
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