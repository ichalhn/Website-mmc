<?php
class Rimdaftar extends CI_Model {

	public function get_irna_antrian_all(){
		$data=$this->db->query(
			"SELECT 
					    a.*, b.*, c.*, d.tgl_keluar
					FROM
					    irna_antrian AS a
					        INNER JOIN
					    data_pasien AS b ON a.no_cm = b.no_medrec
					        INNER JOIN
					    ruang AS c ON a.ruangpilih = c.idrg
					    LEFT JOIN
						pasien_iri d ON a.no_register_asal=d.no_ipd
					WHERE
					    a.batal = 'N' AND a.statusantrian = 'N'
					    AND d.tgl_keluar is null
					ORDER BY noreservasi ASC
			");
		return $data->result_array();
	} // AND (c.lokasi != 'Ruang Bersalin' or c.lokasi != 'Anyelir')

	public function get_irna_antrian_vk_all(){
		$data=$this->db->query(
			"SELECT 
					    a.*, b.*, c.*, d.tgl_keluar
					FROM
					    irna_antrian AS a
					        INNER JOIN
					    data_pasien AS b ON a.no_cm = b.no_medrec
					        INNER JOIN
					    ruang AS c ON a.ruangpilih = c.idrg
					    LEFT JOIN
						pasien_iri d ON a.no_register_asal=d.no_ipd
					WHERE
					    a.batal = 'N' AND a.statusantrian = 'N'
						AND (c.lokasi = 'Ruang Bersalin' or c.lokasi = 'Anyelir')
					    AND d.tgl_keluar is null
					ORDER BY noreservasi ASC
			");
		return $data->result_array();
	}

	// moris up

	public function select_irna_antrian_all($kode_ruang, $kelas){
		if($kode_ruang=='-' && $kelas!='-'){
			$data=$this->db->query(
			"select *from irna_antrian
			where kelas='$kelas' and batal='N' and statusantrian='N'");
		}else if($kode_ruang!='-' && $kelas=='-'){
			$data=$this->db->query(
			"select *from irna_antrian
			where ruangpilih='$kode_ruang' and batal='N' and statusantrian='N'");
		}else if($kode_ruang!='-' && $kelas!='-'){
			$data=$this->db->query(
			"select *from irna_antrian
			where ruangpilih='$kode_ruang' and kelas='$kelas' and batal='N' and statusantrian='N'");
		}else{
			$data=$this->db->query(
			"select *from irna_antrian
			where batal='N' and statusantrian='N'");
		}
		return $data->result_array();
	}
	public function select_pasien_irj_by_no_register_asal($no_register_asal){
		$data=$this->db->query("select * from pasien_irj where no_reg='$no_register_asal'");
		return $data->result_array();
	}
	public function select_pasien_ird_by_no_register_asal($no_register_asal){
		$data=$this->db->query("select * from pasien_ird where no_reg='$no_register_asal'");
		return $data->result_array();
	}
	public function select_ruang_like($value){
		$data=$this->db->query("select * from ruang where idrg like '%$value%' order by idrg asc");
		return $data->result_array();
	}
	public function update_reservasi($noreservasi, $data){
		$this->db->where('noreservasi', $noreservasi);
		$this->db->update('irna_antrian', $data);
	}

	public function get_antrian_by_no_reservasi($noreservasi){
		$data=$this->db->query("select * from irna_antrian where noreservasi = '$noreservasi' ");
		return $data->result_array();
	}

	public function get_noregasal($noreservasi){
		return $this->db->query("select no_register_asal from irna_antrian where noreservasi = '$noreservasi' ");
	}

	public function update_mutasi($no_ipd){
		return $this->db->query("UPDATE pasien_iri SET mutasi=0 WHERE no_ipd = '$no_ipd' ");
	}
	
}
?>
