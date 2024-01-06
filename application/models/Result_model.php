<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Result_model extends CI_Model
{
	public function get_semester()
	{
		$query = $this->db->get('blde_semester');
		return $query->result();
	}

	public function subject_list($sem)
	{
		$this->db->where('sem_id',$sem);
		$query = $this->db->get('blde_subjects');
		if ($query)
		{
			return $query;
		}
		else
		{
			return false;
		}
	}

	public function insert_marks($data)
	{
		$query = $this->db->insert("blde_marks",$data);
		if($query)
		{
			return true;
		}
		else
		{
			return false;
		}
	}	

	

} ?>