<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
include('Rjcterbilang.php');
class Rjcregistrasi extends Secure_area {
//class rjcregistrasi extends CI_Controller {
	public function __construct() {
			parent::__construct();
			$this->load->model('irj/rjmpencarian','',TRUE);
			$this->load->model('irj/rjmregistrasi','',TRUE);
			$this->load->model('irj/rjmpelayanan','',TRUE);
			$this->load->model('irj/rjmkwitansi','',TRUE);
			$this->load->model('irj/ModelRegistrasi','',TRUE);
			$this->load->model('admin/M_user','',TRUE);
			$this->load->model('irj/M_update_sepbpjs','',TRUE);
			
			$this->load->helper('pdf_helper');
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////registrasi biodata pasien
	public function index()
	{
		$data['title'] = 'Registrasi / Daftar Ulang Pasien';
		$data['data_pasien']="";
		$this->load->view('irj/rjvformcaripasien',$data);
	}
	
	public function regpasien()
	{
		$data['title'] = 'Pendataan Biodata Pasien';
		//$data['data_pasien']="";
		$data['kontraktor']=$this->rjmpencarian->get_kontraktor()->result();
		$data['prop']=$this->rjmpencarian->get_prop()->result();
		$data['last_mr']=$this->ModelRegistrasi->get_last_cmpatria()->row()->no_cm;
		//$data['mrnrp']=$this->rjmpencarian->get_hubungan()->result();
		$this->load->view('irj/rjvformdaftar',$data);
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////alamat
	public function data_kotakab($id_prop='',$sid='')
	{
		$data=$this->rjmpencarian->get_kotakab($id_prop)->result();
			echo "<option selected value=''>Pilih Kota/Kabupaten</option>";
			foreach($data as $row){
				echo "<option value='$row->id-$row->nama'>$row->nama</option>";
			}
	}
	public function data_kecamatan($id_kabupaten='',$sid='')
	{
		$data=$this->rjmpencarian->get_kecamatan($id_kabupaten)->result();
			echo "<option selected value=''>Pilih Kecamatan</option>";
			foreach($data as $row){
				echo "<option value='$row->id-$row->nama'>$row->nama</option>";
			}
	}

	public function data_kelurahan($id_kecamatan='',$sid='')
	{
		$data=$this->rjmpencarian->get_kelurahan($id_kecamatan)->result();
			echo "<option selected value=''>Pilih Kelurahan</option>";
			foreach($data as $row){
				echo "<option value='$row->id-$row->nama'>$row->nama</option>";
			}
	}
	public function data_dokter_poli($id_poli='')
	{
		$data=$this->rjmpelayanan->get_dokter_poli($id_poli)->result();
			echo "<option selected value=''>-Pilih Dokter-</option>";
			foreach($data as $row){
				echo "<option value='$row->id_dokter'>$row->nm_dokter</option>";
			}
	}
	public function data_kontraktor($tipe='')
	{
		$data=$this->rjmregistrasi->get_kontraktor_bpjs($tipe)->result();
			echo "<option selected value=''>-Pilih Penjamin-</option>";
			foreach($data as $row){
				echo "<option value='$row->id_kontraktor'>$row->nmkontraktor</option>";
			}
	}
	public function data_kontraktorCoba()
	{
		$tipe='BPJS';
		$data=$this->rjmregistrasi->get_kontraktor_bpjs($tipe)->result();
		echo json_encode($data);
	}

	public function data_tindakan_iri(){
		$keyword=$this->input->post('q');
		//echo json_encode($keyword);			
		$data=$this->rjmregistrasi->get_all_tindakan('III',$keyword)->result();
		echo json_encode($data);
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function pasien($cm='')
	{
		$data['title'] = 'Registrasi Pasien Bridging BPJS';
		
			
		if($this->input->post('cari_no_cm')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_cm($this->input->post('cari_no_cm'))->result();
		}		
		else if($this->input->post('cari_no_kartu')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_kartu($this->input->post('cari_no_kartu'))->result();
		}
		else if($this->input->post('cari_no_identitas')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_identitas($this->input->post('cari_no_identitas'))->result();
		}
		else if($this->input->post('cari_nama')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_nama($this->input->post('cari_nama'))->result();
		}
		else if($this->input->post('cari_alamat')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_alamat($this->input->post('cari_alamat'))->result();
		}
		else if($this->input->post('cari_tgl')!=''){
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_tgl($this->input->post('cari_tgl'))->result();
		}
		
		if (empty($data['data_pasien'])==1) 
		{
			$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-danger alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Data pasien tidak ditemukan !
							</h4>
						</div>
					</div>
				</div>';
			$this->session->set_flashdata('success_msg', $success);
			redirect('irj/rjcregistrasi');
		
		} else {
		
			$this->load->view('irj/rjvformcaripasien',$data);
		}
		
	}
	
	public function cek_available_nokartu($nokartu, $nokartuold='')
	{
		$result=$this->rjmregistrasi->cek_no_kartu($nokartu,$nokartuold);
		echo $result->num_rows();
	}
	
	public function cek_available_noidentitas($noidentitas, $noidentitasold='')
	{
		$result=$this->rjmregistrasi->cek_no_identitas($noidentitas, $noidentitasold);
		echo $result->num_rows();
	}
	
	// non tni
	// tni & kel
	public function insert_tindakan_kartu($data1)
	{
		date_default_timezone_set("Asia/Jakarta");
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xuser']=$user;
		$data['xupdate']=date("Y-m-d H:i:s");
		// baru BA0102 , lama BA0103 //
		$data['no_register']=$data1['no_register'];
		$no_register=$data1['no_register'];		
		$data['id_poli']=$data1['id_poli'];
		
			//tni
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0105')->row();	
			$data['idtindakan']='1B0105';
			$data['tgl_kunjungan']=date("Y-m-d H:i:s");
			$data['bpjs']='0';
			/*if($data1['jenis_pasien']=='BARU'){
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
				$data['idtindakan']='BA0102';					
			}else{
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0103')->row();
				$data['idtindakan']='BA0103';
			}		*/

			$data['nmtindakan']=$detailtind->nmtindakan;		

			$data['biaya_tindakan']=$detailtind->total_tarif;
			$data['biaya_alkes']=$detailtind->tarif_alkes;
			$data['qtyind']='1';
			//$data['dijamin']=$this->input->post('dijamin');
			$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
			
                        
			$id=$this->rjmpelayanan->insert_tindakan($data);
			
			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$data['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot,$data1['no_register']);

		
		
	}

	//automatic add action
	public function insert_tindakan($data1)
	{
		date_default_timezone_set("Asia/Jakarta");
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xuser']=$user;
		$data['xupdate']=date("Y-m-d H:i:s");
		// baru BA0102 , lama BA0103 //
		$data['no_register']=$data1['no_register'];
		$no_register=$data1['no_register'];		
		$data['id_poli']=$data1['id_poli'];				
		//default BA0102
		if($data['id_poli']=='BA00'){
			//1B0102 ->> BPJS Administrasi
			if($data1['jenis_pasien']=='BARU'  && $data1['no_nrp']==''){
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0102')->row();
				$data['idtindakan']='1B0102';
				$data['bpjs']='0';
			}else if($data1['cara_bayar']=='BPJS'){
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0102')->row();
				$data['idtindakan']='1B0102';
				$data['bpjs']='1';
			}
			else { 
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0101')->row();	
				$data['idtindakan']='1B0101s';
				$data['bpjs']='0';
			}
			$data['tgl_kunjungan']=date("Y-m-d H:i:s");

		/*if($data1['jenis_pasien']=='BARU'){
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
			$data['idtindakan']='BA0102';					
		}else{
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0103')->row();
			$data['idtindakan']='BA0103';
		}		*/

			$data['nmtindakan']=$detailtind->nmtindakan;		

			$data['biaya_tindakan']=$detailtind->total_tarif;
			$data['biaya_alkes']=$detailtind->tarif_alkes;
			$data['qtyind']='1';
			//$data['dijamin']=$this->input->post('dijamin');
			$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
 //       		print_r($data);exit();	
			$id=$this->rjmpelayanan->insert_tindakan($data);
			
			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$data['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot,$data1['no_register']);
		}else{

			if($data1['jenis_pasien']=='BARU' && $data1['no_nrp']==''){
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0102')->row();
				$data['idtindakan']='1B0102';
				$data['bpjs']='0';
			}
			else if($data1['cara_bayar']=='BPJS'){
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0102')->row();
				$data['idtindakan']='1B0102';
				$data['bpjs']='1';
			}			
			else { 
				$detailtind=$this->rjmregistrasi->get_detail_tindakan('1B0101')->row();	
				$data['idtindakan']='1B0101';
				$data['bpjs']='0';
			}			
			$data['tgl_kunjungan']=date("Y-m-d H:i:s");

		/*if($data1['jenis_pasien']=='BARU'){
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
			$data['idtindakan']='BA0102';					
		}else{
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0103')->row();
			$data['idtindakan']='BA0103';
		}		*/

			$data['nmtindakan']=$detailtind->nmtindakan;		

			$data['biaya_tindakan']=$detailtind->total_tarif;
			$data['biaya_alkes']=$detailtind->tarif_alkes;
			$data['qtyind']='1';
			//$data['dijamin']=$this->input->post('dijamin');
			$data['vtot']=(int)$data['biaya_tindakan']+(int)$data['biaya_alkes'];
			
			$id=$this->rjmpelayanan->insert_tindakan($data);
			
			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$data['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot,$data1['no_register']);
		}
			

		if($data['id_poli']=='BZ04'){ //lab
			$data4['lab']=1;
			$data4['status_lab']=0;
			$data4['jadwal_lab']=date("Y-m-d H:i:s");
			$data4['ket_pulang']="PULANG";
			$data4['tgl_pulang']=date("Y-m-d");
			$id=$this->rjmpelayanan->update_rujukan_penunjang($data4,$no_register);
		}else if($data['id_poli']=='BZ02'){ //rad
			$data4['rad']=1;
			$data4['status_rad']=0;
			$data4['jadwal_rad']=date("Y-m-d H:i:s");
			$data4['ket_pulang']="PULANG";
			$data4['tgl_pulang']=date("Y-m-d");
			$id=$this->rjmpelayanan->update_rujukan_penunjang($data4,$no_register);
		}else if($data['id_poli']=='BZ01'){ //pa
			$data4['pa']=1;
			$data4['status_pa']=0;
			$data4['jadwal_pa']=date("Y-m-d H:i:s");
			$data4['ket_pulang']="PULANG";
			$data4['tgl_pulang']=date("Y-m-d");
			$id=$this->rjmpelayanan->update_rujukan_penunjang($data4,$no_register);
		}/*else{
			//add periksa
			$detailperiksa=$this->rjmregistrasi->get_tarif_periksa_dokter($data1['id_dokter'])->row();

			$data3['id_dokter']=$data1['id_dokter'];
			$data3['nmtindakan']=$detailperiksa->nmtindakan;
			$data3['nm_dokter']=$detailperiksa->nm_dokter;
			$data3['idtindakan']=$detailperiksa->id_biaya_periksa;
			$data3['qtyind']='1';
			$data3['biaya_tindakan']=$detailperiksa->total_tarif;
			$data3['biaya_alkes']=$detailperiksa->tarif_alkes;
			$data3['vtot']=(int)$data3['biaya_tindakan']+(int)$data3['biaya_alkes'];
			$data3['no_register']=$data1['no_register'];
			$data3['xuser']=$user;
			$id=$this->rjmpelayanan->insert_tindakan($data3);
			
			//penambahan vtot di daftar_ulang_irj
			$vtot_sebelumnya = $this->rjmpelayanan->get_vtot($data1['no_register'])->row()->vtot;
			$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$data3['vtot'];
			$this->rjmpelayanan->update_vtot($data_vtot,$data1['no_register']);
		}*/
		$no_register=$data1['no_register'];
                
//cetak kwitansi biaya daftar       
	//	echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_faktur_kt/$no_register").'", "_blank");window.focus()</script>';
	
                if($data1['cara_bayar']!='UMUM'){
		echo '<script type="text/javascript">window.open("'.site_url("irj/rjcsjp/cetak_sjp/$no_register").'", "_blank");window.focus()</script>';
                }				
	}

	public function irj_pulang()
	{			
		$data['daftar_pasien']=$this->rjmregistrasi->get_daftar_pasien_belum_pulang()->result();

		$data['title'] = 'Daftar Pasien Rawat Jalan yang Belum Pulang';
		$data['message'] = '';
		$data['search_per']='cm';
		$this->load->view('irj/rjvformdaftarpulang',$data);
	}
	public function kelola_sep()
	{			//2016-09-25 2017-03-02
		
		if($this->input->post('tgl0')!=''){
			$tgl0=$this->input->post('tgl0');
			$tgl00=date('d-m-Y', strtotime($tgl0));
		}else{
			$tgl0=date('Y-m-d', strtotime('-7 days'));
			$tgl00=date('d-m-Y', strtotime('-7 days'));
		}

		if($this->input->post('tgl1')!=''){
			$tgl1=$this->input->post('tgl1');
			$tgl11=date('d-m-Y', strtotime($tgl1));
		}else{
			$tgl1=date('Y-m-d');
			$tgl11=date('d-m-Y');
		}
		$data['daftar_sep']=$this->rjmregistrasi->get_daftar_sep($tgl0,$tgl1)->result();

		$data['title'] = 'Kelola Data SEP | '.$tgl00.' s/d '.$tgl11;
		$data['message'] = '';
		$data['search_per']='cm';
		$this->load->view('irj/rjvformsep',$data);	
	}	

	public function kontrol_pasien()
	{			//2016-09-25 2017-03-02
		
		if($this->input->post('tgl0')!=''){
			$tgl0=$this->input->post('tgl0');
			$tgl00=date('d-m-Y', strtotime($tgl0));
		}else{
			$tgl0=date('Y-m-d', strtotime('-7 days'));
			$tgl00=date('d-m-Y', strtotime('-7 days'));
		}

		if($this->input->post('tgl1')!=''){
			$tgl1=$this->input->post('tgl1');
			$tgl11=date('d-m-Y', strtotime($tgl1));
		}else{
			$tgl1=date('Y-m-d');
			$tgl11=date('d-m-Y');
		}
		$data['daftar_kontrol']=$this->rjmregistrasi->get_daftar_kontrol($tgl0,$tgl1)->result();

		$data['title'] = 'Tanggal Kontrol Pasien | '.$tgl00.' s/d '.$tgl11;
		$data['message'] = '';
		$data['search_per']='cm';
		$this->load->view('irj/rjvformkontrol',$data);	
	}	

	public function update_tgl_pulang($no_sep="") {
		$data_bpjs = $this->M_update_sepbpjs->get_data_bpjs();
		$cons_id = $data_bpjs->consid;
		$sec_id = $data_bpjs->secid;
		$ppk_pelayanan = $data_bpjs->rsid;
		$url = $data_bpjs->service_url;		
		if($no_sep==''){
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Nomor SEP tidak boleh kosong.
									</div>
							</div>
						</div>';	
				$this->session->set_flashdata('notification', $notif);		     
				redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');			
		}
		else {
        $timezone = date_default_timezone_get();
		date_default_timezone_set('Asia/Jakarta');
		$timestamp = time();  //cari timestamp
	//	$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date('Y-m-d 00:00:00');
		$http_header = array(
			   'Accept: application/json',
			   // 'Content-type: application/xml',
			   // 'Content-type: application/json',
			   'Content-type: application/x-www-form-urlencoded',
			   'X-cons-id: ' . $cons_id, //id rumah sakit
			   'X-timestamp: ' . $timestamp,
			   'X-signature: ' . $encoded_signature
		);
		date_default_timezone_set($timezone);
				$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
		  		$data = array(
		   		'request'=>array(
		   		't_sep'=>array(
		   			'noSep' => $no_sep,
		   			'tglPlg' => $date->format('Y-m-d H:i:s'),
		   			'ppkPelayanan' => $ppk_pelayanan
		   			)
		   		)
		   		);
    	   		$datasep=json_encode($data);				
         		// print_r($datasep);exit; ///////////////////////////////////////
			    $ch = curl_init($url . 'Sep/updtglplg');
			    curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
             	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
             	curl_setopt($ch, CURLOPT_POSTFIELDS, $datasep);          
             	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              	$result = curl_exec($ch);
             	curl_close($ch);
             	if($result!=''){//valid koneksi internet
		     	$sep = json_decode($result);
         		// print_r($sep->response);exit; ///////////////////////////////////////
		     	if ($sep->metadata->code == '800') {
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, '.$sep->metadata->message.'
								</div>
							</div>
						</div>';
				$this->session->set_flashdata('notification', $notif);		     
				redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');
		     	}
				if ($sep->metadata->code == '200') {
				$data_update = array(
        		'tgl_pulang' => $date->format('Y-m-d H:i:s')
      			);
        		$this->M_update_sepbpjs->update_tgl_pulang($no_sep,$data_update);						
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Tanggal pulang untuk Nomor SEP <b>'.$sep->response.'</b> berhasil diperbarui.
								</div>
							</div>
						</div>';	
				$this->session->set_flashdata('notification', $notif);		     
				redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');				
			}
				else {
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									'.$sep->metadata->message.'.
								</div>
							</div>
						</div>';	
				$this->session->set_flashdata('notification', $notif);		     
				redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');	
			}
		 }
		 		else{
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Pastikan Anda Terhubung Internet!!.
								</div>
							</div>
						</div>';	
				$this->session->set_flashdata('notification', $notif);		     
				redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');						 			
		 		}
		}
	}

public function hapus_sep($no_sep='') {
		$data_bpjs = $this->M_update_sepbpjs->get_data_bpjs();
		$cons_id = $data_bpjs->consid;
		$sec_id = $data_bpjs->secid;
		$ppk_pelayanan = $data_bpjs->rsid;				
		if($no_sep==''){
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Nomor SEP tidak boleh kosong.
									</div>
							</div>
						</div>';	
				$this->session->set_flashdata('notification', $notif);		     
				redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');			
		}
		else {
		$url = $data_bpjs->service_url;
        $timezone = date_default_timezone_get();
		date_default_timezone_set('Asia/Jakarta');
		$timestamp = time();  //cari timestamp
	//	$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date('Y-m-d 00:00:00');
		$http_header = array(
			   'Accept: application/json',
			   // 'Content-type: application/xml',
			   // 'Content-type: application/json',
			   'Content-type: application/x-www-form-urlencoded',
			   'X-cons-id: ' . $cons_id, //id rumah sakit
			   'X-timestamp: ' . $timestamp,
			   'X-signature: ' . $encoded_signature
		);
		date_default_timezone_set($timezone);
				$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
		  		$data = array(
		   		'request'=>array(
		   		't_sep'=>array(
		   			'noSep' => $no_sep,
		   			'ppkPelayanan' => $ppk_pelayanan
		   			)
		   		)
		   		);
    	   		$datasep=json_encode($data);				
         		// print_r($datasep);exit; ///////////////////////////////////////
			    $ch = curl_init($url . 'SEP/Delete');
			    curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
             	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
             	curl_setopt($ch, CURLOPT_POSTFIELDS, $datasep);          
             	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              	$result = curl_exec($ch);
             	curl_close($ch);
             	if($result!=''){//valid koneksi internet
		     	$sep = json_decode($result);
         		// print_r($sep->response);exit; ///////////////////////////////////////
		     	if ($sep->metadata->code == '800') {
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, '.$sep->metadata->message.'
								</div>
							</div>
						</div>';
				$this->session->set_flashdata('notification', $notif);		     
				redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');
		     	}
				if ($sep->metadata->code == '200') {

					$id=$this->M_update_sepbpjs->update_hapus_SEP($no_sep);
				// $data_update = array(
    //     		'no_sep' => NULL
    //   			);				
				// $this->M_update_sepbpjs->delete_sep($no_register,$no_sep,$data_update);					
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Nomor SEP <b>'.$sep->response.'</b> berhasil dihapus.
								</div>
							</div>
						</div>';	
				$this->session->set_flashdata('notification', $notif);		     
				redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');				
			}
				else {
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									'.$sep->metadata->message.'.
								</div>
							</div>
						</div>';	
				$this->session->set_flashdata('notification', $notif);		     
				redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');	
			}
		 }
		 		else{
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Pastikan Anda Terhubung Internet!!.
								</div>
							</div>
						</div>';	
				$this->session->set_flashdata('notification', $notif);		     
				redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');						 			
		 		}
		}
	}	

		public function cetak_ulang_sep($no_register="") {
		$data_bpjs = $this->M_update_sepbpjs->get_data_bpjs();
		$cons_id = $data_bpjs->consid;
		$sec_id = $data_bpjs->secid;
		$ppk_pelayanan = $data_bpjs->rsid;				
		$get_data_sep = $this->M_update_sepbpjs->get_catatan_2($no_register);
		$no_cm=$this->M_update_sepbpjs->get_nocm_pasien($get_data_sep->no_medrec)->row()->no_cm;
		$no_sep = $get_data_sep->no_sep;
		$cetakan_ke = $get_data_sep->cetak_sep_ke;
		if($no_sep==''){
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Nomor SEP tidak boleh kosong.
									</div>
							</div>
						</div>';	
				$this->session->set_flashdata('notification', $notif);		     
				redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');			
		}
		else {
		$url = $data_bpjs->service_url;
        $timezone = date_default_timezone_get();
		date_default_timezone_set('Asia/Jakarta');
		$timestamp = time();  //cari timestamp
	//	$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date('Y-m-d 00:00:00');
		$http_header = array(
			   'Accept: application/json',
			   // 'Content-type: application/xml',
			   // 'Content-type: application/json',
			     // 'Content-type: application/json',
			   'Content-type: application/x-www-form-urlencoded',
			   'X-cons-id: ' . $cons_id, //id rumah sakit
			   'X-timestamp: ' . $timestamp,
			   'X-signature: ' . $encoded_signature
				);
				date_default_timezone_set($timezone);
				//cetak sep

	    		$ch = curl_init($url . 'SEP/'.$no_sep);
	    		// print_r ($ch);exit();
				curl_setopt($ch, CURLOPT_HTTPGET, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch); //json file
				curl_close($ch);
             	if($result!=''){//valid koneksi internet
		     	$sep = json_decode($result);
		     	$datasep = json_decode($result)->response;

         		// print_r($sep->response);exit; ///////////////////////////////////////
		     	if ($sep->metadata->code == '800') {
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, '.$sep->metadata->message.'
								</div>
							</div>
						</div>';
				$this->session->set_flashdata('notification', $notif);		     
				redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');
		     	}
				if ($sep->metadata->code == '200') {

          	    $fields = array(
				'No. SEP' => $datasep->noSep,
				'Tgl. SEP' => $datasep->tglSep,
				'No. Medrec' => $no_cm,
				'No. Register' => $no_register,//$entri_catatan->NO_MEDREC,//$nomedrec,
				'No. Kartu' => $datasep->peserta->noKartu,
				'Peserta' => $datasep->peserta->jenisPeserta->nmJenisPeserta,// '', //ucfirst(strtolower($pasien->pesertaBPJS)),
				'Nama Peserta' => $datasep->peserta->nama,//ucfirst($pasien->NAMA),
				'Tgl. Lahir' => $datasep->peserta->tglLahir,//date("d-m-Y", strtotime($pasien->TGL_LAHIR)),
				'Jenis Kelamin' => $datasep->peserta->sex,//$pasien->SEX,
				'Asal Faskes' => $datasep->peserta->provUmum->nmProvider,// $sep->KD_PPK,// '', //$ppk,
				'Poli Tujuan' => $datasep->poliTujuan->nmPoli,//$entri_rd->ID_POLI,
				'Kelas Rawat' => $datasep->klsRawat->nmKelas,//$entri_rd->KELAS_PASIEN,
				'Jenis Rawat' => $datasep->jnsPelayanan,
				'Diagnosa Awal' => $datasep->diagAwal->nmDiag,// $entri_rd->DIAGNOSA,
				'Catatan' => $get_data_sep->catatan,
		  		// 'Poli RSMH'=>$entri_catatan->POLI_RSMH,
				'Nama RS' => $datasep->provPelayanan->nmProvider, //$namars
				'Cetakan Ke' => $cetakan_ke + 1 
				);
				$data_update = array(
        		'cetak_sep_ke' => $cetakan_ke + 1
      			);
        		$this->M_update_sepbpjs->update_cetakan_sep($no_register,$data_update);
				$this->sep_print($fields);				
				// $notif = 	'
				// 		<div class="content-header">
				// 			<div class="box box-default">
				// 				<div class="alert alert-success alert-dismissable">
				// 					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
				// 					Silahkan Cetak SEP dengan Nomor : <b>'.$datasep->noSep.'</b>.
				// 				</div>
				// 			</div>
				// 		</div>';	
				// $this->session->set_flashdata('notification', $notif);		     
				// redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');				
			}
				else {
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									'.$sep->metadata->message.'.
								</div>
							</div>
						</div>';	
				$this->session->set_flashdata('notification', $notif);		     
				redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');	
			}
		 }
		 		else{
				$notif = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Pastikan Anda Terhubung Internet!!.
								</div>
							</div>
						</div>';	
				$this->session->set_flashdata('notification', $notif);		     
				redirect('irj/rjcregistrasi/kelola_sep' ,'refresh');						 			
		 		}
		}
	}	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////registrasi pasien ke irj
	public function daftarulang($no_cm)
	{
		$data['title'] = 'Daftar Ulang Pasien';
		$data['biayakarcis']=$this->rjmregistrasi->get_biayakarcis()->row();
	//	$data['poliumum']=$this->rjmregistrasi->get_idpoliumum()->row()->id_poli;
			
		if($no_cm!=''){//update
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_cm_baru($no_cm)->row();
			$data['prop']=$this->rjmpencarian->get_prop()->result();
			$data['cara_berkunjung']=$this->rjmpencarian->get_cara_berkunjung()->result();
			$data['ppk']=$this->rjmpencarian->get_ppk()->result();			
			$data['kelas']=$this->rjmpencarian->get_kelas()->result();
			$data['poli']=$this->rjmpencarian->get_poliklinik()->result();
			$data['cara_bayar']=$this->rjmpencarian->get_cara_bayar()->result();
			$data['dokter']=$this->rjmpencarian->get_dokter()->result();
			$data['kontraktor']=$this->rjmpencarian->get_kontraktor()->result();
			$data['diagnosa']=$this->rjmpencarian->get_diagnosa()->result();
			$data['kecelakaan']=$this->rjmpencarian->get_data_kecelakaan()->result();
			//$data['mrnrp']=$this->rjmpencarian->get_nrp()->result();			

			$this->load->view('irj/rjvformdaftar2',$data);
			
			
		}else if($_SERVER['REQUEST_METHOD']!='POST'){
			redirect('irj/rjcregistrasi');
		}else{
			$data['data_pasien']=$this->rjmregistrasi->get_data_pasien_by_no_cm($no_cm)->row();
			$data['prop']=$this->rjmpencarian->get_prop()->result();
			$data['cara_berkunjung']=$this->rjmpencarian->get_cara_berkunjung()->result();
			$data['ppk']=$this->rjmpencarian->get_ppk()->result();
			$data['kelas']=$this->rjmpencarian->get_kelas()->result();
			$data['poli']=$this->rjmpencarian->get_poliklinik()->result();
			$data['cara_bayar']=$this->rjmpencarian->get_cara_bayar()->result();
			$data['dokter']=$this->rjmpencarian->get_dokter()->result();
			$data['kontraktor']=$this->rjmpencarian->get_kontraktor()->result();
			$data['diagnosa']=$this->rjmpencarian->get_diagnosa()->result();			
			$data['kecelakaan']=$this->rjmpencarian->get_data_kecelakaan()->result();
			//$data['mrnrp']=$this->rjmpencarian->get_nrp()->result();
			$this->load->view('irj/rjvformdaftar2',$data);		
		}
	}
	
	function cetak_faktur_kt($no_register='')
	{
			
		$login_data = $this->load->get_var("user_info");
		$user = strtoupper($login_data->username);

		if($no_register!=''){
			$cterbilang=new rjcterbilang();
			/*$get_no_kwkt=$this->rjmkwitansi->get_new_kwkt($no_register)->result();
				foreach($get_no_kwkt as $val){
					$no_kwkt=sprintf("KT%s%06s",$val->year,$val->counter+1);
				}
			$this->rjmkwitansi->update_kwkt($no_kwkt,$no_register);
			
			$tgl_kw=$this->rjmkwitansi->getdata_tgl_kw($no_register)->result();
				foreach($tgl_kw as $row){
					$tgl_jam=$row->tglcetak_kwitansi;
					$tgl=$row->tgl_kwitansi;
				}
			*/
				
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl = date("d-m-Y");

			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$telp=$this->config->item('telp');
			$alamatrs=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');

			$data_pasien=$this->rjmkwitansi->getdata_pasien($no_register)->row();
			
			$detail_daful=$this->rjmkwitansi->get_detail_daful($no_register)->row();
			// 
			//print_r($detail_daful);
			if($detail_daful->cara_bayar=='UMUM'){
				$pasien_bayar='TUNAI';
			}else $pasien_bayar='KREDIT';
			$txtkk='';
			$txtdiskon='';
			$txttunai="";
			$txtperusahaan='';
			$totalbayar='';$totalbayar1='';$totalbayar2='';
			$detail_bayar=$detail_daful->cara_bayar;


			//print_r($detail_bayar);
			if($detail_bayar=='DIJAMIN' || $detail_bayar=='BPJS')
			{
				$kontraktor=$this->rjmkwitansi->getdata_perusahaan($no_register)->row();
				$txtperusahaan="<td><b>Dijamin oleh</b></td>
						<td> : </td>
						<td>".strtoupper($kontraktor->nmkontraktor)."</td>";
			}else{
				$txtperusahaan="<td></td>
								<td></td>
								<td></td>";
			}
			
			
			
			/*$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			$vtot=0;
			foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_tindakan;
			}
			*/
			$vtot=$this->rjmkwitansi->get_vtot($no_register)->row();
			$vtot=0;
			$data_tindakan=$this->rjmkwitansi->getdata_unpaid_tindakan_pasien($no_register)->result();
			foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_tindakan;
			}
			$jumlah_vtot =  $vtot;
						
			$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);
			//echo $jumlah_vtot;
			//echo $vtot_terbilang;			

			$txtjudul="";			
			
			$style='';			
			if($data_pasien->sex=='L'){
				$sex='LAKI-LAKI';
			}else{
				$sex='PEREMPUAN';
			}

			$konten="<style type=\"text/css\">
					.table-font-size{
						font-size:7px;
					    }
					.table-font-size1{
						font-size:8.5px;
					    }
					</style>
					
					<table  border=\"0\" style=\"padding-top:10px;\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
									<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"30\" style=\"padding-right:5px;\">
								</p>
							</td>
								<td  width=\"70%\" style=\" font-size:7px;\"><b><font style=\"font-size:12px\">$namars</font></b><br><br>$alamatrs $kota_kab $telp
							</td>
							<td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam</font></td>						
						</tr>
						
					</table>
						<tr>
						<td colspan=\"3\" ><font size=\"10\" align=\"center\"><u><b>KWITANSI REGISTRASI RAWAT JALAN 
						No. $no_register-1</b></u></font></td>
					</tr>
					<table class=\"table-font-size1\" border=\"0\" style=\"padding-top:5px;\">		
								
																								
							<tr>
								<td width=\"17%\"><b>Nama Pasien</b></td>
								<td width=\"2%\">:</td>
								<td width=\"35%\">".strtoupper($data_pasien->nama)."</td>
								<td width=\"19%\"><b>Tanggal Kunjungan</b></td>
								<td width=\"2%\"> : </td>
								<td width=\"22%\">".date("d F Y",strtotime($data_pasien->tgl_kunjungan))."</td>
							</tr>
							<tr>
								<td><b>Kelamin</b></td>
								<td> : </td>
								<td>".$sex."</td>
								<td ><b>No MR</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->no_cm)."</td>
							</tr>
							<tr>
								<td><b>Alamat</b></td>
								<td> : </td>
								<td>".strtoupper($data_pasien->alamat)."</td>
								<td><b>Poli Tujuan</b></td>
								<td> : </td>
								<td>".strtoupper($data_pasien->nm_poli)."</td>
							</tr>
							
							<tr>
								<td><b>Unit</b></td>
								<td> : </td>
								<td>".$pasien_bayar."</td>
								<td ><b>Gol. Pasien</b></td>
								<td > : </td>
								<td>".strtoupper($data_pasien->cara_bayar)."</td>
							</tr>							
							<tr>
								<td><b>Waktu Shift</b></td>
								<td> : </td>
								<td>".$detail_daful->shift."</td>						
								$txtperusahaan
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>						
								<td></td>
								<td></td>
								<td></td>
							</tr>
																											
					</table>";
															
			
				
			//$data_tindakan=$this->rjmkwitansi->getdata_unpaid_tindakan_pasien($no_register)->result();

			
			//print_r($data_tindakan);
			$no=1;
			$konten.="<table border=\"1\" style=\"padding:2px\" class=\"table-font-size1\">
						<tr>
							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
							<th width=\"75%\"><p align=\"center\"><b>Pemeriksaan</b></p></th>
							<th width=\"20%\"><p align=\"center\"><b>Biaya</b></p></th>

						</tr>";
						// <tr>
						// 	<td><p align=\"center\">1</p></td>
						// 	<td><b>TINDAKAN</b></td>
						// 	<td></td>
						// 	<td><p align=\"right\">".number_format( $vtot, 2 , ',' , '.' )."</p></td>
						// </tr>";

			
				foreach($data_tindakan as $row1){
					
					$konten.="
					<tr>
						<td><p align=\"center\">".$no++."</p></td>
						<td>".ucwords(strtolower($row1->nmtindakan))."</td>
						<td><p align=\"right\">".number_format( $row1->vtot, 2 , ',' , '.' )."</p></td>
						</tr>";
					}

						
			
			$konten.="
						<tr>
							<th colspan=\"2\"><p align=\"right\"><b>Total   </b></p></th>
							<th ><p align=\"right\">".number_format( $vtot, 2 , ',' , '.' )."</p></th>
						</tr>

					</table>
					<table style=\"padding-top:5px;\" class=\"table-font-size1\"><tr>
								<td width=\"17%\"><b>Terbilang</b></td>
								<td width=\"2%\"> : </td>
								<td  width=\"78%\"><b><i>".strtoupper($vtot_terbilang)."</i></b></td>
							</tr></table>
					
					";
					/*<table style=\"border:1px solid black; \" >										
					<tr>
						<td width=\"50%\" ><p>Jumlah </p></td>
						<td width=\"10%\">:</td>
						<td width=\"40%\"><p align=\"right\"> Rp ".number_format( $vtot, 2 , ',' , '.' )."</p></td>
					</tr>
					</table>*/
			
			$konten.="
					
					<table style=\"width:100%;\" style=\"padding-bottom:5px;\">
						<tr>
							<td width=\"75%\" ></td>
							<td width=\"25%\">
								<p align=\"center\">
								$kota_kab, $tgl								
								
								<br><br>$user
								</p>
							</td>
						</tr>	
					</table>";


			//echo $konten1;			
				$konten1=$konten."<hr>".$konten."<hr>".$konten;
				$file_name="Daftar_$no_register-1.pdf";			
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
				$obj_pdf->SetMargins('5', '0', '5');
				$obj_pdf->SetAutoPageBreak(TRUE, '2');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten1;
				ob_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');				
				$obj_pdf->Output(FCPATH.'download/irj/rjkwitansi/'.$file_name, 'FI');
		}else{
			redirect('irj/rjcregistrasi/kwitansi/','refresh');
		}
	}

	public function insert_data_pasien()
	{
		$config['upload_path'] = './upload/photo';
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size'] = '2000000';
		$config['max_width'] = '2000';
		$config['max_height'] = '2000';
		$this->upload->initialize($config);
				
		if(!$this->upload->do_upload()){
			$data['foto']='unknown.png';
			// $error = $this->upload->display_errors();
			// echo $error;
		}else{
			$upload = $this->upload->data();
			$data['foto']=$upload['file_name'];
		}
	
		/*$no_cm=$this->rjmregistrasi->get_new_medrec()->result();
		foreach($no_cm as $val){
			$data['no_medrec']=sprintf("%010s",$val->counter+1);
		}
		*/
		
             //   $data['no_cm']=$this->ModelRegistrasi->get_last_cmpatria()->row()->no_cm + 1;               
//                if ($this->input->post('cm1')!= '') {               
//		 $data['no_cm']=$this->input->post('cm1').''.$this->input->post('cm2').''.$this->input->post('cm3');		
//                 // echo $data['no_cm']; exit();
//                }//else{
                //    $data['no_cm']=$this->ModelRegistrasi->get_last_cmpatria()->row()->no_cm + 1;
               // }
		if ($this->input->post('jenis_identitas')!='') {
			$data['jenis_identitas']=$this->input->post('jenis_identitas');
			$data['no_identitas']=$this->input->post('no_identitas');
		}
		//$data['jenis_kartu']=$this->input->post('jenis_kartu');
		if ($this->input->post('no_kk')!='') {
			$data['no_kk']=$this->input->post('no_kk');
		}
		
		if ($this->input->post('no_kartu')!='') {
			$data['no_kartu']=$this->input->post('no_kartu');
		}

		if ($this->input->post('id_kontraktor1')!='') {
			$data['id_kontraktor1']=$this->input->post('id_kontraktor1');
			$data['no_asuransi1']=$this->input->post('no_asuransi1');
		}
		if ($this->input->post('id_kontraktor2')!='') {
			$data['id_kontraktor2']=$this->input->post('id_kontraktor2');
			$data['no_asuransi2']=$this->input->post('no_asuransi2');
		}

		$data['nama']=strtoupper($this->input->post('nama'));		

		$data['sex']=$this->input->post('sex');
		if ($this->input->post('tmpt_lahir')!='') {
			$data['tmpt_lahir']=$this->input->post('tmpt_lahir');
		}
            //    $tgl='13-05-1995';//$this->input->post('tgl_lahir');
            //    $tgl_baru = $tgl->format('Y-m-d');
		$tgl =$this->input->post('tgl_lahir');
		$data['tgl_lahir']=date('Y-m-d',strtotime($tgl));
                $data['agama']=$this->input->post('agama');
		$data['wnegara']=$this->input->post('wnegara');
		$data['status']=$this->input->post('status');
		$data['alamat']=$this->input->post('alamat');
		$data['rt']=$this->input->post('rt');
		$data['rw']=$this->input->post('rw');
		$data['id_kelurahandesa']=$this->input->post('id_kelurahandesa');
		$data['kelurahandesa']=$this->input->post('kelurahandesa');
		$data['id_kecamatan']=$this->input->post('id_kecamatan');
		$data['kecamatan']=$this->input->post('kecamatan');
		$data['id_kotakabupaten']=$this->input->post('id_kotakabupaten');
		$data['kotakabupaten']=$this->input->post('kotakabupaten');
		$data['id_provinsi']=$this->input->post('id_provinsi');
		$data['provinsi']=$this->input->post('provinsi');
		$data['kodepos']=$this->input->post('kodepos');
		$data['pendidikan']=$this->input->post('pendidikan');
		$data['pekerjaan']=$this->input->post('pekerjaan');
		$data['no_telp']=$this->input->post('no_telp');
		$data['no_hp']=$this->input->post('no_hp');
		$data['no_telp_kantor']=$this->input->post('no_telp_kantor');
		$data['email']=$this->input->post('email');
		$data['goldarah']=$this->input->post('goldarah');
		$data['nm_ibu_istri']=$this->input->post('nm_ibu_istri');
		date_default_timezone_set("Asia/Jakarta");
		$data['tgl_kunjungan']=date("Y-m-d H:i:s");		
		$data['xupdate']=date("Y-m-d H:i:s");
		$data['xuser']=$this->input->post('user_name');		
	
           //   print_r($data);exit();
	
                 if ($this->input->post('cm1')!= '') {               
		 $data['no_cm']=$this->input->post('cm1').''.$this->input->post('cm2').''.$this->input->post('cm3');		
                 // echo $data['no_cm']; exit();
                 $id=$this->rjmregistrasi->insert_pasien_irj_lama($data);
                }else{ 
                 //   $data['no_cm'] = $this->rjmregistrasi->get_no_cm();
                //    print_r($data);exit();
                    $id=$this->rjmregistrasi->insert_pasien_irj($data);
                }
                
		$success = 	'<div class="content-header">
						<div class="box box-default">
							<div class="alert alert-success alert-dismissable">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
								<h4>
								<i class="icon fa fa-check"></i>
								Input biodata berhasil. Silahkan daftar ulang pasien...
								</h4>
							</div>
						</div>
					</div>';
		$this->session->set_flashdata('success_msg', $success);
		//redirect('irj/rjcregistrasi/daftarulang/'.$data['no_medrec']);
		redirect('irj/rjcregistrasi/daftarulang/'.$id);
	}

        public function update_data_pasien()
	{	
			
			$config['upload_path'] = './upload/photo';
			$config['allowed_types'] = 'gif|png|jpg';
			$config['max_size'] = '2000000';
			$config['max_width'] = '2000';
			$config['max_height'] = '2000';
			$this->upload->initialize($config);
					
			if(!$this->upload->do_upload()){
				// $data['foto']='unknown.png';
				// $error = $this->upload->display_errors();
				// echo $error;
			}else{
				$upload = $this->upload->data();
				$data['foto']=$upload['file_name'];
			}
			
		$no_medrec=$this->input->post('no_cm');
		$data['no_cm']=$this->input->post('cm_baru');
		if($this->input->post('jenis_identitas')!=''){
			$data['jenis_identitas']=$this->input->post('jenis_identitas');
			$data['no_identitas']=$this->input->post('no_identitas');
		}
		//$data['jenis_kartu']=$this->input->post('jenis_kartu');
		if ($this->input->post('no_kk')!='') {
			$data['no_kk']=$this->input->post('no_kk');
		}
		if($this->input->post('no_kartu')!=''){
			$data['no_kartu']=$this->input->post('no_kartu');
		}						

		$data['id_kontraktor1']=$this->input->post('id_kontraktor1');
		$data['no_asuransi1']=$this->input->post('no_asuransi1');
		$data['id_kontraktor2']=$this->input->post('id_kontraktor2');
		$data['no_asuransi2']=$this->input->post('no_asuransi2');
		$data['nama']=$this->input->post('nama');
		$data['sex']=$this->input->post('sex');
		$data['tmpt_lahir']=$this->input->post('tmpt_lahir');
                $tgl =$this->input->post('tgl_lahir');
		$data['tgl_lahir']=date('Y-m-d',strtotime($tgl));
	//	$data['tgl_lahir']=$this->input->post('tgl_lahir');
		$data['agama']=$this->input->post('agama');
		$data['wnegara']=$this->input->post('wnegara');
		$data['status']=$this->input->post('status');
		$data['alamat']=$this->input->post('alamat');
		$data['rt']=$this->input->post('rt');
		$data['rw']=$this->input->post('rw');
		$data['id_kelurahandesa']=$this->input->post('id_kelurahandesa');
		$data['kelurahandesa']=$this->input->post('kelurahandesa');
		$data['id_kecamatan']=$this->input->post('id_kecamatan');
		$data['kecamatan']=$this->input->post('kecamatan');
		$data['id_kotakabupaten']=$this->input->post('id_kotakabupaten');
		$data['kotakabupaten']=$this->input->post('kotakabupaten');
		$data['id_provinsi']=$this->input->post('id_provinsi');
		$data['provinsi']=$this->input->post('provinsi');
		$data['kodepos']=$this->input->post('kodepos');
		$data['pendidikan']=$this->input->post('pendidikan');
		$data['pekerjaan']=$this->input->post('pekerjaan');
		$data['no_telp']=$this->input->post('no_telp');
		$data['no_hp']=$this->input->post('no_hp');
		$data['no_telp_kantor']=$this->input->post('no_telp_kantor');
		$data['email']=$this->input->post('email');
		$data['goldarah']=$this->input->post('goldarah');
		$data['nm_ibu_istri']=$this->input->post('nm_ibu_istri');

		date_default_timezone_set("Asia/Jakarta");		
		$data['xupdate']=date("Y-m-d H:i:s");
		$data['xuser']=$this->input->post('user_name');

		$id=$this->rjmregistrasi->update_pasien_irj($data,$no_medrec);
		//print_r($data);
		redirect('irj/rjcregistrasi/daftarulang/'.$no_medrec);
	}
	
  

        public function insert_daftar_ulang()
	{
		$no_medrec=$this->input->post('no_medrec');
		$no_rujukan=$this->input->post('no_rujukan');
		$no_kartu=$this->input->post('no_kartu');
		if ($no_kartu == '' && $no_rujukan == '' && $this->input->post('cara_bayar')=="BPJS") {
		$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Harap Masukkan Nomor Kartu BPJS atau Nomor Rujukan.
								</div>
							</div>
						</div>';
		$this->session->set_flashdata('success_msg', $success);	
		redirect('irj/rjcregistrasi/daftarulang/'.$no_medrec);//exit();	    		
	 	} // no_kartu & no_rujukan null		
		
		//cek data poli hari ini
		$cek_data_poli=$this->rjmregistrasi->cek_data_poli($no_medrec)->row();
		
		if (isset($cek_data_poli) && $this->input->post('id_poli')!='BA00' && $this->input->post('cara_bayar')=='BPJS' )
		{			
			$data_poli = $cek_data_poli->nm_poli;
			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>
									Maaf, Pasien sudah terdaftar pada poli "'.$cek_data_poli->nm_poli.'" pada tanggal "'.date('d F Y H:i',strtotime($cek_data_poli->tgl_kunjungan)).'".<br>
									<i class="icon fa fa-uncheck"></i>
									Silahkan Pulangkan Kunjungan Sebelumnya.
									</h4>
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('success_msg', $success);
			
			redirect('irj/rjcregistrasi');
					
		} else {			
			//get umur
			$get_umur=$this->rjmregistrasi->get_umur($no_medrec)->result();
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
			
			//$no_register=$this->rjmregistrasi->get_new_register()->result();

			$data['umurrj']=$tahun;
			$data['uharirj']=$hari;
			$data['ublnrj']=$bulan;

			$data['no_medrec']=$no_medrec;
			$data['jns_kunj']=$this->input->post('jns_kunj');
			$data['tgl_kunjungan']=$this->input->post('tgl_kunjungan');
			$data['cara_kunj']=$this->input->post('cara_kunj');
			$data['catatan']=$this->input->post('entri_catatan');			
			if($this->input->post('asal_rujukan')!=''){
				$data['asal_rujukan']=$this->input->post('asal_rujukan');
			}

			if($this->input->post('dll_rujukan')!=''){
				$data['asal_rujukan']=$this->input->post('dll_rujukan');
			}

			if($this->input->post('no_rujukan')!=''){
				$data['no_rujukan']=$this->input->post('no_rujukan');
			}
			if($this->input->post('tgl_rujukan')!=''){
				$data['tgl_rujukan']=$this->input->post('tgl_rujukan');
			}
			$data['kelas_pasien']=$this->input->post('kelas_pasien');
			$data['cara_bayar']=$this->input->post('cara_bayar');
			if($this->input->post('id_kontraktor')!=''){
				$data['id_kontraktor']=$this->input->post('id_kontraktor');
			}
			if($this->input->post('id_diagnosa')!=''){
				$data['diagnosa']=$this->input->post('id_diagnosa');
			}
			$data['id_poli']=$this->input->post('id_poli');
			$data['id_dokter']=$this->input->post('id_dokter');

			if($this->input->post('id_poli')=='BA00'){
				$data['alasan_berobat']=$this->input->post('alber');
		
				if($this->input->post('pasdatDg')!=''){
					$data['datang_dengan']=$this->input->post('pasdatDg');}

				if($this->input->post('jenis_kecelakaan')!=''){
					$data['kecelakaan']=$this->input->post('jenis_kecelakaan');
					if($this->input->post('lokasi_kecelakaan')!=''){
						$data['lokasi_kecelakaan']=$this->input->post('lokasi_kecelakaan');
					}
				}
			}
			//$data['kd_ruang']=$this->input->post('kd_ruang');
			//$data['biayadaftar']=$this->input->post('biayadaftar');
			$data['biayadaftar']=0;
			
			$data['nama_penjamin']=$this->input->post('nama_penjamin');
			$data['hubungan']=$this->input->post('hubungan');
			$data['vtot']=0;
			//$data['no_sep']=$this->input->post('no_sep');
			$data['xuser']=$this->input->post('user_name');
			$data['xupdate']=date('Y-m-d H:i:s');
			
				$id=$this->rjmregistrasi->insert_daftar_ulang($data);
				$data['no_nrp']=$this->input->post('hidden_nrpdaful');				
				$data['no_register']=$id->no_register;
				//echo $getnoreg; break;
				$data['jenis_pasien']=$this->input->post('jns_kunj');
				if($this->input->post('cetak_kartu')=='1'){
                                         // untuk insert kartu
					//$this->insert_tindakan_kartu($data);
                                        // untuk cetak kartu pasien
					//irj/rjcregistrasi/cetak_kartu_pasien
					$no_cm = $this->input->post('cetak_kartu1');
					echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/st_cetak_kartu_pasien/$no_cm").'", "_blank");window.focus()</script>';
				}
				
				$this->insert_tindakan($data);			
			
			
			if ($data['cara_bayar']!="BPJS") {
				$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>
									Daftar ulang pasien berhasil.
									</h4>
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('success_msg', $success);						
			} 
						
			//print_r($data);
			//cetak_karcis
			//echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_karcis/$id->no_register").'", "_blank");window.focus()</script>';
			//cetak identitas			
			if($this->input->post('jns_kunj')=='BARU'){
				echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_identitas/").'/'.$this->input->post('cetak_kartu1').'", "_blank");window.focus()</script>';
			}
			$noreg=$id->no_register;
			//if($this->input->post('id_poli')!='BA00'){
 //		 	echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_tracer/$noreg").'", "_blank");window.focus()</script>';
			// //}
			// //cetak sep
			// if ($data['cara_bayar']=="BPJS") {
			// 	//$data2['no_sep']=$this->buat_SEP($id->no_register);
			// 	//echo $data2['no_sep'];
			// 	//$result = $this->rjmregistrasi->update_SEP($no_register, $data2);
				
			 //    echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_sep/$id->no_register").'", "_blank");window.focus()</script>';
			// }
			$noreg=$id->no_register;
			$no_register=$data['no_register'];
			if($this->input->post('id_poli')!='BA00'){
				if ($data['cara_bayar']=="BPJS") {
					if ($no_rujukan == '') {
					$this->create_sep($no_kartu,$no_register);
					$success = 	'
							<div class="content-header">
								<div class="box box-default">
									<div class="alert alert-success alert-dismissable">
										<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
										<h4>
										<i class="icon fa fa-check"></i>
										Daftar ulang pasien berhasil. Silahkan Cetak SEP</h4>
									</div>
								</div>
							</div>';
					$this->session->set_flashdata('success_msg', $success);				
			}
			if ($no_rujukan != '') {		
			// echo '<script type="text/javascript">window.open("'.site_url("irj/c_sepdetail/sep_cetak/$no_rujukan/$no_medrec/$no_register").'", "_blank");window.focus()</script>';
			$this->create_sep($no_kartu,$no_register);				

			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>
									Daftar ulang pasien berhasil. Silahkan Cetak SEP</h4>
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('success_msg', $success);						
			}					
				} // == bpjs
			else {
				//echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_tracer/$noreg").'", "_blank");window.focus()</script>';	
				}				
			} // idpoli =!= BA00
			else {
				if ($data['cara_bayar']=="BPJS" && $no_kartu != '') {
				// echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_tracer/$id->no_register").'", "_blank");window.focus()</script>'; // Cetak SEP Saja
				if ($no_rujukan == '') {
			$this->create_sep($no_kartu,$no_register);
			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>
									Daftar ulang pasien berhasil. Silahkan Cetak SEP</h4>
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('success_msg', $success);					
			}
			if ($no_rujukan != '') {		
			//echo '<script type="text/javascript">window.open("'.site_url("irj/c_sepdetail/sep_cetak/$no_rujukan/$no_medrec/$no_register").'", "_blank");window.focus()</script>';

			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>
									Daftar ulang pasien berhasil. Silahkan Cetak SEP</h4>
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('success_msg', $success);						
			}									
				}	// == bpjs	
				else {
			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Daftar Ulang Berhasil.
								</div>
							</div>
						</div>';					echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_tracer/$noreg").'", "_blank");window.focus()</script>';
			$this->session->set_flashdata('success_msg', $success);		
			//redirect('irj/rjcregistrasi/');			
				}	// else == bpjs && no_kartu != ''	
			} // else idpoli == BA00			
			// if ($data['cara_bayar']=="BPJS") {
				//$data2['no_sep']=$this->buat_SEP($id->no_register);
				//echo $data2['no_sep'];
				//$result = $this->rjmregistrasi->update_SEP($no_register, $data2);
				
				//echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_sep/$id->no_register").'", "_blank");window.focus()</script>';
			// }
		}			
			
		redirect('irj/rjcregistrasi/','refresh');
	}


 
/*        
 	public function insert_daftar_ulang()
	{
		$no_medrec=$this->input->post('no_medrec');
		$no_rujukan=$this->input->post('no_rujukan');
		$no_kartu=$this->input->post('no_kartu');
		if ($no_kartu == '' && $no_rujukan == '' && $this->input->post('cara_bayar')=="BPJS") {
		$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Harap Masukkan Nomor Kartu BPJS atau Nomor Rujukan.
								</div>
							</div>
						</div>';
		$this->session->set_flashdata('success_msg', $success);	
		redirect('irj/rjcregistrasi/daftarulang/'.$no_medrec);//exit();	    		
	 	} // no_kartu & no_rujukan null		
		
		//cek data poli hari ini
		$cek_data_poli=$this->rjmregistrasi->cek_data_poli($no_medrec)->row();
		
		if (isset($cek_data_poli) && $this->input->post('id_poli')!='BA00' && $this->input->post('cara_bayar')=='BPJS' )
		{			
			$data_poli = $cek_data_poli->nm_poli;
			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>
									Maaf, Pasien sudah terdaftar pada poli "'.$cek_data_poli->nm_poli.'" pada tanggal "'.date('d F Y H:i',strtotime($cek_data_poli->tgl_kunjungan)).'".<br>
									<i class="icon fa fa-uncheck"></i>
									Silahkan Pulangkan Kunjungan Sebelumnya.
									</h4>
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('success_msg', $success);
			
			redirect('irj/rjcregistrasi');
					
		} else {			
			//get umur
			$get_umur=$this->rjmregistrasi->get_umur($no_medrec)->result();
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
			
			//$no_register=$this->rjmregistrasi->get_new_register()->result();

			$data['umurrj']=$tahun;
			$data['uharirj']=$hari;
			$data['ublnrj']=$bulan;

			$data['no_medrec']=$no_medrec;
			$data['jns_kunj']=$this->input->post('jns_kunj');

			$data['cara_kunj']=$this->input->post('cara_kunj');
			$data['catatan']=$this->input->post('entri_catatan');			
			if($this->input->post('asal_rujukan')!=''){
				$data['asal_rujukan']=$this->input->post('asal_rujukan');
			}

			if($this->input->post('dll_rujukan')!=''){
				$data['asal_rujukan']=$this->input->post('dll_rujukan');
			}

			if($this->input->post('no_rujukan')!=''){
				$data['no_rujukan']=$this->input->post('no_rujukan');
			}
			if($this->input->post('tgl_rujukan')!=''){
				$data['tgl_rujukan']=$this->input->post('tgl_rujukan');
			}
			$data['kelas_pasien']=$this->input->post('kelas_pasien');
			$data['cara_bayar']=$this->input->post('cara_bayar');
			if($this->input->post('id_kontraktor')!=''){
				$data['id_kontraktor']=$this->input->post('id_kontraktor');
			}
			if($this->input->post('id_diagnosa')!=''){
				$data['diagnosa']=$this->input->post('id_diagnosa');
			}
			$data['id_poli']=$this->input->post('id_poli');
			$data['id_dokter']=$this->input->post('id_dokter');

			if($this->input->post('id_poli')=='BA00'){
				$data['alasan_berobat']=$this->input->post('alber');
		
				if($this->input->post('pasdatDg')!=''){
					$data['datang_dengan']=$this->input->post('pasdatDg');}

				if($this->input->post('jenis_kecelakaan')!=''){
					$data['kecelakaan']=$this->input->post('jenis_kecelakaan');
					if($this->input->post('lokasi_kecelakaan')!=''){
						$data['lokasi_kecelakaan']=$this->input->post('lokasi_kecelakaan');
					}
				}
			}
			//$data['kd_ruang']=$this->input->post('kd_ruang');
			//$data['biayadaftar']=$this->input->post('biayadaftar');
			$data['biayadaftar']=0;
			
			$data['nama_penjamin']=$this->input->post('nama_penjamin');
			$data['hubungan']=$this->input->post('hubungan');
			$data['vtot']=0;
			//$data['no_sep']=$this->input->post('no_sep');
			$data['xuser']=$this->input->post('user_name');
			$data['xupdate']=date('Y-m-d H:i:s');
			
				$id=$this->rjmregistrasi->insert_daftar_ulang($data);
				$data['no_nrp']=$this->input->post('hidden_nrpdaful');				
				$data['no_register']=$id->no_register;
				//echo $getnoreg; break;
				$data['jenis_pasien']=$this->input->post('jns_kunj');
				if($this->input->post('cetak_kartu')=='1'){

					$this->insert_tindakan_kartu($data);

					//irj/rjcregistrasi/cetak_kartu_pasien
					$no_cm = $this->input->post('cetak_kartu1');
					echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/st_cetak_kartu_pasien/$no_cm").'", "_blank");window.focus()</script>';
				}
				
				$this->insert_tindakan($data);			
			
			
			if ($data['cara_bayar']!="BPJS") {
				$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>
									Daftar ulang pasien berhasil.
									</h4>
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('success_msg', $success);						
			} 
			// else {
			// 	$success = 	'
			// 			<div class="content-header">
			// 				<div class="box box-default">
			// 					<div class="alert alert-success alert-dismissable">
			// 						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
			// 						<h4>
			// 						<i class="icon fa fa-check"></i>
			// 						Daftar ulang pasien berhasil.
			// 						</h4>
			// 					</div>
			// 				</div>
			// 			</div>';
			// }
			
			

			//print_r($data);
			//cetak_karcis
			//echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_karcis/$id->no_register").'", "_blank");window.focus()</script>';
			//cetak identitas			
			if($this->input->post('jns_kunj')=='BARU'){
				echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_identitas/").'/'.$this->input->post('cetak_kartu1').'", "_blank");window.focus()</script>';
			}
			$noreg=$id->no_register;
			//if($this->input->post('id_poli')!='BA00'){
		//	 	echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_tracer/$noreg").'", "_blank");window.focus()</script>';
			// //}
			// //cetak sep
			// if ($data['cara_bayar']=="BPJS") {
			// 	//$data2['no_sep']=$this->buat_SEP($id->no_register);
			// 	//echo $data2['no_sep'];
			// 	//$result = $this->rjmregistrasi->update_SEP($no_register, $data2);
				
			// 	//echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_sep/$id->no_register").'", "_blank");window.focus()</script>';
			// }
			$noreg=$id->no_register;
			$no_register=$data['no_register'];
			if($this->input->post('id_poli')!='BA00'){
				if ($data['cara_bayar']=="BPJS") {
					if ($no_rujukan == '') {
					$this->create_sep($no_kartu,$no_register);
					$success = 	'
							<div class="content-header">
								<div class="box box-default">
									<div class="alert alert-success alert-dismissable">
										<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
										<h4>
										<i class="icon fa fa-check"></i>
										Daftar ulang pasien berhasil. Silahkan Cetak SEP</h4>
									</div>
								</div>
							</div>';
					$this->session->set_flashdata('success_msg', $success);				
			}
			if ($no_rujukan != '') {		
			// echo '<script type="text/javascript">window.open("'.site_url("irj/c_sepdetail/sep_cetak/$no_rujukan/$no_medrec/$no_register").'", "_blank");window.focus()</script>';
			$this->create_sep($no_kartu,$no_register);				

			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>
									Daftar ulang pasien berhasil. Silahkan Cetak SEP</h4>
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('success_msg', $success);						
			}					
				} // == bpjs
			else {
				echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_tracer/$noreg").'", "_blank");window.focus()</script>';	
				}				
			} // idpoli =!= BA00
			else {
				if ($data['cara_bayar']=="BPJS" && $no_kartu != '') {
				// echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_tracer/$id->no_register").'", "_blank");window.focus()</script>'; // Cetak SEP Saja
				if ($no_rujukan == '') {
			$this->create_sep($no_kartu,$no_register);
			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>
									Daftar ulang pasien berhasil. Silahkan Cetak SEP</h4>
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('success_msg', $success);					
			}
			if ($no_rujukan != '') {		
			echo '<script type="text/javascript">window.open("'.site_url("irj/c_sepdetail/sep_cetak/$no_rujukan/$no_medrec/$no_register").'", "_blank");window.focus()</script>';

			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>
									Daftar ulang pasien berhasil. Silahkan Cetak SEP</h4>
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('success_msg', $success);						
			}									
				}	// == bpjs	
				else {
			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Daftar Ulang Berhasil.
								</div>
							</div>
						</div>';
						echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_tracer/$noreg").'", "_blank");window.focus()</script>';
			$this->session->set_flashdata('success_msg', $success);		
			//redirect('irj/rjcregistrasi/');			
				}	// else == bpjs && no_kartu != ''	
			} // else idpoli == BA00			
			// if ($data['cara_bayar']=="BPJS") {
				//$data2['no_sep']=$this->buat_SEP($id->no_register);
				//echo $data2['no_sep'];
				//$result = $this->rjmregistrasi->update_SEP($no_register, $data2);
				
				//echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_sep/$id->no_register").'", "_blank");window.focus()</script>';
			// }
		}			
		

		
		redirect('irj/rjcregistrasi/','refresh');
	}

*/        
        public function sep_print($fields)
	{			
		//set timezone
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
		// $data_identitas=$this->rjmregistrasi->getdata_identitas($no_cm)->result();	
		$namars=$this->config->item('namars');
		$alamatrs=$this->config->item('alamat');
		$telprs=$this->config->item('telp');
		$kota=$this->config->item('kota');
		$nmsingkat=$this->config->item('nmsingkat');				
		
		// foreach($data_identitas as $row){
		$konten="<style type=\"text/css\">
				.table-font-size{
					font-size:12px;
				    }
				.table-font-size2{
					font-size:10px;
					padding : 1px, 2px, 2px;
				    }
				.font-italic{
					font-size:9px;
					font-style:italic;
				    }
				</style>
				<table class=\"table-font-size\" border=\"0\">
					<tr>
						<td width=\"20%\" style=\"border-bottom:1px solid black; font-size:13px;\">
								<img src=\"asset/images/logos/logobpjs.png\" alt=\"img\" height=\"70\" style=\"padding-right:5px;\">
						</td>
						<td width=\"60%\" style=\"border-bottom:1px solid black; font-size:13px;\">
							<p align=\"center\">
								<br>
								<b>Surat Eligibilitas Peserta</b>
								<br>
								<b>$namars</b>
							</p>
						</td>
						<td width=\"20%\" style=\"border-bottom:1px solid black; font-size:13px;\" align=\"right\">
								<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
						</td>
					</tr>
				</table>	
				<br><br>
				<table class=\"table-font-size2\" border=\"0\">
					<tr>
						<td width=\"15%\">No. SEP</td>
						<td width=\"40%\">: ".$fields['No. SEP']."</td>
						<td width=\"15%\"></td>
						<td width=\"30%\"></td>
					</tr>		
					<tr>
						<td>Tgl. SEP</td>
						<td>: ".$fields['Tgl. SEP']."</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>No. Kartu</td>
						<td>: ".$fields['No. Kartu']." MR: ".$fields['No. Medrec']."</td>
						<td>Peserta</td>
						<td>: ".$fields['Peserta']."</td>
					</tr>		
					<tr>
						<td>Nama Peserta</td>
						<td>: ".$fields['Nama Peserta']."</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Tgl. Lahir</td>
						<td>: ".$fields['Tgl. Lahir']."</td>
						<td>COB</td>
						<td>: </td>
					</tr>		
					<tr>
						<td>Jenis Kelamin</td>
						<td>: ".$fields['Jenis Kelamin']."</td>
						<td>Jenis Rawat</td>
						<td>: ".$fields['Jenis Rawat']."</td>
					</tr>		
					<tr>
						<td>Poli Tujuan</td>
						<td>: ".$fields['Poli Tujuan']."</td>
						<td>Kelas Rawat</td>
						<td>: ".$fields['Kelas Rawat']."</td>
					</tr>		
					<tr>
						<td>Asal Faskes</td>
						<td>: ".$fields['Asal Faskes']."</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Diagnosa Awal</td>
						<td colspan=\"3\">: ".$fields['Diagnosa Awal']."</td>
					</tr>		
					<tr>
						<td>Catatan</td>
						<td>: ".$fields['Catatan']."</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td colspan=\"4\">
							<font class=\"font-italic\"><br>
*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan.<br>
*SEP bukan sebagai bukti penjaminan peserta
							</font>
						</td>
					</tr>		
					<tr>
						<td>Cetakan Ke ".$fields['Cetakan Ke']."</td>
						<td>: ".$date->format('d-m-Y H:i:s')."</td>
						<td></td>
						<td></td>
					</tr>										
				</table>
				<br><br>
				<table class=\"table-font-size2\" border=\"0\" align=\"center\">
					<tr>
						<td width=\"5%\"></td>
						<td width=\"30%\">Pasien / Keluarga Pasien <br><br></td>
						<td width=\"30%\">Petugas RS</td>
						<td width=\"30%\">Petugas BPJS Kesehatan</td>
						<td width=\"5%\"></td>
					</tr>
					<tr>
						<td width=\"5%\"></td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"5%\"></td>
					</tr>
				</table>
			";
		$file_name="sep_".$fields['No. Register'].".pdf";
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		// $obj_pdf->SetFooterMargin('5');
		$obj_pdf->SetMargins('5', '2', '5');//left top right
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
		$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'/download/irj/sjp/'.$file_name, 'FI');				
		
	}	
	public function pasien_bpjs($no_register='')
	{
		$data['title'] = 'Daftar Pasien Rawat Jalan';
		$data['message'] = $this->session->flashdata('message');

		if($no_register==''){
			$data['daftar_pasien']=$this->rjmregistrasi->get_daftar_pasien()->result();
			$this->load->view('irj/rjvformdaftarbpjs',$data);
		}else{
			$data['detail_pasien']=$this->rjmregistrasi->get_detail_daful($no_register)->result();
			$data['prop']=$this->rjmpencarian->get_prop()->result();
			$data['cara_berkunjung']=$this->rjmpencarian->get_cara_berkunjung()->result();
			$data['ppk']=$this->rjmpencarian->get_ppk()->result();
			$data['kelas']=$this->rjmpencarian->get_kelas()->result();
			$data['poli']=$this->rjmpencarian->get_poliklinik()->result();
			$data['cara_bayar']=$this->rjmpencarian->get_cara_bayar()->result();

			$data['dokter']=$this->rjmpencarian->get_dokter()->result();
			$data['kontraktor']=$this->rjmpencarian->get_kontraktor()->result();
			$data['diagnosa']=$this->rjmpencarian->get_diagnosa()->result();

			$this->load->view('irj/rjvformdaful',$data);
		}
			
	}
	public function insert_pasien_bpjs()
	{			
			//get umur
			$no_medrec=$this->input->post('no_medrec');
			$no_register=$this->input->post('no_register');
			$get_umur=$this->rjmregistrasi->get_umur($no_medrec)->result();
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

			$data['umurrj']=$tahun;
			$data['uharirj']=$hari;
			$data['ublnrj']=$bulan;
			$data['tgl_kunjungan']=$this->input->post('tgl_kunj')." ".date('H:i:s');
			
			$data['jns_kunj']=$this->input->post('jns_kunj');
			$data['cara_kunj']=$this->input->post('cara_kunj');

			if($this->input->post('asal_rujukan')!=''){
				$data['asal_rujukan']=$this->input->post('asal_rujukan');
			}

			if($this->input->post('dll_rujukan')!=''){
				$data['asal_rujukan']=$this->input->post('dll_rujukan');
			}

			if($this->input->post('no_rujukan')!=''){
				$data['no_rujukan']=$this->input->post('no_rujukan');
			}

			$data['tgl_rujukan']=$this->input->post('tgl_rujukan');
			$data['kelas_pasien']=$this->input->post('kelas_pasien');
			$data['cara_bayar']=$this->input->post('cara_bayar');
			if($this->input->post('jenis_kontraktor')!=''){
				$data['id_kontraktor']=$this->input->post('jenis_kontraktor');
			}
			$data['diagnosa']=$this->input->post('id_diagnosa');
			$data['id_poli']=$this->input->post('id_poli');
			$data['id_dokter']=$this->input->post('id_dokter');
			$data['nama_penjamin']=$this->input->post('nama_penjamin');
			$data['hubungan']=$this->input->post('hubungan');
			$data['vtot']=0;
			//$data['no_sep']=$this->input->post('no_sep');
			$data['xuser']=$this->input->post('user_name');


			$id=$this->rjmregistrasi->update_daftar_ulang($no_register,$data);
			
			if ($data['cara_bayar']=="BPJS") {
			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">

									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>

									Daftar ulang pasien berhasil. &nbsp;<a href="'.site_url('irj/rjcregistrasi/buat_SEP/'.$no_register).'" class="btn btn-danger">Cetak SEP</a>
									</h4>
								</div>
							</div>
						</div>';
			} else {
				$success = 	'

						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>

									<h4>
									<i class="icon fa fa-check"></i>
									Daftar ulang pasien berhasil.

									</h4>
								</div>
							</div>
						</div>';
			}
			
			$this->session->set_flashdata('success_msg', $success);
		
			redirect('irj/rjcregistrasi/pasien_bpjs/'.$no_register,'refresh');
			
	}

