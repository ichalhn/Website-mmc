<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
include('Rjcterbilang.php');
class rjctni extends Secure_area {
//class rjcregistrasi extends CI_Controller {
	public function __construct() {
			parent::__construct();
			$this->load->model('irj/rjmpencarian','',TRUE);
			$this->load->model('irj/rjmregistrasi','',TRUE);
			$this->load->model('irj/rjmpelayanan','',TRUE);
			$this->load->model('irj/rjmkwitansi','',TRUE);
			$this->load->model('ird/ModelRegistrasi','',TRUE);
			$this->load->model('admin/M_user','',TRUE);
			
			$this->load->helper('pdf_helper');
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////registrasi biodata pasien
	public function index()
	{
		$data['title'] = 'Registrasi Pasien';
		$data['data_pasien']="";
		
		$this->load->view('irj/rjvformcaripasien',$data);
	}
	
	public function regpasien()
	{
		$data['title'] = 'Registrasi Anggota TNI';
		//$data['data_pasien']="";
		$data['kontraktor']=$this->rjmpencarian->get_kontraktor()->result();
		$data['prop']=$this->rjmpencarian->get_prop()->result();
		$data['cm_last']=$this->ModelRegistrasi->get_last_cmpatria()->row()->no_cm;
		$data['hubungan']=$this->rjmpencarian->get_hubungan()->result();
		$data['angkatan']=$this->rjmpencarian->get_angkatan()->result();
		$data['kesatuan']=$this->rjmpencarian->get_kesatuan()->result();
		$data['pangkat']=$this->rjmpencarian->get_pangkat()->result();
			
		$this->load->view('irj/rjvformdaftartni',$data);
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////alamat
	public function data_kotakab($id_prop='',$sid='')
	{
		$data=$this->rjmpencarian->get_kotakab($id_prop)->result();
			echo "<option selected value=''>Pilih Kota/Kabupaten</option>";
			foreach($data as $row){
				echo "<option value='$row->id-$row->nama'>$row->nama</option>";
			}
	}
	public function data_kecamatan($id_kabupaten='',$sid='')
	{
		$data=$this->rjmpencarian->get_kecamatan($id_kabupaten)->result();
			echo "<option selected value=''>Pilih Kecamatan</option>";
			foreach($data as $row){
				echo "<option value='$row->id-$row->nama'>$row->nama</option>";
			}
	}
	public function data_kelurahan($id_kecamatan='',$sid='')
	{
		$data=$this->rjmpencarian->get_kelurahan($id_kecamatan)->result();
			echo "<option selected value=''>Pilih Kelurahan</option>";
			foreach($data as $row){
				echo "<option value='$row->id-$row->nama'>$row->nama</option>";
			}
	}
	public function data_dokter_poli($id_poli='')
	{
		$data=$this->rjmpelayanan->get_dokter_poli($id_poli)->result();
			echo "<option selected value=''>-Pilih Dokter-</option>";
			foreach($data as $row){
				echo "<option value='$row->id_dokter'>$row->nm_dokter</option>";
			}
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function pasien($cm='')
	{
		$data['title'] = 'Registrasi Pasien';
		
			
		if($this->input->post('cari_no_cm')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_cm($this->input->post('cari_no_cm'))->result();
		}		
		else if($this->input->post('cari_no_kartu')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_kartu($this->input->post('cari_no_kartu'))->result();
		}
		else if($this->input->post('cari_no_identitas')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_identitas($this->input->post('cari_no_identitas'))->result();
		}
		else if($this->input->post('cari_nama')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_nama($this->input->post('cari_nama'))->result();
		}
		else if($this->input->post('cari_alamat')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_alamat($this->input->post('cari_alamat'))->result();
		}
		else if($this->input->post('cari_tgl')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_tgl($this->input->post('cari_tgl'))->result();
		}
		
		if (empty($data['data_pasien'])==1) 
		{
			$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-danger alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Data pasien tidak ditemukan !
							</h4>
						</div>
					</div>
				</div>';
			$this->session->set_flashdata('success_msg', $success);
			redirect('irj/rjcregistrasi');
		
		} else {
		
			$this->load->view('irj/rjvformcaripasien',$data);
		}
		
	}
	
	public function cek_available_nokartu($nokartu, $nokartuold='')
	{
		$result=$this->rjmregistrasi->cek_no_kartu($nokartu,$nokartuold);
		echo $result->num_rows();
	}

	public function cek_available_nonrp($nonrp, $nonrpold='')
	{
		$result=$this->rjmregistrasi->cek_no_nrp($nonrp,$nonrpold);
		echo $result->num_rows();
	}
	
	public function cek_available_noidentitas($noidentitas, $noidentitasold='')
	{
		$result=$this->rjmregistrasi->cek_no_identitas($noidentitas, $noidentitasold);
		echo $result->num_rows();
	}
	

	//automatic add action
	public function insert_tindakan($data1)
	{
		date_default_timezone_set("Asia/Jakarta");
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xuser']=$user;
		$data['xupdate']=date("Y-m-d H:i:s");
		// baru BA0102 , lama BA0103 //
		$data['no_register']=$data1['no_register'];
		$no_register=$data1['no_register'];		
		$data['id_poli']=$data1['id_poli'];

		//default BA0102
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
			$data['idtindakan']='BA0102';
			$data['tgl_kunjungan']=date("Y-m-d H:i:s");

		/*if($data1['jenis_pasien']=='BARU'){
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
			$data['idtindakan']='BA0102';					
		}else{
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0103')->row();
			$data['idtindakan']='BA0103';
		}		*/

			$data['nmtindakan']=$detailtind->nmtindakan;		

		$data['biaya_tindakan']=$detailtind->total_tarif;
		$data['biaya_alkes']=$detailtind->tarif_alkes;
		$data['qtyind']='1';
		//$data['dijamin']=$this->input->post('dijamin');
		$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
		
		$id=$this->rjmpelayanan->insert_tindakan($data);
		
		//penambahan vtot di daftar_ulang_irj
		$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
		$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$data['vtot'];
		$this->rjmpelayanan->update_vtot($data_vtot,$data1['no_register']);


		if($data['id_poli']=='HA00'){ //lab
			$data4['lab']=1;
			$data4['status_lab']=0;
			
			$id=$this->rjmpelayanan->update_rujukan_penunjang($data4,$no_register);
		}else if($data['id_poli']=='LA00'){ //rad
			$data4['rad']=1;
			$data4['status_rad']=0;

			$id=$this->rjmpelayanan->update_rujukan_penunjang($data4,$no_register);
		}else if($data['id_poli']=='PA00'){ //pa
			$data4['pa']=1;
			$data4['status_pa']=0;

			$id=$this->rjmpelayanan->update_rujukan_penunjang($data4,$no_register);
		}else{
			//add periksa
			$detailperiksa=$this->rjmregistrasi->get_tarif_periksa_dokter($data1['id_dokter'])->row();

			$data3['id_dokter']=$data1['id_dokter'];
			$data3['nmtindakan']=$detailperiksa->nmtindakan;
			$data3['nm_dokter']=$detailperiksa->nm_dokter;
			$data3['idtindakan']=$detailperiksa->id_biaya_periksa;
			$data3['qtyind']='1';
			$data3['biaya_tindakan']=$detailperiksa->total_tarif;
			$data3['biaya_alkes']=$detailperiksa->tarif_alkes;
			$data3['vtot']=(int)$data3['biaya_tindakan']+(int)$data3['biaya_alkes'];
			$data3['no_register']=$data1['no_register'];
			$data3['xuser']=$user;
			$id=$this->rjmpelayanan->insert_tindakan($data3);
			
			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$data3['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot,$data1['no_register']);
		}
		$no_register=$data1['no_register'];
		echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_faktur_kt/$no_register").'", "_blank");window.focus()</script>';
		if($data1['cara_bayar']!='UMUM'){
		echo '<script type="text/javascript">window.open("'.site_url("irj/rjcsjp/cetak_sjp/$no_register").'", "_blank");window.focus()</script>';
		}
		
		
	}

	public function irj_pulang()
	{			
		$data['daftar_pasien']=$this->rjmregistrasi->get_daftar_pasien_belum_pulang()->result();

		$data['title'] = 'Daftar Pasien Rawat Jalan yang Belum Pulang';
		$data['message'] = '';
		$data['search_per']='cm';
		$this->load->view('irj/rjvformdaftarpulang',$data);
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////registrasi pasien ke irj
	public function daftarulang($no_cm)
	{
		$data['title'] = 'Daftar Ulang Pasien';
		$data['biayakarcis']=$this->rjmregistrasi->get_biayakarcis()->row();
			
		if($no_cm!=''){//update
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_cm_baru($no_cm)->row();
			$data['prop']=$this->rjmpencarian->get_prop()->result();
			$data['cara_berkunjung']=$this->rjmpencarian->get_cara_berkunjung()->result();
			$data['ppk']=$this->rjmpencarian->get_ppk()->result();			
			$data['kelas']=$this->rjmpencarian->get_kelas()->result();
			$data['poli']=$this->rjmpencarian->get_poliklinik()->result();
			$data['cara_bayar']=$this->rjmpencarian->get_cara_bayar()->result();
			$data['dokter']=$this->rjmpencarian->get_dokter()->result();
			$data['kontraktor']=$this->rjmpencarian->get_kontraktor()->result();
			$data['diagnosa']=$this->rjmpencarian->get_diagnosa()->result();
			$data['mrnrp']=$this->rjmpencarian->get_nrp()->result();
			$this->load->view('irj/rjvformdaftar2',$data);
			
			
		}else if($_SERVER['REQUEST_METHOD']!='POST'){
			redirect('irj/rjcregistrasi');
		}else{
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_cm($no_cm)->row();
			
			$data['prop']=$this->rjmpencarian->get_prop()->result();
			$data['cara_berkunjung']=$this->rjmpencarian->get_cara_berkunjung()->result();
			$data['ppk']=$this->rjmpencarian->get_ppk()->result();
			$data['kelas']=$this->rjmpencarian->get_kelas()->result();
			$data['poli']=$this->rjmpencarian->get_poliklinik()->result();
			$data['cara_bayar']=$this->rjmpencarian->get_cara_bayar()->result();
			$data['dokter']=$this->rjmpencarian->get_dokter()->result();
			$data['kontraktor']=$this->rjmpencarian->get_kontraktor()->result();
			$data['diagnosa']=$this->rjmpencarian->get_diagnosa()->result();
			$data['mrnrp']=$this->rjmpencarian->get_nrp()->result();
			$this->load->view('irj/rjvformdaftar2',$data);		
		}
	}
	
	function cetak_faktur_kt($no_register='')
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

			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');

			$data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();
			
			$detail_daful=$this->rjmkwitansi->get_detail_daful($no_register)->row();
			//print_r($detail_daful);
			if($detail_daful->cara_bayar=='UMUM'){
				$pasien_bayar='TUNAI';
			}else $pasien_bayar='KREDIT';
			$txtkk='';
			$txtdiskon='';
			$txttunai="";
			$txtperusahaan='';
			$totalbayar='';$totalbayar1='';$totalbayar2='';
			$detail_bayar=$detail_daful->cara_bayar;


			//print_r($detail_bayar);
			if($detail_bayar=='DIJAMIN / JAMSOSKES')
			{
				$kontraktor=$this->rjmkwitansi->getdata_perusahaan($no_register)->row();
				$txtperusahaan="<td><b>Dijamin oleh</b></td>
						<td> : </td>
						<td>$detail_daful->id_kontraktor - ".strtoupper($kontraktor->nmkontraktor)."</td>";
			}
			
			
			
			/*$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			$vtot=0;
			foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_tindakan;
			}
			*/
			$vtot=$this->rjmkwitansi->get_vtot($no_register)->row();
			$vtot=0;
			$data_tindakan=$this->rjmkwitansi->getdata_unpaid_tindakan_pasien($no_register)->result();
			foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_tindakan;
			}
			$jumlah_vtot =  $vtot;
						
			$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);
			//echo $jumlah_vtot;
			//echo $vtot_terbilang;			

			$txtjudul="<tr>
					<td colspan=\"3\" ><font size=\"12\" align=\"center\"><u><b>REGISTRASI RAWAT JALAN 
					No. $no_register</b></u></font></td>
				</tr>";			
			
			$style='';			

			$konten="<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					.table-font-size1{
						font-size:12px;
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
					
					<table>		
						$txtjudul	<br>		
							<tr>
								<td width=\"17%\"><b>Terbilang</b></td>
								<td width=\"2%\"> : </td>
								<td  width=\"78%\"><i>".strtoupper($vtot_terbilang)."</i></td>
							</tr>			
							<tr>
								<td><b>Untuk Pemeriksaan</b></td>
								<td> : </td>
								<td><i>Untuk Pembayaran Pemeriksaan, Tindakan Rawat Jalan sesuai nota terlampir</i></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td width=\"17%\"><b>Nama Pasien</b></td>
								<td width=\"2%\">:</td>
								<td width=\"37%\">".strtoupper($data_pasien->nama)." (".$data_pasien->sex.")</td>
								<td width=\"19%\"><b>Tanggal Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td>".date("d-m-Y",strtotime($data_pasien->tgl_kunjungan))."</td>
							</tr>
							<tr>
								<td><b>Umur</b></td>
								<td> : </td>
								<td>".$detail_daful->umurrj." TAHUN ".$detail_daful->ublnrj." BULAN ".$detail_daful->uharirj." HARI</td>
								<td ><b>No Medrec</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->no_cm)."</td>
							</tr>
							<tr>
								<td><b>Alamat</b></td>
								<td> : </td>
								<td>".strtoupper($data_pasien->alamat)."</td>
								<td><b>Poli Tujuan</b></td>
								<td> : </td>
								<td>".strtoupper($data_pasien->nm_poli)."</td>
							</tr>
							
							<tr>
								<td><b>Dokter</b></td>
								<td> : </td>
								<td>".strtoupper($data_pasien->nm_dokter)."</td>
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->cara_bayar)."</td>
							</tr>
							
