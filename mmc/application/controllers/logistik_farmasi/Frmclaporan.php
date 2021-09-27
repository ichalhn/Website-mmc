 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
//
include(dirname(dirname(__FILE__)).'/Tglindo.php');
require_once(APPPATH.'controllers/Secure_area.php');
class Frmclaporan extends Secure_area {
	public function __construct() {
		parent::__construct();
		$this->load->model('ird/ModelPelayanan','',TRUE);
		$this->load->model('ird/ModelRegistrasi','',TRUE);
		$this->load->model('ird/ModelKwitansi','',TRUE);
		$this->load->model('ird/ModelLaporan','',TRUE);
		$this->load->model('logistik_farmasi/Frmmlaporan','',TRUE);
        $this->load->model('logistik_farmasi/Frmmpo','',TRUE);
		$this->load->helper('pdf_helper');
		$this->load->helper('url');
		//include(site_url('/application/controllers/Tglindo.php'));
		//echo site_url('/application/controllers/Tglindo.php');
	}
	public function index()
	{
		// redirect('logistik_farmasi/Frmcdaftar','refresh');
	}

	public function hutang_penjualan(){
        $data['title'] = 'Laporan Hutang Penjualan';
        $data['select_pemasok'] = $this->Frmmpo->get_suppliers();
        $this->load->view('logistik_farmasi/Frmvhutangpenjualan',$data);
    }

    function get_hutang_list(){
	    $line = array();
	    $line2 = array();
	    $row2 = array();

	    if(sizeof($_POST) == 0){
	        $line['data'] = $line2;
        }else{
            $data = $this->Frmmpo->get_hutang($this->input->post());

            foreach ($data as $row) {
                $row2['no_faktur'] = $row->no_faktur;
                $row2['tgl_faktur'] = $row->tgl_faktur;
                $row2['jatuh_tempo'] = $row->jatuh_tempo;
                $row2['supplier'] = $row->supplier;
                $row2['nominal'] = $row->nominal;
                $row2['status'] = "status";
                $row2['aksi'] = "aksi";

                $line2[] = $row2;
            }
            $line['data'] = $line2;
        }

        echo json_encode($line);
    }

	public function data_kunjungan()
	{
		//$this->session->set_flashdata('message_nodata','');
		$data['title'] = 'Laporan Pembelian Logistik Farmasi';
		

		if($_SERVER['REQUEST_METHOD']=='POST'){			
				$tgl_indo=new Tglindo();
				//$tgl_awal=$this->input->post('date_picker_days1');
				//if(){
				//}
				$tgl=$this->input->post('date_picker_days');					
				
				$data['data_laporan_kunj']=$this->Frmmlaporan->get_data_kunj_by_date($tgl)->result();
				$data['data_tindakan']=$this->Frmmlaporan->get_data_tindakan_tgl($tgl)->result();
				
				$tgl1 = date('d F Y', strtotime($tgl));
				$data['date_title']="Laporan Kunjungan Farmasi <b>$tgl1</b>";
				$data['field1']='No. Medrec';					
				$data['tgl']=$tgl;
				
			
				$size=sizeof($data['data_laporan_kunj']);
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

			$this->load->view('farmasi/frmvlapkunjunganrange.php',$data);
		}else{
			$data['data_laporan_kunj']=$this->Frmmlaporan->get_data_kunj_today()->result();
			$data['data_tindakan']=$this->Frmmlaporan->get_data_tindakan()->result();
			
			$data['date_title']='Laporan Kunjungan Pasien Farmasi <b>'.date("d F Y").'</b>';
			$data['tgl']=date("Y-m-d");
			$data['field1']='No. Medrec';	
			
			$size=sizeof($data['data_laporan_kunj']);			

			if($size<1){
				//
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
					
					$data['message_nodata']='';
					$data['size']=$size;
				}

			$this->load->view('farmasi/frmvlapkunjunganrange.php',$data);
		}
	}

	/*public function data_kunjungan($tampil_per='', $param1='')
	{
		$data['title'] = 'Laporan Kunjungan Farmasi';				

		$tgl_indo=new Tglindo();
		if($_SERVER['REQUEST_METHOD']=='POST'){
				$tampil_per=$this->input->post('tampil_per');			
				if($tampil_per=='TGL'){
					$tgl=$this->input->post('date_picker_days');
					$data['data_laporan_kunj']=$this->Frmmlaporan->get_data_kunj_tind_tgl($tgl)->result();
					$data['data_kunjungan']=$this->Frmmlaporan->get_data_keuangan_tgl($tgl)->result();
					$data['cara_bayar_pasien']="";
					$tgl1= date('d F Y', strtotime($tgl));
					
					$data['date_title']="<b>$tgl1</b>";
					$data['field1']='No. Register';
					$data['tgl']=$tgl;	
					}
				}
				$data['tampil_per']=$this->input->post('tampil_per');//untuk param waktu cetak
				
				$size=sizeof($data['data_laporan_kunj']);
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
					$data['message_nodata']='';
					$data['size']=$size;
				}

			$this->load->view('farmasi/frmvlapkunjunganrange',$data);
		}*/
	

	///////////////////////////////////////////////////////////////////////////// PENDAPATAN

