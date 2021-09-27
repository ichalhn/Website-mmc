<?php
class Rimuser extends CI_Model {

	public function get_all_user(){
		$data=$this->db->query("
			select * from hmis_users order by username asc");
		return $data->result_array();
	}

	public function get_log_user_antrian_by_date($tgl_awal,$tgl_akhir){
		$data=$this->db->query("
			SELECT user_approve, COUNT(*) as jml FROM irna_antrian
			WHERE tglreserv BETWEEN '$tgl_awal' AND '$tgl_akhir'
			GROUP BY user_approve

			");
		return $data->result_array();
	}

	public function get_log_user_pasien_by_date($tgl_awal,$tgl_akhir){
		$data=$this->db->query("
			SELECT verifuser, COUNT(*) as jml FROM pasien_iri
			WHERE tgldaftarri BETWEEN '$tgl_awal' AND '$tgl_akhir'
			GROUP BY verifuser
			");
		return $data->result_array();
	}

	public function get_log_user_tindakan_temp_by_date($tgl_awal,$tgl_akhir){
		$data=$this->db->query("
			SELECT xuser, COUNT(*) as jml FROM pelayanan_iri_temp
			WHERE tgl_layanan BETWEEN '$tgl_awal' AND '$tgl_akhir'
			GROUP BY xuser
			");
		return $data->result_array();
	}

	public function get_log_user_tindakan_by_date($tgl_awal,$tgl_akhir){
		$data=$this->db->query("
			SELECT xuser, COUNT(*) as jml FROM pelayanan_iri
			WHERE tgl_layanan BETWEEN '$tgl_awal' AND '$tgl_akhir'
			GROUP BY xuser
			");
		return $data->result_array();
	}

	public function get_log_user_mutasi_by_date($tgl_awal,$tgl_akhir){
		$data=$this->db->query("
			SELECT xuser, COUNT(*) as jml FROM ruang_iri
			WHERE tglmasukrg BETWEEN '$tgl_awal' AND '$tgl_akhir'
			GROUP BY xuser
			");
		return $data->result_array();
	}	


	public function get_log_user_all($tgl_awal,$tgl_akhir){
		$data=$this->db->query("
			SELECT *, count(*) as jml FROM (
				SELECT user_approve as usr FROM irna_antrian
				WHERE tglreserv BETWEEN '$tgl_awal' AND '$tgl_akhir'
				UNION ALL
				SELECT verifuser as usr FROM pasien_iri
				WHERE tgldaftarri BETWEEN '$tgl_awal' AND '$tgl_akhir'
				UNION ALL
				SELECT xuser as usr FROM pelayanan_iri_temp
				WHERE tgl_layanan BETWEEN '$tgl_awal' AND '$tgl_akhir'
				UNION ALL
				SELECT xuser as usr FROM pelayanan_iri
				WHERE tgl_layanan BETWEEN '$tgl_awal' AND '$tgl_akhir'
				UNION ALL
				SELECT xuser as usr FROM ruang_iri
				WHERE tglmasukrg BETWEEN '$tgl_awal' AND '$tgl_akhir'
				) as a
			GROUP BY a.usr
			");
		return $data->result_array();
	}
}
?>
