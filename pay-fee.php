<?php
session_start();
error_reporting(0);
include('connect.php');

if(empty($_SESSION['matric_no'])) {
    header("Location: login.php");
    exit();
}

date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d H:i:s');

//get necessary session details
$ID = $_SESSION["ID"];
$matric_no = $_SESSION["matric_no"];
$dept = $_SESSION['dept'];
$faculty = $_SESSION['faculty'];

// Fetch student data
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

// Calculate total fees required
$sql = "SELECT SUM(amount) as tot_fee FROM fee WHERE faculty=? AND dept=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $faculty, $dept);
$stmt->execute();
$result = $stmt->get_result();
$row_fee = $result->fetch_assoc();
$tot_fee = $row_fee['tot_fee'] ?? 0;

// Calculate total paid
$sql = "SELECT SUM(amount) as tot_pay FROM payment WHERE studentID=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $ID);
$stmt->execute();
$result = $stmt->get_result();
$rowpayment = $result->fetch_assoc();
$tot_pay = $rowpayment['tot_pay'] ?? 0;

$outstanding_fee = $tot_fee - $tot_pay;

// Handle payment submission
if(isset($_POST["btnpay"]) && isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    $amt = floatval($_POST['txtamt']);

    if ($amt <= 0) {
        $_SESSION['error'] = 'Amount must be greater than zero';
    } else if ($amt > $outstanding_fee) {
        $_SESSION['error'] = 'Amount can\'t be greater than Outstanding fee (NGN ' . number_format($outstanding_fee, 2) . ')';
    } else {
        // Generate secure payment ID
        $feeID = bin2hex(random_bytes(6)); // 12 character hex string

        // Insert payment record
        $insert_sql = "INSERT INTO payment (feeID, studentID, amount, datepaid) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ssss", $feeID, $ID, $amt, $current_date);

        if($insert_stmt->execute()) {
            $_SESSION['success'] = 'Fee payment was successful';
            // Refresh page to show updated amounts
            header("Location: pay-fee.php");
            exit();
        } else {
            $_SESSION['error'] = 'Problem processing payment. Please try again.';
        }
    }
}

// Generate CSRF token if it doesn't exist
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Payment | Online Student clearance system</title>

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
                            <h1 class="m-0">Fee Payment</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Fee Payment</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Make Payment</h3>
                                </div>
                                <div class="card-body">
                                    <?php if(!empty($_SESSION['success'])) { ?>
                                        <div class="alert alert-success alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <h5><i class="icon fas fa-check"></i> Success!</h5>
                                            <?php echo $_SESSION['success']; unset($_SESSION["success"]); ?>
                                        </div>
                                    <?php } ?>

                                    <?php if(!empty($_SESSION['error'])) { ?>
                                        <div class="alert alert-danger alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                            <?php echo $_SESSION['error']; unset($_SESSION["error"]); ?>
                                        </div>
                                    <?php } ?>

                                    <form role="form" method="POST" class="needs-validation" novalidate>
                                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                                        <div class="form-group">
                                            <label for="txtamt"><strong>Amount to Pay (NGN)</strong></label>
                                            <input type="number"
                                                   name="txtamt"
                                                   id="txtamt"
                                                   placeholder="Enter Amount to Pay"
                                                   class="form-control"
                                                   min="1"
                                                   max="<?php echo $outstanding_fee; ?>"
                                                   step="0.01"
                                                   required>
                                            <div class="invalid-feedback">
                                                Please enter a valid amount to pay
                                            </div>
                                            <small class="form-text text-muted">
                                                Maximum amount you can pay: NGN <?php echo number_format($outstanding_fee, 2); ?>
                                            </small>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit"
                                                    name="btnpay"
                                                    class="btn btn-primary btn-block"
                                                    onclick="return confirm('Are you sure you want to make this payment?');">
                                                <i class="fa fa-credit-card mr-2"></i> Make Payment
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Financial Summary</h3>
                                </div>
                                <div class="card-body">
                                    <div class="info-box mb-4">
                                        <span class="info-box-icon bg-primary elevation-1">
                                            <i class="fa fa-graduation-cap"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Total Fees Required</span>
                                            <span class="info-box-number">NGN <?php echo number_format($tot_fee, 2); ?></span>
                                        </div>
                                    </div>

                                    <div class="info-box mb-4">
                                        <span class="info-box-icon bg-success elevation-1">
                                            <i class="fa fa-money-bill-wave"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Amount Paid</span>
                                            <span class="info-box-number">NGN <?php echo number_format($tot_pay, 2); ?></span>
                                        </div>
                                    </div>

                                    <div class="info-box mb-4">
                                        <span class="info-box-icon bg-warning elevation-1">
                                            <i class="fa fa-calculator"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Outstanding Fee</span>
                                            <span class="info-box-number">NGN <?php echo number_format($outstanding_fee, 2); ?></span>
                                        </div>
                                    </div>

                                    <div class="mt-4 p-3 bg-light rounded">
                                        <h5 class="text-center">Payment Instructions</h5>
                                        <ul class="list-unstyled">
                                            <li><i class="fa fa-check text-success mr-2"></i> Enter amount you wish to pay</li>
                                            <li><i class="fa fa-check text-success mr-2"></i> Amount cannot exceed outstanding fee</li>
                                            <li><i class="fa fa-check text-success mr-2"></i> Multiple payments allowed</li>
                                            <li><i class="fa fa-check text-success mr-2"></i> Full payment completes fee clearance</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

            // Prevent resubmission on refresh
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        });
    </script>
</body>
</html>