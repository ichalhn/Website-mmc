<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mcppk extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmppk','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master PPK';
		$data['ppk']=$this->mmppk->get_all_ppk()->result();
		// $data['poli']=$this->rjmpencarian->get_poliklinik()->result();
		// $data['biaya']=$this->mmkelas->get_all_biaya()->result();
		$this->load->view('master/mvppk',$data);
	}
	public function insert_ppk(){

		$data['kd_ppk']=$this->input->post('kd_ppk');
		$data['nm_ppk']=$this->input->post('nm_ppk');
		$data['kabupaten']=$this->input->post('kabupaten');
		$data['alamat_ppk']=$this->input->post('alamat_ppk');
		$this->mmppk->insert_ppk($data);
		redirect('master/Mcppk');
	}

	public function get_data_edit_ppk(){
		$ppk=$this->input->post('kd_ppk');
		$datajson=$this->mmppk->get_data_ppk($ppk)->result();
	    echo json_encode($datajson);
	}

	public function edit_ppk(){
		$ppk=$this->input->post('edit_kd_ppk');
		$data['nm_ppk']=$this->input->post('edit_nm_ppk');
		$data['kabupaten']=$this->input->post('edit_kabupaten');
	    $data['alamat_ppk']=$this->input->post('edit_alamat_ppk');
		$this->mmppk->edit_ppk($ppk, $data);

		
		redirect('master/Mcppk');
		//print_r($data);
	}

	public function delete_ppk($ppk){
		
		$datajson=$this->mmppk->delete_ppk($ppk);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Data PPK dengan Kode "'.$ppk.'" berhasil dihapus
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
	    redirect('master/Mcppk');
	}

}
