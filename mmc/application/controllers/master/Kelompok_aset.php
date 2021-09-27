<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Kelompok_aset extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('Masset','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Data Kelompok Aset';

		$data['table']=$this->Masset->get_all_kelaset()->result();
		$this->load->view('master/mvkelaset',$data);
		//print_r($data);
	}

}