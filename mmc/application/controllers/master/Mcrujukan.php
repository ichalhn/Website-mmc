<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mcrujukan extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmrujukan','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Rujukan';

		$data['rujukan']=$this->mmrujukan->get_all_rujukan()->result();
		$this->load->view('master/mvrujukan',$data);
		//print_r($data);
	}

	public function insert_rujukan(){
		$data['kd_ppk']=$this->input->post('kd_ppk');
		$data['nm_ppk']=$this->input->post('nm_ppk');
		$data['jns_ppk']=$this->input->post('jns_ppk');
		$data['alamat_ppk']=$this->input->post('alamat_ppk');
		$this->mmrujukan->insert_rujukan($data);
		
		redirect('master/Mcrujukan');
		//print_r($data);
	}

	public function get_data_edit_rujukan(){
		$kd_ppk=$this->input->post('kd_ppk');
		$datajson=$this->mmrujukan->get_data_rujukan($kd_ppk)->result();
	    echo json_encode($datajson);
	}

	public function edit_rujukan(){
		$kd_ppk=$this->input->post('edit_kd_ppk_hidden');
		$data['nm_ppk']=$this->input->post('edit_nm_ppk');
		$data['jns_ppk']=$this->input->post('edit_jns_ppk');
		$data['alamat_ppk']=$this->input->post('edit_alamat_ppk');

		$this->mmrujukan->edit_rujukan($kd_ppk, $data);
		
		redirect('master/Mcrujukan');
		//print_r($data);
	}

	public function delete_rujukan(){
		$kd_ppk=$this->input->post('kd_ppk');
		$this->mmrujukan->delete_rujukan($kd_ppk);
		
		//redirect('master/kd_ppk');
		print_r($this->mmrujukan->delete_rujukan($kd_ppk));
	}

}