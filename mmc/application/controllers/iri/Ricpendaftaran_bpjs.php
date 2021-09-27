<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
class Ricpendaftaran_bpjs extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('iri/rimpendaftaran');
		$this->load->model('iri/rimcara_bayar');
		$this->load->model('iri/rimkelas');
		$this->load->model('iri/rimreservasi');
		$this->load->model('iri/rimtindakan');
		$this->load->model('irj/rjmregistrasi');
		$this->load->model('irj/rjmregistrasi','',TRUE);
		$this->load->model('irj/M_update_sepbpjs');
	}
	
	public function index($noreservasi=''){
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		
		$value=array(
			'noreservasi'=>$noreservasi
		);
		$this->session->set_userdata($value);
		$irna_antrian=$this->rimpendaftaran->select_irna_antrian_by_noreservasi($this->session->userdata('noreservasi'));

		$tppri=$irna_antrian[0]['tppri'];
		if($tppri=='rawatjalan'){
			$pasien=$this->rimpendaftaran->select_pasien_irj_by_no_register_asal($irna_antrian[0]['no_register_asal']);
		}else if($tppri=='ruangrawat'){
			$pasien=$this->rimpendaftaran->select_pasien_iri_by_no_register_asal($irna_antrian[0]['no_register_asal']);
		}else{
			$pasien=$this->rimpendaftaran->select_pasien_ird_by_no_register_asal($irna_antrian[0]['no_register_asal']);
		}

		$data['irna_reservasi']=$irna_antrian;
		
		$data['kelas'] = $this->rimkelas->get_all_kelas_with_empty_bed();
		$data['status_bed'] = $this->rimkelas->get_status_bed($irna_antrian[0]['kelas'],$irna_antrian[0]['idrg']);

		$data['all_kelas'] = $this->rimkelas->get_kelas();

		$data['empty_bed'] = $this->rimkelas->get_all_empty_bed_by_kelas_and_ruang($irna_antrian[0]['kelas'],$irna_antrian[0]['idrg']);


		$data['data_pasien']=$pasien;
		$data['kls_bpjs']='';
		$pasiendetail = $this->rjmregistrasi->get_data_pasien_by_no_cm_baru($irna_antrian[0]['no_medrec'])->result();
		foreach($pasiendetail as $row){
			$no_medrec=$row->no_medrec;
			$data['kls_bpjs']=$row->kelas_bpjs;
		}
		//get data ppk
		$data['ppk']=$this->rimpendaftaran->get_all_ppk();

		//cara bayar
		$data['cara_bayar']=$this->rimcara_bayar->get_all_cara_bayar();

		//get cara kunjungan
		$data['smf']=$this->rimpendaftaran->get_all_smf();
		//print_r($data['smf']);exit;
		//kontraktor
		$data['kontraktorbpjs']=$this->rjmregistrasi->get_kontraktor_bpjs('BPJS')->result_array();
		$data['kontraktor']=$this->rjmregistrasi->get_kontraktor_bpjs('DIJAMIN')->result_array();
		
		//$this->load->view('iri/rivlink');
		// $this->load->view('iri/rivheader');
		// $this->load->view('iri/rivmenu', $data);
		//$this->load->view('iri/rivpendaftaran', $data_reservasi);
		$this->load->view('iri/form_pendaftaran_bpjs', $data);
		//$this->load->view('iri/rivfooter');
	}
	public function data_ruang() {
		// 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		$keyword = $this->uri->segment(4);
		$data = $this->rimpendaftaran->select_ruang_like($keyword);
		foreach($data as $row){
			$arr['query'] = $keyword;
			$arr['suggestions'][] 	= array(
				'value'				=>$row['idrg'].' - '.$row['nmruang'].' - '.$row['koderg'],
				'idrg'				=>$row['idrg'],
				'nmruang'			=>$row['nmruang'],
				'kelas'				=>$row['koderg']
			);
		}
		echo json_encode($arr);
    }
	public function insert_pendaftaran(){
		$no_kartu = $this->input->post('no_bpjs');
	 	if ($this->input->post('diagnosa_id') == '-' OR $this->input->post('diagnosa_id') == '') {
		$notif = 	'
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, Diagnosa Tidak Boleh Kosong.
								</div>
							</div>';
			$this->session->set_flashdata('notification', $notif);	
			redirect('iri/ricpendaftaran_bpjs/index/'.$this->input->post('noipdlama'));	     		
	 	} // metadata code			

		$data_pendaftaran['noregasal']=$this->input->post('noregasal');
		// $data_pendaftaran['no_cm']=$this->input->post('no_cm');
		$data_pendaftaran['no_cm']=$this->input->post('no_cm_hidden');
		$data_pendaftaran['tgldaftarri']=$this->input->post('tgldaftarri');
		$data_pendaftaran['carabayar']=$this->input->post('carabayar');
		$data_pendaftaran['id_smf']=$this->input->post('id_smf');
		$data_pendaftaran['id_dokter']=$this->input->post('id_dokter');
		$data_pendaftaran['dokter']=$this->input->post('nmdokter');
		
		
		$data_pendaftaran['noipdlama']=$this->input->post('noipdlama');
		$data_pendaftaran['nama']=$this->input->post('nama');
		$data_pendaftaran['tgl_masuk']=date('Y-m-d');

		//ambil_data irna antrian
		$irna_antrian = $this->rimreservasi->select_irna_antrian_by_noreservasi($data_pendaftaran['noipdlama']);
		$data_pendaftaran['diagmasuk'] = $irna_antrian[0]['diagnosa'] ;//isi sama diagnosa di irna antrian

		//data lainlain
		$data_pendaftaran['jatahklsiri']=$this->input->post('jatahkls');
		$data_pendaftaran['nosjp']=$this->input->post('nosjp');
		$data_pendaftaran['nopembayarri']=$this->input->post('nopembayarri');
		$id_kontraktor = $this->input->post('nmkontraktorbpjs');
		if($this->input->post('carabayar')=='BPJS'){
			$id_kontraktor = $this->input->post('nmkontraktorbpjs');
		}		
		$data_pendaftaran['id_kontraktor']=$id_kontraktor;
		$data_pendaftaran['ketpembayarri']=$this->input->post('ketpembayarri');
		$data_pendaftaran['nmpembayatri']=$this->input->post('nmpembayarri');
		$data_pendaftaran['golpembayarri']=$this->input->post('golpembayarri');
		$data_pendaftaran['nmpjawabri']=$this->input->post('nmpjawabri');
		$data_pendaftaran['alamatpjawabri']=$this->input->post('alamatpjawabri');
		$data_pendaftaran['notlppjawab']=$this->input->post('notlppjawab');
		$data_pendaftaran['kartuidpjawab']=$this->input->post('kartuidpjawab');
		$data_pendaftaran['noidpjawab']=$this->input->post('noidpjawab');
		$data_pendaftaran['hubpjawabri']=$this->input->post('hubjawabri');
		$data_pendaftaran['no_sep']=$this->input->post('no_sep_hidden');
		if($data_pendaftaran['no_sep'] == ""){
			$data_pendaftaran['no_sep'] = $this->input->post('no_sep');
		}


		//
		// $data_pendaftaran['idrg']=$this->input->post('ruang');
		// $data_ruang_iri['kelas']=$this->input->post('kelas');
		$temp_ruang=$this->input->post('ruang');
		$temp_ruang =explode("-", $temp_ruang);
		$data_pendaftaran['idrg']=$temp_ruang[0]; // Kode ruang pilih
		$data_pendaftaran['klsiri']=$temp_ruang[2]; // Kode ruang pilih
		$data_ruang_iri['kelas']=$temp_ruang[2]; // Kelas

		$data_ruang_iri['idrg']=$temp_ruang[0];
		$data_ruang_iri['bed']=$this->input->post('bed');
		$login_data = $this->load->get_var("user_info");
		$data_ruang_iri['xuser']=$login_data->username;

		//ngambil dari jatah kelas
		$data_ruang_iri['harga_jatah_kelas']= 0;
		// $biaya_ruang = $this->rimkelas->get_tarif_ruangan($data_pendaftaran['jatahklsiri'],$data_pendaftaran['idrg']);
		// if(!($biaya_ruang) || $data_pendaftaran['carabayar'] != 'DIJAMIN / JAMSOSKES'){
		// 	$data_ruang_iri['harga_jatah_kelas']= 0;
		// }else{
		// 	$data_ruang_iri['harga_jatah_kelas']=$biaya_ruang[0]['total_tarif'];
		// }
		
		$data_pendaftaran['bed']=$data_ruang_iri['bed']; // Kode ruang pilih
		$data_ruang_iri['tglmasukrg']=$this->input->post('tglmasukrg');

		//get biaya ruang
		$biaya_ruang = $this->rimkelas->get_tarif_ruangan($data_ruang_iri['kelas'],$data_pendaftaran['idrg']);
		$data_ruang_iri['vtot']=$biaya_ruang[0]['total_tarif'];
		
		$data_pendaftaran['ipdibu']=$this->input->post('noipdibu');
		if($data_pendaftaran['ipdibu'] != ""){
			$data_ibu = $this->rimtindakan->get_pasien_by_no_ipd($data_pendaftaran['ipdibu']);

			//overide data yang awal diganti pake data yang dari ibu untuk ruangannya aja. kalo ada ipd ibu
			$data_pendaftaran['idrg']=$data_ibu[0]['idrg']; // Kode ruang pilih
			$data_pendaftaran['klsiri']=$data_ibu[0]['kelas']; // Kode ruang pilih
			$data_ruang_iri['kelas']=$data_ibu[0]['kelas']; // Kelas
			$data_ruang_iri['idrg']=$data_ibu[0]['idrg'];
			$data_ruang_iri['bed']=$data_ibu[0]['bed'];
			$data_pendaftaran['bed']=$data_ibu[0]['bed']; // Kode ruang pilih
			$data_ruang_iri['vtot']=0;
		}

		// MENU
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		//cek kalo bed masih kosong, kalo udah diisi ga bisa
		$bed=$this->input->post('bed');
		$bed = $this->rimkelas->get_bed_by_bed($bed);
		if($bed[0]['isi'] == 'Y' && $data_pendaftaran['ipdibu'] == ""){
			$this->session->set_flashdata('pesan',
			"<div class='alert alert-error alert-dismissable'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<i class='icon fa fa-close'></i> Bed Sudah Terisi, Silahkan Pilih Bed Lain!
			</div>");
			header('Location: '.base_url().'iri/ricpendaftaran_bpjs/index/'.$data_pendaftaran['noipdlama']);
			exit;
		}

		//select bed yang kosong
		//update bed menjadi Y

		//set no_ipd
		//ambil tindakan by id. kalo misalnya idnya kosong, isi. kalo udah ada tambahin 1 1 aja terus
		$no=count($this->rimpendaftaran->select_pasien_iri())+1;
		$data_pendaftaran['no_ipd']='RI'.sprintf("%08d", $no);
		$temp_data_ipd = $this->rimtindakan->get_pasien_by_no_ipd($data_pendaftaran['no_ipd']);
		while (($temp_data_ipd)) {
			$no = $no + 1;
			$data_pendaftaran['no_ipd']='RI'.sprintf("%08d", $no);
			$temp_data_ipd =  $this->rimtindakan->get_pasien_by_no_ipd($data_pendaftaran['no_ipd']);
		}

		$login_data = $this->load->get_var("user_info");
		$data_pendaftaran['verifuser']=$login_data->username;
		$status_pasien = $this->rimpendaftaran->insert_pendaftaran($data_pendaftaran); 
		$data_ruang_iri['no_ipd']=$data_pendaftaran['no_ipd'];
		//end query id

		// if($data_pendaftaran['carabayar'] == "BPJS" or $data_pendaftaran['carabayar'] == "DIJAMIN"){
		// 	$message = "<div class='alert alert-success alert-dismissable'>
		// 	<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		// 	<i class='icon fa fa-check'></i> Data telah tersimpan! Klik <a href='".base_url()."iri/ricsjp/cetak_sjp/".$data_pendaftaran['no_ipd']."' target='_blank'>disini</a> untuk mencetak SJP
		// </div>";
		// }else{
		// 	$message = "<div class='alert alert-success alert-dismissable'>
		// 	<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		// 	<i class='icon fa fa-check'></i> Data telah tersimpan!
		// </div>";
		// }
			if($data_pendaftaran['carabayar'] == "DIJAMIN / JAMSOSKES"){
			$message = "<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<i class='icon fa fa-check'></i> Data telah tersimpan! Klik <a href='".base_url()."iri/ricsjp/cetak_sjp/".$data_pendaftaran['no_ipd']."' target='_blank'>disini</a> untuk mencetak SJP
			</div>";
			}
			else if($data_pendaftaran['carabayar'] == "BPJS"){
			$this->create_sep($no_kartu,$data_pendaftaran['no_ipd'],$data_pendaftaran['noipdlama'],$this->input->post('no_cm'));
			$message = '<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>		
			<i class="icon fa fa-check"></i> Data telah tersimpan! Klik <a href="'.base_url().'iri/ricsjp/cetak_sjp/'.$data_pendaftaran['no_ipd'].'" target="_blank">disini</a> untuk mencetak SJP
								</div>
							</div></div>';			
			} else{
			$message = "<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<i class='icon fa fa-check'></i> Data telah tersimpan!
			</div>";
			}		

		$this->session->set_flashdata('pesan',$message);
		$data_update['statusantrian']='Y';

		$data_bed['isi'] = 'Y';
		$this->rimkelas->flag_bed_by_id($data_bed, $data_ruang_iri['bed']);
		$this->rimpendaftaran->insert_ruang_iri($data_ruang_iri);
		$this->rimpendaftaran->update_irna_antrian($data_update, $data_pendaftaran['noipdlama']);

		redirect('iri/ricdaftar_bpjs','refresh');
		
		// $this->validation_pendaftaran(); // Form validasi
		// if($this->form_validation->run()==FALSE){
		// 	$this->session->set_flashdata('pesan',
		// 	"<div class='alert alert-danger alert-dismissable'>
		// 		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		// 		<i class='icon fa fa-check'></i> Data gagal tersimpan!
		// 	</div>");
		// 	redirect('iri/ricpendaftaran_bpjs');
		// }else{
		// 	$this->session->set_flashdata('pesan',
		// 	"<div class='alert alert-success alert-dismissable'>
		// 		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		// 		<i class='icon fa fa-check'></i> Data telah tersimpan!
		// 	</div>");
		// 	$data_update['statusantrian']='Y';
		// 	$this->rimpendaftaran->update_irna_antrian($data_update, $data_pendaftaran['noipdlama']);
		// 	$this->rimpendaftaran->insert_pendaftaran($data_pendaftaran);
		// 	$this->rimpendaftaran->insert_ruang_iri($data_ruang_iri);
		// 	redirect('iri/ricdaftar');
		// }
	}

	public function validation_pendaftaran(){
		$this->form_validation->set_rules('noregasal', 'No. Reg. Asal', 'required');
	}

	public function data_dokter_autocomp() {
		

		// 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		$keyword = $this->uri->segment(4);
		$data = $this->rimpendaftaran->select_dokter_like($keyword);
		foreach($data as $row){
			
			
			$arr['query'] = $keyword;
			$arr['suggestions'][] 	= array(
				'value'				=>$row['nm_dokter'],
				'id_dokter'				=>$row['id_dokter'],
				'nm_dokter'				=>$row['nm_dokter']
			);
		}
		echo json_encode($arr);
    }

public function create_sep($no_kartu='',$no_register='',$no_antrian='',$no_cm='')
	{	
		$data_bpjs = $this->M_update_sepbpjs->get_data_bpjs();
		$cons_id = $data_bpjs->consid;
		$sec_id = $data_bpjs->secid;
		$ppk_pelayanan = $data_bpjs->rsid;

		$tgl_sep = date('Y-m-d 00:00:00');
        $url = $data_bpjs->service_url;
        $entri_catatan = $this->M_update_sepbpjs->get_pasien_iri($no_register);

        $timezone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		$timestamp = strval(time()-strtotime('1970-01-01 00:00:00')); //cari timestamp
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date('Y-m-d 00:00:00');
		$http_header = array(
			   'Accept: application/json',
			   'Content-type: application/x-www-form-urlencoded',
			   'X-cons-id: ' . $cons_id, //id rumah sakit
			   'X-timestamp: ' . $timestamp,
			   'X-signature: ' . $encoded_signature
		);
		date_default_timezone_set($timezone);
  		$ch = curl_init($url . 'Peserta/Peserta/'.$no_kartu);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch); //json file
		curl_close($ch);
    	if($result!='') { //valid koneksi internet
		$datakartu = json_decode($result)->response;
		}
		$cek_peserta = json_decode($result);
	 	if ($cek_peserta->metadata->code == '401') {
		$notif = 	'
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, '.$cek_peserta->metadata->message.'
								</div>
							</div>';
			$this->session->set_flashdata('notification', $notif);	
			redirect('iri/ricpendaftaran_bpjs/index/'.$no_antrian);	     		
	 	} // metadata code			
	 	if ($cek_peserta->metadata->message == 'KP : Peserta Tidak Ditemukan') {
		$notif = 	'
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, Data Peserta Untuk Nomor '.$no_kartu.' Tidak Ditemukan
								</div>
							</div>';
			$this->session->set_flashdata('notification', $notif);	
			redirect('iri/ricpendaftaran_bpjs/index/'.$no_antrian);	     		
	 	} // metadata code		

       $no_medrec =$entri_catatan->no_cm;
	   $login_data = $this->load->get_var("user_info");
	   $xuser=$login_data->username;

		if($datakartu->peserta->provUmum->kdProvider==NULL or $datakartu->peserta->provUmum->kdProvider==''){
			$ppkrujuk='0902R002';
		}else
			$ppkrujuk=$datakartu->peserta->provUmum->kdProvider;


		if($entri_catatan->nosjp==NULL or $entri_catatan->nosjp==''){
			$norujuk='0';
		}else
			$norujuk=$entri_catatan->nosjp;

 		 $data = array(
		   	'request'=>array(
		   		't_sep'=>array(
		   			'noKartu' => $no_kartu,
		   			'tglSep' =>  $tgl_sep,
		   			'tglRujukan' => $tgl_sep,
		   			'noRujukan' => $norujuk,//$entri_catatan->NO_RUJUKAN,
		   			'ppkRujukan' => $ppkrujuk,
		   			'ppkPelayanan' => $ppk_pelayanan,
		   			'jnsPelayanan' => '1',
		   			'catatan' => $entri_catatan->catatan,
		   			'diagAwal' => $entri_catatan->diagmasuk,
		   			'poliTujuan' => '', // INT
		   			'klsRawat' => $datakartu->peserta->kelasTanggungan->kdKelas, // DARI BPJS NO KARTU
		   			'lakaLantas' => '2',
		   			'lokasiLaka' => '',   			
		   			'user' => $xuser,
		   			'noMr' => $no_cm 
		   			)
		   		)
		   	);		  
    	   $datasep=json_encode($data);
       	   // print_r($datasep);exit();
           $ch = curl_init($url . 'SEP/insert');
             curl_setopt($ch, CURLOPT_POST, true);
             curl_setopt($ch, CURLOPT_POSTFIELDS, $datasep);
             curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              $result = curl_exec($ch);
             curl_close($ch);
             if($result!=''){//valid koneksi internet
		     $sep = json_decode($result);
         // print_r($sep);exit; ///////////////////////////////////////
		    if ($sep->metadata->code == '800') {
			$notif = 	'
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, '.$sep->metadata->message.'
								</div>
							</div>';
			$this->session->set_flashdata('notification', $notif);
			redirect('iri/ricpendaftaran_bpjs/index/'.$no_antrian);		     
		    }
			else if ($sep->metadata->code == '200') {
          	$data_update = array(
            'no_sep' => $sep->response
              );
            $this->M_update_sepbpjs->update_sep_iri($no_register,$data_update);
            // print_r($sep->response);
            // exit();
			echo '<script type="text/javascript">window.open("'.site_url("iri/sep_manual/cetak_sep").'/'.$no_register.'", "_blank");window.focus()</script>';			
			$notif = 	'<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Berhasil membuat SEP dengan No. '.$sep->response.', Silahkan Klik <a href="'.site_url("iri/sep_manual/cetak_sep").'/'.$no_register.'" target="_blank">disini</a> Untuk Cetak SEP.
								</div>
							</div></div>';
			$this->session->set_flashdata('notification', $notif);					
			// redirect('iri/ricdaftar_bpjs','refresh');		
			} else {
			$notif = 	'
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, '.$sep->metadata->message.'
								</div>
							</div>';
			$this->session->set_flashdata('notification', $notif);
			redirect('iri/ricpendaftaran_bpjs/index/'.$no_antrian);					
				// exit();
			}
		 } else{
		 	echo "Pastikan Anda Terhubung Internet!!";
		// exit();
		 }
} // create sep

}
