<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class Aset extends Secure_area {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('Masset','',TRUE);
	}
	
	public function daftar() {
		$data['title'] = 'Daftar Aset';
		$data['data_aset']=$this->Masset->get_data_all();
		$data['skel'] = $this->Masset->get_select_skel();
		$this->load->view("aset/daftarAset", $data);
	}
	
	public function mutasi() {
		$data['title'] = 'Riwayat Mutasi Aset';
		$data['data_aset']=$this->Masset->get_mutasi_all();
		$this->load->view("aset/mutasiAset", $data);
	}
	
	public function mutasi_history($search,$id) {
	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->Masset->get_mutasi_history($search,$id);
		
		foreach ($hasil as $value) {
			$row2['id'] = $value->id;
			$row2['tgl_mutasi'] = $value->tgl_mutasi;
			$row2['asset_number'] = $value->asset_number;
			$row2['description'] = $value->description;
			$row2['jenis'] = $value->jenis;
			$row2['pengguna_baru'] = $value->pengguna_baru;
			$row2['unit'] = $value->unit_baru;
			$row2['aksi'] = '<center>
								<button type="button" id="mutasiBtn" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#mutasiModal" data-id="'.$value->id.'" title="Detail"><i class="fa fa-binoculars"></i></button>
							</center>';
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	
	public function insertAsset(){
		$asset_no = $this->input->post('asset_number'); 
		$serial_number = $this->input->post('serial_number'); 
		$isExist = $this->Masset->checkIsExist($asset_no, $serial_number);	
		if ($isExist==0){
			$sukses = $this->Masset->insert($this->input->post());		
			$msg = 	' <div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-check"></i>Data berhasil disimpan							
					  </div>';
		}else{				
			$msg = 	' <div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-ban"></i>Nomor asset '.$asset_no.' dengan SN '.$serial_number.' sudah ada					
					  </div>';
		}
		$this->session->set_flashdata('alert_msg', $msg);
		redirect('aset/daftar');
	}
	
	public function mutasiAsset(){
		$mutasi = $this->Masset->mutasi($this->input->post());	
		if ($mutasi){
			$sukses = $this->Masset->update($this->input->post());						
			$msg = 	' <div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-check"></i>Data mutasi berhasil disimpan							
					  </div>';
			$this->session->set_flashdata('alert_msg', $msg);
			redirect('aset/daftar');
		}
	}
	
	public function deleteAset($id){		
		$cekMutasi = $this->Masset->cek_mutasi($id);	
		if ($cekMutasi > 0){						
			$msg = 	' <div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-ban"></i>Aset Number : '.$id.' memiliki riwayat mutasi. Data tidak dapat dihapus
					  </div>';
		}else{			
			$this->Masset->delete($id);
			$msg = 	' <div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-check"></i>Data aset berhasil dihapus							
					  </div>';
		}
		$this->session->set_flashdata('alert_msg', $msg);
		redirect('aset/daftar');
	}
	
	public function detailAsset(){
		$id = $this->input->post('id');
		echo json_encode($this->Masset->get_info($id));
	}
	
	public function detailAssetMutasi(){
		$id = $this->input->post('id');
		echo json_encode($this->Masset->get_info_mutasi($id));
	}
	
	public function get_select_jenis(){
		$id = $this->input->post('id');
		echo json_encode($this->Masset->get_select_jenis($id));
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
	
	//================================ MASTER JENIS ASSET ================================================//
	public function jenis() {
		$data['title'] = 'Master Data Jenis Aset';
		//$data['data']=$this->Masset->get_all_jenis()->result();
		$this->load->view("aset/jenisAset", $data);
	}
	
	public function dataJenisAsset(){
		$this->load->model("Datatables_models", "datatables");
		$table = 't_sskel';
		$primary_key = 'kd_brg';
		$columns = array(
			array('db' => 'kd_brg', 'dt' => 0),
			array('db' => 'ur_sskel', 'dt' => 1),
			array('db' => 'kd_brg', 'dt' => 2, 'formatter' => function($d, $row){
				return '
													<center>
													<button type="button" class="btn btn-primary btn-xs" onclick="delete_aset($d)" title="Hapus"><i class="fa fa-trash"></i></button>
													</center>';
			})
		);
		
		$this->output->set_content_type("application/json");
		$this->output->set_output(json_encode($this->datatables->simple($this->input->get(), $table, $primary_key, $columns)));
		
		
	}
}


/* end of file login.php
 * location : application/controllers
 */