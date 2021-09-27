<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include(dirname(dirname(__FILE__)).'/Tglindo.php');

require_once(APPPATH.'controllers/Secure_area.php');
class Rictest extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('iri/rimtest');

		$this->load->model('iri/rimpendaftaran');
		$this->load->model('iri/rimcara_bayar');
		$this->load->model('iri/rimkelas');
		$this->load->model('iri/rimreservasi');

	}

	public function index(){
		

		set_time_limit(999999999);

		$data_patria = $this->rimtest->get_all_data_pasien_patria();
		
		$count_bed_error = 0;

		foreach ($data_patria as $r) {
			$data_pasien = $this->rimtest->get_data_pasien_by_no_cm_patria($r['norekmed']);
			//kalo belum ada ada di data_pasien insert ini baru get no_medrecnya
			if(!($data_pasien)){
					$data_pendaftaran_pasien['nama'] = $r['nama'] ;
					$data_pendaftaran_pasien['no_cm'] = $r['norekmed'];
					$data_pendaftaran_pasien['golpskt'] = $r['golpaskt'];
					$this->rimtest->insert_data_pasien($data_pendaftaran_pasien);
					$no_medrec = $this->rimtest->get_last_no_medrec_data_pasien();

					//init data
					$no_medrec_data_pasien = $no_medrec[0]['no_medrec'];
			}else{
					//init data
					$no_medrec_data_pasien = $data_pasien[0]['no_medrec'];
			}

			$temp_cara_bayar = explode(" ", $r['golpaskt']);

			$temp_kamar = explode(" ", $r['ruangkt']);
			$data_pendaftaran['no_cm']=$no_medrec_data_pasien;//done
			$data_pendaftaran['tgldaftarri']=$r['tglmasuk'];//done
			$data_pendaftaran['carabayar']=$temp_cara_bayar[0];//done
			$data_pendaftaran['jatahklsiri']=$r['hakkelas'];
			$data_pendaftaran['nama']=$r['nama'];//done
			$data_pendaftaran['idrg']=$temp_kamar[1]; //done
			$temp_kelas = str_replace("KELAS ","", $r['kelas']);
			if($temp_kelas == "III"){
				$temp_kelas = $temp_kelas." B";
			}
			$data_pendaftaran['klsiri']=$temp_kelas; //done
			$data_ruang_iri['kelas']=$temp_kelas; //done
			$data_ruang_iri['idrg']=$temp_kamar[1];//done
			$data_ruang_iri['tglmasukrg']=$r['tglmasuk'];//done
			$data_pendaftaran['tgl_masuk']=$r['tglmasuk'];//done
			//get semua bed by kelas sama idrg yang kosong. ambil aja limit 1, masukin ke bed
			$array = explode(" ", $data_pendaftaran['klsiri']);
			$bed_kosong = $this->rimtest->get_empty_bed($data_pendaftaran['klsiri'],$data_pendaftaran['idrg']); 
			if(($bed_kosong)){
				$data_ruang_iri['bed']=$bed_kosong[0]['bed'];//done
			}else{
				//kalo kosong tambah bednya aja buat ruang itu. terus masukin dah bednya
				$new_bed['kelas'] = $data_pendaftaran['klsiri'];
				$new_bed['idrg'] = $data_pendaftaran['idrg'];
				$new_bed['isi'] = 'N';

				//buat penamaan bed
				switch ($array[0]) {
					case 'I':
						$kode_kelas_1 = 1;
						break;
					case 'II':
						$kode_kelas_1 = 2;
						break;
					case 'III':
						$kode_kelas_1 = 3;
						break;
					case 'VIP':
						$kode_kelas_1 = "V";
						break;
					default:
						# code...
						break;
				}
				if(isset($array[1])){
					$kode_kelas_gabung = $kode_kelas_1.$array[1];
				}else{
					$kode_kelas_gabung = $kode_kelas_1."0";
				}

				//buat nomor bed
				$temp_bed = $this->rimtest->get_bed($data_pendaftaran['klsiri'],$data_pendaftaran['idrg']);
				if(!($temp_bed)){
					$new_no_bed = "01";
				}else{
					$temp_no_bed = explode(" ", $temp_bed[0]['bed']);
					$new_no_bed = $temp_no_bed[2] + 1;
					if(strlen($new_no_bed) == 1){
						$new_no_bed = "0".$new_no_bed;
					}
				}
				$new_bed['bed'] = $data_pendaftaran['idrg']." ".$kode_kelas_gabung." ".$new_no_bed;

				//insert bed baru
				$data_bed_baru['bed'] = $new_bed['bed'];
				$data_bed_baru['kelas'] = $data_pendaftaran['klsiri'];
				$data_bed_baru['idrg'] = $data_pendaftaran['idrg'];
				$data_bed_baru['isi'] = 'N';
				$this->rimtest->insert_bed($data_bed_baru);

				$data_ruang_iri['bed'] = $new_bed['bed'];
			}

			$data_pendaftaran['noregasal']='';
			$data_pendaftaran['id_smf']='';
			$data_pendaftaran['id_dokter']='';
			$data_pendaftaran['dokter']='';
			$no=count($this->rimpendaftaran->select_pasien_iri())+1;
			$data_pendaftaran['no_ipd']='RI'.sprintf("%08d", $no);
			$data_pendaftaran['noipdlama']='';
			$data_pendaftaran['diagmasuk'] = '' ;
			$data_pendaftaran['nosjp']='';
			$data_pendaftaran['nopembayarri']='';
			$data_pendaftaran['id_kontraktor']='';
			$data_pendaftaran['ketpembayarri']='';
			$data_pendaftaran['nmpembayatri']='';
			$data_pendaftaran['golpembayarri']='';
			$data_pendaftaran['nmpjawabri']='';
			$data_pendaftaran['alamatpjawabri']='';
			$data_pendaftaran['notlppjawab']='';
			$data_pendaftaran['kartuidpjawab']='';
			$data_pendaftaran['noidpjawab']='';
			$data_pendaftaran['hubpjawabri']='';
			$data_ruang_iri['no_ipd']=$data_pendaftaran['no_ipd'];


			//cek kalo di tarif kosong, tambahin ke tarif tindakan
			$biaya_ruang = $this->rimkelas->get_tarif_ruangan($data_ruang_iri['kelas'],$data_pendaftaran['idrg']);
			
			if(!($biaya_ruang)){
				//ambil ruangan yang kelas itu yang ada aja pake like, terus insert
				// $biaya_ruang = $this->rimtest->get_tarif_ruangan($data_ruang_iri['kelas'],$data_pendaftaran['idrg']);
				$biaya_ruang = $this->rimtest->get_tarif_ruangan($array[0],$data_pendaftaran['idrg']);
				$tarif_tindakan_baru['id_tindakan'] =  $biaya_ruang[0]['id_tindakan'];
				$tarif_tindakan_baru['kelas'] =  $data_ruang_iri['kelas'];
				$tarif_tindakan_baru['jasa_sarana'] =  $biaya_ruang[0]['jasa_sarana'];
				$tarif_tindakan_baru['jasa_rs'] =  $biaya_ruang[0]['jasa_rs'];
				$tarif_tindakan_baru['jasa_dr'] =  $biaya_ruang[0]['jasa_dr'];
				$tarif_tindakan_baru['tanastesi'] =  $biaya_ruang[0]['tanastesi'];
				$tarif_tindakan_baru['total_tarif'] =  $biaya_ruang[0]['total_tarif'];
				$tarif_tindakan_baru['tarif_askin'] =  $biaya_ruang[0]['tarif_askin'];
				$tarif_tindakan_baru['tarif_askes'] =  $biaya_ruang[0]['tarif_askes'];
				$tarif_tindakan_baru['costshare'] =  $biaya_ruang[0]['costshare'];
				$tarif_tindakan_baru['idrg'] =  $biaya_ruang[0]['idrg'];
				$tarif_tindakan_baru['tarif_alkes'] =  $biaya_ruang[0]['tarif_alkes'];
				$this->rimtest->insert_tarif_tindakan($tarif_tindakan_baru);
			}

			//ngambil dari jatah kelas
			$biaya_ruang = $this->rimkelas->get_tarif_ruangan($data_pendaftaran['jatahklsiri'],$data_pendaftaran['idrg']);
			if(!($biaya_ruang) || $data_pendaftaran['carabayar'] != 'DIJAMIN / JAMSOSKES'){
				$data_ruang_iri['harga_jatah_kelas']= 0;
			}else{
				$data_ruang_iri['harga_jatah_kelas']=$biaya_ruang[0]['total_tarif'];
			}
			
			$data_pendaftaran['bed']=$data_ruang_iri['bed']; // Kode ruang pilih

			//get biaya ruang
			$biaya_ruang = $this->rimkelas->get_tarif_ruangan($data_ruang_iri['kelas'],$data_pendaftaran['idrg']);
			$data_ruang_iri['vtot']=$biaya_ruang[0]['total_tarif'];
			//$data_ruang_iri['vtot']=0;
			
			// MENU
			$data['reservasi']='';
			$data['daftar']='active';
			$data['pasien']='';
			$data['mutasi']='';
			$data['status']='';
			$data['resume']='';
			$data['kontrol']='';

			//cek kalo bed masih kosong, kalo udah diisi ga bisa
			$bed=$data_ruang_iri['bed'];
			$bed = $this->rimkelas->get_bed_by_bed($bed);
			if($bed[0]['isi'] == 'Y'){
				$count_bed_error = $count_bed_error + 1;
				//masukin yang errornya disini
			}
			$data_update['statusantrian']='Y';
			$data_bed['isi'] = 'Y'; 
			$this->rimkelas->flag_bed_by_id($data_bed, $data_ruang_iri['bed']);
			$this->rimpendaftaran->insert_ruang_iri($data_ruang_iri);
			$this->rimpendaftaran->insert_pendaftaran($data_pendaftaran);
		}

		// $data_pasien = $this->rimtest->get_data_pasien_by_no_cm_patria($data_patria[22]['norekmed']);
		// $data_pendaftaran_pasien['nama'] = $data_patria[22]['nama'] ;
		// $data_pendaftaran_pasien['no_cm'] = $data_patria[22]['norekmed'];
		// $data_pendaftaran_pasien['golpskt'] = $data_patria[22]['golpaskt'];
		// $this->rimtest->insert_data_pasien($data_pendaftaran_pasien);
		// $result = $this->rimtest->get_last_no_medrec_data_pasien();
		// print_r($result[0]['no_medrec']);
		// print_r($data_patria[22]);exit;
		exit;

		

	}
	
}
