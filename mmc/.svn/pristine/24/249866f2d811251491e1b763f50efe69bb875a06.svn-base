 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once ("Secure_area.php");
class Logout extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('admin/M_user','',TRUE);
	}
	
	public function index()
	{
		$this->M_user->logout();
	}
}

?>