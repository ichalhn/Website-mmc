<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class ModelPelayanan extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		function get_pasien(){
			return $this->db->query("SELECT * FROM irddaftar_ulang");
		}
		function get_pasien_daftar_today(){
			return $this->db->query("SELECT *, A.nama
FROM irddaftar_ulang du, data_pasien A
where du.no_medrec=A.no_medrec 
and left(du.tgl_kunjungan,10) = left(now(),10) and du.status='0' order by du.tgl_kunjungan  asc
");
		}
		function get_pasien_daftar_by_nocm($id_poli,$no_medrec){
			return $this->db->query("SELECT * FROM irddaftar_ulang, data_pasien where  irddaftar_ulang.no_medrec=data_pasien.no_medrec and data_pasien.no_medrec='$no_medrec' and irddaftar_ulang.status='0'");
		}
		function get_pasien_daftar_by_noregister($id_poli,$no_register){
			return $this->db->query("SELECT * FROM irddaftar_ulang, data_pasien where  irddaftar_ulang.no_medrec=data_pasien.no_medrec  and irddaftar_ulang.no_register='$no_register' and irddaftar_ulang.status='0'");
		}
		function get_pasien_daftar_by_date($date){
			return $this->db->query("SELECT * FROM irddaftar_ulang du, data_pasien A
where  du.no_medrec=A.no_medrec 
and left(du.tgl_kunjungan,10)  = '$date' 
and du.status='0' order by du.tgl_kunjungan  asc");
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
			return $this->db->query("SELECT A.*, B.idtindakan, B.nmtindakan, (SELECT C.nm_dokter from data_dokter C WHERE A.id_dokter=C.id_dokter) as nm_dokter FROM tindakan_ird A, jenis_tindakan B where A.no_register='$no_register' and A.idtindakan=B.idtindakan order by id_tindakan_ird desc");
		}
		function getdata_diagnosa_pasien($no_register){
			return $this->db->query("SELECT * FROM diagnosa_ird where no_register='$no_register' order by xupdate desc");
		}
		function getdata_resep_pasien($no_register){
			$no_resep=$this->db->query("select max(no_resep) as no_resep from resep_header where no_resgister='$no_register'");
			if($no_resep->row()->no_resep!=''){
				$no_rsp=$no_resep->row()->no_resep;
				return $this->db->query("SELECT * FROM resep_pasien where no_register='$no_register' and no_resep='$no_rsp'");
			}else
				return $no_resep;
			
		}
		
		function getdata_lab_pasien($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_laboratorium as a
				WHERE a.no_register = '$no_register'
				AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))
				order by xupdate asc");
		}
		
		function getcetak_lab_pasien($no_register){
			return $this->db->query("SELECT no_lab FROM pemeriksaan_laboratorium as a
				WHERE a.no_register = '$no_register'
				and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
				and a.cetak_hasil='1'
				group by no_lab
				order by no_lab asc
			");
		}
		
		function getdata_pa_pasien($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_patologianatomi as a
				WHERE a.no_register = '$no_register'
				AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))
				order by xupdate asc");
		}
		
		function getcetak_pa_pasien($no_register){
			return $this->db->query("SELECT no_pa FROM pemeriksaan_patologianatomi as a
				WHERE a.no_register = '$no_register'
				and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
				and a.cetak_hasil='1'
				group by no_pa
				order by no_pa asc
			");
		}
		
		function getdata_rad_pasien($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi as a
				WHERE a.no_register = '$no_register'
				AND ((a.cetak_kwitansi='1' AND a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' AND a.cara_bayar<>'UMUM'))
				order by xupdate asc");
		}
		
		function getcetak_rad_pasien($no_register){
			return $this->db->query("SELECT no_rad FROM pemeriksaan_radiologi as a
				WHERE a.no_register = '$no_register'
				and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
				and a.cetak_hasil='1'
				group by no_rad
				order by no_rad asc
			");
		}
		
		function getdata_ok_pasien($no_register){
			return $this->db->query("SELECT COALESCE(no_ok, 'On Progress') AS no_ok, id_pemeriksaan_ok, id_tindakan, jenis_tindakan, id_dokter, id_opr_anes, id_dok_anes, jns_anes, id_dok_anak, tgl_operasi, vtot, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter) as nm_dokter, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_opr_anes) as nm_opr_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anes) as nm_dok_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anak) as nm_dok_anak 
				FROM pemeriksaan_operasi WHERE no_register='$no_register'");
		}

		function get_no_resep($id_resep){
			return $this->db->query("SELECT no_resep FROM resep_pasien where id_resep_pasien='$id_resep'");
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
		//////////////////////////////////////////////////////////////////////14.946 + 1.276 = 16.422
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
			return $this->db->query("SELECT ok, lab, pa, rad, obat, status_ok, status_lab, status_pa, status_rad, status_obat FROM irddaftar_ulang where no_register='$no_register'");
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
			return $this->db->query("SELECT A.id_tindakan, A.total_tarif, A.kelas, B.idtindakan, B.nmtindakan, B.idpok1  FROM tarif_tindakan A, jenis_tindakan_ird B WHERE A.id_tindakan=B.idtindakan AND A.kelas='$kelas' order by idtindakan asc");
		}
		function get_data_operator(){
			return $this->db->query("SELECT * FROM operator order by id_dokter asc");
		}
		function get_data_dokter(){
			return $this->db->query("SELECT * FROM data_dokter order by nm_dokter");
		}
		function getdata_dokter_lab(){
			return $this->db->query("SELECT * FROM data_dokter where id_dokter='355'");
		}
		function getdata_dokter_pa(){
			return $this->db->query("SELECT * FROM data_dokter where id_dokter='357'");
		}
		function getdata_dokter_rad(){
			return $this->db->query("SELECT * FROM data_dokter where id_dokter='356'");
		}
		function getdata_biaya_idtindakan($id){
			return $this->db->query("SELECT * FROM tarif_tindakan where idtindakan='$id'");
		}
		function get_biaya_tindakan($id,$kelas){
			return $this->db->query("SELECT total_tarif, tarif_alkes FROM tarif_tindakan WHERE id_tindakan='".$id."' AND kelas = '".$kelas."'");
		}
		function cek_lab_resep_rad_ok($no_register){
			return $this->db->query("SELECT COALESCE(lab, 0) AS lab, COALESCE(pa, 0) AS pa, COALESCE(rad, 0) AS rad, COALESCE(ok, 0) AS ok, COALESCE(status_lab, 0) AS status_lab, COALESCE(status_pa, 0) AS status_pa, 
										COALESCE(obat, 0) AS obat, COALESCE(status_obat, 0) AS status_obat, COALESCE(status_rad, 0) AS status_rad, COALESCE(status_ok, 0) AS status_ok
										FROM 	irddaftar_ulang
										WHERE no_register='$no_register'");
		}
		function getdata_tindakan_fisik($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_fisik where no_register='".$no_register."'");
		}
		function insert_data_fisik($data){
			$this->db->insert('pemeriksaan_fisik', $data);
			return true;
		}
	}
?>
