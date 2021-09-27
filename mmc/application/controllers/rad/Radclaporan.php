 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
//
include(dirname(dirname(__FILE__)).'/Tglindo.php');
require_once(APPPATH.'controllers/Secure_area.php');
class Radclaporan extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('ird/ModelKwitansi','',TRUE);
		$this->load->model('rad/Radmlaporan','',TRUE);
		$this->load->helper('pdf_helper');
		$this->load->helper('url');
		//include(site_url('/application/controllers/Tglindo.php'));
		//echo site_url('/application/controllers/Tglindo.php');
	}
	public function index()
	{
		redirect('rad/Radcdaftar','refresh');
	}

	public function data_kunjungan()
	{
		//$this->session->set_flashdata('message_nodata','');
		$data['title'] = 'Laporan Kunjungan Radiologi';
		$data['pemeriksaan_title']="Laporan per Pemeriksaan :";

		if($_SERVER['REQUEST_METHOD']=='POST'){
				$tampil_per=$this->input->post('tampil_per');				
				$tgl_indo=new Tglindo();
				if($tampil_per=='TGL'){
					//$tgl_awal=$this->input->post('date_picker_days1');
					//if(){
					//}
					$tgl=$this->input->post('date_picker_days');					
					
					$data['data_laporan_kunj']=$this->Radmlaporan->get_data_kunj_by_date($tgl)->result();
					$data['data_tindakan']=$this->Radmlaporan->get_data_tindakan_tgl($tgl)->result();
					$data['data_pemeriksaan']=$this->Radmlaporan->get_data_pemeriksaan_tgl($tgl)->result();
					$tgl1 = date('d F Y', strtotime($tgl));
					$data['date_title']="Laporan Kunjungan Pasien Radiologi <b>$tgl1</b>";
					$data['field1']='No. Medrec';					
					$data['tgl']=$tgl;
				}else if($tampil_per=='BLN'){
					$bln=$this->input->post('date_picker_months');

					
					//echo $this->input->post('date_picker_months');

					$data['data_laporan_kunj']=$this->Radmlaporan->get_data_kunj_bln($bln)->result();
					$data['data_tindakan']=$this->Radmlaporan->get_data_tindakan_bln($bln)->result();
					$data['data_pemeriksaan']=$this->Radmlaporan->get_data_pemeriksaan_bln($bln)->result();
					
					$bln1 = date('F Y', strtotime($bln));
					$bln2 = date('m', strtotime($bln));
					$bln3 = $tgl_indo->bulan($bln2);
					$data['date_title']="Laporan Kunjungan Pasien Radiologi per Hari <b>Bulan $bln3</b>";
					$data['pemeriksaan_title']="Laporan Pemeriksaan :";
					$data['field1']='Tanggal';					
					$data['date']=$bln;//untuk param waktu cetak
					$data['bln']=$bln;
					//print_r($bln2);
				}else{
					$thn=$this->input->post('date_picker_years');
					$data['data_laporan_kunj']=$this->Radmlaporan->get_data_kunj_thn($thn)->result();
					$data['data_tindakan']=$this->Radmlaporan->get_data_tindakan_thn($thn)->result();
					$data['data_pemeriksaan']=$this->Radmlaporan->get_data_pemeriksaan_thn($thn)->result();
					
					$data['date_title']="Laporan Kunjungan Pasien Radiologi <b>Tahun $thn</b>";
					$data['pemeriksaan_title']="Laporan Pemeriksaan :";
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

			$this->load->view('rad/radvlapkunjunganrange.php',$data);
		}else{
			$data['data_laporan_kunj']=$this->Radmlaporan->get_data_kunj_today()->result();
			$data['data_tindakan']=$this->Radmlaporan->get_data_tindakan()->result();
			$data['data_pemeriksaan']=$this->Radmlaporan->get_data_pemeriksaan()->result();
			$data['date_title']='Laporan Kunjungan Pasien Radiologi <b>'.date("d F Y").'</b>';
			$data['tgl']=date("Y-m-d");
			$data['field1']='No. Medrec';
			$data['tampil_per']='TGL';		
			
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

			$this->load->view('rad/radvlapkunjunganrange.php',$data);
		}
	}

	///////////////////////////////////////////////////////////////////////////// PENDAPATAN

	public function data_pendapatan($tampil_per='', $param1='')
	{
		$data['title'] = 'Laporan Pendapatan Penunjang Radiologi';				

		$tgl_indo=new Tglindo();
		// if($_SERVER['REQUEST_METHOD']=='POST'){
		// 		$tampil_per=$this->input->post('tampil_per');			
		// 		if($tampil_per=='TGL'){
		// 			$tgl=$this->input->post('date_picker_days');
		// 			$data['data_laporan_keu']=$this->Radmlaporan->get_data_keu_tind_tgl($tgl)->result();
		// 			$data['data_keuangan']=$this->Radmlaporan->get_data_keuangan_tgl($tgl)->result();
		// 			$data['cara_bayar_pasien']="";
		// 			$tgl1= date('d F Y', strtotime($tgl));
					
		// 			$data['date_title']="<b>$tgl1</b>";
		// 			$data['field1']='No. Register';
		// 			$data['tgl']=$tgl;
					
		// 		}else if($tampil_per=='BLN'){
		// 			$bln=$this->input->post('date_picker_months');			

		// 			$data['data_laporan_keu']=$this->Radmlaporan->get_data_keu_tind_bln($bln)->result();

		// 			$cara_bayar=$this->input->post('jenis_pasien1');	
		// 			$data['jenis_bayar']=$this->input->post('jenis_pasien1');			
		// 			if($cara_bayar==''){
		// 				$data['cara_bayar_pasien']="";
		// 				$data['data_periode']=$this->Radmlaporan->get_data_periode_bln($bln)->result();
		// 				$data['data_keuangan']=$this->Radmlaporan->get_data_keuangan_bln($bln)->result();
		// 			} else {
		// 				$data['cara_bayar_pasien']="<br><br>Pasien : <b>".$cara_bayar."</b>";
		// 				$data['data_periode']=$this->Radmlaporan->get_data_periode_bln_bycarabayar($bln, $cara_bayar)->result();
		// 				$data['data_keuangan']=$this->Radmlaporan->get_data_keuangan_bln_bycarabayar($bln, $cara_bayar)->result();
		// 			}
		// 			$bln1 = date('Y', strtotime($bln));
		// 			$bln2 = date('m', strtotime($bln));
		// 			$bln3 = $tgl_indo->bulan($bln2);
		// 			//echo $tgl_indo->bulan('08');
		// 			$data['date_title']="per Hari <b>Bulan $bln3 $bln1</b>";
		// 			$data['field1']='Tanggal';
		// 			$data['tgl']=$bln3;
		// 			$data['bln']=$bln;
		// 			$data['date']=$bln;//untuk param waktu cetak

		// 		}else{					
					
		// 			$thn=$this->input->post('date_picker_years');
		// 			$data['data_laporan_keu']=$this->Radmlaporan->get_data_keu_tind_thn($thn)->result();
		// 			$cara_bayar=$this->input->post('jenis_pasien2');	
		// 			$data['jenis_bayar']=$this->input->post('jenis_pasien2');		
		// 			if($cara_bayar==''){
		// 				$data['cara_bayar_pasien']="";
		// 				$data['data_periode']=$this->Radmlaporan->get_data_periode_thn($thn)->result();
		// 				$data['data_keuangan']=$this->Radmlaporan->get_data_keuangan_thn($thn)->result();
		// 			} else {
		// 				$data['cara_bayar_pasien']="<br><br>Pasien : <b>".$cara_bayar."</b>";
		// 				$data['data_periode']=$this->Radmlaporan->get_data_periode_thn_bycarabayar($thn, $cara_bayar)->result();
		// 				$data['data_keuangan']=$this->Radmlaporan->get_data_keuangan_thn_bycarabayar($thn, $cara_bayar)->result();
		// 			}
		// 			$data['date_title']="per Bulan <b> Tahun $thn</b>";
		// 			$data['field1']='Bulan';
		// 			$data['date']=$thn;//untuk param waktu cetak
		// 			$data['thn']=$thn;
		// 			$data['tgl_indo']=$tgl_indo;
		// 		}
		// 		$data['tampil_per']=$this->input->post('tampil_per');//untuk param waktu cetak
				
		// 		$size=sizeof($data['data_laporan_keu']);
		// 		//$data['size']=$size;
		// 		if($size<1){
		// 		//echo "hahahaha";
		// 		$data['message_nodata']="<div class=\"content-header\">
		// 		<div class=\"alert alert-danger alert-dismissable\">
		// 			<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
		// 		<h4><i class=\"icon fa fa-close\"></i>
		// 			Tidak Ditemukan Data
		// 		</h4>							
		// 		</div>
		// 	</div>";
		// 		$data['size']='';
		// 		}else{
		// 			$data['message_nodata']='';
		// 			$data['size']=$size;
		// 		}

		// 	$this->load->view('rad/pend_today',$data);
		// }else{			
		// 	$data['data_laporan_keu']=$this->Radmlaporan->get_data_keu_tindakan_today()->result();
		// 	$data['data_keuangan']=$this->Radmlaporan->get_data_keuangan_today()->result();
		// 	$data['date_title']='<b>'.date("d F Y").'</b>';
		// 	$data['tgl']=date("Y-m-d");
		// 	$data['field1']='No. Register';
		// 	$data['stat_pilih']='';
		// 	$data['tampil_per']='TGL';
		// 	$data['cara_bayar_pasien']="";

		// 	$size=sizeof($data['data_laporan_keu']);
		// 		//$data['size']=$size;
		// 		if($size<1){
		// 		//echo "hahahaha";
		// 		$data['message_nodata']="<div class=\"content-header\">
		// 		<div class=\"alert alert-danger alert-dismissable\">
		// 			<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
		// 		<h4><i class=\"icon fa fa-close\"></i>
		// 			Tidak Ditemukan Data
		// 		</h4>							
		// 		</div>
		// 	</div>";
		// 		$data['size']='';
		// 		}else{
		// 			//echo "hahahahdwadawdwafawfeagageaga";
		// 			$data['message_nodata']='';
		// 			$data['size']=$size;
		// 		}

		// 	$this->load->view('rad/pend_today',$data);
		// 	//redirect('ird/IrDLaporan/data','refresh');
		// }
		
		$data['date_title']='<b>'.date("d F Y").'</b>';
		$data['tgl']=date("Y-m-d");

		$data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Pendapatan.
			</h4>							
			</div>
		</div>";

		$this->load->view('rad/radvpendapatan',$data);


	}

	public function lap_keu($tampil_per='',$param1='',$param2='')
	{
		$data['title'] = 'Laporan Keuangan Radiologi';

		$tgl_indo=new Tglindo();
		$tampil = substr($tampil_per, 0, 3);
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		//print_r($tampil);
		$namars=$this->config->item('namars');
		$alamat=$this->config->item('alamat');
		$kota_kab=$this->config->item('kota');
		$konten="<table>
					<tr>
						<td colspan=\"2\">
							<p align=\"left\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p>
						</td>
						<td align=\"right\"><font size=\"8\" align=\"right\">$tgl_jam</font></td>
					</tr>
					<tr>
						<td colspan=\"3\">
							<b><font size=\"9\" align=\"right\">$alamat</font></b>
						</td>
					</tr><hr>
					<tr>
						<td colspan=\"3\"><p align=\"center\"><br><b>Laporan Keuangan Radiologi</b></p></td>
					</tr>
					<tr>
						<td></td>
					</tr>";

		$tampil_per=$tampil;		
		if($tampil_per=='TGL'){	
			if($param1!=''){
				$tgl=$param1;
				$tgl1 = date('d F Y', strtotime($tgl));
				
				$date_title='<b>'.$tgl1.'</b>';
				$file_name="KEU_RAD_$tgl.pdf";
				
				$data_laporan_keu=$this->Radmlaporan->get_data_keu_tind_tgl($tgl)->result();
				$data_keuangan=$this->Radmlaporan->get_data_keuangan_tgl($tgl)->result();
			
				$konten=$konten."
							<tr>
								<td width=\"10%\"><b>Tanggal</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>
						</table>
						<br/><hr>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td width=\"3%\"><b>No</b></td>
								<td width=\"10%\"><b>No Medrec</b></td>
								<td width=\"10%\"><b>No Register</b></td>
								<td width=\"26%\"><b>Nama</b></td>
								<td width=\"31%\"><b>Jenis Pemeriksaan</b></td>
								<td width=\"20%\" align=\"right\"><b>Biaya Pemeriksaan</b></td>
							</tr>
						";
						
					$jum_vtot=0;
					$vtot1=0;
					$i=1;
					foreach($data_laporan_keu as $row){
						$no_register=$row->no_register;
						$j=1;		
						foreach($data_keuangan as $row2){
							if ($row2->no_register==$no_register) {
								$vtot1=$vtot1+$row2->vtot;
								//$jum_vtot = $jum_vtot+$row2->total;
								if($j==1){ 
									$konten=$konten."
									<tr>
										<td>".$i++."</td>
										<td>$row->no_cm</td>
										<td>$row->no_register</td>
										<td>$row->nama</td>
										<td>$row2->jenis_tindakan</td>
										<td><p align=\"right\">".number_format($row2->vtot, 2 , ',' , '.' )."</p></td>
									</tr>";
								 } else { 
								 	$konten=$konten."
									<tr>
										<td colspan=\"4\" bgcolor=\"#cdd4cb\"></td>
										<td>$row2->jenis_tindakan</td>
										<td><p align=\"right\">".number_format($row2->vtot, 2 , ',' , '.' )."</p></td>
									</tr>";
								 }
							$j++;
							} // if
						}
					}

					
					$konten=$konten."
						<tr>
							<th colspan=\"5\" bgcolor=\"#cdd4cb\"><p align=\"right\"><b>Total   </b></p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot1, 2 , ',' , '.' )."</p></th>
						</tr>
					</table>
				";//print_r($konten);
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->setPrintHeader(false);
					$obj_pdf->SetHeaderData('', '', $title, '');
					$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
					$obj_pdf->SetDefaultMonospacedFont('helvetica');
					$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
					$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
					$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
					$obj_pdf->SetAutoPageBreak(TRUE, '15');
					$obj_pdf->SetFont('helvetica', '', 11);
					$obj_pdf->setFontSubsetting(false);
					$obj_pdf->AddPage();
					ob_start();
						$content = $konten;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');
					$obj_pdf->Output(FCPATH.'download/rad/radlaporan/keu/'.$file_name, 'FI');
						
			}else{
				redirect('rad/Radclaporan/data_pendapatan','refresh');
			}
		}else if($tampil_per=='BLN'){
			if($param1!=''){
				$bln=$param1;
				$bln1 = date('F Y', strtotime($bln));
				
				$date_title='<b>'.$bln1.'</b>';
				$file_name="KEU_RAD_$bln1.pdf";


				//$data_laporan_keu=$this->Radmlaporan->get_data_keu_tind_bln($bln)->result();
				if($param2!=''){
					$data_periode=$this->Radmlaporan->get_data_periode_bln_bycarabayar($bln, $param2)->result();
					$data_keuangan=$this->Radmlaporan->get_data_keuangan_bln_bycarabayar($bln, $param2)->result();
				} else {
					$data_periode=$this->Radmlaporan->get_data_periode_bln($bln)->result();
					$data_keuangan=$this->Radmlaporan->get_data_keuangan_bln($bln)->result();
				}
				
				$konten=$konten."
							<tr>
								<td width=\"10%\"><b>Bulan</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>";
				if($param2!=''){
					if($param2!='BPJS'){
						$jenis_param2=ucfirst(strtolower($param2));
					} else {
						$jenis_param2=$param2;
					}
					$konten=$konten."
							<tr>
								<td width=\"10%\"><b>Pasien</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">".$jenis_param2."</td>
							</tr>";
				}

				$konten=$konten."
						</table>
						<br/><hr/>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td rowspan=\"2\" width=\"5%\"><b>No</b></td>
								<td rowspan=\"2\" width=\"10%\"><b>Tanggal</b></td>
								<td rowspan=\"2\" width=\"39%\"><b>Jenis Pemeriksaan</b></td>
								<td colspan=\"2\" width=\"26%\" align=\"center\"><b>Jumlah</b></td>
								<td rowspan=\"2\" width=\"20%\"><b>Biaya Total</b></td>
							</tr>
							<tr>
								<td width=\"11%\"><b>Pasien</b></td>
								<td width=\"15%\"><b>Pemeriksaan</b></td>
							</tr>
						";
						$i=1;
						$vtot=0;
						$vtot_pasien=0;
						$vtot_pemeriksaan=0;
						foreach($data_periode as $row){
							//$vtot=$vtot+$row->total;
							if($param2!=''){
								$rwspn=count($this->Radmlaporan->row_table_pertgl_bycarabayar($row->tgl, $param2)->result());
							} else {
								$rwspn=count($this->Radmlaporan->row_table_pertgl($row->tgl)->result());
							}
							
							$rwspn1=$rwspn+1;
							$j=1;
							$vtottotal=0;
							$vtotjumpas=0;
							$vtotjumpem=0;
							foreach($data_keuangan as $row2){
								if($row2->tgl==$row->tgl){
									$bln1 = date('d', strtotime($row2->tgl));
									$bln2 = date('m', strtotime($row2->tgl));
									$bulan = $tgl_indo->bulan($bln2);
									$vtottotal=$vtottotal+$row2->total;
									$vtotjumpas=$vtotjumpas+$row2->jumlah_pasien;
									$vtotjumpem=$vtotjumpem+$row2->jumlah_pemeriksaan;
									$vtot=$vtot+$row2->total;
									$vtot_pasien=$vtot_pasien+$row2->jumlah_pasien;
									$vtot_pemeriksaan=$vtot_pemeriksaan+$row2->jumlah_pemeriksaan;
									$konten=$konten."
										<tr>";
										if($j=='1'){
											$konten=$konten."
											<td rowspan=\"$rwspn1\">".$i++."</td>
											<td rowspan=\"$rwspn\">$bln1 $bulan</td>";
										}
									$konten=$konten."
											<td>$row2->jenis_tindakan</td>
											<td>$row2->jumlah_pasien</td>
											<td>$row2->jumlah_pemeriksaan</td>
											<td align=\"right\">".number_format($row2->total, 2 , ',' , '.' )."</td>
										</tr>";
								$j++;
								}
							}
							$konten=$konten."
										<tr>
											<td colspan=\"2\"  align=\"right\" bgcolor=\"#cdd4cb\">Total</td>
											<td align=\"right\" bgcolor=\"#cdd4cb\">$vtotjumpas</td>
											<td align=\"right\" bgcolor=\"#cdd4cb\">$vtotjumpem</td>
											<th bgcolor=\"#cdd4cb\"><p align=\"right\">".number_format($vtottotal, 2 , ',' , '.' )."</p></th>
										</tr>";
						}
							$konten=$konten."
							<tr>
								<th bgcolor=\"#cdd4cb\" colspan=\"3\"><p align=\"right\"><b>Total Pasien $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">$vtot_pasien</p></th>
								<th bgcolor=\"#cdd4cb\"></th>
								<th bgcolor=\"#cdd4cb\"></th>
							</tr>
							<tr>
								<th bgcolor=\"#cdd4cb\" colspan=\"4\"><p align=\"right\"><b>Total Pemeriksaan $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">$vtot_pemeriksaan</p></th>
								<th bgcolor=\"#cdd4cb\"></th>
							</tr>
							<tr>
								<th bgcolor=\"#cdd4cb\" colspan=\"5\"><p align=\"right\"><b>Total Pendapatan $date_title</b></p></th>
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
					$obj_pdf->setPrintHeader(false);
					$obj_pdf->SetHeaderData('', '', $title, '');
					$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
					$obj_pdf->SetDefaultMonospacedFont('helvetica');
					$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
					$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
					$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
					$obj_pdf->SetAutoPageBreak(TRUE, '15');
					$obj_pdf->SetFont('helvetica', '', 11);
					$obj_pdf->setFontSubsetting(false);
					$obj_pdf->AddPage();
					ob_start();
						$content = $konten;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');
					$obj_pdf->Output(FCPATH.'download/rad/radlaporan/keu/'.$file_name, 'FI');
			}else{
				redirect('rad/Radclaporan/data_pendapatan','refresh');
			}
		}else{
			if($param1!=''){
				$thn=$param1;
				print_r($status);
				$thn1 = date('Y', strtotime($thn));
								
				$date_title='<b>'.$thn1.'</b>';
				$file_name="KEU_RAD_$thn1.pdf";

				//$data_laporan_keu=$this->Radmlaporan->get_data_keu_tind_thn($thn)->result();
				if($param2!=''){
					$data_periode=$this->Radmlaporan->get_data_periode_thn_bycarabayar($thn, $param2)->result();
					$data_keuangan=$this->Radmlaporan->get_data_keuangan_thn_bycarabayar($thn, $param2)->result();
				} else {
					$data_periode=$this->Radmlaporan->get_data_periode_thn($thn)->result();
					$data_keuangan=$this->Radmlaporan->get_data_keuangan_thn($thn)->result();
				}
			
				$konten=$konten."
							<tr>
								<td width=\"10%\"><b>Tahun</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>";
				if($param2!=''){
					if($param2!='BPJS'){
						$jenis_param2=ucfirst(strtolower($param2));
					} else {
						$jenis_param2=$param2;
					}
					$konten=$konten."
							<tr>
								<td width=\"10%\"><b>Pasien</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">".$jenis_param2."</td>
							</tr>";
				}

				$konten=$konten."
						</table>
						<br/><hr/>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td rowspan=\"2\" width=\"5%\"><b>No</b></td>
								<td rowspan=\"2\" width=\"14%\"><b>Bulan</b></td>
								<td rowspan=\"2\" width=\"35%\"><b>Jenis Pemeriksaan</b></td>
								<td colspan=\"2\" width=\"26%\" align=\"center\"><b>Jumlah</b></td>
								<td rowspan=\"2\" width=\"20%\"><b>Biaya Total</b></td>
							</tr>
							<tr>
								<td width=\"11%\"><b>Pasien</b></td>
								<td width=\"15%\"><b>Pemeriksaan</b></td>
							</tr>
						";
						$i=1;
						$vtot=0;
						$vtot_pasien=0;
						$vtot_pemeriksaan=0;
						foreach($data_periode as $row){
							//$vtot=$vtot+$row->total;
							if($param2!=''){
								$rwspn=count($this->Radmlaporan->row_table_perbln_bycarabayar($row->bln, $param2)->result());
							} else {
								$rwspn=count($this->Radmlaporan->row_table_perbln($row->bln)->result());
							}
							$rwspn1=$rwspn+1;
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
									$konten=$konten."
										<tr>";
										if($j=='1'){
											$konten=$konten."
											<td rowspan=\"$rwspn1\">".$i++."</td>
											<td rowspan=\"$rwspn\">$bulan $thn</td>";
										}
									$konten=$konten."
											<td>$row2->jenis_tindakan</td>
											<td>$row2->jumlah_pasien</td>
											<td>$row2->jumlah_pemeriksaan</td>
											<td align=\"right\">".number_format($row2->total, 2 , ',' , '.' )."</td>
										</tr>";
								$j++;
								}
							}
							$konten=$konten."
										<tr>
											<td colspan=\"2\"  align=\"right\" bgcolor=\"#cdd4cb\">Total</td>
											<td align=\"right\" bgcolor=\"#cdd4cb\">$vtotjumpas</td>
											<td align=\"right\" bgcolor=\"#cdd4cb\">$vtotjumpem</td>
											<th bgcolor=\"#cdd4cb\"><p align=\"right\">".number_format($vtottotal, 2 , ',' , '.' )."</p></th>
										</tr>";
						}
							$konten=$konten."
							<tr>
								<th bgcolor=\"#cdd4cb\" colspan=\"3\"><p align=\"right\"><b>Total Pasien Tahun $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">$vtot_pasien</p></th>
								<th bgcolor=\"#cdd4cb\"></th>
								<th bgcolor=\"#cdd4cb\"></th>
							</tr>
							<tr>
								<th bgcolor=\"#cdd4cb\" colspan=\"4\"><p align=\"right\"><b>Total Pemeriksaan Tahun $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">$vtot_pemeriksaan</p></th>
								<th bgcolor=\"#cdd4cb\"></th>
							</tr>
							<tr>
								<th bgcolor=\"#cdd4cb\" colspan=\"5\"><p align=\"right\"><b>Total Pendapatan Tahun $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot, 2 , ',' , '.' )."</p></th>
							</tr>
						</table>"
					;
			//print_r($data_laporan_keu);
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->setPrintHeader(false);
					$obj_pdf->SetHeaderData('', '', $title, '');
					$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
					$obj_pdf->SetDefaultMonospacedFont('helvetica');
					$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
					$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
					$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
					$obj_pdf->SetAutoPageBreak(TRUE, '15');
					$obj_pdf->SetFont('helvetica', '', 11);
					$obj_pdf->setFontSubsetting(false);
					$obj_pdf->AddPage();
					ob_start();
						$content = $konten;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');
					$obj_pdf->Output(FCPATH.'download/rad/radlaporan/keu/'.$file_name, 'FI');
			}else{
				redirect('rad/Radclaporan/data_pendapatan','refresh');
			}
		}
	}

	public function export_excel($tampil_per='',$param1='',$param2='')
	{
		$data['title'] = 'Laporan Keuangan Radiologi';

		$tgl_indo=new Tglindo();
		$tampil = substr($tampil_per, 0, 3);
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		//print_r($tampil);
		$namars=$this->config->item('namars');
		$alamat=$this->config->item('alamat');
		$kota_kab=$this->config->item('kota');
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator("RSPATRIAIKKT")  
		        ->setLastModifiedBy("RSPATRIAIKKT")  
		        ->setTitle("Laporan Keuangan RS PATRIA IKKT")  
		        ->setSubject("Laporan Keuangan RS PATRIA IKKT Document")  
		        ->setDescription("Laporan Keuangan RS PATRIA IKKT for Office 2007 XLSX, generated by HMIS.")  
		        ->setKeywords("RS PATRIA IKKT")  
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
				
				$data_laporan_keu=$this->Radmlaporan->get_data_keu_tind_tgl($tgl)->result();
				$data_keuangan=$this->Radmlaporan->get_data_keuangan_tgl($tgl)->result();
					
				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_rad_tgl.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  
				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$tgl1);
				$vtot1=0;
				$i=1;
				$rowCount = 4;
				foreach($data_laporan_keu as $row){
					$no_register=$row->no_register;
					$j=1;		
					foreach($data_keuangan as $row2){
						if ($row2->no_register==$no_register) {
							$vtot1=$vtot1+$row2->vtot;
							if($j==1){ 
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->no_cm);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_register);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->nama);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->vtot);
							 	$i++;
							 } else { 
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->vtot);
							 }
						$j++;
						$rowCount++;
						} // if
					}
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtot1);
				header('Content-Disposition: attachment;filename="Lap_Keu_Radiologi_TGL.xlsx"');  
					
			}else{
				redirect('rad/Radclaporan/data_pendapatan','refresh');
			}
		}else if($tampil_per=='BLN'){
			if($param1!=''){
				$bln=$param1;
				$bln1 = date('F Y', strtotime($bln));
				
				if($param2!=''){
					$data_periode=$this->Radmlaporan->get_data_periode_bln_bycarabayar($bln, $param2)->result();
					$data_keuangan=$this->Radmlaporan->get_data_keuangan_bln_bycarabayar($bln, $param2)->result();
				} else {
					$data_periode=$this->Radmlaporan->get_data_periode_bln($bln)->result();
					$data_keuangan=$this->Radmlaporan->get_data_keuangan_bln($bln)->result();
				}

				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_rad_bln.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  

				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Bulan : '.$bln1);

				if($param2!=''){
					if($param2!='BPJS'){
						$jenis_param2=ucfirst(strtolower($param2));
					} else {
						$jenis_param2=$param2;
					}
				} else {
					$jenis_param2="Semua";
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Pasien : '.$jenis_param2);

				$i=1;
				$vtot=0;
				$vtot_pasien=0;
				$vtot_pemeriksaan=0;
				$rowCount = 6;
				foreach($data_periode as $row){
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
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Pasien '.$bln1);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot_pasien);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, '-');
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Pemeriksaan '.$bln1);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtot_pemeriksaan);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, '-');
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Pendapatan '.$bln1);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtot);
				header('Content-Disposition: attachment;filename="Lap_Keu_Radiologi_Bulan.xlsx"');  
			}
			else{
				redirect('rad/Radclaporan/data_pendapatan','refresh');
			}
		}else{
			if($param1!=''){
				$thn=$param1;
				$thn1 = date('Y', strtotime($thn));
								
				$date_title='<b>'.$thn1.'</b>';
				$file_name="KEU_RAD_$thn1.pdf";

				//$data_laporan_keu=$this->Radmlaporan->get_data_keu_tind_thn($thn)->result();
				if($param2!=''){
					$data_periode=$this->Radmlaporan->get_data_periode_thn_bycarabayar($thn, $param2)->result();
					$data_keuangan=$this->Radmlaporan->get_data_keuangan_thn_bycarabayar($thn, $param2)->result();
				} else {
					$data_periode=$this->Radmlaporan->get_data_periode_thn($thn)->result();
					$data_keuangan=$this->Radmlaporan->get_data_keuangan_thn($thn)->result();
				}

				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_rad_thn.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  

				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Tahun : '.$thn);


				if($param2!=''){
					if($param2!='BPJS'){
						$jenis_param2=ucfirst(strtolower($param2));
					} else {
						$jenis_param2=$param2;
					}
				} else {
					$jenis_param2="Semua";
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Pasien : '.$jenis_param2);
				$i=1;
				$vtot=0;
				$vtot_pasien=0;
				$vtot_pemeriksaan=0;
				$rowCount = 6;
				foreach($data_periode as $row){
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
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Pasien Tahun '.$bln1);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot_pasien);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, '-');
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Pemeriksaan Tahun '.$bln1);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtot_pemeriksaan);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, '-');
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Pendapatan Tahun '.$bln1);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, '-');
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $vtot);
				header('Content-Disposition: attachment;filename="Lap_Keu_Radiologi_Tahun.xlsx"'); 
			}else{
				redirect('rad/Radclaporan/data_pendapatan','refresh');
			}
		}

		// Rename worksheet (worksheet, not filename)  
		$objPHPExcel->getActiveSheet()->setTitle('RS PATRIA IKKT');  
		   
		   
		   
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

	public function download_keuangan($param1='',$param2=''){
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator("RS AL Marinir Cilandak")  
		        ->setLastModifiedBy("RS AL Marinir Cilandak")  
		        ->setTitle("Laporan Keuangan RS AL Marinir Cilandak")  
		        ->setSubject("Laporan Keuangan RS AL Marinir Cilandak Document")  
		        ->setDescription("Laporan Keuangan RS AL Marinir Cilandak, generated by HMIS.")  
		        ->setKeywords("RS AL Marinir Cilandak")  
		        ->setCategory("Laporan Keuangan");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);

		// $awal = $this->input->post('tanggal_awal');
		// $akhir = $this->input->post('tanggal_akhir');

		$data_keuangan=$this->Radmlaporan->get_data_keu_tind($param1, $param2)->result();
	
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_rad.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		// Add some data  
      	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('I3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('J3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('K3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('L3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('M3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('N3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('O3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->setAutoFilter('A3:O3');

		$objPHPExcel->getActiveSheet()->SetCellValue('A1', "Laporan Pendapatan Radiologi Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
      	$objPHPExcel->getActiveSheet()->mergeCells('A1:O1');
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$rowCount = 4;
		$temp = "";
		$temptgl = "";
		$total_pendapatan = 0;
		foreach($data_keuangan as $row){
			if($temptgl == $row->tgl_kunjungan){

			}else {
				$temptgl = $row->tgl_kunjungan;
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row->tgl_kunjungan);
			}

			if($temp == $row->no_rad){
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->jenis_tindakan);
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->biaya_rad);
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->qty);
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->vtot);
				$total_pendapatan = $total_pendapatan + $row->vtot;
				if($row->cara_bayar=="BPJS"){
					$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "BPJS");
				}else if($row->status=="1"){
					$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "Lunas");
				}else{
					$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "Belum Lunas");
				}
			}else {
				$temp = $row->no_rad;
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->no_rad);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_register);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->nama);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->no_medrec);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->kelas);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->idrg);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->bed);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->cara_bayar);
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->kontraktor);
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->jenis_tindakan);
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->biaya_rad);
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->qty);
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->vtot);
				$total_pendapatan = $total_pendapatan + $row->vtot;
				if($row->cara_bayar=="BPJS"){
					$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "BPJS");
				}else if($row->status=="1"){
					$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "Lunas");
				}else{
					$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "Belum Lunas");
				}
			}
			
			$rowCount++;
		}
		$filename = "Laporan Pendapatan Radiologi ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2));
		$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Total Pendapatan : ");
		$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_pendapatan);
		header('Content-Disposition: attachment;filename="'.$filename.'.xls"');  
				
		// Rename worksheet (worksheet, not filename)  
		$objPHPExcel->getActiveSheet()->setTitle('RS AL Marinir Cilandak');    
		   
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
		// $objWriter->save('php://output');  
		$this->SaveViaTempFile($objWriter);
	}

	static function SaveViaTempFile($objWriter){
		$filePath = sys_get_temp_dir() . "/" . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
		$objWriter->save($filePath);
		readfile($filePath);
		unlink($filePath);
	}
	
}
?>
