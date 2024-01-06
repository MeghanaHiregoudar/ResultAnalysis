<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Result_controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
    if (empty($this->session->userdata('username'))) 
    {
      redirect('login_page','refresh');
    }
    else
    {
  		$dash['semester'] = $this->Result_model->get_semester();
  		$this->load->view('dashboard',$dash);
    }
	}

	public function fetch_subject()
	{
    if (empty($this->session->userdata('username'))) 
    {
      redirect('login_page','refresh');
    }
    else
    {
  		$sem = $this->input->post('id_sem');

  		$query = $this->Result_model->subject_list($sem);

  		$sub_list = $query->result(); 

  		foreach ($sub_list as $value) { ?>
        
       <div class="row">
          <div class="col-lg-9">
            <div class="form-group">
              <label for="subject" class="float-right"  style="color: blue"><?php echo $value->subjects."(".$value->sub_code.")"; ?> : </label>
              <span id="error_subject1" style="color:red"></span>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="form-group">
              <input type="text"   name="sub_marks[]" class=" alphanumeric" maxlength="3" required>
              <span id="error_subject1" style="color:red"></span>
            </div>
          </div>
        </div><!--Row ends -->
        <input type="hidden" name="sub_id[]" value="<?php echo $value->id; ?>">
       
      <?php  
      } 
    } 
  }  

  public function add_marks()
  {
    if (empty($this->session->userdata('username'))) 
    {
      redirect('login_page','refresh');
    }
    else
    {
  	
    	$marks = $this->input->post('sub_marks');
    	foreach ($marks as $key => $marks_list) 
    	{ 
        
        $vtu_no = $this->input->post("vtu_no");
        $sem_id = $this->input->post("hidden_sem_id");  
        $sub_id = $this->input->post("sub_id")[$key];

        $data = array(
        'vtu_no' => strtoupper($vtu_no),
        'sem_id' => $sem_id,
        'sub_id' => $sub_id,
        'marks' => strtoupper($marks_list),
        'insertion_date' => date("Y-m-d H:i:s")
        );

        $query = $this->Result_model->insert_marks($data);
    	}
      if($query)
        {
          $response = array(
            'status' => 'success',
            'msg' => 'Result addedd successfully',
            'type' => 'success'
          );
        }
        else
        {
          $response = array(
            'status' => 'error',
            'msg' => 'Something went wrong, Try again',
            'type' => 'danger'
          );
        }
        echo json_encode($response);
    }
  }


} ?>
