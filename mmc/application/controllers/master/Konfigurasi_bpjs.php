<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Konfigurasi_bpjs extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('Mbpjs','',TRUE);
	}

	public function index(){
		$data['title'] = 'Konfigurasi BPJS';
		$data['data']=$this->Mbpjs->get_bpjs()->row();
		$this->load->view("master/bpjs", $data);
	}
	public function update_bpjs(){
		$rsid = $this->input->post('rsid');
		$data_bpjs = array(
         'service_url' => $this->input->post('service_url'),
         'consid' => $this->input->post('consid'),
         'secid' => $this->input->post('secid'),
         'rsid' => $this->input->post('rsid')
            );
         $this->Mbpjs->update_bpjs($data_bpjs);
		 $notif = '<div class="content-header">
			 <div class="box box-default">
				 <div class="alert alert-success alert-dismissable">
					 <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
					 <i class="fa fa-check"></i> Data Berhasil Disimpan
					 </div>
			 </div>
		 </div>';	
		 $this->session->set_flashdata('success_msg', $notif);		     
		 redirect('master/konfigurasi_bpjs','refresh');	
	}	
}
