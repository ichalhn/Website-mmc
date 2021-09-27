<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class Data_pegawai extends Secure_area {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('kepegawaian/M_pegawai','',TRUE);
	}
	
	public function index() {
		$data['title'] = 'Data Pegawai';
		$data['jenis'] = $this->M_pegawai->get_select_jenis();
		//$data['penggaji'] = $this->M_pegawai->get_select_penggaji();
		$this->load->view("kepegawaian/data_pegawai", $data);
	}
	
	public function detail(){
		$id = $this->input->post('id');
		echo json_encode($this->M_pegawai->get_info($id));
	}
	
	/*============ KELUARGA ================================*/
	public function list_keluarga($id) {
	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_pegawai->get_data_pasangan($id);
		
		foreach ($hasil as $value) {
			$row2['nip'] = $value->nip;
			$row2['nama'] = $value->nm_keluarga;
			$row2['status'] = $value->stat_kel;
			$row2['tgl_lahir'] = $value->tgl_lhr;
			$row2['sex'] = $value->sex_kel;
			$row2['tgl_nikah'] = $value->tgl_nikah;
			$row2['pekerjaan'] = $value->pekerjaan;
			$row2['tunjangan'] = $value->dpt_tunjangan;
			$row2['aksi'] = '<center>
								<button type="button" class="btn btn-primary btn-xs" title="Hapus"  onClick="deleteKel(\''.$value->nip.'\',\''.$value->nm_keluarga.'\')"><i class="fa fa-trash"></i></button>
							</center>';
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	
	public function list_anak($id) {
	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_pegawai->get_data_anak($id);
		
		foreach ($hasil as $value) {
			$row2['nip'] = $value->nip;
			$row2['nama'] = $value->nm_keluarga;
			$row2['status'] = $value->stat_kel;
			$row2['tgl_lahir'] = $value->tgl_lhr;
			$row2['sex'] = $value->sex_kel;
			$row2['pekerjaan'] = $value->pekerjaan;
			$row2['tunjangan'] = $value->dpt_tunjangan;
			$row2['aksi'] = '<center>
								<button type="button" class="btn btn-primary btn-xs" title="Hapus" onClick="deleteKel(\''.$value->nip.'\',\''.$value->nm_keluarga.'\')"><i class="fa fa-trash"></i></button>
							</center>';
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	
	function saveChild(){		
		$data = array(
			'nip'=>$this->input->post('nip_anak'),
			'nm_keluarga'=>$this->input->post('nm_anak'),
			'stat_kel'=>$this->input->post('stat_anak'),
			'tgl_lhr'=>$this->input->post('tgl_anak'),
			'sex_kel'=>$this->input->post('sex_anak'),
			'tgl_nikah'=>'',
			'pekerjaan'=>$this->input->post('krj_anak'),
			'dpt_tunjangan'=>$this->input->post('tunj_anak')
		);
		if ($this->M_pegawai->insert_kel($data)){
			$msg = 	' <div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i>Data keluarga berhasil disimpan							
				  </div>';
		}else{
			$msg = 	' <div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-ban"></i>Data keluarga gagal disimpan
				  </div>';
		}
		$this->session->set_flashdata('alert_msg', $msg);
		redirect(site_url("kepegawaian/Data_pegawai"));
	}
	
	function saveSpouse(){		
		$data = array(
			'nip'=>$this->input->post('nip_si'),
			'nm_keluarga'=>$this->input->post('nm_si'),
			'stat_kel'=>$this->input->post('stat_si'),
			'tgl_lhr'=>$this->input->post('tgl_si'),
			'sex_kel'=>$this->input->post('sex_si'),
			'tgl_nikah'=>$this->input->post('tgl_nikah'),
			'pekerjaan'=>$this->input->post('krj_si'),
			'dpt_tunjangan'=>$this->input->post('tunj_si')
		);
		if ($this->M_pegawai->insert_kel($data)){
			$msg = 	' <div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i>Data keluarga berhasil disimpan							
				  </div>';
		}else{
			$msg = 	' <div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-ban"></i>Data keluarga gagal disimpan
				  </div>';
		}
		$this->session->set_flashdata('alert_msg', $msg);
		redirect(site_url("kepegawaian/Data_pegawai"));
	}
	function delete_kel(){
		$nip = $this->input->post('id');
		$nm = $this->input->post('nama');		
		if ($this->M_pegawai->delete_kel($nip, $nm)){
			$msg = 	' <div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i>Data keluarga berhasil dihapus							
				  </div>';
		}else{
			$msg = 	' <div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-ban"></i>Data keluarga gagal dihapus
				  </div>';
		}
		echo json_encode(array('success'=>true,'message'=>$msg));
	
	}
	/*============ PENDIDIKAN ================================*/
	public function list_pendidikan($id) {
	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_pegawai->get_data_pendidikan($id);
		
		foreach ($hasil as $value) {
			$row2['nip'] = $value->nip;
			$row2['tk_ijazah'] = $value->tk_ijazah;
			$row2['tpt_pend'] = $value->tpt_pend;
			$row2['thn_ijazah'] = $value->thn_ijazah;
			$row2['aksi'] = '<center>
								<button type="button" class="btn btn-primary btn-xs" title="Hapus" onClick="deletePend(\''.$value->nip.'\',\''.$value->tk_ijazah.'\')"><i class="fa fa-trash"></i></button>
							</center>';
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	function savePend(){		
		if ($this->M_pegawai->insert_pend($this->input->post())){
			$msg = 	' <div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i>Data pendidikan berhasil disimpan							
				  </div>';
		}else{
			$msg = 	' <div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-ban"></i>Data pendidikan gagal disimpan
				  </div>';
		}
		$this->session->set_flashdata('alert_msg', $msg);
		redirect(site_url("kepegawaian/Data_pegawai"));
	}
	
	function delete_pend(){		
		$nip = $this->input->post('id');
		$nm = $this->input->post('nama');		
		if ($this->M_pegawai->delete_pend($nip, $nm)){
			$msg = 	' <div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i>Data pendidikan berhasil dihapus							
				  </div>';
		}else{
			$msg = 	' <div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-ban"></i>Data pendidikan gagal dihapus
				  </div>';
		}
		echo json_encode(array('success'=>true,'message'=>$msg));
	
	}
	/*============ KGB ================================*/
	public function list_kgb($id) {	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_pegawai->get_data_kgb($id);
		
		foreach ($hasil as $value) {
			$row2['no_suratkgb'] = $value->no_suratkgb;
			$row2['tgl_berlaku0'] = $value->tgl_berlaku0;
			$row2['tgl_berlaku'] = $value->tgl_berlaku;
			$row2['nm_golongan'] = $value->nm_golongan;
			$row2['pangkat'] = $value->pangkat;
			$row2['gaji_pokok0'] = $value->gaji_pokok0;
			$row2['gaji_pokok'] = $value->gaji_pokok;
			$row2['aksi'] = '<center>
								<button type="button" class="btn btn-primary btn-xs" title="Hapus" onClick="deleteKel(\''.$value->nip.'\',\''.$value->no_suratkgb.'\')"><i class="fa fa-trash"></i></button>
							</center>';
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	function saveKgb(){		
		if ($this->M_pegawai->insert_kgb($this->input->post())){
			$msg = 	' <div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i>Data KGB berhasil disimpan							
				  </div>';
		}else{
			$msg = 	' <div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-ban"></i>Data KGB gagal disimpan
				  </div>';
		}
		$this->session->set_flashdata('alert_msg', $msg);
		redirect(site_url("kepegawaian/Data_pegawai"));
	}
	
	function delete_kgb(){
		$nip = $this->input->post('id');
		$nm = $this->input->post('nama');			
		if ($this->M_pegawai->delete_kgb($nip, $nm)){
			$msg = 	' <div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i>Data KGB berhasil dihapus							
				  </div>';
		}else{
			$msg = 	' <div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-ban"></i>Data KGB gagal dihapus
				  </div>';
		}
		echo json_encode(array('success'=>true,'message'=>$msg));
	
	}
	/*============ JABATAN ================================*/
	public function list_history_jabatan($id) {	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_pegawai->get_data_history_jabatan($id);
		
		foreach ($hasil as $value) {
			$row2['tahun'] = $value->tahun;
			$row2['instansi'] = $value->instansi;
			$row2['nm_jabatan'] = $value->nm_jabatan;
			$row2['aksi'] = "";
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	public function list_history_mutasi($id) {	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_pegawai->get_data_history_mutasi($id);
		
		foreach ($hasil as $value) {
			$row2['tahun'] = $value->tahun;
			$row2['nm_bagian'] = $value->nm_bagian;
			$row2['aksi'] = "";
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	/*============ AUTOCOMPLETE ============================*/
	public function by_nama(){
		$keyword = $this->uri->segment(4);
		$data = $this->db->from('pegawai')->like('nm_pegawai',$keyword)->limit(12, 0)->get()->result();	

		foreach($data as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=> $row->nm_pegawai,
				'nip'	=> $row->nip,
				'id_bagian' => $row->id_bagian
			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}
	
	public function by_nip(){
		$keyword = $this->uri->segment(4);
		$data = $this->db->from('pegawai')->like('nip',$keyword)->limit(12, 0)->get()->result();	

		foreach($data as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=> $row->nip
			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}
	
	public function data_bagian_auto(){
		$keyword = $this->uri->segment(4);
		$data = $this->db->from('bagian')->like('nm_bagian',$keyword)->limit(12, 0)->get()->result();	

		foreach($data as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$row->nm_bagian,
				'id_bagian' => $row->id_bagian
			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}
	
	public function data_jabatan_auto(){
		$keyword = $this->uri->segment(4);
		$data = $this->db->from('jabatan')->like('nm_jabatan',$keyword)->limit(12, 0)->get()->result();	

		foreach($data as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$row->nm_jabatan,
				'id_jabatan' => $row->id_jabatan
			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}
	
	public function data_golongan_auto(){
		$keyword = $this->uri->segment(4);
		$data = $this->db->from('golongan')->like('nm_golongan',$keyword)->limit(12, 0)->get()->result();	

		foreach($data as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$row->nm_golongan.' - '.$row->pangkat,
				'id_golongan' => $row->id_golongan
			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}
	
	public function data_qua_auto(){
		$keyword = $this->uri->segment(4);
		$data = $this->db->from('qualifikasi_pend')->like('nm_qualifikasi',$keyword)->limit(12, 0)->get()->result();	

		foreach($data as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$row->nm_qualifikasi,
				'id_qualifikasi' => $row->id_qualifikasi
			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}
	public function data_sub_qua_auto(){
		$keyword = $this->uri->segment(4);
		$data = $this->db->from('sub_qualifikasi')->like('nm_sub_qua',$keyword)->limit(12, 0)->get()->result();	

		foreach($data as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$row->nm_sub_qua,
				'id_sub_qua' => $row->id_sub_qua
			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}
	
	
	public function get_unit($id){
		echo $this->M_pegawai->get_bagian($id);
	}
	
	public function data_tingkat_auto(){
		$data =  $this->M_pegawai->get_select_tingkat();
		foreach($data as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$row->nama,
			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}
	/*======== SAVE =====================================*/
	function save()
	{
		$newfilename = $this->input->post('vnip');
		//upload logo
		$config['upload_path'] = './upload/pegawai/';
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size'] = '2000000';
		$config['max_width'] = '2000';
		$config['max_height'] = '2000';
		$config['file_name'] = $newfilename;
		$this->upload->initialize($config);
		
		$userfile = $_FILES['userfile']['name'];
		$data = $this->input->post();
		
		if ($userfile){
			$ext = pathinfo($userfile, PATHINFO_EXTENSION);
			$file = $config['upload_path'].$config['file_name'].'.'.$ext;
			if(is_file($file))
				unlink($file);
				
			if(!$this->upload->do_upload()){
				//$data['foto']=$old_logo;
				$error = $this->upload->display_errors();
				echo $error;
			}else{
				$upload = $this->upload->data();
				$foto = $upload['file_name'];
				//echo "success";
				$this->save_batch($data, $foto);
			}	
		}else{
			$foto = "";
			$this->save_batch($data, $foto);
		}
			
	}
	function save_batch($data, $foto){
		if ($this->M_pegawai->insert($data, $foto)){
			$msg = 	' <div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i>Data pegawai berhasil disimpan							
				  </div>';
		}else{
			$msg = 	' <div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-ban"></i>Data pegawai gagal disimpan
				  </div>';
		}
		$this->session->set_flashdata('alert_msg', $msg);
		redirect(site_url("kepegawaian/Data_pegawai"));
	}
	function update(){
		if ($this->M_pegawai->update($this->input->post())){
			$msg = 	' <div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i>Data pegawai berhasil diupdate							
				  </div>';
		}else{
			$msg = 	' <div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-ban"></i>Data pegawai gagal disimpan
				  </div>';
		}
		$this->session->set_flashdata('alert_msg', $msg);
		redirect(site_url("kepegawaian/Data_pegawai"));
	}
	function update_bio(){
		if ($this->M_pegawai->update_bio($this->input->post())){
			$msg = 	' <div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i>Data pegawai berhasil diupdate							
				  </div>';
		}else{
			$msg = 	' <div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-ban"></i>Data pegawai gagal disimpan
				  </div>';
		}
		$this->session->set_flashdata('alert_msg', $msg);
		redirect(site_url("kepegawaian/Data_pegawai"));
	}
	function update_photo()
	{
		$nip = $this->input->post('pnip');
		//upload logo
		$config['upload_path'] = './upload/pegawai/';
		$config['allowed_types'] = 'gif|png|jpg';
		$config['max_size'] = '2000000';
		$config['max_width'] = '2000';
		$config['max_height'] = '2000';
		$config['file_name'] = $nip;
		$this->upload->initialize($config);
		
		$userfile = $_FILES['userfile']['name'];
		$data = $this->input->post();
		
		if ($userfile){
			$ext = pathinfo($userfile, PATHINFO_EXTENSION);
			$file = $config['upload_path'].$config['file_name'].'.'.$ext;
			if(is_file($file))
				unlink($file);
				
			if(!$this->upload->do_upload()){
				$error = $this->upload->display_errors();
				echo $error;
			}else{
				$upload = $this->upload->data();
				$foto = $upload['file_name'];
				
				if ($this->M_pegawai->update_photo($nip, $foto)){
					echo json_encode(array('success'=>true,'photo'=>$foto));
				}else{
					echo json_encode(array('success'=>true,'photo'=>'NoImage.jpg'));
				}
			}	
		}			
	}
	function is_exist(){	
		$id = $this->input->post('id');
		echo json_encode($this->M_pegawai->checkisexist($id));
	}
}