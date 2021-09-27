<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Labcdaftarhasil extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('lab/labmdaftar','',TRUE);
		$this->load->model('lab/labmkwitansi','',TRUE);
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index(){
		$data['title'] = 'Laboratorium';

		$data['laboratorium']=$this->labmdaftar->get_hasil_lab_selesai()->result();
		$this->load->view('lab/labvdaftarhasilselesai',$data);
	}

	public function by_date(){
		$date=$this->input->post('date');
		$data['title'] = 'Laboratorium Tanggal '.$date;

		$data['laboratorium']=$this->labmdaftar->get_hasil_lab_by_date_selesai($date)->result();
		$this->load->view('lab/labvdaftarhasilselesai',$data);
	}

	public function by_no(){
		$key=$this->input->post('key');
		$data['title'] = 'Laboratorium';

		$data['laboratorium']=$this->labmdaftar->get_hasil_lab_by_no_selesai($key)->result();
		$this->load->view('lab/labvdaftarhasilselesai',$data);
	}

	public function view_pdf($no_lab){
		$this->load->helper('download');
		$url_data= './download/lab/labpengisianhasil/Hasil_Lab_'.$no_lab.'.pdf';
		if($this->uri->segment(3))
		{
			if (file_exists($url_data)) {
		    	$data   = file_get_contents($url_data);
				$name   = 'Hasil_Lab_'.$no_lab.'.pdf';
				force_download($name, $data);
			} else {
			    echo 'Data Tidak ada.<br><br><input type="button" name="cancelvalue" value="Klik disini untuk kembali!!" onClick="self.close()"> 
				</td>';
			}
		}
	}
}