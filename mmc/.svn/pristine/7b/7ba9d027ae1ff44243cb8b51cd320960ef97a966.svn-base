<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmkontraktor extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master kontraktor
		function get_all_kontraktor(){
			return $this->db->query("SELECT * FROM kontraktor ORDER BY id_kontraktor");
		}

		function get_data_kontraktor($id_kontraktor){
			return $this->db->query("SELECT * FROM kontraktor WHERE id_kontraktor='$id_kontraktor'");
		}

		function insert_kontraktor($data){
			$this->db->insert('kontraktor', $data);
			return true;
		}

		function edit_kontraktor($id_kontraktor, $data){
			$this->db->where('id_kontraktor', $id_kontraktor);
			$this->db->update('kontraktor', $data); 
			return true;
		}

		function delete_kontraktor($id_kontraktor){
			return $this->db->query("DELETE FROM kontraktor WHERE id_kontraktor='$id_kontraktor'");
		}
	}
?>