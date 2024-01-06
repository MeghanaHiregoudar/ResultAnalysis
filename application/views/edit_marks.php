<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
  <html>
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
      <title>Result Analysis</title>
      <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.css'); ?> ">
      <script src= "<?php echo base_url('assets/js/jquery.js'); ?>"></script>
      <script src= "<?php echo base_url('assets/bootstrap/js/bootstrap.js'); ?> "></script>
      <script src= "<?php echo base_url('assets/js/result_analysis.js'); ?> "></script>
      <script src= "<?php echo base_url('assets/js/notify.js'); ?> "></script>
    </head>
    <body>
      <h1 class="text-center mt-3">Edit Student Record</h1>
      <div class="container">
        <form action="<?php echo site_url('update'); ?>" method="post" id="update_marks" method="post">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="vtu_no" style="color: blue">VTU No :</label>
                <input type="text" id="vtu_no" name="vtu_no" class="text-uppercase" value="<?php echo $vtu_no; ?>">
              </div>
            </div>
          </div>
          <input type="hidden" name="sem_id" value="<?php echo $sem_id; ?>">
          <?php foreach ($list_of_marks as $value) { ?>
              <div class="row mt-4">
                <div class="col-lg-6 mx-auto">
                  <div class="form-group">
                    <label for="subject" style="color: blue"><?php echo $value['subjects']."(".$value['sub_code'].")"; ?> : </label>
                    <input type="text"  id="marks" name="marks[]" class="form-control alphanumeric" value="<?php echo $value['marks']; ?>"><br>
                     <input type="hidden" name="sub_id[]" value="<?php echo $value['sub_id']; ?>">
                     <input type="hidden" name="id[]" value="<?php echo $value['id']; ?>"> 
                    <span id="error_subject1" style="color:red"></span>
                  </div>
                </div>
              </div>

          <?php } ?>
         
          <div>
            <!--<a class="btn btn-primary" href="<?php //echo site_url('list'); ?>">Back</a>-->
            <input type="submit" name="update" id="update" class="btn btn-primary mx-auto d-block" value="update">
         </div>
        </form>
      </div>
    </body>
  </html>

             
