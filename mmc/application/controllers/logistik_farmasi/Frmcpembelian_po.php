<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
include('Frmcterbilang.php');
include(dirname(dirname(__FILE__)).'/Tglindo.php');
class Frmcpembelian_po extends Secure_area
{
	public function __construct(){
		parent::__construct();
		$this->load->model('logistik_farmasi/Frmmpo','',TRUE);
        $this->load->library('session');
	}

	function index()
	{
		$data['title'] = 'Pembelian (PO Reference)';
		$data['select_pemasok'] = $this->Frmmpo->get_suppliers();
		$this->load->view('logistik_farmasi/Frmvpembelian_po',$data);
	}
	
    function get_detail_list(){		
		$line  = array();
		$line2 = array();
		$row2  = array();
		$data = $this->Frmmpo->get_po_total($this->input->post('id'))->result();
	//	Print_r($data);exit();
		$hasil = $this->Frmmpo->get_po_detail_list($this->input->post('id'));
		$getmastertotal = $this->Frmmpo->get_master_total($this->input->post('id'))->row();
		
		foreach ($hasil as $key =>$value) {
			$row2['item_id'] = $value->item_id;
			$row2['id_po'] = $value->id_po;
			$row2['description'] = $value->description;
			$row2['satuank'] = $value->satuank;
			$row2['qty_po'] = $value->qty;
			$row2['qty_beli'] = $value->qty_beli;
			$row2['batch_no'] = $value->batch_no;
			$row2['keterangan'] = $value->keterangan;	
			$row2['expire_date'] = $value->expire_date;
			$row2['hargabeli'] = $value->harga_po;
			$row2['subtotal'] = "<p align='right'>".number_format($value->subtotal, '0', ',', '.')."</p>";
			$row2['jml_kemasan'] = $value->jml_kemasan;
			$row2['harga_item'] = "<p align='right'>".number_format($value->harga_item, '0', ',', '.')."</p>";
			$row2['satuan_item'] = $value->satuan_item;
			/*
			if ($value->qty_beli == null)
				$row2['qty_beli'] = '<input type="hidden" value="'.$value->id.'" id="id" name="id"><input type="number" id="qty_beli'.($key+1).'" name="qty_beli" min=0 >';
			else
				$row2['qty_beli'] = $value->qty_beli;
			if ($value->batch_no == null){
				$row2['batch_no'] = '<input type="text" id="batch_no'.($key+1).'" name="batch_no">';	
			}else
				$row2['batch_no'] = $value->batch_no;
			if ($value->keterangan == null)
				$row2['keterangan'] = '<input type="text" id="keterangan" name="keterangan"><input type="hidden" value="'.$value->item_id.'" name="id_obat">';
			else
				$row2['keterangan'] = $value->keterangan;	
			if ($value->expire_date == null)
				$row2['expire_date'] = '<input type="text" id="expire_date'.($key+1).'" name="expire_date" class="datepicker" placeholder="yyyy-mm-dd">';
			else
				$row2['expire_date'] = $value->expire_date;	
			*/
			$line2[] = $row2;
		}

		$ttotal = 0; $tppn = 0; $tsub = 0;
        foreach ($data as $datas) {
			$subtotal = $datas->qty_beli * $datas->harga_po;
			$tsub += $subtotal;

			if($datas->ppn != 0){
				$tppn += $subtotal * 0.1;
			}else{
				$tppn += 0;
			}

			$ttotal += $subtotal;
		}

		$ttotal = $ttotal - $getmastertotal->total_diskon;
        $ppn = $ttotal * 0.1;

		$line['data'] = $line2;
        $line['subtotal'] = number_format($tsub, '2', ',', '.');
        $line['diskon_po'] = number_format($getmastertotal->total_diskon, '2', ',', '.');
        $line['total'] = number_format($ttotal, '2', ',', '.');
		$line['ppn'] = number_format($tppn, '2', ',', '.');
		$line['totalppn'] = number_format($ttotal + $tppn, '2', ',', '.');

		echo json_encode($line);
    }
    
