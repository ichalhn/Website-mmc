<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
include('Frmcterbilang.php');
class Frmcdistribusi extends Secure_area
{
	public function __construct(){
		parent::__construct();
		$this->load->model('logistik_farmasi/Frmmamprah','',TRUE);
		$this->load->model('logistik_farmasi/Frmmdistribusi','',TRUE);
        $this->load->helper('pdf_helper');
	}

	function index($param='')
	{
		if($param==''){
			$data['title'] = 'Distribusi Logistik Farmasi';
			$data['jenis_barang']='OBAT';
		}else{
			$data['title'] = 'Distribusi Logistik Barang Habis Pakai';	
			$data['jenis_barang']='BHP';		
		}
			$data['select_gudang0'] = $this->Frmmamprah->get_gudang_asal()->result();
			$data['select_gudang1'] = $this->Frmmamprah->get_gudang_tujuan()->result();	
			$this->load->view('logistik_farmasi/Frmvdaftardistribusi',$data);
		
	}
	
    function get_detail_list(){		
		$line  = array();
		$line2 = array();
		$row2  = array();
		$hasil = $this->Frmmdistribusi->get_amprah_detail_list($this->input->post('id'));
		
		foreach ($hasil as $key =>$value) {
			$row2['id_obat'] = $value->id_obat;
			$row2['nm_obat'] = $value->nm_obat;
			$row2['satuank'] = $value->satuank;
			$row2['qty_req'] = $value->qty_req;
			$row2['id_amprah'] = $value->id_amprah;
			/*
			if ($value->qty_acc == null)
				$row2['qty_acc'] = '<input type="hidden" value="'.$value->id.'" name="id">
				<input type="hidden" value="'.$value->id_gudang.'" name="id_gdmnt">
				<input type="hidden" value="'.$value->id_gudang_tujuan.'" name="id_gdtj">
				<input type="hidden" value="'.$value->id_obat.'" name="id_obat">
				<input type="number" id="qty_acc'.($key+1).'" name="qty_acc" min=0 >';
			else
				$row2['qty_acc'] = $value->qty_acc;
			if (($value->batch_no == null)&&($value->qty_acc == null)){
				$stock = $this->Frmmamprah->get_amprah_detail_stock($value->id_obat, $value->id_gudang_tujuan);
				$select = '<select size="1" class="batch_no" name="batch_no">';
				foreach ($stock as $value2) {
					$select = $select . '<option value="'.$value2->batch_no.'">'.$value2->batch_no.' (Expire: '.$value2->expire_date.'||Stock:'.$value2->qty.')</option>';
				}
				$select = $select . "</select>";
				$row2['batch_no'] = $select;		
			}else
				$row2['batch_no'] = $value->batch_no;
			if (($value->keterangan == null)&&($value->qty_acc == null))
				$row2['keterangan'] = '<input type="text" id="keterangan" name="keterangan">';
			else
				$row2['keterangan'] = $value->keterangan;	
			$row2['expire_date'] = $value->expire_date;
			*/
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
    }


	function get_detail_acc(){		
		$line  = array();
		$line2 = array();
		$row2  = array();
		$value2 = $this->Frmmdistribusi->get_total_acc($this->input->post());
		$total_qty_acc = $value2->total_qty_acc;
		$kuota = $value2->kuota;
		$id_obat = $value2->id_obat;
		$id_gudang = $value2->id_gudang;
		$id_gudang_tujuan = $value2->id_gudang_tujuan;
		$qty_req = $value2->qty_req;
		$satuank = $value2->satuank;
		$hasil = $this->Frmmdistribusi->get_amprah_detail_acc($this->input->post());
		
		foreach ($hasil as $value) {
			$row2['qty_acc'] = $value->qty_acc;
			$row2['batch_no'] = $value->batch_no;
			$row2['expire_date'] = $value->expire_date;
			$row2['aksi'] = '';
			//$row2['aksi'] = '<button class="btn btn-xs btn-warning" id="btnHapus" onClick="hapusBeli('.$value->id.')">Hapus</button>';
			/*
			if ($value->qty_acc == null)
				$row2['qty_acc'] = '<input type="hidden" value="'.$value->id.'" id="id" name="id"><input type="number" id="qty_acc'.($key+1).'" name="qty_acc" min=0 >';
			else
				$row2['qty_acc'] = $value->qty_acc;
			if ($value->batch_no == null){
				$row2['batch_no'] = '<input type="text" id="batch_no'.($key+1).'" name="batch_no">';	
			}else
				$row2['batch_no'] = $value->batch_no;
			if ($value->keterangan == null)
				$row2['keterangan'] = '<input type="text" id="keterangan" name="keterangan"><input type="hidden" value="'.$value->item_id.'" name="id_obat">';
			else
				$row2['keterangan'] = $value->keterangan;	
			if ($value->expire_date == null)
				$row2['expire_date'] = '<input type="text" id="expire_date'.($key+1).'" name="expire_date" class="datepicker" placeholder="yyyy-mm-dd">';
			else
				$row2['expire_date'] = $value->expire_date;	
			*/
			$line2[] = $row2;
		}
		$exp = "";
		if ($kuota>0){
			$stock = $this->Frmmdistribusi->get_amprah_detail_stock($id_obat, $id_gudang_tujuan);
			$select = '<select size="1" class="batch_no" id="batch_no">';
			foreach ($stock as $value2) {
				$select = $select . '<option value="'.$value2->batch_no.'">'.$value2->batch_no.' (Stock:'.$value2->qty.')</option>';
				$exp = $value2->expire_date;
			}
			$select = $select . "</select>";
			$row2['batch_no'] = $select;	
			$row2['qty_acc'] = '<input type="number" id="qty_acc" name="qty_acc" min=0 max='.$kuota.' >';
            $row2['aksi'] = '<button class="btn btn-xs btn-primary" id="btnSimpan">Simpan</button>';
            $row2['expire_date'] ='<input type="text" id="expire_date" name="expire_date" placeholder="yyyy-mm-dd" value="'.$exp.'">
			<input type="hidden" value="'.$id_gudang.'" id="id_gudang"><input type="hidden" value="'.$id_gudang_tujuan.'" id="id_gudang_tujuan"><input type="hidden" value="'.$satuank.'" id="satuank"><input type="hidden" value="'.$qty_req.'" id="qty_req">';
			$line2[] = $row2;
		}
		$line['data'] = $line2;
			
		echo json_encode($line);
    }
	
	function save_detail_acc(){
		$this->Frmmdistribusi->insert_detail_acc($this->input->post()) ;
		echo true;
		/*echo "<pre>";
		echo print_r($this->input->post());
		echo "</pre>";*/
	}
	function delete_detail_acc(){
		$this->Frmmdistribusi->delete_detail_acc($this->input->post('id')) ;
		echo true;
	}
/*
	function alokasi(){
		$this->Frmmamprah->update($this->input->post('json'));
		echo true;
	}
*/
    public function cetak_sbbk($idamprah=''){
        if($idamprah!=''){

            //set timezone
            date_default_timezone_set("Asia/Jakarta");
            $tgl_jam = date("d-m-Y H:i:s");
            $tgl = date("d-m-Y");

            $namars=$this->config->item('namars');
            $kota_kab=$this->config->item('kota');
            $telp=$this->config->item('telp');
            $alamatrs=$this->config->item('alamat');
            $nmsingkat=$this->config->item('namasingkat');

            $gd = $this->Frmmdistribusi->get_nama_gudang($idamprah)->row();
            $data_keuangan=$this->Frmmdistribusi->get_data_distribusi_obat($idamprah)->result();

            $konten="<style type=\"text/css\">
                    .table-font-size{
                        font-size:9px;
                        }
                    .table-font-size1{
                        font-size:12px;
                        }
                    .table-font-size2{
                        font-size:9px;
                        margin : 5px 1px 1px 1px;
                        padding : 5px 1px 1px 1px;
                        }
                    </style>
                    
                    <table class=\"table-font-size2\" border=\"0\">
                        <tr>
                            <td width=\"16%\" align=\"center\">
                                    <img src=\"asset/images/logos/".$this->config->item('logo_url')."\" alt=\"img\" height=\"40\" style=\"padding-right:5px;\">
                            </td>
                                <td  width=\"70%\" style=\" font-size:9px;\"><b><font style=\"font-size:12px\">$namars</font></b><br><br>$alamatrs $kota_kab $telp
                            </td>
                            <td width=\"14%\"><font size=\"6\" align=\"right\">$tgl_jam</font></td>                     
                        </tr>
                    </table>
                    <hr/>
                    <p align=\"center\">
                    <b>
                        INSTALASI FARMASI<br>
                        SURAT BUKTI BARANG KELUAR (SBBK)<br/>
                        NO. SBBK: ".$idamprah."/ ".$gd->tujuan."/ RSMC/ ".date('Y')."
                    </b>
                    </p>
                    <table>
                        <tr>
                            <td width=\"20%\">Diberikan kepada</td>
                            <td width=\"3%\"> : </td>
                            <td width=\"77%\">$gd->asal</td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td> : </td>
                            <td>$gd->tgl_amprah</td>
                        </tr>
                    </table>
                    <br/><br/>

                    <table border=\"1\" style=\"padding:2px\">
                        <tr>
                            <th width=\"5%\"><p align=\"center\"><b>No</b></p></th>
                            <th width=\"55%\"><p align=\"center\"><b>Nama Obat/Alat</b></p></th>
                            <th width=\"15%\"><p align=\"center\"><b>Satuan</b></p></th>
                            <th width=\"10%\"><p align=\"center\"><b>Jumlah</b></p></th>
                            <th width=\"15%\"><p align=\"center\"><b>Keterangan</b></p></th>
                        </tr>";

            $i=1;
            $tqty = 0; $tsubtotal = 0;
            foreach($data_keuangan as $row){
                $konten=$konten."
                            <tr>
                                <td><p align=\"center\">$i</p></td>
                                <td>$row->nm_obat</td>
                                <td><p align=\"right\">$row->satuank</p></td>
                                <td><p align=\"center\">$row->qty_acc</p></td>
                                <td></td>
                            </tr>";

                $tqty += $row->qty_acc;

                $i++;
            }


            $konten.="
                        <tr>
                            <td colspan=\"3\"><p align=\"right\">Jumlah</p></td>
                            <td><p align=\"center\">$tqty</p></td>
                            <td></td>
                        </tr>
                    </table>
                    <br>
                    <br>
                    <table style=\"width:100%;\" border=\"0\">
                        <tr>
                            <td width=\"30%\" align=\"center\">
                                <b>Yang Menerima</b>
                            </td>
                            <td width=\"40%\" align=\"center\">
                                <b>Apoteker Gudang</b>
                            </td>
                            <td width=\"30%\" align=\"center\">
                                <b>Yang Menyerahkan</b>
                            </td>
                        </tr>   
                        <tr>
                            <td width=\"30%\" align=\"center\" ><br><br><br><br><br><br>(________________________)</td>
                            <td width=\"40%\" align=\"center\" ><br><br><br>
                                <p align=\"center\">
                                    <br>
                                    
                                </p>
                            </td>
                            <td width=\"30%\" align=\"center\"><br><br><br><br><br><br>(________________________)</td>
                        </tr>   
                    </table>
                    ";

            // $file_name="FKTR_$no_lab.pdf";
            // "SBBK_Nomor_".$idamprah;
            $file_name="SBBK_Nomor_".$idamprah.".pdf";
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            tcpdf();
            $obj_pdf = new TCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
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
            $obj_pdf->SetMargins('10', '5', '10');
            $obj_pdf->SetAutoPageBreak(TRUE, '5');
            $obj_pdf->SetFont('helvetica', '', 9);
            $obj_pdf->setFontSubsetting(false);
            $obj_pdf->AddPage();
            ob_start();
            $content = $konten;
            ob_end_clean();
            $obj_pdf->writeHTML($content, true, false, true, false, '');
            $obj_pdf->Output(FCPATH.'download/lab/labfaktur/'.$file_name, 'FI');
        }else{
            redirect('lab/labcdaftar/','refresh');
        }
    }
}
?>
