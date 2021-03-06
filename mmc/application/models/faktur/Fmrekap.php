<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Fmrekap extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		function get_rekap_faktur_irj(){
			return $this->db->query("SELECT daftar_ulang_irj.counter_kwitansi, daftar_ulang_irj.tgl_kunjungan as tgl_kunjungan, daftar_ulang_irj.no_register as no_register, data_pasien.no_cm as no_cm, data_pasien.nama as nama, daftar_ulang_irj.cara_bayar as cara_bayar, poliklinik.id_poli as id_poli, poliklinik.nm_poli as nm_poli FROM data_pasien, daftar_ulang_irj, poliklinik where daftar_ulang_irj.no_medrec=data_pasien.no_medrec and poliklinik.id_poli=daftar_ulang_irj.id_poli and daftar_ulang_irj.cetak_kwitansi = 1 and left(daftar_ulang_irj.tgl_kunjungan,10)=left(now(),10) order by daftar_ulang_irj.tgl_cetak_kw desc");
		}
		function get_rekap_faktur_iri(){
			return $this->db->query("SELECT a.tgl_masuk as tgl_kunjungan, 
				a.no_ipd as no_register, b.no_cm as no_cm, 
				b.nama as nama, a.carabayar as cara_bayar, 
				(select nmruang from ruang where idrg=a.idrg) as nm_poli
				, a.idrg as id_poli
				FROM pasien_iri a, data_pasien b
				where a.no_cm=b.no_medrec  
				and left(a.tgl_masuk,10)=left(now(),10) 
				and a.cetak_kwitansi='1'
				order by a.tgl_cetak_kw desc");
		}
		function get_rekap_faktur_ird(){
			return $this->db->query("SELECT A.no_medrec, A.no_register,  A.cara_bayar,  B.no_cm, A.tgl_kunjungan, B.nama FROM irddaftar_ulang A, data_pasien B where left(A.tgl_kunjungan,10)=left(now(),10) and A.no_medrec=B.no_medrec order by A.tgl_kunjungan desc");
		}
		function get_pasien_kwitansi_ird_by_date($date){
			return $this->db->query("SELECT * FROM irddaftar_ulang, data_pasien where irddaftar_ulang.no_medrec=data_pasien.no_medrec and left(irddaftar_ulang.tgl_kunjungan,10)='$date' order by irddaftar_ulang.xupdate desc");
		}
		function get_pasien_kwitansi_irj_by_date($date){
			return $this->db->query("SELECT	* FROM	data_pasien, daftar_ulang_irj,poliklinik
									 WHERE
									poliklinik.id_poli = daftar_ulang_irj.id_poli
									AND daftar_ulang_irj.cetak_kwitansi = 1
									AND daftar_ulang_irj.no_medrec = data_pasien.no_medrec
									AND LEFT (daftar_ulang_irj.tgl_kunjungan,10) = '$date'
									ORDER BY daftar_ulang_irj.tgl_cetak_kw DESC");
		}

		function get_pasien_kwitansi_iri_by_date($date){
			return $this->db->query("SELECT * , pasien_iri.no_ipd as no_register, pasien_iri.tgl_masuk as tgl_kunjungan, pasien_iri.carabayar as cara_bayar, (select nmruang from ruang where idrg=pasien_iri.idrg) as nm_poli, pasien_iri.idrg as id_poli
			FROM pasien_iri, data_pasien
			where pasien_iri.no_cm=data_pasien.no_medrec 
			and pasien_iri.tgl_masuk='$date'
			and pasien_iri.cetak_kwitansi='1'
			order by pasien_iri.xupdate desc");
		}

		function get_rekap_lab(){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_lab, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama, count(1) AS banyak 
				FROM pemeriksaan_laboratorium b, pasien_luar 
				WHERE b.no_register=pasien_luar.no_register  
				AND left(pasien_luar.tgl_kunjungan,10)=left(now(),10)
				GROUP BY no_lab ORDER BY tgl DESC");
		}
		function get_rekap_lab_by_date($date){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_lab, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama, count(1) AS banyak 
				FROM pemeriksaan_laboratorium b, pasien_luar 
				WHERE b.no_register=pasien_luar.no_register  
				AND left(pasien_luar.tgl_kunjungan,10)='$date'
				GROUP BY no_lab ORDER BY tgl DESC");
		}

		function get_rekap_rad(){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_rad, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama, count(1) AS banyak FROM pemeriksaan_radiologi b, pasien_luar WHERE b.no_register=pasien_luar.no_register AND left(pasien_luar.tgl_kunjungan,10)=left(now(),10) GROUP BY no_rad ORDER BY tgl DESC");
		}
		function get_rekap_rad_by_date($date){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_rad, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama, count(1) AS banyak FROM pemeriksaan_radiologi b, pasien_luar WHERE b.no_register=pasien_luar.no_register AND left(pasien_luar.tgl_kunjungan,10)='$date' GROUP BY no_rad ORDER BY tgl DESC");
		}

		function get_rekap_frm(){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_resep, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama, count(1) AS banyak FROM resep_pasien b, pasien_luar WHERE b.no_register=pasien_luar.no_register AND left(pasien_luar.tgl_kunjungan,10)=left(now(),10) GROUP BY no_resep ORDER BY tgl DESC");
		}

		function get_data_pasien_by_noreg($noreg){
			return $this->db->query("SELECT * FROM pasien_iri a, data_pasien b 
			where a.no_cm=b.no_medrec and a.no_ipd='$noreg'");
		}

		function get_rekap_frm_by_date($date){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_resep, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama, count(1) AS banyak FROM resep_pasien b, pasien_luar WHERE b.no_register=pasien_luar.no_register AND left(pasien_luar.tgl_kunjungan,10)='$date' GROUP BY no_resep ORDER BY tgl DESC");
		}
		
	}
?>
