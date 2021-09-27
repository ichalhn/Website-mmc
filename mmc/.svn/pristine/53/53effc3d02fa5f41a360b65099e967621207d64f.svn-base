<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mckontraktor extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmkontraktor','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Kontraktor';

		$data['kontraktor']=$this->mmkontraktor->get_all_kontraktor()->result();
		$this->load->view('master/mvkontraktor',$data);
		//print_r($data);
	}

	public function insert_kontraktor(){

		$data['nmkontraktor']=$this->input->post('nmkontraktor');
		$data['jamsoskes']=$this->input->post('jamsoskes');
		$this->mmkontraktor->insert_kontraktor($data);
		
		redirect('master/Mckontraktor');
		//print_r($data);
	}

	public function get_data_edit_kontraktor(){
		$id_kontraktor=$this->input->post('id_kontraktor');
		$datajson=$this->mmkontraktor->get_data_kontraktor($id_kontraktor)->result();
	    echo json_encode($datajson);
	}

	public function edit_kontraktor(){
		$id_kontraktor=$this->input->post('edit_id_kontraktor_hidden');
		$data['nmkontraktor']=$this->input->post('edit_nmkontraktor');
		$data['jamsoskes']=$this->input->post('edit_jenis');

		$this->mmkontraktor->edit_kontraktor($id_kontraktor, $data);
		
		redirect('master/Mckontraktor');
		//print_r($data);
	}

	public function delete_kontraktor(){
		$id_kontraktor=$this->input->post('id_kontraktor');
		$this->mmkontraktor->delete_kontraktor($id_kontraktor);
		
		//redirect('master/Mckontraktor');
		print_r($this->mmkontraktor->delete_kontraktor($id_kontraktor));
	}

}