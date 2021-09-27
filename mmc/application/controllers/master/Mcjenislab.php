<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mcjenislab extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmjenislab','',TRUE);
	}

	public function index(){
		$data['title'] = 'MASTER JENIS LABORATORIUM';

		$data['jenis_lab']=$this->mmjenislab->get_all_jenis_lab()->result();
		$this->load->view('master/mvjenislab',$data);
		//print_r($data);
	}

	public function insert_jenis_lab(){

		$data['nama_jenis']=$this->input->post('nama_jenis');
		$data['kode_jenis']=$this->input->post('kode_jenis');

		$this->mmjenislab->insert_jenis_lab($data);
			
		redirect('master/mcjenislab');
		// print_r($data);
	}

	public function delete_jenis_lab(){
		$id_jenis_lab=$this->input->post('id_jenis_lab');
		$this->mmjenislab->delete_jenis_lab($id_jenis_lab);
		//redirect('master/Mcsupplier');
		//print_r('success');
		return('success');
	}

}
