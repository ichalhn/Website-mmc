<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
class FrmCDistribusiLangsung extends Secure_area{

    public function __construct(){
        parent::__construct();
        $this->load->model('logistik_farmasi/Frmmdistribusi','',TRUE);
        $this->load->model('logistik_farmasi/Frmmamprah','',TRUE);
        $this->load->model('master/Mmobat','',TRUE);
        $this->load->helper('pdf_helper');
    }

    public function index(){
        $data['title'] = 'Distribusi Langsung';
        $data['select_gudang0'] = $this->Frmmamprah->get_gudang_asal()->result();
        $data['select_gudang1'] = $this->Frmmamprah->get_gudang_tujuan()->result();
        //$data['data_obat']=$this->Mmobat->getAllObat_adaStok()->result();
        $this->load->view('logistik_farmasi/Frmvdistribusilangsung',$data);
    }

    function save(){
        $id_amprah = $this->Frmmamprah->insertDistribusiLangsung($this->input->post()) ;
        if ( $id_amprah != '' ){
            $msg = 	' <div class="alert alert-success alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-check"></i>Data permintaan distribusi berhasil disimpan
					  </div>';
        }else{
            $msg = 	' <div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="icon fa fa-ban"></i>Data permintaan distribusi gagal disimpan
					  </div>';
        }
        $this->session->set_flashdata('alert_msg', $msg);
        //$this->cetak_faktur_amprah($id_amprah);
        //$this->session->set_flashdata('cetak', 'cetak('.$id_amprah.');');
        redirect('logistik_farmasi/FrmCDistribusiLangsung');
    }

    public function rekap_distribusi(){
        $data['title'] = 'Rekap Distribusi';
        $namars=$this->config->item('namars');
        $alamat=$this->config->item('alamat');
        $kota_kab=$this->config->item('kota');
          
        /*$userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid)->id_gudang;*/
        $datajson=$this->Frmmdistribusi->get_obat_distribusi()->result();
        
        $this->load->library('Excel');  
           
        // Create new PHPExcel object  
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->getProperties()->setCreator($namars)  
                ->setLastModifiedBy($namars)  
                ->setTitle("Laporan Hasil SO RS Marinir Cilandak ".$namars."  ".$nm_gudang)  
                ->setSubject("Laporan Hasil SO Marinir Cilandak ".$namars." Document")  
                ->setDescription("Laporan Hasil SO Marinir Cilandak ".$namars." for Office 2007 XLSX, generated by HMIS.")  
                ->setKeywords($namars)  
                ->setCategory("Laporan Hasil SO Marinir Cilandak");
        
        $objReader= PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);
        $date=date('Y-m-d');
            $date_title=date('d F Y', strtotime($date));     
          
        $objPHPExcel=$objReader->load(APPPATH.'third_party/log_farm_hasil_so.xlsx');
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet  
        $objPHPExcel->setActiveSheetIndex(0);  
            // Add some data  
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title'].' '.$nm_gudangreal);
        $objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$date_title);
        
        $i=1;
        $rowCount = 5;$qtytot=0;
        foreach($datajson as $row){
          $qtytot+=$row->qty;
          $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row->nm_obat);

          $cek = $this->db->query("SELECT d.`id_amprah`, d.`id_obat`, d.`batch_no`, o.`nm_obat`, o.`satuank`, a.`minggu`, d.`qty_acc`, o.`hargajual`, (o.`hargajual` * d.`qty_acc`) AS total
                FROM distribusi d
                INNER JOIN amprah a ON a.`id_amprah` = d.`id_amprah`
                INNER JOIN master_obat o ON o.`id_obat` = d.`id_obat`
                WHERE a.`minggu` != 0 AND qty_acc != 0 AND d.`id_obat` = ".$row->id_obat." AND d.`batch_no` = '".$row->batch_no."'")->result();

          foreach ($cek as $detail) {
              if($detail->minggu == 1){
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $detail->qty_acc);
              }else{
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 0);
              } 

              if($detail->minggu == 2){
                    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $detail->qty_acc);
              }else{
                    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 0);
              }

              if($detail->minggu == 3){
                    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $detail->qty_acc);
              }else{
                    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 0);
              }

              if($detail->minggu == 4){
                    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $detail->qty_acc);
              }else{
                    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 0);
              }

              if($detail->minggu == 5){
                    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $detail->qty_acc);
              }else{
                    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 0);
              }

              $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $detail->hargajual);
              $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $detail->total);
          }
          //SetCellValue('B'.$rowCount, $row->no_medrec);
          $i++;
          
          $rowCount++;
        }
        
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Total');
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "");
        $objPHPExcel->getActiveSheet()->getStyle('F'.$rowCount)->applyFromArray(
            array(
          'fill' => array(
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              'color' => array('rgb' => 'C1B2B2')
          )
            )
        );
            
              
            
        header('Content-Disposition: attachment;filename="Excel_Distribusi_'.$date.'.xlsx"');  
            
        $objPHPExcel->getActiveSheet()->setTitle($namars);  
                       
        // Redirect output to a client???s web browser (Excel2007)  
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