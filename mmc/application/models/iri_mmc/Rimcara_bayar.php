<?php
class Rimcara_bayar extends CI_Model {

	public function get_all_cara_bayar(){
		$data=$this->db->query("
			select * from cara_bayar order by no_urut asc");
		return $data->result_array();
	}
}
?>
