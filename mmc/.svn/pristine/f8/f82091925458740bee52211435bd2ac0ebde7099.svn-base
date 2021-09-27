<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
class IrDRegistrasi extends Secure_area {
	public function __construct() {
			parent::__construct();
			$this->load->model('ird/ModelAlamat','',TRUE);
			$this->load->model('ird/ModelRegistrasi','',TRUE);
			$this->load->model('ird/ModelPelayanan','',TRUE);
			$this->load->model('ird/ModelKwitansi','',TRUE);
			$this->load->model('irj/rjmpencarian','',TRUE);
			$this->load->model('irj/rjmpelayanan','',TRUE);
			$this->load->model('irj/rjmregistrasi','',TRUE);
			$this->load->model('irj/rjmkwitansi','',TRUE);
//$data['jenis_kontraktor']=$this->rjmpencarian->get_kontraktor()->result();
			$this->load->helper('pdf_helper');
		
		}
	public function index()
	{
		
		
		/*$data['prop']=$this->ModelAlamat->get_prop()->result();
		// $data['poliklinik']=$this->ModelRegistrasi->get_poli()->result();//untuk nav
		$data['cara_berkunjung']=$this->ModelRegistrasi->get_cara_berkunjung()->result();
		$data['cara_bayar']=$this->ModelRegistrasi->get_cara_bayar()->result();
		$data['jenis_kontraktor']=$this->rjmpencarian->get_kontraktor()->result();
		$data['search_per']='cm';
		$data['message'] = $this->session->flashdata('message');
		$data['title'] = 'Instalasi Rawat Darurat';*/
		$data['title'] = 'Registrasi Rawat Darurat';
		$data['message'] = '';
		$data['data_cari'] = '';
		$data['search_per']='cm';
		$this->load->view('ird/form_daftar_cari',$data);
	}
	public function tambah()
	{
		
		
		$data['prop']=$this->ModelAlamat->get_prop()->result();
		// $data['poliklinik']=$this->ModelRegistrasi->get_poli()->result();//untuk nav
		$data['cara_berkunjung']=$this->ModelRegistrasi->get_cara_berkunjung()->result();
		$data['cara_bayar']=$this->ModelRegistrasi->get_cara_bayar()->result();
		$data['jenis_kontraktor']=$this->rjmpencarian->get_kontraktor()->result();
		$data['search_per']='cm';
		$data['message'] = $this->session->flashdata('message');
		$data['cm_last']=$this->ModelRegistrasi->get_last_cmpatria()->row()->no_cm;
		$data['title'] = 'Registrasi Rawat Darurat';
		$data['message'] = '';
		$data['search_per']='cm';
		$this->load->view('ird/form_daftar',$data);
	}

	public function daftar_ird($no_register='')
	{				
		
		$data['search_per']='cm';
		$data['diagnosa']=$this->ModelRegistrasi->get_data_diagnosa()->result();
		$data['message'] = $this->session->flashdata('message');
		
		if($no_register==''){
			$data['daftar_pasien']=$this->ModelRegistrasi->get_daftar_pasien()->result();

			$data['title'] = 'Daftar Pasien Rawat Darurat';
			$data['message'] = '';
			$data['search_per']='cm';
			$this->load->view('ird/daftar_ird',$data);
		}else{
			$data['title'] = 'Detail Pasien Rawat Darurat';
			$data['prop']=$this->ModelAlamat->get_prop()->result();
			// $data['poliklinik']=$this->ModelRegistrasi->get_poli()->result();//untuk nav
			$data['cara_berkunjung']=$this->ModelRegistrasi->get_cara_berkunjung()->result();
			$data['cara_bayar']=$this->ModelRegistrasi->get_cara_bayar()->result();
			$data['jenis_kontraktor']=$this->rjmpencarian->get_kontraktor()->result();
			$data['operator']=$this->ModelRegistrasi->get_data_dokter_IRD()->result();//untuk select
			$data['ppk']=$this->rjmpencarian->get_ppk()->result();
			$data['jenis_kecelakaan']=$this->ModelRegistrasi->get_data_kecelakaan()->result();
			$data['kelas']=$this->ModelRegistrasi->get_kelas()->result();
			$data['detail_pasien']=$this->ModelRegistrasi->get_detail_daful($no_register)->result();
		
			$data['message'] = '';
			$this->load->view('ird/form_daful',$data);
		}
		
	}

	public function ird_pulang()
	{			
		$data['daftar_pasien']=$this->ModelRegistrasi->get_daftar_pasien_belum_pulang()->result();

		$data['title'] = 'Daftar Pasien Rawat Darurat yang Belum Pulang';
		$data['message'] = '';
		$data['search_per']='cm';
		$this->load->view('ird/daftar_ird2',$data);
	}

	public function search_pasien()
	{
		$data['no_medrec']=$this->input->post('no_medrec');
		redirect('ird/IrDRegistrasi/index2/'.$data['no_medrec']);
	}

