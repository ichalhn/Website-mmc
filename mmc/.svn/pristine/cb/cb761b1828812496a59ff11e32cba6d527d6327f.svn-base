 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
include(dirname(dirname(__FILE__)).'/Tglindo.php');
class IrDLaporan extends Secure_area{
	public function __construct() {
		parent::__construct();
		$this->load->model('ird/ModelPelayanan','',TRUE);
		$this->load->model('ird/ModelRegistrasi','',TRUE);
		$this->load->model('ird/ModelKwitansi','',TRUE);
		$this->load->model('ird/ModelLaporan','',TRUE);
		$this->load->helper('pdf_helper');
		$this->load->helper('url');
		//include(site_url('/application/controllers/Tglindo.php'));
		//echo site_url('/application/controllers/Tglindo.php');
	}
	public function index()
	{
		redirect('ird/IrDRegistrasi','refresh');
	}
	public function lapkunjungan()
	{
		$data['title'] = 'Laporan Kunjungan Rawat Darurat';
		$data['data_laporan_kunj']=$this->ModelLaporan->get_data_kunj_today()->result();
		$data['date_title']='Hari ini <b>('.date("d F Y").')</b>';
		$data['tgl_awal']=date("Y-m-d");
		$data['tgl_akhir']=date("Y-m-d");
		$this->load->view('ird/lap_rdkunjungan',$data);
	}
	public function lapkeuangan()
	{
		$data['title'] = 'Laporan Pendapatan Rawat Darurat';
		$data['data_laporan_keu']=$this->ModelLaporan->get_data_keu_tindakan_today()->result();
		$data['date_title']='Hari ini <b>('.date("d F Y").')</b>';
		$data['tgl_awal']=date("Y-m-d");
		$data['tgl_akhir']=date("Y-m-d");
		$this->load->view('ird/pend_today',$data);
	}
	public function lapkeudokter()
	{
		$data['title'] = 'Laporan Keuangan Dokter Rawat Darurat';
		$data['data_pendapatan_dokter']=$this->ModelLaporan->get_data_keu_dokter_today()->result();
		$data['date_title']='Hari ini <b>('.date("d F Y").')</b>';
		$data['tgl_awal']=date("Y-m-d");
		$data['tgl_akhir']=date("Y-m-d");
		$this->load->view('ird/rjvlapkeudokter',$data);
	}

