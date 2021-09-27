<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Radmkwitansi extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_list_kwitansi(){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_rad, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama, count(1) AS banyak FROM pemeriksaan_radiologi b, pasien_luar WHERE b.no_register=pasien_luar.no_register  AND  pasien_luar.cetak_kwitansi='0' AND b.no_rad is not NULL GROUP BY no_rad
				UNION
				SELECT data_pasien.no_cm as no_cm, b.no_rad, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, data_pasien.nama, count(1) AS banyak 
				FROM pemeriksaan_radiologi b, data_pasien 
				WHERE b.no_medrec=data_pasien.no_medrec AND b.cara_bayar='UMUM' AND b.cetak_kwitansi='0' AND b.no_rad is not NULL 
				GROUP BY no_rad ORDER BY tgl DESC");
		}

		function get_list_kwitansi_by_no($key){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_rad, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, pasien_luar.nama, count(1) AS banyak FROM pemeriksaan_radiologi b, pasien_luar WHERE b.no_register=pasien_luar.no_register AND (b.no_register LIKE '%$key%' OR b.no_medrec LIKE '%$key%') AND  pasien_luar.cetak_kwitansi='0' AND b.no_rad is not NULL GROUP BY no_rad
				UNION 
				SELECT data_pasien.no_cm as no_cm, b.no_rad, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, data_pasien.nama, count(1) AS banyak 
				FROM pemeriksaan_radiologi b, data_pasien 
				WHERE b.no_medrec=data_pasien.no_medrec AND (b.no_register LIKE '%$key%' OR data_pasien.nama LIKE '%$key%') AND b.cara_bayar='UMUM'  AND  b.cetak_kwitansi='0' AND b.no_rad is not NULL 
				GROUP BY no_rad  ORDER BY tgl DESC");
		}

		function get_list_kwitansi_by_date($date){
			return $this->db->query("SELECT 'Pasien Luar' as no_cm, b.no_rad, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, nama, count(1) AS banyak FROM pemeriksaan_radiologi b, pasien_luar WHERE b.no_register=pasien_luar.no_register AND left(b.tgl_kunjungan,10)='$date'  AND  pasien_luar.cetak_kwitansi='0' AND b.no_rad is not NULL GROUP BY no_rad
				UNION 
				SELECT data_pasien.no_cm as no_cm, b.no_rad, b.tgl_kunjungan AS tgl, b.no_register, b.no_medrec, data_pasien.nama, count(1) AS banyak 
				FROM pemeriksaan_radiologi b, data_pasien 
				WHERE b.no_medrec=data_pasien.no_medrec AND left(b.tgl_kunjungan,10)='$date' AND b.cara_bayar='UMUM'  AND  b.cetak_kwitansi='0' AND b.no_rad is not NULL 
				GROUP BY no_rad ORDER BY tgl DESC");
		}
		/////////

		function get_data_pasien($no_rad){
			return $this->db->query("SELECT  data_pasien.no_cm as no_cm, a.no_medrec, a.no_register, data_pasien.nama, data_pasien.alamat as alamat, a.tgl_kunjungan as tgl, a.kelas, a.cara_bayar, a.idrg as ruang, datediff(a.tgl_kunjungan,tgl_lahir) as tgl_lahir FROM pemeriksaan_radiologi a, data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND a.no_rad='$no_rad'
				UNION
				SELECT  'Pasien Luar' as no_cm, b.no_medrec, b.no_register, pasien_luar.nama, pasien_luar.alamat as alamat, b.tgl_kunjungan as tgl, b.kelas, b.cara_bayar, 'Pasien Luar' as ruang, datediff(now(),now()) as tgl_lahir FROM pemeriksaan_radiologi b, pasien_luar WHERE b.no_register=pasien_luar.no_register AND no_rad='$no_rad' GROUP BY no_rad");
		}

		function get_data_pemeriksaan($no_rad){
			return $this->db->query("SELECT jenis_tindakan, biaya_rad, qty, vtot FROM pemeriksaan_radiologi WHERE no_rad='$no_rad'");
		}
		/////////

		function get_data_rs($koders){
			return $this->db->query("SELECT * FROM data_rs WHERE koders='$koders'");
		}

		/////////

		function update_status_cetak_kwitansi($no_rad, $diskon, $no_register, $xuser){
			$this->db->query("UPDATE pasien_luar SET cetak_kwitansi='1', xuser='$xuser' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pemeriksaan_radiologi SET cetak_kwitansi='1' WHERE no_rad='$no_rad'");
			$this->db->query("UPDATE rad_header SET diskon='$diskon' WHERE no_rad='$no_rad'");
			return true;
		}
		
	}
?>
