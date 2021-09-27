<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Secure_area.php');
include('Frmcterbilang.php');
class Frmcvalidasi extends Secure_area
{
  public function __construct(){
  parent::__construct();
  $this->load->model('logistik_farmasi/Frmmtransaksi','',TRUE);
  $this->load->model('logistik_farmasi/Frmmpemasok','',TRUE);
  $this->load->model('logistik_farmasi/Frmmvalidasi','',TRUE);
  $this->load->model('master/Mmobat','',TRUE);
  $this->load->helper('pdf_helper');
  }

  function index()
  {
    $data['title'] = 'Validasi Barang';
    $data['select_gudang'] = $this->Frmmvalidasi->get_data_gudang()->result();

    $login_data = $this->load->get_var("user_info");
    // $data['roleid'] = $this->Frmmvalidasi->get_roleid($login_data->userid)->row()->roleid;

    // if($data['roleid']=='1'){
    //   $data['data_barang'] = $this->Frmmvalidasi->getdata_gudang_inventory()->result();
    // } else {
    //   $data['role_id_gudang'] = $this->Frmmvalidasi->get_gudangid($login_data->userid)->row()->id_gudang;
    //   $data['data_barang'] = $this->Frmmvalidasi->getdata_gudang_inventory_by_role($data['role_id_gudang'])->result();
    // }

    $id_gudang = $this->Frmmvalidasi->get_gudangid($login_data->userid)->result();
    $i=1;

    foreach ($id_gudang as $row) {
      if($i==1){
        $gd = $this->Frmmvalidasi->getdata_gudang_inventory_by_role($row->id_gudang)->result();
      }else {
        $gd = array_merge($gd, $this->Frmmvalidasi->getdata_gudang_inventory_by_role($row->id_gudang)->result());
      }
    
      $i++;
    }
    $data['data_barang'] = $gd;
    
    $this->load->view('logistik_farmasi/Frmvvalidasi',$data);
  }

    public function get_data_detail_retur(){
       $id_inventory=$this->input->post('id_inventory');
       $datajson=$this->Frmmvalidasi->data_gudang($id_inventory)->result();
         echo json_encode($datajson);
    }

     public function get_data_detail_gudang(){
       $nm_gudang=$this->input->post('nm_gudang');
       $datajson=$this->Frmmvalidasi->getdata_gudang_inventory($nm_gudang)->result();
         echo json_encode($datajson);
    }


    public function insert_validasi(){
      // $id_obat = '283';
      // $data_obat=$this->Frmmdistribusi->getitem_obat($id_obat)->result();
      // foreach($data_obat as $row){
      // $data['description']=$row->nm_obat;
      //   //$data1['item_unit_price']=$row->hargabeli;
      // }
      // $data1['description']=$this->input->post('edit_description');
      $id_temporary=$this->input->post('id_temporary');
      $id_obat=$this->input->post('id_obat');
      $expire_date=$this->input->post('edit_expire');
      $qty=$this->input->post('edit_qty');
      $qty_mutasi=$this->input->post('edit_mutasi');
      $batch_no=$this->input->post('edit_batch_no');
      $id_gudang_awal=$this->input->post('hide_gudang_awal');
      $id_gudang_tujuan=$this->input->post('hide_gudang_tujuan');
      
      // Update Gudang Awal
      $id_inventory=$this->Frmmvalidasi->get_id_inventory($id_obat, $batch_no, $id_gudang_awal, $expire_date)->row()->id_inventory;
      $this->Frmmvalidasi->update_gudang_awal($id_inventory, $qty_mutasi);

      //Update/Insert Gudang Mutasi
      $data1['id_obat']=$id_obat;
      $data1['qty']=$qty_mutasi;
      $data1['expire_date']=$expire_date;
      $data1['batch_no']=$batch_no;
      $data1['id_gudang']=$id_gudang_tujuan;

      
      $cek_obat_gudang=$this->Frmmvalidasi->get_id_inventory($id_obat, $batch_no, $id_gudang_tujuan, $expire_date)->row()->id_inventory;
      if(!($cek_obat_gudang)==1){
        $this->Frmmvalidasi->insert_validasi($data1);
      } else {
        $this->Frmmvalidasi->update_selesai_distribusi($cek_obat_gudang, $data1['qty']);
      }
      $this->Frmmvalidasi->selesai_validasi($id_temporary);
      
      


      redirect('logistik_farmasi/Frmcvalidasi/index');
      // print_r($data1);
      // print_r('<br>');
      // print_r($id_gudang_awal);
      // print_r('<br>');
      // print_r($id_gudang_tujuan);
      // print_r('<br>');
      // print_r($id_inventory);
      // print_r('<br>');
      // print_r($batch_no);
    }
    
    }
?>
