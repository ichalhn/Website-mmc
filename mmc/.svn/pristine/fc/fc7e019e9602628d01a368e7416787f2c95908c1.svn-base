<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');

class Irj extends Secure_area {
	public function __construct() {
			parent::__construct();
			$this->load->model('ina-cbg/M_irj','',TRUE);				
		}
	public function index()
	{
		$data['title'] = 'INA-CBG - Rawat Jalan';
		$this->load->view('ina-cbg/irj',$data);
	}	

	public function get_klaim()
    {
        $list = $this->M_irj->get_klaim();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $count) {
            $no++;
            $row = array();
            $row[] = $no;
			switch ($count->id_poli) {
			    case 'BA00':
			        $row[] = 'UGD';
			        break;
			    default:
			        $row[] = 'IRJ';
			}
            $row[] = date( 'Y-m-d',strtotime($count->tgl_kunjungan));			
            $row[] = $count->no_cm;
            $row[] = $count->nama;
            $row[] = $count->no_kartu;
            $row[] = $count->no_sep;
            if (isset($count->setclaim_at)) {
				switch ($count->status) {
				    case '1':
				        $row[] = 'finalisasi';
				        break;			        
				    default:
				        $row[] = 'grouping';
				}            	          	
            $row[] = $count->id_setklaim;
            } elseif (isset($count->claim_at)) {
            	if ($count->setclaim_status == 1) {
            	$row[] = 'set_klaim';
            	} else {
            		$row[] = 'klaim';
            	}
            } else {
            	$row[] = '';
            }
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->M_irj->count_all(),
                        "recordsFiltered" => $this->M_irj->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }
	public function show_pasien($no_sep='')
    {
        $pasien = $this->M_irj->show_pasien($no_sep);
        echo json_encode($pasien);
    } 
	public function show_setklaim($no_sep='')
    {
    	$data = $this->M_irj->dataklaim_irj($no_sep);
        $select_diag = $this->M_irj->diagnosa_irj($no_sep); 
        $select_procedure = $this->M_irj->procedure_irj($no_sep); 
        $diagnosa_utama = '';
        $diagnosa_tambahan = array();
        $procedure_utama = '';
        $procedure_tambahan = array();        
        foreach ($select_diag as $diagnosa) {
        	if ($diagnosa->klasifikasi_diagnos == 'utama') {
        		$diagnosa_utama = $diagnosa->id_diagnosa;
        	}
			if ($diagnosa->klasifikasi_diagnos == 'tambahan') {
        		$diagnosa_tambahan[] = $diagnosa->id_diagnosa;
        	}
        }
        foreach ($select_procedure as $procedure) {
        	if ($procedure->klasifikasi_procedure == 'utama') {
        		$procedure_utama = $procedure->id_procedure;
        	}
			if ($procedure->klasifikasi_procedure == 'tambahan') {
        		$procedure_tambahan[] = $procedure->id_procedure;
        	}
        }        

		$result = array(
				'id_klaim' => $data->id_klaim,
			 	'no_sep' => $data->no_sep,
			 	'no_kartu' => $data->no_kartu,
			 	'tgl_kunjungan' => $data->tgl_kunjungan,
			 	'tgl_pulang' => $data->tgl_pulang,
			 	'diagnosa_utama' => $diagnosa_utama,
			 	'diagnosa_tambahan' => $diagnosa_tambahan,
			 	'procedure_utama' => $procedure_utama,
			 	'procedure_tambahan' => $procedure_tambahan
		);         
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
        	'instalasi' => 'irj',
        	'patient_id' => $response_array->response->patient_id,
        	'admission_id' => $response_array->response->admission_id,
        	'hospital_admission_id' => $response_array->response->hospital_admission_id,
        	'no_sep' => $no_sep,
        	'no_kartu' => $no_kartu,
        	'claim_at' => date('Y-m-d H:i:s'),
        	'coder_nik' => '123123123123',

            );
            $this->M_irj->insert_klaim_irj($data_insert);
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
        		'id_klaim' => $this->input->post('id_klaim'),
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
            $this->M_irj->setklaim_irj($data_setklaim);
            $this->M_irj->setklaim_status($this->input->post('id_klaim'));
		} 

	    echo $response;
    }  

	public function grouper_stage1()
    {    	
		$data = array(
			'metadata'=>array(
			 	'method' => 'grouper',
			 	'stage' => '1'
			 	),		   			
			'data'=>array(	
			 	'nomor_sep' => $this->input->post('nomor_sep')			 			   			
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
			if (isset($response_array->special_cmg_option)) {
				foreach ($response_array->special_cmg_option as $cmg_option) {
			   		$push_cmg[] = $cmg_option->code;
				}
				$special_cmg = implode('#', $push_cmg);		
				//$this->grouper_stage2($this->input->post('nomor_sep'),$this->input->post('id_setklaim'),$special_cmg);
			} else {
						$cbg_tarif = '';
						$add_payment_amt = '';
						if (isset($response_array->response->cbg->tariff)) {
							$cbg_tarif = $response_array->response->cbg->tariff;
						}
						if (isset($response_array->response->add_payment_amt)) {
							$add_payment_amt = $response_array->response->add_payment_amt;
						}			
			        	$data_grouping = array(
			        		'id_setklaim' => $this->input->post('id_setklaim'),
						 	'no_sep' => $this->input->post('nomor_sep'),
						 	'cbg_code' => $response_array->response->cbg->code,
						 	'cbg_description' => $response_array->response->cbg->description,
						 	'cbg_tarif' => $cbg_tarif,
						 	'sub_acute_code' => $response_array->response->sub_acute->code,
						 	'sub_acute_description' => $response_array->response->sub_acute->description,
						 	'sub_acute_tarif' => $response_array->response->sub_acute->tariff,
						 	'chronic_code' => $response_array->response->chronic->code,
						 	'chronic_description' => $response_array->response->chronic->description,
						 	'chronic_tarif' => $response_array->response->chronic->tariff,
						 	'kelas' => $response_array->response->kelas,
						 	'add_payment_amt' => $add_payment_amt,
						 	'inacbg_version' => $response_array->response->inacbg_version
			            );

			        	$special_cmg_option = array(
			        		'id_setklaim' => $this->input->post('id_setklaim'),
						 	'no_sep' => $this->input->post('nomor_sep'),
						 	'code' => $this->input->post('code'),
						 	'description' => $this->input->post('description'),
						 	'type' => $this->input->post('type')
			            );                       
			            $this->M_irj->data_grouping($data_grouping);
			            $this->M_irj->special_cmg_option($special_cmg_option);
			            $this->M_irj->grouping_status($this->input->post('id_setklaim'));
			            //$this->finalisasi($nomor_sep);
			}  // isset cmg_option  

		} else {
			echo $response;  			
		}   
		echo $response;  
			
    }  

	public function grouper_stage2($nomor_sep='',$id_setklaim='',$cmg_option='')
    {    	
		$data = array(
			'metadata'=>array(
			 	'method' => 'grouper',
			 	'stage' => '2'
			 	),		   			
			'data'=>array(	
			 	'nomor_sep' => $nomor_sep,
			 	'special_cmg' => $cmg_option			 			   			
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
			$add_payment_amt = '';
			if (isset($response_array->response->add_payment_amt)) {
				$add_payment_amt = $response_array->response->add_payment_amt;
			}			
            
			foreach ($response_array->response->special_cmg as $specialcmg) {
			   	$special_cmg = array(
			        'id_setklaim' => $id_setklaim,
					'no_sep' => $nomor_sep,
					'code' => $specialcmg->code,
					'description' => $specialcmg->description,
					'tarif' => $specialcmg->tariff,
					'type' => $specialcmg->type
			    ); 	
			    $this->M_irj->special_cmg($special_cmg);				
			} 
			foreach ($response_array->tarif_alt as $tarifalt) {
			   	$tarif_alt = array(
	        		'id_setklaim' => $id_setklaim,
					'no_sep' => $nomor_sep,
				 	'kelas' => $tarifalt->kelas,
				 	'tarif_inacbg' => $tarifalt->tarif_inacbg,
				 	'tarif_sp' => $tarifalt->tarif_sp,
				 	'tarif_sr' => $tarifalt->tarif_sr
			    ); 	
			    $this->M_irj->tarif_alt($tarif_alt);				
			}  			                               
            $this->M_irj->grouping_status($this->input->post('id_setklaim'));
            $this->finalisasi($nomor_sep);
		} else {
			echo $response;
		}
    }  


	public function finalisasi($nomor_sep)
    {
    	$login_data = $this->load->get_var("user_info");  
		$coder_nik = $this->M_irj->get_coder_nik($login_data->username);	
		$data = array(
			'metadata'=>array(
			 	'method' => 'claim_final'
			 	),		   			
			'data'=>array(	
			 	'nomor_sep' => $nomor_sep,
			 	'coder_nik' => $coder_nik		 			   			
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
            $this->M_irj->finalisasi_status($this->input->post('id_setklaim'));
		} 
	    echo $response;
    }                   		
}
?>
