<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo URL_ASSETS; ?>images/favicon.png">
  <link rel="icon" type="image/png" href="<?php echo URL_ASSETS; ?>images/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title><?php echo $title; ?></title>

  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <link href="<?php echo URL_ASSETS; ?>css/material-dashboard.css?v=2.1.0" rel="stylesheet" />
  <link href="<?php echo URL_ASSETS; ?>css/demo.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper">

    <!-- Left Sidebar -->
    <?php $this->load->view("backend/page/sidebar.php"); ?>

    <div class="main-panel">
        <!-- Top Navbar -->        
        <?php $this->load->view("backend/page/navbar.php"); ?>

        <!-- Content -->    
        <?php $this->load->view($page); ?>

        <!-- Footer -->        
        <?php $this->load->view("backend/page/footer.php"); ?>
    </div>

  </div>
</body>

  <script src="<?php echo URL_ASSETS; ?>js/core/jquery.min.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/core/popper.min.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/core/bootstrap-material-design.min.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/plugins/moment.min.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/plugins/sweetalert2.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/plugins/jquery.validate.min.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/plugins/jquery.bootstrap-wizard.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/plugins/bootstrap-selectpicker.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/plugins/bootstrap-datetimepicker.min.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/plugins/jquery.dataTables.min.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/plugins/bootstrap-tagsinput.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/plugins/jasny-bootstrap.min.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/plugins/fullcalendar.min.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/plugins/jquery-jvectormap.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/plugins/nouislider.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/plugins/arrive.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2Yno10-YTnLjjn_Vtk0V8cdcY5lC4plU"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/plugins/chartist.min.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/plugins/bootstrap-notify.js"></script>
  <script src="<?php echo URL_ASSETS; ?>js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
  <script src="<?php echo URL_ASSETS; ?>js/demo.js"></script>

  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');
        $sidebar_img_container = $sidebar.find('.sidebar-background');
        $full_page = $('.full-page');
        $sidebar_responsive = $('body > .navbar-collapse');
        window_width = $(window).width();
        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();
        if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
          if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
            $('.fixed-plugin .dropdown').addClass('open');
          }
        }

        $('.fixed-plugin a').click(function(event) {
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .active-color span').click(function() {
          $full_page_background = $('.full-page-background');
          $(this).siblings().removeClass('active');
          $(this).addClass('active');
          var new_color = $(this).data('color');
          if ($sidebar.length != 0) {
            $sidebar.attr('data-color', new_color);
          }
          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }
          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data-color', new_color);
          }
        });

        $('.fixed-plugin .background-color .badge').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('background-color');
          if ($sidebar.length != 0) {
            $sidebar.attr('data-background-color', new_color);
          }
        });

        $('.fixed-plugin .img-holder').click(function() {
          $full_page_background = $('.full-page-background');
          $(this).parent('li').siblings().removeClass('active');
          $(this).parent('li').addClass('active');

          var new_image = $(this).find("img").attr('src');
          if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            $sidebar_img_container.fadeOut('fast', function() {
              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
              $sidebar_img_container.fadeIn('fast');
            });
          }
          if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $full_page_background.fadeOut('fast', function() {
              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
              $full_page_background.fadeIn('fast');
            });
          }
          if ($('.switch-sidebar-image input:checked').length == 0) {
            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
          }
          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
          }
        });

        $('.switch-sidebar-image input').change(function() {
          $full_page_background = $('.full-page-background');
          $input = $(this);

          if ($input.is(':checked')) {
            if ($sidebar_img_container.length != 0) {
              $sidebar_img_container.fadeIn('fast');
              $sidebar.attr('data-image', '#');
            }
            if ($full_page_background.length != 0) {
              $full_page_background.fadeIn('fast');
              $full_page.attr('data-image', '#');
            }
            background_image = true;
          } else {
            if ($sidebar_img_container.length != 0) {
              $sidebar.removeAttr('data-image');
              $sidebar_img_container.fadeOut('fast');
            }
            if ($full_page_background.length != 0) {
              $full_page.removeAttr('data-image', '#');
              $full_page_background.fadeOut('fast');
            }
            background_image = false;
          }
        });

        $('.switch-sidebar-mini input').change(function() {
          $body = $('body');
          $input = $(this);
          if (md.misc.sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            md.misc.sidebar_mini_active = false;
            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();
          } else {
            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');
            setTimeout(function() {
              $('body').addClass('sidebar-mini');
              md.misc.sidebar_mini_active = true;
            }, 300);
          }

          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);
        });
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      md.initDashboardPageCharts();
    });
  </script>

  <script>
  $(document).ready(function() {
    $('#datatables').DataTable({
      "pagingType": "full_numbers",
      "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      responsive: true,
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search records",
      }
    });

    var table = $('#datatable').DataTable();

    // Edit record
    table.on('click', '.edit', function() {
      $tr = $(this).closest('tr');
      var data = table.row($tr).data();
      alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
    });

    // Delete a record
    table.on('click', '.remove', function(e) {
      $tr = $(this).closest('tr');
      table.row($tr).remove().draw();
      e.preventDefault();
    });

    //Like record
    table.on('click', '.like', function() {
      alert('You clicked on Like button');
    });
  });
</script>

</body>
</html>
