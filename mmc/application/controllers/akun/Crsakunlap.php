<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include(dirname(dirname(__FILE__)).'/Tglindo.php');
require_once(APPPATH.'controllers/Secure_area.php');

class crsakunlap extends Secure_area {
//class rjcregistrasi extends CI_Controller {
	public function __construct() {
			parent::__construct();
			$this->load->model('akun/mrsakun','',TRUE);
			$this->load->model('akun/mrsakunlap','',TRUE);
			$this->load->model('irj/rjmkwitansi','',TRUE);
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

	public function lapgl(){

		$data['title'] = 'Laporan GL Accounting';
		
		//if($_SERVER['REQUEST_METHOD']=='POST'){			
				$tgl_indo=new Tglindo();
				//$tgl_awal=$this->input->post('date_picker_days1');
				//if(){
				//}
				$koderek=$this->input->post('carikoderek');
				$tipebt=$this->input->post('tipe_bt');
				
				$tglawal=$this->input->post('date_picker_days0');
				$tglakhir=$this->input->post('date_picker_days1');					
				if($tglawal=='' || $tglakhir==''){
					$tglawal=date('Y-m-d', strtotime("-6 days"));
					$tglakhir=date('Y-m-d');
				}
				
				
					$data['data_laporan_kunj']=$this->mrsakunlap->get_data_lapgl($tglawal,$tglakhir,$tipebt,$koderek)->result();
					$data['data_tindakan']=$this->mrsakunlap->get_data_detailgl($tglawal,$tglakhir,$tipebt,$koderek)->result();
				
				$tgl1 = date('d F Y', strtotime($tglawal));$tgl2 = date('d F Y', strtotime($tglakhir));
				$data['date_title']="Laporan GL Accounting <b>$tgl1 - $tgl2</b>";
				$data['field1']='No. Medrec';					
				$data['tgl_awal']=$tglawal;				
				$data['tgl_akhir']=$tglakhir;
				
				$data['carikoderek']=$koderek;
				$data['caribt']=$tipebt;				
			
				$size=sizeof($data['data_laporan_kunj']);
				//$data['size']=$size;
				if($size<1){
				//echo "hahahaha";
				$data['message_nodata']="<div class=\"content-header\">
				<div class=\"alert alert-danger alert-dismissable\">
					<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
				<h4><i class=\"icon fa fa-close\"></i>
					Tidak Ditemukan Data
				</h4>							
				</div>
			</div>";
				$data['size']='';
				}else{
					//echo "hahahahdwadawdwafawfeagageaga";
					$data['message_nodata']='';
					$data['size']=$size;
				}

			$this->load->view('akun/v_lapgl.php',$data);
		/*}else{
			$data['data_laporan_kunj']=$this->Frmmlaporan->get_data_kunj_today()->result();
			$data['data_tindakan']=$this->Frmmlaporan->get_data_tindakan()->result();
			
			$data['date_title']='Laporan Kunjungan Pasien Farmasi <b>'.date("d F Y").'</b>';
			$data['tgl']=date("Y-m-d");
			$data['field1']='No. Medrec';	
			
			$size=sizeof($data['data_laporan_kunj']);			

			if($size<1){
				//
				$data['message_nodata']="<div class=\"content-header\">
				<div class=\"alert alert-danger alert-dismissable\">
					<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
				<h4><i class=\"icon fa fa-close\"></i>
					Tidak Ditemukan Data
				</h4>							
				</div>
			</div>";
				$data['size']='';
				}else{
					
					$data['message_nodata']='';
					$data['size']=$size;
				}

			$this->load->view('akun/v_lapgl.php',$data);
		}	*/	
	}

	function cetak_lap_pdf($tgl_awal,$tgl_akhir,$koderek='',$tipebt=''){
		if($tgl_awal!='' and $tgl_akhir!=''){
			
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamat=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			
			if($koderek=='0'){
				$kode='';
			}else
				$kode=$koderek;
			
			if($tipebt==''){
				$bt='';
			}else
				$bt=$tipebt;
			
			//set timezone
			date_default_timezone_set("Asia/Bangkok");
			$tgl_jam = date("d-m-Y H:i:s");
			$tgl1=date('d-m-Y', strtotime($tgl_awal));
			$tgl2=date('d-m-Y', strtotime($tgl_akhir));
						
			//$tglawal,$tglakhir,$tipebt,$koderek
			$data_laporan_kunj=$this->mrsakunlap->get_data_lapgl($tgl_awal,$tgl_akhir,$bt,$kode)->result();
			$data_tindakan=$this->mrsakunlap->get_data_detailgl($tgl_awal,$tgl_akhir,$bt,$kode)->result();

			$i=1;
					$vtot_banyak=0;$vtot4=0;
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
								<td colspan=\"3\"><p align=\"center\"><br><b>Laporan GL Accounting</b></p></td>
							</tr>
							<tr>
								<td>$namars</td>
							</tr>
						</table>
						<table >							
							<tr>
								<td width=\"10%\"><b>Tanggal</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$tgl1 s/d $tgl2</td>
							</tr>
						</table>
						<br/><hr/>	
				
					<table border=\"1\"   style=\"padding:2px\">
						<thead>
							<tr>
								<th width=\"3%\">No</th>
								<th width=\"10%\">No Voucher</th>
								<th width=\"7%\">Ket</th>
								<th width=\"10%\">Tgl Entry</th>		
								<th align=\"center\" width=\"70%\">Rincian Transaksi</th>								 
							</tr>
						</thead>
						<tbody>
							
			";
			
			/*
						<tr>
							<td>Biaya Karcis</td>
							<td> : </td>
							<td><b><font size=\"10\">Rp ".number_format( $row->biayadaftar, 2 , ',' , '.' )."</font></b></td>
						</tr>
			*/

					
					foreach($data_laporan_kunj as $row){
						$novoucher=$row->novoucher;
						$vtot_banyak=$vtot_banyak+$row->banyak;
						$konten=$konten."<tr>
							<td width=\"3%\">".$i++."</td>
							<td width=\"10%\">".$row->novoucher."</td>
							<td width=\"7%\">".$row->vouchket."</td>
							<td width=\"10%\">".date('d-m-Y', strtotime($row->tglentry))."</td>
							<td width=\"70%\">";
					
						$konten=$konten."<table width=\"100%\" >
						<thead>
							<tr class=\"border_bottom\">
								<th width=\"3%\">No</th>
								<th width=\"17%\">Kode Rekening</th>
								<th width=\"11%\">Tgl Transaksi</th>
								<th width=\"20%\">Nilai</th>
								<th width=\"20%\">BT</th>
								<th>PIC</th>
								<th width=\"15%\">Ket</th>									 
							</tr>
						</thead>
						<tbody>";
						
						$j=1;$vtot=0;$vtotkredit=0;$vtotdebet=0;
						foreach($data_tindakan as $row2){
							if($novoucher==$row2->novoucher){
								$vtot=$vtot+$row2->Nilai;
								if($row2->tipebt=='K'){
									$vtotkredit=$vtotkredit+(double)$row2->Nilai;
								}else
									$vtotdebet=$vtotdebet+(double)$row2->Nilai;
								$konten=$konten."<tr class=\"border_bottom\"><td>".$j."</td>
									<td> (".$row2->koderek.") ".$row2->perkiraan."</td>
									<td>".date('d-m-Y',strtotime($row2->tgltransaksi))."</td>
									<td>(".$row2->tipebt.") Rp. ".$row2->Nilai."</td>";
								if($row2->kodebt!=''){
									$konten=$konten."<td>(".$row2->kodebt.") ".$row2->btma."</td>";
								}else $konten=$konten."<td >-</td>";
								$konten=$konten."<td>".$row2->pic."</td>
									<td>".$row2->ket."</td></tr>";
								$j++;
							}
						}
						(double)$vtot3=(double)$vtotkredit-(double)$vtotdebet;
						$vtot4=$vtot4+$vtot3;
						$konten=$konten."<tr>
							<td colspan=\"3\"><p align=\"right\">Total&nbsp;&nbsp;&nbsp;&nbsp;</p></td>							
							<td><p align=\"left\">$vtot3</p></td>									 
						</tr>";
						$konten=$konten."</tbody>
						</table>
					</td>

				</tr>";
						
			}
			$konten=$konten."</tbody>
					</table>
					<h4 align=\"center\"><b>Total Voucher : ".($i-1)."<b></h4>
					<h4 align=\"center\"><b>Total Transaksi : ".$vtot_banyak."<b></h4>
					<h4 align=\"center\"><b>Total Rupiah : ".$vtot4."<b></h4>";//echo $konten;
			$file_name="Laporan_$tgl_awal-$tgl_akhir.pdf";
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);				
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
				$obj_pdf->Output(FCPATH.'/download/akun/lap/'.$file_name, 'FI');
		}else{
			redirect('irj/rjcregistrasi','refresh');
		}
	}

