<!DOCTYPE html>
<?php
$path=$_SERVER['DOCUMENT_ROOT'];
session_start();
include("../../scripts/sessionvariables.php");
if ($permission == 1)
    include("../../scripts/adminsession.php");
else if ($permission == 2)
    include("../../scripts/usersession.php");
else {
    header("location:../");
    die();
}
include($path."/scripts/includejs.php");
?>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LUMS | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php
    include ($path."/scripts/includecss.php");
    ?>

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">

        <!-- Logo -->
        <a href="index.php" class="logo">
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
                    <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?php echo $name; ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>

                </div>
            </div>

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">Last Login : <?php echo $lastlogin; ?><br/>Last Login IP : <?php echo $lastip; ?>
                </li>

                <li>
                    <a href="index.php">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="active">
                    <a href="users.php">
                        <i class="fa fa-users"></i> <span>Users</span>
                    </a>
                </li>


                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-table"></i> <span>Reports</span>
                        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="active"><a href="report_entrance.php"><i class="fa fa-circle-o"></i> Central Library</a>
                        </li>
                        <li><a href="report_digilib.php"><i class="fa fa-circle-o"></i> Digital Library</a></li>
                    </ul>
                </li>


                <li>
                    <a href="staff.php">
                        <i class="fa fa-user"></i> <span>Library Staff</span>
                    </a>
                </li>

                <li>
                    <a href="news.php">
                        <i class="fa fa-newspaper-o"></i> <span>News</span>
                    </a>
                </li>


                <li>
                    <a href="../../scripts/logout.php">
                        <i class="fa fa-lock"></i> <span>Logout</span>
                    </a>
                </li>


            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                Report
                <small>Central Library</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li class="active"><i class="fa fa-table"></i> Report</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="modal fade" id="edit-user-modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">User Details</h4>
                        </div>
                        <div class="modal-body">
                            <form id="edit-users-form">
                                <div class="form-group">
                                    <label for="id" class="control-label">
                                        <h5>ID</h5>
                                    </label>
                                    <input id="id" type="text" class="form-control" placeholder="ID"
                                           name="id"
                                           readonly="readonly">
                                </div>
                                <div class="form-group">
                                    <label for="name" class="control-label">
                                        <h5>Edit Name</h5>
                                    </label>
                                    <input id="name" type="text" class="form-control" placeholder="Full Name"
                                           name="name">
                                </div>
                                <div class="form-group">
                                    <label for="Batch" class="control-label">
                                        <h5>Edit Batch</h5>
                                    </label>
                                    <input id="batch" type="text" class="form-control" placeholder="Batch"
                                           name="batch">
                                </div>
                                <div class="form-group">
                                    <label for="designation" class="control-label">
                                        <h5>Edit Designation</h5>
                                    </label>
                                    <input id="designation" type="text" class="form-control" placeholder="Designation"
                                           name="designation">
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button form="edit-users-form" type="submit" value="Submit" class="btn btn-primary">
                                Edit User Details
                            </button>
                        </div>
                    </div>
                </div>
            </div><!-- /#edit-user-modal -->

            <div class="row">
                <div class="col-xs-12">

                    <div class="box">
                        <form id="users-table-form">
                            <div class="box-header">
                                <div class="row">
                                    <h3 class="box-title col-md-2 col-sm-6 col-xs-12 pull-left">Central Library</h3>
                                </div>
                                <br/>

                                <div class="row">


                                    <div class="pull-left" style="padding: 0px 0px 0px 30px;">
                                        <label>Export:</label>

                                        <div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default " id="Excel">
                                                    <i class="fa fa-file-excel-o"></i> Excel
                                                </button>
                                                <button type="button" class="btn btn-default " id="PDF">
                                                    <i class="fa fa-file-pdf-o"></i> PDF
                                                </button>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="pull-right" style="padding: 0cm 30px 0cm 0cm;">
                                        <label>Select All:</label>

                                        <div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default " id="Select-All">
                                                    <i class="fa fa-check"></i> Select All
                                                </button>

                                                <button type="submit" class="btn btn-default " id="Delete-Selected">
                                                    <i class="fa fa-trash"></i> Delete Selected
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pull-right" style="padding: 0px 10px 0px 0px;">
                                        <label>Add Users:</label>

                                        <div>
                                            <div class="btn-group">
                                                <a href="useradd.php" class="btn btn-success ">
                                                    <i class="fa fa-plus"></i> Add Users
                                                </a>

                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="users" class="table table-hover table-bordered ">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Batch</th>
                                                <th>Designation</th>
                                                <th>Photo</th>
                                                <th>Modify</th>

                                            </tr>
                                            </thead>

                                            <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Batch</th>
                                                <th>Designation</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                        </form>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->


        </section>
    </div>

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; <a href="http://sridarshan.tk">Sri Darshan S</a>.</strong> All rights
        reserved.
    </footer>


</div>
<!-- ./wrapper -->

