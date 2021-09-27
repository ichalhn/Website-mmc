<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
class Ricmutasi extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('iri/rimreservasi');
		$this->load->model('iri/rimtindakan');
		$this->load->model('iri/rimpendaftaran');
		$this->load->model('iri/rimkelas');
		$this->load->model('iri/rimpasien');
	}
	public function index($noreservasi=''){
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='';
		$data['pasien']='';
		$data['mutasi']='active';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		$data['kelas'] = $this->rimkelas->get_all_kelas_with_empty_bed();
		
		$no=count($this->rimpendaftaran->select_pasien_iri())+1;
		$data['no_ipd']='RI'.sprintf("%08d", $no);

		$irna_antrian=$this->rimpendaftaran->select_irna_antrian_by_noreservasi($noreservasi);
		$data['data_pasien'] = $irna_antrian;
		$data['pasien_lama'] = $this->rimreservasi->select_pasien_irj_by_ipd($irna_antrian[0]['no_register_asal']);

		$data['bed_by_idrg_kelas'] = $this->rimkelas->get_all_empty_bed_by_kelas_and_ruang($irna_antrian[0]['kelas'],$irna_antrian[0]['idrg']);

		//print_r($data['pasien']);exit;

		// $this->load->view('iri/rivlink');
		//$this->load->view('iri/rivheader');
		//$this->load->view('iri/rivmenu', $data);
		//$this->load->view('iri/rivmutasi');
		$this->load->view('iri/form_mutasi',$data);
		//$this->load->view('iri/rivfooter');
	}
	public function insert_mutasi(){

		// sama kayak ric pendaftaran
		$data_pendaftaran['noregasal']=$this->input->post('no_ipd');
		$data_pendaftaran['no_cm']=$this->input->post('no_medrec');
		$data_pendaftaran['tgldaftarri']=$this->input->post('tgldaftarri');


		//get data awal dari ipd lama
		$pasien_lama = $this->rimreservasi->select_pasien_irj_by_ipd($data_pendaftaran['noregasal']);
		//print_r($pasien_lama[0]);exit;
		$data_pendaftaran['carabayar']=$pasien_lama[0]['carabayar'];//sama kayak awal
		$data_pendaftaran['id_smf']=$pasien_lama[0]['id_smf']; // samakayak awal
		$data_pendaftaran['id_dokter']=$pasien_lama[0]['id_dokter'];// samakayak awal
		$data_pendaftaran['dokter']=$pasien_lama[0]['dokter'];// sama kayak awal
		
		$data_pendaftaran['no_ipd']= $this->input->post('no_ipd');
		$data_pendaftaran['noipdlama']=$this->input->post('no_ipd'); //done
		$data_pendaftaran['nama']=$this->input->post('nama');
		$data_pendaftaran['tgl_masuk']=date('Y-m-d');
		
		$data_ruang_iri['no_ipd']=$data_pendaftaran['no_ipd'];
		$temp_ruang=$this->input->post('ruang');
		$temp_ruang =explode("-", $temp_ruang);
		$data_reservasi['ruangpilih']=$temp_ruang[0]; // Kode ruang pilih
		// $data_reservasi['kelas']=$this->input->post('kelas'); // Kelas
		$data_reservasi['kelas']=$temp_ruang[2]; // Kelas

		$data_ruang_iri['kelas']=$temp_ruang[2];
		$data_ruang_iri['idrg']=$temp_ruang[0];
		$data_ruang_iri['bed']=$this->input->post('bed');

		if($data_ruang_iri['idrg']=='' or $data_ruang_iri['bed']==''){
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-error alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-close'></i> ID ruangan dan bed tidak boleh kosong !
			</div>");
			redirect('iri/ricmutasi/index/'.$this->input->post('no_reservasi'),'refresh');
		}

		$data_ruang_iri['tglmasukrg']=$this->input->post('tgldaftarri');
		$login_data = $this->load->get_var("user_info");
		$data_ruang_iri['xuser']=$login_data->username;
		$data_ruang_iri['statmasukrg']=$this->input->post('idrg_old');
		$data_ruang_iri['xupdate']=date('Y-m-d H:i:s');
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($data_ruang_iri['no_ipd']);
		//ngambil dari jatah kelas
		$data_ruang_iri['harga_jatah_kelas']= 0;
		// $biaya_ruang = $this->rimkelas->get_tarif_ruangan($pasien[0]['jatahklsiri'],$data_ruang_iri['idrg']);
		// if(!($biaya_ruang) || $data_pendaftaran['carabayar'] != 'DIJAMIN / JAMSOSKES'){
		// 	$data_ruang_iri['harga_jatah_kelas']= 0;
		// }else{
		// 	$data_ruang_iri['harga_jatah_kelas']=$biaya_ruang[0]['total_tarif'];
		// }

		//get biaya ruang
		$biaya_ruang = $this->rimkelas->get_tarif_ruangan($data_ruang_iri['kelas'],$data_ruang_iri['idrg']);
		$data_ruang_iri['vtot']=$biaya_ruang[0]['total_tarif'];
		$data_update_pasien_iri['vtot_ruang']=$biaya_ruang[0]['total_tarif'];

		//$this->rimpendaftaran->update_vtot_ruang(,$data_reservasi['vtot_ruang']);

		//echo $biaya_ruang[0]['total_tarif'];exit;
		// MENU
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		
		//cek kalo bed masih kosong, kalo udah diisi ga bisa
		$no_reservasi = $this->input->post('no_reservasi');
		$bed=$this->input->post('bed');
		$bed = $this->rimkelas->get_bed_by_bed($bed);
		if($bed[0]['isi'] == 'Y'){
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-error alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-close'></i> Bed Sudah Terisi, Silahkan Pilih Bed Lain!
			</div>");
			
			redirect('iri/ricmutasi/index/'.$no_reservasi,'refresh');
		}		

		//echo $pasien[0]['no_ipd'];
		//echo 'aaaaa'.($pasien[0]['lokasi']=='Ruang Bersalin' && ($pasien[0]['kelas']!=$temp_ruang[2]));		
		

		// DI EDIT SAMA MUFTI, GANTI JASA PERAWAT PER RUANGAN | AWAL

		$jasa_ruang = $this->rimpasien->get_persen_jasa_ruang($temp_ruang[0])->row();

		if($pasien[0]['kelas']=="VVIP"){
			$persen_jasa = $jasa_ruang->VVIP;
		}else if($pasien[0]['kelas']=="VIP"){
			$persen_jasa = $jasa_ruang->VIP;
		}else if($pasien[0]['kelas']=="UTAMA"){
			$persen_jasa = $jasa_ruang->UTAMA;
		}else if($pasien[0]['kelas']=="I"){
			$persen_jasa = $jasa_ruang->I;
		}else if($pasien[0]['kelas']=="II"){
			$persen_jasa = $jasa_ruang->II;
		}else if($pasien[0]['kelas']=="III"){
			$persen_jasa = $jasa_ruang->III;
		}else{
			$persen_jasa = 0;
		}

		$login_data = $this->load->get_var("user_info");
		$data_pasien_iri['xuser'] = $login_data->username;
		$data_pasien_iri['xupdate'] =date('Y-m-d H:i:s');
		if($pasien[0]['lokasi']=='Ruang Bersalin' && ($pasien[0]['kelas']!=$temp_ruang[2])){
			//update biaya VK
			$this->rimpendaftaran->update_tindakan($temp_ruang[2],$pasien[0]['idrg'],$this->input->post('no_ipd'));
			$this->rimpendaftaran->update_ruangan($temp_ruang[2],$pasien[0]['idrg'],$this->input->post('no_ipd'));

			$detailjasa=$this->rimpasien->get_detail_kelas($temp_ruang[2])->row();
			$total_per_kamar = $pasien[0]['vtot_ruang'] * $diff;
			$jasa_perawat=(double)$total_per_kamar * ((double)$persen_jasa/100);	
			$data_pasien_iri['jasa_perawat'] = $jasa_perawat;
		}else{
			//// add jasa perawat
			$lama_inap = 0;
			$start = new DateTime($pasien[0]['tglmasukrg']);//start
			$end = new DateTime(date("Y-m-d"));//end

			$diff = $end->diff($start)->format("%a");
			if($diff == 0){
				$diff = 1;
			}
			

			// $detailjasa=$this->rimpasien->get_detail_kelas($pasien[0]['kelas'])->row();
			$total_per_kamar = $pasien[0]['vtot_ruang'] * $diff;
			// if($pasien[0]['nmruang']=='Ruang ICU'){
			// 	$jasa_perawat=(double)$total_per_kamar * ((double)25/100);
			// }else
				$jasa_perawat=(double)$total_per_kamar * ((double)$persen_jasa/100);	
			$data_pasien_iri['jasa_perawat'] = $jasa_perawat;
			//echo $jasa_perawat;break;
			// $this->rimpendaftaran->update_ruang_mutasi($data_pasien_iri, $pasien[0]['idrgiri']);
			// echo $pasien[0]['idrgiri']."<br>";
			// echo json_encode($data_pasien_iri);
		}
		$data_pasien_iri['statkeluarrg'] = $data_ruang_iri['idrg'];
		$this->rimpendaftaran->update_ruang_mutasi($data_pasien_iri, $pasien[0]['idrgiri']);

		// DI EDIT SAMA MUFTI, GANTI JASA PERAWAT PER RUANGAN | AKHIR
		
		$data_update['statusantrian']='Y';
		$this->rimpendaftaran->update_irna_antrian($data_update, $this->input->post('no_reservasi'));

		//tambahan update mutasi di pasien iri. flag kalo dia mutasi.
		$data_update_pasien_iri['mutasi']=0;
		$data_update_pasien_iri['idrg']=$data_ruang_iri['idrg'];
		$data_update_pasien_iri['bed']=$data_ruang_iri['bed'];
		$data_update_pasien_iri['klsiri']=$data_ruang_iri['kelas'];
		$this->rimpendaftaran->update_pendaftaran_mutasi($data_update_pasien_iri, $this->input->post('no_ipd'));	


		
		////
		
		//print_r($data_pasien_iri);exit;
		
		//break;
		//update ruang iri yang dulu waktu keluarnya
		$this->rimpendaftaran->update_ruang_iri($data_ruang_iri['tglmasukrg'],$this->input->post('no_ipd'));

		//update bed menjadi untuk bed lama
		$data_bed['isi'] = 'N'; 
		$this->rimkelas->flag_bed_by_id($data_bed, $pasien_lama[0]['bed']);

		//update bed menjadi Y untuk bed baru
		$data_bed['isi'] = 'Y'; 
		$this->rimkelas->flag_bed_by_id($data_bed, $data_ruang_iri['bed']);

		$this->rimpendaftaran->insert_ruang_iri($data_ruang_iri);


		$this->session->set_flashdata('pesan',
		"<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<i class='icon fa fa-check'></i> Data telah tersimpan!
		</div>");

		redirect('iri/ricdaftar');
		//sama kayak ric pendaftaran
	}

	public function get_empty_bed_select(){
		$temp = $this->input->post('val');
		$temp = explode("-", $temp);
		$kelas = $this->rimkelas->get_all_empty_bed_by_kelas_and_ruang($temp[2],$temp[0]);
		$string_option = "";
		foreach ($kelas as $r) {
			$string_option = $string_option.'<option value="'.$r['bed'].' ">'.$r['bed'].'</option>';
		}
		echo $string_option;
	}

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
					'subsidi' => $total_subsidi);
		return $result;
	}
}
