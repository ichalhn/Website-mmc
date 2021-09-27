<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class crsakun extends Secure_area {
//class rjcregistrasi extends CI_Controller {
	public function __construct() {
			parent::__construct();
			$this->load->model('akun/mrsakun','',TRUE);
			$this->load->model('farmasi/Frmmlaporan','',TRUE);
			$this->load->helper('url');
			$this->load->helper('pdf_helper');
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////registrasi biodata pasien
	public function index()
	{
		$data['title'] = 'Akuntansi';
		$data['rekening']=$this->mrsakun->get_all_data_rekening()->result();
		$this->load->view('akun/v_akun',$data);
	}	
	
	public function valid()
	{
		$data['title'] = 'Validasi Voucher';
		$data['valid']=$this->mrsakun->get_all_valid_voucher()->result();
		$this->load->view('akun/v_valid',$data);
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////alamat
	public function insert_koderekening(){

		$data['kode']=$this->input->post('kode_rek');
		$data['perkiraan']=$this->input->post('perkiraan');
		$data['tl']=$this->input->post('jenis_tl');
		$data['tipe']=$this->input->post('jenis_tipe');
		$data['nb']=$this->input->post('jenis_nb');
		$data['nrl']=$this->input->post('jenis_nrl');
		if($this->input->post('upkode')!=''){
			$data['upkode']=$this->input->post('upkode');
		}
		$data['xuser']=$this->input->post('xuser');
		$data['zperkiraan']=$this->input->post('perkiraan');
		$data['statusflag']=$this->input->post('flag');

		$this->mrsakun->insert_rekening($data);
		
		redirect('akun/crsakun/');
		//print_r($data);
	}

	public function get_data_edit_rekening(){
		$kode=$this->input->post('kode');
		$datajson=$this->mrsakun->get_data_rekening($kode)->result();
	    	echo json_encode($datajson);
	}
	
	public function delete_rekening($kode=''){	
		$this->mrsakun->delete_rekening($kode);
	    redirect('akun/crsakun/');
	}

	public function edit_rekening(){

		/*$data['kode'],$data['perkiraan'],$data['tl'],$data['tipe'],$data['nb'],$data['nrl'],$data['upkode'],$data['xuser'],$data['zperkiraan']*/

		$kode=$this->input->post('edit_kode_hidden');
		$data['perkiraan']=$this->input->post('edit_perkiraan');
		//$data['tipebt']=$this->input->post('edit_tb');
		$data['tl']=$this->input->post('edit_jenis_tl');
		$data['tipe']=$this->input->post('edit_tipe');
		$data['nb']=$this->input->post('edit_nb');
		$data['nrl']=$this->input->post('edit_nrl');
		if($this->input->post('edit_upkode')!=''){
		$data['upkode']=$this->input->post('edit_upkode');
		}
		$data['xupdate']=$this->input->post('xupdate');
		$data['zperkiraan']=$this->input->post('edit_perkiraan');
		$data['statusflag']=$this->input->post('edit_flag');
		$this->mrsakun->edit_rekening($kode, $data);
		
		redirect('akun/crsakun');
		//print_r($data);
	}

	public function ajax_list($novoucher='')
	{
		$list = $this->mrsakun->get_datatables($novoucher);
		$voucher=$this->mrsakun->get_data_voucher($novoucher)->result();
		foreach($voucher as $row){
			$tutup=$row->tutupvoucher;
		}
		$data = array();
		$no = $_POST['start'];
		//'id','novoucher','tgltransaksi','rekening','tipe','bt','Nilai','ket'
		foreach ($list as $dgns) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $dgns->novoucher;
			$row[] = date('d-m-Y',strtotime($dgns->tgltransaksi));
			$row[] = $dgns->rekening;
			if($dgns->tipe=='Kredit'){
				$row[] = '<div style="color:red;">'.$dgns->Nilai.'</div>';
			}else{
				$row[] = '<div style="color:navy;">'.$dgns->Nilai.'</div>';
			}			
			$row[] = $dgns->tipe;
			$row[] = $dgns->bt;
			$row[] = $dgns->pic;
			$row[] = $dgns->ket;
			if($tutup!='' && $tutup!='0000-00-00 00:00:00'){
				$row[] = '<a type="button" class="btn btn-danger btn-xs" href="javascript: void(0)" "><i class="fa fa-trash"></i></a>';
			}else{
				$row[] = '<a type="button" class="btn btn-danger btn-xs" href="'.base_url('akun/crsakun/delete_transaksi').'/'.$dgns->novoucher.'/'.$dgns->id.'" "><i class="fa fa-trash"></i></a>';
			}
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->mrsakun->count_all($novoucher),
						"recordsFiltered" => $this->mrsakun->count_filtered($novoucher),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_list2($novoucher='')
	{
		$list = $this->mrsakun->get_datatables($novoucher);
		$voucher=$this->mrsakun->get_data_voucher($novoucher)->result();
		foreach($voucher as $row){
			$tutup=$row->tutupvoucher;
		}
		$data = array();
		$no = $_POST['start'];
		//'id','novoucher','tgltransaksi','rekening','tipe','bt','Nilai','ket'
		foreach ($list as $dgns) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $dgns->novoucher;
			$row[] = date('d-m-Y',strtotime($dgns->tgltransaksi));
			$row[] = $dgns->rekening;
			if($dgns->tipe=='Kredit'){
				$row[] = '<div style="color:red;">'.$dgns->Nilai.'</div>';
			}else{
				$row[] = '<div style="color:navy;">'.$dgns->Nilai.'</div>';
			}			
			$row[] = $dgns->tipe;
			$row[] = $dgns->bt;
			$row[] = $dgns->pic;
			$row[] = $dgns->ket;
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->mrsakun->count_all($novoucher),
						"recordsFiltered" => $this->mrsakun->count_filtered($novoucher),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_list1()
	{
		$list = $this->mrsakun->get_datatables1();
		
		$data = array();
		$no = $_POST['start'];
		//'id','novoucher','tgltransaksi','tglentry','tutupvoucher','tglvalidasi'
		foreach ($list as $dgns) {
			$no++;
			$row = array();
			$row[] = $no;
			if(($dgns->nilaidebet)-($dgns->nilaikredit)!=0){
				$row[] = '<div style="color:red;"><b>'.$dgns->novoucher.'</b></div>';
			}else if($dgns->nilaidebet=='' and $dgns->nilaikredit==''){
				$row[] = '<div style="color:black;">'.$dgns->novoucher.'</div>';
			}
			else
				$row[] = '<div style="color:green;"><b>'.$dgns->novoucher.'</b></div>';
			//$row[] = date('d-m-Y',strtotime($dgns->tgltransaksi));
			if($dgns->tglentry!=null){
				$row[] = date('d-m-Y',strtotime($dgns->tglentry));
			}else
				$row[] = '-';
			//$row[] = $dgns->tutupvoucher;
			if($dgns->tutupvoucher!=null){
				$row[] = date('d-m-Y',strtotime($dgns->tutupvoucher));
			}else
				$row[] = '-';
			//$row[] = date('d-m-Y',strtotime($dgns->tglvalidasi));
			if($dgns->tglvalidasi!=null or $dgns->tglvalidasi!=''){
				$row[] = date('d-m-Y',strtotime($dgns->tglvalidasi));
			}else
				$row[] = '-';
			$row[] = 'Status';
						
			$row[] = '<a type="button" class="btn btn-warn btn-xs" href="'.base_url('akun/crsakun/voucher').'/'.$dgns->novoucher.'" "><i class="fa fa-plus"></i></a> <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_voucher('.$dgns->novoucher.')"><i class="fa fa-edit"></i></button>';
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->mrsakun->count_all1(),
						"recordsFiltered" => $this->mrsakun->count_filtered1(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function voucher($novoucher=''){

		$data['title'] = 'Voucher';
		$data['novoucher'] = $novoucher;
		$data['tglentry']='';
		$data['ket']='';
		$data['tutupvoucher']='';
		$voucher=$this->mrsakun->get_data_voucher($novoucher)->result();
		//print_r($novoucher);
		$data['href_ok']='javascript: void(0)';
		$data['ok']='0';
		foreach($voucher as $row){
			if($row->nilaidebet - $row->nilaikredit==0 and ($row->tutupvoucher==null or $row->tutupvoucher=='0000-00-00 00:00:00' )){
				$data['href_ok']=site_url('akun/crsakun/close_voucher').'/'.$novoucher;
				$data['ok']='1';
			}else{
				//$data['href_ok']='javascript: void(0)';
				//$data['ok']='0';
			}
			$data['tutupvoucher']=$row->tutupvoucher;
			$data['tglentry']=$row->tglentry;
			$data['ket']=$row->ket;
		}
		$data['bt']=$this->mrsakun->get_all_data_bt()->result();
		$data['rekening']=$this->mrsakun->get_all_data_jurnal_rekening()->result();

		$this->load->view('akun/v_vouchertrans',$data);		
	}


	public function open_voucher(){
		
		$novoucher= $this->input->post('novouch1');
		$data['ket'] = $this->input->post('ket1');
		$data['tutupvoucher']='0000-00-00 00:00:00';
		//$data['tglvalidasi']=date('Y-m-d');
		$data['temp']='1';
		
		$this->mrsakun->edit_voucher($novoucher,$data);

		//redirect('/akun/crsakun/valid');	
	}

	public function close_voucher($novoucher=''){
		
		$data['novoucher'] = $novoucher;
		$data['tutupvoucher']=date('Y-m-d h:i:s');
		//$data['tglvalidasi']=date('Y-m-d');
		$data['temp']='0';

		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xupdate']=$user;
		
		$this->mrsakun->edit_voucher($novoucher,$data);

		redirect('akun/crsakun/voucher/'.$novoucher);	
	}

	public function valid_voucher($novoucher=''){
		
		$novoucher = $this->input->post('novouch2');
		$data['ket'] = $this->input->post('ket2');
		$data['tglvalidasi']=date('Y-m-d h:i:s');		
		$data['temp']='0';

		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xupdate']=$user;
		
		$this->mrsakun->edit_voucher($novoucher,$data);

		redirect('akun/crsakun/valid/'.$novoucher);	
	}

	public function open_valid($novoucher=''){
		
		$novoucher = $this->input->post('novouch1');
		$data['ket'] = $this->input->post('ket1');
		$data['tglvalidasi']='0000-00-00 00:00:00';		
		
		$this->mrsakun->edit_voucher($novoucher,$data);

		redirect('akun/crsakun/valid/'.$novoucher);	
	}

	public function delete_transaksi($novoucher='',$id=''){				
		
		$this->mrsakun->delete_transaksi($id);

		redirect('akun/crsakun/voucher/'.$novoucher);	
	}

	public function list_voucher(){

		$data['title'] = 'Daftar Voucher';
		
		$data['tgltrans']='';
		//$data['voucher']=$this->mrsakun->get_all_data_voucher()->result();
		

		$this->load->view('akun/v_voucher',$data);		
	}

	
	public function edit_voucher(){

		$novoucher = $this->input->post('edit_novoucher_hidden');
		$data['tglentry'] = $this->input->post('edit_tgl_entry');
		$data['tutupvoucher']=$this->input->post('edit_tutup');
		$data['tglvalidasi']=$this->input->post('edit_tgl_validasi');
		$data['ket']=$this->input->post('edit_tgl_validasi');
		//$data['tglvalidasi']=date('Y-m-d');
		//$data['temp']='0';

		$login_data = $this->load->get_var("user_info");
		$user = $login_data->username;
		$data['xupdate']=$user;
		
		$this->mrsakun->edit_voucher($novoucher,$data);

		redirect('akun/crsakun/voucher/');		
	}
	
	public function get_data_edit_voucher(){
		$kode=$this->input->post('kode');
		$datajson=$this->mrsakun->get_data_voucher($kode)->result();
	    	echo json_encode($datajson);
	}

	public function add_new_voucher(){

		$data['novoucher']=$this->input->post('new_no_voucher');
		$data['tglentry']=$this->input->post('new_tgl_entry');
		$data['temp']='1';
		$data['xuser']=$this->input->post('xuser');

		$this->mrsakun->insert_voucher($data);
		
		redirect('akun/crsakun/voucher/'.$this->input->post('new_no_voucher'));
		
	}

	public function add_new_transaksi(){

		$data['novoucher']=$this->input->post('trans_novoucher_hidden');
		$data['tgltransaksi']=$this->input->post('trans_tgltrans');		
		$data['Nilai']=$this->input->post('trans_nilai');
		$data['tipebt']=$this->input->post('trans_tipe');
		$data['ket']=$this->input->post('trans_ket');
		if($this->input->post('trans_bt')!=''){
			$data['kodebt']=$this->input->post('trans_bt');
			$data['pic']=$this->input->post('trans_pic');
		}
		$data['koderek']=$this->input->post('trans_koderek');
		$data['xuser']=$this->input->post('xuser');

		$this->mrsakun->insert_transaksi($data);
		//print_r($data);
		redirect('akun/crsakun/voucher/'.$data['novoucher']);
		
	}

	public function insert_voucher(){

		$data['kode']=$this->input->post('kode_rek');
		$data['perkiraan']=$this->input->post('perkiraan');
		$data['tl']=$this->input->post('jenis_tl');
		$data['tipe']=$this->input->post('jenis_tipe');
		$data['nb']=$this->input->post('jenis_nb');
		$data['nrl']=$this->input->post('jenis_nrl');
		if($this->input->post('upkode')!=''){
			$data['upkode']=$this->input->post('upkode');
		}
		$data['xuser']=$this->input->post('xuser');
		$data['zperkiraan']=$this->input->post('perkiraan');
		$data['statusflag']=$this->input->post('flag');

		$this->mrsakun->insert_voucher($data);
		
		redirect('akun/crsakun/voucher/');
		//print_r($data);
	}	
}
?>