	public function data_keuangan()
	{
		if($_SERVER['REQUEST_METHOD']=='POST'){
				$data['tgl_awal']=$this->input->post('tgl_awal');
				$tgl_awal1 = date('d F Y', strtotime($data['tgl_awal']));
				$data['tgl_akhir']=$this->input->post('tgl_akhir');
				$tgl_akhir1 = date('d F Y', strtotime($data['tgl_akhir']));
				
				if($data['tgl_awal']!=$data['tgl_akhir']){
					$data['date_title']='<b>('.$tgl_awal1.' s/d '.$tgl_akhir1.')</b>';
				}else{
					$data['date_title']='<b>('.$tgl_awal1.')</b>';
				}
				$data['data_laporan_keu']=$this->ModelLaporan->get_data_keu_perpoli_in($data['tgl_awal'],$data['tgl_akhir'])->result();
			$this->load->view('ird/rjvlapkeuangan',$data);
		}else{
			redirect('ird/IrDLaporan/lapkeuangan','refresh');
		}
	}
	public function data_keu_dokter()
	{
		if($_SERVER['REQUEST_METHOD']=='POST'){
				$data['tgl_awal']=$this->input->post('tgl_awal');
				$tgl_awal1 = date('d F Y', strtotime($data['tgl_awal']));
				$data['tgl_akhir']=$this->input->post('tgl_akhir');
				$tgl_akhir1 = date('d F Y', strtotime($data['tgl_akhir']));
				
				if($data['tgl_awal']!=$data['tgl_akhir']){
					$data['date_title']='<b>('.$tgl_awal1.' s/d '.$tgl_akhir1.')</b>';
				}else{
					$data['date_title']='<b>('.$tgl_awal1.')</b>';
				}
				$data['data_pendapatan_dokter']=$this->ModelLaporan->get_data_keu_dokter($data['tgl_awal'],$data['tgl_akhir'])->result();
			$this->load->view('ird/rjvlapkeudokter',$data);
		}else{
			redirect('ird/IrDLaporan/lapkeuangan','refresh');
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////kunjungan poli
	public function lap_kunj($pilih='',$param1='',$cara_bayar='')
	{
		$data['title'] = 'Laporan Kunjungan Rawat Darurat';
		$tgl_indo=new Tglindo();
		//echo $cara_bayar;
		if($pilih=='TGL'){
			if($param1!=''){
			$tgl=$param1;
			$tgl1 = date('d F Y', strtotime($tgl));
			$blnindo = $tgl_indo->bulan(date('m', strtotime($tgl)));			
			$date_title='<b>'.date('d', strtotime($tgl)).' '.$blnindo.' '.date('Y', strtotime($tgl)).'</b>';
			$file_name='KUNJ_IRD_'.date('d', strtotime($tgl)).' '.$blnindo.' '.date('Y', strtotime($tgl)).'.pdf';

			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
				
			$data_laporan_kunj=$this->ModelLaporan->get_data_kunj_range($tgl,$cara_bayar)->result();
			if($cara_bayar!='SEMUA'){
				$txtpasien="<tr>
							<td width=\"10%\"><b>Pasien</b></td>
							<td width=\"5%\">:</td>
							<td width=\"80%\">$cara_bayar</td>
						</tr>"	;									
			}else $txtpasien='';
			$konten=
					"<table>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><br><b>Laporan Kunjungan IRD</b></p></td>
							</tr>
							<tr>
								<td>$namars</td>
							</tr>
						</table>
					<table>						
						<tr>
							<td width=\"10%\"><b>Tanggal</b></td>
							<td width=\"5%\">:</td>
							<td width=\"80%\">$date_title</td>
						</tr>
						$txtpasien
					</table>
					<br/><hr/>
					<table border=\"1\" style=\"padding:2px\">
						<tr>
							<td width=\"5%\"><b>No</b></td>							
							<td width=\"15%\"><b>No Medrec</b></td>
							<td width=\"15%\"><b>No Register</b></td>
							<td width=\"30%\"><b>Nama</b></td>
							<td width=\"40%\"><b>Diagnosa</b></td>
								
						</tr>
					";
					$i=1;
					$vtot=0;
					foreach($data_laporan_kunj as $row){
						//$tgl=date("d-m-Y", strtotime($row->tgl_kunjungan));
						//$vtot=$vtot+$row->jum_kunj;
						$konten=$konten."
												
						<tr>
							
						  <td>".$i++."</td>						  
						  <td>$row->no_cm</td>
						  <td>$row->no_register</td>
						  <td>$row->nama</td>
						  <td >$row->diagnosa</td>
						</tr>";
					}
						$konten=$konten."
						<tr>
							<th colspan=\"4\" bgcolor=\"#cdd4cb\"><p align=\"right\"><b>Total   </b></p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">".--$i."</p></th>
						</tr>
					</table>
			";
			//print_r($konten);
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
				$obj_pdf->SetAutoPageBreak(TRUE, '15');
				$obj_pdf->SetFont('helvetica', '', 11);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/ird/rdlaporan/kunj/'.$file_name, 'FI');
			}
			else{
			  redirect('ird/IrDLaporan/lapkunjungan','refresh');
			}
		}
		else if($pilih=='BLN'){
			if($param1!=''){
				$bln=$param1;
				$bln1 = date('F Y', strtotime($bln));	
				$blnindo=$tgl_indo->bulan(date('m', strtotime($bln)));		
				$date_title='<b>'.$blnindo.' '.date('Y', strtotime($bln)).'</b>';
				$file_name="KUNJ_IRD_$date_title.pdf";

				$namars=$this->config->item('namars');
				$kota_kab=$this->config->item('kota');
				$alamatrs=$this->config->item('alamat');
				$nmsingkat=$this->config->item('namasingkat');
				
				$data_laporan_kunj=$this->ModelLaporan->get_data_kunj_bln($bln)->result();
					
				//print_r($data_laporan_kunj);
				$konten=
						"<table>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><br><b>Laporan Kunjungan IRD</b></p></td>
							</tr>
							<tr>
								<td>$namars</td>
							</tr>
						</table>
						<table>							
							<tr>
								<td width=\"10%\"><b>Bulan</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>
						</table>
						<br/><hr/>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td width=\"10%\"><b>No</b></td>							
								<td width=\"50%\"><b>Tanggal</b></td>
								
								<td width=\"40%\" align=\"right\"><b>Jumlah Kunjungan</b></td>
								
							</tr>
						";
						$i=1;
						$vtot=0;
						foreach($data_laporan_kunj as $row){
							//$tgl=date("d-m-Y", strtotime($row->tgl_kunjungan));
							$vtot=$vtot+$row->jum_kunj;
							$konten=$konten."
												
							<tr>
							  <td>".$i++."</td>
							  <td>$row->hari</td>
							  <td align=\"right\">$row->jum_kunj</td>	  
							</tr>";
						}
							$konten=$konten."
							<tr>
								<th colspan=\"2\" bgcolor=\"#cdd4cb\"><p align=\"right\"><b>Total   </b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">$i</p></th>
							</tr>
						</table>
				";
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
					$obj_pdf->SetAutoPageBreak(TRUE, '15');
					$obj_pdf->SetFont('helvetica', '', 11);
					$obj_pdf->setFontSubsetting(false);
					$obj_pdf->AddPage();
					ob_start();
						$content = $konten;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');
					$obj_pdf->Output(FCPATH.'download/ird/rdlaporan/kunj/'.$file_name, 'FI');
				}
				else{
				redirect('ird/IrDLaporan/lapkunjungan','refresh');
				}
		}
		else{
			if($param1!=''){
				$thn=$param1;
				$thn1 = date('Y', strtotime($thn));			
				$date_title='<b>'.$thn1.'</b>';
				$file_name="KUNJ_IRD_$thn.pdf";

				$namars=$this->config->item('namars');
				$kota_kab=$this->config->item('kota');
				$alamatrs=$this->config->item('alamat');
				$nmsingkat=$this->config->item('namasingkat');
				
				$data_laporan_kunj=$this->ModelLaporan->get_data_kunj_thn($thn)->result();
					
				//print_r($data_laporan_kunj);
				$konten=
						"<table>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><br><b>Laporan Kunjungan IRD</b></p></td>
							</tr>
							<tr>
								<td>$namars</td>
							</tr>
						</table>
						<table>							
							<tr>
								<td width=\"10%\"><b>Tahun</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>
						</table>
						<br/><hr/>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td width=\"5%\"><b>No</b></td>							
								<td width=\"50%\"><b>Bulan</b></td>
								
								<td width=\"45%\" align=\"right\"><b>Jumlah Kunjungan</b></td>
								
							</tr>
						";
						$i=1;
						$vtot=0;
						foreach($data_laporan_kunj as $row){
							//$tgl=date("d-m-Y", strtotime($row->tgl_kunjungan));
							$vtot=$vtot+$row->jum_kunj;
							$konten=$konten."
												
							<tr>
							  <td>".$i++."</td>
							  <td>".$tgl_indo->bulan(date("m", strtotime($row->bulan)))."</td>
							  <td align=\"right\">$row->jum_kunj</td>	  
							</tr>";
						}
							$konten=$konten."
							<tr>
								<th colspan=\"2\" bgcolor=\"#cdd4cb\"><p align=\"right\"><b>Total   </b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">$vtot</p></th>
							</tr>
						</table>
				";	//print_r($konten);
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
					$obj_pdf->SetAutoPageBreak(TRUE, '15');
					$obj_pdf->SetFont('helvetica', '', 11);
					$obj_pdf->setFontSubsetting(false);
					$obj_pdf->AddPage();
					ob_start();
						$content = $konten;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');
					$obj_pdf->Output(FCPATH.'download/ird/rdlaporan/kunj/'.$file_name, 'FI');
				}
				else{
				redirect('ird/IrDLaporan/lapkunjungan','refresh');
				}
		}
		
	}
	/*public function lap_kunj($tgl_awal='',$tgl_akhir='')
	{
		$data['title'] = 'Laporan Kunjungan Rawat Darurat';
		if($tgl_awal!='' && $tgl_akhir!=''){
			
			$tgl_awal1 = date('d F Y', strtotime($tgl_awal));
			$tgl_akhir1 = date('d F Y', strtotime($tgl_akhir));
				
			if($tgl_awal!=$tgl_akhir){
				$date_title='<b>'.$tgl_awal1.' s/d '.$tgl_akhir1.'</b>';
				$file_name="KUNJ_IRD_$tgl_awal1-$tgl_akhir1.pdf";
			}else{
				$date_title='<b>'.$tgl_awal1.'</b>';
				$file_name="KUNJ_IRD_$tgl_awal1.pdf";
			}
			
			$data_rs=$this->ModelKwitansi->getdata_rs('10000')->result();
				foreach($data_rs as $row){
					$namars=$row->namars;
					$kota_kab=$row->kota;
				}
				
			$data_laporan_kunj=$this->ModelLaporan->get_data_kunj_range($tgl_awal,$tgl_akhir)->result();
			print_r($data_laporan_kunj);
			$konten=
					"
					<table>
						<tr>
							<td colspan=\"3\"><p align=\"center\"><b>Laporan Kunjungan Instalasi Rawat Darurat</b></p></td>
						</tr>
						<tr>
							<td colspan=\"3\"><p align=\"center\"><b>$namars</b></p></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td width=\"10%\"><b>Tanggal</b></td>
							<td width=\"5%\">:</td>
							<td width=\"80%\">$date_title</td>
						</tr>
					</table>
					<br/><hr/>
					<table>
						<tr>
							<td width=\"5%\"><b>No</b></td>							
							<td width=\"20%\"><b>No Medrec</b></td>
							<td width=\"55%\"><b>Nama</b></td>
							<td width=\"20%\"><b>Jumlah Kunjungan</b></td>
								
						</tr>
					";
					$i=1;
					$vtot=0;
					foreach($data_laporan_kunj as $row){
						//$tgl=date("d-m-Y", strtotime($row->tgl_kunjungan));
						$vtot=0;
						$konten=$konten."
												
						<tr>
							
						  <td>".$i++."</td>						  
						  <td>$row->no_medrec</td>
						  <td>$row->nama</td>
						  <td align=\"right\">$row->jum_kunj</td>
						</tr>";
					}
						$konten=$konten."
						<tr>
							<th colspan=\"3\"><p align=\"right\"><b>Total   </b></p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">$i</p></th>
						</tr>
					</table>
			";
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '20', PDF_MARGIN_RIGHT);
				$obj_pdf->SetAutoPageBreak(TRUE, '15');
				$obj_pdf->SetFont('helvetica', '', 11);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/ird/rdlaporan/kunj/'.$file_name, 'FI');
						
		}else{
			redirect('ird/IrDLaporan/lapkunjungan','refresh');
		}
	}*/
	/////////////////////////////////////////////////////////////////////////////////////keuangan poli
	public function lap_keu($tampil_per='',$param1='',$param2='')
	{
		$data['title'] = 'Laporan Keuangan Rawat Darurat';
		$tgl_indo=new Tglindo();
		$tampil = substr($tampil_per, 0, 3);
		//print_r($tampil);
		
		if(substr($tampil_per,-1)!=''){
			$status = substr($tampil_per, -1);
			//print_r($status);
		}

		$tampil_per=$tampil;
		if($param2!=''){
			$psn=$param2;
		}
				
		if($tampil_per=='TGL'){	
			if($param1!=''){
				$tgl=$param1;
				$tgl1 = date('d', strtotime($tgl));				
				$blnindo = $tgl_indo-> bulan(date('m', strtotime($tgl)));
					$date_title='<b>'.date('d', strtotime($tgl)).' '.$blnindo.' '.date('Y', strtotime($tgl)).'</b>';
					$file_name="KEU_TIND_".date('d', strtotime($tgl)).' '.$blnindo.' '.date('Y', strtotime($tgl)).".pdf";
				
			
				$namars=$this->config->item('namars');
				$kota_kab=$this->config->item('kota');
				$alamat=$this->config->item('alamat');
				$nmsingkat=$this->config->item('namasingkat');

				if($status=='1'){
					$ket_stat='<tr>
								<td width=\"10%\"><b>Status</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\"><b>Pulang</b></td>
							</tr>';					
				}
				else if($status=='0'){
					$ket_stat='<tr>
								<td width=\"10%\"><b>Status</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\"><b>Dirawat</b></td>
							</tr>';
				}else{
					$ket_stat='';
				}
				if($psn=='0'){
					$ket_pasien='';					
				}else{
					$ket_pasien="<tr>
								<td width=\"10%\"><b>Status</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\"><b>$psn</b></td>
							</tr>";
				}
				if($status=='3'){
					$tr_head="<td width=\"5%\"><b>No</b></td>
								<td width=\"10%\"><b>No Medrec</b></td>
								<td width=\"15%\"><b>No Register</b></td>
								<td width=\"25%\"><b>Nama</b></td>
								<td width=\"10%\"><b>Status</b></td>
								<td width=\"15%\" align=\"right\"><p><b>Potongan/<br>Dijamin</b></p></td>
								<td width=\"20%\" align=\"right\"><b>Biaya Tindakan</b></td>";
					

				}else{
					$tr_head="<td width=\"5%\"><b>No</b></td>
								<td width=\"15%\"><b>No Medrec</b></td>
								<td width=\"15%\"><b>No Register</b></td>
								<td width=\"25%\"><b>Nama</b></td>
								<td width=\"20%\" align=\"right\"><p><b>Potongan/<br>Dijamin</b></p></td>
								<td width=\"20%\" align=\"right\"><b>Biaya Tindakan</b></td>";
					
				}
				$data_laporan_keu=$this->ModelLaporan->get_data_keu_tind_tgl($tgl,$status,$psn)->result();
			
				$konten=
						"<table>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><br><b>LAPORAN KEUANGAN IRD</b></p></td>
							</tr>
							<tr>
								<td>$namars</td>
							</tr>
						</table>
						<table>							
							<tr>
								<td width=\"10%\"><b>Tanggal</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>
							$ket_stat
							$ket_pasien
						</table>
						<br/><hr>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								$tr_head
							</tr>
						";
						$i=1;
						$vtot1=0;$vtot2=0;$vtot3=0;
						if($status=='3'){
							foreach($data_laporan_keu as $row){
							$vtot1=$vtot1+$row->biayadaftar;
							$vtot2=$vtot2+$row->total;
							$vtot3=$vtot3+$row->diskon;
							//echo $row->status;
							if($row->status=='1'){ $det_stat="Pulang"; } else { $det_stat="Dirawat";}
							$konten=$konten."
							<tr>
								<td width=\"5%\">".$i++."</td>
								<td width=\"10%\">$row->no_cm</td>
								<td width=\"15%\">$row->no_register</td>
								<td width=\"25%\">".strtoupper($row->nama)."</td>
								<td width=\"10%\">$det_stat</td>
								<td width=\"15%\"><p align=\"right\">".number_format($row->diskon, 2 , ',' , '.' )."</p></td>
								<td width=\"20%\"><p align=\"right\">".number_format($row->total, 2 , ',' , '.' )."</p></td>
							</tr>";
							}
						}else{
							foreach($data_laporan_keu as $row){
								$vtot2=$vtot2+$row->total;
								$vtot3=$vtot3+$row->diskon;
								$konten=$konten."
								<tr>
									<td width=\"5%\">".$i++."</td>
									<td width=\"15%\">$row->no_cm</td>
									<td width=\"15%\">$row->no_register</td>
									<td width=\"25%\">".strtoupper($row->nama)."</td>
			
									<td width=\"20%\"><p align=\"right\">".number_format($row->diskon, 2 , ',' , '.' )."</p></td>
									<td width=\"20%\"><p align=\"right\">".number_format($row->total, 2 , ',' , '.' )."</p></td>
								</tr>";

							}						
						}
						/*<td width=\"10%\"><b>No Medrec</b></td>
								<td width=\"10%\"><b>No Register</b></td>
								<td width=\"35%\"><b>Nama</b></td>
								<td width=\"20%\"><b>Jumlah Tindakan</b></td>
								<td width=\"10%\"><b>Status</b></td>
								<td width=\"15%\" align=\"right\"><b>Total</b></td>*/
							if($status=='3'){ $col1=5; $col2=7; }else { $col1=3; $col2=5;}
							$konten=$konten."
							<tr>
								<th colspan=\"$col1\" bgcolor=\"#cdd4cb\"><p align=\"right\" ><b>Total   </b></p></th>								
								<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot3, 2 , ',' , '.' )."</p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot2, 2 , ',' , '.' )."</p></th>
							</tr>
							
						</table>
				";//print_r($konten);
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
					$obj_pdf->SetAutoPageBreak(TRUE, '15');
					$obj_pdf->SetFont('helvetica', '', 11);
					$obj_pdf->setFontSubsetting(false);
					$obj_pdf->AddPage();
					ob_start();
						$content = $konten;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');
					$obj_pdf->Output(FCPATH.'download/ird/rdlaporan/keu/'.$file_name, 'FI');
						
			}else{
				redirect('ird/IrDLaporan/lapkeuangan','refresh');
			}
		}else if($tampil_per=='BLN'){
			if($param1!=''){
				$bln=$param1;
				$bln1 = date('F Y', strtotime($bln));
				$blnindo = $tgl_indo-> bulan(date('m', strtotime($bln)));				
				$date_title='<b>'.$blnindo.' '.date('Y', strtotime($bln)).'</b>';
				$file_name="KEU_TIND_$bln1.pdf";

				$namars=$this->config->item('namars');
				$kota_kab=$this->config->item('kota');
				$alamatrs=$this->config->item('alamat');
				$nmsingkat=$this->config->item('namasingkat');

				if($status=='1'){
					$ket_stat='<tr>
								<td width=\"10%\"><b>Status</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\"><b>Pulang</b></td>
							</tr>';
				}
				else if($status=='0'){
					$ket_stat='<tr>
								<td width=\"10%\"><b>Status</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\"><b>Dirawat</b></td>
							</tr>';
				}else{
					$ket_stat='';
				}
				
				if($psn=='0'){
					$ket_pasien='';					
				}else{
					$ket_pasien="<tr>
								<td width=\"10%\"><b>Status</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\"><b>$psn</b></td>
							</tr>";
				}
				$data_laporan_keu=$this->ModelLaporan->get_data_keu_tind_bln($bln, $status,$psn)->result();
			
				$konten=
						"<table>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><br><b>Laporan Keuangan IRD</b></p></td>
							</tr>
							<tr>
								<td>$namars</td>
							</tr>
						</table>
						<table >							
							<tr>
								<td width=\"10%\"><b>Tanggal</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>
							$ket_stat
							$ket_pasien
						</table>
						<br/><hr/>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td width=\"5%\"><b>No</b></td>
								<td width=\"25%\"><b>Hari</b></td>
								<td width=\"20%\"><b>Total Kunjungan</b></td>
								<td width=\"25%\" align=\"right\"><b>Total Potongan/Dijamin</b></td>
								<td width=\"25%\" align=\"right\"><b>Total Biaya Tindakan</b></td>
							</tr>
						";
						$i=1;
						$vtot1=0;$vtot2=0;$vtot3=0;$vtot4=0;
						foreach($data_laporan_keu as $row){
							$vtot1=$vtot1+$row->total;
							$vtot4=$vtot4+$row->jum_kunj;
							$vtot3=$vtot3+$row->totdiskon;
							$konten=$konten."
							<tr>
								<td>".$i++."</td>
								<td>$row->hari</td>
								<td>$row->jum_kunj</td>
								<td><p align=\"right\">".number_format($row->totdiskon, 2 , ',' , '.' )."</p></td>
								<td><p align=\"right\">".number_format($row->total, 2 , ',' , '.' )."</p></td>
							</tr>";
						}
							$konten=$konten."
							<tr>
								<th colspan=\"2\" bgcolor=\"#cdd4cb\"><p align=\"right\"><b>Total   </b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".$vtot4."</p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot3, 2 , ',' , '.' )."</p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot1, 2 , ',' , '.' )."</p></th>
							</tr>
							
						</table>
				";
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
					$obj_pdf->SetAutoPageBreak(TRUE, '15');
					$obj_pdf->SetFont('helvetica', '', 11);
					$obj_pdf->setFontSubsetting(false);
					$obj_pdf->AddPage();
					ob_start();
						$content = $konten;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');
					$obj_pdf->Output(FCPATH.'download/ird/rdlaporan/keu/'.$file_name, 'FI');
			}else{
				redirect('ird/IrDLaporan/lapkeuangan','refresh');
			}
		}else{
			if($param1!=''){
				$thn=$param1;
				//print_r($status);
				$thn1 = date('Y', strtotime($thn));
								
				$date_title='<b>'.$thn1.'</b>';
				$file_name="KEU_TIND_$thn1.pdf";

				$namars=$this->config->item('namars');
				$kota_kab=$this->config->item('kota');
				$alamatrs=$this->config->item('alamat');
				$nmsingkat=$this->config->item('namasingkat');

				if($status=='1'){
					$ket_stat='<tr>
								<td width=\"10%\"><b>Status</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\"><b>Pulang</b></td>
							</tr>';
				}
				else if($status=='0'){
					$ket_stat='<tr>
								<td width=\"10%\"><b>Status</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\"><b>Dirawat</b></td>
							</tr>';
				}else{
					$ket_stat='';
				}

				if($psn=='0'){
					$ket_pasien='';					
				}else{
					$ket_pasien="<tr>
								<td width=\"10%\"><b>Pasien</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\"><b>$psn</b></td>
							</tr>";
				}
				$data_laporan_keu=$this->ModelLaporan->get_data_keu_tind_thn($thn, $status,$psn)->result();
			
				$konten=
						"<table>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><br><b>Laporan Keuangan IRD</b></p></td>
							</tr>
							<tr>
								<td>$namars</td>
							</tr>
						</table>
						<table >							
							<tr>
								<td width=\"10%\"><b>Tahun</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>
							$ket_stat
							$ket_pasien
						</table>
						<br/><hr/>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td width=\"5%\"><b>No</b></td>
								<td width=\"25%\"><b>Bulan</b></td>
								<td width=\"20%\"><b>Total Kunjungan</b></td>
								<td width=\"25%\"><b>Total Potongan/Dijamin</b></td>
								<td width=\"25%\" align=\"right\"><b>Total Biaya Tindakan</b></td>
							</tr>
						";
						$i=1;
						$vtot1=0;$vtot3=0;$vtot4=0;
						foreach($data_laporan_keu as $row){
							$vtot1=$vtot1+$row->total;
							$vtot3=$vtot3+$row->totdiskon;
							$vtot4=$vtot4+$row->jum_kunj;
							$konten=$konten."
							<tr>
								<td>".$i++."</td>
								<td>".$tgl_indo->bulan(date('m', strtotime($row->bulan)))."</td>
								<td><p align=\"right\">".$row->jum_kunj."</p></td>
								<td><p align=\"right\">".number_format($row->totdiskon, 2 , ',' , '.' )."</p></td>
								<td><p align=\"right\">".number_format($row->total, 2 , ',' , '.' )."</p></td>
							</tr>";
						}
							$konten=$konten."
							<tr>
								<th colspan=\"2\" bgcolor=\"#cdd4cb\"><p align=\"right\"><b>Total   </b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".$vtot4."</p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot3, 2 , ',' , '.' )."</p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot1, 2 , ',' , '.' )."</p></th>
							</tr>
							
						</table>
				";
			//print_r($data_laporan_keu);
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
					$obj_pdf->SetAutoPageBreak(TRUE, '15');
					$obj_pdf->SetFont('helvetica', '', 11);
					$obj_pdf->setFontSubsetting(false);
					$obj_pdf->AddPage();
					ob_start();
						$content = $konten;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');
					$obj_pdf->Output(FCPATH.'download/ird/rdlaporan/keu/'.$file_name, 'FI');
			}else{
				redirect('ird/IrDLaporan/lapkeuangan','refresh');
			}
		}
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////kunj pilih poli
	/*public function data_kunjungan()
	{
		$data['title'] = 'Laporan Kunjungan Rawat Darurat';
		if($_SERVER['REQUEST_METHOD']=='POST'){
				$data['tgl_awal']=$this->input->post('tgl_awal');
				$tgl_awal1 = date('d F Y', strtotime($data['tgl_awal']));
				$data['tgl_akhir']=$this->input->post('tgl_akhir');
				$tgl_akhir1 = date('d F Y', strtotime($data['tgl_akhir']));
				
				if($data['tgl_awal']!=$data['tgl_akhir']){
					$data['date_title']='<b>('.$tgl_awal1.' s/d '.$tgl_akhir1.')</b>';
				}else{
					$data['date_title']='<b>('.$tgl_awal1.')</b>';
				}
				$data['data_laporan_kunj']=$this->ModelLaporan->get_data_kunj_range($data['tgl_awal'],$data['tgl_akhir'])->result();
			$this->load->view('ird/lap_rdkunjungan_range',$data);
		}else{
			redirect('ird/IrDLaporan/rjvlapkunjungan','refresh');
		}
	}*/	
	public function data_kunjungan()
	{
		//$this->session->set_flashdata('message_nodata','');
		$data['title'] = 'Laporan Kunjungan Rawat Darurat';
		$tgl_indo=new Tglindo();
		if($_SERVER['REQUEST_METHOD']=='POST'){
				$tampil_per=$this->input->post('tampil_per');				
				
				if($tampil_per=='TGL'){
					//$tgl_awal=$this->input->post('date_picker_days1');
					//if(){
					//}
					$tgl=$this->input->post('date_picker_days');
						$data['cara_bayar']=$this->input->post('cara_bayar');
					
						
					$data['data_laporan_kunj']=$this->ModelLaporan->get_data_kunj_range($tgl,$data['cara_bayar'])->result();
					$tgl1 = date('d F Y', strtotime($tgl));
					$data['date_title']="Laporan Kunjungan Pasien IRD <b>$tgl1</b>";
					$data['field1']='No. Medrec';					
					$data['tgl']=$tgl;
				}else if($tampil_per=='BLN'){
					$bln=$this->input->post('date_picker_months');
					
					//echo $this->input->post('date_picker_months');

					$data['data_laporan_kunj']=$this->ModelLaporan->get_data_kunj_bln($bln)->result();
					
					$bln1 = date('F Y', strtotime($bln));
					$bln2 = date('m', strtotime($bln));
					$bln3 = $tgl_indo->bulan($bln2);
					$data['date_title']="Laporan Kunjungan Pasien IRD per Hari <b>Bulan $bln3</b>";
					$data['field1']='Tanggal';					
					$data['date']=$bln;//untuk param waktu cetak
					$data['bln']=$bln;
					//print_r($bln2);
				}else{
					$thn=$this->input->post('date_picker_years');
					$data['data_laporan_kunj']=$this->ModelLaporan->get_data_kunj_thn($thn)->result();
					
					$data['date_title']="Laporan Kunjungan Pasien IRD <b>Tahun $thn</b>";
					$data['field1']='Bulan';
					$data['date']=$thn;//untuk param waktu cetak
					$data['thn']=$thn;
					$data['tgl_indo']=$tgl_indo;
				}
				$data['tampil_per']=$this->input->post('tampil_per');//untuk param waktu cetak
				
				$size=sizeof($data['data_laporan_kunj']);
				//$data['size']=$size;
				if($size<1){
				//echo "hahahaha";
				$data['message_nodata']="<div class=\"content-header\">
				<div class=\"alert alert-danger alert-dismissable\">
					<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
				<h4><i class=\"icon fa fa-close\"></i>
					Tidak Ditemukan Data
				</h4>							
				</div>
			</div>";
				$data['size']='';
				}else{
					//echo "hahahahdwadawdwafawfeagageaga";
					$data['message_nodata']='';
					$data['size']=$size;
				}

			$this->load->view('ird/lap_rdkunjungan_range.php',$data);
		}else{
			$data['data_laporan_kunj']=$this->ModelLaporan->get_data_kunj_today()->result();
			$data['date_title']='Laporan Kunjungan Pasien IRD <b>'.date("d F Y").'</b>';
			$data['tgl']=date("Y-m-d");
			$data['field1']='No. Medrec';
			$data['tampil_per']='TGL';		
			$data['cara_bayar']='SEMUA';
			$size=sizeof($data['data_laporan_kunj']);			

			if($size<1){
				//
				$data['message_nodata']="<div class=\"content-header\">
				<div class=\"alert alert-danger alert-dismissable\">
					<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
				<h4><i class=\"icon fa fa-close\"></i>
					Tidak Ditemukan Data
				</h4>							
				</div>
			</div>";
				$data['size']='';
				}else{
					
					$data['message_nodata']='';
					$data['size']=$size;
				}

			$this->load->view('ird/lap_rdkunjungan_range.php',$data);
		}
	}
	
	
	public function data_pendapatan($param1='')
	{
		$data['title'] = 'Laporan Pendapatan Rawat Darurat';				
		
		if($this->input->post('plgCheckbox')!='' and $this->input->post('noCheckbox')!=''){
			$status='3';
			$data['stat_pilih']='';
		}
		else if($this->input->post('plgCheckbox')!='') {
			$status=$this->input->post('plgCheckbox');			
		//echo $stat_plg;
			$data['stat_pilih']='Pulang';
		}
		else if($this->input->post('noCheckbox')!=''){
			$status=$this->input->post('noCheckbox');
			$data['stat_pilih']='Dirawat';
		}
		else {
			$status='1';
			$data['stat_pilih']='Pulang';
		}

		
		$data['status']=$status;
		$tgl_indo=new Tglindo();		
		if($_SERVER['REQUEST_METHOD']=='POST'){
				$tampil_per=$this->input->post('tampil_per');			
				if($tampil_per=='TGL'){
					if($this->input->post('jenis_pasien0')!='0'){
						$psn=$this->input->post('jenis_pasien0');
			
					}		
					else {
						$psn='0';
			
					}
					$data['psn']=$psn;
					$tgl=$this->input->post('date_picker_days');
					//print_r($tgl.' '.$status);
					//echo $status;
					//$tgl_akhir=$this->input->post('date_picker_days2');
					/*if($this->input->post('plgCheckbox')!='' and $this->input->post('noCheckbox')!=''){
						$data['data_laporan_keu']=$this->ModelLaporan->get_data_keu_tind_in($tgl_awal,$tgl_akhir,)->result();
						$data['stat_pilih']='';
					}
					else if($this->input->post('plgCheckbox')!='') {
						$stat_plg=$this->input->post('plgCheckbox');
						$data['data_laporan_keu']=$this->ModelLaporan->get_data_keu_tind_tgl($tgl_awal,$tgl_akhir,$stat_plg)->result();
						//echo $stat_plg;
						$data['stat_pilih']='Pulang';
					}
					else{
						$stat_no=$this->input->post('noCheckbox');
						$data['data_laporan_keu']=$this->ModelLaporan->get_data_keu_tind_tgl($tgl_awal,$tgl_akhir,$stat_no)->result();
						$data['stat_pilih']='Dirawat';
					}*/
					$data['data_laporan_keu']=$this->ModelLaporan->get_data_keu_tind_tgl($tgl,$status,$psn)->result();
					//print_r($this->ModelLaporan->get_data_keu_tind_tgl($tgl,$status)->result());
					$tgl1= date('d F Y', strtotime($tgl));
					
					$data['date_title']="<b>$tgl1</b>";
					$data['field1']='No. Register';
					$data['tgl']=$tgl;
					$data['psn']=$psn;
					
					
				}else if($tampil_per=='BLN'){
					
					if($this->input->post('jenis_pasien1')!='0'){
						$psn=$this->input->post('jenis_pasien1');
			
					}		
					else {
						$psn='0';
			
					}
					$data['psn']=$psn;
					//echo $this->input->post('jenis_pasien1');
					

					$bln=$this->input->post('date_picker_months');							
					
					$data['data_laporan_keu']=$this->ModelLaporan->get_data_keu_tind_bln($bln,$status,$psn)->result();
					$bln1 = date('Y', strtotime($bln));
					$bln2 = date('m', strtotime($bln));
					$bln3 = $tgl_indo->bulan($bln2);
					//echo $tgl_indo->bulan('08');
					$data['date_title']="per Hari <b>Bulan $bln3 $bln1</b>";
					$data['field1']='Tanggal';
					$data['bln']=$bln;
					$data['date']=$bln;//untuk param waktu cetak

				}else{					
					if($this->input->post('jenis_pasien2')!='0'){
						$psn=$this->input->post('jenis_pasien2');
						
					}		
					else {
						$psn='0';
			
					}
					
					$data['psn']=$psn;
					
					$thn=$this->input->post('date_picker_years');
					$data['data_laporan_keu']=$this->ModelLaporan->get_data_keu_tind_thn($thn,$status,$psn)->result();
					//print_r($data);
					$data['date_title']="per Bulan <b> Tahun $thn</b>";
					$data['field1']='Bulan';
					$data['date']=$thn;//untuk param waktu cetak
					$data['thn']=$thn;
					$data['tgl_indo']=$tgl_indo;
				}
				$data['tampil_per']=$this->input->post('tampil_per');//untuk param waktu cetak
				
				$size=sizeof($data['data_laporan_keu']);
				//$data['size']=$size;
				if($size<1){
				//echo "hahahaha";
				$data['message_nodata']="<div class=\"content-header\">
				<div class=\"alert alert-danger alert-dismissable\">
					<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
				<h4><i class=\"icon fa fa-close\"></i>
					Tidak Ditemukan Data
				</h4>							
				</div>
			</div>";
				$data['size']='';
				}else{
					//echo "hahahahdwadawdwafawfeagageaga";
					$data['message_nodata']='';
					$data['size']=$size;
				}

			$this->load->view('ird/pend_today',$data);
		}else{			
			$data['data_laporan_keu']=$this->ModelLaporan->get_data_keu_tindakan_today()->result();
			$data['date_title']='<b>'.date("d F Y").'</b>';
			$data['tgl']=date("Y-m-d");
			$data['field1']='No. Register';
			$data['stat_pilih']='';
			$data['tampil_per']='TGL';
			$data['psn']='';
			$size=sizeof($data['data_laporan_keu']);
				//$data['size']=$size;
				if($size<1){
				//echo "hahahaha";
				$data['message_nodata']="<div class=\"content-header\">
				<div class=\"alert alert-danger alert-dismissable\">
					<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
				<h4><i class=\"icon fa fa-close\"></i>
					Tidak Ditemukan Data
				</h4>							
				</div>
			</div>";
				$data['size']='';
				}else{
					//echo "hahahahdwadawdwafawfeagageaga";
					$data['message_nodata']='';
					$data['size']=$size;
				}
			
			$this->load->view('ird/pend_today',$data);
			//redirect('ird/IrDLaporan/data','refresh');
		}
	}
	public function lap_keu_poli($date,$tampil_per,$id_poli)
	{
		if($date!='' && $tampil_per!='' && $id_poli!=''){
			$data_nm_poli=$this->ModelLaporan->get_nm_poli($id_poli)->result();
			foreach($data_nm_poli as $row){
				$nm_poli=$row->nm_poli;
			}	
			if($tampil_per=='TGL'){
					$tgl=$this->input->post('date_picker_days');
					$data_laporan_keu=$this->ModelLaporan->get_data_keu_poli_tgl($id_poli,$date)->result();
					$date1 = date('d F Y', strtotime($date));
					$date_title="Laporan Keuangan Poliklinik";
					$field1='No. Register';
					$pada='Tanggal';
					$file_name="KEU_$id_poli_$date1.pdf";
			}else if($tampil_per=='BLN'){
					$data_laporan_keu=$this->ModelLaporan->get_data_keu_poli_bln($id_poli,$date)->result();
					$date1 = date('F Y', strtotime($date));
					$date_title="Laporan Keuangan per Hari Poliklinik";
					$field1='Tanggal';
					$pada='Bulan';
					$file_name="KEU_$id_poli_$date1.pdf";
			}else{
					$data_laporan_keu=$this->ModelLaporan->get_data_keu_poli_thn($id_poli,$date)->result();
					$date_title="Laporan Keuangan per Bulan Poliklinik";
					$date1=$date;
					$field1='Bulan';
					$pada='Tahun';
					$file_name="KEU_$id_poli_$date1.pdf";
				}
			
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');

			$konten="<table>
						<tr>
							<td colspan=\"3\"><p align=\"center\"><b>$date_title</b></p></td>
						</tr>
						<tr>
							<td colspan=\"3\"><p align=\"center\"><b>$namars</b></p></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td width=\"15%\"><b>$pada</b></td>
							<td width=\"5%\">:</td>
							<td width=\"80%\">$date1</td>
						</tr>
						<tr>
							<td><b>Poliklinik</b></td>
							<td>:</td>
							<td>$nm_poli ($id_poli)</td>
						</tr>
					</table>
					<br/><hr/>
					<table>
						<tr>
							<td width=\"5%\"><b>No</b></td>
							<td width=\"70%\"><b>$field1</b></td>
							<td width=\"25%\"><b>Total</b></td>
						</tr>
					";
					$i=1;
					$vtot=0;
					foreach($data_laporan_keu as $row){
						$vtot=$vtot+$row->jumlah_keu;
						$konten=$konten."
						<tr>
							<td>".$i++."</td>
							<td>$row->val_field1</td>
							<td><p align=\"right\">".number_format($row->jumlah_keu, 2 , ',' , '.' )."</p></td>
						</tr>";
					}
						$konten=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"right\"><b>Total   </b></p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot, 2 , ',' , '.' )."</p></th>
						</tr>
					</table>
			";
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '20', PDF_MARGIN_RIGHT);
				$obj_pdf->SetAutoPageBreak(TRUE, '15');
				$obj_pdf->SetFont('helvetica', '', 11);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/ird/rdlaporan/keu/poli/'.$file_name, 'FI');
						
		}else{
			redirect('ird/IrDLaporan/lapkeuangan','refresh');
		}
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////pendapatan dokter
	public function lap_keu_dokter($tgl_awal='',$tgl_akhir='')
	{
		if($tgl_awal!='' && $tgl_akhir!=''){
			
			$tgl_awal1 = date('d F Y', strtotime($tgl_awal));
			$tgl_akhir1 = date('d F Y', strtotime($tgl_akhir));
				
			if($tgl_awal!=$tgl_akhir){
				$date_title='<b>'.$tgl_awal1.' s/d '.$tgl_akhir1.'</b>';
				$file_name="PENDAPATAN_DOKTER_$tgl_awal1-$tgl_akhir1.pdf";
			}else{
				$date_title='<b>'.$tgl_awal1.'</b>';
				$file_name="PENDAPATAN_DOKTER_$tgl_awal1.pdf";
			}
			
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			
			$data_pendapatan_dokter=$this->ModelLaporan->get_data_keu_dokter($tgl_awal,$tgl_akhir)->result();
			
			$konten=
					"
					<table>
						<tr>
							<td colspan=\"3\"><p align=\"center\"><b>Laporan Keuangan Poliklinik</b></p></td>
						</tr>
						<tr>
							<td colspan=\"3\"><p align=\"center\"><b>$namars</b></p></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td width=\"10%\"><b>Tanggal</b></td>
							<td width=\"5%\">:</td>
							<td width=\"80%\">$date_title</td>
						</tr>
					</table>
					<br/><hr/>
					<table>
						<tr>
							<td width=\"5%\"><b>No</b></td>
							<td width=\"15%\"><b>ID Dokter</b></td>
							<td width=\"55%\"><b>Nama Dokter</b></td>
							<td width=\"25%\"><b>Total Pendapatan</b></td>
						</tr>
					";
					$i=1;
					$vtot=0;
					foreach($data_pendapatan_dokter as $row){
						$vtot=$vtot+$row->jumlah_keu_dokter;
						$konten=$konten."
						<tr>
							<td>".$i++."</td>
							<td>$row->id_dokter</td>
							<td>$row->nm_dokter</td>
							<td><p align=\"right\">".number_format($row->jumlah_keu_dokter, 2 , ',' , '.' )."</p></td>
						</tr>";
					}
						$konten=$konten."
						<tr>
							<th colspan=\"3\"><p align=\"right\"><b>Total   </b></p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot, 2 , ',' , '.' )."</p></th>
						</tr>
					</table>
			";
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '20', PDF_MARGIN_RIGHT);
				$obj_pdf->SetAutoPageBreak(TRUE, '15');
				$obj_pdf->SetFont('helvetica', '', 11);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/ird/rdlaporan/dokter/'.$file_name, 'FI');
				
		}else{
			redirect('ird/IrDLaporan/lapkeudokter','refresh');
		}
	}
	////////////////////////////////////////////////
	public function export_excel($tampil_per='',$param1='',$param2='')
	{
		$data['title'] = 'Laporan Keuangan Rawat Darurat';

		$tgl_indo=new Tglindo();

		$tampil = substr($tampil_per, 0, 3);
		//print_r($tampil);
		
		if(substr($tampil_per,-1)!=''){
			$status = substr($tampil_per, -1);
			//print_r($status);
		}

		$tampil_per=$tampil;
		if($param2!=''){
			$psn=$param2;
		}

		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		//print_r($tampil);
		
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');

		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Laporan Keuangan ".$namars)  
		        ->setSubject("Laporan Keuangan ".$namars." Document")  
		        ->setDescription("Laporan Keuangan ".$namars." for Office 2007 XLSX, generated by HMIS.")  
		        ->setKeywords($namars)  
		        ->setCategory("Laporan Keuangan");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);


		////		
		if($tampil_per=='TGL'){	
			if($param1!=''){

				$tgl=$param1;
				$tgl1 = date('d F Y', strtotime($tgl));				
				
				//$data_keuangan=$this->ModelLaporan->get_data_keuangan_tgl($tgl)->result();
					
				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_ird_tgl.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  
				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$tgl1);

				if($psn!='0'){
					if($psn!='BPJS'){
						$jenis_param2=ucfirst(strtolower($psn));
					} else {
							$jenis_param2=$psn;
					}
				} else {
					$jenis_param2="Semua";
				}
				$data_laporan_keu=$this->ModelLaporan->get_data_keu_tind_tgl($tgl,$status,$psn)->result();
				if($status=='1'){
					$stat="Pulang";
				}else if($status=='0'){
					$stat="Dirawat";
				}else
					$stat="Pulang dan Dirawat";
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Pasien : '.$stat.' - '.$jenis_param2);

				$vtot1=0;$vtot2=0;
				$i=1;
				$rowCount = 5;

				foreach($data_laporan_keu as $row){
					$no_register=$row->no_register;
					$vtot1=$vtot1+$row->total;
					$vtot2=$vtot2+$row->diskon;
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
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, strtoupper($row->nama));
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, (int)$row->diskon);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, (int)$row->total);
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
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,  $vtot2);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtot1);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount)->applyFromArray(
				    array(
					'fill' => array(
					    'type' => PHPExcel_Style_Fill::FILL_SOLID,
					    'color' => array('rgb' => 'C1B2B2')
					)
				    )
				);
				
				header('Content-Disposition: attachment;filename="Lap_Keu_IRD_TGL_'.date('d-m-Y', strtotime($tgl)).'.xlsx"');  
					
			}else{
				redirect('ird/IrDLaporan/data_pendapatan','refresh');
			}
		}else if($tampil_per=='BLN'){
			if($param1!=''){
				$bln=$param1;
				$blnindo=$tgl_indo->bulan(date('m', strtotime($bln)));
				$bln1 = $blnindo.' '.date('Y', strtotime($bln));
				$psn=$param2;
				if($psn!=''){					
					$data_keuangan=$this->ModelLaporan->get_data_keu_tind_bln($bln, $status,$psn)->result();
				}

				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_ird_bln.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  

				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Bulan : '.$bln1);

				if($psn!='0'){
					if($psn!='BPJS'){
						$jenis_param2=ucfirst(strtolower($psn));
					} else {
							$jenis_param2=$psn;
					}
				} else {
					$jenis_param2="Semua";
				}

				if($status=='1'){
					$stat="Pulang";
				}else if($status=='0'){
					$stat="Dirawat";
				}else
					$stat="Pulang dan Dirawat";
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Pasien : '.$jenis_param2);
				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Status : '.$stat);
				$i=1;
				$vtottotal=0;$vtotkunj=0;
				$vtotdiskon=0;
				$vtot_pemeriksaan=0;
				$rowCount = 6;

				foreach($data_keuangan as $row){
						
							$bln3 = date('d', strtotime($row->tgl_kunjungan));
							$bln2 = date('m', strtotime($row->tgl_kunjungan));
							$bulan = $tgl_indo->bulan($bln2);
							$vtotkunj=$vtotkunj+$row->jum_kunj;
							$vtottotal=$vtottotal+$row->total;
							$vtotdiskon=$vtotdiskon+$row->totdiskon;
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $bln3.' '.$bulan);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->jum_kunj);
								$objPHPExcel->getActiveSheet()->
								setCellValue(
									'D'.$rowCount, 
									(int)$row->totdiskon
								    );
//SetCellValue('C'.$rowCount, $row->totdiskon);
								$objPHPExcel->getActiveSheet()->
								setCellValue(
									'E'.$rowCount, 
									(int)$row->total
								    );
//SetCellValue('D'.$rowCount, $row->total);
								
							 	$i++;
							
							$rowCount++;
						
				}// if
