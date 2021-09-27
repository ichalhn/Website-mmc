<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
include('Frmcterbilang.php');
class Frmcpembelian extends Secure_area
{
  public function __construct(){
	parent::__construct();
	$this->load->model('logistik_farmasi/Frmmtransaksi','',TRUE);
  $this->load->model('logistik_farmasi/Frmmpemasok','',TRUE);
  $this->load->model('logistik_farmasi/Frmmkwitansi','',TRUE);
      $this->load->model('logistik_farmasi/Frmmpo','',TRUE);
	$this->load->model('master/Mmobat','',TRUE);
  $this->load->model('master/Mmsupplier','',TRUE);
      $this->load->library('session');
  $this->load->helper('pdf_helper');
	}

  function index($param='')
	{
    
    $data['obat']=$this->Frmmtransaksi->get_obat()->result();
	  $data['satuan']=$this->Frmmtransaksi->get_satuan()->result();
    $data['select_obat']=$this->Frmmtransaksi->cari_obat()->result();
    $data['Pemasok']=$this->Frmmpemasok->get_pemasok()->result();

    if($param=='1'){
      $data['title'] = 'Pembelian Barang Habis Pakai (BHP)';
      //$data['jenis_barang']='BHP';
      $data['data_receiving'] = $this->Frmmtransaksi->get_all_data_receiving_bhp()->result();       
      $data['select_pemasok']=$this->Frmmpemasok->cari_pemasok_bhp()->result();
      $this->load->view('logistik_farmasi/Frmvpembelian_bhp',$data);
    }else{
      $data['title'] = 'Pembelian Farmasi';
      //$data['jenis_barang']='OBAT';
      $data['data_receiving'] = $this->Frmmtransaksi->get_all_data_receiving()->result();      
      
    $data['select_pemasok']=$this->Frmmpemasok->cari_pemasok()->result();
      $this->load->view('logistik_farmasi/Frmvpembelian',$data);
    }
    
    
	  
	}

  function form_supplier(){
    $data['title'] = 'Tambah Pemasok';
    $data['Pemasok']=$this->Frmmpemasok->get_pemasok()->result();
	  $data['company_name']=$this->Frmmpemasok->get_company()->result();
	  $data['account_number']=$this->Frmmpemasok->get_account_numb()->result();
    $this->load->view('logistik_farmasi/Frmvtambahpemasok',$data);
  }

  public function insert_supplier(){
    $data['company_name']=$this->input->post('nmsupplier');
    $data['account_number']=$this->input->post('accountnumber');
    $data['adress']=$this->input->post('adress');
    $data['zip_code']=$this->input->post('zip_code');
    $data['phone']=$this->input->post('phone');
    $this->Mmsupplier->insert_supplier($data);
    
    // $this->Frmmpemasok->insert_supplier($data);
    redirect('logistik_farmasi/Frmcpembelian');
  }

  function insert_detail_pembelian(){
      $data['payment_type']=$this->input->post('payment_type');
      $data['receiving_id']=$this->input->post('receiving_id');
      $data['supplier_id']=$this->input->post('id_supplier');
      $no_faktur = str_replace("/", "-", $this->input->post('no_faktur'));
      $data['no_faktur']=$this->input->post('no_faktur');
      $data['tgl_faktur']=$this->input->post('tgl_faktur');
      $data['tgl_kontra_bon']=$this->input->post('tgl_kontra_bon');
      $data['jatuh_tempo']=$this->input->post('jatuh_tempo');
      $data['comment']=$this->input->post('comment');
      $data['ppn']=$this->input->post('ppn');
      $data['sumber_dana'] = $this->input->post('sumber_dana');
      $data['total_price'] = '0';

    $this->Frmmtransaksi->insert_detail($data);
    if($this->input->post('jenis_barang')!=''){
      redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi_bhp/'.$data['no_faktur']);
    }else
      redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi/'.$no_faktur);
    //$data['receiving_id']=$this->Frmmtransaksi->get_receiving_id($data['person_id'],$data['no_faktur'],$data['comment'],$data['payment_type'])->row()->receiving_id;
    
  }

    function form_detail_transaksi($no_faktur=''){
        $no_faktur = str_replace("-", "/", $no_faktur);
        $data['title'] = 'Detail Transaksi';
        //$data['data_obat']=$this->Mmobat->get_all_obat()->result();
        $data['obat_satuan'] = $this->Frmmpo->getSatuanObat()->result();
        $row = $this->Frmmtransaksi->get_receivings($no_faktur)->row();
        $data['receiving_time'] = $row->receiving_time;
        $data['payment_type'] = $row->payment_type;
        $data['id_receiving'] = $row->receiving_id;
        $data['total_price'] = $row->total_price;
        $data['supplier_id'] = $row->supplier_id;
        $data['no_faktur'] = $row->no_faktur;
        $data['jatuh_tempo'] = $row->jatuh_tempo;
        $data['tgl_kontra_bon'] = $row->tgl_kontra_bon;
        $data['select_gudang']=$this->Frmmtransaksi->cari_gudang()->result();
        $data['company_name']=$this->Frmmpemasok->get_company_name($no_faktur)->row();
            $data['data_receiving_item']=$this->Frmmtransaksi->getdata_receiving_item($data['id_receiving'])->result();
        $this->load->view('logistik_farmasi/Frmvdetailtransaksi',$data);
        /*echo "<pre>";
        echo print_r($row);
        echo "</pre>";*/
    }

