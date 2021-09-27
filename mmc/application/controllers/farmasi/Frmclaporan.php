 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
//
include(dirname(dirname(__FILE__)).'/Tglindo.php');
require_once(APPPATH.'controllers/Secure_area.php');
class Frmclaporan extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('ird/ModelPelayanan','',TRUE);
		$this->load->model('ird/ModelRegistrasi','',TRUE);
		$this->load->model('ird/ModelKwitansi','',TRUE);
		$this->load->model('ird/ModelLaporan','',TRUE);
		$this->load->model('farmasi/Frmmlaporan','',TRUE);
		$this->load->helper('pdf_helper');
		$this->load->helper('url');
		//include(site_url('/application/controllers/Tglindo.php'));
		//echo site_url('/application/controllers/Tglindo.php');
	}
	public function index()
	{
		redirect('farmasi/Frmcdaftar','refresh');
	}

	public function data_kunjungan()
	{
		//$this->session->set_flashdata('message_nodata','');
		$data['title'] = 'Laporan Kunjungan Farmasi';
		

		if($_SERVER['REQUEST_METHOD']=='POST'){			
				$tgl_indo=new Tglindo();
				//$tgl_awal=$this->input->post('date_picker_days1');
				//if(){
				//}
				$tgl=$this->input->post('date_picker_days');					
				
				$data['data_laporan_kunj']=$this->Frmmlaporan->get_data_kunj_by_date($tgl)->result();
				$data['data_tindakan']=$this->Frmmlaporan->get_data_tindakan_tgl($tgl)->result();
				
				$tgl1 = date('d F Y', strtotime($tgl));
				$data['date_title']="Laporan Kunjungan Farmasi <b>$tgl1</b>";
				$data['field1']='No. Medrec';					
				$data['tgl']=$tgl;
				
			
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

			$this->load->view('farmasi/frmvlapkunjunganrange.php',$data);
		}else{
			$data['data_laporan_kunj']=$this->Frmmlaporan->get_data_kunj_today()->result();
			$data['data_tindakan']=$this->Frmmlaporan->get_data_tindakan()->result();
			
			$data['date_title']='Laporan Kunjungan Pasien Farmasi <b>'.date("d F Y").'</b>';
			$data['tgl']=date("Y-m-d");
			$data['field1']='No. Medrec';	
			
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

			$this->load->view('farmasi/frmvlapkunjunganrange.php',$data);
		}
	}

	/*public function data_kunjungan($tampil_per='', $param1='')
	{
		$data['title'] = 'Laporan Kunjungan Farmasi';				

		$tgl_indo=new Tglindo();
		if($_SERVER['REQUEST_METHOD']=='POST'){
				$tampil_per=$this->input->post('tampil_per');			
				if($tampil_per=='TGL'){
					$tgl=$this->input->post('date_picker_days');
					$data['data_laporan_kunj']=$this->Frmmlaporan->get_data_kunj_tind_tgl($tgl)->result();
					$data['data_kunjungan']=$this->Frmmlaporan->get_data_keuangan_tgl($tgl)->result();
					$data['cara_bayar_pasien']="";
					$tgl1= date('d F Y', strtotime($tgl));
					
					$data['date_title']="<b>$tgl1</b>";
					$data['field1']='No. Register';
					$data['tgl']=$tgl;	
					}
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
					$data['message_nodata']='';
					$data['size']=$size;
				}

			$this->load->view('farmasi/frmvlapkunjunganrange',$data);
		}*/
	

	///////////////////////////////////////////////////////////////////////////// PENDAPATAN

	public function data_pendapatan($tampil_per='', $param1='')
	{
		$data['title'] = 'Laporan Pendapatan Farmasi';				

		$tgl_indo=new Tglindo();
		// if($_SERVER['REQUEST_METHOD']=='POST'){
		// 		$tampil_per=$this->input->post('tampil_per');			
		// 		if($tampil_per=='TGL'){
		// 			$tgl=$this->input->post('date_picker_days');
		// 			$data['data_laporan_keu']=$this->Frmmlaporan->get_data_keu_tind_tgl($tgl)->result();
					
		// 			$tgl1= date('d F Y', strtotime($tgl));
					
		// 			$data['date_title']="<b>$tgl1</b>";
		// 			$data['field1']='No. Register';
		// 			$data['tgl']=$tgl;
		// 			$data['cara_bayar_pasien']='';
					
					
					
				
		// 		}else if($tampil_per=='BLN'){
		// 			$bln=$this->input->post('date_picker_months');			
		// 			$data['data_laporan_keu']=$this->Frmmlaporan->get_data_keu_tind_bln($bln)->result();
		// 			$cara_bayar=$this->input->post('jenis_pasien1');	
		// 			$data['jenis_bayar']=$this->input->post('jenis_pasien1');			
					
		// 			if($cara_bayar==''){
		// 				$data['cara_bayar_pasien']="";
		// 				$data['data_periode']=$this->Frmmlaporan->get_data_periode_bln($bln)->result();
		// 				$data['data_keuangan']=$this->Frmmlaporan->get_data_keuangan_bln($bln)->result();
		// 			} else {
		// 				$data['cara_bayar_pasien']="<br><br>Pasien : <b>".$cara_bayar."</b>";
		// 				$data['data_periode']=$this->Frmmlaporan->get_data_periode_bln_bycarabayar($bln, $cara_bayar)->result();
		// 				$data['data_keuangan']=$this->Frmmlaporan->get_data_keuangan_bln_bycarabayar($bln, $cara_bayar)->result();
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
		// 			$data['data_laporan_keu']=$this->Frmmlaporan->get_data_keu_tind_thn($thn)->result();
		// 			$cara_bayar=$this->input->post('jenis_pasien2');	
		// 			$data['jenis_bayar']=$this->input->post('jenis_pasien2');		
		// 			if($cara_bayar==''){
		// 				$data['cara_bayar_pasien']="";
		// 				$data['data_periode']=$this->Frmmlaporan->get_data_periode_thn($thn)->result();
		// 				$data['data_keuangan']=$this->Frmmlaporan->get_data_keuangan_thn($thn)->result();
		// 			} else {
		// 				$data['cara_bayar_pasien']="<br><br>Pasien : <b>".$cara_bayar."</b>";
		// 				$data['data_periode']=$this->Frmmlaporan->get_data_periode_thn_bycarabayar($thn, $cara_bayar)->result();
		// 				$data['data_keuangan']=$this->Frmmlaporan->get_data_keuangan_thn_bycarabayar($thn, $cara_bayar)->result();
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
		// 			//echo "hahahahdwadawdwafawfeagageaga";
		// 			$data['message_nodata']='';
		// 			$data['size']=$size;
		// 		}

		// 	$this->load->view('farmasi/pend_today',$data);
		// }else{			
		// 	$data['data_laporan_keu']=$this->Frmmlaporan->get_data_keu_tindakan_today()->result();
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
		// 			$data['message_nodata']='';
		// 			$data['size']=$size;
		// 		}

		// 	$this->load->view('farmasi/pend_today',$data);
		// 	//redirect('ird/IrDLaporan/data','refresh');
		// }


		$data['date_title']='<b>'.date("d F Y").'</b>';
		$data['tgl']=date("Y-m-d");

		$data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Jenis Bayar dan Tanggal Kemudian Download untuk Melihat Laporan Pendapatan.
			</h4>							
			</div>
		</div>";

		$this->load->view('farmasi/frmvpendapatan',$data);
	}

	public function lap_keu($tampil_per='',$param1='',$param2='')
	{
		$data['title'] = 'Laporan Keuangan Farmasi';

		$tampil = substr($tampil_per, 0, 3);
		//print_r($tampil);
		$cara_bayar=$param2;

		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam=date("d-m-Y H:i:s");
		
		$data_rs=$this->ModelKwitansi->getdata_rs('10000')->result();
				$namars=$this->config->item('namars');
				$kota_kab=$this->config->item('kota');
				$alamat=$this->config->item('alamat');
				$nmsingkat=$this->config->item('namasingkat');
		$tampil_per=$tampil;		
		if($tampil_per=='TGL'){	
			if($param1!=''){
				$tgl=$param1;
				$tgl1 = date('d F Y', strtotime($tgl));
				
				
				$date_title='<b>'.$tgl1.'</b>';
				$file_name="KEU_FRM_$tgl1.pdf";
				
				$data_laporan_keu=$this->Frmmlaporan->get_data_keu_tind_tgl($tgl)->result();
			
				$konten=
						"
						<table>
							<tr>
								<td colspan=\"2\"><p align=\"left\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p>
								</td>
								<td align=\"right\">$tgl_jam</td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"left\"><font size=\"10\"><b>$alamat</b></font></p></td>
							</tr>
							<hr>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><b>Laporan Keuangan Farmasi</b></p></td>
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
						<br/><hr>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td width=\"5%\" align=\"left\"><b>No</b></td>
								<td width=\"50%\" align=\"center\"><b>Item Obat</b></td>
								<td width=\"10%\" align=\"center\"><b>Qty</b></td>
								<td width=\"35%\" align=\"center\"><b>Total</b></td>
							</tr>
						";
						$i=1;
						$vtot2=0;
						foreach($data_laporan_keu as $row){
							$vtot2=$vtot2+$row->vtot;
							$konten=$konten."
							<tr>
								<td>".$i++."</td>
								<td>$row->nama_obat</td>
								<td><p align=\"center\">$row->qty</p></td>
								<td><p align=\"right\">".number_format($row->vtot, 2 , ',' , '.' )."</p></td>
							</tr>";

						}	
						$konten=$konten."
							<tr>
								<th colspan=\"3\"><p align=\"right\"><b>Total   </b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot2, 2 , ',' , '.' )."</p></th>
							</tr>
						</table>
				";//print_r($konten);
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->SetPrintHeader(false);
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
					$obj_pdf->Output(FCPATH.'download/farmasi/Frmlaporan/'.$file_name, 'FI');
						
			}else{
				redirect('farmasi/Frmclaporan/data_pendapatan','refresh');
			}
		}else if($tampil_per=='BLN'){
			if($param1!=''){
				$bln=$param1;
				$bln1 = date('F Y', strtotime($bln));
								
				$date_title='<b>'.$bln1.'</b>';
				$file_name="KEU_FRM_$bln1.pdf";

				if($cara_bayar==''){
						
						$data_periode=$this->Frmmlaporan->get_data_periode_bln($bln)->result();
						$data_keuangan=$this->Frmmlaporan->get_data_keuangan_bln($bln)->result();
						$cara_bayar_pasien='Semua';
					} else {
						
						$data_periode=$this->Frmmlaporan->get_data_periode_bln_bycarabayar($bln, $cara_bayar)->result();
						$data_keuangan=$this->Frmmlaporan->get_data_keuangan_bln_bycarabayar($bln, $cara_bayar)->result();
						$cara_bayar_pasien=$cara_bayar;
					}
			
				$konten=
						"
						<table>
							<tr>
								<td colspan=\"2\"><p align=\"left\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p>
								</td>
								<td align=\"right\">$tgl_jam</td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"left\"><font size=\"10\"><b>$alamat</b></font></p></td>
							</tr>
							<hr>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><b>Laporan Keuangan Farmasi</b></p></td>
							</tr>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td width=\"10%\"><b>Tanggal</b></td>
								<td width=\"5%\">:</td>
								<td width=\"55%\">$date_title</td>	
								<td width=\"13%\"><b>Cara Bayar</b></td>
								<td width=\"5%\">:</td>
								<td width=\"35%\">$cara_bayar_pasien</td>
							</tr>
						</table>
						<br/><hr/>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td width=\"4%\"><b>No</b></td>
								<td width=\"12%\" align=\"center\"><b>Tanggal</b></td>
								<td width=\"50%\" align=\"center\"><b>Nama Obat</b></td>
								<td width=\"9%\" align=\"center\"><b>Jumlah Obat</b></td>
								<td width=\"25%\" align=\"center\"><b>Biaya Total</b></td>
							</tr>
						";
						$i=1;
						$vtot=0;
						foreach($data_periode as $row){
							//$vtot=$vtot+$row->total;
							if($param2!=''){
								$rwspn=count($this->Frmmlaporan->row_table_pertgl_bycarabayar($row->tgl, $param2)->result());
							}else{
							$rwspn=count($this->Frmmlaporan->row_table_pertgl($row->tgl)->result());
							}
							$rwspn1=$rwspn+1;
							$j=1;
							$vtot1=0;
							foreach($data_keuangan as $row2){
								if($row2->tgl==$row->tgl){
									$vtot1=$vtot1+$row2->total;
									$vtot=$vtot+$row2->total;
									$konten=$konten."
										<tr>";
										if($j=='1'){
											$konten=$konten."
											<td rowspan=\"$rwspn1\">".$i++."</td>
											<td rowspan=\"$rwspn\">$row2->tgl</td>";
										}
									$konten=$konten."
											<td>$row2->nama_obat</td>
											<td align=\"center\">$row2->jumlah</td>
											<td align=\"right\">".number_format($row2->total, 2 , ',' , '.' )."</td>
										</tr>";
								$j++;
								}
							}
							$konten=$konten."
										<tr>
											<td colspan=\"3\"  align=\"right\" bgcolor=\"grey\">Total</td>
											<th bgcolor=\"grey\"><p align=\"right\">".number_format($vtot1, 2 , ',' , '.' )."</p></th>
										</tr>";
						}
							$konten=$konten."
							<tr>
								<th colspan=\"4\"><p align=\"right\"><b>Total $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot, 2 , ',' , '.' )."</p></th>
							</tr>
						</table>
				";
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->SetPrintHeader(false);
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
					$obj_pdf->Output(FCPATH.'download/farmasi/Frmlaporan/'.$file_name, 'FI');
			}else{
				redirect('farmasi/Frmclaporan/data_pendapatan','refresh');
			}
		}else{
			if($param1!=''){
				$thn=$param1;
				//print_r($status);
				$thn1 = date('Y', strtotime($thn));
								
				$date_title='<b>'.$thn1.'</b>';
				$file_name="KEU_FRM_$thn1.pdf";

				if($cara_bayar==''){
						$data_periode=$this->Frmmlaporan->get_data_periode_thn($thn)->result();
						$data_keuangan=$this->Frmmlaporan->get_data_keuangan_thn($thn)->result();
						$cara_bayar_pasien='Semua';
					} else {
						$data_periode=$this->Frmmlaporan->get_data_periode_thn_bycarabayar($thn, $param2)->result();
						$data_keuangan=$this->Frmmlaporan->get_data_keuangan_thn_bycarabayar($thn, $param2)->result();
						$cara_bayar_pasien=$cara_bayar;
					}
			
				$konten=
						"
						<table>
							<tr>
								<td colspan=\"2\"><p align=\"left\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p>
								</td>
								<td align=\"right\">$tgl_jam</td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"left\"><font size=\"10\"><b>$alamat</b></font></p></td>
							</tr>
							<hr>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><b>Laporan Keuangan Farmasi</b></p></td>
							</tr>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td width=\"10%\"><b>Tanggal</b></td>
								<td width=\"5%\">:</td>
								<td width=\"55%\">$date_title</td>	
								<td width=\"13%\"><b>Cara Bayar</b></td>
								<td width=\"5%\">:</td>
								<td width=\"35%\">$cara_bayar_pasien</td>
							</tr>
						</table>
						<br/><hr/>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td width=\"4%\"><b>No</b></td>
								<td width=\"12%\" align=\"center\"><b>Bulan</b></td>
								<td width=\"50%\" align=\"center\"><b>Nama Obat</b></td>
								<td width=\"9%\" align=\"center\"><b>Jumlah Obat</b></td>
								<td width=\"25%\" align=\"center\"><b>Biaya Total</b></td>
							</tr>
						";
						$i=1;
						$vtot=0;
						foreach($data_periode as $row){
							//$vtot=$vtot+$row->total;
							if($param2!=''){
								$rwspn=count($this->Frmmlaporan->row_table_perbln_bycarabayar($row->bln, $param2)->result());
							}else{
							$rwspn=count($this->Frmmlaporan->row_table_perbln($row->bln)->result());
							}
							
							$rwspn1=$rwspn+1;
							$j=1;
							$vtot1=0;
							foreach($data_keuangan as $row2){
								if($row2->bln==$row->bln){
									$vtot1=$vtot1+$row2->total;
									$vtot=$vtot+$row2->total;
									$konten=$konten."
										<tr>";
										if($j=='1'){
											$konten=$konten."
											<td rowspan=\"$rwspn1\">".$i++."</td>
											<td rowspan=\"$rwspn\">$row2->bln</td>";
										}
									$konten=$konten."
											<td>$row2->nama_obat</td>
											<td align=\"center\">$row2->jumlah</td>
											<td align=\"right\">".number_format($row2->total, 2 , ',' , '.' )."</td>
										</tr>";
								$j++;
								}
							}
							$konten=$konten."
										<tr>
											<td colspan=\"3\"  align=\"right\" bgcolor=\"grey\">Total</td>
											<th bgcolor=\"grey\"><p align=\"right\">".number_format($vtot1, 2 , ',' , '.' )."</p></th>
										</tr>";
						}
							$konten=$konten."
							<tr>
								<th colspan=\"4\"><p align=\"right\"><b>Total $date_title</b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot, 2 , ',' , '.' )."</p></th>
							</tr>
						</table>
				";
			//print_r($data_laporan_keu);
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->SetPrintHeader(false);
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
					$obj_pdf->Output(FCPATH.'download/farmasi/Frmlaporan/'.$file_name, 'FI');
			}else{
				redirect('farmasi/Frmclaporan/data_pendapatan','refresh');
			}
		}
	}

		public function export_excel($tampil_per='',$param1='',$param2='')
	{
		$data['title'] = 'Laporan Keuangan Farmasi';

		$tgl_indo=new Tglindo();
		$tampil = substr($tampil_per, 0, 3);
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		//print_r($tampil);
			$namars=$this->config->item('namars');
				$kota_kab=$this->config->item('kota');
				$alamat=$this->config->item('alamat');
				$nmsingkat=$this->config->item('namasingkat');
		
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

		$tampil_per=$tampil;		
		if($tampil_per=='TGL'){	
			if($param1!=''){
				$tgl=$param1;
				$tgl1 = date('d F Y', strtotime($tgl));
				
				
				$date_title='<b>'.$tgl1.'</b>';
				$file_name="KEU_FRM_$tgl1.pdf";
				
				$data_laporan_keu=$this->Frmmlaporan->get_data_keu_tind_tgl($tgl)->result();
				
				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_farmasi_tgl.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  
				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$tgl1);
				$vtot1=0;
				$i=1;
				$rowCount = 5;
						foreach($data_laporan_keu as $row){
							$vtot1=$vtot1+$row->vtot;
							$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->nama_obat);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->qty);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->vtot);
								$rowCount++;
								$i++;
						}	
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total');
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot1);
							header('Content-Disposition: attachment;filename="Lap_Keu_Farmasi_TGL.xlsx"'); 
						
			}else{
				redirect('farmasi/Frmclaporan/data_pendapatan','refresh');
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			}else if($tampil_per=='BLN'){
			if($param1!=''){
				$bln=$param1;
				$bln1 = date('F Y', strtotime($bln));
								
				$date_title='<b>'.$bln1.'</b>';
				$file_name="KEU_FRM_$bln1.pdf";

				if($param2==''){
						$data_periode=$this->Frmmlaporan->get_data_periode_bln($bln)->result();
						$data_keuangan=$this->Frmmlaporan->get_data_keuangan_bln($bln)->result();
						$cara_bayar_pasien='Semua';
					} else {
						$data_periode=$this->Frmmlaporan->get_data_periode_bln_bycarabayar($bln, $param2)->result();
						$data_keuangan=$this->Frmmlaporan->get_data_keuangan_bln_bycarabayar($bln, $param2)->result();
						$cara_bayar_pasien=$cara_bayar;
					}
			
						$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_farmasi_bln.xlsx');
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
						$rowCount=5;
						$i=1;
						$vtot=0;
						foreach($data_periode as $row){
							//$vtot=$vtot+$row->total;
							$rwspn=count($this->Frmmlaporan->row_table_pertgl($row->tgl)->result());
							$rwspn1=$rwspn+1;

							$j=1;
							$vtot1=0;
							foreach($data_keuangan as $row2){
								if($row2->tgl==$row->tgl){
									$vtot1=$vtot1+$row2->total;
									$vtot=$vtot+$row2->total;
										if($j=='1'){
											$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tgl);
											$i++;
										}
									
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->nama_obat);
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah);
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->total);
										
								$j++;
							    $rowCount++;
								}
							}
									
						}
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total', $date_title);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtot);		
										
								header('Content-Disposition: attachment;filename="Lap_Keu_Farmasi_Bulan.xlsx"');  
					}else{
				redirect('farmasi/Frmclaporan/data_pendapatan','refresh');
			}
							
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			}else{
			if($param1!=''){
				$thn=$param1;
				//print_r($status);
				$thn1 = date('Y', strtotime($thn));
								
				$date_title='<b>'.$thn1.'</b>';
				$file_name="KEU_FRM_$thn1.pdf";

				if($param2==''){
						$data_periode=$this->Frmmlaporan->get_data_periode_thn($thn)->result();
						$data_keuangan=$this->Frmmlaporan->get_data_keuangan_thn($thn)->result();
						$cara_bayar_pasien='Semua';
					} else {
						$data_periode=$this->Frmmlaporan->get_data_periode_thn_bycarabayar($thn, $param2)->result();
						$data_keuangan=$this->Frmmlaporan->get_data_keuangan_thn_bycarabayar($thn, $param2)->result();
						$cara_bayar_pasien=$cara_bayar;
					}
			
					$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_farmasi_thn.xlsx');
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
					
						$rowCount = 6;
						$i=1;
						$vtot=0;
						foreach($data_periode as $row){
							//$vtot=$vtot+$row->total;
							$rwspn=count($this->Frmmlaporan->row_table_perbln($row->bln)->result());
							$rwspn1=$rwspn+1;
							$j=1;
							$vtot1=0;
							foreach($data_keuangan as $row2){
								if($row2->bln==$row->bln){
									
									$vtot=$vtot+$row2->total;
									
										if($j=='1'){
											$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->bln);
											$i++;
										}
								
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->nama_obat);
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah);
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->total);
										
									$j++;
							    	$rowCount++;
								}
							}	
										
						}
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total', $date_title);
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtot);
						header('Content-Disposition: attachment;filename="Lap_Keu_Farmasi_Tahun.xlsx"');  
				}else{
					redirect('farmasi/Frmclaporan/data_pendapatan','refresh');
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

	public function download_keuangan($param1='',$param2='', $jenis){
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

		$data_keuangan=$this->Frmmlaporan->get_data_keu_tind($param1, $param2, $jenis)->result();
	
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_farmasi.xlsx');
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
      	$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('P3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('P3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('Q3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('Q3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('R3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('S3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('T3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('T3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('U3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('U3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('V3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('V3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('W3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('W3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->setAutoFilter('A3:W3');

		$objPHPExcel->getActiveSheet()->SetCellValue('A1', "Laporan Pendapatan Farmasi Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
      	$objPHPExcel->getActiveSheet()->mergeCells('A1:W1');
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$rowCount = 4;
		$temp = "";
		$temptgl = "";
		$i=1;
		$total_pendapatan = 0;
		$total_diskon = 0;
		foreach($data_keuangan as $row){
			$obat_racik = "";
			if($row->racikan=="1"){
				$data_racikan = $this->Frmmlaporan->get_data_racikan($row->id_resep_pasien)->result();
				$n=1;
				foreach ($data_racikan as $key) {
					if($n==1){
						$obat_racik = $key->nm_obat;
					}else{
						$obat_racik = $obat_racik."\n".$key->nm_obat;
					}
					$n++;
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $obat_racik);
				$objPHPExcel->getActiveSheet()->getStyle('P'.$rowCount)->getAlignment()->setWrapText(true);
			}else{
				$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $row->obat);
			}
			/*if($temp == $row->no_resep){
				// $total_diskon = $total_diskon + $row->diskon;
				$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row->harga);
				$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $row->jumlah);
				$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $row->total_obat);
				$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $row->tuslah);
				$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->sub_total);
			}else {
				$temp = $row->no_resep;
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tgl_kunjungan);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_resep);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->no_register);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->no_medrec);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->no_kartu);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->nama);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->cara_bayar);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->kontraktor);
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->no_kartu);
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->pangkat);
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->kesatuan);
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->dokter);
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->ruangan);
				$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row->status);
				$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row->harga);
				$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $row->jumlah);
				$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $row->total_obat);
				$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $row->tuslah);
				$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->sub_total);
				$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $row->diskon);
				$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $row->total);
				$total_diskon = $total_diskon + $row->diskon;
				$total_pendapatan = $total_pendapatan + $row->total;
			}*/
			//Update Untuk Cilandak
			$temp = $row->no_resep;
            $sub_total = (int) (100 * ceil($row->sub_total / 100));
            $total = $sub_total - $row->diskon;
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tgl_kunjungan);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_resep);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->no_register);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->no_medrec);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->no_kartu);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->nama);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->cara_bayar);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->kontraktor);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->no_kartu);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->pangkat);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->kesatuan);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->dokter);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->ruangan);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row->status);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row->harga);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $row->jumlah);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $row->total_obat);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $row->tuslah);
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->sub_total);
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $row->diskon);
			$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $total);

            $total_diskon += $row->diskon;
			$total_pendapatan += $sub_total;
			$i++;
			$rowCount++;
		}
		$filename = "Laporan Pendapatan Farmasi ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2));
		$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, "Total : ");
		$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $total_diskon);
		$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $total_pendapatan);
		$objPHPExcel->getActiveSheet()->SetCellValue('V'.($rowCount+1), "Total Pendapatan : ");
		$objPHPExcel->getActiveSheet()->SetCellValue('W'.($rowCount+1), $total_pendapatan-$total_diskon);
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

    public function download_keuangan_new($param1='',$param2='', $jenis){
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

        $dataresep = $this->Frmmlaporan->find_no_racik($param1, $param2, $jenis)->result();
        $objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_farmasi.xlsx');
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
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('P3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('P3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('Q3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('Q3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('R3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('S3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('T3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('T3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('U3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('U3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('V3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('V3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('W3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('W3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setAutoFilter('A3:W3');

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', "Laporan Pendapatan Farmasi Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:W1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $rowCount = 4;
        $temp = "";
        $temptgl = "";
        $i=1;
        $total_pendapatan = 0;
        $total_diskon = 0;
        $total_resep = 0;
        foreach ($dataresep as $resep) {

            $subtotal_resep = (int) (1000 * ceil($resep->subtotal / 1000));
            $total_resep += $subtotal_resep;
            //$rowCount++;

            $data_keuangan=$this->Frmmlaporan->get_data_keu_tind_new($resep->no_resep, $jenis)->result();
            foreach($data_keuangan as $row){
                $obat_racik = "";
                if($row->racikan=="1"){
                    $data_racikan = $this->Frmmlaporan->get_data_racikan($row->id_resep_pasien)->result();
                    $n=1;
                    foreach ($data_racikan as $key) {
                        if($n==1){
                            $obat_racik = $key->nm_obat;
                        }else{
                            $obat_racik = $obat_racik."\n".$key->nm_obat;
                        }
                        $n++;
                    }
                    $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $obat_racik);
                    $objPHPExcel->getActiveSheet()->getStyle('P'.$rowCount)->getAlignment()->setWrapText(true);
                }else{
                    $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $row->obat);
                }
                if($temp == $row->no_resep){

                    $total = $row->sub_total - $row->diskon;
                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tgl_kunjungan);
                    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_resep);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->no_register);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->no_medrec);
                    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->no_kartu);
                    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->nama);
                    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->cara_bayar);
                    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->kontraktor);
                    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->no_kartu);
                    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->pangkat);
                    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->kesatuan);
                    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->dokter);
                    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->ruangan);
                    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row->status);
                    $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row->harga);
                    $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $row->jumlah);
                    $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $row->total_obat);
                    $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $row->tuslah);
                    $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->sub_total);
                    $objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $row->diskon);
                    $objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $total);

			    }else {
                    $temp = $row->no_resep;
                    $total = $row->sub_total - $row->diskon;
                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tgl_kunjungan);
                    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_resep);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->no_register);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->no_medrec);
                    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->no_kartu);
                    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->nama);
                    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->cara_bayar);
                    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->kontraktor);
                    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->no_kartu);
                    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->pangkat);
                    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->kesatuan);
                    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->dokter);
                    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->ruangan);
                    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row->status);
                    $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row->harga);
                    $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $row->jumlah);
                    $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $row->total_obat);
                    $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $row->tuslah);
                    $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->sub_total);
                    $objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $row->diskon);
                    $objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $total);

                    $objPHPExcel->getActiveSheet()->getStyle('X'.$rowCount)->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $subtotal_resep);
                }

                $total_diskon += $row->diskon;
                $total_pendapatan += $row->sub_total;
                $i++;
                $rowCount++;
            }
        }
        $filename = "Laporan Pendapatan Farmasi ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2));
        $objPHPExcel->getActiveSheet()->getStyle('V'.($rowCount+1))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->SetCellValue('V'.($rowCount+1), "Total Pendapatan : ");
        $objPHPExcel->getActiveSheet()->getStyle('W'.($rowCount+1))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->SetCellValue('W'.($rowCount+1), $total_resep);
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