	public function index2($no_cm='')
	{
		$data['ppk']=$this->rjmpencarian->get_ppk()->result();	
		$data['jenis_kecelakaan']=$this->ModelRegistrasi->get_data_kecelakaan()->result();
		$data['diagnosa']=$this->ModelRegistrasi->get_data_diagnosa()->result();
		$data['prop']=$this->ModelAlamat->get_prop()->result();
		$data['cara_berkunjung']=$this->ModelRegistrasi->get_cara_berkunjung()->result();
		$data['cara_bayar']=$this->ModelRegistrasi->get_cara_bayar()->result();
		$data['kelas']=$this->ModelRegistrasi->get_kelas()->result();
		$data['jenis_kontraktor']=$this->rjmpencarian->get_kontraktor()->result();
		$data['operator']=$this->ModelRegistrasi->get_data_dokter_IRD()->result();//untuk select
		$data['cm_last']=$this->ModelRegistrasi->get_last_cmpatria()->row()->no_cm;

		if($no_cm!=''){//update			
			$data['data_pasien']=$this->ModelRegistrasi->get_data_pasien_by_cmbaru($no_cm)->result();			
			foreach($data['data_pasien'] as $row){
					$data['goldarah']=$row->goldarah;
					$data['agama']=$row->agama;
					$data['id_kontraktor1']=$row->id_kontraktor1;
					$data['no_asuransi1']=$row->no_asuransi1;
					$data['id_kontraktor2']=$row->id_kontraktor2;
					$data['no_asuransi2']=$row->no_asuransi2;
					$data['id_provinsi']=$row->id_provinsi.'-'.$row->provinsi;
					$data['id_kabupaten']=$row->id_kotakabupaten.'-'.$row->kotakabupaten;
					$data['id_kecamatan']=$row->id_kecamatan.'-'.$row->kecamatan;
					$data['id_kelurahan']=$row->id_kelurahandesa.'-'.$row->kelurahandesa;
					$data['id_provinsi1']=$row->id_provinsi;
					$data['id_kabupaten1']=$row->id_kotakabupaten;
					$data['id_kecamatan1']=$row->id_kecamatan;
					$data['id_kelurahan1']=$row->id_kelurahandesa;
					$data['pendidikan']=$row->pendidikan;
					$data['no_kartu']=$row->no_kartu;
					$data['jenis_identitas']=$row->jenis_identitas;
				}
			
			$data['title'] = 'Instalasi Rawat Darurat';
			$data['daful_kontraktor']=$this->ModelRegistrasi->get_daful_kontraktor($no_cm)->result();
			
			$data['tipe_pasien']=$this->ModelRegistrasi->get_data_tipe($no_cm)->result();
				foreach($data['tipe_pasien'] as $row){
					$data['tipe']=$row->tipe;
					$data['biaya1']=$row->biaya;
				}

			$check=$this->ModelRegistrasi->check_register($no_cm)->result();
			//print_r($check);

			$no_register=$this->ModelRegistrasi->get_new_register()->result();
			foreach($no_register as $val){
			$data['no_register']=sprintf("RD%s%06s",$val->year,$val->counter+1);
			}
			$data['search_per']='cm';

			$this->load->view('ird/form_daftar2',$data);
			//redirect('ird/IrDRegistrasi');
		}else if($_SERVER['REQUEST_METHOD']!='POST'){
			redirect('ird/IrDRegistrasi');
		}else{		
			/*$no_register=$this->ModelRegistrasi->get_new_register()->result();
			foreach($no_register as $val){
			$data['no_register']=sprintf("RD%s%06s",$val->year,$val->counter+1);
			}*/			
			if($this->input->post('cari_no_medrec')!=''){
				$no_cmbaru=$this->input->post('cari_no_medrec');
				
				if($this->ModelRegistrasi->get_data_pasien_by($no_cmbaru)->num_rows()>0){
				$data['data_pasien']=$this->ModelRegistrasi->get_data_pasien_by($no_cmbaru)->result();				/*$data['daful_kontraktor']=$this->ModelRegistrasi->get_daful_kontraktor($this->input->post('cari_no_medrec'))->result();
				$data['tipe_pasien']=$this->ModelRegistrasi->get_data_tipe($this->input->post('cari_no_medrec'))->result();
				foreach($data['tipe_pasien'] as $row){
					$data['tipe']=$row->tipe;
					$data['biaya1']=$row->biaya;
				}*/
				$data['data_cari']=$data['data_pasien'];
				$data['search_per']='cm';
				$data['message'] = '';
				$data['title'] = 'Instalasi Rawat Darurat';	
								
				$this->load->view('ird/form_daftar_cari',$data);
				}else{
					$success = 	'<div class="content-header">
						<div class="alert alert-danger alert-dismissable">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-check"></i>
									Data dengan  '.$data['search_per'].': "'.$this->input->post('cari_no_medrec').'" Tidak Ditemukan
							</h4>
						</div>
						</div>';
					$this->session->set_flashdata('message',$success);
					redirect('ird/IrDRegistrasi');
				}
			
			}else if($this->input->post('cari_no_kartu')!=''){
				$no_cmkartu=$this->input->post('no_cmkartu');
				if($this->ModelRegistrasi->get_data_pasien_by_no_kartu($this->input->post('cari_no_kartu'), $no_cmkartu)->num_rows()>0){
				$data['data_pasien']=$this->ModelRegistrasi->get_data_pasien_by_no_kartu($this->input->post('cari_no_kartu'), $no_cmkartu)->result();				
				/*foreach($data['data_pasien'] as $row){
					$data['no_cm']=$row->no_medrec;
				}

				$data['daful_kontraktor']=$this->ModelRegistrasi->get_daful_kontraktor($no_cmkartu)->result();
				$data['tipe_pasien']=$this->ModelRegistrasi->get_data_tipe($data['no_cm'])->result();

				foreach($data['tipe_pasien'] as $row){
					$data['tipe']=$row->tipe;
					$data['biaya1']=$row->biaya;
				}*/

				$data['data_cari']=$data['data_pasien'];
				$data['search_per']='kartu';
				//print_r($no_cmident);
				$data['title'] = 'Instalasi Rawat Darurat';
				$this->load->view('ird/form_daftar_cari',$data);
				}else{
				$success = 	'<div class="content-header">
						<div class="alert alert-danger alert-dismissable">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-check"></i>
									Data dengan  '.$data['search_per'].': "'.$this->input->post('cari_no_kartu').'" Tidak Ditemukan
							</h4>
						</div>
						</div>';
				$this->session->set_flashdata('message',$success);
				redirect('ird/IrDRegistrasi');
				}			
			}else if($this->input->post('cari_no_medrec_lama')!=''){
				$no_cmbaru=$this->input->post('no_cmbaru');
				if($this->ModelRegistrasi->get_data_pasien_by_no_cm_lama($this->input->post('cari_no_medrec_lama'),$no_cmbaru)->num_rows()>0){
				$data['data_pasien']=$this->ModelRegistrasi->get_data_pasien_by_no_cm_lama($this->input->post('cari_no_medrec_lama'),$no_cmbaru)->result();				
				/*foreach($data['data_pasien'] as $row){
					$data['no_cm']=$row->no_medrec;
				}

				$data['daful_kontraktor']=$this->ModelRegistrasi->get_daful_kontraktor($no_cmkartu)->result();
				$data['tipe_pasien']=$this->ModelRegistrasi->get_data_tipe($data['no_cm'])->result();


				foreach($data['tipe_pasien'] as $row){
					$data['tipe']=$row->tipe;
					$data['biaya1']=$row->biaya;
				}*/

				$data['data_cari']=$data['data_pasien'];
				$data['search_per']='cmLama';
				$data['message'] = '';
				//print_r($no_cmident);
				$data['title'] = 'Instalasi Rawat Darurat';
				$this->load->view('ird/form_daftar_cari',$data);
				}else{
				$success = 	'<div class="content-header">
						<div class="alert alert-danger alert-dismissable">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-check"></i>
									Data dengan  '.$data['search_per'].': "'.$this->input->post('cari_no_medrec_lama').'" Tidak Ditemukan
							</h4>
						</div>
						</div>';
				$this->session->set_flashdata('message',$success);
				redirect('ird/IrDRegistrasi');
				}			
			}else if($this->input->post('cari_no_identitas')!=''){
				$no_cmident=$this->input->post('no_cmident');
				//echo $this->input->post('cari_no_identitas');
					if($this->ModelRegistrasi->get_data_pasien_by_no_identitas($this->input->post('cari_no_identitas'),$no_cmident)->num_rows()>0){
					$data['data_pasien']=$this->ModelRegistrasi->get_data_pasien_by_no_identitas($this->input->post('cari_no_identitas'),$no_cmident)->result();	
					foreach($data['data_pasien'] as $row){
						$data['no_cm']=$row->no_medrec;
					}
					$data['data_cari']=$data['data_pasien'];
					/*$data['daful_kontraktor']=$this->ModelRegistrasi->get_daful_kontraktor($no_cmident)->result();
					$data['tipe_pasien']=$this->ModelRegistrasi->get_data_tipe($data['no_cm'])->result();
					foreach($data['tipe_pasien'] as $row){
						$data['tipe']=$row->tipe;
						$data['biaya1']=$row->biaya;
					}

					//print_r($data);*/

					$data['title'] = 'Instalasi Rawat Darurat';
					$data['search_per']='identitas';
					$data['message'] = '';
					$this->load->view('ird/form_daftar_cari',$data);
					}else{
						$success = 	'<div class="content-header">
						<div class="alert alert-danger alert-dismissable">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-check"></i>
									Data dengan  '.$data['search_per'].': "'.$this->input->post('cari_no_identitas').'" Tidak Ditemukan
							</h4>
						</div>
						</div>';
						$this->session->set_flashdata('message',$success);
						redirect('ird/IrDRegistrasi/');
					}
			}else if($this->input->post('cari_nama')!=''){
				//$no_cmident=$this->input->post('no_cmident');
				//echo $this->input->post('cari_no_identitas');
					if($this->ModelRegistrasi->get_data_pasien_by_nama($this->input->post('cari_nama'))->num_rows()>0){					
					$data['data_cari']=$this->ModelRegistrasi->get_data_pasien_by_nama($this->input->post('cari_nama'))->result();										
				
					/*$data['tipe_pasien']=$this->ModelRegistrasi->get_data_tipe($data['no_cm'])->result();
					foreach($data['tipe_pasien'] as $row){
						$data['tipe']=$row->tipe;
						$data['biaya1']=$row->biaya;
					}*/

					//print_r($data['data_pasien']);
					$data['title'] = 'Pencarian Data Pasien Instalasi Rawat Darurat';
					$data['search_per']='nama';
					
					$data['message'] = '';
					$this->load->view('ird/form_daftar_cari',$data);
					}else{ 
						$data['search_per']='nama';
						$success = 	'<div class="content-header">
						<div class="alert alert-danger alert-dismissable">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-check"></i>
									Data dengan  '.$data['search_per'].': "'.$this->input->post('cari_nama').'" Tidak Ditemukan
							</h4>
						</div>
						</div>';
						$data['data_cari']='';
						$this->session->set_flashdata('message', $success);
						$data['title'] = 'Pencarian Data Pasien Instalasi Rawat Darurat';
						$data['cari']=$this->input->post('cari_nama');
						$this->load->view('ird/form_daftar_cari',$data);
					}
			}else if($this->input->post('cari_alamat')!=''){
				//$no_cmident=$this->input->post('no_cmident');
				//echo $this->input->post('cari_no_identitas');
					if($this->ModelRegistrasi->get_data_pasien_by_alamat($this->input->post('cari_alamat'))->num_rows()>0){
					$data['data_cari']=$this->ModelRegistrasi->get_data_pasien_by_alamat($this->input->post('cari_alamat'))->result();										
							
					$data['search_per']='alamat';
					
					//print_r($data['data_pasien']);
					$data['title'] = 'Pencarian Data Pasien Instalasi Rawat Darurat';
					$this->load->view('ird/form_daftar_cari',$data);
					}
					else{
						//$message['message'] = $this->session->set_flashdata('message','1');
						$success = 	'<div class="content-header">
						<div class="alert alert-danger alert-dismissable">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-check"></i>
									Data dengan  '.$data['search_per'].' : "'.$this->input->post('cari_alamat').'" Tidak Ditemukan
							</h4>
						</div>
						</div>';

						$this->session->set_flashdata('message', $success);
						$data['data_cari']='';
						$data['search_per']='alamat';
						$data['title'] = 'Pencarian Data Pasien Instalasi Rawat Darurat';
						$data['cari']=$this->input->post('cari_alamat');
						$this->load->view('ird/form_daftar_cari',$data);
					}
			}else{


				redirect('ird/IrDRegistrasi');
			}											
		}
	}
	public function insert_pasien_ird()
	{
		$no_cm=$this->ModelRegistrasi->get_new_medrec()->result();
		foreach($no_cm as $val){
			$data['no_medrec']=sprintf("%010s",$val->counter+1);
		}

			$config['upload_path'] = './upload/photo';
			$config['allowed_types'] = 'gif|png|jpg';
			$config['max_size'] = '2000000';
			$config['max_width'] = '2000';
			$config['max_height'] = '2000';
			$config['file_name'] = 'IMG_'.$no_cm;
			$this->upload->initialize($config);
					
			if(!$this->upload->do_upload('userfile')){
				$data['foto']='unknown.png';
				// $error = $this->upload->display_errors();
				// echo $error;
			}else{
				$upload = $this->upload->data();
				$data['foto']=$upload['file_name'];
			}
			
		//$data['no_medrec']=$this->input->post('no_cm');
		$data['no_cm']=$this->ModelRegistrasi->get_last_cmpatria()->row()->no_cm + 1;
		//$data['no_cm']=$this->input->post('cm1').''.$this->input->post('cm2').''.$this->input->post('cm3');

		if($this->input->post('jenis_identitas')!=''){
			$data['jenis_identitas']=$this->input->post('jenis_identitas');
			$data['no_identitas']=$this->input->post('no_identitas');
		}
		//$data['jenis_kartu']=$this->input->post('jenis_kartu');
		
		if($this->input->post('no_kartu')!=''){
			$data['no_kartu']=$this->input->post('no_kartu');
		}
		$data['no_kk']=$this->input->post('no_kk');
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

		if($this->input->post('goldarah')!='0'){
		$data['goldarah']=$this->input->post('goldarah');
		}
		if($this->input->post('asuransi1')!='0'){
			$data['id_kontraktor1']=$this->input->post('asuransi1');
			$data['no_asuransi1']=$this->input->post('no_asuransi1');
		}
		if($this->input->post('asuransi2')!='0'){
			$data['id_kontraktor2']=$this->input->post('asuransi2');
			$data['no_asuransi2']=$this->input->post('no_asuransi2');
		}

		$data['nm_ibu_istri']=$this->input->post('nm_ibu_istri');
		//$data['kartusdhdicetak']=$this->input->post('kartusdhdicetak');
		date_default_timezone_set("Asia/Jakarta");		
		$data['xupdate']=date("Y-m-d H:i:s");
		$data['xuser']=$this->input->post('user_name');

		$id=$this->ModelRegistrasi->insert_pasien_ird($data);

		if($id!='0')
		{
			$message['message'] = $this->session->set_flashdata('message',$id['message']);
			redirect('ird/IrDRegistrasi/');
		}else{
			redirect('ird/IrDRegistrasi/index2/'.$data['no_medrec']);
		}
	}
	public function update_pasien_ird()
	{	
			$no_medrec=$this->input->post('no_cm');
			//$data['no_cm']=$this->input->post('cm_patria');
			$config['upload_path'] = './upload/photo';
			$config['allowed_types'] = 'gif|png|jpg';
			$config['max_size'] = '2000000';
			$config['max_width'] = '2000';
			$config['max_height'] = '2000';
			$config['file_name'] = 'IMG_'.$no_medrec;
			$this->upload->initialize($config);
					
			if(!$this->upload->do_upload('userfile')){
				// $data['foto']='unknown.png';
				$error = $this->upload->display_errors();
				echo $error;
			}else{
				$upload = $this->upload->data();
				$data['foto']=$upload['file_name'];
				echo $data['foto'];
			}
			
		
		if($this->input->post('jenis_identitas')!=''){
		//echo "hahahahahah";
			$data['jenis_identitas']=$this->input->post('jenis_identitas');
			$data['no_identitas']=$this->input->post('no_identitas');
		}

		if($this->input->post('no_kartu')!=''){
			$data['no_kartu']=$this->input->post('no_kartu');
		}

		$data['no_kk']=$this->input->post('no_kk');
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
		$data['xuser']=$this->input->post('user_name');

		if($this->input->post('goldarah')!='0'){
			$data['goldarah']=$this->input->post('goldarah');
		}				

		$data['nm_ibu_istri']=$this->input->post('nm_ibu_istri');

		if($this->input->post('asuransi1')!='0'){
			$data['id_kontraktor1']=$this->input->post('asuransi1');
			$data['no_asuransi1']=$this->input->post('no_asuransi1');
		}else { $data['id_kontraktor1']=''; $data['no_asuransi1']='';}
		if($this->input->post('asuransi2')!='0'){
			$data['id_kontraktor2']=$this->input->post('asuransi2');
			$data['no_asuransi2']=$this->input->post('no_asuransi2');
		}else { $data['id_kontraktor2']=''; $data['no_asuransi2']='';}
		//$data['kartusdhdicetak']=$this->input->post('kartusdhdicetak');
		//print_r($data);
		//echo $no_medrec;
		$id=$this->ModelRegistrasi->update_pasien_ird($data,$no_medrec);
		
		redirect('ird/IrDRegistrasi/index2/'.$no_medrec);
	}
	public function delete_pasien($no_cm='', $from='')
	{
		$id=$this->ModelRegistrasi->hapus_pasien($no_cm);

		$success = 	'<div class="content-header">
					<div class="alert alert-success alert-dismissable">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-check"></i>
									Pasien telah berhasil dihapus &nbsp;
							</h4>
					</div>
				</div>';

		$this->session->set_flashdata('message', $success);
		if($from=='1')
		{
			redirect('ird/IrDRegistrasi/');
		}else
			redirect('irj/Rjcregistrasi/');
	}
	public function update_reset_biodata($no_cm)
	{		
		$data['prop']=$this->ModelAlamat->get_prop()->result();
		// $data['poliklinik']=$this->ModelRegistrasi->get_poli()->result();//untuk nav
		$data['cara_berkunjung']=$this->ModelRegistrasi->get_cara_berkunjung()->result();
		$data['cara_bayar']=$this->ModelRegistrasi->get_cara_bayar()->result();
		// print_r($data['prop']);
		$no_register=$this->ModelRegistrasi->get_new_register()->result();
		foreach($no_register as $val){
			$data['no_register']=sprintf("RD%s%06s",$val->year,$val->counter+1);
		}
		$data['operator']=$this->ModelPelayanan->get_data_dokter()->result();//untuk select
		$data['kelas']=$this->ModelRegistrasi->get_kelas()->result();
		$data['data_pasien']=$this->ModelRegistrasi->get_data_pasien_by($no_cm)->result();
		foreach($data['data_pasien'] as $row){
					$data['goldarah']=$row->goldarah;
					$data['agama']=$row->agama;
					$data['id_kontraktor1']=$row->id_kontraktor1;
					$data['no_asuransi1']=$row->no_asuransi1;
					$data['id_kontraktor2']=$row->id_kontraktor2;
					$data['no_asuransi2']=$row->no_asuransi2;
					$data['id_provinsi']=$row->id_provinsi.'-'.$row->provinsi;
					$data['id_kabupaten']=$row->id_kotakabupaten.'-'.$row->kotakabupaten;
					$data['id_kecamatan']=$row->id_kecamatan.'-'.$row->kecamatan;
					$data['id_kelurahan']=$row->id_kelurahandesa.'-'.$row->kelurahandesa;
					$data['pendidikan']=$row->pendidikan;
					$data['jenis_identitas']=$row->jenis_identitas;
				}
		$data['diagnosa']=$this->ModelRegistrasi->get_data_diagnosa()->result();
		$data['jenis_kontraktor']=$this->rjmpencarian->get_kontraktor()->result();
		$data['daful_kontraktor']=$this->ModelRegistrasi->get_daful_kontraktor($no_cm)->result();
		$data['tipe_pasien']=$this->ModelRegistrasi->get_data_tipe($no_cm)->result();
				foreach($data['tipe_pasien'] as $row){
					$data['tipe']=$row->tipe;
					$data['biaya1']=$row->biaya;
				}

		$data['title'] = 'Instalasi Rawat Darurat';
		 
		$this->load->view('ird/form_daftar_reset_bio',$data);

	}

