<?php
session_start();
error_reporting(0);
include('connect.php');
if(empty($_SESSION['matric_no'])) {
    header("Location: login.php");
    exit();
}

$ID = $_SESSION["ID"];
$matric_no = $_SESSION["matric_no"];
$dept = $_SESSION['dept'];
$faculty = $_SESSION['faculty'];

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

// Calculate total fees required
$fee_sql = "SELECT SUM(amount) as tot_fee FROM fee WHERE faculty=? AND dept=?";
$fee_stmt = $conn->prepare($fee_sql);
$fee_stmt->bind_param("ss", $faculty, $dept);
$fee_stmt->execute();
$fee_result = $fee_stmt->get_result();
$fee_row = $fee_result->fetch_assoc();
$tot_fee = $fee_row['tot_fee'] ?? 0;

// Calculate total paid
$payment_sql = "SELECT SUM(amount) as tot_pay FROM payment WHERE studentID=?";
$payment_stmt = $conn->prepare($payment_sql);
$payment_stmt->bind_param("s", $ID);
$payment_stmt->execute();
$payment_result = $payment_stmt->get_result();
$payment_row = $payment_result->fetch_assoc();
$tot_pay = $payment_row['tot_pay'] ?? 0;

date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d H:i:s');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clearance Letter | Innovation Vocational Enterprise Institute</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/dashboard-style.css" rel="stylesheet">
    <link href="css/global-design-system.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">

    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background: white;
            }
            .letter-container {
                box-shadow: none;
                border: none;
                margin: 0;
                padding: 20mm;
            }
        }

        .letter-container {
            max-width: 210mm; /* A4 width */
            min-height: 297mm; /* A4 height */
            margin: 20px auto;
            padding: 30px;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            position: relative;
            border: 1px solid #e0e0e0;
        }

        .letter-header {
            text-align: center;
            border-bottom: 2px solid #4361ee;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .letter-logo {
            width: 100px;
            height: auto;
            margin-bottom: 15px;
        }

        .letter-content {
            line-height: 1.8;
        }

        .clearance-status {
            background: #f8f9fa;
            border-left: 4px solid #4ade80;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 4px 4px 0;
        }

        .signature-section {
            margin-top: 50px;
            text-align: right;
        }

        .registrar-signature {
            margin-top: 60px;
            font-weight: bold;
        }

        .print-controls {
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .btn-print {
            background: #4361ee;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .btn-print:hover {
            background: #3a56e4;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .student-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #4361ee;
            margin: 0 auto 15px;
            display: block;
        }
    </style>
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
                            <h1 class="m-0">Clearance Certificate</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Clearance Certificate</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Clearance Certificate</h3>
                                    <div class="card-tools">
                                        <button class="btn btn-primary" onclick="window.print();">
                                            <i class="fa fa-print"></i> Print Certificate
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="letter-container">
                                        <div class="letter-header">
                                            <img src="images/logo.png" alt="Institution Logo" class="letter-logo">
                                            <h1 style="font-size: 24px; margin: 10px 0;">INNOVATION VOCATIONAL ENTERPRISE INSTITUTE, KANO</h1>
                                            <p style="color: #666; margin: 0;">Official Clearance Certificate</p>
                                        </div>

                                        <div class="letter-content">
                                            <div style="text-align: center; margin-bottom: 30px;">
                                                <img src="<?php echo $rowaccess['photo']; ?>" alt="Student Photo" class="student-photo">
                                                <h2 style="font-size: 28px; color: #333; margin: 10px 0;">CLEARANCE CERTIFICATE</h2>
                                                <p style="color: #666; font-size: 16px;">Certificate No: CL-<?php echo str_pad($ID, 6, '0', STR_PAD_LEFT); ?></p>
                                            </div>

                                            <p><strong>Dear <?php echo htmlspecialchars($rowaccess['fullname']); ?>,</strong></p>

                                            <p>This is to certify that you have been cleared by the following departments:</p>

                                            <div class="clearance-status">
                                                <ul style="margin-bottom: 0;">
                                                    <li><strong>Hostel Department:</strong> <?php echo $rowaccess['is_hostel_approved'] ? '<span style="color: green;">✓ Cleared</span>' : '<span style="color: red;">✗ Pending</span>'; ?></li>
                                                    <li><strong>Student Affairs:</strong> <?php echo $rowaccess['is_stud_affairs_approved'] ? '<span style="color: green;">✓ Cleared</span>' : '<span style="color: red;">✗ Pending</span>'; ?></li>
                                                    <li><strong>Sports Department:</strong> <?php echo $rowaccess['is_sport_approved'] ? '<span style="color: green;">✓ Cleared</span>' : '<span style="color: red;">✗ Pending</span>'; ?></li>
                                                    <li><strong>Bursary Department:</strong> <?php echo ($tot_pay >= $tot_fee) ? '<span style="color: green;">✓ Cleared</span>' : '<span style="color: red;">✗ Pending</span>'; ?></li>
                                                </ul>
                                            </div>

                                            <p><strong>Student Details:</strong></p>
                                            <div style="margin-left: 20px;">
                                                <p><strong>Full Name:</strong> <?php echo htmlspecialchars($rowaccess['fullname']); ?></p>
                                                <p><strong>Matric Number:</strong> <?php echo htmlspecialchars($rowaccess['matric_no']); ?></p>
                                                <p><strong>Faculty:</strong> <?php echo htmlspecialchars($rowaccess['faculty']); ?></p>
                                                <p><strong>Department:</strong> <?php echo htmlspecialchars($rowaccess['dept']); ?></p>
                                            </div>

                                            <p>This certificate confirms that you have completed all necessary clearance requirements and are eligible to proceed with graduation, convocation, and National Youth Service Corps (NYSC) registration.</p>

                                            <p>We wish you success in your future endeavors.</p>

                                            <div class="signature-section">
                                                <p>Date: <?php echo date('F j, Y'); ?></p>
                                                <div class="registrar-signature">
                                                    <p>_________________________</p>
                                                    <p><strong>REGISTRAR</strong></p>
                                                    <p>Innovation Vocational Enterprise Institute</p>
                                                </div>
                                            </div>
                                        </div>
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
        });
    </script>
</body>
</html>