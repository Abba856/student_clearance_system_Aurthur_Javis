<?php
 session_start();
 error_reporting(0);
 include('../connect.php');
 include('../connect2.php');

$username=$_SESSION['admin-username'];
$sql = "select * from admin where username='$username'";
$result = $conn->query($sql);
$row1= mysqli_fetch_array($result);

date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d H:i:s');


if(isset($_POST["btnregister"]))
{


  $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
  $password_stud = substr(str_shuffle($permitted_chars), 0, 6);

$fullname = mysqli_real_escape_string($conn,$_POST['txtfullname']);
$matric_no = mysqli_real_escape_string($conn,$_POST['txtmatric_no']);
$phone = mysqli_real_escape_string($conn,$_POST['txtphone']);
$session = mysqli_real_escape_string($conn,$_POST['cmdsession']);
$faculty = mysqli_real_escape_string($conn,$_POST['cmdfaculty']);
$dept = mysqli_real_escape_string($conn,$_POST['cmddept']);
$phone = mysqli_real_escape_string($conn,$_POST['txtphone']);


 $sql = "SELECT * FROM students where matric_no='$matric_no'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
$_SESSION['error'] =' Matric No already Exist ';

}else{
//save users details
$query = "INSERT into `students` (fullname,matric_no,password,session,faculty,dept,phone,photo)
VALUES ('$fullname','$matric_no','$password_stud','$session','$faculty','$dept','$phone','uploads/avatar_nick.png')";


    $result = mysqli_query($conn,$query);
      if($result){
	  $_SESSION['matric_no']=$matric_no;

//SEnd password Via SMS
$username='rexrolex0@gmail.com';//Note: urlencodemust be added forusernameand
$password='admin123';// passwordas encryption code for security purpose.

$sender='AUTHUR-JAVI';
$message  = 'Dear '.$fullname.', Your password for online clearance system is :'.$password_stud.' ';
$api_url  = 'https://portal.nigeriabulksms.com/api/';

//Create the message data
$data = array('username'=>$username, 'password'=>$password, 'sender'=>$sender, 'message'=>$message, 'mobiles'=>$phone);
//URL encode the message data
$data = http_build_query($data);
//Send the message
$request = $api_url.'?'.$data;
$result  = file_get_contents($request);
$result  = json_decode($result);


$_SESSION['success'] ='Student Registration was successful';

}else{
$_SESSION['error'] ='Problem registering student';

}
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register Student|Dashboard</title>
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
            <h1 class="m-0 text-dark">Register Student</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Register Student</li>
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
          <div class="col-md-8 mx-auto">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Register New Student</h3>
                <div class="card-tools">
                  <a href="student-record.php" class="btn btn-secondary btn-sm">
                    <i class="fa fa-list"></i> View All Students
                  </a>
                </div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
               <form id="form" action="" method="post" class="needs-validation" novalidate>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="txtfullname">Full Name *</label>
                        <input type="text" class="form-control" name="txtfullname" id="txtfullname" value="<?php if (isset($_POST['txtfullname'])) echo $_POST['txtfullname']; ?>" placeholder="Enter Full Name" required>
                        <div class="invalid-feedback">
                          Please enter the student's full name
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="txtmatric_no">Matric No. *</label>
                        <input type="text" class="form-control" name="txtmatric_no" id="txtmatric_no" value="<?php if (isset($_POST['txtmatric_no'])) echo $_POST['txtmatric_no']; ?>" placeholder="Enter Matric No." required>
                        <div class="invalid-feedback">
                          Please enter the matric number
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="txtphone">Phone No. *</label>
                        <input type="tel" class="form-control" name="txtphone" id="txtphone" value="<?php if (isset($_POST['txtphone'])) echo $_POST['txtphone']; ?>" placeholder="Enter Phone" required>
                        <div class="invalid-feedback">
                          Please enter a valid phone number
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="cmdsession">Session *</label>
                        <?php
//Our select statement. This will retrieve the data that we want.
$sql = "SELECT * FROM tblsession";
//Prepare the select statement.
$stmt = $dbh->prepare($sql);
//Execute the statement.
$stmt->execute();
//Retrieve the rows using fetchAll.
$sessions = $stmt->fetchAll();
?>
      <select name="cmdsession" id="cmdsession" class="form-control" required>
        <option value="">Select Session</option>
    <?php foreach($sessions as $row_session): ?>
        <option value="<?= $row_session['session']; ?>" <?php if (isset($_POST['cmdsession']) && $_POST['cmdsession'] == $row_session['session']) echo 'selected'; ?>><?= $row_session['session']; ?></option>
    <?php endforeach; ?>
</select>
                        <div class="invalid-feedback">
                          Please select a session
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="cmdfaculty">Faculty *</label>
                        <select name="cmdfaculty" id="cmdfaculty" class="form-control" required>
                          <option value="">Select Faculty</option>
                          <option value="Science" <?php if (isset($_POST['cmdfaculty']) && $_POST['cmdfaculty'] == 'Science') echo 'selected'; ?>>Science</option>
                          <option value="Engineering" <?php if (isset($_POST['cmdfaculty']) && $_POST['cmdfaculty'] == 'Engineering') echo 'selected'; ?>>Engineering</option>
                          <option value="Social Science" <?php if (isset($_POST['cmdfaculty']) && $_POST['cmdfaculty'] == 'Social Science') echo 'selected'; ?>>Social Science</option>
                          <option value="Arts" <?php if (isset($_POST['cmdfaculty']) && $_POST['cmdfaculty'] == 'Arts') echo 'selected'; ?>>Arts</option>
                          <option value="Law" <?php if (isset($_POST['cmdfaculty']) && $_POST['cmdfaculty'] == 'Law') echo 'selected'; ?>>Law</option>
                          <option value="Medicine" <?php if (isset($_POST['cmdfaculty']) && $_POST['cmdfaculty'] == 'Medicine') echo 'selected'; ?>>Medicine</option>
                        </select>
                        <div class="invalid-feedback">
                          Please select a faculty
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="cmddept">Department *</label>
                        <select name="cmddept" id="cmddept" class="form-control" required>
                          <option value="">Select Department</option>
                          <option value="Computer Science" <?php if (isset($_POST['cmddept']) && $_POST['cmddept'] == 'Computer Science') echo 'selected'; ?>>Computer Science</option>
                          <option value="Electrical Engineering" <?php if (isset($_POST['cmddept']) && $_POST['cmddept'] == 'Electrical Engineering') echo 'selected'; ?>>Electrical Engineering</option>
                          <option value="Business Management" <?php if (isset($_POST['cmddept']) && $_POST['cmddept'] == 'Business Management') echo 'selected'; ?>>Business Management</option>
                          <option value="Information Technology" <?php if (isset($_POST['cmddept']) && $_POST['cmddept'] == 'Information Technology') echo 'selected'; ?>>Information Technology</option>
                          <option value="Mathematics" <?php if (isset($_POST['cmddept']) && $_POST['cmddept'] == 'Mathematics') echo 'selected'; ?>>Mathematics</option>
                          <option value="Physics" <?php if (isset($_POST['cmddept']) && $_POST['cmddept'] == 'Physics') echo 'selected'; ?>>Physics</option>
                          <option value="Chemistry" <?php if (isset($_POST['cmddept']) && $_POST['cmddept'] == 'Chemistry') echo 'selected'; ?>>Chemistry</option>
                          <option value="Biology" <?php if (isset($_POST['cmddept']) && $_POST['cmddept'] == 'Biology') echo 'selected'; ?>>Biology</option>
                        </select>
                        <div class="invalid-feedback">
                          Please select a department
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="btnregister" class="btn btn-primary btn-block">
                    <i class="fa fa-user-plus mr-2"></i> Register Student
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