	//automatic add action
	public function insert_tindakan($data1)
	{
		date_default_timezone_set("Asia/Jakarta");
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xuser']=$user;
		$data['xupdate']=date("Y-m-d H:i:s");
		$data['tgl_kunjungan']=date("Y-m-d H:i:s");
		// baru BA0102 , lama BA0103 //
		//$data['id_poli']=$data1['id_poli'];
		$data['no_register']=$data1['no_register'];

		//default BA0102
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
			$data['idtindakan']='BA0102';

		/*if($data1['jenis_pasien']=='BARU'){
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0102')->row();	
			$data['idtindakan']='BA0102';					
		}else{
			$detailtind=$this->rjmregistrasi->get_detail_tindakan('BA0103')->row();
			$data['idtindakan']='BA0103';
		}		*/

			//$data['nmtindakan']=$detailtind->nmtindakan;		

		$data['biaya_ird']=$detailtind->total_tarif;
		$data['biaya_alkes']=$detailtind->tarif_alkes;
		$data['qty']='1';
		//$data['dijamin']=$this->input->post('dijamin');
		$data['vtot']=(int)$data['biaya_ird']+(int)$data['biaya_alkes'];
		
		$id=$this->ModelPelayanan->insert_pelayanan_tindakan($data);
		
		//penambahan vtot di irddaftar_ulang
		//echo $data1['no_register'];
		$vtot_sebelumnya = $this->ModelPelayanan->get_vtot_daful($data1['no_register'])->row()->vtot;
		$data_vtot['vtot'] = (int)$vtot_sebelumnya+(int)$data['vtot'];
		$this->ModelPelayanan->update_vtot_daful($data1['no_register'],$data_vtot['vtot']);

		if($data1['cara_bayar']!='UMUM'){
		echo '<script type="text/javascript">window.open("'.site_url("ird/irdjamsoskes/cetak_sjp/$no_register").'", "_blank");window.focus()</script>';
		}
	}