    function form_detail_transaksi_bhp($no_faktur=''){
      $data['satuan']=$this->Frmmtransaksi->get_satuan()->result();
        $data['title'] = 'Detail Transaksi';
        $data['data_obat']=$this->Mmobat->get_all_bhp()->result();
        $data_detail_pembelian=$this->Frmmtransaksi->get_receivings($no_faktur)->result();
            foreach($data_detail_pembelian as $row){
                $data['receiving_time'] = $row->receiving_time;
                $data['payment_type'] = $row->payment_type;
                $data['id_receiving'] = $row->receiving_id;
                $data['total_price'] = $row->total_price;
                $data['supplier_id'] = $row->supplier_id;
                $data['no_faktur'] = $row->no_faktur;
                $data['jatuh_tempo'] = $row->jatuh_tempo;
                $data['tgl_kontra_bon'] = $row->tgl_kontra_bon;
            }
        $data['select_gudang']=$this->Frmmtransaksi->cari_gudang()->result();
        $data['company_name']=$this->Frmmpemasok->get_company_name($no_faktur)->row();
        $data['data_receiving_item']=$this->Frmmtransaksi->getdata_receiving_item($data['id_receiving'])->result();
        $this->load->view('logistik_farmasi/Frmvdetailtransaksi_bhp',$data);
    }

    public function insert_pembelian(){
      $data['receiving_id']=$this->input->post('receiving_id');
      $no_faktur=$this->input->post('no_faktur');
      $no_faktur2= str_replace("/", "-", $no_faktur);
      $data['item_id']=$this->input->post('id_obat');
      $data['description']=$this->input->post('cari_obat');
      $data['item_unit_price']=$this->input->post('hargak');
      $data['harga_po'] = $this->input->post('biaya_obat');
      $data['item_cost_price']=$this->input->post('vtot_x');
      $data['quantity_purchased']=$this->input->post('qty');
      $data['ppn_percent']=10;
      $data['batch_no']=$this->input->post('batch_no');

      $this->Frmmtransaksi->insert_receiving_item($data);

      $data1['id_obat']=$this->input->post('id_obat');
      $qty_po = $this->input->post('qty');
      $jml_kemasan = $this->input->post('jml_kemasan');
      $tqty = $qty_po * $jml_kemasan;

      $data1['qty'] = $tqty;
      if($this->input->post('expire_date')!=''){
          $originalDate = $this->input->post('expire_date');
          $newDate = date("Y-m-d", strtotime($originalDate));

        $data1['expire_date']= $newDate;
      }
      $data1['batch_no']=$this->input->post('batch_no');
      $userid = $this->session->userid;
      $group = $this->Frmmpo->getIdGudang($userid);
      $data1['id_gudang']= $group->id_gudang;

      $this->Frmmtransaksi->insert_selesai_transaksi($data1);

      $this->Frmmtransaksi->update_total_price($this->input->post('receiving_id'));

      if($this->input->post('jenis')!=''){
        redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi_bhp/'.$no_faktur);
      }else
        redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi/'.$no_faktur2);
      //echo print_r($data);
    }


    public function selesai_transaksi(){
      $data['item_id']=$this->input->post('idobat');
      $data_obat=$this->Frmmtransaksi->getitem_obat($data['item_id'])->result();
      foreach($data_obat as $row){
        $data['description']=$row->nm_obat;
      }
      $data['quantity_purchased']=$this->input->post('qty');

      $this->Frmmtransaksi->insert_receiving_item($data);
      //$this->Frmmtransaksi->update_total_price($receiving_id);
      /*$data['receiving_time']=$this->input->post('receiving_time');
      $data['person_id']=$this->input->post('person_id');
      $data['no_faktur']=$this->input->post('no_faktur');
      $data['total']=$this->input->post('total');
      $data['payment_type']=$this->input->post('payment_type');*/
      redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi/'.$no_faktur);
      //print_r($data);
    }


    public function get_data_detail_pembelian(){
    $receiving_id=$this->input->post('receiving_id');
    $datajson=$this->Frmmtransaksi->get_data_receiving($receiving_id)->result();
      echo json_encode($datajson);
    }


