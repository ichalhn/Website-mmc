<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
class Ricmonitoring extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('iri/rimkelas');
	}
	public function index(){

		// $uang = 1501;
		// $ratusan = substr($uang, -3);
		//  if($ratusan % 500 != 0){
		//  	$mod = $ratusan % 500;
		// 	$uang = $uang - $mod;
		// 	$uang = $uang + 500;
		//  }
		//  echo number_format($uang, 0);
		//  exit;

		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='';
		$data['pasien']='active';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		
		//$data['list_pasien'] = $this->rimpasien->select_pasien_iri_all();
		$data['list_bed'] = $this->rimkelas->get_jml_ruang_kosong_isi_reservasi();

		$this->load->view('iri/rivlink');
		$this->load->view('iri/monitoring_bed',$data);
	}

}
