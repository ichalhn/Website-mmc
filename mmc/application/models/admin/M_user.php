<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_user extends CI_Model{
	function __construct(){
		parent::__construct();
	}
		
	function exist($username){
		$this->db->from('hmis_users');
		$this->db->where('username',$username);	
		return $this->db->count_all_results();	
	}
	
	function check_pass_match($data){
		$this->db->from('hmis_users');
		$this->db->where('userid', $this->session->userdata('userid'));	
		$this->db->where('password', $data['currpass']);	
		return $this->db->count_all_results();	
	}
	
	function get_all(){
		return $this->db->query("select *
			from hmis_users
			where deleted = 0
			order by username asc");
	}
	
	function get_role_all($id){
		return $this->db->query("select b.id, IFNULL(a.roleid,0) as sts, b.role
			from dyn_role_user a
			RIGHT JOIN 
			dyn_role b
			on a.roleid = b.id
			and a.userid = $id");
	}
	
	function get_role_gudang($id){
		return $this->db->query("select b.id_gudang, IFNULL(a.id_gudang,0) as sts, b.nama_gudang
			from dyn_gudang_user a
			RIGHT JOIN 
			master_gudang b
			on a.id_gudang = b.id_gudang
			and a.userid = $id");
	}

	function get_role_poli($id){
		return $this->db->query("select b.id_poli, IFNULL(a.id_poli,0) as sts, b.nm_poli
			from dyn_poli_user a
			RIGHT JOIN 
			poliklinik b
			on a.id_poli = b.id_poli
			and a.userid = $id");
	}

	function get_role_ruang($id){
		return $this->db->query("select b.idrg as id_ruang, IFNULL(a.id_ruang,0) as sts, b.nmruang as nm_ruang
			from dyn_ruang_user a
			RIGHT JOIN 
			ruang b
			on a.id_ruang = b.idrg
			and a.userid = $id");
	}
	/*
	Attempts to login employee and set session. Returns boolean based on outcome.
	*/
	function login($username, $password)
	{
		//$query = $this->db->get_where('hmis_users', array('username' => $username,'password'=>md5($password), 'deleted'=>0), 1);
		$query = $this->db->get_where('hmis_users', array('username' => $username,'password'=>$password, 'deleted'=>0), 1);
		if ($query->num_rows() ==1)
		{
			$row=$query->row();
			$this->session->set_userdata('userid', $row->userid);
			return true;
		}
		return false;
	}
	
	/*
	Logs out a user by destorying all session data and redirect to login
	*/
	function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
	
	/*
	Determins if a user is logged in
	*/
	function is_logged_in()
	{
		return $this->session->userdata('userid')!=false;
	}
	/*
	Gets information about a user loged in
	*/
	function get_logged_in_user_info()
	{
		$userid = $this->session->userdata('userid');
		if (($userid)){
			return $this->get_info($userid);
		}
	}
	/*
	Gets information about a particular user
	*/
	function get_info($userid)
	{
		$this->db->from('hmis_users');	
		$this->db->where('userid',$userid);
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
			$fields = $this->db->list_fields('hmis_users');

			foreach ($fields as $field)
			{
				$data_obj->$field='';
			}

			return $data_obj;
		}
	}
	/*
	Determins whether the employee specified employee has access the specific module.
	*/
	function has_permission($url,$userid)
	{
		//if no module_id is null, allow access
		if($url==null or $url=='beranda' or $url=='logout')
		{
			return true;
		}else{
			if ($this->is_menu($url)){
				$query = $this->db->query("select count(*) as jml
					from dyn_role_user ru, dyn_role_menu rm, dyn_menu m
					where ru.userid = $userid
						and ru.roleid = rm.role_id
					  and rm.menu_id = m.page_id
					  and m.url = '$url'");
				return ($query->row()->jml > 0);
			}else{
				return true;
			}
		}
		return false;
	}
	
	function is_menu($url){
		$query = $this->db->query("select count(show_menu) as jml
					from dyn_menu
					where url = '$url' and show_menu = 1");
		return ($query->row()->jml == 1);
	}
	
	function has_gudang_access($userid,$id_gudang)
	{
		$query = $this->db->query("select count(*) as jml
					from dyn_gudang_user
					where userid = $userid and id_gudang = $id_gudang");
		return $query->row()->jml;
	}

	function has_poli_access($userid,$id_poli)
	{
		$query = $this->db->query("select count(*) as jml
					from dyn_poli_user
					where userid = $userid and id_poli = $id_poli");
		return $query->row()->jml;
	}

	function has_ruang_access($userid,$id_ruang)
	{
		$query = $this->db->query("select count(*) as jml
					from dyn_ruang_user
					where userid = $userid and id_ruang = $id_ruang");
		return $query->row()->jml;
	}
	
	function save(&$data,$foto)
	{	
		$query = $this->db->query("INSERT INTO hmis_users (username, password, name, deleted, foto) VALUES ('".$data["username"]."','".$data["password"]."','".$data["name"]."','0','$foto')");
		if($query)
		{
			return true;
		}
		return false;
	}
	function update($data){	
		$this->db->set('password', $data["vpassword"]);
		$this->db->where('userid', $data["vuserid"]);
		return $this->db->update('hmis_users');
	}
	function delete($id)
	{
		$this->db->where('userid',$id);	
		if ($this->db->delete('hmis_users')){
			return true;
		}else{			
			return false;
		}
	}
	function userRoleSave($id,&$data)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_role_user');
		$temp =count($data);
		for($i=0; $i<$temp;$i++){
			$this->db->insert('dyn_role_user',$data[$i]);
		}
		return true;
	}
	function userGdgSave($id,&$data)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_gudang_user');
		$temp =count($data);
		for($i=0; $i<$temp;$i++){
			$this->db->insert('dyn_gudang_user',$data[$i]);
		}
		return true;
	}
	function userGdgDelete($id)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_gudang_user');		
		return true;
	}
	function userPoliSave($id,&$data)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_poli_user');
		$temp =count($data);
		for($i=0; $i<$temp;$i++){
			$this->db->insert('dyn_poli_user',$data[$i]);
		}
		return true;
	}
	function userPoliDelete($id)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_poli_user');		
		return true;
	}
	function userRuangSave($id,&$data)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_ruang_user');
		$temp =count($data);
		for($i=0; $i<$temp;$i++){
			$this->db->insert('dyn_ruang_user',$data[$i]);
		}
		return true;
	}
	function userRuangDelete($id)
	{	
		$this->db->where('userid', $id);
		$this->db->delete('dyn_ruang_user');		
		return true;
	}

	
	function update_photo($uid, $foto){
		return $this->db->query("update hmis_users set foto = '".$foto."' where username = '".$uid."'");
	}
	function update_name($data){
		return $this->db->query("update hmis_users set name = '".$data["uname"]."' where username = '".$data["uid"]."'");
	}
	function change_pass($data){
		return $this->db->query("update hmis_users set password = '".$data["newpass"]."' where userid = '".$this->session->userdata('userid')."'");
	}
}
?>