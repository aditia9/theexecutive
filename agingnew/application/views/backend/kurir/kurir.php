<div class="content">
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary card-header-icon">
          <div class="card-icon">
            <i class="material-icons">commute</i>
          </div>
          <h4 class="card-title">Kurir <br>
            (<a href="<?php echo base_url('backend/excelkurir'); ?>" style="color:#8e24aa;"><small>Download Excel</small></a>)
          </h4>
        </div>
        <div class="card-body">
          <div class="toolbar">
          </div>
          <div class="material-datatables">
            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Increment</th>
                  <th>Qty</th>
                  <th>Berat</th>
                  <th>Kurir</th>
                  <th>Biaya Pengiriman</th>
                  <th>Total Biaya</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Increment</th>
                  <th>Qty</th>
                  <th>Berat</th>
                  <th>Kurir</th>
                  <th>Biaya Pengiriman</th>
                  <th>Total Biaya</th>
                </tr>
              </tfoot>
              <tbody>
              <?php 
                foreach($lists as $list) {    
                  if($list->total_item_count <= 3){
                    $berat = 1;
                  }else if($list->total_item_count <= 6){
                    $berat = 2;
                  }else if($list->total_item_count <= 9){
                    $berat = 3;
                  }else if($list->total_item_count > 11){
                    $berat = 4;
                  }else if($list->total_item_count > 14){
                    $berat = 5;
                  }else if($list->total_item_count > 17){
                    $berat = 6;
                  }else if($list->total_item_count > 20){
                    $berat = 7;
                  }
              ?>
                <tr>
                  <td><?php echo $list->entity_id;?></td>
                  <td><?php echo $list->increment_id;?></td>
                  <td><?php echo $list->total_item_count;?></td>
                  <td><?php echo $berat;?></td>
                  <td><?php echo $list->shipping_description;?></td>
                  <td><?php echo number_format($list->shipping_and_handling);?></td>
                  <td><?php echo number_format($list->base_grand_total);?></td>
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