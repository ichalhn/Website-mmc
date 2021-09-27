<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'controllers/Secure_area.php');

class Frmcretur extends Secure_area
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('logistik_farmasi/Frmmretur', '', TRUE);
        $this->load->model('logistik_farmasi/Frmmtransaksi', '', TRUE);
        $this->load->model('logistik_farmasi/Frmmpemasok', '', TRUE);
        $this->load->model('user/Muser', '', TRUE);
        $this->load->library('session');
    }

    public function index()
    {
        $data['title'] = 'Daftar Retur Farmasi';
        $data['logistik_farmasi'] = $this->Frmmretur->get_daftar_retur()->result();
        $this->load->view('logistik_farmasi/Frmvdaftarretur', $data);
    }


    public function by_date()
    {
        $date = $this->input->post('date');
        $data['title'] = 'Tanggal ' . $date;
        $data['logistik_farmasi'] = $this->Frmmretur->get_daftar_retur_by_date($date)->result();
        $this->load->view('logistik_farmasi/frmvdaftarretur', $data);
    }

    public function by_no()
    {

        $key = $this->input->post('key');
        $data['title'] = 'No Faktur ' . $date;
        $data['logistik_farmasi'] = $this->Frmmdaftar->get_daftar_retur_by_no($key)->result();
        $this->load->view('logistik_farmasi/frmvdaftarretur', $data);
    }

    public function get_data_detail_retur()
    {
        $receiving_id = $this->input->post('receiving_id');
        $datajson = $this->Frmmtransaksi->getdata_receiving_item($receiving_id)->result();
        echo json_encode($datajson);
    }

    public function data_receiving_item($receiving_id)
    {
        $datajson['title'] = 'Detail Retur Farmasi';
        $datajson['receiving'] = $this->Frmmtransaksi->getdata_receiving_item($receiving_id)->result();
        $datajson['select_gudang'] = $this->Frmmtransaksi->cari_gudang()->result();
        $this->load->view('logistik_farmasi/frmvdetailretur', $datajson);
    }

    public function retur($nofaktur)
    {
        $newNo = str_replace("-", "/", $nofaktur);
        $data['title'] = 'Daftar Retur Farmasi';
        $data['retur_barang'] = $this->Frmmretur->get_data_retur_by_id($newNo)->result();
        $data['no_faktur'] = $newNo;
        $this->load->view('logistik_farmasi/Frmvdaftardetailretur', $data);
    }

    public function edit_data_retur()
    {
        $batch_no = $this->input->post('batch_no');
        $item_id = $this->input->post('item_id');

        $userid = $this->session->userid;
        $group = $this->Muser->getIdGudang($userid);
        $id_gudang = $group->id_gudang;
        $datajson = $this->Frmmretur->get_data_retur_by_batch($batch_no, $item_id, 1)->result();
        echo json_encode($datajson);
    }

    public function edit_data_stok()
    {
        /*
      $batch_no=$this->input->post('edit_batch_no');
      $item_id=$this->input->post('edit_item_id');
      $data['qty']=$this->input->post('edit_stok_hide');
      $data_retur=$this->input->post('edit_quantity');
      */
        $r_id = $this->input->post('receiving_id');
        $newNo = str_ireplace("/", "-", $r_id);
        if ($this->input->post('edit_quantity_purchased') != 0) {
            $userid = $this->session->userid;
            $group = $this->Muser->getIdGudang($userid);
            $id_gudang = $group->id_gudang;

            // $this->Frmmretur->insert_quantity($this->input->post());
            $this->Frmmretur->edit_stok($this->input->post(), 1);
            redirect('logistik_farmasi/Frmcretur/retur/' . $newNo);
        } else {
            $this->session->set_flashdata('success_msg', '<h3><span style="color: red; ">Stok Tidak Memenuhi!!!</span></h3>');
            redirect('logistik_farmasi/Frmcretur/retur/' . $newNo);
        }

        /*echo "<pre>";
        echo print_r($_POST);
        echo "</pre>";*/
    }

    public function selesai_retur()
    {
        $data['item_id'] = $this->input->post('idobat');
        $data_obat = $this->Frmmtransaksi->getitem_obat($data['item_id'])->result();
        foreach ($data_obat as $row) {
            $data['description'] = $row->nm_obat;
        }
        $data['quantity_purchased'] = $this->input->post('qty');

        $this->Frmmtransaksi->update_receiving_item($data);

        /*$data['receiving_time']=$this->input->post('receiving_time');
        $data['person_id']=$this->input->post('person_id');
        $data['no_faktur']=$this->input->post('no_faktur');
        $data['total']=$this->input->post('total');
        $data['payment_type']=$this->input->post('payment_type');*/
        redirect('logistik_farmasi/Frmcretur/data_receiving_item/' . $receiving_id);
        //print_r($data);
    }

    public function selesai_transaksi()
    {
        $data['item_id'] = $this->input->post('idobat');
        $data_obat = $this->Frmmtransaksi->getitem_obat($data['item_id'])->result();
        foreach ($data_obat as $row) {
            $data['description'] = $row->nm_obat;
        }
        $data['quantity_purchased'] = $this->input->post('qty');

        $this->Frmmtransaksi->insert_receiving_item($data);

        /*$data['receiving_time']=$this->input->post('receiving_time');
        $data['person_id']=$this->input->post('person_id');
        $data['no_faktur']=$this->input->post('no_faktur');
        $data['total']=$this->input->post('total');
        $data['payment_type']=$this->input->post('payment_type');*/
        redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi/' . $no_faktur);
        //print_r($data);
    }

    function form_detail_transaksi($no_faktur = '')
    {
        $data['title'] = 'Detail Transaksi';
        $data['data_obat'] = $this->Mmobat->get_all_obat()->result();
        $data_detail_pembelian = $this->Frmmtransaksi->get_receivings($no_faktur)->result();
        foreach ($data_detail_pembelian as $row) {
            $data['receiving_time'] = $row->receiving_time;
            $data['payment_type'] = $row->payment_type;
            $data['id_receiving'] = $row->receiving_id;
            $data['total_price'] = $row->total_price;
            $data['supplier_id'] = $row->supplier_id;
            $data['no_faktur'] = $row->no_faktur;
            $data['jatuh_tempo'] = $row->jatuh_tempo;

        }
        $data['select_gudang'] = $this->Frmmtransaksi->cari_gudang()->result();
        $data['company_name'] = $this->Frmmpemasok->get_company_name($no_faktur)->row();
        $data['data_receiving_item'] = $this->Frmmtransaksi->getdata_receiving_item($data['id_receiving'])->result();
        $this->load->view('logistik_farmasi/frmvdetailretur', $data);
    }

    public function cetak_faktur()
    {
        $no_faktur = $this->input->post('faktur_hidden');
        echo '<script type="text/javascript">window.open("' . site_url("logistik_farmasi/Frmcretur/cetak_faktur_retur/$no_faktur") . '", "_blank");window.focus()</script>';
        redirect('logistik_farmasi/Frmcpembelian/index/' . 'refresh');
    }


    public function cetak_faktur_retur($no_faktur = '')
    {
        date_default_timezone_set("Asia/Bangkok");
        $tgl_jam = date("d-m-Y H:i:s");
        $tgl = date("d-m-Y");

        $data_rs = $this->Frmmkwitansi->get_data_rs('10000')->result();
        foreach ($data_rs as $row) {
            $namars = $row->namars;
            $kota_kab = $row->kota;
            $alamat = $row->alamat;
        }

        $data_detail_pembelian = $this->Frmmtransaksi->get_receivings($no_faktur)->result();
        foreach ($data_detail_pembelian as $row) {
            $data['receiving_time'] = $row->receiving_time;
            $data['payment_type'] = $row->payment_type;
            $payment_type = $data['payment_type'];
            $data['id_receiving'] = $row->receiving_id;
            $id_receiving = $data['id_receiving'];
            $data['total_price'] = $row->total_price;
            $data['supplier_id'] = $row->supplier_id;
            $data['no_faktur'] = $row->no_faktur;
            $data['jatuh_tempo'] = $row->jatuh_tempo;
        }

        $data['data_receiving_item'] = $this->Frmmtransaksi->getdata_receiving_item($data['id_receiving'])->result();
        $cterbilang = new rjcterbilang();

        $konten =
            "<table>
    						<tr>
    							<td><p align=\"right\"><b>Tanggal-Jam: $tgl_jam</b></p></td>
    						</tr>
    						<tr>
    							<td colspan=\"3\"><img src=\"asset/images/logo-muaraenim.png\" alt=\"img\" height=\"40\"></td>
    						</tr>

    						<tr>
    							<td><b>$alamat</b></td>
    						</tr>
    					</table>
    					<br/><hr/><br/>
    					<p align=\"center\"><b>
    					FAKTUR RETUR OBAT<br/>
    					No. FRM. RT_$id_receiving
    					</b></p><br/>
    					<br><br>
    					<table>
    						<tr>
    							<td width=\"20%\"><b>No. Faktur</b></td>
    							<td width=\"3%\"> : </td>
    							<td>$no_faktur</td>
    							<td width=\"15%\"> </td>
    							<td width=\"15%\"><b>Jenis Transaksi</b></td>
    							<td width=\"3%\"> : </td>
    							<td>RETUR </td>
    						</tr>
    						<tr><td width=\"20%\"><b>Supplier</b></td>
                  <td width=\"3%\"> :  </td>
                  <td>$supplier_id</td>
                  <td width=\"15%\"> </td>
    						</tr>
                <tr>
                  <td><b>Untuk Pembelian Obat</b></td>
                  <td> : </td>
                  <td></td>
                </tr>
    					</table>
    					<br/><br/>
    					<table>
    						<tr><hr>
    							<th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
    							<th width=\"45%\"><p align=\"center\"><b>Nama Item</b></p></th>
    							<th width=\"20%\"><p align=\"center\"><b>Harga</b></p></th>
    							<th width=\"10%\"><p align=\"center\"><b>Banyak</b></p></th>
    							<th width=\"20%\"><p align=\"center\"><b>Total</b></p></th>
    						</tr>
    						<hr>
    					";


        $i = 1;
        $jumlah_vtot = 0;
        foreach ($data['data_receiving_item'] as $row) {
            $jumlah_vtot = $jumlah_vtot + $row->item_cost_price;
            $vtot = number_format($row->item_cost_price, 2, ',', '.');
            $vtot_terbilang = $cterbilang->terbilang($jumlah_vtot);
            $konten = $konten . "<tr>
    										  <td><p align=\"center\">$i</p></td>
    										  <td>$row->description</td>
    										  <td><p align=\"center\">" . number_format($row->item_unit_price, 2, ',', '.') . "</p></td>
    										  <td><p align=\"center\">$row->quantity_purchased</p></td>
    										  <td><p align=\"right\">$vtot</P></td>
    										  <br>
    										</tr>";
            $i++;

        }
        $konten = $konten . "
                      <tr><hr><br>
                        <th colspan=\"4\"><p align=\"right\"><font size=\"12\"><b>Jumlah   </b></font></p></th>
                        <th bgcolor=\"yellow\"><p align=\"right\"><font size=\"12\"><b>" . number_format($jumlah_vtot, 2, ',', '.') . "</b></font></p></th>
                      </tr>

                    </table>
                    <b><font size=\"10\"><p align=\"right\">Terbilang : " . $vtot_terbilang . "</p></font></b>
                    <br><br>
                    <p align=\"right\">$kota_kab, $tgl</p>
                    ";


        $file_name = "SKR_$id_receiving.pdf";
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
        $obj_pdf->Output(FCPATH . 'download/logistik_farmasi/frmkwitansi/' . $file_name, 'FI');
        redirect('logistik_farmasi/Frmcretur/index', 'refresh');

    }

    function laporan_retur(){
        $data['title'] = 'Laporan Retur Berdasarkan Nomor Faktur';

        $data['date_title']='<b>'.date("d F Y").'</b>';
        $data['tgl']=date("Y-m-d");

        $data['message_nodata']="<div class=\"content-header\">
			<div class=\"alert alert-danger alert-dismissable\">
				<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
			<h4><i class=\"icon fa fa-close\"></i>
				Silahkan Pilih Tanggal dan Download untuk Melihat Laporan Retur.
			</h4>							
			</div>
		</div>";

        $this->load->view('logistik_farmasi/Frmvlaporanretur',$data);
    }

    function download_laporan_retur($param1='', $param2=''){
        ////EXCEL
        $this->load->library('Excel');

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("RS AL Marinir Cilandak")
            ->setLastModifiedBy("RS AL Marinir Cilandak")
            ->setTitle("Laporan Keuangan RS AL Marinir Cilandak")
            ->setSubject("Laporan Keuangan RS AL Marinir Cilandak Document")
            ->setDescription("Laporan Keuangan RS AL Marinir Cilandak, generated by HMIS.")
            ->setKeywords("RS AL Marinir Cilandak")
            ->setCategory("Laporan Keuangan");

        //$objReader = PHPExcel_IOFactory::createReader('Excel2007');
        //$objPHPExcel = $objReader->load("project.xlsx");

        $objReader= PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);

        $data_keuangan=$this->Frmmretur->get_laporan_retur($param1, $param2)->result();

        $objPHPExcel=$objReader->load(APPPATH.'third_party/lap_retur_pembelian.xlsx');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Add some data
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', "Laporan Retur Pembelian");
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->SetCellValue('A2', "Periode ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2)));
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(16);
        $objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('E4')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
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
        $objPHPExcel->getActiveSheet()->setAutoFilter('A4:I4');

        $rowCount = 5;
        $i=1;
        $tqty = 0;
        foreach($data_keuangan as $row){

            $tqty += $row->qty_retur;
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->no_faktur);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->tgl_retur);
            $objPHPExcel->getActiveSheet()->getStyle('C'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row->company_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row->nm_obat);
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->batch_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->expire_date);
            $objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->satuank);
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->qty_retur);

            $i++;
            $rowCount++;
        }

        $filename = "Laporan Retur Pembelian ".date('d F Y', strtotime($param1))." - ".date('d F Y', strtotime($param2));
        $objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G'.$rowCount)->getFont()->setSize(16);
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, "Total : ");

        $objPHPExcel->getActiveSheet()->getStyle('I'.$rowCount)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('I'.$rowCount)->getFont()->setSize(16);
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $tqty);
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');

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
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        // $objWriter->save('php://output');
        $this->SaveViaTempFile($objWriter);
    }

    static function SaveViaTempFile($objWriter){
        $filePath = sys_get_temp_dir() . "/" . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
        $objWriter->save($filePath);
        readfile($filePath);
        unlink($filePath);
    }
}
