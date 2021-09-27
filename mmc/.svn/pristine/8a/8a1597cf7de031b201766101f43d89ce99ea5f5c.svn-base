<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');


class Sep_manual extends Secure_area {

	public function __construct(){
	    parent::__construct();
	    $this->load->model('irj/rjmregistrasi','',TRUE);
	    $this->load->model('irj/M_update_sepbpjs');
	    $this->load->helper('pdf_helper');
	}

	public function get_timestamp($no_kartu='',$no_register=''){
		$data_bpjs = $this->M_update_sepbpjs->get_data_bpjs();
		$cons_id = $data_bpjs->consid;
		$sec_id = $data_bpjs->secid;
		$ppk_pelayanan = $data_bpjs->rsid;

		
        $url = $data_bpjs->service_url;
		$timezone = date_default_timezone_get();
		date_default_timezone_set('Asia/Jakarta');
		$tgl_sep = date('Y-m-d H:i:s');
		$timestamp = strval(time()-strtotime('1970-01-01 00:00:00')); //cari timestamp
	//	$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		//$tgl_sep = date('Y-m-d 00:00:00');
		$http_header = array(
			   'Accept: application/json',
		//	   'Content-type: application/xml',
			   'Content-type: application/x-www-form-urlencoded',
			   // 'Content-type: application/json',
			   'X-cons-id: ' . $cons_id, //id rumah sakit
			   'X-timestamp: ' . $timestamp,
			   'X-signature: ' . $encoded_signature
		);
		print_r($http_header);

		/////////
		$timezone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$tgl_sep = date('Y-m-d H:i:s');
		$timestamp = strval(time()-strtotime('1970-01-01 00:00:00')); //cari timestamp
	//	$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		//$tgl_sep = date('Y-m-d 00:00:00');
		$http_header = array(
			   'Accept: application/json',
		//	   'Content-type: application/xml',
			   'Content-type: application/x-www-form-urlencoded',
			   // 'Content-type: application/json',
			   'X-cons-id: ' . $cons_id, //id rumah sakit
			   'X-timestamp: ' . $timestamp,
			   'X-signature: ' . $encoded_signature
		);
		print_r($http_header);

		/////////
	}
		public function cetak_sep($no_register="") {
		$data_bpjs = $this->M_update_sepbpjs->get_data_bpjs();
		$cons_id = $data_bpjs->consid;
		$sec_id = $data_bpjs->secid;
		$ppk_pelayanan = $data_bpjs->rsid;				
		$get_data_sep = $this->M_update_sepbpjs->get_pasien_iri($no_register);
		$no_sep = $get_data_sep->no_sep;
		$cetakan_ke = $get_data_sep->cetak_sep_ke;
		if($no_sep==''){
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Nomor SEP tidak boleh kosong.
									</div>
							</div>
						</div>';	
				$this->session->set_flashdata('notification', $notif);		     
				redirect('iri/ricdaftar_bpjs' ,'refresh');			
		}
		else {
		$url = $data_bpjs->service_url;
        $timezone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$timestamp = strval(time()-strtotime('1970-01-01 00:00:00')); //cari timestamp
	//	$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date('Y-m-d 00:00:00');
		$http_header = array(
			   'Accept: application/json',
			   // 'Content-type: application/xml',
			   // 'Content-type: application/json',
			     // 'Content-type: application/json',
			   'Content-type: application/x-www-form-urlencoded',
			   'X-cons-id: ' . $cons_id, //id rumah sakit
			   'X-timestamp: ' . $timestamp,
			   'X-signature: ' . $encoded_signature
				);
				date_default_timezone_set($timezone);
				//cetak sep

	    		$ch = curl_init($url . 'SEP/'.$no_sep);
	    		// print_r ($ch);exit();
				curl_setopt($ch, CURLOPT_HTTPGET, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch); //json file
				curl_close($ch);
             	if($result!=''){//valid koneksi internet
		     	$sep = json_decode($result);
		     	$datasep = json_decode($result)->response;

         		// print_r($sep->response);exit; ///////////////////////////////////////
		     	if ($sep->metadata->code == '800') {
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, '.$sep->metadata->message.'
								</div>
							</div>
						</div>';
				$this->session->set_flashdata('notification', $notif);		     
				redirect('iri/ricdaftar_bpjs' ,'refresh');
		     	}
				if ($sep->metadata->code == '200') {

          	    $fields = array(
				'No. SEP' => $datasep->noSep,
				'Tgl. SEP' => date('d-m-Y',strtotime($datasep->tglSep)),
				'No. Medrec' => $datasep->peserta->noMr,
				'No. Register' => $no_register,//$entri_catatan->NO_MEDREC,//$nomedrec,
				'No. Kartu' => $datasep->peserta->noKartu,
				'Peserta' => $datasep->peserta->jenisPeserta->nmJenisPeserta,// '', //ucfirst(strtolower($pasien->pesertaBPJS)),
				'Nama Peserta' => $datasep->peserta->nama,//ucfirst($pasien->NAMA),
				'Tgl. Lahir' => date('d-m-Y',strtotime($datasep->peserta->tglLahir)),//date("d-m-Y", strtotime($pasien->TGL_LAHIR)),
				'Jenis Kelamin' => $datasep->peserta->sex,//$pasien->SEX,
				'Asal Faskes' => $datasep->peserta->provUmum->nmProvider,// $sep->KD_PPK,// '', //$ppk,
				'Poli Tujuan' => $datasep->poliTujuan->nmPoli,//$entri_rd->ID_POLI,
				'Kelas Rawat' => $datasep->klsRawat->nmKelas,//$entri_rd->KELAS_PASIEN,
				'Jenis Rawat' => $datasep->jnsPelayanan,
				'Diagnosa Awal' => $datasep->diagAwal->nmDiag,// $entri_rd->DIAGNOSA,
				'Catatan' => $get_data_sep->catatan,
		  		// 'Poli RSMH'=>$entri_catatan->POLI_RSMH,
				'Nama RS' => $datasep->provPelayanan->nmProvider, //$namars
				'Cetakan Ke' => $cetakan_ke + 1 
				);
				$data_update = array(
        		'cetak_sep_ke' => $cetakan_ke + 1
      			);
        		$this->M_update_sepbpjs->update_cetakan_iri($no_register,$data_update);
        		// print_r($fields);exit();
				$this->sep_sjp($fields);				
			
			}
				else {
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									'.$sep->metadata->message.'.
								</div>
							</div>
						</div>';	
				$this->session->set_flashdata('notification', $notif);		     
				redirect('iri/ricdaftar_bpjs' ,'refresh');	
			}
		 }
		 		else{
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Pastikan Anda Terhubung Internet!!.
								</div>
							</div>
						</div>';	
				$this->session->set_flashdata('notification', $notif);		     
				redirect('iri/ricdaftar_bpjs' ,'refresh');						 			
		 		}
		}
	}		

//CETAK SEP/////////////////////////////////////////////////////////////////////////////////////////////////
	public function sep_sjp($fields)
	{			
		//set timezone
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
		// $data_identitas=$this->rjmregistrasi->getdata_identitas($no_cm)->result();	
		$namars=$this->config->item('namars');
		$alamatrs=$this->config->item('alamat');
		$telprs=$this->config->item('telp');
		$kota=$this->config->item('kota');
		$nmsingkat=$this->config->item('nmsingkat');				
		
		// foreach($data_identitas as $row){
		$konten="<style type=\"text/css\">
				.table-font-size{
					font-size:12px;
				    }
				.table-font-size2{
					font-size:10px;
					padding : 1px, 2px, 2px;
				    }
				.font-italic{
					font-size:9px;
					font-style:italic;
				    }
				</style>
				<table class=\"table-font-size\" border=\"0\">
					<tr>
						<td width=\"20%\" style=\"border-bottom:1px solid black; font-size:13px;\">
								<img src=\"asset/images/logos/logobpjs.png\" alt=\"img\" height=\"70\" style=\"padding-right:5px;\">
						</td>
						<td width=\"60%\" style=\"border-bottom:1px solid black; font-size:13px;\">
							<p align=\"center\">
								<br>
								<b>Surat Eligibilitas Peserta</b>
								<br>
								<b>$namars</b>
							</p>
						</td>
						<td width=\"20%\" style=\"border-bottom:1px solid black; font-size:13px;\" align=\"right\">
								<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
						</td>
					</tr>
				</table>	
				<br><br>
				<table class=\"table-font-size2\" border=\"0\">
					<tr>
						<td width=\"15%\" style=\"font-size:15px;\">No. SEP</td>
						<td width=\"40%\" style=\"font-size:15px;\">: ".$fields['No. SEP']."</td>
						<td width=\"15%\"></td>
						<td width=\"30%\"></td>
					</tr>		
					<tr>
						<td>Tgl. SEP</td>
						<td>: ".$fields['Tgl. SEP']."</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>No. Kartu</td>
						<td>: ".$fields['No. Kartu']." MR: ".$fields['No. Medrec']."</td>
						<td>Peserta</td>
						<td>: ".$fields['Peserta']."</td>
					</tr>		
					<tr>
						<td>Nama Peserta</td>
						<td>: ".$fields['Nama Peserta']."</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Tgl. Lahir</td>
						<td>: ".$fields['Tgl. Lahir']."</td>
						<td>COB</td>
						<td>: </td>
					</tr>		
					<tr>
						<td>Jenis Kelamin</td>
						<td>: ".$fields['Jenis Kelamin']."</td>
						<td>Jenis Rawat</td>
						<td>: ".$fields['Jenis Rawat']."</td>
					</tr>		
					<tr>
						<td>Poli Tujuan</td>
						<td>: ".$fields['Poli Tujuan']."</td>
						<td>Kelas Rawat</td>
						<td>: ".$fields['Kelas Rawat']."</td>
					</tr>		
					<tr>
						<td>Asal Faskes</td>
						<td>: ".$fields['Asal Faskes']."</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Diagnosa Awal</td>
						<td colspan=\"3\">: ".$fields['Diagnosa Awal']."</td>
					</tr>		
					<tr>
						<td>Catatan</td>
						<td>: ".$fields['Catatan']."</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td colspan=\"4\">
							<font class=\"font-italic\"><br>
*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan.<br>
*SEP bukan sebagai bukti penjaminan peserta
							</font>
						</td>
					</tr>		
					<tr>
						<td>Cetakan Ke ".$fields['Cetakan Ke']."</td>
						<td>: ".$date->format('d-m-Y H:i:s')."</td>
						<td></td>
						<td></td>
					</tr>										
				</table>
				<br><br>
				<table class=\"table-font-size2\" border=\"0\" align=\"center\">
					<tr>
						<td width=\"5%\"></td>
						<td width=\"30%\">Pasien / Keluarga Pasien <br><br></td>
						<td width=\"30%\">Petugas RS</td>
						<td width=\"30%\">Petugas BPJS Kesehatan</td>
						<td width=\"5%\"></td>
					</tr>
					<tr>
						<td width=\"5%\"></td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"5%\"></td>
					</tr>
				</table>
			";			
		
		// }
		$file_name="SEP_".$fields['No. Register'].".pdf";
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		// $obj_pdf->SetFooterMargin('5');
		$obj_pdf->SetMargins('5', '2', '5');//left top right
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
		$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'/download/inap/sjp/'.$file_name, 'FI');				
		
	}	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>
