<html>
    <head>
        <link rel="stylesheet" href="../css/form1.css">
        <link rel="stylesheet" type="text/css" href="../aging1/css/bootstrap.css">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">


	    <script type="text/javascript" src="../aging1/js/jquery.js"></script>
	    <script type="text/javascript" src="../aging1/js/bootstrap.js"></script>
	    <script type="text/javascript" src="../aging1/js/table.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <script src="../js/captcha.js"></script><script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    </head>
    <body>
       <section id="contact">
			<div class="section-content">
<div class="container"><center><img src="refund.jpg"/></center></container">
				<h1 class="section-header"><span class="content-header wow fadeIn " data-wow-delay="0.2s" data-wow-duration="2s"></span></h1>
				<h3></h3>
			</div>
			<div class="contact-section">
			<div class="container">
				<form data-toggle="validator" action="results1.php" method="POST" role="form">
					<div class="col-md-6 form-line">
			  			<div class="form-group">
			  				<label for="exampleInputEmail">Email</label>
					    	<input type="email" class="form-control" name="email" id="email" placeholder=" Masukkan Email" required>
				  		</div>
			  			<div class="form-group">
			  				<label for="exampleInputUsername">Nama Customer</label>
					    	<input type="text" class="form-control" name="namacustomer" id="namacustomer" placeholder=" Masukkan Nama Customer" required>
				  		</div>
				  		<div class="form-group">
					    	<label for="exampleInputEmail">Order Number</label>
					    	<input type="text" class="form-control" name="noorder" id="noorder" placeholder=" Masukkan Nomor Order" required>
					  	</div>	
						<div class="form-group">
					    	<label for="telephone">Total Order.</label>
					    	<input type="text" class="form-control" name="totalorder" id="totalorder" placeholder=" IDR." required>
			  			</div>
			  			<div class="form-group">
					    	<label for="telephone">Jumlah Dana yang Ingin Dikembalikan.</label>
					    	<input type="text" class="form-control" name="refund" id="refund" placeholder=" IDR." required>
			  			</div>
					  	
			  		</div>
			  		<div class="col-md-6">
			  			
			  			<div class="form-group">
			  				<label for="exampleInputUsername">Nama Pemilik Rekening</label>
					    	<input type="text" class="form-control" name="namarekening" id="namarekening" placeholder=" Masukkan Nama Pemilik Rekening" required>
				  		</div>
				  		<div class="form-group">
					    	<label for="exampleInputEmail">Nomor Rekening</label>
					    	<input type="text" class="form-control" name="norek" id="norek" placeholder=" Masukkan Nomor Rekening" required>
					  	</div>	
					  	<div class="form-group">
					    	<label for="telephone">Nama Bank</label>
					    	<input type="text" class="form-control" name="namabank" id="namabank" placeholder=" Masukkan Nama Bank" required>
			  			</div>
			  			<div class="form-group">
					    	<label for="telephone">Cabang</label>
					    	<input type="text" class="form-control" name="cabang" id="cabang" placeholder=" Masukkan Cabang Bank" required>
			  			</div>
			  			<div class="form-group">
                                        <!-- Replace data-sitekey with your own one, generated at https://www.google.com/recaptcha/admin -->
                                        <div class="g-recaptcha" data-sitekey="6LezHiIUAAAAAJuGI3cgjnIHyqU1N-Xm6MhV1BLv"></div>
                                    </div>
					</div>
<div class="container">
    <table id="myTable" class=" table order-list">
    <thead>
        <tr>
            <td>Product Name</td>
            <td>Color</td>
            <td>Size</td>
            <td>Reason</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="col-sm-4">
                <input type="text" name="productname" class="form-control" />
            </td>
            <td class="col-sm-2">
                <input type="mail" name="color"  class="form-control"/>
            </td>
            <td class="col-sm-2">
                <input type="text" name="size"  class="form-control"/>
            </td>
            <td class="col-sm-6">
                <input type="text" name="reason"  class="form-control"/>
            </td>
            <td class="col-sm-2"><a class="deleteRow"></a>

            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" style="text-align: left;">
                <input type="button" class="btn btn-lg btn-block " id="addrow" value="Add Row" />
            </td>
        </tr>
        <tr>
        </tr>
    </tfoot>
</table>
</div>
					<div class="row" align="center">
				<div class="col-xs-12 col-md-12"><input type="submit" color="black" value="Submit" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
				
				
			</div>
				</form>
			</div>
		</section>
</body>
</html>