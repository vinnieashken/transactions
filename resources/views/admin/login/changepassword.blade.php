<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>News 9 | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?=base_url("cms-assets/bootstrap/css/bootstrap.min.css"); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=base_url("cms-assets/dist/css/AdminLTE.min.css"); ?>">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?=base_url("cms-assets/plugins/iCheck/square/blue.css"); ?>">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="#em"><b>News 9</b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Change Password</p>
        <!--form action="" method="post"-->
        <?=form_open("login/changepassword");?>
          <div class="form-group has-feedback">
            <input type="email" id="em" class="form-control" required="true" autofocus="true" autocomplete="off" name='email' placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          
          <div class="row">
            <div class="col-xs-6">
              <!--div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div-->
              
              <small class="text text-center text-danger"><?=@$elements["msg"]; ?></small>
            </div><!-- /.col -->
            <div class="col-xs-6">
              <button type="submit" name="changepassword" onclick="confirm(' Are you sure you want to change password? ')" value="i" class="btn btn-primary btn-block btn-flat">Change Password</button>
            </div><!-- /.col -->
          </div>
        </form>

        <!--div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
          <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
        </div--><!-- /.social-auth-links -->

        
        <!--a href="register.html" class="text-center">Register a new membership</a-->

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="<?=base_url("cms-assets/plugins/jQuery/jQuery-2.1.4.min.js"); ?>"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?=base_url("cms-assets/bootstrap/js/bootstrap.min.js"); ?>"></script>
    <!-- iCheck -->
    <script src="<?=base_url("cms-assets/plugins/iCheck/icheck.min.js"); ?>"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
