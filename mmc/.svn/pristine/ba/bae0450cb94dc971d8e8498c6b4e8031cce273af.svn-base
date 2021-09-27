<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mcobatsatuan extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmobatsatuan','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Satuan Obat';

		$data['satuan']=$this->mmobatsatuan->get_all_satuan()->result();
		$this->load->view('master/mvobatsatuan',$data);
		//print_r($data);
	}

	public function insert_satuan(){

		$data['nm_satuan']=$this->input->post('nm_satuan');
		$this->mmobatsatuan->insert_satuan($data);
		
		redirect('master/mcobatsatuan');
		//print_r($data);
	}

	public function get_data_edit_satuan(){
		$id_satuan=$this->input->post('id_satuan');
		$datajson=$this->mmobatsatuan->get_data_satuan($id_satuan)->result();
	    echo json_encode($datajson);
	}

	public function edit_satuan(){
		$id_satuan=$this->input->post('edit_id_satuan_hidden');
		$data['nm_satuan']=$this->input->post('edit_nm_satuan');

		$this->mmobatsatuan->edit_satuan($id_satuan, $data);
		
		redirect('master/mcobatsatuan');
		//print_r($data);
	}

	public function delete_satuan(){
		$id_satuan=$this->input->post('id_satuan');
		$this->mmobatsatuan->delete_satuan($id_satuan);
		
		//redirect('master/mcobatsatuan');
		print_r($this->mmobatsatuan->delete_satuan($id_satuan));
	}

}