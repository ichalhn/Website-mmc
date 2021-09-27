<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmsupplier extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master supplier
		function get_all_supplier(){
			return $this->db->query("SELECT * FROM suppliers ORDER BY person_id");
		}

		function get_data_supplier($id_supplier){
			return $this->db->query("SELECT * FROM suppliers WHERE person_id='$id_supplier'");
		}

		function insert_supplier($data){
			$this->db->insert('suppliers', $data);
			return true;
		}

		function edit_supplier($id_supplier, $data){
			$this->db->where('person_id', $id_supplier);
			$this->db->update('suppliers', $data); 
			return true;
		}

		function delete_supplier($id_supplier){
			return $this->db->query("DELETE FROM suppliers WHERE person_ids='$id_supplier'");
		}

		function update_supplier($id_supplier){
			return $this->db->query("UPDATE suppliers SET deleted=1 WHERE person_id='$id_supplier'");
		}
	}
?>