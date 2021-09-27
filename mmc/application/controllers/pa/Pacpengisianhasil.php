<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Pacpengisianhasil extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('lab/labmdaftar','',TRUE);
		$this->load->model('pa/pamdaftar','',TRUE);
		$this->load->model('pa/pamkwitansi','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index(){
		$data['title'] = 'Patologi Anatomi';

		$data['pa']=$this->pamdaftar->get_hasil_pa()->result();
		$this->load->view('pa/pavdaftarpengisian',$data);
	}

	public function by_date(){
		$date=$this->input->post('date');
		$data['title'] = 'Patologi Anatomi Tanggal '.$date;

		$data['pa']=$this->pamdaftar->get_hasil_pa_by_date($date)->result();
		$this->load->view('pa/pavdaftarpengisian',$data);
	}

	public function by_no(){
		$key=$this->input->post('key');
		$data['title'] = 'Patologi Anatomi';

		$data['pa']=$this->pamdaftar->get_hasil_pa_by_no($key)->result();
		$this->load->view('pa/pavdaftarpengisian',$data);
	}

	public function daftar_hasil($no_pa=''){
		$data['title'] = 'Patologi Anatomi';
		$data['no_pa']=$no_pa;
		$no_register=$this->pamdaftar->get_no_register($no_pa)->row()->no_register;
		$data['no_register']=$no_register;
		if(substr($no_register, 0,2)=="PL"){
			$data['data_pasien_pemeriksaan']=$this->pamdaftar->get_data_hasil_pemeriksaan_pasien_luar($no_pa)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['alamat']=$row->alamat;
				$data['dokter_rujuk']=$row->dokter;
				$data['no_medrec']='-';
				$data['no_cm']='-';
				$data['kelas_pasien']='III';
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']='-';
				$data['bed']='-';
				$data['cara_bayar']=$row->cara_bayar;
				$data['nmkontraktor']='';
			}
		}else{
			$data['data_pasien_pemeriksaan']=$this->pamdaftar->get_data_hasil_pemeriksaan($no_pa)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['no_cm']=$row->no_cm;
				$data['no_medrec']=$row->no_medrec;
				$data['kelas_pasien']=$row->kelas;
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']=$row->idrg;
				$data['bed']=$row->bed;
				$data['cara_bayar']=$row->cara_bayar;
				if($row->foto==NULL){
					$data['foto']='unknown.png';
				}else {
					$data['foto']=$row->foto;
				}
			}
			if(substr($no_register, 0,2)=="RJ"){
				if($data['cara_bayar']!='UMUM'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else $data['nmkontraktor']='';
				$data['bed']='Rawat Jalan';
			}else if (substr($no_register, 0,2)=="RI"){
				if($data['cara_bayar']!='UMUM'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else $data['nmkontraktor']='';
								
			}
		}

		$data['daftarpengisian']=$this->pamdaftar->get_data_pengisian_hasil($no_register)->result();

		$this->load->view('pa/pavdaftarhasil',$data);
	}

	public function isi_hasil($id_pemeriksaan_pa=''){
		$data['title'] = 'Patologi Anatomi';
		$data['id_pemeriksaan_pa'] = $id_pemeriksaan_pa;

		$nr=$this->pamdaftar->get_row_register($id_pemeriksaan_pa)->result();
		foreach($nr as $row){
			$no_register=$row->no_register;
		}

		if(substr($no_register, 0,2)=="PL"){
			$data['data_pasien_pemeriksaan']=$this->pamdaftar->get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_pa)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['alamat']=$row->alamat;
				$data['dokter_rujuk']=$row->dokter;
				$data['no_register']=$no_register;
				$data['no_medrec']='-';
				$data['no_cm']='-';
				$data['kelas_pasien']='III';
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']='-';
				$data['bed']='-';
				$data['cara_bayar']=$row->cara_bayar;
				$data['no_pa']=$row->no_pa;
				$data['id_tindakan']=$row->id_tindakan;
				$data['jenis_tindakan']=$row->jenis_tindakan;
				$data['nmkontraktor']='';
			}
		}else{
			$data['data_pasien_pemeriksaan']=$this->pamdaftar->get_data_isi_hasil_pemeriksaan($id_pemeriksaan_pa)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['no_cm']=$row->no_cm;
				$data['no_medrec']=$row->no_medrec;
				$data['no_register']=$no_register;
				$data['id_tindakan']=$row->id_tindakan;
				$data['jenis_tindakan']=$row->jenis_tindakan;
				$data['kelas_pasien']=$row->kelas;
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']=$row->idrg;
				$data['bed']=$row->bed;
				$data['cara_bayar']=$row->cara_bayar;
				$data['no_pa']=$row->no_pa;
				if($row->foto==NULL){
					$data['foto']='unknown.png';
				}else {
					$data['foto']=$row->foto;
				}
			}
			if(substr($no_register, 0,2)=="RJ"){
				if($data['cara_bayar']!='UMUM'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else $data['nmkontraktor']='';
				$data['bed']='Rawat Jalan';
			}else if (substr($no_register, 0,2)=="RI"){
				if($data['cara_bayar']!='UMUM'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else $data['nmkontraktor']='';
								
			}
		}

		$data['get_data_tindakan_pa']=$this->pamdaftar->get_data_tindakan_pa($data['id_tindakan'])->result();
		
		$this->load->view('pa/pavisihasil',$data);
	}

	public function edit_hasil($id_pemeriksaan_pa=''){
		$data['title'] = 'Patologi Anatomi';
		$data['id_pemeriksaan_pa'] = $id_pemeriksaan_pa;

		$nr=$this->pamdaftar->get_row_register($id_pemeriksaan_pa)->result();
		foreach($nr as $row){
			$no_register=$row->no_register;
		}

		if(substr($no_register, 0,2)=="PL"){
			$data['data_pasien_pemeriksaan']=$this->pamdaftar->get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_pa)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['alamat']=$row->alamat;
				$data['dokter_rujuk']=$row->dokter;
				$data['no_register']=$no_register;
				$data['no_medrec']='-';
				$data['no_cm']='-';
				$data['kelas_pasien']='III';
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']='-';
				$data['bed']='-';
				$data['cara_bayar']=$row->cara_bayar;
				$data['no_pa']=$row->no_pa;
				$data['id_tindakan']=$row->id_tindakan;
				$data['jenis_tindakan']=$row->jenis_tindakan;
				$data['nmkontraktor']='';
			}
		}else{
			$data['data_pasien_pemeriksaan']=$this->pamdaftar->get_data_isi_hasil_pemeriksaan($id_pemeriksaan_pa)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['no_cm']=$row->no_cm;
				$data['no_medrec']=$row->no_medrec;
				$data['no_register']=$no_register;
				$data['id_tindakan']=$row->id_tindakan;
				$data['jenis_tindakan']=$row->jenis_tindakan;
				$data['kelas_pasien']=$row->kelas;
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']=$row->idrg;
				$data['bed']=$row->bed;
				$data['cara_bayar']=$row->cara_bayar;
				$data['no_pa']=$row->no_pa;
				if($row->foto==NULL){
					$data['foto']='unknown.png';
				}else {
					$data['foto']=$row->foto;
				}
			}
			if(substr($no_register, 0,2)=="RJ"){
				if($data['cara_bayar']!='UMUM'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else $data['nmkontraktor']='';
				$data['bed']='Rawat Jalan';
			}else if (substr($no_register, 0,2)=="RI"){
				if($data['cara_bayar']!='UMUM'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else $data['nmkontraktor']='';
								
			}
		}

		$data['get_data_edit_tindakan_pa']=$this->pamdaftar->get_data_edit_tindakan_pa($data['id_tindakan'],$data['no_pa'])->result();
		
		$this->load->view('pa/pavedithasil',$data);
	}

	public function simpan_hasil(){
		$id_pemeriksaan_pa=$this->input->post('id_pemeriksaan_pa');
		$no_register=$this->input->post('no_register');
		$no_pa=$this->input->post('no_pa');
		$itot=$this->input->post('itot');
		for($i=1;$i<=$itot;$i++){
			$data['id_tindakan']=$this->input->post('id_tindakan');	
			$data['no_pa']=$this->input->post('no_pa');
			$data['no_register']=$this->input->post('no_register');
			$data['jenis_hasil']=$this->input->post('jenis_hasil_'.$i);
			$data['kadar_normal']=$this->input->post('kadar_normal_'.$i);
			$data['satuan']=$this->input->post('satuan_'.$i);
			$data['hasil_pa']=$this->input->post('hasil_pa_'.$i);

			$this->pamdaftar->isi_hasil($data);
			
		}
		$this->pamdaftar->set_hasil_periksa($id_pemeriksaan_pa);

		redirect('pa/pacpengisianhasil/daftar_hasil/'.$data['no_pa']);
	}

	public function edit_hasil_submit(){
		$no_register=$this->input->post('no_register');
		$no_pa=$this->input->post('no_pa');
		$itot=$this->input->post('itot');
		for($i=1;$i<=$itot;$i++){
			$id_hasil_pemeriksaan=$this->input->post('id_hasil_pemeriksaan_'.$i);
			$hasil_pa=$this->input->post('hasil_pa_'.$i);

			$this->pamdaftar->edit_hasil($id_hasil_pemeriksaan, $hasil_pa);
			
		}

		redirect('pa/pacpengisianhasil/daftar_hasil/'.$no_pa);
	}

	public function st_cetak_hasil_pa()
	{
		$no_pa=$this->input->post('no_pa');
		$data_pasien=$this->pamkwitansi->get_data_pasien($no_pa)->row();

		if($no_pa!=''){

			$this->pamdaftar->update_status_cetak_hasil($no_pa);
			echo '<script type="text/javascript">window.open("'.site_url("pa/pacpengisianhasil/cetak_hasil_pa/$no_pa").'", "_blank");window.focus()</script>';
			
			redirect('pa/pacpengisianhasil/','refresh');
		}else{
			redirect('pa/pacpengisianhasil/','refresh');
		}
	}

	public function st_cetak_hasil_pa_rawat()
	{
		$no_pa=$this->input->post('no_pa');
		$data_pasien=$this->pamkwitansi->get_data_pasien($no_pa)->row();

		if($no_pa!=''){

			$this->pamdaftar->update_status_cetak_hasil($no_pa);
			echo '<script type="text/javascript">window.open("'.site_url("pa/pacpengisianhasil/cetak_hasil_pa/$no_pa").'", "_blank");window.history.back();</script>';
			
			//redirect('pa/pacpengisianhasil/','refresh');
		}else{
			//redirect('pa/pacpengisianhasil/','refresh');
		}
	}

	public function cetak_hasil_pa($no_pa='')
	{
		if($no_pa!=''){
			$nr=$this->pamdaftar->get_row_register_by_nopa($no_pa)->result();
			foreach($nr as $row){
				$no_register=$row->no_register;
			}
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$email=$this->config->item('email');
			$kota_kab=$this->config->item('kota');
			$data_jenis_pa=$this->pamdaftar->get_data_jenis_pa($no_pa)->result();
			$nohptelp = "";$almt = "";
			if(substr($no_register, 0,2)=="PL"){
				$data_pasien=$this->pamdaftar->get_data_pasien_luar_cetak($no_pa)->row();
				$konten=
					"
					<table  border=\"0\" style=\"padding-top:10px;padding-bottom:10px;\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
									<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"50\" style=\"padding-right:5px;\">
								</p>
							</td>
							<td  width=\"70%\" style=\" font-size:8px;\">
								<b><font style=\"font-size:12px\">
								$namars</font></b>
								<br>
								<br>$alamatrs $kota_kab 
								<br>$telp 
								<br>$email
							</td>
							<td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam</font></td>						
						</tr>
					</table>
					<br/><hr/><br/><br>
					<p align=\"center\"><b>
					HASIL PEMERIKSAAN PATOLOGI ANATOMI<br/>
					No Pemeriksaan : $no_pa
					</b></p><br/>
					<table>
						<tr>
							<td width=\"15%\"><b>Nama Pasien</b></td>
							<td width=\"2%\"> : </td>
							<td width=\"45%\">$data_pasien->nama</td>
						</tr>
						<tr>
							<td width=\"15%\"><b>Alamat</b></td>
							<td width=\"2%\"> : </td>
							<td width=\"45%\">$data_pasien->alamat</td>
						</tr>
						<tr>
							<td width=\"15%\"><b>Jenis Pasien</b></td>
							<td width=\"2%\"> : </td>
							<td width=\"45%\">Pasien Luar</td>
						</tr>
						<tr>
							<td width=\"15%\"><b>No Register</b></td>
							<td width=\"2%\"> : </td>
							<td width=\"45%\">$no_register</td>
						</tr>
					</table>
					<br/><br/><hr>
					<table style=\"padding:2px\">
						<tr>
							<th width=\"40%\"><p align=\"left\"><b>Jenis Pemeriksaan</b></p></th>
							<th width=\"15%\"><p align=\"left\"><b>Hasil</b></p></th>
							<th width=\"15%\"><p align=\"left\"><b>Satuan</b></p></th>
							<th width=\"30%\"><p align=\"left\"><b>Nilai Rujukan</b></p></th>
						</tr>
						<hr>
					";
			} else {
				$data_pasien=$this->pamdaftar->get_data_pasien_cetak($no_pa)->row();
				if($data_pasien->sex=="L"){
					$kelamin = "Laki-laki";
				} else {
					$kelamin = "Perempuan";
				}

				$almt = $almt."$data_pasien->alamat ";
				if($data_pasien->rt!=""){
					$almt = $almt."RT. $data_pasien->rt ";
				}
				if($data_pasien->rw!=""){
					$almt = $almt."RW. $data_pasien->rw ";
				}
				if($data_pasien->kelurahandesa!=""){
					$almt = $almt."$data_pasien->kelurahandesa ";
				}
				if($data_pasien->kecamatan!=""){
					$almt = $almt."$data_pasien->kecamatan ";
				}
				if($data_pasien->kotakabupaten!=""){
					$almt = $almt."<br>$data_pasien->kotakabupaten ";
				}

				if(($data_pasien->no_telp!="") && ($data_pasien->no_hp!="")){
					$nohptelp = $nohptelp."$data_pasien->no_telp / $data_pasien->no_hp";
				} else if($data_pasien->no_telp!=""){
					$nohptelp = $nohptelp."$data_pasien->no_telp";
				} else if($data_pasien->no_hp!=""){
					$nohptelp = $nohptelp."$data_pasien->no_hp";
				} else {
					$nohptelp = $nohptelp."-";
				}

				$konten=
					"<table>
						<tr>
							<td><p align=\"left\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p></td>
							<td align=\"right\"><font size=\"8\" align=\"right\">$tgl_jam</font></td>
						</tr>
						<tr>
							<td colspan=\"2\"><b>$alamat</b></td>
						</tr>
					</table>
					<br/><hr/><br/><br>
					<p align=\"center\"><b>
					HASIL PEMERIKSAAN PATOLOGI ANATOMI<br/>
					No Pemeriksaan : $no_pa
					</b></p><br/>
					<table>
						<tr>
							<td width=\"15%\"><b>Nama Pasien</b></td>
							<td width=\"2%\"> : </td>
							<td width=\"45%\">$data_pasien->nama</td>
							<td width=\"15%\"><b>Tanggal Lahir</b></td>
							<td width=\"2%\"> : </td>
							<td width=\"21%\">$data_pasien->tgl_lahir</td>
						</tr>
						<tr>
							<td><b>Alamat</b></td>
							<td>:</td>
							<td rowspan=\"2\">
								$almt
							</td>
							<td><b>Kelamin</b></td>
							<td> : </td>
							<td>$kelamin</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td><b>No Telp/HP</b></td>
							<td> : </td>
							<td>$nohptelp</td>
						</tr>
					</table>
					<br/><br/><hr>
					<table style=\"padding:2px\">
						<tr>
							<th width=\"40%\"><p align=\"left\"><b>Jenis Pemeriksaan</b></p></th>
							<th width=\"15%\"><p align=\"left\"><b>Hasil</b></p></th>
							<th width=\"15%\"><p align=\"left\"><b>Satuan</b></p></th>
							<th width=\"30%\"><p align=\"left\"><b>Nilai Rujukan</b></p></th>
						</tr>
						<hr>
					";
			}
					$i=1;
					foreach($data_jenis_pa as $row){
						$tindakan=strtoupper($row->nmtindakan);
						$konten=$konten."<tr>
							<th colspan=\"4\"><p align=\"left\"><b>$tindakan</b></p></th>
							</tr>";
						$data_hasil_pa=$this->pamdaftar->get_data_hasil_pa($row->id_tindakan,$row->no_pa)->result();
						foreach($data_hasil_pa as $row1){
							$konten=$konten."<tr>
											  <td>&nbsp;&nbsp;$row1->jenis_hasil</td>
											  <td><b>$row1->hasil_pa</b></td>
											  <td>$row1->satuan</td>
											  <td>$row1->kadar_normal</td>
											</tr>";

						}

					}
					
				$konten=$konten."
					</table>
					<hr>
					<br/>
					<p align=\"right\">$kota_kab, $tgl</p>
					";
			
			$file_name="Hasil_Pa_$no_pa.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
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
				$obj_pdf->Output(FCPATH.'download/pa/papengisianhasil/'.$file_name, 'FI');
		}else{
			redirect('pa/pacpengisianhasil/','refresh');
		}
	}
}