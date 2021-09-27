<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class rjrdcmedrec extends Secure_area {
//class rjcregistrasi extends CI_Controller {
	public function __construct() {
			parent::__construct();
			$this->load->model('irj/rjmpencarian','',TRUE);
			$this->load->model('irj/rjmmedrec','',TRUE);
			$this->load->model('irj/rjmregistrasi','',TRUE);
			$this->load->model('irj/rjmpelayanan','',TRUE);
			$this->load->model('irj/rjmkwitansi','',TRUE);
			$this->load->model('ird/ModelRegistrasi','',TRUE);
			$this->load->model('admin/M_user','',TRUE);
			
			$this->load->helper('pdf_helper');
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////registrasi biodata pasien
	public function index()
	{
		$data['title'] = 'Registrasi Rawat Jalan';
		$data['data_pasien']="";
		$this->load->view('irj/rjvformcaripasien',$data);
	}
	
	public function regpasien()
	{
		$data['title'] = 'Registrasi Rawat Jalan';
		//$data['data_pasien']="";
		$data['kontraktor']=$this->rjmpencarian->get_kontraktor()->result();
		$data['prop']=$this->rjmpencarian->get_prop()->result();
		$data['cm_last']=$this->ModelRegistrasi->get_last_cmpatria()->row()->no_cm;
			
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
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function pasien($cm='')
	{
		$data['title'] = 'Registrasi Rawat Jalan';
		
			
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
		
		if (!($data['data_pasien'])==1) 
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
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////registrasi pasien ke irj
	public function daftarulang($no_cm)
	{
		$data['title'] = 'Daftar Ulang Rawat Jalan';
		$data['biayakarcis']=$this->rjmregistrasi->get_biayakarcis()->row();
			
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
			
			$this->load->view('irj/rjvformdaftar2',$data);		
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
		$data['no_cm']=$this->input->post('cm1').''.$this->input->post('cm2').''.$this->input->post('cm3');
		if ($this->input->post('jenis_identitas')!='') {
			$data['jenis_identitas']=$this->input->post('jenis_identitas');
			$data['no_identitas']=$this->input->post('no_identitas');
		}
		//$data['jenis_kartu']=$this->input->post('jenis_kartu');
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

		$data['nama']=$this->input->post('nama');
		$data['sex']=$this->input->post('sex');
		$data['tmpt_lahir']=$this->input->post('tmpt_lahir');
		$data['tgl_lahir']=$this->input->post('tgl_lahir');
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

		$id=$this->rjmregistrasi->insert_pasien_irj($data);
		
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

	public function patientrecord()
	{
		$data['title'] = 'Kunjungan Pasien RS';
		$no_cm=$this->input->post('no_cm');
		//$data['data_pasien']="";
		if($no_cm!=''){
			$data['pasien']=$this->rjmmedrec->get_patient_record($no_cm)->result();
		}else{
			$data['pasien']='';
		}
			
		$this->load->view('medrec/pasien_kunj',$data);
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
		$data['tgl_lahir']=$this->input->post('tgl_lahir');
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
		$id=$this->rjmregistrasi->update_pasien_irj($data,$no_medrec);
		//print_r($data);
		redirect('irj/rjcregistrasi/daftarulang/'.$no_medrec);
	}

	public function insert_daftar_ulang()
	{
		$no_medrec=$this->input->post('no_medrec');
		
		//cek data poli hari ini
		$cek_data_poli=$this->rjmregistrasi->cek_data_poli($no_medrec)->row();
		
		if (isset($cek_data_poli)) 
		{
			$data_poli = $cek_data_poli->nm_poli;
			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>
									Maaf, Pasien sudah terdaftar pada poli "'.$data_poli.'" untuk hari ini.
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
			/*foreach($no_register as $val){
				$data['no_register']=sprintf("RJ%s%06s",$val->year,$val->counter+1);
			}
			*/

			$data['umurrj']=$tahun;
			$data['uharirj']=$hari;
			$data['ublnrj']=$bulan;

			$data['no_medrec']=$no_medrec;
			$data['jns_kunj']=$this->input->post('jns_kunj');
			$data['cara_kunj']=$this->input->post('cara_kunj');
			$data['asal_rujukan']=$this->input->post('asal_rujukan');

			if($this->input->post('dll_rujukan')!=''){
			$data['asal_rujukan']=$this->input->post('dll_rujukan');
			}

			$data['no_rujukan']=$this->input->post('no_rujukan');
			$data['tgl_rujukan']=$this->input->post('tgl_rujukan');
			$data['kelas_pasien']=$this->input->post('kelas_pasien');
			$data['cara_bayar']=$this->input->post('cara_bayar');
			$data['id_kontraktor']=$this->input->post('id_kontraktor');
			$data['diagnosa']=$this->input->post('id_diagnosa');
			$data['id_poli']=$this->input->post('id_poli');
			$data['id_dokter']=$this->input->post('id_dokter');
			//$data['kd_ruang']=$this->input->post('kd_ruang');
			//$data['biayadaftar']=$this->input->post('biayadaftar');
			$data['biayadaftar']=0;
			$data['nama_penjamin']=$this->input->post('nama_penjamin');
			$data['hubungan']=$this->input->post('hubungan');
			$data['vtot']=0;
			//$data['no_sep']=$this->input->post('no_sep');
			$data['xuser']=$this->input->post('user_name');
			if ($this->input->post('statusBpjs')!='') {
				$data['status_bpjs']=$this->input->post('statusBpjs');
			}

			$id=$this->rjmregistrasi->insert_daftar_ulang($data);
			
			if ($data['cara_bayar']=="BPJS") {
			$success = 	'
						<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-success alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>
									Daftar ulang pasien berhasil. &nbsp;<a href="'.site_url('irj/rjcregistrasi/buat_SEP/'.$id->no_register).'" class="btn btn-danger">Cetak SEP</a>
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
			
			
			//cetak_karcis
			//echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_karcis/$id->no_register").'", "_blank");window.focus()</script>';
			//cetak identitas
			$id1=$this->ModelRegistrasi->cek_kunj_ird($no_medrec)->row();
			$id2=$this->rjmregistrasi->cek_kunj_irj($no_medrec)->row();
			
			if($id1->cek+$id2->cek=='1'){
			echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_identitas/$id->no_register").'", "_blank");window.focus()</script>';
			}
			//cetak sep
			if ($data['cara_bayar']=="BPJS") {
				//$data2['no_sep']=$this->buat_SEP($id->no_register);
				//echo $data2['no_sep'];
				//$result = $this->rjmregistrasi->update_SEP($no_register, $data2);
				
				//echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_sep/$id->no_register").'", "_blank");window.focus()</script>';
			}
		}
		
		/*if ($data['cara_bayar']=="BPJS") {
			redirect('irj/rjcregistrasi/daftarulang/'.$no_medrec,'refresh');
		} else {
			redirect('irj/rjcregistrasi/','refresh');
		}
		*/
		
		redirect('irj/rjcregistrasi/','refresh');
	}
	public function list_pasien()
	{
		$tipe_cari=$this->input->post('search_per');
		$tgl1=$this->input->post('date0');
		$tgl2=$this->input->post('date1');
		$data['title'] = 'Daftar Pasien RS';
		$data['message'] = $this->session->flashdata('message');

		if($tgl1=='' && $tgl2==''){
			$tgl1 = date('Y-m-d');
			$date1 = str_replace('-', '/', $tgl1);
			$tgl1 = date('Y-m-d',strtotime($date1 . "-7 days"));
			$tgl2 = date('Y-m-d');
		}
		$data['tgl1'] = $tgl1;
		$data['tgl2'] = $tgl2;
		if($tipe_cari=='1'){
			$data['daftar_pasien']=$this->rjmregistrasi->get_daftar_pasien_1($tgl1,$tgl2)->result();
			$data['search_per']='1';
			$this->load->view('medrec/daftar_pasien',$data);
		}else if($tipe_cari=='2'){
			$data['daftar_pasien']=$this->rjmregistrasi->get_daftar_pasien_2($tgl1,$tgl2)->result();
			$data['search_per']='2';
			$this->load->view('medrec/daftar_pasien',$data);
		}else{
			$data['daftar_pasien']=$this->rjmregistrasi->get_daftar_pasien_all($tgl1,$tgl2)->result();
			$data['search_per']='3';
			$this->load->view('medrec/daftar_pasien',$data);
		}
			
	}

	public function daful_pasien($no_register='')
	{
		$data['title'] = 'Detail Daftar Pasien';
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

			$this->load->view('medrec/form_daful_pasien',$data);

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
			$data['id_kontraktor']=$this->input->post('id_kontraktor');
			$data['diagnosa']=$this->input->post('id_diagnosa');
			$data['id_poli']=$this->input->post('id_poli');
			$data['id_dokter']=$this->input->post('id_dokter');
			$data['nama_penjamin']=$this->input->post('nama_penjamin');
			$data['hubungan']=$this->input->post('hubungan');
			$data['vtot']=0;
			//$data['no_sep']=$this->input->post('no_sep');
			$data['xuser']=$this->input->post('user_name');

			if ($this->input->post('statusBpjs')!='') {
				$data['status_bpjs']=$this->input->post('statusBpjs');
			}

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
	public function kontrol_pasien(){
		$data['title'] = 'Daftar Pasien Kontrol Rawat Jalan';

		$data['kontrol_pasien']=$this->rjmregistrasi->get_pasien_kontrol($no_register)->result();

	}
	//CETAK KARCIS/////////////////////////////////////////////////////////////////////////////////////////////////
	public function cetak_karcis($no_register='')
	{
		if($no_register!=''){
			/*$get_nokarcis=$this->rjmkwitansi->get_new_nokarcis($no_register)->result();
				foreach($get_nokarcis as $val){
					$noseri_karcis=sprintf("B%s%05s",$val->year,$val->counter+1);
				}
			$this->rjmkwitansi->update_nokarcis($noseri_karcis,$no_register);
			*/
			$data_rs=$this->rjmkwitansi->getdata_rs('10000')->result();
				foreach($data_rs as $row){
					$namars=$row->namars;
					$kota=$row->kota;
					$alamatrs=$row->alamat;
					$nmsingkat=$row->namasingkat;
				}
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			
			$data_karcis=$this->rjmregistrasi->getdata_karcis($no_register)->result();
			foreach($data_karcis as $row){
			$konten=
					"<br/><br/>
					$namars<br/>
					$alamatrs<br/><br/>
					
					Administrasi Berobat Ins. Rawat Jalan<br/><br/>
					<table>
						<!--<tr>
							<td width=\"30%\">No. Seri Karcis</td>
							<td width=\"5%\"> : </td>
							<td width=\"65%\"><b>$no_register</b></td>
						</tr>
						-->
						<tr>
							<td width=\"30%\">Pasien</td>
							<td width=\"5%\"> : </td>
							<td width=\"65%\">Umum</td>
						</tr>
						<tr>
							<td>No. CM</td>
							<td> : </td>
							<td><b>$row->no_medrec</b></td>
						</tr>
						<tr>
							<td>No. Registrasi</td>
							<td> : </td>
							<td><b>$row->no_register</b></td>
						</tr>
						<tr>
							<td>Nama</td>
							<td> : </td>
							<td><b>$row->nama</b></td>
						</tr>
						<tr>
							<td>Poli Tujuan</td>
							<td> : </td>
							<td>$row->nm_poli <b>($row->id_poli)</b></td>
						</tr>
						<tr>
							<td>Dokter</td>
							<td> : </td>
							<td>$row->nm_dokter <b>($row->id_dokter)</b></td>
						</tr>
						<tr>
							<td>Tgl Cetak Karcis</td>
							<td> : </td>
							<td>$tgl_jam</td>
						</tr>
						<tr>
							<td>Petugas</td>
							<td> : </td>
							<td>$nmsingkat</td>
						</tr>
						
					</table></br>
					<hr/>
			";
			
			/*
						<tr>
							<td>Biaya Karcis</td>
							<td> : </td>
							<td><b><font size=\"10\">Rp ".number_format( $row->biayadaftar, 2 , ',' , '.' )."</font></b></td>
						</tr>
			*/
						
			}
			$file_name="Karcis_$no_register.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('L', PDF_UNIT, 'A7', true, 'UTF-8', false);
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
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 7);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'/download/irj/rjkarcis/'.$file_name, 'FI');
		}else{
			redirect('irj/rjcregistrasi','refresh');
		}
	}
	
	//CETAK IDENTITAS/////////////////////////////////////////////////////////////////////////////////////////////////
	public function cetak_identitas($no_register='')
	{
		if($no_register!=''){
			$data_rs=$this->rjmkwitansi->getdata_rs('10000')->result();
				foreach($data_rs as $row){
					$namars=$row->namars;
					$kota=$row->kota;
					$alamatrs=$row->alamat;
					$nmsingkat=$row->namasingkat;
				}
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");

			$getrdrj=substr($no_register, 0,2);
			if($getrdrj=="RJ"){
				$data_identitas=$this->rjmregistrasi->getdata_identitas($no_register)->result();
			} else if($getrdrj=="RD"){
				$data_identitas=$this->ModelRegistrasi->getdata_identitas($no_register)->result();
			}else{}
			
			foreach($data_identitas as $row){
			$konten=
					"<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					</style>
					<table class=\"table-font-size\" border=\"0\">
						<tr>
						<td rowspan=\"3\" width=\"16%\" style=\"border-bottom:1px solid black; font-size:8px; \"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"30\" style=\"padding-right:5px;\"></p></td>
						<td rowspan=\"3\" width=\"45%\" style=\"border-bottom:1px solid black; font-size:8px;\"><b>$namars</b> <br/> $alamatrs</td>
						<td width=\"29%\"></td>
						<td width=\"10%\"><div style=\" text-align:center; font-size:8px; border: 1px solid black;\">RM 01</div></td>
						</tr>
						<tr><td></td><td></td></tr>
						<tr><td colspan=\"2\"><p align=\"right\" style=\"font-size:10px;\"><b>NO. RM : <u>".$row->no_cm."</u></b></p></td></tr>
					</table>					
					<p align=\"center\" style=\"font-size:10px\"><u><b>IDENTITAS PASIEN</b></u></p>
			
					<table class=\"table-font-size\" style=\"border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding: 3px; \">
						<tr>
							<td colspan=\"3\"><u><b>PASIEN</b></u></td>
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
							<td width=\"68%\">$row->tmpt_lahir/".date('d-m-Y', strtotime($row->tgl_lahir))."</td>
						</tr>
						<tr>
							<td width=\"27%\">ALAMAT RUMAH/NO. TELP</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->alamat=='' ? '...........................................................................................................................................................................................................................................................................................................................................................' :$row->alamat)." / ".($row->no_telp=='' ? '....................................' :$row->no_telp)."</td>
						</tr>
						<tr>
							<td width=\"27%\">PEKERJAAN</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->pekerjaan=='' ? '................................................................................................' :$row->pekerjaan)."</td>
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
							<td width=\"68%\">".($row->sex=='B'? 'BELUM KAWIN':($row->sex=='K'? 'KAWIN':'KAWIN / BELUM KAWIN / DUDA / JANDA'))."</td>
						</tr>
						<tr>
							<td width=\"27%\">STATUS PASIEN</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->cara_bayar=='' ? 'BPJS / DIJAMIN / JAMSOSKES / UMUM / Lain-Lain .......................' :$row->cara_bayar)."</td>
						</tr>
						
						<tr>
							<td colspan=\"3\"><U><b>PENANGGUNG JAWAB</b></U></td>
						</tr>
						<tr>
							<td width=\"27%\">NAMA LENGKAP</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->nama_penjamin=='' ? '.................................................................................................................................' :strtoupper($row->nama_penjamin))."</td>
						</tr>
						<tr>
							<td width=\"27%\">HUBUNGAN</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">".($row->hubungan=='' ? 'YBS. / SUAMI / ISTRI / ANAK / Lain-Lain ......................................' :strtoupper($row->hubungan))."</td>
						</tr>
						<tr>
							<td width=\"27%\">JENIS KELAMIN</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">LAKI-LAKI / PEREMPUAN</td>
						</tr>
						<tr>
							<td width=\"27%\">TEMPAT/TGL. LAHIR</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">................................/...............................................................</td>
						</tr>
						<tr>
							<td width=\"27%\">ALAMAT RUMAH/NO. TELP</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">....................................................................................................................../.........................................................................</td>
						</tr>
						<tr>
							<td width=\"27%\">PEKERJAAN</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">................................................................................................</td>
						</tr>
						<tr>
							<td width=\"27%\">ALAMAT KANTOR/NO. TELP</td>
							<td width=\"5%\">:</td>
							<td width=\"68%\">....................................................................................................................../.........................................................................</td>
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
			$file_name="Identitas_$no_register.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A5', true, 'UTF-8', false);
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
				$obj_pdf->SetMargins('10', '7', '10');//left top right
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 10);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				if($getrdrj=="RJ"){
					$obj_pdf->Output(FCPATH.'/download/irj/rjidentitas/'.$file_name, 'FI');
				} else if($getrdrj=="RD"){
					$obj_pdf->Output(FCPATH.'/download/ird/rdidentitas/'.$file_name, 'FI');
				}else{}
				
		}else{
			redirect('irj/rjcregistrasi','refresh');
		}
	}
	
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SEP
	public function buat_SEP($no_register) {

		//$timezone = date_default_timezone_get();
		date_default_timezone_set('Asia/Jakarta');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00')); //cari timestamp
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
		$data_rs=$this->rjmkwitansi->getdata_rs('10000')->result();
		foreach($data_rs as $row){
			$namars=$row->namars;
			$kota_kab=$row->kota;
		}
		
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
		
}
?>
