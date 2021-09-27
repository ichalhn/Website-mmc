<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmrujukan extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master rujukan
		function get_all_rujukan(){
			return $this->db->query("SELECT * FROM data_ppk ORDER BY kd_ppk");
		}

		function get_data_rujukan($kd_ppk){
			return $this->db->query("SELECT * FROM data_ppk WHERE kd_ppk='$kd_ppk'");
		}

		function insert_rujukan($data){
			$this->db->insert('data_ppk', $data);
			return true;
		}

		function edit_rujukan($kd_ppk, $data){
			$this->db->where('kd_ppk', $kd_ppk);
			$this->db->update('data_ppk', $data); 
			return true;
		}

		function delete_rujukan($kd_ppk){
			return $this->db->query("DELETE FROM data_ppk WHERE kd_ppk='$kd_ppk'");
		}
	}
?>