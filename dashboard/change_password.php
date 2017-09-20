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
            $(".sidebar-menu-change-password").addClass("active");
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
                Lums
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="/dashboard/">Home</a></li>
                <li class="active"><i class="fa fa-key"></i> Change Password</li>
            </ol>
        </section><!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-sm-4">
                    <div class="box box-info">
                        <div class="box-header">
                            <h4>Change Password</h4>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <form id="password-change-form" action="/scripts/change_password_api.php" method="POST">
                                <div class="form-group">
                                    <label for="old-password" class="control-label">
                                        <h5>Enter Old Password *</h5>
                                    </label>
                                    <input id="old-password" type="password" class="form-control"
                                           placeholder="Old Password" name="old_password"
                                           tabindex="1">
                                </div>
                                <div class="form-group">
                                    <label for="new-password" class="control-label">
                                        <h5>Enter New Password *</h5>
                                    </label>
                                    <input id="new-password" type="password" class="form-control"
                                           placeholder="New Password" name="new_password"
                                           tabindex="2">
                                </div>
                                <div class="form-group">
                                    <label for="repeat-new-password" class="control-label">
                                        <h5>Confirm New Password *</h5>
                                    </label>
                                    <input id="repeat-new-password" type="password" class="form-control"
                                           placeholder="Re-enter New Password" name="repeat_new_password"
                                           tabindex="3">
                                </div>
                                <div class="form-group">
                                    <button id="submit-button" class="btn btn-info" tabindex="4">Change Password
                                    </button>
                                </div>
                            </form>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col-sm-4 -->
            </div><!-- /.row -->
        </section><!-- /.content -->
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

<script>
    /**
     * add event listener to check confirm password entry
     */
    $("#repeat-new-password").on("change keyup paste click", function () {
            if ($('#new-password').val() !== $('#repeat-new-password').val()) {
                $('#repeat-new-password').parent().addClass('has-error');
            } else {
                $('#repeat-new-password').parent().removeClass('has-error');
            }
        }
    );
    /**
     * Password change form submit using ajax
     */
    $("#password-change-form").ajaxForm({
        data: {
            "username": "<?php echo $username;?>"
        },
        success: function (result) {
            $("#password-change-form").resetForm();
            if (result.success) {
                swal("Password Changed", null, "success");
            } else {
                if (result.error_msg === "DB_ERROR") {
                    swal("Server Error\nTry Again Later", null, "error");
                } else {
                    console.log(result);
                    swal("Old Password is Incorrect", null, "error");
                }
            }
        }
    });
</script>

</body>
</html>
