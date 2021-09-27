<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mcobatjenis extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmobatjenis','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Jenis Obat';

		$data['jenis']=$this->mmobatjenis->get_all_jenis()->result();
		$this->load->view('master/mvobatjenis',$data);
		//print_r($data);
	}

	public function insert_jenis(){

		$data['nm_jenis']=$this->input->post('nm_jenis');
		$this->mmobatjenis->insert_jenis($data);
		
		redirect('master/mcobatjenis');
		//print_r($data);
	}

	public function get_data_edit_jenis(){
		$id_jenis=$this->input->post('id_jenis');
		$datajson=$this->mmobatjenis->get_data_jenis($id_jenis)->result();
	    echo json_encode($datajson);
	}

	public function edit_jenis(){
		$id_jenis=$this->input->post('edit_id_jenis_hidden');
		$data['nm_jenis']=$this->input->post('edit_nm_jenis');

		$this->mmobatjenis->edit_jenis($id_jenis, $data);
		
		redirect('master/mcobatjenis');
		//print_r($data);
	}

	public function delete_jenis(){
		$id_jenis=$this->input->post('id_jenis');
		$this->mmobatjenis->delete_jenis($id_jenis);
		
		//redirect('master/mcobatjenis');
		print_r($this->mmobatjenis->delete_jenis($id_jenis));
	}

}