    public function get_biaya_obat()
	  {
		 $id_obat=$this->input->post('idobat');
		 $biaya=$this->Frmmtransaksi->get_biaya($id_obat)->row()->harga_po;
		 echo json_encode($biaya);
	  }

  public function hapus_data_receiving($receiving_id='', $id_obat='', $no_faktur='',$batch_no=''){
      $userid = $this->session->userid;
      $group = $this->Frmmpo->getIdGudang($userid);
      $id_gudang = $group->id_gudang;

    $id=$this->Frmmtransaksi->hapus_data_receiving($receiving_id, $id_obat, $id_gudang, $batch_no);
      redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi/'.$no_faktur);
    /*if($tipe==''){
      //$id=$this->Frmmtransaksi->hapus_data_receiving($receiving_id, $id_obat);

       redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi/'.  $no_faktur);
    }else
        redirect('logistik_farmasi/Frmcpembelian/form_detail_transaksi_bhp/'.  $no_faktur);*/

		//print_r($id);
	}

  public function faktur_pembelian()
  {
    $data['title'] = 'Cetak Faktur Farmasi';
    $no_faktur= $this->input->post('faktur_hidden');
    if($no_faktur!=''){
      $data['no_faktur']=$no_faktur;
      $data_detail_pembelian=$this->Frmmtransaksi->get_receivings($no_faktur)->result();
            foreach($data_detail_pembelian as $row){
                $data['receiving_time'] = $row->receiving_time;
                $data['payment_type'] = $row->payment_type;
                $data['id_receiving'] = $row->receiving_id;
                $data['total_price'] = $row->total_price;
                $data['supplier_id'] = $row->supplier_id;
                $data['no_faktur'] = $row->no_faktur;
                $data['jatuh_tempo'] = $row->jatuh_tempo;
                $data['tgl_kontra_bon'] = $row->tgl_kontra_bon;
            }
      $data['select_gudang']=$this->Frmmtransaksi->cari_gudang()->result();
      $data['company_name']=$this->Frmmpemasok->get_company_name($no_faktur)->row();
      $data['data_receiving_item']=$this->Frmmtransaksi->getdata_receiving_item($data['id_receiving'])->result();
      $data['data_permintaan']=$this->Frmmtransaksi->get_all_data_receiving()->result();
      $data['receiving_item']=$this->Frmmtransaksi->getdata_receiving_item($data['id_receiving'])->result();
          
      if(sizeof($data['data_permintaan'])==0){
        $this->session->set_flashdata('message_no_tindakan','<div class="row">
              <div class="col-md-12">
                <div class="box box-default box-solid">
                <div class="box-header with-border">
                  <center>Tidak Ada Tindakan</center>
                </div>
                </div>
              </div>
            </div>');
      }else{
        $this->session->set_flashdata('message_no_tindakan','');
      }
      
      $this->load->view('logistik_farmasi/Frmvfakturpembelian',$data);
    }else{
      //printf("redirect");
      redirect('logistik_farmasi/Frmcpembelian/faktur_pembelian');
    }
  }

  public function cetak_faktur(){
    $nomor = $this->input->post('faktur_hidden');
    $no_faktur = str_replace('/', '-', $nomor);
    $cookiediskon = $this->input->post('diskon_hide');
    //echo '<script type="text/javascript">window.open("'.site_url("logistik_farmasi/Frmcpembelian/cetak_faktur_kt/$no_faktur").'", "_blank");window.focus()</script>';

    echo '<script type="text/javascript">document.cookie = "diskon='.$cookiediskon.'";window.open("'.site_url("logistik_farmasi/Frmcpembelian/cetak_faktur_kt/$no_faktur").'", "_blank");window.focus()</script>';

    redirect('logistik_farmasi/Frmcpembelian/','refresh');
  }

  public function cetak_faktur_kt($nomor=''){
    $diskon = $_COOKIE['diskon'];

    $no_faktur = str_replace('-', '/', $nomor);

    date_default_timezone_set("Asia/Bangkok");
    $tgl_jam = date("d-m-Y H:i:s");
    $tgl = date("d-m-Y");

    $namars=$this->config->item('namars');
    $kota_kab=$this->config->item('kota');
    $telp=$this->config->item('telp');
    $alamatrs=$this->config->item('alamat');
    $nmsingkat=$this->config->item('namasingkat');
   
    $data_detail_pembelian=$this->Frmmtransaksi->get_receivings($no_faktur)->result();
    foreach($data_detail_pembelian as $row){
        $data['receiving_time'] = $row->receiving_time;
        $data['payment_type'] = $row->payment_type;
        $payment_type=$data['payment_type'] ;
        $data['id_receiving'] = $row->receiving_id;
        $id_receiving=$data['id_receiving'] ;
        $data['total_price'] = $row->total_price;
        $data['supplier_id'] = $row->supplier_id;
        $supplier_id=$data['supplier_id'];
        $data['no_faktur'] = $row->no_faktur;
        $data['tgl_kontra_bon']=$row->tgl_kontra_bon;
        $data['jatuh_tempo'] = $row->jatuh_tempo;
        $data['tgl_kontra_bon'] = $row->tgl_kontra_bon;
    }
     $data['company_name']=$this->Frmmpemasok->get_company_name($no_faktur)->row();
     $company_name=$this->Frmmpemasok->get_company_name_byidsupplier($data['supplier_id'])->row()->company_name;

    print_r($data_detail_pembelian);
    $data['data_receiving_item']=$this->Frmmtransaksi->getdata_receiving_item($data['id_receiving'])->result();
    $cterbilang=new rjcterbilang();
    $konten=
    					"<style type=\"text/css\">
              .table-font-size{
                font-size:7px;
                  }
              .table-font-size1{
                font-size:8.5px;
                  }
              </style>
              
              <table  border=\"0\">
                <tr>
                  <td width=\"16%\" align=\"center\">
                      <img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"40\" style=\"padding-right:5px;\">
                  </td>
                  <td  width=\"70%\" style=\" font-size:7px;\">
                  <b><font style=\"font-size:12px\">$namars</font></b><br><br>$alamatrs $kota_kab $telp
                  </td>
                  <td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam</font></td>           
                </tr>
              </table>
              <hr/>
    					<p align=\"center\"><b>
    					FAKTUR PEMBELIAN OBAT<br/>
    					No. FRM. RCV_".$id_receiving."
    					</b></p><br/>
    					
    					<table class=\"table-font-size1\">
    						<tr>
    							<td width=\"20%\"><b>No. Faktur</b></td>
    							<td width=\"3%\"> : </td>
    							<td>$no_faktur</td>
    							<td width=\"15%\"> </td>
    							<td width=\"15%\"><b>Jenis Transaksi</b></td>
    							<td width=\"3%\"> : </td>
    							<td>$payment_type</td>
    						</tr>
    						<tr><td width=\"20%\"><b>Supplier</b></td>
                  <td width=\"3%\"> :  </td>
                  <td>".$company_name."</td> 
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

		$i=1;
		$jumlah_vtot=0;
		foreach($data['data_receiving_item'] as $row){
			$jumlah_vtot=$jumlah_vtot+$row->item_cost_price;
			$vtot = number_format( $row->item_cost_price, 2 , ',' , '.' );
      $vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);
			$konten=$konten."<tr>
							  <td><p align=\"center\">$i</p></td>
							  <td>$row->description</td>
							  <td><p align=\"center\">".number_format( $row->item_unit_price, 2 , ',' , '.' )."</p></td>
							  <td><p align=\"center\">$row->quantity_purchased</p></td>
							  <td><p align=\"right\">$vtot</P></td>
							  <br>
							</tr>";
			$i++;
		}	
    $konten=$konten."
        <tr><hr><br>
          <th colspan=\"4\"><p align=\"right\"><font size=\"12\"><b>Jumlah   </b></font></p></th>
          <th><p align=\"right\"><font size=\"12\"><b>".number_format( $jumlah_vtot, 2 , ',' , '.' )."</b></font></p></th>
        </tr>      
      ";

    $totakhir=$jumlah_vtot-$diskon;
    if($diskon!=0){
      $vtot_terbilang=$cterbilang->terbilang($totakhir);
      $konten=$konten."
            <tr>
              <th colspan=\"4\"><p align=\"right\"><font size=\"12\"><b>Diskon   </b></font></p></th>
              <th ><p align=\"right\"><font size=\"12\"><b>".number_format( $diskon, 2 , ',' , '.' )."</b></font></p></th>
            </tr>

            <tr><hr><br>
              <th colspan=\"4\"><p align=\"right\"><font size=\"12\"><b>Total Bayar   </b></font></p></th>
              <th bgcolor=\"yellow\"><p align=\"right\"><font size=\"12\"><b>".number_format( $totakhir, 2 , ',' , '.' )."</b></font></p></th>
            </tr>";
      $jumlah_vtot=$jumlah_vtot-$diskon;    
    }
    $konten=$konten."
            <b><font size=\"10\"><p align=\"right\">Terbilang : " .$vtot_terbilang."</p></font></b>
                    <br><br>
                    <p align=\"right\">$kota_kab, $tgl</p>
      </table>
      ";

                  
    $file_name="FT_$id_receiving.pdf";
    //echo '<script type="text/javascript">window.open("'.site_url("logistik_farmasi/Frmcpembelian/cetak_faktur_kt/").'", "_blank");window.focus()</script>';
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
		$obj_pdf->Output(FCPATH.'download/logistik_farmasi/'.$file_name, 'FI');
    redirect('logistik_farmasi/Frmcpembelian/index', 'refresh');
  } 
}
?>