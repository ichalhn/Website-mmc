<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/irj/Rjcterbilang.php');
require_once(APPPATH.'controllers/Secure_area.php');
class Pacdaftar extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('pa/pamdaftar','',TRUE);
		$this->load->model('lab/labmdaftar','',TRUE);
		$this->load->model('pa/pamkwitansi','',TRUE);
		$this->load->helper('pdf_helper');
	}

	public function index(){
		$data['title'] = 'Patologi Anatomi';

		$data['pa']=$this->pamdaftar->get_daftar_pasien_pa()->result();
		$this->load->view('pa/pavdaftarpasien',$data);
		//print_r($data);
	}

	public function by_date(){
		$date=$this->input->post('date');
		$data['title'] = 'Patologi Anatomi, Tanggal '.$date;

		$data['pa']=$this->pamdaftar->get_daftar_pasien_pa_by_date($date)->result();
		$this->load->view('pa/pavdaftarpasien',$data);
	}

	public function by_no(){
		$key=$this->input->post('key');
		$data['title'] = 'Patologi Anatomi';

		$data['pa']=$this->pamdaftar->get_daftar_pasien_pa_by_no($key)->result();
		$this->load->view('pa/pavdaftarpasien',$data);
	}

	public function pemeriksaan_pa($no_register=''){
		$data['title'] = 'Input Pemeriksaan Patologi Anatomi';

		$data['no_register']=$no_register;

		if(substr($no_register, 0,2)=="PL"){
			$data['data_pasien_pemeriksaan']=$this->pamdaftar->get_data_pasien_luar_pemeriksaan($no_register)->result();
			foreach($data['data_pasien_pemeriksaan'] as $row){
				$data['nama']=$row->nama;
				$data['alamat']=$row->alamat;
				$data['dokter_rujuk']=$row->dokter;
				$data['no_medrec']='-';
				$data['no_cm']='-';
				$data['kelas_pasien']='II';
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']='-';
				$data['bed']='-';
				$data['cara_bayar']=$row->cara_bayar;
			}
		}else{
			$data['data_pasien_pemeriksaan']=$this->pamdaftar->get_data_pasien_pemeriksaan($no_register)->result();
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
				$data['kelas_pasien']='II';
			}else if (substr($no_register, 0,2)=="RI"){
				if($data['cara_bayar']!='UMUM'){
					$kontraktor=$this->labmdaftar->get_data_pasien_kontraktor_iri($no_register)->row()->nmkontraktor;
					$data['nmkontraktor']=$kontraktor;	
				}else $data['nmkontraktor']='';			
			}
		}

		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->pamdaftar->get_roleid($login_data->userid)->row()->roleid;

		$data['data_jenis_pa']=$this->pamdaftar->get_jenis_pa()->result();
		$data['data_pemeriksaan']=$this->pamdaftar->get_data_pemeriksaan($no_register)->result();
		$data['dokter']=$this->pamdaftar->getdata_dokter()->result();
		$data['tindakan']=$this->pamdaftar->getdata_tindakan_pasien()->result();

		$this->load->view('pa/pavpemeriksaan',$data);
	}

	public function get_biaya_tindakan()
	{
		$id_tindakan=$this->input->post('id_tindakan');
		$kelas=$this->input->post('kelas');
		$biaya=$this->pamdaftar->get_biaya_tindakan($id_tindakan,$kelas)->row()->total_tarif;
		echo json_encode($biaya);
	}

	public function insert_pemeriksaan()
	{
		$data['no_register']=$this->input->post('no_register');
		$data['no_medrec']=$this->input->post('no_medrec');
		$data['id_tindakan']=$this->input->post('idtindakan');
		$data['kelas']=$this->input->post('kelas_pasien');
		$data['tgl_kunjungan']=$this->input->post('tgl_kunj');
		$data_tindakan=$this->pamdaftar->getjenis_tindakan($data['id_tindakan'])->result();
		foreach($data_tindakan as $row){
			$data['jenis_tindakan']=$row->nmtindakan;
		}
		$data['qty']=$this->input->post('qty');
		$data['id_dokter']=$this->input->post('id_dokter');
		$data_dokter=$this->pamdaftar->getnama_dokter($data['id_dokter'])->result();
		foreach($data_dokter as $row){
			$data['nm_dokter']=$row->nm_dokter;
		}
		$data['biaya_pa']=$this->input->post('biaya_pa_hide');
		$data['vtot']=$this->input->post('vtot_hide');
		$data['idrg']=$this->input->post('idrg');
		$data['bed']=$this->input->post('bed');
		$data['cara_bayar']=$this->input->post('cara_bayar');
		$data['xinput']=$this->input->post('xuser');

		/*$data['no_pa']=$this->input->post('no_pa');
		if($data['no_pa']!=''){
		} else {
			$this->pamdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
			$data['no_pa']=$this->pamdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_pa;
		}*/

		$this->pamdaftar->insert_pemeriksaan($data);
		
		//redirect('pa/pacdaftar/pemeriksaan_pa/'.$data['no_register'].'/'.$data['no_pa']);
		redirect('pa/pacdaftar/pemeriksaan_pa/'.$data['no_register']);
		//print_r($data);
	}

	public function save_pemeriksaan(){
		if( isset( $_POST['myCheckboxes'] ) )
		{
		    for ( $i=0; $i < count( $_POST['myCheckboxes'] ); $i++ )
		    {
		        $data['no_register']=$this->input->post('no_register');
				$data['no_medrec']=$this->input->post('no_medrec');
				$data['id_tindakan']=$this->input->post('myCheckboxes['.$i.']');
				$data['kelas']=$this->input->post('kelas_pasien');
				$data['tgl_kunjungan']=$this->input->post('tgl_kunj');
				$data_tindakan=$this->pamdaftar->getjenis_tindakan($data['id_tindakan'])->result();
				foreach($data_tindakan as $row){
					$data['jenis_tindakan']=$row->nmtindakan;
				}
				$data['qty']='1';
				$data['id_dokter']=$this->input->post('id_dokter');
				$data_dokter=$this->pamdaftar->getnama_dokter($data['id_dokter'])->result();
				foreach($data_dokter as $row){
					$data['nm_dokter']=$row->nm_dokter;
				}
				$data['biaya_pa']=$biaya=$this->pamdaftar->get_biaya_tindakan($data['id_tindakan'], $data['kelas'])->row()->total_tarif;
				$data['vtot']=$data['biaya_pa'];
				$data['idrg']=$this->input->post('idrg');
				$data['bed']=$this->input->post('bed');
				$data['cara_bayar']=$this->input->post('cara_bayar');
				$data['xinput']=$this->input->post('xuser');

				$this->pamdaftar->insert_pemeriksaan($data);
		    }
			
			echo json_encode(array("status" => TRUE));
		}
	}

	public function selesai_daftar_pemeriksaan() //JANGAN LUPA SETTING NOMOR PA DISINI
	{
		$no_register=$this->input->post('no_register');
		$idrg=$this->input->post('idrg');
		$bed=$this->input->post('bed');
		$kelas=$this->input->post('kelas_pasien');
		$getvtotpa=$this->pamdaftar->get_vtot_pa($no_register)->row()->vtot_pa;
		$getrdrj=substr($no_register, 0,2);

		$this->pamdaftar->insert_data_header($no_register,$idrg,$bed,$kelas);
		$no_pa=$this->pamdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row()->no_pa;

		if($getrdrj=="PL"){
			$this->pamdaftar->selesai_daftar_pemeriksaan_PL($no_register,$getvtotpa,$no_pa);
		} else if($getrdrj=="RJ"){
			$this->pamdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotpa,$no_pa);
		}
		else if ($getrdrj=="RD"){
			$this->pamdaftar->selesai_daftar_pemeriksaan_IRD($no_register,$getvtotpa,$no_pa);
		}
		else if ($getrdrj=="RI"){
			$data_iri=$this->pamdaftar->getdata_iri($no_register)->result();
			foreach($data_iri as $row){
				$status_pa=$row->status_pa;
			}
			$status_pa = $status_pa + 1;
			$this->pamdaftar->selesai_daftar_pemeriksaan_IRI($no_register,$status_pa,$getvtotpa,$no_pa);
		}

		if($getrdrj=="PL"){
			echo '<script type="text/javascript">window.open("'.site_url("pa/pacdaftar/cetak_faktur/$no_pa").'", "_blank");window.focus()</script>';

			redirect('pa/pacdaftar/','refresh');
		} 
		else if($getrdrj=="RJ"){
			echo '<script type="text/javascript">window.open("'.site_url("pa/pacdaftar/cetak_faktur/$no_pa").'", "_blank");window.focus()</script>';
			redirect('pa/pacdaftar/','refresh');
		}
		else if ($getrdrj=="RD"){
			echo '<script type="text/javascript">window.open("'.site_url("pa/pacdaftar/cetak_faktur/$no_pa").'", "_blank");window.focus()</script>';
			redirect('pa/pacdaftar/','refresh');
		}
		else if ($getrdrj=="RI"){
			echo '<script type="text/javascript">window.open("'.site_url("pa/pacdaftar/cetak_faktur/$no_pa").'", "_blank");window.focus()</script>';
			redirect('pa/pacdaftar/','refresh');
		}

		// echo '<script type="text/javascript">window.open("'.site_url("pa/pacdaftar/cetak_faktur/$no_pa").'", "_blank");window.focus()</script>';

		// redirect('pa/pacdaftar/','refresh');
		
		//print_r($getvtotpa);
	}

	public function hapus_data_pemeriksaan($id_pemeriksaan_pa='')
	{
		$this->pamdaftar->hapus_data_pemeriksaan($id_pemeriksaan_pa);
        echo json_encode(array("status" => $id_pemeriksaan_pa));
		
		//print_r($id);
	}	

	public function daftar_pasien_luar()
	{
		//$data['xuser']=$this->input->post('xuser');
		$data['nama']=$this->input->post('nama');
		$data['alamat']=$this->input->post('alamat');
		$data['dokter']=$this->input->post('dokter');
		$data['tgl_kunjungan']=date('Y-m-d H:i:s');

		$no_register=$this->pamdaftar->get_new_register()->result();
		foreach($no_register as $val){
			$data['no_register']=sprintf("PL%s%06s",$val->year,$val->counter+1);
		}
		$data['pa']='1';
		
		$this->pamdaftar->insert_pasien_luar($data);
		
		redirect('pa/pacdaftar/pemeriksaan_pa/'.$data['no_register']);
		print_r($data);
	}

	public function cetak_faktur($no_pa='')
	{
		$jumlah_vtot=$this->pamdaftar->get_vtot_no_pa($no_pa)->row()->vtot_no_pa;
		if($no_pa!=''){
			
			//set timezone
			date_default_timezone_set("Asia/Jakarta");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			$data_pasien=$this->pamkwitansi->get_data_pasien($no_pa)->row();
			$data_pemeriksaan=$this->pamkwitansi->get_data_pemeriksaan($no_pa)->result();
			
			$tahun=0;
			$bulan=0;
			$hari=0;
			$tahun=floor($data_pasien->tgl_lahir/365);
			$bulan=floor(($data_pasien->tgl_lahir - ($tahun*365))/30);
			$hari=$data_pasien->tgl_lahir - ($bulan * 30) - ($tahun * 365);
			
			$cterbilang=new rjcterbilang();
			
			$jumlah_vtot0=0;
			foreach($data_pemeriksaan as $row){
				$jumlah_vtot0=$jumlah_vtot0+$row->vtot;
			}

			$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot0);

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
					<hr/>
					<p align=\"center\"><b>
					FAKTUR PATOLOGI ANATOMI 
					No. PA_$no_pa
					</b></p>
					<table>
						<tr>
							<td width=\"20%\"><b>Terbilang</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"78%\"><b><i>".strtoupper($vtot_terbilang)."</i></b></td>							
						</tr>
						<tr>
							<td width=\"20%\"></td>
							<td width=\"3%\"></td>
							<td width=\"78%\"></td>							
						</tr>
						<tr>
							<td width=\"20%\"><b>No. Registrasi</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"27%\">$data_pasien->no_register</td>
							<td width=\"20%\"><b>Nama Pasien</b></td>
							<td width=\"3%\"> : </td>
							<td width=\"27%\">$data_pasien->nama</td>
						</tr>
						<tr>
							<td><b>No. Medrec</b></td>
							<td> : </td>
							<td>$data_pasien->no_cm</td>
							<td><b>Umur</b></td>
							<td> : </td>
							<td>$tahun tahun, $bulan bulan, $hari hari.</td>
						</tr>
						<tr>
							<td><b>Golongan Pasien</b></td>
							<td> : </td>
							<td>$data_pasien->cara_bayar</td>
							<td><b>Alamat</b></td>
							<td> : </td>
							<td>$data_pasien->alamat</td>
						</tr>
					</table>
					<br/><br/>

					<table border=\"1\" style=\"padding:2px\">
						<tr>
							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
							<th width=\"55%\"><p align=\"center\"><b>Nama Pemeriksaan</b></p></th>
							<th width=\"15%\"><p align=\"center\"><b>Biaya</b></p></th>
							<th width=\"10%\"><p align=\"center\"><b>Banyak</b></p></th>
							<th width=\"15%\"><p align=\"center\"><b>Total</b></p></th>
						</tr>
					";
					$i=1;
					$jumlah_vtot=0;
					foreach($data_pemeriksaan as $row){
						$jumlah_vtot=$jumlah_vtot+$row->vtot;
						$vtot = number_format( $row->vtot, 2 , ',' , '.' );
						$konten=$konten."
						<tr>
						  	<td><p align=\"center\">".$i++."</p></td>
						  	<td>".$row->jenis_tindakan."</td>
						  	<td><p align=\"right\">".number_format( $row->biaya_pa, 2 , ',' , '.' )."</p></td>
						  	<td><p align=\"center\">".$row->qty."</p></td>
						  	<td><p align=\"right\">".$vtot."</P></td>
						</tr>";
					}

				$konten=$konten."
						<tr>
							<th colspan=\"4\"><p align=\"right\"><b>Total   </b></p></th>
							<th><p align=\"right\">".number_format( $jumlah_vtot, 2 , ',' , '.' )."</p></th>
						</tr>";
					
				$login_data = $this->load->get_var("user_info");
				$user = strtoupper($login_data->username);
				$konten=$konten."
					</table>
					<br>
					<br>
					<table style=\"width:100%;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
								$kota_kab, $tgl
								<br>Patologi Anatomi
								<br><br><br>$user
								</p>
							</td>
						</tr>	
					</table>
					";
			
			$file_name="FKTR_PA_".$no_pa."_".$data_pasien->nama.".pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
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
				$obj_pdf->SetMargins('10', '5', '10');
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/pa/pafaktur/'.$file_name, 'FI');
		}else{
			redirect('pa/pacdaftar/','refresh');
		}
	}
}