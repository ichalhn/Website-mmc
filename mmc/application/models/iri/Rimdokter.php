<?php
class Rimdokter extends CI_Model {

	public function select_all_data_dokter(){
		$data=$this->db->query("select *
			from data_dokter 
			where nm_dokter <> ''
			order by nm_dokter asc
			");
		return $data->result_array();
	}


	public function select_all_data_dokter_tambah($noreg){
		$data=$this->db->query("
			select *
			from data_dokter 
			where nm_dokter <> '' and id_dokter!=(select id_dokter from pasien_iri where no_ipd='$noreg')
			order by nm_dokter asc
			");
		return $data->result_array();
	}

	public function select_all_data_dokter_pasien($noreg){
		$data=$this->db->query("Select 0 as id_drtambahan, id_dokter, no_ipd, 'DPJP' as ket, 
(select nm_dokter from data_dokter where id_dokter=pasien_iri.id_dokter) as nm_dokter
from pasien_iri
where no_ipd='$noreg'
UNION ALL
select *,(select nm_dokter from data_dokter where id_dokter=drtambahan_iri.id_dokter) as nm_dokter
from drtambahan_iri 
where no_register='$noreg'
			");
		return $data->result_array();
	}

	public function insert_dokter_bersama($data){
		$this->db->insert('drtambahan_iri', $data);
		return $this->db->insert_id();
	}

	public function hapus_drbersama($id){
		$this->db->query("DELETE FROM drtambahan_iri WHERE id_drtambahan='$id'");
		return true;
	}
}
?>
