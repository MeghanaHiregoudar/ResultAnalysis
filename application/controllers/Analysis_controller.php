<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analysis_controller extends CI_Controller
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
			$result['semester'] = $this->Result_model->get_semester();
			$this->load->view('analysis',$result);
		}
		
	}

	public function result_calc()
	{
		if (empty($this->session->userdata('username'))) 
		{
			redirect('login_page','refresh');
		}
		else
		{

			$sem_id = $this->input->post('sem_id');

			$analysis_data = $this->Analysis_model->get_result_analysis($sem_id);
			$data = array();
			if ($analysis_data) 
			{
				foreach ($analysis_data as $value) 
				{
					$array_marks = explode(',', $value['marks']);
					$array_fcd = array();
					$array_fc = array();
					$array_sc = array();
					$array_fail = array();
					$array_pass = array();
					$array_absent = array();
					$i = 0; $j = 0; $k = 0; $l = 0; $m = 0; $n = 0;

					foreach ($array_marks as $marks) 
					{
						if($marks=="A")
						{
							$array_absent[$n]=$marks;
							$n++;
						}
						else if($marks>=70)
						{
							$array_fcd[$i]=$marks;
							$i++; 
						}
						else if($marks>=60 && $marks<70)
						{
							$array_fc[$j]=$marks;
							$j++;
						}
							else if($marks>=50 && $marks<60)
						{
							$array_sc[$k]=$marks;
							$k++;
						}
						else if($marks=="F")
						{
							//$var = $marks;
							$array_fail[$l]=$marks;
							$l++;
						}
						else 
						{
							$array_pass[$m]=$marks;
							$m++;
						}
					} //End of inner foreach*/

					//absend count
					$absent_count = count($array_absent);
					$appear_student = $value['appeared']-$absent_count;
					//absent end
					$fcd_count = count($array_fcd); //fcd count
					$fc_count = count($array_fc); //fc count
					$sc_count = count($array_sc); //sc count

					// just pass count
					$fail_count = count($array_fail);
					$just_pass = ($appear_student)-($fcd_count+$fc_count+$sc_count+$fail_count);
					// just pass count end

					$fail_count = count($array_fail); //fail count

					//passing percentage
						$passing_result =(100 * ($fcd_count + $fc_count + $sc_count + $just_pass)) / $appear_student ;
						if (gettype($passing_result)=="integer")
						{
							$passing_percentage = $passing_result ." "."%";
						}
						else
						{
							$passing_percentage = number_format((float)$passing_result, 2, '.', '')." "."%";
						}
					//passing percentage end

					$data[] = array(
						'subject' => $value['sub_code'],
						'appeared' => $appear_student,
						'fcd' => $fcd_count,
						'fc' => $fc_count,
						'sc' => $sc_count ,
						'just_pass' =>  $just_pass,
						'fail' => $fail_count,
						'passing_percentage' => $passing_percentage
					);
				}
			}//end of if condition
			echo json_encode($data);
		}


	} // End of result_calc function




}?>
