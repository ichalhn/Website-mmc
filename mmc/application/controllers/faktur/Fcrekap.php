 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('Fcterbilang.php');


require_once(APPPATH.'controllers/Secure_area.php');
require_once(APPPATH.'helpers/tcpdf/tcpdf.php');
class MYPDF extends TCPDF {  
	//$this->load->helper('pdf_helper');
       // Page footer
        public function Footer() {
            // Position at 15 mm from bottom
            $this->SetY(-8);
            // Set font
            $this->SetFont('helvetica', 'I', 8);
            // Page number
	date_default_timezone_set("Asia/Jakarta");			
	$tgl_jam = date("d-m-Y H:i:s");
        $this->Cell(0, 0, '', 0, false, 'L', 0, '', 0, false, 'T', 'M');    
	$this->Cell(0, 10, $this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');  
        }      
    }
class Fcrekap extends Secure_area{
	public function __construct() {
		parent::__construct();
		$this->load->model('faktur/fmrekap','',TRUE);
		$this->load->model('irj/rjmkwitansi','',TRUE);
		$this->load->model('irj/rjmpencarian','',TRUE);
		$this->load->model('irj/rjmpelayanan','',TRUE);
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->model('ird/ModelKwitansi','',TRUE);
		$this->load->model('ird/ModelPelayanan','',TRUE);
		$this->load->model('ird/ModelRegistrasi','',TRUE);
		$this->load->model('ird/ModelKwitansi','',TRUE);
		$this->load->model('lab/labmdaftar','',TRUE);
		$this->load->model('lab/labmkwitansi','',TRUE);
		$this->load->model('rad/radmdaftar','',TRUE);
		$this->load->model('rad/radmkwitansi','',TRUE);
		$this->load->helper('pdf_helper');
	}
	public function index()
	{
		redirect('faktur/fcrekap','refresh');
	}
	
	public function rawat_jalan()
	{
		$data['title'] = 'Rekap Faktur Rawat Jalan';
		$date=$this->input->post('date');
		if ($date!='') { 
			$data['date'] = date('d-m-Y',strtotime($date));
			$data['pasien_daftar']=$this->fmrekap->get_pasien_kwitansi_irj_by_date($date)->result();
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
		//	print_r($data['pasien_daftar']);die();
		}else{
		$data['date'] = date('d-m-Y');
		$data['pasien_daftar']=$this->fmrekap->get_rekap_faktur_irj()->result();
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
		}
		$this->load->view('faktur/fvrekap_irj',$data);
	}

