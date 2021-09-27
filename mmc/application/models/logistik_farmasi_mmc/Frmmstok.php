<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class Frmmstok extends CI_Model{
    function __construct(){
    parent::__construct();
  }



   function get_all($id_obat) {
    $query = $this->db->query("SELECT id_obat, nm_obat, hargajual, faktorsatuan FROM master_obat ORDER BY nm_obat");
    return $query->result();
    }

   function get($id_obat) {
    $query = $this->db->get_where('master_obat', array('id_obat'=>$id_obat));
    return $query->row();
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
      return $this->db->query("SELECT * , (SELECT nm_obat FROM master_obat WHERE id_obat=a.id_obat) as nm_obat , (SELECT nama_gudang FROM master_gudang WHERE id_gudang=a.id_gudang) as nama_gudang
        FROM gudang_inventory as a order by nm_obat");
    }

    function getdata_gudang_inventory_by_role($role){
      return $this->db->query("SELECT g.id_obat,g.id_gudang,sum(g.qty) as qty, max(expire_date) as expire_date, max(batch_no) as batch_no, sum(quantity_retur) as quantity_retur, o.`nm_obat`, o.`hargabeli`, o.`jenis_obat` AS jenis_barang, gd.`nama_gudang`, o.`min_stock`
                          FROM gudang_inventory g
                          INNER JOIN master_obat o ON o.`id_obat` = g.`id_obat`
                          INNER JOIN master_gudang gd ON gd.`id_gudang` = g.`id_gudang`
                          WHERE g.id_gudang = '$role'
                          group by g.id_obat,g.id_gudang 
                          ORDER BY o.`nm_obat`");
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

    function get_data_gudang_detail($nm_gudang){
      return $this->db->query("SELECT g.*, o.nm_obat, o.`hargabeli`, o.`hargajual`, o.`jenis_obat`, gd.`nama_gudang`
                        FROM gudang_inventory g
                        INNER JOIN master_obat o ON o.`id_obat` = g.`id_obat`
                        INNER JOIN master_gudang gd ON gd.`id_gudang` =g.`id_gudang`
                        WHERE g.id_gudang=(SELECT id_gudang FROM master_gudang WHERE nama_gudang='$nm_gudang')
                        ORDER BY g.`batch_no`");
    }

    function data_gudang($batch_no){
      return $this->db->query("SELECT a.nm_obat, b.batch_no , b.qty from master_obat as a, gudang_inventory as b where a.id_obat = b.id_obat and b.batch_no ='$batch_no'");
    }

    function get_last_so_by_gudang_name($id_gudang){
        return $this->db->query("SELECT so.*, o.`nm_obat`
                          FROM stock_opname_new so
                          INNER JOIN master_obat o ON o.`id_obat` = so.`id_obat` 
                          INNER JOIN master_gudang mg ON mg.`id_gudang` = so.`id_gudang`
                          WHERE so.`id_gudang` = $id_gudang
                          ORDER BY so.`created_date`");
    }

    function get_last_so($id_gudang){
        return $this->db->query("SELECT so.*, o.`nm_obat`
                          FROM stock_opname_new so
                          INNER JOIN master_obat o ON o.`id_obat` = so.`id_obat` 
                          WHERE so.`id_gudang` = $id_gudang 
                          ORDER BY so.`created_date`");
    }

    function get_item_so($id_obat, $id_gudang){
        return $this->db->query("SELECT so.*, o.`nm_obat`
                          FROM stock_opname_new so
                          INNER JOIN master_obat o ON o.`id_obat` = so.`id_obat` 
                          inner join gudang_inventory_so g on g.`id_obat` = so.`id_obat`
                          where g.`id_gudang` = $id_gudang AND o.`id_obat` = $id_obat
                          ORDER BY so.`created_date`");
    }

    function get_new_jenisobat(){
        return $this->db->query('SELECT*FROM obat_jenis_new ORDER BY nm_jenis ASC');
    }

    function insert_stokopname($data){
        $this->db->select('*')
                  ->where('id_obat', $data['id_obat'])
                  ->where('id_gudang', $data['id_gudang'])
                  ->where('batch_no', $data['batch_no']);
        $cek = $this->db->get('gudang_inventory_so')->num_rows();

        if($cek > 0){
            $this->db->query("UPDATE gudang_inventory_so SET qty = qty + $data[qty] 
              WHERE id_obat = '$data[id_obat]' AND id_gudang = '$data[id_gudang]' AND batch_no = '$data[batch_no]'");
        }else{
            $this->db->query("INSERT INTO gudang_inventory_so (id_inventory, id_obat, id_gudang, qty, expire_date, batch_no, quantity_retur) 
          VALUES ('', '$data[id_obat]', '$data[id_gudang]', '$data[qty]', '$data[expire_date]', '$data[batch_no]', 0)");
        }

        $this->db->query("UPDATE master_obat SET jenis_obat = '$data[jenis_obat]', hargabeli = '$data[hargabeli]', 
          hargajual = '$data[hargajual]' WHERE id_obat = '$data[id_obat]'");

        return $this->db->query("INSERT INTO stock_opname_new (id_obat, id_gudang, hargabeli, hargajual, batch_no, expire_date, qty, jenis_obat, created_date) 
          VALUES ('$data[id_obat]', '$data[id_gudang]', '$data[hargabeli]', '$data[hargajual]', '$data[batch_no]', '$data[expire_date]', '$data[qty]', '$data[jenis_obat]', '$data[created_date]') 
          ON DUPLICATE KEY UPDATE qty = qty + $data[qty], created_date = '$data[created_date]', hargabeli = '$data[hargabeli]', 
          hargajual = '$data[hargajual]', jenis_obat = '$data[jenis_obat]'");
          /*$this->db->insert('stock_opname_new', $data);
      return true;*/
    }

    function edit_stokopname($data){
        $this->db->query("UPDATE gudang_inventory_so 
          SET qty = '$data[qty]',
          expire_date = '$data[expire_date]' 
          WHERE id_obat = '$data[id_obat]' AND id_gudang = '$data[id_gudang]' AND batch_no = '$data[batch_no]'");

        $this->db->query("UPDATE master_obat 
          SET jenis_obat = '$data[jenis_obat]', 
          hargabeli = '$data[hargabeli]', 
          hargajual = '$data[hargajual]' 
          WHERE id_obat = '$data[id_obat]'");

        return $this->db->query("UPDATE stock_opname_new
          SET qty = '$data[qty]', 
          created_date = '$data[created_date]', 
          hargabeli = '$data[hargabeli]', 
          hargajual = '$data[hargajual]', 
          expire_date = '$data[expire_date]',
          jenis_obat = '$data[jenis_obat]'  

          WHERE id_obat = '$data[id_obat]' AND batch_no = '$data[batch_no]'");
    }

    function delete_stokopname($data){
        $this->db->delete('gudang_inventory_so', $data); 
        return $this->db->delete('stock_opname_new', $data); 
    }
}

?>
