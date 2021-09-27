 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(dirname(dirname(__FILE__)).'/Tglindo.php');

require_once(APPPATH.'controllers/Secure_area.php');
class Rjcexcel extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('irj/Rjmpencarian','',TRUE);
		$this->load->model('irj/Rjmpelayanan','',TRUE);
		$this->load->model('irj/Rjmkwitansi','',TRUE);
		$this->load->model('irj/Rjmlaporan','',TRUE);
		//$this->load->library('Excel'); 
		$this->load->file(APPPATH.'third_party/PHPExcel.php'); 
	}
	public function index()
	{
		redirect('irj/Rjcregistrasi','refresh');
	}
	
	public function excel_lapkunj($tampil_per='', $id_poli='', $var1='',$cara_bayar='')
	{
		$title = 'Laporan Kunjungan';
		$tgl_indo = new Tglindo();
		
		//get nama poli
		if ($id_poli!="SEMUA") {
			$nm_poli=$this->Rjmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		}
		
		$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamat=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
		
		////////////////////////////////////////////////////////////EXCEL
		$this->load->library('Excel'); 			
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   

		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)->setLastModifiedBy($namars);  
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);
		
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_irj_excel.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		
		// Add some data  
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $title);
		
		$no = 1;
		
		if ($tampil_per=="TGL") {

		//	print_r($var1);exit();
			
			$tgl=$var1;

		//	print_r($tgl);exit();
				
			//nama file----------------------------------
			$date_title = "Tanggal";
			
			$tgl1 = date('d-m-Y', strtotime($tgl));
			$date=substr($tgl1,0,2).' '.$tgl_indo->bulan(substr($tgl1,3,2)).' '.substr($tgl1,6,4);
			//-------------------------------------------
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$date);
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Pasien : '.$cara_bayar);
				
			if ($id_poli=="SEMUA") {
				
				$file_name="KUNJ_POLI_$tgl1.xlsx";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();

				$data_laporan_kunj=$this->Rjmlaporan->get_data_kunj_poli_harian($tgl,$id_poli,$var1,$cara_bayar)->result();
			//	print_r($data_laporan_kunj);exit();
			//	$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_poli_harian($data['tgl'],$data['cara_bayar'],$this->input->post('bpjs_bayar'))->result();

            //    $data_laporan_kunj = $this->Rjmlaporan->get_data_kunj_poli_harian(date("Y-m-d"),$data['cara_bayar'],'')->result();

			//	print_r($data_laporan_kunj);exit();

				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('E4', 'Nama');				
				$objPHPExcel->getActiveSheet()->SetCellValue('F4', 'Cara Bayar');
				$objPHPExcel->getActiveSheet()->SetCellValue('G4', 'Diagnosa Utama');
				$objPHPExcel->getActiveSheet()->SetCellValue('H4', 'Dokter');
				$objPHPExcel->getActiveSheet()->SetCellValue('I4', 'Keterangan');
				
				$rowCount = 4;
				$vtot1=0;
				foreach($poli as $row1){ 
			
					$array = json_decode(json_encode($data_laporan_kunj), True);
					$data_poli=array_column($array, 'id_poli');
				
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {	
				
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						
						$setpoli=0;

						$i=1;
						foreach($data_laporan_kunj as $row2){
						
							if ($row2->id_poli==$row1->id_poli) {

								$rowCount++;
								$i++;
								if ($setpoli==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row1->nm_poli);
										$setpoli=1;
								}
								$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $row2->no_cm,PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->no_register);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->nama);
								if($row2->cara_bayar=='DIJAMIN / JAMSOSKES'){ 
									$carabayar=$row2->kontraktor; 
								} else 
									$carabayar=$row2->cara_bayar;
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $carabayar);
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row2->diagnosa);
								$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row2->nm_dokter);
								// $waktu='';
								// if($row2->waktu_masuk_poli!='' and $row2->waktu_keluar_poli!=''){
								// 	$waktu=date('H:i',strtotime($row2->waktu_masuk_poli)).' - '.date('H:i',strtotime($row2->waktu_keluar_poli));
								// }
								$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row2->ket_pulang);
							}
						}
						$vtot1=$vtot1+($i-1);
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Total')
							->getStyle('G'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $i-1)
							->getStyle('H'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, '')
							->getStyle('I'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
					}
				}	
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Total Kunjungan')
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $vtot1)
							->getStyle('F'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
			} else {  //jika id_poli tidak "SEMUA" u/ tampil_per "TGL"
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Poliklinik : '.$nm_poli);
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Nama');
				$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Cara Bayar');
				$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Diagnosa Utama');
				$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Keterangan');
				$objPHPExcel->getActiveSheet()->SetCellValue('H5', 'Waktu');
				$rowCount=5;

				$file_name="KUNJ_POLI_".$id_poli."_$tgl1.xlsx";
				$data_laporan_kunj=$this->Rjmlaporan->get_data_kunj_harian($tgl, $id_poli,$cara_bayar)->result();
				
				$i=1;
				foreach($data_laporan_kunj as $row2){
					$rowCount++;
					$i++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $row2->no_cm,PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->no_register);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->nama);
					if($row2->cara_bayar=='BPJS'){ 
						$carabayar=$row2->kontraktor; 
					} else 
						$carabayar=$row2->cara_bayar;
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $carabayar);
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->diagnosa);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row2->ket_pulang);
					$waktu='';
					if($row2->waktu_masuk_poli!='' and $row2->waktu_keluar_poli!=''){
						$waktu=date('H:i',strtotime($row2->waktu_masuk_poli)).' - '.date('H:i',strtotime($row2->waktu_keluar_poli));
					}
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $waktu);
				}
				
				$rowCount++;
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Total')
					->getStyle('G'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $i-1)
					->getStyle('H'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	

			}
		
		} else if ($tampil_per=="BLN") {
				
			$bulan=$var1;
			$tgl_indo = new Tglindo();
			
			//nama file----------------------------------
			$bulan1 = $tgl_indo->bulan(substr($bulan,5,2))." ".date('Y', strtotime($bulan));
			$date_title = "Bulan";
			$date=$bulan1;
			//-------------------------------------------
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Bulan : '.$date);

			if ($id_poli=="SEMUA") {
				
				$file_name="KUNJ_POLI_$bulan1.xlsx";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_kunj=$this->Rjmlaporan->get_data_kunj_poli_bulanan($bulan)->result();
			//	print_r($data_laporan_kunj);die();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Tanggal');
				$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Pasien Baru');
				$objPHPExcel->getActiveSheet()->SetCellValue('E4', 'Pasien Lama');
				$objPHPExcel->getActiveSheet()->SetCellValue('F4', 'Pasien Umum');
				$objPHPExcel->getActiveSheet()->SetCellValue('G4', 'Pasien BPJS/JKN');
				$objPHPExcel->getActiveSheet()->SetCellValue('H4', 'Jumlah Dijamin/Asuransi');
				$objPHPExcel->getActiveSheet()->SetCellValue('I4', 'Jumlah Kunjungan');
				$objPHPExcel->getActiveSheet()->SetCellValue('J4', 'Jumlah Batal');
				$rowCount=4;
				$vtot1=0;$vtot2=0;$vtot3=0;$vtot4=0;$vtot5=0;$vtot6=0;$vtot7=0;

				foreach($poli as $row1){ 
					$array = json_decode(json_encode($data_laporan_kunj), True);
					$data_poli=array_column($array, 'id_poli');
					
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {	
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						$setpoli=0;
						$i=1;
						$vtot=0;$vtotlama=0;$vtotbaru=0;$vtotumum=0;$vtotbpjs=0;$vtotpenjamin=0;$vtotjumlah=0;$vtotbatal=0;
						foreach($data_laporan_kunj as $row2){
							if ($row2->id_poli==$row1->id_poli) {
								$i++;
								$rowCount++;
								$vtot1=$vtot1+$row2->jumlah_kunj;
								$vtotbaru=$vtotbaru+$row2->pasien_baru;
								$vtotlama=$vtotlama+$row2->pasien_lama;
								$vtotumum=$vtotumum+$row2->umum;
								$vtotbpjs=$vtotbpjs+$row2->bpjs;
								$vtotpenjamin=$vtotpenjamin+$row2->penjamin;
								$vtotbatal=$vtotbatal+$row2->jumlah_batal;
								$vtot=$vtot+$row2->jumlah_kunj;
								$vtot2=$vtot2+$row2->pasien_baru;
								$vtot3=$vtot3+$row2->pasien_lama;
								$vtot4=$vtot4+$row2->umum;
								$vtot5=$vtot5+$row2->bpjs;
								$vtot6=$vtot6+$row2->penjamin;
								$vtot7=$vtot7+$row2->jumlah_batal;

								if ($setpoli==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row1->nm_poli);
									$setpoli=1;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->tgl_kunj);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->pasien_baru);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->pasien_lama);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->umum);
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row2->bpjs);
								$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row2->penjamin);
								$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row2->jumlah_kunj);
								$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row2->jumlah_batal);
							}
						}
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtotbaru)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtotlama)
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtotumum)
							->getStyle('F'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $vtotbpjs)
							->getStyle('G'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $vtotpenjamin)
							->getStyle('H'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
						$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $vtot)
							->getStyle('I'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $vtotbatal)
							->getStyle('J'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					}
				}
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Kunjungan')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot1)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Pasien Baru')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot2)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Pasien Lama')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot3)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						
                        $rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Pasien Umum')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot4)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                         $rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Pasien JKN')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot5)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
               
                        $rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Pasien Penjamin')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot6)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Pasien Batal')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot7)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
			} else {
				
				$file_name="KUNJ_POLI_".$id_poli."_$bulan1.xlsx";
				$data_laporan_kunj=$this->Rjmlaporan->get_data_kunj_bulanan($bulan, $id_poli)->result();
				//print_r($data_laporan_kunj);die();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Poliklinik : '.$nm_poli);
			
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Tanggal');
				$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Pasien Baru');
				$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Pasien Lama');
				$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Pasien Umum');
				$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Pasien JKN');
				$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Pasien Penjamin');
				$objPHPExcel->getActiveSheet()->SetCellValue('H5', 'Jumlah Kunjungan');
				$objPHPExcel->getActiveSheet()->SetCellValue('I5', 'Jumlah Batal');
				$rowCount=5;

				$i=1;
				$vtot=0;$vtotlama=0;$vtotbaru=0;$vtotbatal=0;$vtotumum=0;$vtotbpjs=0;$vtotpenjamin=0;
				
				foreach($data_laporan_kunj as $row){
					$vtot=$vtot+$row->jumlah_kunj;
					$vtotbaru=$vtotbaru+$row->pasien_baru;
					$vtotlama=$vtotlama+$row->pasien_lama;
					$vtotumum=$vtotumum+$row->umum;
					$vtotbpjs=$vtotbpjs+$row->bpjs;
				    $vtotpenjamin=$vtotpenjamin+$row->penjamin;
					$vtotbatal=$vtotbatal+$row->jumlah_batal;
				   // foreach($data_laporan_kunj as $row2){
							// 	$vtot=$vtot+$row2->jumlah_kunj;
							// 	$vtotbaru=$vtotbaru+$row2->pasien_baru;
							// 	$vtotlama=$vtotlama+$row2->pasien_lama;
							// 	$vtotumum=$vtotumum+$row2->umum;
							// 	$vtotbpjs=$vtotbpjs+$row2->bpjs;
							// 	$vtotpenjamin=$vtotpenjamin+$row2->penjamin;
							// 	$vtotbatal=$vtotbatal+$row2->jumlah_batal;
					$rowCount++;
					$i++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tgl_kunj);
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->pasien_baru);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->pasien_lama);
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->umum);
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->bpjs);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->penjamin);
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->jumlah_kunj);
					$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->jumlah_batal);
				}

				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total')
					->getStyle('D'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtotbaru)
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtotlama)
					->getStyle('D'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtotumum)
					->getStyle('E'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtotbpjs)
					->getStyle('F'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                 
                 $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $vtotpenjamin)
					->getStyle('G'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $vtot)
					->getStyle('H'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $vtotbatal)
					->getStyle('I'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

			}
				
		} else if ($tampil_per=="THN") {
				
			$tahun=$var1;
			
			//nama file----------------------------------
			$date_title = "Tahun";
			$date=$tahun;
			//-------------------------------------------
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tahun : '.$date);

			if ($id_poli=="SEMUA") {
			
				$file_name="KUNJ_POLI_$tahun.xlsx";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_kunj=$this->Rjmlaporan->get_data_kunj_poli_tahunan($tahun, $id_poli)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Bulan');
				$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Jumlah Kunjungan');
				$rowCount=4;
				$vtot1=0;
				foreach($poli as $row1){ 
		
					$array = json_decode(json_encode($data_laporan_kunj), True);
					$data_poli=array_column($array, 'id_poli');
					
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {	
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						$setpoli=0;
						$i=1;
						$vtot=0;
						foreach($data_laporan_kunj as $row2){
							if ($row2->id_poli==$row1->id_poli) {
								$vtot=$vtot+$row2->jumlah_kunj;
								$vtot1=$vtot1+$row2->jumlah_kunj;
								$i++;
								$rowCount++;
								
								if ($setpoli==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row1->nm_poli);
									$setpoli=1;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $tgl_indo->bulan($row2->bulan_kunj));
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_kunj);

							}
						}
						
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total ')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					}
				}
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Kunjungan')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot1)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
			} else { //else per_tampil 'THN' dan id_poli!='SEMUA'
				
				$file_name="KUNJ_POLI_".$id_poli."_$tahun.xlsx";
				$data_laporan_kunj=$this->Rjmlaporan->get_data_kunj_tahunan($tahun, $id_poli)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Poliklinik : '.$nm_poli);
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Bulan');
				$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Jumlah Kunjungan');
				$rowCount=5;
				
				$i=1;
				$vtot=0;
				foreach($data_laporan_kunj as $row){
					$vtot=$vtot+$row->jumlah_kunj;
					$rowCount++;
					$i++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $tgl_indo->bulan($row->bulan_kunj));
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->jumlah_kunj)
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}
			 
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total')
					->getStyle('B'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtot)
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			}
		}
							
		// Rename worksheet (worksheet, not filename)
		$objPHPExcel->getActiveSheet()->setTitle('Laporan Kunjungan');
		header('Content-Disposition: attachment;filename="'.$file_name.'"');
		$objPHPExcel->getActiveSheet()->setTitle($namars);
		//ob_end_flush();
		ob_end_clean();
		//this is the header given from PHPExcel examples.
		//but the output seems somewhat corrupted in some cases.
		//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
		//so, we use this header instead.  
		header('Content-type: application/vnd.ms-excel');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		
		//redirect('irj/Rjclaporan/lapkunjungan','refresh');
		
	}

    public function excel_lapkunj_detail($tgl_awal='',$tgl_akhir='')
	{
		$title = 'Laporan Kunjungan';
		$tgl_indo = new Tglindo();		
		$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamat=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$file_name="kunj_rj_$tgl_awal.xlsx";
	

		////////////////////////////////////////////////////////////EXCEL
		$this->load->library('Excel'); 			
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   

		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)->setLastModifiedBy($namars);  
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);
		
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_irj_excel.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		
		// Add some data  
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $title);
	//	$no = 1;
		$data['controller']=$this; 

		$tipe_input = $this->input->post('tampil_per');
		$tgl_awal = $this->input->post('tgl_awal');
	//	$jam_awal = $this->input->post('jam_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');
	//	$jam_akhir = $this->input->post('jam_akhir');
	//	$bulan = $this->input->post('bulan');
	//	$tahun = $this->input->post('tahun');
	//	$user_biling = $this->input->post('user_biling');

	//	$data['list_user'] = $this->rimuser->get_all_user();
		
		//echo $tipe_input;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tipe_input == ''){
			$tgl_awal = date("2018-11-12");
			$tgl_akhir = date("2018-11-12");
			$data['data_kunjungan']=$this->Rjmlaporan->get_kunj_pasien_detail($tgl_awal,$tgl_akhir);

		//	$data['tgl_awal_show'] = "";
		//	$data['tgl_akhir_show'] = "";
		//	$data['user_show'] = "";

			$data['tgl_awal'] = $tgl_awal;
			$data['tgl_akhir'] = $tgl_akhir;
			$data['data_kunjungan']=$this->Rjmlaporan->get_kunj_pasien_detail($tgl_awal,$tgl_akhir);
            print_r($data['data_kunjungan']);exit();
			
				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Tanggal');
				$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('E4', 'Nama');				
				$objPHPExcel->getActiveSheet()->SetCellValue('F4', 'Jenis Kelamin');
				$objPHPExcel->getActiveSheet()->SetCellValue('G4', 'poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('H4', 'Dokter');
				$objPHPExcel->getActiveSheet()->SetCellValue('I4', 'Jenis Pasien');

	}

		if($tipe_input == 'TGL'){

			$data['tgl_awal'] = $tgl_awal;
			$data['tgl_akhir'] = $tgl_akhir;
			$data['data_kunjungan']=$this->Rjmlaporan->get_kunj_pasien_detail($tgl_awal,$tgl_akhir);

				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Tanggal');
				$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('E4', 'Nama');				
				$objPHPExcel->getActiveSheet()->SetCellValue('F4', 'Jenis Kelamin');
				$objPHPExcel->getActiveSheet()->SetCellValue('G4', 'poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('H4', 'Dokter');
				$objPHPExcel->getActiveSheet()->SetCellValue('I4', 'Jenis Pasien');

			
		}

				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Tanggal');
				$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('E4', 'Nama');				
				$objPHPExcel->getActiveSheet()->SetCellValue('F4', 'Jenis Kelamin');
				$objPHPExcel->getActiveSheet()->SetCellValue('G4', 'poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('H4', 'Dokter');
				$objPHPExcel->getActiveSheet()->SetCellValue('I4', 'Jenis Pasien');
			
            //    $data_kunjungan=$this->Rjmlaporan->get_kunj_pasien_detail('2018-11-12','201-11-12');

               //  $data['data_kunjungan']=$this->Rjmlaporan->get_kunj_pasien_detail($tgl_awal,$tgl_akhir);
                
               // print_r($data['data_kunjungan']);exit();    

                 $no=1;
				 $rowCount = 4;
			    
			//     $array = json_decode(json_encode($data_kunjungan), True);
                //   print_r($array);exit();

			    foreach($data_kunjungan as $row){
                 $objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
			     $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tanggal);
			
				}
				
							
		// Rename worksheet (worksheet, not filename)
		$objPHPExcel->getActiveSheet()->setTitle('Laporan Kunjungan');
		header('Content-Disposition: attachment;filename="'.$file_name.'"');
		$objPHPExcel->getActiveSheet()->setTitle($namars);
		//ob_end_flush();
		ob_end_clean();
		//this is the header given from PHPExcel examples.
		//but the output seems somewhat corrupted in some cases.
		//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
		//so, we use this header instead.  
		header('Content-type: application/vnd.ms-excel');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		
		//redirect('irj/Rjclaporan/lapkunjungan','refresh');
	
	}


	public function excel_lapkunj_rj($tgl_awal='',$tgl_akhir='')
	{  

        $tgl_awal= date('Y-m-d');
        $tgl_akhir= date('Y-m-d');
     
	  // Load plugin PHPExcel nya    
	 require_once (APPPATH.'third_party/PHPExcel.php');  
	  // Panggil class PHPExcel nya    
	  $excel = new PHPExcel();    
	  // Settingan awal fil excel    
	   $excel->getProperties()->setCreator('Yuliatno Rawosi')
	        ->setLastModifiedBy('Yuliatno Rawosi')
	        ->setTitle("Data Kunjunga Rawat Jalan")                 
	        ->setSubject("Data Kunjungan")                 
	        ->setDescription("Laporan Kunjungan Pasien Rawat Jalan")                 
	        ->setKeywords("Data Kunjungan");   
	         // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    
	        $style_col = array(
	              'font' => array('bold' => true),
	        // Set font nya jadi bold      
	              'alignment' => array(        
	                 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)        
	                 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)      
	                 ),     
	                  'borders' => array(        
	                  'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis        
	                  'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis        
	                  'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis        
	                  'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis      
	                  )    
	                );    

	                // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel    
	                $style_row = array(      
	                 'alignment' => array(        
	                 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)      
	                 ),      
	                 'borders' => array(        
	                 'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis        
	                 'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis       
	                  'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis        
	                  'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis      
	                  )    
	                );    

	                $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA KUNJUNGAN PASIEN"); // Set kolom A1 dengan tulisan "DATA SISWA"    
	                $excel->getActiveSheet()->mergeCells('A1:I1'); // Set Merge Cell pada kolom A1 sampai E1    
	                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1    
	                $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1    
	                $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1    // Buat header tabel nya pada baris ke 3    
	                	                
	                $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"    
	                $excel->setActiveSheetIndex(0)->setCellValue('B3', "TANGGAL"); // Set kolom B3 dengan tulisan "NIS"
	                $excel->setActiveSheetIndex(0)->setCellValue('C3', "NO REGISTER"); // Set kolom C3 dengan tulisan "NAMA"
	                $excel->setActiveSheetIndex(0)->setCellValue('D3', "NO MEDREC"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"    
	                $excel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA"); // Set kolom E3 dengan tulisan "ALAMAT"    
	                $excel->setActiveSheetIndex(0)->setCellValue('F3', "JENIS KELAMIN");
	                $excel->setActiveSheetIndex(0)->setCellValue('G3', "POLIKLINIK");
	                $excel->setActiveSheetIndex(0)->setCellValue('H3', "DOKTER");
	                $excel->setActiveSheetIndex(0)->setCellValue('I3', "JENIS PASIEN");


	                // Apply style header yang telah kita buat tadi ke masing-masing kolom header    
	                
	                $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);    
	                $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);    
	                $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);    
	                $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);    
	                $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
	                $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);    
	                $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);    
	                $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);    
	                $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);    
	               

	                // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya    

	 //     $data['$data_kunjungan']=$this->Rjmlaporan->get_kunj_pasien_detail($tgl_awal,$tgl_akhir); 
	    //            $array = json_decode(json_encode($data_kunjungan), True);

	            $data_kunjungan=$this->Rjmlaporan->get_kunj_pasien_detail($tgl_awal,$tgl_akhir);

	              //  print_r($array);exit();


	             //   print_r($data_kunjungan);exit();  


	                $no = 1; // Untuk penomoran tabel, di awal set dengan 1    
	                $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4    
	               
	                foreach($data_kunjungan as $data){ 
	                // Lakukan looping pada variabel siswa      
	                $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);      
	                $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->tanggal);      
	                $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->no_register);      
	                $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->no_cm);      
	                $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->nama);
	                $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data->jenis_kelamin);      
	                $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->poliklinik);      
	                $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->dokter);      
	                $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->jeins_pasien);  


	                // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)      
	                $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);      
	                $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);      
	                $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);      
	                $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);      
	                $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
	                $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);      
	                $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);      
	                $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);      
	                $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);            
	                $no++; // Tambah 1 setiap kali looping      
	                $numrow++; // Tambah 1 setiap kali looping    }    

	                // Set width kolom    
	                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A    
	                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B    
	                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C    
	                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D    
	                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E
	                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(15); // Set width kolom B    
	                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(25); // Set width kolom C    
	                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20); // Set width kolom D    
	                $excel->getActiveSheet()->getColumnDimension('I')->setWidth(30); // Set width kolom E         
	                // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	                $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);    
	                // Set orientasi kertas jadi LANDSCAPE    
	                $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);    
	                // Set judul file excel nya    
	                $excel->getActiveSheet(0)->setTitle("Laporan Data kunjungan");    
	                $excel->setActiveSheetIndex(0);    

	                // Proses file excel    
	                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');    
	                header('Content-Disposition: attachment; filename="Data Siswa.xlsx"'); // Set nama file excel nya    
	                header('Cache-Control: max-age=0');    
	                $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');    
	                $write->save('php://output');  
	            }
	}
	
	//LAPORAN KEUANGAN----------------------------------------------------------------------------------------------------------------------

	//TGL/SEMUA/2016-12-25/10/SEMUA/2017-03-01
	public function excel_lapkeu($tampil_per='', $id_poli='', $var1='', $status='', $cara_bayar='',$param1='')
	{
		
		$title = 'Laporan Keuangan';
		$tgl_indo = new Tglindo();
		if ($id_poli!="SEMUA") {
			$nm_poli=$this->Rjmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		}
		$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamat=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
		
		////////////////////////////////////////////////////////////EXCEL 
		
		
		////////////////////////////////////////////////////////////EXCEL 
		$this->load->library('Excel'); 		
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   

		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
			->setLastModifiedBy($namars);  

		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		
		// Add some data  
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $title);
		if ($status=='10') {
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Status : Pulang dan Dirawat - '.$cara_bayar);
		} else if ($status=='1') {
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Status : Pulang - '.$cara_bayar);
		} else if ($status=='0') {
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Status : Dirawat - '.$cara_bayar);		
		}
		$no = 1;
		$vtottotal=0;$vtotkunj=0;
		//$vtotlab=0;$vtotrad=0;$vtotobat=0;$vtotok=0;$vtottunai=0;$vtotdiskon=0;$vtottot=0;
		$vtotlabglobal=0;$vtotradglobal=0;$vtotobatglobal=0;$vtotokglobal=0;$vtottunaiglobal=0;$vtotdiskonglobal=0;$vtottotglobal=0;
		if ($tampil_per=="TGL") {
		 
			$tgl=$var1;
			$tgl0=$param1;
			//nama file----------------------------------
			$tgl1 = date('d-m-Y', strtotime($tgl));
			$tgl11 = date('d-m-Y', strtotime($tgl0));
			$date=substr($tgl1,0,2).' '.$tgl_indo->bulan(substr($tgl1,3,2)).' '.substr($tgl1,6,4);
			$date_title = 'Tanggal';
			//-------------------------------------------
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$tgl1.' - '.$tgl11);
			
			if ($id_poli=="SEMUA") {
				
				//style & format
				$objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('H5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('I5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('J5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('K5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('L5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('M5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('N5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('O5')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('O5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->setAutoFilter('A5:O5');

				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Nama');				
				$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Status');
				$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Cara Bayar');
				//$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Biaya Daftar');
				$objPHPExcel->getActiveSheet()->SetCellValue('H5', 'Biaya Tindakan');	
				$objPHPExcel->getActiveSheet()->SetCellValue('I5', 'Laboratorium');
				$objPHPExcel->getActiveSheet()->SetCellValue('J5', 'Radiologi');
				$objPHPExcel->getActiveSheet()->SetCellValue('K5', 'Obat');	
				$objPHPExcel->getActiveSheet()->SetCellValue('L5', 'Operasi');
				$objPHPExcel->getActiveSheet()->SetCellValue('M5', 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('N5', 'Tunai');
				$objPHPExcel->getActiveSheet()->SetCellValue('O5', 'Diskon');

				$rowCount = 5;

				$file_name="KEU_POLI_".$tgl1."_".$tgl11.".xlsx";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_poli_harian($tgl, $tgl0)->result();
			
				foreach($poli as $row1){ 
			
					$array = json_decode(json_encode($data_laporan_keu), True);
					$data_poli=array_column($array, 'id_poli');
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {		
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						
						$setpoli=0;
						$vtot=0;$total=0;
						$vtotlab=0;$vtotrad=0;$vtotobat=0;$vtotok=0;$vtottunai=0;$vtotdiskon=0;$vtottot=0;
						//$biayadaftar=0;
						foreach($data_laporan_keu as $row2){
							if ($row2->id_poli==$row1->id_poli) {
							
								$rowCount++;
							
								$vtot+=$row2->vtot;
								$vtottotal+=$row2->vtot;
								$total=$row2->vtot+$row2->vtot_lab+$row2->vtot_rad+$row2->vtot_obat+$row2->vtot_ok;
								$vtotrad+=$row2->vtot_rad;
								$vtotlab+=$row2->vtot_lab;
								$vtotobat+=$row2->vtot_obat;
								$vtotok+=$row2->vtot_ok;
								$vtottunai+=$row2->tunai;
								$vtotdiskon+=$row2->diskon;
								$vtottot+=$total;
								//$vtotlabglobal=0;$vtotradglobal=0;$vtotobatglobal=0;$vtotokglobal=0;$vtottunaiglobal=0;$vtotdiskonglobal=0;$vtottotglobal=0;
								$vtotlabglobal+=$row2->vtot_lab;
								$vtotradglobal+=$row2->vtot_rad;
								$vtotobatglobal+=$row2->vtot_obat;
								$vtotokglobal+=$row2->vtot_ok;
								$vtottunaiglobal+=$row2->tunai;
								$vtotdiskonglobal+=$row2->diskon;
								$vtottotglobal+=$total;
								//$biayadaftar+=$row2->biayadaftar;
						
								if ($setpoli==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row1->nm_poli);
										$setpoli=1;
								}
								$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $row2->no_cm,PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->no_register);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->nama);		
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->status);		
								if($row2->cara_bayar!='UMUM'){
									$textcb=$row2->nmkontraktor;
								}else{
									$textcb=$row2->cara_bayar;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $textcb);

								$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format( $row2->vtot, 2 , ',' , '.' ))
										->getStyle('H'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format( $row2->vtot_lab, 2 , ',' , '.' ))
										->getStyle('I'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, number_format( $row2->vtot_rad, 2 , ',' , '.' ))
										->getStyle('J'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, number_format( $row2->vtot_obat, 2 , ',' , '.' ))
										->getStyle('K'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, number_format( $row2->vtot_ok, 2 , ',' , '.' ))
										->getStyle('L'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										
								$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, number_format( $total, 2 , ',' , '.' ))
										->getStyle('M'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, number_format( $row2->tunai, 2 , ',' , '.' ))
										->getStyle('N'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, number_format( $row2->diskon, 2 , ',' , '.' ))
										->getStyle('O'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);								
							}

						}
						
							$rowCount++;
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Total')
								->getStyle('G'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
							$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format( $vtottotal, 2 , ',' , '.' ))
								->getStyle('H'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format( $vtotlabglobal, 2 , ',' , '.' ))
								->getStyle('I'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, number_format( $vtotradglobal, 2 , ',' , '.' ))
								->getStyle('J'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, number_format( $vtotobatglobal, 2 , ',' , '.' ))
								->getStyle('K'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, number_format( $vtotokglobal, 2 , ',' , '.' ))
								->getStyle('L'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, number_format( $vtottotglobal, 2 , ',' , '.' ))
								->getStyle('M'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, number_format( $vtottunaiglobal, 2 , ',' , '.' ))
								->getStyle('N'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, number_format( $vtotdiskonglobal, 2 , ',' , '.' ))
								->getStyle('O'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						
					}
				}
				
			} else { //jika id_poli tidak "SEMUA" u/ tampil_per "TGL"
			
				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Poliklinik : '.$nm_poli);
				$objPHPExcel->getActiveSheet()->SetCellValue('B6', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('C6', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('E6', 'Nama');	
				$objPHPExcel->getActiveSheet()->SetCellValue('F6', 'Status');
				$objPHPExcel->getActiveSheet()->SetCellValue('G6', 'Cara Bayar');
				//$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Biaya Daftar');
				$objPHPExcel->getActiveSheet()->SetCellValue('H6', 'Biaya Tindakan');	
				$objPHPExcel->getActiveSheet()->SetCellValue('I6', 'Laboratorium');
				$objPHPExcel->getActiveSheet()->SetCellValue('J6', 'Radiologi');
				$objPHPExcel->getActiveSheet()->SetCellValue('K6', 'Obat');	
				$objPHPExcel->getActiveSheet()->SetCellValue('L6', 'Operasi');
				$objPHPExcel->getActiveSheet()->SetCellValue('M6', 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('N6', 'Tunai');
				$objPHPExcel->getActiveSheet()->SetCellValue('O6', 'Diskon');
				
				$rowCount = 6;
				
				$file_name="KEU_POLI_".$id_poli."_$tgl1_$tgl11.xlsx";
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_harian($tgl,$tgl0, $id_poli)->result();
				
				$vtot=0;$total=0;
				$vtotlab=0;$vtotrad=0;$vtotobat=0;$vtotok=0;$vtottunai=0;$vtotdiskon=0;$vtottot=0;
				//$biayadaftar=0;
				foreach($data_laporan_keu as $row2){
					$vtot+=$row2->vtot;
					//$biayadaftar+=$row2->biayadaftar;
					$vtottotal+=$row2->vtot;
					$total=$row2->vtot+$row2->vtot_lab+$row2->vtot_rad+$row2->vtot_obat+$row2->vtot_ok;
					$vtotrad+=$row2->vtot_rad;
					$vtotlab+=$row2->vtot_lab;
					$vtotobat+=$row2->vtot_obat;
					$vtotok+=$row2->vtot_ok;
					$vtottunai+=$row2->tunai;
					$vtotdiskon+=$row2->diskon;
					$vtottot+=$total;

					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $row2->no_cm,PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->no_register);
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->nama);
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->status);		
								if($row2->cara_bayar!='UMUM'){
									$textcb=$row2->nmkontraktor;
								}else{
									$textcb=$row2->cara_bayar;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $textcb);

								$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format( $row2->vtot, 2 , ',' , '.' ))
										->getStyle('H'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format( $row2->vtot_lab, 2 , ',' , '.' ))
										->getStyle('I'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, number_format( $row2->vtot_rad, 2 , ',' , '.' ))
										->getStyle('J'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, number_format( $row2->vtot_obat, 2 , ',' , '.' ))
										->getStyle('K'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, number_format( $row2->vtot_ok, 2 , ',' , '.' ))
										->getStyle('L'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
										
								$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, number_format( $total, 2 , ',' , '.' ))
										->getStyle('M'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, number_format( $row2->tunai, 2 , ',' , '.' ))
										->getStyle('N'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, number_format( $row2->diskon, 2 , ',' , '.' ))
										->getStyle('O'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);					
				
				}
			
					$rowCount++;
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Total')
								->getStyle('G'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
							$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
								->getStyle('H'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format( $vtotlab, 2 , ',' , '.' ))
								->getStyle('I'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, number_format( $vtotrad, 2 , ',' , '.' ))
								->getStyle('J'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, number_format( $vtotobat, 2 , ',' , '.' ))
								->getStyle('K'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, number_format( $vtotok, 2 , ',' , '.' ))
								->getStyle('L'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, number_format( $vtottotglobal, 2 , ',' , '.' ))
								->getStyle('M'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, number_format( $vtottunai, 2 , ',' , '.' ))
								->getStyle('N'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);							
							$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, number_format( $vtotdiskon, 2 , ',' , '.' ))
								->getStyle('O'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
				
			}  

		} else if ($tampil_per=="BLN") {

			$bulan=$var1;
				
			//nama file----------------------------------
			$bulan1 = $tgl_indo->bulan(substr($bulan,6,2)).date('Y', strtotime($bulan));
			$date_title = "Bulan";
			$date="$bulan1";
			//-------------------------------------------
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Bulan : '.$date);
			 $objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Pasien : '.$cara_bayar);
				
			
			if ($id_poli=="SEMUA") {
				
				$file_name="KEU_POLI_$bulan1.xls";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_poli_bulanan(substr($bulan,6,2), $status, $cara_bayar)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A6', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B6', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C6', 'Tanggal');
				//$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Total Biaya Daftar');
				$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Total Biaya Tindakan');
				$rowCount=6;
				
				foreach($poli as $row1){ 
		
					$array = json_decode(json_encode($data_laporan_keu), True);
					$data_poli=array_column($array, 'id_poli');
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {	

						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						$setpoli=0;
						
						$i=1;
						$vtot=0;$vtot1=0;
						$biayadaftar=0;
						foreach($data_laporan_keu as $row2){
							if ($row2->id_poli==$row1->id_poli) {
								
								$rowCount++;
								$vtot+=$row2->jumlah_vtot;
								$vtottotal+=$row2->jumlah_vtot;
								$vtotkunj+=$row2->jumlah_kunj;
								$biayadaftar+=$row2->jumlah_biayadaftar;
								$vtot1+=$row2->jumlah_kunj;

								if ($setpoli==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row1->nm_poli);
									$setpoli=1;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->tgl_kunj);
								/*$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $row2->jumlah_biayadaftar, 2 , ',' , '.' ))
									->getStyle('D'.$rowCount)
									->getAlignment()
									->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								*/
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_kunj)
									->getStyle('D'.$rowCount)
									->getAlignment()
									->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $row2->jumlah_vtot, 2 , ',' , '.' ))
									->getStyle('E'.$rowCount)
									->getAlignment()
									->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								
							}
						}
						
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						/*$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						*/
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot1)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

						/*$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,'Total Biaya Daftar dan Tindakan')
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						*/
					}
				}
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Biaya')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $vtottotal, 2 , ',' , '.' ))
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Kunjungan')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtotkunj)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			} else { //else per_tampil 'BLN' dan id_poli!='SEMUA'
				
				$file_name="KEU_POLI_".$id_poli."_$bulan1.xls";
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_bulanan(substr($bulan,5,2), $id_poli, $status, $cara_bayar)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Poliklinik : '.$nm_poli);
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A7', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B7', 'Tanggal');
				//$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Total Biaya Daftar');
				$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Total Biaya Tindakan');
				$rowCount=7;

				$i=1;
				$vtot=0;$vtot1=0;
				$biayadaftar=0;
				foreach($data_laporan_keu as $row){
					$vtot+=$row->jumlah_vtot;
					$vtot1+=$row->jumlah_kunj;
					$biayadaftar+=$row->jumlah_biayadaftar;
					
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tgl_kunj);
					/*$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $row->jumlah_biayadaftar, 2 , ',' , '.' ))
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					*/
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->jumlah_kunj)
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $row->jumlah_vtot, 2 , ',' , '.' ))
						->getStyle('D'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}
				
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total')
					->getStyle('B'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				/*$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtot1)
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
					->getStyle('D'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
				/*$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Biaya Daftar dan Tindakan')
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
					->getStyle('D'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
			}
			
		} else if ($tampil_per=="THN") {
				
			$tahun=$var1;
			
			$date_title = 'Tahun';
			$date=$tahun;
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tahun : '.$date);
			$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Pasien : '.$cara_bayar);

			
			if ($id_poli=="SEMUA") {
			
				$file_name="KEU_POLI_$tahun.xls";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_poli_tahunan($tahun, $status, $cara_bayar)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A6', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B6', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C6', 'Bulan');
				$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Total Kunjungan');
				$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Total Biaya Tindakan');
				$rowCount=6;

				
				foreach($poli as $row1){ 
					$array = json_decode(json_encode($data_laporan_keu), True);
					$data_poli=array_column($array, 'id_poli');
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {	
		
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						$setpoli=0;
		
						$i=1;
						$vtot=0;$vtot1=0;
						//$biayadaftar=0;
						foreach($data_laporan_keu as $row2){
							if ($row2->id_poli==$row1->id_poli) {
								
								$rowCount++;
								$vtot+=$row2->jumlah_vtot;
								$vtottotal+=$row2->jumlah_vtot;
								$vtotkunj+=$row2->jumlah_kunj;
								$vtot1+=$row2->jumlah_kunj;
								//$biayadaftar+=$row2->jumlah_biayadaftar;
								

								if ($setpoli==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row1->nm_poli);
									$setpoli=1;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $tgl_indo->bulan($row2->bulan_kunj));
								/*$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $row2->jumlah_biayadaftar, 2 , ',' , '.' ))
								->getStyle('D'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_kunj)
								->getStyle('D'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $row2->jumlah_vtot, 2 , ',' , '.' ))
								->getStyle('E'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							}
						}
					
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						/*$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot1)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

						/*$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,'Total Biaya Daftar dan Tindakan')
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
					} //end if data tdk kosong
				} 
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Biaya')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $vtottotal, 2 , ',' , '.' ))
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total Kunjungan')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtotkunj)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			} else { //else per_tampil 'THN' dan id_poli!='SEMUA'
				
				$file_name="KEU_POLI_".$id_poli."_$tahun.xls";
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_tahunan($tahun, $id_poli, $status, $cara_bayar)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Poliklinik : '.$nm_poli);
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A7', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B7', 'Bulan');
				//$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Total Biaya Daftar');
				$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Total Biaya Tindakan');
				$rowCount=7;
				
				$i=1;
				$vtot=0;$vtot1=0;
				//$biayadaftar=0;
				foreach($data_laporan_keu as $row){
					$vtot+=$row->jumlah_vtot;
					$vtot1+=$row->jumlah_kunj;
					//$biayadaftar+=$row->jumlah_biayadaftar;
					
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $tgl_indo->bulan($row->bulan_kunj));
					/*$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $row->jumlah_biayadaftar, 2 , ',' , '.' ))
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->jumlah_kunj)
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $row->jumlah_vtot, 2 , ',' , '.' ))
						->getStyle('D'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}
				
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total')
					->getStyle('B'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				/*$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtot1)
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
					->getStyle('D'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
				/*$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Biaya Daftar dan Tindakan')
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
					->getStyle('D'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
			}
		}	
		
		$objPHPExcel->getActiveSheet()->setTitle('Laporan Keuangan');
		header('Content-Disposition: attachment;filename="'.$file_name.'"');
		$objPHPExcel->getActiveSheet()->setTitle($namars);
		//ob_end_flush();
		ob_end_clean();
		//this is the header given from PHPExcel examples.
		//but the output seems somewhat corrupted in some cases.
		//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
		//so, we use this header instead.  
		header('Content-type: application/vnd.ms-excel');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');		
	
		redirect('irj/Rjclaporan/lapkeu','refresh');


		
	}
	
	public function excel_lapkeudokter($id_dokter='', $tgl_awal='', $tgl_akhir='', $cara_bayar)
	{
	
		$data['title'] = 'Laporan Pendapatan Dokter';

		$tgl_indo=new Tglindo();

		$id_dokter=$id_dokter;
		$tgl_awal=$tgl_awal;
		$tgl_akhir=$tgl_akhir;
		$dokter=$this->Rjmpencarian->get_dokter()->result();
		
		if($tgl_awal!='' && $tgl_akhir!=''){
			
			$tgl_awal1 = date('d-m-Y', strtotime($tgl_awal));
			$tgl_akhir1 = date('d-m-Y', strtotime($tgl_akhir));
				
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamat=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			
			//////////////////////////////////NAMA FILE
			$date_title = "Tanggal";
			if ($id_dokter=="SEMUA") {
				
				if($tgl_awal!=$tgl_akhir){
				$date=$tgl_awal1.' s/d '.$tgl_akhir1;
				$file_name="PENDAPATAN_DOKTER_(".$tgl_awal1."_sd_".$tgl_akhir1.").xlsx";
				}else{
					$date=$tgl_awal1;
					$file_name="PENDAPATAN_DOKTER_($tgl_awal1).xlsx";
				}
			} else {
				//get nama dokter
				$nm_dokter=$this->Rjmlaporan->get_nm_dokter($id_dokter)->row()->nm_dokter;
			
				if($tgl_awal!=$tgl_akhir){
				$date=$tgl_awal1.' s/d '.$tgl_akhir1;
				$file_name="PENDAPATAN_DOKTER_".$id_dokter."_(".$tgl_awal1."_sd_".$tgl_akhir1.").xlsx";
				}else{
					$date=$tgl_awal1;
					$file_name="PENDAPATAN_DOKTER_".$id_dokter."_($tgl_awal1).xlsx";
				}
			}
			$datakeu_dokter=$this->Rjmlaporan->get_data_keu_dokter($id_dokter, $tgl_awal,$tgl_akhir, $cara_bayar)->result();
			
			////////////////////////////////////////////////////////////EXCEL 
			//$this->load->library('Excel');  
			
			// Create new PHPExcel object  
			$objPHPExcel = new PHPExcel();   

			// Set document properties  
			$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars);  
		        //->setTitle("Laporan Keuangan RS PATRIA IKKT")  
		        //->setSubject("Laporan Keuangan RS PATRIA IKKT Document")  
		        //->setDescription("Laporan Keuangan RS PATRIA IKKT for Office 2007 XLSX, generated by HMIS.")  
		        //->setKeywords("Pendapatan Dokter")  ;
		        //->setCategory("Laporan Keuangan");  

			$objReader= PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(true);
			
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
			$objPHPExcel->setActiveSheetIndex(0);  
			
			// Add some data  
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$date);
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Cara Bayar : '.$cara_bayar);
			
			$no = 1;
				
			if ($id_dokter=="SEMUA") {
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Dokter');
				$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Tanggal');
				$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Nama');
				$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Ruang');
				$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Tindakan');
				$objPHPExcel->getActiveSheet()->SetCellValue('H5', 'Instalasi');
				$objPHPExcel->getActiveSheet()->SetCellValue('I5', 'Biaya');
				$rowCount = 5;
				
				foreach($dokter as $row1){ 

					$array = json_decode(json_encode($datakeu_dokter), True);
					$data_id_dokter=array_column($array, 'id_dokter');
					
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_dokter, $data_id_dokter)) {		
						
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						
						$setdokter=0;
						$total=0;
						foreach($datakeu_dokter as $row2){
							if ($row2->id_dokter==$row1->id_dokter) {
								$rowCount++;
								$total+=$row2->vtot;
								
								if ($setdokter==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row2->nm_dokter);
									$setdokter=1;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->tgl);
								$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$rowCount, $row2->no_cm,PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->nama);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->idrg);
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row2->nmtindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row2->instalasi);
								$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format( $row2->vtot, 2 , ',' , '.' ))
									->getStyle('I'.$rowCount)
									->getAlignment()
									->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							}
						}
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Total')
							->getStyle('H'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, number_format( $total, 2 , ',' , '.' ))
							->getStyle('I'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
					}
				}
				  
			} else {
			
				//get nama dokter
				$nm_dokter=$this->Rjmlaporan->get_nm_dokter($id_dokter)->row()->nm_dokter;
			
				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Dokter : '.$nm_dokter);
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A6', 'Tanggal');
				$objPHPExcel->getActiveSheet()->SetCellValue('B6', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('C6', 'Nama');
				$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Ruang');
				$objPHPExcel->getActiveSheet()->SetCellValue('E6', 'Tindakan');
				$objPHPExcel->getActiveSheet()->SetCellValue('F6', 'Instalasi');
				$objPHPExcel->getActiveSheet()->SetCellValue('G6', 'Biaya');
				$rowCount = 6;
				
				$i=1;
				$total=0;
				foreach($datakeu_dokter as $row2){
					$rowCount++;
					$total+=$row2->vtot;
					
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row2->tgl);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $row2->no_cm,PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->nama);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->idrg);
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->nmtindakan);
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->instalasi);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format( $row2->vtot, 2 , ',' , '.' ))
						->getStyle('G'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}
			
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Total')
					->getStyle('F'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format( $total, 2 , ',' , '.' ))
					->getStyle('G'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
				
			}
			
			header('Content-Disposition: attachment;filename="'.$file_name.'"');  
					
			// Rename worksheet (worksheet, not filename)  
			$objPHPExcel->getActiveSheet()->setTitle('Pendapatan Dokter ');  
	   
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
		
		} else{
			redirect('irj/Rjclaporan/lapkeu_dokter','refresh');
		}
	}
	
}
?>
