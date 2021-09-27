 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
include('Pacterbilang.php');
require_once(APPPATH.'controllers/Secure_area.php');

class Packwitansi extends Secure_area{
	public function __construct() {
		parent::__construct();
		$this->load->model('pa/pamdaftar','',TRUE);
		$this->load->model('pa/pamkwitansi','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index()
	{
		redirect('pa/packwitansi/kwitansi','refresh');
	}
	
	public function kwitansi()
	{
		$data['title'] = 'Kwitansi Patologi Anatomi';
		$data['daftar_pa']=$this->pamkwitansi->get_list_kwitansi()->result();
		if(sizeof($data['daftar_pa'])==0){
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
		$this->load->view('pa/pavkwitansi',$data);
	}

	public function kwitansi_by_no()
	{
		$data['title'] = 'Kwitansi Patologi Anatomi';
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$key=$this->input->post('key');
			$data['daftar_pa']=$this->pamkwitansi->get_list_kwitansi_by_no($key)->result();
			
			if(sizeof($data['daftar_pa'])==0){
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
			$this->load->view('pa/pavkwitansi',$data);
		}else{
			redirect('pa/packwitansi/kwitansi');
		}
	}

	public function kwitansi_by_date()
	{
		$data['title'] = 'Kwitansi Patologi Anatomi';
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$date=$this->input->post('date');
			$data['daftar_pa']=$this->pamkwitansi->get_list_kwitansi_by_date($date)->result();
			if(sizeof($data['daftar_pa'])==0){
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
			$this->load->view('pa/pavkwitansi',$data);
		}else{
			redirect('pa/packwitansi/kwitansi');
		}
	}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////read data pelayanan poli per pasien
	public function kwitansi_pasien($no_pa='')
	{
		$data['title'] = 'Cetak Kwitansi Patologi Anatomi';
		if($no_pa!=''){
			$data['no_pa']=$no_pa;
			$data['data_pasien']=$this->pamkwitansi->get_data_pasien($no_pa)->row();
			$data['data_pemeriksaan']=$this->pamkwitansi->get_data_pemeriksaan($no_pa)->result();
			if(sizeof($data['data_pemeriksaan'])==0){
				$this->session->set_flashdata('message_no_tindakan','<div class="row">
							<div class="col-md-12">
							  <div class="box box-default box-solid">
								<div class="box-header with-border">
								  <center>Tidak Ada Tindakan</center>
								</div>
							  </div>
							</div>
						</div>');
			}else{
				$this->session->set_flashdata('message_no_tindakan','');
			}
			
			$this->load->view('pa/pavkwitansipasien',$data);
		}else{
			redirect('pa/packwitansi/kwitansi');
		}
	}
	
	public function st_cetak_kwitansi_kt()
	{
		$no_pa=$this->input->post('no_pa');
		$xuser=$this->input->post('xuser');
		if ($this->input->post('penyetor')=="") 
		{
			$data_pasien=$this->pamkwitansi->get_data_pasien($no_pa)->row();
			$penyetor=$data_pasien->nama;
		} else {
			$penyetor=$this->input->post('penyetor');
		}
		$jumlah_vtot=$this->input->post('jumlah_vtot');
		$diskon=$this->input->post('diskon_hide');

		if($no_pa!=''){
			$no_register=$this->pamdaftar->get_row_register_by_nopa($no_pa)->row()->no_register;
			$this->pamkwitansi->update_status_cetak_kwitansi($no_pa, $diskon, $no_register, $xuser);
			//print_r($no_pa.' '.$diskon.' '.$no_register.' '.$xuser);
			echo '<script type="text/javascript">document.cookie = "penyetor='.$penyetor.'";document.cookie = "diskon='.$diskon.'";document.cookie = "jumlah_vtot='.$jumlah_vtot.'";window.open("'.site_url("pa/packwitansi/cetak_kwitansi_kt/$no_pa").'", "_blank");window.focus()</script>';
			
			redirect('pa/packwitansi/kwitansi/','refresh');
		}else{
			redirect('pa/packwitansi/kwitansi/','refresh');
		}
	}

	public function st_selesai_kwitansi_kt($no_pa='')
	{
		if($no_pa!=''){
			redirect('pa/packwitansi/kwitansi/','refresh');
		}else{
			redirect('pa/packwitansi/kwitansi/','refresh');
		}
	}

	public function cetak_kwitansi_kt($no_pa='')
	{
		$penyetor =  $_COOKIE['penyetor'];
		$jumlah_vtot =  $_COOKIE['jumlah_vtot'];
		$diskon =  $_COOKIE['diskon'];
		if($no_pa!=''){
			$cterbilang=new pacterbilang();
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");
			
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');

			$data_pasien=$this->pamkwitansi->get_data_pasien($no_pa)->row();
			$data_pemeriksaan=$this->pamkwitansi->get_data_pemeriksaan($no_pa)->result();
			
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
							<td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam</font></td>						
						</tr>
					</table>
					<hr>
					<p align=\"center\"><b>
					KWITANSI PATOLOGI ANATOMI 
					No. PA_$no_pa
					</b></p>
					<table border=\"0\">
						<tr>
							<td width=\"20%\"><b>Sudah Terima Dari</b></td>
							<td width=\"5%\"> : </td>
							<td width=\"25%\">$penyetor</td>
							<td width=\"20%\"><b>Tanggal Periksa</b></td>
							<td width=\"5%\"> : </td>
							<td width=\"25%\">$tgl</td>
						</tr>
						<tr>
							<td><b>Nama Pasien</b></td>
							<td> : </td>
							<td>$data_pasien->nama</td>
							<td width=\"20%\"><b>No. Registrasi</b></td>
							<td width=\"5%\"> : </td>
							<td width=\"25%\">$data_pasien->no_register</td>
						</tr>
						<tr>
							<td><b>Alamat</b></td>
							<td> : </td>
							<td rowspan=\"2\">$data_pasien->alamat</td>
							<td width=\"20%\"><b>No. Medrec</b></td>
							<td width=\"5%\"> : </td>
							<td width=\"25%\">$data_pasien->no_cm</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td><b>Golongan Pasien</b></td>
							<td> : </td>
							<td>$data_pasien->cara_bayar</td>
						</tr>
					</table>
					<br/><br/>
					<table border=\"1\" style=\"padding:2px\">
						<tr>
							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
							<th width=\"65%\"><p align=\"center\"><b>Nama Pemeriksaan</b></p></th>
							<th width=\"10%\"><p align=\"center\"><b>Banyak</b></p></th>
							<th width=\"20%\"><p align=\"center\"><b>Total</b></p></th>
						</tr>
					";
					$i=0;
					$jumlah_vtot=0;
					foreach($data_pemeriksaan as $row){
						$jumlah_vtot=$jumlah_vtot+$row->vtot;
						$vtot = number_format( $row->vtot, 2 , ',' , '.' );
						$i++;
					}

				$konten=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"center\"><b> Patologi Anatomi  </b></p></th>
							<th><p align=\"right\"><b>".$i."   </b></p></th>
							<th><p align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
						</tr>";
				if($diskon!=0){
					$konten=$konten."
						<tr>
							<th colspan=\"3\"><p align=\"right\"><b>Diskon   </b></p></th>
							<th><p align=\"right\">".number_format( $diskon, 2 , ',' , '.' )."</p></th>
						</tr>";
					$jumlah_vtot=$jumlah_vtot-$diskon;
					$konten=$konten."
						<tr>
							<th colspan=\"3\"><p align=\"right\"><b>Total Bayar</b></p></th>
							<th><p align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
						</tr>";
				}
				$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);

				$login_data = $this->load->get_var("user_info");
				$user = strtoupper($login_data->username);
					
				$konten=$konten."
					</table>
					<br><br>
					<b width=\"50%\">
						<font size=\"9\">Terbilang<br>
							<i>".strtoupper($vtot_terbilang)."
						</font>
					</b><br><br><br>
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
			
			$file_name="KW_$no_pa.pdf";
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
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/pa/pakwitansi/'.$file_name, 'FI');
		}else{
			redirect('pa/packwitansi/kwitansi/','refresh');
		}
	}

}
?>