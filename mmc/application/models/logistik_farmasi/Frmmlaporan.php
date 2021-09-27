<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Frmmlaporan extends CI_Model{
		function __construct(){
			parent::__construct();
		}



		function get_data_keuangan_tgl($tgl){
			return $this->db->query("SELECT no_register, item_obat, nama_obat, qty, vtot
				FROM resep_pasien
				WHERE left(tgl_kunjungan,10) = '$tgl'
				AND cetak_kwitansi='1'
				ORDER BY item_obat");
		}

		// function get_data_periode_bln($bln){
		// 	return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, count(1) as jum_pem
		// 		FROM resep_pasien
		// 		WHERE left(tgl_kunjungan,7)  = '$bln'
		// 		GROUP BY tgl");
		// }

		// function get_data_keuangan_bln($bln){
		// 	return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, item_obat, nama_obat, biaya_obat, count(item_obat) as jumlah, sum(vtot) as total
		// 		FROM resep_pasien
		// 		WHERE left(tgl_kunjungan,7) = '$bln'
		// 		GROUP BY tgl, item_obat
		// 		ORDER BY item_obat");
		// }

		function get_data_periode_bln_bycarabayar($bln, $cara_bayar){
			return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, count(1) as jum_pem
				FROM resep_pasien
				WHERE left(tgl_kunjungan,7)  = '$bln' and cara_bayar='$cara_bayar'
				GROUP BY tgl");
		}

		function get_data_keuangan_bln_bycarabayar($bln, $cara_bayar){
			return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, item_obat, nama_obat, biaya_obat, cara_bayar, count(*) as jumlah, sum(vtot) as total
				FROM resep_pasien
				WHERE left(tgl_kunjungan,7) = '$bln' and cara_bayar='$cara_bayar'
				GROUP BY item_obat, tgl
				ORDER BY tgl, item_obat");
		}

		function get_data_periode_thn($thn){
			return $this->db->query("SELECT left(receivings.receiving_time,7) as bln, count(1) as jum_pem
				FROM receivings
				WHERE left(receivings.receiving_time,4) ='$thn'
				GROUP BY bln");
		}

		function get_data_keuangan_thn($thn){
			return $this->db->query("SELECT left(receivings.receiving_time,7) as bln, suppliers.company_name, 
receivings_items.description, count(receivings_items.quantity_purchased) as jumlah, 
sum(receivings_items.item_cost_price) as total
FROM receivings, receivings_items, suppliers
WHERE receivings.receiving_id = receivings_items.receiving_id 
and suppliers.person_id = receivings.supplier_id and left(receivings.receiving_time,4) = '$thn'
GROUP BY bln, suppliers.company_name");
		}

		function get_data_periode_thn_bycarabayar($thn, $cara_bayar){
			return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, count(1) as jum_pem
				FROM resep_pasien
				WHERE left(tgl_kunjungan,4)  = '$thn' and cara_bayar='$cara_bayar'
				GROUP BY bln");
		}

		function get_data_keuangan_thn_bycarabayar($thn, $cara_bayar){
			return $this->db->query("SELECT left(tgl_kunjungan,7) as bln, item_obat, nama_obat, biaya_obat, cara_bayar, count(*) as jumlah, sum(vtot) as total
				FROM resep_pasien
				WHERE left(tgl_kunjungan,4) = '$thn' and cara_bayar='$cara_bayar'
				GROUP BY item_obat, bln
				ORDER BY bln, item_obat");
		}
///////////////////////////////////////////////////////////////////////////////////////////////////////////// edited ibnu

		function get_data_keuangan_bln($bln){
			return $this->db->query("SELECT left(receivings.receiving_time,10) as tgl, suppliers.company_name, receivings_items.description, count(receivings_items.quantity_purchased) as jumlah, sum(receivings_items.item_cost_price) as total
				FROM receivings, receivings_items, suppliers
				WHERE receivings.receiving_id = receivings_items.receiving_id and suppliers.person_id = receivings.supplier_id and left(receivings.receiving_time,7) = '$bln'
				GROUP BY tgl, suppliers.company_name");
		}

		function row_table_perbln($bln){
			return $this->db->query("SELECT Count(*)
				FROM receivings_items, receivings, suppliers
				WHERE receivings.receiving_id = receivings_items.receiving_id AND left(receivings.tgl_kunjungan,7)  = '$bln'
				GROUP BY suppliers.company_name");
		}

		function get_data_periode_bln($bln){
			return $this->db->query("SELECT left(receivings.receiving_time,10) as tgl, count(1) as jum_pem
				FROM receivings
				WHERE left(receivings.receiving_time,7) ='$bln'
				GROUP BY tgl");
		}
		function get_data_keu_tindakan_today(){
			return $this->db->query("SELECT receivings.supplier_id, a.company_name, b.description, b.quantity_purchased, b.item_cost_price 
				FROM suppliers as a, receivings_items as b, receivings 
				WHERE a.person_id=receivings.supplier_id AND b.receiving_id=receivings.receiving_id and left(receivings.receiving_time,10)=left(now(),10) group by receivings.supplier_id");
		}

		function get_data_keu_tind_tgl($tgl){
			return $this->db->query("SELECT receivings.supplier_id, a.company_name, b.description, b.quantity_purchased, b.item_cost_price 
				FROM suppliers as a, receivings_items as b, receivings 
				WHERE a.person_id=receivings.supplier_id AND b.receiving_id=receivings.receiving_id and left(receivings.receiving_time,10)='$tgl' group by receivings.supplier_id");
		}

		function get_data_keu_detail_tgl($tgl){
			return $this->db->query("SELECT receivings.supplier_id, a.company_name, b.description, b.quantity_purchased, b.item_cost_price, m.hargabeli 
				FROM suppliers as a, master_obat AS m, receivings_items as b, receivings 
				WHERE a.person_id=receivings.supplier_id
				AND m.id_obat = b.item_id
				AND b.receiving_id=receivings.receiving_id and left(receivings.receiving_time,10)='$tgl'");
		}

		function get_data_keu_tind_bln($bln){
			return $this->db->query("SELECT DATE_FORMAT(LEFT(receivings.receiving_time,10),'%d %M %Y') AS hari, count(receivings_items.description) AS jum_kunj, LEFT(receivings.receiving_time,10) as tgl, SUM(receivings_items.item_cost_price) as total 
										FROM receivings_items, receivings
										WHERE receivings_items.receiving_id=receivings.receiving_id and LEFT(receivings.receiving_time,7)='$bln'
										GROUP BY hari");
		}

		function get_data_keu_tind_thn($thn){
			return $this->db->query("SELECT MONTHNAME(LEFT(receivings.receiving_time,10)) AS bulan, count(receivings_items.description) AS jum_kunj, LEFT(receivings.receiving_time,10) as tgl, SUM(receivings_items.item_cost_price) as total 
FROM receivings_items, receivings
WHERE receivings_items.receiving_id=receivings.receiving_id and LEFT(receivings.receiving_time,4)='$thn'
GROUP BY bulan");
		}
/////////////////////////////////////////////////
		function row_table_pertgl($tgl){
			return $this->db->query("SELECT Count(*)
				FROM resep_pasien
				WHERE  left(tgl_kunjungan,10)  = '$tgl'
				GROUP BY item_obat");
		}

		function get_data_pembelian($param1, $param2, $filter){
			return $this->db->query("SELECT p.`id_po`, h.`no_po`, h.`sumber_dana`, h.`tgl_po`, s.`company_name`, d.`no_faktur`, d.`jatuh_tempo`, p.`description`, p.`qty_beli`, p.`satuank`, 
                p.`harga_po`, d.`diskon`, (p.`harga_po` * p.`qty_beli`) AS total_obat, d.`materai`, d.`ppn`, p.diskon_item
                FROM po p
                INNER JOIN header_po h ON p.`id_po` = h.`id_po`
                INNER JOIN `do` d ON d.`id_po` = p.`id_po`
                INNER JOIN suppliers s ON s.`person_id` = h.`supplier_id`
                WHERE p.`qty_beli` != '' AND LEFT(h.`tgl_po` , 10) >= '".$param1."' AND LEFT(h.`tgl_po`, 10) <= '".$param2."' 
                AND h.`sumber_dana` LIKE '%".$filter."%'

				ORDER BY h.no_po ASC");
		}

	function get_data_penjualan_terbanyak($param1, $param2, $filter){
		return $this->db->query("SELECT r.`item_obat`, r.`nama_obat`, m.`hargabeli`, m.`hargajual`, SUM(qty) AS penjualan 
				FROM resep_pasien r
				INNER JOIN master_obat m ON r.`item_obat` = m.`id_obat`
				WHERE r.`tgl_kunjungan` BETWEEN '".$param1."' AND '".$param2."' AND r.`nama_obat` NOT LIKE '%racikan%'
				GROUP BY r.`nama_obat` ORDER BY penjualan DESC LIMIT ".$filter);
    }

    function get_data_pembelian_by_po($id_po){
        return $this->db->query("SELECT h.`no_po`, h.`sumber_dana`, h.`tgl_po`, s.`company_name`, d.`no_faktur`, d.`jatuh_tempo`, p.`description`, p.`qty_beli`, p.`satuank`, 
			p.`harga_po`, d.`diskon`, (p.`harga_po` * p.`qty_beli`) AS total_obat, d.`materai`, d.`ppn`, p.diskon_item
			FROM po p
			INNER JOIN header_po h ON p.`id_po` = h.`id_po`
			INNER JOIN `do` d ON d.`id_po` = p.`id_po`
			INNER JOIN suppliers s ON s.`person_id` = h.`supplier_id`
			WHERE p.`qty_beli` != '' AND p.id_po = $id_po GROUP BY p.id");
    }

		function get_data_distribusi_obat($param1, $param2, $filter){

			if($filter != 0){
				$gudang = " AND a.`gd_asal` = ".$filter;
			}else{
                $gudang = "";
			}

            return $this->db->query("SELECT d.`id_obat`, o.`nm_obat`, d.`satuank`, o.`hargabeli`, SUM(d.`qty_acc`) AS qty, SUM(d.`qty_acc`) * o.`hargabeli` AS subtotal, a.`minggu`, a.`gd_asal`,  e.`nama_gudang`, a.`tgl_amprah`
					FROM
					distribusi d
					INNER JOIN master_obat o ON o.`id_obat` = d.`id_obat`
					INNER JOIN amprah a ON a.`id_amprah` = d.`id_amprah`
					INNER JOIN master_gudang e ON e.`id_gudang` = a.`gd_asal`
                WHERE d.`qty_acc` != 0 AND a.`minggu` != 0 $gudang
                AND LEFT(a.tgl_amprah, 10) >= '".$param1."' AND LEFT(a.tgl_amprah, 10) <= '".$param2."' 
                GROUP BY a.`minggu`, d.`id_obat`,e.`id_gudang` 
                ORDER BY a.`minggu`, d.`id_obat` ASC");
        }

        function get_nama_gudang($id_gudang){
			if($id_gudang != ""){
				$query = $this->db->query("SELECT * FROM master_gudang WHERE id_gudang = ".$id_gudang);
			}else{
				$query = $this->db->query("SELECT * FROM master_gudang WHERE id_gudang = 1");
			}
            return $query;
        }

        function get_gudang_distribusi_obat(){
            return $this->db->query("SELECT*FROM master_gudang WHERE id_gudang NOT IN (1, 2, 3, 7)");
        }
		
		// function row_table_pertgl_bycarabayar($tgl, $cara_bayar){
		// 	return $this->db->query("SELECT Count(*)
		// 		FROM resep_pasien
		// 		WHERE  left(tgl_kunjungan,10)  = '$tgl'
		// 		AND cara_bayar='$cara_bayar'
		// 		GROUP BY item_obat");
		// }

		// function row_table_perbln($bln){
		// 	return $this->db->query("SELECT Count(*)
		// 		FROM resep_pasien
		// 		WHERE  left(tgl_kunjungan,7)  = '$bln'
		// 		GROUP BY item_obat");
		// }

		// function row_table_perbln_bycarabayar($bln, $cara_bayar){
		// 	return $this->db->query("SELECT Count(*)
		// 		FROM resep_pasien
		// 		WHERE  left(tgl_kunjungan,7)  = '$bln'
		// 		AND cara_bayar='$cara_bayar'
		// 		GROUP BY item_obat");
	}
?>
