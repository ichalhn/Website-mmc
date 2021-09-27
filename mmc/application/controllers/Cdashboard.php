<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once ("Secure_area.php");
class Cdashboard extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('mdashboard','',TRUE);
	}
	
	////FORM VIEW
	public function index()
	{
		$data['title'] = 'Dashboard '.$this->config->item('namars');

		$this->load->view('dashboard/vdashboard',$data);
	}
	
	public function pasien()
	{
		$data['title'] = 'Pasien '.$this->config->item('namars');
		$this->load->view('dashboard/vpasien',$data);
	}
	
	public function bed()
	{
		$data['title'] = 'STATUS BED '.$this->config->item('namars').' | Tanggal '.date('d-m-Y');
		$this->load->view('dashboard/vbed',$data);
	}

	public function periodik_pendapatan()
	{
		$data['title'] = 'Pendapatan Periodik '.$this->config->item('namars');
		$this->load->view('dashboard/vpendperiodik',$data);
	}
	
	public function pendapatan()
	{
		$data['title'] = 'Pendapatan '.$this->config->item('namars');
		$this->load->view('dashboard/vpendkeseluruhan',$data);
	}
	
	public function poliklinik()
	{
		$data['title'] = 'Kunjungan Pasien Poliklinik '.$this->config->item('namars');
		$this->load->view('dashboard/vpoliklinik',$data);
	}
	
	public function poli()
	{
		$data['title'] = 'Pasien Poliklinik '.$this->config->item('namars');
		$data['pilihpoli'] = $this->mdashboard->get_data_poli()->result();

		$this->load->view('dashboard/vpilihpoli',$data);
	}
	
	public function diagnosa()
	{
		$data['title'] = '10 Diagnosa Terbanyak '.$this->config->item('namars');

		$this->load->view('dashboard/vdiagnosa',$data);	
	}
	
	public function farmasi()
	{
		$data['title'] = '10 Obat Terlaris '.$this->config->item('namars');

		$this->load->view('dashboard/vfarmasi',$data);	
	}

	public function get_data_periodik(){
		//$tahun_akhir=$this->input->post('tahun');
		$tahun_akhir='2016';
		$tahun_awal=$tahun_akhir-3;
		$a=array();
		$b=array();
		$c=array();
		$tableau=array();
		$bulan=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
		$datajson=$this->mdashboard->get_data_periodik($tahun_awal, $tahun_akhir)->result();
		
		foreach($datajson as $row){
			if(substr($row->bln,0,4)==$tahun_akhir-2){
				$a[]=$row->pendapatan;
			} else if(substr($row->bln,0,4)==$tahun_akhir-1){
				$b[]=$row->pendapatan;
			} else if(substr($row->bln,0,4)==$tahun_akhir){
				$c[]=$row->pendapatan;
			}
		}
	
		for($i=0;$i<12;$i++){
    		$tableau[]=array("y" => $bulan[$i],"a" => $a[$i], "b" => $b[$i], "c" => $c[$i]);
		}

	    echo json_encode($tableau);
	}

	public function get_data_pasien(){
		$datajson=$this->mdashboard->get_data_pasien()->result();
	    echo json_encode($datajson);
	}
	
	public function get_data_pasien_range(){
		$tgl_akhir=$this->input->post('tgl_akhir');
		$tgl_awal=$this->input->post('tgl_awal');
		// $datajson=$this->mdashboard->get_data_pasien_range('2017-02-01', '2017-02-28')->result();
		$datajson=$this->mdashboard->get_data_pasien_range($tgl_awal, $tgl_akhir)->result();

		$umum = "UMUM";
		$jumlah_umum = "0";
		$total_umum = "0";
		$bpjs = "BPJS";
		$jumlah_bpjs = "0";
		$total_bpjs = "0";
		$dijamin = "DIJAMIN";
		$jumlah_dijamin = "0";
		$total_dijamin = "0";
		// $dijamin = "JAMSOSKES";
		// $jumlah_jamsoskes = "0";
		// $total_jamsoskes = "0";

		foreach ($datajson as $row) {
			if($row->cara_bayar == "UMUM"){
				$jumlah_umum = $row->jumlah;
				$total_umum = $row->total;
			}
			if($row->cara_bayar == "BPJS"){
				$jumlah_bpjs = $row->jumlah;
				$total_bpjs = $row->total;
			}
			if($row->cara_bayar == "DIJAMIN"){
				$jumlah_dijamin = $row->jumlah;
				$total_dijamin = $row->total;
			} 
			// if($row->cara_bayar == "JAMSOSKES"){
			// 	$jumlah_jamsoskes = $row->jumlah;
			// 	$total_jamsoskes = $row->total;
			// }
		}

		$arrayhasil[] = array('cara_bayar' => "UMUM", 'jumlah' => $jumlah_umum, 'total' => $total_umum);
		$arrayhasil[] = array('cara_bayar' => "BPJS", 'jumlah' => $jumlah_bpjs, 'total' => $total_bpjs);
		$arrayhasil[] = array('cara_bayar' => "DIJAMIN", 'jumlah' => $jumlah_dijamin, 'total' => $total_dijamin);
	//	$arrayhasil[] = array('cara_bayar' => "JAMSOSKES", 'jumlah' => $jumlah_jamsoskes, 'total' => $total_jamsoskes);

	    echo json_encode($arrayhasil);
	}

	public function get_data_kunjungan(){
		$tgl_akhir=$this->input->post('tgl_akhir');
		$tgl_awal=$this->input->post('tgl_awal');
		$datajson=$this->mdashboard->get_data_kunjungan_poli($tgl_awal, $tgl_akhir)->result();
	    echo json_encode($datajson);
	}

	public function get_data_kunjungan_perhari(){
		$id_poli=$this->input->post('id_poli');
		$tgl_akhir=$this->input->post('tgl_akhir');
		$tgl_awal=$this->input->post('tgl_awal');
		$datajson=$this->mdashboard->get_data_kunjungan_poli_perhari($id_poli, $tgl_awal, $tgl_akhir)->result();
	    echo json_encode($datajson);
	}

	// public function get_data_pendapatan(){
	// 	$tgl_akhir=$this->input->post('tgl_akhir');
	// 	$tgl_awal=$this->input->post('tgl_awal');
	// 	$datajson=$this->mdashboard->get_data_pendapatan($tgl_awal, $tgl_akhir)->result();
	//     echo json_encode($datajson);
	// }

	public function get_data_pendapatan(){
		$tgl_akhir=$this->input->post('tgl_akhir');
		$tgl_awal=$this->input->post('tgl_awal');
		// $datajson=$this->mdashboard->get_data_pendapatan($tgl_awal, $tgl_akhir)->result();
		// $datachart="";
		// $i=0;
		// foreach ($datajson as $row) {
		// 	$datachart[$i] = ['name' => $row->label, 'y' => (int)$row->value];
		// 	$i++;
		// }
	 //    echo json_encode($datachart);

		$line  = array();
		$line2 = array();
		$row2  = array();
		if($tgl_awal=='' && $tgl_akhir==''){
			$hasil = $this->Mdashboard->get_pendapatan_keselurahan_today()->result();
		}else{
			$hasil = $this->mdashboard->get_pendapatan_keselurahan_range($tgl_awal, $tgl_akhir)->result();
		}
		/*echo json_encode($hasil);*/
		$line2[0][0] = 0;
		$line2[0][1] = 0;
		$line2[0][2] = 0;
		$line2[0][3] = 0;
		$line2[0][4] = 0;
		$line2[0][5] = 0;
		$line2[1][0] = 0;
		$line2[1][1] = 0;
		$line2[1][2] = 0;
		$line2[1][3] = 0;
		$line2[1][4] = 0;
		$line2[1][5] = 0;
		$line2[2][0] = 0;
		$line2[2][1] = 0;
		$line2[2][2] = 0;
		$line2[2][3] = 0;
		$line2[2][4] = 0;
		$line2[2][5] = 0;

		$i=1;
		foreach ($hasil as $value) {
			if($value->cara_bayar == "UMUM"){
				if($value->jenis == "rawat jalan"){
					$line2[0][0] = $value->total;
				}elseif($value->jenis == "rawat darurat"){
					$line2[0][1] = $value->total;
				}elseif($value->jenis == "rawat inap"){
					$line2[0][2] = $value->total;
				}elseif($value->jenis == "laboratorium"){
					$line2[0][3] = $value->total;
				}elseif($value->jenis == "radiologi"){
					$line2[0][4] = $value->total;
				}elseif($value->jenis == "farmasi"){
					$line2[0][4] = $value->total;
				}
			}elseif($value->cara_bayar == "BPJS"){
				if($value->jenis == "rawat jalan"){
					$line2[1][0] = $value->total;
				}elseif($value->jenis == "rawat darurat"){
					$line2[1][1] = $value->total;
				}elseif($value->jenis == "rawat inap"){
					$line2[1][2] = $value->total;
				}elseif($value->jenis == "laboratorium"){
					$line2[1][3] = $value->total;
				}elseif($value->jenis == "radiologi"){
					$line2[1][4] = $value->total;
				}elseif($value->jenis == "farmasi"){
					$line2[1][4] = $value->total;
				}
			}elseif($value->cara_bayar == "DIJAMIN"){
				if($value->jenis == "rawat jalan"){
					$line2[2][0] = $value->total;
				}elseif($value->jenis == "rawat darurat"){
					$line2[2][1] = $value->total;
				}elseif($value->jenis == "rawat inap"){
					$line2[2][2] = $value->total;
				}elseif($value->jenis == "laboratorium"){
					$line2[2][3] = $value->total;
				}elseif($value->jenis == "radiologi"){
					$line2[2][4] = $value->total;
				}elseif($value->jenis == "farmasi"){
					$line2[2][4] = $value->total;
				}
			}			
		}


		$datachart["UMUM"] = ['name' => "UMUM", 'y' => (array)$line2[0]];
		$datachart["BPJS"] = ['name' => "BPJS", 'y' => (array)$line2[1]];
		$datachart["DIJAMIN"] = ['name' => "DIJAMIN", 'y' => (array)$line2[2]];

				
		// $line2[] = $row;
		// $line['data'] = $line2;
					
		// echo json_encode($line);	    
		echo json_encode($datachart);
	}

		public function pendapatan_keseluruhan($tgl_awal='', $tgl_akhir='') {
		$line  = array();
		$line2 = array();
		$row2  = array();
		if($tgl_awal=='' && $tgl_akhir==''){
			$hasil = $this->mdashboard->get_pendapatan_keselurahan_today()->result();
		}else{
			$hasil = $this->mdashboard->get_pendapatan_keselurahan_range($tgl_awal, $tgl_akhir)->result();
		}
		/*echo json_encode($hasil);*/
		$line2[0][0] = "<b>Rawat Jalan</b>";
		$line2[1][0] = "<b>Rawat Darurat</b>";
		$line2[2][0] = "<b>Rawat Inap</b>";
		$line2[3][0] = "<b>Laboratorium</b>";
		$line2[4][0] = "<b>Radiologi</b>";
		$line2[5][0] = "<b>Farmasi</b>";

		$line2[0][1] = 0;
		$line2[1][1] = 0;
		$line2[2][1] = 0;
		$line2[3][1] = 0;
		$line2[4][1] = 0;
		$line2[5][1] = 0;
		$line2[0][2] = 0;
		$line2[1][2] = 0;
		$line2[2][2] = 0;
		$line2[3][2] = 0;
		$line2[4][2] = 0;
		$line2[5][2] = 0;
		$line2[0][3] = 0;
		$line2[1][3] = 0;
		$line2[2][3] = 0;
		$line2[3][3] = 0;
		$line2[4][3] = 0;
		$line2[5][3] = 0;

		$i=1;
		foreach ($hasil as $value) {
			if($value->jenis == "rawat jalan"){
				if($value->cara_bayar == "UMUM"){
					$line2[0][1] = "Rp. ".number_format($value->total, 0, ',', '.');
				}elseif($value->cara_bayar == "BPJS"){
					$line2[0][2] = "Rp. ".number_format($value->total, 0, ',', '.');
				}elseif($value->cara_bayar == "DIJAMIN"){
					$line2[0][3] = "Rp. ".number_format($value->total, 0, ',', '.');
				}
			}elseif($value->jenis == "rawat darurat"){
				if($value->cara_bayar == "UMUM"){
					$line2[1][1] = "Rp. ".number_format($value->total, 0, ',', '.');
				}elseif($value->cara_bayar == "BPJS"){
					$line2[1][2] = "Rp. ".number_format($value->total, 0, ',', '.');
				}elseif($value->cara_bayar == "DIJAMIN"){
					$line2[1][3] = "Rp. ".number_format($value->total, 0, ',', '.');
				}
			}elseif($value->jenis == "rawat inap"){
				if($value->cara_bayar == "UMUM"){
					$line2[2][1] = "Rp. ".number_format($value->total, 0, ',', '.');
				}elseif($value->cara_bayar == "BPJS"){
					$line2[2][2] = "Rp. ".number_format($value->total, 0, ',', '.');
				}elseif($value->cara_bayar == "DIJAMIN"){
					$line2[2][3] = "Rp. ".number_format($value->total, 0, ',', '.');
				}
			}elseif($value->jenis == "laboratorium"){
				if($value->cara_bayar == "UMUM"){
				   $line2[3][1] = "Rp. ".number_format($value->total, 0, ',', '.');
				}elseif($value->cara_bayar == "BPJS"){
					$line2[3][2] = "Rp. ".number_format($value->total, 0, ',', '.');
				}elseif($value->cara_bayar == "DIJAMIN"){
					$line2[3][3] = "Rp. ".number_format($value->total, 0, ',', '.');
				}
			}elseif($value->jenis == "radiologi"){
				if($value->cara_bayar == "UMUM"){
					$line2[4][1] = "Rp. ".number_format($value->total, 0, ',', '.');
				}elseif($value->cara_bayar == "BPJS"){
					$line2[4][2] = "Rp. ".number_format($value->total, 0, ',', '.');
				}elseif($value->cara_bayar == "DIJAMIN"){
					$line2[4][3] = "Rp. ".number_format($value->total, 0, ',', '.');
				}
			}elseif($value->jenis == "farmasi"){
				if($value->cara_bayar == "UMUM"){
					$line2[5][1] = "Rp. ".number_format($value->total, 0, ',', '.');
				}elseif($value->cara_bayar == "BPJS"){
					$line2[5][2] = "Rp. ".number_format($value->total, 0, ',', '.');
				}elseif($value->cara_bayar == "DIJAMIN"){
					$line2[5][3] = "Rp. ".number_format($value->total, 0, ',', '.');
				}
			}
		}
				
		// $line2[] = $row;
		$line['data'] = $line2;
					
		echo json_encode($line);
	}

	public function get_data_diagnosa(){
		$id_rawat=$this->input->post('id_rawat');
		$tgl_akhir=$this->input->post('tgl_akhir');
		$tgl_awal=$this->input->post('tgl_awal');
		//$datajson=$this->mdashboard->get_data_diagnosa_irj()->result();
		if($id_rawat=="ird"){
			$datajson=$this->mdashboard->get_data_diagnosa_ird($tgl_awal, $tgl_akhir)->result();
		}else if($id_rawat=="irj"){
			$datajson=$this->mdashboard->get_data_diagnosa_irj($tgl_awal, $tgl_akhir)->result();
		}else{
			$datajson=$this->mdashboard->get_data_diagnosa_iri($tgl_awal, $tgl_akhir)->result();
		}

	    echo json_encode($datajson);
	}

	// public function get_data_vtot(){
	// 	$tgl_akhir=$this->input->post('tgl_akhir');
	// 	$tgl_awal=$this->input->post('tgl_awal');
	// 	$datajson=$this->mdashboard->get_data_vtot($tgl_awal, $tgl_akhir)->row()->vtot;
	//     echo json_encode($datajson);
	// }

	public function get_data_vtot(){
		$tgl_akhir=$this->input->post('tgl_akhir');
		$tgl_awal=$this->input->post('tgl_awal');
		$datajson=$this->mdashboard->get_data_vtot($tgl_awal, $tgl_akhir)->row()->vtot;
	    echo json_encode($datajson);
	}


	public function get_data_obat(){
		$tgl_akhir=$this->input->post('tgl_akhir');
		$tgl_awal=$this->input->post('tgl_awal');
		$datajson=$this->mdashboard->get_data_obat($tgl_awal, $tgl_akhir)->result();
	    echo json_encode($datajson);
	}

	//EXPORT 
	public function export_excel($tgl_awal='', $tgl_akhir='')
	{
		$data['title'] = '10 Diagnosa Terbanyak';

		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($this->config->item('namars'))  
		        ->setLastModifiedBy($this->config->item('namars'))  
		        ->setTitle("10 Diagnosa Terbanyak ")  
		        ->setSubject("10 Diagnosa Terbanyak  Document")  
		        ->setDescription("10 Diagnosa Terbanyak  for Office 2007 XLSX, generated by HMIS.")  
		        ->setKeywords("")  
		        ->setCategory("10 Diagnosa Terbanyak");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);
		
		$data_irj=$this->mdashboard->get_excel_diagnosa_irj($tgl_awal,$tgl_akhir)->result();
		$data_ird=$this->mdashboard->get_excel_diagnosa_ird($tgl_awal,$tgl_akhir)->result();
		$data_iri=$this->mdashboard->get_excel_diagnosa_iri($tgl_awal,$tgl_akhir)->result();
			
		$objPHPExcel=$objReader->load(APPPATH.'third_party/10_diagnosa.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		// Add some data  
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
		$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.date('d-m-Y',strtotime($tgl_awal)).' s/d '.date('d-m-Y',strtotime($tgl_akhir)));
		$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Diagnosa Rawat Jalan');
		$objPHPExcel->getActiveSheet()->SetCellValue('H4', 'Diagnosa Rawat Darurat');
		$objPHPExcel->getActiveSheet()->SetCellValue('O4', 'Diagnosa Rawat Inap');
		$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
		$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Id');
		$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Nama');
		$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Jumlah');
		$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'P');
		$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'L');

		$objPHPExcel->getActiveSheet()->SetCellValue('H5', 'No');
		$objPHPExcel->getActiveSheet()->SetCellValue('I5', 'Id');
		$objPHPExcel->getActiveSheet()->SetCellValue('J5', 'Nama');
		$objPHPExcel->getActiveSheet()->SetCellValue('K5', 'Jumlah');
		$objPHPExcel->getActiveSheet()->SetCellValue('L5', 'P');
		$objPHPExcel->getActiveSheet()->SetCellValue('M5', 'L');		

		$objPHPExcel->getActiveSheet()->SetCellValue('O5', 'No');
		$objPHPExcel->getActiveSheet()->SetCellValue('P5', 'Id');
		$objPHPExcel->getActiveSheet()->SetCellValue('Q5', 'Nama');
		$objPHPExcel->getActiveSheet()->SetCellValue('R5', 'Jumlah');
		$objPHPExcel->getActiveSheet()->SetCellValue('S5', 'P');
		$objPHPExcel->getActiveSheet()->SetCellValue('T5', 'L');
		$rowCount=6;
		$i=1;$vtotirjp=0;$vtotirjl=0;
		foreach($data_irj as $row){
			$vtotirjp=$vtotirjp+$row->perempuan;
			$vtotirjl=$vtotirjl+$row->laki;
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->id);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->nama);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->jumlah);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->perempuan);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->laki);
		 	$i++;
		 	$rowCount++;
		}
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtotirjp);
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtotirjl);

		$rowCount=6;
		$i=1;$vtotirdp=0;$vtotirdl=0;
		foreach($data_ird as $row){
			$vtotirdp=$vtotirdp+$row->perempuan;
			$vtotirdl=$vtotirdl+$row->laki;
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $i);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->id);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->nama);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->jumlah);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->perempuan);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->laki);
		 	$i++;
			$rowCount++;
		}
		$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, 'Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $vtotirdp);
		$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $vtotirdl);

		$rowCount=6;
		$i=1;$vtotirip=0;$vtotiril=0;
		foreach($data_iri as $row){
			$vtotirip=$vtotirip+$row->perempuan;
			$vtotiril=$vtotiril+$row->laki;
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $i);
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $row->id);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row->nama);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $row->jumlah);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $row->perempuan);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $row->laki);
		 	$i++;
		 	$rowCount++;
		}
		$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, 'Total');
		$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $vtotirip);
		$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $vtotiril);

		header('Content-Disposition: attachment;filename="10_Diagnosa_Terbanyak.xlsx"');  
		
		// Rename worksheet (worksheet, not filename)  
		$objPHPExcel->getActiveSheet()->setTitle('10 Diagnosa');  
		   
		   
		   
		// Redirect output to a client’s web browser (Excel2007)  
		//clean the output buffer  
		ob_end_clean();  
		   
		//this is the header given from PHPExcel examples.   
		//but the output seems somewhat corrupted in some cases.  
		//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
		//so, we use this header instead.  
		header('Content-type: application/vnd.ms-excel');  
		header('Cache-Control: max-age=0');  
		   
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
		$objWriter->save('php://output');  
	}

	public function data_bed(){
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->mdashboard->get_data_bed()->result();
		/*echo json_encode($hasil);*/
		$i=1;
		foreach ($hasil as $value) {
			$row2['rank'] 	= $i++;
			$row2['kelas'] 	= $value->kelas;
			$row2['nmruang'] 	= $value->nmruang;
			$row2['bed_kapasitas_real'] 	= $value->bed_kapasitas_real;
			//$row2['bed_utama'] 	= $value->bed_utama;
			//$row2['bed_cadangan'] 	= $value->bed_cadangan;
			$row2['bed_isi'] 	= $value->bed_isi;
			$row2['bed_kosong'] = $value->bed_kosong;
	
			$line2[] = $row2;
		}

		$line['data'] = $line2;
					
		echo json_encode($line);
	}
}

?>