	function cetak_lap_excel($tgl_awal,$tgl_akhir,$koderek='',$tipebt=''){
		$data['title'] = 'Laporan GL Accounting';

		$tgl_indo=new Tglindo();
		
		$tgl1=date('d-m-Y', strtotime($tgl_awal));
		$tgl2=date('d-m-Y', strtotime($tgl_akhir));

		if($koderek=='0'){
				$kode='';
			}else
				$kode=$koderek;
			
			if($tipebt==''){
				$bt='';
			}else
				$bt=$tipebt;
			
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		//print_r($tampil);
		$namars=$this->config->item('namars');
		$kota_kab=$this->config->item('kota');
		$alamat=$this->config->item('alamat');
		$nmsingkat=$this->config->item('namasingkat');
		////EXCEL 
		//$this->load->library('Excel');  
		$this->load->file(APPPATH.'third_party/PHPExcel.php');   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy("HMIS")  
		        ->setTitle("Laporan GL Accouting RS")  
		        ->setSubject("Laporan HMIS Document")  
		        ->setDescription("Laporan HMIS for Office 2007 XLSX, generated by HMIS.")  
		        ->setKeywords("HMIS")  
		        ->setCategory("Laporan GL Accounting");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);


				//$tgl=$param1;
				//$tgl1 = date('d F Y', strtotime($tgl));				
				//$data_laporan_kunj=$this->ModelLaporan->get_data_kunj_range($tgl)->result();
				$data_laporan_kunj=$this->mrsakunlap->get_data_lapgl($tgl_awal,$tgl_akhir,$bt,$kode)->result();
				$data_tindakan=$this->mrsakunlap->get_data_detailgl($tgl_awal,$tgl_akhir,$bt,$kode)->result();
				//$data_keuangan=$this->ModelLaporan->get_data_keuangan_tgl($tgl)->result();
					
				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_gl_accounting.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  
				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$tgl1.' s/d '.$tgl2);

				$vtot1=0;$vtot_banyak=0;$vtot4=0;
				$i=1;
				$rowCount = 6;
				$cek=0;
				foreach($data_laporan_kunj as $row){
					$novoucher=$row->novoucher;
					$vtot_banyak=$vtot_banyak+$row->banyak;					
					$j=1;		
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
						$objPHPExcel->getActiveSheet()->
							setCellValueExplicit(
								'B'.$rowCount, 
								$row->novoucher, 
								PHPExcel_Cell_DataType::TYPE_STRING
						);
//SetCellValue('B'.$rowCount, $row->no_medrec);
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->vouchket);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, date('d-m-Y', strtotime($row->tglentry)));
						$j=1;$vtot=0;$i++;$vtotkredit=0;$vtotdebet=0;
						foreach($data_tindakan as $row2){
							if($novoucher==$row2->novoucher){
							$vtot=$vtot+$row2->Nilai;
							if($row2->tipebt=='K'){
									$vtotkredit=$vtotkredit+(double)$row2->Nilai;
							}else
								$vtotdebet=$vtotdebet+(double)$row2->Nilai;
							
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $j);
							$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, '('.$row2->koderek.') '.$row2->perkiraan);
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, date('d-m-Y', strtotime($row2->tgltransaksi)));
							$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row2->Nilai);
							if($row2->kodebt!=''){$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, '('.$row2->kodebt.') '.$row2->btma);}else $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, '-');
							$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row2->pic);
							$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row2->ket);
							$cek=1;
							$j++;			
							$rowCount++;
						}else{
							$cek=2;
										
							//$rowCount++;
							}
						}
						(double)$vtot3=(double)$vtotkredit-(double)$vtotdebet;
						$vtot4=$vtot4+$vtot3;
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Total');
							$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $vtot3);
						// if
						$rowCount++;
				}
				
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total Voucher');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,  $i);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount)->applyFromArray(
				    array(
					'fill' => array(
					    'type' => PHPExcel_Style_Fill::FILL_SOLID,
					    'color' => array('rgb' => 'C1B2B2')
					)
				    )
				);
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total Transaksi');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,  $vtot_banyak);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount)->applyFromArray(
				    array(
					'fill' => array(
					    'type' => PHPExcel_Style_Fill::FILL_SOLID,
					    'color' => array('rgb' => 'C1B2B2')
					)
				    )
				);
				$rowCount++;
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total Rupiah');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,  $vtot4);
				$objPHPExcel->getActiveSheet()->getStyle('D'.$rowCount)->applyFromArray(
				    array(
					'fill' => array(
					    'type' => PHPExcel_Style_Fill::FILL_SOLID,
					    'color' => array('rgb' => 'C1B2B2')
					)
				    )
				);
				
				header('Content-Disposition: attachment;filename="Lap_GL_Account_TGL_'.$tgl1.'_'.$tgl2.'.xlsx"');  														
					

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
	
}
?>
