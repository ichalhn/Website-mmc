<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ricdaftar extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('iri/rimdaftar');
	}
	public function index(){
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pendaftaran']='';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		
		if(!$this->input->post('kode_ruang')){
			$data_daftar['kode_ruang']='-';
		}else{
			$kode_ruang=$this->input->post('kode_ruang');
			if($kode_ruang==''){
				$kode_ruang='-';
			}
			$data_daftar['kode_ruang']=$kode_ruang;
		}
		if(!$this->input->post('kelas')){
			$data_daftar['kelas']='-';
		}else{
			$kelas=$this->input->post('kelas');
			if($kelas==''){
				$kelas='-';
			}
			$data_daftar['kelas']=$kelas;
		}
		
		$this->load->view('iri/rivlink');
		// $this->load->view('iri/rivheader');
		// $this->load->view('iri/rivmenu', $data);
		// $this->load->view('iri/rivdaftar', $data_daftar);
		$this->load->view('iri/list_antrian', $data);
		// $this->load->view('iri/rivfooter');
	}
	public function get_irna_antrian($kode_ruang='-', $kelas='-'){
		$result=$this->rimdaftar->select_irna_antrian_all($kode_ruang, $kelas);
		$totalDataQuery=count($result);
		
		if($totalDataQuery==0){
			$data=Array();
		}
		
		for($i=0;$i<$totalDataQuery;$i++){
			$data[$i]['0']=$result[$i]['noreservasi']; // No Reservasi
			$data[$i]['1']=$result[$i]['no_cm']; // No. CM
			$data[$i]['2']=$result[$i]['no_register_asal']; // No. Registrasi Asal
			$tppri=$result[$i]['tppri'];
			if($tppri=='rawatjalan'){
				$pasien_irj=$this->rimdaftar->select_pasien_irj_by_no_register_asal($data[$i]['2']);
				$data[$i]['3']=$pasien_irj[0]['nama']; // Nama
				$link='ricpendaftaran/index/'.$data[$i]['0'];
			}else if($tppri=='rawatdarurat'){
				$pasien_ird=$this->rimdaftar->select_pasien_ird_by_no_register_asal($data[$i]['2']);
				$data[$i]['3']=$pasien_ird[0]['nama']; // Nama
				$link='ricpendaftaran/index/'.$data[$i]['0'];
			}else{
				$data[$i]['3']=''; // Nama
				$link='ricmutasi/index';
			}
			// $data[$i]['3']=$result[$i]['nama']; // Ruang pilih
			$data[$i]['4']=$result[$i]['ruangpilih']; // Ruang pilih
			$data[$i]['5']=$result[$i]['kelas']; // Kelas
			$data[$i]['6']=$result[$i]['infeksi']; // Infeksi
			$data[$i]['7']=$result[$i]['hp']; // HP
			$data[$i]['8']=$result[$i]['prioritas']; // Prioritas
			$data[$i]['9']=$result[$i]['tglrencanamasuk'];// Tanggal Rencana Masuk
			$data[$i]['10']='<a href="'.$link.'"><button type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Approve</button></a> <a href="ricdaftar/batal_reservasi/'.$data[$i]['0'].'"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Batal</button></a>';
		}
		
		$json_data=array(
			"data"=>$data // total data array
		);
		echo json_encode($json_data); // send data as json format
	}
	public function data_ruang() {
		// 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		$keyword = $this->uri->segment(4);
		$data = $this->rimdaftar->select_ruang_like($keyword);
		foreach($data as $row){
			$arr['query'] = $keyword;
			$arr['suggestions'][] 	= array(
				'value'				=>$row['idrg'],
				'idrg'				=>$row['idrg'],
				'nmruang'			=>$row['nmruang']
			);
		}
		echo json_encode($arr);
    }
	public function batal_reservasi($noreservasi){
		$this->session->set_flashdata('pesan',
		"<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<i class='icon fa fa-check'></i> Reservasi telah dibatalkan!
		</div>");
		$data['batal']='Y';
		$this->rimdaftar->update_reservasi($noreservasi, $data);
		redirect('iri/ricdaftar');
	}
}