	public function rekap_tracer(){		
		$data['title'] = 'Daftar Rekap Tracer Pasien Poli';
		$date=$this->input->post('date');
		if ($date!='') { 
			$data['date'] = date('Y-m-d',strtotime($date));
			$data['pasien_tracer']=$this->rjmregistrasi->get_pasien_tracer($date)->result();
		}else{
			$data['pasien_tracer']=$this->rjmregistrasi->get_pasien_tracer(date('Y-m-d'))->result();
		}
		$this->load->view('irj/rjvformrekaptracer',$data);
	}

	
	//CETAK KARCIS/////////////////////////////////////////////////////////////////////////////////////////////////
	public function cetak_tracer($no_register='')
	{
		if($no_register!=''){
			$namars=$this->config->item('namars');
			$alamatrs=$this->config->item('alamat');
			$kota=$this->config->item('kota');
			$nmsingkat=$this->config->item('nmsingkat');
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");

			$data_tracer=$this->rjmregistrasi->getdata_tracer($no_register)->result();			
			foreach($data_tracer as $row){
				if($row->sex=='L'){$sex='Laki-laki';}else{ $sex='Perempuan';}
				$no_medrec=$row->no_medrec;
				$txtperusahaan='';
				if($row->nmkontraktor!=''){
					if($row->cara_bayar=='BPJS'){
						$txtperusahaan=$row->nmkontraktor;
					}
					else $txtperusahaan=$row->cara_bayar." - ".$row->nmkontraktor;
				}else $txtperusahaan='UMUM';
				$konten=
					"<style type=\"text/css\">
					.table-font-size{
							font-size:14px;
					    }
					</style>					
					$namars | $alamatrs
					
					<h1 style=\"font-size:15px;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<u>TRACER</u>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<u>No. Antrian</u>&nbsp; &nbsp;&nbsp;: $row->no_antrian</h1><br/>
					<table class=\"table-font-size\">
						<tr>
							<td width=\"20%\"><h4>No. MR</h4></td>
							<td width=\"5%\"> : </td>
							<td width=\"30%\"><b>$row->no_cm</b></td>
							<td >Pasien</td>
							<td width=\"5%\"> : </td>
							<td rowspan=\"2\" width=\"20%\">$txtperusahaan</td>							
						</tr>
						<tr>
							<td>Tgl Registrasi</td>
							<td> : </td>
							<td><b>".date('d-m-Y',strtotime($row->tgl_kunjungan))." | ".date('H:i:s',strtotime($row->tgl_kunjungan))."</b></td>
							
						</tr>
						<tr>
							<td>No. Registrasi</td>
							<td> : </td>
							<td><b>$row->no_register</b></td>
							
						</tr>
						<tr>
							<td>Pasien</td>
							<td> : </td>
							<td colspan=\"2\"><b>$row->nama</b></td>
						</tr>												
						<tr>
							<td>Unit Tujuan</td>
							<td> : </td>
							<td colspan=\"2\"><b>$row->nm_poli</b></td>
						</tr>
						
						<tr>
							<td>Tgl Lahir</td>
							<td> : </td>
							<td>".date('d-m-Y', strtotime($row->tgl_lahir))."</td>
						</tr>
						<tr>
							<td>Umur</td>
							<td> : </td>
							<td>$row->umurrj Tahun $row->ublnrj Bulan $row->uharirj Hari</td>
						</tr>
						<tr>
							<td>Kelamin</td>
							<td> : </td>
							<td >$sex</td>
						</tr>";

						if($this->rjmregistrasi->getdata_before($no_medrec,$no_register)->num_rows()>0){
							$data_tracer=$this->rjmregistrasi->getdata_before($no_medrec,$no_register)->result();
							foreach($data_tracer as $row1){
								if($row1->ket_pulang!='PULANG' and $row1->ket_pulang!=''){
									$txtpulang='| '.$row1->ket_pulang;
								}else $txtpulang='';

								$konten1="<tr>
									<td>Unit & Kunjungan Lalu</td>
									<td> : </td>
									<td colspan=\"4\">".date('d-m-Y',strtotime($row1->tgl_kunjungan))." | $row1->nm_poli $txtpulang</td>
								</tr>";
								}
						}else $konten1="<tr>
									<td></td>
									<td></td>
									<td></td>
								</tr>";

						$login_data = $this->load->get_var("user_info");
						if($login_data->name=='' || $login_data->name==null){
							$user=$login_data->username;
						}else $user=$login_data->name;

						 $konten=$konten."$konten1		
						<tr>
                                                                        <td></td>
									<td></td>
									<td></td>
								</tr>
					</table><br>
					<hr/>
					<br>
				";
						
						
			
						
			}
//			print_r($konten);
			$konten1=$konten."<br>".$konten."<br>".$konten;
			$file_name="Tracer_$no_register.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				// $obj_pdf->SetFooterMargin('5');
				$obj_pdf->SetMargins('5', '5', '5');//left top right
				$obj_pdf->SetAutoPageBreak(TRUE, '2');
				$obj_pdf->SetFont('helvetica', '', 6);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten1;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'/download/irj/rjtracer/'.$file_name, 'FI');
		}else{
			redirect('irj/rjcregistrasi','refresh');
		}
	}
	
	//CETAK IDENTITAS/////////////////////////////////////////////////////////////////////////////////////////////////
	public function cetak_identitas($no_cm='')
	{
		if($no_cm!=''){
			// $data_rs=$this->rjmkwitansi->getdata_rs('10000')->result();
			// 	foreach($data_rs as $row){
			// 		$namars=$row->namars;
			// 		$kota=$row->kota;
			// 		$alamatrs=$row->alamat;
			// 		$nmsingkat=$row->namasingkat;
			// 	}
			$namars=$this->config->item('namars');
			$alamatrs=$this->config->item('alamat');
			$telprs=$this->config->item('telp');
			$kota=$this->config->item('kota');
			$nmsingkat=$this->config->item('nmsingkat');
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			
				$data_identitas=$this->rjmregistrasi->getdata_identitas($no_cm)->result();			
			$rt='';$rw='';
			foreach($data_identitas as $row){
				if($row->rt!=''){
					$rt='RT '.$row->rt;
				}
				if($row->rw!=''){
					$rw='RW '.$row->rw;
				}
			$interval = date_diff(date_create(), date_create($row->tgl_lahir));

			$konten=
					"<style type=\"text/css\">
					.table-font-size{
						font-size:12px;
					    }
					</style>
					<table class=\"table-font-size\" border=\"0\">
						<tr>
						<td rowspan=\"3\" width=\"18%\" style=\"border-bottom:1px solid black; font-size:13px; \"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"50\" style=\"padding-right:5px;\"></p></td>
						<td rowspan=\"3\" width=\"48%\" style=\"border-bottom:1px solid black; font-size:13px;\"><b>$namars</b> <br/> $alamatrs<br/>$telprs</td>
						<td width=\"20%\"></td>
						<td width=\"10%\"><div style=\" text-align:center; font-size:13px; border:1px solid black;\">RM 01</div></td>
						</tr>
						<tr><td></td><td></td></tr>
						<tr><td colspan=\"2\"><p align=\"right\" style=\"font-size:15px;\"><b>NO. RM : <u>".$row->no_cm."</u></b></p></td></tr>
					</table>					
					<br>
					<p align=\"center\" style=\"font-size:15px\"><u><b>IDENTITAS PASIEN</b></u></p>
			
					<table class=\"table-font-size \" cellpadding=\"3\" cellspacing=\"3\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding: 3px; \">						
						<tr>
							<td width=\"27%\">TANGGAL DAFTAR</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->tgl_daftar!='0000-00-00 00:00:00' ? strtoupper(date('d F Y | H:i',strtotime($row->tgl_daftar))).' WIB' :'')."</td>
						</tr>
						<tr>
							<td width=\"27%\">NAMA LENGKAP</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".strtoupper($row->nama)."</td>
						</tr>
						<tr>
							<td width=\"27%\">JENIS KELAMIN</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->sex=='L'? 'LAKI-LAKI':($row->sex=='P'? 'PEREMPUAN':'LAKI-LAKI / PEREMPUAN'))."</td>
						</tr>
						<tr>
							<td width=\"27%\">TEMPAT/TGL. LAHIR</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".strtoupper($row->tmpt_lahir)." /".date('d-m-Y', strtotime($row->tgl_lahir))."</td>
						</tr>
						<tr>
							<td width=\"27%\">USIA</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".$interval->format("%Y Tahun, %M Bulan, %d Hari")."</td>
						</tr>
									
									
								
						<tr>
							<td width=\"27%\">ALAMAT RUMAH/NO. TELP</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->alamat=='' ? '...........................................................................................................................................................................................................................................................................................................................................................' :$row->alamat.' '.$rt.' '.$rw.' '.$row->provinsi.' '.$row->kotakabupaten.' '.$row->kecamatan.' '.$row->kelurahandesa)." / ".($row->no_hp=='' ? '....................................' :$row->no_hp)."</td>
						</tr>
						<tr>
							<td width=\"27%\">PEKERJAAN</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->pekerjaan=='' ? ($row->angkatan_name!='' ? $row->angkatan_name : '................................................................................................') :$row->pekerjaan)."</td>
						</tr>
						<tr>
							<td width=\"27%\">ALAMAT KANTOR/NO. TELP</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">........................................................................................................................................................................................................................../".($row->no_telp_kantor=='' ? '.....................................................................' :$row->no_telp_kantor)."</td>
						</tr>
						<tr>
							<td width=\"27%\">AGAMA</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->agama=='' ? 'ISLAM / PROTESTAN / KATHOLIK / HINDU / BUDHA / KONGHUCU / Lain-Lain .......................' :strtoupper($row->agama))."</td>
						</tr>
						<tr>
							<td width=\"27%\">PENDIDIKAN</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->pendidikan=='' ? 'SD / SMP / SMA / D1 / D2 / D3 / D4 / S1 / S2 / S3 / Lain-Lain .......................' :strtoupper($row->pendidikan))."</td>
						</tr>
						<tr>
							<td width=\"27%\">STATUS PERKAWINAN</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".(($row->status!='' && $row->status!=null) ? ($row->status=='K'? 'KAWIN':'BELUM KAWIN') :'KAWIN / BELUM KAWIN')."</td>
						</tr>						
						<tr>
							<td width=\"27%\">No Kartu BPJS</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->no_kartu=='' ? '-': $row->no_kartu)."</td>
						</tr>						
						<tr>
							<td width=\"27%\"></td>
							<td width=\"5%\"></td>
							<td width=\"68%\"></td>
						</tr>												
					</table>
			";
			
			/*
						<tr>
							<td>Biaya Karcis</td>
							<td> : </td>
							<td><b><font size=\"10\">Rp ".number_format( $row->biayadaftar, 2 , ',' , '.' )."</font></b></td>
						</tr>
			*/
						
			}
			$file_name="Identitas_$no_cm.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->setPrintHeader(false);
				$obj_pdf->setPrintFooter(false);
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				// $obj_pdf->SetFooterMargin('5');
				$obj_pdf->SetMargins('15', '20', '15');//left top right
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 10);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
					$obj_pdf->Output(FCPATH.'/download/irj/rjidentitas/'.$file_name, 'FI');				
				
		}else{
			redirect('irj/rjcregistrasi','refresh');
		}
	}
	
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SEP
	public function buat_SEP($no_register) {

		//$timezone = date_default_timezone_get();
		date_default_timezone_set('Asia/Jakarta');
        $timestamp = time();  //cari timestamp
		//echo $timestamp."asa";
        
		$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
        $encoded_signature = base64_encode($signature);
		//echo $encoded_signature."asa";
        
		$http_header = array(
               'Accept: application/json', 
               'Content-type: application/x-www-form-urlencoded',
               'X-cons-id: 1000', //id rumah sakit
               'X-timestamp: ' . $timestamp,
               'X-signature: ' . $encoded_signature
        );
		 
		$data['data_pasien_daftar_ulang']=$this->rjmpelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$logged_in_user_info=$this->M_user->get_logged_in_user_info();
		
         // nama variabel sesuai dengan nama di xml
         $noKartu = $data['data_pasien_daftar_ulang']->no_kartu;
		 $tglSep = date('Y-m-d H:i:s');
         $tglRujukan = $data['data_pasien_daftar_ulang']->tgl_rujukan;
         $noRujukan = $data['data_pasien_daftar_ulang']->no_rujukan;
         $ppkRujukan = $data['data_pasien_daftar_ulang']->asal_rujukan;
		 $ppkPelayanan = '10000'; //id rs
         $jnsPelayanan = '2'; //1->RJ 2->RD 3-> RI
		 $catatan = 'Coba SEP Bridging';
         $diagAwal = $data['data_pasien_daftar_ulang']->diagnosa;
         $poliTujuan = $data['data_pasien_daftar_ulang']->id_poli;
		 $klsRawat = $data['data_pasien_daftar_ulang']->kelas_pasien;
		 $lakaLantas = '2';
         $user = $logged_in_user_info->username;
         $noMr = $data['data_pasien_daftar_ulang']->no_medrec;
         
		 $data = '<request>
					<data>
					<t_sep>
					<noKartu>0001662503141</noKartu>
 <tglSep>2016-04-19 00:00:00</tglSep>
 <tglRujukan>2016-04-13 00:00:00</tglRujukan>
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
				</request>';
				/*
				
					<poliTujuan>'.$poliTujuan.'</poliTujuan>
					
					 
					 
<noKartu>0001662503141</noKartu>
 <tglSep>2016-04-19 00:00:00</tglSep>
 <tglRujukan>2016-04-13 00:00:00</tglRujukan>
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
 
 <noKartu>'.$noKartu.'</noKartu>
					<tglSep>'.$tglSep.'</tglSep>
					<tglRujukan>'.$tglRujukan.'</tglRujukan>
					<noRujukan>'.$noRujukan.'</noRujukan>
					<ppkRujukan>'.$ppkRujukan.'</ppkRujukan>
					<ppkPelayanan>'.$ppkPelayanan.'</ppkPelayanan>
					<jnsPelayanan>'.$jnsPelayanan.'</jnsPelayanan>
					<catatan>'.$catatan.'</catatan>
					<diagAwal>'.$diagAwal.'</diagAwal>
					<poliTujuan>MAT</poliTujuan>
					<klsRawat>'.$klsRawat.'</klsRawat>
					<lakaLantas>'.$lakaLantas.'</lakaLantas>
					<user>'.$user.'</user>
					<noMr>'.$noMr.'</noMr>
					 
 */
		//echo("<br>".$data);
		//break;
         //$ch = curl_init('http://api.asterix.co.id/SepWebRest/sep/create/');
		 $ch = curl_init('http://dvlp.bpjs-kesehatan.go.id:8081/devWSLokalRest/SEP/sep');
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $result = curl_exec($ch);
         curl_close($ch);
		// echo $result; 
         $sep = json_decode($result)->response;
         //echo $sep."sad";
		 return("0301R00104160000010");
		
		// foreach ($sep as $key => $value){
				// echo "$key: $value\n";
				// echo "$key: $value->nama\n";
				// echo "$key: $value->nik\n";
			// };
			
			// foreach($sep->data as $mydata){
				// echo $mydata->nama . "\n";
					// foreach($mydata->values as $values){
						// echo $values->value . "\n";
					// }
			// }
      	}
	
	public function cetak_sep($no_register) {
		
		//require(getenv('DOCUMENT_ROOT') . '/RS-BPJS/assets/Surat.php');
		require_once(APPPATH.'controllers/irj/SEP.php');

		$sep = new SEP();
		//$this->load->model('r_jalan');
		$entri_rj = $this->rjmregistrasi->get_entri($no_register);
		
		if (!$entri_rj) {
			return;
		}
		
		//$this->load->model('pasien_irj');
		$pasien = $this->rjmregistrasi->get_data_pasien_by_no_cm_baru($entri_rj->no_medrec)->row();
		if (!$pasien) {
			return;
		} 
		//$this->load->model('ppk');
		$ppk = $this->rjmregistrasi->get_ppk($entri_rj->asal_rujukan);
		if ($ppk) {
			$ppk = $ppk->nm_ppk;
		}
		else {
			$ppk = $entri_rj->asal_rujukan;
		}
		
		$result = $this->rjmregistrasi->get_diagnosa($entri_rj->diagnosa);
		if($result!=''){
		$diagnosa=$result->id_icd." - ".$result->nm_diagnosa;
		}else $diagnosa='';
		// $data_rs=$this->rjmkwitansi->getdata_rs('10000')->result();
		// foreach($data_rs as $row){
		// 	$namars=$row->namars;
		// 	$kota_kab=$row->kota;
		// }
			$namars=$this->config->item('namars');
			$alamatrs=$this->config->item('alamat');
			$kota_kab=$this->config->item('kota');
			$nmsingkat=$this->config->item('nmsingkat');
		
		$fields = array(
				'No. Register' => $entri_rj->no_register,
				'No. SEP' => $entri_rj->no_sep,
				'Tgl. SEP' => date('d/m/Y'),
				'No. Kartu' => $pasien->no_kartu,
				'Peserta' => $pasien->pesertaBPJS,
				'Nama Peserta' => $pasien->nama,
				'Tgl. Lahir' => date("d-m-Y", strtotime($pasien->tgl_lahir)),
				'Jenis Kelamin' => $pasien->sex,
				'Asal Faskes' => $ppk,
				'Poli Tujuan' => $entri_rj->nm_poli,
				'Kelas Rawat' => $entri_rj->kelas_pasien,
				'Jenis Rawat' => 'Rawat Jalan',
				'Diagnosa Awal' => $diagnosa,
				//'Catatan' => $entri_rj->CATATAN
				'Catatan' => '',
				'Nama RS' => $namars
			); 
		$sep->set_nilai($fields);
		$sep->cetak();
	}	
	
	public function cetak_kartu_pasien()
	{
		// $this->load->library('PrintZebra');  
		// $hostPrinter = "\\PENDAFTARAN\Zebra P330i Card Printer USB (Copy 1)";
		// $speedPrinter = 4;
		// $darknessPrint = 2;
		// $labelSize = array(300,10);
		// $referencePoint = array(223,15);

		// $z = new ZebraPrinter($hostPrinter, $speedPrinter, $darknessPrint, $labelSize, $referencePoint);
		// $z->setBarcode(1, 344, 80, "ContentBarCode"); #1 -> cod128
		// $z->writeLabel("TestLabel",344,30,4);
		// $z->setBarcode(1, 344, 230, "ContentBarCode"); #1 -> cod128
		// $z->writeLabel("TestLabel",344,180,4);
		// $z->setLabelCopies(1);
		// $z->print2zebra();
		// echo $no_cm;
		$no_cm = $this->input->post('cetak_kartu');
		$no_medrec = $this->input->post('no_medrec');
		echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/st_cetak_kartu_pasien/$no_cm").'", "_blank");window.focus()</script>';
		// echo '<img src="'.base_url().'irj/rjcregistrasi/bikin_barcode/'.$no_cm.'" height="120px">';
		redirect('irj/rjcregistrasi/daftarulang/'.$no_medrec,'refresh');
		//echo $no_cm;
	}

	//NEW
	///////////////////////////////////////////////////////////////////////////////////////////
	public function st_cetak_kartu_pasien($no_cm)
	{
		if($no_cm!=''){

			$data_pasien=$this->rjmregistrasi->getdata_pasien($no_cm)->result();

			tcpdf();
			$obj_pdf = new TCPDF('P', 'mm', array('54','86'), true, 'UTF-8', false);
			// TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
			// TCPDF('L', 'mm', array('54','86'), true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "";
			$obj_pdf->SetTitle($title);
			$obj_pdf->SetHeaderData('', '', $title, '');
			// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->setPrintHeader(false);
			$obj_pdf->setPrintFooter(false);
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			// $obj_pdf->SetFooterMargin('5');
			$obj_pdf->SetMargins('3', '3', '3', '1');//left top right
			$obj_pdf->SetAutoPageBreak(TRUE, '10');
			$obj_pdf->SetFont('helvetica', '', 10);
			$obj_pdf->setFontSubsetting(false);
			$obj_pdf->AddPage();
			// $obj_pdf->rotate(-90, 25, 25);
			// 
			// --- Rotation --------------------------------------------
			// $obj_pdf->SetDrawColor(200);
			// $obj_pdf->Rect(1, 1, 84, 52, 'D');
			$obj_pdf->SetDrawColor(0);
			$obj_pdf->SetTextColor(0);
			// Start Transformation
			$obj_pdf->StartTransform();
			// Rotate 20 degrees counter-clockwise centered by (70,110) which is the lower left corner of the rectangle
			$obj_pdf->Rotate(-90, 1, 1);
			$obj_pdf->Translate(0, -52);
			//$obj_pdf->Rect(1, 1, 84, 52, 'D');


			/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

			IMPORTANT:
			If you are printing user-generated content, tcpdf tag can be unsafe.
			You can disable this tag by setting to false the K_TCPDF_CALLS_IN_HTML
			constant on TCPDF configuration file.

			For security reasons, the parameters for the 'params' attribute of TCPDF
			tag must be prepared as an array and encoded with the
			serializeTCPDFtagParameters() method (see the example below).

			 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */




			// $params = $obj_pdf->serializeTCPDFtagParameters(array('www.google.com', 'QRCODE,H', '', '', 80, 30, 0.4, array('position'=>'S', 'border'=>false, 'padding'=>4, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>1), 'N'));

			// new style
			$style = array(
				'border' => false,
				'padding' => 0,
				'fgcolor' => array(128,0,0),
				'bgcolor' => false,
			);

			$params = $obj_pdf->serializeTCPDFtagParameters(array($no_cm, 'QRCODE,H', 71.5, '', 100, 30, $style, 'N'));


			foreach($data_pasien as $row){
				$tgl_lahir = date('d-m-Y', strtotime($row->tgl_lahir));

				if(empty($row->no_nrp)){
					$nrp = '';
				}else{
					$nrp = 'NRP : '.$row->no_nrp;
				}
				if($row->sex=='L'){
					$sex='LAKI-LAKI';
				}else{
					$sex='PEREMPUAN';
				}

				if(strlen($row->nama)>25){
					$nama = substr($row->nama, 0, 23).'..';
				}else{
					$nama = $row->nama;
				}

				//$barcode = $this->set_barcode($no_cm);

				$barcode = '<img src="'.base_url().'irj/rjcregistrasi/set_barcode/'.$no_cm.'">';
				

				$html=
				"
					<br/>
					<br/>
					<br/>
					<br/>
					<table border=\"0\">
						<tr>
							<td width=\"70%\"></td>
							<td width=\"30%\">
							</td>
						</tr>

						<tr>
							<td width=\"70%\">$nrp</td>
							<td width=\"30%\" rowspan=\"3\">
								<tcpdf method=\"write2DBarcode\" params=\"$params\" />
							</td>
						</tr>
						<tr>
							<td>$row->nama ( $row->sex )</td>
						</tr>
						<tr>
							<td>$tgl_lahir</td>
						</tr>
						<tr>
							<td></td>
							<td align=\"right\">$no_cm</td>
						</tr>
					</table>
				";
			}
			// $html = $konten.'<tcpdf method="write2DBarcode" params="'.$params.'" />';


			// output the HTML content
			// $obj_pdf->writeHTML($html, true, 0, true, 0);

			// set style for barcode
			$style = array(
			    'fgcolor' => array(0,0,0),
			    'bgcolor' => false
			);
			$obj_pdf->write2DBarcode($no_cm, 'QRCODE,H', 3, 22, 15, 15, $style, 'N');
			$obj_pdf->Text(3, 44, $no_cm);

			$obj_pdf->Text(21, 22, $nrp);
			$obj_pdf->Text(21, 27, $nama.' ('.$row->sex.')');
			$obj_pdf->Text(21, 32, $tgl_lahir);


			// Stop Transformation
			$obj_pdf->StopTransform();
			

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			// reset pointer to the last page
			$obj_pdf->lastPage();

			// ---------------------------------------------------------

			//Close and output PDF document
			$obj_pdf->Output('kartu_nama.pdf', 'I');
		}else{
			redirect('irj/rjcregistrasi','refresh');
		}
	}


	///////////////////////////////////////////////////////////////////////////////////////////

	public function st_cetak_kartu_pasien_MUFTIOLD($no_cm)
	{
		if($no_cm!=''){

			$data_pasien=$this->rjmregistrasi->getdata_pasien($no_cm)->result();

			tcpdf();
			$obj_pdf = new TCPDF('L', 'mm', array('54','86'), true, 'UTF-8', false);
			// TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
			// TCPDF('L', 'mm', array('54','86'), true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "";
			$obj_pdf->SetTitle($title);
			$obj_pdf->SetHeaderData('', '', $title, '');
			// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->setPrintHeader(false);
			$obj_pdf->setPrintFooter(false);
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			// $obj_pdf->SetFooterMargin('5');
			$obj_pdf->SetMargins('3', '3', '3', '1');//left top right
			$obj_pdf->SetAutoPageBreak(TRUE, '10');
			$obj_pdf->SetFont('helvetica', '', 10);
			$obj_pdf->setFontSubsetting(false);
			$obj_pdf->AddPage();


			/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

			IMPORTANT:
			If you are printing user-generated content, tcpdf tag can be unsafe.
			You can disable this tag by setting to false the K_TCPDF_CALLS_IN_HTML
			constant on TCPDF configuration file.

			For security reasons, the parameters for the 'params' attribute of TCPDF
			tag must be prepared as an array and encoded with the
			serializeTCPDFtagParameters() method (see the example below).

			 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */




			// $params = $obj_pdf->serializeTCPDFtagParameters(array('www.google.com', 'QRCODE,H', '', '', 80, 30, 0.4, array('position'=>'S', 'border'=>false, 'padding'=>4, 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'text'=>true, 'font'=>'helvetica', 'fontsize'=>8, 'stretchtext'=>1), 'N'));

			// new style
			$style = array(
				'border' => false,
				'padding' => 0,
				'fgcolor' => array(128,0,0),
				'bgcolor' => false,
			);

			$params = $obj_pdf->serializeTCPDFtagParameters(array($no_cm, 'QRCODE,H', 71.5, '', 100, 30, $style, 'N'));


			foreach($data_pasien as $row){
				$tgl_lahir = date('d-m-Y', strtotime($row->tgl_lahir));

				if(empty($row->no_nrp)){
					$nrp = '';
				}else{
					$nrp = 'NRP : '.$row->no_nrp;
				}

				//$barcode = $this->set_barcode($no_cm);

				$barcode = '<img src="'.base_url().'irj/rjcregistrasi/set_barcode/'.$no_cm.'">';
				

				$html=
				"
					<br/>
					<br/>
					<br/>
					<br/>
					<table border=\"0\">
						<tr>
							<td width=\"70%\"></td>
							<td width=\"30%\">
							</td>
						</tr>
						<tr>
							<td width=\"70%\">$nrp</td>
							<td width=\"30%\" rowspan=\"3\">
								<tcpdf method=\"write2DBarcode\" params=\"$params\" />
							</td>
						</tr>
						<tr>
							<td>$row->nama ( $row->sex )</td>
						</tr>
						<tr>
							<td>$tgl_lahir</td>
						</tr>
						<tr>
							<td></td>
							<td align=\"right\">$no_cm</td>
						</tr>
					</table>
				";
			}
			// $html = $konten.'<tcpdf method="write2DBarcode" params="'.$params.'" />';


			// output the HTML content
			$obj_pdf->writeHTML($html, true, 0, true, 0);

			// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

			// reset pointer to the last page
			$obj_pdf->lastPage();

			// ---------------------------------------------------------

			//Close and output PDF document
			$obj_pdf->Output('kartu_nama.pdf', 'I');
		}else{
			redirect('irj/rjcregistrasi','refresh');
		}
	}
	  
	// public function bikin_barcode($code)
	// {
	// 	$this->set_barcode($code);
	// }

 //    private function set_barcode($code)
 //    {
	//     $this->load->library('Zend');
	//     $this->zend->load('Zend/Barcode');
 //        //generate barcode
 //        Zend_Barcode::render('code128', 'image', array('text'=>$code), array());
 //    }


	
	//CETAK IDENTITAS/////////////////////////////////////////////////////////////////////////////////////////////////
	public function sep_tracer()
	{
		$namars=$this->config->item('namars');
		$alamatrs=$this->config->item('alamat');
		$telprs=$this->config->item('telp');
		$kota=$this->config->item('kota');
		$nmsingkat=$this->config->item('nmsingkat');
		
		//set timezone
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		
		// $data_identitas=$this->rjmregistrasi->getdata_identitas($no_cm)->result();			
		
		// foreach($data_identitas as $row){
		$konten="<style type=\"text/css\">
				.table-font-size{
					font-size:12px;
				    }
				.table-font-size2{
					font-size:10px;
					padding : 1px, 2px, 2px;
				    }
				.font-italic{
					font-size:9px;
					font-style:italic;
				    }
				</style>
				<table class=\"table-font-size\" border=\"0\">
					<tr>
						<td width=\"20%\" style=\"border-bottom:1px solid black; font-size:13px;\">
								<img src=\"asset/images/logos/logobpjs.png\" alt=\"img\" height=\"70\" style=\"padding-right:5px;\">
						</td>
						<td width=\"60%\" style=\"border-bottom:1px solid black; font-size:13px;\">
							<p align=\"center\">
								<br>
								<b>Surat Eligibilitas Peserta</b>
								<br>
								<b>$namars</b>
							</p>
						</td>
						<td width=\"20%\" style=\"border-bottom:1px solid black; font-size:13px;\" align=\"right\">
								<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"60\" style=\"padding-right:5px;\">
						</td>
					</tr>
				</table>	
				<br><br>
				<table class=\"table-font-size2\" border=\"0\">
					<tr>
						<td width=\"15%\">No. SEP</td>
						<td width=\"40%\">: 0601R00111160000032</td>
						<td width=\"15%\"></td>
						<td width=\"30%\"></td>
					</tr>		
					<tr>
						<td>Tgl. SEP</td>
						<td>: 2016-11-30</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>No. Kartu</td>
						<td>: 0000026975981 MR: 0000000014</td>
						<td>Peserta</td>
						<td>: PNS PUSAT</td>
					</tr>		
					<tr>
						<td>Nama Peserta</td>
						<td>: NURAINI FITRIYAH</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Tgl. Lahir</td>
						<td>: 1999-08-17</td>
						<td>COB</td>
						<td>: </td>
					</tr>		
					<tr>
						<td>Jenis Kelamin</td>
						<td>: P</td>
						<td>Jenis Rawat</td>
						<td>: Jalan</td>
					</tr>		
					<tr>
						<td>Poli Tujuan</td>
						<td>: Poli Penyakit Mata</td>
						<td>Kelas Rawat</td>
						<td>: Kelas III</td>
					</tr>		
					<tr>
						<td>Asal Faskes</td>
						<td>: dr. HJ. SRI AULIATI</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td>Diagnosa Awal</td>
						<td colspan=\"3\">: Cholera due to Vibrio cholerae 01, biovar eltor</td>
					</tr>		
					<tr>
						<td>Catatan</td>
						<td>: test catatan</td>
						<td></td>
						<td></td>
					</tr>		
					<tr>
						<td colspan=\"4\">
							<font class=\"font-italic\"><br>
*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan.<br>
*SEP bukan sebagai bukti penjaminan peserta
							</font>
						</td>
					</tr>		
					<tr>
						<td>Cetakan Ke 5</td>
						<td>: 06-12-2016 11:25:40</td>
						<td></td>
						<td></td>
					</tr>										
				</table>
				<br><br>
				<table class=\"table-font-size2\" border=\"0\" align=\"center\">
					<tr>
						<td width=\"5%\"></td>
						<td width=\"30%\">Pasien / Keluarga Pasien <br><br></td>
						<td width=\"30%\">Petugas RS</td>
						<td width=\"30%\">Petugas BPJS Kesehatan</td>
						<td width=\"5%\"></td>
					</tr>
					<tr>
						<td width=\"5%\"></td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"30%\">(_____________________)</td>
						<td width=\"5%\"></td>
					</tr>
				</table>
			";
			// $poli="Jalan";
			// if($poli!="Darurat"){
				$data_tracer=$this->rjmregistrasi->getdata_tracer('RJ16000104')->result();			
				foreach($data_tracer as $row){
					if($row->sex=='L'){$sex='Laki-laki';}else{ $sex='Perempuan';}
					$no_medrec=$row->no_medrec;
					if($row->nmkontraktor!=''){
						if($row->cara_bayar=='BPJS'){
							$txtperusahaan=$row->nmkontraktor;
						}
						else $txtperusahaan=$row->cara_bayar." - ".$row->nmkontraktor;
					}else {$txtperusahaan='UMUM';}
					$konten=$konten."<style type=\"text/css\">
						.table-font-size{
							font-size:13px;
						    }
						</style>	<br><br><hr>				
						$namars | $alamatrs
						
						<h3>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<u>TRACER</u></h3><br/>
						<table class=\"table-font-size\">
							<tr>
								<td width=\"20%\"><h4>No. Antrian</h4></td>
								<td width=\"5%\"> : </td>
								<td width=\"30%\"><b>$row->no_antrian</b></td>
								<td>No. MR</td>
								<td width=\"5%\"> : </td>
								<td width=\"20%\"><b>$row->no_cm</b></td>
							</tr>
							<tr>
								<td>Tgl Registrasi</td>
								<td> : </td>
								<td><b>".date('d-m-Y',strtotime($row->tgl_kunjungan))." | ".date('H:i:s',strtotime($row->tgl_kunjungan))."</b></td>
								<td >Pasien</td>
								<td width=\"5%\"> : </td>
								<td rowspan=\"2\" width=\"20%\">$txtperusahaan</td>
							</tr>
							<tr>
								<td>No. Registrasi</td>
								<td> : </td>
								<td><b>$row->no_register</b></td>
							</tr>
							<tr>
								<td>Pasien</td>
								<td> : </td>
								<td colspan=\"2\"><b>$row->nama</b></td>
							</tr>												
							<tr>
								<td>Unit Tujuan</td>
								<td> : </td>
								<td colspan=\"2\"><b>$row->nm_poli</b></td>
							</tr>
							
							<tr>
								<td>Tgl Lahir</td>
								<td> : </td>
								<td>".date('d-m-Y', strtotime($row->tgl_lahir))."</td>
							</tr>
							<tr>
								<td>Umur</td>
								<td> : </td>
								<td>$row->umurrj Tahun $row->ublnrj Bulan $row->uharirj Hari</td>
							</tr>
							<tr>
								<td>Kelamin</td>
								<td> : </td>
								<td >$sex</td>
							</tr>";

							if($this->rjmregistrasi->getdata_before($no_medrec,$no_register)->num_rows()>0){
								$data_tracer=$this->rjmregistrasi->getdata_before($no_medrec,$no_register)->result();
								foreach($data_tracer as $row1){
									if($row1->ket_pulang!='PULANG' and $row1->ket_pulang!=''){
										$txtpulang='| '.$row1->ket_pulang;
									}else $txtpulang='';

									$konten1="<tr>
										<td>Unit & Kunjungan Lalu</td>
										<td> : </td>
										<td colspan=\"2\">".date('d-m-Y',strtotime($row1->tgl_kunjungan))." | $row1->nm_poli $txtpulang</td>
									</tr>";
									}
							}else {$konten1="<tr>
										<td></td>
										<td></td>
										<td></td>
									</tr>";}

							$login_data = $this->load->get_var("user_info");
							if($login_data->name=='' || $login_data->name==null){
								$user=$login_data->username;
							}else {$user=$login_data->name;}

							$konten=$konten."$konten1<tr>
								<td>Petugas</td>
								<td> : </td>
								<td colspan=\"2\">".$user."</td>
							</tr>						
							<tr>
										<td></td>
										<td></td>
										<td></td>
									</tr>
						</table><br>
						<br>
						<style type=\"text/css\">
							.table-diagnosis{
								font-size:9px;
							    }
							</style>
							<table class=\"table-diagnosis\" border=\"1\">
								<tr>
									<td width=\"18%\">Diagnosis</td>
									<td width=\"7%\">ICD10</td>
									<td width=\"4%\">KB</td>
									<td width=\"4%\">KL</td>
									<td width=\"15%\">Tindakan</td>
									<td width=\"10%\">ICD 9 CM</td>
									<td width=\"15%\">INA CBG</td>
									<td width=\"15%\">Nama Dokter</td>
									<td width=\"12%\">Kode Dokter</td>
								</tr>
								<tr>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
									<td><br><br><br><br><br><br></td>
								</tr>
							</table>
					";
				}
			// }
						
			
		
		// }
		$file_name="sep.pdf";
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		tcpdf();
		$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetHeaderData('', '', $title, '');
		// $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		// $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->setPrintHeader(false);
		$obj_pdf->setPrintFooter(false);
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		// $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		// $obj_pdf->SetFooterMargin('5');
		$obj_pdf->SetMargins('5', '2', '5');//left top right
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 10);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
			$content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'/download/irj/sjp/'.$file_name, 'FI');				
		
	}

