<div class="content">
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary card-header-icon">
          <div class="card-icon">
            <i class="material-icons">archive</i>
          </div>
          <h4 class="card-title">Tarik Stock <br>
            (<a href="<?php echo base_url('backend/exceltarikstock'); ?>" style="color:#8e24aa;"><small>Download Excel</small></a>)
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
                  <th>SKU</th>
                  <th>Product</th>
                  <th>Stock</th>
                  <th>Status </th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>ID</th>
                  <th>SKU</th>
                  <th>Product</th>
                  <th>Stock</th>
                  <th>Status </th>
                </tr>
              </tfoot>
              <tbody>
              <?php 
                foreach($lists as $list) {    
                if($list->type_id == 'configurable'){
                    $stat = 'Parent';
                    $bold = " style='font-weight: bold'";
                }else{
                    $stat = 'Child';
                    $bold = "";
                }
              ?>
                <tr <?php echo $bold;?>>
                  <td><?php echo $list->product_id;?></td>
                  <td><?php echo $list->sku;?></td>
                  <td><?php echo $list->value;?></td>
                  <td><?php echo str_replace('.0000', '', $list->qty);?></td>
                  <td><?php echo $stat;?></td>
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
