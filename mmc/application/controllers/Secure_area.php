<?php 
class Secure_area extends CI_Controller 
{
	/*
	Controllers that are considered secure extend Secure_area, optionally a $module_id can
	be set to also check if a user can access a particular module in the system.
	*/
	function __construct($module_id=null)
	{
		parent::__construct();	
		$this->load->model('admin/M_user','',TRUE);
		if(!$this->M_user->is_logged_in())
		{
			redirect('login');
		}
		
		$url = $this->uri->uri_string();
		
		if(!($this->M_user->has_permission($url,$this->M_user->get_logged_in_user_info()->userid)))
		{
			redirect('no_access');
		}
		
		//load up global data
		$logged_in_user_info=$this->M_user->get_logged_in_user_info();
		//$data['allowed_modules']=$this->Module->get_allowed_modules($logged_in_employee_info->person_id);
		$data['user_info']=$logged_in_user_info;
		$this->load->vars($data);
	}
}
?>