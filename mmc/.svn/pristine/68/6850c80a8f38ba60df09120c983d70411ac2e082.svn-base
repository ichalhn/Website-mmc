<?php 
class Mbpjs extends CI_Model 
{
    
    public function __construct() 
    {
        parent::__construct();
    }
	
	function get_bpjs(){
		return $this->db->query("select * from data_bpjs");
	}
    public function update_bpjs($data_bpjs){
        $this->db->update('data_bpjs', $data_bpjs);
        $this->db->limit(1);
        return true;        
    }   

}