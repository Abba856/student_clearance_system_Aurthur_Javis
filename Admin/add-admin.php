<?php
 session_start();
 error_reporting(0);
 include('../connect.php');

$username=$_SESSION['admin-username'];
$sql = "select * from admin where username='$username'";
$result = $conn->query($sql);
$row1= mysqli_fetch_array($result);

date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d H:i:s');


if(isset($_POST["btncreate"]))
{

$username = mysqli_real_escape_string($conn,$_POST['txtusername']);
$fullname = mysqli_real_escape_string($conn,$_POST['txtfullname']);
$email = mysqli_real_escape_string($conn,$_POST['txtemail']);
$password = mysqli_real_escape_string($conn,$_POST['txtpassword']);
$password2 = mysqli_real_escape_string($conn,$_POST['txtpassword2']);
$designation = mysqli_real_escape_string($conn,$_POST['cmddesignation']);


 $sql = "SELECT * FROM admin where username='$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
$_SESSION['error'] =' Username Already Exist ';

}elseif($password!=$password2){
$_SESSION['error'] ='Both Passwords Do not match';

}elseif(strlen($password) < 8){
$_SESSION['error'] ='Password must be at least 8 characters';


}else{
//save users details
$query = "INSERT into `admin` (username,password,designation,fullname,email,status,photo)
VALUES ('$username','$password','$designation','$fullname','$email','Active','uploads/avatar_nick.png')";


    $result = mysqli_query($conn,$query);
      if($result){
	  $_SESSION['email']=$email;
	  $_SESSION['password']=$password;

    $_SESSION['success'] ='User Added Successfully';

}else{
  $_SESSION['error'] ='Problem Adding User';

}
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create User|Dashboard</title>
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
            <h1 class="m-0 text-dark">Create User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Create User </li>
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
                <h3 class="card-title">Create New Admin User</h3>
                <div class="card-tools">
                  <a href="admin-record.php" class="btn btn-secondary btn-sm">
                    <i class="fa fa-list"></i> View All Users
                  </a>
                </div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
               <form id="form" action="" method="post" class="needs-validation" novalidate>
                <div class="card-body">
                  <div class="form-group">
                    <label for="txtusername">Username *</label>
                    <input type="text" class="form-control" name="txtusername" id="txtusername" size="77" value="<?php if (isset($_POST['txtusername'])) echo $_POST['txtusername']; ?>" placeholder="Enter Username" required>
                    <div class="invalid-feedback">
                      Please enter a username
                    </div>
                  </div>
				  
                  <div class="form-group">
                    <label for="txtfullname">Full Name *</label>
                    <input type="text" class="form-control" name="txtfullname" id="txtfullname" size="77" value="<?php if (isset($_POST['txtfullname'])) echo $_POST['txtfullname']; ?>" placeholder="Enter Full Name" required>
                    <div class="invalid-feedback">
                      Please enter a full name
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="txtpassword">Password *</label>
                    <div class="input-group">
                      <input type="password" class="form-control" name="txtpassword" id="txtpassword" size="77" value="<?php if (isset($_POST['txtpassword'])) echo $_POST['txtpassword']; ?>" placeholder="Enter Password" required minlength="8">
                      <div class="input-group-append">
                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                          <i class="fa fa-eye"></i>
                        </span>
                      </div>
                    </div>
                    <div class="invalid-feedback">
                      Please enter a password (minimum 8 characters)
                    </div>
                    <small class="form-text text-muted">Password must be at least 8 characters long</small>
                  </div>
                  
                  <div class="form-group">
                    <label for="txtpassword2">Confirm Password *</label>
                    <div class="input-group">
                      <input type="password" class="form-control" name="txtpassword2" id="txtpassword2" size="77" value="<?php if (isset($_POST['txtpassword2'])) echo $_POST['txtpassword2']; ?>" placeholder="Confirm Password" required>
                      <div class="input-group-append">
                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                          <i class="fa fa-eye"></i>
                        </span>
                      </div>
                    </div>
                    <div class="invalid-feedback">
                      Please confirm your password
                    </div>
                  </div>
				  
                  <div class="form-group">
                    <label for="cmddesignation">Designation *</label>
                    <select name="cmddesignation" id="cmddesignation" class="form-control" required>
                      <option value="">Select Designation</option>
                      <option value="Super Admin" <?php if (isset($_POST['cmddesignation']) && $_POST['cmddesignation'] == 'Super Admin') echo 'selected'; ?>>Super Admin</option>
                      <option value="Admin" <?php if (isset($_POST['cmddesignation']) && $_POST['cmddesignation'] == 'Admin') echo 'selected'; ?>>Admin</option>
                      <option value="Librarian" <?php if (isset($_POST['cmddesignation']) && $_POST['cmddesignation'] == 'Librarian') echo 'selected'; ?>>Librarian</option>
                      <option value="Bursar" <?php if (isset($_POST['cmddesignation']) && $_POST['cmddesignation'] == 'Bursar') echo 'selected'; ?>>Bursar</option>
                      <option value="Sport Director" <?php if (isset($_POST['cmddesignation']) && $_POST['cmddesignation'] == 'Sport Director') echo 'selected'; ?>>Sport Director</option>
                    </select>
                    <div class="invalid-feedback">
                      Please select a designation
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="txtemail">Email *</label>
                    <input type="email" class="form-control" name="txtemail" id="txtemail" size="77" value="<?php if (isset($_POST['txtemail'])) echo $_POST['txtemail']; ?>" placeholder="Enter Email" required>
                    <div class="invalid-feedback">
                      Please enter a valid email address
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="btncreate" class="btn btn-primary btn-block">
                    <i class="fa fa-user-plus mr-2"></i> Create User
                  </button>
                </div>
              </form>
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
    <div class="float-right d-none d-sm-inline-block">
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
    $('#txtpassword2').on('input', function() {
      const newPassword = $('#txtpassword').val();
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