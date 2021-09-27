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
}
?>
