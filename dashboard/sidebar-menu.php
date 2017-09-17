<?php

session_start();
include("../scripts/sessionvariables.php");
if ($permission == 1)
    include("../scripts/adminsession.php");
else if ($permission == 2)
    include("../scripts/usersession.php");
else {
    header("location:../");
    die();
}

echo <<<EOD
<header class="main-header">

        <!-- Logo -->
        <a href="/dashboard/index.php" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b></b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Administrator</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>$name</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>

                </div>
            </div>

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">Last Login :$lastlogin<br/>Last Login IP : $lastip
                </li>

                <li class="sidebar-menu-dashboard">
                    <a href="/dashboard/index.php">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-menu-users">
                    <a href="/dashboard/users">
                        <i class="fa fa-users"></i> <span>Users</span>
                    </a>
                </li>


                <li class="treeview sidebar-menu-report">
                    <a href="#">
                        <i class="fa fa-table"></i> <span>Reports</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="sidebar-menu-report-entrance">
                            <a href="/dashboard/reports/report_entrance.php">
                                <i class="fa fa-circle-o"></i> Central Library
                            </a>
                        </li>
                        <li class="sidebar-menu-report-digilib">
                            <a href="/dashboard/reports/report_digilib.php">
                                <i class="fa fa-circle-o"></i> Digital Library
                            </a>
                        </li>
                    </ul>
                </li>
EOD;

if($permission==1) {
    echo <<<EOD

                <li class="sidebar-menu-staff">
                    <a href="/dashboard/staff/">
                        <i class="fa fa-user"></i> <span>Library Staff</span>
                    </a>
                </li>
EOD;
}

echo <<<EOD

                <li class="sidebar-menu-news">
                    <a href="/dashboard/news/">
                        <i class="fa fa-newspaper-o"></i> <span>News</span>
                    </a>
                </li>
    
                <li class="sidebar-menu-change-password">
                    <a href="/dashboard/change_password.php">
                        <i class="fa fa-key"></i> <span>Change Password</span>
                    </a>
                </li>

                <li>
                    <a href="/scripts/logout.php">
                        <i class="fa fa-lock"></i> <span>Logout</span>
                    </a>
                </li>

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
EOD;