	public function insert_daftar_ulang()
	{
		//echo date('y'); 
		$no_medrec=$this->input->post('no_medrec');
		$check=$this->ModelRegistrasi->check_register($no_medrec)->row()->record;
		//print_r($no_medrec);		
		//print_r($check);
		if ($check!='0') 
		{	//print_r($check);
			$success = 	'<div class="content-header">
					<div class="alert alert-danger alert-dismissable">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-check"></i>
									Maaf, Pasien sudah terdaftar untuk hari ini &nbsp;
							</h4>
					</div>
				</div>';

			$this->session->set_flashdata('message', $success);
			redirect('ird/IrDRegistrasi/');
					
		}else{
		//print_r($check); 
		//get umur
		$get_umur=$this->ModelRegistrasi->get_umur($no_medrec)->result();		
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
		//print_r($get_umur);
		//$data['no_register']=$this->input->post('no_register');
		
		$data['no_medrec']=$this->input->post('no_medrec');
		date_default_timezone_set("Asia/Jakarta");
		$data['tgl_kunjungan']=$this->input->post('tgl_kunj')." ".date('H:i:s');
		
		$data['alasan_berobat']=$this->input->post('alber');
		
		$data['datang_dengan']=$this->input->post('pasdatDg');

		if($this->input->post('jenis_kecelakaan')!=''){
			$data['kecelakaan']=$this->input->post('jenis_kecelakaan');
			if($this->input->post('lokasi_kecelakaan')!=''){
				$data['lokasi_kecelakaan']=$this->input->post('lokasi_kecelakaan');
			}
		}			
		
		if($this->input->post('jenis_kontraktor')!=''){
			$data['id_kontraktor']=$this->input->post('jenis_kontraktor');
		}
		$data['kelas_pasien']=$this->input->post('kelas_pasien');
		
		$data['cara_bayar']=$this->input->post('cara_bayar');
		
		
		if($this->input->post('asal_rujukan')!=''){
			$data['asal_rujukan']=$this->input->post('asal_rujukan');
		}

		if($this->input->post('dll_rujukan')!=''){
			$data['asal_rujukan']=$this->input->post('dll_rujukan');
		}
		
		if($this->input->post('id_diagnosa')!=''){
			$data['diagnosa']=$this->input->post('id_diagnosa');	//format salah
		}		
		$data['vtot']='0';	
		
		$data['nama_penjamin']=$this->input->post('nama_penjamin');
		
		$data['hubungan']=$this->input->post('hubungan');
		
		if($this->input->post('no_sep')!=''){
			$data['no_sep']=$this->input->post('no_sep');
		}

		
		
		//$data['goldarah']=$this->input->post('goldarah');
		if($this->input->post('operatorTindakan')!=''){
			$dokter = explode("@", $this->input->post('operatorTindakan'));
			$data['id_dokter']=$dokter[0];
			//$data['nm_dokter']=$dokter[1];
		}


		if($this->input->post('no_rujukan')!=''){
		$data['no_rujukan']=$this->input->post('no_rujukan');}
		
		if($this->input->post('tgl_rujukan')!=''){
		$data['tgl_rujukan']=$this->input->post('tgl_rujukan');}

		$no_register=$this->input->post('no_register');

		$data['lab']='0';		
		$data['vtot_lab']='0';
		
		$data['obat']='0';
		$data['vtot_obat']='0';

		$data['rad']='0';
		$data['vtot_rad']='0';
		
		$data['xuser']=$this->input->post('user_name');

		$id=$this->ModelRegistrasi->insert_daftar_ulang($data,$no_medrec);
		//print_r($data);
		$data['no_register']=$this->ModelRegistrasi->get_noreg_pasien($data['no_medrec'])->row()->noreg;
		$this->insert_tindakan($data);

		$id1=$this->ModelRegistrasi->cek_kunj_ird($no_medrec)->row();
		$id2=$this->rjmregistrasi->cek_kunj_irj($no_medrec)->row();
		
		if($id1->cek + $id2->cek=='1'){
		echo '<script type="text/javascript">window.open("'.site_url("irj/rjcregistrasi/cetak_identitas/$id->no_register").'", "_blank");window.focus()</script>';
		}
		
		if ($data['cara_bayar']=="BPJS") {
				//$data2['no_sep']=$this->buat_SEP($id->no_register);
				//echo $data2['no_sep'];
				//$result = $this->rjmregistrasi->update_SEP($id->no_register, $data2);
				
				//echo '<script type="text/javascript">window.open("'.site_url("ird/IrDRegistrasi/cetak_sep/$id->no_register").'", "_blank");window.focus()</script>';
		}
		
		$success = 	'<div class="content-header">
					<div class="alert alert-success alert-dismissable">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-check"></i>
									Daftar ulang pasien berhasil. &nbsp;
							</h4>
					</div>
				</div>';

		$this->session->set_flashdata('message', $success);
		
		redirect('ird/IrDRegistrasi/');
		}
	}

