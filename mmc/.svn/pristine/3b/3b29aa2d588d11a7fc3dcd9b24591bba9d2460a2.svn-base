<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Labmdaftar extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//modul for labcdaftar
		function get_daftar_pasien_lab(){
			return $this->db->query("SELECT pemeriksaan_lab.no_register, data_pasien.no_cm as no_medrec, pemeriksaan_lab.tgl_kunjungan as tgl_kunjungan, pemeriksaan_lab.jadwal_lab as jadwal_lab, pemeriksaan_lab.kelas, pemeriksaan_lab.idrg, pemeriksaan_lab.bed, data_pasien.nama as nama  
							FROM pemeriksaan_lab, data_pasien 
							WHERE pemeriksaan_lab.no_medrec=data_pasien.no_medrec
							AND LEFT(pemeriksaan_lab.jadwal_lab,10)=LEFT(NOW(),10)
							order by tgl_kunjungan asc
						");
		}

		function get_daftar_pasien_lab_by_date($date){
			return $this->db->query("SELECT
									pemeriksaan_lab.no_register ,
									data_pasien.no_cm as no_medrec ,
									pemeriksaan_lab.tgl_kunjungan ,
									pemeriksaan_lab.kelas ,
									pemeriksaan_lab.idrg ,
									pemeriksaan_lab.bed ,
									data_pasien.nama as nama
									FROM
									pemeriksaan_lab ,
									data_pasien
									WHERE
									pemeriksaan_lab.no_medrec = data_pasien.no_medrec
									AND
									LEFT(pemeriksaan_lab.jadwal_lab , 10) = '$date'
									ORDER BY
									tgl_kunjungan DESC");
		}

		function get_daftar_pasien_lab_by_no($key){
			return $this->db->query("SELECT pemeriksaan_lab.no_register, data_pasien.no_cm as no_medrec, pemeriksaan_lab.tgl_kunjungan, pemeriksaan_lab.kelas, pemeriksaan_lab.idrg, pemeriksaan_lab.bed, data_pasien.nama as nama  
										FROM pemeriksaan_lab, data_pasien 
										WHERE pemeriksaan_lab.no_medrec=data_pasien.no_medrec 
										AND (data_pasien.nama LIKE '%$key%' OR pemeriksaan_lab.no_register LIKE '%$key%')
									UNION
										SELECT pemeriksaan_lab.no_register, pemeriksaan_lab.no_medrec, pemeriksaan_lab.tgl_kunjungan, pemeriksaan_lab.kelas, pemeriksaan_lab.idrg, pemeriksaan_lab.bed, pasien_luar.nama as nama  
										FROM pemeriksaan_lab, pasien_luar 
										WHERE pemeriksaan_lab.no_register=pasien_luar.no_register 
										AND (pasien_luar.nama LIKE '%$key%' OR pemeriksaan_lab.no_register LIKE '%$key%')
										ORDER BY tgl_kunjungan DESC");
		}

		function get_data_pasien_pemeriksaan($no_register){
			return $this->db->query("SELECT *  FROM pemeriksaan_lab, data_pasien WHERE pemeriksaan_lab.no_medrec=data_pasien.no_medrec AND pemeriksaan_lab.no_register='$no_register'");
		}

		function get_data_pasien_kontraktor_irj($no_register){
			return $this->db->query("SELECT nmkontraktor FROM daftar_ulang_irj, kontraktor WHERE daftar_ulang_irj.id_kontraktor=kontraktor.id_kontraktor AND daftar_ulang_irj.no_register='$no_register'");
		}

		function get_data_pasien_kontraktor_iri($no_register){
			return $this->db->query("SELECT nmkontraktor FROM pasien_iri, kontraktor WHERE pasien_iri.id_kontraktor=kontraktor.id_kontraktor AND pasien_iri.no_ipd='$no_register'");
		}

		function get_data_pasien_luar_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_lab, pasien_luar WHERE pemeriksaan_lab.no_register=pasien_luar.no_register AND pemeriksaan_lab.no_register='$no_register'");
		}

		function get_data_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_laboratorium WHERE no_register='$no_register' AND no_lab IS NULL");
		}

		function getdata_tindakan_pasien2($no_register){
			return $this->db->query("SELECT * FROM tarif_tindakan, jenis_tindakan, pemeriksaan_lab where pemeriksaan_lab.no_register='$no_register' and tarif_tindakan.kelas=pemeriksaan_lab.kelas and jenis_tindakan.idtindakan=tarif_tindakan.id_tindakan and tarif_tindakan.id_tindakan LIKE 'h%'");
		}

		function getdata_tindakan_pasien(){
			return $this->db->query("SELECT * FROM jenis_tindakan_lab ORDER BY nmtindakan asc");
		}

		function get_biaya_tindakan($id,$kelas){
			return $this->db->query("SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan='".$id."' AND kelas = '".$kelas."'");
		}

		function get_roleid($userid){
			return $this->db->query("Select roleid from dyn_role_user where userid = '".$userid."'");
		}

		function getdata_dokter(){
			return $this->db->query("SELECT  a.id_dokter, a.nm_dokter FROM data_dokter as a LEFT JOIN dokter_poli as b ON a.id_dokter=b.id_dokter WHERE a.ket = 'Patologi Klinik' or b.id_poli='HA00'");
		}

		function getnama_poli($id_poli){
			return $this->db->query("SELECT nm_poli FROM poliklinik WHERE id_poli='$id_poli'");
		}

		function getnm_dokter($no_register){
			return $this->db->query("SELECT b.nm_dokter FROM daftar_ulang_irj as a
				LEFT JOIN data_dokter as b
				ON b.id_dokter=a.id_dokter
				WHERE no_register='$no_register'");
		}

		function getcr_bayar_bpjs($no_register){
			return $this->db->query("SELECT b.nmkontraktor as b FROM daftar_ulang_irj as a
				LEFT JOIN kontraktor as b
				ON b.id_kontraktor=a.id_kontraktor
				WHERE no_register='$no_register'");
		}

		function getcr_bayar_dijamin($no_register){
			return $this->db->query("SELECT a.cara_bayar as a, b.nmkontraktor as b FROM daftar_ulang_irj as a
				LEFT JOIN kontraktor as b
				ON b.id_kontraktor=a.id_kontraktor
				WHERE no_register='$no_register'");
		}

		function getruang($idrg){
			return $this->db->query("SELECT nmruang FROM ruang WHERE idrg='$idrg'");
		}

		function getnama_dokter($id_dokter){
			return $this->db->query("SELECT * FROM data_dokter WHERE id_dokter='".$id_dokter."' ");
		}

		function getjenis_tindakan($id_tindakan){
			return $this->db->query("SELECT * FROM jenis_tindakan WHERE idtindakan='".$id_tindakan."' ");
		}

		function insert_pemeriksaan($data){
			$this->db->insert('pemeriksaan_laboratorium', $data);
			return true;
		}

		function selesai_daftar_pemeriksaan_PL($no_register,$getvtotlab,$no_lab){
			$this->db->query("UPDATE pemeriksaan_laboratorium SET no_lab='$no_lab' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pasien_luar SET lab=0, vtot_lab='$getvtotlab' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotlab,$no_lab){
			$this->db->query("UPDATE pemeriksaan_laboratorium SET no_lab='$no_lab' WHERE no_register='$no_register'");
			$this->db->query("UPDATE daftar_ulang_irj SET lab=0, status_lab=1, vtot_lab='$getvtotlab' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRD($no_register,$getvtotlab,$no_lab){
			$this->db->query("UPDATE pemeriksaan_laboratorium SET no_lab='$no_lab' WHERE no_register='$no_register'");
			$this->db->query("UPDATE irddaftar_ulang SET lab=0, status_lab=1, vtot_lab='$getvtotlab' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRI($no_register,$status_lab,$vtot_lab,$no_lab){
			$this->db->query("UPDATE pemeriksaan_laboratorium SET no_lab=IF(no_lab IS NULL, '$no_lab', no_lab) WHERE no_register='$no_register'");
			$this->db->query("UPDATE pasien_iri SET lab=0, status_lab='$status_lab', vtot_lab='$vtot_lab' WHERE no_ipd='$no_register'");
			return true;
		}

		function getdata_iri($no_register){
			return $this->db->query("SELECT status_lab FROM pasien_iri WHERE no_ipd='".$no_register."'");
		}

		function get_vtot_lab($no_register){
			return $this->db->query("SELECT SUM(vtot) as vtot_lab FROM pemeriksaan_laboratorium WHERE no_register='".$no_register."'");
		}

		function get_vtot_no_lab($no_lab){
			return $this->db->query("SELECT SUM(vtot) as vtot_no_lab FROM pemeriksaan_laboratorium WHERE no_lab='".$no_lab."'");
		}

		function hapus_data_pemeriksaan($id_pemeriksaan_lab){
			$this->db->where('id_pemeriksaan_lab', $id_pemeriksaan_lab);
       		$this->db->delete('pemeriksaan_laboratorium');			
			return true;
		}	

		function insert_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("INSERT INTO lab_header (no_register, idrg, bed, kelas) VALUES ('$no_register','$idrg','$bed','$kelas')");
		}	

		function get_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("SELECT no_lab FROM lab_header WHERE no_register='$no_register' AND idrg='$idrg' AND bed='$bed' AND kelas='$kelas' ORDER BY no_lab DESC LIMIT 1");
		}

		function insert_pasien_luar($data){
			$this->db->insert('pasien_luar', $data);
			return true;
		}

		function get_new_register(){
			return $this->db->query("SELECT max(right(no_register,6)) as counter, mid(now(),3,2) as year from pasien_luar where mid(no_register,3,2) = (select mid(now(),3,2))");
		}


		//modul for labcpengisianhasil /////////////////////////////////////////////////////////////

		function get_hasil_lab(){
			return $this->db->query("SELECT nama, a.no_lab, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=a.no_lab AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_laboratorium a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_lab is not null
			GROUP BY no_lab
			UNION
			SELECT nama, b.no_lab, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=b.no_lab AND hasil_periksa!='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_lab as vtot 
			FROM pemeriksaan_laboratorium b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_lab is not null
			GROUP BY no_lab ORDER BY tgl asc");
		}

		function get_hasil_lab_by_date($date){
			return $this->db->query("SELECT nama, a.no_lab, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=a.no_lab AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_laboratorium a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_lab is not null AND left(a.tgl_kunjungan,10)  = '$date'
			GROUP BY no_lab
			UNION
			SELECT nama, b.no_lab, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=b.no_lab AND hasil_periksa!='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_lab as vtot 
			FROM pemeriksaan_laboratorium b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_lab is not null AND left(b.tgl_kunjungan,10)  = '$date'
			GROUP BY no_lab ORDER BY tgl asc");
		}

		function get_hasil_lab_by_no($key){
			return $this->db->query("SELECT nama, a.no_lab, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=a.no_lab AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_laboratorium a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='0' AND no_lab is not null AND (a.tgl_kunjungan LIKE '%$key%' OR a.no_register LIKE '%$key%' OR data_pasien.nama LIKE '%$key%')
			GROUP BY no_lab
			UNION
			SELECT nama, b.no_lab, b.no_register, b.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=b.no_lab AND hasil_periksa!='') as selesai, pasien_luar.cetak_kwitansi as cetak_kwitansi, vtot_lab as vtot 
			FROM pemeriksaan_laboratorium b, pasien_luar 
			WHERE b.no_register=pasien_luar.no_register AND cetak_hasil='0' AND no_lab is not null AND (b.tgl_kunjungan LIKE '%$key%' OR b.no_register LIKE '%$key%' OR pasien_luar.nama LIKE '%$key%')
			GROUP BY no_lab ORDER BY tgl asc");
		}

		function getrow_hasil_lab($no_register){
			return $this->db->query("SELECT * FROM pemeriksaan_laboratorium, data_pasien WHERE pemeriksaan_laboratorium.no_medrec=data_pasien.no_medrec AND pemeriksaan_laboratorium.no_register='".$no_register."' ");
		}	

		function get_row_register($id_pemeriksaan_lab){
			return $this->db->query("SELECT no_register FROM pemeriksaan_laboratorium WHERE id_pemeriksaan_lab='$id_pemeriksaan_lab'");
		}

		function get_row_register_by_nolab($no_lab){
			return $this->db->query("SELECT no_register FROM pemeriksaan_laboratorium WHERE no_lab='$no_lab' LIMIT 1");
		}

		function get_row_hasil($no_lab){
			return $this->db->query("SELECT * FROM hasil_pemeriksaan_lab WHERE no_lab='$no_lab' LIMIT 1");
		}

		function get_data_pengisian_hasil($no_lab){
			return $this->db->query("SELECT * FROM pemeriksaan_laboratorium WHERE no_lab='".$no_lab."'  AND cetak_hasil='0' ORDER BY no_lab");
		}

		function get_isi_hasil($no_lab){
			return $this->db->query("SELECT a.id_tindakan, a.jenis_tindakan, b.* FROM pemeriksaan_laboratorium as a 
				LEFT JOIN jenis_hasil_lab as b ON a.id_tindakan=b.id_tindakan 
				WHERE a.no_lab='".$no_lab."'");
		}

		function get_edit_hasil($no_lab){
			return $this->db->query("SELECT a.*, b.nmtindakan FROM hasil_pemeriksaan_lab as a LEFT JOIN jenis_tindakan as b ON a.id_tindakan=b.idtindakan WHERE no_lab='".$no_lab."'");
		}

		function get_banyak_hasil_lab($no_register){
			return $this->db->query("SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_register=".$no_register."' ");
		}

		function get_data_hasil_pemeriksaan($no_lab){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_laboratorium.tgl_kunjungan, 10) as tgl FROM pemeriksaan_laboratorium, data_pasien WHERE pemeriksaan_laboratorium.no_medrec=data_pasien.no_medrec AND pemeriksaan_laboratorium.no_lab='$no_lab' LIMIT 1");
		}

		function get_data_hasil_pemeriksaan_pasien_luar($no_lab){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_laboratorium.tgl_kunjungan, 10) as tgl FROM pemeriksaan_laboratorium, pasien_luar WHERE pemeriksaan_laboratorium.no_register=pasien_luar.no_register AND pemeriksaan_laboratorium.no_lab='$no_lab' LIMIT 1");
		}

		function get_data_isi_hasil_pemeriksaan($id_pemeriksaan_lab){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_laboratorium.tgl_kunjungan, 10) as tgl FROM pemeriksaan_laboratorium, data_pasien WHERE pemeriksaan_laboratorium.no_medrec=data_pasien.no_medrec AND pemeriksaan_laboratorium.id_pemeriksaan_lab='$id_pemeriksaan_lab'");
		}

		function get_data_tindakan_lab($id_tindakan){
			return $this->db->query("SELECT jenis_tindakan.nmtindakan as nm_tindakan, jenis_hasil_lab.* FROM jenis_hasil_lab, jenis_tindakan WHERE  jenis_hasil_lab.id_tindakan=jenis_tindakan.idtindakan AND id_tindakan='$id_tindakan'");
		}

		function isi_hasil($data){
			$this->db->insert('hasil_pemeriksaan_lab', $data);
			return true;	
		}

		function set_hasil_periksa($id_pemeriksaan_lab){
			return $this->db->query("UPDATE pemeriksaan_laboratorium SET hasil_periksa=1 WHERE id_pemeriksaan_lab='$id_pemeriksaan_lab'");
		}

		function get_data_isi_hasil_pemeriksaan_pasien_luar($id_pemeriksaan_lab){
			return $this->db->query("SELECT *, LEFT(pemeriksaan_laboratorium.tgl_kunjungan, 10) as tgl FROM pemeriksaan_laboratorium, pasien_luar WHERE pemeriksaan_laboratorium.no_register=pasien_luar.no_register AND pemeriksaan_laboratorium.id_pemeriksaan_lab='$id_pemeriksaan_lab'");
		}

		function get_data_edit_tindakan_lab($id_tindakan, $no_lab){
			return $this->db->query("SELECT * FROM hasil_pemeriksaan_lab WHERE  id_tindakan='$id_tindakan' AND no_lab='$no_lab'");
		}

		function get_no_register($no_lab){
			return $this->db->query("SELECT no_register FROM pemeriksaan_laboratorium WHERE  no_lab='$no_lab' AND cetak_hasil='0' GROUP BY no_register");
		}

		function edit_hasil($id_hasil_pemeriksaan, $hasil_lab){
			return $this->db->query("UPDATE hasil_pemeriksaan_lab SET hasil_lab='$hasil_lab' WHERE id_hasil_pemeriksaan='$id_hasil_pemeriksaan'");
		}

		function update_status_cetak_hasil($no_lab){
			$this->db->query("UPDATE pemeriksaan_laboratorium SET cetak_hasil='1' where no_lab='$no_lab'");
			return true;
		}

		function get_jenis_lab(){
			return $this->db->query("SELECT * FROM jenis_lab");
		}

		function get_data_kategori_lab($no_lab){
			return $this->db->query("SELECT LEFT(a.id_tindakan,2) AS kode_jenis, b.nama_jenis
				FROM hasil_pemeriksaan_lab as a
				LEFT JOIN jenis_lab as b
				ON LEFT(a.id_tindakan,2)=b.kode_jenis
				WHERE no_lab='$no_lab' AND hasil_lab!='' 
				GROUP BY LEFT(id_tindakan,2)");
		}

		function get_blanko_kategori_lab($no_lab){
			return $this->db->query("SELECT LEFT(a.id_tindakan,2) AS kode_jenis, b.nama_jenis
				FROM pemeriksaan_laboratorium as a
				LEFT JOIN jenis_lab as b
				ON LEFT(a.id_tindakan,2)=b.kode_jenis
				WHERE no_lab='$no_lab'
				GROUP BY LEFT(id_tindakan,2)");
		}

		function get_data_jenis_lab($no_lab){
			return $this->db->query("SELECT a.id_tindakan, a.no_lab, b.nmtindakan FROM hasil_pemeriksaan_lab a, jenis_tindakan b WHERE a.id_tindakan=b.idtindakan AND no_lab='$no_lab' AND hasil_lab!=''  GROUP BY id_tindakan");
		}

		function get_blanko_jenis_lab($no_lab){
			return $this->db->query("SELECT a.id_tindakan, a.no_lab, b.nmtindakan FROM pemeriksaan_laboratorium a, jenis_tindakan b WHERE a.id_tindakan=b.idtindakan AND no_lab='$no_lab' GROUP BY id_tindakan");
		}

		function get_data_hasil_lab($id_tindakan,$no_lab){
			return $this->db->query("SELECT * FROM hasil_pemeriksaan_lab WHERE id_tindakan='$id_tindakan' AND no_lab='$no_lab' AND hasil_lab!=''");
		}

		function get_blanko_hasil_lab($id_tindakan){
			return $this->db->query("SELECT * FROM jenis_hasil_lab WHERE id_tindakan='$id_tindakan'");
		}

		function get_data_pasien_cetak($no_lab){
			return $this->db->query("SELECT * FROM pemeriksaan_laboratorium a, data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_lab='$no_lab' GROUP BY no_lab");
		}

		function get_data_pasien_luar_cetak($no_lab){
			return $this->db->query("SELECT * FROM pemeriksaan_laboratorium a, data_pasien WHERE a.no_medrec=data_pasien.no_medrec AND no_lab='$no_lab' GROUP BY no_lab");
		}

		//modul for labcdaftarhasil /////////////////////////////////////////////////////////////

		function get_hasil_lab_selesai(){
			return $this->db->query("SELECT nama, RIGHT(a.no_medrec,6) as no_medrec, a.no_lab, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=a.no_lab AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_laboratorium a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='1' AND no_lab is not null AND LEFT(a.tgl_kunjungan,10)=LEFT(NOW(),10) 
			GROUP BY no_lab");
		}

		function get_hasil_lab_by_date_selesai($date){
			return $this->db->query("SELECT nama, RIGHT(a.no_medrec,6) as no_medrec, a.no_lab, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=a.no_lab AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_laboratorium a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='1' AND no_lab is not null AND left(a.tgl_kunjungan,10)  = '$date'
			GROUP BY no_lab");
		}

		function get_hasil_lab_by_no_selesai($key){
			return $this->db->query("SELECT nama, RIGHT(a.no_medrec,6) as no_medrec, a.no_lab, a.no_register, a.tgl_kunjungan as tgl, count(1) as banyak, (SELECT COUNT(hasil_periksa) as hasil FROM pemeriksaan_laboratorium WHERE no_lab=a.no_lab AND hasil_periksa!='') as selesai, cetak_kwitansi, sum(vtot) as vtot 
			FROM pemeriksaan_laboratorium a, data_pasien 
			WHERE a.no_medrec=data_pasien.no_medrec AND cetak_hasil='1' AND no_lab is not null AND (a.tgl_kunjungan LIKE '%$key%' OR a.no_register LIKE '%$key%' OR data_pasien.nama LIKE '%$key%' OR data_pasien.no_medrec LIKE '%$key%')
			GROUP BY no_lab");
		}
	}
?>
