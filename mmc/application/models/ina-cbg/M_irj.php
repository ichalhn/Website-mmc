<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class M_irj extends CI_Model {
        var $table = 'data_pasien';
        var $column_order = array(null,'id_poli', 'no_cm','nama','no_kartu','no_sep');
        var $column_search = array('data_pasien.no_cm','data_pasien.nama','data_pasien.no_kartu','daftar_ulang_irj.no_sep','daftar_ulang_irj.id_poli'); 
        var $order = array('tgl_kunjungan' => 'desc');  
        public function __construct() {
            parent::__construct();
            $this->load->database();
        }

		private function _get_datatables_query()  {

            $this->db->FROM('daftar_ulang_irj');
            $this->db->JOIN('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');
            $this->db->where('daftar_ulang_irj.no_sep !=','');
            $this->db->where('daftar_ulang_irj.cara_bayar','BPJS');

            switch ($this->input->post('status_klaim')) {
                case '1':
                    $this->db->where('daftar_ulang_irj.no_sep NOT IN (SELECT no_sep FROM klaim)', NULL, FALSE); 
                    break;
                case '2':
                    $this->db->JOIN('klaim', 'daftar_ulang_irj.no_sep = klaim.no_sep', 'inner');
                    $this->db->SELECT('data_pasien.no_cm,data_pasien.nama,data_pasien.no_kartu,daftar_ulang_irj.no_sep,klaim.claim_at,klaim.setclaim_status,daftar_ulang_irj.id_poli,daftar_ulang_irj.tgl_kunjungan');
                    break;
                case '3':
                    $this->db->JOIN('klaim', 'daftar_ulang_irj.no_sep = klaim.no_sep', 'inner');
                    $this->db->JOIN('set_klaim', 'klaim.id = set_klaim.id_klaim', 'inner');
                    $this->db->SELECT('data_pasien.no_cm,data_pasien.nama,data_pasien.no_kartu,daftar_ulang_irj.no_sep,set_klaim.setclaim_at,daftar_ulang_irj.id_poli,set_klaim.id as id_setklaim,set_klaim.status,daftar_ulang_irj.tgl_kunjungan');
                    break;                      
                default:
                    $this->db->where('daftar_ulang_irj.no_sep NOT IN (SELECT no_sep FROM klaim)', NULL, FALSE); 
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
                    $order = array('tgl_kunjungan' => 'desc');
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
            $this->db->FROM('daftar_ulang_irj');
            $this->db->JOIN('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');
            switch ($this->input->post('status_klaim')) {
                case '1':
                    $this->db->where('daftar_ulang_irj.no_sep NOT IN (SELECT no_sep FROM klaim)', NULL, FALSE); 
                    break;
                case '2':
                    $this->db->JOIN('klaim', 'daftar_ulang_irj.no_sep = klaim.no_sep', 'inner');
                    $this->db->SELECT('data_pasien.no_cm,data_pasien.nama,data_pasien.no_kartu,daftar_ulang_irj.no_sep,klaim.claim_at,klaim.setclaim_status,daftar_ulang_irj.id_poli,daftar_ulang_irj.tgl_kunjungan');
                    break;
                case '3':
                    $this->db->JOIN('klaim', 'daftar_ulang_irj.no_sep = klaim.no_sep', 'inner');
                    $this->db->JOIN('set_klaim', 'klaim.id = set_klaim.id_klaim', 'inner');
                    $this->db->SELECT('data_pasien.no_cm,data_pasien.nama,data_pasien.no_kartu,daftar_ulang_irj.no_sep,set_klaim.setclaim_at,daftar_ulang_irj.id_poli,set_klaim.id as id_setklaim,daftar_ulang_irj.tgl_kunjungan');
                    break;                    
                default:
                    $this->db->where('no_sep NOT IN (SELECT no_sep FROM klaim)', NULL, FALSE); 
            }        
            return $this->db->count_all_results();
        }
  
        function show_pasien($no_sep) {
          $this->db->FROM('daftar_ulang_irj');
          $this->db->JOIN('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');
          $this->db->SELECT('data_pasien.no_cm,data_pasien.no_kartu,data_pasien.nama,data_pasien.tgl_lahir,data_pasien.sex,daftar_ulang_irj.no_sep');   
          $this->db->where('no_sep', $no_sep);
          $this->db->where('no_sep', $no_sep);
          $query = $this->db->get();
          return $query->row();
        } 

        function get_coder_nik($username) {
          $this->db->FROM('hmis_users');
          $this->db->SELECT('coder_nik');   
          $this->db->where('username', $username);
          $query = $this->db->get();
          return $query->row();
        } 


        function diagnosa_irj($no_sep) {
          $this->db->FROM('daftar_ulang_irj');
          $this->db->JOIN('diagnosa_pasien', 'daftar_ulang_irj.no_register = diagnosa_pasien.no_register', 'inner');
          $this->db->SELECT('diagnosa_pasien.no_register,diagnosa_pasien.nm_dokter,diagnosa_pasien.id_diagnosa,diagnosa_pasien.klasifikasi_diagnos,diagnosa_pasien.diagnosa');   
          $this->db->where('no_sep', $no_sep);
          $query = $this->db->get();
          return $query->result();
        }    

        function procedure_irj($no_sep) {
          $this->db->FROM('daftar_ulang_irj');
          $this->db->JOIN('icd9cm_irj', 'daftar_ulang_irj.no_register = icd9cm_irj.no_register', 'inner');
          $this->db->SELECT('icd9cm_irj.no_register,icd9cm_irj.id_procedure,icd9cm_irj.procedure,icd9cm_irj.klasifikasi_procedure');   
          $this->db->where('no_sep', $no_sep);
          $query = $this->db->get();
          return $query->result();
        }            

        function dataklaim_irj($no_sep) {
          $this->db->FROM('daftar_ulang_irj');
          $this->db->JOIN('data_pasien', 'daftar_ulang_irj.no_medrec = data_pasien.no_medrec', 'inner');
          $this->db->JOIN('klaim', 'daftar_ulang_irj.no_sep = klaim.no_sep', 'inner');
          $this->db->SELECT('daftar_ulang_irj.no_sep,data_pasien.no_kartu,daftar_ulang_irj.tgl_kunjungan,daftar_ulang_irj.tgl_pulang,klaim.id as id_klaim');   
          $this->db->where('daftar_ulang_irj.no_sep', $no_sep);
          $query = $this->db->get();
          return $query->row();
        }              

        function insert_klaim_irj($data_insert){          
            $this->db->insert('klaim', $data_insert);
            return $this->db->insert_id();
        }  

        function setklaim_irj($data_setklaim){          
            $this->db->insert('set_klaim', $data_setklaim);
            return $this->db->insert_id();
        }    

        function setklaim_status($id_klaim){
            $data_update = array('setclaim_status' => 1, );
             $this->db->where('id', $id_klaim);
             $this->db->update('klaim', $data_update);
             return true;
        } 

        function grouping_status($id_setklaim){
            $data_update = array('status' => 1, );
             $this->db->where('id', $id_setklaim);
             $this->db->update('set_klaim', $data_update);
             return true;
        }  

        function finalisasi_status($id_setklaim){
            $data_update = array('status' => 3, );
             $this->db->where('id', $id_setklaim);
             $this->db->update('set_klaim', $data_update);
             return true;
        }                  

        function data_grouping($data_grouping){          
            $this->db->insert('data_grouping', $data_grouping);
            return true;
        }

        function tarif_alt($tarif_alt){          
            $this->db->insert('tarif_alt', $tarif_alt);
            return true;
        }

        function special_cmg($special_cmg){          
            $this->db->insert('special_cmg', $special_cmg);
            return true;
        }

        function special_cmg_option($special_cmg_option){          
            $this->db->insert('special_cmg_option', $special_cmg_option);
            return true;
        }                                           

	}

?>