	public function update_daful()
	{
		//echo date('y'); 
		$no_medrec=$this->input->post('no_medrec');
		
		//get umur
		$get_umur=$this->ModelRegistrasi->get_umur($no_medrec)->result();
		$tahun=0;
		$bulan=0;
		$hari=0;
		// (SELECT CONCAT('RJ16',LPAD(max(right(no_register,6))+1,6,0)) from daftar_ulang_irj)
		foreach($get_umur as $row)
		{
			// echo $row->umurday;
			$tahun=floor($row->umurday/365);
			$bulan=floor(($row->umurday - ($tahun*365))/30);
			$hari=$row->umurday - ($bulan * 30) - ($tahun * 365);
		}
		
		$data['umurrj']=$tahun;
		
		$data['uharirj']=$bulan;
		
		$data['ublnrj']=$hari;
		//print_r($get_umur);
		$data['no_register']=$this->input->post('no_register');
		//print_r( $data['no_register']);
		//$data['no_medrec']=$this->input->post('no_medrec');
		date_default_timezone_set("Asia/Jakarta");
		$data['tgl_kunjungan']=$this->input->post('tgl_kunj')." ".date('H:i:s');
		
		$data['alasan_berobat']=$this->input->post('alber');
		
		$data['datang_dengan']=$this->input->post('pasdatDg');

		if($this->input->post('jenis_kecelakaan')!=''){
			$data['kecelakaan']=$this->input->post('jenis_kecelakaan');
		}			
		
		if($this->input->post('jenis_kontraktor')!=''){
			$data['id_kontraktor']=$this->input->post('jenis_kontraktor');
		}
		$data['kelas_pasien']=$this->input->post('kelas_pasien');
		
		$data['cara_bayar']=$this->input->post('cara_bayar');
				
		
		if($this->input->post('id_diagnosa')!=''){
			$data['diagnosa']=$this->input->post('id_diagnosa');	//format salah
		}				
	
		
		/*if ($this->input->post('statusBpjs')!='') {
				$data['statusRecord']=$this->input->post('statusBpjs');
		}*/

		$data['biayadaftar']=$this->input->post('biayadaftar');	
		
		$data['nama_penjamin']=$this->input->post('nama_penjamin');
		
		$data['hubungan']=$this->input->post('hubungan');
		
		//$data['goldarah']=$this->input->post('goldarah');
		$dokter = explode("@", $this->input->post('operatorTindakan'));
		$data['id_dokter']=$dokter[0];
		//$data['nm_dokter']=$dokter[1];

		if($this->input->post('asal_rujukan')!=''){
		$data['asal_rujukan']=$this->input->post('asal_rujukan');}

		if($this->input->post('no_rujukan')!=''){
		$data['no_rujukan']=$this->input->post('no_rujukan');}
		
		if($this->input->post('tgl_rujukan')!=''){
		$data['tgl_rujukan']=$this->input->post('tgl_rujukan');}

		$no_register=$this->input->post('no_register');
		
		$id=$this->ModelRegistrasi->update_daftar_ulang($data,$no_register);

		redirect('ird/IrDRegistrasi/daftar_ird/'.$no_register,'refresh');
		
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////SEP

	public function ambil_sep2($no_register){
		echo '<script type="text/javascript">window.open("'.site_url("ird/IrDRegistrasi/cetak_sep/$no_register").'", "_blank");window.focus()</script>';
	}

	public function ambil_sep($no_register){

		$ruang = 'UGD';
		$kelas = '';
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

		$kode = substr($no_register, 0,2);
		if($kode=='RJ'){
			$pasien=$this->rjmregistrasi->select_pasien_irj_by_no_register_with_diag_utama($no_register);
		}
		else if($kode=='RD'){
			$pasien=$this->ModelRegistrasi->select_pasien_ird_by_no_register_with_diag_utama($no_register);
		}
		else{
		}
		
	
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

			
		
		//<ppkRujukan>'.$pasien[0]['asal_rujukan'].'</ppkRujukan> 0301U049
		 $data = '
			 <request>
			 <data>
			 <t_sep>
			 <noKartu>'.$pasien[0]['no_kartu'].'</noKartu>
			 <tglSep>'.$tgl_sep.'</tglSep>
			 <tglRujukan>'.$tgl_sep.'</tglRujukan>
			 <noRujukan>'.$pasien[0]['no_rujukan'].'</noRujukan>
			 <ppkRujukan>0301U049</ppkRujukan>
			 <ppkPelayanan>0301R001</ppkPelayanan>
			 <jnsPelayanan>2</jnsPelayanan>
			 <catatan>-</catatan>
			 <diagAwal>'.$pasien[0]['diagnosa'].'</diagAwal>
			 <poliTujuan>MAT</poliTujuan>
			 <klsRawat>'.$kelas.'</klsRawat>
			 <lakaLantas>1</lakaLantas>
			 <user>'.$user.'</user>
			 <noMr>'.$pasien[0]['no_cm'].'</noMr>
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
				$data2['no_sep']=$sep->response;
				if($kode=='RD'){
					//$data2['no_sep']=$sep->response;
					$id=$this->ModelRegistrasi->update_SEP($no_register, $data2);
				}else{
					$id=$this->rjmregistrasi->update_SEP($no_register, $data2);
				}
			}
		 }else{
		 	$data_response = array('status' => 0, 
					'response' => "Pastikan Anda Terhubung Internet!!"
					);
		 }

