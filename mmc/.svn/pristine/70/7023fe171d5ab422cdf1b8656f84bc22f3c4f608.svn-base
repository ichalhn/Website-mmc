<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmpoli extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master poli
		function get_all_poli(){
			return $this->db->query("SELECT * FROM poliklinik ORDER BY id_poli");
		}

		function get_data_poli($id_poli){
			return $this->db->query("SELECT * FROM poliklinik WHERE id_poli='$id_poli'");
		}		

		function delete_poli($id_poli){
			return $this->db->query("DELETE FROM poliklinik WHERE id_poli='$id_poli'");
		}

		function insert_poli($data){
			$this->db->insert('poliklinik', $data);
			return true;
		}

		function edit_poli($id_poli, $data){
			$this->db->where('id_poli', $id_poli);
			$this->db->update('poliklinik', $data); 
			return true;
		}
	}
?>
