<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class Frmmtransaksi extends CI_Model{
    function __construct(){
    parent::__construct();
  }

  function cari_obat(){
    return $this->db->query("SELECT id_obat, nm_obat FROM master_obat ORDER BY id_obat");
  }

  function get_obat(){
    return $this->db->query("SELECT id_obat, nm_obat, hargabeli, hargajual FROM master_obat ORDER BY id_obat");
  }

  function get_satuan(){
    return $this->db->query("SELECT * FROM obat_satuan");
  }

  function get_data_obat($id_obat){
    return $this->db->query("SELECT * FROM master_obat WHERE id_obat='$id_obat'");
  }

  function insert_supplier($data){
    $this->db->insert('master_obat', $data);
    return true;
  }

  function get_all($id_obat) {
    $query = $this->db->query("SELECT id_obat, nm_obat, hargajual, faktorsatuan FROM master_obat ORDER BY id_obat");
    return $query->result();
  }

  function get($id_obat) {
    $query = $this->db->get_where('master_obat', array('id_obat'=>$id_obat));
    return $query->row();
  }
  function insert_detail($data){
    $this->db->insert('receivings',$data);
     return  true;
  }

  function get_all_data_receiving(){
     return $this->db->query("SELECT a.receiving_id, a.no_faktur, a.receiving_time, b.company_name , (SELECT SUM(quantity_purchased) FROM receivings_items WHERE
        receiving_id=a.receiving_id GROUP BY receiving_id) as total FROM receivings as a, suppliers as b WHERE a.supplier_id=b.person_id
        ORDER BY a.receiving_id");
  }

  function get_all_data_receiving_bhp(){
     return $this->db->query("SELECT a.receiving_id, a.receiving_time, b.company_name , (SELECT SUM(quantity_purchased) FROM receivings_items WHERE
        receiving_id=a.receiving_id GROUP BY receiving_id) as total FROM receivings as a, suppliers as b WHERE a.supplier_id=b.person_id
        and b.type='BHP'
        ORDER BY a.receiving_id");
  }

  function get_data_receiving($receiving_id){
     return $this->db->query("SELECT * FROM receivings WHERE receiving_id='$receiving_id'");
  }

  function get_receivings($no_faktur) {
     $query = $this->db->get_where('receivings', array('no_faktur'=>$no_faktur));
     return $query;
  }
       
  function update_total_price($receiving_id) {
     return $this->db->query("UPDATE receivings as a SET total_price=(select sum(item_cost_price) as total_price from receivings_items where receiving_id=a.receiving_id) WHERE receiving_id='$receiving_id'");
  }

  function get_receiving_id($person_id,$no_faktur,$comment,$payment_type){
     return $this->db->query("SELECT receiving_id FROM receivings WHERE person_id='$person_id' AND no_faktur='$no_faktur' AND comment='$comment' AND payment_type='$payment_type'  ORDER BY receiving_id DESC LIMIT 1");
  }

  function get_biaya($id_obat){
	   return $this->db->query("SELECT harga_po, hargabeli FROM master_obat WHERE id_obat='".$id_obat."'");
	}

  function getdata_receiving_item($id_receiving){
     return $this->db->query("SELECT * FROM receivings_items WHERE receiving_id='$id_receiving'");
  }

  function getdata_gudang_inventory($id_receiving){
     return $this->db->query("SELECT * FROM gudang_inventory WHERE receiving_id='$id_receiving'");
  }

  function getitem_obat($id_obat){
		 return $this->db->query("SELECT * FROM master_obat WHERE id_obat='".$id_obat."'");
	}

  function getnama_gudang($id_gudang){
     return $this->db->query("SELECT * FROM master_gudang WHERE id_gudang='".$id_gudang."'");
  }

  function cari_gudang(){
     return $this->db->query("SELECT * FROM master_gudang ORDER BY id_gudang");
  }

  function insert_receiving_item($data){
		 $this->db->insert('receivings_items', $data);
		 return true;
	}

  function insert_selesai_transaksi($data1){
     $this->db->insert('gudang_inventory', $data1);
     return true;
  }

  function get_total_harga($receiving_id){
     return $this->db->query("SELECT SUM(total_harga_obat) as total FROM `receivings_items` WHERE receiving_id='$receiving_id' ");
  }

  function update_retur($batch_no){
     return $this->db->query("UPDATE gudang_inventory SET qty='$qty' WHERE batch_no='$batch_no'");
  }

  function hapus_data_receiving($receiving_id, $id_obat, $id_gudang, $batch_no){
      $this->db->query("DELETE FROM gudang_inventory WHERE id_obat = '$id_obat' AND batch_no = '$batch_no' AND id_gudang =".$id_gudang);

     return $this->db->query("DELETE FROM receivings_items WHERE receiving_id='$receiving_id' AND item_id='$id_obat'");
  }
}
?>
