<?php
session_start();
error_reporting(1);
include('connect2.php');

if(isset($_POST['btnlogin']))
{
if($_POST['txtmatric_no'] != "" && $_POST['txtpassword'] != ""){ // Changed OR to AND for proper validation

$matric_no =$_POST['txtmatric_no'];
$password = $_POST['txtpassword'];

$sql = "SELECT * FROM `students` WHERE `matric_no`=? AND `password`=? ";
			$query = $dbh->prepare($sql);
			$query->execute(array($matric_no,$password));
			$row = $query->rowCount();
			$fetch = $query->fetch();
			if($row > 0) {

      //  $_SESSION['matric_no'] = $fetch['matric_no'];
      //$_SESSION['dept'] = $fetch['dept'];
			//$_SESSION['faculty'] = $fetch['faculty'];
		//	$_SESSION['session'] = $fetch['session'];
		//	$_SESSION['ID'] = $fetch['ID'];

				//Get Get all session value
    foreach($fetch as $items => $v){
      if(!is_numeric($items))
      $_SESSION[$items] = $v;
  }

		header("Location: index.php");

} else{
$_SESSION['error']=' Invalid Matric No/Password';
}
}else{
$_SESSION['error']=' Must Fill-in All Fields';

}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Clearance System</title>
    
    <!-- CSS Files -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/login-style.css" rel="stylesheet">
    <link href="css/global-design-system.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
</head>

<body>
    <div class="login-container">
        <!-- Left Side - Welcome Message -->
        <div class="login-left">
            <img src="images/logo.png" alt="University Logo" class="login-logo">
            <h2>Welcome Back!</h2>
            <p>Arthur Javis University Student Clearance System</p>
            <p>Access your clearance status and manage your academic requirements</p>
            
            <!-- Decorative elements -->
            <div class="decoration-circle"></div>
            <div class="decoration-circle"></div>
        </div>
        
        <!-- Right Side - Login Form -->
        <div class="login-right">
            <div class="login-form fade-in">
                <div class="login-header">
                    <h1>Student Login</h1>
                    <p>Enter your credentials to access your account</p>
                </div>
                
                <form role="form" method="POST" action="" class="needs-validation" novalidate>
                    <?php if(!empty($_SESSION['error'])) { ?>
                        <div class="alert alert-error">
                            <i class="fa fa-exclamation-circle"></i> <?php echo $_SESSION['error']; unset($_SESSION["error"]); ?>
                        </div>
                    <?php } ?>
                    
                    <?php if(!empty($_SESSION['success'])) { ?>
                        <div class="alert alert-success">
                            <i class="fa fa-check-circle"></i> <?php echo $_SESSION['success']; unset($_SESSION["success"]); ?>
                        </div>
                    <?php } ?>
                    
                    <div class="form-group">
                        <i class="fa fa-user form-icon"></i>
                        <input type="text" name="txtmatric_no" class="form-control" placeholder="Matric Number" required>
                        <div class="invalid-feedback">
                            Please enter your matric number
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <i class="fa fa-lock form-icon"></i>
                        <input type="password" name="txtpassword" class="form-control" placeholder="Password" required>
                        <div class="invalid-feedback">
                            Please enter your password
                        </div>
                    </div>
                    
                    <button type="submit" name="btnlogin" class="btn btn-primary">
                        <i class="fa fa-sign-in"></i> Sign In
                    </button>
                    
                    <div class="divider">
                        <span>OR</span>
                    </div>
                    
                    <a href="#" class="forgot-password">
                        <i class="fa fa-key"></i> Forgot Password?
                    </a>
                </form>
                
                <div class="login-footer">
                    <p>© <?php echo date("Y") ?> Arthur Javis University. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
    <script>
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

        // Add floating label effect
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                if (this.value === '') {
                    this.parentElement.classList.remove('focused');
                }
            });
        });

        // Show/hide password functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Add password visibility toggle
            const passwordInput = document.querySelector('input[type="password"]');
            if (passwordInput) {
                const passwordField = passwordInput.parentElement;
                const toggleIcon = document.createElement('i');
                toggleIcon.className = 'fa fa-eye form-icon password-toggle';
                toggleIcon.style.right = '1rem';
                toggleIcon.style.left = 'auto';
                toggleIcon.style.cursor = 'pointer';

                passwordField.style.position = 'relative';
                passwordField.appendChild(toggleIcon);

                toggleIcon.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.className = type === 'password' ? 'fa fa-eye form-icon password-toggle' : 'fa fa-eye-slash form-icon password-toggle';
                });
            }

            // Add input field animations
            document.querySelectorAll('.form-control').forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });

            // Add ripple effect to button
            const loginBtn = document.querySelector('.btn-primary');
            if (loginBtn) {
                loginBtn.addEventListener('click', function(e) {
                    // Create ripple element
                    const ripple = document.createElement('span');
                    ripple.classList.add('ripple');

                    // Position ripple
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';

                    // Add ripple to button
                    this.appendChild(ripple);

                    // Remove ripple after animation
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            }
        });
    </script>

    <style>
        /* Additional styles for enhanced UI */
        .form-group {
            position: relative;
            transition: transform 0.3s ease;
        }

        .password-toggle {
            position: absolute !important;
            right: 1rem;
            top: 50% !important;
            transform: translateY(-50%) !important;
            cursor: pointer;
            color: var(--gray-400);
        }

        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.7);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        .btn-primary {
            overflow: hidden;
            position: relative;
        }
    </style>
</body>
</html>