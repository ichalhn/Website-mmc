<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Okmdaftar extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//modul for okcdaftar
		function get_daftar_pasien_ok(){
			return $this->db->query("SELECT pemeriksaan_ok.no_register, data_pasien.no_cm as no_medrec, pemeriksaan_ok.tgl_kunjungan as tgl_kunjungan, pemeriksaan_ok.kelas, pemeriksaan_ok.idrg, pemeriksaan_ok.bed, data_pasien.nama as nama  
									FROM pemeriksaan_ok, data_pasien 
									WHERE pemeriksaan_ok.no_medrec=data_pasien.no_medrec
									AND LEFT(pemeriksaan_ok.jadwal_ok,10)=LEFT(NOW(),10)
							 order by tgl_kunjungan asc");
		}

		function get_daftar_pasien_ok_by_date($date){
			return $this->db->query("SELECT pemeriksaan_ok.no_register, data_pasien.no_cm as no_medrec, pemeriksaan_ok.tgl_kunjungan, pemeriksaan_ok.kelas, pemeriksaan_ok.idrg, pemeriksaan_ok.bed, data_pasien.nama as nama  
										FROM pemeriksaan_ok, data_pasien 
										WHERE pemeriksaan_ok.no_medrec=data_pasien.no_medrec 
										AND LEFT(pemeriksaan_pa.jadwal_ok,10)='$date'
										ORDER BY tgl_kunjungan DESC");
		}

		function get_daftar_pasien_ok_by_no($key){
			return $this->db->query("SELECT pemeriksaan_ok.no_register, data_pasien.no_cm as no_medrec, pemeriksaan_ok.tgl_kunjungan, pemeriksaan_ok.kelas, pemeriksaan_ok.idrg, pemeriksaan_ok.bed, data_pasien.nama as nama  
										FROM pemeriksaan_ok, data_pasien 
										WHERE pemeriksaan_ok.no_medrec=data_pasien.no_medrec 
										AND (data_pasien.nama LIKE '%$key%' OR pemeriksaan_ok.no_register LIKE '%$key%')");
		}

		function get_data_pasien_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_ok, data_pasien WHERE pemeriksaan_ok.no_medrec=data_pasien.no_medrec AND pemeriksaan_ok.no_register='$no_register'");
		}

		function get_data_pasien_luar_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_ok, pasien_luar WHERE pemeriksaan_ok.no_register=pasien_luar.no_register AND pemeriksaan_ok.no_register='$no_register'");
		}

		function get_data_pemeriksaan($no_register){
			return $this->db->query("SELECT id_pemeriksaan_ok, id_dokter2, id_tindakan, jenis_tindakan, id_dokter, id_opr_anes, id_dok_anes, jns_anes, id_dok_anak, tgl_operasi, vtot, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter) as nm_dokter, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter2) as nm_dokter2, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_opr_anes) as nm_opr_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anes) as nm_dok_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anak) as nm_dok_anak 
				FROM pemeriksaan_operasi WHERE no_register='$no_register' AND no_ok IS NULL");
		}

		function getdata_tindakan_pasien2($no_register){
			return $this->db->query("SELECT * FROM tarif_tindakan, jenis_tindakan, pemeriksaan_ok where pemeriksaan_ok.no_register='$no_register' and tarif_tindakan.kelas=pemeriksaan_ok.kelas and jenis_tindakan.idtindakan=tarif_tindakan.id_tindakan and tarif_tindakan.id_tindakan LIKE 'h%'");
		}

		function getdata_tindakan_pasien($kelas){
			return $this->db->query("SELECT * FROM jenis_tindakan_ok where kelas='$kelas'");
		}

		function get_biaya_tindakan($id,$kelas){
			return $this->db->query("SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan='".$id."' AND kelas = '".$kelas."'");
		}

		function getdata_dokter(){
			return $this->db->query("select *
			from data_dokter 
			where nm_dokter <> ''
			order by nm_dokter asc");
		}

		function getnama_dokter($id_dokter){
			return $this->db->query("SELECT * FROM data_dokter WHERE id_dokter='".$id_dokter."' ");
		}

		function getjenis_tindakan($id_tindakan){
			return $this->db->query("SELECT * FROM jenis_tindakan WHERE idtindakan='".$id_tindakan."' ");
		}

		function insert_pemeriksaan($data){
			$this->db->insert('pemeriksaan_operasi', $data);
			return true;
		}

		function selesai_daftar_pemeriksaan_PL($no_register,$getvtotok,$no_ok){
			$this->db->query("UPDATE pemeriksaan_operasi SET no_ok='$no_ok' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pasien_luar SET ok=0, vtot_ok='$getvtotok' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotok,$no_ok){
			$this->db->query("UPDATE pemeriksaan_operasi SET no_ok='$no_ok' WHERE no_register='$no_register'");
			$this->db->query("UPDATE daftar_ulang_irj SET ok=0, status_ok=1, vtot_ok='$getvtotok' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRD($no_register,$getvtotok,$no_ok){
			$this->db->query("UPDATE pemeriksaan_operasi SET no_ok='$no_ok' WHERE no_register='$no_register'");
			$this->db->query("UPDATE irddaftar_ulang SET ok=0, status_ok=1, vtot_ok='$getvtotok' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRI($no_register,$status_ok,$vtot_ok,$no_ok){
			$this->db->query("UPDATE pemeriksaan_operasi SET no_ok=IF(no_ok IS NULL, '$no_ok', no_ok) WHERE no_register='$no_register'");
			$this->db->query("UPDATE pasien_iri SET ok=0, status_ok='$status_ok', vtot_ok='$vtot_ok' WHERE no_ipd='$no_register'");
			return true;
		}

		function getdata_iri($no_register){
			return $this->db->query("SELECT status_ok FROM pasien_iri WHERE no_ipd='".$no_register."'");
		}

		function get_vtot_ok($no_register){
			return $this->db->query("SELECT SUM(vtot) as vtot_ok FROM pemeriksaan_operasi WHERE no_register='".$no_register."'");
		}

		function get_vtot_no_ok($no_ok){
			return $this->db->query("SELECT SUM(vtot) as vtot_no_ok FROM pemeriksaan_operasi WHERE no_ok='".$no_ok."'");
		}

		function hapus_data_pemeriksaan($id_pemeriksaan_ok){
			$this->db->where('id_pemeriksaan_ok', $id_pemeriksaan_ok);
       		$this->db->delete('pemeriksaan_operasi');			
			return true;
		}	

		function insert_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("INSERT INTO ok_header (no_register, idrg, bed, kelas) VALUES ('$no_register','$idrg','$bed','$kelas')");
		}	

		function get_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("SELECT no_ok FROM ok_header WHERE no_register='$no_register' AND idrg='$idrg' AND bed='$bed' AND kelas='$kelas' ORDER BY no_ok DESC LIMIT 1");
		}

		function insert_pasien_luar($data){
			$this->db->insert('pasien_luar', $data);
			return true;
		}

		function get_new_register(){
			return $this->db->query("SELECT max(right(no_register,6)) as counter, mid(now(),3,2) as year from pasien_luar where mid(no_register,3,2) = (select mid(now(),3,2))");
		}


		//modul for okcpengisianhasil /////////////////////////////////////////////////////////////

		function get_hasil_ok(){
			return $this->db->query("SELECT nama, a.no_ok, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_operasi WHERE no_ok=a.no_ok AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_operasi a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_ok is not null
			GROUP BY no_ok
			UNION
			SELECT nama, b.no_ok, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_operasi WHERE no_ok=b.no_ok AND hasil_periksa!='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_ok as vtot 
			FROM pemeriksaan_operasi b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_ok is not null
			GROUP BY no_ok ORDER BY tgl asc");
		}

		function get_hasil_ok_by_date($date){
			return $this->db->query("SELECT nama, a.no_ok, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_operasi WHERE no_ok=a.no_ok AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_operasi a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_ok is not null AND left(A.tgl_kunjungan,10)  = '$date'
			GROUP BY no_ok
			UNION
			SELECT nama, b.no_ok, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_operasi WHERE no_ok=b.no_ok AND hasil_periksa!='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_ok as vtot 
			FROM pemeriksaan_operasi b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_ok is not null AND left(b.tgl_kunjungan,10)  = '$date'
			GROUP BY no_ok ORDER BY tgl asc");
		}

		function get_hasil_ok_by_no($key){
			return $this->db->query("SELECT nama, a.no_ok, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_operasi WHERE no_ok=a.no_ok AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_operasi a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_ok is not null AND (a.tgl_kunjungan LIKE '%$key%' OR a.no_register LIKE '%$key%' OR data_pasien.nama LIKE '%$key%')
			GROUP BY no_ok
			UNION
			SELECT nama, b.no_ok, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_operasi WHERE no_ok=b.no_ok AND hasil_periksa!='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_ok as vtot 
			FROM pemeriksaan_operasi b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_ok is not null AND (b.tgl_kunjungan LIKE '%$key%' OR b.no_register LIKE '%$key%' OR pasien_luar.nama LIKE '%$key%')
			GROUP BY no_ok ORDER BY tgl asc");
		}

		function getrow_hasil_ok($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_operasi, data_pasien WHERE pemeriksaan_operasi.no_medrec=data_pasien.no_medrec AND pemeriksaan_operasi.no_register='".$no_register."' ");
		}	

		function get_row_register($id_pemeriksaan_ok){
			return $this->db->query("SELECT no_register FROM pemeriksaan_operasi WHERE id_pemeriksaan_ok='$id_pemeriksaan_ok'");
		}

		function get_row_register_by_nook($no_ok){
			return $this->db->query("SELECT no_register FROM pemeriksaan_operasi WHERE no_ok='$no_ok' LIMIT 1");
		}

		function get_data_pengisian_hasil($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_operasi WHERE no_register='".$no_register."'  AND cetak_hasil='0' ORDER BY no_ok");
		}

		function get_banyak_hasil_ok($no_register){
			return $this->db->query("SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_operasi WHERE no_register=".$no_register."' ");
		}

		function get_data_hasil_pemeriksaan($no_ok){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_operasi.tgl_kunjungan, 10) as tgl FROM pemeriksaan_operasi, data_pasien WHERE pemeriksaan_operasi.no_medrec=data_pasien.no_medrec AND pemeriksaan_operasi.no_ok='$no_ok' LIMIT 1");
		}

		function get_data_hasil_pemeriksaan_pasien_luar($no_ok){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_operasi.tgl_kunjungan, 10) as tgl FROM pemeriksaan_operasi, pasien_luar WHERE pemeriksaan_operasi.no_register=pasien_luar.no_register AND pemeriksaan_operasi.no_ok='$no_ok' LIMIT 1");
		}

		function get_data_isi_hasil_pemeriksaan($id_pemeriksaan_ok){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_operasi.tgl_kunjungan, 10) as tgl FROM pemeriksaan_operasi, data_pasien WHERE pemeriksaan_operasi.no_medrec=data_pasien.no_medrec AND pemeriksaan_operasi.id_pemeriksaan_ok='$id_pemeriksaan_ok'");
		}

		function get_data_tindakan_ok($id_tindakan){
			return $this->db->query("SELECT jenis_tindakan.nmtindakan as nm_tindakan, jenis_hasil_ok.* FROM jenis_hasil_ok, jenis_tindakan WHERE  jenis_hasil_ok.id_tindakan=jenis_tindakan.idtindakan AND id_tindakan='$id_tindakan'");
		}

		function isi_hasil($data){
			$this->db->insert('hasil_pemeriksaan_ok', $data);
			return true;	
		}

		function set_hasil_periksa($id_pemeriksaan_ok){
			return $this->db->query("UPDATE pemeriksaan_operasi SET hasil_periksa=1 WHERE id_pemeriksaan_ok='$id_pemeriksaan_ok'");
		}

		function get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_ok){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_operasi.tgl_kunjungan, 10) as tgl FROM pemeriksaan_operasi, pasien_luar WHERE pemeriksaan_operasi.no_register=pasien_luar.no_register AND pemeriksaan_operasi.id_pemeriksaan_ok='$id_pemeriksaan_ok'");
		}

		function get_data_edit_tindakan_ok($id_tindakan, $no_ok){
			return $this->db->query("SELECT * FROM hasil_pemeriksaan_ok WHERE  id_tindakan='$id_tindakan' AND no_ok='$no_ok'");
		}

		function get_no_register($no_ok){
			return $this->db->query("SELECT no_register FROM pemeriksaan_operasi WHERE  no_ok='$no_ok' AND cetak_hasil='0' GROUP BY no_register");
		}

		function edit_hasil($id_hasil_pemeriksaan, $hasil_ok){
			return $this->db->query("UPDATE hasil_pemeriksaan_ok SET hasil_ok='$hasil_ok' WHERE id_hasil_pemeriksaan='$id_hasil_pemeriksaan'");
		}

		function update_status_cetak_hasil($no_ok){
			$this->db->query("UPDATE pemeriksaan_operasi SET cetak_hasil='1' where no_ok='$no_ok'");
			return true;
		}

		function get_jenis_ok(){
			return $this->db->query("SELECT * FROM jenis_ok");
		}

		function get_data_jenis_ok($no_ok){
			return $this->db->query("SELECT a.id_tindakan, a.no_ok, b.nmtindakan FROM hasil_pemeriksaan_ok a, jenis_tindakan b WHERE a.id_tindakan=b.idtindakan AND no_ok='$no_ok' AND hasil_ok!=''  GROUP BY id_tindakan");
		}

		function get_data_hasil_ok($id_tindakan,$no_ok){
			return $this->db->query("SELECT * FROM hasil_pemeriksaan_ok WHERE id_tindakan='$id_tindakan' AND no_ok='$no_ok' AND hasil_ok!=''");
		}

		function get_data_pasien_cetak($no_ok){
			return $this->db->query("SELECT * FROM pemeriksaan_operasi a, data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_ok='$no_ok' GROUP BY no_ok");
		}

		function get_data_pasien_luar_cetak($no_ok){
			return $this->db->query("SELECT * FROM pemeriksaan_operasi a, pasien_luar WHERE a.no_register=pasien_luar.no_register AND no_ok='$no_ok' GROUP BY no_ok");
		}
	}
?>