<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class List_model extends CI_Model
{
	/*public function get_semester()
	{
		$query = $this->db->get('semester');
		return $query->result();
	}*/

	public function column_heading($sem_id)
	{
		$this->db->where(array('sem_id' => $sem_id));
		$query = $this->db->get('blde_subjects');
		return $query->result();
	}

	public function marks_column($sem_id)
	{
		$query = $this->db->query("SELECT vtu_no ,sem_id, GROUP_CONCAT(marks ORDER BY sub_id) AS marks FROM blde_marks WHERE sem_id = $sem_id GROUP BY vtu_no");
			return $query->result_array();
	}

	public function marks_edit($vtu_no,$sem_id)
	{
			
			$query = $this->db->query("SELECT m.id, m.vtu_no, m.sem_id, m.sub_id, m.marks , s.sub_code, s.subjects FROM blde_marks m, blde_subjects s WHERE m.sub_id = s.id AND m.sem_id = $sem_id AND m.vtu_no = '$vtu_no' ORDER BY m.sub_id");	
			return $query->result_array();
	}

	public function update_marks($data,$hidden_id)
	{
			$this->db->where(array('id'=> $hidden_id));
			$query = $this->db->update('blde_marks',$data);
			if($query)
			{
				return true;
			}
			else
			{
				return false;
			}
	}

	public function delete($delete_vtu)
	{
			$this->db->where(array('vtu_no'=>$delete_vtu));
			$query = $this->db->delete("blde_marks");
			if ($query)
			{
					return true;
			}
			else
			{
					return false;
			}
	}

	public function truncate($sem_id)
	{
			$this->db->where(array('sem_id'=>$sem_id));
			$query = $this->db->delete('blde_marks');
			if ($query)
		 {
					return true;
			}
			else
			{
					return false;
			}
	}

}?>