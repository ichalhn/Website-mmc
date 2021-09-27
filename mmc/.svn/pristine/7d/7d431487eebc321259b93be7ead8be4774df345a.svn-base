<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmdiagnosa extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master diagnosa
		function get_all_diagnosa(){
			return $this->db->query("SELECT * FROM icd1 ORDER BY id_icd");
		}

		function get_data_diagnosa($id){
			return $this->db->query("SELECT * FROM icd1 WHERE id='$id'");
		}

		function insert_diagnosa($data){
			$this->db->insert('icd1', $data);
			return true;
		}

		function edit_diagnosa($id, $data){
			$this->db->where('id', $id);
			$this->db->update('icd1', $data); 
			return true;
		}
	}
?>