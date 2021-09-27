<?php 
class Masset extends CI_Model 
{
    
    public function __construct() 
    {
        parent::__construct();
    }
	
	function get_data_all(){
		return $this->db->query("select * from asset")->result();
	}
	public function checkisexist($asset_no, $serial_number){
		$query=$this->db->query("select count(id) as jml from asset 
			where asset_number = '".$asset_no."' and serial_number = '".$serial_number."'"); 
		$row = $query->row_array();
		return $row['jml'];
	}
	
	function get_info($id)
	{		
		$query = $this->db->query("SELECT *
			FROM asset
			JOIN t_sskel ON asset.jenis = t_sskel.kd_brg
			WHERE asset.id = ".$id);
			
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//create object with empty properties.
			$obj = new stdClass;
			
			foreach ($query->list_fields() as $field)
			{
				$obj->$field='';
			}
			
			return $obj;
		}
	}
	
	function get_info_mutasi($id)
	{
		$query = $this->db->query("SELECT *
			FROM asset
			JOIN asset_mutasi ON asset.id = asset_mutasi.asset_id
			JOIN t_sskel ON asset.jenis = t_sskel.kd_brg
			WHERE asset_mutasi.id = ".$id);
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//create object with empty properties.
			//$fields = $this->db->list_fields('asset');
			$obj = new stdClass;
			
			foreach ($query->list_fields() as $field)
			{
				$obj->$field='';
			}
			
			return $obj;
		}
	}
	
	function cek_mutasi($id)
	{
		$query = $this->db->query("	SELECT * FROM asset_mutasi WHERE asset_id = ".$id);
		return $query->num_rows();
	}
	
	public function insert($data){
		return $this->db->query("insert into asset(
									asset_number,
									description,
									jenis,
									merk,
									serial_number,
									kondisi,
									tgl_perolehan,
									xuser,
									xupdate
								) values(
									'".$data["asset_number"]."',
									'".$data["description"]."',
									'".$data["jenis"]."',
									'".$data["merk"]."',
									'".$data["serial_number"]."',
									'".$data["kondisi"]."',
									'".$data["tgl_perolehan"]."',
									'".$data["xuser"]."',
									NOW()
								)");
	}
	
	public function update($data){
		return $this->db->query("update asset set
									pengguna_nama = '".$data["pengguna_baru"]."',
									unit = '".$data["unit_baru"]."',
									lokasi = '".$data["lokasi_baru"]."',
									kondisi = '".$data["kondisi_baru"]."',
									unit_id = '".$data["id_unit_baru"]."',
									pengguna_id = '".$data["nip_baru"]."'
								where asset_number = '".$data["vasset_number"]."'"	
								);
	}
	
	
	public function mutasi($data){
		return $this->db->query("insert into asset_mutasi(
									asset_id,
									asset_number,
									tgl_mutasi,
									no_bast,
									pengguna_lama,
									pengguna_baru,
									unit_lama,
									unit_baru,
									lokasi_lama,
									lokasi_baru,
									kondisi_lama,
									kondisi_baru,
									nip_lama,
									nip_baru,
									id_unit_lama,
									id_unit_baru
								) values(
									'".$data["asset_id"]."',
									'".$data["vasset_number"]."',
									'".$data["tgl_mutasi"]."',
									'".$data["no_bast"]."',
									'".$data["pengguna_lama"]."',
									'".$data["pengguna_baru"]."',
									'".$data["unit_lama"]."',
									'".$data["unit_baru"]."',
									'".$data["lokasi_lama"]."',
									'".$data["lokasi_baru"]."',
									'".$data["kondisi_lama"]."',
									'".$data["kondisi_baru"]."',
									'".$data["nip_lama"]."',
									'".$data["nip_baru"]."',
									'".$data["id_unit_lama"]."',
									'".$data["id_unit_baru"]."'
								)");
	}
	
	public function delete($id){
		return $this->db->query("delete from asset where id = '".$id."'");
	}
	
	function get_all_jenis()
	{
		$this->db->from('asset_jenis');
		$this->db->order_by("asset_class", "asc");
		return $this->db->get();
	}
	
	function get_all_kelaset()
	{
		$this->db->from('t_skel');
		$this->db->order_by("kd_skelbrg", "asc");
		return $this->db->get();
	}
	
	function get_select_jenis($id){	
		return $this->db->query("SELECT kd_brg, ur_sskel FROM t_sskel where kd_brg like '".$id."%' ORDER BY kd_brg ASC")->result();
	}
	
	function get_select_skel(){	
		return $this->db->query("SELECT kd_skelbrg, ur_skel FROM t_skel ORDER BY kd_skelbrg ASC")->result();
	}
	
	public function get_mutasi_all(){
   		return $this->db->query("select m.id, m.tgl_mutasi, m.asset_number, a.description, a.jenis, m.pengguna_baru, m.pengguna_lama, m.nip_baru, m.unit_baru, m.id_unit_baru
				from asset a, asset_mutasi m
				where a.asset_number = m.asset_number ")->result();
	}
	
	public function get_mutasi_history($search, $id){
		if ($search == 'cari_unit'){
			return $this->db->query("select m.id, m.tgl_mutasi, m.asset_number, a.description, a.jenis, m.pengguna_baru, m.pengguna_lama, m.nip_baru, m.unit_baru, m.id_unit_baru
				from asset a, asset_mutasi m
				where a.asset_number = m.asset_number and m.id_unit_baru = '$id'")->result();
		}else{
			return $this->db->query("select m.id, m.tgl_mutasi, m.asset_number, a.description, a.jenis, m.pengguna_baru, m.pengguna_lama, m.nip_baru, m.unit_baru, m.id_unit_baru
				from asset a, asset_mutasi m
				where a.asset_number = m.asset_number and m.nip_baru = '$id'")->result();
		}
	}

}