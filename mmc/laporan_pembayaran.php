<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class laporan_pembayaran extends CI_Controller {
	 public function __construct(){
		parent::__construct();
		 
		$this->load->library(array('form_validation','session'));
		$this->load->database();
		$this->load->helper('form','url');
		
		$session = $this->session->userdata('isLogin');
		$this->data['dataUser'] = $this->session->userdata('data_user');
		if ($session == FALSE) {
			redirect('/auth/');
		} 
		else{
			$this->load->model('auth_model'); // load model_users
			$this->load->model('realisasi_pembayaran_model');
			
			$this->data['link_active']	= 'Laporan_pembayaran';
		}
	 }
	 
	public function index(){
		$this->data['title'] = "Realisasi Pembayaran";
		
		$this->data['dataBayar'] = $this->realisasi_pembayaran_model->getFromDate_all();
		
		$this->load->view('component/header', $this->data);
        $this->load->view('component/sidebar', $this->data);
        $this->load->view('realisasi_pembayaran/views_bayar', $this->data);
        $this->load->view('component/footer');
	}
	 
	// public function detail($id_vendor){
	// 	$this->data['title'] = "Vendor";
		
	// 	$dataVendorDetail = $this->vendor_model->getVendorDetail($id_vendor);
	// 	$this->data['dataVendorAllDetail'] = $this->vendor_model->getVendorAllDetail($id_vendor);
		
	// 	$this->data['NamaVen'] = $dataVendorDetail->NMPEMASOK;
	// 	$this->data['IdReg'] = $dataVendorDetail->ID_REGISTRASI_DOKUMEN;
		
	// 	$this->load->view('component/header', $this->data);
 //        $this->load->view('component/sidebar', $this->data);
 //        $this->load->view('vendor/detail', $this->data);
 //        $this->load->view('component/footer');
	// }
}