	function get_detail_beli(){		
		$line  = array();
		$line2 = array();
		$row2  = array();
		$idpo = $this->input->post('id_po');
		$itemid = $this->input->post('item_id');
		$value2 = $this->Frmmpo->get_total_beli($this->input->post());
		$total_qty_beli = $value2->total_qty_beli;
		$jml_kemasan = $value2->jml_kemasan;
        $hargabeli = $value2->hargabeli;
        $hargabeli_po = $value2->harga_po;
        $hargajual = $value2->hargajual;
		$kuota = $value2->kuota;
		$description = $value2->description;
		$qty = $value2->qty;
		$satuank = $value2->satuank;
		$open = $value2->open;
		$hasil = $this->Frmmpo->get_po_detail_beli($this->input->post());
        $data = $this->Frmmpo->get_po_total($idpo)->result();
        $getmastertotal = $this->Frmmpo->get_master_total($idpo)->row();
		
		foreach ($hasil as $value) {
			$row2['qty_beli'] = $value->qty_beli;
			$row2['jml_kemasan'] = $value->jml_kemasan;
			$row2['hargabeli'] = $value->hargaitem;
			$row2['hargabeli_po'] = $value->harga_po;
			$row2['hargajual'] = $value->hargajual;
			$row2['batch_no'] = $value->batch_no;
			$row2['expire_date'] = $value->expire_date;
            $row2['diskon_item'] = $value->diskon_item;
            $subtotal = $value->harga_po * $value->qty_beli;
            $row2['subtotal'] = number_format($subtotal, '2', ',', '.');
			$row2['aksi'] = '<button class="btn btn-xs btn-primary" onclick="editDetailBeli('.$itemid.', '.$idpo.')">Edit</button> | 
					<button class="btn btn-xs btn-primary" onclick="deleteItem('.$idpo.', '.$itemid.', \''.$value->batch_no.'\')">Delete</button>';
			//$row2['aksi'] = '<button class="btn btn-xs btn-warning" id="btnHapus" onClick="hapusBeli('.$value->id.')">Hapus</button>';
			/*
			if ($value->qty_beli == null)
				$row2['qty_beli'] = '<input type="hidden" value="'.$value->id.'" id="id" name="id"><input type="number" id="qty_beli'.($key+1).'" name="qty_beli" min=0 >';
			else
				$row2['qty_beli'] = $value->qty_beli;
			if ($value->batch_no == null){
				$row2['batch_no'] = '<input type="text" id="batch_no'.($key+1).'" name="batch_no">';	
			}else
				$row2['batch_no'] = $value->batch_no;
			if ($value->keterangan == null)
				$row2['keterangan'] = '<input type="text" id="keterangan" name="keterangan"><input type="hidden" value="'.$value->item_id.'" name="id_obat">';
			else
				$row2['keterangan'] = $value->keterangan;	
			if ($value->expire_date == null)
				$row2['expire_date'] = '<input type="text" id="expire_date'.($key+1).'" name="expire_date" class="datepicker" placeholder="yyyy-mm-dd">';
			else
				$row2['expire_date'] = $value->expire_date;	
			*/
			$line2[] = $row2;
		}
		if ($kuota>0 and $open==1){
			$row2['qty_beli'] = '<input type="number" id="qty_beli" name="qty_beli" min=0 max='.$kuota.' style="width:100%">';
			$row2['jml_kemasan'] = '<input type="number" id="jumlahkemasan" name="jumlahkemasan" style="width:50%" min=0 value="'.$jml_kemasan.'">';
			$row2['hargabeli'] = '<input type="number" id="hargabeli" name="hargabeli" style="width:100%" min=0 value="'.$hargabeli.'">';
			//$row2['hargabeli_po'] = '<p align="right">'.number_format($hargabeli_po, '0', ',', '.').'</p>';
			$row2['hargabeli_po'] = '<input type="number" id="hargabeli_po" name="hargabeli_po" style="width:100%" min=0 value="'.$hargabeli_po.'">';
			$row2['hargajual'] = '<input type="number" id="hargajual" name="hargajual" style="width:100%" min=0 value="'.$hargajual.'">
			<input type="hidden" id="hargabeli" name="hargabeli" value="'.$hargabeli.'">';
			$row2['batch_no'] = '<input type="text" id="batch_no" name="batch_no">';
			$row2['diskon_item'] = '<input type="text" id="diskon_item" name="diskon_item" value="0" style="width:100%">';
			$row2['expire_date'] ='<input type="text" id="expire_date" name="expire_date" placeholder="yyyy-mm-dd" style="width:100%">
			<input type="hidden" value="'.$description.'" id="description"><input type="hidden" value="'.$satuank.'" id="satuank"><input type="hidden" value="'.$qty.'" id="qty">';
			$row2['subtotal'] = '0';
			$row2['aksi'] = '<button class="btn btn-xs btn-primary" id="btnSimpan">Simpan</button>';
			$line2[] = $row2;
		}
		$line['data'] = $line2;

        $ttotal = 0; $tppn = 0; $tsub = 0;
        foreach ($data as $datas) {
            $subtotal = $datas->qty_beli * $datas->harga_po;
            $tsub += $subtotal;

            if($datas->ppn != 0){
                $tppn += $subtotal * 0.1;
            }else{
                $tppn += 0;
            }

            $ttotal += $subtotal;
        }

        $ttotal = $ttotal - $getmastertotal->total_diskon;
        $ppn = $ttotal * 0.1;

        $line['data'] = $line2;
        $line['subtotal'] = number_format($tsub, '2', ',', '.');
        $line['diskon_po'] = number_format($getmastertotal->total_diskon, '2', ',', '.');
        $line['total'] = number_format($ttotal, '2', ',', '.');
        $line['ppn'] = number_format($tppn, '2', ',', '.');
        $line['totalppn'] = number_format($ttotal + $tppn, '2', ',', '.');
			
		echo json_encode($line);
    }
	
