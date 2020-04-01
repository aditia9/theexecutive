<div class="sidebar" data-color="purple" data-background-color="white" data-image="<?php echo URL_ASSETS; ?>/images/sidebar-1.jpg">
  <div class="logo">
    <a href="#" class="simple-text logo-normal">
      Creative Tim
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url('backend'); ?>">
          <i class="material-icons">dashboard</i>
          <p>Dashboard</p>
        </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" data-toggle="collapse" href="#massUpdate">
          <i class="material-icons">cloud_upload</i>
          <p> Mass Update
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="massUpdate">
          <ul class="nav">
            <li class="nav-item ">
              <a class="nav-link" href="<?php echo base_url('backend/uploadcategory'); ?>">
                <span class="sidebar-mini"> UC </span>
                <span class="sidebar-normal"> Upload Category </span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="<?php echo base_url('backend/uploadproduct'); ?>">
                <span class="sidebar-mini"> UP </span>
                <span class="sidebar-normal"> Upload Product </span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="<?php echo base_url('backend/uploadstock'); ?>">
                <span class="sidebar-mini"> US </span>
                <span class="sidebar-normal"> Upload Stock </span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="<?php echo base_url('backend/uploadparent'); ?>">
                <span class="sidebar-mini"> UPC </span>
                <span class="sidebar-normal"> Upload Parent and Child</span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="<?php echo base_url('backend/deletecategory'); ?>">
                <span class="sidebar-mini"> DPC </span>
                <span class="sidebar-normal"> Delete Product In Category</span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item ">
        <a class="nav-link" data-toggle="collapse" href="#transaksi">
          <i class="material-icons">all_inbox</i>
          <p> Transaksi
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="transaksi">
          <ul class="nav">
            <li class="nav-item ">
              <a class="nav-link" href="<?php echo base_url('backend/waitingbanktransfer'); ?>">
                <span class="sidebar-mini"> WBT </span>
                <span class="sidebar-normal"> Waiting Bank Transfer </span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="<?php echo base_url('backend/virtualaccount'); ?>">
                <span class="sidebar-mini"> VA </span>
                <span class="sidebar-normal"> Virtual Account </span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="<?php echo base_url('backend/cashondelivery'); ?>">
                <span class="sidebar-mini"> COD </span>
                <span class="sidebar-normal"> Cash On Delivery</span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="<?php echo base_url('backend/confirmationreceive'); ?>">
                <span class="sidebar-mini"> CR </span>
                <span class="sidebar-normal"> Confirmation Receive</span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="<?php echo base_url('backend/creditcard'); ?>">
                <span class="sidebar-mini"> CC </span>
                <span class="sidebar-normal"> Credit Card</span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item ">
        <a class="nav-link" data-toggle="collapse" href="#kurir">
          <i class="material-icons">commute</i>
          <p> Kurir
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse" id="kurir">
          <ul class="nav">
            <li class="nav-item ">
              <a class="nav-link" href="<?php echo base_url('backend/jne'); ?>">
                <span class="sidebar-mini"> JNE</span>
                <span class="sidebar-normal"> JNE</span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="<?php echo base_url('backend/lion'); ?>">
                <span class="sidebar-mini"> COD</span>
                <span class="sidebar-normal"> Lion Parcel</span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      
      <!--<li class="nav-item ">-->
      <!--  <a class="nav-link" href="<?php echo base_url('backend/kurir'); ?>">-->
      <!--    <i class="material-icons">commute</i>-->
      <!--    <p>Kurir</p>-->
      <!--  </a>-->
      <!--</li> -->

      <li class="nav-item ">
        <a class="nav-link" href="<?php echo base_url('backend/tarikstock'); ?>">
          <i class="material-icons">archive</i>
          <p>Tarik Stock</p>
        </a>
      </li> 
      
      <li class="nav-item active-pro">
        <a class="nav-link" href="<?php echo base_url('backend/so'); ?>">
          <i class="material-icons">cloud_done</i>
          <p>SO</p>
        </a>
      </li>    

    </ul>
  </div>
</div>