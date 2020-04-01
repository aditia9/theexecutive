<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo URL_ASSETS; ?>images/favicon.png">
    <link rel="icon" type="image/png" href="<?php echo URL_ASSETS; ?>images/favicon.png">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $title; ?></title>
    <link rel="icon" href="<?php echo URL_ASSETS; ?>images/frontend/fav.png" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="<?php echo URL_ASSETS; ?>vendors/backend/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo URL_ASSETS; ?>vendors/backend/node-waves/waves.css" rel="stylesheet" />
    <link href="<?php echo URL_ASSETS; ?>vendors/backend/animate-css/animate.css" rel="stylesheet" />
    <link href="<?php echo URL_ASSETS; ?>css/backend/style.css" rel="stylesheet">
    <link href="<?php echo URL_ASSETS; ?>css/frontend/sweetalert/sweetalert.css" rel="stylesheet">
</head>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);">Administrator <b>Page</b></a>
            <small>Admin BootStrap Based - <?php echo DOMAIN_WEB; ?></small>
        </div>
        <div class="card">
            <div class="body">
                <form action="<?php echo base_url('backend/login_act'); ?>" method="POST">
                    <div class="msg">Sign in to start your session</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="user" placeholder="Username" required autofocus>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="pass" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                            <label for="rememberme">Remember Me</label>
                        </div>
                        <div class="col-xs-4">
                            <button name="submit" class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<div class="showcase sweet" style="display:none;"><a id="failed">.</a></div>

    <script src="<?php echo URL_ASSETS; ?>vendors/backend/jquery/jquery.min.js"></script>
    <script src="<?php echo URL_ASSETS; ?>vendors/backend/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo URL_ASSETS; ?>vendors/backend/node-waves/waves.js"></script>
    <script src="<?php echo URL_ASSETS; ?>vendors/backend/jquery-validation/jquery.validate.js"></script>
    <script src="<?php echo URL_ASSETS; ?>/js/backend/admin.js"></script>
    <script src="<?php echo URL_ASSETS; ?>/js/backend/pages/examples/sign-in.js"></script>
    <script src="<?php echo URL_ASSETS; ?>css/frontend/sweetalert/sweetalert-dev.js"></script>

<?php if($this->session->flashdata('success')){ ?>
<script>
  $(document).ready(function(e){
      $('#failed').click();
  });

  document.querySelector('.showcase.sweet a').onclick = function(){
  swal("Congratulations...", "<?php echo $this->session->flashdata('success')?>", "success");
  };
</script>
<?php } if($this->session->flashdata('warning')) { ?>
<script>
  $(document).ready(function(e){
      $('#failed').click();
  });

  document.querySelector('.showcase.sweet a').onclick = function(){
  swal("Oops...", "<?php echo $this->session->flashdata('warning')?>", "error");
  };
</script>
<?php } ?>
</html>