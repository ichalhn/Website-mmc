<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
class Frmcpemasok extends Secure_area
{
	function index(){
    $data['title'] = 'Tambah Pemasok';
    $data['Pemasok']=$this->Frmmpemasok->get_pemasok()->result();
	  $data['company_name']=$this->Frmmpemasok->get_company()->result();
	  $data['account_number']=$this->Frmmpemasok->get_account_numb()->result();
    $this->load->view('logistik_farmasi/frmvpemasok',$data);
  }

  public function insert_supplier(){
    $data['person_id']=$this->input->post('person_id');
    $data['company_name']=$this->input->post('company_name');
    $data['account_number']=$this->input->post('account_number');
    $data['adress']=$this->input->post('adress');
    $data['phone']=$this->input->post('phone');
    $data['zip_code']=$this->input->post('zip_code');
    $this->Frmmpemasok->insert_supplier($data);
    redirect('logistik_farmasi/Frmcpemasok');
  }
}
?>