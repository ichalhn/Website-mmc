 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
include('rjcterbilang.php');
include(dirname(dirname(__FILE__)).'/Tglindo.php');
class IrDPelayanan extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('ird/ModelPelayanan','',TRUE);
		$this->load->model('irj/rjmpelayanan','',TRUE);
		$this->load->model('ird/ModelRegistrasi','',TRUE);
		$this->load->model('lab/labmdaftar','',TRUE);
		$this->load->model('pa/pamdaftar','',TRUE);
		$this->load->model('rad/radmdaftar','',TRUE);
		$this->load->model('farmasi/Frmmdaftar','',TRUE);
		$this->load->model('farmasi/Frmmkwitansi','',TRUE);
		$this->load->helper('pdf_helper');
	}
	public function index()
	{
		redirect('ird/IrDRegistrasi');
	}
	public function kunj_pasien()
	{
		// echo $today = date("Y-m-d h:i:s");
		$data['pasien_daftar']=$this->ModelPelayanan->get_pasien_daftar_today()->result();
		// $get_nm_poli=$this->ModelPelayanan->get_nm_poli($id_poli)->result();//untuk nav
		// foreach($get_nm_poli as $row){
			// $data['id_poli']=$row->$id_poli;
		// }
		// $data['id_poli']=$id_poli;
		$data['title'] = 'List Pasien Instalasi Rawat Darurat';
		 
		//print_r($data);
		$this->load->view('ird/pasien_tindakan',$data);
	}
	public function kunj_pasien_tindakan_by_no()
	{
		$key=$this->input->post('key');
		//$id_poli=$this->input->post('id_poli');
		// $data['poliklinik']=$this->ModelRegistrasi->get_poli()->result();//untuk nav
		if($this->input->post('based')=='no_cm'){
			$data['pasien_daftar']=$this->ModelPelayanan->get_pasien_daftar_by_nocm($key)->result();
		}else{
			$data['pasien_daftar']=$this->ModelPelayanan->get_pasien_daftar_by_noregister($key)->result();
		}
		
		$data['title'] = 'Instalasi Rawat Darurat';
		 
		print_r($data);
		$this->load->view('ird/pasien_tindakan',$data);
	}
	public function kunj_pasien_tindakan_by_date()
	{
		$date=$this->input->post('date');
		
		$data['pasien_daftar']=$this->ModelPelayanan->get_pasien_daftar_by_date($date)->result();
		
		$data['title'] = 'Instalasi Rawat Darurat';
		 
		$this->load->view('ird/pasien_tindakan',$data);
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function pelayanan_batal($no_register='')
	{	
		$id=$this->ModelPelayanan->update_status_batal($no_register);
		redirect('ird/IrDPelayanan/kunj_pasien/');
		// echo "//change status daftar_ulang=C or cancel in char";
	}
	public function obj_tanggal(){
		 $tgl_indo = new Tglindo();
		 return $tgl_indo;
	}
	public function pelayanan_pasien($no_register='', $tab ='',$param3='',$param4='')
	{
		$data['controller']=$this; 
		$data['data_pasien_daftar_ulang']=$this->ModelPelayanan->getdata_daftar_ulang_pasien($no_register)->result();
		$data['data_tindakan_pasien']=$this->ModelPelayanan->getdata_tindakan_pasien($no_register)->result();
		$data['data_diagnosa_pasien']=$this->ModelPelayanan->getdata_diagnosa_pasien($no_register)->result();
		foreach($data['data_pasien_daftar_ulang'] as $row){
			$data['tindakan']=$this->ModelPelayanan->getdata_jenis_tindakan($row->kelas_pasien)->result();//untuk select
			$data['kelas_pasien']=$row->kelas_pasien;
			$data['tgl_kunjungan']=$row->tgl_kunjungan;
			$data['idrg']='IRD';			
			$no_medrec=$row->no_medrec;
			$data['no_medrec']=$row->no_medrec;
			$data['cara_bayar']=$row->cara_bayar;
			
		}		
		//print_r($data['data_pasien_daftar_ulang']);
		$data['dokter_rad']=$this->ModelPelayanan->getdata_dokter_rad()->result();
		$data['tindakan_rad']=$this->radmdaftar->getdata_tindakan_pasien()->result();		
		$data['data_tindakan_racikan']='';
		$data['bed']='Rawat Darurat';
		
		$data['a_obat']='a';
		$data['a_lab']='a';
		$data['a_pa']='a';
		$data['a_rad']='a';
		$data['a_ok']='a';
		$result=$this->ModelPelayanan->cek_lab_resep_rad_ok($no_register)->row();
		if ($result->lab=="0" || $result->status_lab=="1") {
			$data['a_lab'] = "closed";
		}
		if ($result->pa=="0" || $result->status_pa=="1") {
			$data['a_pa'] = "closed";
		}
		if ($result->obat=="0" || $result->status_obat=="1") {
			$data['a_obat'] = "closed";
		} 
		if ($result->rad=="0" || $result->status_rad=="1") {
			$data['a_rad'] = "closed";
		} 
		if ($result->ok=="0" || $result->status_ok=="1") {
			$data['a_ok'] = "closed";
		}
		//ambil data runjukan
		$data['list_lab_pasien']=$this->ModelPelayanan->getdata_lab_pasien($no_register)->result();	
		$data['cetak_lab_pasien']=$this->ModelPelayanan->getcetak_lab_pasien($no_register)->result();	
		$data['list_pa_pasien']=$this->ModelPelayanan->getdata_pa_pasien($no_register)->result();	
		$data['cetak_pa_pasien']=$this->ModelPelayanan->getcetak_pa_pasien($no_register)->result();		
		$data['list_rad_pasien']=$this->ModelPelayanan->getdata_rad_pasien($no_register)->result();	
		$data['cetak_rad_pasien']=$this->ModelPelayanan->getcetak_rad_pasien($no_register)->result();	
		$data['list_resep_pasien']=$this->rjmpelayanan->getdata_resep_pasien($no_register)->result();	
		$data['cetak_resep_pasien']=$this->rjmpelayanan->getcetak_resep_pasien($no_register)->result();
		$data['list_ok_pasien']=$this->ModelPelayanan->getdata_ok_pasien($no_register)->result();	
		// $data['cetak_ok_pasien']=$this->ModelPelayanan->getcetak_ok_pasien($no_register)->result();

		//print_r($result);//stdClass Object ( [lab] => 1 [status_lab] => 1 [obat] => 0 [status_obat] => 0 ) RD16000027
		//echo $no_register;
		$data['no_register']=$no_register;
		$data['diagnosa']=$this->ModelRegistrasi->get_data_diagnosa()->result();//untuk select
		//$data['diagnosa']=$this->ModelRegistrasi->get_data_diagnosa($no_)->result();//untuk select
		//$data['operator']=$this->ModelPelayanan->get_data_operator()->result();//untuk select
		$data['operator']=$this->ModelPelayanan->get_data_dokter()->result();//untuk select
		$data['rujukan_penunjang']=$this->ModelPelayanan->get_rujukan_penunjang($no_register)->result();
		//print_r($data['rujukan_penunjang']);//Array ( [0] => stdClass Object ( [lab] => 1 [rad] => 0 [obat] => 0 [status_lab] => 1 [status_obat] => 0 ) )
		$data['data_obat']=$this->Frmmdaftar->get_data_resep()->result();
		
		/*$data['data_pasien_pemeriksaan']=$this->labmdaftar->get_data_pasien_pemeriksaan($no_register)->result();
		foreach($data['data_pasien_pemeriksaan'] as $row){
			$data['nama']=$row->nama;
			$data['no_medrec']=$row->no_medrec;
			$data['kelas_pasien']=$row->kelas;
			$data['tgl_kun']=$row->tgl_kunjungan;
			$data['idrg']=$row->idrg;
			$data['bed']=$row->bed;
		}*/
		$data['data_pemeriksaan_rad']=$this->radmdaftar->get_data_pemeriksaan($no_register)->result();
		$data['data_pemeriksaan']=$this->labmdaftar->get_data_pemeriksaan($no_register,$no_medrec)->result();
		//$data['dokter_lab']=$this->labmdaftar->getdata_dokter()->result();
		//$data['dokter_lab']=$this->ModelPelayanan->getdata_dokter_lab()->result();
		//$data['tindakan_lab']=$this->labmdaftar->getdata_tindakan_pasien()->result();
		//$data['dokter_pa']=$this->ModelPelayanan->getdata_dokter_pa()->result();
		//$data['tindakan_pa']=$this->pamdaftar->getdata_tindakan_pasien()->result();

		/*$data['get_data_markup']=$this->Frmmdaftar->get_data_markup()->result();
		foreach($data['get_data_markup'] as $row){
			$data['kdmarkup']=$row->kodemarkup;
			$data['ketmarkup']=$row->ket_markup;
			$data['fmarkup']=$row->markup;
		}
		$data['ppn']=1.1;*/

		//Array ( [0] => stdClass Object ( [no_resep] => ) )
		
		if($param3==''){			
			if($this->ModelPelayanan->getdata_resep_pasien($no_register)->row()->no_resep!=''){
					$data['data_obat_pasien']=$this->ModelPelayanan->getdata_resep_pasien($no_register)->result();
				}else{
					$data['data_obat_pasien']='';
				}
		}else
			$data['data_obat_pasien']='';

		// if($this->ModelPelayanan->getdata_rad_pasien($no_register)->row()->no_rad!=''){
		// 	$data['data_rad_pasien']=$this->ModelPelayanan->getdata_rad_pasien($no_register)->result();
		// }else
		// 	$data['data_rad_pasien']='';
		
		$data['no_resep']='';$data['no_lab']='';$data['no_rad']='';
		//print_r($data['data_pasien_pemeriksaan']);
		$data['title'] = 'Instalasi Rawat Darurat';
		if ($tab=='' || $tab=='tindakan') {
			$data['tab_tindakan']="active";
			$data['tab_diagnosa']="";
			$data['tab_lab']="";
			$data['tab_pa']="";
			$data['tab_ok']="";
			$data['tab_rad']="";
			$data['tab_obat'] = 'active';
			$data['tab_racikan']  = '';
			$data['tab_resep']="";
			$data['tab_fisik']="";
		} else if ($tab==1)
		{
			$success = 	'
						<div class="content-header">
								<div class="alert alert-danger alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<h4>
									<i class="icon fa fa-check"></i>
									Diagnosa utama untuk no register "'.$no_register.'" sudah terdaftar.
									</h4>
								</div>
							
						</div>';
			$this->session->set_flashdata('success_msg', $success);
			
			$data['tab_tindakan']="";
			$data['tab_lab']="";
			$data['tab_pa']="";
			$data['tab_ok']="";
			$data['tab_rad']="";
			$data['tab_resep']="";
			$data['tab_diagnosa']="active";
			$data['tab_obat']="";
			$data['tab_racikan']="";
			$data['tab_fisik']="";
		} else if($tab=='lab'){
			// $no_lab=$param3;
			// if($no_lab!='')
			// {
			// 	$data['data_pemeriksaan']=$this->Labmdaftar->get_data_pasien_pemeriksaan($no_register)->result();										
			// 	$data['no_lab']=$no_lab;
			// }else {	if($this->ModelPelayanan->getdata_lab_pasien($no_register)->row()->no_lab!=''){
			// 		$data['data_pemeriksaan']=$this->ModelPelayanan->getdata_lab_pasien($no_register)->result();
			// 	}else{
			// 		$data['data_pemeriksaan']='';
			// 	}
			// }


			$data['tab_tindakan']="";
			$data['tab_lab']="active";
			$data['tab_pa']="";
			$data['tab_ok']="";
			$data['tab_resep']="";
			$data['tab_rad']="";
			$data['tab_obat']="";
			$data['tab_racikan']="";
			$data['tab_diagnosa']="";
			$data['tab_fisik']="";
		} else if($tab=='pa'){
			// $no_pa=$param3;
			// if($no_pa!='')
			// {
			// 	$data['data_pemeriksaan']=$this->pamdaftar->get_data_pasien_pemeriksaan($no_register)->result();										
			// 	$data['no_pa']=$no_pa;
			// }else {	if($this->ModelPelayanan->getdata_lab_pasien($no_register)->row()->no_lab!=''){
			// 		$data['data_pemeriksaan']=$this->ModelPelayanan->getdata_lab_pasien($no_register)->result();
			// 	}else{
			// 		$data['data_pemeriksaan']='';
			// 	}
			// }

			$data['tab_tindakan']="";
			$data['tab_lab']="";
			$data['tab_pa']="active";
			$data['tab_ok']="";
			$data['tab_resep']="";
			$data['tab_rad']="";
			$data['tab_obat']="";
			$data['tab_racikan']="";
			$data['tab_diagnosa']="";
			$data['tab_fisik']="";
		} else if($tab=='ok'){
			// $no_pa=$param3;
			// if($no_pa!='')
			// {
			// 	$data['data_pemeriksaan']=$this->pamdaftar->get_data_pasien_pemeriksaan($no_register)->result();										
			// 	$data['no_pa']=$no_pa;
			// }else {	if($this->ModelPelayanan->getdata_lab_pasien($no_register)->row()->no_lab!=''){
			// 		$data['data_pemeriksaan']=$this->ModelPelayanan->getdata_lab_pasien($no_register)->result();
			// 	}else{
			// 		$data['data_pemeriksaan']='';
			// 	}
			// }

			$data['tab_tindakan']="";
			$data['tab_lab']="";
			$data['tab_pa']="";
			$data['tab_ok']="active";
			$data['tab_resep']="";
			$data['tab_rad']="";
			$data['tab_obat']="";
			$data['tab_racikan']="";
			$data['tab_diagnosa']="";
			$data['tab_fisik']="";
		}
		else if($tab=='resep'){

			$no_resep=$param3;
			if($no_resep!='')
			{		

				$data['data_obat_pasien']=$this->Frmmdaftar->getdata_resep_pasien($no_register, $no_resep)->result();						
				$data['data_tindakan_racikan']=$this->Frmmdaftar->getdata_resep_racikan($no_resep)->result();
				$data['no_resep']=$no_resep;
			}else {	if($this->ModelPelayanan->getdata_resep_pasien($no_register)->row()->no_resep!=''){
					$data['data_obat_pasien']=$this->ModelPelayanan->getdata_resep_pasien($no_register)->result();
				}else{
					$data['data_obat_pasien']='';
				}
			}
			$data['tab_tindakan']="";
			$data['tab_lab']="";
			$data['tab_pa']="";
			$data['tab_ok']="";
			$data['tab_rad']="";			
			$data['tab_resep']="active";

			$data['tab_obat'] = 'active';
			$data['tab_racikan']  = '';
			if($param4!=''){
				$data['tab_obat'] = '';
				$data['tab_racikan'] = 'active';
			}
			
			$data['tab_diagnosa']="";
			$data['tab_fisik']="";
		}
		else if($tab=='rad'){

			// $no_rad=$param3;			
			// if($no_rad!='')
			// {		
			// 	$data['data_rad_pasien']=$this->radmdaftar->get_data_pemeriksaan($no_register)->result();
			// 	$data['no_rad']=$no_rad;
			// }else{
			// 	//$data['data_rad_pasien']=$this->ModelPelayanan->getdata_resep_pasien($no_register)->result();
			// 	if($this->ModelPelayanan->getdata_rad_pasien($no_register)->row()->no_rad!=''){
			// 		$data['data_rad_pasien']=$this->ModelPelayanan->getdata_rad_pasien($no_register)->result();
			// 	}else{
			// 		$data['data_rad_pasien']='';
			// 	}
				
			// }
			$data['tab_tindakan']="";
			$data['tab_lab']="";
			$data['tab_pa']="";
			$data['tab_ok']="";
			$data['tab_rad']="active";			
			$data['tab_resep']="";
			$data['tab_diagnosa']="";
			$data['tab_obat'] = '';
			$data['tab_racikan']  = '';
			$data['tab_fisik']="";
		}
		else
		{	
			$data['tab_tindakan']="";
			$data['tab_lab']="";
			$data['tab_pa']="";
			$data['tab_ok']="";
			$data['tab_resep']="";
			$data['tab_rad']="";
			$data['tab_diagnosa']="active";	
			$data['tab_obat'] = '';
			$data['tab_racikan']  = '';
			$data['tab_fisik']="";
		}

		$data['data_fisik']=$this->ModelPelayanan->getdata_tindakan_fisik($no_register)->row();
		if ($data['data_fisik']==FALSE) {
			$data['td']='';
			$data['bb']='';
			$data['tb']='';
			$data['nadi']='';
			$data['suhu']='';
			$data['rr']='';
			$data['ku']='';
			$data['catatan']='';
		} else {
			$data['td']=$data['data_fisik']->td;
			$data['bb']=$data['data_fisik']->bb;
			$data['tb']=$data['data_fisik']->tb;
			$data['nadi']=$data['data_fisik']->nadi;
			$data['suhu']=$data['data_fisik']->suhu;
			$data['rr']=$data['data_fisik']->rr;
			$data['ku']=$data['data_fisik']->ku;
			$data['catatan']=$data['data_fisik']->catatan;
		}

		if ($data['data_fisik']==FALSE) {
			$data['tab_fisik']="active";
			$data['tab_tindakan']="";
			$data['tab_lab']="";
			$data['tab_pa']="";
			$data['tab_ok']="";
			$data['tab_resep']="";
			$data['tab_rad']="";
			$data['tab_diagnosa']="";	
			$data['tab_obat'] = '';
			$data['tab_racikan']  = '';
		} 
		
		$this->load->view('ird/form_pelayanan',$data);
		
	}

	public function insert_fisik()
	{
		// $id_poli=$this->input->post('id_poli');
		$no_register=$this->input->post('no_register');
		$td=$this->input->post('td');
		$bb=$this->input->post('bb');
		$tb=$this->input->post('tb');
		$nadi=$this->input->post('nadi');
		$suhu=$this->input->post('suhu');
		$rr=$this->input->post('rr');
		$ku=$this->input->post('ku');
		$catatan=$this->input->post('catatan');

		$data_fisik=$this->ModelPelayanan->getdata_tindakan_fisik($no_register)->row();
		if ($data_fisik==FALSE) {
			$data['no_register'] = $no_register;
			$data['td'] = $td;
			$data['bb'] = $bb;
			$data['tb'] = $tb;
			$data['nadi'] = $nadi;
			$data['suhu'] = $suhu;
			$data['rr'] = $rr;
			$data['ku'] = $ku;
			$data['catatan'] = $catatan;
	 		$id=$this->ModelPelayanan->insert_data_fisik($data);
			//INSERT
		} else {
			$data['td'] = $td;
			$data['bb'] = $bb;
			$data['tb'] = $tb;
			$data['nadi'] = $nadi;
			$data['suhu'] = $suhu;
			$data['rr'] = $rr;
			$data['ku'] = $ku;
			$data['catatan'] = $catatan;
	 		$this->ModelPelayanan->update_data_fisik($no_register, $data);
			// UPDATE
		}
		//print_r($data);
		redirect('ird/IrDPelayanan/pelayanan_pasien/'.$no_register);
		// redirect('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register);
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function pelayanan_diagnosa($no_register='')
	{
		$data['data_pasien_daftar_ulang']=$this->ModelPelayanan->getdata_daftar_ulang_pasien($no_register)->result();
		
		$data['data_diagnosa_pasien']=$this->ModelPelayanan->getdata_diagnosa_pasien($no_register)->result();
		$data['diagnosa']=$this->ModelRegistrasi->get_data_diagnosa()->result();//untuk select
		// $data['id_poli']=$id_poli;
		$data['activetabD']='active';
		$data['no_register']=$no_register;
		$data['title'] = 'Instalasi Rawat Darurat';
		 
		$this->load->view('ird/form_diagnosa',$data);
		// echo "goto form";
	}
	public function pelayanan_lab($no_register='')
	{
		$data['rujukan_penunjang']=$this->ModelPelayanan->get_rujukan_penunjang($no_register)->result();
		$data['data_pasien_daftar_ulang']=$this->ModelPelayanan->getdata_daftar_ulang_pasien($no_register)->result();
		
		$data['no_register']=$no_register;
		$data['title'] = 'Lab Instalasi Rawat Darurat';
		 
		$this->load->view('ird/form_lab',$data);
		// echo "goto form";
	}
	public function pelayanan_pa($no_register='')
	{
		$data['rujukan_penunjang']=$this->ModelPelayanan->get_rujukan_penunjang($no_register)->result();
		$data['data_pasien_daftar_ulang']=$this->ModelPelayanan->getdata_daftar_ulang_pasien($no_register)->result();
		
		$data['no_register']=$no_register;
		$data['title'] = 'Pa Instalasi Rawat Darurat';
		 
		//$this->load->view('ird/form_lab',$data);
		// echo "goto form";
	}
	public function pelayanan_resep($id_poli='',$no_register='')
	{
		$data['data_pasien_daftar_ulang']=$this->ModelPelayanan->getdata_daftar_ulang_pasien($no_register)->result();
		$data['data_resep_pasien']=$this->ModelPelayanan->getdata_resep_pasien($no_register)->result();
		// $data['poliklinik']=$this->ModelRegistrasi->get_poli()->result();//untuk nav
		// $data['id_poli']=$id_poli;
		$data['no_register']=$no_register;
		$data['title'] = 'Instalasi Rawat Darurat';
		 
		$this->load->view('ird/form_resep',$data);
		// echo "goto form";
	}

	public function search_biaya($idtindakan)
	{
		$data['biaya']=$this->ModelPelayanan->getdata_biaya_idtindakan($idtindakan)->result();
		$data['title'] = 'Instalasi Rawat Darurat';
		 		
		// echo "goto form";
	}
	////////////////////////////////////////////////////////////////////////////////
	public function insert_pelayanan_tindakan()
	{		
		date_default_timezone_set("Asia/Jakarta");

		$data['no_register']=$this->input->post('no_register');
		$no_register=$this->input->post('no_register');
		//$data['data_pasien_daftar_ulang']=$this->ModelPelayanan->getdata_daftar_ulang_pasien($no_register)->result();
		$data['tgl_kunjungan']=$this->input->post('tgl_kunjung');
		$diagnosa = explode("@", $this->input->post('diagnosa'));

		$tindakan = explode("@", $this->input->post('idtindakan'));
		$data['idtindakan']=$tindakan[0];
		//$data['nmtindakan']=$tindakan[1];

			if($this->input->post('dokterTindakan')!=''){
			$dokter = explode("@", $this->input->post('dokterTindakan'));
			$data['id_dokter']=$dokter[0];
			//$data['nm_dokter']=$dokter[1];
			}
		
		if($this->input->post('dokterAsisTindakan')!=''){
			$dokter = explode("@", $this->input->post('dokterAsisTindakan'));
			$data['id_asist_dokter']=$dokter[0];
		}

		if($this->input->post('penataAnasTindakan')!=''){
			$dokter = explode("@", $this->input->post('penataAnasTindakan'));
			$data['id_penata_anas']=$dokter[0];
		}
		if($this->input->post('dokterAnasTindakan')!=''){
			$dokter = explode("@", $this->input->post('dokterAnasTindakan'));
			$data['id_dokter_anas']=$dokter[0];
		}
		if($this->input->post('instrumenTindakan')!=''){
			$dokter = explode("@", $this->input->post('instrumenTindakan'));
			$data['id_instrumen_dokter']=$dokter[0];
		}
		if($this->input->post('dokterAnakTindakan')!=''){
			$dokter = explode("@", $this->input->post('dokterAnakTindakan'));
			$data['id_dokter_anak']=$dokter[0];
		}

		$data['biaya_ird']=$this->input->post('biaya_tindakan_hide');
		$data['biaya_alkes']=$this->input->post('biaya_alkes_hide');
		$data['qty']=$this->input->post('qtyind');
		$data['vtot']=$this->input->post('vtot_hide');
		$vtottind=$this->input->post('vtot_hide');
		
		$vtotird=$this->ModelPelayanan->get_vtot_daful($no_register)->row()->vtot;

		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xuser']=$user;
		$data['xupdate']=date("Y-m-d H:i:s");
		//$data['xuser']=$this->input->post('user_name');

		$id=$this->ModelPelayanan->insert_pelayanan_tindakan($data);
		print_r($id);
		$id= $this->ModelPelayanan->update_vtot_daful($no_register, $vtottind + $vtotird);
		
		//$vtottind + $vtotird;		
		//$data['vtot'] update_vtot_daful($no_register,$vtot)
		//print_r($vtottind + $vtotird);
		//print_r($vtottind );
		//print_r($data);
		redirect('ird/IrDPelayanan/pelayanan_pasien/'.$data['no_register']);
	}
	//RADIOLOGI
	/////////////////////////////////////////////////////////////////////////////////////////////
	public function insert_rad()
	{
		$data['no_register']=$this->input->post('no_register');
		$data['no_medrec']=$this->input->post('no_medrec');
		$data['id_tindakan']=$this->input->post('idtindakan');
		$data['kelas']=$this->input->post('kelas_pasien');
		$data['tgl_kunjungan']=$this->input->post('tgl_kunj');
		$data_tindakan=$this->radmdaftar->getjenis_tindakan($data['id_tindakan'])->result();
		foreach($data_tindakan as $row){
			$data['jenis_tindakan']=$row->nmtindakan;
		}
		$data['qty']=$this->input->post('qty_rad');
		
		$data['id_dokter']=$this->input->post('id_dokter');
		
		/*$data_pasien_daftar_ulang=$this->ModelPelayanan->getdata_daftar_ulang_pasien($data['no_register'])->result();
		foreach($data_pasien_daftar_ulang as $row){
			$data['id_dokter']=$row->id_dokter;
		}*/
		$data_dokter=$this->labmdaftar->getnama_dokter($data['id_dokter'])->result();
		foreach($data_dokter as $row){
			$data['nm_dokter']=$row->nm_dokter;
		}
		$data['biaya_rad']=$this->input->post('biaya_rad_hide');
		$data['vtot']=$this->input->post('vtot_rad_hide');
		$data['idrg']=$this->input->post('idrg');
		$data['bed']=$this->input->post('bed');
		$data['cara_bayar']=$this->input->post('cara_bayar');
		$data['no_rad']=$this->input->post('no_rad');

		if($data['no_rad']!=''){
		} else {
			$this->radmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
			$data['no_rad']=$this->radmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_rad;
		}

		$this->radmdaftar->insert_pemeriksaan($data);
		
		redirect('ird/IrDPelayanan/pelayanan_pasien/'.$data['no_register'].'/rad/'.$data['no_rad']);
		//print_r($data);
	}

	public function selesai_daftar_rad($no_register='')
	{
		$getvtotrad=$this->radmdaftar->get_vtot_rad($no_register)->row()->vtot_rad;
		$getrdrj=substr($no_register, 0,2);
		if ($getrdrj=="RD"){
			$this->radmdaftar->selesai_daftar_pemeriksaan_IRD($no_register,$getvtotrad);
		}

		redirect('ird/IrDPelayanan/pelayanan_pasien/'.$no_register.'/rad');
		//print_r($getvtotrad);
	}

	public function hapus_data_rad($no_register='',$no_rad='', $id_pemeriksaan_rad='')
	{
		$id=$this->radmdaftar->hapus_data_pemeriksaan($id_pemeriksaan_rad);

		redirect('ird/IrDPelayanan/pelayanan_pasien/'.$no_register.'/rad/'.$no_rad);
		
		//print_r($id);
	}	
	////////////////////////////////////////////////////////////////////////////////////////////
	public function insert_pelayanan_diagnosa()
	{
		date_default_timezone_set("Asia/Jakarta");
		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xuser']=$user;
		$data['xupdate']=date("Y-m-d H:i:s");

		$data['no_register']=$this->input->post('no_register');
		
		$diagnosa = explode("@", $this->input->post('jenis_diagnosa'));
		//print_r($diagnosa);
		$data['id_diagnosa']=$diagnosa[0];
		$data['diagnosa']=$diagnosa[1];

		$data['klasifikasi_diagnos']=$this->input->post('klasifikasi');
		if ($data['klasifikasi_diagnos']=="utama") 
		{
		 if($this->ModelPelayanan->cek_diagnosa_utama($data['no_register'])->num_rows()>0){
			$tab=1;
		 	redirect('ird/IrDPelayanan/pelayanan_pasien/'.$data['no_register'].'/'.$tab);
		 }else {
		 	$id=$this->ModelPelayanan->insert_pelayanan_diagnosa($data);
			//print_r($data);
			$tab="diagnosa";
			redirect('ird/IrDPelayanan/pelayanan_pasien/'.$data['no_register'].'/'.$tab);
		 }
		}
		else{
			$id=$this->ModelPelayanan->insert_pelayanan_diagnosa($data);
			//print_r($data);
			$tab="diagnosa";
			redirect('ird/IrDPelayanan/pelayanan_pasien/'.$data['no_register'].'/'.$tab);
		}

		//$data['diagnosa']=$this->ModelPelayanan->get_nm_diagnosa($this->input->post('id_diagnosa'))->result();		
				
		
	}
	
	public function insert_pemeriksaan()
	{
		$data['no_register']=$this->input->post('no_register');
		$data['no_medrec']=$this->input->post('no_medrec');
		$data['id_tindakan']=$this->input->post('idtindakan');
		$data['kelas']=$this->input->post('kelas_pasien');
		$data['tgl_kunjungan']=$this->input->post('tgl_kunj');
		$data['idrg']=$this->input->post('idrg');
		$data['bed']=$this->input->post('bed');
		$data['no_lab']=$this->input->post('no_lab');

		$data_tindakan=$this->labmdaftar->getjenis_tindakan($data['id_tindakan'])->result();
		foreach($data_tindakan as $row){
			$data['jenis_tindakan']=$row->nmtindakan;
		}
		$data['qty']=$this->input->post('qtyLab');
		/*$data_pasien_daftar_ulang=$this->ModelPelayanan->getdata_daftar_ulang_pasien($data['no_register'])->result();
		foreach($data_pasien_daftar_ulang as $row){
			$data['id_dokter']=$row->id_dokter;
		}*/
		$data['id_dokter']=$this->input->post('id_dokter');
		$data_dokter=$this->labmdaftar->getnama_dokter($data['id_dokter'])->result();
		foreach($data_dokter as $row){
			$data['nm_dokter']=$row->nm_dokter;
		}
		$data['biaya_lab']=$this->input->post('biaya_lab_hide');
		$data['vtot']=$this->input->post('vtot_lab_hide');
		

		if($data['no_lab']!=''){


		} else {
			$this->labmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
			$data['no_lab']=$this->labmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_lab;
		}
		//print_r($data);
		$this->labmdaftar->insert_pemeriksaan($data);
		
		redirect('ird/IrDPelayanan/pelayanan_pasien/'.$data['no_register'].'/lab/'.$data['no_lab']);	
	//redirect('lab/labcdaftar/pemeriksaan_lab/'.$data['no_register'].'/'.$data['no_lab']);
		//print_r($data);
	}
	
	public function insert_resep()
	{
		//$id_pemeriksaan_lab=$this->input->post('id_poli');
		//$data['no_slip']=$this->input->post('no_slip');
		
		$data['no_register']=$this->input->post('no_register');
		$data['no_medrec']=$this->input->post('no_medrec');
		$data['tgl_kunjungan']=$this->input->post('tgl_kunjungan');
		$data['item_obat']=$this->input->post('obat');
		$data_tindakan=$this->Frmmdaftar->getitem_obat($data['item_obat'])->result();
		foreach($data_tindakan as $row){
			$data['nama_obat']=$row->nm_obat;
			$data['Satuan_obat']=$row->satuank;
		}
		$data_pasien_daftar_ulang=$this->ModelPelayanan->getdata_daftar_ulang_pasien($data['no_register'])->result();
		foreach($data_pasien_daftar_ulang as $row){
			$data['cara_bayar']=$row->cara_bayar;
			$data['id_dokter']=$row->id_dokter;
		}		

		$data_dokter=$this->labmdaftar->getnama_dokter($data['id_dokter'])->result();
		foreach($data_dokter as $row){
			$data['nm_dokter']=$row->nm_dokter;
		}

		$data['idrg']=$this->input->post('idrg');
		$data['bed']=$this->input->post('bed');
		$data['no_resep']=$this->input->post('no_resep');
		$data['qty']=$this->input->post('qtyResep');
		$data['Signa']=$this->input->post('signa');
		$data['kelas']=$this->input->post('kelas_pasien');
		$data['biaya_obat']=$this->input->post('biaya_obat_hide');
		$data['vtot']=$this->input->post('vtot_resep_hide');

		if($data['no_resep']!=''){
		} else {
			$this->Frmmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas_pasien']);
		$data['no_resep']=$this->Frmmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas_pasien'])->row()->no_resep;
		}
		

		$this->Frmmdaftar->insert_permintaan($data);		
		
		redirect('ird/IrDPelayanan/pelayanan_pasien/'.$data['no_register'].'/resep/'.$data['no_resep']);
		//	print_r($data);
	}

	public function selesai_daftar_obat($no_register='',$no_resep='')
	{		
		$rujukan_penunjang=$this->ModelPelayanan->get_rujukan_penunjang($no_register)->result();
		//print_r($rujukan_penunjang);
		
		foreach($rujukan_penunjang as $row)
		{
			if($row->obat=='1' and $row->status_obat=='1'){
				
				redirect('ird/IrDPelayanan/pelayanan_pasien/'.$no_register.'/resep');
			}else{
			 //$no_register=$this->input->post('no_register');
			 $getvtotobat=$this->Frmmdaftar->get_vtot_obat($no_register)->row()->vtot_obat;
		
			 $this->Frmmdaftar->selesai_daftar_pemeriksaan_IRD($no_register,$getvtotobat);
			 $data['obat']='1';
			 $data['status_obat']='1';
			 $id=$this->ModelPelayanan->update_rujukan_penunjang($data,$no_register);
			 //echo $id;
			 //print_r($id);		
			 echo '<script type="text/javascript">window.open("'.site_url("ird/IrDPelayanan/cetak_kwitansi_kt/$no_resep").'", "_blank");window.focus()</script>';

			 redirect('ird/IrDPelayanan/pelayanan_pasien/'.$no_register.'/resep/'.$no_resep,'refresh');
			}
		}
		
		
		
	}

	public function hapus_data_resep($no_register='', $id_resep_pasien='')
	{
		
		$id=$this->Frmmdaftar->hapus_data_pemeriksaan($id_resep_pasien);

		$no_resep=$this->ModelPelayanan->get_no_resep($id_resep_pasien)->row();
		
		redirect('ird/IrDPelayanan/pelayanan_pasien/'.$no_register.'/resep/'.$no_resep);
		
		//print_r($id);
	}

	public function insert_racikan_selesai()
	{
		//$id_pemeriksaan_lab=$this->input->post('id_poli');
		//$data['no_slip']=$this->input->post('no_slip');
		
		$data['no_register']=$this->input->post('no_register');
		$data['no_medrec']=$this->input->post('no_medrec');
		$data['tgl_kunjungan']=$this->input->post('tgl_kun');
		$data['idrg']=$this->input->post('idrg');
		$data['cara_bayar']=$this->input->post('cara_bayar');
		$data['bed']=$this->input->post('bed');
		$data['no_resep']=$this->input->post('no_resep');
		$data['qty']=$this->input->post('qty1');
		$data['Signa']=$this->input->post('signa');
		$data['kelas']=$this->input->post('kelas_pasien');
		//$data['biaya_obat']=$this->input->post('biaya_obat_hide');//sum dari db
		$data['fmarkup']=$this->input->post('fmarkup');// dari db
		$data['ppn']=1.1;
		$data['vtot']=$this->input->post('vtot_x_hide');
		$data['nama_obat']=$this->input->post('racikan');
		$data['racikan']='1';
		$data_biaya_racik=$this->Frmmdaftar->getbiaya_obat_racik($data['no_resep'])->result();
		foreach($data_biaya_racik as $row){
			$data['biaya_obat']=$row->total;
		}

		if($data['no_resep']!=''){
		} else {
			$this->Frmmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
			$data['no_resep']=$this->Frmmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_resep;
		}

		$this->Frmmdaftar->insert_permintaan($data);
		$id_resep_pasien=$this->Frmmdaftar->get_id_resep($data['no_resep'],$data['nama_obat'])->row()->id_resep_pasien;
		$this->Frmmdaftar->update_racikan($data['no_resep'], $id_resep_pasien);
		
		redirect('ird/IrDPelayanan/pelayanan_pasien/'.$data['no_register'].'/resep/'.$data['no_resep']);
		//print_r($data);
	}

	public function insert_racikan()
	{
		//$id_pemeriksaan_lab=$this->input->post('id_poli');
		//$data['no_slip']=$this->input->post('no_slip');
		
		$data['no_register']=$this->input->post('no_register');
		$data['no_medrec']=$this->input->post('no_medrec');
		$data['item_obat']=$this->input->post('idracikan');
		$data['idrg']=$this->input->post('idrg');
		$data['kelas']=$this->input->post('kelas_pasien');
		$data['bed']=$this->input->post('bed');
		$data_tindakan=$this->Frmmdaftar->getitem_obat($data['item_obat'])->result();
		foreach($data_tindakan as $row){
			$data['nama_obat']=$row->nm_obat;
			$data['Satuan_obat']=$row->satuank;
		}
		$data['qty']=$this->input->post('qty_racikan');
		$data['no_resep']=$this->input->post('no_resep');

		if($data['no_resep']!=''){
		} else {
			$this->Frmmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
			$data['no_resep']=$this->Frmmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_resep;
		}
		
		$this->Frmmdaftar->insert_racikan($data['item_obat'],$data['qty'],$data['no_resep']);
		
		redirect('ird/IrDPelayanan/pelayanan_pasien/'.$data['no_register'].'/resep/'.$data['no_resep'].'/racik');
			print_r($data);
	}

	public function hapus_data_racikan($no_register='', $no_resep='', $item_obat='', $id_resep_pasien='')
	{
		$id=$this->Frmmdaftar->hapus_data_racikan($item_obat, $id_resep_pasien);

		redirect('ird/IrDPelayanan/pelayanan_pasien/'.$no_register.'/resep/'.$no_resep.'/racik');
		
		//print_r($id);
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////
		public function data_tindakan(){
			// tangkap variabel keyword dari URL
			$keyword = $this->uri->segment(3);
			// cari di database
			$data = $this->db->from('jenis_tindakan')->like('nmtindakan',$keyword)->get()->result();	

			// format keluaran di dalam array
			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->nmtindakan,
					'idtindakan'	=>$row->idtindakan,
					'nmtindakan'	=>$row->nmtindakan
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}
		public function data_operator(){
			// tangkap variabel keyword dari URL
			$keyword = $this->uri->segment(3);
			// cari di database
			$data = $this->db->from('operator')->like('nm_dokter',$keyword)->get()->result();	

			// format keluaran di dalam array
			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->nm_dokter,
					'id_dokter'	=>$row->id_dokter,
					'nm_dokter'	=>$row->nm_dokter
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}
		public function data_diagnosa(){
			// tangkap variabel keyword dari URL
			$keyword = $this->uri->segment(3);
			// cari di database
			$data = $this->db->from('icd10')->like('sub_diagnosa',$keyword)->get()->result();	

			// format keluaran di dalam array
			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=>$row->sub_diagnosa,
					'id'	=>$row->id,
					'sub_diagnosa'	=>$row->sub_diagnosa
				);
			}
			// minimal PHP 5.2
			echo json_encode($arr);
		}
	//////////////////////////////////////////////////////////////////////////////////////////////////
	public function update_pulang()
	{	
		$no_register=$this->input->post('no_register');
		if($this->input->post('tgl_kontrol')!=''){
			$data['tgl_kontrol']=$this->input->post('tgl_kontrol');
		}
		$data['tgl_pulang']=$this->input->post('tgl_pulang');
		$data['ket_pulang']=$this->input->post('ket_pulang');
		/*if($this->input->post('labCheckbox')==""){
			$data['lab']='0';
		}
		else $data['lab']=$this->input->post('labCheckbox');
		if($this->input->post('radCheckbox')==""){
			$data['rad']='0';
		}
		else $data['rad']=$this->input->post('radCheckbox');
		if($this->input->post('obatCheckbox')==""){
			$data['obat']='0';
		}
		else $data['obat']=$this->input->post('obatCheckbox');*/
		//print_r($data);
		$id=$this->ModelPelayanan->update_pulang($data,$no_register);
		$id=$this->ModelPelayanan->update_status_selesai($no_register);//kerana sebelumnya ada fungsi
		redirect('ird/IrDPelayanan/kunj_pasien/');
	}
	//////////////////////////////////////////////////////////////////////////////////////////////
	public function update_tindakan()
	{
		// echo "goto detail";
		$id_poli=$this->input->post('id_poli');
		$no_register=$this->input->post('no_register');
		$id_pelayanan_poli=$this->input->post('id_pelayanan_poli2');
		$data['idtindakan']=$this->input->post('idtindakan2');
		$data['nmtindakan']=$this->input->post('nmtindakan2');
		$data['id_dokter']=$this->input->post('id_dokter2');
		$data['nm_dokter']=$this->input->post('nm_dokter2');
		$data['biaya_poli']=$this->input->post('biaya_poli2');
		$data['qtyind']=$this->input->post('qtyind2');
		$data['dijamin']=$this->input->post('dijamin2');
		$data['vtot']=$this->input->post('vtot2');
		$id=$this->ModelPelayanan->update_pelayanan_poli($data,$id_pelayanan_poli);//kerana sebelumnya ada fungsi
		redirect('ird/IrDPelayanan/pelayanan_pasien/'.$id_poli.'/'.$no_register);
	}
	public function hapus_antrian($no_register)
	{						
		//$no_register=$this->ModelPelayanan->get_no_register_tindakan($id_tindakan_ird)->row()->no_register;
				
		$id=$this->ModelPelayanan->hapus_antrian($no_register);
		//print_r($id);		
		redirect('ird/IrDPelayanan/kunj_pasien/');
	}
	public function rujukan_penunjang()
	{	
				
		//$no_register=$this->ModelPelayanan->get_no_register_tindakan($id_tindakan_ird)->row()->no_register;
		$no_register=$this->input->post('no_register');
		$rujukan_penunjang=$this->ModelPelayanan->get_rujukan_penunjang($no_register)->result();
		foreach($rujukan_penunjang as $row){
			if($row->ok!='1'){
				if($this->input->post('okCheckbox')==""){
					$data['ok']='0';
					$data['status_ok']='0';
				}
				else {
					$data['ok']=$this->input->post('okCheckbox');
					$data['status_ok']='0';		
				}
			}
			if($row->lab!='1'){
				if($this->input->post('labCheckbox')==""){
					$data['lab']='0';
					$data['status_lab']='0';
				}
				else {
					$data['lab']=$this->input->post('labCheckbox');
					$data['status_lab']='0';		
				}
			}
			if($row->pa!='1'){
				if($this->input->post('paCheckbox')==""){
					$data['pa']='0';
					$data['status_pa']='0';
				}
				else {
					$data['pa']=$this->input->post('paCheckbox');
					$data['status_pa']='0';		
				}
			}
			if($row->rad!='1'){
				//echo $this->input->post('radCheckbox');
				if($this->input->post('radCheckbox')==""){
					$data['rad']='0';
					$data['status_rad']='0';
				}
				else {
					$data['rad']=$this->input->post('radCheckbox');
					$data['status_rad']='0';
				}

				
			}
			if($row->obat!='1'){
				if($this->input->post('obatCheckbox')==""){
					$data['obat']='0';
					$data['status_obat']='0';
				}else {
					$data['obat']=$this->input->post('obatCheckbox');
					$data['status_obat']='0';
				}
			}
		}
		
		print_r($data);	
		$id=$this->ModelPelayanan->update_rujukan_penunjang($data,$no_register);
			
		redirect('ird/IrDPelayanan/pelayanan_pasien/'.$no_register);
	}
	public function hapus_tindakan($id_tindakan_ird)
	{						
		$no_register=$this->ModelPelayanan->get_no_register_tindakan($id_tindakan_ird)->row()->no_register;
						
		$vtottind=$this->ModelPelayanan->get_vtot_tindakan($id_tindakan_ird)->row()->vtot;
		
		$vtotird=$this->ModelPelayanan->get_vtot_daful($no_register)->row()->vtot;

		//print_r($vtotird - $vtottind);
		$id= $this->ModelPelayanan->update_vtot_daful($no_register, ($vtotird - $vtottind));
		//print_r($no_register);		
		$id=$this->ModelPelayanan->hapus_tindakan($id_tindakan_ird);
		redirect('ird/IrDPelayanan/pelayanan_pasien/'.$no_register);
	}
	public function hapus_diagnosa($id_diagnosa_pasien)
	{
		$no_register=$this->ModelPelayanan->get_no_register_diagnosa($id_diagnosa_pasien)->row()->no_register;
				
		$id=$this->ModelPelayanan->hapus_diagnosa($id_diagnosa_pasien);
		
		//print_r($no_register);		
		redirect('ird/IrDPelayanan/pelayanan_pasien/'.$no_register);
	}
	public function hapus_data_pemeriksaan($no_register='', $no_lab='', $id_pemeriksaan_lab='')
	{
		$id=$this->labmdaftar->hapus_data_pemeriksaan($id_pemeriksaan_lab);

		redirect('ird/IrDPelayanan/pelayanan_pasien/'.$no_register.'/lab/'.$no_lab);
		
		//print_r($id);
	}
	public function update_diagnosa()
	{
		// echo "goto detail";
		$id_poli=$this->input->post('id_poli');
		$no_register=$this->input->post('no_register');
		$id_diagnosa_pasien=$this->input->post('id_diagnosa_pasien2');
		$data['id_diagnosa']=$this->input->post('id_diagnosa2');
		$data['diagnosa']=$this->input->post('diagnosa2');
		$data['id_dokter']=$this->input->post('id_dokter2');
		$data['nm_dokter']=$this->input->post('nm_dokter2');
		$data['tindakan']=$this->input->post('tindakan2');
		$data['klasifikasi_diagnos']=$this->input->post('klasifikasi_diagnos2');
		$data['kasus']=$this->input->post('kasus2');
		$id=$this->ModelPelayanan->update_pelayanan_diagnosa($data,$id_diagnosa_pasien);//kerana sebelumnya ada fungsi
		redirect('ird/IrDPelayanan/pelayanan_diagnosa/'.$id_poli.'/'.$no_register);
	}
	public function update_resep()
	{
		// echo "goto detail";
		$id_poli=$this->input->post('id_poli');
		$no_register=$this->input->post('no_register');
		$id_resep_irj=$this->input->post('id_resep_irj2');
		$data['id_dokter']=$this->input->post('id_dokter2');
		$data['nm_dokter']=$this->input->post('nm_dokter2');
		$data['resep']=$this->input->post('resep2');
		$id=$this->ModelPelayanan->update_pelayanan_resep($data,$id_resep_irj);//kerana sebelumnya ada fungsi
		redirect('ird/IrDPelayanan/pelayanan_resep/'.$id_poli.'/'.$no_register);
	}
	public function update_vtot()
	{		
		$id_poli=$this->input->post('id_poli');
		$no_register=$this->input->post('no_register');
		$id_resep_irj=$this->input->post('id_resep_irj2');
		$data['id_dokter']=$this->input->post('id_dokter2');
		$data['nm_dokter']=$this->input->post('nm_dokter2');
		$data['resep']=$this->input->post('resep2');
		$id=$this->ModelPelayanan->update_pelayanan_resep($data,$id_resep_irj);//kerana sebelumnya ada fungsi
		redirect('ird/IrDPelayanan/pelayanan_resep/'.$id_poli.'/'.$no_register);
	}
	public function get_data_tindakan()
	{
		$no_register=$this->input->post('no_register');
		//$kelas=$this->input->post('kelas');
		$datatind=$this->ModelPelayanan->getdata_tindakan_pasien($no_register)->result();
		//echo json_encode($kelas);
		echo json_encode($datatind);
	}
	public function get_biaya_tindakan()
	{
		$id_tindakan=$this->input->post('id_tindakan');
		$kelas=$this->input->post('kelas');
		$biaya=array();
		$result=$this->ModelPelayanan->get_biaya_tindakan($id_tindakan,$kelas)->row();
		$biaya[0]=$result->total_tarif;
		$biaya[1]=$result->tarif_alkes;
		
		//echo json_encode($kelas);
		echo json_encode($biaya);
	}
	/////////////////////////////////////////////////////////
	
	public function cetak_kwitansi_kt($no_resep='')
	{
		if($no_resep!=''){
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

			// $data_rs=$this->Frmmkwitansi->get_data_rs('10000')->result();
			// 	foreach($data_rs as $row){
			// 		$namars=$row->namars;
			// 		$kota_kab=$row->kota;
			// 		$alamat=$row->alamat;
			// 	}
			$namars=$this->config->item('namars');
			$alamat=$this->config->item('alamat');
			$kota_kab=$this->config->item('kota');
			
			$data_pasien=$this->Frmmkwitansi->get_data_pasien($no_resep)->result();
				foreach($data_pasien as $row){
					$nama=$row->nama;
					$sex=$row->sex;
					$goldarah=$row->goldarah;
					$no_register=$row->no_register;
					$no_medrec=$row->no_medrec;
					$idrg=$row->idrg;
					$bed=$row->bed;
					$cara_bayar=$row->cara_bayar;
				}
			
										
			$nmruang="";
			$data_permintaan=$this->Frmmkwitansi->get_data_permintaan($no_resep)->result();
			
			

			/*$data_tindakan=$this->rjmkwitansi->getdata_tindakan_pasien($no_register)->result();
			$vtot=0;
			foreach($data_tindakan as $row1){
				$vtot=$vtot+$row1->biaya_tindakan;
			}
			*/
			
		
			$konten=
					"<table>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><br><b>FAKTUR PERMINTAAN OBAT</b></p></td>
					
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><b>No. SKT. FRM_$no_resep</b><br></p></td>
							</tr>
						</table>
					
					<table>
						<tr >
							<td ><p align=\"left\" ><b>Tanggal-Jam: $tgl_jam</b></p></td>
							
						</tr>						
					</table>
					
					<table>
						<tr>
							<td width=\"20%\"><b>No. Registrasi</b></td>
							<td width=\"3%\"> : </td>
							<td>$no_register</td>
							<td width=\"15%\"> </td>

							<td width=\"15%\"><b>No. Medrec</b></td>
							<td width=\"3%\"> : </td>
							<td>$no_medrec</td>

							
						</tr>
						<tr>
							<td width=\"20%\"><b>Nama Pasien</b></td>
							<td width=\"3%\"> : </td>
							<td >".$nama." / ".$sex." / ".$goldarah."</td>
							<td width=\"15%\"> </td>
							<td width=\"15%\"><b>Cara Bayar</b></td>
							<td width=\"3%\"> : </td>
							<td>$cara_bayar</td>
							
							
						</tr>
						
						<tr>
							<td><b>Untuk Permintaan Obat</b></td>
							<td> : </td>
							<td></td>
						</tr>
					</table>
					<br/><br/>
					<table>
						<tr><hr>
							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
							<th width=\"45%\"><p align=\"center\"><b>Nama Item</b></p></th>
							<th width=\"20%\"><p align=\"center\"><b>Harga</b></p></th>
							<th width=\"10%\"><p align=\"center\"><b>Banyak</b></p></th>
							<th width=\"20%\"><p align=\"center\"><b>Total</b></p></th>
						</tr>
						<hr>
					";
					$i=1;
					$jumlah_vtot=0;
					foreach($data_permintaan as $row){
						$jumlah_vtot=$jumlah_vtot+$row->vtot;
						$vtot = number_format( $row->vtot, 2 , ',' , '.' );
						$konten=$konten."<tr>
										  <td><p align=\"center\">$i</p></td>
										  <td>$row->nama_obat</td>
										  <td><p align=\"center\">".number_format( $row->biaya_obat, 2 , ',' , '.' )."</p></td>
										  <td><p align=\"center\">$row->qty</p></td>
										  <td><p align=\"right\">$vtot</P></td>
										  <br>
										</tr>";
						$i++;

					}
					
						$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);

				$konten=$konten."
						<tr><hr><br>
							<th colspan=\"4\"><p align=\"right\"><font size=\"12\"><b>Jumlah   </b></font></p></th>
							<th bgcolor=\"yellow\"><p align=\"right\"><font size=\"12\"><b>".number_format( $jumlah_vtot, 2 , ',' , '.' )."</b></font></p></th>
						</tr>
						
					</table>
					<b><font size=\"10\"><p align=\"right\">Terbilang : " .$vtot_terbilang."</p></font></b>
					<br><br>
					<p align=\"right\">$kota_kab, $tgl</p>
					";
			
			
			/* buat print per tindakan
			$i=1;
					$vtot=0;
					foreach($data_tindakan as $row1){
						$vtot=$vtot+$row1->biaya_tindakan;
						$konten=$konten."
						<tr>
							<td><p align=\"center\">".$i++."</p></td>
							<td>$row1->nmtindakan</td>
							<td><p align=\"right\">".number_format( $row1->biaya_tindakan, 2 , ',' , '.' )."</p></td>
						</tr>";
					}
						$konten=$konten."
						<tr>
							<th colspan=\"2\"><p align=\"right\"><b>Total   </b></p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">".number_format( $vtot, 2 , ',' , '.' )."</p></th>
						</tr>
				*/
			$file_name="SKT_$no_resep.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
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
				$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '15', PDF_MARGIN_RIGHT);
				$obj_pdf->SetAutoPageBreak(TRUE, '5');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->Output(FCPATH.'download/farmasi/frmkwitansi/'.$file_name, 'FI');
		}else{
			redirect('ird/IrDPelayanan/resep/'.$no_register.'/resep/'.$no_resep);
		}
	}

	
}
?>
