<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FrmmreturGudang extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    function get_amprah($id_gudang){
        $userid = $this->session->userdata('userid');
        return $this->db->select('a.id_amprah, a.tgl_amprah, a.gd_asal, a.gd_dituju, a.user, a.no_faktur, d.nama_gudang, m.nama_gudang AS nama_gudang_dituju')
            ->from('amprah a')
            ->join('dyn_gudang_user d', 'a.gd_asal = d.id_gudang', 'LEFT')
            ->join('master_gudang m', 'a.gd_dituju = m.id_gudang', 'LEFT')
            ->where('a.gd_asal', $id_gudang)
            ->where('a.jenis_amprah !=', 'BHP')
            ->group_by('a.id_amprah')
            ->order_by('id_amprah', 'ASC')->get();
    }

    function get_amprah_detail_list($id, $idgudang){
        return $this->db->query("SELECT a.id, a.id_amprah, a.id_obat, b.nm_obat, a.satuank, a.qty_req, a.qty_acc, a.expire_date, a.batch_no, a.keterangan, a.id_gudang_tujuan, a.id_gudang, b.hargabeli, g.`qty` as stok
			FROM distribusi a
			LEFT JOIN master_obat b on a.id_obat = b.id_obat
			LEFT JOIN gudang_inventory g ON g.`id_obat` = a.`id_obat`
			WHERE a.id_amprah = $id AND qty_acc != '' AND g.`id_gudang` = ".$idgudang)->result();
    }

    function get_data_retur_by_batch($id_obat, $id_gudang){
        return $this->db->query("SELECT
                              d.id_obat,
                              m.`nm_obat` AS description,
                              d.`batch_no`,
                              g.qty AS quantity_purchased 
                            FROM
                              distribusi d
                              INNER JOIN gudang_inventory g 
                                ON d.id_obat = g.id_obat
                                INNER JOIN master_obat m ON m.`id_obat` = d.`id_obat`
                            WHERE g.id_obat = $id_obat
                              AND g.id_gudang = $id_gudang AND d.batch_no != ''");
    }

    function get_report_retur($param1, $param2){
        return $this->db->query("SELECT a.id, a.id_amprah, am.`tgl_amprah`, m.`nama_gudang` AS gudang_pengirim, 
              mg.`nama_gudang` AS gudang_penerima, a.id_obat, b.nm_obat, a.satuank, a.qty_req, a.qty_acc, a.expire_date, 
              a.batch_no, a.keterangan, a.id_gudang_tujuan, a.id_gudang, b.hargabeli, g.`qty` AS stok, a.`qty_retur`
			FROM distribusi a
			LEFT JOIN master_obat b ON a.id_obat = b.id_obat
			LEFT JOIN gudang_inventory g ON g.`id_obat` = a.`id_obat`
			INNER JOIN amprah am ON am.`id_amprah` = a.`id_amprah`
			LEFT JOIN `master_gudang` `m` ON `am`.`gd_dituju` = `m`.`id_gudang`
			LEFT JOIN `master_gudang` `mg` ON `mg`.`id_gudang` = am.`gd_asal`
			WHERE am.`tgl_amprah` BETWEEN '$param1' AND '$param2'
			AND qty_acc != '' AND qty_retur != 0 GROUP BY a.`id`");
    }

    function insert_quantity($data){
        return $this->db->query("UPDATE distribusi SET qty_retur = qty_retur + ".$data['edit_quantity']." 
                                    WHERE id_amprah = ".$data['id_amprah']." AND 
                                    id_obat = ".$data['edit_item_id']." AND 
                                    batch_no = '".$data['edit_batch_no']."' ");
    }

    function edit_stok($data, $id_gudang){
        return $this->db->query("UPDATE gudang_inventory set qty = ".$data['edit_stok_hide']." where id_obat = ".$data['edit_item_id']." and id_gudang = $id_gudang");
    }
}
?>
