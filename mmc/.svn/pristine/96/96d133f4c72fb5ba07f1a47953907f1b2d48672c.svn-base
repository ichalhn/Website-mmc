<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mcsupplier extends Secure_area {
	public function __construct(){
		parent::__construct();
		$this->load->model('master/Mmsupplier','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master supplier';
		$data['suppliers']=$this->Mmsupplier->get_all_supplier()->result();
		$this->load->view('master/mvsupplier',$data);
		//print_r($data);
	}

	public function insert_supplier(){
		$data['company_name']=$this->input->post('nmsupplier');
		$data['account_number']=$this->input->post('accountnumber');
		$data['adress']=$this->input->post('adress');
		$data['zip_code']=$this->input->post('zip_code');
		$data['phone']=$this->input->post('phone');
		$this->Mmsupplier->insert_supplier($data);
		
		redirect('master/Mcsupplier');
		print_r($data);
	}

	public function get_data_edit_supplier(){
		$id_supplier=$this->input->post('id_supplier');
		$datajson=$this->Mmsupplier->get_data_supplier($id_supplier)->result();
	    echo json_encode($datajson);
	}

	public function edit_supplier(){
		$id_supplier=$this->input->post('edit_id_supplier_hidden');
		$data['company_name']=$this->input->post('edit_nmsupplier');
		$data['account_number']=$this->input->post('edit_accountnumber');
		$data['adress']=$this->input->post('adress');
		$data['zip_code']=$this->input->post('zip_code');
		$data['phone']=$this->input->post('phone');
		$this->Mmsupplier->edit_supplier($id_supplier, $data);
		redirect('master/Mcsupplier');
		//print_r($data);
	}

	public function delete_supplier(){
		$id_supplier=$this->input->post('id_supplier');
		$this->Mmsupplier->delete_supplier($id_supplier);
		//redirect('master/Mcsupplier');
		print_r($this->Mmsupplier->delete_supplier($id_supplier));
	}
}