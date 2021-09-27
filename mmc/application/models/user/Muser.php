<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Muser extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//modul
		function get_user_data_pasien($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xuser) as total, xuser from data_pasien 
where tgl_daftar BETWEEN '$tgl_awal' AND '$tgl_akhir' group by xuser");
		}

		function get_user_all($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT u.username as xuser, IFNULL(SUM(c.total),0) as total, c.tgl_kunjungan as tgl 
FROM hmis_users u 
LEFT JOIN lap_user c 
ON u.username = c.user AND c.tgl_kunjungan>='$tgl_awal' and c.tgl_kunjungan<='$tgl_akhir'
GROUP BY u.username
");
		}	

		function get_user_daful_ird($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xuser) as total, xuser from irddaftar_ulang 
where left(tgl_kunjungan,10)>='$tgl_awal' AND left(tgl_kunjungan,10)<='$tgl_akhir' group by xuser");
		}

		function get_user_daful_irj($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xuser) as total, xuser from daftar_ulang_irj 
where left(tgl_kunjungan,10)>='$tgl_awal' AND left(tgl_kunjungan,10)<='$tgl_akhir' group by xuser");
		}

		function get_user_tind_ird($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xuser) as total, xuser from tindakan_ird 
where left(tgl_kunjungan,10)>='$tgl_awal' AND left(tgl_kunjungan,10)<='$tgl_akhir' group by xuser");
		}

		function get_user_tind_irj($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xuser) as total, xuser from pelayanan_poli 
where left(tgl_kunjungan,10)>='$tgl_awal' AND left(tgl_kunjungan,10)<='$tgl_akhir' group by xuser");
		}

		function get_user_diag_ird($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xuser) as total, xuser from diagnosa_ird 
where left(tgl_kunjungan,10)>='$tgl_awal' AND left(tgl_kunjungan,10)<='$tgl_akhir' group by xuser");
		}

		function get_user_diag_irj($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xuser) as total, xuser from diagnosa_pasien 
where left(tgl_kunjungan,10)>='$tgl_awal' AND left(tgl_kunjungan,10)<='$tgl_akhir' group by xuser");
		}

		function get_cetak_ird($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(xcetak) as total, xcetak from irddaftar_ulang
where left(tgl_cetak_kw,10)>='$tgl_awal' AND left(tgl_cetak_kw,10)<='$tgl_akhir' group by xcetak");
		}

		function get_cetak_irj($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(xcetak) as total, xcetak from daftar_ulang_irj 
where left(tgl_cetak_kw,10)>='$tgl_awal' AND left(tgl_cetak_kw,10)<='$tgl_akhir' group by xcetak");
		}

		function get_cetak_pl_rad($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xuser) as total, COALESCE(xuser, '-') as xuser from pasien_luar 
where vtot_rad is not NULL and left(tgl_kunjungan,10)>='$tgl_awal' AND left(tgl_kunjungan,10)<='$tgl_akhir' group by xuser");
		}
		function get_cetak_pl_lab($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xuser) as total, COALESCE(xuser, '-') as xuser from pasien_luar 
where vtot_lab is not NULL and left(tgl_kunjungan,10)>='$tgl_awal' AND left(tgl_kunjungan,10)<='$tgl_akhir' group by xuser");
		}
		function get_cetak_pl_farm($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xuser) as total, COALESCE(xuser, '-') as xuser from pasien_luar 
where vtot_obat is not NULL and left(tgl_kunjungan,10)>='$tgl_awal' AND left(tgl_kunjungan,10)<='$tgl_akhir' group by xuser");
		}

		function get_user_rad($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xinput) as total, COALESCE(xinput, '-') as xinput from pemeriksaan_radiologi 

where left(tgl_kunjungan,10)>='$tgl_awal' AND left(tgl_kunjungan,10)<='$tgl_akhir' group by xinput");
		}		
		
		function get_user_lab($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xinput) as total, COALESCE(xinput, '-') as xinput from pemeriksaan_laboratorium
where left(tgl_kunjungan,10)>='$tgl_awal' AND left(tgl_kunjungan,10)<='$tgl_akhir' group by xinput");
		}		

		function get_user_farm($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT count(xinput) as total, COALESCE(xinput, '-') as xinput from resep_pasien
where left(tgl_kunjungan,10)>='$tgl_awal' AND left(tgl_kunjungan,10)<='$tgl_akhir' group by xinput");
		}

			function getIdGudang($userid){
            $query = $this->db->get_where('dyn_gudang_user  ', array('userid' => $userid));
            return $query->row();
        }
	}
?>
