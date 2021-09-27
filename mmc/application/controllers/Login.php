<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('admin/M_user','',TRUE);
	}
	
	function index()
	{	   
		if($this->M_user->is_logged_in())
		{
			redirect('beranda');
		}
		else
		{
			$this->form_validation->set_rules('username', 'Username', 'callback_login_check');
    	    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
			if($this->form_validation->run() == FALSE)
			{
				$data['list']=$this->M_user->get_all()->result();
				$this->load->view('login',$data);
			}
			else
			{
				redirect('beranda');
			}
		}
		
	}

	function login_check($username)
	{
		$password = $this->input->post("password");	
		
		if(!$this->M_user->login($username,$password))
		{
			$this->form_validation->set_message('login_check', '<p style="color:red;">Username/Password salah!</p>');
			return false;
		}
		return true;		
	}
}

?>