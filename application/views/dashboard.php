<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
  <html>
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
      <title>Result Analysis</title>
      <!--bootstrap min  -->
      <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.css');?> ">
      <!--Data Tables css -->
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"/>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.bootstrap4.min.css"/>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css"/>
      <!--Data Tables css ends -->
      
      <!--jquery & js files -->
      <script src="<?php echo base_url('assets/js/jquery.js');?>"></script>
      <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.js');?>"></script>
      <script src="<?php echo base_url('assets/js/result_analysis.js');?>"></script>
      <script src="<?php echo base_url('assets/js/notify.js');?>"></script>
      <script src="<?php echo base_url('assets/js/bootbox.js'); ?>"></script>

      <!--Data Tables js-->
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.bootstrap4.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script> 
      <!--Data Tables js ends-->
    </head>
    <body>
      <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-uppercase">
          <a class="navbar-brand px-5" href="<?php echo site_url('dashboard'); ?>">Result Analysis</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto px-5 ">
              <li class="nav-item "> <a class="nav-link active" href="<?php echo site_url('dashboard'); ?>">Add Result </a></li>
              <li class="nav-item "><a class="nav-link" href="<?php echo site_url('list'); ?>">Show List</a></li>
              <li class="nav-item"><a class="nav-link" href="<?php echo site_url('analysis'); ?>">Result Analysis</a></li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $this->session->userdata('name'); ?> </a>
               <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="<?php echo site_url('logout'); ?>">Logout</a>
               </div>
              </li> 
            </ul>
          </div>
        </nav>
      </header>
      
      <div class="container">
        <h3 class="text-center text-capitalize ">Select Semester to Add Student's Result</h3>
        <hr class="w-75" style="border: 1px solid;">
        <div id="display" class="text-center">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="form-group">
                                <label for="semester" class="font-weight-bold float-right">Semester :</label>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                               <select name="semester" id="semester" class="form-control custom-select" data-sub_url="<?php echo site_url('subject'); ?>">
                                	  <option value="select">Select Semester</option>
                                    <?php foreach ($semester as $value) {  ?>
                                      <option value="<?php echo $value->id; ?>"><?php echo $value->semester; ?></option>
                                      <!-- $value->id this id is semester's id from semester table-->
                                     <?php } ?>
                        	    </select> 
                        	 </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form class="d-none" id="add_form" action="<?php echo site_url('marks'); ?>" method="POST">
          <div>
            <input type="hidden" name="hidden_sem_id" id="hidden_sem_id">
          </div>
          <div class="row mt-2">
             <div class="col-lg-8">
                 <div class="row">
                     <div class="col-lg-9">
                         <div class="form-group">
                            <label for="vtu_no" class="float-right" style="color: blue">USN :</label>
                        </div> 
                    </div>
                    <div class="col-lg-3">
                         <div class="form-group">
                            <input type="text" id="vtu_no" name="vtu_no" class="text-uppercase" required>
                        </div> 
                    </div>
                 </div>
            </div>
             
          </div>
          <div class="row" >
            <!--<div class="col-lg-2">
            </div>-->
            <div class="col-lg-8">
              <div id="subjects"> 
              </div>             
            </div>
            <div class="col-lg-2">
            </div>
          </div>
          <button type="submit" id="submit" name="submit" class="btn btn-info d-block mx-auto mb-5">Add Marks</button>
        </form>
      </div><!--End of container-->
    </body>
  </html>