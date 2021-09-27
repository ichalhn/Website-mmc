<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Radcdaftarhasil extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('rad/radmdaftar','',TRUE);
		$this->load->model('rad/radmkwitansi','',TRUE);
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index(){
		$data['title'] = 'DAFTAR HASIL DIAGNOSTIK';

		$data['radiologi']=$this->radmdaftar->get_hasil_rad_selesai()->result();
		$this->load->view('rad/radvdaftarhasilselesai',$data);
	}

	public function by_date(){
		$date=$this->input->post('date');
		$data['title'] = 'AFTAR HASIL DIAGNOSTIK Tanggal '.$date;

		$data['radiologi']=$this->radmdaftar->get_hasil_rad_by_date_selesai($date)->result();
		$this->load->view('rad/radvdaftarhasilselesai',$data);
	}

	public function by_no(){
		$key=$this->input->post('key');
		$data['title'] = 'AFTAR HASIL DIAGNOSTIK';

		$data['radiologi']=$this->radmdaftar->get_hasil_rad_by_no_selesai($key)->result();
		$this->load->view('rad/radvdaftarhasilselesai',$data);
	}

	public function view_pdf($no_rad){
		$this->load->helper('download');
		if($this->uri->segment(3))
		{
		    $data   = file_get_contents('./download/rad/radpengisianhasil/Hasil_Rad_'.$no_rad.'.pdf');
		}
		$name   = 'Hasil_Rad_'.$no_rad.'.pdf';
		force_download($name, $data);
	}
}