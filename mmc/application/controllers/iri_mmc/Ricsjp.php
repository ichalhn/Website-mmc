 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('Rjcterbilang.php');

require_once(APPPATH.'controllers/Secure_area.php');
class Ricsjp extends Secure_area{
	public function __construct() {
		parent::__construct();
		$this->load->model('iri/rimlaporan','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index()
	{
		$data['title'] = 'SJP RAWAT INAP';
		$data['pasien_daftar']=$this->rimlaporan->get_pasien_sjp()->result();
		$data['url']='';
		/*if(sizeof($data['pasien_daftar'])==0){
			$this->session->set_flashdata('message_nodata','<div class="row">
						<div class="col-md-12">
						  <div class="box box-default box-solid">
							<div class="box-header with-border">
							  <center>Tidak ada lagi data</center>
							</div>
						  </div>
						</div>
					</div>');
		}
		*/
		$this->load->view('iri/rivsjp',$data);
	}

	public function cetak_sjp($no_register='', $cara_bayar='')
	{
	
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		if($no_register!=''){
			$cterbilang=new rjcterbilang();
			/*$get_no_kwkt=$this->rjmkwitansi->get_new_kwkt($no_register)->result();
				foreach($get_no_kwkt as $val){
					$no_kwkt=sprintf("KT%s%06s",$val->year,$val->counter+1);
				}
			$this->rjmkwitansi->update_kwkt($no_kwkt,$no_register);
			
			$tgl_kw=$this->rjmkwitansi->getdata_tgl_kw($no_register)->result();
				foreach($tgl_kw as $row){
					$tgl_jam=$row->tglcetak_kwitansi;
					$tgl=$row->tgl_kwitansi;
				}
			*/
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			// $data_rs=$this->rjmkwitansi->getdata_rs('10000')->result();
			// 	foreach($data_rs as $row){
			// 		$namars=$row->namars;
			// 		$kota_kab=$row->kota;
			// 		$alamatrs=$row->alamat;
			// 		$nmsingkat=$row->namasingkat;
			// 	}
			
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamatrs=$this->config->item('alamat');
			$telp=$this->config->item('telp');
			$nmsingkat=$this->config->item('namasingkat');
			$data_pasien=$this->rimlaporan->getdata_pasien_sjp($no_register)->row();
			// print_r($data_pasien);
			$data_ruang=$this->rimlaporan->get_ruang($data_pasien->idrg)->row();

			$bed = substr($data_pasien->bed,-3);
			// $bed = $data_pasien->bed;
			if(substr($data_pasien->noregasal,0,2)=='RD'){
				$data_asal=$this->rimlaporan->getdata_pasien_sjp_rd($data_pasien->noregasal)->row();
			}else{
				$data_asal=$this->rimlaporan->getdata_pasien_sjp_rj($data_pasien->noregasal)->row();
			}

			if($data_pasien->sex=='L'){
				$jk = "LAKI-LAKI";
			} else {
				$jk = "PEREMPUAN";
			}

			if($data_pasien->carabayar=='BPJS'){
				$cara_bayar=$data_pasien->carabayar;
			} else {
				$cara_bayar='DIJAMIN / JAMSOSKES';
			}

			if($data_asal->tgl_rujukan!='' || $data_asal->tgl_rujukan != NULL){
				$tgl_rujukan = date("d-m-Y",strtotime($data_asal->tgl_rujukan));
			} else {
				$tgl_rujukan = '';
			}

			$asal_rujukan=$data_asal->asal_rujukan;
			if($this->rimlaporan->getdata_asal_rujukan($data_asal->asal_rujukan)->row()->nm_ppk=TRUE){;
				$asal_rujukan=$this->rimlaporan->getdata_asal_rujukan($data_asal->asal_rujukan)->row()->nm_ppk;
			}
			if($asal_rujukan!=''){$rujukan=$asal_rujukan;}else{$rujukan=$data_asal->asal_rujukan;}

			
			$style='';			

			$konten="<style type=\"text/css\">
					.table-font-size{
						font-size:12px;
					    }
					.table-font-size1{
						font-size:8px;
						margin : 1px 1px 1px 1px;
						padding : 5px 1px 1px 1px;
					    }
					.table-font-size2{
						font-size:8px;
						margin : 1px 1px 1px 1px;
						padding : 1px 1px 1px 1px;
					    }
					.table-font-size2 th{
						border-top: 1px solid #000;
						border-bottom: 1px solid #000;
					    }
					.table-font-size2 td{
						border-top: 1px solid #000;
						border-bottom: 1px solid #000;
					    }
					</style>
					
					<table class=\"table-font-size1\" border=\"0\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
								</p>
							</td>
								<td align=\"center\" width=\"70%\" style=\" font-size:9px;\"><b><font style=\"font-size:12px\">$namars</font></b><br>$alamatrs $kota_kab $telp
							</td>
							<td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam</font></td>						
						</tr>
					</table >
					<table border=\"0\" class=\"table-font-size1\">
							<tr>
								<td colspan=\"6\" ><hr>
									<font size=\"9\" align=\"center\">
										SURAT JAMINAN PELAYANAN (SJP)<br/>
									 	SJP-RIT No. $no_register
									</font><hr>
								</td>
							</tr>		
							<tr>
								<td width=\"21%\">1. Tanggal Berobat</td>
								<td width=\"1%\">:</td>
								<td width=\"35%\">".strtoupper($tgl)."</td>
								<td width=\"15%\">Nomor Register</td>
								<td width=\"1%\">:</td>
								<td width=\"26%\">".$no_register."</td>
							</tr>	
							<tr>
								<td>2. Nomor Rujukan</td>
								<td>:</td>
								<td>".$data_pasien->no_rujukan."</td>
								<td>Nomor Medrec</td>
								<td>:</td>
								<td><b>".$data_pasien->no_cm."</b></td>
							</tr>	
							<tr>
								<td>3. Tanggal Rujukan</td>
								<td>:</td>
								<td>".$tgl_rujukan."</td>
								<td>Nama Pasien</td>
								<td>:</td>
								<td>".strtoupper($data_pasien->nama)."</td>
							</tr>	
							<tr>
								<td>4. Asal Rujukan / Kode PPK</td>
								<td>:</td>
								<td>".$rujukan."</td>
								<td>Jenis Kelamin</td>
								<td>:</td>
								<td>".$jk."
								</td>
							</tr>	
							<tr>
								<td>5. Diagnosa Asal Rujukan</td>
								<td>:</td>
								<td></td>
								<td>Tanggal Lahir</td>
								<td>:</td>
								<td>".date("d-m-Y",strtotime($data_pasien->tgl_lahir))."</td>
							</tr>	
							<tr>
								<td>6. Tujuan Rujukan</td>
								<td>:</td>
								<td>Rawat Inap</td>
								<td>Nomor Kartu JAMSOSKES</td>
								<td>:</td>
								<td></td>
							</tr>	
							<tr>
								<td>7. Penunjang</td>
								<td>:</td>
								<td>
									1)__LAB &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2)__USG &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3)__EKG 
									<br>
									4)__FISIOTHERAPI
								</td>
								<td>Kepesertaan</td>
								<td>:</td>
								<td></td>
							</tr>	
							<tr>
								<td>8. Rujukan Intern Ke</td>
								<td>:</td>
								<td>
									1). <br>
									2).  
								</td>
								<td colspan=\"3\"> </td>
							</tr>											
					</table><br/><br/>
					<table border=\"0\" class=\"table-font-size2\">
						<tr>
							<td width=\"10%\">Kode</td>
							<td width=\"60%\">Diagnosa / ICD 10</td>
							<td width=\"30%\">Paraf Dokter</td>
						</tr>
						<tr>
							<td>................</td>
							<td>1)............................................................................................................................</td>
							<td>..........................</td>
						</tr>
						<tr>
							<td>................</td>
							<td>2)............................................................................................................................</td>
							<td>..........................</td>
						</tr>
						<tr>
							<td>................</td>
							<td>3)............................................................................................................................</td>
							<td>..........................</td>
						</tr>
						<tr>
							<td width=\"10%\">Kode</td>
							<td width=\"60%\">Terapi / Tindakan / ICD 9</td>
							<td width=\"30%\">Paraf Dokter</td>
						</tr>
						<tr>
							<td>................</td>
							<td>1)............................................................................................................................</td>
							<td>..........................</td>
						</tr>
						<tr>
							<td>................</td>
							<td>2)............................................................................................................................</td>
							<td>..........................</td>
						</tr>
						<tr>
							<td>................</td>
							<td>3)............................................................................................................................</td>
							<td>..........................</td>
						</tr>
					</table>
					<p align=\"right\">Dokter Yang Melayani<br><br> <br><br><br>
					(.................................)</p>";
		
			$konten=$konten."
					<p ><b>BERKAS INI TIDAK DIBAWA PULANG</b></p>
					<table border=\"0\" class=\"table-font-size1\">
							<tr>
								<td width=\"21%\">No. SJP</td>
								<td width=\"1%\">:</td>
								<td width=\"35%\">".$data_pasien->no_register."</td>
								<td width=\"15%\">Nomor Resep</td>
								<td width=\"1%\">:</td>
								<td width=\"26%\"> </td>
							</tr>	
							<tr>
								<td>Nomor Kartu Askes</td>
								<td>:</td>
								<td> </td>
								<td>Nomor Medrec</td>
								<td>:</td>
								<td><b>".$data_pasien->no_cm."</b></td>
							</tr>	
							<tr>
								<td>Status</td>
								<td>:</td>
								<td> </td>
								<td>Nama Pasien</td>
								<td>:</td>
								<td>".strtoupper($data_pasien->nama)."</td>
							</tr>	
							<tr>
								<td>Jenis Kelamin</td>
								<td>:</td>
								<td>".$jk."
								</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>											
					</table>
					<table border=\"0\" class=\"table-font-size1\">
							<tr>
								<td width=\"60%\">R \ Nama Obat :</td>
								<td width=\"8%\">Hari</td>
								<td align=\"center\" width=\"7%\">Signa</td>
								<td align=\"center\" width=\"10%\">Jumlah</td>
								<td width=\"15%\">Biaya</td>
							</tr>	
							<tr>
								<td> &nbsp; &nbsp;R_/....................................................................................................</td>
								<td>........</td>
								<td align=\"center\">X</td>
								<td align=\"center\">........</td>
								<td>Rp. .............................</td>
							</tr>	
							<tr>
								<td> &nbsp; &nbsp;R_/....................................................................................................</td>
								<td>........</td>
								<td align=\"center\">X</td>
								<td align=\"center\">........</td>
								<td>Rp. .............................</td>
							</tr>	
							<tr>
								<td> &nbsp; &nbsp;R_/....................................................................................................</td>
								<td>........</td>
								<td align=\"center\">X</td>
								<td align=\"center\">........</td>
								<td>Rp. .............................</td>
							</tr>	
							<tr>
								<td> &nbsp; &nbsp;R_/....................................................................................................</td>
								<td>........</td>
								<td align=\"center\">X</td>
								<td align=\"center\">........</td>
								<td>Rp. .............................</td>
							</tr>	
							<tr>
								<td> &nbsp; &nbsp;R_/....................................................................................................</td>
								<td>........</td>
								<td align=\"center\">X</td>
								<td align=\"center\">........</td>
								<td>Rp. .............................</td>
							</tr>	
							<tr>
								<td> &nbsp; &nbsp;R_/....................................................................................................</td>
								<td>........</td>
								<td align=\"center\">X</td>
								<td align=\"center\">........</td>
								<td>Rp. .............................</td>
							</tr>	
							<tr>
								<td align=\"right\" colspan=\"2\"> Tanggal, ".strtoupper($tgl)."</td>
								<td align=\"center\" colspan=\"3\">Tanda Tangan Pasien</td>
							</tr>											
					</table>

					";
			//echo $konten;			
				$file_name="SJP_$no_register.pdf";			
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();			
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);				
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setPrintHeader(false);
				$obj_pdf->setPrintFooter(false);
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins('10', '10', '10');
				$obj_pdf->SetAutoPageBreak(TRUE, '15');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');				
				$obj_pdf->Output(FCPATH.'download/inap/sjp/'.$file_name, 'FI');
		}else{
			redirect('iri/ricsjp/','refresh');
		}
	}

	public function cetak_gelang($no_register='')
	{
	
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		if($no_register!=''){
			$cterbilang=new rjcterbilang();
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");
			
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamatrs=$this->config->item('alamat');
			$telp=$this->config->item('telp');
			$nmsingkat=$this->config->item('namasingkat');

			$data_pasien=$this->rimlaporan->getdata_pasien_sjp($no_register)->row();
			// print_r($data_pasien);
			$data_ruang=$this->rimlaporan->get_ruang($data_pasien->idrg)->row();

			$bed = substr($data_pasien->bed,-3);
			// $bed = $data_pasien->bed;
			if(substr($data_pasien->noregasal,0,2)=='RD'){
				$data_asal=$this->rimlaporan->getdata_pasien_sjp_rd($data_pasien->noregasal)->row();
			}else{
				$data_asal=$this->rimlaporan->getdata_pasien_sjp_rj($data_pasien->noregasal)->row();
			}

			if($data_pasien->sex=='L'){
				$jk = "LAKI-LAKI";
			} else {
				$jk = "PEREMPUAN";
			}

			if($data_pasien->carabayar=='BPJS'){
				$cara_bayar=$data_pasien->carabayar;
			} else {
				$cara_bayar='JAMSOSKES';
			}

			if($data_asal->tgl_rujukan!='' || $data_asal->tgl_rujukan != NULL){
				$tgl_rujukan = date("d-m-Y",strtotime($data_asal->tgl_rujukan));
			} else {
				$tgl_rujukan = '';
			}

			$asal_rujukan=$data_asal->asal_rujukan;
			if($this->rimlaporan->getdata_asal_rujukan($data_asal->asal_rujukan)->row()->nm_ppk=TRUE){;
				$asal_rujukan=$this->rimlaporan->getdata_asal_rujukan($data_asal->asal_rujukan)->row()->nm_ppk;
			}
			if($asal_rujukan!=''){$rujukan=$asal_rujukan;}else{$rujukan=$data_asal->asal_rujukan;}

			$interval = date_diff(date_create(), date_create($data_pasien->tgl_lahir));
			$thn=$interval->format("%Y Tahun, %M Bulan");
			
			$style='';			

			$konten="<style type=\"text/css\">
					.table-font-size{
						font-size:5px;
					    }
					.table-font-size1{
						font-size:7px;
						margin : 0.5px 1px 0.5px 1px;
						padding : 1px 1px 0.5px 1px;
						width:100%; height:100%;
					    }
					</style>
					<br><br>
					<table class=\"table-font-size1\" border=\"0.1\">
						<tr>
							<td width=\"16%\"></td>
							<td align=\"center\" rowspan=\"3\" width=\"7%\">
								<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"27\" style=\"\">
							</td>
							<td width=\"37%\">$data_pasien->nama</td>	
							<td width=\"40%\" align=\"left\">No Medrec : $data_pasien->no_cm</td>
						</tr>
						<tr>	
							<td></td>
							<td>$jk</td>					
							<td align=\"left\">No Register : $data_pasien->no_ipd</td>				
						</tr>
						<tr>	
							<td align=\"right\"><font size=\"5px\">$tgl_jam</font></td>
							<td>".date("d-m-Y",strtotime(substr($data_pasien->tgl_lahir,0,10)))." (".$thn.")</td>		
							<td align=\"left\">$data_ruang->nmruang, Bed $bed</td>				
						</tr>
					</table >";
			//echo $konten;			
				$file_name="GELANG_$no_register.pdf";			
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();			
				$pageLayout = array('53', '500'); //  or array($height, $width) 
				$obj_pdf = new TCPDF('L', 'pt', $pageLayout, true, 'UTF-8', false);				
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setPrintHeader(false);
				$obj_pdf->setPrintFooter(false);
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins('1', '1', '1');
				$obj_pdf->SetAutoPageBreak(TRUE, '1');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');				
				$obj_pdf->Output(FCPATH.'download/inap/gelang/'.$file_name, 'FI');
		}else{
			redirect('iri/ricsjp/','refresh');
		}
	}
}
?>
