<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class rjmlaporan extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		function get_data_kunj_all($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT * from sum_detail_jumlah_kunjungan where tanggal>='$tgl_awal' and tanggal<='$tgl_akhir'");
		}
		function get_data_iri_masuk_lt1($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(*) as total, tgldaftarri as tgl from pasien_iri where LEFT(idrg,1)='1' and tgldaftarri>='$tgl_awal' and tgldaftarri<='$tgl_akhir' GROUP BY tgldaftarri");
		}
		function get_data_iri_masuk_lt2($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(*) as total, tgldaftarri as tgl from pasien_iri where LEFT(idrg,1)='2' and tgldaftarri>='$tgl_awal' and tgldaftarri<='$tgl_akhir' GROUP BY tgldaftarri");
		}
		function get_data_iri_masuk_lt3($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(*) as total, tgldaftarri as tgl from pasien_iri where LEFT(idrg,1)='3' and tgldaftarri>='$tgl_awal' and tgldaftarri<='$tgl_akhir' GROUP BY tgldaftarri");
		}
		function get_data_iri_keluar_lt1($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(*) as total, tgl_keluar as tgl from pasien_iri where LEFT(idrg,1)='1' and tgl_keluar>='$tgl_awal' and tgl_keluar<='$tgl_akhir' GROUP BY tgl_keluar");
		}
		function get_data_iri_keluar_lt2($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(*) as total, tgl_keluar as tgl from pasien_iri where LEFT(idrg,1)='2' and tgl_keluar>='$tgl_awal' and tgl_keluar<='$tgl_akhir' GROUP BY tgl_keluar");
		}
		function get_data_iri_keluar_lt3($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(*) as total, tgl_keluar as tgl from pasien_iri where LEFT(idrg,1)='3' and tgl_keluar>='$tgl_awal' and tgl_keluar<='$tgl_akhir' GROUP BY tgl_keluar");
		}
		function get_data_ird_masuk($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(*) as total, tgl_kunjungan as tgl from irddaftar_ulang where Left(tgl_kunjungan,10)>='$tgl_awal' and Left(tgl_kunjungan,10)<='$tgl_akhir' GROUP BY Left(tgl_kunjungan,10)");
		}
		function get_data_irj_masuk($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(*) as total, tgl_kunjungan as tgl from daftar_ulang_irj where Left(tgl_kunjungan,10)>='$tgl_awal' and Left(tgl_kunjungan,10)<='$tgl_akhir' GROUP BY Left(tgl_kunjungan,10)");
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////kunjungan
		function get_pendapatan_perpoli($date_awal,$date_akhir){
			$data=$this->db->query("select b.id_poli, b.nm_poli, c.tanggal, ifnull(c.total,0) as total, ifnull(c.jumlah,0) as jumlah from poliklinik b left JOIN  
(SELECT a.tanggal, sum(a.penerimaan) as total, sum(a.jumlah_os) as jumlah, a.nm_poli , a.id_poli
FROM  v_pendapatan_rawat_jalan a 
where left(a.tanggal,16)>'2016-12-04' and left(a.tanggal,16)<'2016-12-18'
group by a.id_poli) as c
on c.id_poli=b.id_poli");
			return $data->result_array();
			//SELECT tanggal, sum(penerimaan) as total, sum(jumlah_os) as jumlah, nm_poli FROM v_pendapatan_rawat_jalan where left(tanggal,16)>'$date_awal' and left(tanggal,16)<'$date_akhir' 	group by id_poli
		}


			function get_kunj_pasien_detail($tgl_awal,$tgl_akhir){
			$data=$this->db->query("select * FROM  lap_kunj_pasien_irj_detail where tanggal between '$tgl_awal' and '$tgl_akhir'");
			return $data->result_array();
		}

		function get_data_kunj_harian($tgl, $id_poli,$cara_bayar){
			$textcb='';
			if($cara_bayar!='SEMUA'){				
				$textcb="and du.cara_bayar='$cara_bayar'";									
			}else $textcb='';
			return $this->db->query("SELECT du.no_register, du.no_medrec, dp.nama, dp.no_cm, du.cara_bayar, IFNULL(du.ket_pulang,'-') as ket_pulang,
										(SELECT diag.diagnosa  
										FROM diagnosa_pasien AS diag
										WHERE diag.no_register=du.no_register
										AND diag.klasifikasi_diagnos='utama') AS diagnosa,
										(SELECT kon.nmkontraktor  
										FROM kontraktor AS kon
										WHERE kon.id_kontraktor=du.id_kontraktor) AS kontraktor	
									FROM daftar_ulang_irj AS du
									LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
									WHERE LEFT(du.tgl_kunjungan,10) = '$tgl' AND du.id_poli='$id_poli' 
									$textcb
									ORDER BY no_register ");
		}
		
		function get_data_kunj_bulanan($bulan, $id_poli){
			return $this->db->query("SELECT DATE_FORMAT(LEFT(tgl_kunjungan,10),'%d-%m-%Y') AS tgl_kunj, count(*) AS jumlah_kunj,  COUNT(IF(jns_kunj = 'BARU',1,NULL)) as pasien_baru, COUNT(IF(jns_kunj = 'LAMA',1,NULL)) as pasien_lama, count(IF(cara_bayar='UMUM',1,NULL)) AS umum,count(if(id_kontraktor=301 and cara_bayar='DIJAMIN',1,null)) as bpjs, count(if(id_kontraktor!=301 and cara_bayar='DIJAMIN',1,null)) as penjamin, COUNT(IF(ket_pulang = 'BATAL_PELAYANAN_POLI', 1, NULL)) AS jumlah_batal
										FROM daftar_ulang_irj 
										WHERE left(tgl_kunjungan,7)='$bulan' AND id_poli='$id_poli'
										GROUP BY LEFT(tgl_kunjungan,10)");
		}
		
		function get_data_kunj_tahunan($tahun, $id_poli){
			return $this->db->query("SELECT SUBSTR(tgl_kunjungan,6,2) AS bulan_kunj, count(*) AS jumlah_kunj 
										FROM daftar_ulang_irj 
										WHERE SUBSTR(tgl_kunjungan,1,4)='$tahun' AND id_poli='$id_poli'
										GROUP BY SUBSTR(tgl_kunjungan,6,2)");
		}
		
		function get_data_kunj_poli_harian($tgl, $cara_bayar,$bayar_bpjs){
			$textbb='';
			if($cara_bayar!='SEMUA'){
				IF($cara_bayar=='DIJAMIN'){
					$textcb="and du.cara_bayar='DIJAMIN'";
				}else{
					$textcb="and du.cara_bayar='$cara_bayar'";
					if($bayar_bpjs!='SEMUA' && $cara_bayar=='BPJS'){
						$textbb="and du.id_kontraktor='".$bayar_bpjs."'";
					}
				}
			}else $textcb='';


			return $this->db->query("SELECT du.no_sep, du.cara_kunj, du.shift, du.id_poli, du.no_register, du.no_medrec, dp.nama, dp.no_cm, du.cara_bayar, IFNULL(dp.no_nrp,'-') as no_nrp, IFNULL(du.ket_pulang,'-') as ket_pulang, l.nm_dokter,
										(SELECT hub.hub_name  
										FROM tni_hubungan AS hub
										WHERE hub.hub_id=dp.nrp_sbg) AS nrp_sbg,
										(SELECT diag.diagnosa  
										FROM diagnosa_pasien AS diag
										WHERE diag.no_register=du.no_register
										AND diag.klasifikasi_diagnos='utama') AS diagnosa,
										(SELECT kon.nmkontraktor  
										FROM kontraktor AS kon
										WHERE kon.id_kontraktor=du.id_kontraktor) AS kontraktor
									FROM daftar_ulang_irj AS du
									LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
									LEFT JOIN
    data_dokter as l ON du.id_dokter=l.id_dokter
									WHERE LEFT(du.tgl_kunjungan,10) = '$tgl' $textcb $textbb
									ORDER BY no_register, id_poli");
		}
		
		function get_data_kunj_poli_bulanan($bulan){
			return $this->db->query("SELECT id_poli, DATE_FORMAT(LEFT(tgl_kunjungan,10),'%d-%m-%Y') AS tgl_kunj, count(*) AS jumlah_kunj, COUNT(IF(jns_kunj = 'BARU',1,NULL)) as pasien_baru, COUNT(IF(jns_kunj = 'LAMA',1,NULL)) as pasien_lama, count(IF(cara_bayar='UMUM',1,NULL)) AS umum, count(if(id_kontraktor=301 and cara_bayar='DIJAMIN',1,null)) as bpjs, count(if(id_kontraktor!=301 and cara_bayar='DIJAMIN',1,null)) as penjamin, COUNT(IF(ket_pulang = 'BATAL_PELAYANAN_POLI', 1, NULL)) AS jumlah_batal  
										FROM daftar_ulang_irj 
										WHERE left(tgl_kunjungan,7)='$bulan'
										GROUP BY LEFT(tgl_kunjungan,10), id_poli");
		}
		
		function get_data_kunj_poli_tahunan($tahun){
			return $this->db->query("SELECT id_poli, SUBSTR(tgl_kunjungan,6,2) AS bulan_kunj, count(*) AS jumlah_kunj
										FROM daftar_ulang_irj 
										WHERE SUBSTR(tgl_kunjungan,1,4)='$tahun'
										GROUP BY SUBSTR(tgl_kunjungan,6,2), id_poli");
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////keuangan
		function get_data_keu_harian($tgl, $tgl1, $id_poli){
			
			return $this->db->query("SELECT du.no_register, du.no_medrec, dp.nama, dp.no_cm, IF(du.status=1,'PULANG','DIRAWAT') as status, du.biayadaftar, du.vtot, du.cara_bayar, IFNULL(du.tunai,'0') as tunai, IFNULL(du.diskon,'0') as diskon, IFNULL(du.vtot_lab,0) as vtot_lab, IFNULL(du.vtot_rad,0) as vtot_rad, IFNULL(du.vtot_ok,0) as vtot_ok, IFNULL(du.vtot_pa,0) as vtot_pa, IFNULL(du.vtot_obat,0) as vtot_obat, (SELECT nmkontraktor from kontraktor where id_kontraktor=du.id_kontraktor)	as nmkontraktor
									FROM daftar_ulang_irj AS du
									LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
									WHERE LEFT(du.tgl_kunjungan,10)>= '$tgl' 
									AND LEFT(du.tgl_kunjungan,10)<= '$tgl1'
									AND du.id_poli='$id_poli' 
									ORDER BY no_register 
									");
		}
		
		function get_data_keu_bulanan($bulan, $id_poli, $status, $cara_bayar){
			$select_status = ""; 
			if ($status!='10') {
				$select_status = " AND status = '$status'"; 
			}
			
			$select_cara_bayar = ""; 
			if ($cara_bayar!='' && $cara_bayar!='SEMUA' ) {
				$select_cara_bayar = " AND cara_bayar = '$cara_bayar'"; 
			}
			
			return $this->db->query("SELECT DATE_FORMAT(LEFT(tgl_kunjungan,10),'%d-%m-%Y') AS tgl_kunj, count(*) AS jumlah_kunj,
										sum(vtot) AS jumlah_vtot, sum(biayadaftar) AS jumlah_biayadaftar
										FROM daftar_ulang_irj 
										WHERE SUBSTR(tgl_kunjungan,6,2)='$bulan' AND id_poli='$id_poli' $select_status $select_cara_bayar
										GROUP BY LEFT(tgl_kunjungan,10)");
		}
		
		function get_data_keu_tahunan($tahun, $id_poli, $status, $cara_bayar){
			$select_status = ""; 
			if ($status!='10') {
				$select_status = " AND status = '$status'"; 
			}
			
			$select_cara_bayar = ""; 
			if ($cara_bayar!='' && $cara_bayar!='SEMUA' ) {
				$select_cara_bayar = " AND cara_bayar = '$cara_bayar'"; 
			}
			
			return $this->db->query("SELECT SUBSTR(tgl_kunjungan,6,2) AS bulan_kunj,
										sum(vtot) AS jumlah_vtot, sum(biayadaftar) AS jumlah_biayadaftar, count(*) AS jumlah_kunj
										FROM daftar_ulang_irj 
										WHERE SUBSTR(tgl_kunjungan,1,4)='$tahun' AND id_poli='$id_poli' $select_status $select_cara_bayar
										GROUP BY SUBSTR(tgl_kunjungan,6,2)");
		}
		
		function get_data_keu_poli_harian($tgl,$tgl1){			
			return $this->db->query("SELECT du.id_poli, du.no_register,dp.no_cm, du.no_medrec, dp.nama, IF(du.status=1,'PULANG','DIRAWAT') as status, du.biayadaftar, du.vtot, IFNULL(du.vtot_lab,0) as vtot_lab, IFNULL(du.vtot_rad,0) as vtot_rad, IFNULL(du.vtot_pa,0) as vtot_pa, IFNULL(du.vtot_obat,0) as vtot_obat, du.cara_bayar, IFNULL(du.tunai,'0') as tunai, IFNULL(du.vtot_ok,0) as vtot_ok, IFNULL(du.diskon,'0') as diskon, (SELECT nmkontraktor from kontraktor where id_kontraktor=du.id_kontraktor)	as nmkontraktor
									FROM daftar_ulang_irj AS du
									LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
									WHERE LEFT(du.tgl_kunjungan,10)>= '$tgl' and LEFT(du.tgl_kunjungan,10)<= '$tgl1' 
									ORDER BY no_register,id_poli ");
		}

		function cek_data_keu_poli_harian($tgl,$tgl0){
			return $this->db->query("SELECT p.nm_poli,du.id_poli, du.no_register,dp.no_cm, du.no_medrec, dp.nama, IF(du.status=1,'PULANG','DIRAWAT') as status, du.biayadaftar, du.vtot, IFNULL(du.vtot_lab,0) as vtot_lab, IFNULL(du.vtot_rad,0) as vtot_rad, IFNULL(du.vtot_pa,0) as vtot_pa, IFNULL(du.vtot_obat,0) as vtot_obat, du.cara_bayar, IFNULL(du.tunai,'0') as tunai, IFNULL(du.vtot_ok,0) as vtot_ok, IFNULL(du.diskon,'0') as diskon, (SELECT nmkontraktor from kontraktor where id_kontraktor=du.id_kontraktor)	as nmkontraktor
									FROM daftar_ulang_irj AS du
									LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
									LEFT JOIN poliklinik AS p ON du.id_poli = p.id_poli
									WHERE LEFT(du.tgl_kunjungan,10)>= '$tgl' and LEFT(du.tgl_kunjungan,10)<= '$tgl0' 
									ORDER BY no_register,id_poli");
		}
		
		function get_data_keu_poli_bulanan($bulan,$status,$cara_bayar){
			$select_status = ""; 
			if ($status!='10') {
				$select_status = " AND status = '$status'"; 
			}
			
			$select_cara_bayar = ""; 
			if ($cara_bayar!='' && $cara_bayar!='SEMUA' ) {
				$select_cara_bayar = " AND cara_bayar = '$cara_bayar'"; 
			}
			
			return $this->db->query("SELECT id_poli, DATE_FORMAT(LEFT(tgl_kunjungan,10),'%d-%m-%Y') AS tgl_kunj, 
										sum(vtot) AS jumlah_vtot, sum(biayadaftar) AS jumlah_biayadaftar, count(*) AS jumlah_kunj, sum(vtot_lab) as jumlah_lab, sum(vtot_rad) as jumlah_rad,
										sum(vtot_obat) as jumlah_obat
										FROM daftar_ulang_irj 
										WHERE SUBSTR(tgl_kunjungan,6,2)='$bulan' $select_status $select_cara_bayar
										GROUP BY LEFT(tgl_kunjungan,10), id_poli");
		}
		
		function get_data_keu_poli_tahunan($tahun,$status,$cara_bayar){
			//MONTHNAME(LEFT(tgl_kunjungan,10))
			$select_status = ""; 
			if ($status!='10') {
				$select_status = " AND status = '$status'"; 
			}
			
			$select_cara_bayar = ""; 
			if ($cara_bayar!='' && $cara_bayar!='SEMUA' ) {
				$select_cara_bayar = " AND cara_bayar = '$cara_bayar'"; 
			}
			
			return $this->db->query("SELECT id_poli, SUBSTR(tgl_kunjungan,6,2) AS bulan_kunj, 
										sum(vtot) AS jumlah_vtot, sum(biayadaftar) AS jumlah_biayadaftar, count(*) AS jumlah_kunj
										FROM daftar_ulang_irj 
										WHERE SUBSTR(tgl_kunjungan,1,4)='$tahun' $select_status $select_cara_bayar
										GROUP BY SUBSTR(tgl_kunjungan,6,2), id_poli");
		}
		
		////////////////////////////////////////////////////////////////////////////////////////////////////////LAP KEUANGAN
		function get_data_keu_dokter($id_dokter, $tgl_awal,$tgl_akhir, $cara_bayar){
			
			$select="";
			if ($id_dokter!='SEMUA') {
				$select=" AND id_dokter='$id_dokter' ";
			}
			$select_cara_bayar = ""; 
			if ($cara_bayar!='' && $cara_bayar!='SEMUA' ) {
				$select_cara_bayar = " AND cara_bayar = '$cara_bayar'"; 
			}
			return $this->db->query("Select * from (SELECT * FROM tindakan_all 
										WHERE tgl>='$tgl_awal' AND tgl<='$tgl_akhir' $select $select_cara_bayar
										ORDER BY tgl) as a, data_dokter b where a.id_dokter=b.id_dokter");
		}
		
		function get_data_keu_det_dokter($id_dokter, $tgl_awal,$tgl_akhir, $cara_bayar){
			
			$select_cara_bayar = ""; 
			if ($cara_bayar!='' && $cara_bayar!='SEMUA' ) {
				$select_cara_bayar = " AND cara_bayar = '$cara_bayar'"; 
			}
			return $this->db->query("Select * from (SELECT * FROM tindakan_all 
										WHERE tgl>='$tgl_awal' AND tgl<='$tgl_akhir' $select_cara_bayar
										ORDER BY tgl) as a, data_dokter b where a.id_dokter=b.id_dokter group by a.id_dokter");
		}
		function get_nm_dokter($id_dokter){

			return $this->db->query("SELECT nm_dokter FROM data_dokter 
										WHERE id_dokter='$id_dokter'");
		}
	}
?>
