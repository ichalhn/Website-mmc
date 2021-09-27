<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class Frmmvalidasi extends CI_Model{
    function __construct(){
    parent::__construct();
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

   function get_id_inventory($id_obat, $batch_no, $id_gudang_awal, $expire_date){
      return $this->db->query("SELECT id_inventory FROM gudang_inventory 
        WHERE id_obat='$id_obat' and batch_no='$batch_no' and id_gudang='$id_gudang_awal' and expire_date='$expire_date'");
  }

   function get_all_data_receiving(){
      return $this->db->query("SELECT a.receiving_id, a.receiving_time, b.company_name , (SELECT SUM(quantity_purchased) FROM receivings_items WHERE
        receiving_id=a.receiving_id GROUP BY receiving_id) as total FROM receivings as a, suppliers as b WHERE a.supplier_id=b.person_id
        ORDER BY a.receiving_id");
  }
       
   function get_receivings($no_faktur) {
     $query = $this->db->get_where('receivings', array('no_faktur'=>$no_faktur));
     return $query;
    }

    function getdata_gudang_inventory(){
      return $this->db->query("SELECT * , (SELECT nm_obat FROM master_obat WHERE id_obat=a.id_obat) as nm_obat , (SELECT nama_gudang FROM master_gudang WHERE id_gudang=a.id_gudang) as nama_gudang_asal, (SELECT nama_gudang FROM master_gudang WHERE id_gudang=a.id_gudang_tujuan) as nama_gudang_tujuan
        FROM validasi as a  WHERE a.valid='0' order by batch_no");
    }

    function getdata_gudang_inventory_by_role($role){
      return $this->db->query("SELECT * , (SELECT nm_obat FROM master_obat WHERE id_obat=a.id_obat) as nm_obat , (SELECT nama_gudang FROM master_gudang WHERE id_gudang=a.id_gudang) as nama_gudang_asal, (SELECT nama_gudang FROM master_gudang WHERE id_gudang=a.id_gudang_tujuan) as nama_gudang_tujuan
        FROM validasi as a  WHERE a.valid='0' AND a.id_gudang_tujuan='$role' order by batch_no");
    }

    function get_roleid($userid){
      return $this->db->query("Select roleid from dyn_role_user where userid = '".$userid."'");
    }

    function get_gudangid($userid){
      return $this->db->query("Select id_gudang from dyn_gudang_user where userid = '".$userid."'");
    }

    function getitem_obat($id_obat){
      return $this->db->query("SELECT * FROM master_obat WHERE id_obat='".$id_obat."'");
    }

    function getnama_gudang($id_gudang){
      return $this->db->query("SELECT * FROM master_gudang WHERE id_gudang='".$id_gudang."'");
    }

    function get_data_gudang(){
    return $this->db->query("SELECT * FROM master_gudang ORDER BY id_gudang");
  }

    function insert_validasi($data1){
      $this->db->insert('gudang_inventory', $data1);
      return true;
    }

     function update_selesai_distribusi($id_inventory, $qty){
      return $this->db->query("UPDATE gudang_inventory SET qty=qty+'$qty' WHERE id_inventory='$id_inventory'");
    }

     function update_gudang_awal($id_inventory, $qty){
      return $this->db->query("UPDATE gudang_inventory SET qty=qty-'$qty' WHERE id_inventory='$id_inventory'");
    }

     function selesai_validasi($id_temporary){
      return $this->db->query("UPDATE validasi SET valid='1' WHERE id_temporary='$id_temporary'");
    }
    
     function update_retur($batch_no){
      return $this->db->query("UPDATE gudang_inventory SET qty='$qty' WHERE batch_no='$batch_no'");
    }


    function hapus_data_receiving($receiving_id,$id_obat){
      return $this->db->query("DELETE FROM receiving_item WHERE receiving_id='$receiving_id' AND id_obat='$id_obat'");
    }

    function data_gudang($id_temporary){
      return $this->db->query("SELECT *, LEFT(expire_date,10) as expire_date, (SELECT nm_obat FROM master_obat WHERE id_obat=a.id_obat) as nm_obat , (SELECT nama_gudang FROM master_gudang WHERE id_gudang=a.id_gudang) as nama_gudang_asal, (SELECT nama_gudang FROM master_gudang WHERE id_gudang=a.id_gudang_tujuan) as nama_gudang_tujuan  
from validasi as a where id_temporary ='$id_temporary'");
    }

    function cek_obat_gudang($id_obat, $expire_date, $id_gudang){
      return $this->db->query("SELECT id_inventory FROM gudang_inventory WHERE id_obat='$id_obat' and LEFT(expire_date,10)='$expire_date' and id_gudang='$id_gudang'");
    }

}

?>