/*				foreach($data_periode as $row){
					$j=1;
					$vtottotal=0;
					$vtotjumpas=0;
					$vtotjumpem=0;
					foreach($data_keuangan as $row2){
						if($row2->tgl==$row->tgl){
							$bln3 = date('d', strtotime($row2->tgl));
							$bln2 = date('m', strtotime($row2->tgl));
							$bulan = $tgl_indo->bulan($bln2);
							$vtottotal=$vtottotal+$row2->total;
							$vtotjumpas=$vtotjumpas+$row2->jumlah_pasien;
							$vtotjumpem=$vtotjumpem+$row2->jumlah_pemeriksaan;
							$vtot=$vtot+$row2->total;
							$vtot_pasien=$vtot_pasien+$row2->jumlah_pasien;
							$vtot_pemeriksaan=$vtot_pemeriksaan+$row2->jumlah_pemeriksaan;
							if($j==1){ 
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $bln3.' '.$bulan);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_pasien);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jumlah_pemeriksaan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total);
							 	$i++;
							} else { 
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_pasien);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jumlah_pemeriksaan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total);
							}
							$j++;
							$rowCount++;
						} // if
					}
				}*/
				

				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtotkunj);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtotdiskon);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtottotal);				
				
				header('Content-Disposition: attachment;filename="Lap_Keu_IRD_Bulan_'.date('m-Y', strtotime($tgl)).'.xlsx"');  
			}
			else{
				redirect('ird/IrDLaporan/data_pendapatan','refresh');
			}
		}else{
			if($param1!=''){
				$thn=$param1;
				$thn1 = date('Y', strtotime($thn));
				
				$psn=$param2;
				$date_title='<b>'.$thn1.'</b>';
				$file_name="KEU_IRD_$thn1.pdf";

				//$data_laporan_keu=$this->Labmlaporan->get_data_keu_tind_thn($thn)->result();
				if($psn!=''){					
					$data_keuangan=$this->ModelLaporan->get_data_keu_tind_thn($thn, $status,$psn)->result();
				} 
				print_r($data_keuangan);
				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_ird_thn.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  

				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tahun : '.$thn);


				if($psn!='0'){
					if($psn!='BPJS'){
						$jenis_param2=ucfirst(strtolower($psn));
					} else {
						$jenis_param2=$param2;
					}
				} else {
					$jenis_param2="Semua";
				}
			
				if($status=='1'){
					$stat="Pulang";
				}else if($status=='0'){
					$stat="Dirawat";
				}else
					$stat="Pulang dan Dirawat";

				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Pasien : '.$jenis_param2);
				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Status : '.$stat);
				$i=1;
				$vtottotal=0;$vtotkunj=0;
				$vtotdiskon=0;
				$vtot_pemeriksaan=0;
				$rowCount = 6;
				foreach($data_keuangan as $row){
					
							$thn = date('Y', strtotime($row->bulan));
							$bln2 = date('m', strtotime($row->bulan));
							$bulan = $tgl_indo->bulan($bln2);
							$vtotkunj=$vtotkunj+$row->jum_kunj;
							$vtottotal=$vtottotal+$row->total;
							$vtotdiskon=$vtotdiskon+$row->totdiskon;
							
							$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
							$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $bulan.' '.$thn);
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->jum_kunj);
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, (int)$row->totdiskon);
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, (int)$row->total);
							
							$i++;
							$rowCount++;

					
					}

				/*foreach($data_periode as $row){
					$j=1;
					$vtottotal=0;
					$vtotjumpas=0;
					$vtotjumpem=0;
					foreach($data_keuangan as $row2){
						if($row2->bln==$row->bln){
							$thn = date('Y', strtotime($row2->bln));
							$bln2 = date('m', strtotime($row2->bln));
							$bulan = $tgl_indo->bulan($bln2);
							$vtottotal=$vtottotal+$row2->total;
							$vtotjumpas=$vtotjumpas+$row2->jumlah_pasien;
							$vtotjumpem=$vtotjumpem+$row2->jumlah_pemeriksaan;
							$vtot=$vtot+$row2->total;
							$vtot_pasien=$vtot_pasien+$row2->jumlah_pasien;
							$vtot_pemeriksaan=$vtot_pemeriksaan+$row2->jumlah_pemeriksaan;
							if($j==1){ 
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $bulan.' '.$thn);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_pasien);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jumlah_pemeriksaan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total);
							 	$i++;
							} else { 
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_pasien);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jumlah_pemeriksaan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total);
							}
							$j++;
							$rowCount++;
						}
					}
				}*/

				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtotkunj);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtotdiskon);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtottotal);
								
				header('Content-Disposition: attachment;filename="Lap_Keu_IRD_Tahun_'.$thn.'.xlsx"'); 
			}else{
				redirect('ird/IrDLaporan/data_pendapatan','refresh');
			}
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
	////////////////////////////////////////////////
	public function export_excel2($tampil_per='',$param1='',$cara_bayar='')
	{
		$data['title'] = 'Laporan Kunjungan Rawat Darurat';

		$tgl_indo=new Tglindo();
		

		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		//print_r($tampil);
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
		////EXCEL 
		//$this->load->library('Excel');  
		$this->load->file(APPPATH.'third_party/PHPExcel.php'); 
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Laporan Keuangan ".$namars)  
		        ->setSubject("Laporan Keuangan ".$namars." Document")  
		        ->setDescription("Laporan Keuangan ".$namars." for Office 2007 XLSX, generated by HMIS.")  
		        ->setKeywords($namars)  
		        ->setCategory("Laporan Keuangan");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);


		////		
		if($tampil_per=='TGL'){	
			if($param1!=''){

				$tgl=$param1;
				$tgl1 = date('d F Y', strtotime($tgl));				
				$data_laporan_kunj=$this->ModelLaporan->get_data_kunj_range($tgl,$cara_bayar)->result();
				//$data_keuangan=$this->ModelLaporan->get_data_keuangan_tgl($tgl)->result();
					
				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_kunj_ird_tgl.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  
				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$tgl1);
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Pasien : '.$cara_bayar);
				$vtot1=0;$vtot2=0;
				$i=1;
				$rowCount = 5;

				foreach($data_laporan_kunj as $row){
					$no_register=$row->no_register;
					
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
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->nama);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->id_diagnosa);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->diagnosa);
								

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
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total Kunjungan');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,  $i-1);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount)->applyFromArray(
				    array(
					'fill' => array(
					    'type' => PHPExcel_Style_Fill::FILL_SOLID,
					    'color' => array('rgb' => 'C1B2B2')
					)
				    )
				);
				
				header('Content-Disposition: attachment;filename="Lap_Kunj_IRD_TGL_'.date('d-m-Y', strtotime($tgl)).'.xlsx"');  
					
			}else{
				redirect('ird/IrDLaporan/data_pendapatan','refresh');
			}
		}else if($tampil_per=='BLN'){
			if($param1!=''){
				$bln=$param1;
				$blnindo=$tgl_indo->bulan(date('m', strtotime($bln)));
				$bln1 = $blnindo.' '.date('Y', strtotime($bln));
											
				$data_kunj=$this->ModelLaporan->get_data_kunj_bln($bln)->result();
				

				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_kunj_ird_bln.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  

				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Bulan : '.$bln1);
				
				$i=1;
				$vtottotal=0;
				$vtotdiskon=0;
				$vtot_pemeriksaan=0;
				$rowCount = 5;

				foreach($data_kunj as $row){
						
							$bln3 = date('d', strtotime($row->hari));
							$bln2 = date('m', strtotime($row->hari));
							$bulan = $tgl_indo->bulan($bln2);
							$vtottotal=$vtottotal+$row->jum_kunj;
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $bln3.' '.$bulan);

								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->jum_kunj);
								
							 	$i++;
							
							$rowCount++;
						
				}// if
