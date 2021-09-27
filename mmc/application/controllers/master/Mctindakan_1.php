<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Mctindakan_1 extends Secure_area {
	public function __construct(){
		parent::__construct();

		$this->load->model('master/mmtindakan_1','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Tindakan';

		$data['tindakan']=$this->mmtindakan_1->get_all_tindakan()->result();
		$data['kelas']=$this->mmtindakan_1->get_all_kelas()->result();
		$data['kel_tindakan']=$this->mmtindakan_1->get_all_kel_tindakan()->result();
		$this->load->view('master/mvtindakan_1',$data);
		//print_r($data);
	}

	public function insert_tindakan(){
		//insert to jenis_tindakan
		$jt['idtindakan']=$this->input->post('idtindakan');
		$jt['nmtindakan']=$this->input->post('nmtindakan');
		$jt['idpok1']=substr($jt['idtindakan'], 0,1);
		$jt['idpok2']=substr($jt['idtindakan'], 0,2);
		$jt['idkel_tind']=$this->input->post('idkel_tind');
		if($this->input->post('paket')=="on"){
			$jt['paket']="1";
		}else{
			$jt['paket']="0";
		}
		//$jt['xupdate']=$this->input->post('xupdate');

		//insert to jenis_tindakan
		$this->mmtindakan_1->insert_jenis_tindakan($jt);
		// echo json_encode($jt);

		//insert to tarif_tindakan
		$data['id_tindakan']=$this->input->post('idtindakan');
		if($jt['idpok2']=="1A"){
			$data['idrg']=substr($jt['idtindakan'], 2,4);
		}

		//get kelas
		$kelas=$this->mmtindakan_1->get_all_kelas()->result();
		foreach ($kelas as $row) {
			$data['jasa_sarana']=$this->input->post('jasa_sarana_'.$row->kelas);
			$data['jasa_pelayanan']=$this->input->post('jasa_pelayanan_'.$row->kelas);
			$data['total_tarif']=$this->input->post('hidden_total_'.$row->kelas);
			// $data['total_tarif']=$this->input->post('kelas_'.$row->kelas);
			// if($data['total_tarif']==''){
			// 	$data['total_tarif']=='0';
			// }
			$data['kelas']=$row->kelas;
			$this->mmtindakan_1->insert_tarif_tindakan($data);
			// echo json_encode($data);
		}
		
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Tindakan dengan ID "'.$jt['idtindakan'].'" berhasil ditambahkan
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);

		redirect('master/mctindakan_1','refresh');
		//print_r($jt);
	}

	public function get_data_edit_tindakan(){
		$idtindakan=$this->input->post('idtindakan');
		$datajson=$this->mmtindakan_1->get_data_tindakan($idtindakan)->result();
	    echo json_encode($datajson);
	}

	public function delete_tindakan($idtindakan=''){
		$datajson=$this->mmtindakan_1->delete_tindakan($idtindakan);
		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Tindakan dengan ID "'.$idtindakan.'" berhasil dihapus
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);
	    redirect('master/mctindakan','refresh');
	}

	public function edit_tindakan(){
		//edit to jenis_tindakan
		$idtindakan=$this->input->post('edit_idtindakan_hide');
		$jt['nmtindakan']=$this->input->post('edit_nmtindakan');
		$jt['idkel_tind']=$this->input->post('edit_idkel_tind');
		if($this->input->post('edit_paket')=="on"){
			$jt['paket']="1";
		}else{
			$jt['paket']="0";
		}

		$this->mmtindakan_1->edit_jenis_tindakan($idtindakan, $jt);

		//edit to tarif_tindakan
		$data['id_tindakan']=$this->input->post('edit_idtindakan_hide');
		if(substr($idtindakan, 0,2)=="1A"){
			$data['idrg']=substr($idtindakan, 2,4);
		}

		//get kelas
		$kelas=$this->mmtindakan_1->get_all_kelas()->result();

		foreach ($kelas as $row) {
			$data['kelas']=$row->kelas;
			$data['jasa_sarana']=$this->input->post('edit_jasa_sarana_'.$row->kelas);
			$data['jasa_pelayanan']=$this->input->post('edit_jasa_pelayanan_'.$row->kelas);
			$data['total_tarif']=$this->input->post('edit_hidden_total_'.$row->kelas);

    //       print_r($data);exit();
			// $return_data=$this->mmtindakan->return_tarif($idtindakan, $row->kelas)->num_rows();
			$id_tarif_tindakan=$this->mmtindakan_1->return_tarif($idtindakan, $row->kelas)->row()->id_tarif_tindakan;
			$this->mmtindakan_1->edit_tarif_tindakan($id_tarif_tindakan, $data);
		}


		echo json_encode(array("status" => TRUE));
	}

	//EXPORT
	public function export_excel(){
		$data['title'] = 'Tarif Tindakan';

		////EXCEL
		$this->load->library('Excel');

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("RSKMPALEMBANG")
		        ->setLastModifiedBy("RSKMPALEMBANG")
		        ->setTitle("Tarif Tindakan RSKMPALEMBANG")
		        ->setSubject("Tarif Tindakan RSKMPALEMBANG Document")
		        ->setDescription("Tarif Tindakan RSKMPALEMBANG for Office 2007 XLSX, generated by HMIS.")
		        ->setKeywords("RSKMPALEMBANG")
		        ->setCategory("Tarif Tindakan");

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		//$objPHPExcel = $objReader->load("project.xlsx");
		$tindakan=$this->mmtindakan_1->get_all_tindakan()->result();

		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);

		$objPHPExcel=$objReader->load(APPPATH.'third_party/10_diagnosa.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Add some data
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
		$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'No');
		$objPHPExcel->getActiveSheet()->SetCellValue('B3', 'ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('C3', 'Nama');
		//get from kelas
		$kelas=$this->mmtindakan_1->get_all_kelas()->result();
		$code_string = ord("D");
		foreach ($kelas as $row) {
			$objPHPExcel->getActiveSheet()->SetCellValue(chr($code_string).'3', 'Kelas '.$row->kelas);
			$code_string++;
		}
		$rowCount=4;
		$i=1;
		foreach($tindakan as $row){
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->idtindakan);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->nmtindakan);

			$code_string = ord("D");
			foreach ($kelas as $row1) {
              	$naon = $row1->kelas;
              	$naon = strtolower($naon);
              	$vtot = 0;
              	if($row->$naon!=""){
                	$vtot = $row->$naon;
              	}
				$objPHPExcel->getActiveSheet()->SetCellValue(chr($code_string).''.$rowCount, $vtot);
				$code_string++;
			}

		 	$i++;
		 	$rowCount++;
		}
		header('Content-Disposition: attachment;filename="Tarif Tindakan.xlsx"');

		// Rename worksheet (worksheet, not filename)
		$objPHPExcel->getActiveSheet()->setTitle('RS PATRIA IKKT');



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

	public function insert_tindakan_old(){
		//insert to jenis_tindakan
		$jt['idtindakan']=$this->input->post('idtindakan');
		$jt['nmtindakan']=$this->input->post('nmtindakan');
		$jt['idpok1']=substr($jt['idtindakan'], 0,1);
		$jt['idpok2']=substr($jt['idtindakan'], 0,2);
		if($this->input->post('paket')=="on"){
			$jt['paket']="1";
		}else{
			$jt['paket']="0";
		}
		//$jt['xupdate']=$this->input->post('xupdate');

		$this->mmtindakan_1->insert_jenis_tindakan($jt);

		//insert to tarif_tindakan
		$data['id_tindakan']=$this->input->post('idtindakan');
		if($jt['idpok2']=="1A"){
			$data['idrg']=substr($jt['idtindakan'], 2,4);
		}
		  //Kelas VIP A
		if($this->input->post('kelas_vipa')!=0){
			$data['total_tarif']=$this->input->post('kelas_vipa');
			if($data['total_tarif']==''){
				$data['total_tarif']=='0';
			}
			$data['kelas']="VVIP";
			$data['tarif_alkes']=$this->input->post('alkes_kelas_vipa');
			if($data['tarif_alkes']==''){
				$data['tarif_alkes']=='0';
			}
			$this->mmtindakan_1->insert_tarif_tindakan($data);
			$data['tarif_alkes']="";
		}
		  //Kelas VIP B
		if($this->input->post('kelas_vipb')!=0){
			$data['total_tarif']=$this->input->post('kelas_vipb');
			if($data['total_tarif']==''){
				$data['total_tarif']=='0';
			}
			$data['kelas']="VIP";
			$data['tarif_alkes']=$this->input->post('alkes_kelas_vipb');
			if($data['tarif_alkes']==''){
				$data['tarif_alkes']=='0';
			}
			$this->mmtindakan_1->insert_tarif_tindakan($data);
			$data['tarif_alkes']="";
		}

		//KELAS uTAMA
		  if($this->input->post('kelas_3a')!=0){
			$data['total_tarif']=$this->input->post('kelas_3a');
			if($data['total_tarif']==''){
				$data['total_tarif']=='0';
			}
			$data['kelas']="UTAMA";
			$data['tarif_alkes']=$this->input->post('alkes_kelas_3a');
			if($data['tarif_alkes']==''){
				$data['tarif_alkes']=='0';
			}
			$this->mmtindakan_1->insert_tarif_tindakan($data);
			$data['tarif_alkes']="";
		}

		  //Kelas I
		if($this->input->post('kelas_1')!=0){
			$data['total_tarif']=$this->input->post('kelas_1');
			if($data['total_tarif']==''){
				$data['total_tarif']=='0';
			}
			$data['kelas']="I";
			$data['tarif_alkes']=$this->input->post('alkes_kelas_1');
			if($data['tarif_alkes']==''){
				$data['tarif_alkes']=='0';
			}
			$this->mmtindakan_1->insert_tarif_tindakan($data);
			$data['tarif_alkes']="";
		}
		  //Kelas II
		if($this->input->post('kelas_2')!=0){
			$data['total_tarif']=$this->input->post('kelas_2');
			if($data['total_tarif']==''){
				$data['total_tarif']=='0';
			}
			$data['kelas']="II";
			$data['tarif_alkes']=$this->input->post('alkes_kelas_2');
			if($data['tarif_alkes']==''){
				$data['tarif_alkes']=='0';
			}
			$this->mmtindakan_1->insert_tarif_tindakan($data);
			$data['tarif_alkes']="";
		}
		  //Kelas III
		if($this->input->post('kelas_3')!=0){
			$data['total_tarif']=$this->input->post('kelas_3');
			if($data['total_tarif']==''){
				$data['total_tarif']=='0';
			}
			$data['kelas']="III";
			$data['tarif_alkes']=$this->input->post('alkes_kelas_3');
			if($data['tarif_alkes']==''){
				$data['tarif_alkes']=='0';
			}
			$this->mmtindakan_1->insert_tarif_tindakan($data);
			$data['tarif_alkes']="";

		}
		//Kelas III A
		// if($this->input->post('kelas_3a')!=0){
		// 	$data['total_tarif']=$this->input->post('kelas_3a');
		// 	$data['kelas']="III A";
		// 	$data['tarif_alkes']=$this->input->post('alkes_kelas_3a');
		// 	$this->mmtindakan->insert_tarif_tindakan($data);
		// 	$data['tarif_alkes']="";
		// }
		//   //Kelas III B
		// if($this->input->post('kelas_3b')!=0){
		// 	$data['total_tarif']=$this->input->post('kelas_3b');
		// 	$data['kelas']="III B";
		// 	$data['tarif_alkes']=$this->input->post('alkes_kelas_3b');
		// 	$this->mmtindakan->insert_tarif_tindakan($data);
		// 	$data['tarif_alkes']="";
		// }

		$success = 	'<div class="content-header">
					<div class="box box-default">
						<div class="alert alert-success alert-dismissable">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<h4>
							<i class="icon fa fa-ban"></i>
							Tindakan dengan ID "'.$jt['idtindakan'].'" berhasil ditambahkan
							</h4>
						</div>
					</div>
				</div>';
		$this->session->set_flashdata('success_msg', $success);

		redirect('master/mctindakan_1','refresh');
		//print_r($jt);
	}

	public function tes(){

		$code_string = ord("D");
		$code_string = chr(69);
		echo $code_string;
	}
}
