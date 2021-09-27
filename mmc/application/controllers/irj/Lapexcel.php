 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(dirname(dirname(__FILE__)).'/Tglindo.php');

require_once(APPPATH.'controllers/Secure_area.php');
class Lapexcel extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('irj/Rjmlaporan','',TRUE);
		//$this->load->library('Excel'); 
		$this->load->file(APPPATH.'third_party/PHPExcel.php'); 
	}

	public function index()
	{
		redirect('irj/Rjcregistrasi','refresh');
	}
	
	public function lap_kunj_pasien_rj($tgl_awal='',$tgl_akhir='')
	{
       // Load plugin PHPExcel nya
    // include APPPATH.'third_party/PHPExcel/PHPExcel.php';

     // Panggil class PHPExcel nya    
     $excel = new PHPExcel();

      // Settingan awal fil excel    
     $excel->getProperties()->setCreator('Rawosi')
           ->setLastModifiedBy('Rawosi') 
           ->setTitle("Laporan kunjungan Rawat Jalan")                 
           ->setSubject("Rawat jalan")                 
           ->setDescription("Laporan Kunjungan Rawat Jalan")                 
           ->setKeywords("Rawat jalan");    
     // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    
     $style_col = array(      
     'font' => array('bold' => true), // Set font nya jadi bold      
     'alignment' => array(        
     'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)        
     'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)      
      ),      
     'borders' => array(        
     'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis        
     'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis        
     'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis        
     'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis      
     )    
     );

         // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel    
         $style_row = array(      
         'alignment' => array(        
         'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)      
         ),      
         'borders' => array(        
         'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis        
         'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis        
         'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis        
         'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis      
         )    
         );

            $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA KUNJUNGAN PASIEN RAWAT JALAN"); // Set kolom A1 dengan tulisan "DATA SISWA"   
            $excel->getActiveSheet()->mergeCells('A1:I1'); // Set Merge Cell pada kolom A1 sampai E1    
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1    
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
            $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            // Set text center untuk kolom A1    
            // Buat header tabel nya pada baris ke 3    
            $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"    
            $excel->setActiveSheetIndex(0)->setCellValue('B3', "TANGGAL"); // Set kolom B3 dengan tulisan "NIS"    
            $excel->setActiveSheetIndex(0)->setCellValue('C3', "NO REGISTER"); // Set kolom C3 dengan tulisan "NAMA"    
            $excel->setActiveSheetIndex(0)->setCellValue('D3', "NO MEDREC");
            $excel->setActiveSheetIndex(0)->setCellValue('E3', "NAMA");           
            $excel->setActiveSheetIndex(0)->setCellValue('F3', "JENIS KELAMIN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"    
            $excel->setActiveSheetIndex(0)->setCellValue('G3', "POLIKLINIK");
            $excel->setActiveSheetIndex(0)->setCellValue('H3', "DOKTER");
            $excel->setActiveSheetIndex(0)->setCellValue('I3', "JENIS PASIEN"); // Set kolom E3 dengan tulisan "ALAMAT"    
            // Apply style header yang telah kita buat tadi ke masing-masing kolom header    
            $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);    
            $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);    
            $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);    
            $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);    
            $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);    
            $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);    
            $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);    
            $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);    

       //     $siswa = $this->SiswaModel->view();
            $pasien=$this->Rjmlaporan->get_kunj_pasien_detail($tgl_awal,$tgl_akhir);
            print_r($pasien);exit();
            $no=1;
            $numrow  = 4;
            foreach ($pasien as $r) {
            	$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);      
            	$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $r->tanggal);      
            	$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $r->no_register);      
            	$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $r->no_cm);      
            	$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $r->nama);
            	$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $r->jenis_kelamin);      
            	$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $r->nama_poli);      
            	$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $r->nama_dokter);
            	$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $r->cara_bayar);


            	      // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)      
            	$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);      
            	$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);      
            	$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);      
            	$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);      
            	$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
            	$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);      
            	$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);      
            	$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);      
            	$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);                       
            	$no++; // Tambah 1 setiap kali looping      
            	$numrow++; // Tambah 1 setiap kali looping
            }

                // Set width kolom    
                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A    
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20); // Set width kolom B    
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(20); // Set width kolom C    
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set 5width kolom D    
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(50); // Set width kolom E
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(5); // Set width kolom B    
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(50); // Set width kolom C    
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(50); // Set width kolom D    
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth(30); // Set width kolom E
        
                    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
                $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);   
                
                 // Set orientasi kertas jadi LANDSCAPE    
                $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);    

                // Set judul file excel nya    
                $excel->getActiveSheet(0)->setTitle("Laporan");    
                $excel->setActiveSheetIndex(0);    

                // Proses file excel    
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');    
                header('Content-Disposition: attachment; filename="DataKunungan.xls"'); // Set nama file excel nya    
                header('Cache-Control: max-age=0');    

                $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');    
                $write->save('php://output');

	}
}

?>