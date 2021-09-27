<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class ModelKwitansi extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		function get_pasien_kwitansi(){
			return $this->db->query("SELECT A.`status`, A.no_medrec, A.no_register,  A.cara_bayar,  B.no_cm, A.tgl_kunjungan, B.nama FROM irddaftar_ulang A, data_pasien B where   A.status='1' and A.cetak_kwitansi='0' and A.no_medrec=B.no_medrec order by A.tgl_kunjungan desc");
		}
		function get_pasien_kwitansi_by_nocm($no_medrec){
			return $this->db->query("SELECT * FROM daftar_ulang_irj, data_pasien, poliklinik where cetak_kwitansi='0' and daftar_ulang_irj.status='1' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec and poliklinik.id_poli=daftar_ulang_irj.id_poli and data_pasien.no_medrec='$no_medrec' order by daftar_ulang_irj.xupdate desc");
		}
		function get_pasien_kwitansi_by_noregister($no_register){
			return $this->db->query("SELECT * FROM daftar_ulang_irj, data_pasien, poliklinik where cetak_kwitansi='0' and daftar_ulang_irj.status='1' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec and poliklinik.id_poli=daftar_ulang_irj.id_poli and daftar_ulang_irj.no_register='$no_register' order by daftar_ulang_irj.xupdate desc");
		}
		function get_pasien_kwitansi_by_date($date){
			return $this->db->query("SELECT A.`status`, A.no_medrec, A.no_register, A.cara_bayar, A.tgl_kunjungan, B.no_cm, B.nama FROM irddaftar_ulang A, data_pasien B where   A.status='1' and A.cetak_kwitansi='0' and A.no_medrec=B.no_medrec and left(A.tgl_kunjungan,10)='$date' order by A.tgl_kunjungan desc");
		}
		/////////////////////////////////////////////////////////////////////////////////////kwitansi semua
		function getdata_pasien($no_register){
			return $this->db->query("SELECT A.tgl_kunjungan, A.no_medrec, A.no_register, B.nama, B.alamat, A.cara_bayar,B.no_cm, A.kelas_pasien FROM irddaftar_ulang A, data_pasien B where A.no_medrec=B.no_medrec and A.no_register='$no_register'");
		}
		function getdata_tindakan_pasien($no_register){
			return $this->db->query("SELECT A.id_tindakan_ird, A.no_register, A.tgl_kunjungan, A.idtindakan,  A.biaya_ird, B.nmtindakan, A.qty, A.vtot FROM tindakan_ird A, jenis_tindakan B where no_register='$no_register' and A.idtindakan=B.idtindakan");
		}
		function getdata_lab_pasien($no_register){
			return $this->db->query("SELECT A.no_lab, A.no_register, B.id_tindakan, 
B.biaya_lab, B.jenis_tindakan, B.qty, B.vtot 
FROM lab_header A, pemeriksaan_laboratorium B
where A.no_register='$no_register' 
and A.no_lab=B.no_lab");
		}
		function getdata_pa_pasien($no_register){
			return $this->db->query("SELECT A.no_pa, A.no_register, B.id_tindakan, 
B.biaya_pa, B.jenis_tindakan, B.qty, B.vtot 
FROM pa_header A, pemeriksaan_patologianatomi B
where A.no_register='$no_register' 
and A.no_pa=B.no_pa");
		}
		function getdata_ok_pasien($no_register){
			return $this->db->query("SELECT A.no_ok, A.no_register, B.id_tindakan, 
B.biaya_ok, B.jenis_tindakan, B.qty, B.vtot 
FROM ok_header A, pemeriksaan_operasi B
where A.no_register='$no_register' 
and A.no_ok=B.no_ok");
		}
		function getdata_rad_pasien($no_register){
			return $this->db->query("SELECT A.no_rad, A.no_register, B.id_tindakan, 
B.biaya_rad, B.jenis_tindakan, B.qty, B.vtot 
FROM rad_header A, pemeriksaan_radiologi B
where A.no_register='$no_register'
and A.no_rad=B.no_rad");
		}
		function getdata_resep_pasien($no_register){
			return $this->db->query("SELECT A.no_resep, A.no_resgister, B.item_obat, 
B.biaya_obat, B.nama_obat, B.qty, B.vtot 
FROM resep_header A, resep_pasien B
where A.no_resgister='$no_register'
and A.no_resep=B.no_resep");
		}
		function get_vtot($no_register){
			return $this->db->query("SELECT vtot, vtot_lab, vtot_rad, vtot_obat, vtot_pa, vtot_ok FROM irddaftar_ulang WHERE no_register='$no_register'");
		}
		/////////////////////////////////////////////////////////////////////////////////
		function get_new_kwkt($no_register){
			return $this->db->query("select max(right(nokwitansi_kt,6)) as counter, mid(now(),3,2) as year from daftar_ulang_irj where mid(nokwitansi_kt,3,2) = (select mid(now(),3,2)) and no_register not like '$no_register'");
		}
		function update_kwkt($nokwitansi_kt,$no_register){
			$this->db->query("update daftar_ulang_irj set nokwitansi_kt='$nokwitansi_kt', tglcetak_kwitansi=now() where no_register='$no_register'");
			return true;
		}
		function getdata_tgl_kw($no_register){
			return $this->db->query("select date_format(tglcetak_kwitansi, '%d-%m-%Y %h:%m:%s') as tglcetak_kwitansi, date_format(tglcetak_kwitansi, '%d-%m-%Y') as tgl_kwitansi  from daftar_ulang_irj where no_register='$no_register'");
		}
		/////////////////////////////////////////////////////////////////////////////////////kwitansi tindakan
		function get_new_kwkk($id_pelayanan_poli){
			return $this->db->query("select max(right(nokwitansi_kk,6)) as counter, mid(now(),3,2) as year from pelayanan_poli where mid(nokwitansi_kk,3,2) = (select mid(now(),3,2)) and id_pelayanan_poli not like '$id_pelayanan_poli'");
		}
		function update_kwkk($nokwitansi_kk,$id_pelayanan_poli){
			$this->db->query("update pelayanan_poli set nokwitansi_kk='$nokwitansi_kk', tglcetak_kwitansi=now() where id_pelayanan_poli=$id_pelayanan_poli");
			return true;
		}
		
		function update_jenis_bayar($no_register,$jenis_bayar){
			$this->db->query("update irddaftar_ulang set nokwitansi_kk='$jenis_bayar' where no_register=$no_register");
			return true;
		}
		function getdata_tgl_kk($id_pelayanan_poli){
			return $this->db->query("select date_format(tglcetak_kwitansi, '%d-%m-%Y %h:%m:%s') as tglcetak_kwitansi, date_format(tglcetak_kwitansi, '%d-%m-%Y') as tgl_kwitansi from pelayanan_poli where id_pelayanan_poli='$id_pelayanan_poli'");
		}
		function getdata_kwitansikk($id_pelayanan_poli){
			return $this->db->query("select * from daftar_ulang_irj, pelayanan_poli, operator, data_pasien, poliklinik where pelayanan_poli.id_pelayanan_poli=$id_pelayanan_poli and  daftar_ulang_irj.no_medrec=data_pasien.no_medrec and daftar_ulang_irj.no_register=pelayanan_poli.no_register and operator.id_dokter=pelayanan_poli.id_dokter and poliklinik.id_poli=daftar_ulang_irj.id_poli");
		}
		/////////////////////////////////////////////////////////////////////////////////////
		function getdata_rs($koders){
			return $this->db->query("select * from app_config ");
		}
		/////////////////////////////////////////////////////////////////////////////////////karcis
		function get_new_nokarcis($no_register){
			return $this->db->query("select max(right(noseri_karcis,5)) as counter, mid(now(),3,2) as year from daftar_ulang_irj where mid(noseri_karcis,2,2) = (select mid(now(),3,2)) and no_register not like '$no_register'");
		}
		function update_nokarcis($noseri_karcis,$no_register){
			$this->db->query("update daftar_ulang_irj set noseri_karcis='$noseri_karcis', tglcetak_karcis=now() where no_register='$no_register'");
			return true;
		}
		
		function getdata_karcis($no_register){
			return $this->db->query("select A.cara_bayar, B.no_medrec, B.nama, A.no_register, A.biayadaftar from irddaftar_ulang A, data_pasien B where A.no_medrec=B.no_medrec and A.no_register='$no_register'");
		}
		/////////////////////////////////////////////////////////////////////////////////////status kwitansi
		function update_status_kwitansi_kt($no_register,$data){
			$this->db->where('no_register', $no_register);
			$this->db->update('irddaftar_ulang', $data);
			return true;
		}
		function update_pembayaran($no_register,$data){
			$this->db->where('no_register', $no_register);
			$this->db->update('irddaftar_ulang', $data);
			return true;
		}
		//SELECT A.id_kontraktor, B.nmkontraktor FROM hmis_db.irddaftar_ulang A, hmis_db.kontraktor B  where no_register='RD16000055' and A.id_kontraktor=B.id_kontraktor;
		function getdata_perusahaan($no_register){
			return $this->db->query("SELECT A.id_kontraktor, B.nmkontraktor FROM irddaftar_ulang A, kontraktor B  where no_register='$no_register' and A.id_kontraktor=B.id_kontraktor;
");
		}
		function update_diskon($diskon,$no_register){
			$this->db->query("update irddaftar_ulang set diskon='$diskon' where no_register='$no_register'");
			return true;
		}
		function update_status_kwitansi_kk($id_pelayanan_poli){
			$this->db->query("update pelayanan_poli set cetak_kwitansi='1' where id_pelayanan_poli='$id_pelayanan_poli'");
			return true;
		}
		// Pasien SJP
		
		function get_pasien_sjp(){
			return $this->db->query("SELECT a.tgl_kunjungan, a.no_register, a.cara_bayar, 
				b.no_cm, b.nama, c.nmkontraktor, c.id_kontraktor 
				FROM irddaftar_ulang as a
				LEFT JOIN data_pasien as b ON a.no_medrec=b.no_medrec 
				LEFT JOIN kontraktor as c ON a.id_kontraktor=c.id_kontraktor 
				where (cara_bayar='DIJAMIN / JAMSOSKES' or cara_bayar='BPJS') and a.status='0' 
				order by a.xupdate desc");
		}
		
		function getdata_pasien_sjp($no_register){
			return $this->db->query("SELECT a.*, 
				b.no_cm, b.nama, b.alamat, b.tgl_lahir, b.sex, 
				c.nmkontraktor, c.id_kontraktor, 
				d.nm_ppk
				FROM irddaftar_ulang as a
				LEFT JOIN data_pasien as b ON a.no_medrec=b.no_medrec 
				LEFT JOIN kontraktor as c ON a.id_kontraktor=c.id_kontraktor 
				LEFT JOIN data_ppk as d ON a.asal_rujukan=d.kd_ppk 
				WHERE a.no_register='$no_register'");
		}
	}
?>
