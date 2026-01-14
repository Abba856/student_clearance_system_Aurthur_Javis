<?php
session_start();
error_reporting(0);
include('connect.php');

if(empty($_SESSION['matric_no'])) {
    header("Location: login.php");
    exit();
}

$matric_no = $_SESSION["matric_no"];

// Fetch user data
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

$db_pass = $rowaccess['password'];

if(isset($_POST["btnchange"])) {
    $old_password = trim($_POST['txtold_password']);
    $new_password = trim($_POST['txtnew_password']);
    $confirm_password = trim($_POST['txtconfirm_password']);

    // Verify old password using password_verify
    if (!password_verify($old_password, $db_pass)) {
        $_SESSION['error'] = 'Old Password is incorrect';
    } else if ($new_password !== $confirm_password) {
        $_SESSION['error'] = 'New Password and Confirm Password do not match';
    } else if (strlen($new_password) < 6) {
        $_SESSION['error'] = 'Password must be at least 6 characters long';
    } else {
        // Hash the new password
        $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in database
        $update_sql = "UPDATE students SET password=? WHERE matric_no=?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ss", $hashed_new_password, $matric_no);

        if ($update_stmt->execute()) {
            $_SESSION['success'] = 'Password changed successfully!';
            // Redirect to login after success
            header("refresh:3;url=login.php");
        } else {
            $_SESSION['error'] = 'Error updating password. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password| Online clearance system</title>
    
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
                            <h1 class="m-0">Change Password</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Change Password</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Update Your Password</h3>
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
                                        <div class="form-group">
                                            <label for="txtold_password"><strong>Current Password</strong></label>
                                            <div class="input-group">
                                                <input type="password"
                                                       name="txtold_password"
                                                       id="txtold_password"
                                                       placeholder="Enter Current Password"
                                                       class="form-control"
                                                       required>
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
                                            <label for="txtnew_password"><strong>New Password</strong></label>
                                            <div class="input-group">
                                                <input type="password"
                                                       name="txtnew_password"
                                                       id="txtnew_password"
                                                       placeholder="Enter New Password"
                                                       class="form-control"
                                                       required
                                                       minlength="6">
                                                <div class="input-group-append">
                                                    <span class="input-group-text toggle-password" style="cursor: pointer;">
                                                        <i class="fa fa-eye"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter a new password (at least 6 characters)
                                            </div>
                                            <small class="form-text text-muted">
                                                Password must be at least 6 characters long
                                            </small>
                                        </div>

                                        <div class="form-group">
                                            <label for="txtconfirm_password"><strong>Confirm New Password</strong></label>
                                            <div class="input-group">
                                                <input type="password"
                                                       name="txtconfirm_password"
                                                       id="txtconfirm_password"
                                                       placeholder="Confirm New Password"
                                                       class="form-control"
                                                       required>
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

                                        <div class="form-group">
                                            <button class="btn btn-primary btn-block" type="submit" name="btnchange">
                                                <i class="fa fa-key mr-2"></i> Update Password
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Password Security Tips</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="p-2 bg-primary rounded-circle me-3">
                                            <i class="fa fa-shield text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Use Strong Passwords</h6>
                                            <small class="text-muted">Include uppercase, lowercase, numbers, and symbols</small>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-start mb-3">
                                        <div class="p-2 bg-success rounded-circle me-3">
                                            <i class="fa fa-refresh text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Change Regularly</h6>
                                            <small class="text-muted">Update your password every 3-6 months</small>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-start mb-3">
                                        <div class="p-2 bg-warning rounded-circle me-3">
                                            <i class="fa fa-lock text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Don't Reuse</h6>
                                            <small class="text-muted">Avoid using the same password across multiple sites</small>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-start">
                                        <div class="p-2 bg-info rounded-circle me-3">
                                            <i class="fa fa-question-circle text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Need Help?</h6>
                                            <small class="text-muted">Contact support if you have trouble accessing your account</small>
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
        });
    </script>
</body>
</html>