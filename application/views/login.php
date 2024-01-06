<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
      <title>Login</title>
      <!--bootstrap min  -->
      <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.css');?> ">
      <!--jquery & js files -->
      <script src="<?php echo base_url('assets/js/jquery.js');?>"></script>
      <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.js');?>"></script>
      <script src="<?php echo base_url('assets/js/result_analysis.js');?>"></script>
      <script src="<?php echo base_url('assets/js/notify.js');?>"></script>
      <script src="<?php echo base_url('assets/js/bootbox.js'); ?>"></script>
    <style type="text/css">
      #loginPage{
        margin-top: 90px;
      }
    </style> 
  </head>
  <body>
    <div class="container " id="loginPage">
    <div class="row">
      <div class="col-md-6 mx-auto d-block">
        <div class="card ">

          <div class="card-header bg-info">
            <h5 class="card-title font-weight-bold text-center">Log-In</h5>
          </div>
      
          <div class="card-body">
            <form action="<?php echo site_url('login'); ?>" method="post" id="login_form"> 
              <div class="form-group">         
                <input type="text" name="username" class="form-control" id="username"  placeholder="USERNAME">
                <span id="username_error" class="text-danger"></span>
              </div>

              <div class="form-group">         
                <input type="password" name="password" class="form-control" id="password"  placeholder="PASSWORD" minlength="6">  
                <span id="password_error" class="text-danger"></span>
              </div>
              <input type="submit" name="login" id="login" class="btn btn-info btn-block" value="Log In">
              
            </form>
          </div><!-- End of card body-->
        </div><!--End of card -->
      </div>
      <!--End of col-md-6 -->
    </div>
    <!-- End of row-->
  </div>
  <!--End of container -->
  </body>
</html>