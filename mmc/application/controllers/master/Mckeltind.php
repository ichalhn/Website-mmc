<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mckeltind extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmkeltind','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Kelompok Tindakan';

		$data['keltind']=$this->mmkeltind->get_all_keltind()->result();
		//$data['keltind']=$this->rjmpencarian->get_keltindklinik()->result();
		$this->load->view('master/mvkeltind',$data);
		//print_r($data);
	}

	public function insert_keltind(){

		$data['idkel_tind']=$this->input->post('idkel_tind');
		$data['nama_kel']=$this->input->post('nama_kel');
		$data['desc_kel']=$this->input->post('desc_kel');

		$this->mmkeltind->insert_keltind($data);		
		
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Kelompok Tindakan dengan ID "'.$data['idkel_tind'].'" berhasil ditambahkan
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);

		redirect('master/Mckeltind', 'refresh');
		//print_r($data);
	}

	public function get_data_edit_keltind(){
		$idkel_tind=$this->input->post('idkel_tind');
		$datajson=$this->mmkeltind->get_data_keltind($idkel_tind)->result();
	    	echo json_encode($datajson);
	}

	public function edit_keltind(){
		$idkel_tind=$this->input->post('edit_idkel_tind_hidden');
		$data['nama_kel']=$this->input->post('edit_nama_kel');
		$data['desc_kel']=$this->input->post('edit_desc_kel');
		
		$this->mmkeltind->edit_keltind($idkel_tind,$data);

		redirect('master/Mckeltind');
		//print_r($data);
	}

	public function delete_keltind($idkel_tind){		
		if($idkel_tind!=''){
			$this->mmkeltind->delete_keltind($idkel_tind);

			$success = 	'<div class="content-header">
						<div class="box box-default">
							<div class="alert alert-success alert-dismissable">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
								<h4>								
								Kelompok Tindakan dengan ID "'.$idkel_tind.'" berhasil dihapus
								</h4>
							</div>
						</div>
					</div>';
			$this->session->set_flashdata('success_msg', $success);
		}
		redirect('master/Mckeltind','refresh');
		//print_r($data);
	}

}
