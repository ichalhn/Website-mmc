<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmkelas extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master dokter
		function get_all_kelas(){
			return $this->db->query("SELECT * FROM kelas");
		}
		
		function get_data_kelas($kelas){
			return $this->db->query("SELECT kelas, urutan, persen_jasa FROM kelas where kelas='$kelas'");
		}

		
		function delete_kelas($kelas){
			return $this->db->query("DELETE FROM kelas WHERE kelas='$kelas'");
		}

		function insert_kelas($data){
			$this->db->insert('kelas', $data);
			return true;
		}


		function edit_kelas($kelas, $data){
			$this->db->where('kelas', $kelas);
			$this->db->update('kelas', $data); 
			return true;
		}
	}
?>
