<!-- Sidebar user panel (optional) -->
<div class="user-panel mt-3 pb-3 mb-3">
  <div class="info">
    <a href="#" class="d-block text-truncate font-weight-bold" style="color: #fff; font-size: 1.1rem;" title="<?php echo isset($rowaccess['fullname']) ? htmlspecialchars($rowaccess['fullname']) : 'User'; ?>"><?php echo isset($rowaccess['fullname']) ? htmlspecialchars($rowaccess['fullname']) : 'User'; ?></a>
    <small class="text-muted d-block" style="color: #adb5bd !important;"><i class="fas fa-id-card mr-1"></i><?php echo isset($rowaccess['matric_no']) ? htmlspecialchars($rowaccess['matric_no']) : 'Matric No'; ?></small>
    <small class="text-success d-block" style="color: #28a745 !important;"><i class="fas fa-circle mr-1" style="font-size: 0.6em;"></i>Online</small>
  </div>
</div>

<!-- Sidebar Menu -->
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->

    <li class="nav-item">
      <a href="index.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
      </a>
    </li>

    <li class="nav-header text-uppercase text-xs font-weight-bold" style="color: #6c757d;">Account</li>

    <li class="nav-item">
      <a href="changepassword.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'changepassword.php') ? 'active' : ''; ?>">
        <i class="nav-icon fas fa-key text-info"></i>
        <p>Change Password</p>
      </a>
    </li>

    <li class="nav-header text-uppercase text-xs font-weight-bold" style="color: #6c757d;">Fee Management</li>

    <li class="nav-item">
      <a href="pay-fee.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'pay-fee.php') ? 'active' : ''; ?>">
        <i class="nav-icon fas fa-credit-card text-success"></i>
        <p>Pay Fee</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="fee-history.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'fee-history.php') ? 'active' : ''; ?>">
        <i class="nav-icon fas fa-history text-warning"></i>
        <p>Payment History</p>
      </a>
    </li>

    <li class="nav-header text-uppercase text-xs font-weight-bold" style="color: #6c757d;">Clearance</li>

    <li class="nav-item">
      <a href="letter.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'letter.php') ? 'active' : ''; ?>">
        <i class="nav-icon fas fa-file-alt text-primary"></i>
        <p>Clearance Letter</p>
      </a>
    </li>

    <li class="nav-header text-uppercase text-xs font-weight-bold" style="color: #6c757d;">System</li>

    <li class="nav-item">
      <a href="Admin/index.php" class="nav-link">
        <i class='nav-icon fas fa-exchange-alt text-danger'></i>
        <p>Switch To Admin</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="logout.php" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
        <p>Logout</p>
      </a>
    </li>
  </ul>
</nav>
<!-- /.sidebar-menu -->