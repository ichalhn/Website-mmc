<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mcdiagnosa extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmdiagnosa','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Diagnosa';

		$data['diagnosa']=$this->mmdiagnosa->get_all_diagnosa()->result();
		$this->load->view('master/mvdiagnosa',$data);
		//print_r($data);
	}

	public function insert_diagnosa(){
		$data['id_icd']=$this->input->post('iddiagnosa');
		$data['nm_diagnosa']=$this->input->post('nmdiagnosaeng');
		$data['diagnosa_indonesia']=$this->input->post('nmdiagnosaind');

		$this->mmdiagnosa->insert_diagnosa($data);
		
		redirect('master/Mcdiagnosa');
		//print_r($data);
	}

	public function get_data_edit_diagnosa(){
		$id=$this->input->post('id');
		$datajson=$this->mmdiagnosa->get_data_diagnosa($id)->result();
	    echo json_encode($datajson);
	}

	public function edit_diagnosa(){
		$id=$this->input->post('edit_id');
		$data['id_icd']=$this->input->post('edit_iddiagnosa');
		$data['nm_diagnosa']=$this->input->post('edit_nmdiagnosaeng');
		$data['diagnosa_indonesia']=$this->input->post('edit_nmdiagnosaind');

		$this->mmdiagnosa->edit_diagnosa($id, $data);
		
		redirect('master/Mcdiagnosa');
		//print_r($data);
	}

}