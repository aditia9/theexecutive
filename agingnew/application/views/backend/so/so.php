<div class="content">
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary card-header-icon">
          <div class="card-icon">
            <i class="material-icons">cloud_done</i>
          </div>
          <h4 class="card-title">Stock Opname <br>
            (<a href="<?php echo base_url('backend/excelso'); ?>" style="color:#8e24aa;"><small>Download Excel</small></a>)
          </h4>
        </div>
        <div class="card-body">
          <div class="toolbar">
          </div>
          <div class="material-datatables">
            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
              <thead>
                <tr>
                  <th>No Order</th>
                  <th>Order Date</th>
                  <th>Customer Name</th>
                  <th>SKU</th>
                  <th>Article-Color-Size</th>
                  <th>Qty</th>
                  <th>Net Amount</th>
                  <th>Shipping Cost</th>
                  <th>Logistik</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>No Order</th>
                  <th>Order Date</th>
                  <th>Customer Name</th>
                  <th>SKU</th>
                  <th>Article-Color-Size</th>
                  <th>Qty</th>
                  <th>Net Amount</th>
                  <th>Shipping Cost</th>
                  <th>Logistik</th>
                </tr>
              </tfoot>
              <tbody>
              <?php 
                foreach($lists as $list) { 
                $kode     = $list->entity_id; 
                $diskon1  = $list->base_original_price;
                $diskon2  = $list->price; 
                $discount = $diskon1-$diskon2;

                $net1   = $list->price;
                $net2   = $list->discount_amount; 
                $nett   = $net1-$net2;
                $count  = $this->m_sales_order_item->CreditCardKode($kode);

                $potongan = $list->base_original_price-$list->price;

                if($list->base_discount_amount <= 0){
                    $diskon      = str_replace("-","",$list->base_discount_amount)/$count;
                }else{
                    $diskon      = str_replace("-","",$list->discount_amount)/$count;
                }

                if($list->shipping_information == 'Lion Parcel - Cash on Delivery'){
                    $kurir = 'COD';
                }else{
                    $kurir = 'JNE';
                }
                
                $product = $this->m_sales_order_item->StockOpnameKode($list->sku);
                $kota1      = str_replace(",","",$list->city);

                

                $karakter = 60;
                $stringkarakter = strlen($list->street);
                $alamat = $list->street;
                $informasi = substr($alamat, 0, $karakter);
                if($stringkarakter > 60){
                    if ($alamat{$karakter - 1} != ' ') { 
                      $start = $alamat{$karakter - 1} != ' ';
                      $new_pos    = strrpos($informasi, ' '); 
                      $informasi  = substr($alamat, 0, $new_pos);
                      $informasi2 = substr($alamat, $new_pos, 40);
                    }
                }else{
                    $informasi  = $list->street;
                    $informasi2 = '';
                }

                $kota    = explode(",", $list->city);
                $arr = array(
                "Kota Administrasi Jakarta Utara" => "Jakarta Utara",
                "Kota Administrasi Jakarta Barat" => "Jakarta Barat",
                "Kota Administrasi Jakarta Timur" => "Jakarta Timur",
                "Kota Administrasi Jakarta Selatan" => "Jakarta Selatan",
                "Kota Administrasi Jakarta Pusat" => "Jakarta Pusat",
                "Kota Administrasi Kepulauan Seribu" => "Kepulauan Seribu");
              ?>
                <tr>
                  <td><?php echo $list->order_id;?></td>
                  <td><?php echo date('d.m.y', strtotime($list->created_at)); ?></td>
                  <td><?php echo $list->shipping_name;?></td>
                  <td><?php echo $list->sku;?></td>
                  <td><?php echo $kota1;?></td>
                  <td><?php echo str_replace('.0000', '', $list->qty_ordered);?></td>
                  <td><?php echo number_format($nett);?></td>
                  <td><?php echo number_format($list->shipping_and_handling);?></td>
                  <td><?php echo strtr($kota[0],$arr);?></td>
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