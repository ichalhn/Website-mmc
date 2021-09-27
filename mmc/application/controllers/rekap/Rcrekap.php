<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include(dirname(dirname(__FILE__)).'/Tglindo.php');
require_once(APPPATH.'controllers/Secure_area.php');
class Rcrekap extends Secure_area {
	public function __construct(){
		parent::__construct();
		$this->load->model('rekap/Rekap_user');
		$this->load->model('rekap/Rekap_pasien');
		$this->load->helper('url');
		$this->load->model('irj/Rjmpencarian','',TRUE);
		$this->load->model('irj/Rjmpelayanan','',TRUE);
		$this->load->model('irj/Rjmkwitansi','',TRUE);
		$this->load->model('irj/Rjmlaporan','',TRUE);

		$this->load->helper('pdf_helper');
	}
	

	public function log_user_action(){
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		$tgl_awal = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');

		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tgl_awal != '' && $tgl_akhir != '' ){

			//satuan
			// $data['log_user_antrian'] = $this->rimuser->get_log_user_antrian_by_date($tgl_awal,$tgl_akhir);
			// $data['log_user_pasien'] = $this->rimuser->get_log_user_pasien_by_date($tgl_awal,$tgl_akhir);
			// $data['log_user_tindakan_temp'] = $this->rimuser->get_log_user_tindakan_temp_by_date($tgl_awal,$tgl_akhir);
			// $data['log_user_tindakan'] = $this->rimuser->get_log_user_tindakan_by_date($tgl_awal,$tgl_akhir);
			// $data['log_user_mutasi'] = $this->rimuser->get_log_user_mutasi_by_date($tgl_awal,$tgl_akhir);

			//semua
			$data['log_user_tindakan'] = $this->Rekap_user->get_log_user_all($tgl_awal,$tgl_akhir);
			$data['tgl_awal'] = $tgl_awal;
			$data['tgl_akhir'] = $tgl_akhir;
		}

