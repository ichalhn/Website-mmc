<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Pamdaftar extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//modul for pacdaftar
		function get_daftar_pasien_pa(){
			return $this->db->query("SELECT pemeriksaan_pa.no_register, data_pasien.no_cm as no_medrec, pemeriksaan_pa.tgl_kunjungan as tgl_kunjungan, pemeriksaan_pa.kelas, pemeriksaan_pa.idrg, pemeriksaan_pa.bed, data_pasien.nama as nama  
									FROM pemeriksaan_pa, data_pasien 
									WHERE pemeriksaan_pa.no_medrec=data_pasien.no_medrec
									AND LEFT(pemeriksaan_pa.jadwal_pa,10)=LEFT(NOW(),10)
							 order by tgl_kunjungan asc");
		}

		function get_daftar_pasien_pa_by_date($date){
			return $this->db->query("SELECT pemeriksaan_pa.no_register, data_pasien.no_cm as no_medrec, pemeriksaan_pa.tgl_kunjungan, pemeriksaan_pa.kelas, pemeriksaan_pa.idrg, pemeriksaan_pa.bed, data_pasien.nama as nama  
										FROM pemeriksaan_pa, data_pasien 
										WHERE pemeriksaan_pa.no_medrec=data_pasien.no_medrec 
										AND LEFT(pemeriksaan_pa.jadwal_pa,10)='$date'");
		}

		function get_daftar_pasien_pa_by_no($key){
			return $this->db->query("SELECT pemeriksaan_pa.no_register, data_pasien.no_cm as no_medrec, pemeriksaan_pa.tgl_kunjungan, pemeriksaan_pa.kelas, pemeriksaan_pa.idrg, pemeriksaan_pa.bed, data_pasien.nama as nama  
										FROM pemeriksaan_pa, data_pasien 
										WHERE pemeriksaan_pa.no_medrec=data_pasien.no_medrec 
										AND (data_pasien.nama LIKE '%$key%' OR pemeriksaan_pa.no_register LIKE '%$key%')");
		}

		function get_data_pasien_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_pa, data_pasien WHERE pemeriksaan_pa.no_medrec=data_pasien.no_medrec AND pemeriksaan_pa.no_register='$no_register'");
		}

		function get_data_pasien_luar_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_pa, pasien_luar WHERE pemeriksaan_pa.no_register=pasien_luar.no_register AND pemeriksaan_pa.no_register='$no_register'");
		}

		function get_data_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_patologianatomi WHERE no_register='$no_register' AND no_pa IS NULL");
		}

		function getdata_tindakan_pasien2($no_register){
			return $this->db->query("SELECT * FROM tarif_tindakan, jenis_tindakan, pemeriksaan_pa where pemeriksaan_pa.no_register='$no_register' and tarif_tindakan.kelas=pemeriksaan_pa.kelas and jenis_tindakan.idtindakan=tarif_tindakan.id_tindakan and tarif_tindakan.id_tindakan LIKE 'h%'");
		}

		function getdata_tindakan_pasien(){
			return $this->db->query("SELECT * FROM jenis_tindakan_pa");
		}

		function get_biaya_tindakan($id,$kelas){
			return $this->db->query("SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan='".$id."' AND kelas = '".$kelas."'");
		}

		function getdata_dokter(){
			return $this->db->query("SELECT a.*, b.* FROM data_dokter as a LEFT JOIN dokter_poli as b ON a.id_dokter=b.id_dokter WHERE a.ket = 'Patologi Anatomi' or b.id_poli='PA00'");
		}

		function getnama_dokter($id_dokter){
			return $this->db->query("SELECT * FROM data_dokter WHERE id_dokter='".$id_dokter."' ");
		}

		function getjenis_tindakan($id_tindakan){
			return $this->db->query("SELECT * FROM jenis_tindakan WHERE idtindakan='".$id_tindakan."' ");
		}

		function insert_pemeriksaan($data){
			$this->db->insert('pemeriksaan_patologianatomi', $data);
			return true;
		}

		function selesai_daftar_pemeriksaan_PL($no_register,$getvtotpa,$no_pa){
			$this->db->query("UPDATE pemeriksaan_patologianatomi SET no_pa='$no_pa' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pasien_luar SET pa=0, vtot_pa='$getvtotpa' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotpa,$no_pa){
			$this->db->query("UPDATE pemeriksaan_patologianatomi SET no_pa='$no_pa' WHERE no_register='$no_register'");
			$this->db->query("UPDATE daftar_ulang_irj SET pa=0, status_pa=1, vtot_pa='$getvtotpa' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRD($no_register,$getvtotpa,$no_pa){
			$this->db->query("UPDATE pemeriksaan_patologianatomi SET no_pa='$no_pa' WHERE no_register='$no_register'");
			$this->db->query("UPDATE irddaftar_ulang SET pa=0, status_pa=1, vtot_pa='$getvtotpa' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRI($no_register,$status_pa,$vtot_pa,$no_pa){
			$this->db->query("UPDATE pemeriksaan_patologianatomi SET no_pa=IF(no_pa IS NULL, '$no_pa', no_pa) WHERE no_register='$no_register'");
			$this->db->query("UPDATE pasien_iri SET pa=0, status_pa='$status_pa', vtot_pa='$vtot_pa' WHERE no_ipd='$no_register'");
			return true;
		}

		function getdata_iri($no_register){
			return $this->db->query("SELECT status_pa FROM pasien_iri WHERE no_ipd='".$no_register."'");
		}

		function get_vtot_pa($no_register){
			return $this->db->query("SELECT SUM(vtot) as vtot_pa FROM pemeriksaan_patologianatomi WHERE no_register='".$no_register."'");
		}

		function get_vtot_no_pa($no_pa){
			return $this->db->query("SELECT SUM(vtot) as vtot_no_pa FROM pemeriksaan_patologianatomi WHERE no_pa='".$no_pa."'");
		}

		function hapus_data_pemeriksaan($id_pemeriksaan_pa){
			$this->db->where('id_pemeriksaan_pa', $id_pemeriksaan_pa);
       		$this->db->delete('pemeriksaan_patologianatomi');			
			return true;
		}	

		function insert_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("INSERT INTO pa_header (no_register, idrg, bed, kelas) VALUES ('$no_register','$idrg','$bed','$kelas')");
		}	

		function get_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("SELECT no_pa FROM pa_header WHERE no_register='$no_register' AND idrg='$idrg' AND bed='$bed' AND kelas='$kelas' ORDER BY no_pa DESC LIMIT 1");
		}

		function insert_pasien_luar($data){
			$this->db->insert('pasien_luar', $data);
			return true;
		}

		function get_new_register(){
			return $this->db->query("SELECT max(right(no_register,6)) as counter, mid(now(),3,2) as year from pasien_luar where mid(no_register,3,2) = (select mid(now(),3,2))");
		}


		//modul for pacpengisianhasil /////////////////////////////////////////////////////////////

		function get_hasil_pa(){
			return $this->db->query("SELECT nama, a.no_pa, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_patologianatomi WHERE no_pa=a.no_pa AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_patologianatomi a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_pa is not null
			GROUP BY no_pa
			UNION
			SELECT nama, b.no_pa, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_patologianatomi WHERE no_pa=b.no_pa AND hasil_periksa!='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_pa as vtot 
			FROM pemeriksaan_patologianatomi b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_pa is not null
			GROUP BY no_pa ORDER BY tgl asc");
		}

		function get_hasil_pa_by_date($date){
			return $this->db->query("SELECT nama, a.no_pa, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_patologianatomi WHERE no_pa=a.no_pa AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_patologianatomi a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_pa is not null AND left(a.tgl_kunjungan,10)  = '$date'
			GROUP BY no_pa
			UNION
			SELECT nama, b.no_pa, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_patologianatomi WHERE no_pa=b.no_pa AND hasil_periksa!='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_pa as vtot 
			FROM pemeriksaan_patologianatomi b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_pa is not null AND left(b.tgl_kunjungan,10)  = '$date'
			GROUP BY no_pa ORDER BY tgl asc");
		}

		function get_hasil_pa_by_no($key){
			return $this->db->query("SELECT nama, a.no_pa, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_patologianatomi WHERE no_pa=a.no_pa AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_patologianatomi a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_pa is not null AND (a.tgl_kunjungan LIKE '%$key%' OR a.no_register LIKE '%$key%' OR data_pasien.nama LIKE '%$key%')
			GROUP BY no_pa
			UNION
			SELECT nama, b.no_pa, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_patologianatomi WHERE no_pa=b.no_pa AND hasil_periksa!='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_pa as vtot 
			FROM pemeriksaan_patologianatomi b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_pa is not null AND (b.tgl_kunjungan LIKE '%$key%' OR b.no_register LIKE '%$key%' OR pasien_luar.nama LIKE '%$key%')
			GROUP BY no_pa ORDER BY tgl asc");
		}

		function getrow_hasil_pa($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_patologianatomi, data_pasien WHERE pemeriksaan_patologianatomi.no_medrec=data_pasien.no_medrec AND pemeriksaan_patologianatomi.no_register='".$no_register."' ");
		}	

		function get_row_register($id_pemeriksaan_pa){
			return $this->db->query("SELECT no_register FROM pemeriksaan_patologianatomi WHERE id_pemeriksaan_pa='$id_pemeriksaan_pa'");
		}

		function get_row_register_by_nopa($no_pa){
			return $this->db->query("SELECT no_register FROM pemeriksaan_patologianatomi WHERE no_pa='$no_pa' LIMIT 1");
		}

		function get_data_pengisian_hasil($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_patologianatomi WHERE no_register='".$no_register."'  AND cetak_hasil='0' ORDER BY no_pa");
		}

		function get_banyak_hasil_pa($no_register){
			return $this->db->query("SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_patologianatomi WHERE no_register=".$no_register."' ");
		}

		function get_data_hasil_pemeriksaan($no_pa){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_patologianatomi.tgl_kunjungan, 10) as tgl FROM pemeriksaan_patologianatomi, data_pasien WHERE pemeriksaan_patologianatomi.no_medrec=data_pasien.no_medrec AND pemeriksaan_patologianatomi.no_pa='$no_pa' LIMIT 1");
		}

		function get_data_hasil_pemeriksaan_pasien_luar($no_pa){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_patologianatomi.tgl_kunjungan, 10) as tgl FROM pemeriksaan_patologianatomi, pasien_luar WHERE pemeriksaan_patologianatomi.no_register=pasien_luar.no_register AND pemeriksaan_patologianatomi.no_pa='$no_pa' LIMIT 1");
		}

		function get_data_isi_hasil_pemeriksaan($id_pemeriksaan_pa){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_patologianatomi.tgl_kunjungan, 10) as tgl FROM pemeriksaan_patologianatomi, data_pasien WHERE pemeriksaan_patologianatomi.no_medrec=data_pasien.no_medrec AND pemeriksaan_patologianatomi.id_pemeriksaan_pa='$id_pemeriksaan_pa'");
		}

		function get_data_tindakan_pa($id_tindakan){
			return $this->db->query("SELECT jenis_tindakan.nmtindakan as nm_tindakan, jenis_hasil_pa.* FROM jenis_hasil_pa, jenis_tindakan WHERE  jenis_hasil_pa.id_tindakan=jenis_tindakan.idtindakan AND id_tindakan='$id_tindakan'");
		}

		function isi_hasil($data){
			$this->db->insert('hasil_pemeriksaan_pa', $data);
			return true;	
		}

		function set_hasil_periksa($id_pemeriksaan_pa){
			return $this->db->query("UPDATE pemeriksaan_patologianatomi SET hasil_periksa=1 WHERE id_pemeriksaan_pa='$id_pemeriksaan_pa'");
		}

		function get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_pa){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_patologianatomi.tgl_kunjungan, 10) as tgl FROM pemeriksaan_patologianatomi, pasien_luar WHERE pemeriksaan_patologianatomi.no_register=pasien_luar.no_register AND pemeriksaan_patologianatomi.id_pemeriksaan_pa='$id_pemeriksaan_pa'");
		}

		function get_data_edit_tindakan_pa($id_tindakan, $no_pa){
			return $this->db->query("SELECT * FROM hasil_pemeriksaan_pa WHERE  id_tindakan='$id_tindakan' AND no_pa='$no_pa'");
		}

		function get_no_register($no_pa){
			return $this->db->query("SELECT no_register FROM pemeriksaan_patologianatomi WHERE  no_pa='$no_pa' AND cetak_hasil='0' GROUP BY no_register");
		}

		function edit_hasil($id_hasil_pemeriksaan, $hasil_pa){
			return $this->db->query("UPDATE hasil_pemeriksaan_pa SET hasil_pa='$hasil_pa' WHERE id_hasil_pemeriksaan='$id_hasil_pemeriksaan'");
		}

		function update_status_cetak_hasil($no_pa){
			$this->db->query("UPDATE pemeriksaan_patologianatomi SET cetak_hasil='1' where no_pa='$no_pa'");
			return true;
		}

		function get_jenis_pa(){
			return $this->db->query("SELECT * FROM jenis_pa");
		}

		function get_roleid($userid){
			return $this->db->query("Select roleid from dyn_role_user where userid = '".$userid."'");
		}

		function get_data_jenis_pa($no_pa){
			return $this->db->query("SELECT a.id_tindakan, a.no_pa, b.nmtindakan FROM hasil_pemeriksaan_pa a, jenis_tindakan b WHERE a.id_tindakan=b.idtindakan AND no_pa='$no_pa' AND hasil_pa!=''  GROUP BY id_tindakan");
		}

		function get_data_hasil_pa($id_tindakan,$no_pa){
			return $this->db->query("SELECT * FROM hasil_pemeriksaan_pa WHERE id_tindakan='$id_tindakan' AND no_pa='$no_pa' AND hasil_pa!=''");
		}

		function get_data_pasien_cetak($no_pa){
			return $this->db->query("SELECT * FROM pemeriksaan_patologianatomi a, data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_pa='$no_pa' GROUP BY no_pa");
		}

		function get_data_pasien_luar_cetak($no_pa){
			return $this->db->query("SELECT * FROM pemeriksaan_patologianatomi a, pasien_luar WHERE a.no_register=pasien_luar.no_register AND no_pa='$no_pa' GROUP BY no_pa");
		}
	}
?>