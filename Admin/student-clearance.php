<?php
session_start();
error_reporting(0);
include('../connect.php');
if(empty($_SESSION['admin-username']))
    {
    header("Location: login.php");
    }
    else{
	}
	$username=$_SESSION['admin-username'];


date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d');

$sql = "select * from admin where username='$username'";
$result = $conn->query($sql);
$row= mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student Clearance|Dashboard</title>
<link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->

  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

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

 <script type="text/javascript">
function clear_student(matric_no){
if(confirm("ARE YOU SURE YOU WISH TO CLEAR STUDENT WITH MATRIC NO. " + " " + matric_no + " " + " FOR NYSC/GRADUATION ?"))
{
return  true;
}
else {return false;
}

}
</script>

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
        <a href="index.php" class="nav-link">Home</a>
         </li>

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
	    <span class="brand-text font-weight-light">  </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../<?php echo $row['photo'];  ?>" alt="User Image" width="220" height="192" class="img-circle elevation-2">        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $row['fullname'];  ?></a>
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
            <h1 class="m-0 text-dark">Student Clearance</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Student Clearance</li>
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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Student Clearance Records</h3>
                <div class="card-tools">
                  <a href="index.php" class="btn btn-primary btn-sm">
                    <i class="fa fa-arrow-left"></i> Back to Dashboard
                  </a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped" id="example1">
                    <thead class="thead-light">
                      <tr>
                        <th>Full Name</th>
                        <th>Photo</th>
                        <th>Matric No</th>
                        <th>Hostel Status</th>
                        <th>Sport Status</th>
                        <th>Student Affairs Status</th>
                        <th>Overall Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT * FROM students ORDER BY ID ASC";
                      $result = $conn->query($sql);
                      while($row = $result->fetch_assoc()) {
                        $is_cleared = ($row['is_hostel_approved'] == 1 && $row['is_sport_approved'] == 1 && $row['is_stud_affairs_approved'] == 1) ? true : false;
                      ?>
                      <tr>
                        <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                        <td class="text-center">
                          <img src="../<?php echo $row['photo'];?>" alt="Student Photo" width="60" height="60" class="rounded-circle img-thumbnail">
                        </td>
                        <td class="text-center"><?php echo htmlspecialchars($row['matric_no']); ?></td>
                        <td class="text-center">
                          <?php if ($row['is_hostel_approved'] == 1) { ?>
                            <span class="badge badge-success">Cleared</span>
                          <?php } else { ?>
                            <a href="clear_hostel.php?id=<?php echo $row['ID'];?>" onClick="return clear_student('<?php echo $row['matric_no']; ?>');" class="btn btn-sm btn-warning">
                              <i class="fa fa-check"></i> Clear
                            </a>
                          <?php } ?>
                        </td>
                        <td class="text-center">
                          <?php if ($row['is_sport_approved'] == 1) { ?>
                            <span class="badge badge-success">Cleared</span>
                          <?php } else { ?>
                            <a href="clear_sport.php?id=<?php echo $row['ID'];?>" onClick="return clear_student('<?php echo $row['matric_no']; ?>');" class="btn btn-sm btn-warning">
                              <i class="fa fa-check"></i> Clear
                            </a>
                          <?php } ?>
                        </td>
                        <td class="text-center">
                          <?php if ($row['is_stud_affairs_approved'] == 1) { ?>
                            <span class="badge badge-success">Cleared</span>
                          <?php } else { ?>
                            <a href="clear_student_affairs.php?id=<?php echo $row['ID'];?>" onClick="return clear_student('<?php echo $row['matric_no']; ?>');" class="btn btn-sm btn-warning">
                              <i class="fa fa-check"></i> Clear
                            </a>
                          <?php } ?>
                        </td>
                        <td class="text-center">
                          <?php if ($is_cleared) { ?>
                            <span class="badge badge-success">Fully Cleared</span>
                          <?php } else { ?>
                            <span class="badge badge-warning">Pending</span>
                          <?php } ?>
                        </td>
                        <td class="text-center">
                          <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                              Actions
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="clear_hostel.php?id=<?php echo $row['ID'];?>" onClick="return clear_student('<?php echo $row['matric_no']; ?>');">
                                <i class="fa fa-bed mr-2"></i>Clear Hostel
                              </a>
                              <a class="dropdown-item" href="clear_sport.php?id=<?php echo $row['ID'];?>" onClick="return clear_student('<?php echo $row['matric_no']; ?>');">
                                <i class="fa fa-futbol mr-2"></i>Clear Sport
                              </a>
                              <a class="dropdown-item" href="clear_student_affairs.php?id=<?php echo $row['ID'];?>" onClick="return clear_student('<?php echo $row['matric_no']; ?>');">
                                <i class="fa fa-users mr-2"></i>Clear Student Affairs
                              </a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.0
    </div>
    <?php  include('../footer.php');   ?>
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
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
      "language": {
        "paginate": {
          "previous": "&laquo;",
          "next": "&raquo;"
        }
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
</body>
</html>