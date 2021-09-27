 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('rjcterbilang.php');
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

class IrDKwitansi extends Secure_area{
	public function __construct() {
		parent::__construct();
		$this->load->model('ird/ModelPelayanan','',TRUE);
		$this->load->model('ird/ModelRegistrasi','',TRUE);
		$this->load->model('ird/ModelKwitansi','',TRUE);
		$this->load->model('irj/rjmkwitansi','',TRUE);
		$this->load->helper('pdf_helper');
	}
	public function index()
	{
		
		$data['title'] = 'Instalasi Rawat Darurat';

		redirect('ird/IrDRegistrasi/','refresh');
	}
	public function cetak_karcis($no_register='')
	{
		$data['title'] = 'Instalasi Rawat Darurat';

		if($no_register!=''){
			/*$get_nokarcis=$this->ModelKwitansi->get_new_nokarcis($no_register)->result();
				foreach($get_nokarcis as $val){
					$noseri_karcis=sprintf("B%s%05s",$val->year,$val->counter+1);
				}
			$this->ModelKwitansi->update_nokarcis($noseri_karcis,$no_register);*/
			
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');

			$data_karcis=$this->ModelKwitansi->getdata_karcis($no_register)->result();

			//set timezone
			date_default_timezone_set("Asia/Jakarta");			
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl=date("d-m-Y");

			foreach($data_karcis as $row){
			$konten=
					"<br/><br/>
					$namars<br/>
					$alamatrs, $kota_kab<br/><br/>
					
					Administrasi Berobat Ins. Rawat Darurat<br/><br/>
					<table>
						<tr>
							<td width=\"30%\">No. Seri Karcis</td>
							<td width=\"5%\"> : </td>
							<td width=\"65%\"><b>$no_register</b></td>
						</tr>
						<tr>
							<td>Pasien</td>
							<td> : </td>
							<td>Umum</td>
						</tr>
						<tr>
							<td>No. CM</td>
							<td> : </td>
							<td><b>$row->no_medrec</b></td>
						</tr>
						<tr>
							<td>No. Registrasi</td>
							<td> : </td>
							<td><b>$row->no_register</b></td>
						</tr>
						<tr>
							<td>Nama</td>
							<td> : </td>
							<td><b>$row->nama</b></td>
						</tr>						
						<tr>
							<td>Tgl Cetak Karcis</td>
							<td> : </td>
							<td>$tgl_jam</td>
						</tr>
						<tr>
							<td>Petugas</td>
							<td> : </td>
							<td>-</td>
						</tr>
						<tr>
							<td>Biaya Karcis</td>
							<td> : </td>
							<td><b><font size=\"10\">Rp ".number_format( $row->biayadaftar, 2 , ',' , '.' )."</font></b></td>
						</tr>
					</table></br>
					<hr/>
			";
			}
			$file_name="KC_$no_register.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('L', PDF_UNIT, 'A7', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				// $obj_pdf->SetFooterMargin('5');
				$obj_pdf->SetMargins('5', '5', '5');//left top right
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 7);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/ird/rdkarcis/'.$file_name, 'FI');
		}else{
			redirect('ird/rjcregistrasi','refresh');
		}
	}
	public function kwitansi()
	{
		$data['title'] = 'Kwitansi Rawat Darurat';

		$data['pasien_daftar']=$this->ModelKwitansi->get_pasien_kwitansi()->result();
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
		$this->load->view('ird/form_kwitansi',$data);
	}
	public function kwitansi_by_no()
	{
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$key=$this->input->post('key');
			if($this->input->post('based')=='no_cm'){
				$data['pasien_daftar']=$this->ModelKwitansi->get_pasien_kwitansi_by_nocm($key)->result();
			}else{
				$data['pasien_daftar']=$this->ModelKwitansi->get_pasien_kwitansi_by_noregister($key)->result();
			}
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
			$this->load->view('ird/rjvkwitansi',$data);
		}else{
			redirect('ird/rjckwitansi/kwitansi');
		}
	}
	public function kwitansi_by_date()
	{
		$data['title'] = 'Kwitansi Rawat Darurat';
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$date=$this->input->post('date');
			$data['pasien_daftar']=$this->ModelKwitansi->get_pasien_kwitansi_by_date($date)->result();
			if(sizeof($data['pasien_daftar'])==0){
				$this->session->set_flashdata('message_nodata','<div class="content-header">
				<div class="alert alert-danger alert-dismissable">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>				
				<h4><i class="icon fa fa-check"></i>
					Tidak Ditemukan Data
				</h4>							
				</div>
			</div>');
			}else{
				$this->session->set_flashdata('message_nodata','');
			}
			$this->load->view('ird/form_kwitansi',$data);
		}else{
			redirect('ird/IrDKwitansi/kwitansi');
		}
	}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////read data pelayanan poli per pasien
	public function kwitansi_pasien($no_register='')
	{
		$data['title'] = 'Kwitansi Pasien Rawat Darurat';
		if($no_register!=''){
			$data['no_register']=$no_register;
			$data['data_pasien']=$this->ModelKwitansi->getdata_pasien($no_register)->result();
			$data['data_tindakan']=$this->ModelKwitansi->getdata_tindakan_pasien($no_register)->result();
			$data['data_laboratorium']=$this->ModelKwitansi->getdata_lab_pasien($no_register)->result();
			$data['data_radiologi']=$this->ModelKwitansi->getdata_rad_pasien($no_register)->result();
			$data['data_resep']=$this->ModelKwitansi->getdata_resep_pasien($no_register)->result();
			$data['data_pa']=$this->ModelKwitansi->getdata_pa_pasien($no_register)->result();
			$data['data_ok']=$this->ModelKwitansi->getdata_ok_pasien($no_register)->result();
			$data['vtot']=$this->ModelKwitansi->get_vtot($no_register)->row();

			foreach($data['data_pasien'] as $row){
			if($row->cara_bayar=='DIJAMIN / JAMSOSKES'){			
			$data['kontraktor']=$this->ModelKwitansi->getdata_perusahaan($no_register)->row();
			//$data['kontraktor']=$detail_kontraktor->nmkontraktor;
			}
			}
			if(sizeof($data['data_tindakan'])==0 and sizeof($data['data_laboratorium'])==0 and sizeof($data['data_radiologi'])==0 and sizeof($data['data_resep'])==0){
			$data1['vtot']='0';$data1['vtot_lab']='0';$data1['vtot_rad']='0';$data1['vtot_obat']='0';$data1['vtot_pa']='0';$data1['vtot_ok']='0';
			$this->ModelKwitansi->update_pembayaran($no_register,$data1);

				//print_r($data['data_tindakan']);
				$this->session->set_flashdata('message_no_tindakan','<div class="content-header">
				<div class="alert alert-danger alert-dismissable">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>				
				<h4><i class="icon fa fa-check"></i>
					Tidak Ada Tindakan
				</h4>							
				</div>
			</div>');
			}else{
				$this->session->set_flashdata('message_no_tindakan','');
			}
			$this->load->view('ird/form_kwitansipasien',$data);
		}else{
			redirect('ird/IrDKwitansi/kwitansi');
		}
	}
	//pasien_bayar, tunai, no_kkkd, nila_kkkd, persen_kk, lunas
	public function st_cetak_kwitansi_kt()
	{
		$no_register=$this->input->post('no_register');
		//$penyetor=$this->input->post('penyetor');
		$pilih=$this->input->post('pilih');
		
		$data['tunai']='0';$data['no_kkkd']='0';$data['nila_kkkd']='0';$data['persen_kk']='0';$data['diskon']='0';
		$this->ModelKwitansi->update_pembayaran($no_register,$data);

		$data['pasien_bayar']=$this->input->post('jenis_bayar_hide');

		if($this->input->post('nilai_tunai')){
			$data['tunai']=$this->input->post('nilai_tunai');
		}		

		$data_pasien=$this->ModelKwitansi->getdata_pasien($no_register)->row();
		
		$data['lunas']='1';
	
		
		

		if($this->input->post('pilih')!='detail'){			
			//if (!($this->input->post('penyetor'))==1) 
			if (!($this->input->post('penyetor'))==1) 
			{
				$penyetor=$data_pasien->nama;
				
			} else {
				$penyetor=$this->input->post('penyetor');
			}
			$txtpilih='document.cookie = "pilih=0";';
		}else{
			
			//if (!($this->input->post('penyetor_hide'))==1) 
			if (!($this->input->post('penyetor_hide'))==1) 
			{
				$data_pasien=$this->ModelKwitansi->getdata_pasien($no_register)->row();
				$penyetor=$data_pasien->nama;
				
			} else {
				$penyetor=$this->input->post('penyetor_hide');
			}
			
			
		}
		
		
		if ($this->input->post('diskon_hide')!='') 
		{	
			$data['diskon']=$this->input->post('diskon_hide');
		} else 
			$data['diskon']='0';

		if($this->input->post('totfinal_hide')!=''){
			$totakhir=$this->input->post('totakhir');
		}
		print_r($data);

		
		$this->ModelKwitansi->update_pembayaran($no_register,$data);
		print_r($this->input->post('totfinal_hide'));

		if($no_register!=''){
			//ubah status
			$data['cetak_kwitansi']=1;
			
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$data['tgl_cetak_kw']=date("Y-m-d H:i:s");
			
			$login_data = $this->load->get_var("user_info");
			$user = $login_data->username;

			$data['xcetak']= $user;
			$status=$this->ModelKwitansi->update_status_kwitansi_kt($no_register,$data);

			//echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'"; '.$txtpilih.' window.open("'.site_url("ird/IrDKwitansi/cetak_kwitansi_kt/$no_register").'", "_blank");window.focus()</script>';
			$txtpil='document.cookie = "pil=detail";';
			echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'"; '.$txtpil.' window.open("'.site_url("ird/IrDKwitansi/cetak_faktur_kt/$no_register").'", "_blank");window.focus()</script>';
			//echo '<script type="text/javascript">window.open("'.site_url("ird/IrDKwitansi/cetak_kwitansi_kt/$no_register").'", "_blank");window.focus()</script>';
			if($this->input->post('pilih')=='detail'){
				redirect('ird/IrDKwitansi/kwitansi_pasien/'.$no_register,'refresh');
			}else{
				redirect('ird/IrDKwitansi/kwitansi','refresh');
			}
		}else{
			redirect('ird/IrDKwitansi/kwitansi','refresh');
		}
	}
	public function st_selesai_kwitansi_kt($no_register='')
	{
		if($no_register!=''){
			//ubah status
			$data['cetak_kwitansi']='1';
			$status=$this->ModelKwitansi->update_status_kwitansi_kt($no_register,$data);
			redirect('ird/IrDKwitansi/kwitansi','refresh');
		}else{
			redirect('ird/IrDKwitansi/kwitansi','refresh');
		}
	}

	
	
	public function cetak_kwitansi_kt($no_register='')
	{
		$penyetor =  $_COOKIE['penyetor'];

		if($_COOKIE['pilih']!='0'){
			$pilih =  $_COOKIE['pilih'];
		}else $pilih='';					

		if($no_register!=''){
		$cterbilang=new rjcterbilang();
			/*$get_no_kwkt=$this->ModelKwitansi->get_new_kwkt($no_register)->result();
				foreach($get_no_kwkt as $val){
					$no_kwkt=sprintf("KT%s%06s",$val->year,$val->counter+1);
				}*/
			//$this->ModelKwitansi->update_kwkt($no_kwkt,$no_register);
			/*$tgl_kw=$this->ModelKwitansi->getdata_tgl_kw($no_register)->result();
				foreach($tgl_kw as $row){
					$tgl_jam=$row->tglcetak_kwitansi;
					$tgl=$row->tgl_kwitansi;
				}*/
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$telp=$this->config->item('telp');
			
			$vtot=$this->ModelKwitansi->get_vtot($no_register)->row();
			$jumlah_vtot_asli =  $vtot->vtot + $vtot->vtot_lab + $vtot->vtot_rad + $vtot->vtot_obat;
			$jumlah_vtot=$jumlah_vtot_asli;

			//set timezone
			date_default_timezone_set("Asia/Jakarta");			
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl=date("d-m-Y");

			
			$detail_daful=$this->ModelRegistrasi->get_detail_daful($no_register)->row();
			//print_r($detail_daful);
			if($detail_daful->pasien_bayar=='1'){
				$pasien_bayar='TUNAI';
			}else $pasien_bayar='KREDIT';
			$txtkk='';
			$txtdiskon='';
			$txttunai="";
			$txtperusahaan='';
			$totalbayar='';
			$tunai_bulat='';
			$detail_bayar=$detail_daful->cara_bayar;


			//print_r($detail_bayar);
			if($detail_bayar=='DIJAMIN / JAMSOSKES')
			{
				$kontraktor=$this->ModelKwitansi->getdata_perusahaan($no_register)->row();
				if($kontraktor!=''){
					$txtperusahaan="<td><b>Perusahaan</b></td>
						<td> : </td>
						<td>$detail_daful->id_kontraktor - ".strtoupper($kontraktor->nmkontraktor)."</td>";
				}
				
			}
			
			$diskon=$detail_daful->diskon;
			$persen=$detail_daful->persen_kk;
			$tunai=$detail_daful->tunai;
			$nilaikk=$detail_daful->nila_kkkd;
			$nominal_kk=$persen/100*$nilaikk+$nilaikk;
			
			

			if($diskon!='' and $diskon!='0'){
				if($detail_bayar=='BPJS'){//Total Biaya Ditanggung
					$txtdiskon="<tr><td width=\"50%\"><p  style=\"font-size:11px;\">Total Biaya Ditanggung</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\"><p  align=\"right\" style=\"font-size:12px;\">".number_format( $detail_daful->diskon, 2 , ',' , '.' )."</p></td></tr>
					    ";
				}else
				$txtdiskon="<tr><td width=\"50%\"><p  style=\"font-size:11px;\">Dijamin/Potongan</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\"><p  align=\"right\" style=\"font-size:12px;\">".number_format( $detail_daful->diskon, 2 , ',' , '.' )."</p></td></tr>
					    ";				
			}

			if($nilaikk!='' and $nilaikk!='0'){
			$txtkk="<tr>
					<td width=\"50%\"><p  style=\"font-size:11px;\">Kartu Kredit/Debit</p></td>
					<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:12px;\">".number_format($nominal_kk , 2 , ',' , '.' )."</p></td></tr>";
			}
			//echo $nilaikk;
			if(($tunai!='' and $tunai!='0') or ( $nilaikk=='' or $nilaikk=='0')){

				$tot1 = $tunai;
						$tot2 = substr($tot1, - 3);
						if ($tot2 % 500 != 0){
							$mod = $tot2 % 500;
							$tot1 = $tot1 - $mod;
							$tot1 = $tot1 + 500; 
						}
					$tunai_bulat=$tot1;
				
				if($tunai_bulat!='0'){
				$txttunai="<tr>
					<td width=\"50%\"><p  style=\"font-size:11px;\">Total Bayar</p></td>
					<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:12px;\">".number_format($tunai_bulat , 2 , ',' , '.' )."</p></td></tr>";
				}
				
			}

			if(($tunai!='' and $tunai!='0') and ($nilaikk!='' and $nilaikk!='0')){

				$tot1 = $tunai;
						$tot2 = substr($tot1, - 3);
						if ($tot2 % 500 != 0){
							$mod = $tot2 % 500;
							$tot1 = $tot1 - $mod;
							$tot1 = $tot1 + 500; 
						}
					$tunai_bulat=$tot1;
				
				$txttunai="<tr>
					<td width=\"50%\"><p  style=\"font-size:11px;\">Tunai</p></td>
					<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
					<td width=\"40%\" ><p  align=\"right\" style=\"font-size:12px;\">".number_format($tunai_bulat , 2 , ',' , '.' )."</p></td></tr>";
				$totalbayar="<tr >						
						<td width=\"50%\" ><p  style=\"font-size:11px;  margin:0;\">Total</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\" style=\"font-size:11px; \"><p align=\"right\" style=\"font-size:12px; border-top: 1pt solid black;\">  ".number_format( $jumlah_vtot=$nominal_kk+$tunai_bulat+$diskon, 2 , ',' , '.' )."</p></td>
					</tr>";
			}

			if($diskon!='0' or $nominal_kk!='0' or $tunai!='0'){
				
					$jumlah_vtot=$nominal_kk+$tunai+$diskon;
					
			}

			if(($diskon!='' and $diskon!='0') and ($nilaikk!='' and $nilaikk!='0')){
								
				$totalbayar="<tr >						
						<td width=\"50%\" ><p  style=\"font-size:11px;  margin:0;\">Total</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\" style=\"font-size:11px; \"><p align=\"right\" style=\"font-size:12px; border-top: 1pt solid black;\">  ".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></td>
					</tr>";
			}

			
			
			$style='';
			if($txttunai!='' or $txtkk!='' or $txtdiskon!='')
			{
				$style="border-top: 1pt solid black;";
			}

			if($this->ModelKwitansi->getdata_pasien($no_register)->num_rows()>0){
			$data_pasien=$this->ModelKwitansi->getdata_pasien($no_register)->result();
			
			/*foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_ird;
			}*/
			//print_r($data_pasien);
			foreach($data_pasien as $row){
			$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);
			
			$judul='KWITANSI';
			$terBilang="<tr>
					<td width=\"17%\"><b>Terbilang</b></td>
					<td width=\"2%\"> : </td>
					<td  width=\"78%\"><i>".strtoupper($vtot_terbilang)."</i></td>
				    </tr>";

			$konten=
					"<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					.table-font-size1{
						font-size:12px;
					    }
					</style>
					
					<table class=\"table-font-size\" border=\"0\">
						<tr>
						<td rowspan=\"3\" width=\"30%\" style=\"border-bottom:1px solid black; font-size:8px; \"><p align=\"left\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"30\" style=\"padding-right:5px;\"></p>$namars</td>
						<td rowspan=\"3\" width=\"40%\" style=\"border-bottom:1px solid black; font-size:8px;\"> </td>
						<td width=\"5%\"></td>						
						</tr>
						<tr><td></td><td></td></tr>
						<tr><td></td><td colspan=\"1\"><p align=\"left\" style=\"font-size:10px;\"><b>Pembayaran : <u>".$pasien_bayar."</u></b></p></td></tr>
					</table>
					
					
					<table >
						<tr>							
							<td><font size=\"8\" align=\"left\"></font></td>
						</tr>			
						<tr>
							<td colspan=\"3\" ><font size=\"12\" align=\"center\"><u><b>$judul RAWAT DARURAT<br/>
					No. KW. $no_register</b></u></font></td>
						</tr>	<br>		
							$terBilang			
							<tr>
								<td width=\"17%\"><b>Untuk Pemeriksaan</b></td>
								<td width=\"2%\"> : </td>
								<td width=\"78%\"><i>Untuk Pembayaran Pemeriksaan, Tindakan dan pengobatan Rawat Darurat sesuai nota terlampir</i></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>";
					
						$konten=$konten."<td width=\"17%\"><b>Nama Pasien</b></td>
								<td width=\"2%\">:</td>
								<td width=\"37%\">".strtoupper($row->nama)."</td>
								<td width=\"19%\"><b>Tanggal Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td>".date("d-m-Y",strtotime($row->tgl_kunjungan))."</td>
							</tr>
							<tr>
								<td><b>Umur</b></td>
								<td>:</td>
								<td>".$detail_daful->umurrj." TAHUN</td>
								<td ><b>No Medrec</b></td>
								<td > : </td>
								<td>".strtoupper($row->no_cm)."</td>
							</tr>
							<tr>
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($row->cara_bayar)."</td>
								<td><b>Alamat</b></td>
								<td> : </td>
								<td>".strtoupper($row->alamat)."</td>
							</tr>
							
							<tr>
								<td></td>
								<td></td>
								<td></td>
								$txtperusahaan
							</tr>
							
							
							
							
					</table>	
				";
			
			
			if($pilih==''){													

				$konten=$konten."
						
					<br/><br/>
					
					<table style=\"border:1px solid black; width:100%;\" >
					$txttunai
					$txtkk				
					$txtdiskon
					$totalbayar										
					
					</table>
					";
				
			}
			
			}
			
				$konten=$konten."
					<p align=\"right\">$kota_kab, $tgl<br>an. Kepala Rumah Sakit<br>K a s i r &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br><br></p><p align=\"right\">$user&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
					
					";
			
			
			if($pilih==''){
				$file_name="KW_$no_register.pdf";
			}
				//echo $konten;
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				
				if($pilih==''){
					$obj_pdf = new MYPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
				}else
					$obj_pdf = new MYPDF('P', PDF_UNIT, 'A5', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->setPrintHeader(false); //To remove first line on the top
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin('0');
				$obj_pdf->SetFooterMargin('5');
				$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
				$obj_pdf->SetAutoPageBreak(TRUE, '20');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				if($detail_bayar!='UMUM' and $pilih==''){
					$obj_pdf->AddPage();
					ob_start();
						$content = $konten;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');				
				}
				$obj_pdf->Output(FCPATH.'download/ird/rdkwitansi/'.$file_name, 'FI');
				$data['cetak_kwitansi']='1';
				//echo $vtot->vtot_lab!='';
				if($vtot->vtot_lab!=''){
					$this->rjmkwitansi->update_kw_penunjang($no_register,$data,'pemeriksaan_laboratorium');
				}
				if($vtot->vtot_rad!=''){
					$this->rjmkwitansi->update_kw_penunjang($no_register,$data,'pemeriksaan_radiologi');
				}
				if($vtot->vtot_obat!=''){
					$this->rjmkwitansi->update_kw_penunjang($no_register,$data,'resep_pasien');
				}
			}else{
			redirect('ird/IrDKwitansi/kwitansi/','refresh');
		}
		}else{
			redirect('ird/IrDKwitansi/kwitansi/','refresh');
		}
	}
	
	public function cetak_faktur_kt($no_register='')
	{
		$penyetor =  $_COOKIE['penyetor'];

		if($_COOKIE['pil']!='0'){
			$pilih =  $_COOKIE['pil'];
		}else $pilih='';
	
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;

		if($no_register!=''){
		$cterbilang=new rjcterbilang();
			/*$get_no_kwkt=$this->ModelKwitansi->get_new_kwkt($no_register)->result();
				foreach($get_no_kwkt as $val){
					$no_kwkt=sprintf("KT%s%06s",$val->year,$val->counter+1);
				}*/
			//$this->ModelKwitansi->update_kwkt($no_kwkt,$no_register);
			/*$tgl_kw=$this->ModelKwitansi->getdata_tgl_kw($no_register)->result();
				foreach($tgl_kw as $row){
					$tgl_jam=$row->tglcetak_kwitansi;
					$tgl=$row->tgl_kwitansi;
				}*/
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$telp=$this->config->item('telp');
			
			$vtot=$this->ModelKwitansi->get_vtot($no_register)->row();
			$jumlah_vtot_asli =  $vtot->vtot + $vtot->vtot_lab + $vtot->vtot_rad + $vtot->vtot_obat + $vtot->vtot_ok;
			$jumlah_vtot=$jumlah_vtot_asli;

			//set timezone
			date_default_timezone_set("Asia/Jakarta");			
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl=date("d-m-Y");

			
			$detail_daful=$this->ModelRegistrasi->get_detail_daful($no_register)->row();
			//print_r($detail_daful);
			if($detail_daful->pasien_bayar=='1'){
				$pasien_bayar='TUNAI';
			}else $pasien_bayar='KREDIT';
			$txtkk='';
			$txtdiskon='';
			$txttunai="";
			$txtperusahaan='';
			$totalbayar='';
			$tunai_bulat='';
			$detail_bayar=$detail_daful->cara_bayar;


			//print_r($detail_bayar);
			if($detail_bayar=='DIJAMIN / JAMSOSKES')
			{
				$kontraktor=$this->ModelKwitansi->getdata_perusahaan($no_register)->row();
				if($kontraktor!=''){
					$txtperusahaan="<td><b>Perusahaan</b></td>
						<td> : </td>
						<td>$detail_daful->id_kontraktor - ".strtoupper($kontraktor->nmkontraktor)."</td>";
				}
			}
			
			$diskon=$detail_daful->diskon;
			$persen=$detail_daful->persen_kk;
			$tunai=$detail_daful->tunai;
			$nilaikk=$detail_daful->nila_kkkd;
			$nominal_kk=$persen/100*$nilaikk+$nilaikk;
			
			$style='';
		
			if($this->ModelKwitansi->getdata_pasien($no_register)->num_rows()>0){
			$data_pasien=$this->ModelKwitansi->getdata_pasien($no_register)->result();
			
			/*foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_ird;
			}*/
			//print_r($data_pasien);
			foreach($data_pasien as $row){
			$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);
			
			
				$judul='KWITANSI';
				$terBilang="		
							<tr>
								<td width=\"17%\"><b>Terbilang</b></td>
								<td width=\"2%\"> : </td>
								<td  width=\"78%\"><i>".strtoupper($vtot_terbilang)."</i></td>
							</tr>	";
			

			$konten=
					"<style type=\"text/css\">
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
							<td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam</font></td>						
						</tr>
						<tr><td></td><td colspan=\"2\"><p align=\"right\" style=\"font-size:10px;\"><b>Pembayaran : <u>".$pasien_bayar."</u></b></p></td></tr>
					</table>
					
					<table >								
						<tr>
							<td colspan=\"1\" ><font size=\"12\" align=\"center\"><u><b>$judul RAWAT DARURAT 
					No. $no_register</b></u></font></td>
						</tr>	<br>		
							$terBilang			
							<tr>
								<td width=\"17%\"><b>Untuk Pemeriksaan</b></td>
								<td width=\"2%\"> : </td>
								<td width=\"78%\"><i>Untuk Pembayaran Pemeriksaan, Tindakan dan pengobatan Rawat Darurat sesuai nota terlampir</i></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>";
					
						$konten=$konten."<td width=\"17%\"><b>Nama Pasien</b></td>
								<td width=\"2%\">:</td>
								<td width=\"37%\">".strtoupper($row->nama)."</td>
								<td width=\"19%\"><b>Tgl Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td>".date("d-m-Y",strtotime($row->tgl_kunjungan))."</td>
							</tr>
							<tr>
								<td><b>Umur</b></td>
								<td>:</td>
								<td>".$detail_daful->umurrj." TAHUN</td>
								<td ><b>No Medrec</b></td>
								<td > : </td>
								<td>".strtoupper($row->no_cm)."</td>
							</tr>
							<tr>
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($row->cara_bayar)."</td>
								<td><b>Alamat</b></td>
								<td> : </td>
								<td>".strtoupper($row->alamat)."</td>
							</tr>
							
							<tr>
								<td><b>Sudah Terima Dari</b></td>
								<td>:</td>
								<td>".strtoupper($penyetor)."</td>
								$txtperusahaan
							</tr>
							
							
							
							
					</table>	
				";
			
			
			if($pilih!=''){													

				$no=1;
				$data_tind_pasien=$this->ModelKwitansi->getdata_tindakan_pasien($no_register)->result();
				$data_lab_pasien=$this->ModelKwitansi->getdata_lab_pasien($no_register)->result();
				$data_rad_pasien=$this->ModelKwitansi->getdata_rad_pasien($no_register)->result();
				$data_resep_pasien=$this->ModelKwitansi->getdata_resep_pasien($no_register)->result();
				$data_ok_pasien=$this->ModelPelayanan->getdata_ok_pasien($no_register)->result();
					$konten=$konten."
						<br/><br/>
						<table border=\"1\" style=\"padding:2px\" >
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
						// </tr>
						
						// "; 
							foreach($data_tind_pasien as $row) {
					$konten=$konten."
						<tr>
							<td><p align=\"center\">".$no++."</p></td>
							<td>(Tind)".ucwords(strtolower($row->nmtindakan))."</td>
							<td><p align=\"right\">".number_format(  $row->vtot, 2 , ',' , '.' )."</p></td>
						</tr>
						";}
					// $konten=$konten."
					// 	<tr>
					// 		<td><p align=\"center\">2</p></td>
					// 		<td><b>LABORATORIUM</b></td>
					// 		<td></td>
					// 		<td><p align=\"right\">".number_format( $vtot->vtot_lab, 2 , ',' , '.' )."</p></td>
					// 	</tr>
					// 	";
					foreach($data_lab_pasien as $row) {
					$konten=$konten."
						<tr>
							<td><p align=\"center\">".$no++."</p></td>
							<td>(Lab)$row->jenis_tindakan</td>
							<td><p align=\"right\">".number_format( $row->vtot, 2 , ',' , '.' )."</p></td>
						</tr>
						";
					}
					// $konten=$konten."
					// 	<tr>
					// 		<td><p align=\"center\">3</p></td>
					// 		<td><b>RADIOLOGI</b></td>
					// 		<td></td>
					// 		<td><p align=\"right\">".number_format( $vtot->vtot_rad, 2 , ',' , '.' )."</p></td>
					// 	</tr>
					// 	";
					foreach($data_rad_pasien as $row) {
					$konten=$konten."
						<tr>
							<td><p align=\"center\">".$no++."</p></td>
							<td>(Rad)$row->jenis_tindakan</td>
							<td><p align=\"right\">".number_format(  $row->vtot, 2 , ',' , '.' )."</p></td>
						</tr>
						";}
					// $konten=$konten."
					// 	<tr>
					// 		<td><p align=\"center\">4</p></td>
					// 		<td><b>KAMAR OPERASI</b></td>
					// 		<td></td>
					// 		<td><p align=\"right\">".number_format( $vtot->vtot_ok, 2 , ',' , '.' )."</p></td>
					// 	</tr>
						
					// 	";
					foreach($data_resep_pasien as $row) {
					$konten=$konten."
						<tr>
							<td><p align=\"center\">".$no++."</p></td>
							<td>(OK)".ucwords(strtolower($row->jenis_tindakan))."</td>
							<td><p align=\"right\">".number_format(  $row->vtot, 2 , ',' , '.' )."</p></td>
						</tr>
						";}
					// $konten=$konten."
					// 	<tr>
					// 		<td><p align=\"center\">5</p></td>
					// 		<td><b>OBAT</b></td>
					// 		<td></td>
					// 		<td><p align=\"right\">".number_format( $vtot->vtot_obat, 2 , ',' , '.' )."</p></td>
					// 	</tr>
						
					// 	";
					foreach($data_resep_pasien as $row) {
					$konten=$konten."
						<tr>
							<td><p align=\"center\">".$no++."</p></td>
							<td>(Obat)".ucwords(strtolower($row->nama_obat))."</td>
							<td><p align=\"right\">".number_format(  $row->vtot, 2 , ',' , '.' )."</p></td>
						</tr>
						";}
					
				$konten=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"right\"><b>Total   </b></p></th>
							<th><p align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
						</tr>
					</table>
					<br/><br/>
					<table style=\"border:1px solid black; \" >				
					<tr>
						<td width=\"50%\" ><p  style=\"font-size:11px;\">Total</p></td>
						<td width=\"10%\"><p  style=\"font-size:11px;\">Rp.</p></td>
						<td width=\"40%\" style=\"font-size:11px;\"><p align=\"right\" style=\"font-size:12px;\">  ".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></td>
					</tr>
					
					</table>";
				
			}
			
			}
			
				$konten=$konten."
					<br><br><br>
					<table style=\"width:100%;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
								$kota_kab, $tgl
								<br>an. Kepala Rumah Sakit
								<br>K a s i r
								<br><br><br>$user
								</p>
							</td>
						</tr>	
					</table>
					
					";
			
			
				$file_name="IRD_$no_register.pdf";			
				//echo $konten;
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->setPrintHeader(false); //To remove first line on the top
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setPrintHeader(false);
				$obj_pdf->setPrintFooter(false);
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin('0');
				$obj_pdf->SetFooterMargin('5');
				$obj_pdf->SetMargins('10', '10', '10');
				$obj_pdf->SetAutoPageBreak(TRUE, '20');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');				
				$obj_pdf->Output(FCPATH.'download/ird/rdkwitansi/'.$file_name, 'FI');
			}else{
			redirect('ird/IrDKwitansi/kwitansi/','refresh');
		}
		}else{
			redirect('ird/IrDKwitansi/kwitansi/','refresh');
		}
	}
	
	public function st_cetak_kwitansi_kk($id_pelayanan_poli='',$id_poli='',$no_register='')
	{
		if($id_pelayanan_poli!=''){
			//ubah status
			$status=$this->ModelKwitansi->update_status_kwitansi_kk($id_pelayanan_poli);
			echo '<script type="text/javascript">window.open("'.site_url("ird/rjckwitansi/cetak_kwitansi_kk/$id_pelayanan_poli/$id_poli/$no_register").'", "_blank");window.focus()</script>';
			redirect('ird/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register,'refresh');
		}else{
			redirect('ird/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register,'refresh');
		}
	}
	public function cetak_kwitansi_kk($id_pelayanan_poli='',$id_poli='',$no_register='')
	{	
		if($id_pelayanan_poli!=''){
		$cterbilang=new rjcterbilang();
			$get_no_kwkt=$this->ModelKwitansi->get_new_kwkk($id_pelayanan_poli)->result();
				foreach($get_no_kwkt as $val){
					$no_kwkk=sprintf("KK%s%06s",$val->year,$val->counter+1);
				}
			$this->ModelKwitansi->update_kwkk($no_kwkk,$id_pelayanan_poli);
			$tgl_kk=$this->ModelKwitansi->getdata_tgl_kk($id_pelayanan_poli)->result();
				foreach($tgl_kk as $row){
					$tgl_jam=$row->tglcetak_kwitansi;
					$tgl=$row->tgl_kwitansi;
				}
			// $data_rs=$this->ModelKwitansi->getdata_rs('1671013')->result();
			// 	foreach($data_rs as $row){
			// 		$namars=$row->namars;
			// 		$kota_kab=$row->kota_kab;
			// 	}
			
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$data_kwitansikk=$this->ModelKwitansi->getdata_kwitansikk($id_pelayanan_poli)->result();
			foreach($data_kwitansikk as $row){
			$vtot_terbilang=$cterbilang->terbilang($row->biaya_poli);
			$konten=
					"<table>
						<tr>
							<td><b>DEPARTEMEN KESEHATAN RI</b></td>
							<td><b>Tanggal-Jam: $tgl_jam</b></td>
						</tr>
						<tr>
							<td><b>DirjEN BINA PELAYANAN MEDIK</b></td>
						</tr>
						<tr>
							<td><b>$namars</b></td>
						</tr>
					</table>
					<br/><hr/><br/>
					<p align=\"center\"><b>
					BUKTI PEMBAYARAN - KWITANSI LUNAS BIAYA KONSUL DOKTER RAWAT JALAN<br/>
					No. KW. $no_kwkk
					</b></p><br/>
					<table>
							<tr>
								<td width=\"30%\"><b>Sudah Terima Dari</b></td>
								<td width=\"5%\"> : </td>
								<td width=\"65%\">$row->nama</td>
							</tr>
							<tr>
								<td><b>Nama Pasien</b></td>
								<td> : </td>
								<td>$row->nama</td>
							</tr>
							<tr>
								<td><b>Banyak Uang</b></td>
								<td> : </td>
								<td>$vtot_terbilang</td>
							</tr>
							<tr>
								<td><b>Di Poliklinik</b></td>
								<td> : </td>
								<td>$row->nm_poli</td>
							</tr>
							<tr>
								<td><b>Untuk Biaya Konsul Dokter</b></td>
								<td> : </td>
								<td>$row->nm_dokter</td>
							</tr>
							<tr>
								<td><b>Pemeriksaan</b></td>
								<td> : </td>
								<td>$row->nmtindakan</td>
							</tr>
					</table>
					<br/><br/>
				<b><font size=\"12\">Jumlah : Rp ".number_format( $row->biaya_poli, 2 , ',' , '.' )."</font></b>
				<p align=\"right\">$kota_kab, $tgl</p>
			";
			}
			$file_name="$no_kwkk.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
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
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				  
				$obj_pdf->Output(FCPATH.'download/ird/rjkwitansi/'.$file_name, 'FI');
		}else{
			redirect('ird/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register,'refresh');
		}
	}
}

?>