	function save_detail_beli(){
	    $userid = $this->session->userid;
	    $group = $this->Frmmpo->getIdGudang($userid);
		$test = $this->Frmmpo->insert_detail_beli($this->input->post(), 1) ;
		echo true;
        //echo $test;
		/*echo "<pre>";
		echo print_r($this->input->post());
		echo "</pre>";*/
	}
	function delete_detail_beli(){
		$this->Frmmpo->delete_detail_beli($this->input->post('id')) ;
		echo true;
	}
	function selesai_po(){
		$this->Frmmpo->selesai_po($this->input->post('id_po')) ;
		redirect('logistik_farmasi/Frmcpembelian_po');
	}

	function delete_item_beli(){
		$data['id_po'] = $this->input->post('idpo');
		$data['item_id'] = $this->input->post('itemid');
		$data['batch_no'] = $this->input->post('batch_no');

		$res = $this->Frmmpo->delete_item_beli('po', $data);
		if($res > 0){
            $data = array('status' => 'success');
        }else{
            $data = array('status' => 'failed');
		}
        echo json_encode($data);
    }

    function edit_item_beli(){
		$diskon = $this->input->post('diskon');
		$hargabeli_po = $this->input->post('hargabeli_po');
		$subtotal = $this->input->post('qty') * $hargabeli_po;

        if(strpos($diskon, "%") !== false){
            $persentase = substr($diskon, 0, strlen($diskon)-1);
            $diskon_item = ($subtotal * $persentase) / 100;
        }else{
            $persentase = 0;
            $diskon_item = $diskon;
        }

        $where = array(
        	'id_po' => $this->input->post('idpo'),
			'item_id' => $this->input->post('itemid'),
			'batch_no' => $this->input->post('batch')
		);

        $data = array(
        	'qty_beli' => $this->input->post('qty'),
			'hargabeli' => $this->input->post('hargabeli'),
			'harga_item' => $this->input->post('hargabeli'),
			'batch_no' => $this->input->post('batch'),
			'diskon_persen' => $persentase,
			'diskon_item' => $diskon_item,
			'expire_date' => $this->input->post('exdate')
		);

        $data2['id_obat'] = $this->input->post('itemid');
        $data2['hargajual'] = $this->input->post('hargajual');
        $data2['hargabeli_po'] = $hargabeli_po;
        $data2['jml_kemasan'] = $this->input->post('jml_kemasan');

        //echo print_r($where);

        $res = $this->Frmmpo->edit_item_beli('po', $where, $data, $data2);
        if($res > 0){
            $msg = array('status' => 'success');
        }else{
            $msg = array('status' => 'failed');
        }
        echo json_encode($msg);
	}

/*
	function alokasi(){
		$this->Frmmpo->update($this->input->post('json'));
		echo true;
	}
	*/

	public function export_excel($tgl0, $tgl1)
	{
		$data['title'] = 'Pembelian PO Farmasi';
		// $param1 = '2016-05-09';
		// $param2 = '2017-05-09';
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
		$data_po=$this->Frmmpo->get_data_pem_po($param1, $param2)->result();
			
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_pem_po.xlsx');
		
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

      	$objPHPExcel->getActiveSheet()->mergeCells('F3:K3');
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
      	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('I4')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('J4')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('K4')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

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
			$data_obat=$this->Frmmpo->get_data_pem_po_obat($row->id_po)->result();
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
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row2->qty_beli);
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row2->batch_no);
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row2->expire_date); 
				$j++;
				$rowCount++;
			}
		}
		header('Content-Disposition: attachment;filename="Lap_Pem_PO.xlsx"');  
				

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
