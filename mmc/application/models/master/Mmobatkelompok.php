<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmobatkelompok extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master satuan
		function get_all_satuan(){
			return $this->db->query("SELECT * FROM obat_kelompok ORDER BY id_satuan");
		}

		function get_data_satuan($id_satuan){
			return $this->db->query("SELECT * FROM obat_kelompok WHERE id_satuan='$id_satuan'");
		}

		function insert_satuan($data){
			$this->db->insert('obat_kelompok', $data);
			return true;
		}

		function edit_satuan($id_satuan, $data){
			$this->db->where('id_satuan', $id_satuan);
			$this->db->update('obat_kelompok', $data); 
			return true;
		}

		function delete_satuan($id_satuan){
			return $this->db->query("DELETE FROM obat_kelompok WHERE id_satuan='$id_satuan'");
		}
	}
?>