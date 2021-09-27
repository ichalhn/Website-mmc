 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(dirname(dirname(__FILE__)).'/Tglindo.php');

require_once(APPPATH.'controllers/Secure_area.php');
class Rjccetaklaporan extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('irj/Rjmpencarian','',TRUE);
		$this->load->model('irj/Rjmpelayanan','',TRUE);
		$this->load->model('irj/Rjmkwitansi','',TRUE);
		$this->load->model('irj/Rjmlaporan','',TRUE);
		$this->load->helper('pdf_helper');
	}
	public function index()
	{
		redirect('irj/Rjcregistrasi','refresh');
	}
	
	public function pdf_lapkunj($tampil_per='', $id_poli='', $var1='',$cara_bayar='')
	{
		$data['tgl_indo'] = new Tglindo();
		$data['id_poli']=$id_poli;
		$tgl_indo = new Tglindo();
		
		//get nama poli
		$nm_poli=$this->Rjmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		
		$header_pdf=$this->config->item('header_pdf');
		$namars=$this->config->item('namars');
		$kota_kab=$this->config->item('kota');
		$alamat=$this->config->item('alamat');
		$nmsingkat=$this->config->item('namasingkat');
		
		if ($tampil_per=="TGL") {
			
			$tgl=$var1;
				
			//nama file----------------------------------
			$date_title = "Tanggal";
			
			$tgl1 = date('d-m-Y', strtotime($tgl));
			$date='<b>'.substr($tgl1,0,2).' '.$tgl_indo->bulan(substr($tgl1,3,2)).' '.substr($tgl1,6,4).'</b>';
			//-------------------------------------------
			
			if ($id_poli=="SEMUA") {
				
				$file_name="KUNJ_POLI_$tgl1.pdf";
				$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();
				$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_poli_harian($tgl,$cara_bayar)->result();
				$konten = $this->load->view('irj/rjvlapkunjungan_harian',$data,true);
				if($cara_bayar!='SEMUA'){
					if($cara_bayar=='DIJAMIN' or $cara_bayar=='JAMSOSKES'){
						$poli_header="<tr>
								<td ><b>Pasien</b></td>
								<td>:</td>
								<td><b>DIJAMIN</b></td>
							</tr>";
					}else
						$poli_header="<tr>
								<td ><b>Pasien</b></td>
								<td>:</td>
								<td><b>$cara_bayar</b></td>
							</tr>";						
				}
				else $poli_header= "";
				
			} else {
			
				$file_name="KUNJ_POLI_".$id_poli."_$tgl1.pdf";
				$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_harian($tgl, $id_poli,$cara_bayar)->result();
				$konten = $this->load->view('irj/rjvlapkunjungan_harian',$data,true);

				$poli_header= "<tr>
								<td><b>Poliklinik</b></td>
								<td>:</td>
								<td><b>$nm_poli</b></td>
							</tr>";
			}
		} else if ($tampil_per=="BLN") {
				
				$bulan=$var1;
				$tgl_indo = new Tglindo();
				
				//nama file----------------------------------
				$bulan1 = $tgl_indo->bulan(substr($bulan,5,2))." ".date('Y', strtotime($bulan));
				$date_title = "Bulan";
				$date='<b>'.$bulan1.'</b>';
				//-------------------------------------------
			
				if ($id_poli=="SEMUA") {
					
					$file_name="KUNJ_POLI_$bulan1.pdf";
					$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();
					$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_poli_bulanan(substr($bulan,5,2))->result();
					$konten = $this->load->view('irj/rjvlapkunjungan_bulanan',$data,true);
				
					$poli_header= "";
					
				} else {
					
					$file_name="KUNJ_POLI_".$id_poli."_$bulan1.pdf";
					$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_bulanan(substr($bulan,5,2), $id_poli)->result();
					$konten = $this->load->view('irj/rjvlapkunjungan_bulanan',$data,true);
					
					$poli_header= "<tr>
									<td><b>Poliklinik</b></td>
									<td>:</td>
									<td><b>$nm_poli</b></td>
								</tr>";
				}
			
		} else if ($tampil_per=="THN") {
				
			$tahun=$var1;
			
			//nama file----------------------------------
			$date_title = "Tahun";
			$date='<b>'.$tahun.'</b>';
			//-------------------------------------------
			
			if ($id_poli=="SEMUA") {
			
				$file_name="KUNJ_POLI_$tahun.pdf";
				$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();
				$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_poli_tahunan($tahun, $id_poli)->result();
				$konten = $this->load->view('irj/rjvlapkunjungan_tahunan',$data,true);
				$date1="($date)";
				$poli_header= "";
				
			} else {
				
				$file_name="KUNJ_POLI_".$id_poli."_$tahun.pdf";
				$data['data_laporan_kunj']=$this->Rjmlaporan->get_data_kunj_tahunan($tahun, $id_poli)->result();
				$konten = $this->load->view('irj/rjvlapkunjungan_tahunan',$data,true);
				
				$poli_header= "
							<tr>
								<td><b>Poliklinik</b></td>
								<td>:</td>
								<td><b>$nm_poli</b></td>
							</tr>";
			}
		}
		
		$html="
			$header_pdf
			<hr>
			<table>
					<tr>
						<td colspan=\"3\"><p align=\"center\"><br><b>Laporan Kunjungan Poliklinik</b></p></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td width=\"10%\"><b>$date_title</b></td>
						<td width=\"5%\">:</td>
						<td width=\"75%\">$date</td>
					</tr>
					$poli_header					
				<tr>
					
					<td></td>
					<td colspan=\"2\"></td>
				</tr>
				</table>
			<br/>
			";
			
			$html .= $konten;
			
			
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setPrintHeader(false);
				//$obj_pdf->setPrintFooter(false);
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins('5', '10', PDF_MARGIN_RIGHT);
				$obj_pdf->SetAutoPageBreak(TRUE, '15');
				$obj_pdf->SetFont('helvetica', '', 11);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				//$obj_pdf->writeHTML($content, true, false, true, false, '');
				$obj_pdf->writeHTML($html);
				$obj_pdf->Output(FCPATH.'/download/irj/rjlaporan/kunjungan/'.$file_name, 'FI');
		
		//}else{
		redirect('irj/Rjclaporan/lapkunjungan','refresh');
		//}
	}
	
	public function pdf_lapkeu($tampil_per='', $id_poli='', $var1='', $status='', $cara_bayar='')
	{
		$data['tgl_indo'] = new Tglindo();
		$data['id_poli']=$id_poli;
		$data['status']=$status;
		$data['cara_bayar']=$cara_bayar;
		$tgl_indo = new Tglindo();
		
		if ($id_poli!="SEMUA") {
			//get nama poli
			$nm_poli=$this->Rjmpencarian->get_nm_poli($id_poli)->row()->nm_poli;
		}
		
		$namars=$this->config->item('namars');
		$kota_kab=$this->config->item('kota');
		$alamat=$this->config->item('alamat');
		$nmsingkat=$this->config->item('namasingkat');
		
		if ($tampil_per=="TGL") {
		 
			$cara_bayar="<tr>
				<td width=\"10%\"><b>Pasien</b></td>
				<td width=\"5%\">:</td>
				<td width=\"80%\"><b>$cara_bayar</b></td>
				</tr>";
			$tgl=$var1;
				
			//nama file----------------------------------
			$tgl1 = date('d-m-Y', strtotime($tgl));
			$date='<b>'.substr($tgl1,0,2).' '.$tgl_indo->bulan(substr($tgl1,3,2)).' '.substr($tgl1,6,4).'</b>';
			$date_title = 'Tanggal';
			//-------------------------------------------
							
			if ($id_poli=="SEMUA") {
				
				$file_name="KEU_POLI_$tgl1.pdf";
				$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_harian($tgl, $status,$data['cara_bayar'])->result();
				$konten = $this->load->view('irj/rjvlapkeuangan_harian',$data,true);
				
				$poli_header= "";
				
			} else {
			
				$poli_header= "<tr>
								<td><b>Poliklinik</b></td>
								<td>:</td>
								<td><b>$nm_poli</b></td>
							</tr>";
			
				$file_name="KEU_POLI_".$id_poli."_$tgl1.pdf";
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_harian($tgl, $id_poli, $status,$data['cara_bayar'])->result();
				$konten = $this->load->view('irj/rjvlapkeuangan_harian',$data,true);
			}
		} else if ($tampil_per=="BLN") {

			$cara_bayar="<tr>
				<td width=\"10%\"><b>Pasien</b></td>
				<td width=\"5%\">:</td>
				<td width=\"80%\"><b>$cara_bayar</b></td>
				</tr>";
			$bulan=$var1;
			$tgl_indo = new Tglindo();
				
			//nama file----------------------------------
			$bulan1 = $tgl_indo->bulan(substr($bulan,5,2))." ".date('Y', strtotime($bulan));
			$date_title = "Bulan";
			$date="<b>$bulan1</b>";
			//-------------------------------------------
			
				
			if ($id_poli=="SEMUA") {
				
				$file_name="KEU_POLI_$bulan1.pdf";
				$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_bulanan(substr($bulan,5,2), $status, $data['cara_bayar'])->result();
				$konten = $this->load->view('irj/rjvlapkeuangan_bulanan',$data,true);
			
				$poli_header= "";
				
			} else {
				
				$file_name="KEU_POLI_".$id_poli."_$bulan1.pdf";
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_bulanan(substr($bulan,5,2), $id_poli, $status, $data['cara_bayar'])->result();
				$konten = $this->load->view('irj/rjvlapkeuangan_bulanan',$data,true);
				
				$poli_header= "
							<tr>
								<td><b>Poliklinik</b></td>
								<td>:</td>
								<td><b>$nm_poli</b></td>
							</tr>";
			}
			
		} else if ($tampil_per=="THN") {
				
			$cara_bayar="<tr>
				<td width=\"10%\"><b>Pasien</b></td>
				<td width=\"5%\">:</td>
				<td width=\"80%\"><b>$cara_bayar</b></td>
				</tr>";
			$tahun=$var1;
			
			//nama file----------------------------------
			$date_title = 'Tahun';
			$date='<b>'.$tahun.'</b>';
			//-------------------------------------------
			
			if ($id_poli=="SEMUA") {
			
				$file_name="KEU_POLI_$tahun.pdf";
				$data['poli']=$this->Rjmpencarian->get_poliklinik()->result();
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_poli_tahunan($tahun, $status, $data['cara_bayar'])->result();
				$konten = $this->load->view('irj/rjvlapkeuangan_tahunan',$data,true);
			
				$poli_header= "";
				
			} else {
				
				$file_name="KEU_POLI_".$id_poli."_$tahun.pdf";
				$data['data_laporan_keu']=$this->Rjmlaporan->get_data_keu_tahunan($tahun, $id_poli, $status, $data['cara_bayar'])->result();
				$konten = $this->load->view('irj/rjvlapkeuangan_tahunan',$data,true);
				
				$poli_header= "
							<tr>
								<td><b>Poliklinik</b></td>
								<td>:</td>
								<td><b>$nm_poli</b></td>
							</tr>";
			}
		}
		
		if ($status=='10') {
			$status_header = '<tr>
								<td><b>Status</b></td>
								<td>:</td>
								<td><b>Pulang dan Dirawat</b></td>
							</tr>';
		} else if ($status=='1') {
			$status_header = '<tr>
								<td><b>Status</b></td>
								<td>:</td>
								<td><b>Pulang</b></td>
							</tr>';
		} else if ($status=='0') {
			$status_header = '<tr>
								<td><b>Status</b></td>
								<td>:</td>
								<td><b>Dirawat</b></td>
							</tr>';
		}
		
		$html="<table>
					<tr>
						<td colspan=\"3\"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p></td>
					</tr>
					<tr>
						<td colspan=\"3\"><p align=\"center\"><br><b>Laporan Keuangan Poliklinik</b></p></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td width=\"10%\"><b>$date_title</b></td>
						<td width=\"5%\">:</td>
						<td width=\"75%\">$date</td>
					</tr>
		
				$poli_header $status_header $cara_bayar
				<hr>
				<tr>
					
					<td></td>
					<td colspan=\"2\"></td>
				</tr>
				</table>
			<br/>

			";
			
			$html .= $konten;
		
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				tcpdf();
				
					
					
				$obj_pdf = new TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
				$obj_pdf->SetCreator(PDF_CREATOR);
				$title = "";
				$obj_pdf->SetTitle($file_name);
				$obj_pdf->SetHeaderData('', '', $title, '');
				$obj_pdf->setPrintHeader(false);
				$obj_pdf->setPrintFooter(false);
				$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$obj_pdf->SetDefaultMonospacedFont('helvetica');
				$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
				$obj_pdf->SetAutoPageBreak(TRUE, '15');
				$obj_pdf->SetFont('helvetica', '', 11);
				$obj_pdf->setFontSubsetting(false);
				$obj_pdf->AddPage();
				ob_start();
					$content = $konten;
				ob_end_clean();
				$obj_pdf->writeHTML($html, true, false, true, false, '');
				//$obj_pdf->writeHTML($html);
				$obj_pdf->Output(FCPATH.'/download/irj/rjlaporan/keuangan/'.$file_name, 'FI');
		
		//}else{
		redirect('irj/Rjclaporan/lapkeu','refresh');
		//}
	}
	
	public function pdf_lapkeudokter($id_dokter='', $tgl_awal='', $tgl_akhir='', $cara_bayar)
	{
		$data['tgl_indo'] = new Tglindo();
		$data['id_dokter']=$id_dokter;
		$data['tgl_awal']=$tgl_awal;
		$data['tgl_akhir']=$tgl_akhir;
		$data['dokter']=$this->Rjmpencarian->get_dokter()->result();
		
		if($tgl_awal!='' && $tgl_akhir!=''){
			
			$tgl_awal1 = date('d-m-Y', strtotime($tgl_awal));
			$tgl_akhir1 = date('d-m-Y', strtotime($tgl_akhir));
				
			$namars=$this->config->item('namars');
			$kota_kab=$this->config->item('kota');
			$alamat=$this->config->item('alamat');
			$nmsingkat=$this->config->item('namasingkat');
			
			$date_title = "Tanggal";
			
			if ($id_dokter=="SEMUA") {
				
				if($tgl_awal!=$tgl_akhir){
				$date='<b>'.$tgl_awal1.' s/d '.$tgl_akhir1.'</b>';
				$file_name="PENDAPATAN_DOKTER_(".$tgl_awal1."_sd_".$tgl_akhir1.").pdf";
				}else{
					$date='<b>'.$tgl_awal1.'</b>';
					$file_name="PENDAPATAN_DOKTER_($tgl_awal1).pdf";
				}
				$dokter_header= "";
				$data['dokter']=$this->Rjmlaporan->get_data_keu_det_dokter($data['id_dokter'], $data['tgl_awal'],$data['tgl_akhir'], $cara_bayar)->result();
				//print_r($data['dokter']);
			} else {
				//get nama dokter
				$nm_dokter=$this->Rjmlaporan->get_nm_dokter($id_dokter)->row()->nm_dokter;
			
				if($tgl_awal!=$tgl_akhir){
				$date='<b>'.$tgl_awal1.' s/d '.$tgl_akhir1.'</b>';
				$file_name="PENDAPATAN_DOKTER_".$id_dokter."_(".$tgl_awal1."_sd_".$tgl_akhir1.").pdf";
				}else{
					$date='<b>'.$tgl_awal1.'</b>';
					$file_name="PENDAPATAN_DOKTER_".$id_dokter."_($tgl_awal1).pdf";
				}
				
				$dokter_header= "<tr>
								<td><b>Dokter</b></td>
								<td>:</td>
								<td><b>$nm_dokter</b></td>
							</tr>";
			}
			
			$data['datakeu_dokter']=$this->Rjmlaporan->get_data_keu_dokter($data['id_dokter'], $data['tgl_awal'],$data['tgl_akhir'], $cara_bayar)->result();
			$konten = $this->load->view('irj/rjvlapkeuangandokter_harian',$data,true);
	
			$html="
				<table>
					<tr>
						<td colspan=\"3\"><p align=\"center\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p></td>
					</tr>
					<tr>
						<td colspan=\"3\"><p align=\"center\"><br><b>Laporan Pendapatan Dokter</b></p></td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td width=\"13%\"><b>$date_title</b></td>
						<td width=\"2%\">:</td>
						<td width=\"70%\">$date</td>
					</tr>
					<tr>
						<td width=\"13%\"><b>Tipe Pasien</b></td>
						<td width=\"2%\">:</td>
						<td width=\"70%\"><b>$cara_bayar</b></td>
					</tr>
					$dokter_header
					<hr>
					
					<tr>
					<td></td>
					<td colspan=\"2\"></td>
					</tr>
				</table>
				<br/>
			";
			
			$html .= $konten;
			
			
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			tcpdf();
			$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
			$obj_pdf->SetCreator(PDF_CREATOR);
			$title = "";
			$obj_pdf->SetTitle($file_name);
			$obj_pdf->SetHeaderData('', '', $title, '');
			$obj_pdf->setPrintHeader(false);
			//$obj_pdf->setPrintFooter(false);
			$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$obj_pdf->SetDefaultMonospacedFont('helvetica');
			$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
			$obj_pdf->SetAutoPageBreak(TRUE, '15');
			$obj_pdf->SetFont('helvetica', '', 11);
			$obj_pdf->setFontSubsetting(false);
			$obj_pdf->AddPage();
			ob_start();
			$content = $konten;
			ob_end_clean();
			//$obj_pdf->writeHTML($content, true, false, true, false, '');
			$obj_pdf->writeHTML($html);
			$obj_pdf->Output(FCPATH.'/download/irj/rjlaporan/keuangan_dokter/'.$file_name, 'FI');
		
			redirect('irj/Rjclaporan/lapkeu_dokter','refresh');
		}
	}
	
}
?>
