        <li class="nav-item">
            <a href="index.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
			</li>

      <li class="nav-header text-uppercase text-xs font-weight-bold" style="color: #6c757d;">Management</li>

      <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
               User Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="add-admin.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Users</p>
                </a>
              </li>

			   <li class="nav-item">
                <a href="admin-record.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Users Record</p>
                </a>
              </li>
             </ul>
          </li>
	    
		


		   <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>
               Student Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="add-student.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Register Student</p>
                </a>
              </li>

			   <li class="nav-item">
                <a href="student-record.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Student Record</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="student-clearance.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Student Clearance</p>
                </a>
              </li>

             </ul>
          </li>
	    
          
		
	 <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-money-bill-wave"></i>
              <p>
               Fee Management
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">

            			   <li class="nav-item">
                <a href="add-fee.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Fee</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="fee-record.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>payment History</p>
                </a>
              </li>

			     </ul>
          </li>
		  
      <li class="nav-header text-uppercase text-xs font-weight-bold" style="color: #6c757d;">Account</li>

      <li class="nav-item">
            <a href="changepassword.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'changepassword.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-key text-info"></i>
              <p>Change Password</p>
            </a>
          </li>	
		  
      <li class="nav-header text-uppercase text-xs font-weight-bold" style="color: #6c757d;">System</li>
		  
		   <li class="nav-item">
            <a href="../index.php" class="nav-link">
              <i class='nav-icon fas fa-exchange-alt text-danger'></i>
              <p>Switch To Student</p>
            </a>
          </li>

		   <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
              <p>Logout</p>
            </a>
          </li>
		  