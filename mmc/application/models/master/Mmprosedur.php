<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mmprosedur extends CI_Model{
        var $table = 'icd9cm';
        var $column_order = array(null,'id_tind', 'nm_tindakan');
        var $column_search = array('id_tind','nm_tindakan'); 
        var $order = array('id' => 'desc');  		
		function __construct(){
			parent::__construct();
		}

		private function _get_datatables_query()  {

			$this->db->select('id,id_tind,nm_tindakan');
            $this->db->from('icd9cm');
        
            $i = 0;     
            foreach ($this->column_search as $item)
            {
                if($_POST['search']['value'])
                {
                     
                    if($i===0)
                    {
                        $this->db->group_start();
                        $this->db->like($item, $_POST['search']['value']);
                    }
                    else
                    {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
     
                    if(count($this->column_search) - 1 == $i)
                        $this->db->group_end();
                }
	                $i++;
	        }
	         
	        if(isset($_POST['order'])) // here order processing
	        {
	            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
	        } 
	        else if(isset($this->order))
	        {
	            $order = $this->order;
	            $this->db->order_by(key($order), $order[key($order)]);
	        }
	    }

		function get_prosedur(){
            $this->_get_datatables_query();
            if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
 
        public function count_filtered()
        {
            $this->_get_datatables_query();
            $query = $this->db->get();
            return $query->num_rows();
        }
 
	    public function count_all()
	    {
	        $this->db->from($this->table);
	        return $this->db->count_all_results();
	    }
		
        function show_prosedur($id_prosedur) {
        	$this->db->select('id,id_tind,nm_tindakan');
          	$this->db->from('icd9cm');
          	$this->db->where('id', $id_prosedur);
          	$query = $this->db->get();
          	return $query->row();
        } 

		function insert_prosedur($data){
			$this->db->insert('icd9cm', $data);
			return true;
		}


		function edit_prosedur($id_prosedur, $data){
			$this->db->where('id', $id_prosedur);
			$this->db->update('icd9cm', $data); 
			return true;
		}
	}
?>