public function create_sep($no_kartu='',$no_register='')
	{
		$data_bpjs = $this->M_update_sepbpjs->get_data_bpjs();
		$cons_id = $data_bpjs->consid;
		$sec_id = $data_bpjs->secid;
		$ppk_pelayanan = $data_bpjs->rsid;

		$tgl_sep = date('Y-m-d 00:00:00');
        $url = $data_bpjs->service_url;

        $timezone = date_default_timezone_get();
		date_default_timezone_set('Asia/Jakarta');
		$timestamp = time();  //cari timestamp
	//	$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date('Y-m-d 00:00:00');
		$http_header = array(
			   'Accept: application/json',
		//	   'Content-type: application/xml',
			   'Content-type: application/x-www-form-urlencoded',
			   // 'Content-type: application/json',
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
	 	if ($cek_peserta->metadata->message == 'KP : Peserta Tidak Ditemukan') {
		$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, Data Peserta Untuk Nomor '.$no_kartu.' Tidak Ditemukan
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('success_msg', $success);		     
		   	//echo '<script type="text/javascript">window.close();</script>';	
// dihilangkan karena pasien Bpjs   	echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_tracer/$noreg").'", "_blank");window.focus()</script>';
		   	redirect('irj/rjcregistrasi/','refresh');//exit(); 		
	 	} // metadata code		

       $entri_catatan = $this->M_update_sepbpjs->get_catatan_2($no_register);
       $no_medrec =$this->M_update_sepbpjs->get_nocm_pasien($entri_catatan->no_medrec)->row()->no_cm;
       $xuser = $entri_catatan->xuser;
       $id_poli = $entri_catatan->id_poli;
       $alasan_berobat = $entri_catatan->alasan_berobat;
       if ($id_poli == 'BA00' && $alasan_berobat == 'kecelakaan') {
       	$laka_lantas = '1';
       	$lokasi_laka = $entri_catatan->lokasi_kecelakaan;
       }
       else {
       	$laka_lantas = '2';
       	$lokasi_laka = '';
       }
       $poli_bpjs = $this->M_update_sepbpjs->get_poli_bpjs($id_poli);

   //    print_r($poli_bpjs);exit();
                     
		if($datakartu->peserta->provUmum->kdProvider==NULL or $datakartu->peserta->provUmum->kdProvider==''){
			$ppkrujuk='09020100';
		}else
			$ppkrujuk=$datakartu->peserta->provUmum->kdProvider;


		if($entri_catatan->no_rujukan==NULL or $entri_catatan->no_rujukan==''){
			$norujuk='0';
		}else
			$norujuk=$entri_catatan->no_rujukan;

 		 $data = array(
		   	'request'=>array(
		   		't_sep'=>array(
		   			'noKartu' => $no_kartu,
		   			'tglSep' =>  $tgl_sep,
		   			'tglRujukan' => $tgl_sep,
		   			'noRujukan' => $norujuk,//$entri_catatan->NO_RUJUKAN,
		   			'ppkRujukan' => $ppkrujuk,
		   			'ppkPelayanan' => $ppk_pelayanan,
		   			'jnsPelayanan' => '2',
		   			'catatan' => $entri_catatan->catatan,
		   			// 'diagAwal' => $datakartu->item->diagnosa->kdDiag,
		   			'diagAwal' => $entri_catatan->diagnosa,
		   			// 'poliTujuan' => $datakartu->poliRujukan->kdPoli, // INT
		   			'poliTujuan' =>  $poli_bpjs->poli_bpjs, // INT
		   			'klsRawat' => '3',//$datakartu->peserta->provUmum->
		   			'lakaLantas' => $laka_lantas,
		   			'lokasiLaka' => $lokasi_laka,   			
		   			'user' => $xuser,
		   			'noMr' => $no_medrec //'999999999',//$datakartu->item->peserta->noMr
		   			)
		   		)
		   	);		  
    	   $datasep=json_encode($data);
       //	   print_r($datasep);exit();
           $ch = curl_init($url . 'SEP/insert');
             curl_setopt($ch, CURLOPT_POST, true);
             curl_setopt($ch, CURLOPT_POSTFIELDS, $datasep);
             curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              $result = curl_exec($ch);
             curl_close($ch);
             if($result!=''){//valid koneksi internet
	     $sep = json_decode($result);
    //          print_r($result);exit; ///////////////////////////////////////
		    if ($sep->metadata->code == '800') {
			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, '.$sep->metadata->message.'
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('success_msg', $success);		     
		   	//echo '<script type="text/javascript">window.close();</script>';
//		   	echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_tracer/$noreg").'", "_blank");window.focus()</script>';
		   	redirect('irj/rjcregistrasi/','refresh');//exit();
		    }
			else if ($sep->metadata->code == '200') {
				

           // $id= $no_rujukan;
          $data_update = array(
           'NO_SEP' => $sep->response
              );
            $this->M_update_sepbpjs->update_sep_bpjs($no_register,$data_update);
            // print_r($sep->response);
            // exit();
				echo '<script type="text/javascript">window.open("'.site_url("irj/c_sepmanual/cetak_sep/").'/'.$no_register.'", "_blank");window.focus()</script>';

			} else {
				echo $sep->metadata->message;
				exit();
			}
		 } else{
		 	echo "Pastikan Anda Terhubung Internet!!";
		exit();
		 }

		 } // create sep
		
		public function create_sep2($no_kartu='',$no_register='')
	{
		$data_bpjs = $this->M_update_sepbpjs->get_data_bpjs();
		$cons_id = $data_bpjs->consid;
		$sec_id = $data_bpjs->secid;
		$ppk_pelayanan = $data_bpjs->rsid;

		$tgl_sep = date('Y-m-d 00:00:00');
        $url = $data_bpjs->service_url;

        $timezone = date_default_timezone_get();
		date_default_timezone_set('Asia/Jakarta');
		$timestamp = time();  //cari timestamp
	//	$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		$tgl_sep = date('Y-m-d 00:00:00');
		$http_header = array(
			   'Accept: application/json',
		//	   'Content-type: application/xml',
			   'Content-type: application/x-www-form-urlencoded',
			   // 'Content-type: application/json',
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
	 	if ($cek_peserta->metadata->message == 'KP : Peserta Tidak Ditemukan') {
		$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, Data Peserta Untuk Nomor '.$no_kartu.' Tidak Ditemukan
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('success_msg', $success);		     
		   	//echo '<script type="text/javascript">window.close();</script>';	
		   	redirect('irj/rjcregistrasi/','refresh');//exit(); 		
	 	} // metadata code		

       $entri_catatan = $this->M_update_sepbpjs->get_catatan_2($no_register);
       $no_medrec =$this->M_update_sepbpjs->get_nocm_pasien($entri_catatan->no_medrec)->row()->no_cm;
       $xuser = $entri_catatan->xuser;
       $id_poli = $entri_catatan->id_poli;
       $alasan_berobat = $entri_catatan->alasan_berobat;
       if ($id_poli == 'BA00' && $alasan_berobat == 'kecelakaan') {
       	$laka_lantas = '1';
       	$lokasi_laka = $entri_catatan->lokasi_kecelakaan;
       }
       else {
       	$laka_lantas = '2';
       	$lokasi_laka = '';
       }
       $poli_bpjs = $this->M_update_sepbpjs->get_poli_bpjs($id_poli);

           //  print_r($poli_bpjs);exit;
             
		if($datakartu->peserta->provUmum->kdProvider==NULL or $datakartu->peserta->provUmum->kdProvider==''){
			$ppkrujuk='09020100';
		}else
			$ppkrujuk=$datakartu->peserta->provUmum->kdProvider;


		if($entri_catatan->no_rujukan==NULL or $entri_catatan->no_rujukan==''){
			$norujuk='0';
		}else
			$norujuk=$entri_catatan->no_rujukan;

 		 $data = array(
		   	'request'=>array(
		   		't_sep'=>array(
		   			'noKartu' => $no_kartu,
		   			'tglSep' =>  $tgl_sep,
		   			'tglRujukan' => $tgl_sep,
		   			'noRujukan' => $norujuk,//$entri_catatan->NO_RUJUKAN,
		   			'ppkRujukan' => $ppkrujuk,
		   			'ppkPelayanan' => $ppk_pelayanan,
		   			'jnsPelayanan' => '2',
		   			'catatan' => $entri_catatan->catatan,
		   			// 'diagAwal' => $datakartu->item->diagnosa->kdDiag,
		   			'diagAwal' => $entri_catatan->diagnosa,
		   			// 'poliTujuan' => $datakartu->poliRujukan->kdPoli, // INT
		   			'poliTujuan' => $poli_bpjs->poli_bpjs, //id_poli, // INT
		   			'klsRawat' => '3',//$datakartu->peserta->provUmum->
		   			'lakaLantas' => $laka_lantas,
		   			'lokasiLaka' => $lokasi_laka,   			
		   			'user' => $xuser,
		   			'noMr' => $no_medrec //'999999999',//$datakartu->item->peserta->noMr
		   			)
		   		)
		   	);		  
    	   $datasep=json_encode($data);
       	   //print_r($datasep);exit();
           $ch = curl_init($url . 'SEP/insert');
             curl_setopt($ch, CURLOPT_POST, true);
             curl_setopt($ch, CURLOPT_POSTFIELDS, $datasep);
             curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              $result = curl_exec($ch);
             curl_close($ch);
             if($result!=''){//valid koneksi internet
		     $sep = json_decode($result);
         // print_r($sep->response);exit; ///////////////////////////////////////
		    if ($sep->metadata->code == '800') {
			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									Maaf, '.$sep->metadata->message.'
								</div>
							</div>
						</div>';
			$this->session->set_flashdata('success_msg', $success);		
			echo $sep->metadata->message;     
//			print_r($datasep);
		   	//echo '<script type="text/javascript">window.close();</script>';
		   	//redirect('irj/rjcregistrasi/');exit();
		    }
			else if ($sep->metadata->code == '200') {
				

           // $id= $no_rujukan;
          $data_update = array(
           'NO_SEP' => $sep->response
              );
            $this->M_update_sepbpjs->update_sep_bpjs($no_register,$data_update);
            // print_r($sep->response);
            // exit();
				echo '<script type="text/javascript">window.open("'.site_url("irj/c_sepmanual/cetak_sep/").'/'.$no_register.'", "_blank");window.focus()</script>';

			} else {
				echo $sep->metadata->message;
				exit();
			}
		 } else{
		 	echo "Pastikan Anda Terhubung Internet!!";
		exit();
		 }

		 } 
}
?>
