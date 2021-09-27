<?php
class Rimtest extends CI_Model {

	public function get_all_data_pasien_patria(){
		$CI = &get_instance();
		//setting the second parameter to TRUE (Boolean) the function will return the database object.
		$this->db2 = $CI->load->database('db2', TRUE);
		$data=$this->db2->query("
			SELECT tglmasuk,ruangkd,kelas,norekmed,nama,golpaskt,hakkelas,ruangkt
			FROM billing_inap_binap
			WHERE tglmasuk > '2016-05-14'
			and ruangkt not LIKE '%BAYI%'
			and tglkeluar is NULL
			");
		return $data->result_array();
	}

	public function get_data_pasien_by_no_cm_patria($no_cm){
		$data=$this->db->query("
		SELECT * 
		FROM data_pasien
		where no_cm = '$no_cm'
			");
		return $data->result_array();
	}

	public function insert_data_pasien($data){
		if(!$this->db->insert('data_pasien', $data)){
				return $this->db->error(); 
			}else{
				$this->db->insert_id();
				//$data['status']='0';
				return '0';
			}
	}

	public function get_last_no_medrec_data_pasien(){
		$data=$this->db->query("
		SELECT no_medrec
		FROM data_pasien
		order by no_medrec desc
		limit 1
			");
		return $data->result_array();
	}

	public function get_empty_bed($kelas,$idrg){
		$data=$this->db->query("
		SELECT *
		FROM bed 
		WHERE kelas = '$kelas' and idrg = '$idrg'
		and isi = 'N'
		order by bed asc
		limit 1	
			");
		return $data->result_array();
	}

	public function get_bed($kelas,$idrg){
		$data=$this->db->query("
		SELECT *
		FROM bed 
		WHERE kelas = '$kelas' and idrg = '$idrg'
		order by bed desc
		limit 1	
			");
		return $data->result_array();
	}

	public function insert_bed($data){
		$this->db->insert('bed', $data);
	}

	public function get_tarif_ruangan($kelas,$idrg){
		// $data=$this->db->query("
		// 	select *
		// 	from tarif_tindakan
		// 	where idrg = '$idrg' and kelas = '$kelas' and id_tindakan like '1%'
		// 	");

		$data=$this->db->query("
			select *
			from tarif_tindakan
			where kelas like '$kelas%' and id_tindakan like '1%'
			AND SUBSTR(id_tindakan FROM 4 FOR 3) = '$idrg'
			limit 1
			");
		return $data->result_array();
	}

	public function insert_tarif_tindakan($data){
		$this->db->insert('tarif_tindakan', $data);
	}
}
?>
