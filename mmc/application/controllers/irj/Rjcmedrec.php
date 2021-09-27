 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');

include('Rjcterbilang.php');

class rjcmedrec extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('irj/rjmmedrec','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
		$this->load->model('irj/rjmpelayanan','',TRUE);
		$this->load->helper('pdf_helper');
	}
	public function index()
	{
		redirect('irj/rjcregistrasi');
	}
	
	public function list_medrec()
	{
		$data['title'] = 'Data Medical Record Pasien Rawat Jalan';
		
		$data['tgl_kunj']='';
		$data['ceklist_diag']='';
		
		//get medrec max 7 hari
		$int_date=date('Y-m-d', strtotime('-90 days'));
		$data['medrec']=$this->rjmmedrec->get_medrec($int_date)->result();
		
		/*$data['pasien_daftar']=$this->rjmpencarian->get_pasien_daftar_today($id_poli)->result();
		$get_nm_poli=$this->rjmpencarian->get_nm_poli($id_poli)->result();
		foreach($get_nm_poli as $row){
			$data['nm_poli']=$row->nm_poli;
		}
		$data['id_poli']=$id_poli;
		if(sizeof($data['pasien_daftar'])==0){
			$this->session->set_flashdata('message_nodata','<div class="row">
						<div class="col-md-12">
						  <div class="box box-default box-solid">
							<div class="box-header with-border">
							  <center>Tidak ada lagi data</center>
							</div>
						  </div>
						</div>
					</div>');
		}else{
			$this->session->set_flashdata('message_nodata','');
		}
		*/
		
		$this->load->view('irj/rjvmedrec',$data);
	}
	
	public function search_list_medrec()
	{
		$data['tgl_kunj']=$this->input->post('tgl_kunj');
		$data['ceklist_diag']=$this->input->post('ceklist_diag');
		
		$data['medrec']=$this->rjmmedrec->get_medrec_by_search($data['tgl_kunj'],$data['ceklist_diag'])->result();
		
		if(sizeof($data['medrec'])==0){
			$this->session->set_flashdata('message_nodata','<div class="row">
						<div class="col-md-12">
						  <div class="box box-default box-solid">
							<div class="box-header with-border">
							  <center>Tidak ada lagi data</center>
							</div>
						  </div>
						</div>
					</div>');
		}else{
			$this->session->set_flashdata('message_nodata','');
		}
		
		$data['title'] = 'Data Medical Record Pasien Rawat Jalan';
		
		$this->load->view('irj/rjvmedrec',$data);
	}
	
	public function list_kunj_medrec()
	{
		$data['title'] = 'Data Kunjungan Poli Pasien Rawat Jalan';

		$dateawal=$this->input->post('date0');
		$dateakhir=$this->input->post('date1');
		$data['tgl_awal']=date('d-m-Y', strtotime($dateawal));
		$data['tgl_akhir']=date('d-m-Y', strtotime($dateakhir));
		if($dateawal=='' && $dateakhir=='')
		{
			$data['tgl_awal']=date('d-m-Y', strtotime('-7 days', time()));
			$dateawal=date('Y-m-d', strtotime('-7 days', time()));
			$dateakhir=date('Y-m-d');
			$data['tgl_akhir']=date('d-m-Y');
		}
					
		$data['data_kunj_pasien']=$this->rjmmedrec->getdata_kunj_poli_pasien($dateawal,$dateakhir)->result();		
		$this->load->view('irj/rjvkunjmedrec',$data);
	}

	public function list_diagnosa($no_register)
	{
		$data['title'] = 'Data Diagnosa Pasien Rawat Jalan';
		$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		
		$data['diagnosa']=$this->rjmpencarian->get_diagnosa()->result();
		$data['data_diagnosa_pasien']=$this->rjmmedrec->getdata_diagnosa_pasien($data['data_pasien_daftar_ulang']->no_register)->result();
		
		$this->load->view('irj/rjvmedrecdiagnosa',$data);
	}

	public function lap_medrec()
	{		
		/*$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		
		$data['diagnosa']=$this->rjmpencarian->get_diagnosa()->result();
		$data['data_diagnosa_pasien']=$this->rjmmedrec->getdata_diagnosa_pasien($data['data_pasien_daftar_ulang']->no_register)->result();*/
		$dateawal=$this->input->post('date0');
		$dateakhir=$this->input->post('date1');
		$data['tgl_awal']=date('d-m-Y', strtotime($dateawal));
		$data['tgl_akhir']=date('d-m-Y', strtotime($dateakhir));
		$data['id_poli']=$this->input->post('id_poli');		
		if($data['id_poli']=='SEMUA' || $data['id_poli']==''){
			$data['poli']="SEMUA";
			$data['id_poli']="SEMUA";
		}else{
			$select_poli = explode("@", $this->input->post('id_poli'));
			$data['id_poli']=$select_poli[0];
			$data['poli']='<b>'.$select_poli[1].'</b>';
		}
					
		$data['select_poli']=$this->rjmpencarian->get_poliklinik()->result();
		if($dateawal=='' && $dateakhir=='')
		{
			$data['tgl_awal']=date('d-m-Y', strtotime('-7 days', time()));
			$dateawal=date('Y-m-d', strtotime('-7 days', time()));
			$dateakhir=date('Y-m-d');
			$data['tgl_akhir']=date('d-m-Y');
		}
		$data['title'] = 'Data Pasien Pulang Rawat Jalan';
		$data['list_medrec']=$this->rjmmedrec->getdata_diagnosa_pulang_pasien_date($dateawal,$dateakhir,$data['id_poli'])->result();
		$this->load->view('irj/rjvlapmedrecpulang',$data);
	}
	
	public function insert_diagnosa()
	{
		$data['klasifikasi_diagnos']=$this->input->post('klasifikasi_diagnos');
		$data['tgl_kunjungan']=$this->input->post('tgl_kunjungan');
		$data['no_register']=$this->input->post('no_register');
		
		if ($data['klasifikasi_diagnos']=="utama") 
		{
			//cek diagnosa utama 
			$cek_diagnosa_utama=$this->rjmpelayanan->cek_diagnosa_utama($data['no_register'])->row();
			$jumlah_diag_utama=$cek_diagnosa_utama->jumlah;
			//echo  $jumlah_diag_utama;
			if ($jumlah_diag_utama==1) 
			{
				$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>
									Diagnosa utama untuk no register "'.$data['no_register'].'" sudah terdaftar.
									</h4>
								</div>
							</div>
						</div>';
				$this->session->set_flashdata('success_msg', $success);
				
			} else {
			
				$diagnosa = explode("@", $this->input->post('diagnosa'));
				$data['id_diagnosa']=$diagnosa[0];
				$data['diagnosa']=$diagnosa[1];
				$id=$this->rjmpelayanan->insert_diagnosa($data);

			}
		}
		else //jika klasifikasi diagnosa==tambahan
		{
			$diagnosa = explode("@", $this->input->post('diagnosa'));
			$data['id_diagnosa']=$diagnosa[0];
			$data['diagnosa']=$diagnosa[1];
			$id=$this->rjmpelayanan->insert_diagnosa($data);
			
		}
		
		redirect('irj/rjcmedrec/list_diagnosa/'.$data['no_register']);
	}
	
	public function hapus_diagnosa($no_register='', $id_diagnosa_pasien='')
	{	
		$id=$this->rjmpelayanan->hapus_diagnosa($id_diagnosa_pasien);
	
		redirect('irj/rjcmedrec/list_diagnosa/'.$no_register);
	}
	//////////////////////////////////////////////////////////////////////
	public function cetak_pdf0($date='', $diag='')
	{
		//$data['title'] = 'Instalasi Rawat Darurat';
			$namars=$this->config->item('namars');
			$alamat=$this->config->item('alamat');
			$kota_kab=$this->config->item('kota');
			
			

			//set timezone
			date_default_timezone_set("Asia/Bangkok");			
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl=date("d-m-Y");
			
			if($date==''){
				$date_title=date('d F Y', strtotime('-7 days')).' s/d '.date('d F Y');
				$int_date=date('Y-m-d', strtotime('-7 days'));
				$data_pulang=$this->rjmmedrec->get_medrec($int_date,$diag)->result();
			}else{
				$date_title=date('d F Y', strtotime($date));
				$data_pulang=$this->rjmmedrec->get_medrec_by_search($date,$diag)->result();
			}
			
			if($diag!=''){
				$ket_diag='Diagnosa Kosong';
			}else $ket_diag='';
			
			foreach($data_pulang as $row){
			$konten="<table>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><br><b>Laporan Pasien Pulang IRJ</b></p></td>
							</tr>
							<tr>
								<td>$namars</td>
							</tr>
						</table>
						<hr>
						<table >							
							<tr>
								<td width=\"10%\"><b>Tanggal</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>
							$ket_diag
						</table>
						<br>
						<hr/>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td width=\"5%\"><b>No</b></td>
								<td width=\"12%\"><b>Tanggal Kunjungan</b></td>
								<td width=\"20%\"><b>No Medrec</b></td>
								<td width=\"13%\"><b>No Registrasi</b></td>
								<td width=\"15%\"><b>Nama</b></td>
								<td width=\"5%\"><b>JK</b></td>
								<td width=\"5%\"><b>Usia</b></td>
								<td width=\"25%\"><b>Diagnosa Utama</b></td>
								
							</tr>
			";							
							// print_r($pasien_daftar);
								$i=1;
								foreach($data_pulang as $row){
									
									$konten = $konten."
									<tr>
										<td width=\"5%\">".$i++."</td>
										<td width=\"12%\">".date("d-m-Y", strtotime($row->tgl_kunjungan))." | ". date("h:m", strtotime($row->tgl_kunjungan))."</td>
										<td width=\"20%\">".$row->no_cm."</td>
										<td width=\"13%\">".$row->no_register."</td>
										<td width=\"15%\">".strtoupper($row->nama)."</td>
										<td width=\"5%\">".$row->sex."</td>
										<td width=\"5%\">".$row->usia."</td>
										<td width=\"25%\">".$row->diag_utama."</td>						
									</tr>";
									
								}
								$konten=$konten."
								<tr>
								<th colspan=\"7\" bgcolor=\"#cdd4cb\"><p align=\"right\"><b>Total   </b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".($i-1)."</p></th>
							</tr>
							</table>";
							
			}
			$file_name="IRJ_pulang_".$tgl."_".$diag.".pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->setPrintHeader(false); //To remove first line on the top
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->SetHeaderData('', '', $title, '');
					$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
					$obj_pdf->SetDefaultMonospacedFont('helvetica');
					$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
					$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
					$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '20', PDF_MARGIN_RIGHT);
				$obj_pdf->SetMargins('5', '5', '5');//left top right
				$obj_pdf->SetAutoPageBreak(TRUE, '15');
				$obj_pdf->SetFont('helvetica', '', 7);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/irj/rjlaporan/'.$file_name, 'FI');		
	}
	
	public function export_excel($date='', $diag=''){
		
		$data['title'] = 'Laporan Pasien Pulang Rawat Jalan';
		
		$namars=$this->config->item('namars');
		$alamat=$this->config->item('alamat');
		$kota_kab=$this->config->item('kota');
			
		$data_pulang=$this->rjmmedrec->get_medrec_by_search($date,$diag)->result();
		
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();
		
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Laporan Pasien IRD ".$namars)  
		        ->setSubject("Laporan Pasien IRD ".$namars." Document")  
		        ->setDescription("Laporan Pasien IRD ".$namars." for Office 2007 XLSX, generated by HMIS.")  
		        ->setKeywords($namars)  
		        ->setCategory("Laporan Pasien IRD");  
		
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);
		
		if($date==''){
				$date_title=date('d F Y', strtotime('-7 days')).' s/d '.date('d F Y');
				$int_date=date('Y-m-d', strtotime('-7 days'));
				$data_pulang=$this->rjmmedrec->get_medrec($int_date,$diag)->result();
			}else{
				$date_title=date('d F Y', strtotime($date));
				$data_pulang=$this->rjmmedrec->get_medrec_by_search($date,$diag)->result();
			}
			
			if($diag!=''){
				$ket_diag='Diagnosa Kosong';
			}else $ket_diag='';
			
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_plg_ird_tgl.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
				// Add some data  
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
		$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$date_title);
		$objPHPExcel->getActiveSheet()->SetCellValue('A3', $ket_diag);
		
		$i=1;
		$rowCount = 5;
		foreach($data_pulang as $row){
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, date("d-m-Y", strtotime($row->tgl_kunjungan))." | ". date("h:m", strtotime($row->tgl_kunjungan)));
			$objPHPExcel->getActiveSheet()->
				setCellValueExplicit(
				'C'.$rowCount, 
				$row->no_cm, 
				PHPExcel_Cell_DataType::TYPE_STRING
			);
			//SetCellValue('B'.$rowCount, $row->no_medrec);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->no_register);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, strtoupper($row->nama));
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->sex);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->usia);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->diag_utama);			
			$i++;
			
			$rowCount++;
		}
		
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, ($i-1));
				$objPHPExcel->getActiveSheet()->getStyle('H'.$rowCount)->applyFromArray(
				    array(
					'fill' => array(
					    'type' => PHPExcel_Style_Fill::FILL_SOLID,
					    'color' => array('rgb' => 'C1B2B2')
					)
				    )
				);
				
				if($date==''){
					$date=date('Y-m-d');
				}
				
		header('Content-Disposition: attachment;filename="Lap_plg_IRJ_TGL_'.$date.'.xlsx"');  
				
		$objPHPExcel->getActiveSheet()->setTitle($namars);  
		   		   		   
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
	
	public function export_excel3($param1='', $param2='',$param3='')
	{
		$data['title'] = 'Data Pasien Pulang Rawat Jalan';

		require_once(APPPATH.'controllers/Tglindo.php');

		$tgl_indo=new Tglindo();
		

		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		//print_r($tampil);
		// $data_rs=$this->ModelKwitansi->getdata_rs('10000')->result();
		// foreach($data_rs as $row){
		// 	$namars=$row->namars;
		// 	$alamat=$row->alamat;
		// 	$kota_kab=$row->kota;
		// }
			$namars=$this->config->item('namars');
			$alamat=$this->config->item('alamat');
			$kota_kab=$this->config->item('kota');
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Laporan ".$namars);  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);


		////		
			if($param1!='' && $param2!=''){				
				$tgl=$param1;
				$tgl3=$param2;
				$tgl1 = date('d F Y', strtotime($tgl));		
				$tgl2 = date('d F Y', strtotime($tgl3));	
				$dateawal= date('Y-m-d', strtotime($tgl));
				$dateakhir= date('Y-m-d', strtotime($tgl3));
				$data_laporan_kunj=$this->rjmmedrec->getdata_diagnosa_pulang_pasien_date($dateawal,$dateakhir,$param3)->result();
				//$data_keuangan=$this->ModelLaporan->get_data_keuangan_tgl($tgl)->result();
					
				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_irj_plg_tgl.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  
				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$tgl1.' s/d '.$tgl2);

				$vtot1=0;$vtot2=0;
				$i=1;
				$rowCount = 5;

				foreach($data_laporan_kunj as $row){
					$no_register=$row->no_register;
					if($row->cara_bayar=="UMUM"){
						$cb=$row->cara_bayar;
					}else {
						if($row->cara_bayar=='DIJAMIN'){
						$cb= $row->cara_bayar.' - '.$row->nmkontraktor;
						}else 
						$cb=$row->nmkontraktor;
					}
					$j=1;		
					 
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								
								$objPHPExcel->getActiveSheet()->
								setCellValueExplicit(
									'B'.$rowCount, 
									$row->no_cm, 
									PHPExcel_Cell_DataType::TYPE_STRING
								    );
//SetCellValue('B'.$rowCount, $row->no_medrec);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_register);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->jns_kunj);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->nama);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->sex);
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->usia);
								$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->poli);
								$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->icd);
								$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->diag_baru);
								$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->diag_lama);
								$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $cb);
								$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->pangkat);
								$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->kesatuan);
								$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row->no_nrp.' '.$row->hub_name);


							 	$i++;
							 								
						$rowCount++;
						// if
					
				}

				/*foreach($data_laporan_keu as $row){
					$no_register=$row->no_register;
					$j=1;		
					foreach($data_keuangan as $row2){
						if ($row2->no_register==$no_register) {
							$vtot1=$vtot1+$row2->vtot;
							if($j==1){ 
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->no_medrec);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_register);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->nama);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->nm_dokter);
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row2->vtot);
							 	$i++;
							 } else { 
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->nm_dokter);
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row2->vtot);
							 }
						$j++;
						$rowCount++;
						} // if
					}
				}*/
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, 'Total Kunjungan');
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, ($i-1));
				$objPHPExcel->getActiveSheet()->getStyle('M'.$rowCount)->applyFromArray(
				    array(
					'fill' => array(
					    'type' => PHPExcel_Style_Fill::FILL_SOLID,
					    'color' => array('rgb' => 'C1B2B2')
					)
				    )
				);
				
				header('Content-Disposition: attachment;filename="Lap_IRJ_PLG_TGL_'.$tgl.'_'.$tgl3.'.xlsx"');  
					
			}else{
				redirect('irj/rjcmedrec/lap_medrec','refresh');
			}
		

		// Rename worksheet (worksheet, not filename)  
		$objPHPExcel->getActiveSheet()->setTitle($namars);  
		   
		   
		   
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

	public function export_excel4($param1='', $param2='')
	{
		$data['title'] = 'Laporan Kunjungan Poli Pasien Pulang Rawat Jalan';

		require_once(APPPATH.'controllers/Tglindo.php');

		$tgl_indo=new Tglindo();		

		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		//print_r($tampil);
		// $data_rs=$this->ModelKwitansi->getdata_rs('10000')->result();
		// foreach($data_rs as $row){
		// 	$namars=$row->namars;
		// 	$alamat=$row->alamat;
		// 	$kota_kab=$row->kota;
		// }
			$namars=$this->config->item('namars');
			$alamat=$this->config->item('alamat');
			$kota_kab=$this->config->item('kota');
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Laporan ".$namars);  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);


		////		
			if($param1!='' && $param2!=''){				
				$tgl=$param1;
				$tgl3=$param2;
				$tgl1 = date('d F Y', strtotime($tgl));		
				$tgl2 = date('d F Y', strtotime($tgl3));	
				$dateawal= date('Y-m-d', strtotime($tgl));
				$dateakhir= date('Y-m-d', strtotime($tgl3));
				$data_laporan_kunj=$this->rjmmedrec->getdata_kunj_poli_pasien($dateawal,$dateakhir)->result();
				//$data_keuangan=$this->ModelLaporan->get_data_keuangan_tgl($tgl)->result();
					
				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_irj_poli_tgl.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  
				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$tgl1.' s/d '.$tgl2);

				$vtot1=0;$vtot2=0;$vtot3=0;$vtot4=0;$vtot5=0;$vtot6=0;
				$vtotpsn=0;$vtottotal=0;
				$vtotbaru=0;$vtotlama=0;
				$i=1;
				$rowCount = 5;

				foreach($data_laporan_kunj as $row){
								$vtot1=$vtot1+$row->MIL;
								$vtot2=$vtot2+$row->PNS;
								$vtot3=$vtot3+$row->NONAL;
								$vtot4=$vtot4+$row->KEL;
								$vtot5=$vtot5+$row->BPJSUMUM;
								$vtot6=$vtot6+$row->UMUM;
								$vtotpsn=$row->MIL+$row->PNS+$row->NONAL+$row->KEL+$row->BPJSUMUM+$row->UMUM;
								$vtottotal=$vtottotal+$vtotpsn;
								$vtotbaru=$vtotbaru+$row->baru;
								$vtotlama=$vtotlama+$row->lama;
					$j=1;		
					 
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,$row->nm_poli);
//SetCellValue('B'.$rowCount, $row->no_medrec);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->baru);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->lama);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->MIL);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->PNS);
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->KEL);
								$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->NONAL);
								$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->BPJSUMUM);
								$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->UMUM);
								$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $vtotpsn);
							 	$i++;
							 								
						$rowCount++;
						// if
					
				}

				/*foreach($data_laporan_keu as $row){
					$no_register=$row->no_register;
					$j=1;		
					foreach($data_keuangan as $row2){
						if ($row2->no_register==$no_register) {
							$vtot1=$vtot1+$row2->vtot;
							if($j==1){ 
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->no_medrec);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_register);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->nama);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->nm_dokter);
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row2->vtot);
							 	$i++;
							 } else { 
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->nm_dokter);
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row2->vtot);
							 }
						$j++;
						$rowCount++;
						} // if
					}
				}*/
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtotbaru);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtotlama);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtot1);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtot2);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $vtot4);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $vtot3);				
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $vtot5);
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $vtot6);
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $vtottotal);
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtot1+$vtot2+$vtot3+$vtot4+$vtot5+$vtot6);
				header('Content-Disposition: attachment;filename="Lap_IRJ_POLI_TGL_'.$tgl.'_'.$tgl3.'.xlsx"');  
					
			}else{
				redirect('irj/rjcmedrec/list_kunj_medrec','refresh');
			}
		

		// Rename worksheet (worksheet, not filename)  
		$objPHPExcel->getActiveSheet()->setTitle($namars);  
		   
		   
		   
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

	function cetak_pdf($param1='',$param2='')
	{

		if($param1!='' && $param2!=''){
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");
			$dateawal=date('Y-m-d',strtotime($param1));
			$dateakhir=date('Y-m-d',strtotime($param2));
					$namars=$this->config->item('namars');
					$kota_kab=$this->config->item('kota');
					$alamatrs=$this->config->item('alamat');
					$nmsingkat=$this->config->item('namasingkat');

			$data_pasien=$this->rjmmedrec->getdata_diagnosa_pulang_pasien_date($dateawal,$dateakhir)->result();					
			$style='';
			$konten="<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					.table-font-size1{
						font-size:12px;
					    }
					</style>
					
					<table class=\"table-font-size\" border=\"0\">
						<tr>
							<td colspan=\"3\"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p></td>
						</tr>
						<tr>
							<td colspan=\"3\"><p align=\"center\"><br><b>Data Pasien Pulang Rawat Jalan</b></p></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td width=\"10%\"><b>Tanggal</b></td>
							<td width=\"5%\">:</td>
							<td width=\"75%\">$param1 s/d $param2</td>
						</tr>
					
					<br/>";
			
			//$data_tindakan=$this->rjmkwitansi->getdata_unpaid_tindakan_pasien($no_register)->result();
			//print_r($data_tindakan);
			$konten=$konten."<table border=\"1\" style=\"padding:2px\">
						<tr>
							<th width=\"3%\"><p align=\"center\"><b>No</b></p></th>
							<th width=\"5%\"><p align=\"center\"><b>No MR</b></p></th>
							<th width=\"8%\"><p align=\"center\"><b>No Register</b></p></th>
							<th width=\"5%\"><p align=\"center\"><b>Kunjungan</b></p></th>
							<th width=\"15%\"><p align=\"center\"><b>Nama</b></p></th>
							<th width=\"3%\"><p align=\"center\"><b>JK</b></p></th>
							<th width=\"4%\"><p align=\"center\"><b>Usia</b></p></th>
							<th width=\"10%\"><p align=\"center\"><b>Poli</b></p></th>
							<th width=\"5%\"><p align=\"center\"><b>ICD</b></p></th>
							<th width=\"10%\"><p align=\"center\"><b>Diagnosa Baru</b></p></th>
							<th width=\"10%\"><p align=\"center\"><b>Diagnosa Lama</b></p></th>
							<th width=\"10%\"><p align=\"center\"><b>Jenis Pasien</b></p></th>
							<th width=\"6%\"><p align=\"center\"><b>Pangkat</b></p></th>
							<th width=\"6%\"><p align=\"center\"><b>Kesatuan</b></p></th>
						</tr>
						";
				$i=1;
				foreach($data_pasien as $row){
					if($row->cara_bayar!="BPJS"){
						$cb=$row->cara_bayar;
					}else {
						$cb=$row->nmkontraktor;
					}
					$konten=$konten."
					<tr>
						<td>".($i++)."</td>
						<td>".$row->no_cm."</td>
						<td>".$row->no_register."</td>
						<td>".$row->jns_kunj."</td>
						<td>".strtoupper($row->nama)."</td>
						<td>".strtoupper($row->sex)."</td>
						<td>".$row->usia."</td>
						<td>".strtoupper($row->poli)."</td>
						<td>".$row->icd."</td>
						<td>".$row->diag_baru."</td>
						<td>".$row->diag_lama."</td>
						<td>".$cb."</td>
						<td>".$row->pangkat."</td>
						<td>".$row->kesatuan."</td>
						</tr>";
					}
			$konten1=$konten."
						<tr>
							<th colspan=\"13\"><p align=\"right\"><b>Total   </b></p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">".($i-1)."</p></th>
						</tr>
					</table>
					<br/><br/>
					";
				$file_name="Daftar_irj_plg_".$param1."_".$param2.".pdf";			
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				//header("Content-type: application-download");
				tcpdf();			
				$obj_pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);		
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setPrintHeader(false);
				$obj_pdf->setPrintFooter(true);
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
				$obj_pdf->SetAutoPageBreak(TRUE, '15');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten1;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/irj/rjmedrec/'.$file_name, 'FI');
				//header('Content-Disposition: attachment;filename="'.$file_name.'"');
				//$obj_pdf->Output($file_name, 'FD');
		}else{
			redirect('irj/rjcmedrec/lap_medrec','refresh');
		}
	}
}
?>
