<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_sepdetail extends CI_Controller {

	public function __construct(){
	    parent::__construct();
	    //   $this->load->model('M_monitoring');
	    $this->load->model('irj/M_update_sepbpjs');
	}

	public function sep_cetak($no_rujukan='',$no_medrec='',$no_register='')
	{
		$data_bpjs = $this->M_update_sepbpjs->get_data_bpjs();
		$cons_id = $data_bpjs->consid;
		$sec_id = $data_bpjs->secid;
		$ppk_pelayanan = $data_bpjs->rsid;

		$tgl_sep = date('Y-m-d 00:00:00');
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
		//	   'Content-type: application/xml',
			   'Content-type: application/x-www-form-urlencoded',
			   // 'Content-type: application/json',
			   'X-cons-id: ' . $cons_id, //id rumah sakit
			   'X-timestamp: ' . $timestamp,
			   'X-signature: ' . $encoded_signature
		);
		date_default_timezone_set($timezone);
  		$ch = curl_init($url . 'Rujukan/RS/'.$no_rujukan);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch); //json file
		curl_close($ch);
    	if($result!='') { //valid koneksi internet
		$datarujukan = json_decode($result)->response;
	 	// print_r($datarujukan); exit();
		}

      	$entri_catatan = $this->M_update_sepbpjs->get_catatan_2($no_register);
        $xuser = $entri_catatan->xuser;      	 
        $id_poli = $entri_catatan->id_poli;
       	$alasan_berobat = $entri_catatan->alasan_berobat;
        if ($id_poli == 'BA00' && $alasan_berobat == 'kecelakaan') {
       	$laka_lantas = '1';
       	$lokasi_laka = $entri_catatan->lokasi_kecelakaan;
        }
        else {
       	$laka_lantas = '2';
       	$lokasi_laka = '';
        }
        $poli_bpjs = $this->M_update_sepbpjs->get_poli_bpjs($id_poli);

		  $data = array(
		   	'request'=>array(
		   		't_sep'=>array(
		   			'noKartu' => $datarujukan->item->peserta->noKartu,
		   			'tglSep' => $tgl_sep,
		   			'tglRujukan' => $datarujukan->item->tglKunjungan,
		   			'noRujukan' => $no_rujukan,
		   			'ppkRujukan' => $datarujukan->item->provKunjungan->kdProvider,
		   			'ppkPelayanan' => '0601R001', // RS Muara
		   			// if sep_manual input dr form
		   			'jnsPelayanan' => '2',
		   			'catatan' => $entri_catatan->catatan,
		   			'diagAwal' => $datarujukan->item->diagnosa->kdDiag,
		   			// 'poliTujuan' => $datarujukan->item->poliRujukan->kdPoli,
		   			'poliTujuan' => $poli_bpjs->poli_bpjs, // INT
		   			'klsRawat' => '3',
		   			'lakaLantas' => $laka_lantas,
		   			'lokasiLaka' => $lokasi_laka, 
		   			'user' => $xuser,
		   			'noMr' => $no_medrec//'999999999',//$datarujukan->item->peserta->noMr
		   			)
		   		)
		   );
    	   $datasep=json_encode($data);
        // print_r($datasep);exit();
           $ch = curl_init($url . 'SEP/insert');
             curl_setopt($ch, CURLOPT_POST, true);
             curl_setopt($ch, CURLOPT_POSTFIELDS, $datasep);
             curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              $result = curl_exec($ch);
             curl_close($ch);
             if($result!=''){//valid koneksi internet
		     $sep = json_decode($result);
         // print_r($sep->response);exit; ///////////////////////////////////////
		     if ($sep->metadata->code == '800') {
			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, '.$sep->metadata->message.'
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('success_msg', $success);		     
		   	echo '<script type="text/javascript">window.close();</script>';
		     }
			if ($sep->metadata->code == '200') {
				

           // $id= $no_rujukan;
          $data_update = array(
           'NO_SEP' => $sep->response
              );
            $this->M_update_sepbpjs->update_sep_bpjs($no_register,$data_update);
            // print_r($sep->response);exit;

		//cetak sep

	    $ch = curl_init($url . 'SEP/'.$sep->response);
	    // print_r ($ch);exit();
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch); //json file
		curl_close($ch);
              if($result!=''){//valid koneksi internet
		          $datasep = json_decode($result)->response;
		    }

     //          require_once(APPPATH.'controllers/irj/SEP_bpjs.php');

		   // $sepcetak = new SEP();

            $fields = array(
				'No. SEP' => $datasep->noSep,
				'Tgl. SEP' => date('d-m-Y'),
				'No. Medrec' => $no_medrec,
				'No. Register' => $no_register,//$entri_catatan->NO_MEDREC,//$nomedrec,
				'No. Kartu' => $datasep->peserta->noKartu,
				 'Peserta' => $datasep->peserta->jenisPeserta->nmJenisPeserta,// '', //ucfirst(strtolower($pasien->pesertaBPJS)),
				 'Nama Peserta' => $datasep->peserta->nama,//ucfirst($pasien->NAMA),
				 'Tgl. Lahir' => $datasep->peserta->tglLahir,//date("d-m-Y", strtotime($pasien->TGL_LAHIR)),
				 'Jenis Kelamin' => $datasep->peserta->sex,//$pasien->SEX,
				 'Asal Faskes' => $datasep->peserta->provUmum->nmProvider,// $sep->KD_PPK,// '', //$ppk,
				 'Poli Tujuan' => $datasep->poliTujuan->nmPoli,//$entri_rd->ID_POLI,
				 'Kelas Rawat' => $datasep->klsRawat->nmKelas,//$entri_rd->KELAS_PASIEN,
				 'Jenis Rawat' => $datasep->jnsPelayanan,
				 'Diagnosa Awal' => $datasep->diagAwal->nmDiag,// $entri_rd->DIAGNOSA,
				 'Catatan' => $entri_catatan->catatan,
		  		// 'Poli RSMH'=>$entri_catatan->POLI_RSMH,
				 'Nama RS' => $datasep->provPelayanan->nmProvider, //$namars
				 'Cetakan Ke' => 1 
			);
			$data_update = array(
        		'cetak_sep_ke' => 1
      			);
        		$this->M_update_sepbpjs->update_cetakan_sep($no_register,$data_update);			
			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Data Berhasil Disimpan, Silahkan Cetak SEP.
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('success_msg', $success);	               
			$this->sep_tracer($fields);



			}else {
				echo $sep->metadata->message;
				exit();
			}
		 }else{
		 	echo "Pastikan Anda Terhubung Internet!!";
		exit();
		 }


	}

	public function sep_tracer($fields)
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
						<td width=\"15%\">No. SEP</td>
						<td width=\"40%\">: ".$fields['No. SEP']."</td>
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
			// $poli="Jalan";
			if($fields['Poli Tujuan']!="Poli UGD"){
				$data_tracer=$this->rjmregistrasi->getdata_tracer($fields['No. Register'])->result();			
				foreach($data_tracer as $row){
					if($row->sex=='L'){$sex='Laki-laki';}else{ $sex='Perempuan';}
					$no_medrec=$row->no_medrec;
					if($row->nmkontraktor!=''){
						if($row->cara_bayar=='BPJS'){
							$txtperusahaan=$row->nmkontraktor;
						}
						else $txtperusahaan=$row->cara_bayar." - ".$row->nmkontraktor;
					}else {$txtperusahaan='UMUM';}
					$konten=$konten."<style type=\"text/css\">
						.table-font-size{
							font-size:13px;
						    }
						</style>	<br><br><hr>				
						$namars | $alamatrs
						
						<h3>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<u>TRACER</u></h3><br/>
						<table class=\"table-font-size\">
							<tr>
								<td width=\"20%\"><h4>No. Antrian</h4></td>
								<td width=\"5%\"> : </td>
								<td width=\"30%\"><b>$row->no_antrian</b></td>
								<td>No. MR</td>
								<td width=\"5%\"> : </td>
								<td width=\"20%\"><b>$row->no_cm</b></td>
							</tr>
							<tr>
								<td>Tgl Registrasi</td>
								<td> : </td>
								<td><b>".date('d-m-Y',strtotime($row->tgl_kunjungan))." | ".date('H:i:s',strtotime($row->tgl_kunjungan))."</b></td>
								<td >Pasien</td>
								<td width=\"5%\"> : </td>
								<td rowspan=\"2\" width=\"20%\">$txtperusahaan</td>
							</tr>
							<tr>
								<td>No. Registrasi</td>
								<td> : </td>
								<td><b>$row->no_register</b></td>
							</tr>
							<tr>
								<td>Pasien</td>
								<td> : </td>
								<td colspan=\"2\"><b>$row->nama</b></td>
							</tr>												
							<tr>
								<td>Unit Tujuan</td>
								<td> : </td>
								<td colspan=\"2\"><b>$row->nm_poli</b></td>
							</tr>
							
							<tr>
								<td>Tgl Lahir</td>
								<td> : </td>
								<td>".date('d-m-Y', strtotime($row->tgl_lahir))."</td>
							</tr>
							<tr>
								<td>Umur</td>
								<td> : </td>
								<td>$row->umurrj Tahun $row->ublnrj Bulan $row->uharirj Hari</td>
							</tr>
							<tr>
								<td>Kelamin</td>
								<td> : </td>
								<td >$sex</td>
							</tr>";

							if($this->rjmregistrasi->getdata_before($no_medrec,$no_register)->num_rows()>0){
								$data_tracer=$this->rjmregistrasi->getdata_before($no_medrec,$no_register)->result();
								foreach($data_tracer as $row1){
									if($row1->ket_pulang!='PULANG' and $row1->ket_pulang!=''){
										$txtpulang='| '.$row1->ket_pulang;
									}else $txtpulang='';

									$konten1="<tr>
										<td>Unit & Kunjungan Lalu</td>
										<td> : </td>
										<td colspan=\"2\">".date('d-m-Y',strtotime($row1->tgl_kunjungan))." | $row1->nm_poli $txtpulang</td>
									</tr>";
									}
							}else {$konten1="<tr>
										<td></td>
										<td></td>
										<td></td>
									</tr>";}

							$login_data = $this->load->get_var("user_info");
							if($login_data->name=='' || $login_data->name==null){
								$user=$login_data->username;
							}else {$user=$login_data->name;}

							$konten=$konten."$konten1<tr>
								<td>Petugas</td>
								<td> : </td>
								<td colspan=\"2\">".$user."</td>
							</tr>						
							<tr>
										<td></td>
										<td></td>
										<td></td>
									</tr>
						</table><br>
						<br>
						<style type=\"text/css\">
							.table-diagnosis{
								font-size:9px;
							    }
							</style>
							<table class=\"table-diagnosis\" border=\"1\">
								<tr>
									<td width=\"18%\">Diagnosis</td>
									<td width=\"7%\">ICD10</td>
									<td width=\"4%\">KB</td>
									<td width=\"4%\">KL</td>
									<td width=\"15%\">Tindakan</td>
									<td width=\"10%\">ICD 9 CM</td>
									<td width=\"15%\">INA CBG</td>
									<td width=\"15%\">Nama Dokter</td>
									<td width=\"12%\">Kode Dokter</td>
								</tr>
								<tr>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
								</tr>
							</table>
					";
				}
			}
						
			
		
		// }
		$file_name="sep_".$fields['No. Register'].".pdf";
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
		$obj_pdf->Output(FCPATH.'/download/irj/sjp/'.$file_name, 'FI');				
		
	}	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>
