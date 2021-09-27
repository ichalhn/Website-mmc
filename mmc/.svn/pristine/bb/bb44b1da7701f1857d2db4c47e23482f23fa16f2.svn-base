<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include(dirname(dirname(__FILE__)).'/Tglindo.php');
require_once(APPPATH.'controllers/Secure_area.php');
class Riclaporan extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('iri/rimpasien');
		$this->load->model('iri/rimtindakan');
		$this->load->model('iri/rimkelas');
		$this->load->model('iri/rimuser');
		$this->load->helper('url');
		$this->load->model('irj/Rjmpencarian','',TRUE);
		$this->load->model('irj/Rjmpelayanan','',TRUE);
		$this->load->model('irj/Rjmkwitansi','',TRUE);
		$this->load->model('irj/Rjmlaporan','',TRUE);

		$this->load->helper('pdf_helper');
	}
	public function index(){
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		$tipe_input = $this->input->post('tampil_per');
		$tgl_awal = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		
		//echo $tipe_input;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tipe_input == ''){
			$tgl_awal = date("Y-m-d");
			$tgl_akhir = date("Y-m-d");
			// $data['list_keluar_masuk'] = $this->rimpasien->get_jml_keluar_masuk_by_range_date($tgl_awal,$tgl_akhir);
			$data['list_keluar_masuk'] = $this->rimpasien->get_jml_keluar_masuk_by_date($tgl_awal);
			$data['bulan_input'] = $bulan;
			$data['tahun_input'] = $tahun;
			//$this->load->view('iri/rivlink');
			$this->load->view('iri/list_laporan_harian',$data);
			
		}

		if($tipe_input == 'TGL'){
			// $data['list_keluar_masuk'] = $this->rimpasien->get_jml_keluar_masuk_by_range_date($tgl_awal,$tgl_akhir);
			$data['list_keluar_masuk'] = $this->rimpasien->get_jml_keluar_masuk_by_date($tgl_awal);
			$data['bulan_input'] = $bulan;
			$data['tahun_input'] = $tahun;
			//$this->load->view('iri/rivlink');
			$this->load->view('iri/list_laporan_harian',$data);
		
		}

		if($tipe_input == 'BLN'){
			$data['list_keluar_masuk'] = $this->rimpasien->get_jml_keluar_masuk_by_bulan($bulan);

			$data['bulan_input'] = $bulan;
			$data['tahun_input'] = $tahun;
			//$this->load->view('iri/rivlink');
			$this->load->view('iri/list_laporan',$data);
		}

		if($tipe_input == 'THN'){
			$data['list_keluar_masuk'] = $this->rimpasien->get_jml_keluar_masuk_by_tahun($tahun);
		}
	}

	public function log_user_action(){
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		$tgl_awal = $this->input->post('tgl_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');

		$data['tgl_awal'] = $tgl_awal;
		$data['tgl_akhir'] = $tgl_akhir;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tgl_awal != '' && $tgl_akhir != '' ){

			//satuan
			// $data['log_user_antrian'] = $this->rimuser->get_log_user_antrian_by_date($tgl_awal,$tgl_akhir);
			// $data['log_user_pasien'] = $this->rimuser->get_log_user_pasien_by_date($tgl_awal,$tgl_akhir);
			// $data['log_user_tindakan_temp'] = $this->rimuser->get_log_user_tindakan_temp_by_date($tgl_awal,$tgl_akhir);
			// $data['log_user_tindakan'] = $this->rimuser->get_log_user_tindakan_by_date($tgl_awal,$tgl_akhir);
			// $data['log_user_mutasi'] = $this->rimuser->get_log_user_mutasi_by_date($tgl_awal,$tgl_akhir);

			//semua
			$data['log_user_tindakan'] = $this->rimuser->get_log_user_all($tgl_awal,$tgl_akhir);
			$data['tgl_awal'] = $tgl_awal;
			$data['tgl_akhir'] = $tgl_akhir;
		}

		$this->load->view('iri/rivlink');
		// $this->load->view('iri/list_laporan_harian',$data);
		$this->load->view('iri/list_log_user',$data);
	}


	public function pendapatan_mr(){
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		//bikin object buat penanggalan
		$data['controller']=$this; 

		$tipe_input = $this->input->post('tampil_per');
		$tgl_awal = $this->input->post('tgl_awal');
		$jam_awal = $this->input->post('jam_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');
		$jam_akhir = $this->input->post('jam_akhir');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$user_biling = $this->input->post('user_biling');

		$data['list_user'] = $this->rimuser->get_all_user();		
		//echo $tipe_input;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tipe_input == ''){
			$tgl_awal = date("Y-m-d");
			$tgl_akhir = date("Y-m-d");
			$tgl_indo = new Tglindo();
			$data['bulan_show'] = $tgl_indo->bulan(substr($tgl_awal,6,2));
			$data['tahun_show'] = substr($tgl_awal,0,4);
			$data['tanggal_show'] = substr($tgl_awal,8,2);
			// $data['list_keluar_masuk'] = $this->rimpasien->get_total_pendapatan_by_range_date($tgl_awal,$tgl_akhir);
			
			$tgl_awal_gabung = $tgl_awal." 00:00";
			$tgl_akhir_gabung = $tgl_akhir." 23:59";

			$data['list_keluar_masuk'] = $this->rimpasien->get_list_pasien_keluar_by_tanggal($tgl_awal_gabung,$tgl_akhir_gabung,$user_biling);
			$data['list_keluar_ird'] = $this->rimpasien->get_list_pasien_keluar_ird_by_tanggal($tgl_awal_gabung,$tgl_akhir_gabung,$user_biling);
			$data['list_keluar_irj'] = $this->rimpasien->get_list_pasien_keluar_irj_by_tanggal($tgl_awal_gabung,$tgl_akhir_gabung,$user_biling);			

			$bulan_show = $tgl_indo->bulan(substr($tgl_awal_gabung,6,2));
			$tahun_show = substr($tgl_awal_gabung,0,4);
			$tanggal_show = substr($tgl_awal_gabung,8,2);
			$tgl_awal_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show." - ".$jam_awal;

			$bulan_show = $tgl_indo->bulan(substr($tgl_akhir_gabung,6,2));
			$tahun_show = substr($tgl_akhir_gabung,0,4);
			$tanggal_show = substr($tgl_akhir_gabung,8,2);
			$tgl_akhir_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show." - ".$jam_akhir;

			$data['tgl_awal_show'] = "";
			$data['tgl_akhir_show'] = "";
			$data['user_show'] = "";

			$data['tgl_awal'] = $tgl_awal_gabung;
			$data['tgl_akhir'] = $tgl_akhir_gabung;
			$data['user'] = $user_biling;
			$data['bulan_input'] = $bulan;
			$data['tahun_input'] = $tahun;
			$data['tipe_input'] = $tipe_input;
			$this->load->view('iri/rivlink');
			$this->load->view('iri/list_pendapatan_mr',$data);
			
		}

		if($tipe_input == 'TGL'){
			$tgl_indo = new Tglindo();
			$data['bulan_show'] = $tgl_indo->bulan(substr($tgl_awal,6,2));
			$data['tahun_show'] = substr($tgl_awal,0,4);
			$data['tanggal_show'] = substr($tgl_awal,8,2);

			
			$tgl_awal_gabung = $tgl_awal." ".$jam_awal;
			$tgl_akhir_gabung = $tgl_akhir." ".$jam_akhir;

			$data['list_keluar_masuk'] = $this->rimpasien->get_list_pasien_keluar_by_tanggal($tgl_awal_gabung,$tgl_akhir_gabung,$user_biling);
			$data['list_keluar_ird'] = $this->rimpasien->get_list_pasien_keluar_ird_by_tanggal($tgl_awal_gabung,$tgl_akhir_gabung,$user_biling);
			$data['list_keluar_irj'] = $this->rimpasien->get_list_pasien_keluar_irj_by_tanggal($tgl_awal_gabung,$tgl_akhir_gabung,$user_biling);
			
			$data['tgl_awal'] = $tgl_awal_gabung;
			$data['tgl_akhir'] = $tgl_akhir_gabung;
			$data['user'] = $user_biling;

			$bulan_show = $tgl_indo->bulan(substr($tgl_awal,6,2));
			$tahun_show = substr($tgl_awal,0,4);
			$tanggal_show = substr($tgl_awal,8,2);
			$tgl_awal_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show." - ".$jam_awal;

			$bulan_show = $tgl_indo->bulan(substr($tgl_akhir,6,2));
			$tahun_show = substr($tgl_akhir,0,4);
			$tanggal_show = substr($tgl_akhir,8,2);
			$tgl_akhir_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show." - ".$jam_akhir;

			$data['tgl_awal_show'] = date('d F Y',strtotime($tgl_awal))." - ".$jam_awal;//$tgl_awal_lengkap;
			$data['tgl_akhir_show'] = date('d F Y',strtotime($tgl_akhir))." - ".$jam_akhir;//$tgl_akhir_lengkap;
			$data['user_show'] = $user_biling;
			
			$data['tipe_input'] = $tipe_input;
			//$this->load->view('iri/rivlink');
			$this->load->view('iri/list_pendapatan_mr',$data);
			
		}
		
	}

	public function pendapatan(){
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		//bikin object buat penanggalan
		$data['controller']=$this; 

		$tipe_input = $this->input->post('tampil_per');
		$tgl_awal = $this->input->post('tgl_awal');
		$jam_awal = $this->input->post('jam_awal');
		$tgl_akhir = $this->input->post('tgl_akhir');
		$jam_akhir = $this->input->post('jam_akhir');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$user_biling = $this->input->post('user_biling');

		$data['list_user'] = $this->rimuser->get_all_user();
		
		//echo $tipe_input;exit;

		//kalo belum ada input. tampilin bulan sekarang. kalo ada input taun pake yang itu
		if($tipe_input == ''){
			$tgl_awal = date("Y-m-d");
			$tgl_akhir = date("Y-m-d");
			$tgl_indo = new Tglindo();
			$data['bulan_show'] = $tgl_indo->bulan(substr($tgl_awal,6,2));
			$data['tahun_show'] = substr($tgl_awal,0,4);
			$data['tanggal_show'] = substr($tgl_awal,8,2);
			// $data['list_keluar_masuk'] = $this->rimpasien->get_total_pendapatan_by_range_date($tgl_awal,$tgl_akhir);
			
			$tgl_awal_gabung = $tgl_awal." 00:00";
			$tgl_akhir_gabung = $tgl_akhir." 23:59";

			$data['list_keluar_masuk'] = $this->rimpasien->get_list_pasien_keluar_by_tanggal($tgl_awal_gabung,$tgl_akhir_gabung,$user_biling);
			$data['list_keluar_ird'] = $this->rimpasien->get_list_pasien_keluar_ird_by_tanggal($tgl_awal_gabung,$tgl_akhir_gabung,$user_biling);
			$data['list_keluar_irj'] = $this->rimpasien->get_list_pasien_keluar_irj_by_tanggal($tgl_awal_gabung,$tgl_akhir_gabung,$user_biling);
			$data['list_pasien_lab_luar'] = $this->rimpasien->get_list_pasien_luar_lab($tgl_awal_gabung,$tgl_akhir_gabung,$user_biling);
			$data['list_pasien_rad_luar'] = $this->rimpasien->get_list_pasien_luar_rad($tgl_awal_gabung,$tgl_akhir_gabung,$user_biling);
			$data['list_pasien_obat_luar'] = $this->rimpasien->get_list_pasien_luar_obat($tgl_awal_gabung,$tgl_akhir_gabung,$user_biling);

			$bulan_show = $tgl_indo->bulan(substr($tgl_awal_gabung,6,2));
			$tahun_show = substr($tgl_awal_gabung,0,4);
			$tanggal_show = substr($tgl_awal_gabung,8,2);
			$tgl_awal_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show." - ".$jam_awal;

			$bulan_show = $tgl_indo->bulan(substr($tgl_akhir_gabung,6,2));
			$tahun_show = substr($tgl_akhir_gabung,0,4);
			$tanggal_show = substr($tgl_akhir_gabung,8,2);
			$tgl_akhir_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show." - ".$jam_akhir;

			$data['tgl_awal_show'] = "";
			$data['tgl_akhir_show'] = "";
			$data['user_show'] = "";

			$data['tgl_awal'] = $tgl_awal_gabung;
			$data['tgl_akhir'] = $tgl_akhir_gabung;
			$data['user'] = $user_biling;
			$data['bulan_input'] = $bulan;
			$data['tahun_input'] = $tahun;
			$data['tipe_input'] = $tipe_input;
			$this->load->view('iri/rivlink');
			$this->load->view('iri/list_pendapatan',$data);
			
		}

		if($tipe_input == 'TGL'){
			$tgl_indo = new Tglindo();
			$data['bulan_show'] = $tgl_indo->bulan(substr($tgl_awal,6,2));
			$data['tahun_show'] = substr($tgl_awal,0,4);
			$data['tanggal_show'] = substr($tgl_awal,8,2);

			
			$tgl_awal_gabung = $tgl_awal." ".$jam_awal;
			$tgl_akhir_gabung = $tgl_akhir." ".$jam_akhir;

			$data['list_keluar_masuk'] = $this->rimpasien->get_list_pasien_keluar_by_tanggal($tgl_awal_gabung,$tgl_akhir_gabung,$user_biling);
			$data['list_keluar_ird'] = $this->rimpasien->get_list_pasien_keluar_ird_by_tanggal($tgl_awal_gabung,$tgl_akhir_gabung,$user_biling);
			$data['list_keluar_irj'] = $this->rimpasien->get_list_pasien_keluar_irj_by_tanggal($tgl_awal_gabung,$tgl_akhir_gabung,$user_biling);
			$data['list_pasien_lab_luar'] = $this->rimpasien->get_list_pasien_luar_lab($tgl_awal_gabung,$tgl_akhir_gabung,$user_biling);
			$data['list_pasien_rad_luar'] = $this->rimpasien->get_list_pasien_luar_rad($tgl_awal_gabung,$tgl_akhir_gabung,$user_biling);
			$data['list_pasien_obat_luar'] = $this->rimpasien->get_list_pasien_luar_obat($tgl_awal_gabung,$tgl_akhir_gabung,$user_biling);
			
			$data['tgl_awal'] = $tgl_awal_gabung;
			$data['tgl_akhir'] = $tgl_akhir_gabung;
			$data['user'] = $user_biling;

			$bulan_show = $tgl_indo->bulan(substr($tgl_awal,6,2));
			$tahun_show = substr($tgl_awal,0,4);
			$tanggal_show = substr($tgl_awal,8,2);
			$tgl_awal_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show." - ".$jam_awal;

			$bulan_show = $tgl_indo->bulan(substr($tgl_akhir,6,2));
			$tahun_show = substr($tgl_akhir,0,4);
			$tanggal_show = substr($tgl_akhir,8,2);
			$tgl_akhir_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show." - ".$jam_akhir;

			$data['tgl_awal_show'] = date('d F Y',strtotime($tgl_awal))." - ".$jam_awal;//$tgl_awal_lengkap;
			$data['tgl_akhir_show'] = date('d F Y',strtotime($tgl_akhir))." - ".$jam_akhir;//$tgl_akhir_lengkap;
			$data['user_show'] = $user_biling;

			$data['bulan_input'] = $bulan;
			$data['tahun_input'] = $tahun;
			$data['tipe_input'] = $tipe_input;
			$this->load->view('iri/rivlink');
			$this->load->view('iri/list_pendapatan',$data);
			
		}

		if($tipe_input == 'BLN'){
			$tgl_indo = new Tglindo();
			$data['bulan_show'] = $tgl_indo->bulan(substr($bulan,6,2));
			$data['tahun_show'] = substr($bulan,0,4);

			$data['list_keluar_masuk'] = $this->rimpasien->get_total_pendapatan_by_bulan($bulan);
			$data['bulan_input'] = $bulan;
			$data['tahun_input'] = $tahun;
			$data['tipe_input'] = $tipe_input;
			$this->load->view('iri/rivlink');
			$this->load->view('iri/list_pendapatan_bulanan',$data);
		}

		if($tipe_input == 'THN'){
			$data['list_keluar_masuk'] = $this->rimpasien->get_total_pendapatan_by_tahun($tahun);
		}
	}

	public function cetak_laporan_bln($bulan=''){

		$data_keuangan_bulanan = $this->rimpasien->get_total_pendapatan_by_bulan($bulan);
		$logo=$this->config->item('logo_url');

		//ambil data rs
		//$data_rs = $this->rimkelas->get_data_rs('10000');
		$konten = '<table style="padding:4px;" border="0">
		<tr><td><p align="center"><img src="asset/images/logos/"'.$this->config->item('logo_url').'" alt="img" height="42" ></p></td></tr></table>
					<hr><br/><br/>
		<table>
				<tr>
					<td colspan="3"><p align="center"><b>Laporan Keuangan Rawat Inap Bulan '.$bulan.'</b></p></td>
				</tr>
				<tr>
					<td colspan="3"><p align="center"><b>'.$this->config->item('namars').'</b></p></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				</table>
			<br/>
			<hr/>';
		$konten = $konten.'
		<table >
			<tr>
				<th>Tanggal</th>
				<th>Jumlah Pendapatan</th>
				<th>Jumlah Diskon</th>
				<th>Jumlah Pendapatan Total</th>
				<th>Jumlah Pendapatan Tunai</th>
				<th>Jumlah Diskon Tunai</th>
				<th>Jumlah Tunai Total</th>
				<th>Jumlah Pendapatan Kredit</th>
				<th>Jumlah Diskon Kredit</th>
				<th>Jumlah Kredit Total</th>
			</tr> ';

	  	$total = 0;
  		$total_diskon = 0;
	  	$total_tunai = 0;
	  	$total_diskon_tunai = 0;
	  	$total_kredit = 0;
	  	$total_diskon_kredit = 0;
	  	$tgl_indo = new Tglindo();
	  	foreach ($data_keuangan_bulanan as $r) { 

	  	$bulan_show = $tgl_indo->bulan(substr($r['tgl_keluar'],6,2));
		$tahun_show = substr($r['tgl_keluar'],0,4);
		$tanggal_show = substr($r['tgl_keluar'],8,2);
		$tgl_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show;

  		$total = $total + $r['vtot_per_tgl'];
		$total_diskon = $total_diskon + $r['vtot_diskon_per_tgl'];
  		$total_tunai = $total_tunai + $r['vtot_tunai_per_tgl'];
  		$total_diskon_tunai = $total_diskon_tunai + $r['vtot_diskon_tunai_per_tgl'];
  		$total_kredit = $total_kredit + $r['vtot_kredit_per_tgl'];
  		$total_diskon_kredit = $total_diskon_kredit + $r['vtot_diskon_kredit_per_tgl'] ;
		$konten = $konten.'	
		  	<tr>
		  		<td>'.date("j F Y", strtotime($r['tgl_keluar'])).'</td>
		  		<td align="right">Rp. '.number_format($r['vtot_per_tgl'] + $r['vtot_diskon_per_tgl'],0) .'</td>
		  		<td align="right">Rp. '.number_format($r['vtot_diskon_per_tgl'],0) .'</td>
		  		<td align="right">Rp. '.number_format($r['vtot_per_tgl'],0) .'</td>
		  		<td align="right">Rp. '.number_format($r['vtot_tunai_per_tgl'] + $r['vtot_diskon_tunai_per_tgl'],0) .'</td>
		  		<td align="right">Rp. '.number_format($r['vtot_diskon_tunai_per_tgl'],0) .'</td>
		  		<td align="right">Rp. '.number_format($r['vtot_tunai_per_tgl'],0) .'</td>
		  		<td align="right">Rp. '.number_format($r['vtot_kredit_per_tgl'] + $r['vtot_diskon_kredit_per_tgl'],0) .'</td>
		  		<td align="right">Rp. '.number_format($r['vtot_diskon_kredit_per_tgl'],0) .'</td>
		  		<td align="right">Rp. '.number_format($r['vtot_kredit_per_tgl'],0) .'</td>

		  	</tr> ';
	  	}
	  	$konten = $konten.'
		  	<tr>
				<td align="right">Total Pembayaran</td>
				<td align="right">Rp. '.number_format($total+$total_diskon,0) .'</td>
				<td align="right">Rp. '.number_format($total_diskon,0) .'</td>
				<td align="right">Rp. '.number_format($total,0) .'</td>
				<td align="right">Rp. '.number_format($total_tunai+$total_diskon_tunai,0) .'</td>
				<td align="right">Rp. '.number_format($total_diskon_tunai,0) .'</td>
				<td align="right">Rp. '.number_format($total_tunai,0) .'</td>
				<td align="right">Rp. '.number_format($total_kredit+$total_diskon_kredit,0) .'</td>
				<td align="right">Rp. '.number_format($total_diskon_kredit,0) .'</td>
				<td align="right">Rp. '.number_format($total_kredit,0) .'</td>
			</tr>
		</table>
		';


		$file_name = "Laporan_Keuangan_Bln_.pdf";
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
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
			$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'/download/inap/laporan/pembayaran/'.$file_name, 'FI');
	}

	public function cetak_laporan_harian($tgl_awal=''){
		
		$data_pasien_keluar_tanggal = $this->rimpasien->get_list_pasien_keluar_by_tanggal($tgl_awal);

		//ambil data rs
		//$data_rs = $this->rimkelas->get_data_rs('10000');
		$konten = '<table style="padding:4px;" border="0">
						<tr>
							<td>
								<p align="center">
									<img src="asset/images/logos/"'.$this->config->item('logo_url').'"" alt="img" height="42" >
								</p>
							</td>
						</tr>
					</table>
					<hr><br/><br/>
		<table>
				<tr>
					<td colspan="3"><p align="center"><b>Laporan Keuangan Rawat Inap Tanggal '.$tgl_awal.'</b></p></td>
				</tr>
				<tr>
					<td colspan="3"><p align="center"><b>'.$this->config->item('namars').'</b></p></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				</table>
			<br/>
			<hr/>';
		$konten = $konten.'
		<table >
		<tr>
			<th>Tanggal</th>
			<th>No Registrasi</th>
			<th>Nama Pasien</th>
			<th>Jenis Pembayaran</th>
			<th>Sub Total</th>
			<th>Diskon</th>
			<th>Total Bayar</th>
		</tr>
		';	
	  	$total = 0;
	  	$total_diskon = 0;
	  	$tgl_indo = new Tglindo();

	  	foreach ($data_pasien_keluar_tanggal as $r) {
	  		$bulan_show = $tgl_indo->bulan(substr($r['tgl_keluar'],6,2));
			$tahun_show = substr($r['tgl_keluar'],0,4);
			$tanggal_show = substr($r['tgl_keluar'],8,2);
			$tgl_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show;

	  		$total = $total + $r['vtot'];
	  		$diskon = $r['diskon'];
	  		if($diskon == '' || $diskon == NULL){
	  			$diskon = 0;
	  		}
	  		$total_diskon = $total_diskon + $diskon;
	  		$total_disp_bayar_dan_diskon = number_format($r['vtot'] + $diskon,0);
	  		if($r['jenis_bayar'] == "TUNAI"){
	  			$total_bayar_tunai = $total_bayar_tunai + $r['vtot'];
	  			$total_diskon_tunai = $total_diskon_tunai + $r['diskon'];
	  		}else{
	  			$total_bayar_kredit = $total_bayar_kredit + $r['vtot'];
	  			$total_diskon_kredit = $total_diskon_kredit + $r['diskon'];
	  		}
		$konten = $konten . '
	  	<tr>
	  		<td>'.$tgl_lengkap.'</td>
	  		<td>'.$r['no_ipd'].'</td>
	  		<td>'.$r['nama'].'</td>
	  		<td>'.$r['jenis_bayar'].'</td>
	  		<td align="right">Rp. '.$total_disp_bayar_dan_diskon.' </td>
	  		<td align="right">Rp. '.number_format($diskon,0).'</td>
	  		<td align="right">Rp. '.number_format($r['vtot'],0).'</td>
	  	</tr>
		';
		}
		$total_disp_all_bayar_dan_diskon = number_format($total+$total_diskon,0);
		$total_disp_all_bayar_dan_diskon_tunai = number_format($total_bayar_tunai+$total_diskon_tunai,0);
		$total_disp_all_bayar_dan_diskon_kredit = number_format($total_bayar_kredit+$total_diskon_kredit,0);
		$konten = $konten .'
		  	<tr>
				<td colspan="4" align="right">Total Pembayaran</td>
				<td align="right">Rp. '.$total_disp_all_bayar_dan_diskon.'</td>
				<td align="right">Rp. '.number_format($total_diskon,0).'</td>
				<td align="right">Rp. '.number_format($total,0).'</td>
			</tr>
			<tr>
				<td colspan="4" align="right">Total Tunai</td>
				<td align="right">Rp. '.$total_disp_all_bayar_dan_diskon_tunai.'</td>
				<td align="right">Rp. '.number_format($total_diskon_tunai,0).'</td>
				<td align="right">Rp. '.number_format($total_bayar_tunai,0).'</td>
			</tr>
			<tr>
				<td colspan="4" align="right">Total Kredit</td>
				<td align="right">Rp. '.$total_disp_all_bayar_dan_diskon_kredit.'</td>
				<td align="right">Rp. '.number_format($total_diskon_kredit,0).'</td>
				<td align="right">Rp. '.number_format($total_bayar_kredit,0).'</td>
			</tr>
		</table>
		';


		$file_name = "Laporan_Keuangan_Harian_.pdf";
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
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
			$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'/download/inap/laporan/pembayaran/'.$file_name, 'FI');
	}

	//keperluan tanggal
	public function obj_tanggal(){
		 $tgl_indo = new Tglindo();
		 return $tgl_indo;
	}

	public function cetak_laporan_harian_excel($tgl_awal='',$tgl_akhir="",$user=""){
		require_once (APPPATH.'third_party/PHPExcel.php');

      set_time_limit(0);

      $tgl_awal = urldecode($tgl_awal);
      $tgl_akhir = urldecode($tgl_akhir);

      //load our new PHPExcel library
      //$this->load->library('excel');
      //$this->excel = new PHPExcel();

      $excel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_pendapatan_harian.xls");

      //activate worksheet number 1
      $excel->setActiveSheetIndex(0);
      //name the worksheet
      $excel->getActiveSheet()->setTitle('Worksheet 1');

      //ambil semua data pendapatan
      $list_keluar_masuk = $this->rimpasien->get_list_pasien_keluar_by_tanggal($tgl_awal,$tgl_akhir,$user);
	$list_keluar_ird = $this->rimpasien->get_list_pasien_keluar_ird_by_tanggal($tgl_awal,$tgl_akhir,$user);
	$list_keluar_irj = $this->rimpasien->get_list_pasien_keluar_irj_by_tanggal($tgl_awal,$tgl_akhir,$user);
	$list_pasien_lab_luar = $this->rimpasien->get_list_pasien_luar_lab($tgl_awal,$tgl_akhir,$user);
	$list_pasien_rad_luar = $this->rimpasien->get_list_pasien_luar_rad($tgl_awal,$tgl_akhir,$user);
	$list_pasien_obat_luar = $this->rimpasien->get_list_pasien_luar_obat($tgl_awal,$tgl_akhir,$user);
      //print_r($data_pasien_keluar_tanggal[0]);exit;
      $row = 5;
      //set header excel
      // $this->excel->getActiveSheet()->setCellValue('A'.$row, 'UPT');
      // $this->excel->getActiveSheet()->setCellValue('B'.$row, 'Unit');
      // $this->excel->getActiveSheet()->setCellValue('C'.$row, 'Nama Aset');
      // $this->excel->getActiveSheet()->setCellValue('D'.$row, 'Merk');
      // $this->excel->getActiveSheet()->setCellValue('E'.$row, 'No Seri');
      // $this->excel->getActiveSheet()->setCellValue('F'.$row, 'Kondisi');
      // $this->excel->getActiveSheet()->setCellValue('G'.$row, 'PIC');
      // $this->excel->getActiveSheet()->setCellValue('H'.$row, 'No Inventaris');
      // $this->excel->getActiveSheet()->setCellValue('I'.$row, 'IP Address');
      // $this->excel->getActiveSheet()->setCellValue('J'.$row, 'Perolehan');
      // $this->excel->getActiveSheet()->setCellValue('K'.$row, 'Lokasi');
      
       	$tgl_indo = new Tglindo();

  		$bulan_show = $tgl_indo->bulan(substr($tgl_awal,6,2));
		$tahun_show = substr($tgl_awal,0,4);
		$tanggal_show = substr($tgl_awal,8,2);
		$jam_show = substr($tgl_awal,11,5);
		$tgl_awal_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show." - ".$jam_show;

		$bulan_show = $tgl_indo->bulan(substr($tgl_akhir,6,2));
		$tahun_show = substr($tgl_akhir,0,4);
		$tanggal_show = substr($tgl_akhir,8,2);
		$jam_show = substr($tgl_akhir,11,5);
		$tgl_akhir_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show." - ".$jam_show;


      $excel->getActiveSheet()->setCellValue('A1', "Laporan Pendapatan Kasir : ".$user,PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('A2', "Tanggal : ".date('d F Y', strtotime($tgl_awal))." - ".date('d F Y', strtotime($tgl_akhir)),PHPExcel_Cell_DataType::TYPE_STRING);

      $excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('H5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('I5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('J5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      
      $excel->getActiveSheet()->setAutoFilter('A5:J5');
        $total = 0;
	  	$total_diskon = 0;
	  	$total_bayar_tunai = 0;
	  	$total_dibayar_kartu_kredit = 0;
	  	$total_charge_kartu_kredit = 0;

	  //RAWAT INAP
      foreach ($list_keluar_masuk as $r) {
     	$total = $total + $r['vtot'] + $r['diskon'];
  		$total_bayar_tunai = $total_bayar_tunai + $r['tunai'];
  		$total_dibayar_kartu_kredit = $total_dibayar_kartu_kredit + $r['nilai_kkkd'];
  		$total_charge_kartu_kredit = $total_charge_kartu_kredit + ($r['nilai_kkkd'] * $r['persen_kk'] / 100);

  		$diskon = $r['diskon'];
  		if($diskon == '' || $diskon == NULL){
  			$diskon = 0;
  		}
  		$total_diskon = $total_diskon + $diskon;

        $row++;
        $excel->getActiveSheet()->setCellValue('A'.$row, $r['tgl_cetak_kw'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('B'.$row, $r['no_ipd'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('C'.$row, $r['nama'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('D'.$row, $r['jenis_bayar'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('E'.$row, $r['vtot'] + $diskon,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('F'.$row, $diskon,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('G'.$row, $r['vtot'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('H'.$row, $r['tunai'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('I'.$row, $r['nilai_kkkd'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('J'.$row, $r['nilai_kkkd'] * $r['persen_kk'] / 100,PHPExcel_Cell_DataType::TYPE_STRING);
      }

       //LAB
      foreach ($list_pasien_lab_luar as $r) {
     		$total = $total + $r['vtot_lab'];
	  		$total_bayar_tunai = $total_bayar_tunai + $r['vtot_lab'] - $r['diskon'];
	  		$total_dibayar_kartu_kredit = $total_dibayar_kartu_kredit + 0;
	  		$total_charge_kartu_kredit = $total_charge_kartu_kredit + 0;

  		$diskon = $r['diskon'];
  		if($diskon == '' || $diskon == NULL){
  			$diskon = 0;
  		}
  		$total_diskon = $total_diskon + $diskon;

        $row++;
        $excel->getActiveSheet()->setCellValue('A'.$row, $r['xupdate'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('B'.$row, $r['no_register'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('C'.$row, $r['Nama'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('D'.$row, "TUNAI",PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('E'.$row, $r['vtot_lab'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('F'.$row, $diskon,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('G'.$row, $r['vtot_lab'] - $diskon,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('H'.$row, $r['vtot_lab'] - $diskon,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('I'.$row, 0,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('J'.$row, 0,PHPExcel_Cell_DataType::TYPE_STRING);
      }

       //RAD
      foreach ($list_pasien_rad_luar as $r) {
     		$total = $total + $r['vtot_rad'];
	  		$total_bayar_tunai = $total_bayar_tunai + $r['vtot_rad'] - $r['diskon'];
	  		$total_dibayar_kartu_kredit = $total_dibayar_kartu_kredit + 0;
	  		$total_charge_kartu_kredit = $total_charge_kartu_kredit + 0;

  		$diskon = $r['diskon'];
  		if($diskon == '' || $diskon == NULL){
  			$diskon = 0;
  		}
  		$total_diskon = $total_diskon + $diskon;

        $row++;
        $excel->getActiveSheet()->setCellValue('A'.$row, $r['xupdate'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('B'.$row, $r['no_register'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('C'.$row, $r['Nama'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('D'.$row, "TUNAI",PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('E'.$row, $r['vtot_rad'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('F'.$row, $diskon,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('G'.$row, $r['vtot_rad'] - $diskon,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('H'.$row, $r['vtot_rad'] - $diskon,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('I'.$row, 0,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('J'.$row, 0,PHPExcel_Cell_DataType::TYPE_STRING);
      }

        //OBAT
      foreach ($list_pasien_obat_luar as $r) {
     		$total = $total + $r['vtot_obat']+$r['diskon'];
	  		$total_bayar_tunai = $total_bayar_tunai + $r['vtot_obat'];
	  		$total_dibayar_kartu_kredit = $total_dibayar_kartu_kredit + 0;
	  		$total_charge_kartu_kredit = $total_charge_kartu_kredit + 0;

  		$diskon = $r['diskon'];
  		if($diskon == '' || $diskon == NULL){
  			$diskon = 0;
  		}
  		$total_diskon = $total_diskon + $diskon;

        $row++;
        $excel->getActiveSheet()->setCellValue('A'.$row, $r['xupdate'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('B'.$row, $r['no_register'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('C'.$row, $r['Nama'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('D'.$row, "TUNAI",PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('E'.$row, $r['vtot_obat']  + $diskon,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('F'.$row, $diskon,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('G'.$row, $r['vtot_obat'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('H'.$row, $r['vtot_obat'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('I'.$row, 0,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('J'.$row, 0,PHPExcel_Cell_DataType::TYPE_STRING);
      }

      //RAWAT DARURAT
      foreach ($list_keluar_ird as $r) {
     	$total = $total + $r['vtot'] + $r['vtot_rad'] + $r['vtot_lab'] + $r['vtot_obat'] ;
  		$total_bayar_tunai = $total_bayar_tunai + $r['tunai'];
  		$total_dibayar_kartu_kredit = $total_dibayar_kartu_kredit + $r['nila_kkkd'];
  		$total_charge_kartu_kredit = $total_charge_kartu_kredit + ($r['nila_kkkd'] * $r['persen_kk'] / 100);

  		$diskon = $r['diskon'];
  		if($diskon == '' || $diskon == NULL){
  			$diskon = 0;
  		}
  		$total_diskon = $total_diskon + $diskon;


  		if($r['pasien_bayar'] == 1){
  			$jenis_bayar =  "TUNAI";
  		}else{
  			$jenis_bayar =  "KREDIT";
  		}

        $row++;
        $excel->getActiveSheet()->setCellValue('A'.$row, $r['tgl_cetak_kw'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('B'.$row, $r['no_register'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('C'.$row, $r['nama'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('D'.$row, $jenis_bayar,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('E'.$row, $r['vtot'] + $r['vtot_rad'] + $r['vtot_lab'] + $r['vtot_obat'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('F'.$row, $diskon,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('G'.$row, $r['vtot'] + $r['vtot_rad'] + $r['vtot_lab'] + $r['vtot_obat'] - $diskon,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('H'.$row, $r['tunai'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('I'.$row, $r['nila_kkkd'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('J'.$row, $r['nila_kkkd'] * $r['persen_kk'] / 100,PHPExcel_Cell_DataType::TYPE_STRING);
      }

      //RAWAT JALAN
      foreach ($list_keluar_irj as $r) {
     	$total = $total + $r['vtot'] + $r['vtot_rad'] + $r['vtot_lab'] + $r['vtot_obat'] ;
  		$total_bayar_tunai = $total_bayar_tunai + $r['tunai'];
  		$total_dibayar_kartu_kredit = $total_dibayar_kartu_kredit + $r['nilai_kkkd'];
  		$total_charge_kartu_kredit = $total_charge_kartu_kredit + ($r['nilai_kkkd'] * $r['persen_kk'] / 100);

  		$diskon = $r['diskon'];
  		if($diskon == '' || $diskon == NULL){
  			$diskon = 0;
  		}
  		$total_diskon = $total_diskon + $diskon;

  		if($r['pasien_bayar'] == 1){
  			$jenis_bayar =  "TUNAI";
  		}else{
  			$jenis_bayar =  "KREDIT";
  		}

        $row++;
        $excel->getActiveSheet()->setCellValue('A'.$row, $r['tgl_cetak_kw'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('B'.$row, $r['no_register'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('C'.$row, $r['nama'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('D'.$row, $jenis_bayar,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('E'.$row, $r['vtot'] + $r['vtot_rad'] + $r['vtot_lab'] + $r['vtot_obat'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('F'.$row, $diskon,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('G'.$row, $r['vtot'] + $r['vtot_rad'] + $r['vtot_lab'] + $r['vtot_obat'] - $diskon,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('H'.$row, $r['tunai'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('I'.$row, $r['nilai_kkkd'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('J'.$row, $r['nilai_kkkd'] * $r['persen_kk'] / 100,PHPExcel_Cell_DataType::TYPE_STRING);
      }

      $row++;
      $excel->getActiveSheet()->setCellValue('D'.$row, "Total Pembayaran",PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('E'.$row, $total,PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('F'.$row, $total_diskon,PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('G'.$row, $total-$total_diskon,PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('H'.$row, $total_bayar_tunai,PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('I'.$row, $total_dibayar_kartu_kredit,PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('J'.$row, $total_charge_kartu_kredit,PHPExcel_Cell_DataType::TYPE_STRING);

        // //change the font size
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        // //make the font become bold
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        // //merge cell A1 until D1
        // $this->excel->getActiveSheet()->mergeCells('A1:D1');
        // //set aligment to center for that merged cell (A1 to D1)
        // $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	  $newDate = date("d-m-Y", strtotime($tgl_awal));
      $filename='Pendapatan_Tanggal_'.$newDate.'.xls'; //save our workbook as this file name
      header('Content-Type: application/vnd.ms-excel'); //mime type
      header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache
                  
      //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
      //if you want to save it as .XLSX Excel 2007 format
      $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');  
      //force user to download the Excel file without writing it to server's HD
      $objWriter->save('php://output');
	}

	public function cetak_laporan_harian_mr_excel($tgl_awal='',$tgl_akhir="",$user=""){
		require_once (APPPATH.'third_party/PHPExcel.php');

      set_time_limit(0);

      $tgl_awal = urldecode($tgl_awal);
      $tgl_akhir = urldecode($tgl_akhir);

      //load our new PHPExcel library
      //$this->load->library('excel');
      //$this->excel = new PHPExcel();

      $excel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_pendapatan_harian.xls");

      //activate worksheet number 1
      $excel->setActiveSheetIndex(0);
      //name the worksheet
      $excel->getActiveSheet()->setTitle('Worksheet 1');

      //ambil semua data pendapatan
      $list_keluar_masuk = $this->rimpasien->get_list_pasien_keluar_by_tanggal($tgl_awal,$tgl_akhir,$user);	
	$list_keluar_irj = $this->rimpasien->get_list_pasien_keluar_irj_by_tanggal($tgl_awal,$tgl_akhir,$user);
      //print_r($data_pasien_keluar_tanggal[0]);exit;
      $row = 5;
      //set header excel
      // $this->excel->getActiveSheet()->setCellValue('A'.$row, 'UPT');
      // $this->excel->getActiveSheet()->setCellValue('B'.$row, 'Unit');
      // $this->excel->getActiveSheet()->setCellValue('C'.$row, 'Nama Aset');
      // $this->excel->getActiveSheet()->setCellValue('D'.$row, 'Merk');
      // $this->excel->getActiveSheet()->setCellValue('E'.$row, 'No Seri');
      // $this->excel->getActiveSheet()->setCellValue('F'.$row, 'Kondisi');
      // $this->excel->getActiveSheet()->setCellValue('G'.$row, 'PIC');
      // $this->excel->getActiveSheet()->setCellValue('H'.$row, 'No Inventaris');
      // $this->excel->getActiveSheet()->setCellValue('I'.$row, 'IP Address');
      // $this->excel->getActiveSheet()->setCellValue('J'.$row, 'Perolehan');
      // $this->excel->getActiveSheet()->setCellValue('K'.$row, 'Lokasi');
      
       	$tgl_indo = new Tglindo();

  		$bulan_show = $tgl_indo->bulan(substr($tgl_awal,6,2));
		$tahun_show = substr($tgl_awal,0,4);
		$tanggal_show = substr($tgl_awal,8,2);
		$jam_show = substr($tgl_awal,11,5);
		$tgl_awal_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show." - ".$jam_show;

		$bulan_show = $tgl_indo->bulan(substr($tgl_akhir,6,2));
		$tahun_show = substr($tgl_akhir,0,4);
		$tanggal_show = substr($tgl_akhir,8,2);
		$jam_show = substr($tgl_akhir,11,5);
		$tgl_akhir_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show." - ".$jam_show;


      $excel->getActiveSheet()->setCellValue('A1', "Laporan Pendapatan Kasir : ".$user,PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('A2', "Tanggal : ".date('d F Y', strtotime($tgl_awal))." - ".date('d F Y', strtotime($tgl_akhir)),PHPExcel_Cell_DataType::TYPE_STRING);

      $excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('B5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('D5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('E5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      /*$excel->getActiveSheet()->getStyle('F5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('H5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('I5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('J5')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/

      
      $excel->getActiveSheet()->setAutoFilter('A5:J5');
        $total = 0;
	  	$total_diskon = 0;
	  	$total_bayar_tunai = 0;
	  	$total_dibayar_kartu_kredit = 0;
	  	$total_charge_kartu_kredit = 0;

	  //RAWAT INAP
      foreach ($list_keluar_masuk as $r) {
     	$total = $total + $r['vtot'] + $r['diskon'];
  		$total_bayar_tunai = $total_bayar_tunai + $r['tunai'];
  		$total_dibayar_kartu_kredit = $total_dibayar_kartu_kredit + $r['nilai_kkkd'];
  		$total_charge_kartu_kredit = $total_charge_kartu_kredit + ($r['nilai_kkkd'] * $r['persen_kk'] / 100);

  		$diskon = $r['diskon'];
  		if($diskon == '' || $diskon == NULL){
  			$diskon = 0;
  		}
  		$total_diskon = $total_diskon + $diskon;

        $row++;
        $excel->getActiveSheet()->setCellValue('A'.$row, $r['tgl_cetak_kw'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('B'.$row, $r['no_ipd'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('C'.$row, $r['nama'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('D'.$row, 'IRI',PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('E'.$row, $r['tunai'],PHPExcel_Cell_DataType::TYPE_STRING);
        
      }
     
      //RAWAT JALAN
      foreach ($list_keluar_irj as $r) {
     	$total = $total + $r['vtot'] + $r['vtot_rad'] + $r['vtot_lab'] + $r['vtot_obat'] ;
  		$total_bayar_tunai = $total_bayar_tunai + $r['vtotpoli'];
  		$total_dibayar_kartu_kredit = $total_dibayar_kartu_kredit + $r['nilai_kkkd'];
  		$total_charge_kartu_kredit = $total_charge_kartu_kredit + ($r['nilai_kkkd'] * $r['persen_kk'] / 100);

  		$diskon = $r['diskon'];
  		if($diskon == '' || $diskon == NULL){
  			$diskon = 0;
  		}
  		$total_diskon = $total_diskon + $diskon;

  		if($r['pasien_bayar'] == 1){
  			$jenis_bayar =  "TUNAI";
  		}else{
  			$jenis_bayar =  "KREDIT";
  		}

        $row++;
        $excel->getActiveSheet()->setCellValue('A'.$row, $r['tgl_cetak_kw'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('B'.$row, $r['no_register'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('C'.$row, $r['nama'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('D'.$row, $r['nm_poli'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('E'.$row, $r['vtotpoli'],PHPExcel_Cell_DataType::TYPE_STRING);    
      }

      $row++;
      $excel->getActiveSheet()->setCellValue('D'.$row, "Total Pembayaran",PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('E'.$row, $total_bayar_tunai,PHPExcel_Cell_DataType::TYPE_STRING);
     

        // //change the font size
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        // //make the font become bold
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        // //merge cell A1 until D1
        // $this->excel->getActiveSheet()->mergeCells('A1:D1');
        // //set aligment to center for that merged cell (A1 to D1)
        // $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	  $newDate = date("d-m-Y", strtotime($tgl_awal));
      $filename='Pendapatan_Tanggal_'.$newDate.'.xls'; //save our workbook as this file name
      header('Content-Type: application/vnd.ms-excel'); //mime type
      header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache
                  
      //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
      //if you want to save it as .XLSX Excel 2007 format
      $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');  
      //force user to download the Excel file without writing it to server's HD
      $objWriter->save('php://output');
	}

	public function cetak_laporan_bulanan_excel($bulan=''){
		require_once (APPPATH.'third_party/PHPExcel.php');

      set_time_limit(0);

      //load our new PHPExcel library
      //$this->load->library('excel');
      //$this->excel = new PHPExcel();

      $excel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_pendapatan_bulanan.xls");

      //activate worksheet number 1
      $excel->setActiveSheetIndex(0);
      //name the worksheet
      $excel->getActiveSheet()->setTitle('Worksheet 1');

      //ambil semua data pendapatan
      $data_keuangan_bulanan = $this->rimpasien->get_total_pendapatan_by_bulan($bulan);
      $row = 1;
      //set header excel
      // $this->excel->getActiveSheet()->setCellValue('A'.$row, 'UPT');
      // $this->excel->getActiveSheet()->setCellValue('B'.$row, 'Unit');
      // $this->excel->getActiveSheet()->setCellValue('C'.$row, 'Nama Aset');
      // $this->excel->getActiveSheet()->setCellValue('D'.$row, 'Merk');
      // $this->excel->getActiveSheet()->setCellValue('E'.$row, 'No Seri');
      // $this->excel->getActiveSheet()->setCellValue('F'.$row, 'Kondisi');
      // $this->excel->getActiveSheet()->setCellValue('G'.$row, 'PIC');
      // $this->excel->getActiveSheet()->setCellValue('H'.$row, 'No Inventaris');
      // $this->excel->getActiveSheet()->setCellValue('I'.$row, 'IP Address');
      // $this->excel->getActiveSheet()->setCellValue('J'.$row, 'Perolehan');
      // $this->excel->getActiveSheet()->setCellValue('K'.$row, 'Lokasi');
      
      $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

   
      
      $excel->getActiveSheet()->setAutoFilter('A1:J1');
      $total = 0;
      $total_diskon = 0;
	  	$total_tunai = 0;
	  	$total_diskon_tunai = 0;
	  	$total_kredit = 0;
	  	$total_diskon_kredit = 0;
      foreach ($data_keuangan_bulanan as $r) {
        $row++;
        $excel->getActiveSheet()->setCellValue('A'.$row, $r['tgl_keluar'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('B'.$row, $r['vtot_per_tgl'] + $r['vtot_diskon_per_tgl'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('C'.$row, $r['vtot_diskon_per_tgl'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('D'.$row, $r['vtot_per_tgl'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('E'.$row, $r['vtot_tunai_per_tgl'] + $r['vtot_diskon_tunai_per_tgl'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('F'.$row, $r['vtot_diskon_tunai_per_tgl'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('G'.$row, $r['vtot_tunai_per_tgl'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('H'.$row, $r['vtot_kredit_per_tgl'] + $r['vtot_diskon_kredit_per_tgl'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('I'.$row, $r['vtot_diskon_kredit_per_tgl'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('J'.$row, $r['vtot_kredit_per_tgl'],PHPExcel_Cell_DataType::TYPE_STRING);
        $total = $total + $r['vtot_per_tgl'];
        $total_diskon = $total_diskon + $r['vtot_diskon_per_tgl'];
  		$total_tunai = $total_tunai + $r['vtot_tunai_per_tgl'];
  		$total_diskon_tunai = $total_diskon_tunai + $r['vtot_diskon_tunai_per_tgl'];
  		$total_kredit = $total_kredit + $r['vtot_kredit_per_tgl'];
  		$total_diskon_kredit = $total_diskon_kredit + $r['vtot_diskon_kredit_per_tgl'] ;
      }
      $row++;
      $excel->getActiveSheet()->setCellValue('A'.$row, "Total Pembayaran",PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('B'.$row, $total+$total_diskon,PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('C'.$row, $total_diskon,PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('D'.$row, $total,PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('E'.$row, $total_tunai+$total_diskon_tunai,PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('F'.$row, $total_diskon_tunai,PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('G'.$row, $total_tunai,PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('H'.$row, $total_kredit+$total_diskon_kredit,PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('I'.$row, $total_diskon_kredit,PHPExcel_Cell_DataType::TYPE_STRING);
      $excel->getActiveSheet()->setCellValue('J'.$row, $total_kredit,PHPExcel_Cell_DataType::TYPE_STRING);


        // //change the font size
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        // //make the font become bold
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        // //merge cell A1 until D1
        // $this->excel->getActiveSheet()->mergeCells('A1:D1');
        // //set aligment to center for that merged cell (A1 to D1)
        // $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	  $newDate = date("m-Y", strtotime($bulan));
      $filename='Pendapatan_Bulan'.$newDate.'.xls'; //save our workbook as this file name
      header('Content-Type: application/vnd.ms-excel'); //mime type
      header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache
                  
      //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
      //if you want to save it as .XLSX Excel 2007 format
      $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');  
      //force user to download the Excel file without writing it to server's HD
      $objWriter->save('php://output');
	}

	public function cetak_laporan_kunjungan_harian($tgl_awal=''){

		$data_pasien_keluar_tanggal = $this->rimpasien->get_jml_keluar_masuk_by_date($tgl_awal);

		//ambil data rs
		//$data_rs = $this->rimkelas->get_data_rs('10000');
		$konten = "
		<table style=\"padding:4px;\" border=\"0\">
			<tr>
				<td>
					<p align=\"center\">
						<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\" >
					</p>
				</td>
			</tr>
		</table>
					<hr><br/><br/>
		<table>
			<tr>
				<td colspan=\"3\"><p align=\"center\"><b>Laporan Kunjungan Rawat Inap Tanggal ".$tgl_awal."</b></p></td>
			</tr>
			<tr>
				<td colspan=\"3\"><p align=\"center\"><b>".$this->config->item('namars')."</b></p></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>
			<br/>
			<hr/>";
		$konten = $konten."
		<table border=\"1\" style=\"padding:2px\">
		<tr>
			<td>Tanggal</td>
			<td>No Medrec</td>
			<td>No Register</td>
			<td>Nama</td>
			<td>Diagnosa Utama</td>
			<td>Jenis Kelamin</td>
			<td>Alamat</td>
			<td>Status</td>
			<td>Penjamin</td>
			<td>Ruangan</td>
		</tr>
		";	
	  	$total = 0;
	  	$total_diskon = 0;
	  	$tgl_indo = new Tglindo();

	  	foreach ($data_pasien_keluar_tanggal as $r) {
	  		$bulan_show = $tgl_indo->bulan(substr($r['tgl'],6,2));
			$tahun_show = substr($r['tgl'],0,4);
			$tanggal_show = substr($r['tgl'],8,2);
			$tgl_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show;

		$konten = $konten . '
	  	<tr>
	  		<td>'.$tgl_lengkap.'</td>
	  		<td>'.$r['no_cm'].'</td>
	  		<td>'.$r['no_ipd'].'</td>
	  		<td>'.$r['nama'].'</td>
	  		<td>'.$r['id_icd'].' - '.$r['nm_diagnosa'].'</td>
	  		<td>'.$r['sex'].'</td>
	  		<td>'.$r['alamat'].'</td>
	  		<td>'.$r['tipe_masuk'].'</td>
	  		<td>'.$r['nmkontraktor'].'</td>
			<td>'.$r['nmruang'].'</td>
	  	</tr>

		';
		}
		echo $konten;
		$file_name = "Laporan_Kunjungan_Harian_".$tgl_awal.".pdf";
		tcpdf();
		$obj_pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
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
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
			$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'/download/inap/laporan/kunj/'.$file_name, 'FI');
	}

	public function cetak_laporan_kunjungan_harian_excel($tgl_awal=''){
		require_once (APPPATH.'third_party/PHPExcel.php');

      set_time_limit(0);

      //load our new PHPExcel library
      //$this->load->library('excel');
      //$this->excel = new PHPExcel();

      $excel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_kunjungan_harian.xls");

      //activate worksheet number 1
      $excel->setActiveSheetIndex(0);
      //name the worksheet
      $excel->getActiveSheet()->setTitle('Worksheet 1');

      //ambil semua data pendapatan
      $data_pasien_keluar_tanggal = $this->rimpasien->get_jml_keluar_masuk_by_date($tgl_awal);
      //print_r($data_pasien_keluar_tanggal[0]);exit;
      $row = 1;
      //set header excel
      // $this->excel->getActiveSheet()->setCellValue('A'.$row, 'UPT');
      // $this->excel->getActiveSheet()->setCellValue('B'.$row, 'Unit');
      // $this->excel->getActiveSheet()->setCellValue('C'.$row, 'Nama Aset');
      // $this->excel->getActiveSheet()->setCellValue('D'.$row, 'Merk');
      // $this->excel->getActiveSheet()->setCellValue('E'.$row, 'No Seri');
      // $this->excel->getActiveSheet()->setCellValue('F'.$row, 'Kondisi');
      // $this->excel->getActiveSheet()->setCellValue('G'.$row, 'PIC');
      // $this->excel->getActiveSheet()->setCellValue('H'.$row, 'No Inventaris');
      // $this->excel->getActiveSheet()->setCellValue('I'.$row, 'IP Address');
      // $this->excel->getActiveSheet()->setCellValue('J'.$row, 'Perolehan');
      // $this->excel->getActiveSheet()->setCellValue('K'.$row, 'Lokasi');
      
      $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


      $excel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      
      $excel->getActiveSheet()->setAutoFilter('A1:H1');
    
      foreach ($data_pasien_keluar_tanggal as $r) {
      

        $row++;
        $excel->getActiveSheet()->setCellValue('A'.$row, $r['tgl'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('B'.$row, $r['no_cm'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('C'.$row, $r['no_ipd'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('D'.$row, $r['nama'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('D'.$row, $r['id_icd']." - ".$r['nm_diagnosa'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('F'.$row, $r['sex'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('G'.$row, $r['alamat'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('H'.$row, $r['tipe_masuk'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('I'.$row, $r['nmkontraktor'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('J'.$row, $r['nmruang'],PHPExcel_Cell_DataType::TYPE_STRING);        
        
      }

        // //change the font size
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        // //make the font become bold
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        // //merge cell A1 until D1
        // $this->excel->getActiveSheet()->mergeCells('A1:D1');
        // //set aligment to center for that merged cell (A1 to D1)
        // $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	  $newDate = date("d-m-Y", strtotime($tgl_awal));
      $filename='Kunjungan_Tanggal_'.$newDate.'.xls'; //save our workbook as this file name
      header('Content-Type: application/vnd.ms-excel'); //mime type
      header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache
                  
      //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
      //if you want to save it as .XLSX Excel 2007 format
      $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');  
      //force user to download the Excel file without writing it to server's HD
      $objWriter->save('php://output');
	}

	public function cetak_laporan_kunjungan_bulanan($tgl_awal=''){

		$data_pasien_keluar_tanggal = $this->rimpasien->get_jml_keluar_masuk_by_bulan($tgl_awal);

		//ambil data rs
		//$data_rs = $this->rimkelas->get_data_rs('10000');
		$konten = "
		<table style=\"padding:4px;\" border=\"0\">
			<tr>
				<td>
					<p align=\"center\">
						<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\" >
					</p>
				</td>
			</tr>
		</table>
					<hr><br/><br/>
		<table>
			<tr>
				<td colspan=\"3\"><p align=\"center\"><b>Laporan Kunjungan Rawat Inap Tanggal ".$tgl_awal."</b></p></td>
			</tr>
			<tr>
				<td colspan=\"3\"><p align=\"center\"><b>".$this->config->item('namars')."</b></p></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>
			<br/>
			<hr/>";
		$konten = $konten.'
		<table border="1">
		<tr>
			<th>Tanggal</th>
			<th>Jumlah Masuk</th>
			<th>Jumlah Keluar</th>
		</tr>
		';	
	  	$total = 0;
	  	$total_diskon = 0;
	  	$tgl_indo = new Tglindo();

	  	foreach ($data_pasien_keluar_tanggal as $r) {
	  		$bulan_show = $tgl_indo->bulan(substr($r['tanggal'],6,2));
			$tahun_show = substr($r['tanggal'],0,4);
			$tanggal_show = substr($r['tanggal'],8,2);
			$tgl_lengkap = $tanggal_show." ".$bulan_show." ".$tahun_show;

			$jml_masuk = 0;

			if($r['jml_tgl_masuk'] == null){
				$jml_masuk = 0;
			}else{
				$jml_masuk =  $r['jml_tgl_masuk'];
			}

			$jml_keluar = 0;
			if($r['jml_tgl_keluar'] == null){
				$jml_keluar =  0;
			}else{
				$jml_keluar =  $r['jml_tgl_keluar'];
			}

		$konten = $konten . '
	  	<tr>
	  		<td>'.$tgl_lengkap.'</td>
	  		<td>'.$jml_masuk.'</td>
	  		<td>'.$jml_keluar.'</td>
	  	</tr>
		';
		}
	
		$file_name = "Laporan_Kunjungan_Bulanan_".$tgl_awal.".pdf";
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
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
			$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'/download/inap/laporan/kunj/'.$file_name, 'FI');
	}

	public function cetak_laporan_kunjungan_bulanan_excel($tgl_awal=''){
		require_once (APPPATH.'third_party/PHPExcel.php');

      set_time_limit(0);

      //load our new PHPExcel library
      //$this->load->library('excel');
      //$this->excel = new PHPExcel();

      $excel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_kunjungan_bulanan.xls");

      //activate worksheet number 1
      $excel->setActiveSheetIndex(0);
      //name the worksheet
      $excel->getActiveSheet()->setTitle('Worksheet 1');

      //ambil semua data pendapatan
      $data_pasien_keluar_tanggal = $this->rimpasien->get_jml_keluar_masuk_by_bulan($tgl_awal);
      //print_r($data_pasien_keluar_tanggal[0]);exit;
      $row = 1;
      //set header excel
      // $this->excel->getActiveSheet()->setCellValue('A'.$row, 'UPT');
      // $this->excel->getActiveSheet()->setCellValue('B'.$row, 'Unit');
      // $this->excel->getActiveSheet()->setCellValue('C'.$row, 'Nama Aset');
      // $this->excel->getActiveSheet()->setCellValue('D'.$row, 'Merk');
      // $this->excel->getActiveSheet()->setCellValue('E'.$row, 'No Seri');
      // $this->excel->getActiveSheet()->setCellValue('F'.$row, 'Kondisi');
      // $this->excel->getActiveSheet()->setCellValue('G'.$row, 'PIC');
      // $this->excel->getActiveSheet()->setCellValue('H'.$row, 'No Inventaris');
      // $this->excel->getActiveSheet()->setCellValue('I'.$row, 'IP Address');
      // $this->excel->getActiveSheet()->setCellValue('J'.$row, 'Perolehan');
      // $this->excel->getActiveSheet()->setCellValue('K'.$row, 'Lokasi');
      
      $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


      
      $excel->getActiveSheet()->setAutoFilter('A1:C1');
    
      foreach ($data_pasien_keluar_tanggal as $r) {
      
      		if($r['jml_tgl_masuk'] == null){
				$jml_masuk = 0;
			}else{
				$jml_masuk =  $r['jml_tgl_masuk'];
			}

			$jml_keluar = 0;
			if($r['jml_tgl_keluar'] == null){
				$jml_keluar =  0;
			}else{
				$jml_keluar =  $r['jml_tgl_keluar'];
			}

        $row++;
        $excel->getActiveSheet()->setCellValue('A'.$row, $r['tanggal'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('B'.$row, $jml_masuk,PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('C'.$row, $jml_keluar,PHPExcel_Cell_DataType::TYPE_STRING);
        
      }

        // //change the font size
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        // //make the font become bold
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        // //merge cell A1 until D1
        // $this->excel->getActiveSheet()->mergeCells('A1:D1');
        // //set aligment to center for that merged cell (A1 to D1)
        // $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	  $newDate = date("d-m-Y", strtotime($tgl_awal));
      $filename='Kunjungan_Bulan_'.$newDate.'.xls'; //save our workbook as this file name
      header('Content-Type: application/vnd.ms-excel'); //mime type
      header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache
                  
      //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
      //if you want to save it as .XLSX Excel 2007 format
      $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');  
      //force user to download the Excel file without writing it to server's HD
      $objWriter->save('php://output');
	}

	public function cetak_medrec($tgl='',$type=''){

		if($type == "BLN"){
			$data_medrec = $this->rimpasien->get_empty_diagnosa_by_month($tgl);
		}else{
			$data_medrec = $this->rimpasien->get_empty_diagnosa_by_date('',$tgl);
		}

		//ambil data rs
		//$data_rs = $this->rimkelas->get_data_rs('10000');
		$konten = '
		<table style="padding:4px;" >
						<tr>
							<td>
								<p align="center">
									<img src="asset/images/logos/"'.$this->config->item('logo_url').'" alt="img" height="42" >
								</p>
							</td>
						</tr>
					</table>
					<hr><br/><br/>
		<table>
				<tr>
					<td colspan="3"><p align="center"><b>Laporan Medical Record Rawat Inap '.$tgl.'</b></p></td>
				</tr>
				<tr>
					<td colspan="3"><p align="center"><b>'.$this->config->item('namars').'</b></p></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				</table>
			<br/>
			<hr/>';
		$konten = $konten.'
		<table >
			<tr>
				<th>No. Register</th>
				<th>Nama</th>
				<th>No MedRec</th>
				<th>Ruang</th>
				<th>Usia</th>
				<th>Kls</th>
				<th>Tgl Masuk</th>
				<th>Tgl Keluar</th>
				<th>Lama Rawat</th>
				<th>Hari Perawatan</th>
				<th>Dokter</th>
				<th>Diagnosa</th>
				<th>Icd</th>
				<th>Berat Bayi</th>
				<th>Keterangan</th>
			</tr> ';

	  	foreach ($data_medrec as $r) { 

	  		$interval = date_diff(date_create(), date_create($r['tgl_lahir']));
			$umur =  $interval->format("%Y Tahun, %M Bulan, %d Hari");
			$tgl_indo = $this->obj_tanggal();
	  		$bln_row = $tgl_indo->bulan(substr($r['tgl_masuk'],6,2));
	  		$tgl_row = substr($r['tgl_masuk'],8,2);
	  		$thn_row = substr($r['tgl_masuk'],0,4);
			$tgl_masuk_show = $tgl_row." ".$bln_row." ".$thn_row;

			$tgl_indo = $this->obj_tanggal();
	  		$bln_row = $tgl_indo->bulan(substr($r['tgl_keluar'],6,2));
	  		$tgl_row = substr($r['tgl_keluar'],8,2);
	  		$thn_row = substr($r['tgl_keluar'],0,4);
	  		$tgl_keluar_show =  $tgl_row." ".$bln_row." ".$thn_row;

	  		 $temp_tgl_awal = strtotime($r['tgl_masuk']);
			 $temp_tgl_akhir = strtotime($r['tgl_keluar']);
		     $diff = $temp_tgl_akhir - $temp_tgl_awal;
		     $diff =  floor($diff/(60*60*24));
		     if($diff == 0){
		     	$diff = 1;
		     }
		     
		     $hari_perawatan = $diff + 1;
		$konten = $konten.'	
		  	<tr>
		  		<td>'.$r['no_ipd'].'</td>
		  		<td>'.$r['nama'].'</td>
		  		<td>'.$r['no_medrec_patria'].'</td>
		  		<td>'.$r['idrg'].'</td>
		  		<td>'.$umur.'</td>
		  		<td>'.$r['klsiri'].'</td>
		  		<td>'.$tgl_masuk_show.'</td>
		  		<td>'.$tgl_keluar_show.'</td>
	  			<td>'.$diff.'</td>
		  		<td>'.$hari_perawatan.'</td>
		  		<td>'.$r['dokter'].'</td>
		  		<td>'.$r['nm_diagnosa'].','.$r['list_diagnosa_tambahan'].'</td>
		  		<td>'.$r['diagnosa1'].','.$r['list_id_diagnosa_tambahan'].' </td>
		  		<td>'.$r['brtlahir'].'</td>
		  		<td>'.$r['jenis_bayar'].'</td>
		  	</tr> ';
	  	}
	  	$konten = $konten.'
		</table>
		';


		$file_name = "Laporan_MedRec.pdf";
		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->setPrintHeader(false); //To remove first line on the top
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->SetHeaderData('', '', $title, '');
					$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
					$obj_pdf->SetDefaultMonospacedFont('helvetica');
					$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
					$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
					$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '20', PDF_MARGIN_RIGHT);
					$obj_pdf->SetAutoPageBreak(TRUE, '15');
					$obj_pdf->SetFont('helvetica', '', 11);
					$obj_pdf->setFontSubsetting(false);
					$obj_pdf->AddPage();
		ob_start();
			$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'/download/inap/laporan/pembayaran/'.$file_name, 'FI');
	}


	public function cetak_medrec_excel($tgl='',$type=''){
		require_once (APPPATH.'third_party/PHPExcel.php');

      set_time_limit(0);

      //load our new PHPExcel library
      //$this->load->library('excel');
      //$this->excel = new PHPExcel();

      $excel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_medrec.xls");

      //activate worksheet number 1
      $excel->setActiveSheetIndex(0);
      //name the worksheet
      $excel->getActiveSheet()->setTitle('Worksheet 1');

      //ambil semua data pendapatan
      if($type == "BLN"){
			$data_medrec = $this->rimpasien->get_empty_diagnosa_by_month($tgl);
		}else{
			$data_medrec = $this->rimpasien->get_empty_diagnosa_by_date('',$tgl);
		}
      //print_r($data_pasien_keluar_tanggal[0]);exit;
      $row = 1;
      //set header excel
      // $this->excel->getActiveSheet()->setCellValue('A'.$row, 'UPT');
      // $this->excel->getActiveSheet()->setCellValue('B'.$row, 'Unit');
      // $this->excel->getActiveSheet()->setCellValue('C'.$row, 'Nama Aset');
      // $this->excel->getActiveSheet()->setCellValue('D'.$row, 'Merk');
      // $this->excel->getActiveSheet()->setCellValue('E'.$row, 'No Seri');
      // $this->excel->getActiveSheet()->setCellValue('F'.$row, 'Kondisi');
      // $this->excel->getActiveSheet()->setCellValue('G'.$row, 'PIC');
      // $this->excel->getActiveSheet()->setCellValue('H'.$row, 'No Inventaris');
      // $this->excel->getActiveSheet()->setCellValue('I'.$row, 'IP Address');
      // $this->excel->getActiveSheet()->setCellValue('J'.$row, 'Perolehan');
      // $this->excel->getActiveSheet()->setCellValue('K'.$row, 'Lokasi');
      
      $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('N1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('O1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('P1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('P1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('Q1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('R1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('R1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('S1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('S1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


      
      $excel->getActiveSheet()->setAutoFilter('A1:R1');
    
      foreach ($data_medrec as $r) { 

	  		$interval = date_diff(date_create(), date_create($r['tgl_lahir']));
			$umur =  $interval->format("%Y Tahun, %M Bulan, %d Hari");
			$tgl_indo = $this->obj_tanggal();
	  		$bln_row = $tgl_indo->bulan(substr($r['tgl_masuk'],6,2));
	  		$tgl_row = substr($r['tgl_masuk'],8,2);
	  		$thn_row = substr($r['tgl_masuk'],0,4);
			$tgl_masuk_show = $tgl_row." ".$bln_row." ".$thn_row;

			$tgl_indo = $this->obj_tanggal();
	  		$bln_row = $tgl_indo->bulan(substr($r['tgl_keluar'],6,2));
	  		$tgl_row = substr($r['tgl_keluar'],8,2);
	  		$thn_row = substr($r['tgl_keluar'],0,4);
	  		$tgl_keluar_show =  $tgl_row." ".$bln_row." ".$thn_row;

	  		 $temp_tgl_awal = strtotime($r['tgl_masuk']);
			 $temp_tgl_akhir = strtotime($r['tgl_keluar']);
		     $diff = $temp_tgl_akhir - $temp_tgl_awal;
		     $diff =  floor($diff/(60*60*24));
		     if($diff == 0){
		     	$diff = 1;
		     }

		     $hari_perawatan = $diff + 1;

		      $row++;
		    $excel->getActiveSheet()->setCellValue('A'.$row, $r['no_ipd'],PHPExcel_Cell_DataType::TYPE_STRING);
		    $excel->getActiveSheet()->setCellValue('B'.$row, $r['nama'],PHPExcel_Cell_DataType::TYPE_STRING);
		    $excel->getActiveSheet()->setCellValue('C'.$row, $r['no_medrec_patria'],PHPExcel_Cell_DataType::TYPE_STRING);
		    $excel->getActiveSheet()->setCellValue('D'.$row, $r['nmruang'],PHPExcel_Cell_DataType::TYPE_STRING);
		    $excel->getActiveSheet()->setCellValue('E'.$row, $umur,PHPExcel_Cell_DataType::TYPE_STRING);
		     $excel->getActiveSheet()->setCellValue('F'.$row, $r['sex'],PHPExcel_Cell_DataType::TYPE_STRING);
		    $excel->getActiveSheet()->setCellValue('G'.$row, $r['klsiri'],PHPExcel_Cell_DataType::TYPE_STRING);
		    $excel->getActiveSheet()->setCellValue('H'.$row, $tgl_masuk_show,PHPExcel_Cell_DataType::TYPE_STRING);
		    $excel->getActiveSheet()->setCellValue('I'.$row, $tgl_keluar_show,PHPExcel_Cell_DataType::TYPE_STRING);
		    $excel->getActiveSheet()->setCellValue('J'.$row, $diff,PHPExcel_Cell_DataType::TYPE_STRING);
		    $excel->getActiveSheet()->setCellValue('K'.$row, $hari_perawatan,PHPExcel_Cell_DataType::TYPE_STRING);
		    $excel->getActiveSheet()->setCellValue('L'.$row, $r['dokter'],PHPExcel_Cell_DataType::TYPE_STRING);
		    $excel->getActiveSheet()->setCellValue('M'.$row, $r['nm_diagnosa'].','.$r['list_diagnosa_tambahan'],PHPExcel_Cell_DataType::TYPE_STRING);
		    $excel->getActiveSheet()->setCellValue('N'.$row, $r['diagnosa1'].','.$r['list_id_diagnosa_tambahan'],PHPExcel_Cell_DataType::TYPE_STRING);
		    $excel->getActiveSheet()->setCellValue('O'.$row, $r['brtlahir'],PHPExcel_Cell_DataType::TYPE_STRING);
		    $excel->getActiveSheet()->setCellValue('P'.$row, $r['nmkontraktor'],PHPExcel_Cell_DataType::TYPE_STRING);
		    $excel->getActiveSheet()->setCellValue('Q'.$row, $r['kesatuan'],PHPExcel_Cell_DataType::TYPE_STRING);
		    $excel->getActiveSheet()->setCellValue('R'.$row, $r['pangkat'],PHPExcel_Cell_DataType::TYPE_STRING);
		    $excel->getActiveSheet()->setCellValue('S'.$row, $r['jenis_bayar'],PHPExcel_Cell_DataType::TYPE_STRING);
	  	}

 
   

        // //change the font size
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        // //make the font become bold
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        // //merge cell A1 until D1
        // $this->excel->getActiveSheet()->mergeCells('A1:D1');
        // //set aligment to center for that merged cell (A1 to D1)
        // $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	  $newDate = date("d-m-Y", strtotime($tgl));
      $filename='Medical_Record_'.$newDate.'.xls'; //save our workbook as this file name
      header('Content-Type: application/vnd.ms-excel'); //mime type
      header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache
                  
      //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
      //if you want to save it as .XLSX Excel 2007 format
      $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');  
      //force user to download the Excel file without writing it to server's HD
      $objWriter->save('php://output');
	}


	//laporan rawat jalan

	public function excel_lapkunj(){
		$tampil_per = $this->input->get("tampil_per");
		$id_poli = $this->input->get("id_poli");
		$var1 = $this->input->get("var1");
		$id_poli = strtoupper($id_poli);
		$tampil_per = strtoupper($tampil_per);
		require_once (APPPATH.'third_party/PHPExcel.php');
		$title = 'Laporan Kunjungan';
		$tgl_indo = new Tglindo();
		
		//get nama poli
		if ($id_poli!="SEMUA") {
			$nm_poli=$this->Rjmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		}
		
		$data_rs=$this->Rjmkwitansi->getdata_rs('10000')->result();
		foreach($data_rs as $row){
			$namars=$row->namars;
			$kota_kab=$row->kota;
		}
		
		////////////////////////////////////////////////////////////EXCEL 
						
		  $objPHPExcel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_laporan_dokter_excel.xls");

	      //activate worksheet number 1
	      $objPHPExcel->setActiveSheetIndex(0);
	      //name the worksheet
	      $objPHPExcel->getActiveSheet()->setTitle('Worksheet 1');
		
		// Add some data  
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $title);
		
		$no = 1;
		
		if ($tampil_per=="TGL") {
			
			$tgl=$var1;
				
			//nama file----------------------------------
			$date_title = "Tanggal";
			
			$tgl1 = date('d-m-Y', strtotime($tgl));
			$date=substr($tgl1,0,2).' '.$tgl_indo->bulan(substr($tgl1,3,2)).' '.substr($tgl1,6,4);
			//-------------------------------------------
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$date);
				
			if ($id_poli=="SEMUA") {
				$file_name="KUNJ_POLI_$tgl1.xlsx";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_kunj=$this->Rjmlaporan->get_data_kunj_poli_harian($tgl)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('E4', 'Nama');
				$objPHPExcel->getActiveSheet()->SetCellValue('F4', 'Diagnosa Utama');
				
				$rowCount = 4;
				
				foreach($poli as $row1){ 
			
					$array = json_decode(json_encode($data_laporan_kunj), True);
					$data_poli=array_column($array, 'id_poli');
				
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {	
				
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						
						$setpoli=0;

						$i=1;
						foreach($data_laporan_kunj as $row2){
						
							if ($row2->id_poli==$row1->id_poli) {

								$rowCount++;
								$i++;
								if ($setpoli==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row1->nm_poli);
										$setpoli=1;
								}
								$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $row2->no_medrec,PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->no_register);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->nama);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->diagnosa);
							}
						}
				
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Total')
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $i-1)
							->getStyle('F'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
					}
				}	
								
			} else {  //jika id_poli tidak "SEMUA" u/ tampil_per "TGL"
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Poliklinik : '.$nm_poli);
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Nama');
				$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Diagnosa Utama');
				$rowCount=5;

				$file_name="KUNJ_POLI_".$id_poli."_$tgl1.xlsx";
				$data_laporan_kunj=$this->Rjmlaporan->get_data_kunj_harian($tgl, $id_poli)->result();
				
				$i=1;
				foreach($data_laporan_kunj as $row2){
					$rowCount++;
					$i++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $row2->no_medrec,PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->no_register);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->nama);
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->diagnosa);
				}
				
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total')
					->getStyle('D'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $i-1)
					->getStyle('E'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	

			}
		
		} else if ($tampil_per=="BLN") {
				
			$bulan=$var1;
			$tgl_indo = new Tglindo();
			
			//nama file----------------------------------
			$bulan1 = $tgl_indo->bulan(substr($bulan,5,2))." ".date('Y', strtotime($bulan));
			$date_title = "Bulan";
			$date=$bulan1;
			//-------------------------------------------
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Bulan : '.$date);

			if ($id_poli=="SEMUA") {
				
				$file_name="KUNJ_POLI_$bulan1.xls";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_kunj=$this->Rjmlaporan->get_data_kunj_poli_bulanan(substr($bulan,5,2))->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Tanggal');
				$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Jumlah Kunjungan');
				$rowCount=4;
				
				foreach($poli as $row1){ 
	
					$array = json_decode(json_encode($data_laporan_kunj), True);
					$data_poli=array_column($array, 'id_poli');
					
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {	
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						$setpoli=0;
						
						$i=1;
						$vtot=0;
						foreach($data_laporan_kunj as $row2){
							if ($row2->id_poli==$row1->id_poli) {
								$i++;
								$rowCount++;
								$vtot=$vtot+$row2->jumlah_kunj;
								
								if ($setpoli==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row1->nm_poli);
									$setpoli=1;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->tgl_kunj);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_kunj);


							}
						}
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					}
				}
					
			} else {
				
				$file_name="KUNJ_POLI_".$id_poli."_$bulan1.xls";
				$data_laporan_kunj=$this->Rjmlaporan->get_data_kunj_bulanan(substr($bulan,5,2), $id_poli)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Poliklinik : '.$nm_poli);
			
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Tanggal');
				$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Jumlah Kunjungan');
				$rowCount=5;

				$i=1;
				$vtot=0;
				foreach($data_laporan_kunj as $row){
					$vtot=$vtot+$row->jumlah_kunj;
					$rowCount++;
					$i++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tgl_kunj);
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->jumlah_kunj)
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total')
					->getStyle('B'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtot)
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

			}
				
		} else if ($tampil_per=="THN") {
				
			$tahun=$var1;
			
			//nama file----------------------------------
			$date_title = "Tahun";
			$date=$tahun;
			//-------------------------------------------
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tahun : '.$date);

			if ($id_poli=="SEMUA") {
			
				$file_name="KUNJ_POLI_$tahun.xls";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_kunj=$this->Rjmlaporan->get_data_kunj_poli_tahunan($tahun, $id_poli)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Bulan');
				$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Jumlah Kunjungan');
				$rowCount=4;

				foreach($poli as $row1){ 
		
					$array = json_decode(json_encode($data_laporan_kunj), True);
					$data_poli=array_column($array, 'id_poli');
					
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {	
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						$setpoli=0;
						$i=1;
						$vtot=0;
						foreach($data_laporan_kunj as $row2){
							if ($row2->id_poli==$row1->id_poli) {
								$vtot=$vtot+$row2->jumlah_kunj;
								$i++;
								$rowCount++;
								
								if ($setpoli==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row1->nm_poli);
									$setpoli=1;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $tgl_indo->bulan($row2->bulan_kunj));
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_kunj);

							}
						}
						
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total ')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtot)
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					}
				}
				
			} else { //else per_tampil 'THN' dan id_poli!='SEMUA'
				
				$file_name="KUNJ_POLI_".$id_poli."_$tahun.xls";
				$data_laporan_kunj=$this->Rjmlaporan->get_data_kunj_tahunan($tahun, $id_poli)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Poliklinik : '.$nm_poli);
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Bulan');
				$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Jumlah Kunjungan');
				$rowCount=5;
				
				$i=1;
				$vtot=0;
				foreach($data_laporan_kunj as $row){
					$vtot=$vtot+$row->jumlah_kunj;
					$rowCount++;
					$i++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $tgl_indo->bulan($row->bulan_kunj));
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->jumlah_kunj)
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}
			 
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total')
					->getStyle('B'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtot)
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			}
		}
	 header('Content-Type: application/vnd.ms-excel'); //mime type
      header('Content-Disposition: attachment;filename="'.$file_name.'"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache
                  
      //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
      //if you want to save it as .XLSX Excel 2007 format
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
      //force user to download the Excel file without writing it to server's HD
      $objWriter->save('php://output');
	}

	public function excel_lapkeu()
	{
		
		$tampil_per = $this->input->get("tampil_per");
		$id_poli = $this->input->get("id_poli");
		$var1 = $this->input->get("var1");
		$status = $this->input->get("status");
		$cara_bayar = $this->input->get("cara_bayar");

		$id_poli = strtoupper($id_poli);
		$tampil_per = strtoupper($tampil_per);
		$status = strtoupper($status);
		$cara_bayar = strtoupper($cara_bayar);

		require_once (APPPATH.'third_party/PHPExcel.php');

		$title = 'Laporan Keuangan';
		$tgl_indo = new Tglindo();
		if ($id_poli!="SEMUA") {
			$nm_poli=$this->Rjmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		}
		$data_rs=$this->Rjmkwitansi->getdata_rs('10000')->result();
		foreach($data_rs as $row){
			$namars=$row->namars;
			$kota_kab=$row->kota;
		}
		
		////////////////////////////////////////////////////////////EXCEL 
						
		// Create new PHPExcel object  
						
	  $objPHPExcel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_laporan_dokter_excel.xls");

      //activate worksheet number 1
      $objPHPExcel->setActiveSheetIndex(0);
      //name the worksheet
      $objPHPExcel->getActiveSheet()->setTitle('Worksheet 1');
		
		// Add some data  
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $title);
		
		// Add some data  
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $title);
		if ($status=='10') {
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Status : Pulang dan Dirawat');
		} else if ($status=='1') {
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Status : Pulang');
		} else if ($status=='0') {
			$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Status : Dirawat');		
		}
		$no = 1;
		
		if ($tampil_per=="TGL") {
		 
			$tgl=$var1;
			//nama file----------------------------------
			$tgl1 = date('d-m-Y', strtotime($tgl));
			$date=substr($tgl1,0,2).' '.$tgl_indo->bulan(substr($tgl1,3,2)).' '.substr($tgl1,6,4);
			$date_title = 'Tanggal';
			//-------------------------------------------
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$date);
			
			if ($id_poli=="SEMUA") {
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Nama');
				if ($status=='10') {
					$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Status');
					//$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Biaya Daftar');
					$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Biaya Tindakan');
				} else {
					//$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Biaya Daftar');
					$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Biaya Tindakan');
				}
				$rowCount = 5;

				$file_name="KEU_POLI_$tgl1.xlsx";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_poli_harian($tgl, $status)->result();
			
				foreach($poli as $row1){ 
			
					$array = json_decode(json_encode($data_laporan_keu), True);
					$data_poli=array_column($array, 'id_poli');
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {		
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						
						$setpoli=0;
						$vtot=0;
						//$biayadaftar=0;
						foreach($data_laporan_keu as $row2){
							if ($row2->id_poli==$row1->id_poli) {
							
								$rowCount++;
							
								$vtot+=$row2->vtot;
								//$biayadaftar+=$row2->biayadaftar;
						
								if ($setpoli==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row1->nm_poli);
										$setpoli=1;
								}
								$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$rowCount, $row2->no_medrec,PHPExcel_Cell_DataType::TYPE_STRING);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->no_register);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->nama);
								if ($status=='10') {
									$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, ($row2->status=="1" ? "Pulang":"Dirawat"));
									/*$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format( $row2->biayadaftar, 2 , ',' , '.' ))
										->getStyle('G'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
									*/
									$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format( $row2->vtot, 2 , ',' , '.' ))
										->getStyle('G'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								} else {
									/*$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $row2->biayadaftar, 2 , ',' , '.' ))
										->getStyle('F'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
									*/
									$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $row2->vtot, 2 , ',' , '.' ))
										->getStyle('F'.$rowCount)
										->getAlignment()
										->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								}
							}

						}
						
						if ($status=='10') {
							$rowCount++;
							$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Total')
								->getStyle('F'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							/*$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
								->getStyle('G'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
							*/
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
								->getStyle('G'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
						
							/*$rowCount++;
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Total Biaya Daftar dan Tindakan')
								->getStyle('G'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
								->getStyle('H'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
							*/
						} else {
							$rowCount++;
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Total')
								->getStyle('E'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							/*$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
								->getStyle('F'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
							$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
								->getStyle('F'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
						
							/*$rowCount++;
							$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Total Biaya Daftar dan Tindakan')
								->getStyle('F'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
								->getStyle('G'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
						}
						
					}
				}
				
			} else { //jika id_poli tidak "SEMUA" u/ tampil_per "TGL"
			
				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Poliklinik : '.$nm_poli);
				$objPHPExcel->getActiveSheet()->SetCellValue('A6', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B6', 'No Medrec');
				$objPHPExcel->getActiveSheet()->SetCellValue('C6', 'No Register');
				$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Nama');
				if ($status=='10') {
					$objPHPExcel->getActiveSheet()->SetCellValue('E6', 'Status');
					//$objPHPExcel->getActiveSheet()->SetCellValue('F6', 'Biaya Daftar');
					$objPHPExcel->getActiveSheet()->SetCellValue('F6', 'Biaya Tindakan');
				} else {
					//$objPHPExcel->getActiveSheet()->SetCellValue('E6', 'Biaya Daftar');
					$objPHPExcel->getActiveSheet()->SetCellValue('E6', 'Biaya Tindakan');
				}
				$rowCount = 6;
				
				$file_name="KEU_POLI_".$id_poli."_$tgl1.xlsx";
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_harian($tgl, $id_poli, $status)->result();
				
				$vtot=0;
				//$biayadaftar=0;
				foreach($data_laporan_keu as $row2){
					$vtot+=$row2->vtot;
					//$biayadaftar+=$row2->biayadaftar;
				
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$rowCount, $row2->no_medrec,PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->no_register);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->nama);
					if ($status=='10') {
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, ($row2->status=="1" ? "Pulang":"Dirawat"));
						/*$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $row2->biayadaftar, 2 , ',' , '.' ))
							->getStyle('F'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
						$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $row2->vtot, 2 , ',' , '.' ))
							->getStyle('F'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					} else {
						/*$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $row2->biayadaftar, 2 , ',' , '.' ))
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $row2->vtot, 2 , ',' , '.' ))
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					}
				
				}
			
				
				if ($status=='10') {
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Total')
						->getStyle('E'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					/*$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
						->getStyle('F'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
						->getStyle('F'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
				
					/*$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Total Biaya Daftar dan Tindakan')
						->getStyle('F'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
						->getStyle('G'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/	
				} else {
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total')
						->getStyle('D'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					/*$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
						->getStyle('E'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
						->getStyle('E'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);	
				
					/*$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Total Biaya Daftar dan Tindakan')
						->getStyle('E'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
						->getStyle('F'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
				}
				
			}  

		} else if ($tampil_per=="BLN") {

			$bulan=$var1;
				
			//nama file----------------------------------
			$bulan1 = $tgl_indo->bulan(substr($bulan,5,2)).date('Y', strtotime($bulan));
			$date_title = "Bulan";
			$date="$bulan1";
			//-------------------------------------------
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Bulan : '.$date);
			 $objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Pasien : '.$cara_bayar);
				
			
			if ($id_poli=="SEMUA") {
				
				$file_name="KEU_POLI_$bulan1.xlsx";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_poli_bulanan(substr($bulan,5,2), $status, $cara_bayar)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A6', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B6', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C6', 'Tanggal');
				//$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Total Biaya Daftar');
				$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Total Biaya Tindakan');
				$rowCount=6;
				
				foreach($poli as $row1){ 

					$array = json_decode(json_encode($data_laporan_keu), True);
					$data_poli=array_column($array, 'id_poli');
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {	
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						$setpoli=0;
						
						$i=1;
						$vtot=0;
						$biayadaftar=0;
						foreach($data_laporan_keu as $row2){
							if ($row2->id_poli==$row1->id_poli) {
								
								$rowCount++;
								$vtot+=$row2->jumlah_vtot;
								$biayadaftar+=$row2->jumlah_biayadaftar;
								

								if ($setpoli==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row1->nm_poli);
									$setpoli=1;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->tgl_kunj);
								/*$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $row2->jumlah_biayadaftar, 2 , ',' , '.' ))
									->getStyle('D'.$rowCount)
									->getAlignment()
									->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								*/
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $row2->jumlah_vtot, 2 , ',' , '.' ))
									->getStyle('D'.$rowCount)
									->getAlignment()
									->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								
							}
						}
						
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						/*$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						*/
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

						/*$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,'Total Biaya Daftar dan Tindakan')
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						*/
					}
				}
			} else { //else per_tampil 'BLN' dan id_poli!='SEMUA'
				
				$file_name="KEU_POLI_".$id_poli."_$bulan1.xlsx";
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_bulanan(substr($bulan,5,2), $id_poli, $status, $cara_bayar)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Poliklinik : '.$nm_poli);
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A7', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B7', 'Tanggal');
				//$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Total Biaya Daftar');
				$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Total Biaya Tindakan');
				$rowCount=7;

				$i=1;
				$vtot=0;
				$biayadaftar=0;
				foreach($data_laporan_keu as $row){
					$vtot+=$row->jumlah_vtot;
					$biayadaftar+=$row->jumlah_biayadaftar;
					
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tgl_kunj);
					/*$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $row->jumlah_biayadaftar, 2 , ',' , '.' ))
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					*/
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $row->jumlah_vtot, 2 , ',' , '.' ))
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}
				
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total')
					->getStyle('B'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				/*$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
				/*$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Biaya Daftar dan Tindakan')
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
					->getStyle('D'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
			}
			
		} else if ($tampil_per=="THN") {
				
			$tahun=$var1;
			
			$date_title = 'Tahun';
			$date=$tahun;
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tahun : '.$date);
			$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Pasien : '.$cara_bayar);

			
			if ($id_poli=="SEMUA") {
			
				$file_name="KEU_POLI_$tahun.xlsx";
				$poli=$this->Rjmpencarian->get_poliklinik()->result();
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_poli_tahunan($tahun, $status, $cara_bayar)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A6', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B6', 'Poliklinik');
				$objPHPExcel->getActiveSheet()->SetCellValue('C6', 'Bulan');
				//$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Total Biaya Daftar');
				$objPHPExcel->getActiveSheet()->SetCellValue('D6', 'Total Biaya Tindakan');
				$rowCount=6;

				
				foreach($poli as $row1){ 
					$array = json_decode(json_encode($data_laporan_keu), True);
					$data_poli=array_column($array, 'id_poli');
					//Klo data tdk kosong, tampilkan
					if (in_array($row1->id_poli, $data_poli)) {	
		
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.($rowCount+1), $no++);
						$setpoli=0;
		
						$i=1;
						$vtot=0;
						//$biayadaftar=0;
						foreach($data_laporan_keu as $row2){
							if ($row2->id_poli==$row1->id_poli) {
								
								$rowCount++;
								$vtot+=$row2->jumlah_vtot;
								//$biayadaftar+=$row2->jumlah_biayadaftar;
								

								if ($setpoli==0){
									$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row1->nm_poli);
									$setpoli=1;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $tgl_indo->bulan($row2->bulan_kunj));
								/*$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $row2->jumlah_biayadaftar, 2 , ',' , '.' ))
								->getStyle('D'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $row2->jumlah_vtot, 2 , ',' , '.' ))
								->getStyle('D'.$rowCount)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							}
						}
					
						$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,'Total')
							->getStyle('C'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						/*$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

						/*$rowCount++;
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,'Total Biaya Daftar dan Tindakan')
							->getStyle('D'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
							->getStyle('E'.$rowCount)
							->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
					} //end if data tdk kosong
				} 

			} else { //else per_tampil 'THN' dan id_poli!='SEMUA'
				
				$file_name="KEU_POLI_".$id_poli."_$tahun.xlsx";
				$data_laporan_keu=$this->Rjmlaporan->get_data_keu_tahunan($tahun, $id_poli, $status, $cara_bayar)->result();
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'Poliklinik : '.$nm_poli);
				
				$objPHPExcel->getActiveSheet()->SetCellValue('A7', 'No');
				$objPHPExcel->getActiveSheet()->SetCellValue('B7', 'Bulan');
				//$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Total Biaya Daftar');
				$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Total Biaya Tindakan');
				$rowCount=7;
				
				$i=1;
				$vtot=0;
				//$biayadaftar=0;
				foreach($data_laporan_keu as $row){
					$vtot+=$row->jumlah_vtot;
					//$biayadaftar+=$row->jumlah_biayadaftar;
					
					$rowCount++;
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $no++);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $tgl_indo->bulan($row->bulan_kunj));
					/*$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $row->jumlah_biayadaftar, 2 , ',' , '.' ))
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $row->jumlah_vtot, 2 , ',' , '.' ))
						->getStyle('C'.$rowCount)
						->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}
				
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total')
					->getStyle('B'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				/*$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $biayadaftar, 2 , ',' , '.' ))
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, number_format( $vtot, 2 , ',' , '.' ))
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
				/*$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total Biaya Daftar dan Tindakan')
					->getStyle('C'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format( $biayadaftar+$vtot, 2 , ',' , '.' ))
					->getStyle('D'.$rowCount)
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);*/
			}
		}	
		
		// header('Content-Disposition: attachment;filename="'.$file_name.'"');  
					
		// // Rename worksheet (worksheet, not filename)  
		// $objPHPExcel->getActiveSheet()->setTitle('Laporan Keuangan');  
   
		// // Redirect output to a client’s web browser (Excel2007)  
		// //clean the output buffer  
		// ob_end_clean();  
   
		// //this is the header given from PHPExcel examples.   
		// //but the output seems somewhat corrupted in some cases.  
		// //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
		// //so, we use this header instead.  
		// header('Content-type: application/vnd.ms-excel');  
		// header('Cache-Control: max-age=0');  
		   
		// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
		// $objWriter->save('php://output');
	
		// redirect('irj/Rjclaporan/lapkeu','refresh');

		 header('Content-Type: application/vnd.ms-excel'); //mime type
      header('Content-Disposition: attachment;filename="'.$file_name.'"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache
                  
      //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
      //if you want to save it as .XLSX Excel 2007 format
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
      //force user to download the Excel file without writing it to server's HD
      $objWriter->save('php://output');		
	}

	public function cetak_laporan_log_user($tgl_awal='',$tgl_akhir=''){
		require_once (APPPATH.'third_party/PHPExcel.php');

      set_time_limit(0);

      //load our new PHPExcel library
      //$this->load->library('excel');
      //$this->excel = new PHPExcel();

      $excel = PHPExcel_IOFactory::load("./download/inap/laporan/pembayaran/template_log_user.xls");

      //activate worksheet number 1
      $excel->setActiveSheetIndex(0);
      //name the worksheet
      $excel->getActiveSheet()->setTitle('Worksheet 1');

      //ambil semua data pendapatan
      $data_log_user = $this->rimuser->get_log_user_all($tgl_awal,$tgl_akhir);
      //print_r($data_pasien_keluar_tanggal[0]);exit;
      $row = 1;
      //set header excel
      // $this->excel->getActiveSheet()->setCellValue('A'.$row, 'UPT');
      // $this->excel->getActiveSheet()->setCellValue('B'.$row, 'Unit');
      // $this->excel->getActiveSheet()->setCellValue('C'.$row, 'Nama Aset');
      // $this->excel->getActiveSheet()->setCellValue('D'.$row, 'Merk');
      // $this->excel->getActiveSheet()->setCellValue('E'.$row, 'No Seri');
      // $this->excel->getActiveSheet()->setCellValue('F'.$row, 'Kondisi');
      // $this->excel->getActiveSheet()->setCellValue('G'.$row, 'PIC');
      // $this->excel->getActiveSheet()->setCellValue('H'.$row, 'No Inventaris');
      // $this->excel->getActiveSheet()->setCellValue('I'.$row, 'IP Address');
      // $this->excel->getActiveSheet()->setCellValue('J'.$row, 'Perolehan');
      // $this->excel->getActiveSheet()->setCellValue('K'.$row, 'Lokasi');
      
      $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      $excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
      $excel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      
      $excel->getActiveSheet()->setAutoFilter('A1:B1');
    
      foreach ($data_log_user as $r) {
      

        $row++;
        $excel->getActiveSheet()->setCellValue('A'.$row, $r['usr'],PHPExcel_Cell_DataType::TYPE_STRING);
        $excel->getActiveSheet()->setCellValue('B'.$row, $r['jml'],PHPExcel_Cell_DataType::TYPE_STRING);
        
      }

        // //change the font size
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        // //make the font become bold
        // $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        // //merge cell A1 until D1
        // $this->excel->getActiveSheet()->mergeCells('A1:D1');
        // //set aligment to center for that merged cell (A1 to D1)
        // $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	  $start_date_format = date("d-m-Y", strtotime($tgl_awal));
	  $end_date_format = date("d-m-Y", strtotime($tgl_akhir));
      $filename='log_user_rawat_inap_'.$start_date_format.'_.'.$end_date_format.'.xls'; //save our workbook as this file name
      header('Content-Type: application/vnd.ms-excel'); //mime type
      header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
      header('Cache-Control: max-age=0'); //no cache
                  
      //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
      //if you want to save it as .XLSX Excel 2007 format
      $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');  
      //force user to download the Excel file without writing it to server's HD
      $objWriter->save('php://output');
	}
	
}
?>