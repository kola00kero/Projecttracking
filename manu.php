<body class="sidebar-mini fixed">
    <div class="wrapper">
      <!-- Navbar-->
      <header class="main-header hidden-print"><a class="logo" href="index.php">ระบบติดตามความคืบหน้าวิทยานิพนธ์</a>
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a class="sidebar-toggle" href="#" data-toggle="offcanvas"></a>
          <!-- Navbar Right Menu-->
          <div class="navbar-custom-menu">
            <ul class="top-nav">
              <!-- User Menu-->
              <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu">
                  <li><a href="user-profile.php"><i class="fa fa-user fa-lg"></i> ข้อมูลส่วนตัว</a></li>
                  <li><a href="login.php"><i class="fa fa-sign-out fa-lg"></i> ออกจากระบบ</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Side-Nav-->
      <aside class="main-sidebar hidden-print">
        <section class="sidebar">
          <div class="user-panel">
            <div class="pull-left image"><img class="img-circle" src="images/user.png" alt="User Image"></div>
            <div class="pull-left info">
              <p><?php echo $name; ?></p>
              <p class="designation"><?php echo $type; ?></p>
            </div>
          </div>
          <!-- Sidebar Menu-->
          <ul class="sidebar-menu">
            <li <?php if($page == 'Profile'){ ?> class="active" <?php } ?> >
                <a href="user-profile.php"><i class="fa fa-address-card"></i><span>ข้อมูลส่วนตัว</span></a>
            </li>
            <li<?php if($page == 'Board'){ ?> class="active" <?php } ?>>
                <a href="index.php"><i class="fa fa-pencil-square-o"></i><span>บอร์ดติดตามวิทยานิพนธ์</span></a>
            </li>
              
            <?php if ($_SESSION["mem_type"] == '1'){ ?> 
            <li <?php if($page == 'Students'){ ?> class="active" <?php } ?>>
                <a href="students-list.php"><i class="fa fa-th-list"></i><span>รายการข้อมูลนักศึกษา</span></a>
            </li>
            <?php } 
            if ($_SESSION["mem_type"] == '0'){ ?> 
            <li <?php if($page == 'Users'){ ?> class="active" <?php } ?>>
                <a href="users-list.php"><i class="fa fa-th-list"></i><span>รายการข้อมูลสมาชิก</span></a>
            </li>
            <?php } ?>
          </ul>
        </section>
      </aside>