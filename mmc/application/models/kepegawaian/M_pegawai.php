<?php 
class M_pegawai extends CI_Model{
    
    public function __construct(){
        parent::__construct();
    }
	
	function get_data_all(){
		return $this->db->query("select * from pegawai")->result();
	}
	
	public function checkisexist($id){
		$query=$this->db->query("select count(nip) as exist, nm_pegawai as nama 
			from pegawai where nip = '".$id."'"); 
		if($query->num_rows()==1)
		{
			return $query->row();
		}
	}
	
	function get_info($id){
		$query = $this->db->query("	SELECT p.nip, p.nm_pegawai, p.gelar_dpn, p.gelar_bkl, p.aktif, p.fullpartime, p.sk_masuk, p.tgl_masuk, p.dept, p.tmt, p.duk,
			p.id_bagian, b.nm_bagian, p.id_subag, sb.nm_subag,
			p.id_jabatan, jab.nm_jabatan, p.tmt_jabatan, p.id_golongan, g.nm_golongan, p.tmt_golongan,
			p.id_qualifikasi, q.nm_qualifikasi, p.id_sub_qua, sq.nm_sub_qua, p.id_jenis, j.jenis,
			p.gol_puncak, p.penggaji_2, p.flag_ahli, p.tpt_lahir, p.tgl_lahir, p.sex, p.agama, p.no_hp, 
			p.status, p.alamat, p.kota, p.thncutibesar, p.no_karpeg, p.no_taspen, p.prop, p.foto
		FROM pegawai p
		LEFT JOIN	bagian b ON p.id_bagian = b.id_bagian
		LEFT JOIN	sub_bagian sb ON p.id_subag = sb.id_subag
		LEFT JOIN	qualifikasi_pend q ON p.id_qualifikasi = q.id_qualifikasi
		LEFT JOIN	sub_qualifikasi sq ON p.id_sub_qua = sq.id_sub_qua
		LEFT JOIN	jenis_pegawai j ON p.id_jenis = j.id_jenis
		LEFT JOIN	golongan g ON p.id_golongan = g.id_golongan
		LEFT JOIN	jabatan jab ON p.id_jabatan = jab.id_jabatan
		WHERE
			p.nip =".$id);
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//create object with empty properties.
			//$fields = $this->db->list_fields('asset');
			$obj = new stdClass;
			
			foreach ($query->list_fields() as $field)
			{
				$obj->$field='';
			}
			
			return $obj;
		}
	}
	
	function insert($data,$foto){
		if ($data["vduk"]==1) $vduk = 'Y';
		else $vduk = 'N';
		return $this->db->query("insert into pegawai(
									nm_pegawai,	gelar_dpn, gelar_bkl, duk,
									nip, aktif,	fullpartime,
									sk_masuk, tgl_masuk,
									id_bagian, tmt,
									id_jabatan, tmt_jabatan,
									id_golongan, tmt_golongan, gol_puncak,
									id_qualifikasi, id_sub_qua, flag_ahli,
									id_jenis, penggaji_2, tpt_lahir, tgl_lahir, 
									sex, status, agama, alamat, prop, kota,
									foto
								) values(
									'".$data["vnm_pegawai"]."','".$data["vgelar_dpn"]."','".$data["vgelar_bkl"]."','".$vduk."',
									'".$data["vnip"]."','".$data["vaktif"]."','".$data["vfulltime"]."',
									'".$data["vsk_masuk"]."','".$data["vtgl_masuk"]."',
									'".$data["vid_bagian"]."','".$data["vtmt"]."',
									'".$data["vid_jabatan"]."','".$data["vtmt_jabatan"]."',
									'".$data["vid_golongan"]."','".$data["vtmt_golongan"]."','".$data["vgol_puncak"]."',
									'".$data["vid_qualifikasi"]."','".$data["vid_sub_qua"]."','".$data["vahli"]."',
									'".$data["vid_jenis"]."','".$data["vpenggaji_2"]."',
									'".$data["vtpt_lahir"]."','".$data["vtgl_lahir"]."','".$data["vsex"]."','".$data["vstatus"]."','".$data["vagama"]."','".$data["valamat"]."','".$data["vprop"]."','".$data["vkota"]."',
									'".$foto."'
								)");
	}
	public function update($data){
		if ($data["duk"]==1) $vduk = 'Y';
		else $vduk = 'N';
		return $this->db->query("update pegawai set								
				nm_pegawai = '".$data["nm_pegawai"]."',	gelar_dpn = '".$data["gelar_dpn"]."', gelar_bkl = '".$data["gelar_bkl"]."', duk = '".$vduk."', aktif = '".$data["aktif"]."',	fullpartime = '".$data["fulltime"]."',
				sk_masuk = '".$data["sk_masuk"]."', tgl_masuk = '".$data["tgl_masuk"]."',
				id_bagian = '".$data["id_bagian"]."', tmt = '".$data["tmt"]."',
				id_jabatan = '".$data["id_jabatan"]."', tmt_jabatan = '".$data["tmt_jabatan"]."',
				id_golongan = '".$data["id_golongan"]."', tmt_golongan = '".$data["tmt_golongan"]."', gol_puncak = '".$data["gol_puncak"]."',
				id_qualifikasi = '".$data["id_qualifikasi"]."', id_sub_qua = '".$data["id_sub_qua"]."', flag_ahli = '".$data["ahli"]."',
				id_jenis = '".$data["id_jenis"]."', penggaji_2 = '".$data["penggaji_2"]."'
		where nip = '".$data["nip"]."'"	
		);
	}
	public function update_bio($data){
		return $this->db->query("update pegawai set								
				tpt_lahir = '".$data["tpt_lahir"]."',	tgl_lahir = '".$data["tgl_lahir"]."', sex = '".$data["sex"]."', status = '".$data["status"]."',	agama = '".$data["agama"]."',
				alamat = '".$data["alamat"]."', prop = '".$data["prop"]."',
				kota = '".$data["kota"]."', thncutibesar = '".$data["thncutibesar"]."',
				no_karpeg = '".$data["no_karpeg"]."', no_taspen = '".$data["no_taspen"]."',
				no_hp = '".$data["no_hp"]."'
		where nip = '".$data["nip2"]."'"	
		);
	}
	
	public function update_photo($nip, $foto){
		return $this->db->query("update pegawai set	foto = '".$foto."' where nip = '".$nip."'");
	}
	/*== JENIS PEGAWAI =========================================================================*/
	
	function get_select_jenis(){
		$this->db->from('jenis_pegawai');
		$this->db->order_by("jenis", "asc");
		$query=$this->db->get();
		//return $query->result_array();	
		$data[0] = "-Pilih Jenis-";
		foreach($query->result() as $row)
		{
			$data[$row->id_jenis] = $row->jenis;
		}
		return $data;	
	}
	/*
	function get_select_penggaji(){
		$this->db->from('jenis_pegawai');
		$this->db->order_by("jenis", "asc");
		$query=$this->db->get();
		//return $query->result_array();	
		$data[0] = "-Pilih Jenis-";
		foreach($query->result() as $row)
		{
			$data[$row->id_jenis] = $row->jenis;
		}
		return $data;	
	}
	*/
	/*== KELUARGA =============================================================================*/
	function get_data_pasangan($id){
		$query=$this->db->query("select *
                from keluarga
                where nip = '".$id."' and (stat_kel = 'SUAMI' OR stat_kel='ISTRI')");		
		return $query->result();
	}
	function get_data_anak($id){
		$query=$this->db->query("select *
                from keluarga
                where nip = '".$id."' and stat_kel = 'ANAK'");		
		return $query->result();
	}
	
	function insert_kel($data){
		return $this->db->query("insert into keluarga(
									nip, nm_keluarga, stat_kel, tgl_lhr, sex_kel, tgl_nikah, pekerjaan, dpt_tunjangan
								) values(
									'".$data["nip"]."','".$data["nm_keluarga"]."','".$data["stat_kel"]."',
									'".$data["tgl_lhr"]."','".$data["sex_kel"]."','".$data["tgl_nikah"]."',
									'".$data["pekerjaan"]."','".$data["dpt_tunjangan"]."'
								)");
	}
	
	
	public function delete_kel($nip, $nm){
		return $this->db->query("delete from keluarga where nip = '".$nip."' and nm_keluarga = '".$nm."'");
	}
	/*== PENDIDIKAN =============================================================================*/
	function get_data_pendidikan($id){
		$query=$this->db->query("select *
                from pendidikan_peg
                where nip = '".$id."'");		
		return $query->result();
	}
	function insert_pend($data){
		return $this->db->query("insert into pendidikan_peg(
									nip, nm_pendidikan, id_qualifikasi, thn_ijazah, stat_sekolah, tpt_pend, tk_ijazah
								) values(
									'".$data["nip_pend"]."','".$data["nm_pendidikan"]."','".$data["id_qua_pend"]."',
									'".$data["thn_ijazah"]."','".$data["stat_sekolah"]."','".$data["tpt_pend"]."',
									'".$data["nm_pendidikan"]."'
								)");
	}
	function get_select_tingkat(){	
		return $this->db->query("SELECT DISTINCT nm_pendidikan as nama from pendidikan_peg order by nama asc")->result();
	}
	
	public function delete_pend($nip, $nm){
		return $this->db->query("delete from pendidikan_peg where nip = '".$nip."' and nm_pendidikan = '".$nm."'");
	}
	/*== KGB =============================================================================*/
	function get_data_kgb($id){
		$query=$this->db->query("SELECT k.nip, k.no_suratkgb, k.tgl_berlaku0, k.tgl_berlaku, g.nm_golongan, g.pangkat, k.gaji_pokok0, k.gaji_pokok
			FROM kgb k
			LEFT JOIN	golongan g ON k.id_golongan = g.id_golongan
			WHERE k.nip = '".$id."'
			ORDER BY k.tgl_berlaku0 ASC");		
		return $query->result();
	}
	
	function insert_kgb($data){
		return $this->db->query("insert into kgb(
					nip, no_suratkgb, tgl_berlaku0, tgl_berlaku, id_golongan0, id_golongan, gaji_pokok0, gaji_pokok
				) values(
					'".$data["nip_kgb"]."','".$data["no_suratkgb"]."','".$data["tgl_berlaku0"]."',
					'".$data["tgl_berlaku"]."','".$data["id_gol_kgb0"]."','".$data["id_gol_kgb"]."',
					'".$data["gaji_pokok0"]."','".$data["gaji_pokok"]."'
				)");
	}
	public function delete_kgb($nip, $nm){
		return $this->db->query("delete from kgb where nip = '".$nip."' and no_suratkgb = '".$nm."'");
	}
	/*== JABATAN =============================================================================*/
	function get_data_history_jabatan($id){
		$query=$this->db->query("SELECT tahun, instansi, nm_jabatan FROM jabatan_pegawai
			WHERE nip = '".$id."' 
			ORDER BY tahun DESC");		
		return $query->result();
	}
	function get_data_history_mutasi($id){
		$query=$this->db->query("SELECT tahun, nm_bagian FROM unitkerja_pegawai
			WHERE nip = '".$id."' 
			ORDER BY tahun DESC");		
		return $query->result();
	}
	
	/*== DUK =============================================================================*/
	function get_data_duk(){
		$query=$this->db->query("SELECT g.id_golongan, p.nip, p.nm_pegawai, g.nm_golongan, g.pangkat, b.nm_bagian, sb.nm_subag
			FROM pegawai p
			LEFT JOIN	golongan g ON p.id_golongan = g.id_golongan
			LEFT JOIN	bagian b ON p.id_bagian = b.id_bagian
			LEFT JOIN	sub_bagian sb ON p.id_subag = sb.id_subag
			WHERE p.duk = 'Y'
			ORDER BY g.id_golongan DESC");		
		return $query->result();
	}
	
	/*== UNIT =============================================================================*/
	function get_bagian($id){
		$query=$this->db->query("SELECT DISTINCT nm_bagian FROM bagian WHERE id_bagian = '$id'");		
		return $query->row()->nm_bagian;
	}
	
}