		$this->load->view('rekap/rekaplink');
		// $this->load->view('iri/list_laporan_harian',$data);
		$this->load->view('rekap/list_log_user',$data);
	}


	public function pendapatan(){
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		//bikin object buat penanggalan
		$data['controller']=$this; 

		$tipe_input = $this->input->post('tampil_per');
		$tanggal = $this->input->post('tanggal');
		$jam_masuk = $this->input->post('jam_masuk');
		$tgl_akhir = $this->input->post('tgl_akhir');
		$jam_keluar = $this->input->post('jam_keluar');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$user_biling = $this->input->post('user_biling');

		$data['list_user'] = $this->Rekap_user->get_all_user();
		
		//echo $tipe_input;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tipe_input == ''){
			$tanggal = date("Y-m-d");
			$tgl_akhir = date("Y-m-d");
			$tgl_indo = new Tglindo();
			$data['bulan_show'] = $tgl_indo->bulan(substr($tanggal,6,2));
			$data['tahun_show'] = substr($tanggal,0,4);
			$data['tanggal_show'] = substr($tanggal,8,2);
			// $data['list_keluar_masuk'] = $this->rimpasien->get_total_pendapatan_by_range_date($tgl_awal,$tgl_akhir);
			
			$tgl_awal_gabung = $tanggal." 00:00";
			$tgl_akhir_gabung = $tgl_akhir." 23:59";

			$data['list_pendapatan_poli'] = $this->Rekap_pasien->get_list_pendapatan_poli_by_tanggal($tanggal, $jam_masuk, $jam_keluar);
			

			$bulan_show = $tgl_indo->bulan(substr($tanggal,6,2));
			$tahun_show = substr($tanggal,0,4);
			$tanggal_show = substr($tanggal,8,2);
			$tgl_awal_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show." - ".$jam_masuk."-".$jam_keluar;

			$data['tgl_awal_show'] = "";
			$data['user_show'] = "";
			$data['tanggal'] = $tanggal;
			$data['user'] = $user_biling;
			$data['bulan_input'] = $bulan;
			$data['tahun_input'] = $tahun;
			$data['tipe_input'] = $tipe_input;
			$this->load->view('rekap/rekaplink');
			$this->load->view('rekap/list_pendapatan',$data);
			
		}

		if($tipe_input == 'TGL'){
			$tgl_indo = new Tglindo();
			$data['bulan_show'] = $tgl_indo->bulan(substr($tgl_awal,6,2));
			$data['tahun_show'] = substr($tgl_awal,0,4);
			$data['tanggal_show'] = substr($tgl_awal,8,2);

			
			$tanggal = $tgl_awal." ".$jam_awal;
			
			$data['list_pendapatan_poli'] = $this->Rekap_pasien->get_list_pendapatan_poli_by_tanggal($tanggal, $jam_masuk, $jam_keluar);
			
			$data['tgl_awal'] = $tgl_awal_gabung;
			$data['tgl_akhir'] = $tgl_akhir_gabung;
			$data['user'] = $user_biling;

			$bulan_show = $tgl_indo->bulan(substr($tgl_awal,6,2));
			$tahun_show = substr($tgl_awal,0,4);
			$tanggal_show = substr($tgl_awal,8,2);
			$tgl_awal_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show." - ".$jam_awal;

			$data['tgl_awal_show'] = date('d F Y',strtotime($tgl_awal))." - ".$jam_awal;//$tgl_awal_lengkap;
			$data['tgl_akhir_show'] = date('d F Y',strtotime($tgl_akhir))." - ".$jam_akhir;//$tgl_akhir_lengkap;
			$data['user_show'] = $user_biling;

			$data['bulan_input'] = $bulan;
			$data['tahun_input'] = $tahun;
			$data['tipe_input'] = $tipe_input;
			$this->load->view('rekap/rekaplink');
			$this->load->view('rekap/list_pendapatan',$data);
			
		}

	}


	public function cetak_laporan_harian($tgl_awal=''){
		
		$data_pasien_keluar_tanggal = $this->Rekap_pasien->get_list_pasien_keluar_by_tanggal($tgl_awal);

		//ambil data rs
		//$data_rs = $this->Rekap_kelas->get_data_rs('10000');
		$konten = '<table style="padding:4px;" border="0">
						<tr>
							<td>
								<p align="center">
									<img src="asset/images/logos/"'.$this->config->item('logo_url').'"" alt="img" height="42" >
								</p>
							</td>
						</tr>
					</table>
					<hr><br/><br/>
		<table>
				<tr>
					<td colspan="3"><p align="center"><b>Laporan Keuangan Rawat Inap Tanggal '.$tgl_awal.'</b></p></td>
				</tr>
				<tr>
					<td colspan="3"><p align="center"><b>'.$this->config->item('namars').'</b></p></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				</table>
			<br/>
			<hr/>';
		$konten = $konten.'
		<table >
		<tr>
			<th>Tanggal</th>
			<th>No Registrasi</th>
			<th>Nama Pasien</th>
			<th>Jenis Pembayaran</th>
			<th>Sub Total</th>
			<th>Diskon</th>
			<th>Total Bayar</th>
		</tr>
		';	
	  	$total = 0;
	  	$total_diskon = 0;
	  	$tgl_indo = new Tglindo();

	  	foreach ($data_pasien_keluar_tanggal as $r) {
	  		$bulan_show = $tgl_indo->bulan(substr($r['tgl_keluar'],6,2));
			$tahun_show = substr($r['tgl_keluar'],0,4);
			$tanggal_show = substr($r['tgl_keluar'],8,2);
			$tgl_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show;

	  		$total = $total + $r['vtot'];
	  		$diskon = $r['diskon'];
	  		if($diskon == '' || $diskon == NULL){
	  			$diskon = 0;
	  		}
	  		$total_diskon = $total_diskon + $diskon;
	  		$total_disp_bayar_dan_diskon = number_format($r['vtot'] + $diskon,0);
	  		if($r['jenis_bayar'] == "TUNAI"){
	  			$total_bayar_tunai = $total_bayar_tunai + $r['vtot'];
	  			$total_diskon_tunai = $total_diskon_tunai + $r['diskon'];
	  		}else{
	  			$total_bayar_kredit = $total_bayar_kredit + $r['vtot'];
	  			$total_diskon_kredit = $total_diskon_kredit + $r['diskon'];
	  		}
		$konten = $konten . '
	  	<tr>
	  		<td>'.$tgl_lengkap.'</td>
	  		<td>'.$r['no_ipd'].'</td>
	  		<td>'.$r['nama'].'</td>
	  		<td>'.$r['jenis_bayar'].'</td>
	  		<td align="right">Rp. '.$total_disp_bayar_dan_diskon.' </td>
	  		<td align="right">Rp. '.number_format($diskon,0).'</td>
	  		<td align="right">Rp. '.number_format($r['vtot'],0).'</td>
	  	</tr>
		';
		}
		
		$konten = $konten .'
		  	<tr>
				<td colspan="4" align="right">Total Pembayaran</td>
				<td align="right">Rp. '.$total_disp_all_bayar_dan_diskon.'</td>
				<td align="right">Rp. '.number_format($total_diskon,0).'</td>
				<td align="right">Rp. '.number_format($total,0).'</td>
			</tr>
			<tr>
				<td colspan="4" align="right">Total Tunai</td>
				<td align="right">Rp. '.$total_disp_all_bayar_dan_diskon_tunai.'</td>
				<td align="right">Rp. '.number_format($total_diskon_tunai,0).'</td>
				<td align="right">Rp. '.number_format($total_bayar_tunai,0).'</td>
			</tr>
			<tr>
				<td colspan="4" align="right">Total Kredit</td>
				<td align="right">Rp. '.$total_disp_all_bayar_dan_diskon_kredit.'</td>
				<td align="right">Rp. '.number_format($total_diskon_kredit,0).'</td>
				<td align="right">Rp. '.number_format($total_bayar_kredit,0).'</td>
			</tr>
		</table>
		';


		$file_name = "Rekap_Keuangan_Harian_.pdf";
		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$tgl_cetak = date("j F Y");
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins('5', '5', '5', '5');
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
			$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'/download/rekap/'.$file_name, 'FI');
	}

	//keperluan tanggal
	public function obj_tanggal(){
		 $tgl_indo = new Tglindo();
		 return $tgl_indo;
	}

	public function cetak_laporan_harian_excel($tgl_awal='',$tgl_akhir="",$user=""){
		require_once (APPPATH.'third_party/PHPExcel.php');

      set_time_limit(0);

      $tgl_awal = urldecode($tgl_awal);
      $tgl_akhir = urldecode($tgl_akhir);

      //load our new PHPExcel library
      //$this->load->library('excel');
      //$this->excel = new PHPExcel();

      $excel = PHPExcel_IOFactory::load("./download/rekap/template_pendapatan_harian.xls");

      //activate worksheet number 1
      $excel->setActiveSheetIndex(0);
      //name the worksheet
      $excel->getActiveSheet()->setTitle('Worksheet 1');

      //ambil semua data pendapatan
      $list_keluar_masuk = $this->Rekap_pasien->get_list_pasien_keluar_by_tanggal($tgl_awal,$tgl_akhir,$user);
	$list_keluar_irj = $this->Rekap_pasien->get_list_pasien_keluar_irj_by_tanggal($tgl_awal,$tgl_akhir,$user);
	
	}

	public function excel_lapkeu()
	{
		
		$tampil_per = $this->input->get("tampil_per");
		$id_poli = $this->input->get("id_poli");
		$var1 = $this->input->get("var1");
		$status = $this->input->get("status");
		$cara_bayar = $this->input->get("cara_bayar");

		$id_poli = strtoupper($id_poli);
		$tampil_per = strtoupper($tampil_per);
		$status = strtoupper($status);
		$cara_bayar = strtoupper($cara_bayar);

		require_once (APPPATH.'third_party/PHPExcel.php');

		$title = 'Laporan Keuangan';
		$tgl_indo = new Tglindo();
		if ($id_poli!="SEMUA") {
			$nm_poli=$this->Rjmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		}
		$data_rs=$this->Rjmkwitansi->getdata_rs('10000')->result();
		foreach($data_rs as $row){
			$namars=$row->namars;
			$kota_kab=$row->kota;
		}
		
		////////////////////////////////////////////////////////////EXCEL 
						
		// Create new PHPExcel object  
						
	  $objPHPExcel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_laporan_dokter_excel.xls");

      //activate worksheet number 1
      $objPHPExcel->setActiveSheetIndex(0);
      //name the worksheet
      $objPHPExcel->getActiveSheet()->setTitle('Worksheet 1');
		
		// Add some data  
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $title);
		
		// Add some data  
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $title);
		if ($status=='10') {
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Status : Pulang dan Dirawat');
		} else if ($status=='1') {
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Status : Pulang');
		} else if ($status=='0') {
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Status : Dirawat');		
		}
		$no = 1;
		
		if ($tampil_per=="TGL") {
		 
			$tgl=$var1;
			//nama file----------------------------------
			$tgl1 = date('d-m-Y', strtotime($tgl));
			$date=substr($tgl1,0,2).' '.$tgl_indo->bulan(substr($tgl1,3,2)).' '.substr($tgl1,6,4);
			$date_title = 'Tanggal';
			//-------------------------------------------
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$date);
			
			if ($id_poli=="SEMUA") {
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Nama');
				if ($status=='10') {
					$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Status');
					//$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Biaya Daftar');
					$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Biaya Tindakan');
				} else {
					//$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Biaya Daftar');
					$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Biaya Tindakan');
				}
				$rowCount = 5;

				$file_name="KEU_POLI_$tgl1.xlsx";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_poli_harian($tgl, $status)->result();
			
				foreach($poli as $row1){ 
			
					$array = json_decode(json_encode($data_laporan_keu), True);
					$data_poli=array_column($array, 'id_poli');
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {		
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						
						$setpoli=0;
						$vtot=0;
						//$biayadaftar=0;
						foreach($data_laporan_keu as $row2){
							if ($row2->id_poli==$row1->id_poli) {
							
								$rowCount++;
							
								$vtot+=$row2->vtot;
								//$biayadaftar+=$row2->biayadaftar;
						
								if ($setpoli==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row1->nm_poli);
										$setpoli=1;
								}
								$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $row2->no_medrec,PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->no_register);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->nama);
								if ($status=='10') {
									$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, ($row2->status=="1" ? "Pulang":"Dirawat"));
									$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format( $row2->vtot, 2 , ',' , '.' ))
										->getStyle('G'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								} else {
									$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $row2->vtot, 2 , ',' , '.' ))
										->getStyle('F'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								}
							}

						}
						
						if ($status=='10') {
							$rowCount++;
							$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Total')
								->getStyle('F'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							/*$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
								->getStyle('G'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
							*/
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
								->getStyle('G'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
						
							/*$rowCount++;
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Total Biaya Daftar dan Tindakan')
								->getStyle('G'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
								->getStyle('H'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
							*/
						} else {
							$rowCount++;
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Total')
								->getStyle('E'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							/*$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
								->getStyle('F'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
							$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
								->getStyle('F'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
						
							/*$rowCount++;
							$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Total Biaya Daftar dan Tindakan')
								->getStyle('F'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
								->getStyle('G'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
						}
						
					}
				}
				
			} else { //jika id_poli tidak "SEMUA" u/ tampil_per "TGL"
			
				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Poliklinik : '.$nm_poli);
				$objPHPExcel->getActiveSheet()->SetCellValue('A6', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B6', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('C6', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Nama');
				if ($status=='10') {
					$objPHPExcel->getActiveSheet()->SetCellValue('E6', 'Status');
					//$objPHPExcel->getActiveSheet()->SetCellValue('F6', 'Biaya Daftar');
					$objPHPExcel->getActiveSheet()->SetCellValue('F6', 'Biaya Tindakan');
				} else {
					//$objPHPExcel->getActiveSheet()->SetCellValue('E6', 'Biaya Daftar');
					$objPHPExcel->getActiveSheet()->SetCellValue('E6', 'Biaya Tindakan');
				}
				$rowCount = 6;
				
				$file_name="KEU_POLI_".$id_poli."_$tgl1.xlsx";
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_harian($tgl, $id_poli, $status)->result();
				
				$vtot=0;
				//$biayadaftar=0;
				foreach($data_laporan_keu as $row2){
					$vtot+=$row2->vtot;
					//$biayadaftar+=$row2->biayadaftar;
				
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $row2->no_medrec,PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->no_register);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->nama);
					if ($status=='10') {
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, ($row2->status=="1" ? "Pulang":"Dirawat"));
						/*$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $row2->biayadaftar, 2 , ',' , '.' ))
							->getStyle('F'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
						$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $row2->vtot, 2 , ',' , '.' ))
							->getStyle('F'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					} else {
						/*$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $row2->biayadaftar, 2 , ',' , '.' ))
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $row2->vtot, 2 , ',' , '.' ))
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					}
				
				}
			
				
				if ($status=='10') {
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Total')
						->getStyle('E'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					/*$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
						->getStyle('F'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
						->getStyle('F'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
				
					/*$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Total Biaya Daftar dan Tindakan')
						->getStyle('F'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
						->getStyle('G'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/	
				} else {
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total')
						->getStyle('D'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					/*$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
						->getStyle('E'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
						->getStyle('E'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
				
					/*$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Total Biaya Daftar dan Tindakan')
						->getStyle('E'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
						->getStyle('F'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
				}
				
			}  

		} else if ($tampil_per=="BLN") {

			$bulan=$var1;
				
			//nama file----------------------------------
			$bulan1 = $tgl_indo->bulan(substr($bulan,5,2)).date('Y', strtotime($bulan));
			$date_title = "Bulan";
			$date="$bulan1";
			//-------------------------------------------
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Bulan : '.$date);
			 $objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Pasien : '.$cara_bayar);
				
			
			if ($id_poli=="SEMUA") {
				
				$file_name="KEU_POLI_$bulan1.xlsx";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_poli_bulanan(substr($bulan,5,2), $status, $cara_bayar)->result();
				
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
						$vtot=0;
						$biayadaftar=0;
						foreach($data_laporan_keu as $row2){
							if ($row2->id_poli==$row1->id_poli) {
								
								$rowCount++;
								$vtot+=$row2->jumlah_vtot;
								$biayadaftar+=$row2->jumlah_biayadaftar;
								

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
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $row2->jumlah_vtot, 2 , ',' , '.' ))
									->getStyle('D'.$rowCount)
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
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
							->getStyle('D'.$rowCount)
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
			} else { //else per_tampil 'BLN' dan id_poli!='SEMUA'
				
				$file_name="KEU_POLI_".$id_poli."_$bulan1.xlsx";
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_bulanan(substr($bulan,5,2), $id_poli, $status, $cara_bayar)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Poliklinik : '.$nm_poli);
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A7', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B7', 'Tanggal');
				//$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Total Biaya Daftar');
				$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Total Biaya Tindakan');
				$rowCount=7;

				$i=1;
				$vtot=0;
				$biayadaftar=0;
				foreach($data_laporan_keu as $row){
					$vtot+=$row->jumlah_vtot;
					$biayadaftar+=$row->jumlah_biayadaftar;
					
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tgl_kunj);
					/*$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $row->jumlah_biayadaftar, 2 , ',' , '.' ))
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					*/
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $row->jumlah_vtot, 2 , ',' , '.' ))
						->getStyle('C'.$rowCount)
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
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
					->getStyle('C'.$rowCount)
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
			
				$file_name="KEU_POLI_$tahun.xlsx";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_poli_tahunan($tahun, $status, $cara_bayar)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A6', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B6', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C6', 'Bulan');
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
						$vtot=0;
						//$biayadaftar=0;
						foreach($data_laporan_keu as $row2){
							if ($row2->id_poli==$row1->id_poli) {
								
								$rowCount++;
								$vtot+=$row2->jumlah_vtot;
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
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $row2->jumlah_vtot, 2 , ',' , '.' ))
								->getStyle('D'.$rowCount)
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
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
							->getStyle('D'.$rowCount)
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

			} else { //else per_tampil 'THN' dan id_poli!='SEMUA'
				
				$file_name="KEU_POLI_".$id_poli."_$tahun.xlsx";
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_tahunan($tahun, $id_poli, $status, $cara_bayar)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Poliklinik : '.$nm_poli);
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A7', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B7', 'Bulan');
				//$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Total Biaya Daftar');
				$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Total Biaya Tindakan');
				$rowCount=7;
				
				$i=1;
				$vtot=0;
				//$biayadaftar=0;
				foreach($data_laporan_keu as $row){
					$vtot+=$row->jumlah_vtot;
					//$biayadaftar+=$row->jumlah_biayadaftar;
					
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $tgl_indo->bulan($row->bulan_kunj));
					/*$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $row->jumlah_biayadaftar, 2 , ',' , '.' ))
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $row->jumlah_vtot, 2 , ',' , '.' ))
						->getStyle('C'.$rowCount)
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
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
					->getStyle('C'.$rowCount)
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
		
		// header('Content-Disposition: attachment;filename="'.$file_name.'"');  
					
		// // Rename worksheet (worksheet, not filename)  
		// $objPHPExcel->getActiveSheet()->setTitle('Laporan Keuangan');  
   
		// // Redirect output to a client’s web browser (Excel2007)  
		// //clean the output buffer  
		// ob_end_clean();  
   
		// //this is the header given from PHPExcel examples.   
		// //but the output seems somewhat corrupted in some cases.  
		// //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
		// //so, we use this header instead.  
		// header('Content-type: application/vnd.ms-excel');  
		// header('Cache-Control: max-age=0');  
		   
		// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
		// $objWriter->save('php://output');
	
		// redirect('irj/Rjclaporan/lapkeu','refresh');

		 header('Content-Type: application/vnd.ms-excel'); //mime type
      header('Content-Disposition: attachment;filename="'.$file_name.'"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache
                  
      //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
      //if you want to save it as .XLSX Excel 2007 format
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
      //force user to download the Excel file without writing it to server's HD
      $objWriter->save('php://output');		
	}

	public function cetak_laporan_log_user($tgl_awal='',$tgl_akhir=''){
		require_once (APPPATH.'third_party/PHPExcel.php');

      set_time_limit(0);

      //load our new PHPExcel library
      //$this->load->library('excel');
      //$this->excel = new PHPExcel();

      $excel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_log_user.xls");

      //activate worksheet number 1
      $excel->setActiveSheetIndex(0);
      //name the worksheet
      $excel->getActiveSheet()->setTitle('Worksheet 1');

      //ambil semua data pendapatan
      $data_log_user = $this->rimuser->get_log_user_all($tgl_awal,$tgl_akhir);
      //print_r($data_pasien_keluar_tanggal[0]);exit;
      $row = 1;
      //set header excel
      // $this->excel->getActiveSheet()->setCellValue('A'.$row, 'UPT');
      // $this->excel->getActiveSheet()->setCellValue('B'.$row, 'Unit');
      // $this->excel->getActiveSheet()->setCellValue('C'.$row, 'Nama Aset');
      // $this->excel->getActiveSheet()->setCellValue('D'.$row, 'Merk');
      // $this->excel->getActiveSheet()->setCellValue('E'.$row, 'No Seri');
      // $this->excel->getActiveSheet()->setCellValue('F'.$row, 'Kondisi');
      // $this->excel->getActiveSheet()->setCellValue('G'.$row, 'PIC');
      // $this->excel->getActiveSheet()->setCellValue('H'.$row, 'No Inventaris');
      // $this->excel->getActiveSheet()->setCellValue('I'.$row, 'IP Address');
      // $this->excel->getActiveSheet()->setCellValue('J'.$row, 'Perolehan');
      // $this->excel->getActiveSheet()->setCellValue('K'.$row, 'Lokasi');
      
      $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      
      $excel->getActiveSheet()->setAutoFilter('A1:B1');
    
      foreach ($data_log_user as $r) {
      

        $row++;
        $excel->getActiveSheet()->setCellValue('A'.$row, $r['usr'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('B'.$row, $r['jml'],PHPExcel_Cell_DataType::TYPE_STRING);
        
      }

        // //change the font size
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        // //make the font become bold
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        // //merge cell A1 until D1
        // $this->excel->getActiveSheet()->mergeCells('A1:D1');
        // //set aligment to center for that merged cell (A1 to D1)
        // $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	  $start_date_format = date("d-m-Y", strtotime($tgl_awal));
	  $end_date_format = date("d-m-Y", strtotime($tgl_akhir));
      $filename='log_user_rawat_inap_'.$start_date_format.'_.'.$end_date_format.'.xls'; //save our workbook as this file name
      header('Content-Type: application/vnd.ms-excel'); //mime type
      header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache
                  
      //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
      //if you want to save it as .XLSX Excel 2007 format
      $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');  
      //force user to download the Excel file without writing it to server's HD
      $objWriter->save('php://output');
	}
}
?>