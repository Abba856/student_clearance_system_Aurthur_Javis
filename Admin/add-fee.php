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


if(isset($_POST["btnAdd"]))
{

$faculty = mysqli_real_escape_string($conn,$_POST['cmdfaculty']);
$dept = mysqli_real_escape_string($conn,$_POST['cmddept']);
$session = mysqli_real_escape_string($conn,$_POST['cmdsession']);
$amt = mysqli_real_escape_string($conn,$_POST['txtamt']);


 $sql = "SELECT * FROM fee where session='$session' and faculty='$faculty' and dept='$dept'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
$_SESSION['error'] ='This Fee Already Exist ';

}else{
//save fee details
$query = "INSERT into `fee` (session,faculty,dept,amount)
VALUES ('$session','$faculty','$dept','$amt')";


    $result = mysqli_query($conn,$query);
      if($result){
	  //$_SESSION['matric_no']=$matric_no;

$_SESSION['success'] ='Fee Added successfully';

}else{
$_SESSION['error'] ='Problem Adding fee';

}
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add fee|Admin Dashboard</title>
 <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Custom styles -->
  <link rel="stylesheet" href="css/admin-custom.css">
  <link rel="stylesheet" href="../css/global-design-system.css">

  <script type="text/javascript">
		function deldata(){
if(confirm("ARE YOU SURE YOU WISH TO DELETE THIS FEE ?" ))
{
return  true;
}
else {return false;
}

}

</script>
</head>
<body class="hold-transition sidebar-mini">
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
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Fee</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Add Fee</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add New Fee</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="form" action="" method="post" class="needs-validation" novalidate>
                <div class="card-body">
                  <div class="form-group">
                    <label for="cmdsession">Session</label>
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
      <select name="cmdsession" id="cmdsession" class="form-control" required="">
        <option value="">Select Session</option>
    <?php foreach($sessions as $row_session): ?>
        <option value="<?= $row_session['session']; ?>"><?= $row_session['session']; ?></option>
    <?php endforeach; ?>
</select>
<div class="invalid-feedback">
  Please select a session
</div>
   </div>
   
   <div class="form-group">
                    <label for="cmdfaculty">Faculty</label>
                    <select name="cmdfaculty" id="cmdfaculty" class="form-control" required="">
                      <option value="">Select Faculty</option>
                      <option value="Science">Science</option>
                      <option value="Engineering">Engineering</option>
                      <option value="Social Science">Social Science</option>
                      <option value="Arts">Arts</option>
                      <option value="Law">Law</option>
                      <option value="Medicine">Medicine</option>
                    </select>
                    <div class="invalid-feedback">
                      Please select a faculty
                    </div>
                  </div>
				  
				  <div class="form-group">
                    <label for="cmddept">Department</label>
                    <select name="cmddept" id="cmddept" class="form-control" required="">
                      <option value="">Select Department</option>
                      <option value="Computer Science">Computer Science</option>
                      <option value="Electrical Engineering">Electrical Engineering</option>
                      <option value="Business Management">Business Management</option>
                      <option value="Information Technology">Information Technology</option>
                      <option value="Mathematics">Mathematics</option>
                      <option value="Physics">Physics</option>
                      <option value="Chemistry">Chemistry</option>
                      <option value="Biology">Biology</option>
                    </select>
                    <div class="invalid-feedback">
                      Please select a department
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="txtamt">Amount (NGN)</label>
                    <input type="number" class="form-control" name="txtamt" id="txtamt" value="<?php if (isset($_POST['txtamt'])) echo $_POST['txtamt']; ?>" placeholder="Enter Amount" required>
                    <div class="invalid-feedback">
                      Please enter a valid amount
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="btnAdd" class="btn btn-primary btn-block">
                    <i class="fa fa-plus mr-2"></i> Add Fee
                  </button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-8">
            <!-- general form elements disabled -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Fee Structure</h3>
                <div class="card-tools">
                  <a href="fee-record.php" class="btn btn-primary btn-sm">
                    <i class="fa fa-list"></i> View All Fees
                  </a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped" id="example1">
                    <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Faculty</th>
                        <th>Department</th>
                        <th>Session</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT * FROM fee ORDER BY session ASC";
                    $result = $conn->query($sql);
                    $cnt=1;
                    while($row = $result->fetch_assoc()) { ?>
                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo htmlspecialchars($row['faculty']); ?></td>
                        <td><?php echo htmlspecialchars($row['dept']); ?></td>
                        <td><?php echo htmlspecialchars($row['session']); ?></td>
                        <td><strong>NGN<?php echo number_format((float) $row['amount'], 2); ?></strong></td>
                        <td>
                          <div class="btn-group">
                    <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown">
                      Actions
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="delete-fee.php?id=<?php echo $row['ID'];?>" onClick="return deldata();">
                        <i class="fa fa-trash mr-2"></i>Delete
                      </a>
                    </div>
                  </div>
                </td>
                      </tr>
                    <?php $cnt=$cnt+1;} ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!--/.col (right) -->
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
    <strong><?php include '../footer.php' ?></strong>
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
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
$(function () {
  bsCustomFileInput.init();
  
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