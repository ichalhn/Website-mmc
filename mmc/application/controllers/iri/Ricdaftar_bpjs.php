<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include(dirname(dirname(__FILE__)).'/Tglindo.php');

require_once(APPPATH.'controllers/Secure_area.php');
class Ricdaftar_bpjs extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('iri/rimdaftar');
		$this->load->model('iri/rimpasien');
	}

	//keperluan tanggal
	public function obj_tanggal(){
		 $tgl_indo = new Tglindo();
		 return $tgl_indo;
	}

	public function index(){
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pendaftaran']='';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		
		//bikin object buat penanggalan
		$data['controller']=$this; 

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

		$data_list_reservasi_all = $this->rimdaftar->get_irna_antrian_all();
		$data['list_reservasi_all'] = $data_list_reservasi_all;
		
		// $this->load->view('iri/rivlink');
		$this->load->view('iri/list_antrian_bpjs', $data);
	}
	
	public function batal_reservasi($noreservasi){
		//ambil irna antrian
		$data_reservasi = $this->rimdaftar->get_antrian_by_no_reservasi($noreservasi);

		//cek semua tindakan yang pernah ada. kalo belum ada tindakan ga boleh batal
		if(substr($data_reservasi[0]['no_register_asal'], 0,2) == "RI"){
			//get pasien RI. ambil no ip sama register asalnya
			$pasien = $this->rimtindakan->get_pasien_by_no_ipd($data_reservasi[0]['no_register_asal']);
			$no_ipd = $pasien[0]['no_ipd'];
			$no_register_asal = $pasien[0]['noregasal'];
		}else{
			$no_ipd = '';
			$no_register_asal = $data_reservasi[0]['no_register_asal'];
		}
		
		$status_bisa_batal = true;

		$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd,$no_register_asal);
		if(($list_lab_pasien)){
			$status_bisa_batal = false;
		}
		$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$no_register_asal);//belum ada no_register
		if(($list_radiologi)){
			$status_bisa_batal = false;
		}
		$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd,$no_register_asal);
		if(($list_resep)){
			$status_bisa_batal = false;
		}
		$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($no_register_asal);
		if(($list_tindakan_ird)){
			$status_bisa_batal = false;
		}
		$poli_irj = $this->rimpasien->get_list_poli_rj_pasien($no_register_asal);
		if(($poli_irj)){
			$status_bisa_batal = false;
		}

		if($status_bisa_batal == true){
			//echo "bisa pulang";
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-success alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-check'></i> Reservasi telah dibatalkan!
			</div>");
			$data['batal']='Y';
			$this->rimdaftar->update_reservasi($noreservasi, $data);
			redirect('iri/ricdaftar_bpjs');
		}else{
			//echo "tidak bisa ulang";
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-error alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-close'></i> Reservasi tidak bisa dibatalkan karena sudah ada tindakan yang terinput!
			</div>");
			redirect('iri/ricdaftar_bpjs');
		}		
	}

	public function batal_mutasi($noreservasi){
		
		//echo "bisa pulang";
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-success alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-check'></i> Reservasi telah dibatalkan!
			</div>");
			$data['batal']='Y';
			$this->rimdaftar->update_reservasi($noreservasi, $data);
			redirect('iri/ricdaftar_bpjs');		
	}
}
