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
            $(".sidebar-menu-news").addClass("active");
        });
    </script>

    <!-- custom css for news page -->
    <link rel="stylesheet" href="newsCustom.css">


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
        <section class="row content" ng-app="newsApp" ng-controller="newsControl">
            <div class="col-lg-4">

                <!-- input group with add and delete buttons -->
                <div id="add-delete-group" class="row">
                    <!-- begin: add button and number input -->
                    <div class="col-lg-6">
                        <div class="input-group">
                            <input type="number" min="1" class="form-control" ng-model="numToAdd"
                                   title="Number of News Items to add">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button"
                                        ng-click="addNews(numToAdd)">Add News</button>
                            </span>
                        </div><!-- /input-group -->
                        <div>
                            <small>number of items to add</small>
                        </div>
                    </div><!-- /.col-lg-6 -->

                    <div class="col-lg-6">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button class="btn btn-danger" type="button"
                                        ng-click="deleteNewsItems()">Delete News</button>
                            </span>
                        </div><!-- /input-group -->
                        <div>
                            <small>check items to delete</small>
                        </div>
                    </div><!-- /.col-lg-6 -->
                </div><!-- /#add-delete-group -->

                <!-- begin: special content to show when there is no news -->
                <div class="page-header" ng-hide="news.length">
                    There are no News to display <br/>
                    Click 'Add News' to add news
                </div>
                <!-- end: special content to show when there is no news -->

                <div id="news-list" class="list-group">
                    <div class="list-group-item hov" ng-class="n.isHighlighted" ng-click="highlightNews(n)"
                         ng-repeat="n in news">
                        <label for="{{n.id}}" class="control control--checkbox">
                            <input id="{{n.id}}" type="checkbox" ng-model="n.isChecked" ng-checked="n.isChecked"/>
                            <span class="control__indicator"></span>
                            <span class="news-content">{{n.news}}</span>
                        </label>

                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="page-header">
                    <h2>Edit news</h2>
                </div>
                <textarea id="edit-area" class="col-lg-12 form-control" rows="10" ng-model="currNews"
                          autofocus></textarea>
                <button id="save" ng-click="updateNewsItem(currNews)" class="btn btn-primary">Save</button>
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; <a href="http://sridarshan.tk">Sri Darshan S</a>, Sankkara Narayanan.</strong> All
        rights
        reserved.
    </footer>


</div>
<!-- ./wrapper -->

</body>
</html>
