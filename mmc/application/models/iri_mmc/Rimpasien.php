<?php
class Rimpasien extends CI_Model {

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

	public function get_matkes_ruang($noregister){
		$data=$this->db->query("SELECT * FROM pelayanan_iri a, jenis_tindakan b
where a.id_tindakan=b.idtindakan
and b.nmtindakan like '%MATKES%'
and b.idtindakan like 'NA01%'
and a.no_ipd='$noregister'");
		return $data->result_array();
	}

	public function get_matkes_ok($noregister){
		$data=$this->db->query("SELECT * FROM pelayanan_iri a, jenis_tindakan b
where a.id_tindakan=b.idtindakan
and b.nmtindakan like '%MATKES%'
and b.idtindakan like 'D%'
and a.no_ipd='$noregister'");
		return $data->result_array();
	}

	public function get_matkes_vk($noregister){
		$data=$this->db->query("SELECT * FROM pelayanan_iri a, jenis_tindakan b
where a.id_tindakan=b.idtindakan
and b.nmtindakan like '%MATKES%'
and b.idtindakan like 'BE%'
and a.no_ipd='$noregister'");
		return $data->result_array();
	}

	public function get_tindakan_perawat($no_ipd){
		$data=$this->db->query("SELECT * FROM pelayanan_iri JOIN data_dokter 
		ON pelayanan_iri.idoprtr=data_dokter.id_dokter
		where data_dokter.ket='Perawat' and pelayanan_iri.no_ipd='$no_ipd'");
		return $data->result_array();
	}

	public function get_detail_tindakan($id_tindakan,$kelas){
			return $this->db->query("select a.idtindakan, a.nmtindakan, b.total_tarif, b.tarif_alkes from jenis_tindakan a, tarif_tindakan b where a.idtindakan=b.id_tindakan and b.id_tindakan='$id_tindakan'
and b.kelas='$kelas'");
		}

		public function get_detail_kelas($kelas){
			return $this->db->query("select * from kelas where kelas='$kelas'");
		}

	public function get_jml_keluar_masuk_by_date($tgl_awal){
		$data=$this->db->query("
		SELECT a.tgl_masuk as tgl, a.no_ipd,b.no_cm,b.nama,c.id_icd,c.nm_diagnosa,b.sex,b.alamat,k.nmkontraktor,r.nmruang,'MASUK' as tipe_masuk
		FROM pasien_iri as a
		LEFT JOIN data_pasien as b on a.no_cm = b.no_medrec
		LEFT JOIN kontraktor as k on a.id_kontraktor = k.id_kontraktor
		LEFT JOIN ruang as r on a.idrg = r.idrg
		LEFT JOIN icd1 as c on a.diagnosa1 = c.id_icd
		WHERE a.tgl_masuk = '$tgl_awal'
		UNION
		SELECT d.tgl_keluar as tgl, d.no_ipd,e.no_cm,e.nama,f.id_icd,f.nm_diagnosa,e.sex,e.alamat,z.nmkontraktor,m.nmruang,'KELUAR' as tipe_masuk
		FROM pasien_iri as d
		LEFT JOIN data_pasien as e on d.no_cm = e.no_medrec
		LEFT JOIN kontraktor as z on d.id_kontraktor = z.id_kontraktor
		LEFT JOIN ruang as m on d.idrg = m.idrg
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
		$data=$this->db->query("select *, (SELECT nmkontraktor from kontraktor where id_kontraktor=a.id_kontraktor) as nmkontraktor
			from pasien_iri as a left join ruang_iri as b on a.no_ipd = b.no_ipd
			inner join data_pasien as c on a.no_cm = c.no_medrec
			left join ruang as d on a.idrg = d.idrg
			where a.tgl_keluar IS NULL and b.tglkeluarrg IS NULL
			and (a.ipdibu = '' or a.ipdibu is null)

			order by a.no_ipd asc
			");
		return $data->result_array();
	}

	public function select_pasien_iri_user($userid){
		$data=$this->db->query("select *, (SELECT nmkontraktor from kontraktor where id_kontraktor=a.id_kontraktor) as nmkontraktor
			from pasien_iri as a left join ruang_iri as b on a.no_ipd = b.no_ipd
			inner join data_pasien as c on a.no_cm = c.no_medrec
			left join ruang as d on a.idrg = d.idrg
            inner join dyn_ruang_user as e on a.idrg = e.id_ruang
			where a.tgl_keluar IS NULL and b.tglkeluarrg IS NULL
            and e.userid='$userid'
            and a.mutasi=0
			and (a.ipdibu = '' or a.ipdibu is null)
			order by a.no_ipd asc
			");
		return $data->result_array();
	}

	public function select_ruang_user($userid){
		$data=$this->db->query("select GROUP_CONCAT(nm_ruang) as akses_ruang from dyn_ruang_user as e where e.userid='$userid'
			");
		return $data->row();
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
			and (a.cara_bayar='BPJS' or a.cara_bayar='DIJAMIN' or (a.cetak_kwitansi='0' and a.cara_bayar='UMUM'))
			and a.no_lab is not null
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_all_lab_pasien($no_ipd){
		$data=$this->db->query("select *
		from pemeriksaan_laboratorium as a
		where a.no_register in ('$no_ipd')
		and a.no_lab is not null
		order by xupdate asc");
		return $data->result_array();
	}

	public function get_patient_doctor($no_ipd){
		$data=$this->db->query("select distinct(idoprtr) from pelayanan_iri where no_ipd='$no_ipd' and idoprtr!=''");
		return $data->result_array();
	}

	public function get_list_ok_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("SELECT COALESCE(no_ok, 'On Progress') AS no_ok, id_pemeriksaan_ok, id_tindakan, biaya_ok, jenis_tindakan, id_dokter, id_opr_anes, id_dok_anes, jns_anes, id_dok_anak, tgl_operasi, qty, vtot, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter) as nm_dokter, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_opr_anes) as nm_opr_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anes) as nm_dok_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anak) as nm_dok_anak
			FROM pemeriksaan_operasi WHERE no_register in ('$no_ipd','$no_reg_asal')
			order by jenis_tindakan asc");
		return $data->result_array();
	}
	//and jenis_tindakan not like '%MATKES%'
	public function get_list_tind_ok_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("SELECT COALESCE(no_ok, 'On Progress') AS no_ok, id_pemeriksaan_ok, id_tindakan, biaya_ok, jenis_tindakan, id_dokter, id_opr_anes, id_dok_anes, jns_anes, id_dok_anak, tgl_operasi, vtot, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter) as nm_dokter, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_opr_anes) as nm_opr_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anes) as nm_dok_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anak) as nm_dok_anak, qty
			FROM pemeriksaan_operasi WHERE no_register in ('$no_ipd','$no_reg_asal')
			and jenis_tindakan not like '%MATKES%'");
		return $data->result_array();
	}

	public function get_list_matkes_ok_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("SELECT COALESCE(no_ok, 'On Progress') AS no_ok, id_pemeriksaan_ok, id_tindakan, biaya_ok, jenis_tindakan, id_dokter, id_opr_anes, id_dok_anes, jns_anes, id_dok_anak, qty, tgl_operasi, vtot, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dokter) as nm_dokter, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_opr_anes) as nm_opr_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anes) as nm_dok_anes, (select nm_dokter as nm_dokter from data_dokter where id_dokter=pemeriksaan_operasi.id_dok_anak) as nm_dok_anak, qty
				FROM pemeriksaan_operasi 
				WHERE no_register in ('$no_ipd','$no_reg_asal')
				and jenis_tindakan like '%MATKES%'");
		return $data->result_array();
	}

	public function get_cetak_lab_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("select no_lab
			from pemeriksaan_laboratorium as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and (a.cara_bayar='BPJS' or a.cara_bayar='DIJAMIN' or (a.cetak_kwitansi='0' and a.cara_bayar='UMUM'))
			and a.cetak_hasil='1' and a.no_lab is not null
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
			and a.cetak_hasil='1' and a.no_lab is not null
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
			and a.no_lab is not null
			group by no_lab
			order by no_lab asc
			");
		return $data->result_array();
	}

	public function get_list_all_pa_pasien($no_ipd){
		$data=$this->db->query("select *
			from pemeriksaan_patologianatomi as a
			where a.no_register in ('$no_ipd')
			and a.no_pa is not null
			order by no_pa asc
			");
		return $data->result_array();
	}

	public function get_list_pa_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("select *
			from pemeriksaan_patologianatomi as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and (a.cara_bayar='BPJS' or a.cara_bayar='DIJAMIN' or (a.cetak_kwitansi='0' and a.cara_bayar='UMUM'))
			and a.no_pa is not null 
			order by no_pa asc
			");
		return $data->result_array();
	}

	public function get_list_pa_pasien_umum($no_ipd){
		$data=$this->db->query("select *
			from pemeriksaan_patologianatomi as a
			where a.no_register='$no_ipd'
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			and a.no_pa is not null 
			order by no_pa asc
			");
		return $data->result_array();
	}

	public function get_cetak_pa_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("select no_pa
			from pemeriksaan_patologianatomi as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and (a.cara_bayar='BPJS' or a.cara_bayar='DIJAMIN' or (a.cetak_kwitansi='0' and a.cara_bayar='UMUM'))
			and a.cetak_hasil='1' and a.no_pa is not null
			order by no_pa asc
			");
		return $data->result_array();
	}

	public function get_cetak_pa_pasien_umum($no_ipd){
		$data=$this->db->query("select no_pa
			from pemeriksaan_patologianatomi as a
			where a.no_register='$no_ipd'
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			and a.cetak_hasil='1' and a.no_pa is not null
			group by no_pa
			order by no_pa asc
			");
		return $data->result_array();
	}

	public function get_list_radiologi_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("select *
			from pemeriksaan_radiologi as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and (a.cara_bayar='BPJS' or a.cara_bayar='DIJAMIN' or (a.cetak_kwitansi='0' and a.cara_bayar='UMUM'))
			and a.no_rad is not null
			and a.jenis_tindakan not like '%USG%'
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_usg_pasien($no_ipd,$no_reg_asal){
		$data=$this->db->query("select *
			from pemeriksaan_radiologi as a
			where a.no_register in ('$no_ipd','$no_reg_asal')
			and (a.cara_bayar='BPJS' or a.cara_bayar='DIJAMIN' or (a.cetak_kwitansi='0' and a.cara_bayar='UMUM'))
			and a.no_rad is not null
			and a.jenis_tindakan like '%USG%'
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_all_radiologi_pasien($no_ipd){
		$data=$this->db->query("select *
			from pemeriksaan_radiologi as a
			where a.no_register in ('$no_ipd')
			and a.no_rad is not null			
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_radiologi_pasien_umum($no_ipd){
		$data=$this->db->query("select *
			from pemeriksaan_radiologi as a
			where a.no_register ='$no_ipd'
			and ((a.cetak_kwitansi='1' and a.cara_bayar='UMUM') or (a.cetak_kwitansi='0' and a.cara_bayar<>'UMUM'))
			and a.no_rad is not null
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
			and a.no_rad is not null
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
			and a.no_rad is not null
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
			and a.no_resep is not null
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_all_resep_pasien($no_ipd){
		$data=$this->db->query("select *
			from resep_pasien as a
			where a.no_register in ('$no_ipd')
			and a.no_resep is not null
			order by xupdate asc
			");
		return $data->result_array();
	}

	public function get_list_resep_pasien_umum($no_ipd){
		$data=$this->db->query("select *
			from resep_pasien as a
			where a.no_register='$no_ipd'
			and cetak_kwitansi <> 1
			and a.no_resep is not null
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

	public function get_list_poli_rj_dokter_pasien($no_reg_asal){
		$data=$this->db->query("select *
			from pelayanan_poli as a, data_dokter b
			where a.id_dokter=b.id_dokter 
        	and b.ket!='Perawat' and a.no_register = '$no_reg_asal'
			order by tgl_kunjungan asc
			");
		return $data->result_array();
	}

	public function get_list_poli_rj_perawat_pasien($no_reg_asal){
		$data=$this->db->query("select *
			from pelayanan_poli as a
			where ((SELECT ket from data_dokter where id_dokter=a.id_dokter)='Perawat' or (a.id_dokter is null or a.id_dokter='')) and a.no_register = '$no_reg_asal'
			order by a.tgl_kunjungan asc
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
			");
		//and a.xuser = '$user'
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

	public function get_list_pasien_keluar_irj_by_tanggalold($tgl_awal,$tgl_akhir,$user){
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

	public function get_list_pasien_keluar_irj_by_tanggal($tgl_awal,$tgl_akhir,$user){
		$data=$this->db->query("
            SELECT a.*,b.nama, SUM(c.vtot) as vtotpoli, (SELECT nmkontraktor from kontraktor where id_kontraktor=a.id_kontraktor) as nmkontraktor, (SELECT nm_poli from poliklinik where id_poli=a.id_poli) as nm_poli, c.tgl_cetak_kw as tgl_cetak, a.xuser
			FROM daftar_ulang_irj as a, data_pasien as b, pelayanan_poli as c  
			where c.tgl_cetak_kw IS NOT NULL
            and a.no_medrec = b.no_medrec
            and a.no_register=c.no_register
			and LEFT(c.tgl_cetak_kw,16)>='$tgl_awal' AND LEFT(c.tgl_cetak_kw,16)<='$tgl_akhir'			
			and c.idtindakan in ('1B0105','1B0106','1B0104','1B0102')
            group by (a.no_register)
			");
		//and c.xuser = '$user'
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
			SELECT a.*,b.*,c.tgl_lahir, c.sex,c.no_cm as no_medrec_patria, (SELECT nmkontraktor from kontraktor where id_kontraktor=a.id_kontraktor) as nmkontraktor,
			group_concat( e.diagnosa ) AS list_diagnosa_tambahan,
			group_concat( e.id_diagnosa ) AS list_id_diagnosa_tambahan, 
				(SELECT nmruang from ruang where idrg=d.idrg) as nmruang
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
			SELECT a.*,b.*,c.tgl_lahir, c.sex , c.no_cm as no_medrec_patria, (SELECT nmkontraktor from kontraktor where id_kontraktor=a.id_kontraktor) as nmkontraktor,
			group_concat( e.diagnosa ) AS list_diagnosa_tambahan,
			(SELECT nmruang from ruang where idrg=d.idrg) as nmruang,
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

	function get_data_ruangan($no_ipd){
		return $this->db->query("SELECT a.no_ipd AS no_ipd , a.nama AS nama , a.klsiri AS klsiri , a.bed AS bed , b.nmruang AS nmruang , c.idrgiri AS idrgiri , d.no_cm AS no_cm FROM pasien_iri a LEFT JOIN ruang b ON LEFT(a.bed , 4) = b.idrg LEFT JOIN ruang_iri c ON( a.no_ipd = c.no_ipd AND a.bed = c.bed) LEFT JOIN data_pasien AS d ON a.no_cm = d.no_medrec WHERE a.no_ipd = '$no_ipd'");
	}

	public function get_all_kelas_with_empty_bed(){
		$data=$this->db->query("
			SELECT concat(a.idrg,'-',b.nmruang,'-',a.kelas) as text, count(*) 
			from bed as a
			inner join ruang as b on a.idrg = b.idrg
			where a.isi = 'N'
			group by a.kelas,a.idrg,b.nmruang");
		return $data->result_array();
	}

	public function update_bed($asal, $baru){
		$this->db->query("UPDATE bed SET isi ='N' WHERE bed = '$asal'");
		$this->db->query("UPDATE bed SET isi ='Y' WHERE bed = '$baru'");
		return true;
	}

	public function update_ruangan_ruangiri($data, $idrgiri){
			$this->db->where('idrgiri', $idrgiri);
			$this->db->update('ruang_iri', $data); 
			return true;
	}

	public function update_ruangan_pasieniri($data1, $no_ipd){
			$this->db->where('no_ipd', $no_ipd);
			$this->db->update('pasien_iri', $data1); 
			return true;
	}
	public function get_vtot_ruangan($id_tindakan, $kelas){
		return $this->db->query("SELECT total_tarif AS vtot FROM tarif_tindakan WHERE id_tindakan = '$id_tindakan' AND kelas = '$kelas'");
	}

	public function count_tindakan($no_ipd){
		return $this->db->query("SELECT 
    (IFNULL((SELECT 
                    COUNT(*) AS cek
                FROM
                    pelayanan_iri
                WHERE
                    no_ipd = '$no_ipd'),
            0) + IFNULL((SELECT 
                    COUNT(*) AS cek
                FROM
                    pelayanan_iri_temp
                WHERE
                    no_ipd = '$no_ipd'
                GROUP BY no_ipd),
            0)) AS total

");
	}

	function get_roleid($userid){
		return $this->db->query("Select roleid from dyn_role_user where userid = '".$userid."'");
	}

	function balikkan_keruangan($no_ipd){
		$this->db->query("UPDATE pasien_iri as a, ruang_iri as b
			set a.tgl_keluar = NULL ,
			 b.tglkeluarrg = NULL
			where
			a.no_ipd = '$no_ipd' and b.no_ipd='$no_ipd'");
		return true;
	}
}
?>
