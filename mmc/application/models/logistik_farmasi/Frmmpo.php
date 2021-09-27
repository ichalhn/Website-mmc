<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class Frmmpo extends CI_Model{
    function __construct(){
    parent::__construct();
  }

    function insert($data){   
		if ($this->db->query("insert into header_po(supplier_id, tgl_po, sumber_dana, no_po, user, ppn, total)
							values(
									'".$data["supplier_id"]."',
									'".$data["tgl_po"]."',
									'".$data["sumber_dana"]."',
									'".$data["no_po"]."',
									'".$data["user"]."',
									'".$data["ppn_po"]."',
									'".$data["total_akhir"]."'
								)"))
		{
			$json = json_decode($data["dataobat"], true);
			$id_po=$this->db->insert_id();			
		
			$dataobat= array();
			$arr = array("id_po" => $id_po);
			foreach ($json as $value) {
				array_push($dataobat, array_merge($value, $arr));
                $this->db->query("UPDATE master_obat SET harga_po = ".$value['harga_po']." WHERE id_obat = ".$value['item_id']);
            }

            $this->db->insert_batch('po', $dataobat);
            return $id_po;
		}
		return false; 
   }
   function insert_detail_beli($data, $id_gudang){

   		// Aturan Baru, Beli Satuan Besar masuknya Jumlah Kemasan x Qty Beli.
   		$qty_akhir = $data["jml_kemasan"] * $data["qty_beli"];
        // Cek diskon item nya berupa Persentase/ Rupiah
        if(strpos($data['diskon_item'], "%") !== false){
            $persentase = substr($data['diskon_item'], 0, strlen($data['diskon_item'])-1);
            $diskon_item = ($data['hargabeli_po'] * $persentase) / 100;
        }else{
            $persentase = 0;
            $diskon_item = $data['diskon_item'];
        }

       $harga_baru = $data['hargabeli_po'] - $diskon_item;

        //Cek Data Materai
       if($data['materai'] != 0){
           $materai = 6000;
       }else{
           $materai = 0;
       }

       /*$konten = "";
       $konten .= "insert into po(id_po, item_id, description, satuank, qty, qty_beli, batch_no, expire_date, user, hargabeli, diskon_item, harga_po, jml_kemasan, harga_item, satuan_item, diskon_persen)
		values(
				'".$data["id_po"]."',
				'".$data["item_id"]."',
				'".$data["description"]."',
				'".$data["satuank"]."',
				'".$data["qty"]."',
				'".$data["qty_beli"]."',
				'".$data["batch_no"]."',
				'".$data["expire_date"]."',
				'".$this->load->get_var("user_info")->username."',
				'".$data["hargabeli"]."',
				'".$diskon_item."',
				'".$data["harga_po"]."',
				'".$data["jml_kemasan"]."',
				'".$data["hargabeli"]."',
				'".$data["satuan_item"]."',
				'".$persentase."'
			)<br/>";*/

		if ($this->db->query("insert into po(id_po, item_id, description, satuank, qty, qty_beli, batch_no, expire_date, user, hargabeli, diskon_item, harga_po, jml_kemasan, harga_item, satuan_item, diskon_persen, no_faktur, ppn)
		values(
				'".$data["id_po"]."',
				'".$data["item_id"]."',
				'".$data["description"]."',
				'".$data["satuank"]."',
				'".$data["qty"]."',
				'".$data["qty_beli"]."',
				'".$data["batch_no"]."',
				'".$data["expire_date"]."',
				'".$this->load->get_var("user_info")->username."',
				'".$data["hargabeli_po"]."',
				'".$diskon_item."',
				'".$harga_baru."',
				'".$data["jml_kemasan"]."',
				'".$data["hargabeli_po"]."',
				'".$data["satuan_item"]."',
				'".$persentase."',
				'".$data['no_faktur']."',
				'".$data['ppn']."'
			)"))
			{
                //Insert Table do (Delivery Order)
                $this->db->query("INSERT IGNORE INTO do (id_po, no_faktur, tgl_faktur, jatuh_tempo, ppn, materai, cara_bayar, keterangan_faktur, diskon) 
                      VALUES ('".$data['id_po']."',  
                      '".$data['no_faktur']."', 
                      '".$data['tgl_faktur']."', 
                      '".$data['jatuh_tempo']."', 
                      '".$data['ppn']."', 
                      '".$materai."',
                      '".$data['cara_bayar']."', 
                      '".$data['keterangan']."', 
                      '".$data['diskonF']."')");

       /*$konten .= "INSERT IGNORE INTO do (id_po, no_faktur, tgl_faktur, jatuh_tempo, ppn, materai, cara_bayar, keterangan_faktur, diskon)
                      VALUES ('".$data['id_po']."',  
                      '".$data['no_faktur']."', 
                      '".$data['tgl_faktur']."', 
                      '".$data['jatuh_tempo']."', 
                      '".$data['ppn']."', 
                      '".$materai."', 
                      '".$data['cara_bayar']."', 
                      '".$data['keterangan']."', 
                      '".$data['diskonF']."')<br/>";*/


                //Update Harga Jual Obat
                $this->db->query("UPDATE master_obat SET
                        hargajual = '".$data['hargajual']."',
                        hargabeli = '".$data['hargabeli_po']."'
                        
                        WHERE id_obat = '".$data["item_id"]."'");

       /*$konten .= "UPDATE master_obat SET
                        hargajual = '".$data['hargajual']."',
                        hargabeli = '".$data['hargabeli']."'
                        
                        WHERE id_obat = '".$data["item_id"]."'<br/>";*/

                //Input History Pergerakan Stok
				$stok = $this->check_stock_awal(1, $data["item_id"], $data["batch_no"]);
				$stok_akhir = $stok + $qty_akhir;
				$this->db->query("INSERT INTO history_stok (no_transaksi, id_obat, batch_no, tanggal, keterangan, tujuan, stok_awal, stok_in, stok_akhir)
					VALUES ('".$data["no_faktur"]."', '".$data["item_id"]."', '".$data["batch_no"]."', '".date('Y-m-d H:i:s')."', 'Pembelian', 1, '".$stok."', '".$qty_akhir."', '".$stok_akhir."')");

       /*$konten .= "INSERT INTO history_stok (no_transaksi, id_obat, batch_no, tanggal, keterangan, tujuan, stok_awal, stok_in, stok_akhir)
					VALUES ('".$data["no_faktur"]."', '".$data["item_id"]."', '".$data["batch_no"]."', '".date('Y-m-d H:i:s')."', 'Pembelian', 1, '".$stok."', '".$qty_akhir."', '".$stok_akhir."')<br>";*/

				//Check stock gudang peminta
				$check_stock = $this->check_stock(1, $data["item_id"], $data["batch_no"]);
				if ($check_stock > 0){
					$this->db->query("UPDATE gudang_inventory SET qty = qty + '".$qty_akhir."' 
					WHERE id_gudang = '".$id_gudang."'
					AND id_obat  = '".$data["item_id"]."'
					AND batch_no = '".$data["batch_no"]."'");
				}		
				else{
					$this->db->query("INSERT INTO gudang_inventory(id_gudang, id_obat, batch_no, qty, expire_date)
					VALUES(
							'".$id_gudang."',
							'".$data["item_id"]."',
							'".$data["batch_no"]."',
							'".$qty_akhir."',
							'".$data["expire_date"]."'
						)");
				}
			}
		return true;
   }
   /*
    function update($json){   
		$userid = $this->session->userdata('username');
		foreach ($json as &$value) {		
			$id = $value[0]["value"];
			$qty_beli = $value[1]["value"];
			$batch_no = $value[2]["value"];
			$expire_date = $value[3]["value"];
			$keterangan = $value[4]["value"];
			$id_obat = $value[5]["value"];
			
			$this->db->query("UPDATE po SET batch_no = '".$batch_no."', qty_beli = '".$qty_beli."', expire_date = '".$expire_date."', keterangan ='".$keterangan."', user = '".$userid."' WHERE id = '".$id."'");
			
			//Check stock gudang peminta
			$check_stock = $this->check_stock(1, $id_obat, $batch_no);
			if ($check_stock > 0)			
				$this->db->query("UPDATE gudang_inventory SET qty = qty + '".$qty_beli."' 
				WHERE id_gudang = 1
				AND id_obat  = '".$id_obat."'
				AND batch_no = '".$batch_no."'");
			else
				$this->db->query("INSERT INTO gudang_inventory(id_gudang, id_obat, batch_no, qty, expire_date)
				VALUES(
						1,
						'".$id_obat."',
						'".$batch_no."',
						'".$qty_beli."',
						'".$expire_date."'
					)");
		}
		return true;
   }
   */
    function get_suppliers(){
      return $this->db->query("SELECT person_id, company_name FROM suppliers")->result();
    }
	
	function get($id_obat) {
		$query = $this->db->get_where('master_obat', array('id_obat'=>$id_obat));
		return $query->row();
	}

	function getIdGudang($userid){
        $query = $this->db->get_where('dyn_gudang_user', array('userid' => $userid));
        return $query->row();
    }

    function get_po_list($data){
		$where = "";
		if ($data["no_po"] != "")
		{
			$where .= " AND a.no_po = '".$data["no_po"]."'";
		}
		else {
			if (($data["tgl0"] != "") && ($data["tgl1"] == "")){
				$where .= " AND a.tgl_po = '".$data["tgl0"]."'";
			}
			if (($data["tgl0"] != "") && ($data["tgl1"] != "")){
				$where .= " AND a.tgl_po BETWEEN ('".$data["tgl0"]."') AND ('".$data["tgl1"]."')";
			}
			if ($data["supplier_id"] != ""){
				$where .= " AND supplier_id = ".$data["supplier_id"] ;
			}
		}

		return $this->db->query("SELECT a.id_po, a.no_po, a.tgl_po, a.supplier_id, s.company_name, a.sumber_dana, a.user, a.open
			FROM header_po a
			LEFT JOIN suppliers s ON a.supplier_id = s.person_id
			WHERE a.id_po > 0
			$where 
			ORDER BY a.no_po DESC")->result();
    }
    function  get_po_detail_list($id){
		return $this->db->query("SELECT p.*, (p.qty * p.jml_kemasan) as jml_item ,m.hargabeli, m.hargajual, (p.qty * p.`harga_po`) AS subtotal
            FROM po p
            INNER JOIN master_obat m ON m.id_obat = p.item_id
            WHERE p.id_po = $id
            AND qty_beli is NULL ORDER BY id ASC")->result();
    }

    function get_po_total($id){
        return $this->db->query("SELECT qty_beli, harga_po, ppn FROM po WHERE id_po = $id AND qty_beli IS NOT NULL");
    }

    function get_master_total($id){
        return $this->db->query("SELECT SUM(diskon) AS total_diskon FROM `do` WHERE id_po = ".$id);
    }

    function get_po_detail_beli($data){
		return $this->db->query("SELECT a.id, a.id_po, a.item_id, a.description, a.satuank, a.qty, a.qty_beli, a.expire_date, 
              a.batch_no, a.keterangan, a.hargabeli, a.user, o.hargajual, a.`jml_kemasan`, a.diskon_item, o.hargabeli AS hargaitem, a.harga_po
			FROM po a
			INNER JOIN master_obat o ON o.id_obat = a.item_id
			WHERE a.id_po = '".$data["id_po"]."' AND a.item_id = '".$data["item_id"]."'
			AND a.qty_beli IS NOT NULL AND a.batch_no IS NOT NULL AND a.expire_date IS NOT NULL")->result();
    }
	function get_total_beli($data){
        return $this->db->query("SELECT description, qty, a.satuank, IFNULL(SUM(qty_beli),0) as total_qty_beli, IFNULL(MAX(qty),0) as qty_po, IFNULL(MAX(qty),0)-IFNULL(SUM(qty_beli),0) as kuota, b.open, o.hargajual, a.harga_item AS hargabeli, a.`jml_kemasan`, a.`harga_po`, a.`satuan_item`
			FROM po a
			LEFT JOIN header_po AS b ON b.id_po=a.id_po
			INNER JOIN master_obat o ON o.id_obat = a.item_id
			WHERE a.id_po = '".$data["id_po"]."' AND a.item_id = '".$data["item_id"]."'")->row();
	}
	function get_info($id)
	{		
		$query = $this->db->query("SELECT a.id_po, a.no_po, a.tgl_po, a.supplier_id, s.company_name, a.sumber_dana, a.user,a.total,a.ppn
			FROM header_po a
			LEFT JOIN suppliers s ON a.supplier_id = s.person_id
			WHERE a.id_po = ".$id);
			
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
	}
	
	public function checkisexist($id){
		$query=$this->db->query("select count(id_po) as exist, tgl_po as tgl 
			from header_po where no_po = '".$id."'"); 
		if($query->num_rows()==1)
		{
			return $query->row();
		}
	}
	function check_stock($id_gudang, $id_obat, $batch_no){
		$query=$this->db->query("select count(id_inventory) as jml
			from gudang_inventory 
			where id_gudang = '".$id_gudang."' and id_obat = '".$id_obat."' and batch_no = '".$batch_no."'"); 
		if($query->num_rows()==1)
		{
			return $query->row()->jml;
		}
	}

	function check_stock_awal($id_gudang, $id_obat, $batch_no){
		$query = $this->db->query("SELECT * FROM gudang_inventory 
			WHERE id_gudang = '".$id_gudang."' AND id_obat = '".$id_obat."' AND batch_no = '".$batch_no."'");
		if($query->num_rows() > 0){
			return $query->row()->qty;
		}else{
			return 0;
		}
	}

	function delete_detail_beli($id){		
		$this->db->where('id',$id);	
		if ($this->db->delete('po')){
			return true;
		}else{			
			return false;
		}
	}
	function selesai_po($id_po){		
		return $this->db->query("UPDATE header_po SET open = 0 
					WHERE id_po = '$id_po'");
	}

	function getNomorPO(){
	    $month = date('m'); $year = date('Y');
	    $query = $this->db->query("SELECT COUNT(id_po) AS total FROM header_po WHERE tgl_po LIKE '$year-$month%'")->row();
	    /*$this->db->select_max('no_po', 'last');
	    $this->db->like('tgl_po', $year.'-'.$month);
        $query = $this->db->get('header_po')->row();*/

        //$getLast = substr($query->last, 8, 11);
        $counter = $query->total + 1;
        $nextCounter = sprintf("%03s", $counter);
        $next = $month."/".$year."/".$nextCounter;
        return $next;
    }

    function getNomorPOCari($cari){
	    $data = explode("-", $cari);

        /*$this->db->select_max('no_po', 'last');
        $this->db->like('tgl_po', $cari);
        $query = $this->db->get('header_po')->row();

        $getLast = substr($query->last, 8, 11);*/
        $query = $this->db->query("SELECT COUNT(id_po) AS total FROM header_po WHERE tgl_po LIKE '".$data[0]."-".$data[1]."%'")->row();
        $counter = $query->total + 1;
        $nextCounter = sprintf("%03s", $counter);
        $next = $data[1]."/".$data[0]."/".$nextCounter;
        return $next;
    }

	function get_data_po($tgl1, $tgl2){
		return $this->db->query("SELECT a.id_po, a.tgl_po, a.no_po, b.company_name, sumber_dana FROM header_po as a
			left join suppliers as b on a.supplier_id=b.person_id
			WHERE a.tgl_po >= '$tgl1' and a.tgl_po <= '$tgl2'");
	}

	function get_data_po_obat($id_po){
		return $this->db->query("SELECT description, satuank, qty FROM po WHERE id_po = '$id_po'");
	}

	function get_data_pem_po($tgl1, $tgl2){
		return $this->db->query("SELECT a.id_po, a.tgl_po, a.no_po, b.company_name, sumber_dana FROM header_po as a
			left join suppliers as b on a.supplier_id=b.person_id
			WHERE a.tgl_po >= '$tgl1' and a.tgl_po <= '$tgl2' AND open=0");
	}

	function get_data_pem_po_obat($id_po){
		return $this->db->query("SELECT description, satuank, qty, qty_beli, batch_no, expire_date, hargabeli FROM po WHERE qty_beli IS NOT NULL AND id_po = '$id_po'");
	}

    function getNamaSupplier($supplier_id){
      return $this->db->select("adress")
          ->from('suppliers')
          ->where('person_id', $supplier_id)
          ->get()->row();
    }

    function getSatuanObat(){
      return $this->db->get('obat_satuan');
    }

    function delete_item_beli($table, $data){
        $this->db->query("DELETE FROM gudang_inventory WHERE id_obat = ".$data['item_id']." AND batch_no = '".$data['batch_no']."' AND id_gudang = 1");
        return $this->db->delete($table, $data);
    }

    function edit_item_beli($table, $where, $data, $data2){
        $this->db->query("UPDATE master_obat SET harga_po = ".$data2['hargabeli_po'].", hargajual = ".$data2['hargajual']." WHERE id_obat = ".$data2['id_obat']);

        $tqty = $data['qty_beli'] * $data2['jml_kemasan'];
        $this->db->query("UPDATE gudang_inventory SET qty = ".$tqty." 
					WHERE id_gudang = 1
					AND id_obat  = '".$where['item_id']."'
					AND batch_no = '".$where['batch_no']."'");

        return $this->db->update($table, $data, $where);
    }

      function autocomplete_obat($q){
          $query=$this->db->query("SELECT o.`id_obat`, o.`nm_obat`, o.`hargabeli`, o.`hargajual`, o.`satuank`, g.`batch_no`, g.`expire_date`, g.`qty`, o.`jenis_obat`, o.`harga_po`
                                FROM master_obat o
                                LEFT JOIN gudang_inventory g ON o.id_obat = g.id_obat
                                WHERE o.`nm_obat` LIKE '%".$q."%' LIMIT 20");
          if($query->num_rows() > 0){
              foreach ($query->result() as $row){
                  $new_row['label']=htmlentities(stripslashes($row->nm_obat." (".$row->batch_no.",".$row->expire_date.",".$row->qty.")"));
                  $new_row['value']=htmlentities(stripslashes($row->nm_obat));
                  $new_row['harga']=htmlentities(stripslashes($row->hargajual));
                  $new_row['idobat'] = htmlentities(stripslashes($row->id_obat));
                  $new_row['hargabeli'] = htmlentities(stripslashes($row->hargabeli));
                  $new_row['satuan'] = htmlentities(stripslashes($row->satuank));
                  $new_row['harga_po'] = htmlentities(stripslashes($row->harga_po));
                  $row_set[] = $new_row; //build an array
              }
              echo json_encode($row_set); //format the array into json data
          } else {
              echo json_encode([]);
          }
      }

      function getDataHutang(){
          return $this->db->query("SELECT d.no_faktur, d.tgl_faktur, d.jatuh_tempo, s.company_name, SUM(p.qty_beli * p.hargabeli) AS nominal, d.status_bayar, d.created_status, d.created_status_by
                FROM `do` d
                INNER JOIN po p ON p.id_po = d.id_po
                INNER JOIN header_po h ON h.id_po = p.id_po
                INNER JOIN suppliers s ON s.person_id = h.supplier_id
                
                WHERE p.qty_beli != ''
                GROUP BY p.no_faktur");
      }
}

?>