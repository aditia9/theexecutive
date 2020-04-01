<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include 'cek-akses.php'; 
?>
<html>
<head>
    <title>Log Admin</title>
    <link rel="stylesheet" type="text/css" href="assets/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="buttons/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>

<body>

    <a href="/admin/index.php" class="btn btn-success btn-xs">Back</a>
    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>IP</th>
                <th>Session</th>
                <th>Email</th>
                <th>Date</th>

            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>IP</th>
                <th>Session</th>
                <th>Email</th>
                <th>Date</th>
            </tr>
        </tfoot>
        <tbody>
        <?php
        $sql = "SELECT a.id, a.session_id, a.updated_at, a.ip, b.email
        FROM admin_user_session AS a 
        LEFT JOIN admin_user b ON b.user_id=a.user_id where a.user_id != '' ORDER BY a.updated_at DESC";

        $query = $db->query($sql);
        while($row = $query->fetch_assoc()):
        ?>
            <tr>
                <td><?php echo $row['id'] ?></td>
                <td><?php echo $row['ip'] ?></td>
                <td><?php echo $row['session_id'] ?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo $row['updated_at'] ?></td>
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