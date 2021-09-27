<?php
class rimdaftar extends CI_Model {
	public function select_irna_antrian_all($kode_ruang, $kelas){
		if($kode_ruang=='-' && $kelas!='-'){
			$data=$this->db->query(
			"select irna_antrian.noreservasi, irna_antrian.no_cm, irna_antrian.no_register_asal, tglrencanamasuk.nama, irna_antrian.ruangpilih, irna_antrian.kelas, irna_antrian.infeksi, irna_antrian.hp, irna_antrian.prioritas, irna_antrian.tglrencanamasuk
			from irna_antrian left join pasien_irj on irna_antrian.no_register_asal=pasien_irj.no_reg
			where irna_antrian.kelas='$kelas' and irna_antrian.batal='N' and irna_antrian.statusantrian='N'");
		}else if($kode_ruang!='-' && $kelas=='-'){
			$data=$this->db->query(
			"select irna_antrian.noreservasi, irna_antrian.no_cm, irna_antrian.no_register_asal, pasien_irj.nama, irna_antrian.ruangpilih, irna_antrian.kelas, irna_antrian.infeksi, irna_antrian.hp, irna_antrian.prioritas, irna_antrian.tglrencanamasuk
			from irna_antrian left join pasien_irj on irna_antrian.no_register_asal=pasien_irj.no_reg
			where irna_antrian.ruangpilih='$kode_ruang' and irna_antrian.batal='N' and irna_antrian.statusantrian='N'");
		}else if($kode_ruang!='-' && $kelas!='-'){
			$data=$this->db->query(
			"select irna_antrian.noreservasi, irna_antrian.no_cm, irna_antrian.no_register_asal, pasien_irj.nama, irna_antrian.ruangpilih, irna_antrian.kelas, irna_antrian.infeksi, irna_antrian.hp, irna_antrian.prioritas, irna_antrian.tglrencanamasuk
			from irna_antrian left join pasien_irj on irna_antrian.no_register_asal=pasien_irj.no_reg
			where irna_antrian.ruangpilih='$kode_ruang' and irna_antrian.kelas='$kelas' and irna_antrian.batal='N' and irna_antrian.statusantrian='N'");
		}else{
			$data=$this->db->query(
			"select irna_antrian.noreservasi, irna_antrian.no_cm, irna_antrian.no_register_asal, pasien_irj.nama, irna_antrian.ruangpilih, irna_antrian.kelas, irna_antrian.infeksi, irna_antrian.hp, irna_antrian.prioritas, irna_antrian.tglrencanamasuk
			from irna_antrian left join pasien_irj on irna_antrian.no_register_asal=pasien_irj.no_reg
			where irna_antrian.batal='N' and irna_antrian.statusantrian='N'");
		}
		return $data->result_array();
	}
	public function select_irna_antrian_order($column, $sort, $start, $length, $kode_ruang, $kelas){
		if($kode_ruang=='-' && $kelas!='-'){
			$data=$this->db->query(
			"select irna_antrian.noreservasi, irna_antrian.no_cm, irna_antrian.no_register_asal, pasien_irj.nama, irna_antrian.ruangpilih, irna_antrian.kelas, irna_antrian.infeksi, irna_antrian.hp, irna_antrian.prioritas, irna_antrian.tglrencanamasuk
			from irna_antrian left join pasien_irj on irna_antrian.no_register_asal=pasien_irj.no_reg
			where kelas='$kelas' and batal='N' and statusantrian='N'
			order by $column $sort limit $start, $length");
		}else if($kode_ruang!='-' && $kelas=='-'){
			$data=$this->db->query(
			"select irna_antrian.noreservasi, irna_antrian.no_cm, irna_antrian.no_register_asal, pasien_irj.nama, irna_antrian.ruangpilih, irna_antrian.kelas, irna_antrian.infeksi, irna_antrian.hp, irna_antrian.prioritas, irna_antrian.tglrencanamasuk
			from irna_antrian left join pasien_irj on irna_antrian.no_register_asal=pasien_irj.no_reg
			where ruangpilih='$kode_ruang' and batal='N' and statusantrian='N'
			order by $column $sort limit $start, $length");
		}else if($kode_ruang!='-' && $kelas!='-'){
			$data=$this->db->query(
			"select irna_antrian.noreservasi, irna_antrian.no_cm, irna_antrian.no_register_asal, pasien_irj.nama, irna_antrian.ruangpilih, irna_antrian.kelas, irna_antrian.infeksi, irna_antrian.hp, irna_antrian.prioritas, irna_antrian.tglrencanamasuk
			from irna_antrian left join pasien_irj on irna_antrian.no_register_asal=pasien_irj.no_reg
			where ruangpilih='$kode_ruang' and kelas='$kelas' and batal='N' and statusantrian='N'
			order by $column $sort limit $start, $length");
		}else{
			$data=$this->db->query(
			"select irna_antrian.noreservasi, irna_antrian.no_cm, irna_antrian.no_register_asal, pasien_irj.nama, irna_antrian.ruangpilih, irna_antrian.kelas, irna_antrian.infeksi, irna_antrian.hp, irna_antrian.prioritas, irna_antrian.tglrencanamasuk
			from irna_antrian left join pasien_irj on irna_antrian.no_register_asal=pasien_irj.no_reg
			where batal='N' and statusantrian='N'
			order by $column $sort limit $start, $length");
		}
		return $data->result_array();
	}
	public function select_irna_antrian_search($column, $sort, $start, $length, $value, $kode_ruang, $kelas){
		if($kode_ruang=='-' && $kelas!='-'){
			$data=$this->db->query(
			"select irna_antrian.noreservasi, irna_antrian.no_cm, irna_antrian.no_register_asal, pasien_irj.nama as nama_irj, irna_antrian.ruangpilih, irna_antrian.kelas, irna_antrian.infeksi, irna_antrian.hp, irna_antrian.prioritas, irna_antrian.tglrencanamasuk
			from irna_antrian left join pasien_irj on irna_antrian.no_register_asal=pasien_irj.no_reg
			where irna_antrian.noreservasi like '%$value%' or irna_antrian.no_cm like '%$value%' or irna_antrian.no_register_asal like '%$value%' or irna_antrian.hp like '%$value%' or irna_antrian.prioritas like '%$value%' or irna_antrian.tglrencanamasuk like '%$value%' and irna_antrian.kelas='$kelas' and irna_antrian.batal='N' and irna_antrian.statusantrian='N'
			order by $column $sort limit $start, $length");
		}else if($kode_ruang!='-' && $kelas=='-'){
			$data=$this->db->query(
			"select irna_antrian.noreservasi, irna_antrian.no_cm, irna_antrian.no_register_asal, pasien_irj.nama as nama_irj, irna_antrian.ruangpilih, irna_antrian.kelas, irna_antrian.infeksi, irna_antrian.hp, irna_antrian.prioritas, irna_antrian.tglrencanamasuk
			from irna_antrian left join pasien_irj on irna_antrian.no_register_asal=pasien_irj.no_reg
			where irna_antrian.noreservasi like '%$value%' or irna_antrian.no_cm like '%$value%' or irna_antrian.no_register_asal like '%$value%' or irna_antrian.hp like '%$value%' or irna_antrian.prioritas like '%$value%' or irna_antrian.tglrencanamasuk like '%$value%' and irna_antrian.ruangpilih='$kode_ruang' and irna_antrian.batal='N' and irna_antrian.statusantrian='N'
			order by $column $sort limit $start, $length");
		}else if($kode_ruang!='-' && $kelas!='-'){
			$data=$this->db->query(
			"select irna_antrian.noreservasi, irna_antrian.no_cm, irna_antrian.no_register_asal, pasien_irj.nama as nama_irj, irna_antrian.ruangpilih, irna_antrian.kelas, irna_antrian.infeksi, irna_antrian.hp, irna_antrian.prioritas, irna_antrian.tglrencanamasuk
			from irna_antrian left join pasien_irj on irna_antrian.no_register_asal=pasien_irj.no_reg
			where irna_antrian.noreservasi like '%$value%' or irna_antrian.no_cm like '%$value%' or irna_antrian.no_register_asal like '%$value%' or irna_antrian.hp like '%$value%' or irna_antrian.prioritas like '%$value%' or irna_antrian.tglrencanamasuk like '%$value%' and irna_antrian.ruangpilih='$kode_ruang' and irna_antrian.kelas='$kelas' and irna_antrian.batal='N' and irna_antrian.statusantrian='N'
			order by $column $sort limit $start, $length");
		}else{
			$data=$this->db->query(
			"select irna_antrian.noreservasi, irna_antrian.no_cm, irna_antrian.no_register_asal, pasien_irj.nama as nama_irj, irna_antrian.ruangpilih, irna_antrian.kelas, irna_antrian.infeksi, irna_antrian.hp, irna_antrian.prioritas, irna_antrian.tglrencanamasuk
			from irna_antrian left join pasien_irj on irna_antrian.no_register_asal=pasien_irj.no_reg
			where irna_antrian.noreservasi like '%$value%' or irna_antrian.no_cm like '%$value%' or irna_antrian.no_register_asal like '%$value%' or irna_antrian.hp like '%$value%' or irna_antrian.prioritas like '%$value%' or irna_antrian.tglrencanamasuk like '%$value%' and irna_antrian.batal='N' and irna_antrian.statusantrian='N'
			order by $column $sort limit $start, $length");
		}
		return $data->result_array();
	}
	public function update_reservasi($noreservasi, $data){
		$this->db->where('noreservasi', $noreservasi);
		$this->db->update('irna_antrian', $data);
	}
	public function select_pasien_irj_by_no_register_asal($no_register_asal){
		$data=$this->db->query("select *from pasien_irj where no_reg='$no_register_asal'");
		return $data->result_array();
	}
	public function select_ruang_like($value){
		$data=$this->db->query("select *from ruang where idrg like '%$value%' order by idrg asc");
		return $data->result_array();
	}
}
?>
