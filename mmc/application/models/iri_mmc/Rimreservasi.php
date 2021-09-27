<?php
class Rimreservasi extends CI_Model {

	public function select_pasien_irj_like($value){
		// $data=$this->db->query("select *
		// 	from daftar_ulang_irj as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		// 	left join poliklinik as c on a.id_poli = c.id_poli
		// 	where a.no_register like '%$value%'");
		$data=$this->db->query("
			select a.*, b.no_cm as no_cm_real, b.*,c.*,d.*,e.*,f.id_diagnosa,f.diagnosa as diagnosa_utama, g.nm_dokter as nama_dokter
			from pasien_rujuk_inap as a inner join data_pasien as b on a.no_medrec = b.no_medrec
			left join daftar_ulang_irj as d on a.no_register = d.no_register
			left join poliklinik as c on d.id_poli = c.id_poli
			left join icd1 as e on d.diagnosa = e.id_icd
			left join diagnosa_pasien as f on a.no_register = f.no_register
			left join data_dokter as g on g.id_dokter = d.id_dokter
			where a.no_register like '%$value%'
			and (f.klasifikasi_diagnos = 'utama' or f.klasifikasi_diagnos is NULL)
			");
		return $data->result_array();
	}

	public function batal_iri_reservasi($value){
		$data=$this->db->query("UPDATE daftar_ulang_irj set ket_pulang='DIRUJUK_RAWATINAP_BATAL'
			where no_register='$value'");
		return true;
	}

	public function select_pasien_irj($value){
		// $data=$this->db->query("select *
		// 	from daftar_ulang_irj as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		// 	left join poliklinik as c on a.id_poli = c.id_poli
		// 	where a.no_register like '%$value%'");
		$data=$this->db->query("
			select a.*,b.*,c.*,d.*,e.*,f.id_diagnosa,f.diagnosa as diagnosa_utama, g.nm_dokter as nama_dokter
			from pasien_rujuk_inap as a inner join data_pasien as b on a.no_medrec = b.no_medrec
			left join daftar_ulang_irj as d on a.no_register = d.no_register
			left join poliklinik as c on d.id_poli = c.id_poli
			left join icd1 as e on d.diagnosa = e.id_icd
			left join diagnosa_pasien as f on a.no_register = f.no_register
			left join data_dokter as g on g.id_dokter = d.id_dokter
			where a.no_register like '$value'
			and (f.klasifikasi_diagnos = 'utama' or f.klasifikasi_diagnos is NULL)
			");
		return $data->result_array();
	}

	public function check_iri($noreg){
			return $this->db->query("SELECT COUNT(*) as cek, tgl_masuk FROM pasien_iri WHERE no_cm='".$noreg."' AND tgl_keluar is null ");
	}

	public function select_pasien_ird($value){
		// $data=$this->db->query("
		// 	select * 
		// 	from irddaftar_ulang as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		// 	where a.no_register like '%$value%'");

		$data=$this->db->query("
			select a.*,b.*,c.*,d.id_diagnosa, d.diagnosa as diagnosa_utama
			from pasien_rujuk_inap as a inner join data_pasien as b on a.no_medrec = b.no_medrec
			left join irddaftar_ulang as c on a.no_register = c.no_register
			left join icd1 as e on c.diagnosa = e.id_icd
			left join diagnosa_ird as d on a.no_register = d.no_register
			where a.no_register like '$value'
			and (d.klasifikasi_diagnos = 'utama' or d.klasifikasi_diagnos is null)
			");
		return $data->result_array();
	}

	public function select_pasien_iri_like($value){
		// $data=$this->db->query("select *
		// 	from daftar_ulang_irj as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		// 	left join poliklinik as c on a.id_poli = c.id_poli
		// 	where a.no_register like '%$value%'");
		$data=$this->db->query("
			select a.*, b.*, c.*, d.*
			from pasien_iri as a inner join data_pasien as b on a.no_cm = b.no_medrec
			left join icd1 as c on c.id_icd = a.diagmasuk
			left join ruang as d on d.idrg = a.idrg
			where a.no_ipd like '%$value%' and a.tgl_keluar is NULL
			");
		return $data->result_array();
	}

	//moris up

	public function select_pasien_ird_like($value){
		// $data=$this->db->query("
		// 	select * 
		// 	from irddaftar_ulang as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		// 	where a.no_register like '%$value%'");

		$data=$this->db->query("
			select a.*,b.*,c.*,d.id_diagnosa, d.diagnosa as diagnosa_utama,g.nm_dokter
			from pasien_rujuk_inap as a inner join data_pasien as b on a.no_medrec = b.no_medrec
			left join irddaftar_ulang as c on a.no_register = c.no_register
			left join icd1 as e on c.diagnosa = e.id_icd
			left join diagnosa_ird as d on a.no_register = d.no_register
			left join data_dokter as g on g.id_dokter = c.id_dokter
			where a.no_register like '%$value%'
			and (d.klasifikasi_diagnos = 'utama' or d.klasifikasi_diagnos is null)
			");
		return $data->result_array();
	}

	

	public function select_pasien_irj_by_ipd($value){
		$data=$this->db->query("select *
			from pasien_iri as a inner join data_pasien as b on a.no_cm = b.no_medrec
			inner join ruang_iri as c on a.no_ipd = c.no_ipd
			inner join ruang as d on c.idrg = d.idrg
			left join icd1 as e on e.id_icd = a.diagmasuk
			where a.no_ipd = '$value'");
		return $data->result_array();
	}
	//moris up

	public function select_irna_antrian_by_noreservasi($value){
		$data=$this->db->query("select * from irna_antrian where noreservasi like '%$value%'");
		return $data->result_array();
	}
	
	public function select_ruang_like($value){
		$data=$this->db->query("select *from ruang where idrg like '%$value%'");
		return $data->result_array();
	}
	
	public function insert_reservasi($data){
		$this->db->insert('irna_antrian', $data);
	}
}
?>
