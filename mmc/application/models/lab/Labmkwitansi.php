<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Labmkwitansi extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_list_kwitansi(){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_lab, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama, count(1) AS banyak FROM pemeriksaan_laboratorium b, pasien_luar WHERE b.no_register=pasien_luar.no_register  AND  pasien_luar.cetak_kwitansi='0' AND b.no_lab is not NULL GROUP BY no_lab 
				UNION
				SELECT data_pasien.no_cm as no_cm, b.no_lab, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, data_pasien.nama, count(1) AS banyak 
				FROM pemeriksaan_laboratorium b, data_pasien 
				WHERE b.no_medrec=data_pasien.no_medrec AND b.cara_bayar='UMUM'  AND  b.cetak_kwitansi='0' AND b.no_lab is not NULL
				GROUP BY no_lab 
				ORDER BY tgl DESC");
		}

		function get_list_kwitansi_by_no($key){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_lab, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama, count(1) AS banyak 
				FROM pemeriksaan_laboratorium b, pasien_luar 
				WHERE b.no_register=pasien_luar.no_register AND (b.no_register LIKE '%$key%' OR pasien_luar.nama LIKE '%$key%') AND  pasien_luar.cetak_kwitansi='0' AND b.no_lab is not NULL 
				GROUP BY no_lab
				UNION 
				SELECT data_pasien.no_cm as no_cm, b.no_lab, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, data_pasien.nama, count(1) AS banyak 
				FROM pemeriksaan_laboratorium b, data_pasien 
				WHERE b.no_medrec=data_pasien.no_medrec AND (b.no_register LIKE '%$key%' OR data_pasien.nama LIKE '%$key%') AND b.cara_bayar='UMUM'  AND  b.cetak_kwitansi='0' AND b.no_lab is not NULL 
				GROUP BY no_lab  ORDER BY tgl DESC");
		}

		function get_list_kwitansi_by_date($date){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_lab, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, nama, count(1) AS banyak FROM pemeriksaan_laboratorium b, pasien_luar WHERE b.no_register=pasien_luar.no_register AND left(b.tgl_kunjungan,10)='$date'  AND  pasien_luar.cetak_kwitansi='0' AND b.no_lab is not NULL GROUP BY no_lab
				UNION 
				SELECT data_pasien.no_cm as no_cm, b.no_lab, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, data_pasien.nama, count(1) AS banyak 
				FROM pemeriksaan_laboratorium b, data_pasien 
				WHERE b.no_medrec=data_pasien.no_medrec AND left(b.tgl_kunjungan,10)='$date' AND b.cara_bayar='UMUM'  AND  b.cetak_kwitansi='0' AND b.no_lab is not NULL 
				GROUP BY no_lab ORDER BY tgl DESC");
		}
		/////////

		function get_data_pasien($no_lab){
			return $this->db->query("SELECT data_pasien.no_cm as no_cm, a.no_medrec, a.no_register, data_pasien.nama, data_pasien.alamat as alamat, a.tgl_kunjungan as tgl, a.kelas, a.cara_bayar, a.idrg as ruang, datediff(a.tgl_kunjungan,tgl_lahir) as tgl_lahir FROM pemeriksaan_laboratorium a, data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_lab='$no_lab' GROUP BY no_lab");
		}

		function get_data_pasien_byno_register($no_register){
			return $this->db->query("SELECT data_pasien.no_cm as no_cm, a.no_medrec, a.no_register, data_pasien.nama, data_pasien.alamat as alamat, a.tgl_kunjungan as tgl, a.kelas, a.cara_bayar, a.idrg as ruang, datediff(tgl_kunjungan,tgl_lahir) as tgl_lahir FROM pemeriksaan_laboratorium a, data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_register='$no_register' GROUP BY no_register");
		}

		function get_data_pemeriksaan($no_lab){
			return $this->db->query("SELECT jenis_tindakan, biaya_lab, qty, vtot FROM pemeriksaan_laboratorium WHERE no_lab='$no_lab'");
		}

		function get_data_pemeriksaan_byno_register($no_register){
			return $this->db->query("SELECT tgl_kunjungan, no_lab, jenis_tindakan, biaya_lab, qty, vtot FROM pemeriksaan_laboratorium WHERE no_register='$no_register' AND no_lab is not null");
		}

		function get_data_pemeriksaan_byno_register_ri($no_register, $noregasal){
			return $this->db->query("SELECT
										tgl_kunjungan ,
										no_lab ,
										jenis_tindakan ,
										biaya_lab ,
										qty ,
										vtot ,
										no_register
									FROM
										pemeriksaan_laboratorium a
									WHERE
										a.no_register IN('$no_register' , '$noregasal')
									AND no_lab IS NOT NULL");
		}

		function get_noreg_asal($no_register){
			return $this->db->query("SELECT noregasal FROM pasien_iri WHERE no_ipd = '$no_register'");
		}
		/////////

		function get_data_rs($koders){
			return $this->db->query("SELECT * FROM data_rs WHERE koders='$koders'");
		}
		/////////

		function update_status_cetak_kwitansi($no_lab, $diskon, $no_register, $xuser){
			$this->db->query("UPDATE pasien_luar SET cetak_kwitansi='1', xuser='$xuser' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pemeriksaan_laboratorium SET cetak_kwitansi='1' WHERE no_lab='$no_lab'");
			$this->db->query("UPDATE lab_header SET diskon='$diskon' WHERE no_lab='$no_lab'");
			return true;
		}
		
	}
?>