<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Frmmretur extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		
		//daftar resep pasien

		function get_daftar_retur(){
			return $this->db->query("SELECT 
                              h.`supplier_id`,
                              s.`company_name`,
                              d.`tgl_faktur`,
                              d.`no_faktur`,
                              d.`cara_bayar`,
                              d.`keterangan_faktur` 
                            FROM
                              po p 
                              INNER JOIN header_po h 
                                ON p.`id_po` = h.`id_po` 
                              INNER JOIN suppliers s 
                                ON h.`supplier_id` = s.`person_id` 
                              INNER JOIN `do` d ON d.`id_po` = p.`id_po`
                            WHERE d.`no_faktur` IS NOT NULL 
                            GROUP BY d.`no_faktur` 
                            ORDER BY d.tgl_faktur DESC");
		}

		function get_daftar_retur_by_date($date){
			return $this->db->query("SELECT receiving_time, receiving_id, suppliers.company_name as supplier_id, payment_type from receivings, suppliers WHERE receivings.supplier_id=suppliers.person_id
										AND left(receivings.receiving_time,10)  = '$date'
										ORDER BY receiving_time DESC");
		}

		function get_daftar_retur_by_no($key){
			return $this->db->query("SELECT receiving_id, no_faktur, receiving_time,  suppliers.company_name as suppplier_id, payment_type from receivings , suppliers WHERE receivings.supplier_id=suppliers.person_id  AND (no_faktur='$key') GROUP BY receiving_id
			ORDER BY receiving_time ASC");
		}

		
		function get_data_transaksi(){
			return $this->db->query("SELECT * FROM receivings");
		}

		function get_data_retur_by_id($nofaktur){
			//return $this->db->query("SELECT receivings_items.item_id, receivings_items.description, receivings_items.batch_no, gudang_inventory.qty as quantity_purchased from receivings_items, gudang_inventory where gudang_inventory.id_obat = receivings_items.item_id and receivings_items.receiving_id = '$receiving_id' and gudang_inventory.id_gudang = 1");
			return $this->db->query("SELECT
    p.`id_po`,
    p.`item_id`,
    a.`no_faktur`,
    p.`batch_no`,
    o.`nm_obat`,
    o.`hargabeli`,
    o.`hargajual`,
    p.`qty_beli`,
    g.`qty` AS stok,
    p.`jml_kemasan`,
    r.`qty` AS quantity_retur
FROM
    po p
INNER JOIN master_obat o ON o.`id_obat` = p.`item_id`
INNER JOIN gudang_inventory g ON (g.`id_obat` = p.`item_id` and p.batch_no = g.batch_no)
INNER JOIN do a ON (a.id_po = p.id_po)
LEFT JOIN retur r ON r.`no_faktur` = a.`no_faktur`
WHERE
    a.`no_faktur` = '".$nofaktur."'
AND g.`id_gudang` = 1");
		}

		// function get_data_retur_by_id($nofaktur){
		// 	//return $this->db->query("SELECT receivings_items.item_id, receivings_items.description, receivings_items.batch_no, gudang_inventory.qty as quantity_purchased from receivings_items, gudang_inventory where gudang_inventory.id_obat = receivings_items.item_id and receivings_items.receiving_id = '$receiving_id' and gudang_inventory.id_gudang = 1");
		// 	return $this->db->query("SELECT p.`id_po`, p.`item_id`, p.`no_faktur`, p.`batch_no`, o.`nm_obat`, o.`hargabeli`, o.`hargajual`, p.`qty_beli`, g.`qty` AS stok, p.`jml_kemasan`, r.`qty` AS quantity_retur
		// 		FROM po p
		// 		INNER JOIN master_obat o ON o.`id_obat` = p.`item_id`
		// 		INNER JOIN gudang_inventory g ON g.`id_obat` = p.`item_id`
		// 		LEFT JOIN retur r ON r.`no_faktur` = p.`no_faktur`
		// 		WHERE p.`no_faktur` = '".$nofaktur."' AND g.`id_gudang` = 1");
		// }
		
		function get_data_retur_by_batch($batch_no, $id_obat, $id_gudang){
			//return $this->db->query("SELECT receivings_items.item_id, receivings_items.description, receivings_items.batch_no, gudang_inventory.qty as quantity_purchased from receivings_items, gudang_inventory where gudang_inventory.id_obat = receivings_items.item_id and gudang_inventory.id_obat = '$id_obat'");
            return $this->db->query("SELECT g.`id_obat` AS item_id, o.`nm_obat` AS description, g.`batch_no`, g.`qty` AS quantity_purchased
                            FROM gudang_inventory g
                            INNER JOIN master_obat o ON o.`id_obat` = g.`id_obat`
                            WHERE g.id_obat = '$id_obat' AND g.`id_gudang` = $id_gudang AND g.`batch_no` = '$batch_no'");
		}

		function edit_stok($data, $id_gudang){
			//return $this->db->query("UPDATE gudang_inventory set qty = ".$data['edit_stok_hide']." where id_obat = ".$data['edit_item_id']." and id_gudang = $id_gudang");

            $this->db->query("INSERT INTO retur (no_faktur, tgl_retur, id_obat, qty) VALUES ('".$data['edit_faktur']."', '".date('Y-m-d')."', ".$data['edit_item_id'].", ".$data['edit_quantity'].")");

            return $this->db->query("UPDATE gudang_inventory 
            SET qty = ".$data['edit_stok_hide'].", quantity_retur = (quantity_retur + ".$data['edit_quantity'].") 
            WHERE id_obat = '".$data['edit_item_id']."' AND batch_no = '".$data['edit_batch_no']."' AND id_gudang = $id_gudang");
		}

		function insert_quantity($data){
			return $this->db->query("UPDATE header_po SET quantity_retur = quantity_retur + ".$data['edit_quantity']." WHERE id_obat = '".$data['edit_item_id']."' AND batch_no = '".$data['edit_batch_no']."' AND id_gudang = 1");
		}

		function get_laporan_retur($param1, $param2){
            return $this->db->query("SELECT r.`no_faktur`, r.`tgl_retur`, SUM(r.`qty`) AS qty_retur, o.`nm_obat`, o.`satuank`, g.`batch_no`, g.`expire_date`, s.`company_name`, o.`satuank`
                FROM retur r
                INNER JOIN master_obat o ON o.`id_obat` = r.`id_obat`
                INNER JOIN gudang_inventory g ON g.`id_obat` = r.`id_obat`
                INNER JOIN po p ON p.`no_faktur` = r.`no_faktur`
                INNER JOIN header_po h ON h.`id_po` = p.`id_po`
                INNER JOIN suppliers s ON s.`person_id` = h.`supplier_id`
                WHERE r.`tgl_retur` BETWEEN '".$param1."' AND '".$param2."' AND g.`id_gudang` = 1
                GROUP BY r.`no_faktur`, r.`id_obat`
                ORDER BY r.`no_faktur` ASC");
        }

	}
?>
