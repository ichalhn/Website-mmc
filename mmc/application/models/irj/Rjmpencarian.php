<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Rjmpencarian extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////daftar_ulang
		function get_cara_berkunjung(){
			return $this->db->query("SELECT * FROM cara_berkunjung");
		}
		function get_ppk(){
			return $this->db->query("SELECT * FROM data_ppk ORDER BY nm_ppk");
		}
		function get_kelas(){
			return $this->db->query("SELECT * FROM kelas");
		}
		function get_kesatuan(){
			return $this->db->query("SELECT * FROM tni_kesatuan");
		}
		function get_pangkat(){
			return $this->db->query("SELECT * FROM tni_pangkat");
		}
		function get_hubungan(){
			return $this->db->query("SELECT * FROM tni_hubungan");
		}
		function get_angkatan(){
			return $this->db->query("SELECT * FROM tni_angkatan");
		}
		function get_poliklinik(){
			return $this->db->query("SELECT id_poli, nm_poli FROM poliklinik");
		}
		function get_cara_bayar(){
			return $this->db->query("SELECT * FROM cara_bayar");
		}
		function get_kontraktor(){
			return $this->db->query("SELECT * FROM kontraktor ORDER BY nmkontraktor");
		}
		function get_diagnosa(){
			return $this->db->query("SELECT id_icd, nm_diagnosa FROM icd1 ORDER BY id_icd");
		}
                
//                function get_proceddure(){
//			return $this->db->query("SELECT id_tind, nm_tind FROM icd9cm ORDER BY id_tind");
//		}
                
		function get_dokter(){
			return $this->db->query("SELECT id_dokter, nm_dokter FROM data_dokter where deleted='0' ORDER BY nm_dokter");
		}
		function get_data_kecelakaan(){
			$this->db->select('*');
			$this->db->from('kecelakaan_ird');
			$query = $this->db->get();
			return $query;
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////pencarian list antrian pasien per poli by
		function get_pasien_daftar_today($id_poli){
			return $this->db->query("SELECT *, data_dokter.nm_dokter, (SELECT count(*) from pelayanan_poli where no_register=daftar_ulang_irj.no_register and bayar='0') as unpaid
FROM daftar_ulang_irj, data_pasien, data_dokter 
where daftar_ulang_irj.id_poli='$id_poli' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec and daftar_ulang_irj.id_dokter = data_dokter.id_dokter  
and left(daftar_ulang_irj.tgl_kunjungan,10) = left(now(),10) and daftar_ulang_irj.status='0' order by daftar_ulang_irj.no_antrian
");
		}
		function get_list_rawat_jalan(){
			return $this->db->query("SELECT *, (SELECT count(*) from pelayanan_poli where no_register=daftar_ulang_irj.no_register and bayar='0') as unpaid
FROM daftar_ulang_irj, data_pasien 
where daftar_ulang_irj.no_medrec=data_pasien.no_medrec  
and left(daftar_ulang_irj.tgl_kunjungan,10) = left(now(),10) and daftar_ulang_irj.status='0' order by daftar_ulang_irj.no_antrian
");
		}

		function get_data_by_register($no_register){
			return $this->db->query("SELECT *, (SELECT count(*) from pelayanan_poli where no_register=daftar_ulang_irj.no_register and bayar='0') as unpaid
FROM daftar_ulang_irj, data_pasien 
where daftar_ulang_irj.no_register='$no_register' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec  
and left(daftar_ulang_irj.tgl_kunjungan,10) = left(now(),10) and daftar_ulang_irj.status='0' order by daftar_ulang_irj.no_antrian
");

//SELECT * FROM daftar_ulang_irj, data_pasien where daftar_ulang_irj.id_poli='$id_poli' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec  and left(daftar_ulang_irj.tgl_kunjungan,10) = left(now(),10) and daftar_ulang_irj.status='0'
		}
		function edit_cara_bayar($no_register, $data){
			$this->db->where('no_register', $no_register);
			$this->db->update('daftar_ulang_irj', $data); 
			return true;
		}
		function get_pasien_daftar_by_nocm($id_poli,$no_medrec){
			return $this->db->query("SELECT * FROM daftar_ulang_irj, data_pasien where daftar_ulang_irj.id_poli='$id_poli' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec  and data_pasien.no_medrec='$no_medrec' and daftar_ulang_irj.status='0'");
		}
		function get_pasien_daftar_by_noregister($id_poli,$no_register){
			return $this->db->query("SELECT * FROM daftar_ulang_irj, data_pasien where daftar_ulang_irj.id_poli='$id_poli' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec  and daftar_ulang_irj.no_register='$no_register' and daftar_ulang_irj.status='0'");
		}
		function get_pasien_daftar_by_date($id_poli,$date){
			return $this->db->query("SELECT *, (SELECT count(*) from pelayanan_poli where no_register=daftar_ulang_irj.no_register and bayar='1') as unpaid FROM daftar_ulang_irj, data_pasien where daftar_ulang_irj.id_poli='$id_poli' and daftar_ulang_irj.no_medrec=data_pasien.no_medrec  and left(daftar_ulang_irj.tgl_kunjungan,10) = '$date' and daftar_ulang_irj.status='0'");
		}
		function get_nrp(){
			return $this->db->query("select no_nrp, no_cm as no_medrec from data_pasien where no_nrp is not null");
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////alamat		
		function get_prop(){
			return $this->db->query("SELECT * FROM provinsi order by nama");
		}
		function get_kotakab($id_prop){
			return $this->db->query("SELECT * FROM kotakabupaten where id_prov='$id_prop' order by nama");
		}
		function get_kecamatan($id_kabupaten){
			return $this->db->query("SELECT * FROM kecamatan where id_kabupaten='$id_kabupaten' order by nama");
		}
		function get_kelurahan($id_kecamatan){
			return $this->db->query("SELECT * FROM kelurahandesa where id_kecamatan='$id_kecamatan' order by nama");
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////list_poli
		function get_poli($username){
			return $this->db->query("SELECT poliklinik.id_poli,poliklinik.nm_poli,
										(select count(id_poli) from daftar_ulang_irj 
										where poliklinik.id_poli=daftar_ulang_irj.id_poli and daftar_ulang_irj.status='0' and daftar_ulang_irj.batal = '0' 
										and left(daftar_ulang_irj.tgl_kunjungan,10) = left(now(),10)) as counter
									FROM poliklinik 
									LEFT JOIN dyn_poli_user ON dyn_poli_user.id_poli=poliklinik.id_poli
									where dyn_poli_user.userid='$username' 
									GROUP BY poliklinik.id_poli");
		}
		function get_nm_poli($id_poli){//judul poli -> header dalam list antrian
			return $this->db->query("SELECT nm_poli FROM poliklinik where id_poli='$id_poli'");
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////tarif_tindakan
		function get_tarif_tindakan($keyword,$kelas_pasien){//judul poli -> header dalam list antrian
			return $this->db->query("select * from jenis_tindakan, tarif_tindakan where jenis_tindakan.nmtindakan like '%$keyword%' and jenis_tindakan.idtindakan=tarif_tindakan.idtindakan and tarif_tindakan.kelas='$kelas_pasien' and jenis_tindakan.cito='B'");
		}
		
	}
?>
