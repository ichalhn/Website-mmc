<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Labcpengisianhasil extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('lab/labmdaftar','',TRUE);
		$this->load->model('lab/labmkwitansi','',TRUE);
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index(){
		$data['title'] = 'Laboratorium';

		$data['laboratorium']=$this->labmdaftar->get_hasil_lab()->result();
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->labmdaftar->get_roleid($login_data->userid)->row()->roleid;
		$this->load->view('lab/labvdaftarpengisian',$data);
	}

	public function by_date(){
		$date=$this->input->post('date');
		$data['title'] = 'Laboratorium Tanggal '.$date;

		$data['laboratorium']=$this->labmdaftar->get_hasil_lab_by_date($date)->result();
		$this->load->view('lab/labvdaftarpengisian',$data);
	}

	public function by_no(){
		$key=$this->input->post('key');
		$data['title'] = 'Laboratorium';

		$data['laboratorium']=$this->labmdaftar->get_hasil_lab_by_no($key)->result();
		$this->load->view('lab/labvdaftarpengisian',$data);
	}

	public function daftar_hasil($no_lab=''){
		$data['title'] = 'Laboratorium';
		$data['no_lab']=$no_lab;
		$no_register=$this->labmdaftar->get_no_register($no_lab)->row()->no_register;
		$data['no_register']=$no_register;
		if(substr($no_register, 0,2)=="PL"){
			$data['data_pasien_pemeriksaan']=$this->labmdaftar->get_data_hasil_pemeriksaan_pasien_luar($no_lab)->result();
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
			$data['data_pasien_pemeriksaan']=$this->labmdaftar->get_data_hasil_pemeriksaan($no_lab)->result();
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
				} else $data['nmkontraktor']='';
				$data['bed']='Rawat Jalan';
			}else if (substr($no_register, 0,2)=="RI"){
				if($data['cara_bayar']!='UMUM'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;		
				}else $data['nmkontraktor']='';
			}
		}

		$hasil=$this->labmdaftar->get_row_hasil($no_lab)->result();

		if(empty($hasil)){
			$data['jenis']='isi';
			$data['daftarpengisian']=$this->labmdaftar->get_isi_hasil($no_lab)->result();
		} else {
			$data['jenis']='edit';
			$data['daftarpengisian']=$this->labmdaftar->get_edit_hasil($no_lab)->result();
		}
		// $data['daftarpengisian']=$this->labmdaftar->get_data_pengisian_hasil($no_lab)->result();
		// print_r($data['jenis']);
		$this->load->view('lab/labvdaftarhasil',$data);
	}

	public function isi_hasil($id_pemeriksaan_lab=''){
		$data['title'] = 'Laboratorium';
		$data['id_pemeriksaan_lab'] = $id_pemeriksaan_lab;

		$nr=$this->labmdaftar->get_row_register($id_pemeriksaan_lab)->result();
		foreach($nr as $row){
			$no_register=$row->no_register;
		}

		if(substr($no_register, 0,2)=="PL"){
			$data['data_pasien_pemeriksaan']=$this->labmdaftar->get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_lab)->result();
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
				$data['no_lab']=$row->no_lab;
				$data['id_tindakan']=$row->id_tindakan;
				$data['jenis_tindakan']=$row->jenis_tindakan;
			}
		}else{
			$data['data_pasien_pemeriksaan']=$this->labmdaftar->get_data_isi_hasil_pemeriksaan($id_pemeriksaan_lab)->result();
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
				$data['no_lab']=$row->no_lab;
				$data['foto']=$row->foto;
			}
			if(substr($no_register, 0,2)=="RJ"){
				$data['bed']='Rawat Jalan';
			}else if (substr($no_register, 0,2)=="RD"){
				$data['bed']='Rawat Darurat';
			}
		}

		$data['get_data_tindakan_lab']=$this->labmdaftar->get_data_tindakan_lab($data['id_tindakan'])->result();
		
		$this->load->view('lab/labvisihasil',$data);
	}

	public function edit_hasil($id_pemeriksaan_lab=''){
		$data['title'] = 'Laboratorium';
		$data['id_pemeriksaan_lab'] = $id_pemeriksaan_lab;

		$nr=$this->labmdaftar->get_row_register($id_pemeriksaan_lab)->result();
		foreach($nr as $row){
			$no_register=$row->no_register;
		}

		if(substr($no_register, 0,2)=="PL"){
			$data['data_pasien_pemeriksaan']=$this->labmdaftar->get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_lab)->result();
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
				$data['no_lab']=$row->no_lab;
				$data['id_tindakan']=$row->id_tindakan;
				$data['jenis_tindakan']=$row->jenis_tindakan;
			}
		}else{
			$data['data_pasien_pemeriksaan']=$this->labmdaftar->get_data_isi_hasil_pemeriksaan($id_pemeriksaan_lab)->result();
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
				$data['no_lab']=$row->no_lab;
				$data['foto']=$row->foto;
			}
			if(substr($no_register, 0,2)=="RJ"){
				$data['bed']='Rawat Jalan';
			}else if (substr($no_register, 0,2)=="RD"){
				$data['bed']='Rawat Darurat';
			}
		}

		$data['get_data_edit_tindakan_lab']=$this->labmdaftar->get_data_edit_tindakan_lab($data['id_tindakan'],$data['no_lab'])->result();
		
		$this->load->view('lab/labvedithasil',$data);
	}

	public function simpan_hasil(){
		$id_pemeriksaan_lab=$this->input->post('id_pemeriksaan_lab');
		$no_register=$this->input->post('no_register');
		$no_lab=$this->input->post('no_lab');
		$itot=$this->input->post('itot');
		for($i=1;$i<=$itot;$i++){
			$data['id_tindakan']=$this->input->post('id_tindakan_'.$i);	
			$data['no_lab']=$this->input->post('no_lab');
			$data['no_register']=$this->input->post('no_register');
			$data['jenis_hasil']=$this->input->post('jenis_hasil_'.$i);
			$data['kadar_normal']=$this->input->post('kadar_normal_'.$i);
			$data['satuan']=$this->input->post('satuan_'.$i);
			$data['hasil_lab']=$this->input->post('hasil_lab_'.$i);

			$this->labmdaftar->isi_hasil($data);
			
		}
		$this->labmdaftar->set_hasil_periksa($id_pemeriksaan_lab);

		// redirect('lab/labcpengisianhasil/daftar_hasil/'.$data['no_lab']);
		echo json_encode(array("status" => TRUE));
	}

	public function edit_hasil_submit(){
		$no_register=$this->input->post('no_register');
		$no_lab=$this->input->post('no_lab');
		$itot=$this->input->post('itot');
		for($i=1;$i<=$itot;$i++){
			$id_hasil_pemeriksaan=$this->input->post('id_hasil_pemeriksaan_'.$i);
			$hasil_lab=$this->input->post('hasil_lab_'.$i);

			$this->labmdaftar->edit_hasil($id_hasil_pemeriksaan, $hasil_lab);
			
		}

		// redirect('lab/labcpengisianhasil/daftar_hasil/'.$no_lab);
		echo json_encode(array("status" => TRUE));
	}

	public function st_cetak_hasil_lab()
	{
		$no_lab=$this->input->post('no_lab');
		$data_pasien=$this->labmkwitansi->get_data_pasien($no_lab)->row();

		if($no_lab!=''){

			$this->labmdaftar->update_status_cetak_hasil($no_lab);
			echo '<script type="text/javascript">window.open("'.site_url("lab/labcpengisianhasil/cetak_hasil_lab/$no_lab").'", "_blank");window.focus()</script>';
			
			redirect('lab/labcpengisianhasil/','refresh');
		}else{
			redirect('lab/labcpengisianhasil/','refresh');
		}
	}

	public function st_cetak_hasil_lab_rawat()
	{
		$no_lab=$this->input->post('no_lab');
		$data_pasien=$this->labmkwitansi->get_data_pasien($no_lab)->row();

		if($no_lab!=''){

			$this->labmdaftar->update_status_cetak_hasil($no_lab);
			echo '<script type="text/javascript">window.open("'.site_url("lab/labcpengisianhasil/cetak_hasil_lab/$no_lab").'", "_blank");window.history.back();</script>';
			
			//redirect('lab/labcpengisianhasil/','refresh');
		}else{
			//redirect('lab/labcpengisianhasil/','refresh');
		}
	}

	public function cetak_hasil_lab($no_lab='')
	{
		if($no_lab!=''){
			$nr=$this->labmdaftar->get_row_register_by_nolab($no_lab)->result();
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

			$data_jenis_lab=$this->labmdaftar->get_data_jenis_lab($no_lab)->result();
			$data_kategori_lab=$this->labmdaftar->get_data_kategori_lab($no_lab)->result();
			$nohptelp = "";$almt = "";

			$konten="
					
					<table  border=\"0\" style=\"padding-top:10px;padding-bottom:10px;\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
									<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"50\" style=\"padding-right:5px;\"><br>$namars
								</p>
							</td>
								<td  width=\"70%\" style=\" font-size:8px;\"><b><font style=\"font-size:12px\">LABORATORIUM</font></b><br><br>$alamatrs $kota_kab <br>$telp 
								<br>Email : laboratoriumrsmc@gmail.com
							</td>
							<td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam</font></td>						
						</tr>
					</table>

					<hr/><br/><br>
					<p align=\"center\"><b>
					HASIL PEMERIKSAAN LABORATORIUM
					</b></p><br/>";
			if(substr($no_register, 0,2)=="PL"){
				$data_pasien=$this->labmdaftar->get_data_pasien_luar_cetak($no_lab)->row();
				$konten=$konten.
					"<table border=\"0\">
						<tr>
							<td width=\"10%\">No. Lab</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">$no_lab</td>
							<td width=\"10%\">No Reg</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">$data_pasien->no_register</td>
							<td width=\"5%\">No MR</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">-</td>
						</tr>
						<tr>
							<td>Dokter</td>
							<td> : </td>
							<td>$data_pasien->dokter</td>
							<td>Nama Pasien</td>
							<td> : </td>
							<td colspan=\"4\"><b>$data_pasien->nama</b></td>
						</tr>
						<tr>
							<td>Dr. PJ. Lab</td>
							<td> : </td>
							<td>$data_pasien->dokter</td>
							<td width=\"10%\">Kelamin</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">-</td>
							<td width=\"5%\">Usia</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">- Thn</td>
						</tr>
						<tr>
							<td width=\"10%\">Tanggal</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">".date("d F Y",strtotime($data_pasien->tgl_kunjungan))."</td>
							<td>Status</td>
							<td> : </td>
							<td>UMUM</td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td> : </td>
							<td>$data_pasien->alamat</td>
							<td>Asal / Lokasi</td>
							<td> : </td>
							<td colspan=\"4\" rowspan=\"2\">-</td>
						</tr>
					</table>
					<br/><hr>
					";
			} else {
				$data_pasien=$this->labmdaftar->get_data_pasien_cetak($no_lab)->row();
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

				$get_umur=$this->rjmregistrasi->get_umur($data_pasien->no_medrec)->result();
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
				$nm_poli=$this->labmdaftar->getnama_poli($data_pasien->idrg)->row()->nm_poli;
				if($data_pasien->cara_bayar=='BPJS'){
					$a=$this->labmdaftar->getcr_bayar_bpjs($data_pasien->no_register)->row();
					$cara_bayar= "$a->b";
				} else if($data_pasien->cara_bayar=='DIJAMIN'){
					$a=$this->labmdaftar->getcr_bayar_dijamin($data_pasien->no_register)->row();
					$cara_bayar= "$a->a - $a->b";
				} else {
					$cara_bayar=$data_pasien->cara_bayar;
				}
				if (substr($no_register,0,2)==RJ) {
					$nama_dokter=$this->labmdaftar->getnm_dokter_rj($data_pasien->no_register)->row()->nm_dokter;
					$lokasi = $data_pasien->idrg;
				}else if(substr($no_register,0,2)==RI) {
					$nama_dokter=$this->labmdaftar->getnm_dokter_ri($data_pasien->no_register)->row()->nm_dokter;
					$lokasi = 'Rawat Inap - '.$data_pasien->idrg." (".$data_pasien->bed.")";
					// $lokasi = $nm_poli;
				}else {
					$lokasi = 'Pasien Langsung';
				}
				

				$konten=$konten.
					"<table  border=\"0\">
						<tr>
							<td width=\"10%\">No. Lab</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">$no_lab</td>
							<td width=\"10%\">No Reg</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">$data_pasien->no_register </td>
							<td width=\"5%\">No MR</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">$data_pasien->no_cm</td>
						</tr>
						<tr>
							<td>Dokter</td>
							<td> : </td>
							<td>$nama_dokter</td>
							<td>Nama Pasien</td>
							<td> : </td>
							<td colspan=\"4\"><b>$data_pasien->nama</b></td>
						</tr>
						<tr>
							<td>Dr. PJ. Lab</td>
							<td> : </td>
							<td>$data_pasien->nm_dokter</td>
							<td width=\"10%\">Kelamin</td>
							<td width=\"2%\"> : </td>
							<td width=\"16%\">$kelamin</td>
							<td width=\"5%\">Usia</td>
							<td width=\"2%\"> : </td>
							<td width=\"13%\">$tahun Thn</td>
						</tr>
						<tr>
							<td width=\"10%\">Tanggal</td>
							<td width=\"2%\"> : </td>
							<td width=\"40%\">".date("d F Y",strtotime($data_pasien->tgl_kunjungan))."</td>
							<td>Status</td>
							<td> : </td>
							<td>$cara_bayar</td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td> : </td>
							<td>
								$almt
							</td>
							<td>Asal / Lokasi</td>
							<td> : </td>
							<td colspan=\"4\" rowspan=\"2\">$lokasi</td>
						</tr>
					</table>
					<br/><hr>
					";
			}
			$konten=$konten."
					<table style=\"padding-left:10px; font-size:9\">
						<tr>
							<th width=\"30%\"><p align=\"left\"><b>Jenis Pemeriksaan</b></p></th>
							<th width=\"28%\"><p align=\"left\"><b>Hasil</b></p></th>
							<th width=\"20%\"><p align=\"left\"><b>Satuan</b></p></th>
							<th width=\"22%\"><p align=\"left\"><b>Nilai Rujukan</b></p></th>
						</tr>
					</table><hr>
					<style type=\"text/css\">
					.table-isi{
						    padding-left:10px; 
						    font-size:11;
						}
					.table-isi th{
						    border-bottom: 1px solid #ddd;
						}
					.table-isi td{
						    border-bottom: 1px solid #ddd;
						}
					</style>
					<table class=\"table-isi\" border=\"0\">";
					foreach ($data_kategori_lab as $rw) {
						$tindakan=strtoupper($rw->nama_jenis);
						$konten=$konten."
							<tr>
								<th colspan=\"4\"><p align=\"left\">
									<br/><b><i>$tindakan</i></b></p>
								</th>
							</tr>";
						foreach($data_jenis_lab as $row){
							if ($rw->kode_jenis == substr($row->id_tindakan,0,2)) {
								$konten=$konten."
									<tr>
										<th colspan=\"4\"><p align=\"left\"><b>&nbsp;&nbsp;$row->nmtindakan</b></p></th>
									</tr>";
								$data_hasil_lab=$this->labmdaftar->get_data_hasil_lab($row->id_tindakan,$row->no_lab)->result();
								foreach($data_hasil_lab as $row1){
									$kadar_normal = str_replace('<', '&lt;', $row1->kadar_normal);
									$kadar_normal = str_replace('>', '&gt;', $kadar_normal);
									// $kadar_normal = $row1->kadar_normal;
									$konten=$konten."<tr>
													  <td width=\"30%\">&nbsp;&nbsp;&nbsp;&nbsp;$row1->jenis_hasil</td>
													  <td width=\"30%\"><center>$row1->hasil_lab</center></td>
													  <td width=\"20%\">$row1->satuan</td>
													  <td width=\"20%\">$kadar_normal</td>
													</tr>";

								}
							}
						}
					}
					
					
				$konten=$konten."
					</table>
					<hr>
					<br/>
					<br/>
					<table style=\"width:100%;\" style=\"padding-bottom:5px;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
					<br/>
								$kota_kab, $tgl								
								
								<br><br><br>Petugas. Laboratorium
								<br>
								</p>
							</td>
						</tr>	
					</table>
					<br>*Penafsiran Makna hasil pemeriksaan laboratorium ini hanya dapat diberikan oleh dokter
					";
			
			$file_name="Hasil_Lab_$no_lab.pdf";
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
				$obj_pdf->SetMargins('5', '5', '5');
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/lab/labpengisianhasil/'.$file_name, 'FI');
		}else{
			redirect('lab/labcpengisianhasil/','refresh');
		}
	}
}