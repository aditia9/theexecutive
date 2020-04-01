<div class="content">
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary card-header-icon">
          <div class="card-icon">
            <i class="material-icons">commute</i>
          </div>
          <h4 class="card-title">Airwaybill Lion Parcel <br>
            (<a href="<?php echo base_url('backend/excellion'); ?>" style="color:#8e24aa;"><small>Download Excel</small></a>)
          </h4>
        </div>
        <div class="card-body">
          <div class="toolbar">
          </div>
          <div class="material-datatables">
            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
              <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Customer Name</th>
                  <th style="width: 450px">Receiver Address</th>
                  <th>Receiver City</th>
                  <th>SKU</th>
                  <th>Qty</th>
                  <th>Service</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Order ID</th>
                  <th>Customer Name</th>
                  <th style="width: 450px">Receiver Address</th>
                  <th>Receiver City</th>
                  <th>SKU</th>
                  <th>Qty</th>
                  <th>Service</th>
                </tr>
              </tfoot>
              <tbody>
              <?php 
                foreach($lists as $list) { 

                  $pecah  = explode(", ", $list->city);
                  if(!isset($pecah[1])){
                      $hasil = $pecah[0];
                  }else{
                      $hasil = $pecah[1];
                  }
      
                  $arr = array(
                  "Kota Administrasi Jakarta Utara" => "DKI Jakarta",
                  "Kota Administrasi Jakarta Barat" => "DKI Jakarta",
                  "Kota Administrasi Jakarta Timur" => "DKI Jakarta",
                  "Kota Administrasi Jakarta Selatan" => "DKI Jakarta",
                  "Kota Administrasi Jakarta Pusat" => "DKI Jakarta",
                  "Kota Administrasi Kepulauan Seribu" => "DKI Jakarta");
              ?>
                <tr>
                  <td><?php echo $list->order_id;?></td>
                  <td><?php echo $list->shipping_name;?></td>
                  <td><?php echo $list->street;?></td>
                  <td><?php echo strtr($hasil,$arr);?></td>
                  <td><?php echo $list->sku;?></td>
                  <td><?php echo str_replace('.0000', '', $list->qty_ordered);?></td>
                  <td>COD</td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>