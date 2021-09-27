<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
include(dirname(dirname(__FILE__)).'/Tglindo.php');
class Frmcpo extends Secure_area
{
  public function __construct(){
      parent::__construct();
      $this->load->model('farmasi/Frmmdaftar','',TRUE);
      $this->load->model('logistik_farmasi/Frmmpo','',TRUE);
      $this->load->model('master/Mmobat','',TRUE);
      $this->load->helper('pdf_helper');
  }
  
	function index()
	{
		$data['title'] = 'Monitoring PO Farmasi';
		$data['select_pemasok'] = $this->Frmmpo->get_suppliers();
		$this->load->view('logistik_farmasi/Frmvpo',$data);
	}
	
	function form()
	{
		$data['title'] = 'Form PO Farmasi';
		$data['select_pemasok'] = $this->Frmmpo->get_suppliers();
		$data['no_po'] = $this->Frmmpo->getNomorPO();
        $data['data_obat']=$this->Mmobat->get_all_obat()->result();
        $data['obat_satuan'] = $this->Frmmpo->getSatuanObat()->result();
		$this->load->view('logistik_farmasi/Frmvaddpo',$data);
	}
	
    function save(){	
    	/*echo "<pre>";
    	echo print_r( $this->input->post() );
    	echo "</pre>";*/
		$id_po = $this->Frmmpo->insert($this->input->post());
		$no_po = $this->input->post('no_po');
		$jenis_pesanan = $this->input->post('sumber_dana');
		$supplier_id = $this->input->post('supplier_id');
        $supplier = $this->Frmmpo->getNamaSupplier($supplier_id);

		if ( $id_po != '' ){
			$msg = 	' <div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-check"></i>Data PO berhasil disimpan
					  </div>';
		}else{				
			$msg = 	' <div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-ban"></i>Data PO gagal disimpan
					  </div>';
		}
        $this->session->set_flashdata('alert_msg', $msg);
        $this->cetak_faktur($id_po, $no_po, $jenis_pesanan, $supplier->adress);
        $this->session->set_flashdata('cetak', 'cetak('.$id_po.');');
        redirect('logistik_farmasi/Frmcpo/form');
		
  }
  
	public function get_satuan_obat(){
		$data = $this->Frmmpo->get($this->input->post('id'));
		echo $data->satuank."|".$data->hargabeli;
	}

    public function cari_data_obat(){
        $login_data = $this->load->get_var("user_info");
        $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

        $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
        $i=1;

        foreach ($id_gudang as $row) {
            $no_gudang[]=$row->id_gudang;
        }

        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);
        if($group->id_gudang == "8" || $group->id_gudang == "7"){
            $ids = "1";
        }else{
            $ids = join("','",$no_gudang);
        }

        $keyword = $this->uri->segment(4);
        /*$data = $this->db->select('o.`id_obat`, o.`nm_obat`, o.`hargabeli`, o.`hargajual`, g.`batch_no`, g.`expire_date`, g.`qty`, o.`jenis_obat`')
            ->from('master_obat o')
            ->join('gudang_inventory g', 'o.id_obat = g.id_obat', 'inner')
            ->where('g.id_gudang', $ids)
            ->like('o.nm_obat',$keyword)->limit(20, 0)->get()->result();*/
        $data = $this->db->query("SELECT o.`id_obat`, o.`nm_obat`, o.`hargabeli`, o.`hargajual`, o.`satuank`,o.`satuanb`,o.`faktorsatuan`, g.`batch_no`, g.`expire_date`, g.`qty`, o.`jenis_obat`
                                FROM master_obat o
                                LEFT JOIN gudang_inventory g ON o.id_obat = g.id_obat
                                WHERE o.`nm_obat` LIKE '%".$keyword."%' LIMIT 20")->result();
        $arr='';
        if(!empty($data)){
            foreach($data as $row)
            {
                $arr['query'] = $keyword;
                $arr['suggestions'][] = array(
                    'value'	=> $row->nm_obat." (".$row->batch_no.",".$row->expire_date.",".$row->qty.")",
                    'idobat' => $row->id_obat,
                    'nama'	=>$row->nm_obat,
                    'harga' => $row->hargajual,
                    'hargabeli' => $row->hargabeli,
                    'satuank' => $row->satuank,
                    'satuanb' => $row->satuanb,
                    'faktorsatuan' => $row->faktorsatuan,
                    'batch_no' => $row->batch_no,
                    'expire_date' => $row->expire_date,
                    'qty' => $row->qty,
                    'jenis_obat' => $row->jenis_obat
                );
            }
        }
        // minimal PHP 5.2
        echo json_encode($arr);
    }
	
