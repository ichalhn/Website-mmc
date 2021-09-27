<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Okmkwitansi extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_list_kwitansi(){
			return $this->db->query("SELECT data_pasien.no_cm as no_cm, b.no_ok, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, data_pasien.nama, count(1) AS banyak 
				FROM pemeriksaan_operasi b, data_pasien 
				WHERE b.no_medrec=data_pasien.no_medrec AND b.cara_bayar='UMUM' AND b.no_lab is not NULL
				GROUP BY no_ok 
				ORDER BY tgl DESC");
		}
		/////////

		function get_data_pasien($no_ok){
			return $this->db->query("SELECT data_pasien.no_cm as no_cm, a.no_medrec, a.no_register, data_pasien.nama, data_pasien.alamat as alamat, a.tgl_kunjungan as tgl, a.kelas, a.cara_bayar, a.idrg as ruang, datediff(a.tgl_kunjungan,tgl_lahir) as tgl_lahir FROM pemeriksaan_operasi a, data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_ok='$no_ok' GROUP BY no_ok");
		}

		function get_data_pemeriksaan($no_ok){
			return $this->db->query("SELECT jenis_tindakan, biaya_ok, qty, vtot FROM pemeriksaan_operasi WHERE no_ok='$no_ok'");
		}
		/////////

		function get_data_rs($koders){
			return $this->db->query("SELECT * FROM data_rs WHERE koders='$koders'");
		}
		/////////

		function update_status_cetak_kwitansi($no_ok, $diskon, $no_register, $xuser){
			$this->db->query("UPDATE pasien_luar SET cetak_kwitansi='1', xuser='$xuser' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pemeriksaan_operasi SET cetak_kwitansi='1' WHERE no_ok='$no_ok'");
			$this->db->query("UPDATE ok_header SET diskon='$diskon' WHERE no_ok='$no_ok'");
			return true;
		}
		
	}
?>