<script type="text/javascript">


    $('#users tfoot th').each(function () {
        var title = $(this).text();
        if (title != "")
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
    });

    var table = $('#users').DataTable({
        "lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
        "processing": true,
        "serverSide": true,
        "sAjaxSource": "/scripts/user_listing.php",
        "sServerMethod": "POST",
        'select': {
            'style': 'multi'
        },
        "order": [[1, "asc"]],
        "columnDefs": [
            {
                'targets': 0,
                'searchable': true,
                'orderable': false,
                'className': 'dt-body-center checkbox-data',
                'render': function (data, type, full, meta) {
                    return '<input type="checkbox" name="checkbox[]" value="' + $('<div/>').text(data).html() + '">';
                }
            },
            {
                'targets': 5,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center',
                'render': function (data, type, full, meta) {
                    return '<a href="' + $('<div/>').text(data).html() + '" class="fa fa-file-image-o"></a>';

                }
            },
            {
                'targets': 6,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center',
                'render': function (data, type, full, meta) {
                    return '<div class="btn-group">' +
                        '<a class="btn btn-info btn-sm" title="Edit"><i class="fa fa-pencil"></i></a>' +
                        '<a class="btn btn-danger btn-sm" title="Delete" onclick="deleteUser(' + '\'' + $('<div/>').text(data).html() + '\'' + ')"><i class="fa fa-trash"></i></a>' +
                        '</div>';

                }
            }
        ]

    });

    $('#Select-All').click(function () {
        if (this.innerHTML.trim() == '<i class="fa fa-check"></i> Select All'.trim()) {
            var that = this;
            var t = table;
            t.page.len(-1).draw();
            t.on('draw.dt', function () {
                    var rows = t.rows({'search': 'applied'}).nodes();
                    $('input[type="checkbox"]', rows).prop('checked', true);
                    that.innerHTML = '<i class="fa fa-check"></i> Unselect All';
                }
            );


        } else {
            var rows = table.rows({'search': 'applied'}).nodes();
            $('input[type="checkbox"]', rows).prop('checked', false);
            this.innerHTML = '<i class="fa fa-check"></i> Select All';
        }
    });


    table.columns().every(function () {
        var that = this;

        $('input', this.footer()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that
                    .search(this.value)
                    .draw();
            }
        });
    });


    $('#Excel').click(function () {
        var ur = table.ajax.url();
        var pa = table.ajax.params();
        pa.action = "Excel";
        pa.iDisplayLength = -1;


        var xhr = new XMLHttpRequest();
        xhr.open('POST', ur, true);
        xhr.responseType = 'blob';

        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function (e) {

            if (this.status == 200) {
                var blob = new Blob([this.response], {type: 'application/vnd.ms-excel'});
                var downloadUrl = URL.createObjectURL(blob);
                var a = document.createElement("a");
                a.href = downloadUrl;
                a.download = "data.xls";
                document.body.appendChild(a);
                a.click();
            } else {
                alert('Unable to download excel.')
            }
        };
        xhr.send(jQuery.param(pa));


    });


    $('#PDF').click(function () {

        var ur = table.ajax.url();
        var pa = table.ajax.params();
        pa.action = "Pdf";
        pa.iDisplayLength = -1;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', ur, true);
        xhr.responseType = 'blob';

        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function (e) {

            if (this.status == 200) {
                var blob = new Blob([this.response], {type: 'application/pdf'});
                var downloadUrl = URL.createObjectURL(blob);
                var a = document.createElement("a");
                a.href = downloadUrl;
                a.download = "data.pdf";
                document.body.appendChild(a);
                a.click();
            } else {
                alert('Unable to download PDF.')
            }
        };
        xhr.send(jQuery.param(pa));


    });

    function showEditModal(id, name, batch, designation) {
        $('#edit-user-modal #id').val(id);
        $('#edit-user-modal #name').val(name);
        $('#edit-user-modal #batch').val(batch);
        $('#edit-user-modal #designation').val(designation);
        $('#edit-user-modal').modal();
    }

    function deleteUser(id) {
        swal({
                title: "Delete?",
                text: "Are you sure you want to delete user?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false,
                html: true
            },
            function () {
                $.post('/scripts/userDelete.php', {id: id}, function (result) {
                    table.ajax.reload();
                    if (result.success) {
                        swal("User Deleted", "", "success");
                    } else {
                        swal("Error", result.message, "error");
                    }
                });
            }
        );
    }

    $(document).ready(function () {
        $('#users tbody').on('click', '.btn-info', function () {
            var data = table.row($(this).parents('tr')).data();
            showEditModal(data[1], data[2], data[3], data[4]);
        });

        $("#edit-users-form").ajaxForm({
            url: '/scripts/editUser.php',
            method: 'POST',
            success: function (result) {
                $('#edit-user-modal').modal('hide');
                $('#edit-users-form').resetForm();
                table.ajax.reload();
                if (result.success) {
                    swal("User Data Updated", "", "success");
                } else {
                    swal("Server Error\nTry Again Later", "", "error");
                }
            }
        });
        $("#users-table-form").ajaxForm({
            beforeSubmit: function (formData, jqForm, options) {
                swal({
                    title: "Delete?",
                    text: "Are you sure you want to delete <strong>" + (formData.length - 1) + "</strong> item(s)?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false,
                    html: true
                },
                function () {
                    $.post('/scripts/userDeleteBatchAPI.php', formData, function (result) {
                        table.ajax.reload();
                        if (result.success) {
                            swal("User Deleted", "", "success");
                        } else {
                            swal("Error", result.message, "error");
                        }
                    });
                });
                return false;
            }});
    })

</script>

</body>
</html>
