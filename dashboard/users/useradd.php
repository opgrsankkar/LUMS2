<!DOCTYPE html>
<?php
$path = $_SERVER['DOCUMENT_ROOT'];
session_start();
include($path."/scripts/sessionvariables.php");
if ($permission == 1)
    include($path."/scripts/adminsession.php");
else if ($permission == 2)
    include($path."/scripts/usersession.php");
else {
    header("location:../");
    die();
}
include($path . "/scripts/includejs.php");
?>
<script src="/dist/js/xlsxjs.full.min.js"></script>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LUMS | Dashboard</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php
    include($path . "/scripts/includecss.php");
    ?>
    <script>
        $(document).ready(function () {
            $(".sidebar-menu-users").addClass("active");
        });
    </script>

    <!-- custom css for news page -->
    <link rel="stylesheet" href="usersCustom.css">


</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php
    include($path . '/dashboard/sidebar-menu.php');
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                Dashboard
                <small>Version 1.0</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="../index.php">Home</a></li>
                <li><a href="../index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"><i class="fa fa-newspaper-o"></i> News</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="row content" ng-app="usersApp" ng-controller="userAddController">

            <?php if ($permission == 1) {
                ?>

                <div class="col-sm-8">
                    <div class="box box-success">
                        <div class="box-header">
                            <h4>Add Batch of Users</h4>
                        </div><!-- /.box-header-->
                        <div class="box-body">
                            <div class="btn-group">
                                <label class="btn btn-success btn-file">
                                    Select File <input onchange="handleFileSelect(event)" type="file" name="files[]"
                                                       style="display: none;">
                                </label>
                                <button id="load-data-btn" class="btn btn-success" ng-click="loadData()" disabled>
                                    Load File
                                </button>
                                <button id="upload-data-btn" class="btn btn-success" ng-click="uploadData()"
                                        disabled>Upload
                                    File
                                </button>
                            </div>

                            <br>
                            <div class="alert alert-success alert-dismissible" role="alert"
                                 ng-show="uploadComplete">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span>
                                </button>
                                Upload Complete
                            </div>
                            <div id="uploading" class="alert alert-info" role="alert" ng-show="uploading">
                                Uploading.
                            </div>

                            <div class="well" ng-show="!usersTable.numberOfRecords">
                                <h5>Steps to upload Excel files</h5>
                                <ol>
                                    <li>Select the '.xls' file</li>
                                    <li>Load the file</li>
                                    <li>Upload the file</li>
                                </ol>
                                <a href="/ext-res/sample.xlsx">
                                    <u>Sample Excel File</u>
                                </a>

                            </div><!-- /.well -->

                            <div id="output" ng-show="usersTable.numberOfRecords">
                                <table>
                                    <caption class="page-header">There are {{usersTable.numberOfRecords}} records in the
                                        uploaded
                                        sheet
                                    </caption>
                                    <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th ng-repeat="key in usersTable.keys">
                                            {{key}}
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr ng-repeat="user in usersTable.data">
                                        <td>{{$index + 1}}</td>
                                        <td ng-repeat="key in usersTable.keys">{{user[key]}}</td>
                                    </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div><!-- /.box-body-->
                    </div><!-- box -->
                </div><!-- /.col-sm-8 -->
                <?php
            }
            ?>

            <div class="col-sm-4">
                <div class="box box-success">
                    <div class="box-header">
                        <h4>Add Single User</h4>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="well" ng-show="single.uploading">
                            <h4>Uploading Data</h4>
                        </div>
                        <div class="alert alert-success alert-dismissable" role="alert" ng-show="single.uploaded">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span>
                            </button>
                            <h4>User Added</h4>
                        </div>
                        <form id="single-user-add" ng-submit="single.addUser()">
                            <div class="form-group">
                                <label for="id-card-number" class="control-label">
                                    <h5>Enter ID card Number *</h5>
                                </label>
                                <input id="id-card-number" type="text" class="form-control" placeholder="ID card Number"
                                       ng-model="single.id" tabindex="1">
                            </div>
                            <div class="form-group">
                                <label for="full-name" class="control-label">
                                    <h5>Enter Name *</h5>
                                </label>
                                <input id="full-name" type="text" class="form-control" placeholder="Full Name"
                                       ng-model="single.fullName" tabindex="2">
                            </div>
                            <div class="form-group">
                                <label for="batch" class="control-label">
                                    <h5>Enter Batch</h5>
                                </label>
                                <input id="batch" type="text" class="form-control" placeholder="Batch"
                                       ng-model="single.batch" tabindex="3">
                            </div>
                            <div class="form-group">
                                <label for="designation" class="control-label">
                                    <h5>Enter Designation</h5>
                                </label>
                                <input id="designation" type="text" class="form-control" placeholder="Designation"
                                       ng-model="single.designation" tabindex="4">
                            </div>

                            <div class="form-group-lg">
                                <button type="submit" class="btn btn-success" tabindex="6">Add New User</button>
                            </div>
                        </form>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col-sm-4 -->
        </section>
    </div>

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; <a href="http://sridarshan.tk">Sri Darshan S</a>, Sankkara Narayanan.</strong> All
        rights reserved.
    </footer>


</div>
<!-- ./wrapper -->

</body>
</html>
