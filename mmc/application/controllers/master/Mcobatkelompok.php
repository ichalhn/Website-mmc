<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mcobatkelompok extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmobatkelompok','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Kelompok Obat';

		$data['satuan']=$this->mmobatkelompok->get_all_satuan()->result();
		$this->load->view('master/mvobatkelompok',$data);
		//print_r($data);
	}

	public function insert_satuan(){

		$data['nm_satuan']=$this->input->post('nm_satuan');
		$this->mmobatkelompok->insert_satuan($data);
		
		redirect('master/mcobatkelompok');
		//print_r($data);
	}

	public function get_data_edit_satuan(){
		$id_satuan=$this->input->post('id_satuan');
		$datajson=$this->mmobatkelompok->get_data_satuan($id_satuan)->result();
	    echo json_encode($datajson);
	}

	public function edit_satuan(){
		$id_satuan=$this->input->post('edit_id_satuan_hidden');
		$data['nm_satuan']=$this->input->post('edit_nm_satuan');

		$this->mmobatkelompok->edit_satuan($id_satuan, $data);
		
		redirect('master/mcobatkelompok');
		//print_r($data);
	}

	public function delete_satuan(){
		$id_satuan=$this->input->post('id_satuan');
		$this->mmobatkelompok->delete_satuan($id_satuan);
		
		//redirect('master/mcobatkelompok');
		print_r($this->mmobatkelompok->delete_satuan($id_satuan));
	}

}