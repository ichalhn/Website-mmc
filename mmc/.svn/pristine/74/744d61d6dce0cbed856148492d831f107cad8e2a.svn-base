<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mrsnrl extends CI_Model{
		function __construct(){
			parent::__construct();
			$this->load->database();
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

		function get_all_data_trans_nrl($id_nrl){
			return $this->db->query("SELECT *  FROM transaksi_nrl where id_nrl=$id_nrl ORDER BY right(bulan,2) asc");
		}

		//Laporan NERACA
		function get_lap_nrl($tipe,$date1,$date0,$nrl){
			if($tipe=='BLN'){
				return $this->db->query("Select  *,  
(SELECT perkiraan from koderekening where kode=b.koderek) as perkiraan,
(SELECT perkiraan from koderekening where kode=b.koderek_akhir) as perkiraanakhir 
from transaksi_nrl a,  master_lap_nrl b
where a.id_nrl=b.id_nrl and (a.bulan='$date1' or a.bulan='$date0')
and tipe='$nrl' group by a.id_nrl");
			}else{
			return $this->db->query("Select  *, left(a.bulan,4) as year,
(SELECT perkiraan from koderekening where kode=b.koderek) as perkiraan,
(SELECT perkiraan from koderekening where kode=b.koderek_akhir) as perkiraanakhir 
from transaksi_nrl a,  master_lap_nrl b
where a.id_nrl=b.id_nrl and (left(a.bulan,4)='$date1' or left(a.bulan,4)='$date0')
and tipe='$nrl' group by a.id_nrl");
			}
		}

		function get_detail_lap_nrl($tipe,$date1,$date0,$nrl){
			if($tipe=='BLN'){
				return $this->db->query("Select a.id_nrl, IFNULL(a.nilai,0) as totnilai, a.bulan as year
from transaksi_nrl a,  master_lap_nrl b
where a.id_nrl=b.id_nrl and (a.bulan='$date1' or a.bulan='$date0') and b.tipe='$nrl' order by a.bulan desc
 ");
			}else{
				return $this->db->query("Select a.id_nrl, SUM(IFNULL(a.nilai,0)) as totnilai, left(a.bulan,4) as year
from transaksi_nrl a,  master_lap_nrl b
where a.id_nrl=b.id_nrl and (left(a.bulan,4)='$date1' or left(a.bulan,4)='$date0') and b.tipe='$nrl' 
 group by left(a.bulan,4), a.id_nrl order by year desc");
			}
		}

		//Laporan RUGI LABA
		function get_lap_rl($id_nrl){
			return $this->db->query("SELECT *  FROM transaksi_nrl where id_nrl=$id_nrl ORDER BY right(bulan,2) asc");
		}

		function get_all_data_masternrl(){
			return $this->db->query("SELECT *, (SELECT perkiraan from koderekening where kode=a.koderek) as perkiraan, (SELECT perkiraan from koderekening where kode=a.koderek_akhir) as perkiraanakhir
FROM master_lap_nrl a");
		}

		function get_all_param1(){
			return $this->db->query("select param1 from master_lap_nrl group by param1");
		}

		function get_all_param2(){
			return $this->db->query("select param2 from master_lap_nrl group by param2");
		}

		function get_data_masternrl($id_nrl){
			return $this->db->query("SELECT *, (SELECT perkiraan from koderekening where kode=a.koderek) as perkiraan, (SELECT perkiraan from koderekening where kode=a.koderek_akhir) as perkiraanakhir
FROM master_lap_nrl a where id_nrl=$id_nrl");
		}

		function get_data_trans_nrl($id_trans_nrl){
			return $this->db->query("SELECT * FROM transaksi_nrl a where a.id_transaksi_nrl=$id_trans_nrl");
		}
		
		function get_year_nrl($id_nrl){
			return $this->db->query("select left(bulan,4) as year from transaksi_nrl where id_nrl=$id_nrl group by left(bulan,4)");
		}

		//count
		function get_count_trans_nrl($id_nrl){
			return $this->db->query("select count(*) as banyak from transaksi_nrl where id_nrl=$id_nrl");
		}

		function delete_nrl($kode){
			$this->db-> where('id_nrl', $kode);
			$this->db-> delete('master_lap_nrl');
			return true;
		}
		function delete_trans_nrl($kode){
			$this->db-> where('left(bulan,4)', $kode);
			$this->db-> delete('transaksi_nrl');
			return true;
		}	
		function insert_master_nrl($data){
			$this->db->insert('master_lap_nrl', $data);
			return true;
		}

		function edit_nrl($kode, $data){
			$this->db->where('id_nrl', $kode);
			$this->db->update('master_lap_nrl', $data); 
			return true;
		}
		function edit_nilai_nrl($kode, $data){
			$this->db->where('id_transaksi_nrl', $kode);
			$this->db->update('transaksi_nrl', $data); 
			return true;
		}
		
		//master rekening
		function get_all_data_voucher($date0,$date1){
			return $this->db->query("SELECT *, 'Status' as status FROM voucher where left(tgltransaksi,10)>='$date0' and left(tgltransaksi,10)<='$date1'");
		}

		function get_data_nrl($kode){
			return $this->db->query("SELECT * FROM master_lap_nrl WHERE id_nrl='$kode'");
		}

		function get_koderek_akhir($kode){
			return $this->db->query("SELECT * FROM koderekening WHERE kode like '$kode%' order by CAST(kode AS UNSIGNED)");
		}

		function delete_transaksi($kode){
			$this->db-> where('id', $kode);
			$this->db-> delete('gltransaksi');
			return true;
		}	
		function insert_transaksi_nrl($data){
			$this->db->insert('transaksi_nrl', $data);
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