	public function auto_no_po(){
		$keyword = $this->uri->segment(4);
		$data = $this->db->from('header_po')->like('no_po',$keyword)->limit(12, 0)->get()->result();	

		foreach($data as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'value'	=>$row->no_po,
				'id' => $row->id_po
			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}
	
    function get_info(){
		$id = $this->input->post('id');
		echo json_encode($this->Frmmpo->get_info($id));
		//echo json_encode($this->Frmmpo->get_header_po($id)->row());
    }
    function get_po_list(){		
		//print_r($this->input->post());
		$line  = array();
		$line2 = array();
		$row2  = array();
		if(sizeof($_POST)==0) {
			$line['data'] = $line2;
		}else{		
			$hasil = $this->Frmmpo->get_po_list($this->input->post());
			/*$line['data'] = $hasil;*/			
			foreach ($hasil as $value) {
				$row2['id_po'] = $value->id_po;
				$row2['no_po'] = $value->no_po;
				$row2['tgl_po'] = $value->tgl_po;
				$row2['company_name'] = $value->company_name;
				//$row2['supplier'] = $value->company_name;
				$row2['sumber_dana'] = $value->sumber_dana;
				$row2['user'] = $value->user;

				//$row2['no_faktur'] = $value->no_faktur;
				if ($value->open > 0)
					$row2['status'] = '<font color="red">Open</font>';
				else
					$row2['status'] = '<font color="green">Closed</font>';
				$row2['aksi'] = '<center>
				<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailModal" data-id="'.$value->id_po.'" data-no="'.$value->no_po.'" data-open="'.$value->open.'">Detail</button> 
							</center>';
							
				$line2[] = $row2;
			}
			$line['data'] = $line2;
			
		}
		echo json_encode($line);
    }
    function get_detail_list(){		
		$line  = array();
		$line2 = array();
		$row2  = array();
		$hasil = $this->Frmmpo->get_po_detail_list($this->input->post('id'));
		
		$total = 0;
		foreach ($hasil as $value) {
			$row2['item_id'] = $value->item_id;
			$row2['description'] = $value->description;
			$row2['satuank'] = $value->satuank;
			$row2['qty_po'] = "<p align='right'>".number_format($value->qty, '0', ',', '.')."</p>";
			$row2['qty_beli'] = $value->qty_beli;
			$row2['batch_no'] = $value->batch_no;
			$row2['keterangan'] = $value->keterangan;	
			$row2['expire_date'] = $value->expire_date;
			$row2['hargabeli'] = "<p align='right'>".number_format($value->harga_po, '0', ',', '.')."</p>";
			$row2['subtotal'] = "<p align='right'>".number_format($value->subtotal, '0', ',', '.')."</p>";
			$row2['jml_kemasan'] = "<p align='right'>".number_format($value->jml_kemasan, '0', ',', '.')."</p>";
			$row2['harga_item'] = "<p align='right'>".number_format($value->harga_item, '0', ',', '.')."</p>";
			$total += $value->subtotal;
			$line2[] = $row2;
		}
		$line['data'] = $line2;
		$line['total'] = number_format($total, '2', ',', '.');
			
		echo json_encode($line);
    }
	public function cetak_faktur($id_po, $no_po, $jenis_pesanan, $supplier){
		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam = date("d-m-Y H:i:s");
		$tgl = date("d-m-Y");

		  $namars=$this->config->item('namars');
		  $kota_kab=$this->config->item('kota_kab');
		  $alamatrs=$this->config->item('alamat');
		  $telp=$this->config->item('kota');
	   
		//$data_detail_amprah=$this->Frmmamprah->get_receivings($no_faktur_amp)->result();
		$data1=$this->Frmmpo->get_info($id_po);
		$data = json_decode(json_encode($data1), true);
		/*
		 $data['select_gudang']=$this->Frmmamprah->cari_gudang()->result();
		*/  

		$konten="<table style=\"padding:0px;\" border=\"0\">
						<tr>
							<td width=\"16%\">
								<p align=\"center\">
									<img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"40\" style=\"padding-right:5px;\">
								</p>
							</td>
								<td  width=\"70%\" style=\" font-size:9px;\"><b><font style=\"font-size:12px\">$namars</font></b><br>$alamatrs $kota_kab $telp
							</td>
							<td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam</font></td>						
						</tr>
					</table>
				  <hr/>
				  <p align=\"center\"><b>
				  SURAT PESANAN<br/>
				  No. PO. ".$no_po." - ".$jenis_pesanan."
				  </b></p><br/>
				 
				  <table>
					<tr>
					  <td width=\"15%\"><b>Tgl PO</b></td>
					  <td width=\"3%\"> : </td>
					  <td width=\"25%\">".$data['tgl_po']."</td>
					</tr>
					<tr>
					  <td width=\"15%\"><b>Supplier</b></td>
					  <td width=\"3%\"> : </td>
					  <td width=\"60%\">".$data['company_name']."</td>
					</tr>
					<tr>
					  <td width=\"15%\"><b>Alamat Supplier</b></td>
					  <td width=\"3%\"> : </td>
					  <td width=\"60%\">".$supplier."</td>
					</tr>
					<tr>
					  <td><b>Untuk Permintaan</b></td>
					  <td> : </td>
					</tr>
				  </table>
				  <br/><br/>
				  <table>
				  <br/><br/>
					<tr><hr>
					  <th width=\"5%\"><b>No</b></th>
					  <th width=\"30%\"><b>Nama Item</b></th>
					  <th width=\"10%\"><b>Qty</b></th>
					  <th width=\"10%\"><b>Satuan</b></th>
					  <th width=\"20%\"><b>Harga Pesan</b></th>
					  <th width=\"10%\"><b>Diskon %</b></th>
					</tr>";
		
		$data_detail_po=$this->Frmmpo->get_po_detail_list($id_po);
		foreach($data_detail_po as $key=>$row){
			$konten = $konten . "
					<tr>
						<td>".($key+1)."</td>
						<td>".$row->description."</td>
						<td>".$row->qty."</td>
						<td>".$row->satuank."</td>
						<td>".$row->harga_po."</td>
						<td>".$row->diskon_persen."</td>
					</tr>";
		}
		$konten = $konten ."
					<hr>
		  </table>
		  <br><br><br>
		  <table border=\"0\">
		  			<tr>
		  			  <td width=\"30%\"></td>
		  			  <td width=\"30%\"></td>
					  <td width=\"40%\"></td>
					</tr>
		  			<tr>
		  			  <td width=\"30%\"></td>
		  			  <td width=\"30%\"></td>
					  <td width=\"40%\" align=\"right\">Palembang, ___ ________________ 20____</td>
					</tr>
					<tr>
					  <td width=\"25%\"> </td>
					  <td width=\"25%\"> </td>
					  <td width=\"25%\"> </td>
					  <td width=\"25%\" align=\"center\"><br><br><br>(__________________)</td>
					</tr>
		  </table>
		  ";

					  
		$file_name="FP_$id_po.pdf";

		tcpdf();
		$obj_pdf = new TCPDF('L', PDF_UNIT, 'A5', true, 'UTF-8', false);
		$obj_pdf->SetCreator(PDF_CREATOR);
		$title = "";
		$obj_pdf->SetTitle($file_name);
		$obj_pdf->SetPrintHeader(false);
		$obj_pdf->SetPrintFooter(false);
		$obj_pdf->SetHeaderData('', '', $title, '');
		$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$obj_pdf->SetDefaultMonospacedFont('helvetica');
		$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$obj_pdf->SetMargins('10', '10', '10');
		$obj_pdf->SetAutoPageBreak(TRUE, '5');
		$obj_pdf->SetFont('helvetica', '', 9);
		$obj_pdf->setFontSubsetting(false);
		$obj_pdf->AddPage();
		ob_start();
		  $content = $konten;
		ob_end_clean();
		$obj_pdf->writeHTML($content, true, false, true, false, '');
		$obj_pdf->Output(FCPATH.'download/logistik_farmasi/PO/'.$file_name, 'F');
		
	  } 

	function is_exist(){	
		$id = $this->input->post('id');
		echo json_encode($this->Frmmpo->checkisexist($id));
	}

	public function export_excel($tgl0, $tgl1)
	{
		$data['title'] = 'PO Farmasi';
		$param1 = $tgl0;
		$param2 = $tgl1;
		// $param1 = $this->input->post('tgl0');
		// $param2 = $this->input->post('tgl1');

		$tgl_indo=new Tglindo();
		date_default_timezone_set("Asia/Jakarta");
		$tgl_jam = date("d-m-Y H:i:s");
		//print_r($tampil);
		$namars=$this->config->item('namars');
		$alamat=$this->config->item('alamat');
		$kota_kab=$this->config->item('kota');
		////EXCEL 
		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator("RSMCilandak")  
		        ->setLastModifiedBy("RSMCilandak")  
		        ->setTitle("Laporan Keuangan RS Marinir Cilandak")  
		        ->setSubject("Laporan Keuangan RS Marinir Cilandak Document")  
		        ->setDescription("Laporan Keuangan Marinir Cilandak for Office 2007 XLSX, generated by HMIS.")  
		        ->setKeywords(" Marinir Cilandak")  
		        ->setCategory("Laporan Pembuatan PO");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);


		if($param1=='' or $param2==''){
			$param1 = date("Y-m-d");
			$param2 = date("Y-m-d");
		}
		$tgl1 = date('d F Y', strtotime($param1));
		$tgl2 = date('d F Y', strtotime($param2));
		$data_po=$this->Frmmpo->get_data_po($param1, $param2)->result();
			
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_po.xlsx');
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
		$objPHPExcel->setActiveSheetIndex(0);  
		// Add some data  
      	$objPHPExcel->getActiveSheet()->mergeCells('A3:A4');
      	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      	$objPHPExcel->getActiveSheet()->mergeCells('B3:B4');
      	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      	$objPHPExcel->getActiveSheet()->mergeCells('C3:C4');
      	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      	$objPHPExcel->getActiveSheet()->mergeCells('D3:D4');
      	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      	$objPHPExcel->getActiveSheet()->mergeCells('E3:E4');
      	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

      	$objPHPExcel->getActiveSheet()->mergeCells('F3:H3');
      	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getStyle('F4')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('G4')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('H4')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		// Add some data  
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
      	$objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
		$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Periode '.$tgl1.' - '.$tgl2);
      	$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');

		$i=1;
		$rowCount = 5;
		foreach($data_po as $row){
			$no_po=$row->no_po;
			$data_obat='';
			$data_obat=$this->Frmmpo->get_data_po_obat($row->id_po)->result();
			$j=1;		
			foreach($data_obat as $row2){
				if($j==1){ 
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
				 	$i++;
				}
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tgl_po);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_po);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->company_name);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->sumber_dana);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row2->description);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row2->satuank);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row2->qty);
				$j++;
				$rowCount++;
			}
		}
		header('Content-Disposition: attachment;filename="Lap_PO.xlsx"');  
				

		// Rename worksheet (worksheet, not filename)  
		$objPHPExcel->getActiveSheet()->setTitle('RSM Cilandak');  
		   
		   
		   
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

		echo json_encode(array("status" => TRUE));
	}
    
}
?>
