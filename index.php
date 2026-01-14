<?php
session_start();
error_reporting(0);
include('connect.php');
if(empty($_SESSION['matric_no']))
    {
    header("Location: login.php");
    }
    else{
	}


    //get neccesary session details
    $ID = $_SESSION["ID"];
    $matric_no = $_SESSION["matric_no"];
    $dept = $_SESSION['dept'];
    $faculty = $_SESSION['faculty'];


    $sql = "select SUM(amount) as tot_fee from fee where faculty='$faculty' AND dept='$dept'";
    $result = $conn->query($sql);
    $row_fee = mysqli_fetch_array($result);
    $tot_fee=$row_fee['tot_fee'];

    //Get outstanding payment etc
    $sql = "select SUM(amount) as tot_pay from payment where studentID='$ID'";
    $result = $conn->query($sql);
    $rowpayment = mysqli_fetch_array($result);
    $tot_pay=$rowpayment['tot_pay'];

    $outstanding_fee=$tot_fee-$tot_pay;

$sql = "select * from students where matric_no='$matric_no'";
$result = $conn->query($sql);
$rowaccess = mysqli_fetch_array($result);

$hostel = $rowaccess["is_hostel_approved"];
$sport = $rowaccess['is_sport_approved'];
$stud_affairs = $rowaccess['is_stud_affairs_approved'];

date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d H:i:s');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard | Online clearance System</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/dashboard-style.css" rel="stylesheet">
    <link href="css/global-design-system.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index.php" class="brand-link">
                <img src="images/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8; width: auto; height: 40px;">
                <span class="brand-text font-weight-light">Student Portal</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <?php
                include('sidebar.php');
                ?>
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>NGN<?php echo number_format((float) $tot_fee, 2); ?></h3>
                                    <p>Total Fee Required</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>NGN<?php echo number_format((float) $tot_pay, 2); ?></h3>
                                    <p>Amount Paid</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>NGN<?php echo number_format((float) $outstanding_fee, 2); ?></h3>
                                    <p>Outstanding Fee</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-calculator"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <?php if (($outstanding_fee) == "0" && ($sport) == "1" && ($hostel) == "1" && ($stud_affairs) == "1") { ?>
                                        <h3><i class="fas fa-check-circle"></i> Cleared</h3>
                                        <p>Status: Ready for Letter</p>
                                    <?php } else { ?>
                                        <h3><i class="fas fa-times-circle"></i> Pending</h3>
                                        <p>Status: Incomplete</p>
                                    <?php } ?>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                                <?php if (($outstanding_fee) == "0" && ($sport) == "1" && ($hostel) == "1" && ($stud_affairs) == "1") { ?>
                                    <a href="letter.php" class="small-box-footer">Print Clearance Letter <i class="fas fa-arrow-circle-right"></i></a>
                                <?php } else { ?>
                                    <a href="#" class="small-box-footer">Complete Requirements <i class="fas fa-arrow-circle-right"></i></a>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-12">
                            <!-- Custom tabs (Charts with tabs)-->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-pie mr-1"></i>
                                        Clearance Status
                                    </h3>
                                    <div class="card-tools">
                                        <ul class="nav nav-pills ml-auto">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#status-chart" data-toggle="tab">Overview</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content p-0">
                                        <div class="chart tab-pane active" id="status-chart" style="position: relative; height: 300px;">
                                            <div class="row">
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="info-box mb-3">
                                                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Fee Payment</span>
                                                            <span class="info-box-number">
                                                                <?php if (($outstanding_fee) == (("0"))) { ?>
                                                                    <span class="badge badge-success">Cleared</span>
                                                                <?php } else { ?>
                                                                    <span class="badge badge-warning">Pending</span>
                                                                <?php } ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="info-box mb-3">
                                                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-home"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Hostel Clearance</span>
                                                            <span class="info-box-number">
                                                                <?php if (($rowaccess['is_hostel_approved']) == (("0"))) { ?>
                                                                    <span class="badge badge-warning">Pending</span>
                                                                <?php } else { ?>
                                                                    <span class="badge badge-success">Cleared</span>
                                                                <?php } ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="info-box mb-3">
                                                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-football-ball"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Sport Clearance</span>
                                                            <span class="info-box-number">
                                                                <?php if (($rowaccess['is_sport_approved']) == (("0"))) { ?>
                                                                    <span class="badge badge-warning">Pending</span>
                                                                <?php } else { ?>
                                                                    <span class="badge badge-success">Cleared</span>
                                                                <?php } ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="info-box mb-3">
                                                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Student Affairs</span>
                                                            <span class="info-box-number">
                                                                <?php if (($rowaccess['is_stud_affairs_approved']) == (("0"))) { ?>
                                                                    <span class="badge badge-warning">Pending</span>
                                                                <?php } else { ?>
                                                                    <span class="badge badge-success">Cleared</span>
                                                                <?php } ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </section>
                    </div>
                    <!-- /.row -->
                </div><!--/. container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <?php include('footer.php'); ?>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="js/jquery-2.1.1.js"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/inspinia.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize push menu widget for sidebar toggle
            $('[data-widget="pushmenu"]').PushMenu();

            // Initialize treeview for sidebar navigation
            $('[data-widget="treeview"]').Treeview('init');

            // Auto-refresh status indicators
            setInterval(function() {
                $('.info-box-number .badge').addClass('pulse');
                setTimeout(function() {
                    $('.info-box-number .badge').removeClass('pulse');
                }, 500);
            }, 30000); // Refresh every 30 seconds

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Use AdminLTE's built-in sidebar toggle functionality
            // The sidebar collapse is handled by the 'sidebar-mini' and 'sidebar-collapse' classes
        });

        // Add CSS for pulse animation
        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.05); }
                100% { transform: scale(1); }
            }
            .pulse {
                animation: pulse 0.5s ease-in-out;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>