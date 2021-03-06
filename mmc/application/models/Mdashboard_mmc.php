<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mdashboard extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//modul
		function get_data_pasien(){
			return $this->db->query("SELECT cara_bayar, count(1) as jumlah, sum(total) as total FROM data_pasien_cara_bayar WHERE tgl = left(now(),10) GROUP BY cara_bayar ORDER BY cara_bayar");
		}

		function get_data_pasien_range($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT cara_bayar, count(1) as jumlah, sum(total) as total FROM data_pasien_cara_bayar WHERE (tgl>='$tgl_awal' AND tgl<='$tgl_akhir') AND (cara_bayar='BPJS' OR cara_bayar='UMUM' OR cara_bayar='DIJAMIN' OR cara_bayar='JAMSOSKES') GROUP BY cara_bayar");
		}

		function get_data_kunjungan_poli($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT nm_poli as nama, sum(jumlah) as total FROM data_kunjungan_poli WHERE tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir' GROUP BY nm_poli ORDER BY total DESC");
		}

		function get_data_kunjungan_poli_perhari($id_poli, $tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, count(*) as total 
							FROM data_kunjungan_poli 
							WHERE id_poli='$id_poli' 
							AND (left(tgl_kunjungan,10)>='$tgl_awal' AND left(tgl_kunjungan,10)<='$tgl_akhir')
							GROUP BY tgl");
		}

		function get_data_pendapatan($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT label, SUM(value) as `value` FROM data_pendapatan_keseluruhan 
				WHERE tgl>='$tgl_awal' AND tgl<='$tgl_akhir'
				GROUP BY label");
		}

		function get_data_diagnosa_ird($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT nm_diagnosa as nama, SUM(jumlah) AS jumlah FROM data_diagnosa_ird WHERE tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir' and id_diagnosa is not NULL and id_diagnosa!='' GROUP BY id_diagnosa ORDER BY jumlah DESC LIMIT 10");
		}

		function get_data_diagnosa_irj($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT nm_diagnosa as nama, SUM(jumlah) AS jumlah FROM data_diagnosa_irj WHERE tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir' and id_diagnosa is not NULL and id_diagnosa!='' GROUP BY id_diagnosa ORDER BY jumlah DESC LIMIT 10");
		}

		function get_data_diagnosa_iri($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT nm_diagnosa as nama, SUM(jumlah) AS jumlah, SUM(perempuan) AS perempuan, SUM(laki) as laki FROM data_diagnosa_iri WHERE tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir' and id_diagnosa is not NULL and id_diagnosa!=''GROUP BY id_diagnosa ORDER BY jumlah DESC LIMIT 10");
		}

		function get_excel_diagnosa_ird($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT id_diagnosa as id, nm_diagnosa as nama, SUM(jumlah) AS jumlah, SUM(perempuan) AS perempuan, SUM(laki) as laki FROM data_diagnosa_ird WHERE tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir' and id_diagnosa is not NULL and id_diagnosa!='' GROUP BY id_diagnosa ORDER BY jumlah DESC LIMIT 0, 10");
		}

		function get_excel_diagnosa_irj($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT id_diagnosa as id, nm_diagnosa as nama, SUM(jumlah) AS jumlah, SUM(perempuan) as perempuan, SUM(laki) as laki FROM data_diagnosa_irj WHERE tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir' and id_diagnosa is not NULL and id_diagnosa!='' GROUP BY id_diagnosa ORDER BY jumlah DESC LIMIT 0, 10");
		}

		function get_excel_diagnosa_iri($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT id_diagnosa as id, nm_diagnosa as nama, SUM(jumlah) AS jumlah, SUM(perempuan) as perempuan, SUM(laki) as laki FROM data_diagnosa_iri WHERE tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir' and id_diagnosa is not NULL and id_diagnosa!='' GROUP BY id_diagnosa ORDER BY jumlah DESC LIMIT 0, 10");
		}

		function get_data_poli(){
			return $this->db->query("SELECT id_poli, nm_poli FROM data_kunjungan_poli GROUP BY id_poli");
		}

		function get_data_vtot($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT sum(value) as vtot FROM data_pendapatan_keseluruhan 
				WHERE tgl>='$tgl_awal' AND tgl<='$tgl_akhir'");
		}

		function get_data_obat($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT nama_obat as nama, sum(qty) as jumlah FROM resep_pasien, master_obat
				WHERE resep_pasien.item_obat=master_obat.id_obat
				AND tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir'
				GROUP BY nama_obat
				ORDER BY jumlah DESC LIMIT 0, 10");
		}

		function get_data_periodik($thn_awal, $thn_akhir){
			return $this->db->query("SELECT tahunbln as bln, pendapatan FROM pendapatan_rs WHERE LEFT(tahunbln,4)>='$thn_awal' AND LEFT(tahunbln,4)<='$thn_akhir' ORDER BY tahunbln");
		}

		function get_data_bed(){
			return $this->db->query("SELECT
					a.idrg,
					a.nmruang,
					a.lokasi,
					b.kelas,
					COUNT( a.idrg ) AS bed_kapasitas_real,
					SUM( CASE WHEN b.isi = 'Y' THEN 1 ELSE 0 END ) AS bed_isi,
					SUM( CASE WHEN b.isi = 'N' THEN 1 ELSE 0 END ) AS bed_kosong 
				FROM
					ruang a
					LEFT JOIN bed b ON a.idrg = b.idrg 
				WHERE
					a.aktif = 'Active' 
					and a.lokasi!='Kamar Operasi'
				GROUP BY
					idrg,
					b.kelas");
		}
	}
?>