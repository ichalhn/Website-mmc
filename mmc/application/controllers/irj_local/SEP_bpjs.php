<?php
	//require(getenv('DOCUMENT_ROOT'). '/RS-BPJS/assets/fpdf.php');
	ob_start();
	require_once(APPPATH.'controllers/fpdf_sep.php');
	class SEP extends FPDF {
		private $pdf = null;
		private $fields_value = array();
		public function __construct() {
			parent::__construct('P', 'mm', 'A4', true, 'UTF-8', false);
			//parent::__construct('L', 'mm', array(210.0580, 93.72600));
			$this->SetMargins(0, 0);
			$this->SetAutoPageBreak(false);
		}

		public function cetak() {

			$this->SetTitle("SEP_".$this->fields_value['No. SEP'].".pdf");

			$this->AddPage();

			$this->div1();
			$this->Cell(5);
		//	$this->Cell(0, 4, 'Cetakan ke 1');
			$this->div2();
			// $this->div3();
			// $this->header_tracer();
			// $this->div4();

			// $this->AddPage();
			// $this->div1();
			// $this->Cell(5);
			// $this->Cell(0, 4, 'Cetakan ke 2');
			// $this->div2();
			// $this->div3();

			// $this->AddPage();
			// $this->div1();
			// $this->Cell(5);
			// $this->Cell(0, 4, 'Cetakan ke 3');
			// $this->div2();
			// $this->div3();

			$this->Output();
			ob_end_flush(); 
		}

		private function header_surat() {
			$this->SetFont('Arial', 'B', 14);

			$this->Cell(1);
			$this->Cell(10, 15, $this->Image(base_url() . 'asset/images/logos/logobpjs.png',$this->GetX(), $this->GetY(),	 40), 0, 0,'L');

            $this->Cell(65);
            $this->Cell(6, 20, 'Surat Eligibilitas Peserta', 0, 0);
            $this->SetFont('Arial', '', 12);
          //  $this->Cell(75);
			$this->Cell(6, 30,$this->fields_value['Nama RS'], 0, 0);
            $this->Cell(80);
  		    // $this->Cell(0,15, $this->Image(getenv('DOCUMENT_ROOT'). '/hmis/hmis_cilandak/asset/images/logos/logocilandak.jpg',$this->GetX(), $this->GetY(),	 22), 0, 0,'R');

			$this->Cell(0, 20, '', 0, 2);
	    //	$this->Cell(10);
	//		$this->Cell(180, 0, 'Surat Eligibilitas Peserta', 0, 2, 'C');
		//	$this->Cell(180, 6, 'RS. Dr. Moch Hoesin Palembang', 0, 2, 'C');
	//		$this->SetFont('Arial', '', 12);
	//		$this->Cell(180, 9,$this->fields_value['Nama RS'], 0, 1, 'C');

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
			$this->Cell(80, 6, ': ' . $this->fields_value['No. Kartu'] .'    ' . 'MR : ' . $this->fields_value['No. Medrec'] , 0, 0);

			//No. Kartu
			$this->Cell(30, 6, 'Peserta');
			$this->Cell(0, 6, ': ' . $this->fields_value['Peserta'] , 0, 1);

			//Nama Peserta
			$this->Cell(5);
			$this->Cell(30, 6, 'Nama Peserta');
			$this->Cell(0, 6, ': ' . $this->fields_value['Nama Peserta'] , 0, 1);


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
			$this->Cell(30, 5, 'Catatan');
			$this->Cell(0, 5, ': ' . $this->fields_value['Catatan'], 0, 1);

			$this->SetFont('Arial', '', 8);

			$this->Cell(0, 5, ' ', 0, 1);

			$this->Cell(5);
			$this->Cell(0, 1, '*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan.',0,1);

			$this->Cell(5);
			$this->Cell(0, 8, '*SEP bukan sebagai bukti penjaminan peserta',0,1);

			$this->SetFont('Arial', '', 9);
			//Cetakan
			$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
			$this->Cell(5);
			$this->Cell(30, 5, 'Cetakan ke' . ' ' . $this->fields_value['Cetakan Ke']);
			$this->Cell(0, 5, ': ' . $date->format('d-m-Y H:i:s'), 0, 1);

		}

		public function div2() {
			$this->SetFont('Arial', '', 10);

			$this->Cell(0, 5, ' ', 0, 1);
			$this->Cell(0, 5, ' ', 0, 1);

			$this->Cell(10);
			$this->Cell(60, 3, 'Pasien / Keluarga Pasien', 0, 0, 'C');

			$this->Cell(20);
			$this->Cell(15, 3, 'Petugas RS', 0, 0, 'C');

			$this->Cell(20);
			$this->Cell(0, 3, 'Petugas BPJS Kesehatan', 0, 1, 'C');

			$this->Cell(0, 5, ' ', 0, 1);
			$this->Cell(10);
			$this->Cell(60, 10, '(____________________)', 0, 0, 'C');

			$this->Cell(10);
			$this->Cell(40, 10, '(____________________)', 0, 0, 'C');

			$this->Cell(5);
			$this->Cell(0, 10, '(____________________)', 0, 1, 'C');
		}

		// public function div3() {
		// 	$this->SetFont('Arial', '', 8);

		// 	$this->Cell(0, 10, ' ', 0, 1);

		// 	$this->Cell(0, 0, '-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0);

  //      }
 //       		public function header_tracer() {
	// 		$this->SetFont('Arial', 'B', 14);


 //            $this->Cell(65);
 //            $this->Cell(6, 20, 'TRACER', 0, 0);



	// 		$this->Cell(0, 20, '', 0, 2);
	//     //	$this->Cell(10);
	// //		$this->Cell(180, 0, 'Surat Eligibilitas Peserta', 0, 2, 'C');
	// 	//	$this->Cell(180, 6, 'RS. Dr. Moch Hoesin Palembang', 0, 2, 'C');
	// //		$this->SetFont('Arial', '', 12);
	// //		$this->Cell(180, 9,$this->fields_value['Nama RS'], 0, 1, 'C');

	// 		$this->Cell(0, 6, ' ', 0, 1);

	// 		$this->Cell(0);
	// 		$this->Cell(0, 3, $this->Line(0, $this->GetY(), $this->GetX(), $this->GetY()),0,1);
	// 		//$this->Line(0, 28, 210, 28);
 //       }

 //           	public function div4() {
 //  			$this->SetFont('Arial', '', 10);
	// 		//No. SEP
	// 		$this->Cell(5);
	// 		$this->Cell(30, 6, 'No. SEP',0);
	// 		$this->Cell(0, 6, ': ' . $this->fields_value['No. SEP'], 0, 1);

	// 		//Tgl. SEP
	// 		$this->Cell(5);
	// 		$this->Cell(30, 6, 'Tgl. SEP');
	// 		$this->Cell(0, 6, ': ' . $this->fields_value['Tgl. SEP'], 0, 1);

	// 		//No. Kartu
	// 		$this->Cell(5);
	// 		$this->Cell(30, 6, 'No. Kartu');
	// 		$this->Cell(80, 6, ': ' . $this->fields_value['No. Kartu'] .'    ' . 'MR : ' . $this->fields_value['No. Medrec'] , 0, 0);

	// 		//No. Kartu
	// 		$this->Cell(30, 6, 'Peserta');
	// 		$this->Cell(0, 6, ': ' . $this->fields_value['Peserta'] , 0, 1);

	// 		//Nama Peserta
	// 		$this->Cell(5);
	// 		$this->Cell(30, 6, 'Nama Peserta');
	// 		$this->Cell(0, 6, ': ' . $this->fields_value['Nama Peserta'] , 0, 1);


	// 		//Tgl. Lahir
	// 		$this->Cell(5);
	// 		$this->Cell(30, 6, 'Tgl. Lahir');
	// 		$this->Cell(80, 6, ': ' . $this->fields_value['Tgl. Lahir'], 0, 0);

	// 		//COB
	// 		$this->Cell(30, 6, 'COB');
	// 		$this->Cell(0, 6, ': ', 0, 1);

	// 		//Jenis Kelamin
	// 		$this->Cell(5);
	// 		$this->Cell(30, 6, 'Jenis Kelamin');
	// 		$this->Cell(80, 6, ': ' . $this->fields_value['Jenis Kelamin'], 0, 0);

	// 		//Jenis Rawat
	// 		$this->Cell(30, 6, 'Jenis Rawat');
	// 		$this->Cell(0, 6, ': ' .  $this->fields_value['Jenis Rawat'], 0, 1);

	// 		//Poli Tujuan
	// 		$this->Cell(5);
	// 		$this->Cell(30, 6, 'Poli Tujuan');
	// 		$this->Cell(80, 6, ': ' . $this->fields_value['Poli Tujuan'], 0, 0);

	// 		//Kelas Rawat
	// 		$this->Cell(30, 6, 'Kelas Rawat');
	// 		$this->Cell(0, 6, ': ' . $this->fields_value['Kelas Rawat'], 0, 1);

	// 		//Asal Faskes
	// 		$this->Cell(5);
	// 		$this->Cell(30, 6, 'Asal Faskes');
	// 		$this->Cell(50, 6, ': ' . $this->fields_value['Asal Faskes'], 0, 1);

	// 		//Diagnosa Awal
	// 		$this->Cell(5);
	// 		$this->Cell(30, 6, 'Diagnosa Awal');
	// 		$this->Cell(0, 6, ': ' . $this->fields_value['Diagnosa Awal'], 0, 1);

	// 		//Catatan
	// 		$this->Cell(5);
	// 		$this->Cell(30, 5, 'Catatan');
	// 		$this->Cell(0, 5, ': ' . $this->fields_value['Catatan'], 0, 1);

	// 		$this->SetFont('Arial', '', 8);

	// 		$this->Cell(0, 5, ' ', 0, 1);

	// 		$this->Cell(5);
	// 		$this->Cell(0, 1, '*Saya Menyetujui BPJS Kesehatan menggunakan informasi Medis Pasien jika diperlukan.',0,1);

	// 		$this->Cell(5);
	// 		$this->Cell(0, 8, '*SEP bukan sebagai bukti penjaminan peserta',0,1);

	// 		$this->SetFont('Arial', '', 9);
	// 		//Cetakan
	// 		$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
	// 		$this->Cell(5);
	// 		$this->Cell(30, 5, 'Cetakan ke' . ' ' . $this->fields_value['Cetakan Ke']);
	// 		$this->Cell(0, 5, ': ' . $date->format('d-m-Y H:i:s'), 0, 1);
	// 	}

  //          public function div4() {

		// 	$this->SetFont('Arial', '', 10);

		// 	$this->Cell(0, 10, ' ', 0, 1);

		// 	$this->Cell(18);
		// 	$this->Cell(70, 3, 'R \ Nama Obat', 0, 0);
		// 	$this->Cell(50);
		// 	$this->Cell(30, 3, ':', 0, 1, 'C');

		// }



		public function set_nilai($array) {
			$this->fields_value = $array;
		}



	}

?>
