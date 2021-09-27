<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmcara_bayar extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master dokter
		function get_all_carabayar(){
			return $this->db->query("SELECT * FROM cara_bayar");
		}
		
		function get_data_carabayar($cara_bayar){
			return $this->db->query("SELECT cara_bayar, klsrawatjalan, kode FROM cara_bayar where cara_bayar='$cara_bayar'");
		}

		
		function delete_carabayar($cara_bayar){
			return $this->db->query("DELETE FROM cara_bayar WHERE cara_bayar='$cara_bayar'");
		}

		function insert_carabayar($data){
			$this->db->insert('cara_bayar', $data);
			return true;
		}


		function edit_carabayar($cara_bayar, $data){
			$this->db->where('cara_bayar', $cara_bayar);
			$this->db->update('cara_bayar', $data); 
			return true;
		}
	}
?>