	public function st_cetak_kwitansi_kt()
	{
		$no_register=$this->input->post('no_register');

		$pilih=$this->input->post('pilih');

		$data['tunai']='0';$data['no_kkkd']='0';$data['nilai_kkkd']='0';$data['persen_kk']='0';$data['diskon']='0';
		$this->rjmkwitansi->update_pembayaran($no_register,$data);

		$data['pasien_bayar']=$this->input->post('jenis_bayar_hide');

		if($this->input->post('nilai_tunai')){
			$data['tunai']=$this->input->post('nilai_tunai');
		}
		if($this->input->post('no_kartuk')!=''){
			$data['no_kkkd']=$this->input->post('no_kartuk');
		}
		if($this->input->post('nilai_kk')!=''){
			$data['nilai_kkkd']=$this->input->post('nilai_kk');
		}
		if($this->input->post('charge_rate')!=''){
			$data['persen_kk']=$this->input->post('charge_rate');
		}

		$data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();

		$data['lunas']='0';
		//|| $data_pasien->cara_bayar=='BPJS'
		if($data_pasien->cara_bayar!='DIJAMIN' ){
			$data['lunas']='1';
		}

		if($this->input->post('pilih')!='detail'){			
			if ($this->input->post('penyetor')=="") 
			{
				$penyetor=$data_pasien->nama;
			} else {
				$penyetor=$this->input->post('penyetor');
			}
			$txtpilih='document.cookie = "pilih=0";';
		}else{
			
			if (!($this->input->post('penyetor_hide'))==1) 
			{
				$penyetor=$data_pasien->nama;
				
			} else {
				$penyetor=$this->input->post('penyetor_hide');
			}
			$txtpilih='document.cookie = "pilih='.$pilih.'";';
			
		}
//		print_r($data);
		
		if ($this->input->post('diskon_hide')!='') 
		{	
			$data['diskon']=$this->input->post('diskon_hide');
		} else 
			$data['diskon']='0';

		if($this->input->post('totfinal_hide')!=''){
			$totakhir=$this->input->post('totakhir');
		}
		
//		print_r($data);
		
		//$this->rjmkwitansi->update_pembayaran($no_register,$data);

		if($no_register!=''){
			//ubah status
			$data['cetak_kwitansi']=1;
			//print_r($txtpilih);
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$data['tgl_cetak_kw']=date("Y-m-d H:i:s");

			$login_data = $this->load->get_var("user_info");
			$user = $login_data->username;
			$data['xcetak']= $user;

			$status=$this->rjmkwitansi->update_status_kwitansi_kt($no_register,$data);
			//cetak kw.pdf
			
			//echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'"; '.$txtpilih.' window.open("'.site_url("irj/rjckwitansi/cetak_kwitansi_kt/$no_register").'", "_blank");window.focus()</script>';
			$txtpil='document.cookie = "pil=detail";';

			$data_tindakan=$this->rjmkwitansi->getdata_unpaid_finish_tindakan_pasien($no_register)->result();
			$noncover=0;
			foreach($data_tindakan as $row1){
				
				if(($row1->noncover)>0){
					$noncover=1;
				}
			}

			if(($noncover==1 && $data_pasien->cara_bayar=='BPJS') || $data_pasien->cara_bayar=='UMUM'){
				echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'"; '.$txtpil.' window.open("'.site_url("irj/rjckwitansi/cetak_faktur_kw0_kt/$no_register").'", "_blank");window.focus()</script>';
			}
			if($data_pasien->cara_bayar=='DIJAMIN'){
				echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'"; '.$txtpil.' window.open("'.site_url("irj/rjckwitansi/cetak_faktur_kw0_kt/$no_register").'", "_blank");window.focus()</script>';
			}
			
			
			if($this->input->post('pilih')=='detail'){
				redirect('irj/rjckwitansi/kwitansi_pasien/'.$no_register,'refresh');
			}else{
				redirect('faktur/fcrekap/rawat_jalan/','refresh');
			}
		}else{
			redirect('faktur/fcrekap/rawat_jalan/','refresh');
		}
	}

