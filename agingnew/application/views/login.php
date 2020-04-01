<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="icon" type="image/png" href="../../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Login Page | Aging TheExecutive
  </title>

  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <link rel="canonical" href="" />
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <link href="<?php echo URL_ASSETS; ?>css/login/material-dashboard.min.css?v=2.1.0" rel="stylesheet" />
  <link href="<?php echo URL_ASSETS; ?>css/login/demo.css" rel="stylesheet" />
</head>

<body class="off-canvas-sidebar">

  <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
    <div class="container">
      <div class="navbar-wrapper">
        <a class="navbar-brand" href="#pablo">Login Page</a>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav">
          <li class="nav-item  active ">
            <a href="#" class="nav-link">
              <i class="material-icons">fingerprint</i> Login
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="wrapper wrapper-full-page">
    <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('<?php echo URL_ASSETS; ?>images/login.jpg'); background-size: cover; background-position: top center;">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
            <form class="form" method="post" action="<?php echo base_url('backend/login_act'); ?>">
              <div class="card card-login card-hidden">
                <div class="card-header card-header-rose text-center">
                    <img src="<?php echo URL_ASSETS; ?>images/brands.png" width="230px">
                  <div class="social-line">
                    <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                      <i class="fa fa-facebook-square"></i>
                    </a>
                    <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                      <i class="fa fa-twitter"></i>
                    </a>
                    <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                      <i class="fa fa-google-plus"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body ">
                  <p class="card-description text-center"></p>
                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">face</i>
                        </span>
                      </div>
                      <input type="text" class="form-control" name="user" placeholder="Username" required>
                    </div>
                  </span><br>
                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">lock_outline</i>
                        </span>
                      </div>
                      <input type="password" class="form-control" name="pass" placeholder="Password" required>
                    </div>
                  </span>
                </div><br>
                <div class="card-footer justify-content-center">
                  <button name="submit" class="btn btn-rose btn-link btn-lg" type="submit">Lets Go</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container">
          <div class="copyright">
            Dealmibrands &copy; <?php echo date('Y'); ?> All rights reserved
          </div>
        </div>
      </footer>
    </div>
  </div>

  <script src="<?php echo URL_ASSETS; ?>js/login/jquery.min.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/login/popper.min.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/login/bootstrap-material-design.min.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/login/perfect-scrollbar.jquery.min.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/login/chartist.min.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/login/bootstrap-notify.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/login/material-dashboard.min.js?v=2.1.0" type="text/javascript"></script>

  <script>
    $(document).ready(function() {
      md.checkFullPageBackgroundImage();
      setTimeout(function() {
        $('.card').removeClass('card-hidden');
      }, 700);
    });
  </script>

</body>
</html>