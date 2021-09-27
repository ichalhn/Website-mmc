<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class M_iri extends CI_Model {
        var $table = 'data_pasien';
        var $column_order = array(null,'no_cm','nama','no_kartu','no_sep');
        var $column_search = array('data_pasien.no_cm','data_pasien.nama','data_pasien.no_kartu','pasien_iri.no_sep'); 
        var $order = array('tgl_masuk' => 'desc');  
        public function __construct() {
            parent::__construct();
            $this->load->database();
        }
		public function cek_user($data) {
			$query = $this->db->get_where('login_session', $data);
			return $query;
		}
		private function _get_datatables_query()  {

            $this->db->FROM('pasien_iri');
            $this->db->JOIN('data_pasien', 'pasien_iri.no_cm = data_pasien.no_cm', 'inner');
            $this->db->where('pasien_iri.no_sep !=','');

            switch ($this->input->post('status_klaim')) {
                case '1':
                    $this->db->where('pasien_iri.no_sep NOT IN (SELECT no_sep FROM ina_cbg)', NULL, FALSE); 
                    break;
                case '2':
                    $this->db->JOIN('ina_cbg', 'pasien_iri.no_sep = ina_cbg.no_sep', 'inner');
                    $this->db->SELECT('data_pasien.no_cm,data_pasien.nama,data_pasien.no_kartu,pasien_iri.no_sep,ina_cbg.patient_id,ina_cbg.claim_at');
                    break;
                default:
                    $this->db->where('pasien_iri.no_sep NOT IN (SELECT no_sep FROM ina_cbg)', NULL, FALSE); 
            }
        
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
         
            if(isset($_POST['order']))
            {
                $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } 
            else if(isset($this->order))
            {
                if ($this->input->post('status_klaim') == '2') {
                    $order = array('claim_at' => 'desc');
                } else {
                    $order = array('tgl_masuk' => 'desc');
                }            
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }
 
        public function get_klaim()
        {
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
            $this->db->FROM('pasien_iri');
            $this->db->JOIN('data_pasien', 'pasien_iri.no_cm = data_pasien.no_cm', 'inner');
            switch ($this->input->post('status_klaim')) {
                case '1':
                    $this->db->where('no_sep NOT IN (SELECT no_sep FROM ina_cbg)', NULL, FALSE); 
                    break;
                case '2':
                    $this->db->JOIN('ina_cbg', 'pasien_iri.no_sep = ina_cbg.no_sep', 'inner');
                    $this->db->SELECT('data_pasien.no_cm,data_pasien.nama,data_pasien.no_kartu,pasien_iri.no_sep,ina_cbg.patient_id');
                    break;
                default:
                    $this->db->where('no_sep NOT IN (SELECT no_sep FROM ina_cbg)', NULL, FALSE); 
            }        
            return $this->db->count_all_results();
        }
  
        function show_pasien($no_sep) {
          $this->db->FROM('pasien_iri');
          $this->db->JOIN('data_pasien', 'pasien_iri.no_cm = data_pasien.no_cm', 'inner');
          $this->db->SELECT('data_pasien.no_cm,data_pasien.no_kartu,data_pasien.nama,data_pasien.tgl_lahir,data_pasien.sex,pasien_iri.no_sep');   
          $this->db->where('no_sep', $no_sep);
          $query = $this->db->get();
          return $query->row();
        } 

        function diagnosa_iri($no_sep) {
          $this->db->FROM('pasien_iri');
          $this->db->JOIN('data_pasien', 'pasien_iri.no_cm = data_pasien.no_cm', 'inner');
          $this->db->JOIN('diagnosa_pasien', 'pasien_iri.no_register = diagnosa_pasien.no_register', 'inner');
          $this->db->SELECT('pasien_iri.no_sep,data_pasien.no_kartu,pasien_iri.tgl_masuk,pasien_iri.tgl_pulang,diagnosa_pasien.no_register,diagnosa_pasien.nm_dokter,diagnosa_pasien.id_diagnosa,diagnosa_pasien.klasifikasi_diagnos,diagnosa_pasien.diagnosa');   
          $this->db->where('no_sep', $no_sep);
          $query = $this->db->get();
          return $query->result();
        }      

        function insert_klaim_iri($data_insert){          
            $this->db->insert('ina_cbg', $data_insert);
            return $this->db->insert_id();
        }  

        function setklaim_iri($data_setklaim){          
            $this->db->insert('set_klaim', $data_setklaim);
            return $this->db->insert_id();
        } 

        public function update_setklaim_id($no_sep,$data_setklaim){
            $this->db->where('no_sep', $no_sep);
            $this->db->update('ina_cbg', $data_setklaim);
            return true;
        }                 

	}

?>