<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">Tambah User</h4>
            <p class="card-category">Silahkan lengkapi data diri anda</p>
          </div>
          <div class="card-body"><br>
          <form action="<?php echo base_url('backend/adduser_act'); ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="bmd-label-floating">Name</label>
                  <input type="text" name="name" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="bmd-label-floating">Email</label>
                  <input type="email" name="email" class="form-control" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="bmd-label-floating">Username</label>
                  <input type="text" name="username" class="form-control" required>
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
                    <option value="1" selected>Administrator</option>
                    <option value="2">Gudang</option>
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
                    <textarea class="form-control" name="deskripsi" rows="5" required></textarea>
                </div>
              </div>
            </div>  
            <button type="submit" name="submit" class="btn btn-primary pull-right">Simpan Profile</button>
            <div class="clearfix"></div>
          </form>

          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-profile">
          <div class="card-avatar">
            <a href="#pablo">
              <img class="img" src="<?php echo URL_ASSETS; ?>images/favicon.png" />
            </a>
          </div>
          <div class="card-body">
            <h6 class="card-category text-gray">Role User</h6>
            <h4 class="card-title">Name User</h4>
            <p class="card-description">About User</p>
            <a href="#pablo" class="btn btn-primary btn-round">The Executive</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>