<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmobatjenis extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master jenis
		function get_all_jenis(){
			return $this->db->query("SELECT * FROM obat_jenis ORDER BY id_jenis");
		}

		function get_data_jenis($id_jenis){
			return $this->db->query("SELECT * FROM obat_jenis WHERE id_jenis='$id_jenis'");
		}

		function insert_jenis($data){
			$this->db->insert('obat_jenis', $data);
			return true;
		}

		function edit_jenis($id_jenis, $data){
			$this->db->where('id_jenis', $id_jenis);
			$this->db->update('obat_jenis', $data); 
			return true;
		}

		function delete_jenis($id_jenis){
			return $this->db->query("DELETE FROM obat_jenis WHERE id_jenis='$id_jenis'");
		}
	}
?>