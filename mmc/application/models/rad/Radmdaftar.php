<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Radmdaftar extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//modul for radcdaftar
		function get_daftar_pasien_rad(){
			return $this->db->query("SELECT
										pemeriksaan_rad.no_register ,
										data_pasien.no_cm as no_medrec ,
										pemeriksaan_rad.tgl_kunjungan ,
										pemeriksaan_rad.jadwal_rad as jadwal_rad ,
										pemeriksaan_rad.kelas ,
										pemeriksaan_rad.idrg ,
										pemeriksaan_rad.bed ,
										data_pasien.nama as nama
									FROM
										pemeriksaan_rad ,
										data_pasien
									WHERE
										pemeriksaan_rad.no_medrec = data_pasien.no_medrec
									AND LEFT(pemeriksaan_rad.jadwal_rad , 10) = LEFT(NOW() , 10)
									order by
										tgl_kunjungan asc");
		}

		function get_daftar_pasien_rad_by_date($date){
			return $this->db->query("SELECT pemeriksaan_rad.no_register, data_pasien.no_cm as no_medrec, pemeriksaan_rad.tgl_kunjungan, pemeriksaan_rad.kelas, pemeriksaan_rad.idrg, pemeriksaan_rad.bed, data_pasien.nama as nama  
										FROM pemeriksaan_rad, data_pasien 
										WHERE pemeriksaan_rad.no_medrec=data_pasien.no_medrec 
										AND LEFT(pemeriksaan_rad.jadwal_rad,10)='$date'
										ORDER BY tgl_kunjungan DESC");
		}

		function get_daftar_pasien_rad_by_no($key){
			return $this->db->query("SELECT pemeriksaan_rad.no_register, data_pasien.no_cm as no_medrec, pemeriksaan_rad.tgl_kunjungan, pemeriksaan_rad.kelas, pemeriksaan_rad.idrg, pemeriksaan_rad.bed, data_pasien.nama as nama  
										FROM pemeriksaan_rad, data_pasien 
										WHERE pemeriksaan_rad.no_medrec=data_pasien.no_medrec 
										AND (data_pasien.nama LIKE '%$key%' OR pemeriksaan_rad.no_register LIKE '%$key%')
									UNION
										SELECT pemeriksaan_rad.no_register, pemeriksaan_rad.no_medrec, pemeriksaan_rad.tgl_kunjungan, pemeriksaan_rad.kelas, pemeriksaan_rad.idrg, pemeriksaan_rad.bed, pasien_luar.nama as nama  
										FROM pemeriksaan_rad, pasien_luar 
										WHERE pemeriksaan_rad.no_register=pasien_luar.no_register 
										AND (pasien_luar.nama LIKE '%$key%' OR pasien_luar.no_register LIKE '%$key%')
										ORDER BY tgl_kunjungan DESC");
		}

		function get_data_pasien_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_rad, data_pasien WHERE pemeriksaan_rad.no_medrec=data_pasien.no_medrec AND pemeriksaan_rad.no_register='$no_register'");
		}

		function get_data_pasien_luar_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_rad, pasien_luar WHERE pemeriksaan_rad.no_register=pasien_luar.no_register AND pemeriksaan_rad.no_register='$no_register'");
		}

		function get_jenis_rad(){
			return $this->db->query("SELECT * FROM jenis_rad");
		}

		function get_roleid($userid){
			return $this->db->query("Select roleid from dyn_role_user where userid = '".$userid."'");
		}

		function get_data_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi WHERE no_register='$no_register' AND no_rad IS NULL");
		}

		function getdata_tindakan_pasien2($no_register){
			return $this->db->query("SELECT * FROM tarif_tindakan, jenis_tindakan, pemeriksaan_rad where pemeriksaan_rad.no_register='$no_register' and tarif_tindakan.kelas=pemeriksaan_rad.kelas and jenis_tindakan.idtindakan=tarif_tindakan.id_tindakan and tarif_tindakan.id_tindakan LIKE 'h%'");
		}

		function getdata_tindakan_pasien(){
			return $this->db->query("SELECT * FROM jenis_tindakan_rad order by nmtindakan");
		}

		function get_biaya_tindakan($id,$kelas){
			return $this->db->query("SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan='".$id."' AND kelas = '".$kelas."'");
		}

		function getdata_dokter(){
			return $this->db->query("SELECT a.id_dokter, a.nm_dokter FROM data_dokter as a LEFT JOIN dokter_poli as b ON a.id_dokter=b.id_dokter WHERE a.ket = 'Radiologi' or b.id_poli='LA00'");
		}

		function get_row_register_by_norad($no_rad){
			return $this->db->query("SELECT no_register FROM pemeriksaan_radiologi WHERE no_rad='$no_rad' LIMIT 1");
		}

		function getnama_dokter($id_dokter){
			return $this->db->query("SELECT * FROM data_dokter WHERE id_dokter='".$id_dokter."' ");
		}

		function getjenis_tindakan($id_tindakan){
			return $this->db->query("SELECT * FROM jenis_tindakan WHERE idtindakan='".$id_tindakan."' ");
		}

		function insert_pemeriksaan($data){
			$this->db->insert('pemeriksaan_radiologi', $data);
			return true;
		}

		function selesai_daftar_pemeriksaan_PL($no_register,$getvtotrad,$no_rad){
			$this->db->query("UPDATE pemeriksaan_radiologi SET no_rad='$no_rad' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pasien_luar SET rad=0, vtot_rad='$getvtotrad' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotrad,$no_rad){
			$this->db->query("UPDATE pemeriksaan_radiologi SET no_rad='$no_rad' WHERE no_register='$no_register'");
			$this->db->query("UPDATE daftar_ulang_irj SET rad=0, status_rad=1, vtot_rad='$getvtotrad' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRD($no_register,$getvtotrad,$no_rad){
			$this->db->query("UPDATE pemeriksaan_radiologi SET no_rad='$no_rad' WHERE no_register='$no_register'");
			$this->db->query("UPDATE irddaftar_ulang SET rad=0, status_rad=1, vtot_rad='$getvtotrad' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRI($no_register,$status_rad,$vtot_rad,$no_rad){
			$this->db->query("UPDATE pemeriksaan_radiologi SET no_rad=IF(no_rad IS NULL, '$no_rad', no_rad) WHERE no_register='$no_register'");
			$this->db->query("UPDATE pasien_iri SET rad=0, status_rad='$status_rad', vtot_rad='$vtot_rad' WHERE no_ipd='$no_register'");
			return true;
		}

		function getdata_iri($no_register){
			return $this->db->query("SELECT status_rad FROM pasien_iri WHERE no_ipd='".$no_register."'");
		}

		function get_vtot_rad($no_register){
			return $this->db->query("SELECT SUM(vtot) as vtot_rad FROM pemeriksaan_radiologi WHERE no_register='".$no_register."'");
		}

		function get_vtot_no_rad($no_rad){
			return $this->db->query("SELECT SUM(vtot) as vtot_no_rad FROM pemeriksaan_radiologi WHERE no_rad='".$no_rad."'");
		}

		function hapus_data_pemeriksaan($id_pemeriksaan_rad){
			$this->db->where('id_pemeriksaan_rad', $id_pemeriksaan_rad);
       		$this->db->delete('pemeriksaan_radiologi');			
			return true;
		}	

		function insert_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("INSERT INTO rad_header (no_register, idrg, bed, kelas) VALUES ('$no_register','$idrg','$bed','$kelas')");
		}	

		function get_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("SELECT no_rad FROM rad_header WHERE no_register='$no_register' AND idrg='$idrg' AND bed='$bed' AND kelas='$kelas' ORDER BY no_rad DESC LIMIT 1");
		}

		function insert_pasien_luar($data){
			$this->db->insert('pasien_luar', $data);
			return true;
		}

		function get_new_register(){
			return $this->db->query("SELECT max(right(no_register,6)) as counter, mid(now(),3,2) as year from pasien_luar where mid(no_register,3,2) = (select mid(now(),3,2))");
		}


		//modul for radcpengisianhasil /////////////////////////////////////////////////////////////

		function get_hasil_rad(){
			return $this->db->query("SELECT nama, a.no_rad, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_radiologi WHERE no_rad=a.no_rad AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_radiologi a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_rad is not null 
			GROUP BY no_rad
			UNION
			SELECT nama, b.no_rad, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_radiologi WHERE no_rad=b.no_rad AND hasil_periksa!='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_rad as vtot 
			FROM pemeriksaan_radiologi b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_rad is not null
			GROUP BY no_rad ORDER BY tgl asc");
		}

		function get_hasil_rad_by_date($date){
			return $this->db->query("SELECT nama, a.no_rad, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_radiologi WHERE no_rad=a.no_rad AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_radiologi a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_rad is not null AND left(a.tgl_kunjungan,10)='$date'
			GROUP BY no_rad
			UNION
			SELECT nama, b.no_rad, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_radiologi WHERE no_rad=b.no_rad AND hasil_periksa!='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_rad as vtot 
			FROM pemeriksaan_radiologi b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_rad is not null AND left(b.tgl_kunjungan,10)='$date'
			GROUP BY no_rad ORDER BY tgl asc");
		}

		function get_hasil_rad_by_no($key){
			return $this->db->query("SELECT nama, a.no_rad, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_radiologi WHERE no_rad=a.no_rad AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_radiologi a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_rad is not null AND (a.tgl_kunjungan LIKE '%$key%' OR a.no_register LIKE '%$key%' OR data_pasien.nama LIKE '%$key%')
			GROUP BY no_rad
			UNION
			SELECT nama, b.no_rad, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_radiologi WHERE no_rad=b.no_rad AND hasil_periksa!='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_rad as vtot 
			FROM pemeriksaan_radiologi b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_rad is not null AND (b.tgl_kunjungan LIKE '%$key%' OR b.no_register LIKE '%$key%' OR pasien_luar.nama LIKE '%$key%')
			GROUP BY no_rad ORDER BY tgl asc
");
		}

		function getrow_hasil_rad($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi, data_pasien WHERE pemeriksaan_radiologi.no_medrec=data_pasien.no_medrec AND pemeriksaan_radiologi.no_register='".$no_register."' ");
		}	

		function get_data_pengisian_hasil($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi WHERE no_register='".$no_register."'  AND cetak_hasil='0' ORDER BY no_rad");
		}

		function get_banyak_hasil_rad($no_register){
			return $this->db->query("SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_radiologi WHERE no_register=".$no_register."' ");
		}

		function get_data_hasil_pemeriksaan($no_rad){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_radiologi.tgl_kunjungan, 10) as tgl FROM pemeriksaan_radiologi, data_pasien WHERE pemeriksaan_radiologi.no_medrec=data_pasien.no_medrec AND pemeriksaan_radiologi.no_rad='$no_rad' LIMIT 1");
		}

		function get_data_hasil_pemeriksaan_pasien_luar($no_rad){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_radiologi.tgl_kunjungan, 10) as tgl FROM pemeriksaan_radiologi, pasien_luar WHERE pemeriksaan_radiologi.no_register=pasien_luar.no_register AND pemeriksaan_radiologi.no_rad='$no_rad' LIMIT 1");
		}

		function get_data_isi_hasil_pemeriksaan($id_pemeriksaan_rad){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_radiologi.tgl_kunjungan, 10) as tgl FROM pemeriksaan_radiologi, data_pasien WHERE pemeriksaan_radiologi.no_medrec=data_pasien.no_medrec AND pemeriksaan_radiologi.id_pemeriksaan_rad='$id_pemeriksaan_rad'");
		}

		function get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_rad){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_radiologi.tgl_kunjungan, 10) as tgl FROM pemeriksaan_radiologi, pasien_luar WHERE pemeriksaan_radiologi.no_register=pasien_luar.no_register AND pemeriksaan_radiologi.id_pemeriksaan_rad='$id_pemeriksaan_rad'");
		}

		function get_data_tindakan_rad($id_tindakan){
			return $this->db->query("SELECT jenis_tindakan.nmtindakan as nm_tindakan, jenis_hasil_rad.* FROM jenis_hasil_rad, jenis_tindakan WHERE  jenis_hasil_rad.id_tindakan=jenis_tindakan.idtindakan AND id_tindakan='$id_tindakan'");
		}

		function get_data_tindakan_rad_id($id_pemeriksaan_rad){
			return $this->db->query("SELECT
										*
									FROM
										pemeriksaan_radiologi
									WHERE
										id_pemeriksaan_rad = '$id_pemeriksaan_rad'");
		}

		function isi_hasil($data){
			$this->db->insert('hasil_pemeriksaan_rad', $data);
			return true;	
		}

		function set_hasil_periksa($id_pemeriksaan_rad, $data){
			$this->db->where('id_pemeriksaan_rad', $id_pemeriksaan_rad);
			$this->db->update('pemeriksaan_radiologi', $data);
			return true;
		}

		function get_row_register($id_pemeriksaan_rad){
			return $this->db->query("SELECT no_register FROM pemeriksaan_radiologi WHERE id_pemeriksaan_rad='$id_pemeriksaan_rad'");
		}

		function get_data_edit_tindakan_rad($id_pemeriksaan_rad, $no_rad){
			return $this->db->query("SELECT * FROM hasil_pemeriksaan_rad WHERE  id_tindakan='$id_tindakan' AND no_rad='$no_rad'");
		}

		function get_no_register($no_rad){
			return $this->db->query("SELECT no_register FROM pemeriksaan_radiologi WHERE  no_rad='$no_rad' AND cetak_hasil='0' GROUP BY no_register");
		}

		function edit_hasil($id_hasil_pemeriksaan, $hasil_rad){
			return $this->db->query("UPDATE hasil_pemeriksaan_rad SET hasil_rad='$hasil_rad' WHERE id_hasil_pemeriksaan='$id_hasil_pemeriksaan'");
		}

		function update_status_cetak_hasil($no_rad){
			$this->db->query("UPDATE pemeriksaan_radiologi SET cetak_hasil='1' where no_rad='$no_rad'");
			return true;
		}

		function get_data_hasil_rad($no_rad){
			return $this->db->query("SELECT id_tindakan, no_rad, jenis_tindakan, hasil_periksa FROM pemeriksaan_radiologi WHERE no_rad='$no_rad'");
		}

		function get_data_pasien_cetak($no_rad){
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi a, data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_rad='$no_rad' GROUP BY no_rad");
		}

		function get_data_pasien_luar_cetak($no_rad){
			return $this->db->query("SELECT * FROM pemeriksaan_radiologi a, pasien_luar WHERE a.no_register=pasien_luar.no_register AND no_rad='$no_rad' GROUP BY no_rad");
		}

		//modul for labcdaftarhasil /////////////////////////////////////////////////////////////

		function get_hasil_rad_selesai(){
			return $this->db->query("SELECT
										nama ,
										RIGHT(a.no_medrec , 6) as no_medrec ,
										a.no_rad ,
										a.no_register ,
										a.tgl_kunjungan as tgl ,
										count(1) as banyak ,
										(
											SELECT
												COUNT(hasil_periksa) as hasil
											FROM
												pemeriksaan_radiologi
											WHERE
												no_rad = a.no_rad
											AND hasil_periksa != ''
										) as selesai ,
										cetak_kwitansi ,
										sum(vtot) as vtot
									FROM
										pemeriksaan_radiologi a ,
										data_pasien
									WHERE
										a.no_medrec = data_pasien.no_medrec
									AND cetak_hasil = '1'
									AND no_rad is not null
									-- AND LEFT(a.tgl_kunjungan,10)=LEFT(NOW(),10) 
									GROUP BY
										no_rad
									ORDER BY
											tgl asc ");
		}

		function get_hasil_rad_by_date_selesai($date){
			return $this->db->query("SELECT
										nama ,
										RIGHT(a.no_medrec , 6) as no_medrec ,
										a.no_rad ,
										a.no_register ,
										a.tgl_kunjungan as tgl ,
										count(1) as banyak ,
										(
											SELECT
												COUNT(hasil_periksa) as hasil
											FROM
												pemeriksaan_radiologi
											WHERE
												no_rad = a.no_rad
											AND hasil_periksa != ''
										) as selesai ,
										cetak_kwitansi ,
										sum(vtot) as vtot
									FROM
										pemeriksaan_radiologi a ,
										data_pasien
									WHERE
										a.no_medrec = data_pasien.no_medrec
									AND cetak_hasil = '1'
									AND no_rad is not null
									AND LEFT(b.tgl_kunjungan,10)=LEFT('$date',10) 
									GROUP BY
										no_rad
									ORDER BY
											tgl asc");
		}

		function get_hasil_rad_by_no_selesai($key){
			return $this->db->query("SELECT
										nama ,
										RIGHT(a.no_medrec , 6) as no_medrec ,
										a.no_rad ,
										a.no_register ,
										a.tgl_kunjungan as tgl ,
										count(1) as banyak ,
										(
											SELECT
												COUNT(hasil_periksa) as hasil
											FROM
												pemeriksaan_radiologi
											WHERE
												no_rad = a.no_rad
											AND hasil_periksa != ''
										) as selesai ,
										cetak_kwitansi ,
										sum(vtot) as vtot
									FROM
										pemeriksaan_radiologi a ,
										data_pasien
									WHERE
										a.no_medrec = data_pasien.no_medrec
									AND cetak_hasil = '1'
									AND no_rad is not null
									AND (a.tgl_kunjungan LIKE '%$key%' OR a.no_register LIKE '%$key%' OR data_pasien.nama LIKE '%$key%' OR data_pasien.no_medrec LIKE '%$key%')
									GROUP BY
										no_rad
									ORDER BY
											tgl asc");
		}
	}
?>

