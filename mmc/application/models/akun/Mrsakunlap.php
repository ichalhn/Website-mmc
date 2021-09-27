<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mrsakunlap extends CI_Model{
		function __construct(){
			parent::__construct();
			$this->load->database();
		}

		function get_data_lapgl($tglawal,$tglakhir,$tipebt,$koderek){
			if($koderek!=''){
				$select_koderek="and  b.koderek='$koderek'";
			}else $select_koderek="";
			if($tipebt!=''){
				$select_bt="and  b.tipebt='$tipebt'";
			}else $select_bt="";
				
			
			return $this->db->query("SELECT a.novoucher, a.ket as vouchket, a.tglentry, count(b.novoucher) as banyak
				FROM voucher a, gltransaksi b 
				WHERE a.novoucher=b.novoucher
				AND left(a.tglentry,10)  <= '$tglakhir'
				AND left(a.tglentry,10)  >= '$tglawal'
				and (a.tutupvoucher!='0000-00-00 00:00:00' and a.tutupvoucher is not null)
				$select_koderek
				$select_bt
				GROUP BY a.novoucher");
		}

		function get_data_detailgl($tglawal,$tglakhir,$tipebt,$koderek){
			if($koderek!=''){
				$select_koderek="and  koderek='$koderek'";
			}else $select_koderek="";
			if($tipebt!=''){
				$select_bt="and tipebt='$tipebt'";
			}else $select_bt="";
			
			return $this->db->query("SELECT *, (SELECT mataanggaran from kodebtambahan where kode=SUBSTRING_INDEX(SUBSTRING_INDEX(gltransaksi.kodebt, '-', 2), '-', -1) and tipe=SUBSTRING_INDEX(SUBSTRING_INDEX(gltransaksi.kodebt, '-', 1), '-', -1)) as btma, (SELECT perkiraan from koderekening where kode=gltransaksi.koderek)  as perkiraan from gltransaksi where left(tgltransaksi,10)  <= '$tglakhir' AND left(tgltransaksi,10)  >= '$tglawal' $select_koderek $select_bt order by novoucher");
		}

		//master rekening
		function get_all_data_rekening(){
			return $this->db->query("SELECT kode, perkiraan, tl, tipe, IF(nb='K','KREDIT','DEBET') as nb, IF(nrl='R','RUGI LABA','NERACA') as nrl, upkode, IF(statusflag='1','Aktif','Nonaktif') as status  FROM koderekening ORDER BY kode");
		}

		function get_all_data_jurnal_rekening(){
			return $this->db->query("SELECT kode, perkiraan, tl, tipe, IF(nb='K','KREDIT','DEBET') as nb, IF(nrl='R','RUGI LABA','NERACA') as nrl, upkode, IF(statusflag='1','Aktif','Nonaktif') as status  FROM koderekening where tipe='JURNAL' ORDER BY kode");
		}

		function get_all_data_bt(){
			return $this->db->query("SELECT *  FROM kodebtambahan ORDER BY mataanggaran");
		}

		function get_data_rekening($kode){
			return $this->db->query("SELECT * FROM koderekening WHERE kode='$kode'");
		}

		function delete_rekening($kode){
			$this->db-> where('kode', $kode);
			$this->db-> delete('koderekening');
			return true;
		}	
		function insert_rekening($data){
			$this->db->insert('koderekening', $data);
			return true;
		}

		function edit_rekening($kode, $data){
			$this->db->where('kode', $kode);
			$this->db->update('koderekening', $data); 
			return true;
		}
		
		//master rekening
		function get_all_data_voucher($date0,$date1){
			return $this->db->query("SELECT *, 'Status' as status FROM voucher where left(tgltransaksi,10)>='$date0' and left(tgltransaksi,10)<='$date1'");
		}

		function get_data_voucher($kode){
			return $this->db->query("SELECT * FROM data_voucher WHERE novoucher='$kode'");
		}

		function delete_transaksi($kode){
			$this->db-> where('id', $kode);
			$this->db-> delete('gltransaksi');
			return true;
		}	
		function insert_voucher($data){
			$this->db->insert('voucher', $data);
			return true;
		}

		function edit_voucher($kode, $data){
			$this->db->where('novoucher', $kode);
			$this->db->update('voucher', $data); 
			return true;
		}

		function insert_transaksi($data){
			$this->db->insert('gltransaksi', $data);
			return true;
		}

	var $table = 'data_transaksi_voucher';
	var $column_order = array(null,'id','novoucher','tgltransaksi','rekening','tipe','bt','Nilai','ket',null); //set column field database for datatable orderable
	var $column_search = array('novoucher','tgltransaksi','rekening','tipe','bt','Nilai','ket','id'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('id' => 'desc'); // default order 	

	private function _get_datatables_query($novoucher)
	{
		$this->db-> where('novoucher', $novoucher);
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

		function get_datatables($novoucher)
		{
			$this->_get_datatables_query($novoucher);
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();			
			return $query->result();
		}

		function count_filtered($novoucher)
		{
			$this->_get_datatables_query($novoucher);
			$query = $this->db->get();
			return $query->num_rows();
		}

		public function count_all($novoucher)
		{
			$this->db-> where('novoucher', $novoucher);
			$this->db->from($this->table);
			return $this->db->count_all_results();
		}

	var $table1 = 'data_voucher';
	var $column_order1 = array(null,'id','novoucher','tgltransaksi','tglentry','tutupvoucher','tglvalidasi',null); //set column field database for datatable orderable
	var $column_search1 = array('id','novoucher','tgltransaksi','tglentry','tutupvoucher','tglvalidasi'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order1 = array('novoucher' => 'desc'); // default order 	

	private function _get_datatables_query1()
	{
		//$this->db-> where('novoucher', $novoucher);
		$this->db->from($this->table1);

		$i = 0;
	
		foreach ($this->column_search1 as $item) // loop column 
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

				if(count($this->column_search1) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
			}
		
			if(isset($_POST['order'])) // here order processing
			{
				$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($this->order1))
			{
				$order = $this->order1;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}

		function get_datatables1()
		{
			$this->_get_datatables_query1();
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();			
			return $query->result();
		}

		function count_filtered1()
		{
			$this->_get_datatables_query1();
			$query = $this->db->get();
			return $query->num_rows();

		}

		public function count_all1()
		{
			$this->db->from($this->table1);
			return $this->db->count_all_results();
		}

	}
?>