	public function cetak_faktur_kw0_kt($no_register='')
	{
		$penyetor =  $_COOKIE['penyetor'];		
		$pilihtemp=$_COOKIE['pil'];
		if($pilihtemp=='0'){
			$pilih = '';
		}else $pilih=$pilihtemp;

		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		if($no_register !=''){
			$cterbilang=new fcterbilang();
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();
			
			$detail_daful=$this->rjmkwitansi->get_detail_daful($no_register)->row();
		 //	print_r($detail_daful);die();
			if($detail_daful->pasien_bayar=='1'){
				$pasien_bayar='TUNAI';
			}else $pasien_bayar='KREDIT';
			$txtkk='';
			$txtdiskon='';
			$txttunai="";
			$txtperusahaan='';
			$totalbayar='';$totalbayar1='';$totalbayar2='';
			$detail_bayar=$detail_daful->cara_bayar;


			//print_r($detail_bayar);
			if($detail_bayar=='DIJAMIN' || $detail_bayar=='BPJS')
			{
				$kontraktor=$this->rjmkwitansi->getdata_perusahaan($no_register)->row();
				$txtperusahaan="<td><b>Dijamin Oleh</b></td>
						<td> : </td>
						<td>".strtoupper($kontraktor->nmkontraktor)."</td>";
			}
			
			$diskon=$detail_daful->diskon;
			$persen=$detail_daful->persen_kk;
			$tunai=$detail_daful->tunai;
			$nilaikk=$detail_daful->nilai_kkkd;				
			$nominal_kk=$persen/100*$nilaikk+$nilaikk;
			$vtot_terbilang=$cterbilang->terbilang($tunai);
			/*$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			$vtot=0;
			foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_tindakan;
			}
			*/
			//print_r($detail_daful);
			//$vtot=$this->rjmkwitansi->get_vtot($no_register)->row();
			$data_tindakan=$this->rjmkwitansi->getdata_unpaid_finish_tindakan_pasien($no_register)->result();

			$data_ok=$this->ModelKwitansi->getdata_ok_pasien($no_register)->result();
			$vtottind=0;
			foreach($data_tindakan as $row1){
				if($row1->bpjs==0){
					$vtottind=$vtottind+$row1->vtot;
				}				
			}
			//	$jumlah_vtot =  $vtottind;
						
			
			//echo $jumlah_vtot;
			//echo $vtot_terbilang;			

			$txtjudul="";			
			
			$style='';			

			$konten="<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					.table-font-size1{
						font-size:12px;
					    }
					.table-font-size2{
						font-size:9px;
						margin : 5px 1px 1px 1px;
						padding : 5px 1px 1px 1px;
					    }
					</style>
					
					<table class=\"table-font-size2\" border=\"0\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
									<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"40\" style=\"padding-right:5px;\">
								</p>
							</td>
								<td  width=\"70%\" style=\" font-size:9px;\"><b><font style=\"font-size:12px\">$namars</font></b><br><br>$alamatrs $kota_kab $telp
							</td>
							<td width=\"14%\"><font size=\"8\" align=\"right\">$tgl_jam</font></td>						
						</tr>
						<tr><td></td><td colspan=\"2\"><p align=\"right\" style=\"font-size:10px;\"><b>Pembayaran : <u>".$pasien_bayar."</u></b></p></td></tr>
					</table>
					
					<table>	
							<tr>
								<td colspan=\"3\" ><font size=\"12\" align=\"center\"><u><b>KWITANSI RAWAT JALAN 
								No. $no_register</b></u></font></td>
							</tr>	
							<br>		
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td width=\"17%\"><b>Sudah Terima Dari</b></td>
								<td width=\"2%\"> : </td>
								<td width=\"37%\">".strtoupper($penyetor)."</td>
								<td width=\"19%\"><b>Tgl Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td>".date("d-m-Y",strtotime($data_pasien->tgl_kunjungan))."</td>
							</tr>
							<tr>
								<td><b>Nama Pasien</b></td>
								<td> : </td>
								<td>".strtoupper($data_pasien->nama)."</td>
								<td ><b>No Medrec</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->no_cm)."</td>
							</tr>
							<tr>
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->cara_bayar)."</td>
								
								$txtperusahaan
							</tr>
							
							<tr>
								<td><b>Unit</b></td>
								<td> : </td>
								<td rowspan=\"3\">".strtoupper($detail_daful->nm_poli)."</td>
								<td><b>Dokter</b></td>
								<td> : </td>
								<td>".strtoupper($detail_daful->nm_dokter)."</td>
							</tr>											
							</table>
							<br/><br/>";
															
			$konten=$konten."<table border=\"1\" style=\"padding:2px\">
						<tr>
							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
							<th width=\"75%\"><p align=\"center\"><b>Pemeriksaan</b></p></th>
							<th width=\"20%\"><p align=\"center\"><b>Biaya</b></p></th>

						</tr>";
						// <tr>
						// 	<td><p align=\"center\">1</p></td>
						// 	<td><b>TINDAKAN</b></td>
						// 	<td></td>
						// 	<td><p align=\"right\">".number_format( $vtot->vtot, 2 , ',' , '.' )."</p></td>
						// </tr>";

