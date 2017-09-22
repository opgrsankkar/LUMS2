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
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


    <?php
    include($path . "/scripts/includecss.php");
    ?>

    <script>
        $(document).ready(function () {
            $(".sidebar-menu-report").addClass("active");
            $(".sidebar-menu-report-entrance").addClass("active");
        });
    </script>


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
                Report
                <small>Central Library</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="/dashboard/">Home</a></li>
                lo
                <li class="active"><i class="fa fa-table"></i> Central Library</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-xs-12">

                    <div class="box">
                        <div class="box-header">
                            <div class="row">
                                <h3 class="box-title col-md-2 col-sm-6 col-xs-12 pull-left">Central Library</h3>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="pull-left" style="padding: 0px 0px 0px 30px;">
                                    <label>Export:</label>

                                    <div>
                                        <div class="btn-group" id="export-btns">
                                            <button type="button" class="btn btn-default" id="Excel" disabled>
                                                <i class="fa fa-file-excel-o"></i> Excel
                                            </button>
                                            <button type="button" class="btn btn-default" id="PDF" disabled>
                                                <i class="fa fa-file-pdf-o"></i> PDF
                                            </button>


                                        </div>
                                    </div>
                                </div>

                                <div class="pull-left" style="padding: 0cm 30px 0cm 0cm;">
                                    <label>Date Range:</label>


                                    <div class="input-group">
                                        <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                        <span>
                                          <i class="fa fa-calendar"></i> Filter
                                        </span>
                                            <i class="fa fa-caret-down"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="report" class="table table-hover table-bordered ">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Time In</th>
                                        <th>Time Out</th>
                                    </tr>
                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Time In</th>
                                        <th>Time Out</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
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
        <strong>Copyright &copy; <a href="/humans.txt">LUMS 2.0</a></strong> All rights
        reserved.
    </footer>


</div>
<!-- ./wrapper -->


<script type="text/javascript">
    var datefrom = "";
    var dateto = "";

    $('#report tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" />');
    });

    var table = $('#report').DataTable({

        "lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
        "processing": true,
        "serverSide": true,
        "sAjaxSource": "/scripts/entrance_report.php",
        "sServerMethod": "POST",
        "order": [[3, "desc"]],
        "fnServerParams": function (aoData) {
            aoData.push({"name": "fromdate", "value": datefrom});
            aoData.push({"name": "todate", "value": dateto});
        },

    });


    function exportCheck(){
        var result=false;
        var dataset = table.columns().search();
        var count =0;

        for(i=0;i<5;i++){
            if (dataset[i]=="")
                count++;
        }

        if(!(table.search()=="" && count==5)){
            result=true;
        }
        if(datefrom!="" && dateto !=""){
            result=true;
        }
        $("#export-btns .btn").prop("disabled",!result);

    }

    table.on( 'search.dt', function () {
        exportCheck();
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

    $(function () {
        $('#daterange-btn').daterangepicker(
            {
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function (start, end) {
                $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
        );

        $('#daterange-btn').on('cancel.daterangepicker', function (ev, picker) {
            //do something, like clearing an input
            $('#daterange-btn span').html(" \<i class=\"fa fa-calendar\"\>\</i\> Filter");
            dateto = datefrom = "";
            table.ajax.reload(null, false);
            exportCheck();



        });
        $('#daterange-btn').on('apply.daterangepicker', function (ev, picker) {
            datefrom = picker.startDate.format('YYYY-MM-DD') + " 00:00:00";
            dateto = picker.endDate.format('YYYY-MM-DD') + " 23:59:59";
            table.ajax.reload(null, false);
            exportCheck();


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


    })

</script>

</body>
</html>
