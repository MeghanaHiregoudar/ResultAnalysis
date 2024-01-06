<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_controller extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Login_model");
	}
    
    
    
	public function index()
	{
		$this->load->view('login');
	}

	public function login_process()
	{
		$username = $this->input->post("username");
      	$password = $this->input->post("password");
      	$login_data = array(
      		'username' => $username,
      		'password' => $password,
      		'active' => 1
      	);
      	$query = $this->Login_model->login_check($login_data);

      	if($query)
      	{
      		$rows = $query->row();

      		$session_array = array(
      			'login_access' => true,
            'name' => $rows->name,
      			'id' => $rows->id,
      			'username' => $rows->username
      		);

      		$this->session->set_userdata($session_array);

      		$response = array(
      			'status' => 'success',
      			'msg' => 'Login Successfull',
      			'type' => 'success',
      			'redirect_url' => site_url('dashboard')
      		);
      	}
      	else
      	{
      		$response = array(
      			'status' => 'error',
      			'msg' => 'Invalid Credentials!!',
      			'type' => 'danger'
      		);
      	}
      	echo json_encode($response);
	}

  public function logout()
  {
    $session_array = array(
      'login_access',
      'name' ,
      'id' ,
      'username' 
    );
    $this->session->unset_userdata($session_array);
    $this->session->sess_destroy();
    redirect('login_page','refresh');
  }
	

	




} ?>