	public function data_pendapatan($tampil_per='', $param1='')
	{
		$data['title'] = 'Laporan Pendapatan Logistik Farmasi';				

		$tgl_indo=new Tglindo();
		if($_SERVER['REQUEST_METHOD']=='POST'){
				$tampil_per=$this->input->post('tampil_per');			
				if($tampil_per=='TGL'){
					$tgl=$this->input->post('date_picker_days');
					$data['data_laporan_keu']=$this->Frmmlaporan->get_data_keu_tind_tgl($tgl)->result();
					$data['data_laporan_detail_keu']=$this->Frmmlaporan->get_data_keu_detail_tgl($tgl)->result();
					$tgl1= date('d F Y', strtotime($tgl));
					
					$data['date_title']="<b>$tgl1</b>";
					$data['field1']='No. Register';
					$data['tgl']=$tgl;
					$data['cara_bayar_pasien']='';
					
				}else if($tampil_per=='BLN'){
					$bln=$this->input->post('date_picker_months');			
					$data['data_laporan_keu']=$this->Frmmlaporan->get_data_keu_tind_bln($bln)->result();
					$data['data_periode']=$this->Frmmlaporan->get_data_periode_bln($bln)->result();
					$data['data_keuangan']=$this->Frmmlaporan->get_data_keuangan_bln($bln)->result();
					// $cara_bayar=$this->input->post('jenis_pasien1');	
					// $data['jenis_bayar']=$this->input->post('jenis_pasien1');			
					
					$bln1 = date('Y', strtotime($bln));
					$bln2 = date('m', strtotime($bln));
					$bln3 = $tgl_indo->bulan($bln2);
					//echo $tgl_indo->bulan('08');
					$data['date_title']="per Hari <b>Bulan $bln3 $bln1</b>";
					$data['field1']='Bulan'; //edited
					$data['tgl']=$bln3;
					$data['bln']=$bln;
					$data['date']=$bln;//untuk param waktu cetak

				}else{					
					
					$thn=$this->input->post('date_picker_years');
					$data['data_laporan_keu']=$this->Frmmlaporan->get_data_keu_tind_thn($thn)->result();
					$data['data_periode']=$this->Frmmlaporan->get_data_periode_thn($thn)->result();
					$data['data_keuangan']=$this->Frmmlaporan->get_data_keuangan_thn($thn)->result();		
					
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

			 $this->load->view('logistik_farmasi/pend_today',$data);
		}else{			
			$data['data_laporan_keu']=$this->Frmmlaporan->get_data_keu_tindakan_today()->result();
			$data['data_laporan_detail_keu']=$this->Frmmlaporan->get_data_keu_detail_tgl(date('Y-m-d'))->result();
			$data['date_title']='<b>'.date("d F Y").'</b>';
			$data['tgl']=date("Y-m-d");
			$data['field1']='No. Register';
			$data['stat_pilih']='';
			$data['tampil_per']='TGL';
			$data['cara_bayar_pasien']="";

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
					$data['message_nodata']='';
					$data['size']=$size;
				}

			$this->load->view('logistik_farmasi/pend_today',$data);
			//redirect('ird/IrDLaporan/data','refresh');
		}
	}

