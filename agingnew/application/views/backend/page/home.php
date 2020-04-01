<div class="content">
<div class="container-fluid">


  <!-- row pertama -->
  <div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header card-header-warning card-header-icon">
          <div class="card-icon">
            <i class="material-icons">content_copy</i>
          </div>
          <p class="card-category">Revenue</p>
          <h3 class="card-title">Rp <?php echo number_format($countrevenue->total); ?>
          </h3>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">update</i> Last 24 Hours
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header card-header-success card-header-icon">
          <div class="card-icon">
            <i class="material-icons">store</i>
          </div>
          <p class="card-category">Status Complete</p>
          <h3 class="card-title"><?php echo $countcomplete; ?>
          <small>Orders</small>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">date_range</i> Last 24 Hours
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header card-header-danger card-header-icon">
          <div class="card-icon">
            <i class="material-icons">info_outline</i>
          </div>
          <p class="card-category">Subscribers</p>
          <h3 class="card-title"><?php echo $countsubscriber; ?>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">local_offer</i> Tracked from Github
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header card-header-info card-header-icon">
          <div class="card-icon">
            <i class="fa fa-twitter"></i>
          </div>
          <p class="card-category">Shipping And Handling</p>
          <h3 class="card-title">Rp <?php echo number_format($countshipping->shipping); ?>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">update</i> Just Updated
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- row kedua -->
  <div class="row">
    <div class="col-md-4">
      <div class="card card-chart">
        <div class="card-header card-header-success">
          <div class="ct-chart" id="dailySalesChart"></div>
        </div>
        <div class="card-body">
          <h4 class="card-title">Daily Sales</h4>
          <p class="card-category">
            <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">access_time</i> updated 4 minutes ago
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-chart">
        <div class="card-header card-header-warning">
          <div class="ct-chart" id="websiteViewsChart"></div>
        </div>
        <div class="card-body">
          <h4 class="card-title">Email Subscriptions</h4>
          <p class="card-category">Last Campaign Performance</p>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">access_time</i> campaign sent 2 days ago
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-chart">
        <div class="card-header card-header-danger">
          <div class="ct-chart" id="completedTasksChart"></div>
        </div>
        <div class="card-body">
          <h4 class="card-title">Completed Tasks</h4>
          <p class="card-category">Last Campaign Performance</p>
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">access_time</i> campaign sent 2 days ago
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- row ketiga -->
  <div class="row">
    <div class="col-lg-8 col-md-12">
      <div class="card">
        <div class="card-header card-header-tabs card-header-primary">
          <div class="nav-tabs-navigation">
            <div class="nav-tabs-wrapper">
              <ul class="nav nav-tabs" data-tabs="tabs">
                <li class="nav-item">
                  <a class="nav-link active" href="#complete" data-toggle="tab" style="font-size:11px">
                    <i class="material-icons">done_all</i> Payment Confirmation Receive
                    <div class="ripple-container"></div>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#preparation" data-toggle="tab" style="font-size:11px">
                    <i class="material-icons">settings_ethernet</i> Preperation In Progress
                    <div class="ripple-container"></div>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#delivery" data-toggle="tab" style="font-size:11px">
                    <i class="material-icons">local_shipping</i> On Delivery
                    <div class="ripple-container"></div>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#pending" data-toggle="tab" style="font-size:11px">
                    <i class="material-icons">report_problem</i> Pending Payment
                    <div class="ripple-container"></div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="tab-content">
            <div class="tab-pane active" id="complete">
              <table class="table">
                <tbody>
                <?php foreach($taskspcr as $list) { ?>
                  <tr>
                    <td><?php echo $list->shipping_name;?></td>
                    <td><?php echo $list->sku;?></td>
                    <td><?php echo $list->name;?></td>
                    <td><?php echo number_format($list->qty_ordered);?></td>
                    <td class="td-actions text-right">Rp <?php echo number_format($list->base_grand_total);?></td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
            <div class="tab-pane" id="preparation">
              <table class="table">
                <tbody>
                <?php foreach($taskspreparation as $list) { ?>
                  <tr>
                    <td><?php echo $list->shipping_name;?></td>
                    <td><?php echo $list->sku;?></td>
                    <td><?php echo $list->name;?></td>
                    <td><?php echo number_format($list->qty_ordered);?></td>
                    <td class="td-actions text-right">Rp <?php echo number_format($list->base_grand_total);?></td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
            <div class="tab-pane" id="delivery">
              <table class="table">
                <tbody>
                <?php foreach($tasksdelivery as $list) { ?>
                  <tr>
                    <td><?php echo $list->shipping_name;?></td>
                    <td><?php echo $list->sku;?></td>
                    <td><?php echo $list->name;?></td>
                    <td><?php echo number_format($list->qty_ordered);?></td>
                    <td class="td-actions text-right">Rp <?php echo number_format($list->base_grand_total);?></td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
            <div class="tab-pane" id="pending">
              <table class="table">
                <tbody>
                <?php foreach($taskspending as $list) { ?>
                  <tr>
                    <td><?php echo $list->shipping_name;?></td>
                    <td><?php echo $list->sku;?></td>
                    <td><?php echo $list->name;?></td>
                    <td><?php echo number_format($list->qty_ordered);?></td>
                    <td class="td-actions text-right">Rp <?php echo number_format($list->base_grand_total);?></td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-12">
      <div class="card">
        <div class="card-header card-header-warning">
          <h4 class="card-title">Complate Stats</h4>
          <p class="card-category">New employees on 15th September, 2016</p>
        </div>
        <div class="card-body table-responsive">
          <table class="table table-hover">
            <thead class="text-warning">
              <th>Name</th>
              <th>SKU</th>
              <th style="width:100px">Price</th>
            </thead>
            <tbody>
              <?php foreach($taskscomplete as $list) { ?>
              <tr>
                <td><?php echo $list->shipping_name;?></td>
                <td><?php echo $list->sku;?></td>
                <td class="td-actions text-right">Rp <?php echo number_format($list->base_grand_total);?></td>
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