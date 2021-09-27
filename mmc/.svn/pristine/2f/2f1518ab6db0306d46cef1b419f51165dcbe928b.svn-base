<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmgudang extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master gudang
		function get_all_gudang(){
			return $this->db->query("SELECT * FROM master_gudang ORDER BY id_gudang");
		}

		function get_data_gudang($id_gudang){
			return $this->db->query("SELECT * FROM master_gudang WHERE id_gudang='$id_gudang'");
		}

		function insert_gudang($data){
			$this->db->insert('master_gudang', $data);
			return true;
		}

		function delete_gudang($id_gudang){
			return $this->db->query("DELETE FROM master_gudang WHERE id_gudang='$id_gudang'");
		}
	}
?>