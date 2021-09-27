<?php
class Rimlaporan extends CI_Model {

	function get_data_keu_tind_tgl($tglawal,$tglakhir,$status){
			if($status=='1'){
				return $this->db->query("
SELECT 
    b.no_cm,
    b.nama,    
    c.no_ipd,
    c.vtot,
    c.vtot_kamar,
    c.vtot_ruang,
    c.vtot_medis,
    c.vtot_paramedis,
    c.tunai,
    IF(c.lunas='1','LUNAS','-') as lunas,
    (SELECT nmruang
        FROM
            ruang            
        WHERE
            ruang.idrg = c.idrg
        ) AS ruang,
    IF(c.tgl_keluar,datediff(c.tgl_keluar,c.tgldaftarri),'-') as rawat,
    SUM(a.jasa_perawat) as jasa_perawat,
    ifnull(c.vtot_lab,0) as vtot_lab,
    ifnull(c.vtot_rad,0) as vtot_rad,
    ifnull(c.vtot_obat,0) as vtot_obat,
    ifnull(c.vtot_pa,0) as vtot_pa,
    ifnull(c.vtot_ok,0) as vtot_ok,
    ifnull(c.vtot_vk,0) as vtot_vk,
    ifnull(c.vtot_icu,0) as vtot_icu,
    c.vtot_kamaricu,
    c.vtot_kamarvk,
    c.biaya_daftar,
    c.biaya_administrasi,
    ifnull(c.matkes_iri,0) as matkes_iri,
    IF(c.tgl_keluar IS NOT NULL, 'PULANG', 'DIRAWAT') AS status,
    c.carabayar,
    IFNULL(IF(c.diskon = '', NULL, c.diskon), 0) AS diskon,
    ifnull(c.total,0) AS total,
    c.tgl_keluar,
    (SELECT nmkontraktor from kontraktor where id_kontraktor=c.id_kontraktor) as nmkontraktor
FROM
    ruang_iri AS a,
    pasien_iri AS c,
    data_pasien b
WHERE
    a.no_ipd = c.no_ipd
        AND b.no_medrec = c.no_cm and c.tgl_keluar>='$tglawal' and c.tgl_keluar<='$tglakhir'
GROUP BY a.no_ipd 
");
//SELECT b.no_cm, b.nama, c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar, IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar FROM ruang_iri as a, pasien_iri as c, data_pasien b WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and c.tgl_masuk='$tgl' and c.tgl_keluar is not null GROUP BY a.no_ipd ORDER BY a.no_ipd

//SELECT B.no_cm ,  IF(A.tgl_keluar is not null,'1','0') as status, B.nama, IFNULL(A.vtot,0) as total, A.carabayar, A.tgl_masuk, A.no_ipd, A.tgl_keluar, IFNULL(A.diskon,0) as diskon FROM `pasien_iri` A, `data_pasien` B where A.no_cm = B.no_medrec and tgl_keluar is not null and A.tgl_masuk='$tgl' ORDER BY A.no_ipd
			}else if ($status=='0'){
				return $this->db->query("
SELECT 
    b.no_cm,
    b.nama,    
    c.no_ipd,
    c.vtot,
    c.vtot_ruang,
    c.tunai,
    IF(c.lunas='1','LUNAS','-') as lunas,
    (select GROUP_CONCAT(nmruang SEPARATOR ', ') from ruang, ruang_iri
    where ruang.idrg=ruang_iri.idrg
    ) as ruang,
    c.vtot_kamaricu,
    c.vtot_kamarvk,
    c.biaya_daftar,
    c.vtot_medis,
    c.vtot_paramedis,
    IF(c.tgl_keluar,datediff(c.tgl_keluar,c.tgldaftarri),'-') as rawat,
    SUM(a.jasa_perawat) as jasa_perawat,
    c.vtot_kamar,
    ifnull(c.vtot_lab,0) as vtot_lab,
    ifnull(c.vtot_rad,0) as vtot_rad,
    ifnull(c.vtot_obat,0) as vtot_obat,
    ifnull(c.vtot_pa,0) as vtot_pa,
    ifnull(c.vtot_ok,0) as vtot_ok,
    ifnull(c.vtot_vk,0) as vtot_vk,
    ifnull(c.vtot_icu,0) as vtot_icu,
    c.biaya_administrasi,
    ifnull(c.matkes_iri,0) as matkes_iri,
    IF(c.tgl_keluar IS NOT NULL, 'PULANG', 'DIRAWAT') AS status,
    c.carabayar,
    IFNULL(IF(c.diskon = '', NULL, c.diskon), 0) AS diskon,
    ifnull(c.total,0) AS total,
    c.tgl_keluar,
    (SELECT nmkontraktor from kontraktor where id_kontraktor=c.id_kontraktor) as nmkontraktor
FROM
    ruang_iri AS a,
    pasien_iri AS c,
    data_pasien b
WHERE
    a.no_ipd = c.no_ipd
        AND b.no_medrec = c.no_cm and c.tgl_masuk>='$tglawal' and c.tgl_masuk<='$tglakhir' and c.tgl_keluar is null
GROUP BY a.no_ipd
 ");
//SELECT b.no_cm, b.nama, c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar, IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar FROM ruang_iri as a, pasien_iri as c, data_pasien b WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and c.tgl_masuk='$tgl' and c.tgl_keluar is null GROUP BY a.no_ipd ORDER BY a.no_ipd

//SELECT B.no_cm ,  IF(A.tgl_keluar is not null,'1','0') as status, B.nama, A.carabayar, IFNULL(A.vtot,0) as total, A.tgl_masuk, A.no_ipd, A.tgl_keluar, IFNULL(A.diskon,0) as diskon FROM `pasien_iri` A, `data_pasien` B where A.no_cm = B.no_medrec and tgl_keluar is null and A.tgl_masuk='$tgl' ORDER BY A.no_ipd
			}
			else {
				return $this->db->query("
SELECT 
    b.no_cm,
    b.nama,    
    c.no_ipd,
    c.vtot,
    c.tunai,
    c.vtot_kamar,
    c.vtot_ruang,
    c.vtot_kamaricu,
    c.vtot_kamarvk,
    c.biaya_daftar,
    c.vtot_medis,
    c.vtot_paramedis,
    IF(c.lunas='1','LUNAS','-') as lunas,
    (SELECT nmruang
        FROM
            ruang            
        WHERE
            ruang.idrg = c.idrg
        ) AS ruang,
    IF(c.tgl_keluar,datediff(c.tgl_keluar,c.tgldaftarri),'-') as rawat,
    SUM(a.jasa_perawat) as jasa_perawat,
    ifnull(c.vtot_lab,0) as vtot_lab,
    ifnull(c.vtot_rad,0) as vtot_rad,
    ifnull(c.vtot_obat,0) as vtot_obat,
    ifnull(c.vtot_pa,0) as vtot_pa,
    ifnull(c.vtot_ok,0) as vtot_ok,
    ifnull(c.vtot_vk,0) as vtot_vk,
    ifnull(c.vtot_icu,0) as vtot_icu,
    c.biaya_administrasi,
    ifnull(c.matkes_iri,0) as matkes_iri,
    IF(c.tgl_keluar IS NOT NULL, 'PULANG', 'DIRAWAT') AS status,
    c.carabayar,
    IFNULL(IF(c.diskon = '', NULL, c.diskon), 0) AS diskon,
    ifnull(c.total,0) AS total,
    c.tgl_keluar,
    (SELECT nmkontraktor from kontraktor where id_kontraktor=c.id_kontraktor) as nmkontraktor
FROM
    ruang_iri AS a,
    pasien_iri AS c,
    data_pasien b
WHERE
    a.no_ipd = c.no_ipd
        AND b.no_medrec = c.no_cm and c.tgl_masuk>='$tglawal' and c.tgl_masuk<='$tglakhir' and c.tgl_keluar is null
GROUP BY a.no_ipd
UNION
SELECT 
    b.no_cm,
    b.nama,    
    c.no_ipd,
    c.vtot,
    c.tunai,
    c.vtot_kamar,
    c.vtot_ruang,
    c.vtot_kamaricu,
    c.vtot_kamarvk,
    c.biaya_daftar,
    c.vtot_medis,
    c.vtot_paramedis,
    IF(c.lunas='1','LUNAS','-') as lunas,
    (SELECT nmruang
        FROM
            ruang            
        WHERE
            ruang.idrg = c.idrg
        ) AS ruang,
    IF(c.tgl_keluar,datediff(c.tgl_keluar,c.tgldaftarri),'-') as rawat,
    SUM(a.jasa_perawat) as jasa_perawat,
    ifnull(c.vtot_lab,0) as vtot_lab,
    ifnull(c.vtot_rad,0) as vtot_rad,
    ifnull(c.vtot_obat,0) as vtot_obat,
    ifnull(c.vtot_pa,0) as vtot_pa,
    ifnull(c.vtot_ok,0) as vtot_ok,
    ifnull(c.vtot_vk,0) as vtot_vk,
    ifnull(c.vtot_icu,0) as vtot_icu,
    c.biaya_administrasi,
    ifnull(c.matkes_iri,0) as matkes_iri,
    IF(c.tgl_keluar IS NOT NULL, 'PULANG', 'DIRAWAT') AS status,
    c.carabayar,
    IFNULL(IF(c.diskon = '', NULL, c.diskon), 0) AS diskon,
    ifnull(c.total,0) AS total,
    c.tgl_keluar,
    (SELECT nmkontraktor from kontraktor where id_kontraktor=c.id_kontraktor) as nmkontraktor
FROM
    ruang_iri AS a,
    pasien_iri AS c,
    data_pasien b
WHERE
    a.no_ipd = c.no_ipd
        AND b.no_medrec = c.no_cm and c.tgl_keluar>='$tglawal' and c.tgl_keluar<='$tglakhir'
GROUP BY a.no_ipd");
//SELECT b.no_cm, b.nama, c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar, IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar FROM ruang_iri as a, pasien_iri as c, data_pasien b WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and c.tgl_masuk='$tgl' GROUP BY a.no_ipd ORDER BY a.no_ipd

//SELECT B.no_cm ,  IF(A.tgl_keluar is not null,'1','0') as status, A.carabayar, B.nama, IFNULL(A.vtot,0) as total, A.tgl_masuk, A.no_ipd, A.tgl_keluar, IFNULL(A.diskon,0) as diskon FROM `pasien_iri` A, `data_pasien` B where A.no_cm = B.no_medrec and A.tgl_masuk='$tgl' ORDER BY A.no_ipd
				
			}
			
		}
		
	function getdata_perusahaan($no_ipd){
		return $this->db->query("SELECT A.id_kontraktor, B.nmkontraktor FROM pasien_iri A, kontraktor B  where no_ipd='$no_ipd' and A.id_kontraktor=B.id_kontraktor");
	}

	function get_data_keu_tind_bln($bln, $status,$psn){		
			if($status=='1'){
				if($psn=='0'){
					return $this->db->query("
SELECT SUM(a.total) as total, a.carabayar, SUM(a.diskon) as diskon, date_format(a.tgl_keluar,'%d-%m-%Y') as hari, count(*) as jum_tind, a.tgl_keluar as tgl_layanan from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar,
IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar 
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_keluar,7)='$bln' 
GROUP BY a.no_ipd) as a GROUP by hari");
//SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(c.tgl_keluar,'%d-%m-%Y') as hari, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and c.tgl_keluar is not null and left(d.tgl_keluar,7)='$bln' GROUP by hari

//SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%d-%m-%Y') as hari, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where A.tgl_keluar is not null and left(B.tgl_layanan,7)='$bln' GROUP by hari
				}
				else{
					return $this->db->query("
SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_keluar,'%d-%m-%Y') as hari, SUM(a.diskon) as diskon, count(*) as jum_tind, a.tgl_keluar as tgl_layanan from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar,
IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar 
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_keluar,7)='$bln' and c.carabayar='$psn' 
GROUP BY a.no_ipd) as a GROUP by hari");
//SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(c.tgl_keluar,'%d-%m-%Y') as hari, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and c.tgl_keluar is not null and left(d.tgl_keluar,7)='$bln' and c.carabayar='$psn' GROUP by hari

//SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%d-%m-%Y') as hari, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where A.tgl_keluar is not null and left(B.tgl_layanan,7)='$bln' and A.carabayar='$psn' GROUP by hari
				}				
				
			}
			else if ($status=='3'){
				if($psn=='0'){
					return $this->db->query("SELECT SUM(v.total) as total, Sum(v.diskon) as diskon, v.hari, sum(v.jum_tind) as jum_tind from 
(SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_keluar,'%d-%m-%Y') as hari, count(*) as jum_tind, SUM(a.diskon) as diskon from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar,
IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar 
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_keluar,7)='$bln' 
GROUP BY a.no_ipd) as a GROUP by hari
UNION
SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_masuk,'%d-%m-%Y') as hari, count(*) as jum_tind, SUM(a.diskon) as diskon from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar,
IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_masuk 
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_masuk,7)='$bln' and c.tgl_keluar is null GROUP BY a.no_ipd) as a GROUP by hari) as v GROUP by v.hari");
//SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(c.tgl_masuk,'%d-%m-%Y') as hari, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and left(c.tgl_masuk,7)='$bln' GROUP by hari UNION SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(c.tgl_keluar,'%d-%m-%Y') as hari, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and left(c.tgl_keluar,7)='$bln' GROUP by hari

//SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%d-%m-%Y') as hari, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where left(B.tgl_layanan,7)='$bln' GROUP by hari
				}else{
					return $this->db->query("
SELECT SUM(v.total) as total, Sum(v.diskon) as diskon, v.hari, sum(v.jum_tind) as jum_tind, v.tgl_layanan from 
(SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_layanan,'%d-%m-%Y') as hari, count(*) as jum_tind, SUM(a.diskon) as diskon, a.tgl_layanan from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar,
IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar as tgl_layanan
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_keluar,7)='$bln' and c.carabayar='$psn'
GROUP BY a.no_ipd) as a GROUP by hari
UNION
SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_layanan,'%d-%m-%Y') as hari, count(*) as jum_tind, SUM(a.diskon) as diskon, a.tgl_layanan from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar,
IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_masuk as tgl_layanan
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_masuk,7)='$bln' and c.carabayar='$psn' and c.tgl_keluar is null and c.carabayar='BPJS' GROUP BY a.no_ipd) as a GROUP by hari) as v GROUP by v.hari");
//SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(d.tgl_layanan,'%d-%m-%Y') as hari, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and left(c.tgl_masuk,7)='$bln' and c.carabayar='$psn' GROUP by hari UNION SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(d.tgl_layanan,'%d-%m-%Y') as hari, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and left(c.tgl_keluar,7)='$bln' and c.carabayar='$psn' GROUP by hari

//SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%d-%m-%Y') as hari, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where left(B.tgl_layanan,7)='$bln' and A.carabayar='$psn' GROUP by hari
				}
				
			}		
			else{
				if($psn=='0'){
					return $this->db->query("
SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_masuk,'%d-%m-%Y') as hari, count(*) as jum_tind, SUM(a.diskon) as diskon, a.tgl_masuk as tgl_layanan from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar,
IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar, c.tgl_masuk 
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_masuk,7)='$bln'
GROUP BY a.no_ipd) as a GROUP by hari");
//SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(d.tgl_layanan,'%d-%m-%Y') as hari, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and c.tgl_keluar is null and left(c.tgl_masuk,7)='$bln' GROUP by hari

//SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%d-%m-%Y') as hari, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where A.tgl_keluar is null and left(B.tgl_layanan,7)='$bln' GROUP by hari
				}else{
					return $this->db->query("
SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_masuk,'%d-%m-%Y') as hari, count(*) as jum_tind, SUM(a.diskon) as diskon, a.tgl_masuk as tgl_layanan from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar,
IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar, c.tgl_masuk 
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_masuk,7)='$bln' and c.carabayar='$psn' 
GROUP BY a.no_ipd) as a GROUP by hari");
//SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(d.tgl_layanan,'%d-%m-%Y') as hari, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and c.tgl_keluar is null and left(c.tgl_masuk,7)='$bln' and c.carabayar='$psn' GROUP by hari

//SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%d-%m-%Y') as hari, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where A.tgl_keluar is null and left(B.tgl_layanan,7)='$bln' and A.carabayar='$psn' GROUP by hari
				}
				
			}
			
		}
		function get_data_keu_tind_thn($thn, $status,$psn){
			if($status=='1'){
				if($psn=='0'){
					return $this->db->query("
SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(c.tgl_keluar,'%M ') as bulan, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and c.tgl_keluar is not null and left(c.tgl_keluar,4)='$thn' GROUP by bulan ORDER by Month(c.tgl_keluar)");
//SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%M ') as bulan, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where A.tgl_keluar is not null and left(B.tgl_layanan,4)='$thn' GROUP by bulan ORDER BY Month(B.tgl_layanan)
				}else{
					return $this->db->query("
SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(d.tgl_layanan,'%M ') as bulan, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and c.tgl_keluar is not null and left(c.tgl_keluar,4)='$thn' and c.carabayar='$psn' GROUP by bulan ORDER by Month(c.tgl_keluar)");
//SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%M ') as bulan, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where A.tgl_keluar is not null and left(B.tgl_layanan,4)='$thn' and A.carabayar='$psn' GROUP by bulan ORDER BY Month(B.tgl_layanan)
				}
				
			}
			else if ($status=='3'){
				if($psn=='0'){
					return $this->db->query("SELECT SUM(v.total) as total, SUM(v.jum_tind) as jum_tind, v.bulan, SUM(v.diskon) as diskon from 
(SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_keluar,'%M') as bulan, a.tgl_keluar as tgl, SUM(a.diskon) as diskon, count(*) as jum_tind from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar,
IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total,  c.tgl_keluar,  c.tgl_masuk FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_keluar,4)='$thn' 
GROUP BY a.no_ipd) as a GROUP by bulan 
UNION
SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_masuk,'%M') as bulan, SUM(a.diskon) as diskon, a.tgl_masuk as tgl, count(*) as jum_tind from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar, IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar,  c.tgl_masuk
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_masuk,4)='$thn' and c.tgl_keluar is null 
GROUP BY a.no_ipd) as a GROUP by bulan) 
as v GROUP by v.bulan order by Month(v.tgl)");
//SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(d.tgl_layanan,'%M ') as bulan, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and c.tgl_keluar is not null and left(d.tgl_layanan,4)='$thn' GROUP by bulan ORDER by Month(d.tgl_layanan)

//SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%M ') as bulan, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where left(B.tgl_layanan,4)='$thn' GROUP by bulan ORDER BY Month(B.tgl_layanan)
				}else{
					return $this->db->query("
SELECT SUM(v.total) as total, SUM(v.jum_tind) as jum_tind, v.bulan, SUM(v.diskon) as diskon from 
(SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_keluar,'%M') as bulan, a.tgl_keluar as tgl, SUM(a.diskon) as diskon, count(*) as jum_tind from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar,
IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total,  c.tgl_keluar,  c.tgl_masuk FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_keluar,4)='$thn' and c.carabayar='$psn'
GROUP BY a.no_ipd) as a GROUP by bulan 
UNION
SELECT SUM(a.total) as total, a.carabayar, date_format(a.tgl_masuk,'%M') as bulan, SUM(a.diskon) as diskon, a.tgl_masuk as tgl, count(*) as jum_tind from (SELECT c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar, IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar,  c.tgl_masuk
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and left(c.tgl_masuk,4)='$thn' and c.tgl_keluar is null and c.carabayar='$psn'
GROUP BY a.no_ipd) as a GROUP by bulan) 
as v GROUP by v.bulan order by Month(v.tgl)");
//SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(d.tgl_layanan,'%M ') as bulan, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and left(d.tgl_layanan,4)='$thn' and c.carabayar='$psn' GROUP by bulan ORDER by Month(d.tgl_layanan)

//SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%M ') as bulan, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where left(B.tgl_layanan,4)='$thn' and A.carabayar='$psn' GROUP by bulan ORDER BY Month(B.tgl_layanan)
				}
				
			}
			else{
				if($psn=='0'){
					return $this->db->query("
SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(c.tgl_masuk,'%M ') as bulan, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and c.tgl_keluar is null and left(c.tgl_masuk,4)='$thn' GROUP by bulan ORDER by Month(c.tgl_masuk)");
//SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(d.tgl_layanan,'%M ') as bulan, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and left(d.tgl_layanan,4)='$thn' and c.tgl_keluar is null GROUP by bulan ORDER by Month(d.tgl_layanan)

//SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%M ') as bulan, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where A.tgl_keluar is null and left(B.tgl_layanan,4)='$thn' GROUP by bulan ORDER BY Month(B.tgl_layanan)
				}else{
					return $this->db->query("
SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(c.tgl_masuk,'%M ') as bulan, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and c.tgl_keluar is null and left(c.tgl_masuk,4)='$thn' and c.carabayar='$psn' GROUP by bulan ORDER by Month(c.tgl_masuk)");
//SELECT (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, date_format(d.tgl_layanan,'%M ') as bulan, d.tgl_layanan, count(d.id_jns_layanan) as jum_tind, c.tgl_keluar, SUM(IFNULL(if(c.diskon='' ,NULL,c.diskon),0)) as diskon FROM ruang_iri as a, pasien_iri as c, pelayanan_iri as d where c.no_ipd = d.no_ipd and c.no_ipd=a.no_ipd and left(d.tgl_layanan,4)='$thn' and c.tgl_keluar is null and c.carabayar='$psn' GROUP by bulan ORDER by Month(d.tgl_layanan)

//SELECT SUM(B.vtot) as total, date_format(B.tgl_layanan,'%M ') as bulan, B.tgl_layanan, count(B.id_jns_layanan) as jum_tind, A.tgl_keluar, SUM(IFNULL(if(A.diskon='' ,NULL,A.diskon),0)) as diskon FROM `pasien_iri` A Left JOIN pelayanan_iri B on A.no_ipd = B.no_ipd where A.tgl_keluar is null and left(B.tgl_layanan,4)='$thn' and A.carabayar='$psn' GROUP by bulan ORDER BY Month(B.tgl_layanan)
				}
				
			}
			
		}

	function get_data_keu_tindakan_today(){
			return $this->db->query("
SELECT b.no_cm, b.nama, c.no_ipd, IF(c.tgl_keluar is not null,'1','0') as status, c.carabayar, IFNULL(if(c.diskon='' ,NULL,c.diskon),0) as diskon, (IFNULL(a.vtot,0)+IFNULL((SELECT SUM(vtot+tarifalkes) FROM pelayanan_iri WHERE no_ipd=a.no_ipd GROUP BY no_ipd),0)) as total, c.tgl_keluar 
FROM ruang_iri as a, pasien_iri as c, data_pasien b
WHERE a.no_ipd=c.no_ipd and b.no_medrec=c.no_cm and c.tgl_masuk=left(now(),10) and c.tgl_keluar is not null
GROUP BY a.no_ipd ORDER BY c.no_ipd");
//SELECT B.no_cm , B.nama, IFNULL(A.vtot,0) as total, A.tgl_masuk, A.no_ipd, A.tgl_keluar, IFNULL(A.diskon,0) as diskon FROM `pasien_iri` A, `data_pasien` B where A.no_cm = B.no_medrec and tgl_keluar is not null and A.tgl_masuk=left(now(),10) Group BY A.no_ipd
		}
		// Pasien SJP
		
		function get_pasien_sjp(){
			return $this->db->query("SELECT a.tgl_masuk, a.no_ipd, a.carabayar, b.no_cm, a.nama, a.noregasal
				FROM pasien_iri as a
				LEFT JOIN data_pasien as b ON a.no_cm=b.no_medrec 
				where (a.carabayar='DIJAMIN' or a.carabayar='BPJS') and (a.keadaanpulang IS NULL or a.keadaanpulang='') 
				order by a.xupdate desc");
		}
		
		function getdata_pasien_sjp($no_register){
			return $this->db->query("SELECT a.*, 
				b.no_cm, b.alamat, b.tgl_lahir, b.sex
				FROM pasien_iri as a
				LEFT JOIN data_pasien as b ON a.no_cm=b.no_medrec 
				WHERE a.no_ipd='$no_register'");
		}
		
		function getdata_pasien_sjp_rd($no_register){
			return $this->db->query("SELECT * FROM irddaftar_ulang WHERE no_register='$no_register'");
		}
		
		function getdata_pasien_sjp_rj($no_register){
			return $this->db->query("SELECT * FROM daftar_ulang_irj WHERE no_register='$no_register'");
		}
		
		function getdata_asal_rujukan($kd_ppk){
			return $this->db->query("SELECT nm_ppk FROM data_ppk WHERE kd_ppk='$kd_ppk'");
		}

		function get_ruang($idrg){
			return $this->db->query("SELECT * FROM ruang WHERE idrg='$idrg'");
		}

}
?>
