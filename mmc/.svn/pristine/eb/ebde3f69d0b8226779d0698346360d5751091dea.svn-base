<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Diagnosa extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/Mmdiagnosa','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Diagnosa';
		$this->load->view('master/diagnosa',$data);
	}

	public function get_diagnosa()
    {
        $result = $this->Mmdiagnosa->get_diagnosa();
        $data = array();
        $no = $_POST['start'];
        foreach ($result as $count) {
            $no++;
            $row = array();
            $row[] = $no;			
            $row[] = $count->id_icd;
            $row[] = $count->nm_diagnosa;
            $row[] = $count->diagnosa_indonesia;          	          	
            $row[] = '<center><button type="button" class="btn btn-sm btn-primary text-bold" onclick="show_diagnosa('.$count->id.')"><i class="fa fa-pencil-square-o"></i> Edit</button></center>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Mmdiagnosa->count_all(),
                        "recordsFiltered" => $this->Mmdiagnosa->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

	public function edit_diagnosa(){
		$id_diagnosa=$this->input->post('id_diagnosa');
		$data = array(			
			'id_icd' => $this->input->post('edit_id_icd1'),
			'nm_diagnosa' => $this->input->post('edit_nm_diagnosa'),
			'diagnosa_indonesia' => $this->input->post('edit_diagnosa_indonesia')	   			
		);
		$result = $this->Mmdiagnosa->edit_diagnosa($id_diagnosa, $data);
		
		echo json_encode($result);
	}

	public function show_diagnosa($id_diagnosa) {
		$result = $this->Mmdiagnosa->show_diagnosa($id_diagnosa);
		echo json_encode($result);
	}

	public function insert_diagnosa()
    {
		$data = array(			
			'id_icd' => $this->input->post('add_id_icd1'),
			'nm_diagnosa' => $this->input->post('add_nm_diagnosa'),
			'diagnosa_indonesia' => $this->input->post('add_diagnosa_indonesia')		   			
		);

		$result = $this->Mmdiagnosa->insert_diagnosa($data);
		echo json_encode($result);

	}	

}