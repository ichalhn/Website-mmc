<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mcdokter extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmdokter','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Dokter';

		$data['dokter']=$this->mmdokter->get_all_dokter()->result();
		$data['poli']=$this->rjmpencarian->get_poliklinik()->result();
		$data['biaya']=$this->mmdokter->get_all_biaya()->result();
		$this->load->view('master/mvdokter',$data);
		//print_r($data);
	}

	public function insert_dokter(){

		$data['nm_dokter']=$this->input->post('nm_dokter');
		$data['nipeg']=$this->input->post('nipeg');
		$data['ket']=$this->input->post('ket');

		$this->mmdokter->insert_dokter($data);
		
		$dokter=$this->mmdokter->get_dokter($data['nm_dokter'])->result();
		foreach($dokter as $row)
			{
				// echo $row->umurday;
				$data1['id_dokter']=$row->id_dokter;				
			}
		if($this->input->post('poli')!=''){
			$data1['id_poli']=$this->input->post('poli');
			$data1['id_biaya_periksa']=$this->input->post('biaya');
			$this->mmdokter->insert_dokter_poli($data1);
		}
		
		
		redirect('master/Mcdokter');
		//print_r($data);
	}

	public function get_data_edit_dokter(){
		$id_dokter=$this->input->post('id_dokter');
		$datajson=$this->mmdokter->get_data_dokter($id_dokter)->result();
	    echo json_encode($datajson);
	}

	public function edit_dokter(){
		$id_dokter=$this->input->post('edit_id_dokter_hidden');
		$data['nm_dokter']=$this->input->post('edit_nm_dokter');
		$data['nipeg']=$this->input->post('edit_nipeg');
		$data['ket']=$this->input->post('edit_ket');
		
		$this->mmdokter->edit_dokter($id_dokter, $data);

		$data1['id_dokter']=$id_dokter;							
		
		if($this->input->post('edit_poli')!=''){
			$data1['id_poli']=$this->input->post('edit_poli');
			$data1['id_biaya_periksa']=$this->input->post('edit_biaya');
			$this->mmdokter->delete_dokter_poli($this->input->post('old_poli'),$data1['id_dokter']);
			$this->mmdokter->insert_dokter_poli($data1);
		}else
			$this->mmdokter->delete_dokter_poli($this->input->post('old_poli'),$data1['id_dokter']);

		
		
		redirect('master/Mcdokter');
		//print_r($data);
	}

	public function delete_dokter($iddokter=''){
		$data['deleted']='1';
		$datajson=$this->mmdokter->delete_dokter($iddokter,$data);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">??</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Dokter dengan ID "'.$iddokter.'" berhasil dihapus
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
	    redirect('master/mcdokter','refresh');
	}

}
