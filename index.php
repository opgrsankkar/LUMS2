<?php /**
 * Created by PhpStorm.
 * User: darsh
 * Date: 17-05-2017
 * Time: 07:35 AM
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>LUMS | Log in</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
    <script src="../../dist/js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../dist/css/sweetalert.css">

<body class="hold-transition login-page">

<div class="login-box">

    <div class="login-logo">
        <b>LUMS</b> Login
    </div>


    <div class="login-box-body">
        <p class="login-box-msg">Sign in</p>

        <form action="scripts/login.php" method="post">

            <div class="form-group has-feedback">
                <input type="text" name="username" class="form-control" placeholder="Username">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            <div class="row">
                <div class="col-xs-8">
                </div>
                <!-- /.col -->

                <div class="col-xs-4">
                    <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->

            </div>

        </form>

        <a href="#" data-toggle="modal" data-target="#passwordModal">I am unable to Login</a><br>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->


<div id="passwordModal" class="modal modal-warning fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Unable to Login</h4>
            </div>
            <div class="modal-body">
                <p>Please Contact the Administrator to reset your password...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- jQuery 2.2.3 -->
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
<?php
if(isset($_GET['login']))
    if($_GET['login'] == "false"):?>
        <script>
            sweetAlert("Oops...", "Invalid Credentials!", "error");</script>
    <?php else:?>
        <script> sweetAlert("Oops...", "Your Account is locked. Contact Administrator!", "warning");</script>
    <?php endif;?>