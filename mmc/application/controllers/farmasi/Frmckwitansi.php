<?php
defined('BASEPATH') OR exit('No direct script access allowed');


require_once(APPPATH.'controllers/Secure_area.php');
include('Frmcterbilang.php');
class Frmckwitansi extends Secure_area{
	public function __construct() {
		parent::__construct();
		$this->load->model('farmasi/Frmmdaftar','',TRUE);
		$this->load->model('farmasi/Frmmkwitansi','',TRUE);
		$this->load->helper('pdf_helper');
	}
	public function index()
	{
		// $cterbilang=new rjcterbilang();
		// echo $cterbilang->terbilang(100);
		redirect('farmasi/Frmcdaftar','refresh');
	}

	public function kwitansi()
	{
		$data['title'] = 'Kwitansi Farmasi';
		$data['daftar_farmasi']=$this->Frmmkwitansi->get_list_kwitansi()->result();
		if(sizeof($data['daftar_farmasi'])==0){
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
		$this->load->view('farmasi/frmvkwitansi',$data);
	}
	
	public function kwitansi_by_no()
	{
		$data['title'] = 'Kwitansi Farmasi';
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$key=$this->input->post('key');
			$data['daftar_farmasi']=$this->Frmmkwitansi->get_list_kwitansi_by_no($key)->result();
			
			if(sizeof($data['daftar_farmasi'])==0){
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
			$this->load->view('farmasi/frmvkwitansi',$data);
		}else{
			redirect('farmasi/Frmckwitansi/kwitansi');
		}
	}

	public function kwitansi_by_date()
	{
		$data['title'] = 'Kwitansi Farmasi';
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$date=$this->input->post('date');
			$data['daftar_farmasi']=$this->Frmmkwitansi->get_list_kwitansi_by_date($date)->result();
			if(sizeof($data['daftar_farmasi'])==0){
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
			$this->load->view('farmasi/frmvkwitansi',$data);
		}else{
			redirect('farmasi/Frmckwitansi/kwitansi');
		}
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////read data pelayanan poli per pasien
	public function kwitansi_pasien($no_resep='')
	{
		$data['title'] = 'Cetak Kwitansi Farmasi';
		if($no_resep!=''){
			$data['no_resep']=$no_resep;

			$data['data_pasien']=$this->Frmmkwitansi->get_data_pasien($no_resep)->row();
			$data['data_permintaan']=$this->Frmmkwitansi->get_data_permintaan($no_resep)->result();
			if(sizeof($data['data_permintaan'])==0){
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
			
			$this->load->view('farmasi/frmvkwitansipasien',$data);
		}else{
			//printf("redirect");
			redirect('farmasi/Frmckwitansi/kwitansi');
		}
	}
	
	public function faktur_pasien($no_resep='')
	{
		$data['title'] = 'Cetak Kwitansi Farmasi';
		if($no_resep!=''){
			$data['no_resep']=$no_resep;

			$data['data_pasien']=$this->Frmmkwitansi->get_data_pasien($no_resep)->row();
			$data['data_permintaan']=$this->Frmmkwitansi->get_data_permintaan($no_resep)->result();
			if(sizeof($data['data_permintaan'])==0){
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
			
			$this->load->view('farmasi/frmvfakturpasien',$data);
		}else{
			//printf("redirect");
			redirect('farmasi/Frmckwitansi/kwitansi');
		}
	}
	

	public function st_cetak_kwitansi_kt()
	{
		$no_resep=$this->input->post('no_resep');
		$totakhir=$this->input->post('totakhir');
		$no_register=$this->input->post('no_register');
		$xuser=$this->input->post('xuser');
		$diskon=$this->input->post('diskon_hide');

		$data_pasien=$this->Frmmkwitansi->get_data_pasien($no_resep)->row();
	  	//$penyetor=$data_pasien->nama;
		
		
		$no_register=$this->input->post('no_register');

		$getvtotobat=$this->Frmmdaftar->get_vtot_obat($no_register)->row()->vtot_obat;
		$getrdrj=substr($no_register, 0,2);

		if($getrdrj=="PL"){
			$this->Frmmdaftar->selesai_daftar_pemeriksaan_PL($no_register,$getvtotobat,$no_resep);
			//print_r('PL Cetak');
		} else if($getrdrj=="RJ"){
			$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotobat,$no_resep);
		}
		else if ($getrdrj=="RD"){
			$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRD($no_register,$getvtotobat,$no_resep);
		}
		else if ($getrdrj=="RI"){
			$data_iri=$this->Frmmdaftar->getdata_iri($no_register)->result();
			foreach($data_iri as $row){
				$status_obat=$row->status_obat;
			}
			$status_obat = $status_obat + 1;
			$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRI($no_register,$status_obat,$getvtotobat,$no_resep);
		}

		if ($this->input->post('diskon_hide')!='') 
		{	
			if($this->input->post('totakhir')!=''){
				$totakhir=$this->input->post('totakhir');
			}
			$cookiediskon='document.cookie = "diskon='.$diskon.'";';
		} 
		else $cookiediskon='document.cookie = "diskon=0";';

		$this->Frmmkwitansi->update_status_cetak_kwitansi($no_resep,$diskon,$no_register,$xuser);

		echo '<script type="text/javascript">'.$cookiediskon.'document.cookie= "xuser='.$xuser.'";window.open("'.site_url("farmasi/Frmckwitansi/cetak_kwitansi_kt/$no_resep").'", "_blank");window.focus()</script>';
		
		redirect('farmasi/Frmckwitansi/kwitansi','refresh');
		//print_r($no_resep);
		
	}

	public function st_cetak_faktur_kt()
	{
		$no_resep=$this->input->post('no_resep');
		$nmdokter=$this->input->post('nmdokter');
		
		$data_pasien=$this->Frmmkwitansi->get_data_pasien($no_resep)->row();
	  //$penyetor=$data_pasien->nama;
		
		
		$no_register=$this->input->post('no_register');

		$getvtotobat=$this->Frmmdaftar->get_vtot_obat($no_register)->row()->vtot_obat;
		$getrdrj=substr($no_register, 0,2);

		if($getrdrj=="PL"){
			$this->Frmmdaftar->selesai_daftar_pemeriksaan_PL($no_register,$getvtotobat);
			//print_r('PL Cetak');
		} else if($getrdrj=="RJ"){
			$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotobat);
		}
		else if ($getrdrj=="RD"){
			$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRD($no_register,$getvtotobat);
		}
		else if ($getrdrj=="RI"){
			$data_iri=$this->Frmmdaftar->getdata_iri($no_register)->result();
			foreach($data_iri as $row){
				$status_obat=$row->status_obat;
			}
			$status_obat = $status_obat + 1;
			$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRI($no_register,$status_obat,$getvtotobat);
		}
		
		

		$tot_tuslah= $this->Frmmkwitansi->get_total_tuslah($no_resep)->row()->vtot_tuslah;

		$this->Frmmdaftar->update_data_header($no_resep, $nmdokter, $tot_tuslah);

		if ($this->input->post('diskon_hide')!='') 
		{
			$diskon=$this->input->post('diskon_hide');
			if($this->input->post('totakhir')!=''){
				$totakhir=$this->input->post('totakhir');
			}
			$cookiediskon='document.cookie = "diskon='.$diskon.'";';
		} else $cookiediskon='document.cookie = "diskon=0";';

		echo '<script type="text/javascript">'.$cookiediskon.';window.open("'.site_url("farmasi/Frmckwitansi/cetak_faktur_kt/$no_resep").'", "_blank");window.focus()</script>';

		
		
		redirect('farmasi/Frmckwitansi/','refresh');
		//print_r($tot_tuslah);
		
	}

	public function st_selesai_bayar($no_register='')
	{
		
		$getrdrj=substr($no_register, 0,2);

		if($getrdrj=="PL"){
			$this->Frmmdaftar->selesai_bayar_PL($no_register);
			//print_r('PL Cetak');
		} else if ($getrdrj=="RJ") {
			$this->Frmmdaftar->selesai_bayar_IRJ($no_register);
		} else if ($getrdrj=="RD") {
			$this->Frmmdaftar->selesai_bayar_IRD($no_register);
		} else if ($getrdrj=="RI") {
			$data_iri=$this->Frmmdaftar->getdata_iri($no_register)->result();
			foreach($data_iri as $row){
				$status_obat=$row->status_obat;
			}
			$status_obat = $status_obat + 1;
			$this->Frmmdaftar->selesai_bayar_IRI($no_register,$status_obat);
		}
		

		//echo '<script type="text/javascript">window.open("'.site_url("farmasi/Frmckwitansi/cetak_faktur_kt/$no_resep").'", "_blank");window.focus()</script>';
		
		redirect('farmasi/Frmcdaftar/','refresh');
		//print_r($tot_tuslah);
		
	}

	public function cetak_faktur_resep_kt()
	{
		$no_resep=$this->input->post('no_resep');
		$data_pasien=$this->Frmmkwitansi->get_data_pasien($no_resep)->row();

		if($no_resep!=''){

			//$this->no_labmdaftar->update_status_cetak_hasil($no_no_lab);
			echo '<script type="text/javascript">window.open("'.site_url("farmasi/Frmckwitansi/cetak_faktur_kt/$no_resep").'", "_blank");window.history.back();</script>';
			
			//redirect('lab/labcpengisianhasil/','refresh');
		}else{
			//redirect('lab/labcpengisianhasil/','refresh');
		}

	}
	public function cetak_faktur_kt($no_resep='')
	{
		if($no_resep!=''){
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
			$diskon = 0;
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			
				$namars=$this->config->item('namars');
				$kota_kab=$this->config->item('kota');
				$alamatrs=$this->config->item('alamat');
				$nmsingkat=$this->config->item('namasingkat');
			//echo $namars;
			$data_pasien=$this->Frmmkwitansi->get_data_pasien($no_resep)->result();
				foreach($data_pasien as $row){
					$nama=$row->nama;
					$no_register=$row->no_register;
					$no_medrec=$row->no_medrec;
					$no_cm=$row->no_cm;
					$bed=$row->bed;
					$cara_bayar=$row->cara_bayar;
				}

			$data_header=$this->Frmmdaftar->getnama_dokter_poli($no_register)->result();
				foreach($data_header as $row){
					$nmdokter=$row->nmdokter;
					
				}


			if (substr($no_register,0,2)=="PL"){
				$data_ruang=$this->Frmmkwitansi->getdata_ruang($idrg)->result();

				foreach($data_ruang as $row){
					$nmruang='Pasien Luar';
				}

			} 
			$data_permintaan=$this->Frmmkwitansi->get_data_permintaan($no_resep)->result();

			/*$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			$vtot=0;
			foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_tindakan;
			}
			*/

			if($cara_bayar == 'BPJS'){
				$konten=
				"<style type=\"text/css\">
				.table-font-size{
					font-size:7px;
				    }
				.table-font-size1{
					font-size:7px;
				    }
				.table-font-size2{
					font-size:8px;
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
								<td  width=\"70%\" style=\" font-size:9px;\"><font style=\"font-size:10px\">$namars</font><br><br>$alamatrs $kota_kab $telp
							</td>
							<td width=\"14%\"><font size=\"8\" align=\"right\">$tgl_jam</font></td>						
						</tr>						
					</table>

				</br></br><br>
				<table class=\"table-font-size1\">
					<tr>
						<td width=\"20%\">No. Reg</td>
						<td width=\"4%\">:</td>
						<td width=\"20%\">$no_register</td>
						<td width=\"5%\"> </td>
						<td width=\"20%\">Cara Bayar</td>
						<td width=\"4%\">:</td>
						<td width=\"15%\">$cara_bayar</td>
						
					</tr>
					<tr>
						<td width=\"20%\">No. Medrec</td>
						<td width=\"4%\">:</td>
						<td width=\"20%\">$no_cm</td>
						<td width=\"5%\"> </td>
						<td width=\"20%\">No Resep</td>
						<td width=\"4%\">:</td>
						<td width=\"15%\">FRM_$no_resep</td>
					</tr>
					<tr>
						<td  width=\"20%\">Nama Pasien</td>
						<td  width=\"4%\">:</td>
						<td  width=\"20%\">$nama</td>
						<td width=\"5%\"> </td>
						<td  width=\"20%\">Resep Dokter</td>
						<td  width=\"4%\">:</td>
						<td  width=\"20%\">$nmdokter</td>
					</tr>
					<tr>
						<td  width=\"20%\">Unit Asal</td>
						<td  width=\"4%\">:</td>
						<td  width=\"20%\">$bed</td>
						<td width=\"5%\"> </td>
						<td  width=\"20%\"></td>
						<td  width=\"4%\"></td>
						<td  width=\"20%\"></td>						
					</tr>
					
				</table>
				<br/><br/><br/>
				<table class=\"table-font-size1\">
					<tr>
						<th  width=\"10%\"><p align=\"center\">No</p></th>
						<th  width=\"60%\"><p align=\"center\">Nama Item</p></th>
						<th  width=\"30%\"><p align=\"center\">Banyak</p></th>
					</tr>
					<hr>
				";

				
				$i=1;
				$jumlah_vtot=0;

				foreach($data_permintaan as $row){
					$jumlah_vtot += $row->vtot;
					$vtot = number_format( $row->vtot, 2 , ',' , '.' );

					$konten=$konten."<tr>
									  <td><p  align=\"center\">$i</p></td>
									  <td>$row->nama_obat</td>									 
									  <td><p align=\"right\">$row->qty</p></td>
									  <br>
									</tr>";
					$i++;

				}
				$total_akhir = (int) (1000 * ceil($jumlah_vtot / 1000));
				$vtot_terbilang=$cterbilang->terbilang($total_akhir);

				$konten=$konten."
						<hr><br>
						<tr><br>
							<th colspan=\"2\"><p class=\"table-font-size1\" align=\"right\">Jumlah   </p></th>
							<th><p class=\"table-font-size1\" align=\"right\">".number_format( $total_akhir, 2 , ',' , '.' )."</p></th>
						</tr>
						<br>
						<tr>
							<th colspan=\"4\"><p class=\"table-font-size1\" align=\"right\"><b>Terbilang:</b> ".$vtot_terbilang."</p></th>
						</tr>
					</table>						
					<p class=\"table-font-size\" align=\"right\">Biaya yang dibayar oleh pasien sebesar 0 rupiah<br>(Ditanggung BPJS)</p>
					<table class=\"table-font-size\">
						<tr>
							<td><p align=\"right\">Tanggal-Jam: $tgl_jam</p></td>
						</tr>
					</table>
					";
			}else{
				$konten=
				"<style type=\"text/css\">
				.table-font-size{
					font-size:7px;
				    }
				.table-font-size1{
					font-size:7px;
				    }
				.table-font-size2{
					font-size:8px;
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
								<td  width=\"70%\" style=\" font-size:9px;\"><font style=\"font-size:10px\">$namars</font><br><br>$alamatrs $kota_kab $telp
							</td>
							<td width=\"14%\"><font size=\"8\" align=\"right\">$tgl_jam</font></td>						
						</tr>						
					</table>
					<hr>

				</br></br><br>
				<table class=\"table-font-size1\">
					<tr>
						<td width=\"20%\">No. Reg</td>
						<td width=\"4%\">:</td>
						<td width=\"20%\">$no_register</td>
						<td width=\"5%\"> </td>
						<td width=\"20%\">Cara Bayar</td>
						<td width=\"4%\">:</td>
						<td width=\"15%\">$cara_bayar</td>
						
					</tr>
					<tr>
						<td width=\"20%\">No. Medrec</td>
						<td width=\"4%\">:</td>
						<td width=\"20%\">$no_cm</td>
						<td width=\"5%\"> </td>
						<td width=\"20%\">No Resep</td>
						<td width=\"4%\">:</td>
						<td width=\"15%\">FRM_$no_resep</td>
					</tr>
					<tr>
						<td  width=\"20%\">Nama Pasien</td>
						<td  width=\"4%\">:</td>
						<td  width=\"20%\">$nama</td>
						<td width=\"5%\"> </td>
						<td  width=\"20%\">Resep Dokter</td>
						<td  width=\"4%\">:</td>
						<td  width=\"20%\">$nmdokter</td>
					</tr>
					<tr>
						<td  width=\"20%\">Unit Asal</td>
						<td  width=\"4%\">:</td>
						<td  width=\"20%\">$bed</td>
						<td width=\"5%\"> </td>
						<td  width=\"20%\"></td>
						<td  width=\"4%\"></td>
						<td  width=\"20%\"></td>						
					</tr>
					
				</table>
				<br/><br/><br/>
				<table class=\"table-font-size1\">
					<tr>
						<th  width=\"10%\"><p align=\"center\">No</p></th>
						<th  width=\"50%\"><p align=\"center\">Nama Item</p></th>
						<th  width=\"12%\"><p align=\"center\">Banyak</p></th>
						<th  width=\"30%\"><p align=\"center\">Total</p></th>
					</tr>
					<hr>
				";

				
				$i=1;
				$jumlah_vtot=0;

				foreach($data_permintaan as $row){
					$bulat = (int) (100 * ceil($row->vtot / 100));
					$jumlah_vtot=$jumlah_vtot+$bulat;
					$vtot = number_format( $bulat, 2 , ',' , '.' );

					$konten=$konten."<tr>
									  <td><p  align=\"center\">$i</p></td>
									  <td>$row->nama_obat</td>
									 
									  <td><p align=\"center\">$row->qty</p></td>
									  <td><p align=\"right\">$vtot</P></td>
									  <br>
									</tr>";
					$i++;

				}

				$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);
					
				$konten=$konten."
						<tr><hr><br>
							<th colspan=\"3\"><p class=\"table-font-size1\" align=\"right\">Jumlah   </p></th>
							<th><p class=\"table-font-size1\" align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
						</tr>";
						//$totakhir=$jumlah_vtot-$diskon;
						$persen=$diskon/100;
						$diskon_persen=$jumlah_vtot*$persen;
						$totakhir=$jumlah_vtot-$diskon_persen;
				if($diskon!=0){
					$konten=$konten."
						<tr>
							<th colspan=\"3\"><p class=\"table-font-size1\" align=\"right\">Diskon   </p></th>
							<th bgcolor=\"yellow\"><p class=\"table-font-size1\" align=\"right\"> $diskon </p></th>
							<th> % </th>
						</tr>

						<tr><hr><br>
							<th colspan=\"3\"><p class=\"table-font-size1\" align=\"right\">Total Bayar   </p></th>
							<th><p class=\"table-font-size1\" align=\"right\">".number_format( $totakhir, 2 , ',' , '.' )."</p></th>
						</tr>";
					$jumlah_vtot=$jumlah_vtot-$diskon_persen;
				}
				$vtot_terbilang=$cterbilang->terbilang($totakhir);

				$konten = $konten."
				<br>
				<tr>
					<th colspan=\"4\"><p class=\"table-font-size1\" align=\"left\"><b>Terbilang:</b> ".$vtot_terbilang."</p></th>
				</tr>";
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
							<th colspan=\"2\"><p align=\"right\">Total   </p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $vtot, 2 , ',' , '.' )."</p></th>
						</tr>
				*/
			$file_name="SKT_$no_resep.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetPrintHeader(false);
				$obj_pdf->SetPrintFooter(false);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins('10', '3', '10');
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				
				$obj_pdf->Output(FCPATH.'download/farmasi/frmkwitansi/'.$file_name, 'FI');
		}else{
			redirect('farmasi/Frmckwitansi/','refresh');
		}
	}
	


public function cetak_kwitansi_kt($no_resep='')
	{
		if($no_resep!=''){
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
		
			
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			
			$data_pasien=$this->Frmmkwitansi->get_data_pasien($no_resep)->result();
				foreach($data_pasien as $row){
					$nama=$row->nama;
					$sex=$row->sex;
					$goldarah=$row->goldarah;
					$no_register=$row->no_register;
					$no_medrec=$row->no_medrec;
					$no_cm=$row->no_cm;
					$idrg=$row->idrg;
					$bed=$row->bed;
					$cara_bayar=$row->cara_bayar;
				}

			$data_header=$this->Frmmdaftar->getnama_dokter_poli($no_register)->result();
				foreach($data_header as $row){
					$nmdokter=$row->nmdokter;
					
				}

			if (substr($no_register,0,2)=="PL"){
					$nmruang='Pasien Luar';
			} 
			$data_permintaan=$this->Frmmkwitansi->get_data_permintaan($no_resep)->result();
			
			$diskon =  $_COOKIE['diskon'];
			$xuser = strtoupper($_COOKIE['xuser']);
			
			/*$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			$vtot=0;
			foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_tindakan;
			}
			*/
			
			$konten=
					"
					<style type=\"text/css\">
					.table-font-size{
						font-size:6px;
					    }
					.table-font-size1{
						font-size:10px;
					    }
					.table-font-size2{
						font-size:8px;
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
								<td  width=\"70%\" style=\" font-size:9px;\"><font style=\"font-size:10px\">$namars</font><br><br>$alamatrs $kota_kab $telp
							</td>
							<td width=\"14%\"><font size=\"8\" align=\"right\">$tgl_jam</font></td>						
						</tr>						
					</table>
					<hr>
					<br>
					<table class=\"table-font-size1\">
						<tr>
							<td width=\"20%\"></td>
							<td width=\"2%\"></td>
							<td width=\"20%\"></td>
							<td width=\"5%\"></td>
							<td width=\"24%\"></td>
							<td width=\"2%\"></td>
							<td width=\"15%\"></td>							
						</tr>
						<tr>
							<td width=\"20%\">No. Registrasi</td>
							<td width=\"2%\">:</td>
							<td width=\"20%\">$no_register</td>
							<td width=\"5%\"> </td>
							<td width=\"24%\">Cara Bayar</td>
							<td width=\"2%\">:</td>
							<td width=\"15%\">$cara_bayar</td>
							
						</tr>
						<tr>
							<td width=\"20%\">No. Medrec</td>
							<td width=\"2%\">:</td>
							<td width=\"20%\">$no_cm</td>
							<td width=\"5%\"> </td>
							<td width=\"24%\">No Resep</td>
							<td width=\"2%\">:</td>
							<td width=\"15%\">FRM_$no_resep</td>
						</tr>
						<tr>
							<td  width=\"20%\">Nama Pasien</td>
							<td  width=\"2%\">:</td>
							<td  width=\"20%\">$nama</td>
							<td width=\"5%\"> </td>
							<td  width=\"24%\">Resep Dokter</td>
							<td  width=\"2%\">:</td>
							<td  width=\"20%\">$nmdokter</td>
						</tr>
						<tr>
							<td  width=\"20%\">Unit Asal</td>
							<td  width=\"2%\">:</td>
							<td  width=\"20%\">$bed</td>
							<td width=\"5%\"> </td>
							<td  width=\"24%\"></td>
							<td  width=\"2%\"></td>
							<td  width=\"20%\"></td>
						</tr>
						
					</table>
					<br/>
					<br/><br/>
					<table class=\"table-font-size1\">
						<tr>
							<th  width=\"10%\"><p align=\"center\">No</p></th>
							<th  width=\"50%\"><p align=\"center\">Nama Item</p></th>
							<th  width=\"12%\"><p align=\"center\">Banyak</p></th>
							<th  width=\"30%\"><p align=\"center\">Total</p></th>
						</tr>
						<hr> ";
					$i=1;
					$jumlah_vtot=0;

					foreach($data_permintaan as $row){
						$jumlah_vtot=$jumlah_vtot+$row->vtot;
						$vtot = number_format( $row->vtot, 2 , ',' , '.' );
						$konten=$konten."<tr>
										  <td><p  align=\"center\">$i</p></td>
										  <td>$row->nama_obat</td>
										 
										  <td><p align=\"center\">$row->qty</p></td>
										  <td><p align=\"right\">$vtot</P></td>
										  <br>
										</tr>";
						$i++;

					} 

							if($cara_bayar=='BPJS'){
						$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);

				$konten=$konten."
					</table>
						<tr><br>
							<th colspan=\"3\"><p class=\"table-font-size1\" align=\"right\">Jumlah   </p></th>
							<th bgcolor=\"yellow\"><p class=\"table-font-size1\" align=\"right\">".number_format( '0', 2 , ',' , '.' )."</p></th>
						</tr>
						
					
					<p class=\"table-font-size1\" align=\"right\">Biaya yang dibayar oleh pasien sebesar 0 rupiah (Ditanggung BPJS)</p>
					<table class=\"table-font-size1\">
						<tr>
							<td><p align=\"right\">Tanggal-Jam: $tgl_jam</p></td>
						</tr>
					</table>
					";
					}else{
						$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);
					

				$konten=$konten."
						<tr><hr><br>
							<th colspan=\"3\"><p class=\"table-font-size1\" align=\"right\">Jumlah   </p></th>
							<th bgcolor=\"yellow\"><p class=\"table-font-size1\" align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
						</tr>";
						//$totakhir=$jumlah_vtot-$diskon;
						$persen=$diskon/100;
						$diskon_persen=$jumlah_vtot*$persen;
						$totakhir=$jumlah_vtot-$diskon_persen;
				if($diskon!=0){
					$konten=$konten."
						<tr>
							<th colspan=\"3\"><p class=\"table-font-size1\" align=\"right\">Diskon   </p></th>
							<th bgcolor=\"yellow\"><p class=\"table-font-size1\" align=\"right\"> $diskon </p></th>
							<th> % </th>
						</tr>

						<tr><hr><br>
							<th colspan=\"3\"><p class=\"table-font-size1\" align=\"right\">Total Bayar   </p></th>
							<th><p class=\"table-font-size1\" align=\"right\">".number_format( $totakhir, 2 , ',' , '.' )."</p></th>
						</tr>
						<table>";
					$jumlah_vtot=$jumlah_vtot-$diskon_persen;
				}
				$vtot_terbilang=$cterbilang->terbilang($totakhir);
					
				}
						
					$jumlah_vtot=0;
					foreach($data_permintaan as $row){
						$jumlah_vtot=$jumlah_vtot+$row->vtot;
						$vtot = number_format( $row->vtot, 2 , ',' , '.' );
						

					}

					//if ($cara_bayar=='BPJS' or $cara_bayar=='PERUSAHAAN'){
					//	$jumlah_vtot=$jumlah_vtot;
					//}else{
						//$tot1 = $jumlah_vtot;
						//$tot2 = substr($tot1, - 3);
						//if ($tot2 % 500 != 0){
						//	$mod = $tot2 % 500;
						//	$tot1 = $tot1 - $mod;
						//	$tot1 = $tot1 + 500; 
						//}
						//$jumlah_vtot=$tot1;
					//}
					
				$konten=$konten."
						<tr><br>
							<th class=\"table-font-size1\" colspan=\"3\"><p align=\"left\"><u>Total  Rp.".number_format( $jumlah_vtot, 2 , ',' , '.' )."  </u></p></th>
							
						</tr>";
						//$totakhir=$jumlah_vtot-$diskon;
						$persen=$diskon/100;
						$diskon_persen=$jumlah_vtot*$persen;
						$totakhir=$jumlah_vtot-$diskon_persen;

				if($diskon!=0){
					$konten=$konten."
						<tr>
							<th class=\"table-font-size1\" colspan=\"3\"><p align=\"left\"><u>Diskon".$diskon." % </u></p></th>
						</tr>

						<tr><hr>
							<th class=\"table-font-size1\" colspan=\"3\"><p align=\"left\"><u>Total Bayar  Rp.".number_format( $totakhir, 2 , ',' , '.' )."  </u></p></th>
						</tr>";
					$jumlah_vtot=$jumlah_vtot-$diskon_persen;
				}
				$vtot_terbilang=$cterbilang->terbilang($totakhir);

				$konten=$konten."
						
					</table>
					<font size=\"10\">
					Terbilang : " .$vtot_terbilang."
					</font>
					<p class=\"table-font-size1\" align=\"right\"><i>Untuk Pembayaran Obat yang diminta, sesuai nota terlampir</i></p>
					<br><br>
					<table class=\"table-font-size1\">
						<tr>
							<td></td>
							<td></td>
							<td>$kota_kab, $tgl</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>an.Kepala Rumah Sakit</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>K a s i r</td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>----------------------------------------</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>$xuser</td>
						</tr>
					</table>
					";

			
			
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
							<th colspan=\"2\"><p align=\"right\">Total   </p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $vtot, 2 , ',' , '.' )."</p></th>
						</tr>
				*/
			$file_name="KWI_$no_resep.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetPrintHeader(false);
				$obj_pdf->SetPrintFooter(false);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins('10', '3', '10');
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/farmasi/frmkwitansi/'.$file_name, 'FI');
		}else{
			redirect('farmasi/Frmckwitansi/','refresh');
			
		}
	}
	
}
?>
