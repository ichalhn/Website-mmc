<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class crsnrl extends Secure_area {
//class rjcregistrasi extends CI_Controller {
	public function __construct() {
			parent::__construct();
			$this->load->model('akun/mrsakun','',TRUE);
			$this->load->model('akun/mrsnrl','',TRUE);
			$this->load->helper('url');
			$this->load->helper('pdf_helper');
		}
		
	public function index()
	{
		$data['title'] = 'Master Neraca Rugi Laba';
		$data['rekening']=$this->mrsakun->get_all_data_rekening()->result();
		$data['master_nrl']=$this->mrsnrl->get_all_data_masternrl()->result();
		$data['param1']=$this->mrsnrl->get_all_param1()->result();
		$data['param2']=$this->mrsnrl->get_all_param2()->result();
		$this->load->view('akun/v_masternrl',$data);
	}

	//transaksi	
	public function transaksi($id_nrl='')
	{
		if($id_nrl==''){
			$data['title'] = 'Input Neraca Rugi Laba';
			$data['rekening']=$this->mrsakun->get_all_data_rekening()->result();
			$data['master_nrl']=$this->mrsnrl->get_all_data_masternrl()->result();
			$this->load->view('akun/v_inputnrl',$data);
		}else{
			$data['title'] = 'Input Detail Neraca Rugi Laba';
			$data['detail_nrl']=$this->mrsnrl->get_data_masternrl($id_nrl)->row();
			$data['trans_nrl']=$this->mrsnrl->get_all_data_trans_nrl($id_nrl)->result();
			$data['year_nrl']=$this->mrsnrl->get_year_nrl($id_nrl)->result();
			$this->load->view('akun/v_inputnrl_detail',$data);
		}
	}
	//ajax
	public function data_koderek_akhir($id_nrl='')
	{
		$data=$this->mrsnrl->get_koderek_akhir($id_nrl)->result();
			echo "<option selected value=''>Pilih Kode Rekening Akhir</option>";
			foreach($data as $row){
				echo "<option value='".$row->kode."'>(".$row->kode.") ".$row->perkiraan."</option>";
			}
	}
	////////////////////////////////////////////////////////////////////////////////////////////////////////////alamat
	public function insert_master_nrl(){

		if($this->input->post('param1_lain')!=''){
			$data['param1']=$this->input->post('param1_lain');
		}else	$data['param1']=$this->input->post('param1');
		if($this->input->post('param2_lain')!=''){
			$data['param2']=$this->input->post('param2_lain');
		}else	$data['param2']=$this->input->post('param2');

		$data['param3']=$this->input->post('param3');
		$data['tipe']=$this->input->post('jenis_tipe');
		
		if($this->input->post('koderek0')!=''){
			$data['koderek_akhir']=$this->input->post('koderek0');
		}
		$data['xuser']=$this->input->post('xuser');		
		$data['koderek']=$this->input->post('koderek');

		$this->mrsnrl->insert_master_nrl($data);
		
		redirect('akun/crsnrl/');
		//print_r($data);
	}

	public function get_data_edit_nrl(){
		$kode=$this->input->post('id_nrl');
		$datajson=$this->mrsnrl->get_data_nrl($kode)->result();
	    	echo json_encode($datajson);
	}
	//get_data_edit_trans_nrl
	public function get_data_edit_trans_nrl(){
		$kode=$this->input->post('id_trans_nrl');
		$datajson=$this->mrsnrl->get_data_trans_nrl($kode)->result();
	    	echo json_encode($datajson);
	}
	public function delete_trans_nrl($id_nrl='',$year=''){	
		$this->mrsnrl->delete_trans_nrl($year);
	    	redirect('akun/crsnrl/transaksi/'.$id_nrl);
	}

	public function edit_nrl(){		

		$kode=$this->input->post('edit_id_nrl_hidden');

		if($this->input->post('edit_param1_lain')!=''){
			$data['param1']=$this->input->post('edit_param1_lain');
		}else	$data['param1']=$this->input->post('edit_param1');
		if($this->input->post('edit_param2_lain')!=''){
			$data['param2']=$this->input->post('edit_param2_lain');
		}else	$data['param2']=$this->input->post('edit_param2');

		//$data['param1']=$this->input->post('edit_param1');
		//$data['tipebt']=$this->input->post('edit_tb');
		//$data['param2']=$this->input->post('edit_param2');
		$data['param3']=$this->input->post('edit_param3');
		$data['tipe']=$this->input->post('edit_jenis_tipe');
		$data['koderek']=$this->input->post('edit_koderek');
		if($this->input->post('edit_koderek_akhir')!=''){
			$data['koderek_akhir']=$this->input->post('edit_koderek_akhir');
		}
		$data['xuser']=$this->input->post('xuser');
		$this->mrsnrl->edit_nrl($kode, $data);
		
		redirect('akun/crsnrl');
		//print_r($data);
	}

	public function edit_nilai_nrl(){
		$kode=$this->input->post('edit_id_nrl_hidden');
		
		$id_transaksi_nrl=$this->input->post('edit_id_trans_nrl_hidden');
		//$data['bulan']=$this->input->post('edit_bulan');
		$data['nilai']=$this->input->post('edit_nilai');
		$data['tgl_input']=date('Y-m-d h:i:s');
		$data['xuser']=$this->input->post('xuser');
		$this->mrsnrl->edit_nilai_nrl($id_transaksi_nrl, $data);
		
		redirect('akun/crsnrl/transaksi/'.$kode);
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
			if($tutup!=''){
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

	public function delete_transaksi($novoucher='',$id=''){				
		
		$this->mrsakun->delete_transaksi($id);

		redirect('akun/crsakun/voucher/'.$novoucher);	
	}

	public function delete_nrl($id_nrl=''){		
		if($id_nrl!=''){		
			$banyak=$this->mrsnrl->get_count_trans_nrl($id_nrl)->row()->banyak;
			if($banyak==0){
				$this->mrsnrl->delete_nrl($id_nrl);
			}else{
				$success = 	'<div class="content-header">
					
							<div class="alert alert-danger alert-dismissable">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
								<h4>
								<i class="icon fa fa-ban"></i>
								Data Tidak Dapat Dihapus ! Terdapat Data Transaksi NRL dengan id "'.$id_nrl.'"
								</h4>
							</div>
					
					</div>';
				$this->session->set_flashdata('success_msg', $success);
			}
		}
		redirect('akun/crsnrl/');	
	}

	public function lap_neraca(){
		$data['tampil_per']='THN';$data['date0']=date('Y');
		if($this->input->post('tampil_per')!=''){
			$data['tampil_per']=$this->input->post('tampil_per');
			if($this->input->post('tampil_per')=='BLN'){		
				$data['date0']=$this->input->post('bln0');
			}else{
				$data['date0']=$this->input->post('thn0');
			}
		}
		
		//$data['title'] = 'Laporan Neraca '.date('F Y', strtotime($data['date0']));
		//$data['date_title'] = 'Laporan Neraca '.$data['date0'].' s/d '.((int)$data['date0']-1);
		$data['title'] = 'Laporan Neraca ';
		if($data['tampil_per']=='' or $data['tampil_per']=='THN'){			
			$data['date00']=((int)$data['date0']-1);
			$data['date_title'] = 'Laporan Neraca '.$data['date0'].' & '.$data['date00'];
			$data['data_lap_neraca']=$this->mrsnrl->get_lap_nrl($data['tampil_per'],$data['date0'],((int)$data['date0']-1),'N')->result();
			$data['data_detail_lap_neraca']=$this->mrsnrl->get_detail_lap_nrl($data['tampil_per'],$data['date0'],((int)$data['date0']-1),'N')->result();		
		}else{
			
			$year=((int)date('Y', strtotime($data['date0']))-1).'-'.date('m', strtotime($data['date0']));
			$data['date00']=$year;
			$data['date_title'] = 'Laporan Neraca '.date('F Y', strtotime($data['date0'])).' & '.date('F Y', strtotime($data['date00']));
			//$year=((int)date('Y', strtotime($data['date0']))-1).'-'.date('m', strtotime($data['date0']));
			//echo $year;
			$data['data_lap_neraca']=$this->mrsnrl->get_lap_nrl($data['tampil_per'],$data['date0'],((int)$data['date0']-1),'N')->result();
			$data['data_detail_lap_neraca']=$this->mrsnrl->get_detail_lap_nrl($data['tampil_per'],$data['date0'],$year,'N')->result();
		}
		$data['size'] =sizeof($data['data_lap_neraca']);
		//$data['date_title'] = 'Laporan Neraca '.date('F Y', strtotime($data['date0'])).' s/d '.date('F Y', strtotime($data['date00']));	
		if($data['size']==0){
			$data['message_nodata'] = 	'<div class="content-header">
					
						<div class="alert alert-danger alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Tidak Terdapat Data
							</h4>
						</div>
					
				</div>';
		}else if($data['size']==1){
			//echo $data['size'];
			$data['message_nodata'] = 	'<div class="content-header">
					
						<div class="alert alert-danger alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Data pada tahun "'.$data['date00'].'" belum diinput
							</h4>
						</div>
					
				</div>';
		}
		$this->load->view('akun/v_lapnrc',$data);		
	}

	//rugi laba
	public function lap_rugilaba(){
		$data['tampil_per']='THN';$data['date0']=date('Y');
		if($this->input->post('tampil_per')!=''){
			$data['tampil_per']=$this->input->post('tampil_per');
			if($this->input->post('tampil_per')=='BLN'){		
				$data['date0']=$this->input->post('bln0');
			}else{
				$data['date0']=$this->input->post('thn0');
			}
		}
		
		$data['title'] = 'Laporan Rugi Laba ';
		if($data['tampil_per']=='' or $data['tampil_per']=='THN'){
			
			$data['date00']=((int)$data['date0']-1);
			$data['date_title'] = 'Laporan Rugi Laba '.$data['date0'].' & '.$data['date00'];
			$data['data_lap_rl']=$this->mrsnrl->get_lap_nrl($data['tampil_per'],$data['date0'],((int)$data['date0']-1),'RL')->result();
			$data['data_detail_lap_rl']=$this->mrsnrl->get_detail_lap_nrl($data['tampil_per'],$data['date0'],((int)$data['date0']-1),'RL')->result();		
		}else{
			
			$year=((int)date('Y', strtotime($data['date0']))-1).'-'.date('m', strtotime($data['date0']));
			$data['date00']=$year;
			$data['date_title'] = 'Laporan Rugi Laba '.date('F Y', strtotime($data['date0'])).' & '.date('F Y', strtotime($data['date00']));
			//$year=((int)date('Y', strtotime($data['date0']))-1).'-'.date('m', strtotime($data['date0']));
			//echo $year;
			$data['data_lap_rl']=$this->mrsnrl->get_lap_nrl($data['tampil_per'],$data['date0'],((int)$data['date0']-1),'RL')->result();
			$data['data_detail_lap_rl']=$this->mrsnrl->get_detail_lap_nrl($data['tampil_per'],$data['date0'],$year,'RL')->result();
		}
		$data['size'] =sizeof($data['data_lap_rl']);
		//$data['date_title'] = 'Laporan Neraca '.date('F Y', strtotime($data['date0'])).' s/d '.date('F Y', strtotime($data['date00']));
		
		if($data['size']==0){
			$data['message_nodata'] = 	'<div class="content-header">
					
						<div class="alert alert-danger alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Tidak Terdapat Data
							</h4>
						</div>
					
				</div>';
		}else if($data['size']==1){
			//echo $data['size'];
			$data['message_nodata'] = 	'<div class="content-header">
					
						<div class="alert alert-danger alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Data pada tahun "'.$data['date00'].'" belum diinput
							</h4>
						</div>
					
				</div>';
		}
		$this->load->view('akun/v_laprl',$data);		
	}

	function cetak_lap_pdf($tipe,$param1,$nrl){

		if($tipe!='' and $param1!=''){
			
		$namars=$this->config->item('namars');
		$kota_kab=$this->config->item('kota');
		$alamat=$this->config->item('alamat');
		$nmsingkat=$this->config->item('namasingkat');
			$date0 = $param1;
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			//$tgl1=date('d-m-Y', strtotime($tgl_awal));
			//$tgl2=date('d-m-Y', strtotime($tgl_akhir));
			
			

			if($tipe=='BLN'){
				$type="Bulan";
				$year=((int)date('Y', strtotime($date0))-1).'-'.date('m', strtotime($date0));
				$date00=$year;
				$datenormal= date('F Y', strtotime($date0));}
			else{
				$type="Tahun";
				$date00=((int)$date0-1);
				$datenormal=$date0;
			}

			if($nrl!=''){
				$judul="Rugi Laba";
				$data_lap_nrl=$this->mrsnrl->get_lap_nrl($tipe,$date0,$date00,'RL')->result();
				$data_detail_lap_nrl=$this->mrsnrl->get_detail_lap_nrl($tipe,$date0,$date00,'RL')->result();
			}else{
				$judul="Neraca";
				$data_lap_nrl=$this->mrsnrl->get_lap_nrl($tipe,$date0,$date00,'N')->result();
				$data_detail_lap_nrl=$this->mrsnrl->get_detail_lap_nrl($tipe,$date0,$date00,'N')->result();
			}

			if($tipe=='BLN'){
				$dateminus=date('F Y', strtotime($date00));}
			else{
				$dateminus=$date00;
			}

			$i=1;
					$vtot_banyak=0;
			$konten=
					"<style type=\"text/css\">
					.table-font-size{
						font-size:9px;
					    }
					.table-font-size1{
						font-size:12px;
					    }
					tr.border_bottom td {
					  border-top:1pt solid black;
					}
					
					</style>
					<table>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><br><b>Laporan $judul</b></p></td>
							</tr>
							<tr>
								<td>$namars</td>
							</tr>
						</table>
						<table >							
							<tr>
								<td width=\"10%\"><b>$type</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$datenormal & $dateminus</td>
							</tr>
						</table>
						<br/><hr/><div></div>
				
					<table border=\"1\"   style=\"padding:2px\">
						<thead>
							<tr>
								<th width=\"5%\">No</th>
								<th width=\"15%\">Param 1</th>
								<th width=\"20%\">Param 2</th>
								<th width=\"20%\">Param 3</th>		
								<th width=\"20%\">$datenormal</th>
								<th width=\"20%\">$dateminus</th>
							</tr>
						</thead>
						<tbody>
							
			";
						

					$vtotdate0=0;$vtotdate00=0;
					foreach($data_lap_nrl as $row){	
						$id_nrl=$row->id_nrl;					
						$konten=$konten."<tr>
							<td width=\"5%\">".$i++."</td>
							<td width=\"15%\">".$row->param1."</td>
							<td width=\"20%\">".$row->param2."</td>
							<td width=\"20%\">".$row->param3."</td>";
							//echo $date0.' - '.$date00;
							foreach($data_detail_lap_nrl as $row1){							
							if($row1->id_nrl==$id_nrl){
								if($row1->year==$date0){
									//echo $row1->totnilai.'ppp';
									$vtotdate0=$vtotdate0+$row1->totnilai;
									
									$konten=$konten."<td width=\"20%\"><p align=\"right\">".number_format($row1->totnilai, 2 , ',' , '.' )."</p></td>";
								}
								//echo $row1->year;
								if($row1->year==$date00){
									//echo $row1->totnilai.'fff';
									$vtotdate00=$vtotdate00+$row1->totnilai;
									
									$konten=$konten."<td width=\"20%\"><p align=\"right\">".number_format($row1->totnilai, 2 , ',' , '.' )."</p></td>";
								}
							}}

				$konten=$konten."</tr>";						
			}
			
				$konten=$konten."<tr>
							<th colspan=\"4\" bgcolor=\"#cdd4cb\"><p align=\"right\"><b>Total   </b></p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtotdate0, 2 , ',' , '.' )."</p></th>
							<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtotdate00, 2 , ',' , '.' )."</p></th>
						</tr>";
			$konten=$konten."</tbody>
					</table>";					
			$file_name="Laporan_$date0-$date00.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);				
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setPrintHeader(false);
				$obj_pdf->setPrintFooter(true);
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
				$obj_pdf->SetAutoPageBreak(TRUE, '15');
				$obj_pdf->SetFont('helvetica', '', 9);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($content, true, false, true, false, '');
				if($nrl==''){
				$obj_pdf->Output(FCPATH.'/download/akun/neraca/'.$file_name, 'FI');
				}else $obj_pdf->Output(FCPATH.'/download/akun/rugilaba/'.$file_name, 'FI');
		}else{
			redirect('akun/crsnrl/lap_neraca','refresh');
		}
	}

	function cetak_lap_excel($tipe,$param1,$nrl){
		

		//$tgl_indo=new Tglindo();				

		date_default_timezone_set("Asia/Bangkok");		
		$date0 = $param1;
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			//$tgl1=date('d-m-Y', strtotime($tgl_awal));
			//$tgl2=date('d-m-Y', strtotime($tgl_akhir));
			
			

			if($tipe=='BLN'){
				$type="Bulan";
				$datenormal= date('F Y', strtotime($date0));
				$year=((int)date('Y', strtotime($date0))-1).'-'.date('m', strtotime($date0));
				$date00=$year;
			}else{
				$type="Tahun";
				$date00=((int)$date0-1);
				$datenormal=$date0;
			}
			
			if($nrl!=''){
				$data['title'] = 'Laporan Rugi Laba';
				$data_lap_nrl=$this->mrsnrl->get_lap_nrl($tipe,$date0,$date00,'RL')->result();
				$data_detail_lap_nrl=$this->mrsnrl->get_detail_lap_nrl($tipe,$date0,$date00,'RL')->result();
			}else{
				$data['title'] = 'Laporan Neraca';
				$data_lap_nrl=$this->mrsnrl->get_lap_nrl($tipe,$date0,$date00,'N')->result();
				$data_detail_lap_nrl=$this->mrsnrl->get_detail_lap_nrl($tipe,$date0,$date00,'N')->result();
			}

			if($tipe=='BLN'){
				$dateminus=date('F Y', strtotime($date00));}
			else{
				$dateminus=$date00;
			}

		//print_r($tampil);
		$namars=$this->config->item('namars');
		$kota_kab=$this->config->item('kota');
		$alamat=$this->config->item('alamat');
		$nmsingkat=$this->config->item('namasingkat');
		////EXCEL 
		$this->load->library('Excel');  
		//$this->load->file(APPPATH.'third_party/PHPExcel.php');   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy("HMIS")  
		        ->setTitle($data['title']." RS")  
		        ->setSubject("Laporan HMIS Document")  
		        ->setDescription("Laporan HMIS for Office 2007 XLSX, generated by HMIS.")  
		        ->setKeywords("HMIS")  
		        ->setCategory($data['title']);  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);


				//$tgl=$param1;
				//$tgl1 = date('d F Y', strtotime($tgl));				
				//$data_laporan_kunj=$this->ModelLaporan->get_data_kunj_range($tgl)->result();
				//$data_laporan_kunj=$this->mrsakunlap->get_data_lapgl($tgl_awal,$tgl_akhir)->result();
				//$data_tindakan=$this->mrsakunlap->get_data_detailgl($tgl_awal,$tgl_akhir)->result();
				//$data_keuangan=$this->ModelLaporan->get_data_keuangan_tgl($tgl)->result();
					
				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_neraca.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  
				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', $type.' : '.$datenormal.' & '.$dateminus);

				$vtot1=0;$vtot_banyak=0;
				$i=1;
				$rowCount = 4;

				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $datenormal);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $dateminus);
				$rowCount++;

				$cek=0;$vtotdate0=0;$vtotdate00=0;
				foreach($data_lap_nrl as $row){
				$id_nrl=$row->id_nrl;					
					$j=1;		
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
						$objPHPExcel->getActiveSheet()->
							setCellValueExplicit(
								'B'.$rowCount, 
								$row->param1, 
								PHPExcel_Cell_DataType::TYPE_STRING
						);
//SetCellValue('B'.$rowCount, $row->no_medrec);
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->param2);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->param3);
						foreach($data_detail_lap_nrl as $row1){							
							if($row1->id_nrl==$id_nrl){
								if($row1->year==$date0){
									//echo $row1->totnilai.'ppp';
									$vtotdate0=$vtotdate0+$row1->totnilai;
									
									$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row1->totnilai);
								}
								if($row1->year==$date00){
									//echo $row1->totnilai.'ppp';
									$vtotdate00=$vtotdate00+$row1->totnilai;
									
									$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row1->totnilai);
								}
							}
						}
					
						// if
				$rowCount++;$i++;	
				}
				
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,  $vtotdate0);
				$objPHPExcel->getActiveSheet()->getStyle('E'.$rowCount)->applyFromArray(
				    array(
					'fill' => array(
					    'type' => PHPExcel_Style_Fill::FILL_SOLID,
					    'color' => array('rgb' => 'C1B2B2')
					)
				    )
				);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,  $vtotdate00);
				$objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->applyFromArray(
				    array(
					'fill' => array(
					    'type' => PHPExcel_Style_Fill::FILL_SOLID,
					    'color' => array('rgb' => 'C1B2B2')
					)
				    )
				);
				if($nrl==''){
					header('Content-Disposition: attachment;filename="Lap_Neraca_'.$tipe.'_'.$date0.'_'.$date00.'.xlsx"'); 
				}else{
					header('Content-Disposition: attachment;filename="Lap_Rugilaba_'.$tipe.'_'.$date0.'_'.$date00.'.xlsx"'); 
				} 														
					

		// Rename worksheet (worksheet, not filename)  
		$objPHPExcel->getActiveSheet()->setTitle($namars);  
		   
		   
		   
		// Redirect output to a client’s web browser (Excel2007)  
		//clean the output buffer  
		ob_end_clean();  
		   
		//this is the header given from PHPExcel examples.   
		//but the output seems somewhat corrupted in some cases.  
		//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
		//so, we use this header instead.  
		header('Content-type: application/vnd.ms-excel');  
		header('Cache-Control: max-age=0');  
		   
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
		$objWriter->save('php://output');  
	}

	public function add_new_transnrl(){

		$data['id_nrl']=$this->input->post('id_nrl_hidden');
		$year=$this->input->post('detail_year');		
		$data['nilai']=$this->input->post('detail_nilai');		
		$data['xuser']=$this->input->post('xuser');

		$tahun=$this->mrsnrl->get_year_nrl($data['id_nrl'])->result();
		$v=0;
		foreach($tahun as $roww){
			if($roww->year==$year){
				$v=1;
			}
		}
		if($v==0){
			for ($x = 0; $x < 12; $x++) {
				//echo $x+1;
				//echo strlen($x);
				if(strlen($x+1)==1){
				$data['bulan']=$year.'-0'.($x+1);
				}else $data['bulan']=$year.'-'.($x+1);
				$this->mrsnrl->insert_transaksi_nrl($data);
			} 		
			//print_r($data);
				
			redirect('akun/crsnrl/transaksi/'.$data['id_nrl']);
		}else{
			$success = 	'<div class="content-header">
					
						<div class="alert alert-danger alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Transaksi Tahun '.$year.' Telah Ditambahkan
							</h4>
						</div>
					
				</div>';
			$this->session->set_flashdata('success_msg', $success);	
			redirect('akun/crsnrl/transaksi/'.$data['id_nrl']);
			}
		
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
