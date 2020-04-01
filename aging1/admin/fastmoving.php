<?php

// memanggil file config.php

defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);

include '../cek-akses.php'; 

?>

<html>

<head>

    <title>Data Aging Colorbox</title>

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

                <th>No</th>

                <th>SKU</th>

                <th>Article Name</th>

                <th>QTY</th>

                <th>Terjual</th>

                <th>Date Add</th>

                <th>Jumlah Hari</th>

            </tr>

        </thead>

        <tfoot>

            <tr>

                <th>No</th>

                <th>SKU</th>

                <th>Article Name</th>

                <th>QTY</th>

                <th>Terjual</th>

                <th>Date Add</th>

                <th>Jumlah Hari</th>

            </tr>

        </tfoot>

        <tbody>

        <?php

        $sql = "select od.product_reference, od.product_name,  pa.quantity, COUNT(od.product_quantity) as terjual,DATEDIFF( CURRENT_DATE( ) , p.date_add ) AS JUMLAH_HARI, p.date_add

from ps_product_attribute pa

LEFT JOIN ps_order_detail od on pa.reference=od.product_reference

LEFT JOIN ps_product p on p.id_product=pa.id_product

where p.date_add >= '2017-01-01'

group By od.product_reference

order By JUMLAH_HARI asc";

        $query = $db->query($sql);

        $no=0;

        while ($row = $query->fetch_assoc()) :

        $no++;

        ?>

            <tr>



                        <td><?php echo $no;?></td>

                <td><?php echo $row['product_reference'];?></td>

                <td><?php echo $row['product_name'];?></td>

                <td><?php echo $row['quantity'];?></td>

                <td><?php echo $row['terjual'];?></td>

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