							<tr>
								<td></td>
								<td></td>
								<td></td>
								$txtperusahaan
							</tr>
																											
					</table><br/><br/>";
															
			
				
			//$data_tindakan=$this->rjmkwitansi->getdata_unpaid_tindakan_pasien($no_register)->result();

			
			//print_r($data_tindakan);
			$no=1;
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
						// 	<td><p align=\"right\">".number_format( $vtot, 2 , ',' , '.' )."</p></td>
						// </tr>";

			
				foreach($data_tindakan as $row1){
					
					$konten=$konten."
					<tr>
						<td><p align=\"center\">".$no++."</p></td>
						<td>".ucwords(strtolower($row1->nmtindakan))."</td>
						<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>
						</tr>";
					}

						
			
			$konten1=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"right\"><b>Total   </b></p></th>
							<th ><p align=\"right\">".number_format( $vtot, 2 , ',' , '.' )."</p></th>
						</tr>
					</table>
					<br/><br/>
					<table style=\"border:1px solid black; \" >										
					<tr>
						<td width=\"50%\" ><p>Jumlah </p></td>
						<td width=\"10%\">:</td>
						<td width=\"40%\"><p align=\"right\"> Rp ".number_format( $vtot, 2 , ',' , '.' )."</p></td>
					</tr>
					</table>";
			
