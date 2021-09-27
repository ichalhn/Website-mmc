<?php
class Rimtindakan extends CI_Model {

	//ini buat save bener bener //

	public function insert_tindakan($data){
		$this->db->insert('pelayanan_iri', $data);
	}

	//end hapus komengnya

	public function select_icd_1_like($value){

		// $data=$this->db->query("select *
		// 	from icd1 as a
		// 	where a.nm_diagnosa like '%$value%'
		// 	order by nm_diagnosa asc
		// 	");

		// $data=$this->db->query("select *
		// 	from icd1 as a
		// 	where a.id_icd like '%$value%'
		// 	order by id_icd asc
		// 	");

		$data=$this->db->query("
					SELECT * from (
					select *
					from icd1 as a
					where a.id_icd like '%$value%'
					UNION
					select *
					from icd1 as b
					where b.nm_diagnosa like '%$value%') c
					GROUP BY c.id_icd
					limit 20
			");
		return $data->result_array();
	}

	public function select_all_tindakan(){
		$data=$this->db->query("select * from pelayanan_iri");
		return $data->result_array();
	}

	public function delete_pelayanan_iri_temp($no_ipd){
		$data=$this->db->query("
			DELETE FROM pelayanan_iri_temp
			WHERE no_ipd = '$no_ipd' ; 
			");
	}

	public function delete_pelayanan_iri_temp_by_id($id){
		$data=$this->db->query("
			DELETE FROM pelayanan_iri_temp
			WHERE id_jns_layanan = '$id' ; 
			");
	}

	public function select_all_tindakan_temp(){
		$data=$this->db->query("select * from pelayanan_iri_temp");
		return $data->result_array();
	}

	public function select_tindakan_temp_by_id($id_jns_layanan){
		$data=$this->db->query("select * 
			from pelayanan_iri_temp
			where id_jns_layanan = '$id_jns_layanan'
			");
		return $data->result_array();
	}

	public function select_tindakan_by_id($id_jns_layanan){
		$data=$this->db->query("select * 
			from pelayanan_iri
			where id_jns_layanan = '$id_jns_layanan'
			");
		return $data->result_array();
	}

	function get_rujukan_penunjang($no_ipd){
		return $this->db->query("SELECT 
	COALESCE(ok,'0')as ok, 
	COALESCE(lab,'0') as lab, 
	COALESCE(rad,'0') as rad, 
	COALESCE(pa,'0') as pa, 
	COALESCE(obat,'0') as obat, 
	COALESCE(status_ok,'0') as status_ok, 
	COALESCE(status_lab,'0') as status_lab, 
	COALESCE(status_pa,'0') as status_pa, 
	COALESCE(status_rad,'0') as status_rad, 
	COALESCE(status_obat,'0') as status_obat 
FROM pasien_iri 
WHERE no_ipd='$no_ipd' order by tgldaftarri DESC
Limit 1");
	}		
		function update_rujukan_penunjang($data,$no_ipd){
			$this->db->where('no_ipd', $no_ipd);
			$this->db->update('pasien_iri', $data);
			return true;
		}



	public function get_list_tindakan_pasien_by_no_ipd_temp($no_ipd){
		// $data=$this->db->query("
		// 	select * 
		// 	from pelayanan_iri_temp as a inner join data_pasien as b on a.nomederec = b.no_medrec
		// 	inner join jenis_tindakan as c on a.id_tindakan = c.idtindakan
		// 	where a.no_ipd = '$no_ipd' 
		// 	order by tgl_layanan asc");

		$data=$this->db->query("
			select *, a.xuser as user_input, (select nm_dokter from data_dokter where id_dokter=a.idoprtr) as nmdokter
			from pelayanan_iri_temp as a inner join data_pasien as b on a.nomederec = b.no_medrec
			inner join jenis_tindakan as c on a.id_tindakan = c.idtindakan
			where a.no_ipd = '$no_ipd' 
			order by tgl_layanan asc");
		return $data->result_array();
	}

	public function get_all_tindakan($kelas){
		

		// $data=$this->db->query("
		// 	select * 
		// 	from jenis_tindakan_inap as a inner join tarif_tindakan as b on a.idtindakan = b.id_tindakan
		// 	left join jenis_tindakan as c on a.idtindakan = c.id_tindakan
		// 	where a.nmtindakan <> '' and b.kelas = '$kelas'
		// 	order by a.nmtindakan asc");

		// echo "
		// select a.*,b.*,c.paket 
		// 	from jenis_tindakan_inap as a inner join tarif_tindakan as b on a.idtindakan = b.id_tindakan
		// 	left join jenis_tindakan as c on a.idtindakan = c.idtindakan
		// 	where a.nmtindakan <> '' and b.kelas = '$kelas'
		// 	order by a.nmtindakan asc
		// 	";exit;

		$data=$this->db->query("
				select a.*,b.*,c.paket 
			from jenis_tindakan_inap as a inner join tarif_tindakan as b on a.idtindakan = b.id_tindakan
			inner join jenis_tindakan as c on a.idtindakan = c.idtindakan
			where a.nmtindakan <> '' and b.kelas = '$kelas'
			and a.idpok1!='D' and a.idpok1!='F'
			order by a.nmtindakan asc
			");

		return $data->result_array();
	}	

	public function get_all_tindakan_vk($kelas){		

		$data=$this->db->query("
				select a.*,b.*,c.paket 
			from jenis_tindakan_vk as a inner join tarif_tindakan as b on a.idtindakan = b.id_tindakan
			inner join jenis_tindakan as c on a.idtindakan = c.idtindakan
			where a.nmtindakan <> '' and b.kelas = '$kelas'
			order by a.nmtindakan asc
			");

		return $data->result_array();
	}

	public function get_all_tindakan_icu($kelas){		

		$data=$this->db->query("
				select a.*,b.*,c.paket 
			from jenis_tindakan_inap as a inner join tarif_tindakan as b on a.idtindakan = b.id_tindakan
			left join jenis_tindakan as c on a.idtindakan = c.idtindakan
			where a.nmtindakan <> '' and b.kelas = '$kelas'
			and a.idpok1!='D' and a.idpok1!='N'
			order by a.nmtindakan asc
			");

		return $data->result_array();
	}

	public function get_tarif_tindakan_by_id_kelas($id_tindakan,$kelas){
		$data=$this->db->query("
			select * 
			from jenis_tindakan as a inner join tarif_tindakan as b on a.idtindakan = b.id_tindakan
			where a.nmtindakan <> '' and b.kelas = '$kelas' and b.id_tindakan = '$id_tindakan' ");
		return $data->result_array();
	}
/*SELECT * FROM pelayanan_iri, data_dokter, jenis_tindakan
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and data_dokter.ket!='Perawat' and pelayanan_iri.no_ipd='RI00000013'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and jenis_tindakan.nmtindakan not like '%MATKES%'*/
	public function get_list_tindakan_pasien_by_no_ipd($no_ipd){
		$data=$this->db->query("
			select *, (select nm_dokter from data_dokter where id_dokter=a.idoprtr) as nm_dokter, (select nmruang from ruang where idrg=a.idrg) as nmruang 
			from pelayanan_iri as a inner join data_pasien as b on a.nomederec = b.no_medrec
			inner join jenis_tindakan as c on a.id_tindakan = c.idtindakan
			where a.no_ipd = '$no_ipd' 
			order by a.idoprtr asc
			");
		return $data->result_array();
	}

	public function get_list_sumtindakan_pasien_by_no_ipd($no_ipd){
		$data=$this->db->query("
			select a.id_tindakan, a.kelas, a.idoprtr, a.tgl_layanan, c.nmtindakan, SUM(a.vtot) as vtot, a.tarifalkes, a.tumuminap, sum(a.qtyyanri) as qtyyanri, (select nm_dokter from data_dokter where id_dokter=a.idoprtr) as nm_dokter, (select nm_dokter from data_dokter where id_dokter=a.idoprtr) as nmdokter 
			from pelayanan_iri as a inner join data_pasien as b on a.nomederec = b.no_medrec
			inner join jenis_tindakan as c on a.id_tindakan = c.idtindakan
			where a.no_ipd = '$no_ipd' 
			group by a.id_tindakan, a.idoprtr, a.kelas, a.tgl_layanan
			order by a.idoprtr asc");
		return $data->result_array();
	}

	public function get_list_tindakan_dokter_pasien_by_no_ipd($no_ipd){
		$data=$this->db->query("SELECT pelayanan_iri.id_tindakan, jenis_tindakan.nmtindakan, SUM(pelayanan_iri.vtot) as vtot, pelayanan_iri.tarifalkes, pelayanan_iri.kelas, pelayanan_iri.tumuminap, sum(pelayanan_iri.qtyyanri) as qtyyanri, (select nm_dokter from data_dokter where id_dokter=pelayanan_iri.idoprtr) as nm_dokter, (select nm_dokter from data_dokter where id_dokter=pelayanan_iri.idoprtr) as nmdokter  
			FROM pelayanan_iri, data_dokter, jenis_tindakan, data_pasien
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and data_dokter.ket!='Perawat' and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec
        and jenis_tindakan.nmtindakan not like '%MATKES%'
        and jenis_tindakan.nmtindakan not like '%oksigen%'
        and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%ICU%')
        and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%Bersalin%')
        group by pelayanan_iri.id_tindakan, pelayanan_iri.idoprtr, pelayanan_iri.kelas
		order by data_dokter.nm_dokter asc");
		return $data->result_array();
	}

	public function get_list_tindakan_dokter_pasien_by_no_ipd_kw($no_ipd){
	$data=$this->db->query("SELECT pelayanan_iri.id_tindakan,
jenis_tindakan.idkel_tind,
    jenis_tindakan.nmtindakan,
    SUM(pelayanan_iri.tarifalkes) as tarifalkes,
    pelayanan_iri.kelas,
    SUM(pelayanan_iri.qtyyanri) AS qtyyanri,
    SUM(pelayanan_iri.tumuminap) as tumuminap,
    SUM(pelayanan_iri.tumuminap*pelayanan_iri.qtyyanri) as vtot, IF((SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='Spesialis' && (SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='','',(SELECT 
            nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)) as nm_dokter, 
    IF((SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='Spesialis' && (SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='','',(SELECT 
            nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)) AS nmdokter    
     from pelayanan_iri, jenis_tindakan, kel_tind, data_dokter, data_pasien 
where
		pelayanan_iri.idoprtr=data_dokter.id_dokter 
		and jenis_tindakan.idkel_tind=kel_tind.idkel_tind 
        and pelayanan_iri.no_ipd='RI00000470'
        AND data_dokter.ket != 'Perawat'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec
        GROUP BY pelayanan_iri.id_tindakan , pelayanan_iri.idoprtr , jenis_tindakan.idkel_tind
		ORDER BY data_dokter.nm_dokter ASC
        
   ");
		return $data->result_array();
	}

	public function get_list_tindakan_dokter_pasien_by_no_ipd_newest($no_ipd, $case){
		$query='';
		if($case=='visite'){
			$query="and kel_tind.idkel_tind=3 GROUP BY pelayanan_iri.idoprtr";
		} else {
			$query="and kel_tind.idkel_tind=0 GROUP BY pelayanan_iri.idoprtr, pelayanan_iri.id_tindakan";
		}
		
		$data=$this->db->query("SELECT (SELECT nmruang from ruang where idrg=pelayanan_iri.idrg) as nmruang,pelayanan_iri.id_tindakan,
		jenis_tindakan.idkel_tind,
	    jenis_tindakan.nmtindakan,
	    kel_tind.nama_kel,
	    SUM(pelayanan_iri.tarifalkes) as tarifalkes,
	    pelayanan_iri.kelas,
	    SUM(pelayanan_iri.qtyyanri) AS qtyyanri,
	    pelayanan_iri.tumuminap,
	    SUM(pelayanan_iri.tumuminap*pelayanan_iri.qtyyanri) as vtot, IF((SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='Spesialis' && (SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='','',(SELECT 
            nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)) as nm_dokter, 
    IF((SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='Spesialis' && (SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='','',(SELECT 
            nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)) AS nmdokter    
     from pelayanan_iri, jenis_tindakan, kel_tind, data_dokter, data_pasien 
where
		pelayanan_iri.idoprtr=data_dokter.id_dokter 
		and jenis_tindakan.idkel_tind=kel_tind.idkel_tind 
        and pelayanan_iri.no_ipd='$no_ipd'
        AND (data_dokter.ket != 'Perawat'
        and data_dokter.ket != 'Bidan')
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec        
        $query        
		ORDER BY nm_dokter DESC");
		return $data->result_array();
	}

	public function get_list_tindakan_perawat_pasien_by_no_ipd($no_ipd){
		$data=$this->db->query("SELECT * FROM pelayanan_iri, data_dokter, jenis_tindakan, data_pasien
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and data_dokter.ket='Perawat' and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec
        and jenis_tindakan.nmtindakan not like '%MATKES%'
        and jenis_tindakan.nmtindakan not like '%oksigen%'
        and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%ICU%')
        and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%Bersalin%')
		order by pelayanan_iri.tgl_layanan asc");
		return $data->result_array();
	}

	public function get_list_tindakan_perawat_pasien_by_no_ipd_newest($no_ipd, $case){
		$query='';
		if($case=='anyelir'){
			$query="and ((SELECT nmruang from ruang where idrg=pelayanan_iri.idrg) like '%Bersalin%'
        or (SELECT nmruang from ruang where idrg=pelayanan_iri.idrg) like '%Anyelir%')";
		} else {
			$query="and ((SELECT nmruang from ruang where idrg=pelayanan_iri.idrg) not like '%Bersalin%'
        and (SELECT nmruang from ruang where idrg=pelayanan_iri.idrg) not like '%Anyelir%')";
		}
		
		$data=$this->db->query("SELECT (SELECT nmruang from ruang where idrg=pelayanan_iri.idrg) as nmruang,pelayanan_iri.id_tindakan,
jenis_tindakan.idkel_tind,
    jenis_tindakan.nmtindakan,
    SUM(pelayanan_iri.tarifalkes) as tarifalkes,
    pelayanan_iri.kelas,
    SUM(pelayanan_iri.qtyyanri) AS qtyyanri,
    pelayanan_iri.tumuminap,
    SUM(pelayanan_iri.tumuminap*pelayanan_iri.qtyyanri) as vtot, IF((SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='Spesialis' && (SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='','',(SELECT 
            nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)) as nm_dokter, 
    IF((SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='Spesialis' && (SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='','',(SELECT 
            nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)) AS nmdokter    
     from pelayanan_iri, jenis_tindakan, kel_tind, data_dokter, data_pasien 
where
		pelayanan_iri.idoprtr=data_dokter.id_dokter 
		and jenis_tindakan.idkel_tind=kel_tind.idkel_tind 
        and pelayanan_iri.no_ipd='$no_ipd'
        AND (data_dokter.ket = 'Perawat'
        or data_dokter.ket = 'Bidan')
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec
        and kel_tind.idkel_tind=0
        $query
        GROUP BY pelayanan_iri.id_tindakan , pelayanan_iri.idoprtr , jenis_tindakan.idkel_tind
		ORDER BY nm_dokter DESC");
		return $data->result_array();
	}

	public function get_list_tindakan_perawat_pasien_by_no_ipd_kw($no_ipd){
		$data=$this->db->query("SELECT (SELECT nmruang from ruang where idrg=pelayanan_iri.idrg) as nmruang, SUM(tarifalkes) as tarifalkes, SUM(tumuminap*qtyyanri) as vtot, SUM(qtyyanri) as qtyyanri, SUM(tumuminap) as tumuminap FROM pelayanan_iri, data_dokter, jenis_tindakan, data_pasien
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and data_dokter.ket='Perawat' and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec
        and jenis_tindakan.nmtindakan not like '%MATKES%'
        and jenis_tindakan.nmtindakan not like '%oksigen%'
        group by pelayanan_iri.idrg
		order by pelayanan_iri.tgl_layanan asc");
		return $data->result_array();
	}

	public function get_list_oksigen_pasien_by_no_ipd($no_ipd){
		$data=$this->db->query("SELECT * FROM pelayanan_iri, data_dokter, jenis_tindakan, data_pasien
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and data_dokter.ket='Rumah Sakit' and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec
        and jenis_tindakan.nmtindakan like '%oksigen%'
		order by pelayanan_iri.tgl_layanan asc");
		return $data->result_array();
		//        and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%ICU%')
        //and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%Bersalin%')
	}

	public function get_list_oksigen_pasien_by_no_ipd_newest($no_ipd){
		$data=$this->db->query("SELECT (SELECT nmruang from ruang where idrg=pelayanan_iri.idrg) as nmruang,pelayanan_iri.id_tindakan,
jenis_tindakan.idkel_tind,
    jenis_tindakan.nmtindakan,
    SUM(pelayanan_iri.tarifalkes) as tarifalkes,
    pelayanan_iri.kelas,
    SUM(pelayanan_iri.qtyyanri) AS qtyyanri,
    pelayanan_iri.tumuminap,
    SUM(pelayanan_iri.tumuminap*pelayanan_iri.qtyyanri) as vtot, IF((SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='Spesialis' && (SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='','',(SELECT 
            nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)) as nm_dokter, 
    IF((SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='Spesialis' && (SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='','',(SELECT 
            nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)) AS nmdokter    
     from pelayanan_iri, jenis_tindakan, kel_tind, data_dokter, data_pasien 
where
		pelayanan_iri.idoprtr=data_dokter.id_dokter 
		and jenis_tindakan.idkel_tind=kel_tind.idkel_tind 
        and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec
        and kel_tind.idkel_tind=1");
		return $data->result_array();
		//        and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%ICU%')
        //and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%Bersalin%')
	}

	public function get_list_tindakan_perawat_ruang_pasien_by_no_ipd($no_ipd){
		$data=$this->db->query("SELECT * FROM pelayanan_iri, data_dokter, jenis_tindakan, data_pasien
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and data_dokter.ket='Perawat' and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec
        and jenis_tindakan.nmtindakan not like '%MATKES%'
		order by pelayanan_iri.tgl_layanan asc");
		return $data->result_array();
	}

	//matkes ruang
	public function get_list_tindakan_matkes_pasien_by_no_ipd_newest($no_ipd){
		$data=$this->db->query("SELECT (SELECT nmruang from ruang where idrg=pelayanan_iri.idrg) as nmruang,pelayanan_iri.id_tindakan,
jenis_tindakan.idkel_tind,
    jenis_tindakan.nmtindakan,
    SUM(pelayanan_iri.tarifalkes) as tarifalkes,
    pelayanan_iri.kelas,
    SUM(pelayanan_iri.qtyyanri) AS qtyyanri,
    pelayanan_iri.tumuminap,
    SUM(pelayanan_iri.tumuminap*pelayanan_iri.qtyyanri) as vtot, IF((SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='Spesialis' && (SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='','',(SELECT 
            nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)) as nm_dokter, 
    IF((SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='Spesialis' && (SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='','',(SELECT 
            nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)) AS nmdokter    
     from pelayanan_iri, jenis_tindakan, kel_tind, data_dokter, data_pasien 
where
		pelayanan_iri.idoprtr=data_dokter.id_dokter 
		and jenis_tindakan.idkel_tind=kel_tind.idkel_tind 
        and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec
        and kel_tind.idkel_tind=4");
		return $data->result_array();
		//and data_dokter.ket!='Perawat' 
	}

	//matkes icu
	public function get_list_tindakan_matkes_icu_pasien_by_no_ipd($no_ipd){
		$data=$this->db->query("SELECT * FROM pelayanan_iri, data_dokter, jenis_tindakan, data_pasien
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec
        and jenis_tindakan.nmtindakan like '%MATKES%'
        and pelayanan_iri.idrg = (SELECT idrg FROM ruang WHERE lokasi = 'Ruang ICU')
		order by pelayanan_iri.tgl_layanan asc");
		return $data->result_array();
		//and data_dokter.ket!='Perawat' 
	}

	//matkes vk
	public function get_list_tindakan_matkes_vk_pasien_by_no_ipd($no_ipd){
		$data=$this->db->query("SELECT * FROM pelayanan_iri, data_dokter, jenis_tindakan, data_pasien
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec
        and jenis_tindakan.nmtindakan like '%MATKES%'
        and pelayanan_iri.idrg = (SELECT idrg FROM ruang WHERE lokasi = 'Ruang Bersalin')
		order by pelayanan_iri.tgl_layanan asc");
		return $data->result_array();
		//and data_dokter.ket!='Perawat' 
	}



	//ruang
	public function get_list_ruang_pasien_by_no_ipd($no_ipd){
		$data=$this->db->query("SELECT 
		    *,
		    IF(b.tglkeluarrg,
		        DATEDIFF(b.tglkeluarrg, b.tglmasukrg),
		        DATEDIFF(Left(a.tgl_keluar, 10), b.tglmasukrg)) as days,		    
		    IF(b.tglkeluarrg,
		        DATEDIFF(b.tglkeluarrg, b.tglmasukrg),
		        DATEDIFF(Left(a.tgl_keluar, 10), b.tglmasukrg))*IFNULL(b.vtot,0) as vtot_ruang
			FROM
			    ruang_iri b,
                pasien_iri a
			WHERE b.idrg != (SELECT 
			            idrg
			        FROM
			            ruang
			        WHERE
			            lokasi = 'Ruang ICU')
			and
			    b.idrg != (SELECT 
			            idrg
			        FROM
			            ruang
			        WHERE
			            lokasi = 'Ruang Bersalin')		
			and b.no_ipd='$no_ipd'
            and b.no_ipd=a.no_ipd
			");
		return $data->result_array();
	}

	//icu
	public function get_list_tindakan_icu_pasien_by_no_ipd($no_ipd){
		$data=$this->db->query("SELECT 
		    *,
		    IF(b.tglkeluarrg,
		        DATEDIFF(b.tglkeluarrg, b.tglmasukrg),
		        DATEDIFF(LEFT(NOW(), 10), b.tglmasukrg)) as days,
		    SUM(a.vtot) AS vtot,
		    IF(b.tglkeluarrg,
		        DATEDIFF(b.tglkeluarrg, b.tglmasukrg),
		        DATEDIFF(LEFT(NOW(), 10), b.tglmasukrg))*IFNULL(b.vtot,0)+SUM(a.vtot) as vtot_icu,
		    IF(b.tglkeluarrg,
		        DATEDIFF(b.tglkeluarrg, b.tglmasukrg),
		        DATEDIFF(LEFT(NOW(), 10), b.tglmasukrg))*IFNULL(b.vtot,0) as vtot_ruang
			FROM
			    pelayanan_iri a,
			    ruang_iri b
			WHERE
			    a.idrg = (SELECT 
			            idrg
			        FROM
			            ruang
			        WHERE
			            lokasi = 'Ruang ICU')
			And a.no_ipd='$no_ipd'
			and a.no_ipd=b.no_ipd
			");
		return $data->result_array();
	}

	public function get_vk_room($no_ipd){
		$data=$this->db->query("SELECT 
		    *, (SELECT nmruang from ruang where idrg=b.idrg) as nmruang
			FROM
			    ruang_iri b
			WHERE
			    b.idrg = (SELECT 
			            idrg
			        FROM
			            ruang
			        WHERE
			            lokasi = 'Ruang Bersalin')
			And b.no_ipd='$no_ipd'");
		return $data->result_array();
	}
	//vk
	public function get_list_tindakan_vk_pasien_by_no_ipd($no_ipd){
		$data=$this->db->query("SELECT 
		    *,
		    IF(b.tglkeluarrg,
		        DATEDIFF(b.tglkeluarrg, b.tglmasukrg),
		        DATEDIFF(LEFT(NOW(), 10), b.tglmasukrg)) as days,
		    SUM(a.vtot) AS vtot,
		    IF(b.tglkeluarrg,
		        DATEDIFF(b.tglkeluarrg, b.tglmasukrg),
		        DATEDIFF(LEFT(NOW(), 10), b.tglmasukrg))*IFNULL(b.vtot,0)+SUM(a.vtot) as vtot_vk,
		    IF(b.tglkeluarrg,
		        DATEDIFF(b.tglkeluarrg, b.tglmasukrg),
		        DATEDIFF(LEFT(NOW(), 10), b.tglmasukrg))*IFNULL(b.vtot,0) as vtot_ruang
			FROM
			    pelayanan_iri a,
			    ruang_iri b
			WHERE
			    a.idrg = (SELECT 
			            idrg
			        FROM
			            ruang
			        WHERE
			            lokasi = 'Ruang Bersalin')
			And a.no_ipd='$no_ipd'
			and a.no_ipd=b.no_ipd
			");
		return $data->result_array();
	}

	public function get_list_tindakan_vk_pasien_by_no_ipd_kw($no_ipd){
		$data=$this->db->query("SELECT pelayanan_iri.id_tindakan, jenis_tindakan.nmtindakan, SUM(pelayanan_iri.vtot) as vtot, pelayanan_iri.tarifalkes, pelayanan_iri.kelas, pelayanan_iri.tumuminap, sum(pelayanan_iri.qtyyanri) as qtyyanri, 
		IF((SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='Spesialis' && (SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='','',(SELECT 
            nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)) as nm_dokter, 
        IF((SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='Spesialis' && (SELECT 
            ket
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)!='','',(SELECT 
            nm_dokter
        FROM
            data_dokter
        WHERE
            id_dokter = pelayanan_iri.idoprtr)) AS nmdokter  
			FROM pelayanan_iri, data_dokter, jenis_tindakan, data_pasien
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec        
        and jenis_tindakan.nmtindakan not like '%oksigen%'
        and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%ICU%')
        and pelayanan_iri.idrg=(SELECT idrg from ruang where lokasi LIKE '%Bersalin%')
        group by pelayanan_iri.id_tindakan, pelayanan_iri.idoprtr, pelayanan_iri.kelas
		order by data_dokter.nm_dokter asc
		");
		return $data->result_array();
	}

	public function get_list_tindakan_vk_pasien_by_no_ipd_new($no_ipd){
		$data=$this->db->query("SELECT pelayanan_iri.id_tindakan, jenis_tindakan.nmtindakan, SUM(pelayanan_iri.vtot) as vtot, pelayanan_iri.tarifalkes, pelayanan_iri.kelas, pelayanan_iri.tumuminap, sum(pelayanan_iri.qtyyanri) as qtyyanri, (select nm_dokter from data_dokter where id_dokter=pelayanan_iri.idoprtr) as nm_dokter, (select nm_dokter from data_dokter where id_dokter=pelayanan_iri.idoprtr) as nmdokter  
			FROM pelayanan_iri, data_dokter, jenis_tindakan, data_pasien
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec        
        and jenis_tindakan.nmtindakan not like '%oksigen%'
        and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%ICU%')
        and pelayanan_iri.idrg=(SELECT idrg from ruang where lokasi LIKE '%Bersalin%')
        group by pelayanan_iri.id_tindakan, pelayanan_iri.idoprtr, pelayanan_iri.kelas
		order by data_dokter.nm_dokter asc
		");
		return $data->result_array();
	}

	//icu
	public function get_list_tindakan_icu_pasien_by_no_ipd_new($no_ipd){
		$data=$this->db->query("SELECT pelayanan_iri.id_tindakan, jenis_tindakan.nmtindakan, SUM(pelayanan_iri.vtot) as vtot, pelayanan_iri.tarifalkes, pelayanan_iri.kelas, pelayanan_iri.tumuminap, sum(pelayanan_iri.qtyyanri) as qtyyanri, (select nm_dokter from data_dokter where id_dokter=pelayanan_iri.idoprtr) as nm_dokter, (select nm_dokter from data_dokter where id_dokter=pelayanan_iri.idoprtr) as nmdokter  
			FROM pelayanan_iri, data_dokter, jenis_tindakan, data_pasien
		where pelayanan_iri.idoprtr=data_dokter.id_dokter 
        and pelayanan_iri.no_ipd='$no_ipd'
        and pelayanan_iri.id_tindakan=jenis_tindakan.idtindakan
        and pelayanan_iri.nomederec=data_pasien.no_medrec        
        and jenis_tindakan.nmtindakan not like '%oksigen%'
        and pelayanan_iri.idrg=(SELECT idrg from ruang where lokasi LIKE '%ICU%')
        and pelayanan_iri.idrg!=(SELECT idrg from ruang where lokasi LIKE '%Bersalin%')
        group by pelayanan_iri.id_tindakan, pelayanan_iri.idoprtr, pelayanan_iri.kelas
		order by data_dokter.nm_dokter asc
		");
		return $data->result_array();
	}


	public function get_paket_tindakan($no_ipd){
		$data=$this->db->query("
			SELECT * 
			FROM pelayanan_iri
			WHERE no_ipd = '$no_ipd' AND paket = 1

			");
		return $data->result_array();
	}
	public function getdata_perusahaan($no_register){
			return $this->db->query("SELECT A.id_kontraktor, B.nmkontraktor FROM pasien_iri A, kontraktor B  where no_ipd='$no_register' and A.id_kontraktor=B.id_kontraktor");
	}
	public function get_pasien_by_no_ipd($no_ipd){
		$data=$this->db->query("
			select a.*, a.jasa_perawat as jasaperawat, b.*, c.vtot as vtot_ruang, c.*,d.*,e.*, f.nm_diagnosa as nm_diagmasuk,
    		(SELECT nmruang from ruang where idrg=d.idrg) as nmruang, (SELECT nmkontraktor from kontraktor where id_kontraktor=a.id_kontraktor) as nmkontraktor			
			from pasien_iri as a inner join data_pasien as b on a.no_cm = b.no_medrec
			left join ruang_iri as c on a.no_ipd = c.no_ipd
			left join ruang as d on c.idrg = d.idrg
			left join icd1 as e on a.diagnosa1 = e.id_icd
			left join icd1 as f on a.diagmasuk = f.id_icd
			where a.no_ipd = '$no_ipd' 
			");
		return $data->result_array();
	}

	public function get_old_pasien($no_register){
		$data=$this->db->query("select * from daftar_ulang_irj where no_register='$no_register'");
		return $data->result_array();
	}

	public function get_ruang_by_no_ipd($no_ipd){
		$data=$this->db->query("
			select * 
			from ruang_iri, ruang
			where ruang_iri.no_ipd = '$no_ipd' 
			and ruang_iri.idrg=ruang.idrg
			order by ruang_iri.idrgiri desc
			");
		return $data->result_array();
	}

	public function insert_tindakan_temp($data){
		$this->db->insert('pelayanan_iri_temp', $data);
		// if(!$this->db->insert('pelayanan_iri_temp', $data)){
		// 	print_r($this->db->error());
		// 	exit; 
		// }else{
		// 	$this->db->insert_id();
		// 	//$data['status']='0';
		// 	return '0';
		// }
	}

	public function insert_diagnosa($data){
		$this->db->insert('diagnosa_iri', $data);
	}

	public function hapus_diagnosa_by_id($id){
		$data=$this->db->query("
			delete 
			from diagnosa_iri
			where id_diagnosa_pasien = '$id' ");
	}

	public function get_diagnosa_by_id($id){
		$data=$this->db->query("
			select * 
			from icd1
			where id_icd = '$id' ");
		return $data->result_array();
	}
}
?>
