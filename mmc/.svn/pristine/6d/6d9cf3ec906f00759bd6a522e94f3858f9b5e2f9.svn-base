<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
class IrDMedrec extends Secure_area {
	public function __construct() {
			parent::__construct();
			$this->load->model('ird/ModelPelayanan','',TRUE);
			$this->load->model('ird/ModelRegistrasi','',TRUE);
			$this->load->model('ird/ModelMedrec','',TRUE);
			$this->load->helper('pdf_helper');
		}
	public function index()
	{
		if($this->input->post('date')=='')
		{
			
			$date='';
			
		}else
			$date=$this->input->post('date');
		
		if($this->input->post('cek')=='0')
		{			
			$diag='0';	
				
		}else   $diag='';
		//echo $this->input->post('cek');
		//$diag='';
		$data['pasien_daftar']=$this->ModelMedrec->get_pasien_pulang($date,$diag)->result();
		//print_r($data['pasien_daftar']);
		$data['date'] = $date;
		$data['diag'] = $diag;
		$data['title'] = 'Diagnosa Pulang Instalasi Rawat Darurat';

		$this->load->view('ird/list_diagnosa_pulang',$data);
	}
	public function search_pasien()
	{
		$data['no_medrec']=$this->input->post('no_medrec');
		redirect('ird/IrDRegistrasi/index2/'.$data['no_medrec']);
	}

	public function pelayanan_diagnosa($no_register)
	{
				
		//echo $no_register;
		$data['data_pasien_daftar_ulang']=$this->ModelPelayanan->getdata_daftar_ulang_pasien($no_register)->result();
		
		$data['data_diagnosa_pasien']=$this->ModelPelayanan->getdata_diagnosa_pasien($no_register)->result();
		//print_r($data);
		$data['diagnosa']=$this->ModelRegistrasi->get_data_diagnosa()->result();//untuk select
		// $data['id_poli']=$id_poli;
		$data['activetabD']='active';
		$data['no_register']=$no_register;
		$data['title'] = 'Instalasi Rawat Darurat';
		
		$this->load->view('ird/form_diagnosa_pulang',$data);
		// echo "goto form";
	}

	public function insert_pelayanan_diagnosa()
	{
						
		$data['no_register']=$this->input->post('no_register');
		echo $data['no_register'];
		$diagnosa = explode("@", $this->input->post('jenis_diagnosa'));
		//print_r($diagnosa);
		$data['id_diagnosa']=$diagnosa[0];
		$data['diagnosa']=$diagnosa[1];

		$data['klasifikasi_diagnos']=$this->input->post('klasifikasi');
		if ($data['klasifikasi_diagnos']=="utama") 
		{
		 if($this->ModelPelayanan->cek_diagnosa_utama($data['no_register'])->num_rows()>0){
			$success = 	'
						<section class="content-header">
							
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>
									Diagnosa utama untuk no register "'.$data['no_register'].'" sudah terdaftar.
									</h4>
								</div>
							
						</section>';
			$this->session->set_flashdata('success_msg', $success);			
		 	redirect('ird/IrDMedrec/pelayanan_diagnosa/'.$data['no_register']);
		 }else {
		 	$id=$this->ModelPelayanan->insert_pelayanan_diagnosa($data);
			//print_r($data);
			redirect('ird/IrDMedrec/pelayanan_diagnosa/'.$data['no_register']);
		 }
		}
		else{
			$id=$this->ModelPelayanan->insert_pelayanan_diagnosa($data);
			//print_r($data);
			$tab="diagnosa";
			redirect('ird/IrDMedrec/pelayanan_diagnosa/'.$data['no_register']);
		}

		//$data['diagnosa']=$this->ModelPelayanan->get_nm_diagnosa($this->input->post('id_diagnosa'))->result();		
				
		
	}
	
	
	public function cetak_pdf($date='', $diag='')
	{
		//$data['title'] = 'Instalasi Rawat Darurat';
			$namars=$this->config->item('namars');
			$alamat=$this->config->item('alamat');
			$kota_kab=$this->config->item('kota');
			
			$data_pulang=$this->ModelMedrec->get_pasien_pulang($date,$diag)->result();

			//set timezone
			date_default_timezone_set("Asia/Bangkok");			
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl=date("d-m-Y");
			
			if($date==''){
				$date_title=date('d F Y', strtotime('-7 days')).' s/d '.date('d F Y');
			}else
				$date_title=date('d F Y', strtotime($date));
			
			if($diag!=''){
				$ket_diag='Diagnosa Kosong';
			}else $ket_diag='';
			
			foreach($data_pulang as $row){
			$konten="<table>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><br><b>Laporan Pasien Pulang IRD</b></p></td>
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
								<td width=\"25%\"><b>Diagnosa Utama</b></td>
								<td width=\"25%\"><b>Nama</b></td>
							</tr>
			";							
							// print_r($pasien_daftar);
								$i=1;
								foreach($data_pulang as $row){
									
									$konten = $konten."
									<tr>
										<td width=\"5%\">".$i++."</td>
										<td width=\"12%\">".date("d-m-Y", strtotime($row->tgl_kunjungan))." | ". date("h:m", strtotime($row->tgl_kunjungan))."</td>
										<td width=\"20%\">".$row->no_medrec."</td>
										<td width=\"13%\">".$row->no_register."</td>
										<td width=\"25%\">".$row->diag_utama."</td>
										<td width=\"25%\">".strtoupper($row->nama)."</td>
									</tr>";
									
								}
								$konten=$konten."
								<tr>
								<th colspan=\"5\" bgcolor=\"#cdd4cb\"><p align=\"right\"><b>Total   </b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".($i-1)."</p></th>
							</tr>
							</table>";
							
			}
			$file_name="IRD_pulang_$date".$diag.".pdf";
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
				$obj_pdf->Output(FCPATH.'download/ird/rdlaporan/'.$file_name, 'FI');		
	}
	