			$konten1=$konten1."
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
					</table>";
			//echo $konten;			
				$file_name="Daftar_$no_register.pdf";			
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
					$content = $konten1;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');				
				$obj_pdf->Output(FCPATH.'download/irj/rjkwitansi/'.$file_name, 'FI');
		}else{
			redirect('irj/rjcregistrasi/kwitansi/','refresh');
		}
	}

	public function insert_data_tni()
	{				

		$data['nama_anggota']=$this->input->post('nama');		

		$data['nrp']=$this->input->post('no_nrp');

		$data['kst_id']=$this->input->post('kesatuan');
		$data['pkt_id']=$this->input->post('pangkat');
		$data['angkatan']=$this->input->post('angkatan');	
		if($this->input->post('tgl_nonaktif')!=''){
			$data['tgl_nonaktif']=$this->input->post('tgl_nonaktif');
		}	
		
		date_default_timezone_set("Asia/Jakarta");		
		$data['xupdate']=date("Y-m-d H:i:s");
		$data['xuser']=$this->input->post('user_name');		
		
		$success = 	'<div class="content-header">
						<div class="box box-default">
							<div class="alert alert-success alert-dismissable">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
								<h4>
								<i class="icon fa fa-check"></i>
								Input biodata berhasil
								</h4>
							</div>
						</div>
					</div>';
		$this->session->set_flashdata('success_msg', $success);
		//redirect('irj/rjcregistrasi/daftarulang/'.$data['no_medrec']);		

		$data['hub_id']=$this->input->post('hub_id');
		$data['hub_name']=$this->input->post('hub_name');

		$data['sex']=$this->input->post('sex');
		$data['tmpt_lahir']=$this->input->post('tmpt_lahir');
		$data['tgl_lahir']=$this->input->post('tgl_lahir');
		$data['agama']=$this->input->post('agama');		
		$data['status']=$this->input->post('status');
		$data['alamat']=$this->input->post('alamat');
		$data['rt']=$this->input->post('rt');
		$data['rw']=$this->input->post('rw');
		$data['id_kelurahandesa']=$this->input->post('id_kelurahandesa');
		$data['kelurahandesa']=$this->input->post('kelurahandesa');
		$data['id_kecamatan']=$this->input->post('id_kecamatan');
		$data['kecamatan']=$this->input->post('kecamatan');
		$data['id_kotakabupaten']=$this->input->post('id_kotakabupaten');
		$data['kotakabupaten']=$this->input->post('kotakabupaten');
		//$data['id_provinsi']=$this->input->post('id_provinsi');
		//$data['provinsi']=$this->input->post('provinsi');
		$data['kodepos']=$this->input->post('kodepos');
		$data['pendidikan']=$this->input->post('pendidikan');
		//$data['pekerjaan']=$this->input->post('pekerjaan');
		$data['no_telp']=$this->input->post('no_telp');
		$data['no_hp']=$this->input->post('no_hp');
		$data['no_telp_kantor']=$this->input->post('no_telp_kantor');

		$id=$this->rjmregistrasi->insert_tnipns($data);

		//redirect('irj/rjctni/bio/'.$data['no_nrp']);
	}

	public function bio($nrp=''){
		if($nrp!=''){
			$data['hubungantni']=$this->rjmpencarian->get_hubungan()->result();
			$data['angkatan']=$this->rjmpencarian->get_angkatan()->result();
			$data['kesatuan']=$this->rjmpencarian->get_kesatuan()->result();
			$data['pangkat']=$this->rjmpencarian->get_pangkat()->result();

			$this->load->view('irj/rjvformdaftartni2',$data);

		}else{
			redirect('irj/rjctni/regpasien/');
		}

	}

	public function update_data_pasien()
	{	
			
			$config['upload_path'] = './upload/photo';
			$config['allowed_types'] = 'gif|png|jpg';
			$config['max_size'] = '2000000';
			$config['max_width'] = '2000';
			$config['max_height'] = '2000';
			$this->upload->initialize($config);
					
			if(!$this->upload->do_upload()){
				// $data['foto']='unknown.png';
				// $error = $this->upload->display_errors();
				// echo $error;
			}else{
				$upload = $this->upload->data();
				$data['foto']=$upload['file_name'];
			}
			
		$no_medrec=$this->input->post('no_cm');
		$data['no_cm']=$this->input->post('cm_baru');
		if($this->input->post('jenis_identitas')!=''){
			$data['jenis_identitas']=$this->input->post('jenis_identitas');
			$data['no_identitas']=$this->input->post('no_identitas');
		}
		//$data['jenis_kartu']=$this->input->post('jenis_kartu');
		if ($this->input->post('no_kk')!='') {
			$data['no_kk']=$this->input->post('no_kk');
		}
		if($this->input->post('no_kartu')!=''){
			$data['no_kartu']=$this->input->post('no_kartu');
		}
		if($this->input->post('no_nrp')!=''){
			$data['no_nrp']=$this->input->post('no_nrp');
		}

		if($this->input->post('nrp_sbg')!=''){
			$data['nrp_sbg']=$this->input->post('nrp_sbg');
		}
		$data['id_kontraktor1']=$this->input->post('id_kontraktor1');
		$data['no_asuransi1']=$this->input->post('no_asuransi1');
		$data['id_kontraktor2']=$this->input->post('id_kontraktor2');
		$data['no_asuransi2']=$this->input->post('no_asuransi2');
		$data['nama']=$this->input->post('nama');
		$data['sex']=$this->input->post('sex');
		$data['tmpt_lahir']=$this->input->post('tmpt_lahir');
		$data['tgl_lahir']=$this->input->post('tgl_lahir');
		$data['agama']=$this->input->post('agama');
		$data['wnegara']=$this->input->post('wnegara');
		$data['status']=$this->input->post('status');
		$data['alamat']=$this->input->post('alamat');
		$data['rt']=$this->input->post('rt');
		$data['rw']=$this->input->post('rw');
		$data['id_kelurahandesa']=$this->input->post('id_kelurahandesa');
		$data['kelurahandesa']=$this->input->post('kelurahandesa');
		$data['id_kecamatan']=$this->input->post('id_kecamatan');
		$data['kecamatan']=$this->input->post('kecamatan');
		$data['id_kotakabupaten']=$this->input->post('id_kotakabupaten');
		$data['kotakabupaten']=$this->input->post('kotakabupaten');
		$data['id_provinsi']=$this->input->post('id_provinsi');
		$data['provinsi']=$this->input->post('provinsi');
		$data['kodepos']=$this->input->post('kodepos');
		$data['pendidikan']=$this->input->post('pendidikan');
		$data['pekerjaan']=$this->input->post('pekerjaan');
		$data['no_telp']=$this->input->post('no_telp');
		$data['no_hp']=$this->input->post('no_hp');
		$data['no_telp_kantor']=$this->input->post('no_telp_kantor');
		$data['email']=$this->input->post('email');
		$data['goldarah']=$this->input->post('goldarah');
		$data['nm_ibu_istri']=$this->input->post('nm_ibu_istri');
		$id=$this->rjmregistrasi->update_pasien_irj($data,$no_medrec);
		//print_r($data);
		redirect('irj/rjcregistrasi/daftarulang/'.$no_medrec);
	}
	public function insert_daftar_ulang()
	{
		$no_medrec=$this->input->post('no_medrec');
		
		//cek data poli hari ini
		/*$cek_data_poli=$this->rjmregistrasi->cek_data_poli($no_medrec)->row();
		
		if (isset($cek_data_poli)) 
		{
			$data_poli = $cek_data_poli->nm_poli;
			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>
									Maaf, Pasien sudah terdaftar pada poli "'.$cek_data_poli->nm_poli.'" pada tanggal "'.$cek_data_poli->tgl_kunjungan.'".<br>
									<i class="icon fa fa-uncheck"></i>
									Silahkan Pulangkan Kunjungan Sebelumnya.
									</h4>
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('success_msg', $success);
			
			redirect('irj/rjcregistrasi');
					
		} else {
			*/
			//get umur
			$get_umur=$this->rjmregistrasi->get_umur($no_medrec)->result();
			$tahun=0;
			$bulan=0;
			$hari=0;
			foreach($get_umur as $row)
			{
				// echo $row->umurday;
				$tahun=floor($row->umurday/365);
				$bulan=floor(($row->umurday - ($tahun*365))/30);
				$hari=$row->umurday - ($bulan * 30) - ($tahun * 365);
			}
			
			//$no_register=$this->rjmregistrasi->get_new_register()->result();
			/*foreach($no_register as $val){
				$data['no_register']=sprintf("RJ%s%06s",$val->year,$val->counter+1);
			}
			*/
			$datenow=date('Y-m-d');
			$noreservasi=($this->rjmregistrasi->select_antrian_bynoreg($datenow,$this->input->post('id_poli'))->row()->no)+1;
			//echo $noreservasi;
			$data['no_antrian']=$noreservasi; 

			$data['umurrj']=$tahun;
			$data['uharirj']=$hari;
			$data['ublnrj']=$bulan;

			$data['no_medrec']=$no_medrec;
			$data['jns_kunj']=$this->input->post('jns_kunj');
			$data['cara_kunj']=$this->input->post('cara_kunj');
			if($this->input->post('asal_rujukan')!=''){
				$data['asal_rujukan']=$this->input->post('asal_rujukan');
			}

			if($this->input->post('dll_rujukan')!=''){
				$data['asal_rujukan']=$this->input->post('dll_rujukan');
			}

			if($this->input->post('no_rujukan')!=''){
				$data['no_rujukan']=$this->input->post('no_rujukan');
			}
			if($this->input->post('tgl_rujukan')!=''){
				$data['tgl_rujukan']=$this->input->post('tgl_rujukan');
			}
			$data['kelas_pasien']=$this->input->post('kelas_pasien');
			$data['cara_bayar']=$this->input->post('cara_bayar');
			if($this->input->post('id_kontraktor')!=''){
				$data['id_kontraktor']=$this->input->post('id_kontraktor');
			}
			if($this->input->post('id_diagnosa')!=''){
				$data['diagnosa']=$this->input->post('id_diagnosa');
			}
			$data['id_poli']=$this->input->post('id_poli');
			$data['id_dokter']=$this->input->post('id_dokter');

			if($this->input->post('id_poli')=='BA00'){
				$data['alasan_berobat']=$this->input->post('alber');
		
				if($this->input->post('pasdatDg')!=''){
					$data['datang_dengan']=$this->input->post('pasdatDg');}

				if($this->input->post('jenis_kecelakaan')!=''){
					$data['kecelakaan']=$this->input->post('jenis_kecelakaan');
					if($this->input->post('lokasi_kecelakaan')!=''){
						$data['lokasi_kecelakaan']=$this->input->post('lokasi_kecelakaan');
					}
				}
			}
			//$data['kd_ruang']=$this->input->post('kd_ruang');
			//$data['biayadaftar']=$this->input->post('biayadaftar');
			$data['biayadaftar']=0;
			$data['nama_penjamin']=$this->input->post('nama_penjamin');
			$data['hubungan']=$this->input->post('hubungan');
			$data['vtot']=0;
			//$data['no_sep']=$this->input->post('no_sep');
			$data['xuser']=$this->input->post('user_name');
			$data['xupdate']=date('Y-m-d H:i:s');
			
				$id=$this->rjmregistrasi->insert_daftar_ulang($data);
			
				$data['no_register']=$this->rjmregistrasi->get_noreg_pasien($data['no_medrec'])->row()->noreg;
				//echo $getnoreg; break;
				$data['jenis_pasien']=$this->input->post('jenis_pasien');
				$this->insert_tindakan($data);			
			
			
			if ($data['cara_bayar']=="BPJS") {
			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>
									Daftar ulang pasien berhasil. &nbsp;<a href="'.site_url('irj/rjcregistrasi/buat_SEP/'.$id->no_register).'" class="btn btn-danger">Cetak SEP</a>
									</h4>
								</div>
							</div>
						</div>';
			} else {
				$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>
									Daftar ulang pasien berhasil.
									</h4>
								</div>
							</div>
						</div>';
			}
			
			$this->session->set_flashdata('success_msg', $success);
			
			
			//cetak_karcis
			//echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_karcis/$id->no_register").'", "_blank");window.focus()</script>';
			//cetak identitas			
			if($this->input->post('jns_kunj')=='BARU'){
				echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_identitas/$id->no_register").'", "_blank");window.focus()</script>';
			}
			echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_tracer/$id->no_register").'", "_blank");window.focus()</script>';
			//cetak sep
			if ($data['cara_bayar']=="BPJS") {
				//$data2['no_sep']=$this->buat_SEP($id->no_register);
				//echo $data2['no_sep'];
				//$result = $this->rjmregistrasi->update_SEP($no_register, $data2);
				
				//echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_sep/$id->no_register").'", "_blank");window.focus()</script>';
			}
		//}
		
		/*if ($data['cara_bayar']=="BPJS") {
			redirect('irj/rjcregistrasi/daftarulang/'.$no_medrec,'refresh');
		} else {
			redirect('irj/rjcregistrasi/','refresh');
		}
		*/
		
		redirect('irj/rjcregistrasi/','refresh');
	}
	public function pasien_bpjs($no_register='')
	{
		$data['title'] = 'Daftar Pasien Rawat Jalan';
		$data['message'] = $this->session->flashdata('message');

		if($no_register==''){
			$data['daftar_pasien']=$this->rjmregistrasi->get_daftar_pasien()->result();
			$this->load->view('irj/rjvformdaftarbpjs',$data);
		}else{
			$data['detail_pasien']=$this->rjmregistrasi->get_detail_daful($no_register)->result();
			$data['prop']=$this->rjmpencarian->get_prop()->result();
			$data['cara_berkunjung']=$this->rjmpencarian->get_cara_berkunjung()->result();
			$data['ppk']=$this->rjmpencarian->get_ppk()->result();
			$data['kelas']=$this->rjmpencarian->get_kelas()->result();
			$data['poli']=$this->rjmpencarian->get_poliklinik()->result();
			$data['cara_bayar']=$this->rjmpencarian->get_cara_bayar()->result();

			$data['dokter']=$this->rjmpencarian->get_dokter()->result();
			$data['kontraktor']=$this->rjmpencarian->get_kontraktor()->result();
			$data['diagnosa']=$this->rjmpencarian->get_diagnosa()->result();

			$this->load->view('irj/rjvformdaful',$data);
		}
			
	}
	public function insert_pasien_bpjs()
	{			
			//get umur
			$no_medrec=$this->input->post('no_medrec');
			$no_register=$this->input->post('no_register');
			$get_umur=$this->rjmregistrasi->get_umur($no_medrec)->result();
			$tahun=0;
			$bulan=0;
			$hari=0;
			foreach($get_umur as $row)
			{
				// echo $row->umurday;
				$tahun=floor($row->umurday/365);
				$bulan=floor(($row->umurday - ($tahun*365))/30);
				$hari=$row->umurday - ($bulan * 30) - ($tahun * 365);
			}

			$data['umurrj']=$tahun;
			$data['uharirj']=$hari;
			$data['ublnrj']=$bulan;
			$data['tgl_kunjungan']=$this->input->post('tgl_kunj')." ".date('H:i:s');
			
			$data['jns_kunj']=$this->input->post('jns_kunj');
			$data['cara_kunj']=$this->input->post('cara_kunj');

			if($this->input->post('asal_rujukan')!=''){
				$data['asal_rujukan']=$this->input->post('asal_rujukan');
			}

			if($this->input->post('dll_rujukan')!=''){
				$data['asal_rujukan']=$this->input->post('dll_rujukan');
			}

			if($this->input->post('no_rujukan')!=''){
				$data['no_rujukan']=$this->input->post('no_rujukan');
			}

			$data['tgl_rujukan']=$this->input->post('tgl_rujukan');
			$data['kelas_pasien']=$this->input->post('kelas_pasien');
			$data['cara_bayar']=$this->input->post('cara_bayar');
			if($this->input->post('jenis_kontraktor')!=''){
				$data['id_kontraktor']=$this->input->post('jenis_kontraktor');
			}
			$data['diagnosa']=$this->input->post('id_diagnosa');
			$data['id_poli']=$this->input->post('id_poli');
			$data['id_dokter']=$this->input->post('id_dokter');
			$data['nama_penjamin']=$this->input->post('nama_penjamin');
			$data['hubungan']=$this->input->post('hubungan');
			$data['vtot']=0;
			//$data['no_sep']=$this->input->post('no_sep');
			$data['xuser']=$this->input->post('user_name');


			$id=$this->rjmregistrasi->update_daftar_ulang($no_register,$data);
			
			if ($data['cara_bayar']=="BPJS") {
			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">

									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>

									Daftar ulang pasien berhasil. &nbsp;<a href="'.site_url('irj/rjcregistrasi/buat_SEP/'.$no_register).'" class="btn btn-danger">Cetak SEP</a>
									</h4>
								</div>
							</div>
						</div>';
			} else {
				$success = 	'

						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>

									<h4>
									<i class="icon fa fa-check"></i>
									Daftar ulang pasien berhasil.

									</h4>
								</div>
							</div>
						</div>';
			}
			
			$this->session->set_flashdata('success_msg', $success);
		
			redirect('irj/rjcregistrasi/pasien_bpjs/'.$no_register,'refresh');
			
	}
	public function kontrol_pasien(){
		$data['title'] = 'Daftar Pasien Kontrol Rawat Jalan';

		$data['kontrol_pasien']=$this->rjmregistrasi->get_pasien_kontrol($no_register)->result();

	}
	//CETAK KARCIS/////////////////////////////////////////////////////////////////////////////////////////////////
	public function cetak_tracer($no_register='')
	{
		if($no_register!=''){
			/*$get_nokarcis=$this->rjmkwitansi->get_new_nokarcis($no_register)->result();
				foreach($get_nokarcis as $val){
					$noseri_karcis=sprintf("B%s%05s",$val->year,$val->counter+1);
				}
			$this->rjmkwitansi->update_nokarcis($noseri_karcis,$no_register);
			*/
			// $data_rs=$this->rjmkwitansi->getdata_rs('10000')->result();
			// 	foreach($data_rs as $row){
			// 		$namars=$row->namars;
			// 		$kota=$row->kota;
			// 		$alamatrs=$row->alamat;
			// 		$nmsingkat=$row->namasingkat;
			// 	}
			$namars=$this->config->item('namars');
			$alamatrs=$this->config->item('alamat');
			$kota=$this->config->item('kota');
			$nmsingkat=$this->config->item('nmsingkat');
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			
			$data_tracer=$this->rjmregistrasi->getdata_tracer($no_register)->result();			
			foreach($data_tracer as $row){
				if($row->sex=='L'){$sex='Laki-laki';}else{ $sex='Perempuan';}
			$no_medrec=$row->no_medrec;
			$konten=
					"<style type=\"text/css\">
					.table-font-size{
						font-size:8.5px;
					    }
					</style>					
					$namars | $alamatrs
					
					<h3>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<u>TRACER</u></h3><br/>
					<table class=\"table-font-size\">
						<tr>
							<td width=\"20%\"><h4>No. Antrian</h4></td>
							<td width=\"5%\"> : </td>
							<td width=\"30%\"><b>$row->no_antrian</b></td>
							<td>No. MR</td>
							<td width=\"5%\"> : </td>
							<td width=\"20%\"><b>$row->no_medrec</b></td>
						</tr>
						<tr>
							<td>Tgl Registrasi</td>
							<td> : </td>
							<td><b>".date('d-m-Y',strtotime($row->tgl_kunjungan))." | ".date('H:i:s',strtotime($row->tgl_kunjungan))."</b></td>
							<td >Pasien</td>
							<td width=\"5%\"> : </td>
							<td width=\"20%\">$row->cara_bayar</td>
						</tr>
						<tr>
							<td>No. Registrasi</td>
							<td> : </td>
							<td><b>$row->no_register</b></td>
						</tr>
						<tr>
							<td>Waktu Shift</td>
							<td> : </td>
							<td><b>$row->shift</b></td>
						</tr>						
						<tr>
							<td>Unit Tujuan</td>
							<td> : </td>
							<td>$row->nm_poli <b>($row->id_poli)</b></td>
						</tr>
						<tr>
							<td>Pasien</td>
							<td> : </td>
							<td><b>$row->nama</b></td>
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
							<td>$sex</td>
						</tr>";

						if($this->rjmregistrasi->getdata_before($no_medrec,$no_register)->num_rows()>0){
							$data_tracer=$this->rjmregistrasi->getdata_before($no_medrec,$no_register)->result();
							foreach($data_tracer as $row1){
							if($row1->ket_pulang!='PULANG' and $row1->ket_pulang!=''){
								$txtpulang='| '.$row1->ket_pulang;
							}else $txtpulang='';
							$konten=$konten."<tr>
								<td>Unit & Kunjungan Lalu</td>
								<td> : </td>
								<td>".date('d-m-Y',strtotime($row1->tgl_kunjungan))." | $row1->nm_poli $txtpulang</td>
							</tr>";
							}
						}						
						$konten=$konten."<tr>
							<td>Petugas</td>
							<td> : </td>
							<td>$row->xuser</td>
						</tr>						
						
					</table><br>
					<hr/>
					<br>
			";
						
						
			
						
			}
			print_r($konten);
			$konten1=$konten."<br>".$konten."<br>".$konten;
			$file_name="Tracer_$no_register.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A5', true, 'UTF-8', false);
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
					$content = $konten1;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'/download/irj/rjtracer/'.$file_name, 'FI');
		}else{
			redirect('irj/rjcregistrasi','refresh');
		}
	}
	
	//CETAK IDENTITAS/////////////////////////////////////////////////////////////////////////////////////////////////
	public function cetak_identitas($no_register='')
	{
		if($no_register!=''){
			// $data_rs=$this->rjmkwitansi->getdata_rs('10000')->result();
			// 	foreach($data_rs as $row){
			// 		$namars=$row->namars;
			// 		$kota=$row->kota;
			// 		$alamatrs=$row->alamat;
			// 		$nmsingkat=$row->namasingkat;
			// 	}
			$namars=$this->config->item('namars');
			$alamatrs=$this->config->item('alamat');
			$kota=$this->config->item('kota');
			$nmsingkat=$this->config->item('nmsingkat');
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");

			$getrdrj=substr($no_register, 0,2);
			if($getrdrj=="RJ"){
				$data_identitas=$this->rjmregistrasi->getdata_identitas($no_register)->result();
			} else if($getrdrj=="RD"){
				$data_identitas=$this->ModelRegistrasi->getdata_identitas($no_register)->result();
			}else{}
			
			foreach($data_identitas as $row){
			$konten=
					"<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					</style>
					<table class=\"table-font-size\" border=\"0\">
						<tr>
						<td rowspan=\"3\" width=\"16%\" style=\"border-bottom:1px solid black; font-size:8px; \"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"30\" style=\"padding-right:5px;\"></p></td>
						<td rowspan=\"3\" width=\"45%\" style=\"border-bottom:1px solid black; font-size:8px;\"><b>$namars</b> <br/> $alamatrs</td>
						<td width=\"29%\"></td>
						<td width=\"10%\"><div style=\" text-align:center; font-size:8px; border: 1px solid black;\">RM 01</div></td>
						</tr>
						<tr><td></td><td></td></tr>
						<tr><td colspan=\"2\"><p align=\"right\" style=\"font-size:10px;\"><b>NO. RM : <u>".$row->no_cm."</u></b></p></td></tr>
					</table>					
					<p align=\"center\" style=\"font-size:10px\"><u><b>IDENTITAS PASIEN</b></u></p>
			
					<table class=\"table-font-size\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding: 3px; \">
						<tr>
							<td colspan=\"3\"><u><b>PASIEN</b></u></td>
						</tr>
						<tr>
							<td width=\"27%\">NAMA LENGKAP</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".strtoupper($row->nama)."</td>
						</tr>
						<tr>
							<td width=\"27%\">JENIS KELAMIN</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->sex=='L'? 'LAKI-LAKI':($row->sex=='P'? 'PEREMPUAN':'LAKI-LAKI / PEREMPUAN'))."</td>
						</tr>
						<tr>
							<td width=\"27%\">TEMPAT/TGL. LAHIR</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">$row->tmpt_lahir/".date('d-m-Y', strtotime($row->tgl_lahir))."</td>
						</tr>
						<tr>
							<td width=\"27%\">ALAMAT RUMAH/NO. TELP</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->alamat=='' ? '...........................................................................................................................................................................................................................................................................................................................................................' :$row->alamat)." / ".($row->no_telp=='' ? '....................................' :$row->no_telp)."</td>
						</tr>
						<tr>
							<td width=\"27%\">PEKERJAAN</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->pekerjaan=='' ? '................................................................................................' :$row->pekerjaan)."</td>
						</tr>
						<tr>
							<td width=\"27%\">ALAMAT KANTOR/NO. TELP</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">........................................................................................................................................................................................................................../".($row->no_telp_kantor=='' ? '.....................................................................' :$row->no_telp_kantor)."</td>
						</tr>
						<tr>
							<td width=\"27%\">AGAMA</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->agama=='' ? 'ISLAM / PROTESTAN / KATHOLIK / HINDU / BUDHA / KONGHUCU / Lain-Lain .......................' :strtoupper($row->agama))."</td>
						</tr>
						<tr>
							<td width=\"27%\">PENDIDIKAN</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->pendidikan=='' ? 'SD / SMP / SMA / D1 / D2 / D3 / D4 / S1 / S2 / S3 / Lain-Lain .......................' :strtoupper($row->pendidikan))."</td>
						</tr>
						<tr>
							<td width=\"27%\">STATUS PERKAWINAN</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->sex=='B'? 'BELUM KAWIN':($row->sex=='K'? 'KAWIN':'KAWIN / BELUM KAWIN / DUDA / JANDA'))."</td>
						</tr>
						<tr>
							<td width=\"27%\">STATUS PASIEN</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->cara_bayar=='' ? 'BPJS / DIJAMIN / JAMSOSKES / UMUM / Lain-Lain .......................' :$row->cara_bayar)."</td>
						</tr>
						
						<tr>
							<td colspan=\"3\"><U><b>PENANGGUNG JAWAB</b></U></td>
						</tr>
						<tr>
							<td width=\"27%\">NAMA LENGKAP</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->nama_penjamin=='' ? '.................................................................................................................................' :strtoupper($row->nama_penjamin))."</td>
						</tr>
						<tr>
							<td width=\"27%\">HUBUNGAN</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->hubungan=='' ? 'YBS. / SUAMI / ISTRI / ANAK / Lain-Lain ......................................' :strtoupper($row->hubungan))."</td>
						</tr>
						<tr>
							<td width=\"27%\">JENIS KELAMIN</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">LAKI-LAKI / PEREMPUAN</td>
						</tr>
						<tr>
							<td width=\"27%\">TEMPAT/TGL. LAHIR</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">................................/...............................................................</td>
						</tr>
						<tr>
							<td width=\"27%\">ALAMAT RUMAH/NO. TELP</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">....................................................................................................................../.........................................................................</td>
						</tr>
						<tr>
							<td width=\"27%\">PEKERJAAN</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">................................................................................................</td>
						</tr>
						<tr>
							<td width=\"27%\">ALAMAT KANTOR/NO. TELP</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">....................................................................................................................../.........................................................................</td>
						</tr>
					</table>
			";
			
			/*
						<tr>
							<td>Biaya Karcis</td>
							<td> : </td>
							<td><b><font size=\"10\">Rp ".number_format( $row->biayadaftar, 2 , ',' , '.' )."</font></b></td>
						</tr>
			*/
						
			}
			$file_name="Identitas_$no_register.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A5', true, 'UTF-8', false);
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
				$obj_pdf->SetMargins('10', '7', '10');//left top right
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 10);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				if($getrdrj=="RJ"){
					$obj_pdf->Output(FCPATH.'/download/irj/rjidentitas/'.$file_name, 'FI');
				} else if($getrdrj=="RD"){
					$obj_pdf->Output(FCPATH.'/download/ird/rdidentitas/'.$file_name, 'FI');
				}else{}
				
		}else{
			redirect('irj/rjcregistrasi','refresh');
		}
	}
	
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SEP
	public function buat_SEP($no_register) {

		//$timezone = date_default_timezone_get();
		date_default_timezone_set('Asia/Jakarta');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00')); //cari timestamp
		//echo $timestamp."asa";
        
		$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
        $encoded_signature = base64_encode($signature);
		//echo $encoded_signature."asa";
        
		$http_header = array(
               'Accept: application/json', 
               'Content-type: application/x-www-form-urlencoded',
               'X-cons-id: 1000', //id rumah sakit
               'X-timestamp: ' . $timestamp,
               'X-signature: ' . $encoded_signature
        );
		 
		$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$logged_in_user_info=$this->M_user->get_logged_in_user_info();
		
         // nama variabel sesuai dengan nama di xml
         $noKartu = $data['data_pasien_daftar_ulang']->no_kartu;
		 $tglSep = date('Y-m-d H:i:s');
         $tglRujukan = $data['data_pasien_daftar_ulang']->tgl_rujukan;
         $noRujukan = $data['data_pasien_daftar_ulang']->no_rujukan;
         $ppkRujukan = $data['data_pasien_daftar_ulang']->asal_rujukan;
		 $ppkPelayanan = '10000'; //id rs
         $jnsPelayanan = '2'; //1->RJ 2->RD 3-> RI
		 $catatan = 'Coba SEP Bridging';
         $diagAwal = $data['data_pasien_daftar_ulang']->diagnosa;
         $poliTujuan = $data['data_pasien_daftar_ulang']->id_poli;
		 $klsRawat = $data['data_pasien_daftar_ulang']->kelas_pasien;
		 $lakaLantas = '2';
         $user = $logged_in_user_info->username;
         $noMr = $data['data_pasien_daftar_ulang']->no_medrec;
         
		 $data = '<request>
					<data>
					<t_sep>
					<noKartu>0001662503141</noKartu>
 <tglSep>2016-04-19 00:00:00</tglSep>
 <tglRujukan>2016-04-13 00:00:00</tglRujukan>
 <noRujukan>Tes01</noRujukan>
 <ppkRujukan>0301U049</ppkRujukan>
 <ppkPelayanan>0301R001</ppkPelayanan>
 <jnsPelayanan>2</jnsPelayanan>
 <catatan>Coba SEP Bridging</catatan>
 <diagAwal>H52.0</diagAwal>
 <poliTujuan>MAT</poliTujuan>
 <klsRawat>3</klsRawat>
 <lakaLantas>2</lakaLantas>
 <user>viena</user>
 <noMr>121280</noMr>
					 
					</t_sep>
					</data>
				</request>';
				/*
				
					<poliTujuan>'.$poliTujuan.'</poliTujuan>
					
					 
					 
<noKartu>0001662503141</noKartu>
 <tglSep>2016-04-19 00:00:00</tglSep>
 <tglRujukan>2016-04-13 00:00:00</tglRujukan>
 <noRujukan>Tes01</noRujukan>
 <ppkRujukan>0301U049</ppkRujukan>
 <ppkPelayanan>0301R001</ppkPelayanan>
 <jnsPelayanan>2</jnsPelayanan>
 <catatan>Coba SEP Bridging</catatan>
 <diagAwal>H52.0</diagAwal>
 <poliTujuan>MAT</poliTujuan>
 <klsRawat>3</klsRawat>
 <lakaLantas>2</lakaLantas>
 <user>viena</user>
 <noMr>121280</noMr>
 
 <noKartu>'.$noKartu.'</noKartu>
					<tglSep>'.$tglSep.'</tglSep>
					<tglRujukan>'.$tglRujukan.'</tglRujukan>
					<noRujukan>'.$noRujukan.'</noRujukan>
					<ppkRujukan>'.$ppkRujukan.'</ppkRujukan>
					<ppkPelayanan>'.$ppkPelayanan.'</ppkPelayanan>
					<jnsPelayanan>'.$jnsPelayanan.'</jnsPelayanan>
					<catatan>'.$catatan.'</catatan>
					<diagAwal>'.$diagAwal.'</diagAwal>
					<poliTujuan>MAT</poliTujuan>
					<klsRawat>'.$klsRawat.'</klsRawat>
					<lakaLantas>'.$lakaLantas.'</lakaLantas>
					<user>'.$user.'</user>
					<noMr>'.$noMr.'</noMr>
					 
 */
		//echo("<br>".$data);
		//break;
         //$ch = curl_init('http://api.asterix.co.id/SepWebRest/sep/create/');
		 $ch = curl_init('http://dvlp.bpjs-kesehatan.go.id:8081/devWSLokalRest/SEP/sep');
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $result = curl_exec($ch);
         curl_close($ch);
		// echo $result; 
         $sep = json_decode($result)->response;
         //echo $sep."sad";
		 return("0301R00104160000010");
		
		// foreach ($sep as $key => $value){
				// echo "$key: $value\n";
				// echo "$key: $value->nama\n";
				// echo "$key: $value->nik\n";
			// };
			
			// foreach($sep->data as $mydata){
				// echo $mydata->nama . "\n";
					// foreach($mydata->values as $values){
						// echo $values->value . "\n";
					// }
			// }
      	}
	
	public function cetak_sep($no_register) {
		
		//require(getenv('DOCUMENT_ROOT') . '/RS-BPJS/assets/Surat.php');
		require_once(APPPATH.'controllers/irj/SEP.php');

		$sep = new SEP();
		//$this->load->model('r_jalan');
		$entri_rj = $this->rjmregistrasi->get_entri($no_register);
		
		if (!$entri_rj) {
			return;
		}
		
		//$this->load->model('pasien_irj');
		$pasien = $this->rjmregistrasi->get_data_pasien_by_no_cm_baru($entri_rj->no_medrec)->row();
		if (!$pasien) {
			return;
		} 
		//$this->load->model('ppk');
		$ppk = $this->rjmregistrasi->get_ppk($entri_rj->asal_rujukan);
		if ($ppk) {
			$ppk = $ppk->nm_ppk;
		}
		else {
			$ppk = $entri_rj->asal_rujukan;
		}
		
		$result = $this->rjmregistrasi->get_diagnosa($entri_rj->diagnosa);
		if($result!=''){
		$diagnosa=$result->id_icd." - ".$result->nm_diagnosa;
		}else $diagnosa='';
		// $data_rs=$this->rjmkwitansi->getdata_rs('10000')->result();
		// foreach($data_rs as $row){
		// 	$namars=$row->namars;
		// 	$kota_kab=$row->kota;
		// }
			$namars=$this->config->item('namars');
			$alamatrs=$this->config->item('alamat');
			$kota_kab=$this->config->item('kota');
			$nmsingkat=$this->config->item('nmsingkat');
		
		$fields = array(
				'No. Register' => $entri_rj->no_register,
				'No. SEP' => $entri_rj->no_sep,
				'Tgl. SEP' => date('d/m/Y'),
				'No. Kartu' => $pasien->no_kartu,
				'Peserta' => $pasien->pesertaBPJS,
				'Nama Peserta' => $pasien->nama,
				'Tgl. Lahir' => date("d-m-Y", strtotime($pasien->tgl_lahir)),
				'Jenis Kelamin' => $pasien->sex,
				'Asal Faskes' => $ppk,
				'Poli Tujuan' => $entri_rj->nm_poli,
				'Kelas Rawat' => $entri_rj->kelas_pasien,
				'Jenis Rawat' => 'Rawat Jalan',
				'Diagnosa Awal' => $diagnosa,
				//'Catatan' => $entri_rj->CATATAN
				'Catatan' => '',
				'Nama RS' => $namars
			); 
		$sep->set_nilai($fields);
		$sep->cetak();
	}	
		
}
?>