	public function lap_keu($tampil_per='',$param1='')
	{
		$data['title'] = 'Laporan Pembelian Logistik Farmasi';

		$tampil = substr($tampil_per, 0, 3);
		//print_r($tampil);

		date_default_timezone_set("Asia/Bangkok");
		$tgl_jam=date("d-m-Y H:i:s");
		
		$namars=$this->config->item('namars');
		$kota_kab=$this->config->item('kota');
		$alamat=$this->config->item('alamat');
		$nmsingkat=$this->config->item('namasingkat');

		$tampil_per=$tampil;		
		if($tampil_per=='TGL'){	
			if($param1!=''){
				$tgl=$param1;
				$tgl1 = date('d F Y', strtotime($tgl));
				
				
				$date_title='<b>'.$tgl1.'</b>';
				$file_name="KEU_LOG_FRM_$tgl1.pdf";
				
				$data_laporan_keu=$this->Frmmlaporan->get_data_keu_tind_tgl($tgl)->result();
				$data_laporan_detail_keu=$this->Frmmlaporan->get_data_keu_detail_tgl($tgl)->result();
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
								<td colspan=\"3\"><p align=\"left\"><font size=\"10\"><b>$alamat</b></font></p></td>
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
								<td width=\"10%\"><b>$tampil_per</b></td>
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
					foreach($data_laporan_keu as $row){
						$supplier=$row->supplier_id;
						$konten=$konten."<tr>
							<td width=\"5%\">".$i++."</td>
							<td width=\"25%\">".$row->company_name."</td>
							<td width=\"70%\">";
					
						$konten=$konten."<table width=\"100%\" >
						<thead>
							<tr class=\"border_bottom\">
								<th width=\"5%\" >No</th>
								<th width=\"30%\">Nama Obat</th>
								<th width=\"25%\">Quantity</th>
								<th width=\"40%\">Nilai</th>											
							</tr>
						</thead>
						<tbody>";
						
						$j=1;$vtot1=0;
						foreach($data_laporan_detail_keu as $row1){
							if($row1->supplier_id==$supplier){
								$vtot1=$vtot1+$row1->item_cost_price;
								
								$konten=$konten."<tr class=\"border_bottom\"><td>".$j."</td>
									<td>".$row1->description."</td>
									<td>".$row1->quantity_purchased."</td>
									<td>".number_format( $row1->item_cost_price, 2 , ',' , '.' )."</td></tr>";
								$j++;
							}
						}
						$konten=$konten."</tbody>
						</table>
					</td>

				</tr>";
						
			}
			$konten=$konten."</tbody>
					</table>					
					<h4 align=\"right\"><b>Total Transaksi : ".$vtot1."<b></h4>";
						
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
					$obj_pdf->Output(FCPATH.'download/logistik_farmasi/'.$file_name, 'FI');
						
			}else{
				redirect('logistik_farmasi/Frmclaporan/data_pendapatan','refresh');
			}
		}else if($tampil_per=='BLN'){
			if($param1!=''){
				$bln=$param1;
				$bln1 = date('F Y', strtotime($bln));
				$bln2 = date('F', strtotime($bln));				
				$date_title='<b>'.$bln1.'</b>';
				$file_name="KEU_FRM_$bln1.pdf";
			
					$data_laporan_keu=$this->Frmmlaporan->get_data_keu_tind_bln($bln)->result();
					$data_periode=$this->Frmmlaporan->get_data_periode_bln($bln)->result();
					$data_keuangan=$this->Frmmlaporan->get_data_keuangan_bln($bln)->result();
						//$data_periode=$this->Frmmlaporan->get_data_periode_bln($bln)->result();
						//$data_keuangan=$this->Frmmlaporan->get_data_keuangan_bln($bln)->result();
			
				$konten=
						"
						<table>
							<tr>
								<td colspan=\"2\"><p align=\"left\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p>
								</td>
								<td align=\"right\">$tgl_jam</td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"left\"><font size=\"10\"><b>$alamat</b></font></p></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><b>Laporan Pembelian Logistik Farmasi</b></p></td>
							</tr>
							<hr>
							
							<tr>
								<td></td>
							</tr>
							<tr>
								<td width=\"10%\"><b>Bulan</b></td>
								<td width=\"5%\">:</td>
								<td width=\"55%\">$date_title</td>	
							</tr>
						</table>
						<br/>";
						$i=1;
						$vtot=0;
						foreach($data_periode as $row1){
							$cek_tgl=$row1->tgl;
						$konten=$konten."<h4><b>Tanggal ".substr($row1->tgl, 8, 2)." ".$bln2."</b></h4>
<hr>
							<table border=\"1\" >
							<thead>
								<tr>
									<th width=\"5%\"><b>No</b></th>
									<th width=\"40%\"><b>Nama Supplier</b></th>
									<th width=\"10%\"><b>Qty</b></th>
									<th width=\"45%\"><b>Total</b></th>
								</tr>
							</thead>
							<tbody>
						";
													
							$j=1;
							$vtot1=0;
							foreach($data_keuangan as $row2){
								if($row2->tgl==$row1->tgl){
									$vtot1=$vtot1+$row2->total;
									$vtot=$vtot+$row2->total;									
										
									$konten=$konten."
										<tr><td width=\"5%\">".$i++."</td>
											<td width=\"40%\">$row2->company_name</td>
											<td width=\"10%\">$row2->jumlah</td>
											<td width=\"45%\">".number_format($row2->total, 2 , ',' , '.' )."</td>
										</tr>";
								$j++;
								}
							}
							$konten=$konten."
										<tr>
											<td colspan=\"3\"  align=\"right\" bgcolor=\"grey\">Total</td>
											<th bgcolor=\"grey\"><p align=\"right\">".number_format($vtot1, 2 , ',' , '.' )."</p></th>
										</tr>
							</tbody>
</table>";
						}
							$konten=$konten."
							<h4 align=\"center\"><b>Total $date_title</b></h4>
								<h4 align=\"center\">".number_format($vtot, 2 , ',' , '.' )."</h4>
				";//echo $konten;
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->SetPrintHeader(false);
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
					$obj_pdf->Output(FCPATH.'download/logistik_farmasi/'.$file_name, 'FI');
			}else{
				redirect('logistik_farmasi/Frmclaporan/data_pendapatan','refresh');
			}
		}else{
			if($param1!=''){
				$thn=$param1;
				//print_r($status);
				$thn1 = date('Y', strtotime($thn));
								
				$date_title='<b>'.$thn1.'</b>';
				$file_name="KEU_LOG_FRM_$thn1.pdf";
						$data_periode=$this->Frmmlaporan->get_data_periode_thn($thn)->result();
						$data_keuangan=$this->Frmmlaporan->get_data_keuangan_thn($thn)->result();
					
					
			
				$konten=
						"
						<table>
							<tr>
								<td colspan=\"2\"><p align=\"left\"><img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"42\"></p>
								</td>
								<td align=\"right\">$tgl_jam</td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"left\"><font size=\"10\"><b>$alamat</b></font></p></td>
							</tr>
							<hr>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td colspan=\"3\"><p align=\"center\"><b>Laporan Pendapatan Logistik Farmasi</b></p></td>
							</tr>
							<tr>
								<td></td>
							</tr>
							<tr>
								<td width=\"10%\"><b>Tahun</b></td>
								<td width=\"5%\">:</td>
								<td width=\"55%\">$date_title</td>	
								
								
							</tr>
						</table>
						<br/><hr/>
						<table border=\"1\" style=\"padding:2px\">
							<tr>
								<td width=\"4%\"><b>No</b></td>
								<td width=\"12%\" align=\"center\"><b>Bulan</b></td>
								<td width=\"50%\" align=\"center\"><b>Nama Supplier</b></td>
								<td width=\"9%\" align=\"center\"><b>Jumlah Obat</b></td>
								<td width=\"25%\" align=\"center\"><b>Biaya Total</b></td>
							</tr>
						";
						$i=1;
						$vtot=0;
						foreach($data_periode as $row){
							//$vtot=$vtot+$row->total;
							if($param2 ==''){
							$rwspn=count($this->Frmmlaporan->row_table_perbln($row->bln)->result());
							}
							
							$rwspn1=$rwspn+1;
							$j=1;
							$vtot1=0;
							foreach($data_keuangan as $row2){
								if($row2->bln==$row->bln){
									$vtot1=$vtot1+$row2->total;
									$vtot=$vtot+$row2->total;
									$konten=$konten."
										<tr>";
										if($j=='1'){
											$konten=$konten."
											<td rowspan=\"$rwspn1\">".$i++."</td>
											<td rowspan=\"$rwspn\">$row2->bln</td>";
										}
									$konten=$konten."
											<td>$row2->company_name</td>
											<td align=\"center\">$row2->jumlah</td>
											<td align=\"right\">".number_format($row2->total, 2 , ',' , '.' )."</td>
										</tr>";
								$j++;
								}
							}
							$konten=$konten."
										<tr>
											<td colspan=\"2\"  align=\"right\" bgcolor=\"grey\">Total</td>
											<th bgcolor=\"grey\"><p align=\"right\">".number_format($vtot1, 2 , ',' , '.' )."</p></th>
										</tr>";
						}
							$konten=$konten."
							
						</table>
						<h3 bgcolor=\"yellow\"align=\"right\">Total $date_title : Rp. ".number_format($vtot, 2 , ',' , '.' )."</h3>
				";
			//print_r($data_laporan_keu);
			//echo $konten;

			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					tcpdf();
					$obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
					$obj_pdf->SetCreator(PDF_CREATOR);
					$title = "";
					$obj_pdf->SetPrintHeader(false);
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
					$obj_pdf->Output(FCPATH.'download/logistik_farmasi/'.$file_name, 'FI');
			}else{
				redirect('logistik_farmasi/Frmclaporan/data_pendapatan','refresh');
			}
		}
	}

