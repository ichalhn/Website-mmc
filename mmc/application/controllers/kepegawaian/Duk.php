<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class Duk extends Secure_area {

	public function __construct() {
		parent::__construct();
		$this->load->model('kepegawaian/M_pegawai','',TRUE);
		$this->load->helper('pdf_helper');
	}
	
	public function index() {
		$data['title'] = 'Daftar Urutan Kepangkatan';
		$this->load->view("kepegawaian/data_duk", $data);
	}
	
	public function data(){	
		$line  = array();
		$line2 = array();
		$row2  = array();		
		$hasil = $this->M_pegawai->get_data_duk();	
		foreach ($hasil as $value) {
			$row2['id_golongan'] = $value->id_golongan;
			$row2['nip'] = $value->nip;
			$row2['nm_pegawai'] = $value->nm_pegawai;
			$row2['nm_golongan'] = $value->nm_golongan;
			$row2['pangkat'] = $value->pangkat;
			$row2['nm_bagian'] = $value->nm_bagian;
			$row2['nm_subag'] = $value->nm_subag;
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}
	
	public function export_to_pdf(){
		$namars=$this->config->item('namars');
		$kota_kab=$this->config->item('kota');
		$alamat=$this->config->item('alamat');
		$nmsingkat=$this->config->item('namasingkat');
		$data['title'] = 'KEMENTRIAN KESEHATAN';

		//$tampil = substr($tampil_per, 0, 3);
		//print_r($tampil);

		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam=date("d-m-Y H:i:s");
		
				$tgl1 = date('d F Y');
				
				
				$date_title='<b>'.$tgl1.'</b>';
				$file_name="DUK_$tgl1.pdf";
				
				$data_laporan= $this->M_pegawai->get_data_duk();	
				$konten=
						"<style>
						tr.border_bottom td {
						  border-top:1pt solid black;
						}
						</style>
						<table>
							<tr>
								<td colspan=\"2\"><p align=\"left\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p>
								</td>
								<td align=\"right\">$tgl_jam</td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"left\"><font size=\"10\"><b>alamat</b></font></p></td>
							</tr>
							<hr>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><b>Laporan Pembelian Logistik Farmasi</b></p></td>
							</tr>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td width=\"10%\"><b>tampil_per</b></td>
								<td width=\"5%\">:</td>
								<td width=\"80%\">$date_title</td>
							</tr>
						</table>
						<br/><hr>
						
						<table border=\"1\"   style=\"padding:2px\">
						<thead>
							<tr>
								<th width=\"5%\">No</th>
								<th width=\"25%\">Supplier</th>
								<th width=\"70%\">Rincian Obat</th>							
							</tr>
						</thead>
						<tbody>
							
			";
			
			
					$i=0;
					foreach($data_laporan as $row){
						$supplier=$row->id_golongan;
						$konten=$konten."<tr>
							<td width=\"5%\">".$i++."</td>
							<td width=\"25%\">".$row->nip."</td>
							<td width=\"70%\">
							</td>

				</tr>";
						
			}
			$konten=$konten."</tbody>
					</table>					
					<h4 align=\"center\"><b>Total Data : ".$i."<b></h4>";
						
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->SetTitle($file_name);
					$obj_pdf->SetPrintHeader(false);
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
					$obj_pdf->Output(FCPATH.'download/logistik_farmasi/Frmlaporan/'.$file_name, 'FI');
						
			
		
	}
}