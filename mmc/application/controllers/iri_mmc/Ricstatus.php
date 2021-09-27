<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include('Rjcterbilang.php');

include(dirname(dirname(__FILE__)).'/Tglindo.php');

require_once(APPPATH.'controllers/Secure_area.php');
class Ricstatus extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('iri/rimreservasi');
		$this->load->model('iri/rimtindakan');
		$this->load->model('iri/rimlaporan');
		$this->load->model('iri/rimpasien');
		$this->load->model('iri/rimkelas');
		$this->load->model('iri/rimpendaftaran');
		$this->load->model('irj/M_update_sepbpjs');
		$this->load->helper('pdf_helper');
	}

	public function test(){


		$timezone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$timestamp = strval(time()-strtotime('1970-01-01 00:00:00')); //cari timestamp
		$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date("Y-m-d H:i:s");
		$http_header = array(
			   'X-cons-id: 1000', //id rumah sakit
			   'X-timestamp: ' . $timestamp,
			   'X-signature: ' . $encoded_signature
		);

		 $data = '
			 <request>
			 <data>
			 <t_sep>
			 <noKartu>0000026975924</noKartu>
			 <tglSep>'.$tgl_sep.'</tglSep>
			 <tglRujukan>'.$tgl_sep.'</tglRujukan>
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
			 </request>
		 ';
			
		 $ch = curl_init('http://dvlp.bpjs-kesehatan.go.id:8081/devWSLokalRest/SEP/sep');
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $result = curl_exec($ch);
         curl_close($ch);
		 exit;


		$timezone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$timestamp = strval(time()-strtotime('1970-01-01 00:00:00')); //cari timestamp
		$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$encoded_signature = base64_encode($signature);
		$http_header = array(
			   'Accept: application/json', 
			   'Content-type: application/xml',
			   'X-cons-id: 1000', //id rumah sakit
			   'X-timestamp: ' . $timestamp,
			   'X-signature: ' . $encoded_signature
		);
		date_default_timezone_set($timezone);
		$ch = curl_init('http://dvlp.bpjs-kesehatan.go.id:8081/devWSLokalRest/Peserta/peserta/0001219738138');
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);//json file
		curl_close($ch);
		$json_response = json_decode($result);
		print_r($json_response->response->peserta);exit;
	}

	public function cek_kartu_bpjs(){
    	$data_bpjs = $this->M_update_sepbpjs->get_data_bpjs();
		$cons_id = $data_bpjs->consid;
		$sec_id = $data_bpjs->secid;
		$ppk_pelayanan = $data_bpjs->rsid;

        $url = $data_bpjs->service_url;		
		$no_bpjs = $this->input->post('no_bpjs');
		$timezone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$timestamp = strval(time()-strtotime('1970-01-01 00:00:00')); //cari timestamp
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		$http_header = array(
			   'Accept: application/json', 
			   'Content-type: application/x-www-form-urlencoded',
			   'X-cons-id: ' . $cons_id, //id rumah sakit
			   'X-timestamp: ' . $timestamp,
			   'X-signature: ' . $encoded_signature
		);
		date_default_timezone_set($timezone);
		$ch = curl_init($url . 'Peserta/peserta/'.$no_bpjs);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);//json file
		curl_close($ch);
		
		if($result!=''){//valid koneksi internet
		$sep = json_decode($result)->response;
		//echo $result;
		//print_r($sep->peserta);
		if ($sep->peserta=='') {
			echo "No Kartu \"<b>$no_bpjs</b>\" Tidak Ditemukan. <br> Silahkan memilih cara bayar yang lain...";
		} else {
			foreach ($sep as $key => $value){
				echo "<b>No Kartu:</b> $value->noKartu <br/>";
				echo "<b>NIK:</b> $value->nik <br/>";
				echo "<b>Nama:</b> $value->nama <br/>";
				echo "<b>Pisa:</b> $value->pisa <br/>";
				echo "<b>Sex:</b> $value->sex <br/>";
				echo "<b>Tanggal Lahir:</b> $value->tglLahir <br/>";
				echo "<b>Tanggal Cetak Kartu:</b> $value->tglCetakKartu <br/>";
				$kdprovider=$value->provUmum->kdProvider;
				$nmProvider=$value->provUmum->nmProvider;
				$kdCabang=$value->provUmum->kdCabang;
				$nmCabang=$value->provUmum->nmCabang;
				echo '<br/><b>Kode Provider:</b> '.$kdprovider;
				echo '<br/><b>Nama Provider:</b> '.$nmProvider;
				echo '<br/><b>Kode Cabang:</b> '.$kdCabang;
				echo '<br/><b>Nama Cabang:</b> '.$nmCabang;
				$kdJenisPeserta=$value->jenisPeserta->kdJenisPeserta;
				$nmJenisPeserta=$value->jenisPeserta->nmJenisPeserta;
				echo '<br/><br/><b>Kode Jenis Peserta:</b> '.$kdJenisPeserta;
				echo '<br/><b>Jenis Peserta:</b> '.$nmJenisPeserta;
				$kdKelas=$value->kelasTanggungan->kdKelas;
				$nmKelas=$value->kelasTanggungan->nmKelas;
				echo '<br/><br/><b>Kode Kelas:</b> '.$kdKelas;
				echo '<br/><b>Nama Kelas:</b> '.$nmKelas;
				echo '<br/><b>Status Peserta:</b> '.$value->statusPeserta->keterangan;
				// print_r($value->jenisPeserta->nmJenisPeserta);
			};
		}
		 }else{
			echo "<div style=\"color:red;\">Pastikan Anda Terhubung Internet!!</div><br/>";
			//echo "Tidak ditemukan no Kartu: <b>$no_kartu<b/>";
		 }
	}

	public function ambil_sep(){


		$no_bpjs = $this->input->post('no_bpjs');
		$nosjp = $this->input->post('nosjp');
		$noregasal = $this->input->post('noregasal_hidden');
		$temp_ruang = $this->input->post('ruang');
		$diagnosa_id = $this->input->post('diagnosa_id');
		$no_cm = $this->input->post('no_cm');
		$ppk = $this->input->post('ppk');
		if($no_bpjs == ""){
			$data_response = array('status' => 0, 
					'response' => "Nomor Kartu BPJS Kosong"
					);
			echo json_encode($data_response);
			exit;
		}
		if($nosjp == ""){
			$data_response = array('status' => 0, 
					'response' => "Nomor SJP / Rujukan Kosong"
					);
			echo json_encode($data_response);
			exit;
		}
		if($temp_ruang == ""){
			$data_response = array('status' => 0, 
					'response' => "Nomor Kelas Ruangan Belum Terpilih"
					);
			echo json_encode($data_response);
			exit;
		}

		$ruang = explode("-", $temp_ruang);
		$temp_kelas = $ruang[2];
		$temp_kelas = explode(" ", $temp_kelas);

		$kelas = $temp_kelas[0];
		switch ($kelas) {
			case 'I':
				$kelas = 1;
				break;
			case 'II':
				$kelas = 2;
				break;
			case 'III':
				$kelas = 3;
				break;
			case 'VIP':
				$kelas = 1;
				break;
			default:
				$kelas = 3;
				break;
		}

		$kode = substr($noregasal, 0,2);

		// if($kode=='RJ'){
		// 	$pasien=$this->rimpendaftaran->select_pasien_irj_by_no_register_asal_with_diag_utama($noregasal);
		// }else if($kode=='RI'){
		// 	$pasien=$this->rimpendaftaran->select_pasien_iri_by_no_register_asal($noregasal);
		// }else{
		// 	$pasien=$this->rimpendaftaran->select_pasien_ird_by_no_register_asal_with_diag_utama($noregasal);
		// }

		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;

		$timezone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$timestamp = strval(time()-strtotime('1970-01-01 00:00:00')); //cari timestamp
		$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date("Y-m-d H:i:s");
		$http_header = array(
			   'X-cons-id: 1000', //id rumah sakit
			   'X-timestamp: ' . $timestamp,
			   'X-signature: ' . $encoded_signature
		);
		 $data = '
			 <request>
			 <data>
			 <t_sep>
			 <noKartu>'.$no_bpjs.'</noKartu>
			 <tglSep>'.$tgl_sep.'</tglSep>
			 <tglRujukan>'.$tgl_sep.'</tglRujukan>
			 <noRujukan>'.$nosjp.'</noRujukan>
			 <ppkRujukan>'.$ppk.'</ppkRujukan>
			 <ppkPelayanan>0301R001</ppkPelayanan>
			 <jnsPelayanan>2</jnsPelayanan>
			 <catatan>-</catatan>
			 <diagAwal>'.$diagnosa_id.'</diagAwal>
			 <poliTujuan>MAT</poliTujuan>
			 <klsRawat>'.$kelas.'</klsRawat>
			 <lakaLantas>2</lakaLantas>
			 <user>'.$user.'</user>
			 <noMr>'.$no_cm.'</noMr>
			 </t_sep>
			 </data>
			 </request>
		 ';
		 //print_r($data);exit;
		 $ch = curl_init('http://dvlp.bpjs-kesehatan.go.id:8081/devWSLokalRest/SEP/sep');
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $result = curl_exec($ch);
         curl_close($ch);
         if($result!=''){//valid koneksi internet
			$sep = json_decode($result);
			//echo $result;
			//print_r($sep->peserta);
			if ($sep->metadata->code == '800') {
				$data_response = array('status' => 0, 
					'response' => $sep->metadata->message
					);
			} else {
				$data_response = array('status' => 1, 
					'response' => $sep->response
					);
			}
		 }else{
		 	$data_response = array('status' => 0, 
					'response' => "Pastikan Anda Terhubung Internet!!"
					);
		 }

		 echo json_encode($data_response);
	}

	public function set_pulang_sep(){


		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;

		$timezone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$timestamp = strval(time()-strtotime('1970-01-01 00:00:00')); //cari timestamp
		$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date("Y-m-d H:i:s");
		$http_header = array(
			   'Content-type: Application/x-www-form-urlencoded',
			   'X-cons-id: 1000', //id rumah sakit
			   'X-timestamp: ' . $timestamp,
			   'X-signature: ' . $encoded_signature
		);
		 $data = '
			<request>
			 <data>
			  <t_sep>
			   <noSep>0301R00105160000042</noSep>
			   <tglPlg>'.$tgl_sep.'</tglPlg>
			   <ppkPelayanan>0301R001</ppkPelayanan>
			  </t_sep>
			 </data>
			</request>

		 ';
		 //print_r($data);exit;
		 $ch = curl_init('http://dvlp.bpjs-kesehatan.go.id:8081/devWSLokalRest/Sep/Sep/updtglplg');
         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $result = curl_exec($ch);
         curl_close($ch);
         print_r($result);exit;
         if($result!=''){//valid koneksi internet
			$sep = json_decode($result);
			//echo $result;
			//print_r($sep->peserta);
			if ($sep->metadata->code == '800') {
				$data_response = array('status' => 0, 
					'response' => $sep->metadata->message
					);
			} else {
				$data_response = array('status' => 1, 
					'response' => $sep->response
					);
			}
		 }else{
		 	$data_response = array('status' => 0, 
					'response' => "Pastikan Anda Terhubung Internet!!"
					);
		 }

		 echo json_encode($data_response);
	}

	public function hapus_sep(){


		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;

		$timezone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$timestamp = strval(time()-strtotime('1970-01-01 00:00:00')); //cari timestamp
		$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date("Y-m-d H:i:s");
		$http_header = array(
			   'Content-type: Application/x-www-form-urlencoded',
			   'X-cons-id: 1000', //id rumah sakit
			   'X-timestamp: ' . $timestamp,
			   'X-signature: ' . $encoded_signature
		);
		 $data = '
			<request>
			 <data>
			  <t_sep>
			   <noSep>0301R00105160000042</noSep>
			   <ppkPelayanan>0301R001</ppkPelayanan>
			  </t_sep>
			 </data>
			</request>

		 ';
		 //print_r($data);exit;
		 $ch = curl_init('http://dvlp.bpjs-kesehatan.go.id:8081/devWSLokalRest/SEP/sep');
         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $result = curl_exec($ch);
         curl_close($ch);
         print_r($result);exit;
         if($result!=''){//valid koneksi internet
			$sep = json_decode($result);
			//echo $result;
			//print_r($sep->peserta);
			if ($sep->metadata->code == '800') {
				$data_response = array('status' => 0, 
					'response' => $sep->metadata->message
					);
			} else {
				$data_response = array('status' => 1, 
					'response' => $sep->response
					);
			}
		 }else{
		 	$data_response = array('status' => 0, 
					'response' => "Pastikan Anda Terhubung Internet!!"
					);
		 }

		 echo json_encode($data_response);
	}

	public function cetak_sep($no_ipd = '') {
		
		//require(getenv('DOCUMENT_ROOT') . '/RS-BPJS/assets/Surat.php');
		require_once(APPPATH.'controllers/irj/SEP.php');

		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		//$data_rs = $this->rimkelas->get_data_rs('10000');

		$sep = new SEP();
		
		
		$fields = array(
				'No. Register' => $pasien[0]['no_ipd'],
				'No. SEP' => $pasien[0]['no_sep'],
				'Tgl. SEP' => $pasien[0]['tgl_masuk'],
				'No. Kartu' => $pasien[0]['no_kartu'],
				'Peserta' => $pasien[0]['no_kartu'],
				'Nama Peserta' => $pasien[0]['nama'],
				'Tgl. Lahir' => $pasien[0]['tgl_lahir'],
				'Jenis Kelamin' => $pasien[0]['sex'],
				'Asal Faskes' => $pasien[0]['tgl_lahir'],
				'Poli Tujuan' => "-",
				'Kelas Rawat' => $pasien[0]['kelas'],
				'Jenis Rawat' => "Rawat Inap",
				'Diagnosa Awal' => $pasien[0]['nm_diagmasuk'],
				'Catatan' => "",
				'Nama RS' => $this->config->item('namars')
			); 
		$sep->set_nilai($fields);
		$sep->cetak();
	}

	//keperluan tanggal
	public function obj_tanggal(){
		 $tgl_indo = new Tglindo();
		 return $tgl_indo;
	}

	public function get_grandtotal_all($no_ipd){


		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$pasienold = $this->rimtindakan->get_old_pasien($pasien[0]['noregasal']);		

		//list tidakan, mutasi, dll
		$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		$status_paket = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if(($data_paket)){
			$status_paket = 1;
		}
		//print_r($list_mutasi_pasien);exit;
				


		$grand_total = 0;
		$subsidi_total = 0;
		//mutasi ruangan pasien
		if(($list_mutasi_pasien)){
			$result = $this->string_table_mutasi_ruangan_simple($list_mutasi_pasien,$pasien,$status_paket);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
		}

		//tindakan
		if(($list_tindakan_pasien)){
			$result = $this->string_table_tindakan_simple($list_tindakan_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
		}


		// if($pasienold[0]['cetak_kwitansi']=='1' || $pasienold[0]['tgl_cetak_kw']!=''){			
		// 	$list_lab_pasien = $this->rimpasien->get_list_lab_pasien_umum($no_ipd);
		// 	$list_radiologi = $this->rimpasien->get_list_radiologi_pasien_umum($no_ipd);//belum ada no_register
		// 	$list_resep = $this->rimpasien->get_list_resep_pasien_umum($no_ipd);
		// 	$list_pa = $this->rimpasien->get_list_pa_pasien_umum($no_ipd);
		// 	//radiologi
		// 	if(($list_radiologi)){
		// 		$result = $this->string_table_radiologi_simple($list_radiologi);
		// 		$grand_total = $grand_total + $result['subtotal'];
				
		// 	}

		// 	//lab
		// 	if(($list_lab_pasien)){
		// 		$result = $this->string_table_lab_simple($list_lab_pasien);
		// 		$grand_total = $grand_total + $result['subtotal'];
		// 	}

		// 	//pa
		// 	if(($list_pa)){
		// 		$result = $this->string_table_pa_simple($list_pa);
		// 		$grand_total = $grand_total + $result['subtotal'];
		// 	}

		// 	//resep
		// 	if(($list_resep)){
		// 		$result = $this->string_table_resep_simple($list_resep);
		// 		$grand_total = $grand_total + $result['subtotal'];
		// 	}
		// }else{
			$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd,$pasien[0]['noregasal']);
			$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$pasien[0]['noregasal']);
			$list_pa = $this->rimpasien->get_list_pa_pasien($no_ipd,$pasien[0]['noregasal']);
			$list_ok = $this->rimpasien->get_list_ok_pasien($no_ipd,$pasien[0]['noregasal']);
			$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd,$pasien[0]['noregasal']);
			$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
			$poli_irj = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);
			//radiologi
			if(($list_radiologi)){
				$result = $this->string_table_radiologi_simple($list_radiologi);
				$grand_total = $grand_total + $result['subtotal'];
				
			}

			//lab
			if(($list_lab_pasien)){
				$result = $this->string_table_lab_simple($list_lab_pasien);
				$grand_total = $grand_total + $result['subtotal'];
			}

			//pa
			if(($list_pa)){
				$result = $this->string_table_pa_simple($list_pa);
				$grand_total = $grand_total + $result['subtotal'];
			}

			//ok
			if(($list_ok)){
				$result = $this->string_table_ok_simple($list_ok);
				$grand_total = $grand_total + $result['subtotal'];
			}

			//resep
			if(($list_resep)){
				$result = $this->string_table_resep_simple($list_resep);
				$grand_total = $grand_total + $result['subtotal'];
			}

			//ird
			if(($list_tindakan_ird)){
				$result = $this->string_table_ird_simple($list_tindakan_ird);
				$grand_total = $grand_total + $result['subtotal'];
				
			}

			//irj
			if($pasien[0]['carabayar']=='BPJS'){
				if(($poli_irj)){
					$result = $this->string_table_irj_simple($poli_irj);
					$grand_total = $grand_total + $result['subtotal'];
					
				}
			}
		// }

		return $grand_total;
	}

	public function get_total_pembayaran($no_ipd=''){

		//Mufti hehe :D

		// $total_ruangan = ;
		// $total_tindakan = ;
		// $total_operasi = ;
		// $total_lab = ;
		// $total_rad = ;
		// $total_pa = ;
		// $total_resep = ;
		// $total_poli = ;

		return $grand_total;
	}

	public function index($no_ipd='',$param=''){

		$data['title']='';
		$data['reservasi']='';
		$data['daftar']='';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='active';
		$data['resume']='';
		$data['kontrol']='';
		$data['linkheader']='ricstatus';

		//bikin object buat penanggalan
		$data['controller']=$this; 
		
		//data pasien
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
	
		$data['data_pasien'] = $pasien;
		$data['state'] = $param;
		//list tindakan, mutasi, dll
		$data['list_tindakan_pasien'] = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		$pasienold = $this->rimtindakan->get_old_pasien($pasien[0]['noregasal']);		

		$data['rujukan_penunjang']=$this->rimtindakan->get_rujukan_penunjang($no_ipd)->result();
		//kalo misalnya dia ada paket, langusn flag paketnya
		$data['status_paket'] = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if(($data_paket)){
			$data['status_paket'] = 1;
		}
		
			$temp = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd_temp($no_ipd);
			if($temp){
				$this->session->set_flashdata('pesan_tindakan',
				"<div class='alert alert-danger alert-dismissable'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					<i class='icon fa fa-check'></i> Terdapat Data Tindakan yang belum tersimpan ! Simpan terlebih dahulu sebelum pasien akan dimutasi/dipulangkan
				</div>");
			}
			
		
		$data['list_mutasi_pasien'] = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		$data['list_ok_pasien'] = $this->rimpasien->get_list_ok_pasien($no_ipd,$pasien[0]['noregasal']);
		
		// if($pasienold[0]['cetak_kwitansi']=='1' || $pasienold[0]['tgl_cetak_kw']!=''){	
		// 	$data['list_lab_pasien'] = $this->rimpasien->get_list_lab_pasien_umum($no_ipd);
		// 	$data['cetak_lab_pasien'] = $this->rimpasien->get_cetak_lab_pasien_umum($no_ipd,$pasien[0]['noregasal']);
		// 	$data['list_pa_pasien'] = $this->rimpasien->get_list_pa_pasien_umum($no_ipd,$pasien[0]['noregasal']);
		// 	$data['cetak_pa_pasien'] = $this->rimpasien->get_cetak_pa_pasien_umum($no_ipd,$pasien[0]['noregasal']);
		// 	$data['list_radiologi'] = $this->rimpasien->get_list_radiologi_pasien_umum($no_ipd,$pasien[0]['noregasal']);//belum ada no_register
		// 	$data['cetak_rad_pasien'] = $this->rimpasien->get_cetak_rad_pasien_umum($no_ipd,$pasien[0]['noregasal']);
		// 	$data['list_resep'] = $this->rimpasien->get_list_resep_pasien_umum($no_ipd,$pasien[0]['noregasal']);
		// 	$data['list_tindakan_ird'] = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
		// 	$data['poli_irj'] = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);
		// }else{
			$data['list_lab_pasien'] = $this->rimpasien->get_list_lab_pasien($no_ipd,$pasien[0]['noregasal']);
			$data['cetak_lab_pasien'] = $this->rimpasien->get_cetak_lab_pasien($no_ipd,$pasien[0]['noregasal']);
			$data['list_pa_pasien'] = $this->rimpasien->get_list_pa_pasien($no_ipd,$pasien[0]['noregasal']);
			$data['cetak_pa_pasien'] = $this->rimpasien->get_cetak_pa_pasien($no_ipd,$pasien[0]['noregasal']);
			$data['list_radiologi'] = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$pasien[0]['noregasal']);
			$data['cetak_rad_pasien'] = $this->rimpasien->get_cetak_rad_pasien($no_ipd,$pasien[0]['noregasal']);
			$data['list_resep'] = $this->rimpasien->get_list_resep_pasien($no_ipd,$pasien[0]['noregasal']);
			$data['list_tindakan_ird'] = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
			$data['poli_irj'] = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);
		// }
		//print_r($data['poli_irj']);exit();

		$data['grand_total'] = $this->get_grandtotal_all($no_ipd);

		//$this->load->view('iri/rivlink');
		//$this->load->view('iri/rivheader');
		//$this->load->view('iri/rivmenu', $data);
		//$this->load->view('iri/rivstatus');
		$this->load->view('iri/list_status',$data);
		//$this->load->view('iri/rivfooter');
	}

	public function cetak_list_pembayaran_pasien_simple(){
		
		$no_ipd = $this->input->post('no_ipd');
		$penerima = $this->input->post('penerima');
		$diskon = $this->input->post('diskon');
		//echo $diskon;
		$dibayar_tunai = $this->input->post('dibayar_tunai');
		//$dibayar_kartu_cc_debit = $this->input->post('dibayar_kartu_cc_debit');
		//$charge = $this->input->post('charge');
		//$no_kartu_kredit = $this->input->post('no_kartu_kredit');
		//$nomimal_charge = $dibayar_kartu_cc_debit * $charge / 100;
		$biaya_administrasi = $this->input->post('biaya_administrasi');
		$jasa_perawat = $this->input->post('jasa_perawat');
		$biaya_materai = $this->input->post('biaya_materai');
		$biaya_daftar = $this->input->post('biaya_daftar');

		$jenis_pembayaran = $this->input->post('jenis_pembayaran');

		if(!($diskon) || $diskon == ''){
			$diskon = 0;
		}		
		//print_r($penerima);exit;

		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		
		//kamari
		/*if($pasien[0]['cetak_kwitansi'] == '1'){
			$string_close_windows = "window.open('', '_self', ''); window.close();";
			echo 'Kwitansi hanya diperbolehkan dicetak satu kali. klik tombol ini untuk kembali <button type="button" 
        onclick="'.$string_close_windows.'">Kembali</button>';
        	exit;
		}*/
		//end 
		
		//list tidakan, mutasi, dll
		$list_tindakan_dokter_pasien = $this->rimtindakan->get_list_tindakan_dokter_pasien_by_no_ipd($no_ipd);
		$list_tindakan_perawat_pasien = $this->rimtindakan->get_list_tindakan_perawat_pasien_by_no_ipd($no_ipd);
		$list_tindakan_matkes_pasien = $this->rimtindakan->get_list_tindakan_matkes_pasien_by_no_ipd($no_ipd);
		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		$status_paket = 0;
		if(($data_paket)){
			$status_paket = 1;
		}
		//print_r($list_mutasi_pasien);exit;
		$list_ok_pasien = $this->rimpasien->get_list_tind_ok_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_pa_pasien = $this->rimpasien->get_list_pa_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$pasien[0]['noregasal']);//belum ada no_register
		$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
		$poli_irj = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);

		$nama_pasien = str_replace(" ","_",$pasien[0]['nama']);
		$file_name = "pembayaran_".$pasien[0]['no_ipd']."_".$nama_pasien.".pdf";
		$konten = "";

		
		$konten = $konten.'<table border="1">';

		$grand_total = 0;
		$subsidi_total = 0;
		$mutasicount= 0;
		//mutasi ruangan pasien
		if(($list_mutasi_pasien)){
			$result = $this->string_table_mutasi_ruangan_simple($list_mutasi_pasien,$pasien,$status_paket);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
			$konten1 = $konten1.$result['konten'];
			$mutasicount=$mutasicount+1;			
		}

		//tindakan dokter
		if(($list_tindakan_dokter_pasien)){
			$result = $this->string_table_tindakan_simple($list_tindakan_dokter_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
			$konten1 = $konten1.$result['konten'];
			//print_r($konten);exit;
		}
		
		//tindakan perawat
		if(($list_tindakan_perawat_pasien)){
			$result = $this->string_table_tindakan_simple($list_tindakan_perawat_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
			$konten1 = $konten1.$result['konten'];
			//print_r($konten);exit;
		}

		//tindakan matkes
		if(($list_tindakan_matkes_pasien)){
			$result = $this->string_table_tindakan_simple($list_tindakan_matkes_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
			$konten1 = $konten1.$result['konten'];
			//print_r($konten);exit;
		}


		//radiologi
		if(($list_radiologi)){
			$result = $this->string_table_radiologi_simple($list_radiologi);
			$grand_total = $grand_total + $result['subtotal'];
			$konten1 = $konten1.$result['konten'];
		}

		//ok
		if(($list_ok_pasien)){
			$result = $this->string_table_ok_simple($list_ok_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten1 = $konten1.$result['konten'];
		}

		$matkes_iri=0;
		if(($list_matkes_ok_pasien)){
			$result = $this->string_table_ok_simple($list_matkes_ok_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$matkes_iri = $matkes_iri + $result['subtotal'];
			$konten1 = $konten1.$result['konten'];
		}		
		//pa
		if(($list_pa_pasien)){
			$result = $this->string_table_pa_simple($list_pa_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten1 = $konten1.$result['konten'];
		}

		//lab
		if(($list_lab_pasien)){
			$result = $this->string_table_lab_simple($list_lab_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten1 = $konten1.$result['konten'];
		}

		//resep
		if(($list_resep)){
			$result = $this->string_table_resep_simple($list_resep);
			$grand_total = $grand_total + $result['subtotal'];
			$konten1 = $konten1.$result['konten'];
		}

		//ird
		/*if(($list_tindakan_ird)){
			$result = $this->string_table_ird_simple($list_tindakan_ird);
			$grand_total = $grand_total + $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}*/

		//irj
		if($pasien[0]['carabayar']=='BPJS'){
			/*if(($poli_irj)){
			$result = $this->string_table_irj_simple($poli_irj);
			$grand_total = $grand_total + $result['subtotal'];
			//$konten = $konten.$result['konten'];
			}*/
			if(($poli_irj)){
			$result = $this->string_table_irj($poli_irj);
			$grand_total = $grand_total + $result['subtotal'];
			$konten1 = $konten1."
			<tr>
				<td colspan=\"7\">Total Pembayaran Rawat Jalan</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";
			//$konten = $konten.$result['konten'];
			}
		}		

		//INIT KALO TUNAI DAN KREDIT
		$jenis_bayar = $this->input->post('jenis_pembayaran');
		//echo $grand_total.' '.$biaya_administrasi.' '.$biaya_materai.' '.$biaya_daftar.' '.$jasa_perawat;
		$vtot_peserta = $grand_total+$biaya_administrasi+$biaya_materai+$biaya_daftar+$jasa_perawat;
		//echo $grand_total.' '.$biaya_administrasi.' '.$biaya_materai.' '.$biaya_daftar.' '.$jasa_perawat;
		/*switch ($jenis_bayar) {
			case 'TUNAI':
				$vtot_peserta = $dibayar_tunai+$dibayar_kartu_cc_debit+$nomimal_charge;
				break;
			case 'KREDIT':
				/*if($jenis_bayar == "KREDIT" && ( $dibayar_tunai != 0 || $dibayar_kartu_cc_debit != 0 ) )
				{
					$vtot_peserta = $dibayar_tunai + $dibayar_kartu_cc_debit +$nomimal_charge;
				}else{
					$vtot_peserta = $grand_total+$biaya_administrasi;
				}
				$vtot_peserta = $grand_total+$biaya_administrasi;
				break;
			default:
				# code...
				break;
		}*/
		//INIT KALO TUNAI DAN KREDIT

		// $konten = $this->string_data_pasien_simple($pasien,$grand_total-$subsidi_total,$penerima,$jenis_pembayaran).$konten;
		$konten = $this->string_data_pasien_simple($pasien,$dibayar_tunai,$penerima,$jenis_pembayaran).$konten;
		$tgl = date("d F Y");		

		$jenis_bayar = $this->input->post('jenis_pembayaran');
		$string_detail_pembayaran_kredit_tunai = "";
		$string_diskon = "";
				if($diskon != 0){
					$string_diskon = "<tr>
						<th colspan=\"6\"><p align=\"left\"><b>Diskon   </b></p></th>
						<th ><p align=\"right\">Rp. ".number_format( $diskon, 0 )."</p></th>
					</tr>";
				}

				$string_detail_pembayaran_kredit_tunai = 
				"
				<tr>
					<th colspan=\"6\"><p align=\"left\"><b>Dibayar Tunai   </b></p></th>
					<th ><p align=\"right\">Rp. ".number_format( $dibayar_tunai, 0 )."</p></th>
				</tr>
				".$string_diskon;
			//echo $vtot_peserta;
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);
		//echo $string_detail_pembayaran_kredit_tunai;
		$grand_total_string = "
		<br><br>
		<table border=\"1\">
			".$string_detail_pembayaran_kredit_tunai."
			<tr>
				<th colspan=\"6\"><p align=\"left\"><b>Total   </b></p></th>
				<th ><p align=\"right\">Rp. ".number_format( $vtot_peserta, 0 )."</p></th>
			</tr>
		</table>
		<br/><br/>
		<table>
			<tr>
				<td></td>
				<td></td>
				<td>$tgl</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>an.Bendaharawan Rumah Sakit</td>
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
				<td>$user</td>
			</tr>
		</table>
		";

		// $konten = "<table style=\"padding:4px;\" border=\"0\">
		// 				<tr>
		// 					<td>
		// 						<p align=\"center\">
		// 							<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\" >
		// 						</p>
		// 					</td>
		// 				</tr>
		// 			</table>
		// 			<hr><br/><br/>".$konten.$grand_total_string;

		$konten = $konten."<br>".$grand_total_string;

		//update status cetak kwitansi
		$data_pasien_iri['cetak_kwitansi'] = 1;
		$data_pasien_iri['vtot'] = $grand_total-$diskon+$biaya_administrasi;
		$data_pasien_iri['vtot_piutang'] = $subsidi_total;
		$data_pasien_iri['tgl_cetak_kw'] = date("Y-m-d H:i:s");
		$login_data = $this->load->get_var("user_info");
		$data_pasien_iri['xuser'] = $login_data->username;
		//kalo kredit, sisa dari yang dibayar pasien masukin ke kredit, plus diskon
		if($jenis_bayar == "KREDIT"){
			$data_pasien_iri['diskon'] = $grand_total + $biaya_administrasi - $dibayar_tunai - $this->input->post('diskon');
			$data_pasien_iri['vtot'] = $grand_total + $biaya_administrasi - $data_pasien_iri['diskon'] ;
			// tambahan kredit //
			$konten_kredit = $this->string_perusahaan($pasien,$data_pasien_iri['diskon'],$penerima,$jenis_pembayaran,$data_pasien_iri['tgl_cetak_kw']);
			// end tambahan kredit //
		}else{
			$data_pasien_iri['diskon'] = $this->input->post('diskon');
		}
		$data_pasien_iri['jenis_bayar'] = $this->input->post('jenis_pembayaran');
		$data_pasien_iri['remark'] = $this->input->post('remark');

		$data_pasien_iri['tunai'] = $dibayar_tunai;
		//$data_pasien_iri['no_kkkd'] = $no_kartu_kredit;
		//$data_pasien_iri['nilai_kkkd'] = $dibayar_kartu_cc_debit;
		//$data_pasien_iri['persen_kk'] = $charge;
		$data_pasien_iri['matkes_iri'] = $matkes_iri;
		$data_pasien_iri['jasa_perawat'] = $this->input->post('jasa_perawat');
		$data_pasien_iri['biaya_administrasi'] = $this->input->post('biaya_administrasi');
		//$data_pasien_iri['total_charge_kkkd'] = $dibayar_kartu_cc_debit * $charge / 100;

		$data_pasien_iri['lunas'] = 1;
		if($pasien[0]['carabayar'] == "DIJAMIN"){
			$data_pasien_iri['lunas'] = 0;
		}

		//print_r($data_pasien_iri);exit;
		$this->rimpendaftaran->update_pendaftaran_mutasi($data_pasien_iri, $no_ipd);
		$this->rimpasien->flag_kwintasi_rad_terbayar($no_ipd);
		$this->rimpasien->flag_kwintasi_lab_terbayar($no_ipd);
		$this->rimpasien->flag_kwintasi_obat_terbayar($no_ipd);
		$this->rimpasien->flag_ird_terbayar($pasien[0]['noregasal'],date("Y:m:d H:m:i"),$data_pasien_iri['lunas']);
		$this->rimpasien->flag_irj_terbayar($pasien[0]['noregasal'],date("Y:m:d H:m:i"),$data_pasien_iri['lunas']);
		//update ke lab, rad, obat kalo udah pembayaran


		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$tgl_cetak = date("j F Y");
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins('5', '5', '5', '5');
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 9);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();

		if($jenis_bayar == "KREDIT" && ( $dibayar_tunai != 0 || $dibayar_kartu_cc_debit != 0 ) )
		{
			ob_start();
			$content = $konten;
			ob_end_clean();
			$obj_pdf->writeHTML($content, true, false, true, false, '');

			$obj_pdf->AddPage();
			ob_start();
				$content = $konten_kredit;
			ob_end_clean();
			$obj_pdf->writeHTML($content, true, false, true, false, '');
		}else{
			ob_start();
			$content = $konten;
			ob_end_clean();
			$obj_pdf->writeHTML($content, true, false, true, false, '');
		}
		$obj_pdf->Output(FCPATH.'/download/inap/laporan/pembayaran/'.$file_name, 'FI');


	}

	public function cetak_log_list_pembayaran_pasien_simple(){
		
		$no_ipd = $this->input->post('no_ipd');
		$penerima = $this->input->post('penerima');
		$diskon = $this->input->post('diskon');

		$dibayar_tunai = $this->input->post('dibayar_tunai');
		$dibayar_kartu_cc_debit = $this->input->post('dibayar_kartu_cc_debit');
		$charge = $this->input->post('charge');
		$no_kartu_kredit = $this->input->post('no_kartu_kredit');
		$nomimal_charge = $dibayar_kartu_cc_debit * $charge / 100;
		$biaya_administrasi = $this->input->post('biaya_administrasi');


		$jenis_pembayaran = $this->input->post('jenis_pembayaran');

		if(!($diskon) || $diskon == ''){
			$diskon = 0;
		}		
		//print_r($penerima);exit;

		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		
		//kamari
		// if($pasien[0]['cetak_kwitansi'] == '1'){
		// 	$string_close_windows = "window.open('', '_self', ''); window.close();";
		// 	echo 'Kwitansi hanya diperbolehkan dicetak satu kali. klik tombol ini untuk kembali <button type="button" 
  //       onclick="'.$string_close_windows.'">Kembali</button>';
  //       	exit;
		// }
		//end 
		
		//list tidakan, mutasi, dll
		$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		$status_paket = 0;
		if(($data_paket)){
			$status_paket = 1;
		}
		//print_r($list_mutasi_pasien);exit;
		$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$pasien[0]['noregasal']);//belum ada no_register
		$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
		$poli_irj = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);

		$nama_pasien = str_replace(" ","_",$pasien[0]['nama']);
		$file_name = "pembayaran_".$pasien[0]['no_ipd']."_".$nama_pasien." .pdf";
		$konten = "";

		
		$konten = $konten.'<table border="1">';

		$grand_total = 0;
		$subsidi_total = 0;
		//mutasi ruangan pasien
		if(($list_mutasi_pasien)){
			$result = $this->string_table_mutasi_ruangan_simple($list_mutasi_pasien,$pasien,$status_paket);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
			//$konten = $konten.$result['konten'];
		}

		//tindakan
		if(($list_tindakan_pasien)){
			$result = $this->string_table_tindakan_simple($list_tindakan_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
			//$konten = $konten.$result['konten'];
			//print_r($konten);exit;
		}

		//radiologi
		if(($list_radiologi)){
			$result = $this->string_table_radiologi_simple($list_radiologi);
			$grand_total = $grand_total + $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//lab
		if(($list_lab_pasien)){
			$result = $this->string_table_lab_simple($list_lab_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//resep
		if(($list_resep)){
			$result = $this->string_table_resep_simple($list_resep);
			$grand_total = $grand_total + $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//ird
		if(($list_tindakan_ird)){
			$result = $this->string_table_ird_simple($list_tindakan_ird);
			$grand_total = $grand_total + $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//irj
		if(($poli_irj)){
			$result = $this->string_table_irj_simple($poli_irj);
			$grand_total = $grand_total + $result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//INIT KALO TUNAI DAN KREDIT
		$jenis_bayar = $this->input->post('jenis_pembayaran');
		switch ($jenis_bayar) {
			case 'TUNAI':
				$vtot_peserta = $dibayar_tunai+$dibayar_kartu_cc_debit+$nomimal_charge;
				break;
			case 'KREDIT':
				if($jenis_bayar == "KREDIT" && ( $dibayar_tunai != 0 || $dibayar_kartu_cc_debit != 0 ) )
				{
					$vtot_peserta = $dibayar_tunai + $dibayar_kartu_cc_debit +$nomimal_charge;
				}else{
					$vtot_peserta = $grand_total+$biaya_administrasi;
				}
				break;
			default:
				# code...
				break;
		}
		//INIT KALO TUNAI DAN KREDIT

		// $konten = $this->string_data_pasien_simple($pasien,$grand_total-$subsidi_total,$penerima,$jenis_pembayaran).$konten;
		$konten = $this->string_data_pasien_simple($pasien,$vtot_peserta,$penerima,$jenis_pembayaran).$konten;
		$tgl = date("d F Y");

		$jenis_bayar = $this->input->post('jenis_pembayaran');
		$string_detail_pembayaran_kredit_tunai = "";
		switch ($jenis_bayar) {
			case 'TUNAI':
				$string_kartu_kredit = "";
				if($dibayar_kartu_cc_debit != 0){
					$string_kartu_kredit = "
					<tr>
						<th colspan=\"6\"><p align=\"left\"><b>Dibayar Kartu Kredit / Debit   </b></p></th>
						<th ><p align=\"right\">Rp. ".number_format( $dibayar_kartu_cc_debit, 0 )."</p></th>
					</tr>
					<tr>
						<th colspan=\"6\"><p align=\"left\"><b>Charge % </b></p></th>
						<th ><p align=\"right\">".$charge."</p></th>
					</tr>
					<tr>
						<th colspan=\"6\"><p align=\"left\"><b>Nominal Charge   </b></p></th>
						<th ><p align=\"right\">Rp. ".number_format( $nomimal_charge, 0 )."</p></th>
					</tr>
					";
				}

				$string_diskon = "";
				if($diskon != 0){
					$string_diskon = "<tr>
						<th colspan=\"6\"><p align=\"left\"><b>Diskon   </b></p></th>
						<th ><p align=\"right\">Rp. ".number_format( $diskon, 0 )."</p></th>
					</tr>";
				}

				$string_detail_pembayaran_kredit_tunai = 
				"
				<tr>
					<th colspan=\"6\"><p align=\"left\"><b>Dibayar Tunai   </b></p></th>
					<th ><p align=\"right\">Rp. ".number_format( $dibayar_tunai, 0 )."</p></th>
				</tr>
				".$string_kartu_kredit.$string_diskon
				;
				break;
			case 'KREDIT':
				//$vtot_peserta = $grand_total+$biaya_administrasi;
				break;
			default:
				# code...
				break;
		}

		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		$grand_total_string = "
		<br><br><br>
		<table border=\"1\">
			".$string_detail_pembayaran_kredit_tunai."
			<tr>
				<th colspan=\"6\"><p align=\"left\"><b>Total   </b></p></th>
				<th ><p align=\"right\">Rp. ".number_format( $vtot_peserta, 0 )."</p></th>
			</tr>
		</table>
		<br/><br/>
		<table>
			<tr>
				<td></td>
				<td></td>
				<td>$tgl</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>an.Bendaharawan Rumah Sakit</td>
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
				<td>$user</td>
			</tr>
		</table>
		";

		// $konten = "<table style=\"padding:4px;\" border=\"0\">
		// 				<tr>
		// 					<td>
		// 						<p align=\"center\">
		// 							<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\" >
		// 						</p>
		// 					</td>
		// 				</tr>
		// 			</table>
		// 			<hr><br/><br/>".$konten.$grand_total_string;

		$konten = $konten."<br>".$grand_total_string;

		//update status cetak kwitansi
		$data_pasien_iri['cetak_kwitansi'] = 1;
		$data_pasien_iri['vtot'] = $grand_total-$diskon+$biaya_administrasi;
		$data_pasien_iri['vtot_piutang'] = $subsidi_total;
		$data_pasien_iri['tgl_cetak_kw'] = date("Y-m-d H:i:s");
		$login_data = $this->load->get_var("user_info");
		$data_pasien_iri['xuser'] = $login_data->username;
		//kalo kredit, sisa dari yang dibayar pasien masukin ke kredit, plus diskon
		if($jenis_bayar == "KREDIT"){
			$data_pasien_iri['diskon'] =  $this->input->post('diskon');
			$data_pasien_iri['vtot'] = $grand_total + $biaya_administrasi - $data_pasien_iri['diskon'] ;
			// tambahan kredit //
			$konten_kredit = $this->string_perusahaan($pasien,$data_pasien_iri['diskon'],$penerima,$jenis_pembayaran,$data_pasien_iri['tgl_cetak_kw']);
			// end tambahan kredit //
		}else{
			$data_pasien_iri['diskon'] = $this->input->post('diskon');
		}
		$data_pasien_iri['jenis_bayar'] = $this->input->post('jenis_pembayaran');
		$data_pasien_iri['remark'] = $this->input->post('remark');

		$data_pasien_iri['tunai'] = $dibayar_tunai;
		$data_pasien_iri['no_kkkd'] = $no_kartu_kredit;
		$data_pasien_iri['nilai_kkkd'] = $dibayar_kartu_cc_debit;
		$data_pasien_iri['persen_kk'] = $charge;
		$data_pasien_iri['biaya_administrasi'] = $biaya_administrasi;
		$data_pasien_iri['total_charge_kkkd'] = $dibayar_kartu_cc_debit * $charge / 100;

		$data_pasien_iri['lunas'] = 1;
		if($pasien[0]['carabayar'] == "DIJAMIN / JAMSOSKES"){
			$data_pasien_iri['lunas'] = 0;
		}

		//print_r($data_pasien_iri);exit;
		// $this->rimpendaftaran->update_pendaftaran_mutasi($, $no_ipd);
		// $this->rimpasien->flag_kwintasi_rad_terbayar(data_pasien_iri$no_ipd);
		// $this->rimpasien->flag_kwintasi_lab_terbayar($no_ipd);
		// $this->rimpasien->flag_kwintasi_obat_terbayar($no_ipd);
		// $this->rimpasien->flag_ird_terbayar($pasien[0]['noregasal'],date("Y:m:d H:m:i"),$data_pasien_iri['lunas']);
		// $this->rimpasien->flag_irj_terbayar($pasien[0]['noregasal'],date("Y:m:d H:m:i"),$data_pasien_iri['lunas']);
		//update ke lab, rad, obat kalo udah pembayaran


		tcpdf();
		$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$tgl_cetak = date("j F Y");
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins('5', '5', '5', '5');
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 9);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();

		if($jenis_bayar == "KREDIT" && ( $dibayar_tunai != 0 || $dibayar_kartu_cc_debit != 0 ) )
		{
			ob_start();
			$content = $konten;
			ob_end_clean();
			$obj_pdf->writeHTML($content, true, false, true, false, '');

			$obj_pdf->AddPage();
			ob_start();
				$content = $konten_kredit;
			ob_end_clean();
			//$obj_pdf->writeHTML($content, true, false, true, false, '');
		}else{
			ob_start();
			$content = $konten;
			ob_end_clean();
			//$obj_pdf->writeHTML($content, true, false, true, false, '');
		}
		//$obj_pdf->Output(FCPATH.'/download/inap/laporan/pembayaran/'.$file_name, 'FI');


	}

	private function string_perusahaan($pasien,$jumlah_dijamin,$penerima,$jenis_pembayaran,$tgl){
		$konten = "";
		$konten = $konten.$this->string_data_pasien_simple($pasien,$jumlah_dijamin,$penerima,$jenis_pembayaran);
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);
		
		$grand_total_string = "
		<br><br><br>
		<table border=\"1\">
			<tr>
				<th colspan=\"6\"><p align=\"left\"><b>Total   </b></p></th>
				<th ><p align=\"right\">Rp. ".number_format( $jumlah_dijamin, 0 )."</p></th>
			</tr>
		</table>
		<br/><br/>
		<table>
			<tr>
				<td></td>
				<td></td>
				<td>$tgl</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>an.Bendaharawan Rumah Sakit</td>
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
				<td>$user</td>
			</tr>
		</table>
		";

		$konten = $konten."<br>".$grand_total_string;
		return $konten;
	}

		//modul cetak laporan simple

	private function string_table_mutasi_ruangan_simple($list_mutasi_pasien,$pasien,$status_paket){
		$konten = "";
		$konten= $konten.'
			<tr>
			  <td align="center" >Ruang</td>
			  <td align="center">Kelas</td>
			  <td align="center">Bed</td>
			  <td align="center">Tgl Masuk</td>
			  <td align="center">Tgl Keluar</td>
			  <td align="center">Lama Inap</td>
			  <td align="center">Total Biaya</td>
			</tr>
		';
		$subtotal = 0;
		$diff = 1;
		$lama_inap = 0;
		$total_subsidi = 0;
		$tgl_indo = new Tglindo();
		$ceknull=0;
		$jasaperawat=0;
		foreach ($list_mutasi_pasien as $r) {

			$bulan_show = $tgl_indo->bulan(substr($r['tglmasukrg'],6,2));
			$tahun_show = substr($r['tglmasukrg'],0,4);
			$tanggal_show = substr($r['tglmasukrg'],8,2);
			$tgl_masuk_rg = $tanggal_show." ".$bulan_show." ".$tahun_show;

			//$tgl_masuk_rg = date("j F Y", strtotime($r['tglmasukrg']));
			if($r['tglkeluarrg'] != null){
				//$tgl_keluar_rg =  date("j F Y", strtotime($r['tglkeluarrg'])) ;

				$bulan_show = $tgl_indo->bulan(substr($r['tglkeluarrg'],6,2));
				$tahun_show = substr($r['tglkeluarrg'],0,4);
				$tanggal_show = substr($r['tglkeluarrg'],8,2);
				$tgl_keluar_rg = $tanggal_show." ".$bulan_show." ".$tahun_show;

			}else{
				if($pasien[0]['tgl_keluar'] != null){
					//$tgl_keluar_rg = date("j F Y", strtotime($pasien[0]['tgl_keluar'])) ;

					$bulan_show = $tgl_indo->bulan(substr($pasien[0]['tgl_keluar'],6,2));
					$tahun_show = substr($pasien[0]['tgl_keluar'],0,4);
					$tanggal_show = substr($pasien[0]['tgl_keluar'],8,2);
					$tgl_keluar_rg = $tanggal_show." ".$bulan_show." ".$tahun_show;
				}else{
					$tgl_keluar_rg = "-" ;
				}	
			}

			if($r['tglkeluarrg'] != null){
				$start = new DateTime($r['tglmasukrg']);//start
				$end = new DateTime($r['tglkeluarrg']);//end

				$diff = $end->diff($start)->format("%a");
				if($diff == 0){
					$diff = 1;
				}
				$selisih_hari =  $diff." Hari"; 
			}else{
				if($pasien[0]['tgl_keluar'] != NULL){
					$start = new DateTime($r['tglmasukrg']);//start
					$end = new DateTime($pasien[0]['tgl_keluar']);//end

					$diff = $end->diff($start)->format("%a");
					if($diff == 0){
						$diff = 1;
					}
					$selisih_hari =  $diff." Hari";
				}else{
					$start = new DateTime($r['tglmasukrg']);//start
					$end = new DateTime(date("Y-m-d"));//end

					$diff = $end->diff($start)->format("%a");
					if($diff == 0){
						$diff = 1;
					}

					$selisih_hari =  "- Hari";
				}
			}

			//untuk perhitungan subsidi, berdasarkan lama inap
			$lama_inap = $lama_inap + $diff;
			$jasaperawat=$jasaperawat+$r['jasa_perawat'];

			if($r['tglkeluarrg']==null || $r['tglkeluarrg']==''){
				$ceknull=1;
			}
			//ambil harga jatah kelas
			// $kelas = $this->rimkelas->get_tarif_ruangan($pasien[0]['jatahklsiri'],$r['idrg']);
			// if(!($kelas)){
			// 	$total_tarif = 0;
			// }else{
			// 	$total_tarif = $kelas[0]['total_tarif'] ;
			// }\
			$total_tarif = $r['harga_jatah_kelas'] ;

			$subsidi_inap_kelas = $diff * $total_tarif ;//harga permalemnya berapa kalo ada jatah kelas
			$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

			//kalo paket 2 hari inep free
			/*if($status_paket == 1){
				$temp_diff = $diff - 2;//kalo ada paket free 2 hari
				if($temp_diff < 0){
					$temp_diff = 0;
				}
				$total_per_kamar = $r['vtot'] * $temp_diff;
			}else{*/
				$total_per_kamar = $r['vtot'] * $diff;
			//}

			$subtotal = $subtotal + $total_per_kamar;
			$konten = $konten. "
			<tr>
				<td align=\"center\">".$r['nmruang']."</td>
				<td align=\"center\">".$r['kelas']."</td>
				<td align=\"center\">".$r['bed']."</td>
				<td align=\"center\">".$tgl_masuk_rg."</td>
				<td align=\"center\">".$tgl_keluar_rg."</td>
				<td align=\"center\">".$selisih_hari."</td>
				<td align=\"right\">Rp. ".number_format($total_per_kamar,0)."</td>
			</tr>
			";
		}

		$result = array('konten' => $konten,
					'subtotal' => $subtotal,
					'subsidi' => $total_subsidi,
					'jasaperawat' => $jasaperawat,
					'ceknull' => $ceknull);
		return $result;
	}

	private function string_table_tindakan_simple($list_tindakan_pasien){
		$konten = "";
		
		$subtotal = 0;

		$subtotal_jth_kelas = 0;
		foreach ($list_tindakan_pasien as $r) {
			$subtotal = $subtotal + $r['tumuminap'] + $r['tarifalkes'];
			$tumuminap = number_format($r['tumuminap'],0);
			$vtot = number_format($r['vtot'],0);

			$subtotal_jth_kelas = $subtotal_jth_kelas + $r['vtot_jatah_kelas'];
			$harga_satuan_jatah_kelas = number_format($r['harga_satuan_jatah_kelas'],0);
			$vtot_jatah_kelas = number_format($r['vtot_jatah_kelas'],0);
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" >Subtotal Tindakan Rawat Inap</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		$result = array('konten' => $konten,
					'subtotal' => $subtotal,
					'subsidi' => $subtotal_jth_kelas);
		return $result;
	}

	private function string_table_radiologi_simple($list_radiologi){
		$konten = "";
		$subtotal = 0;
		foreach ($list_radiologi as $r) {
			$subtotal = $subtotal + $r['vtot'];
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" align="left">Subtotal Radiologi</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_lab_simple($list_lab_pasien){
		$konten = "";
		$subtotal = 0;
		foreach ($list_lab_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_lab = number_format($r['biaya_lab'],0);
			$vtot = number_format($r['vtot'],0);
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" align="left">Subtotal Laboratorium</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
	
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_ok_simple($list_ok_pasien){
		$konten = "";
		$subtotal = 0;
		foreach ($list_ok_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			// $biaya_ok = number_format($r['biaya_ok'],0);
			// $vtot = number_format($r['vtot'],0);
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" align="left">Subtotal Operasi</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
	
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_pa_simple($list_pa_pasien){
		$konten = "";
		$subtotal = 0;
		foreach ($list_pa_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_pa = number_format($r['biaya_pa'],0);
			$vtot = number_format($r['vtot'],0);
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" align="left">Subtotal Patologi Anatomi</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
	
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_resep_simple($list_resep){
		$konten = "";
		
		$subtotal = 0;
		foreach ($list_resep as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$vtot = number_format($r['vtot'],0) ;
			
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" align="left">Subtotal Obat</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_ird_simple($list_tindakan_ird){
		$konten = "";
		
		$subtotal = 0;
		foreach ($list_tindakan_ird as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_ird = number_format($r['biaya_ird'],0);
			$vtot = number_format($r['vtot'],0);
			
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" align="left">Subtotal Rawat Darurat</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_irj_simple($poli_irj){
		$konten = "";
		
		$subtotal = 0;
		foreach ($poli_irj as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_tindakan = number_format($r['biaya_tindakan'],0);
			$vtot = number_format($r['vtot'],0);
			
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" >Subtotal Rawat Jalan</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';

		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}
	//end modul cetak laporan simple

	public function cetak_list_pembayaran_pasien($no_ipd='',$status=''){

		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		//kamari
		// if($pasien[0]['cetak_kwitansi'] != '1'){
		// 	$string_close_windows = "window.open('', '_self', ''); window.close();";
		// 	echo 'Kwintasi Harus Dicetak Terlebih Dahulu <button type="button" 
		  //       onclick="'.$string_close_windows.'">Kembali</button>';
		  //       	exit;
		// }
		//end 

		//list tidakan, mutasi, dll
				
		// $konten = $this->string_data_pasien($pasien,$grand_total,$penerima,'').$konten;
		if($status=='0'){

			//oksigen
			$list_oksigen = $this->rimtindakan->get_list_oksigen_pasien_by_no_ipd($no_ipd);
			$list_tindakan_dokter_pasien = $this->rimtindakan->get_list_tindakan_dokter_pasien_by_no_ipd($no_ipd);
			//ICU
			$list_tindakan_icu_pasien = $this->rimtindakan->get_list_tindakan_icu_pasien_by_no_ipd_new($no_ipd);

			$list_tindakan_perawat_pasien = $this->rimtindakan->get_list_tindakan_perawat_pasien_by_no_ipd($no_ipd);
			$list_tindakan_matkes_pasien = $this->rimtindakan->get_list_tindakan_matkes_pasien_by_no_ipd($no_ipd);
			$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
			$status_paket = 0;
			$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
			
			if(($data_paket)){
				$status_paket = 1;
			}
			$list_ok_pasien = $this->rimpasien->get_list_tind_ok_pasien($no_ipd,$pasien[0]['noregasal']);
			$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd,$pasien[0]['noregasal']);

			$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd,$pasien[0]['noregasal']);
			//radiologi
			$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$pasien[0]['noregasal']);//belum ada no_register		

			$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd,$pasien[0]['noregasal']);
			$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
			$poli_irj = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);

			$nama_pasien = str_replace(" ","_",$pasien[0]['nama']);
			$file_name = "pembayaran_".$pasien[0]['no_ipd']."_".$nama_pasien." .pdf";

			$konten = "";
			
			$konten = $konten.'<br><br><br><table border="1">';

			$jasa_total =0;
			$grand_total = 0;
			$subsidi_total = 0;
			$total_alkes = 0;
			$mutasicount= 0;
			$ceknull=0;

		//mutasi ruangan pasien
		if(($list_mutasi_pasien)){
			$result = $this->string_table_mutasi_ruangan($list_mutasi_pasien,$pasien,$status_paket);
			$grand_total = $grand_total + $result['subtotal'];
			$jasa_total = $jasa_total + $result['jasaperawat'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			$ceknull=$result['ceknull'];
			$mutasicount= $mutasicount+1;
			$konten = $konten.$result['konten'];
		}
		$biaya_kamar=$grand_total;
		
		if($ceknull==1){
			if($pasien[0]['nmruang']=='Ruang ICU'){
					$jasa_perawat=(double)$total_per_kamar * ((double)20/100);
				}else{
					$detailjasa=$this->rimpasien->get_detail_kelas($pasien[0]['kelas'])->row();	
					$jasa_perawat=((double) $biaya_kamar * ((double)$detailjasa->persen_jasa/100))+$jasa_total;
				}
			
		}else 
			$jasa_perawat=$jasa_total;		

		if(($list_tindakan_icu_pasien)){
			$result = $this->string_table_icu($list_tindakan_icu_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$vtoticu = $result['subtotal'];
			//$vtotkamaricu=$result['subtotalruang'];
			//$total_alkes = $total_alkes + $result['subtotal_tind'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			$konten = $konten.$result['konten'];
			//$matkes=$result['subtotal'];
			//print_r($konten);exit;
		}
		//tindakan
		if(($list_tindakan_dokter_pasien)){
			$result = $this->string_table_tindakan_dokter($list_tindakan_dokter_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			$konten = $konten.$result['konten'];
			//print_r($konten);exit;
		}
		//tindakan
		$vtotoksigen=0;
		if(($list_oksigen)){ //harus Pelaksana Rumah Sakit
			$result = $this->string_table_tindakan($list_oksigen);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten."
			<table border=\"1\">
			<tr>
				<td colspan=\"7\">Oksigen (O2)</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr></table>
			";
			$vtotoksigen=$result['subtotal'];
		}
		$tind_perawat=0;
		if(($list_tindakan_perawat_pasien)){
			$result = $this->string_table_tindakan($list_tindakan_perawat_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			//$konten = $konten.$result['konten'];
			$tind_perawat=$result['subtotal'];
			//print_r($konten);exit;
		}
		$matkes=0;
		if(($list_tindakan_matkes_pasien)){
			$result = $this->string_table_tindakan($list_tindakan_matkes_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			//$konten = $konten.$result['konten'];
			$matkes=$result['subtotal'];
			//print_r($konten);exit;
		}

		//radiologi
		if(($list_radiologi)){
			$result = $this->string_table_radiologi($list_radiologi);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten."
			<tr>
				<td colspan=\"7\">Total Pembayaran Diagnostik</td>
				<td> ".number_format($result['subtotal'],0)."</td>
			</tr>
			";
			//$konten = $konten.$result['konten'];
		}		

		//operasi
		if(($list_ok_pasien)){
			$result = $this->string_table_operasi($list_ok_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten."
			<tr>
				<td colspan=\"7\">Total Tindakan Operasi</td>
				<td> ".number_format($result['subtotal'],0)."</td>
			</tr>
			";
			//$konten = $konten.$result['konten'];
		}

		//operasi
		if(($list_matkes_ok_pasien)){
			$result = $this->string_table_operasi($list_matkes_ok_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten."
			<tr>
				<td colspan=\"7\">Matkes Operasi</td>
				<td> ".number_format($result['subtotal'],0)."</td>
			</tr>
			";
			//$konten = $konten.$result['konten'];
		}		

		//lab
		if(($list_lab_pasien)){
			$result = $this->string_table_lab($list_lab_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten."
			<tr>
				<td colspan=\"7\">Total Pembayaran Laboratorium</td>
				<td> ".number_format($result['subtotal'],0)."</td>
			</tr>
			";
			// $konten = $konten.$result['konten'];
		}

		//resep
		if(($list_resep)){
			$result = $this->string_table_resep($list_resep);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten."
			<tr>
				<td colspan=\"7\">Total Pembayaran Resep</td>
				<td> ".number_format($result['subtotal'],0)."</td>
			</tr>
			";
			//$konten = $konten.$result['konten'];
		}

		//ird
		/*if(($list_tindakan_ird)){
			$result = $this->string_table_ird($list_tindakan_ird);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten."
			<tr>
				<td colspan=\"6\">Total Pembayaran Rawat Darurat</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";
			//$konten = $konten.$result['konten'];
		}*/

		//irj
		if(($poli_irj)){
			$result = $this->string_table_irj($poli_irj);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten."
			<tr>
				<td colspan=\"7\">Total Pembayaran Rawat Jalan</td>
				<td> ".number_format($result['subtotal'],0)."</td>
			</tr>
			";
			//$konten = $konten.$result['konten'];
		}
		

		//biaya_administrasi
		/*$biaya_administrasi= (double) $grand_total * 0.1;
		if($biaya_administrasi<=50000){
			$fix_adm=50000;
		}else if($biaya_administrasi>=750000 && $pasien[0]['carabayar']=='UMUM'){
			$fix_adm=750000;
		}else{
			$fix_adm=$biaya_administrasi;
		}*/

			//1B0103
		$detailtind=$this->rimpasien->get_detail_tindakan('1B0103',$pasien[0]['kelas'])->row();		
		
			//$data['dijamin']=$this->input->post('dijamin');
			$biaya_daftar=(int) $detailtind->total_tarif+(int)$detailtind->tarif_alkes;
		$konten = $konten."
		<table border=\"1\">
			<tr>
				<td colspan=\"7\">Sewa Alat</td>
				<td><p> ".number_format( $total_alkes, 0)."</p></td>
			</tr>			
			<tr>
				<td colspan=\"7\">Biaya Materai</td>
				<td> ".number_format(6000,0)."</td>
			</tr>
			<tr>
				<td colspan=\"7\">Biaya Pendaftaran</td>
				<td> ".number_format($biaya_daftar,0)."</td>
			</tr>
			</table>
			";

			/*<tr>
				<td colspan=\"7\">Tindakan Perawat</td>
				<td> ".number_format($tind_perawat,0)."</td>
			</tr>			
			<tr>
				<td colspan=\"7\">Matkes Ruang Rawat</td>
				<td> ".number_format($matkes,0)."</td>
			</tr>
			<tr>
				<td colspan=\"7\">Jasa Keperawatan</td>
				<td> ".number_format($jasa_perawat,0)."</td>
			</tr>
			<tr>
				<td colspan=\"7\">Biaya Administrasi</td>
				<td> ".number_format($fix_adm,0)."</td>
			</tr>*/
		$grand_total = (double) $grand_total + 6000 + (double) $biaya_daftar;
			$konten = $this->string_data_pasien_sementara($pasien,$grand_total,"",'').$konten;
		}else{
			//status!=0

		$list_tindakan_pasien = $this->rimtindakan->get_list_sumtindakan_pasien_by_no_ipd($no_ipd);	
		$list_dokter= $this->rimpasien->get_patient_doctor($no_ipd);	
		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		$status_paket = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if(($data_paket)){
			$status_paket = 1;
		}
		$list_ok_pasien = $this->rimpasien->get_list_tind_ok_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd,$pasien[0]['noregasal']);
		
		if($pasien[0]['carabayar']=='UMUM'){
			$list_lab_pasien = $this->rimpasien->get_list_all_lab_pasien($no_ipd);
			$list_radiologi = $this->rimpasien->get_list_all_radiologi_pasien($no_ipd);//belum ada no_register
			$list_resep = $this->rimpasien->get_list_all_resep_pasien($no_ipd);
			$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
			$poli_irj = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);
		}else{
			$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd,$pasien[0]['noregasal']);
			//radiologi
			$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$pasien[0]['noregasal']);
			$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd,$pasien[0]['noregasal']);
			$list_tindakan_ird = "";
			$poli_irj = "";
		}
		

		$nama_pasien = str_replace(" ","_",$pasien[0]['nama']);
		$file_name = "detail_pembayaran_".$pasien[0]['no_ipd']."_".$nama_pasien."_faktur.pdf";


		$konten = "";

		
		$konten = $konten.'<br><br><br>';

		$grand_total = 0;
		$subsidi_total = 0;
		$total_alkes = 0;
		$mutasicount= 0;
		$ceknull=0;
		$jasa_total=0;
		//mutasi ruangan pasien
		if(($list_mutasi_pasien)){
			$result = $this->string_table_mutasi_ruangan($list_mutasi_pasien,$pasien,$status_paket);
			$grand_total = $grand_total + $result['subtotal'];
			$jasa_total = $jasa_total + $result['jasaperawat'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			$ceknull=$result['ceknull'];
			$mutasicount= $mutasicount+1;
			$konten = $konten.$result['konten'];
		}
		$biaya_kamar=$grand_total;		
		
		//tindakan
		if(($list_tindakan_pasien)){
			$result = $this->string_table_tindakan_faktur($list_tindakan_pasien,$list_dokter);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			$konten = $konten.$result['konten'];
			//print_r($konten);exit;
		}
		/*$tind_perawat=0;
		if(($list_tindakan_perawat_pasien)){
			$result = $this->string_table_tindakan($list_tindakan_perawat_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			//$konten = $konten.$result['konten'];
			$tind_perawat=$result['subtotal'];
			//print_r($konten);exit;
		}
		$matkes=0;
		if(($list_tindakan_matkes_pasien)){
			$result = $this->string_table_tindakan($list_tindakan_matkes_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			//$konten = $konten.$result['konten'];
			$matkes=$result['subtotal'];
			//print_r($konten);exit;
		}*/

		//radiologi
		if(($list_radiologi)){
			$result = $this->string_table_radiologi($list_radiologi);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten.$result['konten'];
			/*$konten = $konten."
			<tr>
				<td colspan=\"3\">Total Pembayaran Radiologi</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";*/
			//$konten = $konten.$result['konten'];
		}

		//operasi
		if(($list_ok_pasien)){
			$result = $this->string_table_operasi($list_ok_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten.$result['konten'];
			/*$konten = $konten."
			<tr>
				<td colspan=\"3\">Total Tindakan Operasi</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";*/
			//
		}

		//operasi
		if(($list_matkes_ok_pasien)){
			$result = $this->string_table_operasi($list_matkes_ok_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten.$result['konten'];
			/*$konten = $konten."
			<tr>
				<td colspan=\"3\">Matkes Operasi</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";*/
			//$konten = $konten.$result['konten'];
		}
		
		//lab
		if(($list_lab_pasien)){
			$result = $this->string_table_lab($list_lab_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten.$result['konten'];
			/*$konten = $konten."
			<tr>
				<td colspan=\"3\">Total Pembayaran Laboratorium</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";*/
			// $konten = $konten.$result['konten'];
		}

		//resep
		if(($list_resep)){
			$result = $this->string_table_resep($list_resep);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten.$result['konten'];
			/*$konten = $konten."
			<tr>
				<td colspan=\"3\">Total Pembayaran Resep</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";*/
			//$konten = $konten.$result['konten'];
		}

		//ird
		/*if(($list_tindakan_ird)){
			$result = $this->string_table_ird($list_tindakan_ird);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten."
			<tr>
				<td colspan=\"6\">Total Pembayaran Rawat Darurat</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";
			//$konten = $konten.$result['konten'];
		}*/

		//irj
		if(($poli_irj)){
			$result = $this->string_table_irj($poli_irj);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten.$result['konten'];
			/*$konten = $konten."
			<tr>
				<td colspan=\"3\">Total Pembayaran Rawat Jalan</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";*/
			//$konten = $konten.$result['konten'];
		}
		
			//1B0103
		$detailtind=$this->rimpasien->get_detail_tindakan('1B0103',$pasien[0]['kelas'])->row();		
		
			//$data['dijamin']=$this->input->post('dijamin');<tr>
			//	<td colspan=\"7\">Tindakan Perawat</td>
			//	<td>Rp. ".number_format($tind_perawat,0)."</td>
			//</tr>
			/*<tr>
				<td colspan=\"6\">Matkes Ruang Rawat</td>
				<td>Rp. ".number_format($pasien[0]['matkes_iri'],0)."</td>
			</tr>*/
		if($status=='0'){
			$span='7';
		}else{
			$span='7';
		}

			$biaya_daftar=(int) $detailtind->total_tarif+(int)$detailtind->tarif_alkes;
		$konten = $konten."		
		<table border=\"1\">
			<tr>
				<td colspan=\"".$span."\">Sewa Alat</td>
				<td><p>Rp. ".number_format( $total_alkes, 0)."</p></td>
			</tr>			
			<tr>
				<td colspan=\"".$span."\">Biaya Materai</td>
				<td>Rp. ".number_format(6000,0)."</td>
			</tr>
			<tr>
				<td colspan=\"".$span."\">Biaya Pendaftaran</td>
				<td>Rp. ".number_format($pasien[0]['biaya_daftar'],0)."</td>
			</tr>
			";
			/*<tr>
				<td colspan=\"".$span."\">Jasa Keperawatan</td>
				<td>Rp. ".number_format($pasien[0]['jasaperawat'],0)."</td>
			</tr>
			<tr>
				<td colspan=\"".$span."\">Biaya Administrasi</td>
				<td>Rp. ".number_format($pasien[0]['biaya_administrasi'],0)."</td>
			</tr>*/

		$grand_total = (double) $grand_total + 6000 + (double) $pasien[0]['biaya_daftar'];
			$konten = $this->string_data_pasien_faktur($pasien,$grand_total,"",'').$konten;
		}
		
		//$tgl = date("Y-m-d");
		$tgl = date('d F Y');

		$cterbilang= new rjcterbilang();
		// $vtot_terbilang=$cterbilang->terbilang($grand_total-$subsidi_total-$pasien[0]['diskon']);
		$vtot_terbilang=$cterbilang->terbilang($grand_total,1);
		$nomimal_charge = $pasien[0]['nilai_kkkd'] * $pasien[0]['persen_kk'] / 100;
		// $grand_total_string = "
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Dibayar Tunai   </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $pasien[0]['tunai'], 0 )."</p></th>
		// 	</tr>
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Dibayar Kartu Kredit / Debit   </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $pasien[0]['nilai_kkkd'], 0 )."</p></th>
		// 	</tr>
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Charge % </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".$pasien[0]['persen_kk']."</p></th>
		// 	</tr>
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Nominal Charge   </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $nomimal_charge, 0 )."</p></th>
		// 	</tr>
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Diskon   </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $pasien[0]['diskon'], 0 )."</p></th>
		// 	</tr>
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Total   </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $grand_total-$subsidi_total-$pasien[0]['diskon'], 0)."</p></th>
		// 	</tr>
		// </table>
		// <br/><br/>
		// Terbilang<br>
		// ".strtoupper($vtot_terbilang)."
		// <br/><br/>
		// <table>
		// 	<tr>
		// 		<td></td>
		// 		<td></td>
		// 		<td>$tgl</td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 		<td></td>
		// 		<td>an.Kepala Rumah Sakit</td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 		<td></td>
		// 		<td>K a s i r</td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 		<td></td>
		// 		<td>----------------------------------------</td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 		<td></td>
		// 		<td>ADMIN</td>
		// 	</tr>
		// </table>
		// ";

		// $konten = "<table style=\"padding:4px;\" border=\"0\">
		// 				<tr>
		// 					<td>
		// 						<p align=\"center\">
		// 							<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\" >
		// 						</p>
		// 					</td>
		// 				</tr>
		// 			</table>
		// 			<hr><br/><br/>".$konten.$grand_total_string;

		$biaya_adm = $pasien[0]['biaya_administrasi'];
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if(($data_paket)){
			$status_paket = 1;
		}


		/*if($biaya_adm == "" && $status_paket == 0){
			$biaya_adm = $grand_total * 5 / 100;
			$grand_total = $grand_total + $biaya_adm;
		}*/

		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);
		/*<tr>
				<th colspan=\"6\"><p><b>Biaya Administrasi   </b></p></th>
				<th><p>Rp. ".number_format( $biaya_adm, 0)."</p></th>
			</tr>*/
		if($status=='0'){
			$span='7';
		}else{
			$span='7';
		}
		
		$grand_total_string = "	
			<tr>
				<th colspan=\"".$span."\"><p><b>Denda Terlambat</b></p></th>
				<th><p>Rp. ".number_format( $pasien[0]['denda_terlambat'], 0)."</p></th>
			</tr>					
			<tr>
				<th colspan=\"".$span."\"><p><b>Total Biaya</b></p></th>
				<th><p>Rp. ".number_format( $grand_total+$pasien[0]['denda_terlambat'], 0)."</p></th>
			</tr>
		</table>
		<br><br><br>
		<table>
			<tr>
				<td></td>
				<td></td>
				<td>$tgl</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>an.Bendaharawan Rumah Sakit</td>
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
				<td>$user</td>
			</tr>
		</table>
		";

		$konten = $konten.$grand_total_string;

		// $konten = "";


		// $konten = $konten.$this->string_data_pasien($pasien,0,'');

		// $grand_total = 0;
		// //mutasi ruangan pasien
		// if(($list_mutasi_pasien)){
		// 	$result = $this->string_table_mutasi_ruangan($list_mutasi_pasien,$pasien);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }


		// //tindakan
		// if(($list_tindakan_pasien)){
		// 	$result = $this->string_table_tindakan($list_tindakan_pasien);
		// 	$grand_total = $grand_total + $result['subtotal'];

		// 	$konten = $konten.$result['konten'];
		// 	//print_r($konten);exit;
		// }

		// //radiologi
		// if(($list_radiologi)){
		// 	$result = $this->string_table_radiologi($list_radiologi);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }

		// //lab
		// if(($list_lab_pasien)){
		// 	$result = $this->string_table_lab($list_lab_pasien);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }

		// //resep
		// if(($list_resep)){
		// 	$result = $this->string_table_resep($list_resep);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }

		// //ird
		// if(($list_tindakan_ird)){
		// 	$result = $this->string_table_ird($list_tindakan_ird);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }

		// //irj
		// if(($poli_irj)){
		// 	$result = $this->string_table_irj($poli_irj);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }

		// $grand_total_string = '
		// <table border="1">
		// 	<tr>
		// 		<td colspan="6" align="center">Grand Total</td>
		// 		<td align="right">Rp. '.number_format($grand_total,0).'</td>
		// 	</tr>
		// </table>
		// ';

		// $konten = '<table style=\"padding:4px;\" border=\"0\">
		// 				<tr>
		// 					<td>
		// 						<p align=\"center\">
		// 							<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\" >
		// 						</p>
		// 					</td>
		// 				</tr>
		// 			</table>
		// 			<hr><br/><br/>'.$konten.$grand_total_string;

		tcpdf();
		//echo $konten;
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "Faktur Rawat Inap - ".$no_ipd." - ".$pasien[0]['nama'];
		$tgl_cetak = date("j F Y");
		$obj_pdf->SetTitle($title);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins('5', '5', '5', '5');
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 9);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();

		// $obj_pdf = new TCPDF('P', PDF_UNIT, 'A5', true, 'UTF-8', false);
		// $obj_pdf->SetCreator(PDF_CREATOR);
		// $title = "Rincian Biaya Rawat Inap - ".$no_ipd." - ".$pasien[0]['nama'];
		// $tgl_cetak = date("j F Y");
		// $obj_pdf->SetTitle($file_name);
		// $obj_pdf->SetHeaderData('', '', $title, 'Tanggal Cetak - '.$tgl_cetak);
		// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		// $obj_pdf->SetDefaultMonospacedFont('helvetica');
		// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		// $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		// $obj_pdf->SetMargins('5', '5', '5', '5');
		// $obj_pdf->setPrintHeader(false);
		// $obj_pdf->setPrintFooter(false);
		// $obj_pdf->SetAutoPageBreak(TRUE, '5');
		// $obj_pdf->SetFont('helvetica', '', 10);
		// $obj_pdf->setFontSubsetting(false);
		// $obj_pdf->AddPage();
		ob_start();
			$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'/download/inap/laporan/pembayaran/'.$file_name, 'FI');
	}

	//modul cetak laporan detail



	//COBA COBA

	public function cetak_list_pembayaran_pasien_simple2(){
		$no_ipd = $this->input->post('no_ipd');
		$penerima = $this->input->post('penerima');
		$diskon = $this->input->post('diskon');
		$vtotdenda = $this->input->post('denda');
		$obat = $this->input->post('biaya_obat');
		//echo $diskon;
		$dibayar_tunai = (int)$this->input->post('dibayar_tunai')+(int)$this->input->post('denda');
		//$dibayar_kartu_cc_debit = $this->input->post('dibayar_kartu_cc_debit');
		//$charge = $this->input->post('charge');
		//$no_kartu_kredit = $this->input->post('no_kartu_kredit');
		//$nomimal_charge = $dibayar_kartu_cc_debit * $charge / 100;
		$biaya_administrasi = $this->input->post('biaya_administrasi');
		$jasa_perawat = $this->input->post('jasa_perawat');
		$biaya_materai = $this->input->post('biaya_materai');
		$biaya_daftar = $this->input->post('biaya_daftar');

		$jenis_pembayaran = $this->input->post('jenis_pembayaran');

		if(!($diskon) || $diskon == ''){
			$diskon = 0;
		}

		if(!($vtotdenda) || $vtotdenda==''){
			$vtotdenda=0;
		}

		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		//print_r($no_ipd);
		//kamari
		// if($pasien[0]['cetak_kwitansi'] != '1'){
		// 	$string_close_windows = "window.open('', '_self', ''); window.close();";
		// 	echo 'Kwintasi Harus Dicetak Terlebih Dahulu <button type="button" 
  //       onclick="'.$string_close_windows.'">Kembali</button>';
  //       	exit;
		// }
		//end 

		//list tidakan, mutasi, dll
		$list_tindakan_dokter_pasien = $this->rimtindakan->get_list_tindakan_dokter_pasien_by_no_ipd_kw($no_ipd);
		//$list_tindakan_perawat_pasien = $this->rimtindakan->get_list_tindakan_perawat_pasien_by_no_ipd($no_ipd);

		$list_tindakan_perawat_pasien = $this->rimtindakan->get_list_tindakan_perawat_pasien_by_no_ipd_kw($no_ipd);

		$list_tindakan_perawat_ruang_pasien = $this->rimtindakan->get_list_tindakan_perawat_ruang_pasien_by_no_ipd($no_ipd);
		//matkes ruang
		$list_tindakan_matkes_pasien = $this->rimtindakan->get_list_tindakan_matkes_pasien_by_no_ipd($no_ipd);
		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);

		//Ruang ICU VK
		$list_tindakan_ruang_pasien = $this->rimtindakan->get_list_ruang_pasien_by_no_ipd($no_ipd);
		//$list_tindakan_icu_pasien = $this->rimtindakan->get_list_tindakan_icu_pasien_by_no_ipd($no_ipd);
		

		//new
		//VK
		$list_tindakan_vk_pasien = $this->rimtindakan->get_list_tindakan_vk_pasien_by_no_ipd_kw($no_ipd);
		//ICU
		$list_tindakan_icu_pasien = $this->rimtindakan->get_list_tindakan_icu_pasien_by_no_ipd_new($no_ipd);
		
		//oksigen
		$list_oksigen = $this->rimtindakan->get_list_oksigen_pasien_by_no_ipd($no_ipd);

		//matkes ICU matkes VK
		$list_tindakan_matkes_icu_pasien = $this->rimtindakan->get_list_tindakan_matkes_icu_pasien_by_no_ipd($no_ipd);
		$list_tindakan_matkes_vk_pasien = $this->rimtindakan->get_list_tindakan_matkes_vk_pasien_by_no_ipd($no_ipd);

		$status_paket = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if(($data_paket)){
			$status_paket = 1;
		}
		$list_ok = $this->rimpasien->get_list_ok_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_ok_pasien = $this->rimpasien->get_list_tind_ok_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_matkes_ok_pasien = $this->rimpasien->get_list_matkes_ok_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_pa_pasien = $this->rimpasien->get_list_pa_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$pasien[0]['noregasal']);//belum ada no_register

		//usg
		$list_usg_radiologi = $this->rimpasien->get_list_usg_pasien($no_ipd,$pasien[0]['noregasal']);

		$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
		$poli_irj_dokter = $this->rimpasien->get_list_poli_rj_dokter_pasien($pasien[0]['noregasal']);
		$poli_irj_perawat = $this->rimpasien->get_list_poli_rj_perawat_pasien($pasien[0]['noregasal']);

		$nama_pasien = str_replace(" ","_",$pasien[0]['nama']);
		$file_name = "detail_pembayaran_".$pasien[0]['no_ipd']."_".$nama_pasien." .pdf";

		$konten = "";
		$konten0 = "";

		
		$konten0 = $konten0.'<style type=\"text/css\">
			
			.table-isi th{
			border-bottom: 1px solid #ddd;
			}
			.table-isi td{
			border-bottom: 1px solid #ddd;
			}
			</style>
		<br><br><br><table border="1">';

		$grand_total = 0;
		$subsidi_total = 0;
		$total_alkes = 0;
		$mutasicount= 0;
		$vtotruang=0;
		$ceknull=0;$jasa_total=0;
		//mutasi ruangan pasien
		if(($list_mutasi_pasien)){
			$result = $this->string_table_mutasi_ruangan($list_mutasi_pasien,$pasien,$status_paket);
			$grand_total = $grand_total + $result['subtotal'];
			$jasa_total = $jasa_total + $result['jasaperawat'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			$vtotruang=$result['subtotal_ruang'];			
			$vtoticu=$result['subtotal_icu'];
			$ceknull=$result['ceknull'];
			$mutasicount= $mutasicount+1;
			$konten = $konten.$result['konten'];
		}
		$jasa_perawat=$jasa_total;		

		$biaya_kamar=$grand_total;
		$vtotkamarvk=0;
		$list_tindakan_vk_kamar = $this->rimtindakan->get_vk_room($no_ipd);
		$result = $this->string_table_mutasi_ruangan_vk($list_tindakan_vk_kamar,$pasien,$status_paket);
		$vtotkamarvk=$result['subtotalvk'];
		$grand_total = $grand_total +$vtotkamarvk;
		$trvk=$result['konten'];

		//vk
		$vtotvk=0;
		if(($list_tindakan_vk_pasien)){
			$result = $this->string_table_vk_kw($list_tindakan_vk_pasien,$trvk,$vtotkamarvk);
			$vtotvk = $vtotvk+$result['subtotal'];
			$grand_total = $grand_total + $result['subtotal'];	
			//$vtotkamarvk=$result['subtotalruang'];
			//$total_alkes = $total_alkes + $result['subtotal_tind'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			$konten = $konten.$result['konten'];
			//$matkes=$result['subtotal'];
			//print_r($konten);exit;
		}

		//operasi		
		if(($list_ok)){
			$result = $this->string_table_operasi_kw($list_ok);
			//$grand_total = $grand_total + $result['subtotal'];	
			$vtotok=$result['subtotal'];
			/*$konten = $konten."
			<tr>
				<td colspan=\"7\">Total Tindakan Operasi</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";*/
			$konten = $konten.$result['konten'];
		}

		$vtotok=0;
		if(($list_ok_pasien)){
			$result = $this->string_table_operasi($list_ok_pasien);
			$grand_total = $grand_total + $result['subtotal'];	
			$vtotok=$result['subtotal'];
			/*$konten = $konten."
			<tr>
				<td colspan=\"7\">Total Tindakan Operasi</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";*/
			//$konten = $konten.$result['konten'];
		}

		//operasi
		$matkesok=0;
		if(($list_matkes_ok_pasien)){
			$result = $this->string_table_operasi($list_matkes_ok_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$matkes_ok=$result['subtotal'];
			$matkesok=$result['subtotal'];
			/*$konten = $konten."
			<tr>
				<td colspan=\"7\">Matkes Operasi</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";*/
			//$konten = $konten.$result['konten'];
		}

		//tindakan
		$vtotmedis=0;
		if(($list_tindakan_dokter_pasien)){
			$result = $this->string_table_tindakan_dokter_kw($list_tindakan_dokter_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$vtotmedis=$result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			$konten = $konten.$result['konten'];
			//print_r($konten);exit;
		}

		
		
//echo $konten;
		$vtotparamedis=0;
		if(($list_tindakan_perawat_ruang_pasien)){
			$result = $this->string_table_tindakan($list_tindakan_perawat_ruang_pasien);
			//$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			//$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			//$konten = $konten.$result['konten'];
			$vtotparamedis=$result['subtotal'];
			//print_r($konten);exit;
		}

		$matkes=0;
		if(($list_tindakan_matkes_pasien)){
			$result = $this->string_table_tindakan($list_tindakan_matkes_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			//$konten = $konten.$result['konten'];
			$matkes=$result['subtotal'];
			//print_r($konten);exit;
		}

		$matkesicu=0;
		if(($list_tindakan_matkes_icu_pasien)){
			$result = $this->string_table_tindakan($list_tindakan_matkes_icu_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			//$konten = $konten.$result['konten'];
			$matkesicu=$result['subtotal'];
			//print_r($konten);exit;
		}

		$matkesvk=0;
		if(($list_tindakan_matkes_vk_pasien)){
			$result = $this->string_table_tindakan($list_tindakan_matkes_vk_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			//$konten = $konten.$result['konten'];
			$matkesvk=$result['subtotal'];
			//print_r($konten);exit;
		}

		//$list_tindakan_icu_pasien = $this->rimtindakan->get_list_tindakan_icu_pasien_by_no_ipd($no_ipd);
		//$list_tindakan_vk_pasien = $this->rimtindakan->get_list_tindakan_vk_pasien_by_no_ipd($no_ipd);

		//ruang
		$vtotruang=0;
		if(($list_tindakan_ruang_pasien)){
			$result = $this->string_table_ruang($list_tindakan_ruang_pasien);
			//$vtotruang = $result['subtotal'];
			//$total_alkes = $total_alkes + $result['subtotal_tind'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			//$konten = $konten.$result['konten'];
			//$matkes=$result['subtotal'];
			//print_r($konten);exit;
		}

		//icu
		$vtotkamaricu=0;
		$vtoticu=0;
		if(($list_tindakan_icu_pasien)){
			$result = $this->string_table_icu_kw($list_tindakan_icu_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$vtoticu = $result['subtotal'];
			//$vtotkamaricu=$result['subtotalruang'];
			//$total_alkes = $total_alkes + $result['subtotal_tind'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			$konten = $konten.$result['konten'];
			//$matkes=$result['subtotal'];
			//print_r($konten);exit;
		}
		

		//radiologi
		$vtotrad=0;
		if(($list_radiologi)){
			$result = $this->string_table_radiologi($list_radiologi);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten."<table class=\"table-isi\" border=\"0\">
			<tr>
				<td colspan=\"7\">Total Pembayaran Radiologi</td>
				<td> ".number_format($result['subtotal'],0)."</td>
			</tr></table>
			";
			$vtotrad=$result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//usg
		$vtotusg=0;
		if(($list_usg_radiologi)){
			$result = $this->string_table_radiologi($list_usg_radiologi);
			$grand_total = $grand_total + $result['subtotal'];
			$vtotusg=$result['subtotal'];
			$konten = $konten."<table class=\"table-isi\" border=\"0\">
			<tr>
				<td colspan=\"7\">Total Pembayaran USG Radiologi</td>
				<td> ".number_format($result['subtotal'],0)."</td>
			</tr></table>
			";
			$vtotrad=$result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//pa
		$vtotpa=0;
		if(($list_pa_pasien)){
			$result = $this->string_table_pa($list_pa_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten."<table class=\"table-isi\" border=\"0\">
			<tr>
				<td colspan=\"7\">Total Pembayaran Patologi Anatomi</td>
				<td> ".number_format($result['subtotal'],0)."</td>
			</tr></table>
			";
			$vtotpa=$result['subtotal'];
			//$konten = $konten.$result['konten'];
		}

		//lab
		$vtotlab=0;
		if(($list_lab_pasien)){
			$result = $this->string_table_lab($list_lab_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten."<table class=\"table-isi\" border=\"0\">
			<tr>
				<td colspan=\"7\">Total Pembayaran Laboratorium</td>
				<td> ".number_format($result['subtotal'],0)."</td>
			</tr></table>
			";
			$vtotlab=$result['subtotal'];
			// $konten = $konten.$result['konten'];
		}

		//resep
		$vtotresep=0;
		/*if(($list_resep)){
			$result = $this->string_table_resep($list_resep);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten."<table border=\"1\">
			<tr>
				<td colspan=\"7\">Total Pembayaran Resep</td>
				<td> ".number_format($result['subtotal'],0)."</td>
			</tr></table>
			";
			$vtotresep=$result['subtotal'];
			//$konten = $konten.$result['konten'];
		}*/

		if(($obat)){
			//$result = $this->string_table_resep($list_resep);
			$grand_total = $grand_total + $obat;
			$konten = $konten."<table class=\"table-isi\" border=\"0\">
			<tr>
				<td colspan=\"7\"> Total Pembayaran Resep</td>
				<td align=\"right\"> ".number_format($obat,0)."</td>
			</tr></table>
			";
			$vtotresep=$obat;
			//$konten = $konten.$result['konten'];
		}
		$vtotoksigen=0;
		if(($list_oksigen)){ //harus Pelaksana Rumah Sakit
			$result = $this->string_table_tindakan($list_oksigen);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten."
			<table class=\"table-isi\" border=\"0\">
			<tr>
				<td colspan=\"7\"> Oksigen (O2)</td>
				<td align=\"right\"> ".number_format($result['subtotal'],0)."</td>
			</tr></table>
			";
			$vtotoksigen=$result['subtotal'];
		}		
		//ird
		/*if(($list_tindakan_ird)){
			$result = $this->string_table_ird($list_tindakan_ird);
			$grand_total = $grand_total + $result['subtotal'];
			$konten = $konten."
			<tr>
				<td colspan=\"6\">Total Pembayaran Rawat Darurat</td>
				<td>Rp. ".number_format($result['subtotal'],0)."</td>
			</tr>
			";
			//$konten = $konten.$result['konten'];
		}*/		
		//irj
		if($pasien[0]['carabayar']=='BPJS'){
			if(($poli_irj_dokter)){
				$result = $this->string_table_irj_kw($poli_irj_dokter);
				$grand_total = $grand_total + $result['subtotal'];
				$konten= $konten.$result['konten'];
				/*$konten = $konten."
				<tr>
					<td colspan=\"7\">Total Pembayaran Rawat Jalan</td>
					<td>Rp. ".number_format($result['subtotal'],0)."</td>
				</tr>
				";*/
				//$konten = $konten.$result['konten'];
			}
			if(($poli_irj_perawat)){
				$result = $this->string_table_irj($poli_irj_perawat);
				if((int)$result['subtotal']!=0){
					$grand_total = $grand_total + $result['subtotal'];				
					$konten = $konten."
					<table class=\"table-isi\" border=\"0\">
					<tr>
						<td colspan=\"7\">Tindakan Perawat Rawat Jalan</td>
						<td align=\"right\"> ".number_format($result['subtotal'],0)." </td>
					</tr>
					</table>
					";
				}
				
				//$konten = $konten.$result['konten'];
			}
		}		

		//biaya_administrasi
		$biaya_administrasi= (double) $grand_total * 0.1;
		if($biaya_administrasi<=50000){
			$fix_adm=50000;
		}else if($biaya_administrasi>=750000 && $pasien[0]['carabayar']=='UMUM'){
			$fix_adm=750000;
		}else{
			$fix_adm=$biaya_administrasi;
		}		


		//1B0103
		$detailtind=$this->rimpasien->get_detail_tindakan('1B0103',$pasien[0]['kelas'])->row();		
		
			//$data['dijamin']=$this->input->post('dijamin');
			$biaya_daftar=(int) $detailtind->total_tarif+(int)$detailtind->tarif_alkes;
		$konten = $konten."<br><br>
			<table class=\"table-isi\" border=\"0\">";
		if((int)$total_alkes!=0){
			$konten = $konten."<tr>
				<td colspan=\"7\">Sewa Alat</td>
				<td align=\"right\"><p> ".number_format( $total_alkes, 0)." </p></td>
			</tr>";
		}
			
		/*if((int)$tind_perawat!=0){
			$konten = $konten."<tr >
				<td colspan=\"7\">Tindakan Perawat</td>
				<td align=\"right\"> ".number_format($tind_perawat,0)." </td>
			</tr>";
		}*/

		$tind_perawat=0;		
		if(($list_tindakan_perawat_pasien)){
			$result = $this->string_table_tindakan_perawat($list_tindakan_perawat_pasien);
			$grand_total = $grand_total + $result['subtotal'] + $result['subtotal_alkes'];
			$total_alkes = $total_alkes + $result['subtotal_alkes'];
			// $subsidi = $result['subsidi'];
			// $subsidi_total = $subsidi_total + $subsidi;
			// $konten = $konten."
			// <tr>
			// 	<td>Total Pembayaran Tindakan Ruangan</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			$konten = $konten.$result['konten'];
			$tind_perawat=$result['subtotal'];
			//print_r($konten);exit;
			
		}

		if((int)$matkes!=0){
			$konten = $konten."<tr>
				<td colspan=\"7\">Matkes Ruang Rawat</td>
				<td align=\"right\"> ".number_format($matkes,0)." </td>
			</tr>";
		}
		

		$konten = $konten."<tr>
				<td align=\"right\" colspan=\"7\">Total</td>
				<td align=\"right\"> ".number_format($grand_total,0)." </td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td colspan=\"7\">Jasa Keperawatan</td>
				<td align=\"right\"> ".number_format($jasa_perawat,0)." </td>
			</tr>
			<tr>
				<td colspan=\"7\">Biaya Administrasi</td>
				<td align=\"right\"> ".number_format($fix_adm,0)." </td>
			</tr>
			<tr>
				<td colspan=\"7\">Biaya Materai</td>
				<td align=\"right\"> ".number_format(6000,0)." </td>
			</tr>
			<tr>
				<td colspan=\"7\">Biaya Pendaftaran</td>
				<td align=\"right\"> ".number_format($biaya_daftar,0)." </td>
			</tr>			
			";

		$grand_total = (double) $grand_total + (double) $fix_adm + (double) $jasa_perawat + 6000 + (double) $biaya_daftar;

		// $konten = $this->string_data_pasien($pasien,$grand_total,$penerima,'').$konten;
		
					
		


			$jenis_bayar = $this->input->post('jenis_pembayaran');
			$string_detail_pembayaran_kredit_tunai = "";
			$string_diskon = "";
					if($diskon != 0){
						$string_diskon = "<tr>
							<th colspan=\"6\"><p align=\"left\"><b>Diskon   </b></p></th>
							<th ><p align=\"right\"> ".number_format( $diskon, 0 )." </p></th>
						</tr>";
					}

					$string_detail_pembayaran_kredit_tunai = 
					"
					<tr>
						<th colspan=\"6\"><p align=\"left\"><b>Dibayar Tunai   </b></p></th>
						<th ><p align=\"right\"> ".number_format( $dibayar_tunai, 0 )." </p></th>
					</tr>
					".$string_diskon;
				//echo $vtot_peserta;
			
			$login_data = $this->load->get_var("user_info");
			$user = strtoupper($login_data->username);

			$grand_total_string = "
						
			<table class=\"table-isi\" border=\"0\">
				".$string_detail_pembayaran_kredit_tunai."
				<tr>
					<th colspan=\"6\"><p align=\"left\"><b>Total   </b></p></th>
					<th ><p align=\"right\"> ".number_format( $grand_total+$vtotdenda, 0 )." </p></th>
				</tr>
			</table>
			<br/><br/><br/>			
			<table border=\"1\">";

			$konten0 = $konten0."<br>".$grand_total_string;
			$konten0 = $this->string_data_pasien($pasien,$grand_total,"",'').$konten0;

			$konten = $konten0.$konten;
			//echo $konten;
			//break;
		//$tgl = date("Y-m-d");
		$tgl = date('d F Y');


		//INIT KALO TUNAI DAN KREDIT
		$jenis_bayar = $this->input->post('jenis_pembayaran');
		//echo $grand_total.' '.$biaya_administrasi.' '.$biaya_materai.' '.$biaya_daftar.' '.$jasa_perawat;
		$vtot_peserta = $grand_total+$biaya_administrasi+$biaya_materai+$biaya_daftar+$jasa_perawat;
		//$biaya_adm = $pasien[0]['biaya_administrasi'];
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if(($data_paket)){
			$status_paket = 1;
		}


		/*if($biaya_adm == "" && $status_paket == 0){
			$biaya_adm = $grand_total * 5 / 100;
			$grand_total = $grand_total + $biaya_adm;
		}*/
		$cterbilang= new rjcterbilang();
		$vtot_terbilang=$cterbilang->terbilang($grand_total+$vtotdenda,1);
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);
		/*<tr>
				<th colspan=\"6\"><p><b>Biaya Administrasi   </b></p></th>
				<th><p>Rp. ".number_format( $biaya_adm, 0)."</p></th>
			</tr>*/
		$grand_total_string = "			
			<tr>
				<th colspan=\"7\"><p><b>Denda Terlambat</b></p></th>
				<th><p align=\"right\"> ".number_format( $vtotdenda, 0)." </p></th>
			</tr>
			<tr>
				<th colspan=\"7\"><p><b>Total Biaya</b></p></th>
				<th><p align=\"right\"> ".number_format( $grand_total+$vtotdenda, 0)." </p></th>
			</tr>
		</table>
		<br>
		<p><b>Terbilang : </b><i>".strtoupper($vtot_terbilang)."</i></p><br>	
		<table>
			<tr>
				<td></td>
				<td></td>
				<td>$tgl</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>an.Kepala Rumah Sakit</td>
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
				<td>$user</td>
			</tr>
		</table>	
		";

		$konten = $konten.$grand_total_string;

		//update status cetak kwitansi
		$data_pasien_iri['cetak_kwitansi'] = 1;
		//$data_pasien_iri['vtot'] = $grand_total;
		$data_pasien_iri['total'] = $grand_total;
		$data_pasien_iri['vtot_piutang'] = $subsidi_total;
		$data_pasien_iri['tgl_cetak_kw'] = date("Y-m-d H:i:s");
		$data_pasien_iri['vtot_kamar']=$biaya_kamar;
		$data_pasien_iri['vtot_icu']=$vtoticu;
		$data_pasien_iri['vtot_vk']=$vtotvk;
		$data_pasien_iri['vtot_ok']=$vtotok;
		$data_pasien_iri['vtot_lab']=$vtotlab;
		$data_pasien_iri['vtot_rad']=$vtotrad;
		$data_pasien_iri['vtot_pa']=$vtotpa;
		$data_pasien_iri['vtot_obat']=$vtotresep;
		$data_pasien_iri['vtot_usg']=$vtotusg;
		$data_pasien_iri['denda_terlambat']=$vtotdenda;

		$data_pasien_iri['biaya_alkes']=$total_alkes;
		$data_pasien_iri['vtot_ruang']=$vtotruang;
		$data_pasien_iri['matkes_ok']=$matkesok;
		$data_pasien_iri['matkes_vk']=$matkesvk;
		$data_pasien_iri['biaya_daftar']=$biaya_daftar;
		$data_pasien_iri['matkes_icu']=$matkesicu;

		$data_pasien_iri['vtot_oksigen']=$vtotoksigen;
		$data_pasien_iri['vtot_kamaricu']=$vtotkamaricu;
		$data_pasien_iri['vtot_kamarvk']=$vtotkamarvk;
		$data_pasien_iri['vtot_medis']=$vtotmedis;
		$data_pasien_iri['vtot_paramedis']=$vtotparamedis;
		$login_data = $this->load->get_var("user_info");
		$data_pasien_iri['xuser'] = $login_data->username;
		//kalo kredit, sisa dari yang dibayar pasien masukin ke kredit, plus diskon
		if($jenis_bayar == "KREDIT"){
			$data_pasien_iri['diskon'] = $diskon;
			$data_pasien_iri['vtot'] = $grand_total;
			// tambahan kredit //
			$konten_kredit = $this->string_perusahaan($pasien,$data_pasien_iri['diskon'],$penerima,$jenis_pembayaran,$data_pasien_iri['tgl_cetak_kw']);
			// end tambahan kredit //
		}else{
			$data_pasien_iri['diskon'] = $diskon;
		}
		$data_pasien_iri['jenis_bayar'] = $this->input->post('jenis_pembayaran');
		$data_pasien_iri['remark'] = $this->input->post('remark');

		$data_pasien_iri['tunai'] = $dibayar_tunai;
		//$data_pasien_iri['no_kkkd'] = $no_kartu_kredit;
		//$data_pasien_iri['nilai_kkkd'] = $dibayar_kartu_cc_debit;
		//$data_pasien_iri['persen_kk'] = $charge;
		$data_pasien_iri['matkes_iri'] = $matkes;
		$data_pasien_iri['jasa_perawat'] = $jasa_perawat;
		$data_pasien_iri['biaya_administrasi'] = $fix_adm;		
		//$data_pasien_iri['total_charge_kkkd'] = $dibayar_kartu_cc_debit * $charge / 100;

		$data_pasien_iri['lunas'] = 1;
		if($pasien[0]['carabayar'] == "DIJAMIN"){
			$data_pasien_iri['lunas'] = 0;
		}

		//print_r($data_pasien_iri);exit;
		$this->rimpendaftaran->update_pendaftaran_mutasi($data_pasien_iri, $no_ipd);
		$this->rimpasien->flag_kwintasi_rad_terbayar($no_ipd);
		$this->rimpasien->flag_kwintasi_lab_terbayar($no_ipd);
		$this->rimpasien->flag_kwintasi_obat_terbayar($no_ipd);
		$this->rimpasien->flag_ird_terbayar($pasien[0]['noregasal'],date("Y:m:d H:i"),$data_pasien_iri['lunas']);
		$this->rimpasien->flag_irj_terbayar($pasien[0]['noregasal'],date("Y:m:d H:i"),$data_pasien_iri['lunas']);
		//update ke lab, rad, obat kalo udah pembayaran		
		//echo $konten;
		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "Kwitansi Rawat Inap - ".$no_ipd." - ".$pasien[0]['nama'];
		$tgl_cetak = date("j F Y");
		$obj_pdf->SetTitle($title);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins('5', '5', '5', '5');
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 9);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();

		// $obj_pdf = new TCPDF('P', PDF_UNIT, 'A5', true, 'UTF-8', false);
		// $obj_pdf->SetCreator(PDF_CREATOR);
		// $title = "Rincian Biaya Rawat Inap - ".$no_ipd." - ".$pasien[0]['nama'];
		// $tgl_cetak = date("j F Y");
		// $obj_pdf->SetTitle($file_name);
		// $obj_pdf->SetHeaderData('', '', $title, 'Tanggal Cetak - '.$tgl_cetak);
		// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		// $obj_pdf->SetDefaultMonospacedFont('helvetica');
		// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		// $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		// $obj_pdf->SetMargins('5', '5', '5', '5');
		// $obj_pdf->setPrintHeader(false);
		// $obj_pdf->setPrintFooter(false);
		// $obj_pdf->SetAutoPageBreak(TRUE, '5');
		// $obj_pdf->SetFont('helvetica', '', 10);
		// $obj_pdf->setFontSubsetting(false);
		// $obj_pdf->AddPage();
		ob_start();
			$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'/download/inap/laporan/pembayaran/'.$file_name, 'FI');				
	}



	//COBA COBA

	private function string_data_pasien($pasien,$grand_total,$penerima,$jenis_pembayaran){
		// $konten="";
		// $format_tanggal = date("j F Y", strtotime($pasien[0]['tgl_masuk']));
		// $konten = $konten."
		// <table>
		// 	<tr>
		// 		<td>Nama</td>
		// 		<td>".$pasien[0]['nama']."</td>
		// 		<td>Tanggal Kunjungan</td>
		// 		<td>".$format_tanggal."</td>
		// 	</tr>
		// 	<tr>
		// 		<td>No CM</td>
		// 		<td>".$pasien[0]['no_cm']."</td>
		// 		<td>Ruang/Kelas/Bed</td>
		// 		<td>".$pasien[0]['nmruang']."/".$pasien[0]['kelas']."/".$pasien[0]['bed']."</td>
		// 	</tr>
		// 	<tr>
		// 		<td>No Register</td>
		// 		<td>".$pasien[0]['no_ipd']."</td>
		// 	</tr>
		// </table> <br><br> ";
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$tgl = date("d-m-Y");

		


		//tanda terima
		$penyetor = $penerima;


		//terbilang
		$cterbilang= new rjcterbilang();
		$vtot_terbilang=$cterbilang->terbilang($grand_total);

		$konten = "";
		// <table>
		// 				<tr>
		// 					<td></td>
		// 					<td></td>
		// 					<td></td>
		// 					<td><b>Tanggal-Jam: $tgl_jam</b></td>
		// 				</tr>
		// 			</table>

		// <tr>
		// 					<td width=\"20%\"><b>Sudah Terima Dari</b></td>
		// 					<td width=\"5%\"> : </td>
		// 					<td>".$penyetor."</td>
		// 				</tr>


		// <td><b>Banyak Ulang</b></td>
		// 					<td> : </td>
		// 					<td>".$vtot_terbilang."</td>
		$interval = date_diff(date_create(), date_create($pasien[0]['tgl_lahir']));

		$tambahan_jenis_pembayaran = "";
		if($jenis_pembayaran == "KREDIT"){
			$tambahan_jenis_pembayaran = " (KREDIT) ";
		}else{
			$tambahan_jenis_pembayaran = " (TUNAI) ";
		}

		//print_r($detail_bayar);
		$txtperusahaan='';
		if($pasien[0]['carabayar']=='DIJAMIN' || $pasien[0]['carabayar']=='BPJS')
			{
				$kontraktor=$this->rimlaporan->getdata_perusahaan($pasien[0]['no_ipd'])->row();
				$txtperusahaan="<td><b>Dijamin Oleh</b></td>
						<td> : </td>
						<td>".strtoupper($kontraktor->nmkontraktor)."</td>";//
			}

		$konten = $konten."<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					.table-font-size1{
						font-size:12px;
					    }
					</style>
					
					<table class=\"table-font-size\" border=\"0\">
						<tr>
						<td rowspan=\"3\" width=\"16%\"  style=\"border-bottom:1px solid black; font-size:8px; \"><p align=\"center\">
							<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"20\" style=\"padding-right:5px;\"></p></td>
						<td rowspan=\"3\" width=\"84%\" style=\"border-bottom:1px solid black; font-size:8.5px;\"><b>".$this->config->item('namars')."</b> <br/> ".$this->config->item('alamat')."</td>
												
						</tr>
						<tr><td></td><td></td></tr>
						
					</table>
					
					<table style=\"padding-top:2px;\">
						<tr>							
							<td><font size=\"8\" align=\"right\">$tgl_jam</font></td>
						</tr>			
						<tr>
							<td colspan=\"3\" ><font size=\"12\" align=\"center\"><u><b>KWITANSI RAWAT INAP</b></u></font></td>
						</tr>			
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td width=\"17%\"><b>Sudah Terima Dari</b></td>
								<td width=\"2%\"> : </td>
								<td width=\"37%\">".strtoupper($pasien[0]['nama'])."</td>
								<td width=\"19%\"><b>Tanggal Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td>".date("d-m-Y",strtotime($pasien[0]['tgl_masuk']))."</td>
							</tr>
							<tr>
								<td><b>Nama Pasien</b></td>
								<td> : </td>
								<td>".strtoupper($pasien[0]['nama'])."</td>
								<td ><b>No Medrec</b></td>
								<td > : </td>
								<td>".strtoupper($pasien[0]['no_cm'])."</td>
							</tr>
							<tr>
								<td ><b>Umur</b></td>
								<td > : </td>
								<td>".$interval->format("%Y Thn, %M Bln, %d Hr")."</td>
								
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($pasien[0]['carabayar'])."</td>
							</tr>
							
							<tr>
								<td><b>Alamat</b></td>
								<td> : </td>
								<td>".strtoupper($pasien[0]['alamat'])."</td>
								
								$txtperusahaan
							</tr>
					</table>";

		// $konten = $konten."
		// 			<p align=\"center\"><b>
		// 			Faktur $tambahan_jenis_pembayaran Rawat Inap<br/>
		// 			</b></p><br/>
		// 			<table>
						
		// 				<tr>
		// 					<td><b>NAMA PASIEN : </b></td>
							
		// 					<td>".$pasien[0]['nama']."</td>

		// 					<td><b>TGL.RAWAT : </b></td>
							
		// 					<td>".date("d/m/Y",strtotime($pasien[0]['tgl_masuk']) )." s/d ".date("d/m/Y", strtotime($pasien[0]['tgl_keluar'])) ."</td>
		// 				</tr>

		// 				<tr>
		// 					<td><b>UMUR : </b></td>
							
		// 					<td>".$interval->format("%Y Tahun, %M Bulan, %d Hari")."</td>

		// 					<td><b>GOLONGAN PASIEN : </b></td>
							
		// 					<td>".$pasien[0]['carabayar']."</td>
		// 				</tr>

		// 				<tr>
		// 					<td><b>ALAMAT : </b></td>
							
		// 					<td>".$pasien[0]['alamat']."</td>

		// 					<td><b>RUANGAN : </b></td>
							
		// 					<td>BED ".$pasien[0]['bed']." KELAS ".$pasien[0]['kelas']."</td>
		// 				</tr>
		// 			</table>
		// 			<br/><br/>
		// ";

		return $konten;
	}

	private function string_data_pasien_sementara($pasien,$grand_total,$penerima,$jenis_pembayaran){
		// $konten="";
		// $format_tanggal = date("j F Y", strtotime($pasien[0]['tgl_masuk']));
		// $konten = $konten."
		// <table>
		// 	<tr>
		// 		<td>Nama</td>
		// 		<td>".$pasien[0]['nama']."</td>
		// 		<td>Tanggal Kunjungan</td>
		// 		<td>".$format_tanggal."</td>
		// 	</tr>
		// 	<tr>
		// 		<td>No CM</td>
		// 		<td>".$pasien[0]['no_cm']."</td>
		// 		<td>Ruang/Kelas/Bed</td>
		// 		<td>".$pasien[0]['nmruang']."/".$pasien[0]['kelas']."/".$pasien[0]['bed']."</td>
		// 	</tr>
		// 	<tr>
		// 		<td>No Register</td>
		// 		<td>".$pasien[0]['no_ipd']."</td>
		// 	</tr>
		// </table> <br><br> ";
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$tgl = date("d-m-Y");	

		//tanda terima
		$penyetor = $penerima;

		//terbilang
		$cterbilang= new rjcterbilang();
		$vtot_terbilang=$cterbilang->terbilang($grand_total);

		$konten = "";
		// <table>
		// 				<tr>
		// 					<td></td>
		// 					<td></td>
		// 					<td></td>
		// 					<td><b>Tanggal-Jam: $tgl_jam</b></td>
		// 				</tr>
		// 			</table>

		// <tr>
		// 					<td width=\"20%\"><b>Sudah Terima Dari</b></td>
		// 					<td width=\"5%\"> : </td>
		// 					<td>".$penyetor."</td>
		// 				</tr>


		// <td><b>Banyak Ulang</b></td>
		// 					<td> : </td>
		// 					<td>".$vtot_terbilang."</td>
		$interval = date_diff(date_create(), date_create($pasien[0]['tgl_lahir']));

		$tambahan_jenis_pembayaran = "";
		if($jenis_pembayaran == "KREDIT"){
			$tambahan_jenis_pembayaran = " (KREDIT) ";
		}else{
			$tambahan_jenis_pembayaran = " (TUNAI) ";
		}

		//print_r($detail_bayar);
		$txtperusahaan='';
		if($pasien[0]['carabayar']=='DIJAMIN')
			{
				$kontraktor=$this->rimlaporan->getdata_perusahaan($pasien[0]['no_ipd'])->row();
				if($kontraktor!=''){
					$txtperusahaan="<td><b>Dijamin Oleh</b></td>
						<td> : </td>
						<td>".strtoupper($kontraktor->nmkontraktor)."</td>";
				}				
			}

		$konten = $konten."<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					.table-font-size1{
						font-size:12px;
					    }
					</style>
					
					".$this->config->item('header_pdf')."
					<hr>
					<table style=\"padding-top:2px;\">
						<tr>							
							<td><font size=\"8\" align=\"right\">$tgl_jam</font></td>
						</tr>			
						<tr>
							<td colspan=\"3\" ><font size=\"12\" align=\"center\"><u><b>KWITANSI SEMENTARA RAWAT INAP</b></u></font></td>
						</tr>			
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td width=\"17%\"><b>Sudah Terima Dari</b></td>
								<td width=\"2%\"> : </td>
								<td width=\"37%\">".strtoupper($pasien[0]['nama'])."</td>
								<td width=\"19%\"><b>Tanggal Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td>".date("d-m-Y",strtotime($pasien[0]['tgl_masuk']))."</td>
							</tr>
							<tr>
								<td><b>Nama Pasien</b></td>
								<td> : </td>
								<td>".strtoupper($pasien[0]['nama'])."</td>
								<td ><b>No Medrec</b></td>
								<td > : </td>
								<td>".strtoupper($pasien[0]['no_cm'])."</td>
							</tr>
							<tr>
								<td ><b>Umur</b></td>
								<td > : </td>
								<td>".$interval->format("%Y Thn, %M Bln, %d Hr")."</td>
								
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($pasien[0]['carabayar'])."</td>
							</tr>
							
							<tr>
								<td><b>Alamat</b></td>
								<td> : </td>
								<td>".strtoupper($pasien[0]['alamat'])."</td>								
								$txtperusahaan
							</tr>
					</table>";

		// $konten = $konten."
		// 			<p align=\"center\"><b>
		// 			Faktur $tambahan_jenis_pembayaran Rawat Inap<br/>
		// 			</b></p><br/>
		// 			<table>
						
		// 				<tr>
		// 					<td><b>NAMA PASIEN : </b></td>
							
		// 					<td>".$pasien[0]['nama']."</td>

		// 					<td><b>TGL.RAWAT : </b></td>
							
		// 					<td>".date("d/m/Y",strtotime($pasien[0]['tgl_masuk']) )." s/d ".date("d/m/Y", strtotime($pasien[0]['tgl_keluar'])) ."</td>
		// 				</tr>

		// 				<tr>
		// 					<td><b>UMUR : </b></td>
							
		// 					<td>".$interval->format("%Y Tahun, %M Bulan, %d Hari")."</td>

		// 					<td><b>GOLONGAN PASIEN : </b></td>
							
		// 					<td>".$pasien[0]['carabayar']."</td>
		// 				</tr>

		// 				<tr>
		// 					<td><b>ALAMAT : </b></td>
							
		// 					<td>".$pasien[0]['alamat']."</td>

		// 					<td><b>RUANGAN : </b></td>
							
		// 					<td>BED ".$pasien[0]['bed']." KELAS ".$pasien[0]['kelas']."</td>
		// 				</tr>
		// 			</table>
		// 			<br/><br/>
		// ";

		return $konten;
	}

	private function string_data_pasien_faktur($pasien,$grand_total,$penerima,$jenis_pembayaran){
		// $konten="";
		// $format_tanggal = date("j F Y", strtotime($pasien[0]['tgl_masuk']));
		// $konten = $konten."
		// <table>
		// 	<tr>
		// 		<td>Nama</td>
		// 		<td>".$pasien[0]['nama']."</td>
		// 		<td>Tanggal Kunjungan</td>
		// 		<td>".$format_tanggal."</td>
		// 	</tr>
		// 	<tr>
		// 		<td>No CM</td>
		// 		<td>".$pasien[0]['no_cm']."</td>
		// 		<td>Ruang/Kelas/Bed</td>
		// 		<td>".$pasien[0]['nmruang']."/".$pasien[0]['kelas']."/".$pasien[0]['bed']."</td>
		// 	</tr>
		// 	<tr>
		// 		<td>No Register</td>
		// 		<td>".$pasien[0]['no_ipd']."</td>
		// 	</tr>
		// </table> <br><br> ";
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$tgl = date("d-m-Y");
		//tanda terima
		$penyetor = $penerima;

		//terbilang
		$cterbilang= new rjcterbilang();
		$vtot_terbilang=$cterbilang->terbilang($grand_total);

		$konten = "";
		// <table>
		// 				<tr>
		// 					<td></td>
		// 					<td></td>
		// 					<td></td>
		// 					<td><b>Tanggal-Jam: $tgl_jam</b></td>
		// 				</tr>
		// 			</table>

		// <tr>
		// 					<td width=\"20%\"><b>Sudah Terima Dari</b></td>
		// 					<td width=\"5%\"> : </td>
		// 					<td>".$penyetor."</td>
		// 				</tr>


		// <td><b>Banyak Ulang</b></td>
		// 					<td> : </td>
		// 					<td>".$vtot_terbilang."</td>
		$interval = date_diff(date_create(), date_create($pasien[0]['tgl_lahir']));

		$tambahan_jenis_pembayaran = "";
		if($jenis_pembayaran == "KREDIT"){
			$tambahan_jenis_pembayaran = " (KREDIT) ";
		}else{
			$tambahan_jenis_pembayaran = " (TUNAI) ";
		}

		//print_r($detail_bayar);
		$txtperusahaan='';
		if($pasien[0]['carabayar']=='DIJAMIN')
			{
				$kontraktor=$this->rimlaporan->getdata_perusahaan($pasien[0]['no_ipd'])->row();
				if($kontraktor!=''){
					$txtperusahaan="<td><b>Dijamin Oleh</b></td>
						<td> : </td>
						<td>".strtoupper($kontraktor->nmkontraktor)."</td>";
				}
				
			}

		$konten = $konten."<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					.table-font-size1{
						font-size:12px;
					    }
					</style>
					
					".$this->config->item('header_pdf')."
					<hr>
					
					<table style=\"padding-top:2px;\">
						<tr>							
							<td><font size=\"8\" align=\"right\">$tgl_jam</font></td>
						</tr>			
						<tr>
							<td colspan=\"3\" ><font size=\"12\" align=\"center\"><u><b>FAKTUR RAWAT INAP</b></u></font></td>
						</tr>			
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td width=\"17%\"><b>Sudah Terima Dari</b></td>
								<td width=\"2%\"> : </td>
								<td width=\"37%\">".strtoupper($pasien[0]['nama'])."</td>
								<td width=\"19%\"><b>Tanggal Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td>".date("d-m-Y",strtotime($pasien[0]['tgl_masuk']))."</td>
							</tr>
							<tr>
								<td><b>Nama Pasien</b></td>
								<td> : </td>
								<td>".strtoupper($pasien[0]['nama'])."</td>
								<td ><b>No Medrec</b></td>
								<td > : </td>
								<td>".strtoupper($pasien[0]['no_cm'])."</td>
							</tr>
							<tr>
								<td ><b>Umur</b></td>
								<td > : </td>
								<td>".$interval->format("%Y Thn, %M Bln, %d Hr")."</td>
								
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($pasien[0]['carabayar'])."</td>
							</tr>
							
							<tr>
								<td><b>Alamat</b></td>
								<td> : </td>
								<td>".strtoupper($pasien[0]['alamat'])."</td>								
								$txtperusahaan
							</tr>
					</table>";

		// $konten = $konten."
		// 			<p align=\"center\"><b>
		// 			Faktur $tambahan_jenis_pembayaran Rawat Inap<br/>
		// 			</b></p><br/>
		// 			<table>
						
		// 				<tr>
		// 					<td><b>NAMA PASIEN : </b></td>
							
		// 					<td>".$pasien[0]['nama']."</td>

		// 					<td><b>TGL.RAWAT : </b></td>
							
		// 					<td>".date("d/m/Y",strtotime($pasien[0]['tgl_masuk']) )." s/d ".date("d/m/Y", strtotime($pasien[0]['tgl_keluar'])) ."</td>
		// 				</tr>

		// 				<tr>
		// 					<td><b>UMUR : </b></td>
							
		// 					<td>".$interval->format("%Y Tahun, %M Bulan, %d Hari")."</td>

		// 					<td><b>GOLONGAN PASIEN : </b></td>
							
		// 					<td>".$pasien[0]['carabayar']."</td>
		// 				</tr>

		// 				<tr>
		// 					<td><b>ALAMAT : </b></td>
							
		// 					<td>".$pasien[0]['alamat']."</td>

		// 					<td><b>RUANGAN : </b></td>
							
		// 					<td>BED ".$pasien[0]['bed']." KELAS ".$pasien[0]['kelas']."</td>
		// 				</tr>
		// 			</table>
		// 			<br/><br/>
		// ";

		return $konten;
	}
	private function string_data_pasien_simple($pasien,$grand_total,$penerima,$jenis_pembayaran){
		// $konten="";
		// $format_tanggal = date("j F Y", strtotime($pasien[0]['tgl_masuk']));
		// $konten = $konten."
		// <table>
		// 	<tr>
		// 		<td>Nama</td>
		// 		<td>".$pasien[0]['nama']."</td>
		// 		<td>Tanggal Kunjungan</td>
		// 		<td>".$format_tanggal."</td>
		// 	</tr>
		// 	<tr>
		// 		<td>No CM</td>
		// 		<td>".$pasien[0]['no_cm']."</td>
		// 		<td>Ruang/Kelas/Bed</td>
		// 		<td>".$pasien[0]['nmruang']."/".$pasien[0]['kelas']."/".$pasien[0]['bed']."</td>
		// 	</tr>
		// 	<tr>
		// 		<td>No Register</td>
		// 		<td>".$pasien[0]['no_ipd']."</td>
		// 	</tr>
		// </table> <br><br> ";
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$tgl = date("d-m-Y");		

		//tanda terima
		$penyetor = $penerima;

		//terbilang
		$cterbilang= new rjcterbilang();
		$vtot_terbilang=$cterbilang->terbilang($grand_total);

		$konten = "";
		$interval = date_diff(date_create(), date_create($pasien[0]['tgl_lahir']));

		$tambahan_jenis_pembayaran = "";
		if($jenis_pembayaran == "KREDIT"){
			$tambahan_jenis_pembayaran = " (KREDIT) ";
		}else{
			$tambahan_jenis_pembayaran = " TUNAI ";
		}
		$konten = $konten."<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					.table-font-size1{
						font-size:12px;
					    }
					</style>
					
					
						".$this->config->item('header_pdf')."
					<table class=\"table-font-size\" border=\"0\">
						<tr><td></td><td colspan=\"2\"><p align=\"right\" style=\"font-size:10px;\"><b>Pembayaran : <u>".$tambahan_jenis_pembayaran."</u></b></p></td></tr>
					</table>
					
					
					<table >
						<tr>							
							<td><font size=\"8\" align=\"left\">$tgl_jam</font></td>
						</tr>			
						<tr>
							<td colspan=\"3\" ><font size=\"12\" align=\"center\"><u><b>KWITANSI RAWAT INAP<br/>
					No. KW. ".$pasien[0]['no_ipd']."</b></u></font></td>
						</tr>	<br>		
							<tr>
								<td width=\"17%\"><b>Terbilang</b></td>
								<td width=\"2%\"> : </td>
								<td  width=\"78%\"><i>".strtoupper($vtot_terbilang)."</i></td>
							</tr>			
							<tr>
								<td><b>Untuk Pemeriksaan</b></td>
								<td> : </td>
								<td><i>Untuk Pembayaran Pemeriksaan, Tindakan dan pengobatan Rawat Inap sesuai nota terlampir</i></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td width=\"17%\"><b>Sudah Terima Dari</b></td>
								<td width=\"2%\"> : </td>
								<td width=\"37%\">".strtoupper($pasien[0]['nama'])."</td>
								<td width=\"19%\"><b>Tanggal Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td>".date("d-m-Y",strtotime($pasien[0]['tgl_masuk']))."</td>
							</tr>
							<tr>
								<td><b>Nama Pasien</b></td>
								<td> : </td>
								<td>".strtoupper($pasien[0]['nama'])."</td>
								<td ><b>No Medrec</b></td>
								<td > : </td>
								<td>".strtoupper($pasien[0]['no_cm'])."</td>
							</tr>
							<tr>
								<td ><b>Umur</b></td>
								<td > : </td>
								<td>".$interval->format("%Y Tahun, %M Bulan, %d Hari")." TAHUN</td>
								
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($pasien[0]['carabayar'])."</td>
							</tr>
							
							<tr>
								<td><b>Alamat</b></td>
								<td> : </td>
								<td>".strtoupper($pasien[0]['alamat'])."</td>
								
							</tr>
					</table>";

		// $konten = $konten."
		// 			<p align=\"center\"><b>
		// 			Kwitansi $tambahan_jenis_pembayaran Rawat Inap<br/>
		// 			No. KW. ".$pasien[0]['no_ipd']."
		// 			</b></p><br/>
		// 			<table>
						
		// 				<tr>
		// 					<td><b>NAMA PASIEN : </b></td>
							
		// 					<td>".$pasien[0]['nama']."</td>

		// 					<td><b>TGL.RAWAT : </b></td>
							
		// 					<td>".date("d/m/Y",strtotime($pasien[0]['tgl_masuk']) )." s/d ".date("d/m/Y", strtotime($pasien[0]['tgl_keluar'])) ."</td>
		// 				</tr>

		// 				<tr>
		// 					<td><b>UMUR : </b></td>
							
		// 					<td>".$interval->format("%Y Tahun, %M Bulan, %d Hari")."</td>

		// 					<td><b>GOLONGAN PASIEN : </b></td>
							
		// 					<td>".$pasien[0]['carabayar']."</td>
		// 				</tr>

		// 				<tr>
		// 					<td><b>ALAMAT : </b></td>
							
		// 					<td>".$pasien[0]['alamat']."</td>

		// 					<td><b>RUANGAN : </b></td>
							
		// 					<td>BED ".$pasien[0]['bed']." KELAS ".$pasien[0]['kelas']."</td>
		// 				</tr>
		// 			</table>
		// 			<br/><br/>
		// ";

		return $konten;
	}

	private function string_table_mutasi_ruangan($list_mutasi_pasien,$pasien,$status_paket){
		$konten = "";
		//
		$konten= $konten.'
		<table  class="table-isi" border="0">
			<tr>
			  <td colspan="2" align="center" >Ruangan</td>
			  <td align="center">Kelas</td>
			  <td align="center">Tgl Masuk</td>
			  <td align="center">Tgl Keluar</td>
			  <td align="center">Tarif</td>
			  <td align="center">Lama Inap</td>
			  <td align="center"></td>
			</tr>
		';
		$subtotal = 0;
		$subtotalruang = 0;
		$diff = 1;
		$total_subsidi = 0;
		$jasaperawat=0;$ceknull=0;
		$subtotalvk=0;$subtotalicu=0;
		foreach ($list_mutasi_pasien as $r) {
			if(strpos($r['nmruang'],'Bersalin')==false){
				$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
				if($r['tglkeluarrg'] != null){
					$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg'])) ;
				}else{
					if($pasien[0]['tgl_keluar'] != null){
						$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar'])) ;
					}else{
						//$tgl_keluar_rg = "-" ;
						$tgl_keluar_rg = date("d-m-Y");
					}	
				}
				if($r['tglkeluarrg'] != null){
					$start = new DateTime($r['tglmasukrg']);//start
					$end = new DateTime($r['tglkeluarrg']);//end

					$diff = $end->diff($start)->format("%a");
					if($diff == 0){
						$diff = 1;
					}
					$selisih_hari =  $diff." Hari"; 
				}else{
					if($pasien[0]['tgl_keluar'] != NULL){
						$start = new DateTime($r['tglmasukrg']);//start
						$end = new DateTime($pasien[0]['tgl_keluar']);//end

						$diff = $end->diff($start)->format("%a");
						if($diff == 0){
							$diff = 1;
						}
						$selisih_hari =  $diff." Hari";
					}else{
						$start = new DateTime($r['tglmasukrg']);//start
						$end = new DateTime();//end

						$diff = $end->diff($start)->format("%a");
						if($diff == 0){
							$diff = 1;
						}
						$selisih_hari =  $diff." Hari";
						//$selisih_hari =  "- Hari";
					}
				}
				$jasaperawat=$jasaperawat+$r['jasa_perawat'];			
				if(($r['tglkeluarrg']==null || $r['tglkeluarrg']=='') && ($pasien[0]['tgl_keluar']==null || $pasien[0]['tgl_keluar']=='')){
					$ceknull=1;
				}
				$total_tarif = $r['harga_jatah_kelas'] ;



				$subsidi_inap_kelas = $diff * $total_tarif ;//harga permalemnya berapa kalo ada jatah kelas
				$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

				//$total_per_kamar = $r['vtot'] * $diff;

				/*if($status_paket == 1){
					$temp_diff = $diff - 2;//kalo ada paket free 2 hari
					if($temp_diff < 0){
						$temp_diff = 0;
					}
					$total_per_kamar = $r['vtot'] * $temp_diff;
				}else{*/
					$total_per_kamar = $r['vtot'] * $diff;
				//}

				$subtotal = $subtotal + $total_per_kamar;

				if(strpos($r['nmruang'],'ICU')){
					$subtotalicu+=$total_per_kamar;
				} else{
					$subtotalruang+=$total_per_kamar;
				}

				$konten = $konten. "
				<tr>
					<td colspan=\"2\" align=\"left\">".$r['nmruang']."</td>
					<td align=\"center\">".$r['kelas']."</td>
					<td align=\"center\">".$tgl_masuk_rg."</td>
					<td align=\"center\">".$tgl_keluar_rg."</td>
					<td align=\"center\"> ".number_format($r['vtot'],0)."</td>
					<td align=\"center\">".$selisih_hari."</td>
					<td align=\"right\"> ".number_format($total_per_kamar,0)."</td>
				</tr>
				";
			}
		} 
			
		$konten = $konten.'
				<tr>
					<td colspan="6" align="right">Subtotal</td>
					<td colspan="2" align="right"> '.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table> <br><br>";
		
		$result = array('konten' => $konten,
					'subtotal' => $subtotal,
					'subtotal_ruang' => $subtotalruang,
					'subtotal_vk' => $subtotalvk,
					'subtotal_icu' => $subtotalicu,
					'jasaperawat' => $jasaperawat,
					'ceknull' => $ceknull);
		return $result;
	}

	private function string_table_mutasi_ruangan_vk($list_mutasi_pasien,$pasien,$status_paket){
		$konten = "";
		//		
		$subtotal = 0;
		$subtotalruang = 0;
		$diff = 1;
		$total_subsidi = 0;
		$ceknull=0;
		$subtotalvk=0;
		foreach ($list_mutasi_pasien as $r) {
			$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
			if($r['tglkeluarrg'] != null){
				$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg'])) ;
			}else{
				if($pasien[0]['tgl_keluar'] != null){
					$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar'])) ;
				}else{
					//$tgl_keluar_rg = "-" ;
					$tgl_keluar_rg = date("d-m-Y");
				}	
			}
			if($r['tglkeluarrg'] != null){
				$start = new DateTime($r['tglmasukrg']);//start
				$end = new DateTime($r['tglkeluarrg']);//end

				$diff = $end->diff($start)->format("%a");
				if($diff == 0){
					$diff = 1;
				}
				$selisih_hari =  $diff." Hari"; 
			}else{
				if($pasien[0]['tgl_keluar'] != NULL){
					$start = new DateTime($r['tglmasukrg']);//start
					$end = new DateTime($pasien[0]['tgl_keluar']);//end

					$diff = $end->diff($start)->format("%a");
					if($diff == 0){
						$diff = 1;
					}
					$selisih_hari =  $diff." Hari";
				}else{
					$start = new DateTime($r['tglmasukrg']);//start
					$end = new DateTime();//end

					$diff = $end->diff($start)->format("%a");
					if($diff == 0){
						$diff = 1;
					}
					$selisih_hari =  $diff." Hari";
					//$selisih_hari =  "- Hari";
				}
			}
			//$jasaperawat=$jasaperawat+$r['jasa_perawat'];			
			if(($r['tglkeluarrg']==null || $r['tglkeluarrg']=='') && ($pasien[0]['tgl_keluar']==null || $pasien[0]['tgl_keluar']=='')){
				$ceknull=1;
			}
			$total_tarif = $r['harga_jatah_kelas'] ;



			$subsidi_inap_kelas = $diff * $total_tarif ;//harga permalemnya berapa kalo ada jatah kelas
			$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

			//$total_per_kamar = $r['vtot'] * $diff;

			/*if($status_paket == 1){
				$temp_diff = $diff - 2;//kalo ada paket free 2 hari
				if($temp_diff < 0){
					$temp_diff = 0;
				}
				$total_per_kamar = $r['vtot'] * $temp_diff;
			}else{*/
				$total_per_kamar = $r['vtot'] * $diff;
			//}

			$subtotal = $subtotal + $total_per_kamar;

			$subtotalvk+=$total_per_kamar;
			
			$namaruang=$r['nmruang'];
			$konten = $konten. "
			<tr>
				<td align=\"left\" colspan=\"3\"> Sewa ".$r['nmruang']."</td>
				<td align=\"center\" colspan=\"3\"></td>
				<td align=\"right\" colspan=\"2\"> ".number_format($total_per_kamar,0)." </td>
			</tr>
			";
		}		
		$result = array(
					'subtotalvk'=> $subtotalvk,
					'konten'=> $konten
					);
		return $result;
	}

	private function string_table_mutasi_ruangan_kw($list_mutasi_pasien,$pasien,$status_paket){
		$konten = "";
		//
		$konten= $konten.'
		<table border="1">
			<tr>
			  <td align="center" >Ruang</td>
			  <td align="center">Kelas</td>
			  <td align="center">Bed</td>
			  <td align="center">Tgl Masuk</td>
			  <td align="center">Tgl Keluar</td>
			  <td align="center">Tarif</td>
			  <td align="center">Lama Inap</td>
			  <td align="center"></td>
			</tr>
		';
		$subtotal = 0;
		$subtotalruang = 0;
		$diff = 1;
		$total_subsidi = 0;
		$jasaperawat=0;$ceknull=0;
		$subtotalvk=0;$subtotalicu=0;
		foreach ($list_mutasi_pasien as $r) {			
			$tgl_masuk_rg = date("d-m-Y", strtotime($r['tglmasukrg']));
			if($r['tglkeluarrg'] != null){
				$tgl_keluar_rg =  date("d-m-Y", strtotime($r['tglkeluarrg'])) ;
			}else{
				if($pasien[0]['tgl_keluar'] != null){
					$tgl_keluar_rg = date("d-m-Y", strtotime($pasien[0]['tgl_keluar'])) ;
				}else{
					//$tgl_keluar_rg = "-" ;
					$tgl_keluar_rg = date("d-m-Y");
				}	
			}
			if($r['tglkeluarrg'] != null){
				$start = new DateTime($r['tglmasukrg']);//start
				$end = new DateTime($r['tglkeluarrg']);//end

				$diff = $end->diff($start)->format("%a");
				if($diff == 0){
					$diff = 1;
				}
				$selisih_hari =  $diff." Hari"; 
			}else{
				if($pasien[0]['tgl_keluar'] != NULL){
					$start = new DateTime($r['tglmasukrg']);//start
					$end = new DateTime($pasien[0]['tgl_keluar']);//end

					$diff = $end->diff($start)->format("%a");
					if($diff == 0){
						$diff = 1;
					}
					$selisih_hari =  $diff." Hari";
				}else{
					$start = new DateTime($r['tglmasukrg']);//start
					$end = new DateTime();//end

					$diff = $end->diff($start)->format("%a");
					if($diff == 0){
						$diff = 1;
					}
					$selisih_hari =  $diff." Hari";
					//$selisih_hari =  "- Hari";
				}
			}
			$jasaperawat=$jasaperawat+$r['jasa_perawat'];			
			if(($r['tglkeluarrg']==null || $r['tglkeluarrg']=='') && ($pasien[0]['tgl_keluar']==null || $pasien[0]['tgl_keluar']=='')){
				$ceknull=1;
			}
			$total_tarif = $r['harga_jatah_kelas'] ;



			$subsidi_inap_kelas = $diff * $total_tarif ;//harga permalemnya berapa kalo ada jatah kelas
			$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

			//$total_per_kamar = $r['vtot'] * $diff;

			/*if($status_paket == 1){
				$temp_diff = $diff - 2;//kalo ada paket free 2 hari
				if($temp_diff < 0){
					$temp_diff = 0;
				}
				$total_per_kamar = $r['vtot'] * $temp_diff;
			}else{*/
				$total_per_kamar = $r['vtot'] * $diff;
			//}

			$subtotal = $subtotal + $total_per_kamar;

			if(strpos($r['nmruang'],'Ruang Bersalin')){
				$subtotalvk+=$total_per_kamar;
			} else	if(strpos($r['nmruang'],'ICU')){
				$subtotalicu+=$total_per_kamar;
			} else{
				$subtotalruang+=$total_per_kamar;
			}

			$konten = $konten. "
			<tr>
				<td align=\"center\">".$r['nmruang']."</td>
				<td align=\"center\">".$r['kelas']."</td>
				<td align=\"center\">".$r['bed']."</td>
				<td align=\"center\">".$tgl_masuk_rg."</td>
				<td align=\"center\">".$tgl_keluar_rg."</td>
				<td align=\"center\">Rp. ".number_format($r['vtot'],0)."</td>
				<td align=\"center\">".$selisih_hari."</td>
				<td align=\"right\"> ".number_format($total_per_kamar,0)."</td>
			</tr>
			";
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="center">Subtotal</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table> <br><br>";
		
		$result = array('konten' => $konten,
					'subtotal' => $subtotal,
					'subtotal_ruang' => $subtotalruang,
					'subtotal_vk' => $subtotalvk,
					'subtotal_icu' => $subtotalicu,
					'jasaperawat' => $jasaperawat,
					'ceknull' => $ceknull);
		return $result;
	}

	private function string_table_tindakan_faktur($list_tindakan_pasien, $list_dokter){
		$konten = "";
		$konten= $konten.'
		<table class="table-isi" border="0">
		<tr>
		   	<td colspan="3" align="center">Tindakan</td>
		   	<td align="center">Pelaksana</td>
		   	<td align="center">Tgl layanan</td>
		  	<td align="center">Biaya Tindakan</td>
		  	<td align="center">Qty</td>
		  	<td align="center">Total</td>
		</tr>
		';
		$subtotal = 0;
		$subtotal_alkes = 0;
		foreach($list_dokter as $d){	
			$subtotalinner=0;
			$subtotal_alkesinner = 0;	
			foreach ($list_tindakan_pasien as $r) {
				if($d['idoprtr']==$r['idoprtr']){
					$subtotal = $subtotal + ($r['tumuminap']*$r['qtyyanri']); 
					$subtotalinner=$subtotalinner + ($r['tumuminap']*$r['qtyyanri']);
					$subtotal_alkes = $subtotal_alkes + ($r['tarifalkes']*$r['qtyyanri']);
					$subtotal_alkesinner = $subtotal_alkesinner + ($r['tarifalkes']*$r['qtyyanri']);
					$tumuminap = number_format($r['tumuminap'],0);
					$vtot = number_format($r['vtot'],0);
					$konten = $konten. "
					<tr>
					<td colspan=\"3\" align=\"center\">".$r['nmtindakan']." (".$r['kelas'].")</td>
					<td align=\"center\">".$r['nm_dokter']."</td>
					<td align=\"center\">".date('d-m-Y',strtotime($r['tgl_layanan']))."</td>
					<td align=\"center\">Rp. ".$tumuminap."</td>
					<td align=\"center\">".$r['qtyyanri']."</td>
					<td align=\"right\">Rp. ".($r['tumuminap']*$r['qtyyanri'])."</td>
					</tr>					
					";
				}
				
			}
			$konten = $konten."
				<tr>
						<td colspan=\"7\" align=\"right\">Total&nbsp;&nbsp;&nbsp;</td>
						<td align=\"right\">Rp. ".number_format($subtotalinner,0)."</td>
					</tr>
				";
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="center">Subtotal</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table> <br><br>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal,
					'subtotal_alkes' => $subtotal_alkes
					);
		return $result;
	}

	private function string_table_tindakan($list_tindakan_pasien){
		$konten = "";
		$konten= $konten.'
		<table class="table-isi" border="0">
		<tr>
		   	<td colspan="3" align="center">Tindakan</td>
		   	<td align="center">Pelaksana</td>
		  	<td align="center">Biaya Tindakan</td>
		  	<td align="center">Biaya Alkes</td>
		  	<td align="center">Qty</td>
		  	<td align="center">Total</td>
		</tr>
		';
		$subtotal = 0;
		$subtotal_alkes = 0;
		foreach ($list_tindakan_pasien as $r) {
			$subtotal = $subtotal + ($r['tumuminap']*$r['qtyyanri']); 
			$subtotal_alkes = $subtotal_alkes + ($r['tarifalkes']*$r['qtyyanri']);
			$tumuminap = number_format($r['tumuminap'],0);
			$vtot = number_format($r['vtot'],0);
			$konten = $konten. "
			<tr>
			<td colspan=\"3\" align=\"center\">".$r['nmtindakan']."</td>
			<td align=\"center\">".$r['nm_dokter']."</td>
			<td align=\"center\">Rp. ".$tumuminap."</td>
			<td align=\"center\">Rp. ".$r['tarifalkes']."</td>
			<td align=\"center\">".$r['qtyyanri']."</td>
			<td align=\"right\">Rp. ".$vtot."</td>
		</tr>
			";
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="center">Subtotal</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table> <br><br>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal,
					'subtotal_alkes' => $subtotal_alkes
					);
		return $result;
	}

	private function string_table_tindakan_perawat($list_tindakan_pasien){
		$konten = "";
		//<table class="table-isi" border="0">
		$konten= $konten.'
				
		';
		$subtotal = 0;
		$subtotal_vk = 0;
		$subtotal_alkes = 0;
		$subtotal_alkes_vk = 0;		

			foreach ($list_tindakan_pasien as $r) {
					//echo strpos($r['nmruang'],'anyelir');
					if(strpos($r['nmruang'],'Bersalin') || (strpos($r['nmruang'],'Anyelir') || strpos($r['nmruang'],'Anyelir')==0)){
						$subtotal_vk = $subtotal_vk + ($r['tumuminap']*$r['qtyyanri']); 
						$subtotal_alkes_vk = $subtotal_alkes_vk + ($r['tarifalkes']*$r['qtyyanri']);
						
					}else{
						$subtotal = $subtotal + ($r['tumuminap']*$r['qtyyanri']); 
						$subtotal_alkes = $subtotal_alkes + ($r['tarifalkes']*$r['qtyyanri']);
						$tumuminap = number_format($r['tumuminap'],0);
						$konten = $konten.'
							<tr>
								<td colspan="7" >Tindakan Perawat '.$r['nmruang'].'</td>
								<td align="right">'.number_format($subtotal,0).'</td>
							</tr>
						';
					}
			}
			if((int)$subtotal_vk!=0){
				$subtotal = $subtotal + $subtotal_vk; 
				$subtotal_alkes = $subtotal_alkes + $subtotal_alkes_vk;
				$konten = $konten.'
							<tr>
								<td colspan="7">Tindakan Perawat Anyelir</td>
								<td align="right">'.number_format($subtotal,0).'</td>
							</tr>
						';
			}
				
		//$konten = $konten."</table>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal,
					'subtotal_alkes' => $subtotal_alkes
					);
		return $result;
	}

	private function string_table_tindakan_dokter($list_tindakan_pasien){
		$konten = "";
		$konten= $konten.'
		<table class="table-isi" border="0">
		<tr>
		   	<td colspan="3" align="center">Tindakan</td>
		   	<td colspan="2" align="center">Pelaksana</td>
		  	<td align="center">Biaya Tindakan</td>		  	
		  	<td align="center">Qty</td>
		  	<td align="center">Total</td>
		</tr>
		';
			//<td align="center">Biaya Alkes</td>
		$subtotal = 0;
		$subtotal_alkes = 0;
		foreach ($list_tindakan_pasien as $r) {
			$vtottind=(int)$r['tumuminap']*(int)$r['qtyyanri'];
			//$subtotal = $subtotal + $r['endtotal']; 
			$subtotal = $subtotal + $vtottind;
			$subtotal_alkes = $subtotal_alkes + ($r['tarifalkes']*(int)$r['qtyyanri']);
			$tumuminap = number_format($r['tumuminap'],0);
			//$vtot = number_format($r['endtotal'],0);
			
			$konten = $konten. "
			<tr>
			<td colspan=\"3\" align=\"center\">".$r['nmtindakan']."</td>
			<td colspan=\"2\" align=\"center\">".$r['nm_dokter']."</td>
			<td align=\"center\">Rp. ".$tumuminap."</td>			
			<td align=\"center\">".$r['qtyyanri']."</td>
			<td align=\"right\">Rp. ".number_format($vtottind,0)."</td>
		</tr>
			";
			//<td align=\"center\">Rp. ".$r['tarifalkes']."</td>
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="center">Subtotal</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table> <br><br>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal,
					'subtotal_alkes' => $subtotal_alkes
					);
		return $result;
	}

	private function string_table_tindakan_dokter_kw($list_tindakan_pasien){
		$konten = "";
		/*<tr>
		   	<td colspan="3" align="center">Tindakan Rawat Inap</td>
		   	<td colspan="3" align="left">Pelaksana</td>
		  	<td colspan="2" align="center"></td>
		</tr>*/
		$konten= $konten.'
		<table class="table-isi" border="0">
		
		';
			//<td align="center">Biaya Alkes</td>
		$subtotal = 0;
		$subtotal_alkes = 0;
		foreach ($list_tindakan_pasien as $r) {
			$vtottind=(int)$r['tumuminap']*(int)$r['qtyyanri'];
			//$subtotal = $subtotal + $r['endtotal']; 
			$subtotal = $subtotal + $vtottind;
			$subtotal_alkes = $subtotal_alkes + ($r['tarifalkes']*(int)$r['qtyyanri']);
			$tumuminap = number_format($r['tumuminap'],0);
			//$vtot = number_format($r['endtotal'],0);
			
			$konten = $konten."
			<tr>
			<td colspan=\"3\" >".$r['nmtindakan']."</td>
			<td colspan=\"3\" align=\"left\">".$r['nm_dokter']."</td>
			<td colspan=\"2\" align=\"right\">".number_format($vtottind,0)."</td>
		</tr>
			";
			//<td align=\"center\">Rp. ".$r['tarifalkes']."</td>
		}
		/*$konten = $konten.'
				<tr>
					<td colspan="6" align="right">Subtotal</td>
					<td colspan="2" align="right">'.number_format($subtotal,0).'</td>
				</tr>
				';*/
		$konten = $konten."</table> <br><br>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal,
					'subtotal_alkes' => $subtotal_alkes
					);
		return $result;
	}

	private function string_table_ruang($list_tindakan_pasien){
		
		$subtotal = 0;
		//$subtotal_tind = 0;
		foreach ($list_tindakan_pasien as $r) {
			$subtotal = $subtotal + $r['vtot_ruang']; 
			//$subtotal_tind = $subtotal_tind + $r['vtot'];			
			
		}		
		$result = array('subtotal' => $subtotal
			//		'subtotal_tind' => $subtotal_tind
					);
		return $result;
	}


	private function string_table_icu($list_tindakan_pasien){
		$konten = "";
		$konten= $konten.'
		<table class="table-isi" border="0">
		<tr>
		   	<td colspan="3" align="center">Tindakan ICU</td>
		   	<td colspan="2" align="center">Pelaksana</td>
		  	<td align="center">Biaya Tindakan</td>		  	
		  	<td align="center">Qty</td>
		  	<td align="center">Total</td>
		</tr>
		';
			//<td align="center">Biaya Alkes</td>
		$subtotal = 0;$subtotalruang = 0;
		$subtotal_tind = 0;
		foreach ($list_tindakan_pasien as $r) {
			$vtottind=(int)$r['tumuminap']*(int)$r['qtyyanri'];
			//$subtotal = $subtotal + $r['endtotal']; 
			$subtotal = $subtotal + $vtottind;
			$subtotal_alkes = $subtotal_alkes + $r['tarifalkes'];
			$tumuminap = number_format($r['tumuminap'],0);
			
			//$vtot = number_format($r['endtotal'],0);
			
			$konten = $konten. "
			<tr>
			<td colspan=\"3\" align=\"center\">".$r['nmtindakan']." (".$r['kelas'].")</td>
			<td colspan=\"2\" align=\"center\">".$r['nm_dokter']."</td>
			<td align=\"center\">Rp. ".$tumuminap."</td>			
			<td align=\"center\">".$r['qtyyanri']."</td>
			<td align=\"right\">Rp. ".number_format($vtottind,0)."</td>
		</tr>
			";
			//<td align=\"center\">Rp. ".$r['tarifalkes']."</td>
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="center">Subtotal</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table> <br><br>";

		
		$result = array('subtotal' => $subtotal,
					//'subtotalruang' => $subtotalruang,
					'konten' => $konten,
					'subtotal_alkes' => $subtotal_alkes
					);
		return $result;
	}

	private function string_table_icu_kw($list_tindakan_pasien){
		$konten = "";
		/*<tr>
		   	<td colspan="3" align="center">Tindakan ICU</td>
		   	<td colspan="3" align="center">Pelaksana</td>
		  	<td colspan="2" align="center"></td>
		</tr>*/
		$konten= $konten.'
		<table class="table-isi" border="0">		
		';
			//<td align="center">Biaya Alkes</td>
		$subtotal = 0;$subtotalruang = 0;
		$subtotal_tind = 0;
		foreach ($list_tindakan_pasien as $r) {
			$vtottind=(int)$r['tumuminap']*(int)$r['qtyyanri'];
			//$subtotal = $subtotal + $r['endtotal']; 
			$subtotal = $subtotal + $vtottind;
			$subtotal_alkes = $subtotal_alkes + $r['tarifalkes'];
			$tumuminap = number_format($r['tumuminap'],0);
			
			//$vtot = number_format($r['endtotal'],0);
			
			$konten = $konten. "
			<tr>
			<td colspan=\"3\" align=\"center\">".$r['nmtindakan']." (".$r['kelas'].")</td>
			<td colspan=\"3\" align=\"center\">".$r['nm_dokter']."</td>
			<td colspan=\"2\" align=\"right\">Rp. ".number_format($vtottind,0)."</td>
		</tr>
			";
			//<td align=\"center\">Rp. ".$r['tarifalkes']."</td>
		}
		/*$konten = $konten.'
				<tr>
					<td colspan="7" align="center">Subtotal</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';*/
		$konten = $konten."</table>";

		
		$result = array('subtotal' => $subtotal,
					//'subtotalruang' => $subtotalruang,
					'konten' => $konten,
					'subtotal_alkes' => $subtotal_alkes
					);
		return $result;
	}

	private function string_table_vk_kw($list_tindakan_pasien,$kamar_konten,$totkamarvk){
		$konten = "";
		/*<tr>
		   	<td colspan="3" align="center">Tindakan VK</td>
		   	<td colspan="3" align="left">Pelaksana</td>
		  	<td colspan="2" align="center"></td>
		</tr>*/
		$konten= $konten.'
		<table class="table-isi" border="0">		
		'.$kamar_konten;
			//<td align="center">Biaya Alkes</td>
		$subtotal = 0;$subtotalruang = 0; $subtotal_alkes=0;
		$subtotal_tind = 0;
		foreach ($list_tindakan_pasien as $r) {
			$vtottind=(int)$r['tumuminap']*(int)$r['qtyyanri'];
			//$subtotal = $subtotal + $r['endtotal']; 
			$subtotal = $subtotal + $vtottind;
			$subtotal_alkes = $subtotal_alkes + $r['tarifalkes'];
			$tumuminap = number_format($r['tumuminap'],0);			
			//$vtot = number_format($r['endtotal'],0);
			
			$konten = $konten."
			<tr>
			<td colspan=\"3\" align=\"left\">".$r['nmtindakan']." (".$r['kelas'].")</td>
			<td colspan=\"3\" align=\"left\">".$r['nm_dokter']."</td>
			<td colspan=\"2\" align=\"right\"> ".number_format($vtottind,0)."</td>
		</tr>
			";
			//<td align=\"center\">Rp. ".$r['tarifalkes']."</td>
		}
		/*$konten = $konten.'
				<tr>
					<td colspan="6" align="right">Subtotal</td>
					<td colspan="2" align="right"> '.number_format($subtotal+$totkamarvk,0).'</td>
				</tr>
				';*/
		$konten = $konten."</table>";		
		$result = array('subtotal' => $subtotal,
					//'subtotalruang' => $subtotalruang,
					'konten' => $konten,
					'subtotal_alkes' => $subtotal_alkes
					);
		return $result;
	}

	private function string_table_vk($list_tindakan_pasien){
		$konten = "";
		$konten= $konten.'
		<table class="table-isi" border="0">
		<tr>
		   	<td colspan="3" align="center">Tindakan VK</td>
		   	<td colspan="2" align="center">Pelaksana</td>
		  	<td align="center">Biaya Tindakan</td>		  	
		  	<td align="center">Qty</td>
		  	<td align="center">Total Biaya</td>
		</tr>
		';
			//<td align="center">Biaya Alkes</td>
		$subtotal = 0;$subtotalruang = 0; $subtotal_alkes=0;
		$subtotal_tind = 0;
		foreach ($list_tindakan_pasien as $r) {
			$vtottind=(int)$r['tumuminap']*(int)$r['qtyyanri'];
			//$subtotal = $subtotal + $r['endtotal']; 
			$subtotal = $subtotal + $vtottind;
			$subtotal_alkes = $subtotal_alkes + $r['tarifalkes'];
			$tumuminap = number_format($r['tumuminap'],0);			
			//$vtot = number_format($r['endtotal'],0);
			
			$konten = $konten. "
			<tr>
			<td colspan=\"3\" align=\"center\">".$r['nmtindakan']." (".$r['kelas'].")</td>
			<td colspan=\"2\" align=\"center\">".$r['nm_dokter']."</td>
			<td align=\"center\">Rp. ".$tumuminap."</td>			
			<td align=\"center\">".$r['qtyyanri']."</td>
			<td align=\"right\">Rp. ".number_format($vtottind,0)."</td>
		</tr>
			";
			//<td align=\"center\">Rp. ".$r['tarifalkes']."</td>
		}
		$konten = $konten.'
				<tr>
					<td colspan="7" align="center">Subtotal</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table> <br><br>";		
		$result = array('subtotal' => $subtotal,
					//'subtotalruang' => $subtotalruang,
					'konten' => $konten,
					'subtotal_alkes' => $subtotal_alkes
					);
		return $result;
	}

	private function string_table_radiologi($list_radiologi){
		$konten = "";
		//<table border="1">
		$konten= $konten.'
		<table class="table-isi" border="0">
		<tr>
			<td colspan="3" align="center">Jenis Tind Radiologi</td>
			<td colspan="2" align="center">Dokter</td>
			<td colspan="2" align="center">Qty</td>
		</tr>
		';
		$subtotal = 0;
		foreach ($list_radiologi as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$konten = $konten. "
			<tr>
				<td colspan=\"3\" align=\"center\">".$r['jenis_tindakan']."</td>
				<td colspan=\"2\" align=\"center\">".$r['nm_dokter']."</td>
				<td colspan=\"2\" align=\"center\">".$r['qty']."</td>
			</tr>
			";
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" align="center">Subtotal</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table> <br><br>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_operasi($list_ok_pasien){
		$konten = "";
		$konten= $konten.'
		<table class="table-isi" border="0">
		<tr>
			<td colspan="3" align="center">Jenis Tind Operasi</td>
			<td colspan="3" align="left">Dokter</td>
			<td colspan="2" align="center"></td>
		</tr>
		';
		$subtotal = 0;
		foreach ($list_ok_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$konten = $konten. "
			<tr>
				<td colspan=\"3\" >".$r['jenis_tindakan']."</td>
				<td colspan=\"3\" align=\"left\">".$r['nm_dokter']."</td>
				<td colspan=\"2\" align=\"right\">".number_format($r['vtot'],0)."</td>
			</tr>
			";
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" align="right">Subtotal</td>
					<td colspan="2" align="right">'.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table> <br><br>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_operasi_kw($list_ok_pasien){
		$konten = "";
		$konten= $konten.'
		<table class="table-isi" border="0">		
		';
		/*<tr>
			<td colspan="3" align="center">Jenis Tind Operasi</td>
			<td colspan="3" align="left">Dokter</td>
			<td colspan="2" align="center"></td>
		</tr>*/
		$subtotal = 0;
		foreach ($list_ok_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$konten = $konten. "
			<tr>
				<td colspan=\"3\" >".$r['jenis_tindakan']."</td>
				<td colspan=\"3\" align=\"left\">".$r['nm_dokter']."</td>
				<td colspan=\"2\" align=\"right\">".number_format($r['vtot'],0)."</td>
			</tr>
			";
		}
		/*$konten = $konten.'
				<tr>
					<td colspan="6" align="right">Subtotal</td>
					<td colspan="2" align="right">'.number_format($subtotal,0).'</td>
				</tr>
				';*/
		$konten = $konten."</table>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_pa($list_pa_pasien){
		$konten = "";
		$konten= $konten.'
		<table class="table-isi" border="0">
		<tr>
			<td colspan="3" align="center">Jenis Tind PA</td>
			<td colspan="3" align="center">Dokter</td>			
			<td colspan="2" align="center"></td>
		</tr>
		';
		$subtotal = 0;
		foreach ($list_pa_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$konten = $konten. "
			<tr>
				<td colspan=\"3\" align=\"center\">".$r['jenis_tindakan']."</td>
				<td colspan=\"2\" align=\"left\">".$r['nm_dokter']."</td>
				<td colspan=\"2\" align=\"right\">".number_format($r['vtot'],0)."</td>
			</tr>
			";
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" align="right">Subtotal</td>
					<td align="right">'.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table><br><br>";
		//</table>
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_lab($list_lab_pasien){
		$konten = "";
		//<table border="1">
		$konten= $konten.'		
		<table class="table-isi" border="0">
		<tr>
		   	<td colspan="2" align="center">Jenis Tind Laboratorium</td>
		  	<td colspan="2" align="center">Dokter</td>
		  	<td align="center">Harga Satuan</td>
		  	<td align="center">Qty</td>
		  	<td align="center">Total</td>
		</tr>
		';
		$subtotal = 0;
		foreach ($list_lab_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_lab = number_format($r['biaya_lab'],0);
			$vtot = number_format($r['vtot'],0);
			$konten = $konten. "
			<tr>
			<td colspan=\"2\" align=\"center\">".$r['jenis_tindakan']."</td>
			<td colspan=\"2\" align=\"center\">".$r['nm_dokter']."</td>
			<td align=\"center\">Rp. ".$biaya_lab."</td>
			<td align=\"center\">".$r['qty']."</td>
			<td align=\"right\">Rp. ".$vtot."</td>
		</tr>
			";
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" align="center">Subtotal</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table><br><br>";
		//</table>
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_resep($list_resep){
		$konten = "";
		//<table border="1">
		$konten= $konten.'
		<table border="1">
		<tr>
		  	<td colspan="4" align="center">Nama Obat</td>
			<td align="center">Satuan Obat</td>
			<td align="center">Qty</td>
			<td align="center">Total</td>
		</tr>
		';
		$subtotal = 0;
		foreach ($list_resep as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$vtot = number_format($r['vtot'],0) ;
			$konten = $konten. "
			<tr>
			<td colspan=\"4\" align=\"center\">".$r['nama_obat']."</td>
			<td align=\"center\">".$r['Satuan_obat']."</td>
			<td align=\"center\">".$r['qty']."</td>
			<td align=\"right\">Rp. ".$vtot."</td>
		</tr>
			";
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" align="center">Subtotal</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table><br><br>";
		//</table>
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_ird($list_tindakan_ird){
		$konten = "";
		$konten= $konten.'
		<table border="1">
		<tr>
		    <td colspan="2" align="center">Tindakan</td>
			<td colspan="2" align="center">Dokter</td>
			<td align="center">Biaya</td>
			<td align="center">Qty</td>
			<td align="center">Total</td>
		</tr>
		';
		$subtotal = 0;
		foreach ($list_tindakan_ird as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_ird = number_format($r['biaya_ird'],0);
			$vtot = number_format($r['vtot'],0);
			$konten = $konten. "
			<tr>
			<td colspan=\"2\" align=\"center\">".$r['idtindakan']."</td>
			<td colspan=\"2\" align=\"center\">".$r['nm_dokter']."</td>
			<td align=\"center\">Rp. ".$biaya_ird."</td>
			<td align=\"center\">".$r['qty']."</td>
			<td align=\"right\">Rp. ".$vtot."</td>
		</tr>
			";
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" align="center">Subtotal</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table> <br><br>";
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_irj($poli_irj){
		$konten = "";		
		$konten= $konten.'
		<table class="table-isi" border="0">
		<tr>
		  	<td colspan="2" align="center">Tindakan IRJ</td>
		  	<td colspan="2" align="center">Dokter</td>
		  	<td align="center">Biaya</td>
		  	<td align="center">Qty</td>
		  	<td align="center">Total</td>
		</tr>
		';
		$subtotal = 0;
		foreach ($poli_irj as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_tindakan = number_format($r['biaya_tindakan'],0);
			$vtot = number_format($r['vtot'],0);
			$konten = $konten. "
			<tr>
				<td colspan=\"2\" align=\"center\">".$r['nmtindakan']."</td>
				<td colspan=\"2\" align=\"center\">".$r['nm_dokter']."</td>
				<td align=\"center\">Rp. ".$biaya_tindakan."</td>
				<td align=\"center\">".$r['qtyind']."</td>
				<td align=\"right\">Rp. ".$vtot."</td>
			</tr>
			";
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" align="right">Subtotal</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		$konten = $konten."</table><br><br>";
	
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}
	//end modul cetak laporan detail

	private function string_table_irj_kw($poli_irj){
		$konten = "";		
		$konten= $konten.'
		<table class="table-isi" border="0">
			<tr>
		  	<td colspan="3" align="center" > Tindakan IRJ</td>
		  	<td colspan="3" align="left">Dokter</td>
		  	<td colspan="2" align="center"></td>
		</tr>		
		';
		/**/
		$subtotal = 0;
		foreach ($poli_irj as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_tindakan = number_format($r['biaya_tindakan'],0);
			$vtot = number_format($r['vtot'],0);
			$konten = $konten. "
			<tr>
				<td colspan=\"3\" >".$r['nmtindakan']."</td>
				<td colspan=\"3\" align=\"left\">".$r['nm_dokter']."</td>
				<td colspan=\"2\" align=\"right\"> ".$vtot."</td>
			</tr>
			";
		}
		/*$konten = $konten.'
				<tr>
					<td colspan="6" align="right">Subtotal</td>
					<td colspan="2" align="right"> '.number_format($subtotal,0).'</td>
				</tr>
				';*/
		$konten = $konten."</table>";
	
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	public function insert_status(){
		$this->session->set_flashdata('pesan',
		"<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<i class='icon fa fa-check'></i> Data telah tersimpan!
		</div>");
		
		redirect('iri/ricstatus');
	}

	public function data_icd_1() {
		// 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		$keyword = $this->uri->segment(4);
		$data = $this->rimtindakan->select_icd_1_like($keyword);

		foreach($data as $row){
			
			$arr['query'] = $keyword;
			$arr['suggestions'][] 	= array(
				'value'				=>$row['id_icd']." - ".$row['nm_diagnosa'],
				'id_icd'				=>$row['id_icd'],
				'kode_icd'				=>$row['id_icd'],
				'nm_diagnosa'				=> $row['nm_diagnosa']
			);
		}
		echo json_encode($arr);

		// // 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		// $keyword = $this->uri->segment(4);
		// $data = $this->rimreservasi->select_pasien_irj_like($keyword);
		// foreach($data as $row){
		// 	$coba=strtotime($row['tgl_lahir']);
		// 	$date=date('d/m/Y', $coba);
			
		// 	$arr['query'] = $keyword;
		// 	$arr['suggestions'][] 	= array(
		// 		'value'				=>$row['no_register'],
		// 		'no_cm'				=>$row['no_medrec'],
		// 		'no_reg'			=>$row['no_register'],
		// 		'nama'				=>$row['nama'],
		// 		'jenis_kelamin'		=>$row['sex'],
		// 		'tanggal_lahir'		=>$date,
		// 		'telp'				=>$row['no_telp'],
		// 		'hp'				=>$row['no_hp'],
		// 		'id_poli'			=>'',
		// 		'poliasal'			=>'',
		// 		'id_dokter'			=>'',
		// 		'dokter'			=>'',
		// 		'diagnosa'			=>''
		// 		// 'id_poli'			=>$row['id_poli'],
		// 		// 'poliasal'			=>$row['poliasal'],
		// 		// 'id_dokter'			=>$row['id_dokter'],
		// 		// 'dokter'			=>$row['dokter'],
		// 		// 'diagnosa'			=>$row['diagnosa']
		// 	);
		// }
		// echo json_encode($arr);
    }

public function data_icd9cm() {
		// 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		$keyword = $this->uri->segment(4);
		$data = $this->rimtindakan->select_icd9cm_like($keyword);

		foreach($data as $row){
			
			$arr['query'] = $keyword;
			$arr['suggestions'][] 	= array(
				'value'				=>$row['id_tind']." - ".$row['nm_tindakan'],
				'id_tind'				=>$row['id_tind'],
				'kode_procedure'				=>$row['id_tind'],
				'nm_tindakan'				=> $row['nm_tindakan']
			);
		}
		echo json_encode($arr);
    }    

    private function clean($string) {
	   $str = str_replace(array('-', '<', '>', '&', '{', '}', '*'), array(' '), $string);
	   return $str; 
	}

	public function batalkan_pasien($no_ipd = ''){
		//cek semua tindakan yang pernah ada. kalo belum ada tindakan ga boleh batal
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		$no_ipd = $pasien[0]['no_ipd'];
		$no_register_asal = $pasien[0]['noregasal'];
		
		$status_bisa_batal = true;

		$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		if(($list_tindakan_pasien)){
			$status_bisa_batal = false;
		}

		$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd,$no_register_asal);
		if(($list_lab_pasien)){
			$status_bisa_batal = false;
		}
		$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$no_register_asal);//belum ada no_register
		if(($list_radiologi)){
			$status_bisa_batal = false;
		}
		$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd,$no_register_asal);
		if(($list_resep)){
			$status_bisa_batal = false;
		}
		$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($no_register_asal);
		if(($list_tindakan_ird)){
			$status_bisa_batal = false;
		}
		$poli_irj = $this->rimpasien->get_list_poli_rj_pasien($no_register_asal);
		if(($poli_irj)){
			$status_bisa_batal = false;
		}

		if($status_bisa_batal == true){
			//echo "bisa pulang";
			//hapus dulu ruangan

			$this->rimpasien->delete_ruang_iri_by_ipd($no_ipd);

			//flag bed jadi N
			$data_bed['isi'] = 'N'; 
			$this->rimkelas->flag_bed_by_id($data_bed, $pasien[0]['bed']);


			//hapus pasien
			$this->rimpasien->delete_pasien_iri($no_ipd);

			$this->session->set_flashdata('pesan',
			"<div class='alert alert-success alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-check'></i> Pasien telah dibatalkan!
			</div>");
			redirect('iri/ricpasien/');
		}else{
			//echo "tidak bisa ulang";
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-error alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-close'></i> Pasien tidak bisa dibatalkan karena sudah ada tindakan yang terinput!
			</div>");
			redirect('iri/ricstatus/index/'.$no_ipd);
		}
	}

	public function cetak_detail_farmasi($no_ipd=''){

		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);

		//kamari
		// if($pasien[0]['cetak_kwitansi'] != '1'){
		// 	$string_close_windows = "window.open('', '_self', ''); window.close();";
		// 	echo 'Kwintasi Harus Dicetak Terlebih Dahulu <button type="button" 
  //       onclick="'.$string_close_windows.'">Kembali</button>';
  //       	exit;
		// }
		//end 

		//list tidakan, mutasi, dll
		$status_paket = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if(($data_paket)){
			$status_paket = 1;
		}
		$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd,$pasien[0]['noregasal']);

		$nama_pasien = str_replace(" ","_",$pasien[0]['nama']);
		$file_name = "detail_pembayaran_".$pasien[0]['no_ipd']."_".$nama_pasien." .pdf";


		$konten = "";

		
		$konten = $konten.'<br><br><br><table border="1">';

		$grand_total = 0;
		$subsidi_total = 0;
		$total_alkes = 0;

		//resep
		if(($list_resep)){
			$result = $this->string_table_resep($list_resep);
			$grand_total = $grand_total + $result['subtotal'];
			// $konten = $konten."
			// <tr>
			// 	<td colspan=\"6\">Total Pembayaran Resep</td>
			// 	<td>Rp. ".number_format($result['subtotal'],0)."</td>
			// </tr>
			// ";
			$konten = $konten.$result['konten'];
		}

		$grand_total = $grand_total + $pasien[0]['biaya_administrasi'];

		// $konten = $this->string_data_pasien($pasien,$grand_total,$penerima,'').$konten;
		$konten = $this->string_data_pasien_utk_farmasi($pasien,$grand_total,"",'',$no_ipd).$konten;
		$tgl = date("Y-m-d");

		$tgl_indo = new Tglindo();
		$bulan_show = $tgl_indo->bulan(substr($tgl,6,2));
		$tahun_show = substr($tgl,0,4);
		$tanggal_show = substr($tgl,8,2);
		$tgl = $tanggal_show." ".$bulan_show." ".$tahun_show;

		$cterbilang= new rjcterbilang();
		// $vtot_terbilang=$cterbilang->terbilang($grand_total-$subsidi_total-$pasien[0]['diskon']);
		$vtot_terbilang=$cterbilang->terbilang($grand_total,1);
		$nomimal_charge = $pasien[0]['nilai_kkkd'] * $pasien[0]['persen_kk'] / 100;
		// $grand_total_string = "
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Dibayar Tunai   </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $pasien[0]['tunai'], 0 )."</p></th>
		// 	</tr>
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Dibayar Kartu Kredit / Debit   </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $pasien[0]['nilai_kkkd'], 0 )."</p></th>
		// 	</tr>
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Charge % </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".$pasien[0]['persen_kk']."</p></th>
		// 	</tr>
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Nominal Charge   </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $nomimal_charge, 0 )."</p></th>
		// 	</tr>
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Diskon   </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $pasien[0]['diskon'], 0 )."</p></th>
		// 	</tr>
		// 	<tr>
		// 		<th colspan=\"6\"><p align=\"right\"><b>Total   </b></p></th>
		// 		<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $grand_total-$subsidi_total-$pasien[0]['diskon'], 0)."</p></th>
		// 	</tr>
		// </table>
		// <br/><br/>
		// Terbilang<br>
		// ".strtoupper($vtot_terbilang)."
		// <br/><br/>
		// <table>
		// 	<tr>
		// 		<td></td>
		// 		<td></td>
		// 		<td>$tgl</td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 		<td></td>
		// 		<td>an.Kepala Rumah Sakit</td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 		<td></td>
		// 		<td>K a s i r</td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 		<td></td>
		// 		<td>----------------------------------------</td>
		// 	</tr>
		// 	<tr>
		// 		<td></td>
		// 		<td></td>
		// 		<td>ADMIN</td>
		// 	</tr>
		// </table>
		// ";

		// $konten = "<table style=\"padding:4px;\" border=\"0\">
		// 				<tr>
		// 					<td>
		// 						<p align=\"center\">
		// 							<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\" >
		// 						</p>
		// 					</td>
		// 				</tr>
		// 			</table>
		// 			<hr><br/><br/>".$konten.$grand_total_string;
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		$grand_total_string = "
		</table>
		<br><br><br>
		<table>
			<tr>
				<td></td>
				<td></td>
				<td>$tgl</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>an.Kepala Rumah Sakit</td>
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
				<td>$user</td>
			</tr>
		</table>
		";

		$konten = $konten.$grand_total_string;

		// $konten = "";


		// $konten = $konten.$this->string_data_pasien($pasien,0,'');

		// $grand_total = 0;
		// //mutasi ruangan pasien
		// if(($list_mutasi_pasien)){
		// 	$result = $this->string_table_mutasi_ruangan($list_mutasi_pasien,$pasien);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }


		// //tindakan
		// if(($list_tindakan_pasien)){
		// 	$result = $this->string_table_tindakan($list_tindakan_pasien);
		// 	$grand_total = $grand_total + $result['subtotal'];

		// 	$konten = $konten.$result['konten'];
		// 	//print_r($konten);exit;
		// }

		// //radiologi
		// if(($list_radiologi)){
		// 	$result = $this->string_table_radiologi($list_radiologi);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }

		// //lab
		// if(($list_lab_pasien)){
		// 	$result = $this->string_table_lab($list_lab_pasien);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }

		// //resep
		// if(($list_resep)){
		// 	$result = $this->string_table_resep($list_resep);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }

		// //ird
		// if(($list_tindakan_ird)){
		// 	$result = $this->string_table_ird($list_tindakan_ird);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }

		// //irj
		// if(($poli_irj)){
		// 	$result = $this->string_table_irj($poli_irj);
		// 	$grand_total = $grand_total + $result['subtotal'];
		// 	$konten = $konten.$result['konten'];
		// }

		// $grand_total_string = '
		// <table border="1">
		// 	<tr>
		// 		<td colspan="6" align="center">Grand Total</td>
		// 		<td align="right">Rp. '.number_format($grand_total,0).'</td>
		// 	</tr>
		// </table>
		// ';

		// $konten = '<table style=\"padding:4px;\" border=\"0\">
		// 				<tr>
		// 					<td>
		// 						<p align=\"center\">
		// 							<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\" >
		// 						</p>
		// 					</td>
		// 				</tr>
		// 			</table>
		// 			<hr><br/><br/>'.$konten.$grand_total_string;

		tcpdf();


		$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "Rincian Obat - ".$no_ipd." - ".$pasien[0]['nama'];;
		$tgl_cetak = date("j F Y");
		$obj_pdf->SetTitle($title);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins('5', '5', '5', '5');
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 9);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();

		// $obj_pdf = new TCPDF('P', PDF_UNIT, 'A5', true, 'UTF-8', false);
		// $obj_pdf->SetCreator(PDF_CREATOR);
		// $title = "Rincian Biaya Rawat Inap - ".$no_ipd." - ".$pasien[0]['nama'];
		// $tgl_cetak = date("j F Y");
		// $obj_pdf->SetTitle($file_name);
		// $obj_pdf->SetHeaderData('', '', $title, 'Tanggal Cetak - '.$tgl_cetak);
		// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		// $obj_pdf->SetDefaultMonospacedFont('helvetica');
		// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		// $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		// $obj_pdf->SetMargins('5', '5', '5', '5');
		// $obj_pdf->setPrintHeader(false);
		// $obj_pdf->setPrintFooter(false);
		// $obj_pdf->SetAutoPageBreak(TRUE, '5');
		// $obj_pdf->SetFont('helvetica', '', 10);
		// $obj_pdf->setFontSubsetting(false);
		// $obj_pdf->AddPage();
		ob_start();
			$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'/download/inap/laporan/pembayaran/'.$file_name, 'FI');
	}

	private function string_data_pasien_utk_farmasi($pasien,$grand_total,$penerima,$jenis_pembayaran,$no_ipd){
		// $konten="";
		// $format_tanggal = date("j F Y", strtotime($pasien[0]['tgl_masuk']));
		// $konten = $konten."
		// <table>
		// 	<tr>
		// 		<td>Nama</td>
		// 		<td>".$pasien[0]['nama']."</td>
		// 		<td>Tanggal Kunjungan</td>
		// 		<td>".$format_tanggal."</td>
		// 	</tr>
		// 	<tr>
		// 		<td>No CM</td>
		// 		<td>".$pasien[0]['no_cm']."</td>
		// 		<td>Ruang/Kelas/Bed</td>
		// 		<td>".$pasien[0]['nmruang']."/".$pasien[0]['kelas']."/".$pasien[0]['bed']."</td>
		// 	</tr>
		// 	<tr>
		// 		<td>No Register</td>
		// 		<td>".$pasien[0]['no_ipd']."</td>
		// 	</tr>
		// </table> <br><br> ";
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$tgl = date("d-m-Y");

		


		//tanda terima
		$penyetor = $penerima;


		//terbilang
		$cterbilang= new rjcterbilang();
		$vtot_terbilang=$cterbilang->terbilang($grand_total);

		$konten = "";
		// <table>
		// 				<tr>
		// 					<td></td>
		// 					<td></td>
		// 					<td></td>
		// 					<td><b>Tanggal-Jam: $tgl_jam</b></td>
		// 				</tr>
		// 			</table>

		// <tr>
		// 					<td width=\"20%\"><b>Sudah Terima Dari</b></td>
		// 					<td width=\"5%\"> : </td>
		// 					<td>".$penyetor."</td>
		// 				</tr>


		// <td><b>Banyak Ulang</b></td>
		// 					<td> : </td>
		// 					<td>".$vtot_terbilang."</td>
		$interval = date_diff(date_create(), date_create($pasien[0]['tgl_lahir']));

		$tambahan_jenis_pembayaran = "";
		if($jenis_pembayaran == "KREDIT"){
			$tambahan_jenis_pembayaran = " (KREDIT) ";
		}else{
			$tambahan_jenis_pembayaran = " (TUNAI) ";
		}


		$konten = $konten."<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					.table-font-size1{
						font-size:12px;
					    }
					</style>
					
					<table class=\"table-font-size\" border=\"0\">
						<tr>
						<td rowspan=\"3\" width=\"16%\" style=\"border-bottom:1px solid black; font-size:8px; \"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"30\" style=\"padding-right:5px;\"></p></td>
						<td rowspan=\"3\" width=\"40%\" style=\"border-bottom:1px solid black; font-size:8px;\"><b>".$this->config->item('namars')."</b> <br/> ".$this->config->item('alamat')."</td>
						<td width=\"10%\"></td>						
						</tr>
						<tr><td></td><td></td></tr>
						
					</table>
					
					
					<table >
						<tr>							
							<td><font size=\"8\" align=\"left\">$tgl_jam</font></td>
						</tr>			
						<tr>
							<td colspan=\"3\" ><font size=\"12\" align=\"center\"><u><b>RINCIAN OBAT PASIEN RAWAT INAP
					</b></u></font></td>
						</tr>	<br>		
							<tr>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td width=\"17%\"><b>NO REGISTER</b></td>
								<td width=\"2%\"> : </td>
								<td width=\"37%\">".$no_ipd."</td>
								<td width=\"19%\"><b>Tanggal Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td>".date("d-m-Y",strtotime($pasien[0]['tgl_masuk']))."</td>
							</tr>
							<tr>
								<td><b>Nama Pasien</b></td>
								<td> : </td>
								<td>".strtoupper($pasien[0]['nama'])."</td>
								<td ><b>No MR</b></td>
								<td > : </td>
								<td>".strtoupper($pasien[0]['no_cm'])."</td>
							</tr>
							<tr>
								<td ><b>Umur</b></td>
								<td > : </td>
								<td>".$interval->format("%Y Tahun, %M Bulan, %d Hari")."</td>
								
								<td ><b>Status Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($pasien[0]['carabayar'])."</td>
							</tr>
							
							<tr>
								<td><b>Alamat</b></td>
								<td> : </td>
								<td>".strtoupper($pasien[0]['alamat'])."</td>
								
							</tr>
					</table>";

		// $konten = $konten."
		// 			<p align=\"center\"><b>
		// 			Faktur $tambahan_jenis_pembayaran Rawat Inap<br/>
		// 			</b></p><br/>
		// 			<table>
						
		// 				<tr>
		// 					<td><b>NAMA PASIEN : </b></td>
							
		// 					<td>".$pasien[0]['nama']."</td>

		// 					<td><b>TGL.RAWAT : </b></td>
							
		// 					<td>".date("d/m/Y",strtotime($pasien[0]['tgl_masuk']) )." s/d ".date("d/m/Y", strtotime($pasien[0]['tgl_keluar'])) ."</td>
		// 				</tr>

		// 				<tr>
		// 					<td><b>UMUR : </b></td>
							
		// 					<td>".$interval->format("%Y Tahun, %M Bulan, %d Hari")."</td>

		// 					<td><b>GOLONGAN PASIEN : </b></td>
							
		// 					<td>".$pasien[0]['carabayar']."</td>
		// 				</tr>

		// 				<tr>
		// 					<td><b>ALAMAT : </b></td>
							
		// 					<td>".$pasien[0]['alamat']."</td>

		// 					<td><b>RUANGAN : </b></td>
							
		// 					<td>BED ".$pasien[0]['bed']." KELAS ".$pasien[0]['kelas']."</td>
		// 				</tr>
		// 			</table>
		// 			<br/><br/>
		// ";

		return $konten;
	}

	public function update_dokter(){
		$no_ipd = $this->input->post('no_ipd');
		$id_dokter = $this->input->post('id_dokter');
		$nmdokter = $this->input->post('nmdokter');

		$data['id_dokter'] = $id_dokter;
		$data['dokter'] = $nmdokter;

		$this->rimpendaftaran->update_pendaftaran_mutasi($data, $no_ipd);

		echo "1";
	}
}
