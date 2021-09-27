<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Prosedur extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('master/Mmprosedur','',TRUE);
	}

	public function index(){
		$data['title'] = 'Master Prosedur';
		$this->load->view('master/prosedur',$data);
	}

	public function get_prosedur()
    {
        $result = $this->Mmprosedur->get_prosedur();
        $data = array();
        $no = $_POST['start'];
        foreach ($result as $count) {
            $no++;
            $row = array();
            $row[] = $no;			
            $row[] = $count->id_tind;
            $row[] = $count->nm_tindakan;          	          	
            $row[] = '<center><button type="button" class="btn btn-sm btn-primary text-bold" onclick="show_prosedur('.$count->id.')"><i class="fa fa-pencil-square-o"></i> Edit</button></center>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Mmprosedur->count_all(),
                        "recordsFiltered" => $this->Mmprosedur->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

	public function edit_prosedur(){
		$id_prosedur=$this->input->post('id_prosedur');
		$data = array(			
			'id_tind' => $this->input->post('id_tind'),
			'nm_tindakan' => $this->input->post('nm_tindakan')		   			
		);
		$result = $this->Mmprosedur->edit_prosedur($id_prosedur, $data);
		
		echo json_encode($result);
	}

	public function show_prosedur($id_prosedur) {
		$result = $this->Mmprosedur->show_prosedur($id_prosedur);
		echo json_encode($result);
	}

	public function insert_prosedur()
    {
		$data = array(			
			'id_tind' => $this->input->post('add_idtind'),
			'nm_tindakan' => $this->input->post('add_nmtindakan')		   			
		);

		$result = $this->Mmprosedur->insert_prosedur($data);
		echo json_encode($result);

	}	

}