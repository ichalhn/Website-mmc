<?php
	require(getenv('DOCUMENT_ROOT'). '/RS-BPJS/assets/fpdf.php');
	class Surat extends FPDF {
		private $pdf = null;
		private $fields_value = array();
		public function __construct() {
			parent::__construct('L', 'mm', array(120, 75));
			$this->SetMargins(0, 0);
			$this->SetAutoPageBreak(false);
		}
		public function cetak() {
			$this->AddPage();
			$this->header_surat();

			$this->SetFont('Arial', '', 6);
			
			//No. SEP
			$this->Cell(5);
			$this->Cell(20, 3, 'No. SEP');
			$this->Cell(0, 3, ': ' . $this->fields_value['No. SEP'], 0, 1);
			
			//Tgl. SEP
			$this->Cell(5);
			$this->Cell(20, 3, 'Tgl. SEP');
			$this->Cell(0, 3, ': ' . $this->fields_value['Tgl. SEP'], 0, 1);
			
			//No. Kartu
			$this->Cell(5);
			$this->Cell(20, 3, 'No. Kartu');
			$this->Cell(50, 3, ': ' . $this->fields_value['No. Kartu'], 0, 0);
			
			//No. Kartu
			$this->Cell(20, 3, 'Peserta');
			$this->Cell(0, 3, ': ' . $this->fields_value['Peserta'], 0, 1);
			
			//Nama Peserta
			$this->Cell(5);
			$this->Cell(20, 3, 'Nama Peserta');
			$this->Cell(0, 3, ': ' . $this->fields_value['Nama Peserta'], 0, 1);
			
			//Tgl. Lahir
			$this->Cell(5);
			$this->Cell(20, 3, 'Tgl. Lahir');
			$this->Cell(50, 3, ': ' . $this->fields_value['Tgl. Lahir'], 0, 0);
			
			//COB
			$this->Cell(20, 3, 'COB');
			$this->Cell(0, 3, ': ', 0, 1);
			
			//Jenis Kelamin
			$this->Cell(5);
			$this->Cell(20, 3, 'Jenis Kelamin');
			$this->Cell(50, 3, ': ' . $this->fields_value['Jenis Kelamin'], 0, 0);
			
			//Jenis Rawat
			$this->Cell(20, 3, 'Jenis Rawat');
			$this->Cell(0, 3, ': ' .  $this->fields_value['Jenis Rawat'], 0, 1);
				
			//Poli Tujuan
			$this->Cell(5);
			$this->Cell(20, 3, 'Poli Tujuan');
			$this->Cell(50, 3, ': ' . $this->fields_value['Poli Tujuan'], 0, 0);
			
			//Kelas Rawat
			$this->Cell(20, 3, 'Kelas Rawat');
			$this->Cell(0, 3, ': ' . $this->fields_value['Kelas Rawat'], 0, 1);
			
			//Asal Faskes
			$this->Cell(5);
			$this->Cell(20, 3, 'Asal Faskes');
			$this->Cell(50, 3, ': ' . $this->fields_value['Asal Faskes'], 0, 1);
			
			//Diagnosa Awal
			$this->Cell(5);
			$this->Cell(20, 3, 'Diagnosa Awal');
			$this->Cell(0, 3, ': ' . $this->fields_value['Diagnosa Awal'], 0, 1);
			
			//Catatan
			$this->Cell(5);
			$this->Cell(20, 3, 'Catatan');
			$this->Cell(0, 3, ': ' . $this->fields_value['Catatan'], 0, 1);
			
			
			$this->Cell(0, 4, ' ', 0, 1);

			$this->Cell(5);
			$this->Cell(30, 3, 'Pasien / Keluarga Pasien', 0, 0, 'C');
			$this->Cell(50);
			$this->Cell(30, 3, 'Petugas', 0, 1, 'C');
			
			$this->Cell(0, 10, ' ', 0, 1);
			$this->Cell(5);
			$this->Cell(30, 3, '(____________________)', 0, 0, 'C');
			$this->Cell(50);
			$this->Cell(30, 3, '(____________________)', 0, 1, 'C');
			
			
			
			
			
			$this->Output();
		}
		public function set_nilai($array) {
			$this->fields_value = $array;
		}
		private function header_surat() {
			$this->Image(getenv('DOCUMENT_ROOT'). '/assets/images/logobpjs.png',0,0, 20);
			$this->SetFont('Arial', 'B', 8);
			$this->Cell(0, 3, '', 0, 2);
			$this->Cell(20);
			$this->Cell(80, 4, 'Surat Eligibilitas Peserta', 0, 2, 'C');
			$this->SetFont('Arial', '', 8);
			$this->Cell(80, 4, 'RSUP Mohammad Hoesin Palembang', 0, 1, 'C');
			$this->Cell(0, 6, ' ', 0, 1);
			$this->Line(0, 13, 120, 13);
		}
		
		
		
	}
		
?>