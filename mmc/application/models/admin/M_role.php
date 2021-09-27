<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_role extends CI_Model{
	function __construct(){
		parent::__construct();
	}
		
	function exist($role){
		$this->db->from('dyn_role');
		$this->db->where('role',$role);	
		return $this->db->count_all_results();	
	}
	
	function get_all(){
		return $this->db->query("select *
			from dyn_role
			where is_active = 1
			order by role asc");
	}
	function get_info($id)
	{
		$this->db->from('dyn_role');	
		$this->db->where('id',$id);
		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $item_id is NOT an item
			$data_obj=new stdClass();

			//Get all the fields from items table
			$fields = $this->db->list_fields('dyn_role');

			foreach ($fields as $field)
			{
				$data_obj->$field='';
			}

			return $data_obj;
		}
	}
	
	function save(&$data)
	{	
		if ($data["id"] == ''){
			$this->db->set('is_active', '1');
			$role = $data["role"];
			$deskripsi = $data["deskripsi"];
			// if($this->db->insert('dyn_role',$data))
			$query = $this->db->query("INSERT INTO dyn_role (is_active, role, deskripsi) VALUES ('1', '$role','$deskripsi')");
			if($query)
			{
				return true;
			}
			return false;
		}else{			
			$this->db->set('is_active', $data["is_active"]);
			$this->db->where('id', $data["id"]);
			return $this->db->update('dyn_role');
		}
	}
	
	function delete($id)
	{
		$this->db->where('id',$id);	
		if ($this->db->delete('dyn_role')){
			return true;
		}else{			
			return false;
		}
	}
	
	function get_menu_all($id){
		return $this->db->query("select b.page_id,
			CASE WHEN b.is_parent = 1 THEN CONCAT(LPAD(b.page_id,2,'0'),'00')
									ELSE CONCAT(LPAD(b.parent_id,2,'0'),LPAD(b.position,2,'0'))
			END AS urutan,
			CASE WHEN (b.is_parent = 1 or b.parent_id = 0) THEN b.title
									ELSE CONCAT('<i class=\"fa fa-angle-double-right fa-fw\"></i>',b.title)
			END AS title, IFNULL(a.role_id,0) as sts
			from dyn_role_menu a
			RIGHT JOIN 
			dyn_menu b
			on a.menu_id = b.page_id
			and a.role_id = $id
			order by urutan asc");
	}
	
	function roleMenuSave($id,&$data)
	{	
		$this->db->where('role_id', $id);
		$this->db->delete('dyn_role_menu');
		$temp =count($data);
		for($i=0; $i<$temp;$i++){
			$this->db->insert('dyn_role_menu',$data[$i]);
		}
		return true;
	}
}
?>