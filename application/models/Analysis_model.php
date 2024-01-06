<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analysis_model extends CI_Model
{

	public function get_result_analysis($sem_id)
	{
		$query=$this->db->query("select blde_subjects.sub_code, COUNT(marks) as appeared, GROUP_CONCAT(marks) as marks from blde_marks inner join blde_subjects on blde_marks.sub_id = blde_subjects.id where  blde_marks.sem_id = $sem_id GROUP BY blde_marks.sub_id order by blde_subjects.id");
		return $query->result_array();
	}



}