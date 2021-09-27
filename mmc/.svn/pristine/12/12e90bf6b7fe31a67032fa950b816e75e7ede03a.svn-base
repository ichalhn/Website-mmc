<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MHistoripasien extends CI_Model {

	var $table = 'medrec_pasien';
	var $column_order = array(null,'no_register','no_cm','nama','id_poli','tgl_kunjungan'); //set column field database for datatable orderable
	var $column_search = array('no_register','no_cm','nama','id_poli','tgl_kunjungan'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('tgl_kunjungan' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
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

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
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
       
	function get_info_pasien($no_cm){
		$query = $this->db->query("SELECT d.nama,d.no_cm,d.goldarah,d.foto,
			DATE_FORMAT(FROM_DAYS(DATEDIFF(CURRENT_DATE, d.tgl_lahir)),'%y Tahun %m Bulan %d Hari') AS umur 
			FROM data_pasien d
			WHERE no_cm = '".$no_cm."'");
			
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
		return $this->db->query("");
	}
	
	function get_history($no_cm, $tujuan){
		return $this->db->query("SELECT e.*, 
		(SELECT COUNT(ee.no_register) FROM elektromedikalrecord ee WHERE ee.tujuan = e.tujuan AND ee.no_cm = e.no_cm AND ee.no_register = e.no_register) jml
			FROM elektromedikalrecord e
			WHERE e.tujuan = '".$tujuan."'
			AND e.no_cm = $no_cm ORDER BY e.tanggal DESC, e.keterangan ASC")->result();
	}

	function get_history_lab($no_cm){
		return $this->db->query('SELECT a.no_medrec AS no_medrec, a.tgl_kunjungan AS tgl_kunjungan, a.no_register AS no_register, a.no_lab AS no_lab, a.id_tindakan AS id_tindakan, a.jenis_tindakan AS jenis_tindakan, b.jenis_hasil AS jenis_hasil, b.kadar_normal AS kadar_normal, b.satuan AS satuan, b.hasil_lab AS hasil_lab FROM pemeriksaan_laboratorium as a
				LEFT JOIN hasil_pemeriksaan_lab as b ON a.id_tindakan=b.id_tindakan
				where a.no_medrec = "0000'.$no_cm.'"')->result();

	}
	function get_history_irj($no_cm){
		return $this->db->query("SELECT e.*, 
		(SELECT COUNT(ee.no_register) FROM elektromedikalrecord ee WHERE ee.tujuan = e.tujuan AND ee.no_cm = e.no_cm AND ee.no_register = e.no_register) jml
			FROM elektromedikalrecord e
			WHERE e.no_register LIKE 'RJ%' and (e.keterangan = 'DIAGNOSA' or e.keterangan = 'TINDAKAN')
			AND e.no_cm = $no_cm ORDER BY e.tanggal DESC, e.keterangan ASC")->result();
	}
	
}
