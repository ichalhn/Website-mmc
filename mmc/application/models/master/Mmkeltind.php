<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmkeltind extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master poli
		function get_all_keltind(){
			return $this->db->query("SELECT * FROM kel_tind ORDER BY idkel_tind");
		}

		function get_data_keltind($idkel_tind){
			return $this->db->query("SELECT * FROM kel_tind WHERE idkel_tind='$idkel_tind'");
		}		

		function delete_keltind($idkel_tind){
			return $this->db->query("DELETE FROM kel_tind WHERE idkel_tind='$idkel_tind'");
		}

		function insert_keltind($data){
			$this->db->insert('kel_tind', $data);
			return true;
		}

		function edit_keltind($idkel_tind, $data){
			$this->db->where('idkel_tind', $idkel_tind);
			$this->db->update('kel_tind', $data); 
			return true;
		}
	}
?>
