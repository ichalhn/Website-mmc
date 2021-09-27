<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Frmmkwitansi extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_list_kwitansi(){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_resep, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama, count(1) AS banyak, cara_bayar as cara_bayar 
				FROM resep_pasien b, pasien_luar 
				WHERE b.no_register=pasien_luar.no_register  AND  pasien_luar.cetak_kwitansi='0' AND b.no_resep is not NULL
				GROUP BY no_resep 
				UNION
				SELECT data_pasien.no_cm as no_cm, b.no_resep, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, data_pasien.nama, count(1) AS banyak, cara_bayar as cara_bayar
				FROM resep_pasien b, data_pasien 
				WHERE b.no_medrec=data_pasien.no_medrec AND b.cara_bayar='UMUM' AND b.cetak_kwitansi='0' AND b.no_resep is not NULL
				GROUP BY no_resep 
				ORDER BY tgl ASC");
		}

		function get_list_kwitansi_by_no($key){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_resep, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec,  pasien_luar.nama, count(1) AS banyak FROM resep_pasien b, pasien_luar WHERE b.no_register=pasien_luar.no_register AND b.no_resep is not NULL AND (b.no_register='$key' OR b.no_medrec='$key') GROUP BY no_resep 
				UNION
				SELECT data_pasien.no_cm, b.no_resep, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec,  data_pasien.nama, count(1) AS banyak FROM resep_pasien b, data_pasien WHERE b.no_medrec=data_pasien.no_medrec  AND AND b.no_resep is not NULL (b.no_register='$key' OR b.no_medrec='$key') AND b.cara_bayar='UMUM' GROUP BY no_resep 
				ORDER BY tgl ASC");
		}

		function get_list_kwitansi_by_date($date){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_resep, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama, count(1) AS banyak FROM resep_pasien b, pasien_luar WHERE b.no_register=pasien_luar.no_register AND b.no_resep is not NULL AND left(b.tgl_kunjungan,10)='$date' GROUP BY no_resep 
				UNION
				SELECT data_pasien.no_cm, b.no_resep, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec,  data_pasien.nama, count(1) AS banyak FROM resep_pasien b, data_pasien WHERE b.no_medrec=data_pasien.no_medrec AND b.no_resep is not NULL AND left(b.tgl_kunjungan,10)='$date' AND b.cara_bayar='UMUM' GROUP BY no_resep 
				ORDER BY tgl ASC");
		}
		/////////

		function get_data_pasien($no_resep){
			return $this->db->query("SELECT data_pasien.no_cm as no_cm, a.cara_bayar, b.idrg, b.bed, a.no_medrec, a.no_register, data_pasien.nama as nama, data_pasien.sex as sex, data_pasien.goldarah as goldarah, a.tgl_kunjungan as tgl_kunjungan, a.kelas, '-' as nm_dokter FROM resep_pasien a, data_pasien, resep_header b WHERE a.no_resep=b.no_resep AND a.no_medrec=data_pasien.no_medrec AND a.no_resep='$no_resep' GROUP BY a.no_resep
			UNION 
			SELECT 'Pasien Luar' as no_cm, c.cara_bayar, c.idrg, c.bed, c.no_medrec, c.no_register, pasien_luar.nama as nama, '-' as sex, '-' as goldarah, c.tgl_kunjungan as tgl_kunjungan, c.kelas, d.nm_dokter FROM resep_pasien c, pasien_luar, resep_header d WHERE c.no_resep=d.no_resep AND c.no_register=pasien_luar.no_register AND c.no_register=pasien_luar.no_register AND c.no_resep='$no_resep' GROUP BY c.no_resep");
		}

		function getdata_ruang($idrg){
			return $this->db->query("SELECT * FROM ruang WHERE idrg='$idrg'");
		}

		function getdata_poliklinik($idrg){
			return $this->db->query("SELECT * FROM poliklinik WHERE id_poli='$idrg'");
		}

		function get_data_permintaan($no_resep){
			return $this->db->query("SELECT nama_obat,item_obat, biaya_obat, qty, cara_bayar, vtot FROM resep_pasien where no_resep='$no_resep'");
		}

		/////////

		function get_data_rs($koders){
			return $this->db->query("SELECT * from data_rs where koders='$koders'");
		}

		function get_total_tuslah($no_resep){
			return $this->db->query("SELECT sum(tuslah) as vtot_tuslah from resep_pasien where no_resep='$no_resep'");
		}
		
		function update_status_resep($nokwitansi_kt,$no_register){
			$this->db->query("update  set nokwitansi_kt='$nokwitansi_kt', tglcetak_kwitansi=now() where no_register='$no_register'");
			return true;
		}

		function update_diskon($diskon,$no_resep){
			$this->db->query("update resep_header set diskon='$diskon' where no_resep='$no_resep'");
			return true;
		}

		function update_status_cetak_kwitansi($no_resep, $diskon, $no_register, $xuser){
			$this->db->query("UPDATE pasien_luar SET cetak_kwitansi='1', xuser='$xuser' WHERE no_register='$no_register'");
			$this->db->query("UPDATE resep_pasien SET cetak_kwitansi='1' WHERE no_resep='$no_resep'");
			$this->db->query("UPDATE resep_header SET diskon='$diskon' WHERE no_resep='$no_resep'");
			return true;
		}
	}
?>