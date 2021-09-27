<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class CHistoripasien extends Secure_area {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('medrec/mhistoripasien','pasien');
	}

	public function index()
	{
		$data['title'] = 'Riwayat Pasien';
		$this->load->helper('url');

		$this->load->view('medrec/vhistoripasien',$data);
	}

	public function ajax_list()
	{
		$list = $this->pasien->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $dgns) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $dgns->no_register;
			$row[] = $dgns->no_cm;
			$row[] = $dgns->nama;
			$row[] = $dgns->id_poli;
			$row[] = $dgns->tgl_kunjungan;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->pasien->count_all(),
						"recordsFiltered" => $this->pasien->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
 
}