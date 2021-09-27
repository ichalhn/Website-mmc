<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Unit_kerja extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('kepegawaian/M_unitkerja','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Data Unit Kerja';

		$data['table']=$this->M_unitkerja->get_data_all();
		$this->load->view('master/mvunitkerja',$data);
	}
	
	public function list_data() {	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_unitkerja->get_data_all();
		
		foreach ($hasil as $value) {
			$row2['id_bagian'] = $value->id_bagian;
			$row2['nm_bagian'] = $value->nm_bagian;
			$row2['aksi'] = '<center>
							<button type="button" id="editBtn" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" data-id="'.$value->id_bagian.'"  data-nm="'.$value->nm_bagian.'" title="Edit"><i class="fa fa-edit"></i></button>
							<a href="#" onClick="deleteBagian(\''.$value->id_bagian.'\')" type="button" class="btn btn-primary btn-xs" title="Hapus"><i class="fa fa-trash"></i></a>
							</center>';
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}

	function is_exist(){	
		$id = $this->input->post('id');
		echo json_encode($this->M_unitkerja->checkisexist($id));
	}

	function save(){	
		if ($this->M_unitkerja->insert($this->input->post())){
			$msg = 	' <div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i>Data bagian berhasil disimpan							
				  </div>';
		}else{
			$msg = 	' <div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-ban"></i>Data bagian gagal disimpan
				  </div>';
		}
		echo json_encode(array('success'=>true,'message'=>$msg));
	}

	function delete(){	
		if ($this->M_unitkerja->delete($this->input->post('id'))){
			$msg = 	' <div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i>Data bagian berhasil dihapus							
				  </div>';
		}else{
			$msg = 	' <div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-ban"></i>Data bagian gagal dihapus
				  </div>';
		}
		echo json_encode(array('success'=>true,'message'=>$msg));
	}
	
	function edit(){	
		if ($this->M_unitkerja->update($this->input->post())){
			$msg = 	' <div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i>Perubahan data bagian berhasil disimpan							
				  </div>';
		}else{
			$msg = 	' <div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-ban"></i>Perubahan data bagian gagal disimpan
				  </div>';
		}
		echo json_encode(array('success'=>true,'message'=>$msg));
	}
}