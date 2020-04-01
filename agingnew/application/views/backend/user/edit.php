<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">Rubah Profile</h4>
            <p class="card-category">Silahkan lengkapi data diri anda</p>
          </div>
          <div class="card-body"><br>
          <form action="<?php echo base_url('backend/edituser_act'); ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="bmd-label-floating">Name</label>
                  <input type="text" name="name" class="form-control" value="<?php echo $detail->aname; ?>" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="bmd-label-floating">Email</label>
                  <input type="email" name="email" class="form-control" value="<?php echo $detail->aemail; ?>" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="bmd-label-floating">Username</label>
                  <input type="text" name="username" class="form-control" value="<?php echo $detail->ausername; ?>" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="bmd-label-floating">Password</label>
                  <input type="password" name="pass" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label class="bmd-label-floating" style="font-size: 11px;"> Akses Role</label>
                <select class="form-control show-tick" name="role" required>
                    <option value="1" <?php if($detail->arole==1) echo 'selected="selected"'?>>Administrator</option>
                    <option value="2" <?php if($detail->arole==2) echo 'selected="selected"'?>>Gudang</option>
                </select>
              </div>
            </div><br>
            <div class="row">
              <div class="col-md-12">                  
                <div class="picture">
                  <h6 class="description" style="font-size: 10px;font-weight: normal;">Choose Foto <small>(.jpg, .png)</small></h6> 
                  <input type="file" name="foto" id="foto" accept=".jpg, .png">
                </div>
              </div>
            </div><br>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                    <label class="bmd-label-floating"> Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" rows="5" required><?php echo $detail->adesc; ?></textarea>
                </div>
              </div>
            </div>  
            <input type="hidden" name="id" value="<?php echo $detail->aid; ?>">
            <button type="submit" name="submit" class="btn btn-primary pull-right">Update Profile</button>
            <div class="clearfix"></div>
          </form>

          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-profile">
          <div class="card-avatar">
            <a href="#pablo">
              <img class="img" src="<?php echo URL_ASSETS; ?>user/<?php echo $detail->aimage; ?>" />
            </a>
          </div>
          <div class="card-body">
            <h6 class="card-category text-gray">
            <?php 
              if($detail->arole==1){
                echo"Administrator";
              }else{
                echo"Gudang";
              }
            ?>
            </h6>
            <h4 class="card-title"><?php echo $detail->aname; ?></h4>
            <p class="card-description">
              <?php echo $detail->adesc; ?>
            </p>
            <a href="#pablo" class="btn btn-primary btn-round">The Executive</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>