/*				foreach($data_periode as $row){
					$j=1;
					$vtottotal=0;
					$vtotjumpas=0;
					$vtotjumpem=0;
					foreach($data_keuangan as $row2){
						if($row2->tgl==$row->tgl){
							$bln3 = date('d', strtotime($row2->tgl));
							$bln2 = date('m', strtotime($row2->tgl));
							$bulan = $tgl_indo->bulan($bln2);
							$vtottotal=$vtottotal+$row2->total;
							$vtotjumpas=$vtotjumpas+$row2->jumlah_pasien;
							$vtotjumpem=$vtotjumpem+$row2->jumlah_pemeriksaan;
							$vtot=$vtot+$row2->total;
							$vtot_pasien=$vtot_pasien+$row2->jumlah_pasien;
							$vtot_pemeriksaan=$vtot_pemeriksaan+$row2->jumlah_pemeriksaan;
							if($j==1){ 
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $bln3.' '.$bulan);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_pasien);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jumlah_pemeriksaan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total);
							 	$i++;
							} else { 
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_pasien);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jumlah_pemeriksaan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total);
							}
							$j++;
							$rowCount++;
						} // if
					}
				}*/
				

				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total Kunjungan');
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtottotal);				
				
				header('Content-Disposition: attachment;filename="Lap_Kunj_IRD_Bulan_'.date('m-Y', strtotime($tgl)).'.xlsx"');  
			}
			else{
				redirect('ird/IrDLaporan/data_pendapatan','refresh');
			}
		}else{
			if($param1!=''){
				$thn=$param1;
				$thn1 = date('Y', strtotime($thn));
				
				$date_title='<b>'.$thn1.'</b>';
				$file_name="KUNJ_IRD_$thn1.pdf";

				//$data_laporan_keu=$this->Labmlaporan->get_data_keu_tind_thn($thn)->result();
								
					$data_kunj=$this->ModelLaporan->get_data_kunj_thn($thn)->result();
				
				
				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_kunj_ird_thn.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  

				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tahun : '.$thn);
			
				
				$i=1;
				$vtottotal=0;
				$vtot_pemeriksaan=0;
				$rowCount = 5;

				foreach($data_kunj as $row){
					
							$thn = date('Y', strtotime($row->bulan));
							$bln2 = date('m', strtotime($row->bulan));
							$bulan = $tgl_indo->bulan($bln2);
							$vtottotal=$vtottotal+$row->jum_kunj;

							$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
							$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $bulan.' '.$thn);
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->jum_kunj);
							
							$i++;
							$rowCount++;

					
					}

				/*foreach($data_periode as $row){
					$j=1;
					$vtottotal=0;
					$vtotjumpas=0;
					$vtotjumpem=0;
					foreach($data_keuangan as $row2){
						if($row2->bln==$row->bln){
							$thn = date('Y', strtotime($row2->bln));
							$bln2 = date('m', strtotime($row2->bln));
							$bulan = $tgl_indo->bulan($bln2);
							$vtottotal=$vtottotal+$row2->total;
							$vtotjumpas=$vtotjumpas+$row2->jumlah_pasien;
							$vtotjumpem=$vtotjumpem+$row2->jumlah_pemeriksaan;
							$vtot=$vtot+$row2->total;
							$vtot_pasien=$vtot_pasien+$row2->jumlah_pasien;
							$vtot_pemeriksaan=$vtot_pemeriksaan+$row2->jumlah_pemeriksaan;
							if($j==1){ 
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $bulan.' '.$thn);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_pasien);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jumlah_pemeriksaan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total);
							 	$i++;
							} else { 
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_pasien);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jumlah_pemeriksaan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total);
							}
							$j++;
							$rowCount++;
						}
					}
				}*/

				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total Kunjungan');
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtottotal);
				
				header('Content-Disposition: attachment;filename="Lap_Kunj_IRD_Tahun_'.$thn.'.xlsx"'); 
			}else{
				redirect('ird/IrDLaporan/data_pendapatan','refresh');
			}
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

}
?>