				$no=1;
				$data_tindakan1=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
				// print_r($data_tindakan1);
				// exit();
				foreach($data_tindakan1 as $row1){
					if($row1->bpjs==0){
						$konten=$konten."
						<tr>
							<td><p align=\"center\">".$no++."</p></td>
							<td>".ucwords(strtolower($row1->nmtindakan))."</td>
							<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>
							</tr>";
                                                // $jumlah_vtot=0;
                                                $jumlah_vtot=$jumlah_vtot+$row1->vtot;
					}
				}			
				// foreach($data_ok as $row1){
				// 		$konten=$konten."
				// 		<tr>
				// 			<td><p align=\"center\">".$no++."</p></td>
				// 			<td>(ok) ".ucwords(strtolower($row1->jenis_tindakan))."</td>
				// 			<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>
				// 			</tr>";
				// 		}				
				if($diskon>0 && $data_pasien->cara_bayar=='UMUM'){
					$txtdiskon="<tr>
									<td width=\"17%\"><b>Diskon</b></td>
									<td width=\"2%\"> : </td>
									<td  width=\"78%\"><i>".number_format( $diskon, 2 , ',' , '.' )."</i></td>
								</tr>";
					}else $txtdiskon="";
					if($data_pasien->cara_bayar=='UMUM'){
						$txttunai="<tr>
										<td width=\"17%\"><b>Jumlah Yang Dibayar</b></td>
										<td width=\"2%\"> : </td>
										<td  width=\"78%\"><i>".number_format($jumlah_vtot, 2 , ',' , '.' )."</i></td>
									</tr>";
						$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);
					}else {
						if($data_pasien->cara_bayar=='DIJAMIN'){
							$txttunai=''; $vtot_terbilang=$cterbilang->terbilang($diskon);
						}
						else{
							$txttunai=''; $vtot_terbilang='Nol Rupiah';
						}
					}
			/* buat print per tindakan
			$i=1;
					$vtot=0;
					foreach($data_tindakan as $row1){
						$vtot=$vtot+$row1->biaya_tindakan;
						$konten=$konten."
						<tr>
							<td><p align=\"center\">".$i++."</p></td>
							<td>$row1->nmtindakan</td>
							<td><p align=\"right\">".number_format( $row1->biaya_tindakan, 2 , ',' , '.' )."</p></td>
						</tr>";
					}
						$konten=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"right\"><b>Total   </b></p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $vtot, 2 , ',' , '.' )."</p></th>
						</tr>
				*/
			$konten=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"right\"><b>Total   </b></p></th>
							<th><p align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
						</tr>
					</table>
					<br/><br/>
					<table  >
					$txtdiskon	
					$txttunai									
					<tr>
								<td width=\"17%\"><b>Terbilang</b></td>
								<td width=\"2%\"> : </td>
								<td  width=\"78%\"><i>".strtoupper($vtot_terbilang)."</i></td>
							</tr>
					</table>";
			
			

			$konten=$konten."
						
					<br/>
					
					";

			/*<tr>
								<td width=\"17%\"><b>Terbilang</b></td>
								<td width=\"2%\"> : </td>
								<td  width=\"78%\"><i>".strtoupper($vtot_terbilang)."</i></td>
							</tr>*/
			
			$konten=$konten."
					
					<table style=\"width:100%;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
								$kota_kab, $tgl
								<br>an. Bendaharawan Rumah Sakit
								<br>K a s i r
								<br><br><br>$user
								</p>
							</td>
						</tr>	
					</table>

					";
			//echo $konten;			
				$file_name="REKAP_IRJ0_$no_register.pdf";			
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();			
				$obj_pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);				
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
				$obj_pdf->Output(FCPATH.'download/irj/rjkwitansi/'.$file_name, 'FI');
		}else{
			redirect('faktur/fcrekap/rawat_jalan/','refresh');
		}
	}


	public function rawat_inap()
	{
		$data['title'] = 'Rekap Faktur Rawat Inap';
		$date=$this->input->post('date');
		if ($date!='') { 
			$data['date'] = date('d-m-Y',strtotime($date));
			$data['pasien_daftar']=$this->fmrekap->get_pasien_kwitansi_iri_by_date($date)->result();
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
		}else{
		$data['date'] = date('d-m-Y');
		$data['pasien_daftar']=$this->fmrekap->get_rekap_faktur_iri()->result();
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
		}
		$this->load->view('faktur/fvrekap_iri',$data);
	}
	
	public function rawat_darurat()
	{
		$data['title'] = 'Rekap Faktur Rawat Darurat';
		$date=$this->input->post('date');
		$setor='';
		echo '<script type="text/javascript">document.cookie = "penyetor='.$setor.'";</script>';
		//echo $date;
		if ($date!='') { 
			$data['date'] = date('d-m-Y',strtotime($date));
			$data['pasien_daftar']=$this->fmrekap->get_pasien_kwitansi_ird_by_date($date)->result();
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
		}else{
		$data['date'] = date('d-m-Y');
		$data['pasien_daftar']=$this->fmrekap->get_rekap_faktur_ird()->result();
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
		}
		$this->load->view('faktur/fvrekap_ird',$data);
		
	}
	public function faktur_ird($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/ird/rdkwitansi/'.$link));
	}
	
	public function faktur_irj($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/irj/rjkwitansi/'.$link));
	}	
	
	public function lab()
	{
		$data['title'] = 'Rekap Faktur & Kwitansi Laboratorim';
		$date=$this->input->post('date');
		if ($date!='') { 
			$data['date'] = date('d-m-Y',strtotime($date));
			$data['daftar_lab']=$this->fmrekap->get_rekap_lab_by_date($date)->result();
		}else{
			$data['date'] = date('d-m-Y');
			$data['daftar_lab']=$this->fmrekap->get_rekap_lab()->result();
		}
		$this->load->view('faktur/fvrekap_lab',$data);
	}
	public function faktur_lab($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/lab/labfaktur/'.$link));
	}
	public function kwitansi_lab($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/lab/labkwitansi/'.$link));
	}
	
	public function rad()
	{
		$data['title'] = 'Rekap Faktur & Kwitansi Radiologi';
		$date=$this->input->post('date');
		if ($date!='') { 
			$data['date'] = date('d-m-Y',strtotime($date));
			$data['daftar_rad']=$this->fmrekap->get_rekap_rad_by_date($date)->result();
		}else{
			$data['date'] = date('d-m-Y');
			$data['daftar_rad']=$this->fmrekap->get_rekap_rad()->result();
		}
		$this->load->view('faktur/fvrekap_rad',$data);
	}
	public function faktur_rad($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/rad/radfaktur/'.$link));
	}
	public function kwitansi_rad($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/rad/radkwitansi/'.$link));
	}
	
	public function frm()
	{
		$data['title'] = 'Rekap Faktur & Kwitansi Farmasi';
		$date=$this->input->post('date');
		if ($date!='') { 
			$data['date'] = date('d-m-Y',strtotime($date));
			$data['daftar_farmasi']=$this->fmrekap->get_rekap_frm_by_date($date)->result();
		}else{
			$data['date'] = date('d-m-Y');
			$data['daftar_farmasi']=$this->fmrekap->get_rekap_frm()->result();
		}
		$this->load->view('faktur/fvrekap_frm',$data);
	}
	public function faktur_frm($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/farmasi/frmkwitansi/'.$link));
	}

	//pembayaran_RI00000008_Tentara_Coba
	//"detail_pembayaran_".$pasien[0]['no_ipd']."_".$nama_pasien." .pdf"
	public function kw_iri($noreg)
	{
		$data1=$this->fmrekap->get_data_pasien_by_noreg($noreg)->row();
		$nama = str_replace(" ","_",$data1->nama);	
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/inap/laporan/pembayaran/detail_pembayaran_'.$noreg.'_'.$nama.' .pdf'));
	}

	//detail_pembayaran_".$pasien[0]['no_ipd']."_".$nama_pasien."_faktur.pdf
	public function faktur_iri($noreg)
	{
		$data1=$this->fmrekap->get_data_pasien_by_noreg($noreg)->row();
		$nama = str_replace(" ","_",$data1->nama);	
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/inap/laporan/pembayaran/detail_pembayaran_'.$noreg.'_'.$nama.'_faktur.pdf'));
	}

	public function kw_irj_1($noreg)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/irj/rjkwitansi/Daftar_'.$noreg.'-1.pdf'));
	}
	public function kw_irj_2($noreg)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/irj/rjkwitansi/IRJ_'.$noreg.'.pdf'));
	}
	public function kwitansi_frm($link)
	{
		$url = $this->output
           ->set_content_type('application/pdf')
           ->set_output(file_get_contents(FCPATH.'download/farmasi/frmkwitansi/'.$link));
	}
	
}
?>
