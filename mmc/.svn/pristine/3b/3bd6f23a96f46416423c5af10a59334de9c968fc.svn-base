<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class ModelMedrec extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		function get_pasien(){
			return $this->db->query("SELECT * FROM irddaftar_ulang");
		}
		function get_pasien_pulang($tgl_kunj,$ceklist_diag){
		
			$select_tgl="";
			if ($tgl_kunj!='') {
				$select_tgl=" AND LEFT(du.tgl_kunjungan,10)='$tgl_kunj'";
			}else{
				$select_tgl=" AND LEFT(du.tgl_kunjungan,10)>=DATE(DATE_SUB(NOW(), INTERVAL 7 DAY))";
			}
			
			if ($ceklist_diag!='') {
				$query="SELECT a.* FROM (
							SELECT du.no_register, du.tgl_kunjungan, dpa.nama, dpa.no_cm as no_medrec,
							(SELECT CONCAT_WS(' - ',id_diagnosa,diagnosa) as diagnosa
							FROM diagnosa_ird AS dp 
							WHERE dp.klasifikasi_diagnos='utama' AND dp.no_register=du.no_register) AS diag_utama
						FROM irddaftar_ulang AS du 
						LEFT JOIN data_pasien AS dpa ON du.no_medrec=dpa.no_medrec 
						WHERE du.status='1' $select_tgl
						ORDER BY tgl_kunjungan DESC
						) AS a WHERE diag_utama is NULL";
			} else {
				$query="SELECT du.no_register, du.tgl_kunjungan, dpa.nama, dpa.no_cm as no_medrec,
							(SELECT CONCAT_WS(' - ',id_diagnosa,diagnosa) as diagnosa 
							FROM diagnosa_ird AS dp 
							WHERE dp.klasifikasi_diagnos='utama' AND dp.no_register=du.no_register) AS diag_utama	
						FROM irddaftar_ulang AS du 
						LEFT JOIN data_pasien AS dpa ON du.no_medrec=dpa.no_medrec
						WHERE du.status='1' $select_tgl ORDER BY tgl_kunjungan DESC";
			}
									
			return $this->db->query($query);
		}
		function get_pasien_daftar_by_nocm($id_poli,$no_medrec){
			return $this->db->query("SELECT * FROM irddaftar_ulang, data_pasien where  irddaftar_ulang.no_medrec=data_pasien.no_medrec and data_pasien.no_medrec='$no_medrec' and irddaftar_ulang.status='0'");
		}
		function get_pasien_daftar_by_noregister($id_poli,$no_register){
			return $this->db->query("SELECT * FROM irddaftar_ulang, data_pasien where  irddaftar_ulang.no_medrec=data_pasien.no_medrec  and irddaftar_ulang.no_register='$no_register' and irddaftar_ulang.status='0'");
		}
		function get_pasien_daftar_by_date($date){
			return $this->db->query("SELECT * FROM irddaftar_ulang, data_pasien where  irddaftar_ulang.no_medrec=data_pasien.no_medrec and left(irddaftar_ulang.tgl_kunjungan,10) = '$date' and irddaftar_ulang.status='0'");
		}
		function cek_diagnosa_utama($no_register){
			return $this->db->query("SELECT * FROM diagnosa_ird WHERE klasifikasi_diagnos='utama' AND no_register='".$no_register."'");
		}
		////////////////////////////////////////////////////////////////
		function update_status_selesai($no_register){
			$this->db->query("update irddaftar_ulang set status='1' where no_register='$no_register'");
			return true;
		}
		function update_lab($no_register){
			$this->db->query("update irddaftar_ulang set lab='1', status_lab='1' where no_register='$no_register'");
			return true;
		}
		function update_status_batal($no_register){
			$this->db->query("update irddaftar_ulang set status='C' where no_register='$no_register'");
			return true;
		}
		function update_vtot_daful($no_register,$vtot){
			$this->db->query("update irddaftar_ulang set vtot='$vtot' where no_register='$no_register'");
			return true;
		}
		///////////////////////////////////////////////////////////////////////
		function getdata_daftar_ulang_pasien($no_register){
			return $this->db->query("SELECT * FROM irddaftar_ulang,data_pasien where irddaftar_ulang.no_medrec=data_pasien.no_medrec and irddaftar_ulang.no_register='$no_register'");
		}
		function getdata_tindakan_pasien($no_register){
			return $this->db->query("SELECT A.*, B.idtindakan, B.nmtindakan, C.id_dokter, C.nm_dokter FROM tindakan_ird A,  jenis_tindakan B, data_dokter C where no_register='$no_register' and A.idtindakan=B.idtindakan and A.id_dokter=C.id_dokter order by id_tindakan_ird desc");
		}
		function getdata_diagnosa_pasien($no_register){
			return $this->db->query("SELECT * FROM diagnosa_ird where no_register='$no_register' order by xupdate desc");
		}
		function getdata_resep_pasien($no_register){
			return $this->db->query("SELECT * FROM resep_irj where no_register='$no_register' order by xupdate desc");
		}
		//////////////////////////////////////////////////////////////////////////////
		function insert_pelayanan_tindakan($data){
			$this->db->insert('tindakan_ird', $data);
			return $this->db->insert_id();
		}
		function update_pelayanan_poli($data,$id_pelayanan_poli){
			$this->db->where('id_pelayanan_poli', $id_pelayanan_poli);
			$this->db->update('pelayanan_poli', $data);
			return true;
		}
		function insert_pelayanan_diagnosa($data){
			$this->db->insert('diagnosa_ird', $data);
			return $this->db->insert_id();
		}
		function update_pelayanan_diagnosa($data,$id_diagnosa_pasien){
			$this->db->where('id_diagnosa_pasien', $id_diagnosa_pasien);
			$this->db->update('diagnosa_pasien', $data);
			return true;
		}
		function insert_pelayanan_resep($data){
			$this->db->insert('resep_irj', $data);
			return $this->db->insert_id();
		}
		function update_pelayanan_resep($data,$id_resep_irj){
			$this->db->where('id_resep_irj', $id_resep_irj);
			$this->db->update('resep_irj', $data);
			return true;
		}
		function update_rujukan_penunjang($data,$no_register){
			$this->db->where('no_register', $no_register);
			$this->db->update('irddaftar_ulang', $data);
			return true;
		}
		//////////////////////////////////////////////////////////////////////
		function hapus_antrian($no_register){
			$this->db->where('no_register', $no_register);
       			$this->db->delete('irddaftar_ulang');			
			return true;
		}		
		function hapus_tindakan($id_tindakan_ird){
			$this->db->where('id_tindakan_ird', $id_tindakan_ird);
       			$this->db->delete('tindakan_ird');			
			return true;
		}
		function hapus_diagnosa($id_diagnosa_pasien){
			$this->db->where('id_diagnosa_pasien', $id_diagnosa_pasien);
       			$this->db->delete('diagnosa_ird');			
			return true;
		}
		//////////////////////////////////////////////////////////////////////
		function update_pulang($data,$no_register){
			$this->db->where('no_register', $no_register);
			$this->db->update('irddaftar_ulang', $data);
			return true;
		}
		//////////////////////////////////////////////////////////////////////
		function get_vtot_daful($no_register){
			return $this->db->query("SELECT vtot FROM irddaftar_ulang where no_register='$no_register'");
		}
		
		function get_vtot_tindakan($id_tindakan_ird){
			return $this->db->query("SELECT vtot FROM tindakan_ird where id_tindakan_ird='$id_tindakan_ird'");
		}
		function get_rujukan_penunjang($no_register){
			return $this->db->query("SELECT lab, rad, obat, ok, status_lab, status_obat, status_ok FROM irddaftar_ulang where no_register='$no_register'");
		}		
		function get_nm_poli($id_poli){
			return $this->db->query("SELECT nm_poli FROM poliklinik where id_poli='$id_poli'");
		}
		function get_no_medrec_tindakan($id_tindakan_ird){
			return $this->db->query("SELECT no_medrec FROM irddaftar_ulang where id_tindakan_ird='$id_tindakan_ird'");
		}
		function get_no_register_tindakan($id_tindakan_ird){
			return $this->db->query("SELECT no_register FROM tindakan_ird where id_tindakan_ird='$id_tindakan_ird'");
		}
		function get_no_register_diagnosa($id_diagnosa_pasien){
			return $this->db->query("SELECT no_register FROM diagnosa_ird where id_diagnosa_pasien='$id_diagnosa_pasien'");
		}
		function get_nm_diagnosa($id_icd){
			return $this->db->query("SELECT nm_diagnosa FROM icd1 where id_icd='$id_icd'");
		}
		function getdata_jenis_tindakan($kelas){
			return $this->db->query("SELECT A.id_tindakan, A.kelas, B.idtindakan, B.nmtindakan, B.idpok1  FROM tarif_tindakan A, jenis_tindakan B WHERE B.idpok1='C' AND A.id_tindakan=B.idtindakan AND A.kelas='$kelas' order by nmtindakan asc");
		}
		function get_data_operator(){
			return $this->db->query("SELECT * FROM operator order by id_dokter asc");
		}
		function get_data_dokter(){
			return $this->db->query("SELECT * FROM data_dokter order by id_dokter asc");
		}
		function getdata_biaya_idtindakan($id){
			return $this->db->query("SELECT * FROM tarif_tindakan where idtindakan='$id'");
		}
		function get_biaya_tindakan($id,$kelas){
			return $this->db->query("SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan='".$id."' AND kelas = '".$kelas."'");
		}
		function cek_lab_resep($no_register){
			return $this->db->query("SELECT COALESCE(lab, 0) AS lab, COALESCE(status_lab, 0) AS status_lab, 
										COALESCE(obat, 0) AS obat, COALESCE(status_obat, 0) AS status_obat
										FROM 	irddaftar_ulang
										WHERE no_register='$no_register'");
		}
	}
?>
