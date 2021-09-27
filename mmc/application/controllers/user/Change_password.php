 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Change_password extends Secure_area {
	public function __construct() {
		parent::__construct();
		
		$this->load->model('admin/M_user','',TRUE);
	}
	
	public function index()
	{
		$data["title"] = "Change Password";
		$this->load->view('admin/change_password', $data);
	}
	
	public function save(){
		$ismatch = $this->M_user->check_pass_match($this->input->post());
		if ($ismatch == 1){
			$sukses = $this->M_user->change_pass($this->input->post());		
			$msg = 	' <div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-check"></i>Perubahan password berhasil disimpan							
					  </div>';
		}else{				
			$msg = 	' <div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-ban"></i>Current password tidak cocok!		
					  </div>';
		}
		$this->session->set_flashdata('alert_msg', $msg);
		redirect('user/Change_password');
	}
}
?>