	public function export_excel($date='', $diag=''){
		
		$data['title'] = 'Laporan Pasien Pulang Rawat Darurat';
		
		$namars=$this->config->item('namars');
		$alamat=$this->config->item('alamat');
		$kota_kab=$this->config->item('kota');
			
		$data_pulang=$this->ModelMedrec->get_pasien_pulang($date,$diag)->result();
		
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
			}else
				$date_title=date('d F Y', strtotime($date));
			
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
				$row->no_medrec, 
				PHPExcel_Cell_DataType::TYPE_STRING
			);
			//SetCellValue('B'.$rowCount, $row->no_medrec);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->no_register);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->diag_utama);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->nama);
			$i++;
			
			$rowCount++;
		}
		
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, ($i-1));
				$objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->applyFromArray(
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
				
		header('Content-Disposition: attachment;filename="Lap_plg_IRD_TGL_'.$date.'.xlsx"');  
				
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
	
	public function data_kotakab($id_prop='',$sid='')
	{
		$data=$this->ModelAlamat->get_kotakab($id_prop)->result();
			echo "<option selected value=''>Pilih Kota/Kabupaten</option>";
			foreach($data as $row){
				echo "<option value='$row->id-$row->nama'>$row->nama</option>";
			}
	}
	public function data_kecamatan($id_kabupaten='',$sid='')
	{
		$data=$this->ModelAlamat->get_kecamatan($id_kabupaten)->result();
			echo "<option selected value=''>Pilih Kecamatan</option>";
			foreach($data as $row){
				echo "<option value='$row->id-$row->nama'>$row->nama</option>";
			}
	}
	public function data_kelurahan($id_kecamatan='',$sid='')
	{
		$data=$this->ModelAlamat->get_kelurahan($id_kecamatan)->result();
			echo "<option selected value=''>Pilih Kelurahan</option>";
			foreach($data as $row){
				echo "<option value=$row->id-$row->nama'>$row->nama</option>";
			}
	}
	public function data_pasien(){
			$keyword = $this->uri->segment(4);
			$data = $this->db->from('data_pasien')->like('no_medrec',$keyword)->get()->result();	

			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->no_medrec,
					'no_medrec'	=>$row->no_medrec
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}
	public function data_kecelakaan(){
			// tangkap variabel keyword dari URL
			$keyword = $this->uri->segment(4);
			// cari di database
			$data = $this->db->from('kecelakaan_ird')->like('id',$keyword)->get()->result();	

			// format keluaran di dalam array
			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->id,
					'id'	=>$row->id,
					'nm_kecelakaan'	=>$row->nm_kecelakaan
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}

	public function data_ruang(){
			// tangkap variabel keyword dari URL
			$keyword = $this->uri->segment(4);
			// cari di database
			$data = $this->db->from('ruang')->like('idrg',$keyword)->get()->result();	

			// format keluaran di dalam array
			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->idrg,
					'id'	=>$row->idrg,
					'nm_ruang'	=>$row->nmruang
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}

	public function data_kelas(){
			// tangkap variabel keyword dari URL
			$keyword = $this->uri->segment(4);
			// cari di database
			$data = $this->db->from('kelas')->like('kelas',$keyword)->get()->result();	

			// format keluaran di dalam array
			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->urutan,
					'id'	=>$row->urutan,
					'nm_kelas'	=>$row->kelas
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}
	
	public function data_diagnosa(){
			// tangkap variabel keyword dari URL
			$keyword = $this->uri->segment(4);
			// cari di database
			$data = $this->db->from('icd1')->like('id_icd',$keyword)->get()->result();	

			// format keluaran di dalam array
			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->id_icd,
					'id'	=>$row->id_icd,
					'nama_diagnosa'	=>$row->nm_diagnosa
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}
	
	public function data_kontraktor(){
			// tangkap variabel keyword dari URL
			$keyword = $this->uri->segment(4);
			// cari di database
			$data = $this->db->from('kontraktor')->like('id_kontraktor',$keyword)->get()->result();	
			//$data = $this->db->from('kontraktor')->like('nmkontraktor',$keyword)->get()->result();	
			// format keluaran di dalam array
			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->id_kontraktor,
					'id'	=>$row->id_kontraktor,
					'nm_kontraktor'	=>$row->nmkontraktor
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}

	///////////////////////////////////////////////////
	public function kwitansi()
	{	
		// $data['poliklinik']=$this->ModelRegistrasi->get_poli()->result();//untuk nav
		$data['title'] = 'Instalasi Rawat Darurat';
		 
		$this->load->view('ird/kwitansi',$data);
	}
	public function list_poli()
	{	
		$data['poliklinik']=$this->ModelRegistrasi->get_poli()->result();//untuk nav
		$data['title'] = 'Instalasi Rawat Darurat';
		 
		$this->load->view('ird/list_poli',$data);
	}
	public function pasien_poli()
	{	
		$id_poli=$this->input->post('id_poli');
		redirect('ird/IrjPelayanan/kunj_pasien_poli/'.$id_poli);
	}
}
?>
