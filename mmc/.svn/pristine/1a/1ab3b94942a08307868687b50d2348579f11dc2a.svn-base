<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mchasillab extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmhasillab','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Hasil Lab';

		$data['tindakan_lab']=$this->mmhasillab->get_all_tindakan_lab()->result();
		$data['hasil_lab']=$this->mmhasillab->get_all_hasil_lab()->result();
		$this->load->view('master/mvhasillab',$data);
		//print_r($data);
	}

	public function insert_jenis_hasil_lab(){

		$data['id_tindakan']=$this->input->post('id_tindakan');
		$data['jenis_hasil']=$this->input->post('jenis_hasil');
		$data['kadar_normal']=$this->input->post('kadar_normal');
		$data['satuan']=$this->input->post('satuan');

		$this->mmhasillab->insert_jenis_hasil_lab($data);
			
		redirect('master/mchasillab');
		// print_r($data);
	}

	public function delete_jenis_hasil_lab(){
		$id_jenis_hasil_lab=$this->input->post('id_jenis_hasil_lab');
		$this->mmhasillab->delete_jenis_hasil_lab($id_jenis_hasil_lab);
		//redirect('master/Mcsupplier');
		//print_r('success');
		return('success');
	}

}
