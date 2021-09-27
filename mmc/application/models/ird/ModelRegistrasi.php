<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class ModelRegistrasi extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		function get_cara_berkunjung(){
			$this->db->select('*');
			$this->db->from('cara_berkunjung');
			$query = $this->db->get();
			return $query;
		}
		function get_cara_bayar(){
			$this->db->select('*');
			$this->db->from('cara_bayar');
			$query = $this->db->get();
			return $query;
		}
		// SELECT max(no_cm) FROM data_pasien;
		function get_last_cmpatria(){
			return $this->db->query("SELECT max(no_cm) as no_cm FROM data_pasien");
		}
		function get_data_kecelakaan(){
			$this->db->select('*');
			$this->db->from('kecelakaan_ird');
			$query = $this->db->get();
			return $query;
		}
		function get_data_diagnosa(){
			$this->db->select('*');
			$this->db->from('icd1');
			$query = $this->db->get();
			return $query;
		}
		
		function get_kelas(){
			$this->db->select('*');
			$this->db->from('kelas');
			$query = $this->db->get();
			return $query;
		}
		///////////////////////////////////////////////////////////////////////////////////
		
		function get_data_dokter_IRD(){
			$this->db->select('*');
			$this->db->from('data_dokter');
			$this->db->where('ket', 'Dokter Jaga'); 
			$query = $this->db->get();
			return $query;
		}
		function get_new_medrec(){
			return $this->db->query("select max(no_medrec) as counter from data_pasien");
		}
		function insert_pasien_ird($data){
			//$this->db->insert('data_pasien', $data);
			//$this->db->insert_id();
			if(!$this->db->insert('data_pasien', $data)){
				return $this->db->error(); 
			}else{
				$this->db->insert_id();
				//$data['status']='0';
				return '0';
			}
			
		}
		function update_pasien_ird($data,$no_medrec){
			$this->db->where('no_medrec', $no_medrec);
			$this->db->update('data_pasien', $data);
			return true;
		}
		function update_daftar_ulang($data,$no_register){
			$this->db->where('no_register', $no_register);
			$this->db->update('irddaftar_ulang', $data);
			return true;
		}
		/////////////////////////////////////////////////
		function get_daftar_pasien(){
			return $this->db->query("SELECT *, A.nama
FROM irddaftar_ulang du, data_pasien A
where du.no_medrec=A.no_medrec 
and left(du.tgl_kunjungan,10) <= curdate()
and left(du.tgl_kunjungan,10) >= curdate()- interval 3 Day
and du.cara_bayar='BPJS'
and du.status=1
order by du.tgl_kunjungan  asc");
		}
		function get_daftar_pasien_belum_pulang(){
			return $this->db->query("SELECT *, A.nama
FROM irddaftar_ulang du, data_pasien A
where du.no_medrec=A.no_medrec 
and left(du.tgl_kunjungan,10) <= curdate()
and left(du.tgl_kunjungan,10) >= curdate()- interval 6 Day
and du.tgl_pulang is null
order by du.tgl_kunjungan  asc");
		}



		function get_detail_daful($no_register){
			return $this->db->query("SELECT A.*, B.nama, B.tgl_daftar, B.no_kartu, (SELECT nm_ppk
	FROM data_ppk  AS pk
	WHERE pk.kd_ppk=A.asal_rujukan) AS nm_ppk, 
	(SELECT nm_dokter
	FROM data_dokter  AS dd
	WHERE dd.id_dokter=A.id_dokter ) AS nm_dokter,
	(SELECT nm_kecelakaan
	FROM kecelakaan_ird  AS ki
	WHERE ki.id=A.kecelakaan) AS nm_kecelakaan,
	(SELECT nm_kecelakaan
	FROM kecelakaan_ird  AS ki
	WHERE ki.id=A.kecelakaan) AS nm_kecelakaan
FROM irddaftar_ulang A , data_pasien B 
where A.no_register='$no_register'
and A.no_medrec=B.no_medrec");
		}
		
		function get_data_pasien_by($no_cm){
			return $this->db->query("SELECT * FROM data_pasien where no_cm='$no_cm'");
		}

		function get_data_pasien_by_cmbaru($no_cm){
			return $this->db->query("SELECT * FROM data_pasien where no_medrec='$no_cm'");
		}	

		function select_pasien_ird_by_no_register_with_diag_utama($no_register){
		$data=$this->db->query("
			select *
			from irddaftar_ulang as a inner join data_pasien as b on a.no_medrec = b.no_medrec
			left join data_dokter as c on c.id_dokter = a.id_dokter
			where a.no_register='$no_register' 
			");
		return $data->result_array();
		}
		function get_data_pasien_by_nama($nama){
			$this->db->select('*');
			$this->db->from('data_pasien');
			$this->db->like('nama', $nama);
			$this->db->order_by("nama", "asc");  
			$query = $this->db->get();
			return $query;
		}
		function get_data_pasien_by_alamat($alamat){
			$this->db->select('*');
			$this->db->from('data_pasien');
			$this->db->like('alamat', $alamat);
			$this->db->order_by("alamat", "asc");  
			$query = $this->db->get();
			return $query;
		}	
		function get_data_pasien_by_no_kartu($no_kartu,$no_cm){
			$this->db->select('*');
			$this->db->from('data_pasien');
			$this->db->where('no_medrec', $no_cm);
			$this->db->where('no_kartu', $no_kartu);
			$query = $this->db->get();
			return $query;
		}
		function get_data_pasien_by_no_cm_lama($medrec_patria,$no_cm_baru){
			$this->db->select('*');
			$this->db->from('data_pasien');
			$this->db->where('no_medrec', $no_cm_baru);
			$this->db->where('no_cm', $medrec_patria);
			$query = $this->db->get();
			return $query;
		}
		function get_data_pasien_by_no_identitas($no_identitas,$no_cm){
			return $this->db->query("SELECT * FROM data_pasien where no_identitas='$no_identitas' and no_medrec='$no_cm'");
		}
		function get_data_tipe($no_register){
			return $this->db->query("SELECT date_format(tgl_daftar,'%d-%m-%Y') as hari, (case when (left(tgl_daftar,10) = left(now(),10)) 
 THEN
      'BARU' 
 ELSE
      'LAMA' 
 END) as tipe,  (case when (left(tgl_daftar,10) = left(now(),10)) 
 THEN
      (Select nilai_karcis from karcis_sec where seri_karcis='BARU')
 ELSE
      (Select nilai_karcis from karcis_sec where seri_karcis='LAMA') 
 END) as biaya FROM data_pasien, karcis_sec
where data_pasien.no_medrec='$no_register'
group by data_pasien.no_medrec;");
		}
		function check_register($no_cm){
			//return $this->db->where('no_medrec', $no_cm)->where('left(tgl_kunjungan,10)', 'left(now(),10)')->count_all_results('irddaftar_ulang');
			return $this->db->query("SELECT  COUNT(no_medrec) as record FROM irddaftar_ulang where no_medrec='$no_cm' AND left(tgl_kunjungan,10) = left(now(),10) and status='0'");
		}
		////////////////////////////////////////////////////////////////
		function hapus_pasien($no_cm) {
			$this->db->where('no_medrec', $no_cm);
       			$this->db->delete('data_pasien');			
			return true;
		}
		////////////////////////////////////////////////////////////////
		function get_umur_all(){
			return $this->db->query("select datediff(now(),tgl_lahir) as umurday from data_pasien");
		}
		function get_umur($no_medrec){
			return $this->db->query("select datediff(now(),tgl_lahir) as umurday from data_pasien where no_medrec='$no_medrec'");
		}
		function get_daful_kontraktor($no_medrec){
			return $this->db->query("SELECT B.id_kontraktor, A.nmkontraktor FROM kontraktor A, irddaftar_ulang B 
where A.id_kontraktor = B.id_kontraktor
and B.no_medrec='$no_medrec'");
		}
		///////////////////////////////////////////////////////////////////////////////////
		public function get_noreg_pasien($no_medrec){
			return $this->db->query("select max(no_register) as noreg from irddaftar_ulang where no_medrec='$no_medrec'");
		}
		function get_new_register(){
			return $this->db->query("select max(right(no_register,6)) as counter, mid(now(),3,2) as year from irddaftar_ulang where mid(no_register,3,2) = (select mid(now(),3,2))");
		}
		function insert_daftar_ulang($data,$no_medrec){
			//print_r($data['no_medrec']);
			$no_register=$this->db->query("SELECT IFNULL(CONCAT('RD16',LPAD(max(right(no_register,6))+1,6,0)),'RD16000001') as no_register from irddaftar_ulang");	
			$query1 = "(SELECT IFNULL(CONCAT('RD".date("y")."',LPAD(max(right(no_register,6))+1,6,0)),'RD".date("y")."000001')
from (SELECT * FROM irddaftar_ulang) as daful)";
			//echo $query1;
			$no_reg=$no_register->row()->no_register;
			$this->db->set('no_register',$query1 , FALSE);
			$this->db->insert('irddaftar_ulang', $data);
			
				$no_register=$this->db->query("SELECT CONCAT('RD16',LPAD(max(right(irddaftar_ulang.no_register,6)),6,0)) as no_register
	from irddaftar_ulang, data_pasien 
	where data_pasien.no_medrec='$no_medrec'
	and irddaftar_ulang.no_medrec = data_pasien.no_medrec
	and left(irddaftar_ulang.tgl_kunjungan,10)=left(now(),10)");
			$no_reg=$no_register->row()->no_register;
			//echo '<script type="text/javascript">window.open("'.site_url("ird/IrDRegistrasi/cetak_karcis/$no_reg").'", "_blank");window.focus()</script>';
			
			return $no_register->row();
			
		}
		//SELECT count(no_medrec) from daftar_ulang_irj where no_medrec='0000000740'
		function cek_kunj_ird($no_medrec){
			return $this->db->query("SELECT count(no_medrec) as cek 
from irddaftar_ulang where no_medrec='$no_medrec'");
		}
		function getdata_identitas($no_register){
			return $this->db->query("select du.cara_bayar, du.nama_penjamin, du.hubungan, dp.*
										from irddaftar_ulang AS du, data_pasien AS dp
										where du.no_medrec=dp.no_medrec
										and du.no_register='$no_register'");
		}
		////////////////////////////
		function update_pesertaBpjs($no_medrec,$data){
			$this->db->where('no_medrec', $no_medrec);
			$this->db->update('data_pasien', $data);
			return true;
		}
		function update_sep($no_register,$data){
			$this->db->where('no_register', $no_register);
			$this->db->update('irddaftar_ulang', $data);
			return true;
		}
		///////////////////////////////////////////////////////////////////////////////////
		function get_poli(){
			return $this->db->query("SELECT poliklinik.id_poli,poliklinik.nm_poli,(select count(id_poli) from daftar_ulang where poliklinik.id_poli=daftar_ulang.id_poli and daftar_ulang.status='0' and left(daftar_ulang.tgl_kunjungan,10) = left(now(),10)) as counter FROM poliklinik left join daftar_ulang on poliklinik.id_poli=daftar_ulang.id_poli group by poliklinik.id_poli;");
		}
		///////////////////////////////////////////////////////////////////////////////////
		function get_entri($noreg) {
			$this->db->from('irddaftar_ulang');			
			$this->db->select('*');
			$this->db->where('irddaftar_ulang.no_register', $noreg);
			$query = $this->db->get();
			return $query->row();
		}
		public function get_ppk($kd_ppk) {
			$this->db->where('kd_ppk', $kd_ppk);
			$query = $this->db->get('data_ppk');
			return $query->row();
		}
		public function get_diagnosa($id_icd) {
			$this->db->where('id_icd', $id_icd);
			$query = $this->db->get('icd1');
			return $query->row();
		}
	}
?>
