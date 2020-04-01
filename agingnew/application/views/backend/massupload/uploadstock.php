<div class="content">
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary card-header-icon">
          <div class="card-icon">
              <i class="material-icons">cloud_upload</i>
          </div>
          <h4 class="card-title">Mass Upload Stock</h4>
        </div>
        <div class="card-body">
          <form method="post" action="<?php echo base_url('backend/uploadstock_act'); ?>" id="import_form" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-12">
                <div class="picture-container">
                  <div class="picture">
                    <h6 class="description">Choose File <small>(.xls, .xlsx)</small></h6> 
                    <input type="file" name="file" id="file" required accept=".xls, .xlsx">
                  </div>
                </div>
              </div>
            </div>
            <input type="submit" name="import" value="Upload Stock" class="btn btn-primary pull-right" />
            <div class="clearfix"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>