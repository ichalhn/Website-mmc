<?php
class Rekap_pasien extends CI_Model {

	public function get_jml_keluar_masuk_by_range_date($tgl_awal,$tgl_akhir){
		$data=$this->db->query("
			SELECT h.*,IFNULL(h.tgl_keluar,h.tgl_masuk) as tanggal
			FROM
			(SELECT * FROM
			(select b.tgl_keluar,count(tgl_keluar) as jml_tgl_keluar
			from pasien_iri as b
			where
			b.tgl_keluar BETWEEN '$tgl_awal' AND '$tgl_akhir'
			GROUP BY b.tgl_keluar) as d
			LEFT JOIN (select a.tgl_masuk,count(tgl_masuk) as jml_tgl_masuk
			from pasien_iri as a
			where
			a.tgl_masuk BETWEEN '$tgl_awal' AND '$tgl_akhir'
			GROUP BY a.tgl_masuk) as e on d.tgl_keluar = e.tgl_masuk
			UNION
			SELECT * FROM
			(select b.tgl_keluar,count(tgl_keluar) as jml_tgl_keluar
			from pasien_iri as b
			where
			b.tgl_keluar BETWEEN '$tgl_awal' AND '$tgl_akhir'
			GROUP BY b.tgl_keluar) as d
			RIGHT JOIN (select a.tgl_masuk,count(tgl_masuk) as jml_tgl_masuk
			from pasien_iri as a
			where
			a.tgl_masuk BETWEEN '$tgl_awal' AND '$tgl_akhir'
			GROUP BY a.tgl_masuk) as e on d.tgl_keluar = e.tgl_masuk
			) as h
			order by tanggal asc
			");
		return $data->result_array();
	}

		public function get_jml_keluar_masuk_by_date($tgl_awal){
		$data=$this->db->query("
		SELECT a.tgl_masuk as tgl, a.no_ipd,b.no_cm,b.nama,c.id_icd,c.nm_diagnosa,b.sex,b.alamat,'MASUK' as tipe_masuk
		FROM pasien_iri as a
		LEFT JOIN data_pasien as b on a.no_cm = b.no_medrec
		LEFT JOIN icd1 as c on a.diagnosa1 = c.id_icd
		WHERE a.tgl_masuk = '$tgl_awal'
		UNION
		SELECT d.tgl_keluar as tgl, d.no_ipd,e.no_cm,e.nama,f.id_icd,f.nm_diagnosa,e.sex,e.alamat,'KELUAR' as tipe_masuk
		FROM pasien_iri as d
		LEFT JOIN data_pasien as e on d.no_cm = e.no_medrec
		LEFT JOIN icd1 as f on d.diagnosa1 = f.id_icd
		WHERE d.tgl_keluar = '$tgl_awal'
			");
		return $data->result_array();
	}

	public function get_jml_keluar_masuk_by_bulan($tgl_awal){
		$data=$this->db->query("
			SELECT h.*,IFNULL(h.tgl_keluar,h.tgl_masuk) as tanggal
			FROM
			(SELECT * FROM
			(select b.tgl_keluar,count(tgl_keluar) as jml_tgl_keluar
			from pasien_iri as b
			where
			b.tgl_keluar like '$tgl_awal-%'
			GROUP BY b.tgl_keluar) as d
			LEFT JOIN (select a.tgl_masuk,count(tgl_masuk) as jml_tgl_masuk
			from pasien_iri as a
			where
			a.tgl_masuk like '$tgl_awal-%'
			GROUP BY a.tgl_masuk) as e on d.tgl_keluar = e.tgl_masuk
			UNION
			SELECT * FROM
			(select b.tgl_keluar,count(tgl_keluar) as jml_tgl_keluar
			from pasien_iri as b
			where
			b.tgl_keluar like '$tgl_awal-%'
			GROUP BY b.tgl_keluar) as d
			RIGHT JOIN (select a.tgl_masuk,count(tgl_masuk) as jml_tgl_masuk
			from pasien_iri as a
			where
			a.tgl_masuk like '$tgl_awal-%'
			GROUP BY a.tgl_masuk) as e on d.tgl_keluar = e.tgl_masuk
			) as h
			order by tanggal asc
			");
		return $data->result_array();
	}

	public function get_jml_keluar_masuk_by_tahun($tgl_awal){
		$data=$this->db->query("
			SELECT h.*,IFNULL(h.tgl_keluar,h.tgl_masuk) as tanggal
			FROM
			(SELECT * FROM
			(select b.tgl_keluar,count(tgl_keluar) as jml_tgl_keluar
			from pasien_iri as b
			where
			b.tgl_keluar like '$tgl_awal-%'
			GROUP BY b.tgl_keluar) as d
			LEFT JOIN (select a.tgl_masuk,count(tgl_masuk) as jml_tgl_masuk
			from pasien_iri as a
			where
			a.tgl_masuk like '$tgl_awal-%'
			GROUP BY a.tgl_masuk) as e on d.tgl_keluar = e.tgl_masuk
			UNION
			SELECT * FROM
			(select b.tgl_keluar,count(tgl_keluar) as jml_tgl_keluar
			from pasien_iri as b
			where
			b.tgl_keluar like '$tgl_awal-%'
			GROUP BY b.tgl_keluar) as d
			RIGHT JOIN (select a.tgl_masuk,count(tgl_masuk) as jml_tgl_masuk
			from pasien_iri as a
			where
			a.tgl_masuk like '$tgl_awal-%'
			GROUP BY a.tgl_masuk) as e on d.tgl_keluar = e.tgl_masuk
			) as h
			order by tanggal asc
			");
		return $data->result_array();
	}

	//--- end laporan

	public function select_pasien_iri_all(){
		$data=$this->db->query("select *
			from pasien_iri as a left join ruang_iri as b on a.no_ipd = b.no_ipd
			inner join data_pasien as c on a.no_cm = c.no_medrec
			left join ruang as d on a.idrg = d.idrg
			where a.tgl_keluar IS NULL and b.tglkeluarrg IS NULL
			and (a.ipdibu = '' or a.ipdibu is null)
			order by a.no_ipd asc
			");
		return $data->result_array();
	}

	public function get_bayi_by_ipd_ibu($ipdibu){
		$data=$this->db->query("select *
			from pasien_iri as a
			where a.ipdibu = '$ipdibu'
			");
		return $data->result_array();
	}

	public function select_pasien_iri_pulang_all(){
		$data=$this->db->query("select *
			from pasien_iri as a join ruang_iri as b on a.no_ipd = b.no_ipd
			inner join data_pasien as c on a.no_cm = c.no_medrec
			left join ruang as d on a.idrg = d.idrg
			where a.tgl_keluar IS NOT NULL
			order by a.no_ipd asc
			");
		return $data->result_array();
	}

	public function select_pasien_iri_pulang_bpjs(){
		$data=$this->db->query("select *
			from pasien_iri as a join ruang_iri as b on a.no_ipd = b.no_ipd
			inner join data_pasien as c on a.no_cm = c.no_medrec
			left join ruang as d on a.idrg = d.idrg
			where a.tgl_keluar IS NOT NULL
			and a.no_sep is not null
			order by a.no_ipd asc
			");
		return $data->result_array();
	}

	public function select_pasien_iri_pulang_belum_cetak_kwitansi(){
		$data=$this->db->query("select *
			from pasien_iri as a inner join ruang_iri as b on a.no_ipd = b.no_ipd
			inner join data_pasien as c on a.no_cm = c.no_medrec
			where a.tgl_keluar IS NOT NULL and a.cetak_kwitansi is NULL
			and b.tglkeluarrg is null
			order by a.no_ipd asc
			");
		return $data->result_array();
	}

	public function select_pasien_iri_pulang_sudah_cetak_kwitansi(){
		$data=$this->db->query("
			SELECT
				*
			FROM
				pasien_iri AS a
			INNER JOIN ruang_iri AS b ON a.no_ipd = b.no_ipd
			INNER JOIN data_pasien AS c ON a.no_cm = c.no_medrec
			WHERE
			a.cetak_kwitansi = '1'
			ORDER BY
			a.no_ipd ASC
			");
		return $data->result_array();
	}



	public function get_list_ruang_mutasi_pasien($no_ipd){
		$data=$this->db->query("select *
			from ruang_iri as a left join ruang as b on a.idrg = b.idrg
			left join tarif_tindakan as c on a.idrg = RIGHT(c.id_tindakan,4) and a.kelas = c.kelas
			where a.no_ipd = '$no_ipd' and c.id_tindakan like '1%'
			order by tglmasukrg asc
			");

		// $data=$this->db->query("select *
		// 	from ruang_iri as a left join ruang as b on a.idrg = b.idrg
		// 	where a.no_ipd = '$no_ipd'
		// 	order by tglmasukrg asc
		// 	");
		return $data->result_array();
	}

	public function get_list_lab_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("select *
			from pemeriksaan_laboratorium as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_ok_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("SELECT COALESCE(no_ok, 'On Progress') AS no_ok, id_pemeriksaan_ok, id_tindakan, biaya_ok, jenis_tindakan, id_dokter, id_opr_anes, id_dok_anes, jns_anes, id_dok_anak, tgl_operasi, vtot, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter) as nm_dokter, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_opr_anes) as nm_opr_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anes) as nm_dok_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anak) as nm_dok_anak
				FROM pemeriksaan_operasi WHERE no_register in ('$no_ipd','$no_reg_asal')");
		return $data->result_array();
	}

	public function get_cetak_lab_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("select no_lab
			from pemeriksaan_laboratorium as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			and a.cetak_hasil='1'
			group by no_lab
			order by no_lab asc
			");
		return $data->result_array();
	}

	public function get_cetak_lab_pasien_umum($no_ipd){
		$data=$this->db->query("select no_lab
			from pemeriksaan_laboratorium as a
			where a.no_register='$no_ipd'
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			and a.cetak_hasil='1'
			group by no_lab
			order by no_lab asc
			");
		return $data->result_array();
	}

	public function get_list_lab_pasien_umum($no_ipd){
		$data=$this->db->query("select no_lab
			from pemeriksaan_laboratorium as a
			where a.no_register='$no_ipd'
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			group by no_lab
			order by no_lab asc
			");
		return $data->result_array();
	}

	public function get_list_pa_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("select *
			from pemeriksaan_patologianatomi as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			order by no_pa asc
			");
		return $data->result_array();
	}

	public function get_list_pa_pasien_umum($no_ipd){
		$data=$this->db->query("select *
			from pemeriksaan_patologianatomi as a
			where a.no_register='$no_ipd'
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			order by no_pa asc
			");
		return $data->result_array();
	}

	public function get_cetak_pa_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("select no_pa
			from pemeriksaan_patologianatomi as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			and a.cetak_hasil='1'
			group by no_pa
			order by no_pa asc
			");
		return $data->result_array();
	}

	public function get_cetak_pa_pasien_umum($no_ipd){
		$data=$this->db->query("select no_pa
			from pemeriksaan_patologianatomi as a
			where a.no_register='$no_ipd'
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			and a.cetak_hasil='1'
			group by no_pa
			order by no_pa asc
			");
		return $data->result_array();
	}

	public function get_list_radiologi_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("select *
			from pemeriksaan_radiologi as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_radiologi_pasien_umum($no_ipd){
		$data=$this->db->query("select *
			from pemeriksaan_radiologi as a
			where a.no_register ='$no_ipd'
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_cetak_rad_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("select no_rad
			from pemeriksaan_radiologi as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			and a.cetak_hasil='1'
			group by no_rad
			order by no_rad asc
			");
		return $data->result_array();
	}	

	public function get_cetak_rad_pasien_umum($no_ipd,$no_reg_asal){
		$data=$this->db->query("select no_rad
			from pemeriksaan_radiologi as a
			where a.no_register='$no_ipd'
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			and a.cetak_hasil='1'
			group by no_rad
			order by no_rad asc
			");
		return $data->result_array();
	}

	public function get_list_resep_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("select *
			from resep_pasien as a
			where a.no_register in ('$no_ipd','$no_reg_asal') 
			and cetak_kwitansi <> 1
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_resep_pasien_umum($no_ipd){
		$data=$this->db->query("select *
			from resep_pasien as a
			where a.no_register='$no_ipd'
			and cetak_kwitansi <> 1
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_tindakan_ird_pasien($no_reg_asal){
		$data=$this->db->query("
			select a.*,b.nm_dokter, c.nmtindakan as nama_tindakan
			from tindakan_ird as a
			left join data_dokter as b on a.id_dokter = b.id_dokter
			left join jenis_tindakan as c on a.idtindakan = c.idtindakan
			where a.no_register = '$no_reg_asal'
			order by tgl_kunjungan asc
			");
		return $data->result_array();
	}

	public function get_list_poli_rj_pasien($no_reg_asal){
		$data=$this->db->query("select *
			from pelayanan_poli as a
			where a.no_register = '$no_reg_asal'
			order by tgl_kunjungan asc
			");
		return $data->result_array();
	}

	// pendapatan
	public function get_list_pasien_keluar_by_tanggal($tgl_awal,$tgl_akhir,$user){
		$data=$this->db->query("
			SELECT *
			FROM pasien_iri as a
			where a.tgl_cetak_kw IS NOT NULL
			and a.tgl_cetak_kw BETWEEN '$tgl_awal' AND '$tgl_akhir'
			and a.xuser = '$user'
			");
		return $data->result_array();
	}

	public function get_list_pasien_keluar_ird_by_tanggal($tgl_awal,$tgl_akhir,$user){
		$data=$this->db->query("
			SELECT a.*,b.nama
			FROM irddaftar_ulang as a
			LEFT JOIN data_pasien as b on a.no_medrec = b.no_medrec
			where a.tgl_cetak_kw IS NOT NULL
			and a.tgl_cetak_kw BETWEEN '$tgl_awal' AND '$tgl_akhir'
			and a.xcetak = '$user'
			");
		return $data->result_array();
	}

	public function get_list_pasien_keluar_irj_by_tanggal($tgl_awal,$tgl_akhir,$user){
		$data=$this->db->query("
			SELECT a.*,b.nama
			FROM daftar_ulang_irj as a
			LEFT JOIN data_pasien as b on a.no_medrec = b.no_medrec
			where a.tgl_cetak_kw IS NOT NULL
			and a.tgl_cetak_kw BETWEEN '$tgl_awal' AND '$tgl_akhir'
			and a.xcetak = '$user'
			");
		return $data->result_array();
	}

	public function get_list_pendapatan_poli_by_tanggal($tanggal, $jam_masuk, $jam_keluar){
		$data=$this->db->query("
			SELECT tanggal, id_poli, nm_poli,  SUM(jumlah_os),SUM(penerimaan) FROM v_pendapatan_rawat_jalan WHERE LEFT(tanggal, 10) = $tanggal AND RIGHT(tanggal, 8) BETWEEN '$jam_masuk' AND '$jam_keluar' GROUP BY id_poli
			");
		return $data->result_array();
	}


	public function get_list_pasien_luar_lab($tgl_awal,$tgl_akhir,$user){

		$data=$this->db->query("
			SELECT a.no_register,a.Nama,a.vtot_lab,b.diskon,a.xupdate
			FROM pasien_luar as a
			left join lab_header as b on a.no_register = b.no_register
			where a.lab = 0
			and a.xupdate BETWEEN '$tgl_awal' AND '$tgl_akhir'
			and a.cetak_kwitansi = 1
			and a.xuser = '$user'
			");
		return $data->result_array();
	}

	public function get_list_pasien_luar_rad($tgl_awal,$tgl_akhir,$user){

		$data=$this->db->query("
			SELECT a.no_register,a.Nama,a.vtot_rad,b.diskon,a.xupdate
			FROM pasien_luar as a
			left join rad_header as b on a.no_register = b.no_register
			where a.rad = 0
			and a.xupdate BETWEEN '$tgl_awal' AND '$tgl_akhir'
			and a.cetak_kwitansi = 1
			and a.xuser = '$user'
			");
		return $data->result_array();
	}

	public function get_list_pasien_luar_obat($tgl_awal,$tgl_akhir,$user){

		$data=$this->db->query("
			SELECT a.no_register,a.Nama,a.vtot_obat,b.diskon,a.xupdate,b.tot_tuslah
			FROM pasien_luar as a
			left join resep_header as b on a.no_register = b.no_resgister
			where a.obat = 0
			and a.xupdate BETWEEN '$tgl_awal' AND '$tgl_akhir'
			and a.cetak_kwitansi = 1
			and a.xuser = '$user'
			");
		return $data->result_array();
	}


	public function get_total_pendapatan_by_range_date($tgl_awal,$tgl_akhir){
		$data=$this->db->query("
			SELECT a.tgl_keluar, SUM(a.vtot) as vtot_per_tgl
			FROM pasien_iri as a
			where a.tgl_keluar IS NOT NULL
			and a.tgl_keluar BETWEEN '$tgl_awal' and '$tgl_akhir'
			GROUP BY tgl_keluar
			");
		return $data->result_array();
	}

	public function get_total_pendapatan_by_bulan($tgl_awal){
		// $data=$this->db->query("
		// 	SELECT a.tgl_keluar, SUM(a.vtot) as vtot_per_tgl, SUM(a.diskon) as vtot_diskon_per_tgl,
		// 	SUM(CASE WHEN jenis_bayar = 'TUNAI' THEN vtot ELSE 0 END) AS vtot_tunai_per_tgl,
		// 	SUM(CASE WHEN jenis_bayar = 'KREDIT' THEN vtot ELSE 0 END) AS vtot_kredit_per_tgl,
		// 	SUM(CASE WHEN jenis_bayar = 'TUNAI' THEN diskon ELSE 0 END) AS vtot_diskon_tunai_per_tgl,
		// 	SUM(CASE WHEN jenis_bayar = 'KREDIT' THEN diskon ELSE 0 END) AS vtot_diskon_kredit_per_tgl

		// 	FROM pasien_iri as a
		// 	where a.tgl_keluar IS NOT NULL
		// 	and a.tgl_keluar LIKE '$tgl_awal-%'
		// 	GROUP BY tgl_keluar
		// 	");

		$data=$this->db->query("
			SELECT a.tgl_keluar, SUM(a.vtot) as vtot_per_tgl, SUM(a.diskon) as vtot_diskon_per_tgl,
			SUM(a.nilai_kkkd) as vtot_dibayar_kartu_kredit,
			SUM(a.tunai) as vtot_dibayar_pasien,
			SUM(a.total_charge_kkkd) as vtot_charge_kk

			FROM pasien_iri as a
			where a.tgl_keluar IS NOT NULL
			and a.tgl_keluar LIKE '$tgl_awal-%'
			GROUP BY tgl_keluar
			");
		return $data->result_array();
	}

	public function get_total_pendapatan_by_tahun($tgl_awal){
		$data=$this->db->query("
			SELECT a.tgl_keluar, SUM(a.vtot) as vtot_per_tgl
			FROM pasien_iri as a
			where a.tgl_keluar IS NOT NULL
			and a.tgl_keluar LIKE '$tgl_awal-%''
			GROUP BY tgl_keluar
			");
		return $data->result_array();
	}

	// kamari
	public function get_empty_diagnosa_by_date($tgl_awal,$tgl_akhir){
		$data=$this->db->query("
			SELECT a.*,b.*,c.tgl_lahir, c.no_cm as no_medrec_patria,
			group_concat( e.diagnosa ) AS list_diagnosa_tambahan,
			group_concat( e.id_diagnosa ) AS list_id_diagnosa_tambahan
				FROM pasien_iri as a
				LEFT JOIN icd1 as b on a.diagnosa1 = b.id_icd
				LEFT JOIN data_pasien as c on a.no_cm = c.no_medrec
				LEFT JOIN ruang_iri as d on a.no_ipd = d.no_ipd
				LEFT JOIN diagnosa_iri as e on a.no_ipd = e.no_register
				WHERE a.tgl_keluar is not null
				and d.tglkeluarrg is null
				and a.tgl_keluar = '$tgl_akhir'
				GROUP BY a.no_ipd
			");
		return $data->result_array();
	}

	public function get_empty_diagnosa_by_month($bulan){
		// $data=$this->db->query("
		// 	SELECT *
		// 		FROM pasien_iri as a
		// 		LEFT JOIN icd1 as b on a.diagnosa1 = b.id_icd
		// 		WHERE a.tgl_keluar is not null
		// 		and a.tgl_keluar like '$bulan-%'
		// 	");
		$data=$this->db->query("
			SELECT a.*,b.*,c.tgl_lahir, c.no_cm as no_medrec_patria,
			group_concat( e.diagnosa ) AS list_diagnosa_tambahan,
			group_concat( e.id_diagnosa ) AS list_id_diagnosa_tambahan
				FROM pasien_iri as a
				LEFT JOIN icd1 as b on a.diagnosa1 = b.id_icd
				LEFT JOIN data_pasien as c on a.no_cm = c.no_medrec
				LEFT JOIN ruang_iri as d on a.no_ipd = d.no_ipd
				LEFT JOIN diagnosa_iri as e on a.no_ipd = e.no_register
				WHERE a.tgl_keluar is not null
				and a.tgl_keluar like '$bulan-%'
				GROUP BY a.no_ipd
			");
		return $data->result_array();
	}

	public function get_empty_diagnosa_by_year($tahun){
		$data=$this->db->query("
			SELECT *
				FROM pasien_iri as a
				LEFT JOIN icd1 as b on a.diagnosa1 = b.id_icd
				WHERE a.tgl_keluar is not null
				and a.tgl_keluar like '$tahun-%'
			");
		return $data->result_array();
	}

	public function select_pasien_like($value){
		// $data=$this->db->query("select *
		// 	from daftar_ulang_irj as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		// 	left join poliklinik as c on a.id_poli = c.id_poli
		// 	where a.no_register like '%$value%'");
		$data=$this->db->query("
			select *
			from pasien_iri as a
			where a.no_ipd like '%$value%'
			and tgl_keluar is null
			");
		return $data->result_array();
	}

	public function select_diagnosa_iri_by_id($id){
		// $data=$this->db->query("select *
		// 	from daftar_ulang_irj as a inner join data_pasien as b on a.no_medrec = b.no_medrec
		// 	left join poliklinik as c on a.id_poli = c.id_poli
		// 	where a.no_register like '%$value%'");
		$data=$this->db->query("
			select *
			from diagnosa_iri as a
			where a.no_register = '$id'
			");
		return $data->result_array();
	}


	//flag kwintansi
	public function flag_kwintasi_rad_terbayar($no_ipd){
		$data=$this->db->query("
			update pemeriksaan_radiologi
			set cetak_kwitansi = '1'
			where no_register = '$no_ipd'
			");
	}

	public function flag_kwintasi_lab_terbayar($no_ipd){
		$data=$this->db->query("
			update pemeriksaan_laboratorium
			set cetak_kwitansi = '1'
			where no_register = '$no_ipd'
			");
	}

	public function flag_kwintasi_obat_terbayar($no_ipd){
		$data=$this->db->query("
			update resep_pasien
			set cetak_kwitansi = '1'
			where no_register = '$no_ipd'
			");
	}

	public function flag_ird_terbayar($no_register,$tgl_cetak,$lunas){
		$data=$this->db->query("
			update irddaftar_ulang
			set cetak_kwitansi = 1, tgl_cetak_kw = '$tgl_cetak',lunas = $lunas
			where no_register = '$no_register'
			");
	}

	public function flag_irj_terbayar($no_register,$tgl_cetak,$lunas){
		$data=$this->db->query("
			update daftar_ulang_irj
			set cetak_kwitansi = 1, tgl_cetak_kw = '$tgl_cetak', lunas = $lunas
			where no_register = '$no_register'
			");

	}
}
?>