		public function export_excel($tampil_per='',$param1='',$param2='')
	{
		$data['title'] = 'Laporan Pembelian Logistik Farmasi';

		$tgl_indo=new Tglindo();
		$tampil = substr($tampil_per, 0, 3);
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
		$objPHPExcel->getProperties()->setCreator("RS H RABAIN MUARA ENIM")  
		        ->setLastModifiedBy("RS H RABAIN MUARA ENIM")  
		        ->setTitle("Laporan Keuangan RS H RABAIN MUARA ENIM")  
		        ->setSubject("Laporan Keuangan RS RS H RABAIN MUARA ENIM")  
		        ->setDescription("Laporan Keuangan RS H RABAIN MUARA ENIM for Office 2007 XLSX, generated by HMIS.")  
		        ->setKeywords("RS H RABAIN MUARA ENIM")  
		        ->setCategory("Laporan Keuangan");  

		//$objReader = PHPExcel_IOFactory::createReader('Excel2007');    
		//$objPHPExcel = $objReader->load("project.xlsx");
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);

		$tampil_per=$tampil;		
		if($tampil_per=='TGL'){	
			if($param1!=''){
				$tgl=$param1;
				$tgl1 = date('d F Y', strtotime($tgl));
				
				
				$date_title='<b>'.$tgl1.'</b>';
				$file_name="KEU_LOG_FRM_$tgl1.pdf";
				
				$data_laporan_keu=$this->Frmmlaporan->get_data_keu_tind_tgl($tgl)->result();
				
				$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_logistik_farmasi_tgl.xlsx');
				// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
				$objPHPExcel->setActiveSheetIndex(0);  
				// Add some data  
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
				$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Tanggal : '.$tgl1);
				$vtot1=0;
				$i=1;
				$rowCount = 5;
						foreach($data_laporan_keu as $row){
							$vtot1=$vtot1+$row->vtot;
							$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
							$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->company_name);
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->description);
								$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->quantity_purchased);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->item_cost_price);
								$rowCount++;
								$i++;
						}	
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total');
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtot1);
							header('Content-Disposition: attachment;filename="Lap_Keu_Logistik_Farmasi_TGL.xlsx"'); 
						
			}else{
				redirect('logistik_farmasi/Frmclaporan/data_pendapatan','refresh');
			}

			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			}else if($tampil_per=='BLN'){
			if($param1!=''){
				$bln=$param1;
				$bln1 = date('F Y', strtotime($bln));
								
				$date_title='<b>'.$bln1.'</b>';
				$file_name="KEU_LOG_FRM_$bln1.pdf";

				
						$data_periode=$this->Frmmlaporan->get_data_periode_bln($bln)->result();
						$data_keuangan=$this->Frmmlaporan->get_data_keuangan_bln($bln)->result();		
						$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_logistik_farmasi_bln.xlsx');
						// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
						$objPHPExcel->setActiveSheetIndex(0);  

						// Add some data  
						$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
						$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Bulan : '.$bln1);

				//$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Pasien : '.$jenis_param2);
						$rowCount=6;
						$i=1;
						$vtot=0;
						foreach($data_periode as $row){
							//$vtot=$vtot+$row->total;
							$rwspn=count($this->Frmmlaporan->row_table_pertgl($row->tgl)->result());
							$rwspn1=$rwspn+1;

							$j=1;
							$vtot1=0;
							foreach($data_keuangan as $row2){
								if($row2->tgl==$row->tgl){
									$vtot1=$vtot1+$row2->total;
									$vtot=$vtot+$row2->total;
										if($j=='1'){
											$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tgl);
											$i++;
										}
									
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->description);
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah);
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->total);
										
								$j++;
							    $rowCount++;
								}
							}
									
						}
								$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Total', $date_title);
								$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtot);		
										
								header('Content-Disposition: attachment;filename="Lap_Keu_Logistik_Farmasi_Bulan.xlsx"');  
					}else{
				redirect('logistik_farmasi/Frmclaporan/data_pendapatan','refresh');
			}
							
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			}else{
			if($param1!=''){
				$thn=$param1;
				//print_r($status);
				$thn1 = date('Y', strtotime($thn));
								
				$date_title='<b>'.$thn1.'</b>';
				$file_name="KEU_FRM_$thn1.pdf";

				if($param2==''){
						$data_periode=$this->Frmmlaporan->get_data_periode_thn($thn)->result();
						$data_keuangan=$this->Frmmlaporan->get_data_keuangan_thn($thn)->result();
						$cara_bayar_pasien='Semua';
					} 
			
					$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_keu_logistik_farmasi_thn.xlsx');
					// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
					$objPHPExcel->setActiveSheetIndex(0);  

					// Add some data  
					$objPHPExcel->getActiveSheet()->SetCellValue('A1', $data['title']);
					$objPHPExcel->getActiveSheet()->SetCellValue('A3', 'Tahun : '.$thn);


						$jenis_param2="Semua";
					
					//$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Pasien : '.$jenis_param2);
					
						$rowCount = 6;
						$i=1;
						$vtot=0;
						foreach($data_periode as $row){
							//$vtot=$vtot+$row->total;
							$rwspn=count($this->Frmmlaporan->row_table_perbln($row->bln)->result());
							$rwspn1=$rwspn+1;
							$j=1;
							$vtot1=0;
							foreach($data_keuangan as $row2){
								if($row2->bln==$row->bln){
									
									$vtot=$vtot+$row2->total;
									
										if($j=='1'){
											$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
											$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->bln);
											
											$i++;
										}
											$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row2->description);
											$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row2->jumlah);
											$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row2->total);
										
									$j++;
							    	$rowCount++;
								}
							}	
										
						}
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Total', $date_title);
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $vtot);
						header('Content-Disposition: attachment;filename="Lap_Pembelian_Logistik_Farmasi_Tahun.xlsx"');  
				}else{
					redirect('logistik_farmasi/Frmclaporan/data_pendapatan','refresh');
				}
			}

		// Rename worksheet (worksheet, not filename)  
		$objPHPExcel->getActiveSheet()->setTitle('RS H RABAIN MUARA ENIM');  
		   
		   
		   
		// Redirect output to a client’s web browser (Excel2007)  
		//clean the output buffer  
		ob_end_clean(); 
		ob_start();
		   
		//this is the header given from PHPExcel examples.   
		//but the output seems somewhat corrupted in some cases.  
		//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
		//so, we use this header instead.  
		header('Content-type: application/vnd.ms-excel');  
		header('Cache-Control: max-age=0');  
		   
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
		$objWriter->save('php://output');  
	}

	public function data_pendapatan_new($tampil_per='', $param1=''){
		$data['title'] = 'Laporan Pembelian Per Nomor Faktur & Detail Obat';

		$tgl_indo=new Tglindo();
		$data['date_title']='<b>'.date("d F Y").'</b>';
		$data['tgl']=date("Y-m-d");

		$data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Pembelian.
			</h4>							
			</div>
		</div>";

		$this->load->view('logistik_farmasi/frmvlaporanpembelian',$data);
	}

    public function data_penjualan_obat($tampil_per='', $param1=''){
        $data['title'] = 'Laporan Penjualan Obat Terbanyak';

        $tgl_indo=new Tglindo();
        $data['date_title']='<b>'.date("d F Y").'</b>';
        $data['tgl']=date("Y-m-d");

        $data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Penjualan Terbanyak.
			</h4>							
			</div>
		</div>";

        $this->load->view('logistik_farmasi/frmvlaporanpenjualanterbanyak',$data);
    }

	public function download_pembelian($param1='',$param2='', $filter=''){
		////EXCEL 
		/*$data_keuangan=$this->Frmmlaporan->get_data_pembelian($param1, $param2)->result();
		echo "<pre>";
		echo print_r($data_keuangan);
		echo "</pre>";*/

		$this->load->library('Excel');  
		   
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();   
		   
		// Set document properties  
		$objPHPExcel->getProperties()->setCreator("RS AL Marinir Cilandak")  
		        ->setLastModifiedBy("RS AL Marinir Cilandak")  
		        ->setTitle("Laporan Pembelian Obat Apotek YANMASUM")  
		        ->setSubject("Laporan Pembelian Obat Apotek YANMASUM")  
		        ->setDescription("Laporan Pembelian Obat Apotek YANMASUM, generated by HMIS.")  
		        ->setKeywords("RS AL Marinir Cilandak")
		        ->setCategory("Laporan Pembelian Obat");  
		   
		$objReader= PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);

		$data_keuangan=$this->Frmmlaporan->get_data_pembelian($param1, $param2, $filter)->result();
	
		$objPHPExcel=$objReader->load(APPPATH.'third_party/lap_pembelian_obat.xlsx');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Add some data
      	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('I3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('J3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('K3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('L3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('M3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('N3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
      	$objPHPExcel->getActiveSheet()->getStyle('O3')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      	$objPHPExcel->getActiveSheet()->setAutoFilter('A3:O3');

		$objPHPExcel->getActiveSheet()->SetCellValue('A1', "Laporan Pembelian Obat Per Faktur Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
      	$objPHPExcel->getActiveSheet()->mergeCells('A1:O1');
      	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('A2', "Filter Berdasarkan: ".$filter);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:O2');
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$rowCount = 4;
		$temp = "";
		$i=1;
        $tdiskon = 0; $tppn = 0; $tmaterai = 0; $ttot = 0;
		foreach($data_keuangan as $row){
            $tplusdiskon = $row->total_obat - $row->diskon_item;
            $tplusdiskonplusdiskon = $tplusdiskon - $row->diskon;
            //Jika PPN
            if($row->ppn == 1){
                $ppn = ($tplusdiskonplusdiskon*10) / 100;
            }else{
                $ppn = 0;
            }
            $subtotal = $tplusdiskonplusdiskon + $ppn + $row->materai;

            $tdiskon += $row->diskon_item;
            $tppn += $ppn;
            $tmaterai += $row->materai;
            $ttot += $subtotal;

			if($temp == $row->id_po){
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->description);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->qty_beli);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->satuank);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->harga_po);
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->diskon_item);
				$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $tplusdiskon);
				$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->diskon);
				$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $ppn);
				$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->materai);
				$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $subtotal);
			}else {
				$temp = $row->id_po;
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row->no_po);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->no_faktur);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->tgl_po);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->jatuh_tempo);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->company_name);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->description);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->qty_beli);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->satuank);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->harga_po);
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->diskon_item);
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $tplusdiskon);
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->diskon);
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $ppn);
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->materai);
                $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $subtotal);
			}
			//Update Untuk Cilandak
			/*$temp = $row->no_resep;
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tgl_kunjungan);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->no_resep);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->no_register);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->no_medrec);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->no_kartu);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->nama);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->cara_bayar);
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->kontraktor);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->no_kartu);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row->pangkat);
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->kesatuan);
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row->dokter);
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->ruangan);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row->status);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row->harga);
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $row->jumlah);
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $row->total_obat);
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $row->tuslah);
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row->sub_total);
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $row->diskon);
			$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $row->total);
			$total_diskon = $total_diskon + $row->diskon;
			$total_pendapatan = $total_pendapatan + $row->total;*/
			$i++;
			$rowCount++;
		}
		$filename = "Laporan_Pembelian Obat_".date('d F Y', strtotime($param1))."-".date('d F Y', strtotime($param2));
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "Total : ");
		$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $tdiskon);
		$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $tppn);
		$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $tmaterai);
		$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $ttot);
				
		// Rename worksheet (worksheet, not filename)  
		$objPHPExcel->getActiveSheet()->setTitle('RS AL Marinir Cilandak');    
		   
		// Redirect output to a client’s web browser (Excel2007)  
		//clean the output buffer  
		ob_end_clean(); 
		   
		//this is the header given from PHPExcel examples.   
		//but the output seems somewhat corrupted in some cases.  
		//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
		//so, we use this header instead.  
		header('Content-type: application/vnd.ms-excel');  
		header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
		header('Cache-Control: max-age=0');  
		   
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
		$objWriter->save('php://output');

		//$this->SaveViaTempFile($objWriter);
	}

    public function download_pembelian_by_po($id_po){
        ////EXCEL
        /*$data_keuangan=$this->Frmmlaporan->get_data_pembelian($param1, $param2)->result();
        echo "<pre>";
        echo print_r($data_keuangan);
        echo "</pre>";*/

        $this->load->library('Excel');

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("RS AL Marinir Cilandak")
            ->setLastModifiedBy("RS AL Marinir Cilandak")
            ->setTitle("Laporan Pembelian Obat Apotek YANMASUM")
            ->setSubject("Laporan Pembelian Obat Apotek YANMASUM")
            ->setDescription("Laporan Pembelian Obat Apotek YANMASUM, generated by HMIS.")
            ->setKeywords("RS AL Marinir Cilandak")
            ->setCategory("Laporan Pembelian Obat");

        $objReader= PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);

        $data_keuangan=$this->Frmmlaporan->get_data_pembelian_by_po($id_po)->result();

        $objPHPExcel=$objReader->load(APPPATH.'third_party/lap_pembelian_obat.xlsx');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Add some data
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('H3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('I3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('J3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('K3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('L3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('M3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('N3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('O3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setAutoFilter('A3:O3');

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', "Laporan Pembelian Obat By NO PO");
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:O1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('A2', "");
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:O2');
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $rowCount = 4;
        $temp = "";
        $i=1;
        $tdiskon = 0; $tppn = 0; $tmaterai = 0; $ttot = 0;
        foreach($data_keuangan as $row){
            $tplusdiskon = $row->total_obat - $row->diskon_item;
            $tplusdiskonplusdiskon = $tplusdiskon - $row->diskon;
            //Jika PPN
            if($row->ppn == 1){
                $ppn = ($tplusdiskonplusdiskon*10) / 100;
            }else{
                $ppn = 0;
            }
            $subtotal = $tplusdiskonplusdiskon + $ppn + $row->materai;

            $tdiskon += $row->diskon_item;
            $tppn += $ppn;
            $tmaterai += $row->materai;
            $ttot += $subtotal;

            if($temp == $row->no_po){
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->description);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->qty_beli);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->satuank);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->harga_po);
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->diskon_item);
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $tplusdiskon);
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->diskon);
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $ppn);
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->materai);
                $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $subtotal);
            }else {
                $temp = $row->no_po;
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row->no_po);
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->no_faktur);
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->tgl_po);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->jatuh_tempo);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->company_name);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->description);
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->qty_beli);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->satuank);
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->harga_po);
                $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row->diskon_item);
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $tplusdiskon);
                $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row->diskon);
                $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $ppn);
                $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row->materai);
                $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $subtotal);
            }
            $i++;
            $rowCount++;
        }
        $filename = "Laporan_Pembelian_Obat_by_PO".$id_po;
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "Total : ");
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $tdiskon);
        $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $tppn);
        $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $tmaterai);
        $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $ttot);

        // Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('RS AL Marinir Cilandak');

        // Redirect output to a client’s web browser (Excel2007)
        //clean the output buffer
        ob_end_clean();

        //this is the header given from PHPExcel examples.
        //but the output seems somewhat corrupted in some cases.
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //so, we use this header instead.
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        //$this->SaveViaTempFile($objWriter);
    }

	static function SaveViaTempFile($objWriter){
		$filePath = sys_get_temp_dir() . "/" . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
		$objWriter->save($filePath);
		readfile($filePath);
		unlink($filePath);
	}

    public function distribusi_obat(){
        $data['title'] = 'Laporan Distribusi Obat';

        $tgl_indo=new Tglindo();
        $data['date_title']='<b>'.date("d F Y").'</b>';
        $data['tgl']=date("Y-m-d");

        $data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Distribusi Obat.
			</h4>							
			</div>
		</div>";

        $this->load->view('logistik_farmasi/Frmvlaporandistribusiobat',$data);
    }

    public function distribusi_ruangan(){
      
        $data['title'] = 'Laporan Distribusi Ruangan';

        $tgl_indo=new Tglindo();
        $data['date_title']='<b>'.date("d F Y").'</b>';
        $data['tgl']=date("Y-m-d");

        $data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Distribusi Ruangan.
			</h4>							
			</div>
		</div>";

        $data['gudang'] = $this->Frmmlaporan->get_gudang_distribusi_obat()->result();
         

        $this->load->view('logistik_farmasi/Frmvlaporandistribusiruangan',$data);
    }

    public function download_distribusi_obat($param1='', $param2='', $filter='', $nip_serah='', $nip_terima='', $nama_serah='', $nama_terima=''){
        ////EXCEL
        $this->load->library('Excel');

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $namars=$this->config->item('namars');
        $objPHPExcel->getProperties()->setCreator($namars)
            ->setLastModifiedBy($namars)
            ->setTitle("Laporan Distribusi Obat Gudang Farmasi")
            ->setSubject("Laporan Distribusi Obat Gudang Farmasi")
            ->setDescription("Laporan Distribusi Obat Gudang Farmasi, generated by MMC.")
            ->setKeywords($namars)
            ->setCategory("Laporan Distribusi Obat");

        $objReader= PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);

        $gd = $this->Frmmlaporan->get_nama_gudang($filter)->row();

        $data_keuangan=$this->Frmmlaporan->get_data_distribusi_obat($param1, $param2, $filter)->result();

        $objPHPExcel=$objReader->load(APPPATH.'third_party/lap_distribusi_obat.xlsx');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Add some data
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('E9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('F9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('G9')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setAutoFilter('A9:G9');

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', "RS. Musi Kedika Cendikia");
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->getActiveSheet()->SetCellValue('A2', "DEPARTEMEN FARMASI");
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->getActiveSheet()->SetCellValue('A4', "BUKTI PENGELUARAN");
        $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A4:G4');
        $objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('A5', "NO:");
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A5:G5');
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('A7', "Telah dikeluarkan Material Kesehatan dari ".$gd->nama_gudang);
        $objPHPExcel->getActiveSheet()->getStyle('A7')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A7')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A7:G7');
        $objPHPExcel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->getActiveSheet()->SetCellValue('A8', "Berdasarkan Permintaan masing Ruangan sbb :");
        $objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A8')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A8:G8');
        $objPHPExcel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $rowCount = 10;
        $i=1;
        $tqty = 0; $tsubtotal = 0;
        foreach($data_keuangan as $row){
         //   $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row->nama_gudang);
             $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->tgl_amprah);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->nm_obat);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->qty);
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->satuank);
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->hargabeli);
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->subtotal);
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->minggu);
            $tqty += $row->qty;
            $tsubtotal += $row->subtotal;

            $i++;
            $rowCount++;
        }
        $filename = "Laporan_Distribusi_Obat_".date('d F Y', strtotime($param1))."-".date('d F Y', strtotime($param2));
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, "Total : ");
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $tqty);
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $tsubtotal);

