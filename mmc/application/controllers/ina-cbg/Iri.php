<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class Iri extends Secure_area {
	public function __construct() {
			parent::__construct();
			$this->load->model('ina-cbg/M_iri','',TRUE);				
		}
	public function index()
	{
		$data['title'] = 'INA-CBG - Rawat Inap';
		$this->load->view('ina-cbg/iri',$data);
	}	

	public function get_klaim()
    {
        $list = $this->M_iri->get_klaim();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $count) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $count->no_cm;
            $row[] = $count->nama;
            $row[] = $count->no_kartu;
            $row[] = $count->no_sep;
            if (isset($count->patient_id)) {
            $row[] = '1';
            }
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->M_iri->count_all(),
                        "recordsFiltered" => $this->M_iri->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }
	public function show_pasien($no_sep='')
    {
        $pasien = $this->M_iri->show_pasien($no_sep);
        echo json_encode($pasien);
    } 
	public function show_setklaim($no_sep='')
    {
        $select = $this->M_iri->diagnosa_iri($no_sep);
        foreach ($select as $diagnosa) {
        	   $result['no_sep'] = $diagnosa->no_sep;
        	   $result['no_kartu'] = $diagnosa->no_kartu;
        	   $result['tgl_kunjungan'] = $diagnosa->tgl_kunjungan;
        	   $result['tgl_pulang'] = $diagnosa->tgl_pulang;
        	if ($diagnosa->klasifikasi_diagnos == 'utama') {
        		$result['utama'] = $diagnosa->id_diagnosa;
        	}
			if ($diagnosa->klasifikasi_diagnos == 'tambahan') {
        		$tambahan[] = $diagnosa->id_diagnosa;
        	}
        }
        $result['tambahan'] = $tambahan;
        echo json_encode($result);
    }     
	public function add_claim()
    {
    	$no_kartu = $this->input->post('no_kartu');
    	$no_sep = $this->input->post('no_sep');
    	$nomor_rm = $this->input->post('no_rm');

		$data = array(
			'metadata'=>array(
			 	'method' => 'new_claim'
			 	),		   			
			'data'=>array(
			 	'nomor_kartu' => $no_kartu,
			 	'nomor_sep' => $no_sep,
			 	'nomor_rm' => $nomor_rm,
				'nama_pasien' => $this->input->post('nama'),
			 	'tgl_lahir' => $this->input->post('tgl_lahir'),
			 	'gender' => $this->input->post('gender')		   			
			 )
		);

	 	$data_klaim=json_encode($data);
		$header = array("Content-Type: application/x-www-form-urlencoded");
		$url = "http://10.1.0.233/E-Klaim/ws.php?mode=debug";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_klaim);
		$response = curl_exec($ch);
		curl_close($ch);

		$response_array = json_decode($response);

		if ($response_array->metadata->code == '200') {
        	$data_insert = array(
        	'instalasi' => 'iri',
        	'patient_id' => $response_array->response->patient_id,
        	'admission_id' => $response_array->response->admission_id,
        	'hospital_admission_id' => $response_array->response->hospital_admission_id,
        	'no_sep' => $no_sep,
        	'no_kartu' => $no_kartu,
        	'claim_at' => date('Y-m-d H:i:s'),
        	'coder_nik' => '123123123123',

            );
            $this->M_iri->insert_klaim_iri($data_insert);
		} 

	    echo $response;
    }    

	public function update_patient()
    {
		$data_update = array(
			'metadata'=>array(
			 	'method' => 'update_patient',
			 	'nomor_rm' => $this->input->post('edit_cm')
			 	),		   			
			'data'=>array(
			 	'nomor_kartu' => $this->input->post('edit_kartu'),
			 	'nomor_rm' => $this->input->post('edit_cm'),
				'nama_pasien' => $this->input->post('edit_nama'),
			 	'tgl_lahir' => $this->input->post('edit_tgllahir'),
			 	'gender' => $this->input->post('edit_gender')		   			
			 )
		);

	 	$data_edit=json_encode($data_update);
		$header = array("Content-Type: application/x-www-form-urlencoded");
		$url = "http://10.1.0.233/E-Klaim/ws.php?mode=debug";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_edit);
		$response_edit = curl_exec($ch);
		curl_close($ch);

	    echo $response_edit;
    }      

	public function delete_patient()
    {
		$data_update = array(
			'metadata'=>array(
			 	'method' => 'delete_patient'
			 	),		   			
			'data'=>array(
			 	'nomor_rm' => $this->input->post('nomor_rm'),
			 	'coder_nik' => $this->input->post('coder_nik')		   			
			 )
		);

	 	$data_edit=json_encode($data_update);
		$header = array("Content-Type: application/x-www-form-urlencoded");
		$url = "http://10.1.0.233/E-Klaim/ws.php?mode=debug";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_edit);
		$response_edit = curl_exec($ch);
		curl_close($ch);

	    echo $response_edit;
    } 

	public function set_claim()
    {    	
		$data = array(
			'metadata'=>array(
			 	'method' => 'set_claim_data',
			 	'nomor_sep' => $this->input->post('set_nosep')
			 	),		   			
			'data'=>array(
			 	'nomor_sep' => $this->input->post('set_nosep'),
			 	'nomor_kartu' => $this->input->post('set_nokartu'),
			 	'tgl_masuk' => $this->input->post('set_tglmasuk'),
				'tgl_pulang' => $this->input->post('set_tglpulang'),
			 	'jenis_rawat' => $this->input->post('set_jnsrawat'),
			 	'kelas_rawat' => $this->input->post('set_klsrawat'),
			 	'adl_sub_acute' => $this->input->post('adl_sub_acute'),
			 	'adl_chronic' => $this->input->post('adl_chronic'),
			 	'icu_indikator' => $this->input->post('icu_indikator'),
				'icu_los' => $this->input->post('icu_los'),
			 	'ventilator_hour' => $this->input->post('ventilator_hour'),
			 	'upgrade_class_ind' => $this->input->post('upgrade_class_ind'),
			 	'upgrade_class_class' => $this->input->post('upgrade_class_class'),
			 	'upgrade_class_los' => $this->input->post('upgrade_class_los'),
			 	'add_payment_pct' => $this->input->post('add_payment_pct'),
			 	'birth_weight' => $this->input->post('birth_weight'),
			 	'discharge_status' => $this->input->post('discharge_status'),
			 	'diagnosa' => $this->input->post('diagnosa'),
			 	'procedure' => $this->input->post('procedure'),
			 	'tarif_rs' => $this->input->post('tarif_rs'),
			 	'tarif_poli_eks' => $this->input->post('tarif_poli_eks'),
			 	'nama_dokter' => $this->input->post('nama_dokter'),	
			 	'kode_tarif' => $this->input->post('kode_tarif'),		
			 	'payor_id' => $this->input->post('payor_id'),		
			 	'payor_cd' => $this->input->post('payor_cd'),		
			 	'cob_cd' => $this->input->post('cob_cd'),		
			 	'coder_nik' => $this->input->post('coder_nik')			 			   			
			 )
		);

	 	$data_klaim=json_encode($data);
		$header = array("Content-Type: application/x-www-form-urlencoded");
		$url = "http://10.1.0.233/E-Klaim/ws.php?mode=debug";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_klaim);
		$response = curl_exec($ch);
		curl_close($ch);

		$response_array = json_decode($response);

		if ($response_array->metadata->code == '200') {
        	$data_setklaim = array(
			 	'nomor_sep' => $this->input->post('set_nosep'),
			 	'nomor_kartu' => $this->input->post('set_nokartu'),
			 	'tgl_masuk' => $this->input->post('set_tglmasuk'),
				'tgl_pulang' => $this->input->post('set_tglpulang'),
			 	'jenis_rawat' => $this->input->post('set_jnsrawat'),
			 	'kelas_rawat' => $this->input->post('set_klsrawat'),
			 	'adl_sub_acute' => $this->input->post('adl_sub_acute'),
			 	'adl_chronic' => $this->input->post('adl_chronic'),
			 	'icu_indikator' => $this->input->post('icu_indikator'),
				'icu_los' => $this->input->post('icu_los'),
			 	'ventilator_hour' => $this->input->post('ventilator_hour'),
			 	'upgrade_class_ind' => $this->input->post('upgrade_class_ind'),
			 	'upgrade_class_class' => $this->input->post('upgrade_class_class'),
			 	'upgrade_class_los' => $this->input->post('upgrade_class_los'),
			 	'add_payment_pct' => $this->input->post('add_payment_pct'),
			 	'birth_weight' => $this->input->post('birth_weight'),
			 	'discharge_status' => $this->input->post('discharge_status'),
			 	'diagnosa' => $this->input->post('diagnosa'),
			 	'procedure_code' => $this->input->post('procedure'),
			 	'tarif_rs' => $this->input->post('tarif_rs'),
			 	'tarif_poli_eks' => $this->input->post('tarif_poli_eks'),
			 	'nama_dokter' => $this->input->post('nama_dokter'),	
			 	'kode_tarif' => $this->input->post('kode_tarif'),		
			 	'payor_id' => $this->input->post('payor_id'),		
			 	'payor_cd' => $this->input->post('payor_cd'),		
			 	'cob_cd' => $this->input->post('cob_cd'),		
			 	'coder_nik' => $this->input->post('coder_nik'),
			 	'setclaim_at' => date('Y-m-d H:i:s')	
            );
            $insert = $this->M_iri->setklaim_iri($data_setklaim);
			$data_setklaim = array(
        		'set_claim' => $insert
      		);	            
            $this->M_iri->update_setklaim_id($this->input->post('set_nosep'),$data_setklaim);
		} 

	    echo $response;
    }              		
}
?>
