<!DOCTYPE html>
<?php
$path = $_SERVER['DOCUMENT_ROOT'];
session_start();
include($path . "/scripts/sessionvariables.php");
if ($permission == 1)
    include($path . "/scripts/adminsession.php");
else if ($permission == 2)
    include($path . "/scripts/usersession.php");
else {
    header("location:../");
    die();
}
include($path . "/scripts/includejs.php");
?>

<html>
<head>
    <link type="text/plain" rel="author" href="/humans.txt"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LUMS | Dashboard</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">



    <style>
        body {
            font-family: Verdana;
            font-size: 11px;
        }

        h2 {
            margin-bottom: 0;
        }

        small {
            display: block;
            margin-top: 40px;
            font-size: 9px;
        }

        small,
        small a {
            color: #666;
        }

        a {
            color: #000;
            text-decoration: underline;
            cursor: pointer;
        }

        #toolbar [data-wysihtml5-action] {
            float: right;
        }

        #toolbar,
        textarea {
            width: 920px;
            padding: 5px;
            -webkit-box-sizing: border-box;
            -ms-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        textarea {
            height: 280px;
            border: 2px solid green;
            font-family: Verdana;
            font-size: 11px;
        }

        textarea:focus {
            color: black;
            border: 2px solid black;
        }

        .wysihtml5-command-active {
            font-weight: bold;
        }

        [data-wysihtml5-dialog] {
            margin: 5px 0 0;
            padding: 5px;
            border: 1px solid #666;
        }

        a[data-wysihtml5-command-value="red"] {
            color: red;
        }

        a[data-wysihtml5-command-value="green"] {
            color: green;
        }

        a[data-wysihtml5-command-value="blue"] {
            color: blue;
        }
    </style>


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
                News
                <small>Announcements on home page</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="/dashboard/">Home</a></li>
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
            <div class="col-lg-8 ewrapper">
                <div class="page-header">
                    <h2>Edit news</h2>
                </div>
                <div class="toolbar" style="display: none;">
                    <a data-wysihtml5-command="bold" title="CTRL+B">bold</a> |
                    <a data-wysihtml5-command="italic" title="CTRL+I">italic</a> |
                    <a data-wysihtml5-command="superscript" title="sup">superscript</a> |
                    <a data-wysihtml5-command="subscript" title="sub">subscript</a> |
                    <a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h1">h1</a> |
                    <a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h2">h2</a> |
                    <a data-wysihtml5-command="formatBlock" data-wysihtml5-command-blank-value="true">plaintext</a> |
                    <a data-wysihtml5-command="insertUnorderedList">insertUnorderedList</a> |
                    <a data-wysihtml5-command="insertOrderedList">insertOrderedList</a> |
                    <a data-wysihtml5-command="foreColor" data-wysihtml5-command-value="red">red</a> |
                    <a data-wysihtml5-command="foreColor" data-wysihtml5-command-value="green">green</a> |
                    <a data-wysihtml5-command="foreColor" data-wysihtml5-command-value="blue">blue</a> |
                    <a data-wysihtml5-command="undo">undo</a> |
                    <a data-wysihtml5-command="redo">redo</a> |
                    <a data-wysihtml5-action="change_view">switch to html view</a>

                </div>
                <textarea id="edit-area" class="col-lg-12 form-control editable" rows="10" ng-model="currNews"
                          autofocus></textarea>
                <button id="save" ng-click="updateNewsItem(currNews)" class="btn btn-primary">Save</button>
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; <a href="/humans.txt">LUMS 2.0</a></strong> All
        rights
        reserved.
    </footer>


</div>
<!-- ./wrapper -->
</body>

<script src="/dist/js/advanced_unwrap.js"></script>
<script src="/dist/js/wysihtml-toolbar.min.js"></script>
<script>
    var editors = [];

    $('.ewrapper').each(function(idx, wrapper) {
        var e = new wysihtml5.Editor($(wrapper).find('.editable').get(0), {
            toolbar:        $(wrapper).find('.toolbar').get(0),
            parserRules:    wysihtml5ParserRules,
            stylesheets:  "wysiwyg-stylesheet.css"
            //showToolbarAfterInit: false
        });
        editors.push(e);
    });

</script>
</html>