		 echo json_encode($data_response);
	}


	public function buat_SEP($no_register) {
		


		
		date_default_timezone_set('Asia/Jakarta');
        $timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        
		$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
        $encoded_signature = base64_encode($signature);
		$http_header = array(
               'Accept: application/json', 
               'Content-type: application/x-www-form-urlencoded',
               'X-cons-id: 1000', //id rumah sakit
               'X-timestamp: ' . $timestamp,
               'X-signature: ' . $encoded_signature
        );
		 
		$data['data_pasien_daftar_ulang']=$this->ModelPelayanan->getdata_daftar_ulang_pasien($no_register)->row();
		$logged_in_user_info=$this->M_user->get_logged_in_user_info();
		
         // nama variabel sesuai dengan nama di xml
         $noKartu = $data['data_pasien_daftar_ulang']->no_kartu;
		 $tglSep = date('Y-m-d H:i:s');
         /*$tglRujukan = $data['data_pasien_daftar_ulang']->tgl_rujukan;
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
         */
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
					<user>viena</user>
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
		echo $result; 
         $sep = json_decode($result)->response;
         //echo $sep;
		 return($sep);
		
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
	public function getTimestamp() {
		date_default_timezone_set('Asia/Jakarta');
        	$timestamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        
		$signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
        	$encoded_signature = base64_encode($signature);

		echo $encoded_signature.'\n';
		echo $timestamp;

	}
	public function cetak_sep($no_register) {
		
		//require(getenv('DOCUMENT_ROOT') . '/RS-BPJS/assets/Surat.php');
		require_once(APPPATH.'controllers/ird/SEP.php');

		$sep = new SEP();
		//$this->load->model('r_jalan');
		//$entri_rd = $this->rjmregistrasi->get_entri($no_register);
		$entri_rd = $this->ModelRegistrasi->get_entri($no_register);
		if (!$entri_rd) {
			return;
		}
		//$this->load->model('pasien_irj');
		$pasien = $this->rjmregistrasi->get_data_pasien_by_no_cm_baru($entri_rd->no_medrec)->row();
		if (!$pasien) {
			return;
		} 
		//$this->load->model('ppk');
		$ppk = $this->rjmregistrasi->get_ppk($entri_rd->asal_rujukan);
		//print_r($entri_rd);
		if ($ppk) {
			$ppk = $ppk->nm_ppk;
		}
		else {
			$ppk = $entri_rd->asal_rujukan;
		}
		
		$result = $this->rjmregistrasi->get_diagnosa($entri_rd->diagnosa);
		//print_r($result);
		$diagnosa=$result->id_icd." - ".$result->nm_diagnosa;

		// $data_rs=$this->rjmkwitansi->getdata_rs('10000')->result();
		// foreach($data_rs as $row){
		// 	$namars=$row->namars;
		// 	$kota_kab=$row->kota;
		// }
			$namars=$this->config->item('namars');
			$alamat=$this->config->item('alamat');
			$kota_kab=$this->config->item('kota');
		
		$fields = array(
				'No. SEP' => $entri_rd->no_sep,
				'Tgl. SEP' => date('d-m-Y'),
				'No. Kartu' => $pasien->no_kartu,
				'Peserta' => ucfirst(strtolower($pasien->pesertaBPJS)),
				'Nama Peserta' => ucfirst($pasien->nama),
				'Tgl. Lahir' => date("d-m-Y", strtotime($pasien->tgl_lahir)),
				'Jenis Kelamin' => $pasien->sex,
				'Asal Faskes' => $ppk,
				'Poli Tujuan' => 'IRD',
				'Kelas Rawat' => $entri_rd->kelas_pasien,
				'Jenis Rawat' => 'Rawat Jalan',
				'Diagnosa Awal' => $diagnosa,
				//'Catatan' => $entri_rd->CATATAN
				'Catatan' => '',
				'Nama RS' => $namars
			); 
		//print_r($fields);
		$sep->set_nilai($fields);
		$sep->cetak();
	}

	public function insert_nosep()
	{
		
	}

	public function cetak_karcis($no_register='')
	{
		$data['title'] = 'Instalasi Rawat Darurat';

		if($no_register!=''){
			
			
			// $data_rs=$this->ModelKwitansi->getdata_rs('10000')->result();
			// 	foreach($data_rs as $row){
			// 		$namars=$row->namars;
			// 		$kota_kab=$row->kota;
			// 		$alamatrs=$row->alamat;
			// 		//$nmsingkat=$row->nmsingkat;
			// 	}
			$namars=$this->config->item('namars');
			$alamat=$this->config->item('alamat');
			$kota_kab=$this->config->item('kota');
			$data_karcis=$this->ModelKwitansi->getdata_karcis($no_register)->result();

			//set timezone
			date_default_timezone_set("Asia/Bangkok");			
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl=date("d-m-Y");

			foreach($data_karcis as $row){
			$konten=
					"<br/><br/>
					$namars<br/>
					$alamatrs, $kota_kab<br/><br/>
					
					Administrasi Berobat Ins. Rawat Darurat<br/><br/>
					<table>
						<tr>
							<td width=\"30%\">No. Seri Karcis</td>
							<td width=\"5%\"> : </td>
							<td width=\"65%\"><b>$no_register</b></td>
						</tr>
						<tr>
							<td>Pasien</td>
							<td> : </td>
							<td>$row->cara_bayar</td>
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
							<td>Tgl Cetak Karcis</td>
							<td> : </td>
							<td>$tgl_jam</td>
						</tr>
						<tr>
							<td>Petugas</td>
							<td> : </td>
							<td>-</td>
						</tr>
						<tr>
							<td>Biaya Karcis</td>
							<td> : </td>
							<td><b><font size=\"10\">Rp ".number_format( $row->biayadaftar, 2 , ',' , '.' )."</font></b></td>
						</tr>
					</table></br>
					<hr/>
			";
			}
			$file_name="KC_$no_register.pdf";
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
				$obj_pdf->Output(FCPATH.'download/ird/rdkarcis/'.$file_name, 'FI');
		}else{
			redirect('ird/IrDRegistrasi','refresh');
		}
	}
	public function data_kotakab($id_prop='',$sid='')
	{
		$data=$this->ModelAlamat->get_kotakab($id_prop)->result();
			echo "<option selected value=''>Pilih Kota/Kabupaten</option>";
			foreach($data as $row){
				echo "<option value='".$row->id."-".$row->nama."'>".$row->nama."</option>";
			}
	}
	public function data_kecamatan($id_kabupaten='',$sid='')
	{
		$data=$this->ModelAlamat->get_kecamatan($id_kabupaten)->result();
			echo "<option selected value=''>Pilih Kecamatan</option>";
			foreach($data as $row){
				echo "<option value='".$row->id."-".$row->nama."'>".$row->nama."</option>";
			}
	}
	public function data_kelurahan($id_kecamatan='',$sid='')
	{
		$data=$this->ModelAlamat->get_kelurahan($id_kecamatan)->result();
			echo "<option selected value=''>Pilih Kelurahan</option>";
			foreach($data as $row){
				echo "<option value='".$row->id."-".$row->nama."'>".$row->nama."</option>";
			}
	}
	public function data_pasien(){
			$keyword = $this->uri->segment(4);
			$data = $this->db->from('data_pasien')->like('no_cm',$keyword)->limit(12, 0)->get()->result();	

			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->no_cm,
					'no_medrec'	=>$row->no_medrec,
					'no_cm'	=>$row->no_cm
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}
	public function data_pasien_lama(){
			$keyword = $this->uri->segment(4);
			$data = $this->db->from('data_pasien')->like('no_cm',$keyword)->limit(12, 0)->get()->result();	

			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->no_cm,
					'no_medrec'=>$row->no_medrec,
					'no_cm'	=>$row->no_cm
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}
	public function data_pasien_by_nokartu(){
			$keyword = $this->uri->segment(4);
			$data = $this->db->from('data_pasien')->like('no_kartu',$keyword)->limit(12, 0)->get()->result();	

			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->no_kartu,
					'no_kartu'	=>$row->no_kartu,
					'no_medrec'	=>$row->no_medrec,
					'no_cm'	=>$row->no_cm
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}
	public function data_pasien_by_noidentitas(){
			$keyword = $this->uri->segment(4);
			$data = $this->db->from('data_pasien')->like('no_identitas',$keyword)->limit(12, 0)->get()->result();	

			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->no_identitas,
					'no_identitas'	=>$row->no_identitas,
					'no_medrec'	=>$row->no_medrec,
					'no_cm'	=>$row->no_cm
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}
	public function data_kecelakaan(){
			// tangkap variabel keyword dari URL
			$keyword = $this->uri->segment(4);
			// cari di database
			$data = $this->db->from('kecelakaan_ird')->like('id',$keyword)->get()->result();	

			// format keluaran di dalam array
			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->id,
					'id'	=>$row->id,
					'nm_kecelakaan'	=>$row->nm_kecelakaan
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}

	public function data_ruang(){
			// tangkap variabel keyword dari URL
			$keyword = $this->uri->segment(4);
			// cari di database
			$data = $this->db->from('ruang')->like('idrg',$keyword)->get()->result();	

			// format keluaran di dalam array
			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->idrg,
					'id'	=>$row->idrg,
					'nm_ruang'	=>$row->nmruang
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}

	public function data_kelas(){
			// tangkap variabel keyword dari URL
			$keyword = $this->uri->segment(4);
			// cari di database
			$data = $this->db->from('kelas')->like('kelas',$keyword)->get()->result();	

			// format keluaran di dalam array
			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->urutan,
					'id'	=>$row->urutan,
					'nm_kelas'	=>$row->kelas
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}
	
	public function data_diagnosa(){
			// tangkap variabel keyword dari URL
			$keyword = $this->uri->segment(4);
			// cari di database
			$data = $this->db->from('icd1')->like('id_icd',$keyword)->get()->result();	

			// format keluaran di dalam array
			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->id_icd,
					'id'	=>$row->id_icd,
					'nama_diagnosa'	=>$row->nm_diagnosa
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}
	
	public function data_kontraktor(){
			// tangkap variabel keyword dari URL
			$keyword = $this->uri->segment(4);
			// cari di database
			$data = $this->db->from('kontraktor')->like('id_kontraktor',$keyword)->get()->result();	
			//$data = $this->db->from('kontraktor')->like('nmkontraktor',$keyword)->get()->result();	
			// format keluaran di dalam array
			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->id_kontraktor,
					'id'	=>$row->id_kontraktor,
					'nm_kontraktor'	=>$row->nmkontraktor
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}

	///////////////////////////////////////////////////
	public function kwitansi()
	{	
		// $data['poliklinik']=$this->ModelRegistrasi->get_poli()->result();//untuk nav
		$data['title'] = 'Instalasi Rawat Darurat';
		 
		$this->load->view('ird/kwitansi',$data);
	}
	public function list_poli()
	{	
		$data['poliklinik']=$this->ModelRegistrasi->get_poli()->result();//untuk nav
		$data['title'] = 'Instalasi Rawat Darurat';
		 
		$this->load->view('ird/list_poli',$data);
	}
	public function pasien_poli()
	{	
		$id_poli=$this->input->post('id_poli');
		redirect('ird/IrjPelayanan/kunj_pasien_poli/'.$id_poli);
	}

	
	
	public function cetak_sep2($no_register='') {
		require(getenv('DOCUMENT_ROOT') . '/hmis_muara/asset/Surat.php');
		$surat = new Surat();		
		$entri_rd = $this->ModelRegistrasi->get_entri($no_register);
		
		if (!$entri_rd) {
			return;
		}
				
		$pasien = $this->ModelRegistrasi->cari_by_medrec($entri_rd->NO_MEDREC);
		if (!$pasien) {
			return;
		} 
		$ppk = $this->ppk->get_data($entri_rd->KD_PPK);
		if ($ppk) {
			$ppk = $ppk->NM_PPK;
		}
		else {
			$ppk = $entri_rd->KD_PPK;
		}
		
		$fields = array(
				'No. SEP' => $entri_rd->NO_SEP,
				'Tgl. SEP' => date('d/m/Y'),
				'No. Kartu' => $pasien->NO_ASURANSI,
				'Peserta' =>  $entri_rd->PESERTABPJS,
				'Nama Peserta' => $entri_rd->NAMA,
				'Tgl. Lahir' => $pasien->TGL_LAHIR,
				'Jenis Kelamin' => $pasien->SEX,
				'Asal Faskes' => $ppk,
				'Poli Tujuan' => $entri_rd->NM_POLI,
				'Kelas Rawat' => $entri_rd->KELAS_PASIEN,
				'Jenis Rawat' => 'Rawat Darurat',
				'Diagnosa Awal' => $entri_rd->ID_DIAGNOSA,
				'Catatan' => $entri_rd->CATATAN
			); 
		$surat->set_nilai($fields);
		//$surat->cetak();
	}

	public function check_no_kartu($no_cm='') {
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
				//
				//$ch = curl_init('http://api.asterix.co.id/SepWebRest/peserta/'.$no_kartu);
				$ch = curl_init('http://dvlp.bpjs-kesehatan.go.id:8081/devWSLokalRest/Peserta/peserta/'.$no_kartu);
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
					if($sep==''){
						echo "<h4>Tidak ditemukan no Kartu: <b>$no_kartu<b/></h4>";}
					else{
						foreach ($sep as $key => $value){
						$data['pesertaBPJS']=$value->jenisPeserta->nmJenisPeserta;
						$pasien = $this->ModelRegistrasi->update_pesertaBpjs($no_cm,$data );
					        
						echo "<b>No Kartu :</b> $value->noKartu <br/>";
						echo "<b>NIK :</b> $value->nik <br/>";
						echo "<b>Nama :</b> $value->nama <br/>";
						echo "<b>Pisa :</b> $value->pisa <br/>";
						echo "<b>Sex :</b> $value->sex <br/>";
						echo "<b>Tanggal Lahir :</b> ".date("d-m-Y", strtotime($value->tglLahir ))."<br/>";
						echo "<b>Tanggal Cetak Kartu :</b> ".date("d-m-Y", strtotime($value->tglCetakKartu ))." <br/>";
						$kdprovider=$value->provUmum->kdProvider;
						$nmProvider=$value->provUmum->nmProvider;
						$kdCabang=$value->provUmum->kdCabang;
						$nmCabang=$value->provUmum->nmCabang;
						echo '<br/><b>Kode Provider :</b> '.$kdprovider;
						echo '<br/><b>Nama Provider :</b> '.$nmProvider;
						echo '<br/><b>Kode Cabang :</b> '.$kdCabang;
						echo '<br/><b>Nama Cabang :</b> '.$nmCabang;
						$kdJenisPeserta=$value->jenisPeserta->kdJenisPeserta;
						$nmJenisPeserta=$value->jenisPeserta->nmJenisPeserta;
						
						echo '<br/><br/><b>Kode Jenis Peserta :</b> '.$kdJenisPeserta;
						echo '<br/><b>Jenis Peserta :</b> '.$nmJenisPeserta;
						$kdKelas=$value->kelasTanggungan->kdKelas;
						$nmKelas=$value->kelasTanggungan->nmKelas;
						echo '<br/><br/><b>Kode Kelas :</b> '.$kdKelas;
						echo '<br/><b>Nama Kelas :</b> '.$nmKelas;
						
						// print_r($value->jenisPeserta->nmJenisPeserta);
					};
				 }}else{
					echo "<div style=\"color:red;\">Pastikan Anda Terhubung Internet!!</div><br/>";
					echo "Tidak ditemukan no Kartu: <b>$no_kartu<b/>";
				 }
			}
		}
	}
}
?>
