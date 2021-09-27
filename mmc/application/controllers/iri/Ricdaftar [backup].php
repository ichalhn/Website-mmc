<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ricdaftar extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('iri/rimdaftar');
	}
	public function index(){
		$data['reservasi']='';
		$data['daftar']='active';
		$data['pendaftaran']='';
		$data['pasien']='';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
		
		if(!$this->input->post('kode_ruang')){
			$data_daftar['kode_ruang']='-';
		}else{
			$kode_ruang=$this->input->post('kode_ruang');
			if($kode_ruang==''){
				$kode_ruang='-';
			}
			$data_daftar['kode_ruang']=$kode_ruang;
		}
		if(!$this->input->post('kelas')){
			$data_daftar['kelas']='-';
		}else{
			$kelas=$this->input->post('kelas');
			if($kelas==''){
				$kelas='-';
			}
			$data_daftar['kelas']=$kelas;
		}
		
		$this->load->view('iri/rivlink');
		$this->load->view('iri/rivheader');
		$this->load->view('iri/rivmenu', $data);
		$this->load->view('iri/rivdaftar', $data_daftar);
		$this->load->view('iri/rivfooter');
	}
	public function get_irna_antrian($kode_ruang='-', $kelas='-'){
		$requestData= $_REQUEST; //menampung post request dari ajax
		
		$columns = array( // datatable column index  => database column name
			0 =>'noreservasi', 
			1 =>'no_cm',
			2 =>'no_register_asal',
			3 =>'nama',
			4 =>'ruangpilih',
			5 =>'kelas',
			6 =>'infeksi',
			7 =>'hp',
			8 =>'prioritas',
			9 =>'tglrencanamasuk',
			10 =>'aksi'
		);
		$result['data'] = $this->rimdaftar->select_irna_antrian_all($kode_ruang,$kelas);
		
		// select *from pendidikan
		$totalData=count($result['data']);
		
		
		//------------------------------------------------------------AMBIL DATA----------------------------------------
		$result['data'] = $this->rimdaftar->select_irna_antrian_order($columns[$requestData['order'][0]['column']],$requestData['order'][0]['dir'],$requestData['start'],$requestData['length'],$kode_ruang,$kelas);
		// select *from pendidikan order by $column $order limit start, length;
		$totalDataQuery=count($result['data']);
		$totalFiltered = $totalData;
		//--------------------------------------------------------------------------------------------------------------
		
		
		//----------------------------------------------------------KALAU ADA SEARCH------------------------------------
		if(($requestData['columns'][0]['search']['value'])){
			$result['data'] = $this->rimdaftar->select_irna_antrian_search($columns[$requestData['order'][0]['column']],$requestData['order'][0]['dir'],$requestData['start'],$requestData['length'],$requestData['columns'][0]['search']['value'],$kode_ruang,$kelas);
			// select *from pendidikan order by $column $order limit start, length where id like value or nama like value;
			//jika data null
			$totalDataQuery=count($result['data']);
			$totalFiltered=count($result['data']);
		}
		
		//--------------------------------------------------------------------------------------------------------------
		for($i=0;$i<$totalDataQuery;$i++){
			$sort[$i]['0']=$result['data'][$i]['noreservasi']; // No Reservasi
			$sort[$i]['1']=$result['data'][$i]['no_cm']; // No. CM
			$sort[$i]['2']=$result['data'][$i]['no_register_asal']; // Nama
			$sort[$i]['3']=$result['data'][$i]['nama']; // Nama
			$sort[$i]['4']=$result['data'][$i]['ruangpilih']; // Nama
			$sort[$i]['5']=$result['data'][$i]['kelas']; // Nama
			$sort[$i]['6']=$result['data'][$i]['infeksi']; // HP
			$sort[$i]['7']=$result['data'][$i]['hp']; // HP
			$sort[$i]['8']=$result['data'][$i]['prioritas']; // Prioritas
			$sort[$i]['9']=$result['data'][$i]['tglrencanamasuk'];// Tanggal Rencana Masuk
			$sort[$i]['10']='<a href="ricpendaftaran"><button type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Approve</button></a><a href="ricdaftar/batal_reservasi/'.$sort[$i]['0'].'"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Batal</button></a>';
		}
		
		if($totalDataQuery==0){
			$data=Array();
		}else{
			$data=$sort;
		}
		
		$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data,   // total data array
			"start"           => $requestData['start'],   // total data array
			"length"          => $requestData['length'],   // total data array
			);
		echo json_encode($json_data);  // send data as json format
	}
	public function data_ruang() {
		// 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		$keyword = $this->uri->segment(4);
		$data = $this->rimdaftar->select_ruang_like($keyword);
		foreach($data as $row){
			$arr['query'] = $keyword;
			$arr['suggestions'][] 	= array(
				'value'				=>$row['idrg'],
				'idrg'				=>$row['idrg'],
				'nmruang'			=>$row['nmruang']
			);
		}
		echo json_encode($arr);
    }
	public function batal_reservasi($noreservasi){
		$this->session->set_flashdata('pesan',
		"<div class='alert alert-success alert-dismissable'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<i class='icon fa fa-check'></i> Reservasi telah dibatalkan!
		</div>");
		$data['batal']='Y';
		$this->rimdaftar->update_reservasi($noreservasi, $data);
		redirect('iri/ricdaftar');
	}
}
