<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class ModelLaporan extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////kunjungan
		function get_data_kunj_today(){
			return $this->db->query("
SELECT du.no_register, du.no_medrec, dp.nama, dp.no_cm, du.cara_bayar,
	(SELECT diag.diagnosa  
	FROM diagnosa_ird AS diag
	WHERE diag.no_register=du.no_register
	AND diag.klasifikasi_diagnos='utama') AS diagnosa
	FROM irddaftar_ulang AS du
	LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
	WHERE LEFT(du.tgl_kunjungan,10) = left(now(),10)
	ORDER BY no_register
");
		}
		function get_data_kunj_range($tgl,$cara_bayar){
			if($cara_bayar!='SEMUA'){
				IF($cara_bayar=='DIJAMIN'){
					$textcb="and du.cara_bayar='DIJAMIN / JAMSOSKES'";
				}else
					$textcb="and du.cara_bayar='$cara_bayar'";
			}else $textcb="";
			return $this->db->query("SELECT du.no_register, LPAD( du.no_medrec, 6, '0') as no_medrec, dp.no_cm, du.cara_bayar 	 , dp.nama, 
					(SELECT diag.id_diagnosa  
					FROM diagnosa_ird AS diag
					WHERE diag.no_register=du.no_register
					AND diag.klasifikasi_diagnos='utama') AS id_diagnosa, 
					(SELECT diag.diagnosa  
					FROM diagnosa_ird AS diag
					WHERE diag.no_register=du.no_register
					AND diag.klasifikasi_diagnos='utama') AS diagnosa
					FROM irddaftar_ulang AS du
					LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec					
					where left(du.tgl_kunjungan,10)='$tgl' $textcb
					ORDER BY no_register");
		}
		// function get_data_kunj_all($tgl_awal,$tgl_akhir){
			// return $this->db->query("SELECT count(no_register) as kunj_all from irddaftar_ulang where left(irddaftar_ulang.tgl_kunjungan,10)>='$tgl_awal' and left(irddaftar_ulang.tgl_kunjungan,10)<='$tgl_akhir'");
		// }
		//////////////////////////////////////////////////////////////////////////////////////keuangan+status daftar_ulang selesai
		function get_data_keu_tindakan_today(){
			return $this->db->query("SELECT A.no_medrec,  A.biayadaftar,A.no_register, C.no_cm, A.cara_bayar, C.nama, A.tgl_kunjungan,  B.idtindakan,COUNT(B.idtindakan) as tot_tind, SUM(B.vtot) as total, COALESCE(A.diskon, 0) as diskon, A.status
from irddaftar_ulang A,  tindakan_ird B, data_pasien C
where  A.no_register=B.no_register 
and A.no_medrec=C.no_medrec
and left(B.tgl_kunjungan,10)=left(now(),10)
GROUP BY A.no_register");
		}
		function get_data_keu_tind_in($tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT A.no_medrec, A.status, A.biayadaftar,A.no_register, C.no_cm, C.nama, B.tgl_kunjungan,  B.idtindakan,COUNT(B.idtindakan) as tot_tind, SUM(B.vtot) as total
from irddaftar_ulang A,  tindakan_ird B, data_pasien C
where  A.no_register=B.no_register 
and A.no_medrec=C.no_medrec
and left(B.tgl_kunjungan,10)>='$tgl_awal' 
and left(B.tgl_kunjungan,10)<='$tgl_akhir'
GROUP BY A.no_register");
		}
		// function get_data_keu_all($tgl_awal,$tgl_akhir){
			// return $this->db->query("SELECT coalesce(sum(pelayanan_poli.biaya_poli),0) as keu_all from pelayanan_poli, irddaftar_ulang where irddaftar_ulang.no_register=pelayanan_poli.no_register and left(irddaftar_ulang.tgl_kunjungan,10)>='$tgl_awal' and left(irddaftar_ulang.tgl_kunjungan,10)<='$tgl_akhir'");
		// }
		/////////////////////////////////////////////////////////////////////////////////////////kunj pilih poli
		function get_data_kunj_poli_tgl($id_poli,$tgl){
			return $this->db->query("SELECT data_pasien.no_medrec as val_field1, count(irddaftar_ulang.no_register) as jum_kunj from data_pasien, irddaftar_ulang where data_pasien.no_medrec=irddaftar_ulang.no_medrec and left(irddaftar_ulang.tgl_kunjungan,10)='$tgl' and irddaftar_ulang.id_poli='$id_poli'");
		}
		function get_data_kunj_bln($bln){
			return $this->db->query("
SELECT  DATE_FORMAT(LEFT(tgl_kunjungan,10),'%d %M %Y') AS hari, count(*) AS jum_kunj 

										FROM irddaftar_ulang

										WHERE LEFT(tgl_kunjungan,7)='$bln'

										GROUP BY LEFT(tgl_kunjungan,10)
");
		}
		function get_data_kunj_bln_range($bln_awal,$bln_akhir){
			return $this->db->query("select date_format(tgl_kunjungan,'%d %M %Y') as hari, count(no_register) 
as jum_kunj from irddaftar_ulang where left(tgl_kunjungan,7)>='$bln_awal' and left(tgl_kunjungan,7)<='$bln_akhir' GROUP BY hari");
		}
		function get_data_kunj_thn($thn){
			return $this->db->query("SELECT MONTHNAME(LEFT(tgl_kunjungan,10)) AS bulan, count(*) AS jum_kunj 

										FROM irddaftar_ulang

										WHERE LEFT(tgl_kunjungan,4)='$thn'

										GROUP BY bulan
										ORDER BY Month(tgl_kunjungan)");
		}
		function get_data_kunj_thn_range($thn){
			return $this->db->query("select date_format(tgl_kunjungan,'%M') as bulan, count(no_register) 
as jum_kunj from irddaftar_ulang where left(tgl_kunjungan,4)>='$thn_awal' and left(tgl_kunjungan,4)<='$thn_akhir'
GROUP BY bulan");
		}
		/////////////////////////////////////////////////////////////////////////////////keu pilih poli+status daftar_ulang selesai
		function get_data_keu_tind_tgl($tgl, $status,$psn){		
			if($status=='3'){
				if($psn=='0'){
					return $this->db->query("
SELECT du.no_register, du.tgl_kunjungan, du.no_medrec, dp.no_cm, dp.nama, du.status , du.cara_bayar, du.biayadaftar , COALESCE(du.vtot, 0) as total, COALESCE(du.diskon, 0) as diskon	
FROM irddaftar_ulang AS du
LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
where left(du.tgl_kunjungan,10)='$tgl'
ORDER BY no_register
");
				}
				else{
					return $this->db->query("

SELECT du.no_register, du.tgl_kunjungan, du.no_medrec, dp.no_cm, dp.nama, du.status , du.cara_bayar, du.biayadaftar , COALESCE(du.vtot, 0) as total, COALESCE(du.diskon, 0) as diskon	
FROM irddaftar_ulang AS du
LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
where left(du.tgl_kunjungan,10)='$tgl'
and du.cara_bayar='$psn'
ORDER BY no_register
");
				}				
				
			}		
			else{
				if($psn=='0'){
					return $this->db->query("SELECT du.no_register, du.tgl_kunjungan, du.no_medrec, du.cara_bayar,dp.no_cm, dp.nama, du.status, du.biayadaftar , COALESCE(du.vtot, 0) as total, COALESCE(du.diskon, 0) as diskon
FROM irddaftar_ulang AS du
LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
WHERE du.status='$status'
and left(du.tgl_kunjungan,10)='$tgl'
ORDER BY no_register
");
				}else{
					return $this->db->query("SELECT du.no_register, du.tgl_kunjungan, du.no_medrec, dp.no_cm, dp.nama, du.status , du.cara_bayar, du.biayadaftar , COALESCE(du.vtot, 0) as total, COALESCE(du.diskon, 0) as diskon	
FROM irddaftar_ulang AS du
LEFT JOIN data_pasien AS dp ON du.no_medrec=dp.no_medrec
where left(du.tgl_kunjungan,10)='$tgl'
and du.cara_bayar='$psn' and du.status='$status'
ORDER BY no_register
");
				}
				
		}
		}
		
		function get_data_keu_tind_bln($bln, $status,$psn){		
			if($status=='3'){
				if($psn=='0'){
					return $this->db->query("
SELECT  date_format(A.tgl_kunjungan,'%d-%m-%Y') as hari, COUNT(B.idtindakan) as jum_kunj, SUM(A.biayadaftar) as totdaftar,B.tgl_kunjungan, 
A.no_register,  SUM(B.vtot) as total, SUM(A.diskon) as totdiskon
FROM irddaftar_ulang A
LEFT JOIN 
tindakan_ird B
ON A.no_register=B.no_register
where left(A.tgl_kunjungan,7)='$bln'
GROUP by  hari
");
				}
				else{
					return $this->db->query("
SELECT  date_format(A.tgl_kunjungan,'%d-%m-%Y') as hari, COUNT(B.idtindakan) as jum_kunj, SUM(A.biayadaftar) as totdaftar,B.tgl_kunjungan, 
A.no_register,  SUM(B.vtot) as total, SUM(A.diskon) as totdiskon
FROM irddaftar_ulang A
LEFT JOIN 
tindakan_ird B
ON A.no_register=B.no_register
where left(A.tgl_kunjungan,7)='$bln'
and A.cara_bayar='$psn'
GROUP by  hari
");
				}				
				
			}		
			else{
				if($psn=='0'){
					return $this->db->query("
SELECT  date_format(A.tgl_kunjungan,'%d-%m-%Y') as hari, COUNT(B.idtindakan) as jum_kunj, SUM(A.biayadaftar) as totdaftar,A.tgl_kunjungan, 
A.no_register,  SUM(B.vtot) as total, SUM(A.diskon) as totdiskon
FROM irddaftar_ulang A
LEFT JOIN 
tindakan_ird B
ON A.no_register=B.no_register
where left(A.tgl_kunjungan,7)='$bln'
and A.status='$status'
GROUP by  hari
");
				}else{
					return $this->db->query("
SELECT  date_format(A.tgl_kunjungan,'%d-%m-%Y') as hari, COUNT(B.idtindakan) as jum_kunj, SUM(A.biayadaftar) as totdaftar,A.tgl_kunjungan, 
A.no_register,  SUM(B.vtot) as total, SUM(A.diskon) as totdiskon
FROM irddaftar_ulang A
LEFT JOIN 
tindakan_ird B
ON A.no_register=B.no_register
where left(A.tgl_kunjungan,7)='$bln'
and A.status='$status'
and A.cara_bayar='$psn'
GROUP by  hari
");
				}
				
			}
			
		}
		function get_data_keu_tind_thn($thn, $status,$psn){
			if($status=='3'){
				if($psn=='0'){
					return $this->db->query("
SELECT  date_format(A.tgl_kunjungan,'%M ') as bulan, COUNT(B.idtindakan) as jum_kunj, SUM(A.biayadaftar) as totdaftar,B.tgl_kunjungan, 
A.no_register,  SUM(B.vtot) as total, SUM(A.diskon) as totdiskon
FROM irddaftar_ulang A
LEFT JOIN 
tindakan_ird B
ON A.no_register=B.no_register
where left(A.tgl_kunjungan,4)='$thn'
GROUP by  bulan
ORDER BY Month(A.tgl_kunjungan)
");
				}else{
					return $this->db->query("
SELECT  date_format(A.tgl_kunjungan,'%M ') as bulan, COUNT(B.idtindakan) as jum_kunj, SUM(A.biayadaftar) as totdaftar,B.tgl_kunjungan, 
A.no_register,  SUM(B.vtot) as total, SUM(A.diskon) as totdiskon
FROM irddaftar_ulang A
LEFT JOIN 
tindakan_ird B
ON A.no_register=B.no_register
where left(A.tgl_kunjungan,4)='$thn'
and A.cara_bayar='$psn'
GROUP by  bulan
ORDER BY Month(A.tgl_kunjungan)
");
				}
				
			}
			else{
				if($psn=='0'){
					return $this->db->query("
SELECT  date_format(A.tgl_kunjungan,'%M ') as bulan, COUNT(B.idtindakan) as jum_kunj, SUM(A.biayadaftar) as totdaftar,B.tgl_kunjungan, 
A.no_register,  SUM(B.vtot) as total, SUM(A.diskon) as totdiskon
FROM irddaftar_ulang A
LEFT JOIN 
tindakan_ird B
ON A.no_register=B.no_register
where A.status='$status'
and left(A.tgl_kunjungan,4)='$thn'
GROUP by  bulan
ORDER BY Month(A.tgl_kunjungan)
");
				}else{
					return $this->db->query("
SELECT  date_format(A.tgl_kunjungan,'%M ') as bulan, COUNT(B.idtindakan) as jum_kunj, SUM(A.biayadaftar) as totdaftar,B.tgl_kunjungan, 
A.no_register,  SUM(B.vtot) as total, SUM(A.diskon) as totdiskon
FROM irddaftar_ulang A
LEFT JOIN 
tindakan_ird B
ON A.no_register=B.no_register
where A.status='$status'
and left(A.tgl_kunjungan,4)='$thn'
and A.cara_bayar='$psn'
GROUP by  bulan
ORDER BY Month(A.tgl_kunjungan)
");
				}
				
			}
			
		}
		/////////////////////////////////////////////////////////////////////////////keu dokter+status daftar_ulang selesai
		function get_data_keu_dokter_today(){
			return $this->db->query("select operator.id_dokter, operator.nm_dokter, sum(pelayanan_poli.biaya_poli) as jumlah_keu_dokter from pelayanan_poli, operator, irddaftar_ulang where pelayanan_poli.id_dokter=operator.id_dokter and left(irddaftar_ulang.tgl_kunjungan,10) = left(now(),10) and irddaftar_ulang.status='1' group by operator.id_dokter");
		}
		function get_data_keu_dokter($tgl_awal,$tgl_akhir){
			return $this->db->query("select operator.id_dokter, operator.nm_dokter, sum(pelayanan_poli.biaya_poli) as jumlah_keu_dokter from pelayanan_poli, operator, irddaftar_ulang where pelayanan_poli.id_dokter=operator.id_dokter and left(irddaftar_ulang.tgl_kunjungan,10)>='$tgl_awal' and left(irddaftar_ulang.tgl_kunjungan,10)<='$tgl_akhir' and irddaftar_ulang.status='1' group by operator.id_dokter");
		}
		//////////////////////////////////just get nama poli untuk kwitansi
		function get_nm_poli($id_poli){
			return $this->db->query("SELECT * from poliklinik where id_poli='$id_poli'");
		}
		
	}
?>
