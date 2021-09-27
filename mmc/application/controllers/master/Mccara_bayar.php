<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mccara_bayar extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmcara_bayar','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Cara Bayar';

		$data['cara_bayar']=$this->mmcara_bayar->get_all_carabayar()->result();
		// $data['poli']=$this->rjmpencarian->get_poliklinik()->result();
		// $data['biaya']=$this->mmkelas->get_all_biaya()->result();
		$this->load->view('master/mvcara_bayar',$data);
	}
	public function insert_carabayar(){

		$data['cara_bayar']=$this->input->post('cara_bayar');
		$data['klsrawatjalan']=$this->input->post('klsrawatjalan');
		$data['kode']=$this->input->post('kode');

		$this->mmcara_bayar->insert_carabayar($data);
		
		redirect('master/Mccara_bayar');
	}

	public function get_data_edit_carabayar(){
		$cara_bayar=$this->input->post('cara_bayar');
		$datajson=$this->mmcara_bayar->get_data_carabayar($cara_bayar)->result();
	    echo json_encode($datajson);
	}

	public function edit_carabayar(){
		$cara_bayar=$this->input->post('edit_cara_bayar');
		$data['klsrawatjalan']=$this->input->post('edit_klsrawatjalan');
		$data['kode']=$this->input->post('edit_kode');
		
		$this->mmcara_bayar->edit_carabayar($cara_bayar, $data);

		// $data1['id_dokter']=$id_dokter;							
		
		// if($this->input->post('edit_poli')!=''){
		// 	$data1['id_poli']=$this->input->post('edit_poli');
		// 	$data1['id_biaya_periksa']=$this->input->post('edit_biaya');
		// 	$this->mmdokter->delete_dokter_poli($this->input->post('old_poli'),$data1['id_dokter']);
		// 	$this->mmdokter->insert_dokter_poli($data1);
		// }else
		// 	$this->mmdokter->delete_dokter_poli($this->input->post('old_poli'),$data1['id_dokter']);

		
		
		redirect('master/Mccara_bayar');
		//print_r($data);
	}

	public function delete_carabayar($cara_bayar){
		
		$datajson=$this->mmcara_bayar->delete_carabayar($cara_bayar);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Data Master Cara Bayar "'.$cara_bayar.'" berhasil dihapus
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
	    redirect('master/Mccara_bayar');
	}

}
