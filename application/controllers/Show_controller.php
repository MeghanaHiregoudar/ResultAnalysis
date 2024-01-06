<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Show_controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Excel');
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
			$this->load->view('show_list',$dash);
		}
	}

	public function get_table()
	{
		if (empty($this->session->userdata('username'))) 
	  {
	    redirect('login_page','refresh');
	  }
	  else
	  {
			$sem_id = $this->input->post('sem_id');
			$data = $this->List_model->column_heading($sem_id);
			echo json_encode($data);
		}
	}

	public function marks_list()
	{
		if (empty($this->session->userdata('username'))) 
	  {
	    redirect('login_page','refresh');
	  }
	  else
	  {

			$sem_id = $this->input->post('sem_id');
			$list = $this->List_model->marks_column($sem_id);  
			/*$data = array();
			foreach ($list as  $value) { 
				$m_list = explode(",", $value['marks']); 
				foreach ($m_list as $lists) {
	 			 	$list = $lists; 
	 			}

				$data[] = array(
					'vtu_no' => $value['vtu_no'],
					'sem_id' => $value['sem_id'],
					'marks_list' =>  $value['marks']
				);
			}
			echo json_encode($data);*/
			foreach ($list as  $value) { ?>
			<tr>
				<td><?php echo $value['vtu_no']; ?></td>
				<?php $m_list = explode(",", $value['marks']); 
				foreach ($m_list as $lists) { ?>
					<td><?php echo $lists; ?></td>
				<?php }
				?>
				<!--<td> 
				  <a href="<?php //echo site_url('edit/'.$value['vtu_no'].'/'.$value['sem_id']); ?>" title="Edit"  id="client_edit" class="dropdown-item text-warning" ><i class="fa fa-pencil-square-o mr-1" aria-hidden="true"></i>Edit</a>
      		<a href="javascript:;" id="client_delete" data-delete_vtu="<?php //echo $value['vtu_no']; ?>" class="dropdown-item text-danger del_id"><i class="fa fa-trash mr-1" aria-hidden="true"></i>Delete</a>
				</td>-->
				<td>
					<a href="<?php echo site_url('edit/'.$value['vtu_no'].'/'.$value['sem_id']); ?>"  id="client_edit"  class=" text-warning" ><i class="fa fa-pencil-square-o mr-1" aria-hidden="true"></i></a>
                    <span class="text-info">|</span>  
                    <a href="javascript:;" id="client_delete" data-delete_vtu= "<?php echo $value['vtu_no']; ?>" class=" text-danger"><i class="fa fa-trash mr-1" aria-hidden="true"></i></a>
                                       
				</td>

			</tr>
			
			<?php 
			}

		}
	}
	

public function edit_marks($vtu_no,$sem_id)
{
	if (empty($this->session->userdata('username'))) 
	  {
	    redirect('login_page','refresh');
	  }
	  else
	  {
			$vtu_no = ($vtu_no);
			$sem_id = $sem_id;
			$query['list_of_marks'] = $this->List_model->marks_edit($vtu_no,$sem_id);
			/*echo "<pre>";
			print_r($query['list_of_marks']);*/
			$query['vtu_no'] = $query['list_of_marks'][0]['vtu_no']; 
			$query['sem_id'] = $query['list_of_marks'][0]['sem_id']; 
			$this->load->view('edit_marks',$query);
		}
} 

public function update_marks()
{
	if (empty($this->session->userdata('username'))) 
	{
	  redirect('login_page','refresh');
	}
	else
	{
		$marks = $this->input->post('marks');
  	foreach ($marks as $key => $marks_list) 
  	{ 
  		$hidden_id = $this->input->post("id")[$key];
      $vtu_no = $this->input->post("vtu_no");
      $sem_id = $this->input->post("sem_id");  
      $sub_id = $this->input->post("sub_id")[$key];

      $data = array(
      'vtu_no' => strtoupper($vtu_no),
      'marks' => strtoupper($marks_list)
      );

     	$query = $this->List_model->update_marks($data,$hidden_id);
    }
    if($query)
    {
      $response = array(
        'status' => 'success',
        'msg' => 'Updated successfully',
        'type' => 'success',
        'redirect_url' => site_url('list')
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


public function delete_marks()
{
	if (empty($this->session->userdata('username'))) 
	{
	  redirect('login_page','refresh');
	}
	else
	{
		$delete_vtu = $this->input->post("delete_vtu");

		$query = $this->List_model->delete($delete_vtu);

		if ($query)
		{
			$response = array(
	      'status' => 'success',
	      'msg' => 'Deleted successfully',
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

public function truncate_sem()
{
	if (empty($this->session->userdata('username'))) 
	{
	  redirect('login_page','refresh');
  }
  else
  {
		$sem_id = $this->input->post('sem_id');

		$query = $this->List_model->truncate($sem_id);

		if ($query)
		{
			$response = array(
	      'status' => 'success',
	      'msg' => 'Truncated successfully',
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



}?>