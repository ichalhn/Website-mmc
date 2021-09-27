<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Jabatan extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('kepegawaian/M_jabatan','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Data Jabatan';

		$data['table']=$this->M_jabatan->get_data_all();
		$this->load->view('master/mvjabatan',$data);
	}
	
	public function list_data() {	
		$line  = array();
		$line2 = array();
		$row2  = array();
		
		$hasil = $this->M_jabatan->get_data_all();
		
		foreach ($hasil as $value) {
			$row2['id_jabatan'] = $value->id_jabatan;
			$row2['nm_jabatan'] = $value->nm_jabatan;
			$row2['aksi'] = '<center>
							<button type="button" id="editBtn" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" data-id="'.$value->id_jabatan.'"  data-nm="'.$value->nm_jabatan.'" title="Edit"><i class="fa fa-edit"></i></button>
							<a href="#" onClick="deletejabatan(\''.$value->id_jabatan.'\')" type="button" class="btn btn-primary btn-xs" title="Hapus"><i class="fa fa-trash"></i></a>
							</center>';
						
			$line2[] = $row2;
		}
				
		$line['data'] = $line2;
					
		echo json_encode($line);
	}

	function is_exist(){	
		$id = $this->input->post('id');
		echo json_encode($this->M_jabatan->checkisexist($id));
	}

	function save(){	
		if ($this->M_jabatan->insert($this->input->post())){
			$msg = 	' <div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i>Data jabatan berhasil disimpan							
				  </div>';
		}else{
			$msg = 	' <div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-ban"></i>Data jabatan gagal disimpan
				  </div>';
		}
		echo json_encode(array('success'=>true,'message'=>$msg));
	}

	function delete(){	
		if ($this->M_jabatan->delete($this->input->post('id'))){
			$msg = 	' <div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i>Data jabatan berhasil dihapus							
				  </div>';
		}else{
			$msg = 	' <div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-ban"></i>Data jabatan gagal dihapus
				  </div>';
		}
		echo json_encode(array('success'=>true,'message'=>$msg));
	}
	
	function edit(){	
		if ($this->M_jabatan->update($this->input->post())){
			$msg = 	' <div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-check"></i>Perubahan data jabatan berhasil disimpan							
				  </div>';
		}else{
			$msg = 	' <div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="icon fa fa-ban"></i>Perubahan data jabatan gagal disimpan
				  </div>';
		}
		echo json_encode(array('success'=>true,'message'=>$msg));
	}
}