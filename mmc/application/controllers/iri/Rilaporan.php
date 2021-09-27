<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include(dirname(dirname(__FILE__)).'/Tglindo.php');

require_once(APPPATH.'controllers/Secure_area.php');
class Rilaporan extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('iri/Rimlaporan');
		$this->load->model('ird/ModelKwitansi');
		$this->load->model('iri/rimpasien');
		$this->load->helper('pdf_helper');
	}

	//keperluan tanggal
	public function obj_tanggal(){
		 $tgl_indo = new Tglindo();
		 return $tgl_indo;
	}

	public function index(){
		
		$data['title'] = 'Laporan Pendapatan Rawat Inap';			
		
		if($this->input->post('plgCheckbox')!='' and $this->input->post('noCheckbox')!=''){
			$status='3';
			$data['stat_pilih']='';
		}
		else if($this->input->post('plgCheckbox')!='') {
			$status=$this->input->post('plgCheckbox');			
		//echo $stat_plg;
			$data['stat_pilih']='Pulang';
		}
		else if($this->input->post('noCheckbox')!=''){
			$status=$this->input->post('noCheckbox');
			$data['stat_pilih']='Dirawat';
		}
		else {
			$status='1';
			$data['stat_pilih']='Pulang';
		}

		if($this->input->post('date_picker_days0')!=''){
			$tgl0=$this->input->post('date_picker_days0');
		}else{
			$tgl0=date('Y-m-d', strtotime('-7 days'));
		}

		if($this->input->post('date_picker_days1')!=''){
			$tgl1=$this->input->post('date_picker_days1');
		}else{
			$tgl1=date('Y-m-d');
		}
		
		$data['status']=$status;
		//$tgl_indo=new Tglindo();		
		if($_SERVER['REQUEST_METHOD']=='POST'){
				$tampil_per=$this->input->post('tampil_per');			

				//echo '<script type="text/javascript">window.open("'.site_url("iri/rilaporan/export_excel/$tampil_per$status/$tgl0/$tgl1").'", "_blank");window.focus()</script>';

				if($tampil_per=='TGL'){
					$tgl=$this->input->post('date_picker_days');
					//print_r($tgl.' '.$status);
					//echo $status;
					//$tgl_akhir=$this->input->post('date_picker_days2');
					/*if($this->input->post('plgCheckbox')!='' and $this->input->post('noCheckbox')!=''){
						$data['data_laporan_keu']=$this->Rimlaporan->get_data_keu_tind_in($tgl_awal,$tgl_akhir,)->result();
						$data['stat_pilih']='';
					}
					else if($this->input->post('plgCheckbox')!='') {
						$stat_plg=$this->input->post('plgCheckbox');
						$data['data_laporan_keu']=$this->Rimlaporan->get_data_keu_tind_tgl($tgl_awal,$tgl_akhir,$stat_plg)->result();
						//echo $stat_plg;
						$data['stat_pilih']='Pulang';
					}
					else{
						$stat_no=$this->input->post('noCheckbox');
						$data['data_laporan_keu']=$this->Rimlaporan->get_data_keu_tind_tgl($tgl_awal,$tgl_akhir,$stat_no)->result();
						$data['stat_pilih']='Dirawat';
					}*/
					$data['data_laporan_keu']=$this->Rimlaporan->get_data_keu_tind_tgl($tgl0,$tgl1,$status)->result();
					//print_r($this->Rimlaporan->get_data_keu_tind_tgl($tgl,$status)->result());
					$tgl1= date('d F Y', strtotime($tgl0));
					$tgl11= date('d F Y', strtotime($tgl1));
					
					$data['date_title']="<b>$tgl1 - $tgl11</b>";
					$data['field1']='No. Register';
					$data['tgl']=$tgl;
					$data['psn']='';
					
					
				}else if($tampil_per=='BLN'){
					
					if($this->input->post('jenis_pasien1')!='0'){
						$psn=$this->input->post('jenis_pasien1');
			
					}		
					else {
						$psn='0';
			
					}
					$data['psn']=$psn;
					//echo $this->input->post('jenis_pasien1');
					

					$bln=$this->input->post('date_picker_months');							
					
					$data['data_laporan_keu']=$this->Rimlaporan->get_data_keu_tind_bln($bln,$status,$psn)->result();
					$bln1 = date('Y', strtotime($bln));
					$bln2 = date('m', strtotime($bln));
					$bln3 = $tgl_indo->bulan($bln2);
					//echo $tgl_indo->bulan('08');
					$data['date_title']="per Hari <b>Bulan $bln3 $bln1</b>";
					$data['field1']='Tanggal';
					$data['bln']=$bln;
					$data['date']=$bln;//untuk param waktu cetak

				}else{					
					if($this->input->post('jenis_pasien2')!='0'){
						$psn=$this->input->post('jenis_pasien2');
						
					}		
					else {
						$psn='0';
			
					}
					
					$data['psn']=$psn;
					
					$thn=$this->input->post('date_picker_years');
					$data['data_laporan_keu']=$this->Rimlaporan->get_data_keu_tind_thn($thn,$status,$psn)->result();
					//print_r($data);
					$data['date_title']="per Bulan <b> Tahun $thn</b>";
					$data['field1']='Bulan';
					$data['date']=$thn;//untuk param waktu cetak
					$data['thn']=$thn;
					$data['tgl_indo']=$tgl_indo;
				}
				$data['tampil_per']=$this->input->post('tampil_per');//untuk param waktu cetak
				
				$size=sizeof($data['data_laporan_keu']);
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

			$this->load->view('iri/pend_today',$data);
		}else{			
			$data['data_laporan_keu']=$this->Rimlaporan->get_data_keu_tindakan_today()->result();
			$data['date_title']='<b>'.date("d F Y").'</b>';
			$data['tgl']=date("Y-m-d");
			$data['field1']='No. Register';
			$data['stat_pilih']='';
			$data['tampil_per']='TGL';
			$data['psn']='';
			$size=sizeof($data['data_laporan_keu']);
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
			
			$this->load->view('iri/pend_today',$data);
			//redirect('ird/IrDLaporan/data','refresh');
		}					
	}
	
	////////////////////////////////////////////////
	public function export_excel($tampil_per='',$param1='',$param2='')
	{
		$data['title'] = 'Laporan Keuangan Rawat Inap';

		$tgl_indo=new Tglindo();

		$tampil = substr($tampil_per, 0, 3);
		//print_r($tampil);
		
		if(substr($tampil_per,-1)!=''){
			$status = substr($tampil_per, -1);
			//print_r($status);
		}

		$tampil_per=$tampil;
		if($param2!='' && $tampil_per=='TGL'){
			$tgl00=$param2;
		}else if($param2!=''){
			$psn=$param2;
		}

		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		//print_r($tampil);
		$namars=$this->config->item('namars');
		$kota_kab=$this->config->item('kota');
		$alamat=$this->config->item('alamat');
		$nmsingkat=$this->config->item('namasingkat');
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator($namars)  
		        ->setLastModifiedBy($namars)  
		        ->setTitle("Laporan Keuangan ".$namars)  
		        ->setSubject("Laporan Keuangan ".$namars." Document")  
		        ->setDescription("Laporan Keuangan ".$namars." for Office 2007 XLSX, generated by HMIS.")  
		        ->setKeywords($namars)  
		        ->setCategory("Laporan Keuangan");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);


		////		
		if($tampil_per=='TGL'){	
			if($param1!=''){

				$tgl0=$param1;
				$tgl1 = date('d F Y', strtotime($tgl0));	
				$tgl11 = date('d F Y', strtotime($tgl00));			
				$data_laporan_keu=$this->Rimlaporan->get_data_keu_tind_tgl($tgl0,$tgl00,$status)->result();
				//$data_keuangan=$this->Rimlaporan->get_data_keuangan_tgl($tgl)->result();
					
				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_iri_tgl.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  
				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$tgl1.' - '.$tgl11);

				$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('E4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('F4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('G4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('H4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('I4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('J4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('K4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('L4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('M4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('N4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('O4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('O4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('P4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('P4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('Q4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('Q4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('R4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('R4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('S4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('S4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('T4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('T4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('U4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('U4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('V4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('V4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('W4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('W4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('X4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('X4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('Y4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('Y4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('Z4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('Z4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->getStyle('AA4')->getFont()->setBold(true);
      			$objPHPExcel->getActiveSheet()->getStyle('AA4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      			$objPHPExcel->getActiveSheet()->setAutoFilter('A4:AA4');
				if($status=='1'){
					$stat="Pulang";
				}else if($status=='0'){
					$stat="Dirawat";
				}else
					$stat="Pulang dan Dirawat";
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Pasien : '.$stat);

				$vtot1=0;$vtot2=0;$vtotlab=0;$vtotrad=0;$vtotok=0;$vtotobat=0;$vtotmatkes=0;$vtotadm=0;$vtotjasa=0;
				$i=1;$vtotkamar=0;$vtottunai=0;$vtoticu=0;$vtotvk=0;$vtotdaftar=0;$vtotmaterai=0;$vtotdiskon=0;$vtottotal=0;
				$rowCount = 5;$total=0;
				$vtotmedis=0;$vtotparamedis=0;
				foreach($data_laporan_keu as $row){
					$no_ipd=$row->no_ipd;					
					$vtot1=$vtot1+$row->total;
					$vtot2=$vtot2+$row->diskon;
					$vtotkamar+=$row->vtot_ruang;
					$vtotlab+=$row->vtot_lab;
					$vtotrad+=$row->vtot_rad;
					$vtotok+=$row->vtot_ok;
					$vtotobat+=$row->vtot_obat;
					$vtotmatkes+=$row->matkes_iri;
					$vtotadm+=$row->biaya_administrasi;
					$vtotjasa+=$row->jasa_perawat;
					$vtottunai+=$row->tunai;
					$vtoticu+=$row->vtot_kamaricu;
					$vtotvk+=$row->vtot_kamarvk;
					$vtotmaterai+=6000;
					$vtotdiskon+=$row->diskon;
					$vtotdaftar+=$row->biaya_daftar;


					$total=$row->total;
					$vtottotal+=$total;
					$j=1;		
					 
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->
								setCellValueExplicit(
									'B'.$rowCount, 
									$row->no_cm, 
									PHPExcel_Cell_DataType::TYPE_STRING
								    );
//SetCellValue('B'.$rowCount, $row->no_medrec);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_ipd);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, strtoupper($row->nama));
								//cara bayar
								if($row->carabayar=='UMUM'){
									$textcb=$row->carabayar;
								}else{
									$textcb=$row->nmkontraktor;
								}
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,$textcb );
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->ruang);
								$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->rawat);

								//biaya kamar
								$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, (int)$row->vtot_ruang);
								$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, (int)$row->vtot_kamaricu);
								$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, (int)$row->vtot_kamarvk);

								$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, (int)$row->vtot_lab);
								$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, (int)$row->vtot_rad);
								$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, (int)$row->vtot_obat);
								$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, (int)$row->vtot_ok);
								$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, (int)$row->matkes_iri);

								$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, (int)$row->biaya_administrasi);
								$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, (int)$row->vtot_medis);
								$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, (int)$row->vtot_paramedis);
								$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, (int)$row->jasa_perawat);
								$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, (int)6000);
								$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, (int)$row->biaya_daftar);
								$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, (int)$total);
								$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, (int)$row->diskon);
								$objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, (int)$row->tunai);
								$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, $row->status);
								$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, $row->lunas);
								$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, $row->no_sep);
							 	$i++;
							 								
						$rowCount++;
						// if					
				}				
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,  $vtotkamar);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $vtoticu);				
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $vtotvk);
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $vtotlab);
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount,  $vtotrad);
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $vtotobat);
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount,  $vtotok);
				$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $vtotmatkes);
				$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $vtotadm);
				$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount,  $vtotmedis);
				$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $vtotparamedis);				
				$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $vtotjasa);
				$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount,  $vtotmaterai);
				$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $vtotdaftar);				
				$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $vtottotal);
				$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount,  $vtotdiskon);
				$objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $vtottunai);

				header('Content-Disposition: attachment;filename="Lap_Keu_IRI_TGL_'.date('d-m-Y', strtotime($tgl0)).'_'.date('d-m-Y', strtotime($tgl00)).'.xlsx"');  
					
			}else{
				redirect('iri/rilaporan/','refresh');
			}
		}else if($tampil_per=='BLN'){
			if($param1!=''){
				$bln=$param1;
				$blnindo=$tgl_indo->bulan(date('m', strtotime($bln)));
				$bln1 = $blnindo.' '.date('Y', strtotime($bln));
				$psn=$param2;
				if($psn!=''){					
					$data_keuangan=$this->Rimlaporan->get_data_keu_tind_bln($bln, $status,$psn)->result();
				}

				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_iri_bln.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  

				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Bulan : '.$bln1);

				if($psn!='0'){
					if($psn!='BPJS'){
						$jenis_param2=ucfirst(strtolower($psn));
					} else {
							$jenis_param2=$psn;
					}
				} else {
					$jenis_param2="Semua";
				}

				if($status=='1'){
					$stat="Pulang";
				}else if($status=='0'){
					$stat="Dirawat";
				}else
					$stat="Pulang dan Dirawat";
				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Pasien : '.$jenis_param2);
				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Status : '.$stat);
				$i=1;
				$vtottotal=0;$vtotkunj=0;
				$vtotdiskon=0;
				$vtot_pemeriksaan=0;
				$rowCount = 6;

				foreach($data_keuangan as $row){
						
							$bln3 = date('d', strtotime($row->tgl_layanan));
							$bln2 = date('m', strtotime($row->tgl_layanan));
							$bulan = $tgl_indo->bulan($bln2);
							$vtotkunj=$vtotkunj+$row->jum_tind;
							$vtottotal=$vtottotal+$row->total;
							$vtotdiskon=$vtotdiskon+$row->diskon;
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $bln3.' '.$bulan);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->jum_tind);
								$objPHPExcel->getActiveSheet()->
								setCellValue(
									'D'.$rowCount, 
									(int)$row->diskon
								    );
//SetCellValue('C'.$rowCount, $row->totdiskon);
								$objPHPExcel->getActiveSheet()->
								setCellValue(
									'E'.$rowCount, 
									(int)$row->total
								    );
//SetCellValue('D'.$rowCount, $row->total);
								
							 	$i++;
							
							$rowCount++;
						
				}// if
