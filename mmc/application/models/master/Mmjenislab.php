<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmjenislab extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function get_all_jenis_lab(){
			return $this->db->query("SELECT * FROM jenis_lab ORDER BY kode_jenis");
		}

		function insert_jenis_lab($data){
			$this->db->insert('jenis_lab', $data);
			return true;
		}

		function delete_jenis_lab($id){
			return $this->db->query("DELETE FROM jenis_lab WHERE id='$id'");
		}
	}
?>
