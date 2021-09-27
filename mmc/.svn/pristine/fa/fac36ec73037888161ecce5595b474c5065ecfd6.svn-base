<?php 
class M_jabatan extends CI_Model{
    
    public function __construct(){
        parent::__construct();
    }
	
	function get_data_all(){
		return $this->db->query("select * from jabatan")->result();
	}
	
	public function checkisexist($id){
		$query=$this->db->query("select count(id_jabatan) as exist, nm_jabatan as nama 
			from jabatan where id_jabatan = '".$id."'"); 
		if($query->num_rows()==1)
		{
			return $query->row();
		}
	}
	
	function get_info($id){
		$query = $this->db->query("	SELECT * from jabatan where id_jabatan =".$id);
		
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
	
	function insert($data){
		return $this->db->query("insert into jabatan( id_jabatan, nm_jabatan) 
								values(	'".$data["id_jabatan"]."','".$data["nm_jabatan"]."')");
	}
	public function update($data){
		return $this->db->query("update jabatan set nm_jabatan = '".$data["vnm_jabatan"]."'
								where id_jabatan = '".$data["vid_jabatan"]."'"	
		);
	}
	
	public function delete($id){
		return $this->db->query("delete from jabatan where id_jabatan = '".$id."'");
	}

}