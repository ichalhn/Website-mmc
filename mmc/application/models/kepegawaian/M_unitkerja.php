<?php 
class M_unitkerja extends CI_Model{
    
    public function __construct(){
        parent::__construct();
    }
	
	function get_data_all(){
		return $this->db->query("select * from bagian")->result();
	}
	
	public function checkisexist($id){
		$query=$this->db->query("select count(id_bagian) as exist, nm_bagian as nama 
			from bagian where id_bagian = '".$id."'"); 
		if($query->num_rows()==1)
		{
			return $query->row();
		}
	}
	
	function get_info($id){
		$query = $this->db->query("	SELECT * from bagian where id_bagian =".$id);
		
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
		return $this->db->query("insert into bagian( id_bagian, nm_bagian) 
								values(	'".$data["id_bagian"]."','".$data["nm_bagian"]."')");
	}
	public function update($data){
		return $this->db->query("update bagian set nm_bagian = '".$data["vnm_bagian"]."'
								where id_bagian = '".$data["vid_bagian"]."'"	
		);
	}
	
	public function delete($id){
		return $this->db->query("delete from bagian where id_bagian = '".$id."'");
	}

}