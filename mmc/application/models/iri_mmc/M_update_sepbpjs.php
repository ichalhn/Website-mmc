<?php
	class M_update_sepbpjs extends CI_Model{
		public function __construct(){
			parent::__construct();
		}


    function update_tgl_pulang($no_sep,$data_update){
     $this->db->where('no_sep', $no_sep);
     $this->db->update('daftar_ulang_irj', $data_update);
     return true;
    }

    function update_sep_bpjs($no_register,$data_update){
     $this->db->where('no_register', $no_register);
     $this->db->update('daftar_ulang_irj', $data_update);
     return true;
    }
    function update_sep_iri($no_register,$data_update){
     $this->db->where('no_ipd', $no_register);
     $this->db->update('pasien_iri', $data_update);
     return true;
    }
    function update_cetakan_iri($no_register,$data_update){
     $this->db->where('no_ipd', $no_register);
     $this->db->update('pasien_iri', $data_update);
     return true;
    }     
    function delete_sep($no_register,$no_sep,$data_update){
    $this->db->where('no_sep', $no_sep);
    $this->db->where('no_register', $no_register);
    $this->db->update('daftar_ulang_irj', $data_update);
    }

    function update_cetakan_sep($no_register,$data_update){
     $this->db->where('no_register', $no_register);
     $this->db->update('daftar_ulang_irj', $data_update);
     return true;
    }

    function update_sep_bpjs_2($noregister,$data_update){
     $this->db->where('NO_REGISTER', $noregister);
     $this->db->update('SEP_BPJS', $data_update);
     return true;
    }


  //   function get_catatan($nosep) {
  //     $this->db->FROM('SEP_BPJS');
  // //    $this->db->SELECT('NO_SEP, NO_REGISTER, CATATAN, TO_CHAR(TGL_SEP,'DD-MM-YYYY HH24:MI:SS') TGL_SEP, NO_MEDREC, NO_RUJUKAN, ID_POLI, POLI_RSMH');
  //     $this->db->SELECT('*');
	 //  $this->db->WHERE('SEP_BPJS.NO_SEP', $nosep);
  //     $query = $this->db->get();
  //     return $query->row();
  //   }
    function get_catatan($no_register) {
      $this->db->FROM('daftar_ulang_irj');
     $this->db->SELECT('catatan');
      // $this->db->SELECT('*');
    $this->db->WHERE('daftar_ulang_irj.no_register', $no_register);
      $query = $this->db->get();
      return $query->row();
    }

    function update_hapus_SEP($nosep){
      $data['hapusSEP']='1';
      $this->db->where('no_sep', $nosep);
      $this->db->update('daftar_ulang_irj', $data);
    }

    function get_nocm_pasien($no_medrec){
      return $this->db->query("select no_cm from data_pasien where no_medrec='$no_medrec'");
    }

     function get_catatan_2($no_register) {
      $this->db->FROM('daftar_ulang_irj');
      $this->db->SELECT('*');
      $this->db->WHERE('daftar_ulang_irj.no_register', $no_register);
      $query = $this->db->get();
      return $query->row();
    }
      function get_data_bpjs() {
      $this->db->FROM('data_bpjs');
      $this->db->SELECT('*');
      $query = $this->db->get();
      return $query->row();
    }
    function get_pasien_iri($no_ipd){
      $this->db->FROM('pasien_iri');
      $this->db->SELECT('*');
      $this->db->WHERE('pasien_iri.no_ipd', $no_ipd);
      $query = $this->db->get();
      return $query->row();      
    }    
     function get_poli_bpjs($id_poli) {
      $this->db->FROM('poliklinik');
      $this->db->SELECT('*');
      $this->db->WHERE('poliklinik.id_poli', $id_poli);
      $query = $this->db->get();
      return $query->row();
    }


}
?>
