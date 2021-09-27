<?php
	//require(getenv('DOCUMENT_ROOT'). '/RS-BPJS/assets/fpdf.php');
	require_once(APPPATH.'controllers/fpdf.php');
	class SEP extends FPDF {
		private $pdf = null;
		private $fields_value = array();
		public function __construct() {
			parent::__construct('L', 'mm', 'A5', true, 'UTF-8', false);
			//('L', 'mm',array(420.94,595.28));
			//parent::__construct('L', 'mm', array(210.0580, 93.72600));
			$this->SetMargins(0, 0);
			$this->SetAutoPageBreak(false);
		}
		public function cetak() {

			$this->AddPage();
			
			$this->div1();
			$this->Cell(5);
			$this->Cell(0, 4, 'Cetakan ke 1');
			$this->div2();
			
			$this->AddPage();
			$this->div1();
			$this->Cell(5);
			$this->Cell(0, 4, 'Cetakan ke 2');
			$this->div2();
			
			$this->AddPage();
			$this->div1();
			$this->Cell(5);
			$this->Cell(0, 4, 'Cetakan ke 3');
			$this->div2();
			
			$this->Output();
		}
		
		private function header_surat() {
			//$this->Image(getenv('DOCUMENT_ROOT'). '/hmis/asset/images/logobpjs.png',0,0, 45);
			//$image1 = getenv('DOCUMENT_ROOT'). "/hmis/asset/images/logobpjs.png";
			$this->SetFont('Arial', 'B', 14);
			
			$this->Cell(1);
			$this->Cell(10, 15, $this->Image(getenv('DOCUMENT_ROOT'). '/hmis/asset/images/logobpjs.png',$this->GetX(), $this->GetY(),	 45), 0, 0);
			
			$this->Cell(0, 8, '', 0, 2);
			$this->Cell(10);
			$this->Cell(180, 6, 'Surat Eligibilitas Peserta', 0, 2, 'C');
			$this->SetFont('Arial', '', 14);
			$this->Cell(180, 9,$this->fields_value['Nama RS'], 0, 1, 'C');
			$this->Cell(0, 6, ' ', 0, 1);
			
			$this->Cell(0);
			$this->Cell(0, 3, $this->Line(0, $this->GetY(), $this->GetX(), $this->GetY()),0,1);
			//$this->Line(0, 28, 210, 28);
		}
		
		public function div1() {
			
			$this->header_surat();
		
			$this->SetFont('Arial', '', 10);
			
			//No. SEP
			$this->Cell(5);
			$this->Cell(30, 6, 'No. SEP',0);
			$this->Cell(0, 6, ': ' . $this->fields_value['No. SEP'], 0, 1);
			
			//Tgl. SEP
			$this->Cell(5);
			$this->Cell(30, 6, 'Tgl. SEP');
			$this->Cell(0, 6, ': ' . $this->fields_value['Tgl. SEP'], 0, 1);
			
			//No. Kartu
			$this->Cell(5);
			$this->Cell(30, 6, 'No. Kartu');
			$this->Cell(80, 6, ': ' . $this->fields_value['No. Kartu'], 0, 0);
			
			//No. Kartu
			$this->Cell(30, 6, 'Peserta');
			$this->Cell(0, 6, ': ' . $this->fields_value['Peserta'], 0, 1);
			
			//Nama Peserta
			$this->Cell(5);
			$this->Cell(30, 6, 'Nama Peserta');
			$this->Cell(0, 6, ': ' . $this->fields_value['Nama Peserta'], 0, 1);
			
			//Tgl. Lahir
			$this->Cell(5);
			$this->Cell(30, 6, 'Tgl. Lahir');
			$this->Cell(80, 6, ': ' . $this->fields_value['Tgl. Lahir'], 0, 0);
			
			//COB
			$this->Cell(30, 6, 'COB');
			$this->Cell(0, 6, ': ', 0, 1);
			
			//Jenis Kelamin
			$this->Cell(5);
			$this->Cell(30, 6, 'Jenis Kelamin');
			$this->Cell(80, 6, ': ' . $this->fields_value['Jenis Kelamin'], 0, 0);
			
			//Jenis Rawat
			$this->Cell(30, 6, 'Jenis Rawat');
			$this->Cell(0, 6, ': ' .  $this->fields_value['Jenis Rawat'], 0, 1);
				
			//Poli Tujuan
			$this->Cell(5);
			$this->Cell(30, 6, 'Poli Tujuan');
			$this->Cell(80, 6, ': ' . $this->fields_value['Poli Tujuan'], 0, 0);
			
			//Kelas Rawat
			$this->Cell(30, 6, 'Kelas Rawat');
			$this->Cell(0, 6, ': ' . $this->fields_value['Kelas Rawat'], 0, 1);
			
			//Asal Faskes
			$this->Cell(5);
			$this->Cell(30, 6, 'Asal Faskes');
			$this->Cell(50, 6, ': ' . $this->fields_value['Asal Faskes'], 0, 1);
			
			//Diagnosa Awal
			$this->Cell(5);
			$this->Cell(30, 6, 'Diagnosa Awal');
			$this->Cell(0, 6, ': ' . $this->fields_value['Diagnosa Awal'], 0, 1);
			
			//Catatan
			$this->Cell(5);
			$this->Cell(30, 6, 'Catatan');
			$this->Cell(0, 6, ': ' . $this->fields_value['Catatan'], 0, 1);
			
			$this->SetFont('Arial', '', 8);
			
			$this->Cell(0, 5, ' ', 0, 1);
			
			$this->Cell(5);
			$this->Cell(0, 1, '*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan.',0,1);
			
			$this->Cell(5);
			$this->Cell(0, 8, '*SEP bukan sebagai bukti penjaminan peserta',0,1);
			
		}
		
		public function div2() {
			$this->SetFont('Arial', '', 10);
			
			$this->Cell(0, 10, ' ', 0, 1);

			$this->Cell(18);
			$this->Cell(70, 3, 'Pasien / Keluarga Pasien', 0, 0, 'C');
			$this->Cell(50);
			$this->Cell(30, 3, 'Petugas BPJS Kesehatan', 0, 1, 'C');
			
			$this->Cell(0, 15, ' ', 0, 1);
			$this->Cell(18);
			$this->Cell(70, 15, '(____________________)', 0, 0, 'C');
			$this->Cell(50);
			$this->Cell(30, 15, '(____________________)', 0, 1, 'C');
		}
		public function set_nilai($array) {
			$this->fields_value = $array;
		}
		
		
		
	}
		
?>
