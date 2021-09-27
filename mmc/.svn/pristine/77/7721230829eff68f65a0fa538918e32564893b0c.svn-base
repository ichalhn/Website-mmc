 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');

class Rme extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('medrec/MHistoripasien','',TRUE);
	}
	
	public function histori($no_cm){
		// $no_cm = "160306090001087";
		$data["title"] = "Rekam Medik Elektronik";
		$data['data_pasien']= $this->MHistoripasien->get_info_pasien($no_cm);
		$data['irj']=$this->MHistoripasien->get_history_irj($no_cm);
		$data['ird']=$this->MHistoripasien->get_history($no_cm,'IRD');
		$data['iri']=$this->MHistoripasien->get_history($no_cm,'IRI');
		// $data['laboratorium']=$this->MHistoripasien->get_history($no_cm,'LABORATORIUM');
		$data['laboratorium']=$this->MHistoripasien->get_history_lab($no_cm);
		$data['patologi']=$this->MHistoripasien->get_history($no_cm,'PATOLOGI ANATOMI');
		$data['radiologi']=$this->MHistoripasien->get_history($no_cm,'RADIOLOGI');
		$data['operasi']=$this->MHistoripasien->get_history($no_cm,'OPERASI');
		$data['farmasi']=$this->MHistoripasien->get_history($no_cm,'FARMASI');
		
		$line = array();
		$row  = array();
		
		$row['nama'] = 'IRJ';
		$row['total'] = count($data['irj']);						
		$line[] = $row;
		$row['nama'] = 'IRD';
		$row['total'] = count($data['ird']);						
		$line[] = $row;
		$row['nama'] = 'IRI';
		$row['total'] = count($data['iri']);						
		$line[] = $row;
		$row['nama'] = 'FAR';
		$row['total'] = count($data['farmasi']);						
		$line[] = $row;
		$row['nama'] = 'LAB';
		$row['total'] = count($data['laboratorium']);						
		$line[] = $row;
		$row['nama'] = 'PAT';
		$row['total'] = count($data['patologi']);						
		$line[] = $row;
		$row['nama'] = 'RAD';
		$row['total'] = count($data['radiologi']);						
		$line[] = $row;
		$row['nama'] = 'OPS';
		$row['total'] = count($data['operasi']);						
		$line[] = $row;
				
		$data['graph']=json_encode($line);
		
		$this->load->view('medrec/vrme.php',$data);
	}
}