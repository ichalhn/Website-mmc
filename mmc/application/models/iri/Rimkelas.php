<?php
class Rimkelas extends CI_Model {

	public function get_data_rs($koders){
		$data=$this->db->query("
			select * from data_rs where koders='$koders'");
		return $data->result_array();
	}

	public function get_kelas(){
		$data=$this->db->query("
			select *
			from kelas as a
			order by urutan asc
			");
		return $data->result_array();
	}

	public function get_all_kelas(){
		$data=$this->db->query("
			select a.kelas,a.idrg, count(*), b.nmruang
			from bed as a
			left join ruang as b on a.idrg = b.idrg
			group by a.kelas,a.idrg,b.nmruang
			order by idrg,kelas asc");
		return $data->result_array();
	}

	public function get_bed_by_bed($bed){
		$data=$this->db->query("
			select *
			from bed as a
			where a.bed = '".$bed."'
			");
		return $data->result_array();
	}

	public function get_all_kelas_with_empty_bed(){
		$data=$this->db->query("
			select a.kelas,a.idrg, count(*), b.nmruang
			from bed as a
			inner join ruang as b on a.idrg = b.idrg
			group by a.kelas,a.idrg,b.nmruang");
		return $data->result_array();
	}

	public function get_status_bed($kelas, $idrg){
		$data=$this->db->query("SELECT a.kelas,a.idrg, count(*), b.nmruang
			from bed as a
			inner join ruang as b on a.idrg = b.idrg
			where a.isi = 'N' and a.kelas='$kelas' and a.idrg='$idrg'
			group by a.kelas,a.idrg,b.nmruang");
		return $data->result_array();
	}

	public function get_all_empty_bed_by_kelas_and_ruang($kelas,$idrg){
		$data=$this->db->query("
			select *
			from bed as a
			inner join ruang as b on a.idrg = b.idrg
			where a.isi = 'N' and a.kelas = '$kelas' and a.idrg = '$idrg'
			");
		return $data->result_array();
	}

	public function flag_bed_by_id($data,$bed_id){
		$this->db->where('bed', $bed_id);
		$this->db->update('bed', $data);
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
				where kelas = '$kelas' and id_tindakan like '1A%'
				AND SUBSTR(id_tindakan FROM 3 FOR 4) = '$idrg'");
		return $data->result_array();
	}

	public  function get_jml_ruang_kosong_isi_reservasi(){
		// $data=$this->db->query("
		// 	select d.*, e.nmruang from (
		// 	select b.idrg,b.total_isi,b.total_kosong,SUM(case c.statusantrian when 'N' then 1 else 0 end) as total_reservasi,SUM(case c.batal when 'Y' then 1 else 0 end) as total_batal
		// 	from(
		// 		select a.idrg,SUM(case a.isi when 'N' then 1 else 0 end) as total_kosong, SUM(case a.isi when 'Y' then 1 else 0 end) as total_isi
		// 		from bed as a
		// 		GROUP BY a.idrg
		// 		ORDER BY a.idrg ASC
		// 	) as b LEFT JOIN irna_antrian as c on b.idrg = c.ruangpilih
		// 	GROUP BY b.idrg,b.total_isi,b.total_kosong
		// 	) as d LEFT JOIN ruang as e on d.idrg = e.idrg
		// 	");

		// $data=$this->db->query("
		// 	select d.*, e.nmruang from (
		// 	select b.kelas,b.idrg,b.total_isi,b.total_kosong,SUM(case c.statusantrian when 'N' then 1 else 0 end) as total_reservasi,SUM(case c.batal when 'Y' then 1 else 0 end) as total_batal
		// 	from(
		// 		select a.kelas,a.idrg,SUM(case a.isi when 'N' then 1 else 0 end) as total_kosong, SUM(case a.isi when 'Y' then 1 else 0 end) as total_isi
		// 		from bed as a
		// 		GROUP BY a.idrg,a.kelas
		// 		ORDER BY a.idrg ASC
		// 	) as b LEFT JOIN irna_antrian as c on b.idrg = c.ruangpilih
		// 	GROUP BY b.idrg,b.total_isi,b.total_kosong
		// 	) as d LEFT JOIN ruang as e on d.idrg = e.idrg
		// 	");

		$data=$this->db->query("
			select d.*, e.nmruang from (
			select b.idrg,b.total_isi,b.total_kosong,SUM(case c.statusantrian when 'N' then 1 else 0 end) as total_reservasi,SUM(case c.batal when 'Y' then 1 else 0 end) as total_batal
			from(
				select a.idrg,SUM(case a.isi when 'N' then 1 else 0 end) as total_kosong, SUM(case a.isi when 'Y' then 1 else 0 end) as total_isi
				from bed as a
				GROUP BY a.idrg
				ORDER BY a.idrg ASC
			) as b LEFT JOIN irna_antrian as c on b.idrg = c.ruangpilih
			GROUP BY b.idrg,b.total_isi,b.total_kosong
			) as d LEFT JOIN ruang as e on d.idrg = e.idrg
			ORDER BY idrg asc
			");
		return $data->result_array();
	}

	

}
?>
