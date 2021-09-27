<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Jenis_aset extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('Masset','',TRUE);
	}

	public function index(){
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
