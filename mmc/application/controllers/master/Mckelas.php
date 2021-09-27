<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mckelas extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmkelas','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Kelas';

		$data['kelas']=$this->mmkelas->get_all_kelas()->result();
		// $data['poli']=$this->rjmpencarian->get_poliklinik()->result();
		// $data['biaya']=$this->mmkelas->get_all_biaya()->result();
		$this->load->view('master/mvkelas',$data);
	}
	public function insert_kelas(){

		$data['kelas']=$this->input->post('kelas');
		$data['urutan']=$this->input->post('urutan');
		$data['persen_jasa']=$this->input->post('persen_jasa');

		$this->mmkelas->insert_kelas($data);
		
		redirect('master/Mckelas');
	}

	public function get_data_edit_kelas(){
		$kelas=$this->input->post('kelas');
		$datajson=$this->mmkelas->get_data_kelas($kelas)->result();
	    echo json_encode($datajson);
	}

	public function edit_kelas(){
		$kelas=$this->input->post('edit_kelas');
		$data['urutan']=$this->input->post('edit_urutan');
		$data['persen_jasa']=$this->input->post('edit_persen_jasa');
		
		$this->mmkelas->edit_kelas($kelas, $data);

		// $data1['id_dokter']=$id_dokter;							
		
		// if($this->input->post('edit_poli')!=''){
		// 	$data1['id_poli']=$this->input->post('edit_poli');
		// 	$data1['id_biaya_periksa']=$this->input->post('edit_biaya');
		// 	$this->mmdokter->delete_dokter_poli($this->input->post('old_poli'),$data1['id_dokter']);
		// 	$this->mmdokter->insert_dokter_poli($data1);
		// }else
		// 	$this->mmdokter->delete_dokter_poli($this->input->post('old_poli'),$data1['id_dokter']);

		
		
		redirect('master/Mckelas');
		//print_r($data);
	}

	public function delete_kelas($kelas){
		
		$datajson=$this->mmkelas->delete_kelas($kelas);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Data Kelas "'.$kelas.'" berhasil dihapus
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
	    redirect('master/Mckelas');
	}

}
