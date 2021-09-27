<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mdashboard extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//modul
		function get_data_pasien(){
			return $this->db->query("SELECT cara_bayar, count(1) as jumlah, sum(total) as total FROM data_pasien_cara_bayar WHERE tgl = left(now(),10) GROUP BY cara_bayar ORDER BY cara_bayar");
		}

		function get_data_pasien_range($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT cara_bayar, count(1) as jumlah, sum(total) as total FROM data_pasien_cara_bayar WHERE (tgl>='$tgl_awal' AND tgl<='$tgl_akhir') AND (cara_bayar='BPJS' OR cara_bayar='UMUM' OR cara_bayar='DIJAMIN') GROUP BY cara_bayar");
		}

		function get_data_kunjungan_poli($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT nm_poli as nama, sum(jumlah) as total FROM data_kunjungan_poli WHERE LEFT(tgl_kunjungan,10)>='$tgl_awal' AND LEFT(tgl_kunjungan,10)<='$tgl_akhir' GROUP BY nm_poli ORDER BY total DESC");
		}

		function get_total_kunjungan_poli(){
			return $this->db->query("SELECT count(*) AS total_pasien FROM dashboard_kunj_poli WHERE LEFT (tgl_kunjungan,10)=LEFT (now(),10)");
		}

		function get_total_kunjungan_poli_range($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT count(*) AS total_pasien FROM dashboard_kunj_poli WHERE LEFT (tgl_kunjungan,10)>= '$tgl_awal' AND LEFT (tgl_kunjungan,10)<= '$tgl_akhir'");
		}

		function get_data_kunjungan_poli_perhari($id_poli, $tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT left(tgl_kunjungan,10) as tgl, count(*) as total 
							FROM data_kunjungan_poli 
							WHERE id_poli='$id_poli' 
							AND (left(tgl_kunjungan,10)>='$tgl_awal' AND left(tgl_kunjungan,10)<='$tgl_akhir')
							GROUP BY tgl");
		}

		function get_data_pendapatan($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT label, SUM(value) as `value` FROM data_pendapatan_keseluruhan 
				WHERE tgl>='$tgl_awal' AND tgl<='$tgl_akhir'
				GROUP BY label");
		}

		function get_data_diagnosa_ird($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT nm_diagnosa as nama, SUM(jumlah) AS jumlah FROM data_diagnosa_ird WHERE tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir' and id_diagnosa is not NULL and id_diagnosa!='' GROUP BY id_diagnosa ORDER BY jumlah DESC LIMIT 0,10");
		}

		function get_data_diagnosa_irj($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT nm_diagnosa AS nama,SUM(jumlah) AS jumlah FROM data_diagnosa_irj WHERE tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir' AND id_diagnosa IS NOT NULL AND id_diagnosa !='' GROUP BY id_diagnosa ORDER BY jumlah DESC LIMIT 0,10");
		}

		function get_data_diagnosa_iri($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT nm_diagnosa as nama, SUM(jumlah) AS jumlah FROM data_diagnosa_iri WHERE tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir' and id_diagnosa is not NULL and id_diagnosa!=''GROUP BY id_diagnosa ORDER BY jumlah DESC LIMIT 0,10");
		}

		function get_excel_diagnosa_ird($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT id_diagnosa as id, nm_diagnosa as nama, SUM(jumlah) AS jumlah FROM data_diagnosa_ird WHERE tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir' and id_diagnosa is not NULL and id_diagnosa!='' GROUP BY id_diagnosa ORDER BY jumlah DESC");
		}

		function get_excel_diagnosa_irj($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT id_diagnosa as id, nm_diagnosa as nama, SUM(jumlah) AS jumlah FROM data_diagnosa_irj WHERE tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir' and id_diagnosa is not NULL and id_diagnosa!='' GROUP BY id_diagnosa ORDER BY jumlah DESC");
		}

		function get_excel_diagnosa_iri($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT id_diagnosa as id, nm_diagnosa as nama, SUM(jumlah) AS jumlah FROM data_diagnosa_iri WHERE tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir' and id_diagnosa is not NULL and id_diagnosa!='' GROUP BY id_diagnosa ORDER BY jumlah DESC");
		}

		function get_data_poli(){
			return $this->db->query("SELECT id_poli, nm_poli FROM data_kunjungan_poli GROUP BY id_poli");
		}

		function get_nm_poli($id_poli){
			return $this->db->query("SELECT nm_poli FROM poliklinik WHERE id_poli='$id_poli'");
		}

		function get_data_vtot($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT sum(sum_vtot) as vtot FROM dashboard_pendapatan
				WHERE tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir'");
		}

		function get_all_vtot(){
			return $this->db->query("SELECT sum(value) as vtot FROM data_pendapatan_keseluruhan");
		}

		function get_data_obat($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT nama_obat as nama, sum(qty) as jumlah FROM resep_pasien, master_obat
				WHERE resep_pasien.item_obat=master_obat.id_obat
				AND tgl_kunjungan>='$tgl_awal' AND tgl_kunjungan<='$tgl_akhir'
				AND master_obat.kel<>'ALKES'
				GROUP BY nama_obat
				ORDER BY jumlah DESC LIMIT 0, 10");
		}

		function get_data_periodik($thn_awal, $thn_akhir){
			return $this->db->query("SELECT tahunbln as bln, pendapatan FROM pendapatan_rs WHERE LEFT(tahunbln,4)>='$thn_awal' AND LEFT(tahunbln,4)<='$thn_akhir' ORDER BY tahunbln");
		}

		function get_kunj_poli_today(){
			return $this->db->query("SELECT
										id_poli,
										nm_poli,
										SUM(l) as l,
										SUM(p) as p,
										SUM(umum) as umum,
										SUM(tni_al_m) as tni_al_m,
										SUM(tni_al_s) as tni_al_s,
										SUM(tni_al_k) as tni_al_k,
										SUM(tni_n_al_m) as tni_n_al_m,
										SUM(tni_n_al_s) as tni_n_al_s,
										SUM(tni_n_al_k) as tni_n_al_k,
										SUM(pol) as pol,
										SUM(pol_k) as pol_k,
										SUM(askes_al) as askes_al,
										SUM(askes_n_al) as askes_n_al,
										SUM(bpjs_kes) as bpjs_kes,
										SUM(kjs) as kjs,
										SUM(pbi) as pbi,
										SUM(bpjs_ket) as bpjs_ket,
										SUM(phl) as phl,
										SUM(jam_per) as jam_per,
										SUM(kerjasama) as kerjasama,
										COUNT(id_poli) as total
										FROM
											dashboard_kunj_poli 
										WHERE
											tgl_kunjungan = LEFT(NOW(),10)
										GROUP BY
											id_poli
											ORDER BY
											total DESC");
		}

		function get_kunj_poli_range($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT
										id_poli,
										nm_poli,
										SUM(l) as l,
										SUM(p) as p,
										SUM(umum) as umum,
										SUM(tni_al_m) as tni_al_m,
										SUM(tni_al_s) as tni_al_s,
										SUM(tni_al_k) as tni_al_k,
										SUM(tni_n_al_m) as tni_n_al_m,
										SUM(tni_n_al_s) as tni_n_al_s,
										SUM(tni_n_al_k) as tni_n_al_k,
										SUM(pol) as pol,
										SUM(pol_k) as pol_k,
										SUM(askes_al) as askes_al,
										SUM(askes_n_al) as askes_n_al,
										SUM(bpjs_kes) as bpjs_kes,
										SUM(kjs) as kjs,
										SUM(pbi) as pbi,
										SUM(bpjs_ket) as bpjs_ket,
										SUM(phl) as phl,
										SUM(jam_per) as jam_per,
										SUM(kerjasama) as kerjasama,
										COUNT(id_poli) as total
										FROM
											dashboard_kunj_poli 
										WHERE
											tgl_kunjungan >= '$tgl_awal' 
										AND
											tgl_kunjungan <= '$tgl_akhir'
										GROUP BY
											id_poli
											ORDER BY
											total DESC");
		}


		function get_data_poli_pasien($id_poli){
			return $this->db->query("SELECT
										*
									FROM
										dashboard_kunj_poli 
									WHERE
										tgl_kunjungan = LEFT(NOW(),10)
									AND
										id_poli='$id_poli'");
		}
		function get_data_poli_pasien_range($id_poli,$tgl_awal,$tgl_akhir){
			return $this->db->query("SELECT
										*
									FROM
										dashboard_kunj_poli 
									WHERE
										tgl_kunjungan >= '$tgl_awal' 
									AND
										tgl_kunjungan <= '$tgl_akhir'
									AND
										id_poli='$id_poli'");
		}

		function get_data_bed(){
			return $this->db->query("SELECT a.idrg,a.nmruang,a.lokasi,b.kelas,COUNT(a.idrg) AS bed_kapasitas_real,SUM(CASE WHEN b.STATUS=1 THEN 1 ELSE 0 END) AS bed_utama,SUM(CASE WHEN b.STATUS=2 THEN 1 ELSE 0 END) AS bed_cadangan,SUM(CASE WHEN b.isi='Y' THEN 1 ELSE 0 END) AS bed_isi,SUM(CASE WHEN b.isi='N' THEN 1 ELSE 0 END) AS bed_kosong FROM ruang a INNER JOIN bed b ON a.idrg=b.idrg WHERE a.aktif='Active' GROUP BY lokasi, b.kelas ORDER BY kelas DESC");
		}

		function get_pembelian_obat(){
		    return $this->db->query("SELECT h.`sumber_dana`, d.`tgl_faktur`, s.`company_name`, d.`no_faktur`, d.`jatuh_tempo`, SUM(p.`harga_po` * p.`qty_beli`) AS total_obat
			FROM po p
			INNER JOIN header_po h ON p.`id_po` = h.`id_po`
			INNER JOIN `do` d ON d.`id_po` = p.`id_po`
			INNER JOIN suppliers s ON s.`person_id` = h.`supplier_id`
			WHERE p.`qty_beli` != '' GROUP BY d.no_faktur ORDER BY d.tgl_faktur DESC");
        }

        function get_data_stok($idgudang){
            return $this->db->query("SELECT g.id_obat, mg.nama_gudang, mo.nm_obat, mo.satuank, SUM(g.qty) AS qty
                FROM gudang_inventory g
                INNER JOIN master_obat mo ON mo.id_obat = g.id_obat
                INNER JOIN master_gudang mg ON mg.id_gudang = g.id_gudang
                WHERE g.id_gudang = ".$idgudang."
                GROUP BY g.id_obat, g.id_gudang");
        }

        function get_data_urikes($date1,$date2){
        	return $this->db->query("
        		SELECT a.nama, a.tgl_pemeriksaan ,a.nip, b.pangkat, a.kesatuan, a.jabatan, c.sf_umum, c.sf_atas, c.sf_bawah, c.sf_dengar, c.sf_lihat,c.sf_gigi, c.sf_jiwa, a.umur,a.catatan, SUBSTRING(a.golongan,5) as statkes
        		FROM urikkes_pasien a
        		LEFT JOIN urikkes_pemeriksaan_umum c on a.nomor_kode=c.nomor_kode
        		LEFT JOIN tni_pangkat b ON a.kdpangkat=b.pangkat_id
        		WHERE a.tgl_pemeriksaan>='$date1' and a.tgl_pemeriksaan<='$date2' 
        		ORDER BY a.tgl_pemeriksaan
        		");
        }

		function get_kunj_lab_today(){
			return $this->db->query("SELECT
										a.no_lab, a.no_register, c.no_cm, a.tgl_kunjungan, c.nama
									FROM
										pemeriksaan_laboratorium as a
									LEFT JOIN data_pasien as c ON a.no_medrec=c.no_medrec
									WHERE
										LEFT(a.tgl_kunjungan,10) = LEFT(NOW(),10)
									AND
										a.no_lab IS NOT NULL
									GROUP BY
										no_lab 
									ORDER BY
										tgl_kunjungan ASC");
		}

		function get_kunj_lab_range($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT
										a.no_lab, a.no_register, c.no_cm, a.tgl_kunjungan, c.nama
									FROM
										pemeriksaan_laboratorium as a
									LEFT JOIN data_pasien as c ON a.no_medrec=c.no_medrec
									WHERE
										LEFT(a.tgl_kunjungan,10) >= '$tgl_awal' 
										AND
										LEFT(a.tgl_kunjungan,10)<= '$tgl_akhir'
										AND
										a.no_lab IS NOT NULL
									GROUP BY
										no_lab 
									ORDER BY
										tgl_kunjungan ASC");
		}

		function get_tind_lab($no_lab){
			return $this->db->query("SELECT
										a.jenis_tindakan
									FROM
										pemeriksaan_laboratorium AS a
									WHERE
										a.no_lab = '$no_lab' ");
		}

		function get_kunj_rad_today(){
			return $this->db->query("SELECT
										a.no_rad, a.no_register, c.no_cm, a.tgl_kunjungan, c.nama
									FROM
										pemeriksaan_radiologi as a
									LEFT JOIN data_pasien as c ON a.no_medrec=c.no_medrec
									WHERE
										LEFT(a.tgl_kunjungan,10) = LEFT(NOW(),10)
									AND
										a.no_rad IS NOT NULL
									GROUP BY
										no_rad 
									ORDER BY
										tgl_kunjungan ASC");
		}

		function get_kunj_rad_range($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT
										a.no_rad, a.no_register, c.no_cm, a.tgl_kunjungan, c.nama
									FROM
										pemeriksaan_radiologi as a
									LEFT JOIN data_pasien as c ON a.no_medrec=c.no_medrec
									WHERE
										LEFT(a.tgl_kunjungan,10) >= '$tgl_awal' 
										AND
										LEFT(a.tgl_kunjungan,10) <= '$tgl_akhir'
										AND
										a.no_rad IS NOT NULL
									GROUP BY
										no_rad 
									ORDER BY
										tgl_kunjungan ASC");
		}

		function get_tind_rad($no_rad){
			return $this->db->query("SELECT
										a.jenis_tindakan
									FROM
										pemeriksaan_radiologi AS a
									WHERE
										a.no_rad = '$no_rad' ");
		}

		function get_pendapatan_keselurahan_today(){
			return $this->db->query("SELECT
										jenis, cara_bayar, sum(sum_vtot) as total
									FROM
										dashboard_pendapatan 
									WHERE
										tgl_kunjungan = LEFT ( NOW( ), 10 ) 
									GROUP BY
										jenis, cara_bayar
									ORDER BY
										total DESC");
		}

		function get_pendapatan_keselurahan_range($tgl_awal, $tgl_akhir){
			return $this->db->query("SELECT
										jenis, cara_bayar, sum(sum_vtot) as total
									FROM
										dashboard_pendapatan 
									WHERE
										tgl_kunjungan >= '$tgl_awal' 
									AND
										tgl_kunjungan <= '$tgl_akhir'
									GROUP BY
										jenis, cara_bayar
									ORDER BY
										total DESC
									");
		}

		function get_indikator_ruang_today(){
			// return $this->db->query("");
		}

		function get_indikator_ruang_thn($thn){
			// return $this->db->query("");
		}

		function get_all_ruang_tt(){
			return $this->db->query("SELECT a.lokasi,count(a.idrg) AS jumlah_bed FROM ruang AS a LEFT JOIN bed AS b ON a.idrg=b.idrg WHERE a.aktif='Active' GROUP BY a.lokasi");
		}

		function get_all_kelas_tt(){
			return $this->db->query("SELECT b.kelas,count(a.idrg) AS jumlah_bed FROM ruang AS a LEFT JOIN bed AS b ON a.idrg=b.idrg WHERE a.aktif='Active' AND b.kelas IS NOT NULL GROUP BY b.kelas");
		}

		function get_ldhp($thnbln, $lok){
			return $this->db->query("SELECT kelas,lokasi,tgl_masuk,tgl_keluar,SUM(IF (LEFT (tgl_keluar,7)='".$thnbln."',(DATEDIFF(tgl_keluar,tgl_masuk)),0)) AS ld,SUM(IF (LEFT (tgl_masuk,7) !='".$thnbln."',DATEDIFF(tgl_keluar,'".$thnbln."-01'),IF (LEFT (tgl_keluar,7) !='".$thnbln."',IF (tgl_masuk=LAST_DAY('".$thnbln."-01'),1,DATEDIFF(LAST_DAY('".$thnbln."-01'),tgl_masuk)+1),IF (LEFT (tgl_masuk,7) !='".$thnbln."' AND tgl_keluar !='".$thnbln."',(DATEDIFF(LAST_DAY('".$thnbln."-01'),'".$thnbln."-01')+1),DATEDIFF(tgl_keluar,tgl_masuk))))) AS hp FROM hari_perawatan WHERE '".$thnbln."' BETWEEN LEFT (tgl_masuk,7) AND LEFT (tgl_keluar,7) AND lokasi='".$lok."'");
		}

		function get_jum_pas_keluar($thnbln, $lok){
			return $this->db->query("SELECT count(no_ipd) AS jumlah_pasien_keluar FROM hari_perawatan WHERE '".$thnbln."'=LEFT (tgl_keluar,7) AND lokasi='".$lok."'");
		}

		function get_ldhp_kelas($thnbln, $kelas){
			return $this->db->query("SELECT kelas,lokasi,tgl_masuk,tgl_keluar,SUM(IF (LEFT (tgl_keluar,7)='".$thnbln."',(DATEDIFF(tgl_keluar,tgl_masuk)),0)) AS ld,SUM(IF (LEFT (tgl_masuk,7) !='".$thnbln."',DATEDIFF(tgl_keluar,'".$thnbln."-01'),IF (LEFT (tgl_keluar,7) !='".$thnbln."',IF (tgl_masuk=LAST_DAY('".$thnbln."-01'),1,DATEDIFF(LAST_DAY('".$thnbln."-01'),tgl_masuk)+1),IF (LEFT (tgl_masuk,7) !='".$thnbln."' AND tgl_keluar !='".$thnbln."',(DATEDIFF(LAST_DAY('".$thnbln."-01'),'".$thnbln."-01')+1),DATEDIFF(tgl_keluar,tgl_masuk))))) AS hp FROM hari_perawatan WHERE '".$thnbln."' BETWEEN LEFT (tgl_masuk,7) AND LEFT (tgl_keluar,7) AND kelas='".$kelas."'");
		}

		function get_jum_pas_keluar_kelas($thnbln, $kelas){
			return $this->db->query("SELECT count(no_ipd) AS jumlah_pasien_keluar FROM hari_perawatan WHERE '".$thnbln."'=LEFT (tgl_keluar,7) AND kelas='".$kelas."'");
		}
	}
?>