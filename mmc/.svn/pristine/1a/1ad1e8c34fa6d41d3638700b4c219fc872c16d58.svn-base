<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmppk extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master dokter
		function get_all_ppk(){
			return $this->db->query("SELECT * FROM data_ppk");
		}
		
		function get_data_ppk($ppk){
			return $this->db->query("SELECT kd_ppk, nm_ppk, kabupaten, alamat_ppk, kdkc FROM data_ppk where kd_ppk='$ppk'");
		}

		function delete_ppk($ppk){
			return $this->db->query("DELETE FROM data_ppk WHERE kd_ppk='$ppk'");
		}

		function insert_ppk($data){
			$this->db->insert('data_ppk', $data);
			return true;
		}

		function edit_ppk($ppk, $data){
			$this->db->where('kd_ppk', $ppk);
			$this->db->update('data_ppk', $data); 
			return true;
		}
	}
?>
