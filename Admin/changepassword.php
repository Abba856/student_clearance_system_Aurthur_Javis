<?php
 session_start();
 error_reporting(0);
 include('../connect.php');
if(strlen($_SESSION['admin-username'])=="")
    {
    header("Location: login.php");
    }
    else{
	}
	$username=$_SESSION['admin-username'];

	date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d H:i:s');

$sql = "select * from admin where username='$username'";
$result = $conn->query($sql);
$row1= mysqli_fetch_array($result);

  $q = "select * from admin where username = '$username'";
  $q1 = $conn->query($q);
  while($row = mysqli_fetch_array($q1)){
    extract($row);
    $db_pass = $row['password'];
	 $email = $row['email'];
  }

if(isset($_POST["btnpassword"])){

  $old = $_POST['txtold_password'];
  $pass_new =  $_POST['txtnew_password'];
  $confirm_new =  $_POST['txtconfirm_password'];


  if($db_pass!=$old){ ?>
    <?php $_SESSION['error']='Old Password not matched';?>
   <!--  <script>
    alert('OLD Paasword not matched');
    </script> -->
  <?php } else if($pass_new!=$confirm_new){ ?>
    <?php $_SESSION['error']='NEW Password and CONFIRM password not Matched';?>
   <!--  <script>
    alert('NEW Password and CONFIRM password not Matched');
    </script> -->
  <?php } else {
    //$pass = md5($_POST['password']);
   $sql = "update  admin set `password`='$confirm_new' where username= '".$_SESSION['admin-username']."'";
  $res = $conn->query($sql);
  ?>
   <?php



   $_SESSION['success']='Password changed Successfully...';?>
  <script>
    //alert('Password changed Successfully...');
    window.location ="logout.php";
  </script>
  <?php

  }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Change Password|Admin Dashboard</title>
 <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- Custom styles -->
  <link rel="stylesheet" href="css/admin-custom.css">
  <link rel="stylesheet" href="../css/global-design-system.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Home</a>      </li>

    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">


    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="../images/logo.png" alt="Logo" width="200" height="111" class="" style="opacity: .8">
      <span class="brand-text font-weight-light"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../<?php echo $row1['photo'];    ?>" alt="User Image" width="220" height="192" class="img-circle elevation-2">        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $row1['fullname'];  ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

		 <?php
			   include('sidebar.php');

			   ?>


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Change Password</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Change Password  </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-md-6 mx-auto">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Update Your Password</h3>
                <div class="card-tools">
                  <a href="index.php" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back to Dashboard
                  </a>
                </div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
               <form id="form" action="" method="post" class="needs-validation" novalidate>
                <div class="card-body">
                  <div class="form-group">
                    <label for="txtold_password">Current Password *</label>
                    <div class="input-group">
                      <input type="password" class="form-control" name="txtold_password" id="txtold_password" value="<?php if (isset($_POST['txtold_password'])) echo $_POST['txtold_password']; ?>" placeholder="Enter Current Password" required>
                      <div class="input-group-append">
                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                          <i class="fa fa-eye"></i>
                        </span>
                      </div>
                    </div>
                    <div class="invalid-feedback">
                      Please enter your current password
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="txtnew_password">New Password *</label>
                    <div class="input-group">
                      <input type="password" class="form-control" name="txtnew_password" id="txtnew_password" value="<?php if (isset($_POST['txtnew_password'])) echo $_POST['txtnew_password']; ?>" placeholder="Enter New Password" required minlength="6">
                      <div class="input-group-append">
                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                          <i class="fa fa-eye"></i>
                        </span>
                      </div>
                    </div>
                    <div class="invalid-feedback">
                      Please enter a new password (at least 6 characters)
                    </div>
                    <small class="form-text text-muted">Password must be at least 6 characters long</small>
                  </div>
                  
                  <div class="form-group">
                    <label for="txtconfirm_password">Confirm New Password *</label>
                    <div class="input-group">
                      <input type="password" class="form-control" name="txtconfirm_password" id="txtconfirm_password" value="<?php if (isset($_POST['txtconfirm_password'])) echo $_POST['txtconfirm_password']; ?>" placeholder="Confirm New Password" required>
                      <div class="input-group-append">
                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                          <i class="fa fa-eye"></i>
                        </span>
                      </div>
                    </div>
                    <div class="invalid-feedback">
                      Please confirm your new password
                    </div>
                  </div>
                  
                  <div class="mt-4 p-3 bg-light rounded">
                    <h5 class="text-center">Password Requirements</h5>
                    <ul class="list-unstyled">
                      <li><i class="fa fa-check text-success mr-2"></i> At least 6 characters long</li>
                      <li><i class="fa fa-check text-success mr-2"></i> Include uppercase and lowercase letters</li>
                      <li><i class="fa fa-check text-success mr-2"></i> Include numbers</li>
                      <li><i class="fa fa-check text-success mr-2"></i> Include special characters</li>
                    </ul>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="btnpassword" class="btn btn-primary btn-block">
                    <i class="fa fa-key mr-2"></i> Update Password
                  </button>
                </div>
              </form>
            </div>
            
            <div class="card">
              <div class="card-body">
                <h4 class="text-center mb-4">Password Security Tips</h4>
                <div class="d-flex align-items-center mb-3">
                  <div class="p-2 bg-primary rounded-circle me-3">
                    <i class="fa fa-shield text-white"></i>
                  </div>
                  <div>
                    <h6 class="mb-0">Use Strong Passwords</h6>
                    <small class="text-muted">Include uppercase, lowercase, numbers, and symbols</small>
                  </div>
                </div>
                
                <div class="d-flex align-items-center mb-3">
                  <div class="p-2 bg-success rounded-circle me-3">
                    <i class="fa fa-refresh text-white"></i>
                  </div>
                  <div>
                    <h6 class="mb-0">Change Regularly</h6>
                    <small class="text-muted">Update your password every 3-6 months</small>
                  </div>
                </div>
                
                <div class="d-flex align-items-center mb-3">
                  <div class="p-2 bg-warning rounded-circle me-3">
                    <i class="fa fa-lock text-white"></i>
                  </div>
                  <div>
                    <h6 class="mb-0">Don't Reuse</h6>
                    <small class="text-muted">Avoid using the same password across multiple sites</small>
                  </div>
                </div>
                
                <div class="d-flex align-items-center">
                  <div class="p-2 bg-info rounded-circle me-3">
                    <i class="fa fa-question-circle text-white"></i>
                  </div>
                  <div>
                    <h6 class="mb-0">Need Help?</h6>
                    <small class="text-muted">Contact support if you have trouble accessing your account</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="card">
              <div class="card-body text-center">
                <img src="../<?php echo $row1['photo']; ?>" alt="User Profile" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                <h4><?php echo htmlspecialchars($row1['fullname']); ?></h4>
                <p class="text-muted"><?php echo htmlspecialchars($row1['designation']); ?></p>
                <p class="text-muted"><?php echo htmlspecialchars($row1['email']); ?></p>
                
                <div class="mt-4">
                  <div class="info-box mx-auto mb-3" style="max-width: 300px;">
                    <span class="info-box-icon bg-primary elevation-1">
                      <i class="fa fa-user"></i>
                    </span>
                    <div class="info-box-content">
                      <span class="info-box-text">Username</span>
                      <span class="info-box-number"><?php echo htmlspecialchars($row1['username']); ?></span>
                    </div>
                  </div>
                  
                  <div class="info-box mx-auto mb-3" style="max-width: 300px;">
                    <span class="info-box-icon bg-success elevation-1">
                      <i class="fa fa-calendar"></i>
                    </span>
                    <div class="info-box-content">
                      <span class="info-box-text">Last Login</span>
                      <span class="info-box-number"><?php echo date('M j, Y'); ?></span>
                    </div>
                  </div>
                  
                  <div class="info-box mx-auto" style="max-width: 300px;">
                    <span class="info-box-icon bg-warning elevation-1">
                      <i class="fa fa-shield-alt"></i>
                    </span>
                    <div class="info-box-content">
                      <span class="info-box-text">Account Status</span>
                      <span class="info-box-number"><?php echo htmlspecialchars($row1['status']); ?></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.0
    </div>
    <?php include('../footer.php');  ?>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>

<script>
  $(document).ready(function() {
    // Form validation
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
    
    // Password visibility toggle
    $('.toggle-password').on('click', function() {
      const input = $(this).closest('.input-group').find('input');
      const icon = $(this).find('i');
      
      if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
      } else {
        input.attr('type', 'password');
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
      }
    });
    
    // Password match validation
    $('#txtconfirm_password').on('input', function() {
      const newPassword = $('#txtnew_password').val();
      const confirmPassword = $(this).val();
      
      if (newPassword !== confirmPassword) {
        $(this).removeClass('is-valid').addClass('is-invalid');
      } else {
        $(this).removeClass('is-invalid').addClass('is-valid');
      }
    });
    
    // Add ripple effect to buttons
    $('.btn').on('click', function(e) {
      let $button = $(this);
      let circle = $('<span class="ripple"></span>');
      
      // Remove any existing ripples
      $button.find('.ripple').remove();
      
      // Add the ripple to the button
      $button.append(circle);
      
      // Position the ripple
      let xPos = e.pageX - $button.offset().left;
      let yPos = e.pageY - $button.offset().top;
      
      circle.css({
        top: yPos,
        left: xPos
      });
      
      // Remove the ripple after the animation
      setTimeout(function() {
        circle.remove();
      }, 600);
    });
  });
</script>

<link rel="stylesheet" href="popup_style.css">
<?php if(!empty($_SESSION['success'])) {  ?>
<div class="popup popup--icon -success js_success-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      <strong>Success</strong>
    </h1>
    <p><?php echo $_SESSION['success']; ?></p>
    <p>
      <button class="button button--success" data-for="js_success-popup">Close</button>
    </p>
  </div>
</div>
<?php unset($_SESSION["success"]);
} ?>
<?php if(!empty($_SESSION['error'])) {  ?>
<div class="popup popup--icon -error js_error-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      <strong>Error</strong>
    </h1>
    <p><?php echo $_SESSION['error']; ?></p>
    <p>
      <button class="button button--error" data-for="js_error-popup">Close</button>
    </p>
  </div>
</div>
<?php unset($_SESSION["error"]);  } ?>
    <script>
      var addButtonTrigger = function addButtonTrigger(el) {
  el.addEventListener('click', function () {
    var popupEl = document.querySelector('.' + el.dataset.for);
    popupEl.classList.toggle('popup--visible');
  });
};

Array.from(document.querySelectorAll('button[data-for]')).
forEach(addButtonTrigger);
    </script>
</body>
</html>