 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
class rjcwebservice extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('irj/rjmpencarian','',TRUE);
		$this->load->model('irj/rjmpelayanan','',TRUE);
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->model('irj/M_update_sepbpjs','',TRUE);
	}
	public function index() {
		redirect('irj/rjcregistrasi');
	}
	public function update_nokartu() {
		$kartu_bpjs = $this->input->post('no_kartu');
		$nmr_medrec = $this->input->post('no_medrec');
		$data_update = array(
        		'no_kartu' => $kartu_bpjs,
        		'no_medrec' => $nmr_medrec,
      			);
        $this->rjmregistrasi->update_nokartu($no_kartu,$nmr_medrec,$data_update);		
		}
		// Cek nomor rujukan
	public function check_no_rujukan($no_rujukan='',$cara_kunjungan='') {
			if($no_rujukan==''){
				echo "Masukkan Nomor Rujukan";
			}else{
    			$data_bpjs = $this->M_update_sepbpjs->get_data_bpjs();
				$cons_id = $data_bpjs->consid;
				$sec_id = $data_bpjs->secid;		
				$url = $data_bpjs->service_url;		
				$timezone = date_default_timezone_get();
				date_default_timezone_set('UTC');
				$timestamp = strval(time()-strtotime('1970-01-01 00:00:00')); //cari timestamp
				$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
				$encoded_signature = base64_encode($signature);
				$http_header = array(
					   'Accept: application/json', 
					   'Content-type: application/json',
					   'X-Cons-ID: ' . $cons_id, //id rumah sakit
					   'X-Timestamp: ' . $timestamp,
					   'X-Signature: ' . $encoded_signature
				);
				date_default_timezone_set($timezone);
				//$ch = curl_init('http://api.asterix.co.id/SepWebRest/peserta/'.$no_kartu);
				if ($cara_kunjungan == 'RS') {
					$ch = curl_init($url . 'Rujukan/RS/'.$no_rujukan);
				}
				else {
					$ch = curl_init($url . 'Rujukan/'.$no_rujukan);
				}				
				curl_setopt($ch, CURLOPT_HTTPGET, true);
				// curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch);//json file
				curl_close($ch);
				 // echo '<pre>';
				 // print_r($sep);
	
					if($result!=''){//valid koneksi internet
					$sep = json_decode($result)->response;
					//echo $result;
					//print_r($sep->peserta);
					if ($sep->item=='') {
						echo "Nomor Rujukan \"<b>$no_rujukan</b>\" Tidak Ditemukan. <br> Silahkan masukkan nomor yang valid...";
					} else {
						echo $result;
					}
				 }else{
					echo "<div style=\"color:red;\">Pastikan Anda Terhubung Internet!!</div><br/>";
					//echo "Tidak ditemukan no Kartu: <b>$no_kartu<b/>";
				 }
			}
	}
	// cek nomor rujukan	
	public function check_no_kartu($no_cm='') {
		if($no_cm==''){
			echo "Masukan terlebih dulu nomor kartu BPJS/Askes anda";
		}else{
			$data_pasien=$this->rjmpelayanan->getdata_pasien($no_cm)->result();
			foreach($data_pasien as $row){
				$no_kartu=$row->no_kartu;
				$no_medrec=$row->no_medrec;
			}			

			if($no_kartu==''){
				echo "Masukan terlebih dulu nomor kartu BPJS/Askes anda";
			}else{
    			$data_bpjs = $this->M_update_sepbpjs->get_data_bpjs();
				$cons_id = $data_bpjs->consid;
				$sec_id = $data_bpjs->secid;		
				$url = $data_bpjs->service_url;					
				$timezone = date_default_timezone_get();
				date_default_timezone_set('Asia/Jakarta');
				$timestamp = time(); //cari timestamp
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
				//$ch = curl_init('http://api.asterix.co.id/SepWebRest/peserta/'.$no_kartu);
				$ch = curl_init($url . 'Peserta/peserta/'.$no_kartu);
				curl_setopt($ch, CURLOPT_HTTPGET, true);
				// curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch);//json file
				curl_close($ch);
				 // echo '<pre>';
				 // print_r($sep);
	
				if($result!=''){//valid koneksi internet
					$sep = json_decode($result)->response;
					//echo $result;
					//print_r($sep->peserta);
					if ($sep->peserta=='') {
						echo "No Kartu \"<b>$no_kartu</b>\" Tidak Ditemukan. <br> Silahkan memilih cara bayar yang lain...";
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

							if($kdKelas!=''){
								if($kdKelas=='1'){
									$kdKelas='I';
								}else if($kdKelas=='2'){
									$kdKelas='II';
								}else if($kdKelas=='3'){
									$kdKelas='III';
								}
								$data['kelas_bpjs']=$kdKelas;
								$id=$this->rjmregistrasi->update_pasien_irj($data,$no_medrec);
							}
							// print_r($value->jenisPeserta->nmJenisPeserta);
						};
					}
				 }else{
					echo "<div style=\"color:red;\">Pastikan Anda Terhubung Internet!!</div><br/>";
					//echo "Tidak ditemukan no Kartu: <b>$no_kartu<b/>";
				 }
			}
		}
	}

		public function validasi_kartu($no_cm='') {
		if($no_cm==''){
			echo "Masukan terlebih dulu nomor kartu BPJS/Askes anda";
		}else{
			$data_pasien=$this->rjmpelayanan->getdata_pasien($no_cm)->result();
			foreach($data_pasien as $row){
				$no_kartu=$row->no_kartu;
			}
			if($no_kartu==''){
				echo "Masukan terlebih dulu nomor kartu BPJS/Askes anda";
			}else{
    			$data_bpjs = $this->M_update_sepbpjs->get_data_bpjs();
				$cons_id = $data_bpjs->consid;
				$sec_id = $data_bpjs->secid;		
				$url = $data_bpjs->service_url;					
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
				//$ch = curl_init('http://api.asterix.co.id/SepWebRest/peserta/'.$no_kartu);
				$ch = curl_init($url . 'Peserta/peserta/'.$no_kartu);
				curl_setopt($ch, CURLOPT_HTTPGET, true);
				// curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch);//json file
				curl_close($ch);
				 // echo '<pre>';
				 // print_r($sep);
	
				if($result!=''){//valid koneksi internet
					$sep = json_decode($result)->response;
					//echo $result;
					//print_r($sep->peserta);
					if ($sep->peserta=='') {
						echo "No Kartu \"<b>$no_kartu</b>\" Tidak Ditemukan. <br> Silahkan memilih cara bayar yang lain...";
					} else {
					echo $result;
					}
				 }else{
					echo "<div style=\"color:red;\">Pastikan Anda Terhubung Internet!!</div><br/>";
					//echo "Tidak ditemukan no Kartu: <b>$no_kartu<b/>";
				 }
			}
		}
	}
	

}?>
