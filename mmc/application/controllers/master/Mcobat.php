<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mcobat extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/mmobat','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Obat';

		$data['obat']=$this->mmobat->get_all_obat()->result();
		$data['satuan']=$this->mmobat->get_data_satuan()->result();
		$data['kelompok']=$this->mmobat->get_data_kelompok()->result();
		$data['jenis']=$this->mmobat->get_data_jenis()->result();
		$this->load->view('master/mvobat',$data);
		//print_r($data);
	}

	public function insert_obat(){

		$data['nm_obat']=$this->input->post('nm_obat');
		$data['satuank']=$this->input->post('satuank');
		$data['satuanb']=$this->input->post('satuanb');
		$data['faktorsatuan']=$this->input->post('faktorsatuan');
		// $data['hargabeli']=$this->input->post('hargabeli');
		$data['hargajual']=$this->input->post('hargajual');
		$data['kel']=$this->input->post('kel');
		$data['jenis_obat']=$this->input->post('jenis_obat');
		$data['min_stock'] = $this->input->post('minstok');
		//$data['xupdate']=$this->input->post('xupdate');

		$this->mmobat->insert_obat($data);
		
		redirect('master/Mcobat');
		//print_r($data);
	}

	public function get_data_edit_obat(){
		$id_obat=$this->input->post('id_obat');
		$datajson=$this->mmobat->get_data_obat($id_obat)->result();
	    echo json_encode($datajson);
	}

	public function edit_obat(){
		$id_obat=$this->input->post('edit_id_obat_hidden');
		$data['nm_obat']=$this->input->post('edit_nm_obat');
		$data['satuank']=$this->input->post('edit_satuank');
		$data['satuanb']=$this->input->post('edit_satuanb');
		$data['faktorsatuan']=$this->input->post('edit_faktorsatuan');
		// $data['hargabeli']=$this->input->post('edit_hargabeli');
		$data['hargajual']=$this->input->post('edit_hargajual');
		$data['kel']=$this->input->post('edit_kel');
		$data['jenis_obat']=$this->input->post('edit_jenis_obat');
		$data['min_stock'] = $this->input->post('edit_minstok');

		$this->mmobat->edit_obat($id_obat, $data);
		
		redirect('master/Mcobat');
		//print_r($data);
	}

	//kebijakan obat
	public function kebijakan(){
		$data['title'] = 'Kebijakan Obat';

		$data['kebijakan']=$this->mmobat->get_all_kebijakan()->result();
		$this->load->view('master/mvobatkebijakan',$data);
		//print_r($data);
	}

	public function insert_kebijakan(){
		$data['id_kebijakan']=$this->input->post('id_kebijakan');
		$data['keterangan']=$this->input->post('keterangan');
		$data['nilai']=$this->input->post('nilai');
		//$data['xupdate']=$this->input->post('xupdate');

		$this->mmobat->insert_kebijakan($data);
		
		redirect('master/Mcobat/kebijakan');
		//print_r($data);
	}

	public function edit_kebijakan(){
		$id_kebijakan=$this->input->post('edit_id_kebijakan_hidden');
		$data['keterangan']=$this->input->post('edit_keterangan');
		$data['nilai']=$this->input->post('edit_nilai');

		$this->mmobat->edit_kebijakan($id_kebijakan, $data);
		
		redirect('master/Mcobat/kebijakan');
		//print_r($data);
	}

	public function get_data_edit_kebijakan(){
		$id_kebijakan=$this->input->post('id_kebijakan');
		$datajson=$this->mmobat->get_data_kebijakan($id_kebijakan)->result();
	    echo json_encode($datajson);
	}

}