/*				foreach($data_periode as $row){
					$j=1;
					$vtottotal=0;
					$vtotjumpas=0;
					$vtotjumpem=0;
					foreach($data_keuangan as $row2){
						if($row2->tgl==$row->tgl){
							$bln3 = date('d', strtotime($row2->tgl));
							$bln2 = date('m', strtotime($row2->tgl));
							$bulan = $tgl_indo->bulan($bln2);
							$vtottotal=$vtottotal+$row2->total;
							$vtotjumpas=$vtotjumpas+$row2->jumlah_pasien;
							$vtotjumpem=$vtotjumpem+$row2->jumlah_pemeriksaan;
							$vtot=$vtot+$row2->total;
							$vtot_pasien=$vtot_pasien+$row2->jumlah_pasien;
							$vtot_pemeriksaan=$vtot_pemeriksaan+$row2->jumlah_pemeriksaan;
							if($j==1){ 
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $bln3.' '.$bulan);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_pasien);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jumlah_pemeriksaan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total);
							 	$i++;
							} else { 
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_pasien);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jumlah_pemeriksaan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total);
							}
							$j++;
							$rowCount++;
						} // if
					}
				}*/
				

				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtotkunj);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtotdiskon);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtottotal);				
				
				header('Content-Disposition: attachment;filename="Lap_Keu_IRI_Bulan_'.date('m-Y', strtotime($bln1)).'.xlsx"');  
			}
			else{
				redirect('ird/IrDLaporan/data_pendapatan','refresh');
			}
		}else{
			if($param1!=''){
				$thn=$param1;
				$thn1 = date('Y', strtotime($thn));
				
				$psn=$param2;
				$date_title='<b>'.$thn1.'</b>';
				$file_name="KEU_IRI_$thn1.pdf";

				//$data_laporan_keu=$this->Labmlaporan->get_data_keu_tind_thn($thn)->result();
				if($psn!=''){					
					$data_keuangan=$this->Rimlaporan->get_data_keu_tind_thn($thn, $status,$psn)->result();
				} 
				print_r($data_keuangan);
				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_iri_thn.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  

				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tahun : '.$thn);


				if($psn!='0'){
					if($psn!='BPJS'){
						$jenis_param2=ucfirst(strtolower($psn));
					} else {
						$jenis_param2=$param2;
					}
				} else {
					$jenis_param2="Semua";
				}
			
				if($status=='1'){
					$stat="Pulang";
				}else if($status=='0'){
					$stat="Dirawat";
				}else
					$stat="Pulang dan Dirawat";

				$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Pasien : '.$jenis_param2);
				$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'Status : '.$stat);
				$i=1;
				$vtottotal=0;$vtotkunj=0;
				$vtotdiskon=0;
				$vtot_pemeriksaan=0;
				$rowCount = 6;
				foreach($data_keuangan as $row){
					
							$thn = date('Y', strtotime($row->bulan));
							$bln2 = date('m', strtotime($row->bulan));
							$bulan = $tgl_indo->bulan($bln2);
							$vtotkunj=$vtotkunj+$row->jum_tind;
							$vtottotal=$vtottotal+$row->total;
							$vtotdiskon=$vtotdiskon+$row->diskon;
							
							$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
							$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $bulan.' '.$thn);
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->jum_tind);
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, (int)$row->diskon);
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, (int)$row->total);
							
							$i++;
							$rowCount++;

					
					}

				/*foreach($data_periode as $row){
					$j=1;
					$vtottotal=0;
					$vtotjumpas=0;
					$vtotjumpem=0;
					foreach($data_keuangan as $row2){
						if($row2->bln==$row->bln){
							$thn = date('Y', strtotime($row2->bln));
							$bln2 = date('m', strtotime($row2->bln));
							$bulan = $tgl_indo->bulan($bln2);
							$vtottotal=$vtottotal+$row2->total;
							$vtotjumpas=$vtotjumpas+$row2->jumlah_pasien;
							$vtotjumpem=$vtotjumpem+$row2->jumlah_pemeriksaan;
							$vtot=$vtot+$row2->total;
							$vtot_pasien=$vtot_pasien+$row2->jumlah_pasien;
							$vtot_pemeriksaan=$vtot_pemeriksaan+$row2->jumlah_pemeriksaan;
							if($j==1){ 
								$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
								$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $bulan.' '.$thn);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_pasien);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jumlah_pemeriksaan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total);
							 	$i++;
							} else { 
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->jenis_tindakan);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah_pasien);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->jumlah_pemeriksaan);
								$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->total);
							}
							$j++;
							$rowCount++;
						}
					}
				}*/

				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Total');
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $vtotkunj);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $vtotdiskon);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtottotal);
								
				header('Content-Disposition: attachment;filename="Lap_Keu_IRI_Tahun_'.$thn.'.xls"'); 
			}else{
				redirect('iri/rilaporan/','refresh');
			}
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
/////////////////////////////////////////////////////////////////////////////////////keuangan poli
	public function lap_keu($tampil_per='',$param1='',$param2='')
	{
		$data['title'] = 'Laporan Keuangan Rawat Inap';
		$tgl_indo=new Tglindo();
		$tampil = substr($tampil_per, 0, 3);
		//print_r($tampil);
		
		if(substr($tampil_per,-1)!=''){
			$status = substr($tampil_per, -1);
			//print_r($status);
		}

		$tampil_per=$tampil;
		if($param2!=''){
			$psn=$param2;
		}
				
		if($tampil_per=='TGL'){	
			if($param1!=''){
				$tgl=$param1;
				$tgl1 = date('d', strtotime($tgl));				
				$blnindo = $tgl_indo-> bulan(date('m', strtotime($tgl)));
					$date_title='<b>'.date('d', strtotime($tgl)).' '.$blnindo.' '.date('Y', strtotime($tgl)).'</b>';
					$file_name="KEU_TIND_".date('d', strtotime($tgl)).' '.$blnindo.' '.date('Y', strtotime($tgl)).".pdf";
				
			
				$namars=$this->config->item('namars');
				$kota_kab=$this->config->item('kota');
				$alamat=$this->config->item('alamat');
				$nmsingkat=$this->config->item('namasingkat');
				
				if($status=='1'){
					$ket_stat='<tr>
								<td width=\"10%\"><b>Status</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\"><b>Pulang</b></td>
							</tr>';					
				}
				else if($status=='0'){
					$ket_stat='<tr>
								<td width=\"10%\"><b>Status</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\"><b>Dirawat</b></td>
							</tr>';
				}else{
					$ket_stat='';
				}
				
				if($status=='3'){
					$tr_head="<td width=\"5%\"><b>No</b></td>
								<td width=\"10%\"><b>No Medrec</b></td>
								<td width=\"15%\"><b>No Register</b></td>
								<td width=\"25%\"><b>Nama</b></td>
								<td width=\"10%\"><b>Status</b></td>
								<td width=\"15%\" align=\"right\"><p><b>Potongan/<br>Dijamin</b></p></td>
								<td width=\"20%\" align=\"right\"><b>Biaya Tindakan</b></td>";
					

				}else{
					$tr_head="<td width=\"5%\"><b>No</b></td>
								<td width=\"15%\"><b>No Medrec</b></td>
								<td width=\"15%\"><b>No Register</b></td>
								<td width=\"25%\"><b>Nama</b></td>
								<td width=\"20%\" align=\"right\"><p><b>Potongan/<br>Dijamin</b></p></td>
								<td width=\"20%\" align=\"right\"><b>Biaya Tindakan</b></td>";
					
				}
				$data_laporan_keu=$this->Rimlaporan->get_data_keu_tind_tgl($tgl,$status)->result();
			
				$konten=
						"<table>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><br><b>LAPORAN KEUANGAN IRI</b></p></td>
							</tr>
							<tr>
								<td></td>
							</tr>
						</table>
						<table>							
							<tr>
								<td width=\"10%\"><b>Tanggal</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>
							$ket_stat
						</table>
						<br/><hr>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								$tr_head
							</tr>
						";
						$i=1;
						$vtot1=0;$vtot2=0;$vtot3=0;
						if($status=='3'){
							foreach($data_laporan_keu as $row){
							//$vtot1=$vtot1+$row->biayadaftar;
							$vtot2=$vtot2+$row->total;
							$vtot3=$vtot3+$row->diskon;
							//echo $row->status;
							if($row->status=='1'){ $det_stat="Pulang"; } else { $det_stat="Dirawat";}
							$konten=$konten."
							<tr>
								<td width=\"5%\">".$i++."</td>
								<td width=\"10%\">$row->no_cm</td>
								<td width=\"15%\">$row->no_ipd</td>
								<td width=\"25%\">".strtoupper($row->nama)."</td>
								<td width=\"10%\">$det_stat</td>
								<td width=\"15%\"><p align=\"right\">".number_format($row->diskon, 2 , ',' , '.' )."</p></td>
								<td width=\"20%\"><p align=\"right\">".number_format($row->total, 2 , ',' , '.' )."</p></td>
							</tr>";
							}
						}else{
							foreach($data_laporan_keu as $row){
								$vtot2=$vtot2+$row->total;
								$vtot3=$vtot3+$row->diskon;
								$konten=$konten."
								<tr>
									<td width=\"5%\">".$i++."</td>
									<td width=\"15%\">$row->no_cm</td>
									<td width=\"15%\">$row->no_ipd</td>
									<td width=\"25%\">".strtoupper($row->nama)."</td>
			
									<td width=\"20%\"><p align=\"right\">".number_format($row->diskon, 2 , ',' , '.' )."</p></td>
									<td width=\"20%\"><p align=\"right\">".number_format($row->total, 2 , ',' , '.' )."</p></td>
								</tr>";

							}						
						}
						/*<td width=\"10%\"><b>No Medrec</b></td>
								<td width=\"10%\"><b>No Register</b></td>
								<td width=\"35%\"><b>Nama</b></td>
								<td width=\"20%\"><b>Jumlah Tindakan</b></td>
								<td width=\"10%\"><b>Status</b></td>
								<td width=\"15%\" align=\"right\"><b>Total</b></td>*/
							if($status=='3'){ $col1=5; $col2=7; }else { $col1=4; $col2=6;}
							$konten=$konten."
							<tr>
								<th colspan=\"$col1\" bgcolor=\"#cdd4cb\"><p align=\"right\" ><b>Total   </b></p></th>								
								<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot3, 2 , ',' , '.' )."</p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot2, 2 , ',' , '.' )."</p></th>
							</tr>
							
						</table>
				";//print_r($konten);
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->setPrintHeader(false); //To remove first line on the top
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->SetHeaderData('', '', $title, '');
					$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
					$obj_pdf->SetDefaultMonospacedFont('helvetica');
					$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
					$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
					$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '20', PDF_MARGIN_RIGHT);
					$obj_pdf->SetAutoPageBreak(TRUE, '15');
					$obj_pdf->SetFont('helvetica', '', 11);
					$obj_pdf->setFontSubsetting(false);
					$obj_pdf->AddPage();
					ob_start();
						$content = $konten;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');
					$obj_pdf->Output(FCPATH.'download/inap/laporan/keu/'.$file_name, 'FI');
						
			}else{
				redirect('iri/rilaporan/','refresh');
			}
		}else if($tampil_per=='BLN'){
			if($param1!=''){
				$bln=$param1;
				$bln1 = date('F Y', strtotime($bln));
				$blnindo = $tgl_indo-> bulan(date('m', strtotime($bln)));				
				$date_title='<b>'.$blnindo.' '.date('Y', strtotime($bln)).'</b>';
				$file_name="KEU_TIND_$bln1.pdf";

				$namars=$this->config->item('namars');
				$kota_kab=$this->config->item('kota');
				$alamat=$this->config->item('alamat');
				$nmsingkat=$this->config->item('namasingkat');
				if($status=='1'){
					$ket_stat='<tr>
								<td width=\"10%\"><b>Status</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\"><b>Pulang</b></td>
							</tr>';
				}
				else if($status=='0'){
					$ket_stat='<tr>
								<td width=\"10%\"><b>Status</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\"><b>Dirawat</b></td>
							</tr>';
				}else{
					$ket_stat='';
				}
				
				if($psn=='0'){
					$ket_pasien='';					
				}else{
					$ket_pasien="<tr>
								<td width=\"10%\"><b>Status</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\"><b>$psn</b></td>
							</tr>";
				}
				$data_laporan_keu=$this->Rimlaporan->get_data_keu_tind_bln($bln, $status,$psn)->result();
			
				$konten=
						"<table>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><br><b>Laporan Keuangan IRI</b></p></td>
							</tr>
							<tr>
								<td></td>
							</tr>
						</table>
						<table >							
							<tr>
								<td width=\"10%\"><b>Tanggal</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>
							$ket_stat
							$ket_pasien
						</table>
						<br/><hr/>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td width=\"5%\"><b>No</b></td>
								<td width=\"25%\"><b>Hari</b></td>
								<td width=\"20%\"><b>Total Pasien</b></td>
								<td width=\"25%\" align=\"right\"><b>Total Potongan/Dijamin</b></td>
								<td width=\"25%\" align=\"right\"><b>Total Biaya Tindakan</b></td>
							</tr>
						";
						$i=1;
						$vtot1=0;$vtot2=0;$vtot3=0;$vtot4=0;
						foreach($data_laporan_keu as $row){
							$vtot1=$vtot1+$row->vtot;
							$vtot4=$vtot4+$row->jum_tind;
							$vtot3=$vtot3+$row->diskon;
							$konten=$konten."
							<tr>
								<td>".$i++."</td>
								<td>$row->hari</td>
								<td>$row->jum_tind</td>
								<td><p align=\"right\">".number_format($row->diskon, 2 , ',' , '.' )."</p></td>
								<td><p align=\"right\">".number_format($row->vtot, 2 , ',' , '.' )."</p></td>
							</tr>";
						}
							$konten=$konten."
							<tr>
								<th colspan=\"2\" bgcolor=\"#cdd4cb\"><p align=\"right\"><b>Total   </b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".$vtot4."</p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot3, 2 , ',' , '.' )."</p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot1, 2 , ',' , '.' )."</p></th>
							</tr>
							
						</table>
				";
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->setPrintHeader(false); //To remove first line on the top
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->SetHeaderData('', '', $title, '');
					$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
					$obj_pdf->SetDefaultMonospacedFont('helvetica');
					$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
					$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
					$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '20', PDF_MARGIN_RIGHT);
					$obj_pdf->SetAutoPageBreak(TRUE, '15');
					$obj_pdf->SetFont('helvetica', '', 11);
					$obj_pdf->setFontSubsetting(false);
					$obj_pdf->AddPage();
					ob_start();
						$content = $konten;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');
					$obj_pdf->Output(FCPATH.'download/inap/laporan/keu/'.$file_name, 'FI');
			}else{
				redirect('iri/rilaporan/','refresh');
			}
		}else{
			if($param1!=''){
				$thn=$param1;
				//print_r($status);
				$thn1 = date('Y', strtotime($thn));
								
				$date_title='<b>'.$thn1.'</b>';
				$file_name="IRI_KEU_TIND_$thn1.pdf";

				$namars=$this->config->item('namars');
				$kota_kab=$this->config->item('kota');
				$alamat=$this->config->item('alamat');
				$nmsingkat=$this->config->item('namasingkat');
				
				if($status=='1'){
					$ket_stat='<tr>
								<td width=\"10%\"><b>Status</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\"><b>Pulang</b></td>
							</tr>';
				}
				else if($status=='0'){
					$ket_stat='<tr>
								<td width=\"10%\"><b>Status</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\"><b>Dirawat</b></td>
							</tr>';
				}else{
					$ket_stat='';
				}

				if($psn=='0'){
					$ket_pasien='';					
				}else{
					$ket_pasien="<tr>
								<td width=\"10%\"><b>Pasien</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\"><b>$psn</b></td>
							</tr>";
				}
				$data_laporan_keu=$this->Rimlaporan->get_data_keu_tind_thn($thn, $status,$psn)->result();
			
				$konten=
						"<table>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><br><b>Laporan Keuangan IRI</b></p></td>
							</tr>
							<tr>
								<td></td>
							</tr>
						</table>
						<table >							
							<tr>
								<td width=\"10%\"><b>Bulan</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>
							$ket_stat
							$ket_pasien
						</table>
						<br/><hr/>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td width=\"5%\"><b>No</b></td>
								<td width=\"25%\"><b>Bulan</b></td>
								<td width=\"20%\"><b>Total Pasien</b></td>
								<td width=\"25%\"><b>Total Potongan/Dijamin</b></td>
								<td width=\"25%\" align=\"right\"><b>Total Biaya Tindakan</b></td>
							</tr>
						";
						$i=1;
						$vtot1=0;$vtot3=0;$vtot4=0;
						foreach($data_laporan_keu as $row){
							$vtot1=$vtot1+$row->total;
							$vtot3=$vtot3+$row->diskon;
							$vtot4=$vtot4+$row->jum_tind;
							$konten=$konten."
							<tr>
								<td>".$i++."</td>
								<td>".$tgl_indo->bulan(date('m', strtotime($row->bulan)))."</td>
								<td><p align=\"right\">".$row->jum_tind."</p></td>
								<td><p align=\"right\">".number_format($row->diskon, 2 , ',' , '.' )."</p></td>
								<td><p align=\"right\">".number_format($row->total, 2 , ',' , '.' )."</p></td>
							</tr>";
						}
							$konten=$konten."
							<tr>
								<th colspan=\"2\" bgcolor=\"#cdd4cb\"><p align=\"right\"><b>Total   </b></p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".$vtot4."</p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot3, 2 , ',' , '.' )."</p></th>
								<th bgcolor=\"yellow\"><p align=\"right\">".number_format($vtot1, 2 , ',' , '.' )."</p></th>
							</tr>
							
						</table>
				";
			//print_r($data_laporan_keu);
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->setPrintHeader(false); //To remove first line on the top
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->SetHeaderData('', '', $title, '');
					$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
					$obj_pdf->SetDefaultMonospacedFont('helvetica');
					$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
					$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
					$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '20', PDF_MARGIN_RIGHT);
					$obj_pdf->SetAutoPageBreak(TRUE, '15');
					$obj_pdf->SetFont('helvetica', '', 11);
					$obj_pdf->setFontSubsetting(false);
					$obj_pdf->AddPage();
					ob_start();
						$content = $konten;
					ob_end_clean();
					$obj_pdf->writeHTML($content, true, false, true, false, '');
					$obj_pdf->Output(FCPATH.'download/inap/laporan/keu/'.$file_name, 'FI');
			}else{
				redirect('iri/rilaporan/','refresh');
			}
		}
	}
}
