<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model
{
	public function login_check($login_data)
	{
		$query = $this->db->get_where('blde_users',$login_data);
		if($query->num_rows() > 0)
		{
			return $query;
		}
		else
		{
			return false;
		}
	}

}