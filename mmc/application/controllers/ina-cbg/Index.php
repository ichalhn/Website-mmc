<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class Index extends Secure_area {
//class rjcregistrasi extends CI_Controller {
	public function __construct() {
			parent::__construct();
			$this->load->model('irj/rjmpencarian','',TRUE);
			$this->load->model('irj/rjmregistrasi','',TRUE);
			$this->load->model('irj/rjmpelayanan','',TRUE);
			$this->load->model('irj/rjmkwitansi','',TRUE);
			$this->load->model('ird/ModelRegistrasi','',TRUE);
			$this->load->model('admin/M_user','',TRUE);
			$this->load->model('irj/M_update_sepbpjs','',TRUE);			
			
			$this->load->helper('pdf_helper');
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////registrasi biodata pasien
	public function index()
	{
		echo "ina cbg";
	}		
}
?>
