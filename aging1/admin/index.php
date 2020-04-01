<?php
defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include '../cek-akses.php'; 
?>

<html>
<head>
    <title>Home - Index</title>
    <link rel="stylesheet" type="text/css" href="../css/index.css">
        <link rel="stylesheet" type="text/css" href="../buttons/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
</head>

<body>
    <div class="row">
        <div class="btn-group btn-group-justified">
            <div class="btn-group">
		<a href="#">
                <button type="button" class="btn btn-nav">
                    <span><img src="../images/slow.png"></span>
                    <p>Slow Moving</p>
                </button></a>
            </div>
            <div class="btn-group">
		<a href="#">
                <button type="button" class="btn btn-nav">
                    <span><img src="../images/fast.png"></span>
                    <p>Fast Moving</p>
                </button></a>
            </div>
            
            <div class="btn-group">
		<a href="/aging1/admin/awaiting.php">
                <button type="button" class="btn btn-nav">
                    <span><img src="../images/pcr.png"></span>
                    <p>Awaiting Bank Transfer</p>
                </button></a>
            </div>

            <div class="btn-group">
		<a href="/aging1/admin/va.php">
                <button type="button" class="btn btn-nav">
                    <span><img src="../images/va.png"></span>
                    <p>Virtual Account</p>
                </button></a>
            </div>

            <div class="btn-group">
		<a href="/aging1/admin/cod.php">
                <button type="button" class="btn btn-nav">
                    <span><img src="../images/cod.png"></span>
                    <p>Cash on Delivery</p>
                </button></a>
            </div>
            <div class="btn-group">
		<a href="/aging1/admin/pcr.php">
                <button type="button" class="btn btn-nav">
                    <span><img src="../images/pcr.png"></span>
                    <p>Payment Confirmation Receive</p>
                </button></a>
            </div>
            <div class="btn-group">
		<a href="/aging1/admin/cc.php">
                <button type="button" class="btn btn-nav">
                    <span><img src="../images/cc.png"></span>
                    <p>Payment Credit Card</p>
                </button></a>
            </div>
         </div>
    </div>
        <div class="row">
        <div class="btn-group btn-group-justified">

            <div class="btn-group">
		<a href="/aging1/admin/ubahtanggal.html">
                <button type="button" class="btn btn-nav">
                    <span><img src="../images/tgl.png"></span>
                    <p>Ubah Tanggal</p>
                </button></a>
            </div>
            
            <div class="btn-group">
		<a href="#">
                <button type="button" class="btn btn-nav">
                    <span><img src="../images/aging.png"></span>
                    <p>Data Aging</p>
                </button></a>
            </div>
       	    <div class="btn-group">
		<a href="/aging1/admin/update.php">
                <button type="button" class="btn btn-nav">
                    <span><img src="../images/stock.png"></span>
                    <p>Update Stock</p>
                </button></a>
            </div>

            <div class="btn-group">
		<a href="/aging1/admin/tarikstockall.php">
                <button type="button" class="btn btn-nav">
                    <span><img src="../images/stock.png"></span>
                    <p>Tarik Stock</p>
                </button></a>
            </div>

            <div class="btn-group">
		<a href="/aging1/admin/tarikstock.php">
                <button type="button" class="btn btn-nav">
                    <span><img src="../images/stock.png"></span>
                    <p>Tarik Data + Image</p>
                </button></a>
            </div>

            <div class="btn-group">
		<a href="/aging1/admin/kurir.php">
                <button type="button" class="btn btn-nav">
                    <span><img src="../images/kurir.png"></span>
                    <p>Kurir</p>
                </button></a>
            </div>

            <div class="btn-group">
		<a href="../logout.php">
                <button type="button" class="btn btn-nav">
                    <span><img src="../images/logout.png"></span>
                    <p>Logout</p>
                </button></a>
            </div>

           
        </div>
    </div>
</div>
<script type="text/javascript" src="../css/login.js"></script>
</body>
</html>
