<?php
session_start();
error_reporting(0);
include('connect.php');

if(empty($_SESSION['matric_no'])) {
    header("Location: login.php");
    exit();
} else {
    $ID = $_SESSION["ID"];
    $matric_no = $_SESSION["matric_no"];
    $dept = $_SESSION['dept'];
    $faculty = $_SESSION['faculty'];

    date_default_timezone_set('Africa/Lagos');
    $current_date = date('Y-m-d H:i:s');

    // Fetch student data using prepared statement
    $sql = "SELECT * FROM students WHERE matric_no=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $rowaccess = $result->fetch_assoc();

    if (!$rowaccess) {
        header("Location: login.php");
        exit();
    }

    // Fetch payment history using prepared statement
    $payment_sql = "SELECT * FROM payment WHERE studentID=? ORDER BY datepaid DESC";
    $payment_stmt = $conn->prepare($payment_sql);
    $payment_stmt->bind_param("s", $ID);
    $payment_stmt->execute();
    $payment_result = $payment_stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Payment History | Online Student Clearance system</title>

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
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-user"></i>
                        <span class="badge badge-danger navbar-badge"><?php echo htmlspecialchars($rowaccess['fullname']); ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-item">
                            <div class="media">
                                <img src="<?php echo $rowaccess['photo']; ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title"><?php echo htmlspecialchars($rowaccess['fullname']); ?></h3>
                                    <p class="text-sm"><?php echo htmlspecialchars($rowaccess['matric_no']); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="logout.php" class="dropdown-item">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </div>
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
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Payment History</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Payment History</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Payment Records</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Payment ID</th>
                                                <th>Amount</th>
                                                <th>Date of Payment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cnt = 1;
                                            if ($payment_result->num_rows > 0) {
                                                while($row = $payment_result->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?php echo $cnt; ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($row['feeID']); ?></td>
                                                <td class="text-center"><strong>NGN<?php echo number_format((float)$row['amount'], 2); ?></strong></td>
                                                <td class="text-center"><?php echo $row['datepaid']; ?></td>
                                            </tr>
                                            <?php
                                                    $cnt++;
                                                }
                                            } else {
                                            ?>
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    <div class="alert alert-info mb-0">
                                                        <i class="fa fa-info-circle"></i> No payment records found.
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>

                    <?php if($payment_result->num_rows > 0) { ?>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-success elevation-1">
                                    <i class="fa fa-money"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Payments</span>
                                    <span class="info-box-number">
                                        <?php
                                        // Count total payments using prepared statement
                                        $total_payments_sql = "SELECT COUNT(*) as total FROM payment WHERE studentID=?";
                                        $total_stmt = $conn->prepare($total_payments_sql);
                                        $total_stmt->bind_param("s", $ID);
                                        $total_stmt->execute();
                                        $total_result = $total_stmt->get_result();
                                        $total_row = $total_result->fetch_assoc();
                                        echo $total_row['total'];
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary elevation-1">
                                    <i class="fa fa-calculator"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Amount Paid</span>
                                    <span class="info-box-number">
                                        NGN
                                        <?php
                                        // Calculate total amount using prepared statement
                                        $total_amount_sql = "SELECT SUM(amount) as total FROM payment WHERE studentID=?";
                                        $amount_stmt = $conn->prepare($total_amount_sql);
                                        $amount_stmt->bind_param("s", $ID);
                                        $amount_stmt->execute();
                                        $amount_result = $amount_stmt->get_result();
                                        $amount_row = $amount_result->fetch_assoc();
                                        echo number_format((float)$amount_row['total'], 2);
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning elevation-1">
                                    <i class="fa fa-clock-o"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Last Payment</span>
                                    <span class="info-box-number">
                                        <?php
                                        // Get last payment date using prepared statement
                                        $last_payment_sql = "SELECT datepaid FROM payment WHERE studentID=? ORDER BY datepaid DESC LIMIT 1";
                                        $last_stmt = $conn->prepare($last_payment_sql);
                                        $last_stmt->bind_param("s", $ID);
                                        $last_stmt->execute();
                                        $last_result = $last_stmt->get_result();
                                        if($last_result->num_rows > 0) {
                                            $last_row = $last_result->fetch_assoc();
                                            echo date('M j, Y', strtotime($last_row['datepaid']));
                                        } else {
                                            echo 'None';
                                        }
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </section>
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <?php include('footer.php'); ?>
        </footer>
    </div>
    <!-- ./wrapper -->

    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/inspinia.js"></script>

    <!-- AdminLTE App -->
    <script>
        $(document).ready(function() {
            // Initialize push menu widget for sidebar toggle
            $('[data-widget="pushmenu"]').PushMenu();

            // Initialize treeview for sidebar navigation
            $('[data-widget="treeview"]').Treeview('init');
        });
    </script>
</body>
</html>