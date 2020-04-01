<div class="content">
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary card-header-icon">
          <div class="card-icon">
            <i class="material-icons">all_inbox</i>
          </div>
          <h4 class="card-title">Payment Confirmation Receive <br>
            (<a href="<?php echo base_url('backend/excelconfirmationreceive'); ?>" style="color:#8e24aa;"><small>Download Excel</small></a>)
          </h4>
        </div>
        <div class="card-body">
          <div class="toolbar">
          </div>
          <div class="material-datatables">
            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
              <thead>
                <tr>
                  <th>ID Order</th>
                  <th>Customer Name</th>
                  <th>SKU</th>
                  <th>Product</th>
                  <th>Qty</th>
                  <th>Pembayaran</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>ID Order</th>
                  <th>Customer Name</th>
                  <th>SKU</th>
                  <th>Product</th>
                  <th>Qty</th>
                  <th>Pembayaran</th>
                  <th>Tanggal</th>
                </tr>
              </tfoot>
              <tbody>
              <?php 
                foreach($lists as $list) { 
              ?>
                <tr>
                  <td><?php echo $list->increment_id;?></td>
                  <td><?php echo $list->billing_name;?></td>
                  <td><?php echo $list->sku;?></td>
                  <td><?php echo $list->name;?></td>
                  <td><?php echo number_format($list->qty_ordered,0,",","");?></td>
                  <td><?php echo number_format($list->grand_total);?></td>
                  <td><?php echo $list->created_at;?></td>
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