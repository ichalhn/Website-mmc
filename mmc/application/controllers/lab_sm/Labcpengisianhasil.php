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
		$data['title'] = 'PENGISIAN HASIL LABORATORIUM';

		$data['laboratorium']=$this->labmdaftar->get_hasil_lab()->result();
		$this->load->view('lab/labvdaftarpengisian',$data);
	}

	public function by_date(){
		$date=$this->input->post('date');
		$data['title'] = 'PENGISIAN HASIL LABORATORIUM Tanggal '.$date;

		$data['laboratorium']=$this->labmdaftar->get_hasil_lab_by_date($date)->result();
		$this->load->view('lab/labvdaftarpengisian',$data);
	}

	public function by_no(){
		$key=$this->input->post('key');
		$data['title'] = 'PENGISIAN HASIL LABORATORIUM';

		$data['laboratorium']=$this->labmdaftar->get_hasil_lab_by_no($key)->result();
		$this->load->view('lab/labvdaftarpengisian',$data);
	}

	public function daftar_hasil($no_lab=''){
		$data['title'] = 'PENGISIAN HASIL LABORATORIUM';
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
				if($data['cara_bayar']=='DIJAMIN'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_irj($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;
				}else $data['nmkontraktor']='';
				$data['bed']='Rawat Jalan';
				$data['kelas_pasien']='II';
			}else if (substr($no_register, 0,2)=="RI"){
				if($data['cara_bayar']=='DIJAMIN'){
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
		$data['title'] = 'PENGISIAN HASIL LABORATORIUM';
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
		$data['title'] = 'PENGISIAN HASIL LABORATORIUM';
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
			$data['metode']=$this->input->post('metode_'.$i);
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
			$no_register=$this->labmdaftar->get_row_register_by_nolab($no_lab)->row()->no_register;
				
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
			$header_pdf=$this->config->item('header_pdf');

			$data_jenis_lab=$this->labmdaftar->get_data_jenis_lab($no_lab)->result();
			$data_kategori_lab=$this->labmdaftar->get_data_kategori_lab($no_lab)->result();
			$nohptelp = "";$almt = "";

			$konten="
					<font size=\"6\" align=\"right\">$tgl_jam</font><br>
					$header_pdf

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
				$nama_dokter=$this->labmdaftar->getnm_dokter($data_pasien->no_register)->row()->nm_dokter;
				if($data_pasien->cara_bayar=='DIJAMIN'){
					$a=$this->labmdaftar->getcr_bayar_dijamin($data_pasien->no_register)->row();
					$cara_bayar= "$a->a - $a->b";
				} else {
					$cara_bayar=$data_pasien->cara_bayar;
				}
				if (substr($no_register,0,2)==RJ) {
					$lokasi = $data_pasien->idrg;
				}else if(substr($no_register,0,2)==RI) {
					$lokasi = 'Rawat Inap - '.$this->labmdaftar->getruang($data_pasien->idrg)->row()->nmruang;
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
							<th width=\"25%\"><p align=\"left\"><b>Jenis Pemeriksaan</b></p></th>
							<th width=\"25%\"><p align=\"left\"><b>Hasil</b></p></th>
							<th width=\"15%\"><p align=\"left\"><b>Satuan</b></p></th>
							<th width=\"15%\"><p align=\"left\"><b>Nilai Rujukan</b></p></th>
							<th width=\"20%\"><p align=\"left\"><b>Metode</b></p></th>
						</tr>
					</table><hr>
					<style type=\"text/css\">
					.table-isi{
						    padding-left:10px; 
						    font-size:9;
						}
					.table-isi th{
						    border-bottom: 1px solid #ddd;
						}
					.table-isi td{
						    border-bottom: 1px solid #ddd;
						    border-right: 1px solid #ddd;
						}
					</style>
					<table class=\"table-isi\" border=\"0\">";
					foreach ($data_kategori_lab as $rw) {
						$tindakan=strtoupper($rw->nama_jenis);
						$konten=$konten."
							<tr>
								<th colspan=\"5\"><p align=\"left\">
									<br/><b>Jenis Pemeriksaan : <i>$tindakan</i></b></p>
								</th>
							</tr>";
						foreach($data_jenis_lab as $row){
							if ($rw->kode_jenis == substr($row->id_tindakan,0,2)) {
								$konten=$konten."
									<tr>
										<th colspan=\"5\"><p align=\"left\"><b>&nbsp;&nbsp;$row->nmtindakan</b></p></th>
									</tr>";
								$data_hasil_lab=$this->labmdaftar->get_data_hasil_lab($row->id_tindakan,$row->no_lab)->result();
								foreach($data_hasil_lab as $row1){
									$konten=$konten."<tr>
													  <td width=\"25%\">&nbsp;&nbsp;&nbsp;&nbsp;$row1->jenis_hasil</td>
													  <td width=\"25%\"><center>$row1->hasil_lab</center></td>
													  <td width=\"15%\">$row1->satuan</td>
													  <td width=\"15%\">$row1->kadar_normal</td>
													  <td width=\"20%\">$row1->metode</td>
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
								
								<br><br><br>Laboratorium
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

	public function export_hasil_lab($no_lab=''){
		if($no_lab!=''){
			$no_register=$this->labmdaftar->get_row_register_by_nolab($no_lab)->row()->no_register;
				
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
			$header_pdf=$this->config->item('header_pdf');

			$data_jenis_lab=$this->labmdaftar->get_data_jenis_lab($no_lab)->result();
			$data_kategori_lab=$this->labmdaftar->get_data_kategori_lab($no_lab)->result();


			////EXCEL 
			$this->load->library('Excel');  
			   
			// Create new PHPExcel object  
			$objPHPExcel = new PHPExcel();   
			   
			// Set document properties  
			$objPHPExcel->getProperties()->setCreator("RUMAH SAKIT KHUSUS MATA")  
			        ->setLastModifiedBy("RUMAH SAKIT KHUSUS MATA")  
			        ->setTitle("Laporan Keuangan RUMAH SAKIT KHUSUS MATA")  
			        ->setSubject("Laporan Keuangan RUMAH SAKIT KHUSUS MATA Document")  
			        ->setDescription("Laporan Keuangan RUMAH SAKIT KHUSUS MATA, generated by HMIS.")  
			        ->setKeywords("RUMAH SAKIT KHUSUS MATA")  
			        ->setCategory("Laboratorium");  

			//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
			//$objPHPExcel = $objReader->load("project.xlsx");
			   
			$objReader= PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(true);

			// $awal = $this->input->post('tanggal_awal');
			// $akhir = $this->input->post('tanggal_akhir');

			$data_keuangan=$this->Labmlaporan->get_data_keu_tind($param1, $param2)->result();
		
			$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_lab.xlsx');
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
			$objPHPExcel->setActiveSheetIndex(0);  
			// Add some data  
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('I3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('J3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('K3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('L3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('M3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('N3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('O3')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	      	$objPHPExcel->getActiveSheet()->setAutoFilter('A3:O3');

			$objPHPExcel->getActiveSheet()->SetCellValue('A1', "Laporan Pendapatan Laboratorium Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));
	      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
	      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
	      	$objPHPExcel->getActiveSheet()->mergeCells('A1:O1');
	      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$rowCount = 4;
			$temp = "";
			$temptgl = "";
			$total_pendapatan = 0;
			foreach($data_keuangan as $row){
				if($temptgl == $row->tgl_kunjungan){

				}else {
					$temptgl = $row->tgl_kunjungan;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row->tgl_kunjungan);
				}

				if($temp == $row->no_lab){
					$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->jenis_tindakan);
					$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->biaya_lab);
					$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->qty);
					$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->vtot);
					$total_pendapatan = $total_pendapatan + $row->vtot;
					if($row->cara_bayar=="BPJS"){
						$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "BPJS");
					}else if($row->status=="1"){
						$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "Lunas");
					}else{
						$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "Belum Lunas");
					}
				}else {
					$temp = $row->no_lab;
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->no_lab);
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_register);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->nama);
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->no_medrec);
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->kelas);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->idrg);
					$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->bed);
					$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->cara_bayar);
					$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->kontraktor);
					$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->jenis_tindakan);
					$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->biaya_lab);
					$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->qty);
					$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->vtot);
					$total_pendapatan = $total_pendapatan + $row->vtot;
					if($row->cara_bayar=="BPJS"){
						$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "BPJS");
					}else if($row->status=="1"){
						$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "Lunas");
					}else{
						$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, "Belum Lunas");
					}
				}
				
				$rowCount++;
			}
			$filename = "Laporan Pendapatan Laboratorium ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2));
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "Total Pendapatan : ");
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $total_pendapatan);
			header('Content-Disposition: attachment;filename="'.$filename.'.xls"');  
					
			// Rename worksheet (worksheet, not filename)  
			$objPHPExcel->getActiveSheet()->setTitle('RUMAH SAKIT KHUSUS MATA');    
			   
			// Redirect output to a client’s web browser (Excel2007)  
			//clean the output buffer  
			ob_end_clean();  
			   
			//this is the header given from PHPExcel examples.   
			//but the output seems somewhat corrupted in some cases.  
			//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
			//so, we use this header instead.  
			header('Content-type: application/vnd.ms-excel');  
			header('Cache-Control: max-age=0');  
			   
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
			// $objWriter->save('php://output');  
			$this->SaveViaTempFile($objWriter);

			// $awal = $this->input->post('tanggal_awal');
			// $akhir = $this->input->post('tanggal_akhir');
			// $data_keuangan=$this->Labmlaporan->get_data_keu_tind($awal, $akhir)->result();
			// echo json_encode($data_keuangan);
		}else{
			redirect('lab/labcpengisianhasil/','refresh');
		}
	}
}