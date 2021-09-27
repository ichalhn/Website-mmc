<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class Frmmadjustment extends CI_Model{
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

   function get_all_data_receiving(){
      return $this->db->query("SELECT a.receiving_id, a.receiving_time, b.company_name , (SELECT SUM(quantity_purchased) FROM receivings_items WHERE
        receiving_id=a.receiving_id GROUP BY receiving_id) as total FROM receivings as a, suppliers as b WHERE a.supplier_id=b.person_id
        ORDER BY a.receiving_id");
  }
       
   function get_receivings($no_faktur) {
     $query = $this->db->get_where('receivings', array('no_faktur'=>$no_faktur));
     return $query;
    }

    function getdata_gudang_inventory($data){
	  $userid = $this->session->userdata('userid');
	  $where = "";
		if ($data["select_gudang"] != ""){
			$where .= " AND i.id_gudang = ".$data["select_gudang"];
		}
		if ($data["id_obat"] != ""){
			$where .= " AND i.id_obat = ".$data["id_obat"];
		}
	  return $this->db->query("SELECT i.batch_no, i.expire_date, i.id_gudang, i.id_inventory, i.id_obat, i.qty, m.nm_obat, g.nama_gudang, IF(i.expire_date < NOW(), 1, 0) as expired
		FROM gudang_inventory i, master_obat m, master_gudang g, dyn_gudang_user d
		WHERE i.id_obat = m.id_obat 
			and i.id_gudang = d.id_gudang 
			and g.id_gudang = d.id_gudang
			and d.userid = $userid
			$where
		order by i.id_inventory ASC")->result();
    }

    function getitem_obat($id_obat){
			return $this->db->query("SELECT * FROM master_obat WHERE id_obat='".$id_obat."'");
		}

    function getnama_gudang($id_gudang){
      return $this->db->query("SELECT * FROM master_gudang WHERE id_gudang='".$id_gudang."'");
    }

    function get_data_gudang(){
	  $userid = $this->session->userdata('userid');
      return $this->db->query("SELECT * FROM dyn_gudang_user WHERE userid = $userid ORDER BY id_gudang");
	}

    function insert_selesai_adjustment($data1){
	
	  $this->db->set('tanggal', 'NOW()', FALSE);
      $this->db->insert('adjustment', $data1);
      return true;
    }

    function update_selesai_adjustment($qty_hasil, $id_inventory, $expire_date){
      return $this->db->query("UPDATE gudang_inventory SET qty=$qty_hasil,expire_date='$expire_date' WHERE id_inventory=$id_inventory");
    }
     
    
     function update_retur($batch_no){
      return $this->db->query("UPDATE gudang_inventory SET qty='$qty' WHERE batch_no='$batch_no'");
    }


    function hapus_data_receiving($receiving_id,$id_obat){
      return $this->db->query("DELETE FROM receiving_item WHERE receiving_id='$receiving_id' AND id_obat='$id_obat'");
    }

    function data_gudang($id_inventory){
      return $this->db->query("SELECT b.id_inventory, b.id_gudang, a.nm_obat, a.id_obat, b.batch_no , b.qty, LEFT(b.expire_date,10) as expire_date from master_obat as a, gudang_inventory as b where a.id_obat = b.id_obat and b.id_inventory ='$id_inventory'");
    }

    function cek_obat_gudang($id_obat, $expire_date, $id_gudang){
      return $this->db->query("SELECT id_inventory FROM gudang_inventory WHERE id_obat='$id_obat' and LEFT(expire_date,10)='$expire_date' and id_gudang='$id_gudang'");
    }

	function delete($id)
	{
		$this->db->where('id_inventory',$id);	
		if ($this->db->delete('gudang_inventory')){
			return true;
		}else{			
			return false;
		}
	}
}

?>
