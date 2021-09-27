<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mcpoli extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmpoli','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Poliklinik';

		$data['poli']=$this->mmpoli->get_all_poli()->result();
		//$data['poli']=$this->rjmpencarian->get_poliklinik()->result();
		$this->load->view('master/mvpoli',$data);
		//print_r($data);
	}

	public function insert_poli(){

		$data['id_poli']=$this->input->post('id_poli');
		$data['nm_poli']=$this->input->post('nm_poli');
		$data['nm_pokpoli']=$this->input->post('nm_pokpoli');
		$data['pok_tindak']=substr($this->input->post('id_poli'),0,2);

		$this->mmpoli->insert_poli($data);		
		
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Poliklinik dengan ID "'.$data['id_poli'].'" berhasil ditambahkan
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);

		redirect('master/Mcpoli', 'refresh');
		//print_r($data);
	}

	public function get_data_edit_poli(){
		$id_poli=$this->input->post('id_poli');
		$datajson=$this->mmpoli->get_data_poli($id_poli)->result();
	    	echo json_encode($datajson);
	}

	public function edit_poli(){
		$id_poli=$this->input->post('edit_id_poli_hidden');
		$data['nm_poli']=$this->input->post('edit_nm_poli');
		$data['nm_pokpoli']=$this->input->post('edit_nm_pokpoli');
		
		$this->mmpoli->edit_poli($id_poli,$data);

		redirect('master/Mcpoli');
		//print_r($data);
	}

	public function delete_poli($id_poli){		
		if($id_poli!=''){
			$this->mmpoli->delete_poli($id_poli);

			$success = 	'<div class="content-header">
						<div class="box box-default">
							<div class="alert alert-success alert-dismissable">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
								<h4>								
								Poliklinik dengan ID "'.$id_poli.'" berhasil dihapus
								</h4>
							</div>
						</div>
					</div>';
			$this->session->set_flashdata('success_msg', $success);
		}
		redirect('master/Mcpoli','refresh');
		//print_r($data);
	}

}
