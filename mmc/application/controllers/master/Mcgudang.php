<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mcgudang extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmgudang','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Gudang dan TPO';

		$data['gudang']=$this->mmgudang->get_all_gudang()->result();
		$this->load->view('master/mvgudang',$data);
		//print_r($data);
	}

	public function insert_gudang(){

		$data['nama_gudang']=$this->input->post('nama_gudang');
		$this->mmgudang->insert_gudang($data);
		
		redirect('master/Mcgudang');
		//print_r($data);
	}

	public function delete_gudang(){
		$id_gudang=$this->input->post('id_gudang');
		$this->mmgudang->delete_gudang($id_gudang);
		
		//redirect('master/Mcgudang');
		print_r($this->mmgudang->delete_gudang($id_gudang));
	}

}