<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmhasillab extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		//master dokter
		function get_all_tindakan_lab(){
			return $this->db->query("SELECT idtindakan, nmtindakan FROM jenis_tindakan WHERE idtindakan LIKE 'H%'");
		}

		function get_all_hasil_lab(){
			return $this->db->query("SELECT a.*, b.nmtindakan FROM jenis_hasil_lab AS a LEFT JOIN jenis_tindakan AS b ON a.id_tindakan=b.idtindakan ORDER BY a.id_tindakan, a.id_jenis_hasil_lab");
		}

		function insert_jenis_hasil_lab($data){
			$this->db->insert('jenis_hasil_lab', $data);
			return true;
		}

		function delete_jenis_hasil_lab($id_jenis_hasil_lab){
			return $this->db->query("DELETE FROM jenis_hasil_lab WHERE id_jenis_hasil_lab='$id_jenis_hasil_lab'");
		}
	}
?>