//        $objPHPExcel->getActiveSheet()->SetCellValue('F'.($rowCount+3), "Palembang,");
 //       $objPHPExcel->getActiveSheet()->SetCellValue('F'.($rowCount+5), "Yang Menerima");
        /*$objPHPExcel->getActiveSheet()->SetCellValue('B'.($rowCount+6), "Mengetahui");
        $objPHPExcel->getActiveSheet()->getStyle('B'.($rowCount+6))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/
 //       $objPHPExcel->getActiveSheet()->SetCellValue('F'.($rowCount+6), "Nama : ".$nama_terima);
        /*$objPHPExcel->getActiveSheet()->SetCellValue('B'.($rowCount+7), "Pjs. Kabag Far RSMC");
        $objPHPExcel->getActiveSheet()->getStyle('B'.($rowCount+7))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/
  //      $objPHPExcel->getActiveSheet()->SetCellValue('F'.($rowCount+7), "NIP : ".$nip_terima);
   //     $objPHPExcel->getActiveSheet()->SetCellValue('F'.($rowCount+8), "");
   //     $objPHPExcel->getActiveSheet()->SetCellValue('F'.($rowCount+11), "Yang Menyerahkan");
   //     $objPHPExcel->getActiveSheet()->SetCellValue('F'.($rowCount+12), "Nama : ".$nama_serah);
   //     $objPHPExcel->getActiveSheet()->SetCellValue('F'.($rowCount+13), "NIP : ".$nip_serah);
   //     $objPHPExcel->getActiveSheet()->SetCellValue('F'.($rowCount+14), "");

       

        // Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('RS Musi Medika Cendikia');

        // Redirect output to a client’s web browser (Excel2007)
        //clean the output buffer
        ob_end_clean();
        ob_start();
        //this is the header given from PHPExcel examples.
        //but the output seems somewhat corrupted in some cases.
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //so, we use this header instead.
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        //$this->SaveViaTempFile($objWriter);
    }

    public function download_penjualan_terbanyak($param1='',$param2='', $filter=''){
        ////EXCEL
        /*$data_keuangan=$this->Frmmlaporan->get_data_pembelian($param1, $param2)->result();
        echo "<pre>";
        echo print_r($data_keuangan);
        echo "</pre>";*/

        $this->load->library('Excel');

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("RS Musi Medika Cendikia")
            ->setLastModifiedBy("RS Musi Medika Cendikia")
            ->setTitle("Laporan Penjualan Obat Terbanyak Apotek YANMASUM")
            ->setSubject("Laporan Penjualan Obat Terbanyak Apotek YANMASUM")
            ->setDescription("Laporan Penjualan Obat Terbanyak Apotek YANMASUM, generated by MMC.")
            ->setKeywords("RS. MMC")
            ->setCategory("Laporan Penjualan Obat Terbanyak");

        $objReader= PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);

        $dataobat=$this->Frmmlaporan->get_data_penjualan_terbanyak($param1, $param2, $filter)->result();

        $objPHPExcel=$objReader->load(APPPATH.'third_party/lap_penjualan_terbanyak.xlsx');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Add some data
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setAutoFilter('A3:E3');

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', "Penjualan Obat Terbanyak Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('A2', "LIMIT: ".$filter." Data");
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $rowCount = 5;
        $temp = "";
        $i=1;
        $tdiskon = 0; $tppn = 0; $tmaterai = 0; $ttot = 0;
        foreach($dataobat as $row){

            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->item_obat);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->nama_obat);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->hargajual);
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->penjualan);

            $i++;
            $rowCount++;
        }
        $filename = "Laporan_Penjualan_Obat_Terbanyak_".date('d F Y', strtotime($param1))."-".date('d F Y', strtotime($param2));

        // Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('RS AL Marinir Cilandak');

        // Redirect output to a client’s web browser (Excel2007)
        //clean the output buffer
        ob_end_clean();

        //this is the header given from PHPExcel examples.
        //but the output seems somewhat corrupted in some cases.
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //so, we use this header instead.
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        //$this->SaveViaTempFile($objWriter);
    }
}
