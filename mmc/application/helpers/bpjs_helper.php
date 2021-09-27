<?php
	function bpjs_config() {		
		$CI =& get_instance();    		
		$CI->load->model('bpjs/Mbpjs','',TRUE);		
		$result = $CI->Mbpjs->get_data_bpjs();
		return $result;	
	}

	// function kartu_bpjs($no_bpjs='') {
	// 	$CI =& get_instance();    
	// 	$CI->load->model('bpjs/Mbpjs','',TRUE);		
	// 	$bpjs_config = $CI->Mbpjs->get_data_bpjs();	
	// 	$cons_id = $bpjs_config->consid;
	// 	$sec_id = $bpjs_config->secid;		
	// 	$url = $bpjs_config->service_url;									
	// 	$timestamp = time();
	// 	$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
	// 	$encoded_signature = base64_encode($signature);
	// 	$http_header = array(
	// 		'Accept: application/json', 
	// 		'Content-type: application/json',
	// 		'X-cons-id: ' . $cons_id, 
	// 		'X-timestamp: ' . $timestamp,
	// 		'X-signature: ' . $encoded_signature
	// 	);
	// 	$timezone = date_default_timezone_get();
	// 	date_default_timezone_set($timezone);
	// 	$tgl_pelayanan = date('Y-m-d');
	// 	$ch = curl_init($url.'Peserta/nokartu/'.$no_bpjs.'/'.'tglSEP/'.$tgl_pelayanan);		
	// 	curl_setopt($ch, CURLOPT_HTTPGET, true);
	// 	curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
	// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// 	$result = curl_exec($ch);
	// 	curl_close($ch);

	// 	if ($result) {
	// 		return $result;
	// 	} else {
	// 		$result_error = array(
 //        		'metaData' => array('code' => '503','message' => 'Gagal Koneksi.'),
 //        		'response' => ['peserta' => null]
 //      		);
	// 		return json_encode($result_error);
	// 	}
	// }

	// function nik($no_nik='') {
	// 	$CI =& get_instance();    
	// 	$CI->load->model('bpjs/Mbpjs','',TRUE);		
	// 	$bpjs_config = $CI->Mbpjs->get_data_bpjs();	
	// 	$cons_id = $bpjs_config->consid;
	// 	$sec_id = $bpjs_config->secid;		
	// 	$url = $bpjs_config->service_url;		
	// 	date_default_timezone_set('Asia/Jakarta');							
	// 	$timestamp = time();
	// 	$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
	// 	$encoded_signature = base64_encode($signature);
	// 	$http_header = array(
	// 		'Accept: application/json', 
	// 		'Content-type: application/json',
	// 		'X-cons-id: ' . $cons_id, 
	// 		'X-timestamp: ' . $timestamp,
	// 		'X-signature: ' . $encoded_signature
	// 	);
	// 	$timezone = date_default_timezone_get();
	// 	date_default_timezone_set($timezone);
	// 	$tgl_pelayanan = date('Y-m-d');
	// 	$ch = curl_init($url.'Peserta/nik/'.$no_nik.'/'.'tglSEP/'.$tgl_pelayanan);	
	// 	curl_setopt($ch, CURLOPT_HTTPGET, true);
	// 	curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
	// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// 	$result = curl_exec($ch);
	// 	curl_close($ch);
		
	// 	if ($result) {
	// 		return $result;
	// 	} else {
	// 		$result_error = array(
 //        		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
 //        		'response' => ['peserta' => null]
 //      		);
	// 		return json_encode($result_error);
	// 	}
	// }

	// function rujukan_pcare($no_rujukan='') {
	// 	$CI =& get_instance();    
	// 	$CI->load->model('bpjs/Mbpjs','',TRUE);		
	// 	$bpjs_config = $CI->Mbpjs->get_data_bpjs();	
	// 	$cons_id = $bpjs_config->consid;
	// 	$sec_id = $bpjs_config->secid;		
	// 	$url = $bpjs_config->service_url;									
	// 	$timestamp = time();
	// 	$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
	// 	$encoded_signature = base64_encode($signature);
	// 	$http_header = array(
	// 		'Accept: application/json', 
	// 		'Content-type: application/json',
	// 		'X-cons-id: ' . $cons_id, 
	// 		'X-timestamp: ' . $timestamp,
	// 		'X-signature: ' . $encoded_signature
	// 	);
	// 	$timezone = date_default_timezone_get();
	// 	date_default_timezone_set($timezone);
	// 	$tgl_pelayanan = date('Y-m-d');
	// 	$ch = curl_init($url.'Rujukan/'.$no_rujukan);		
	// 	curl_setopt($ch, CURLOPT_HTTPGET, true);
	// 	curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
	// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// 	$result = curl_exec($ch);
	// 	curl_close($ch);
		
	// 	if ($result) {
	// 		return $result;
	// 	} else {
	// 		$result_error = array(
 //        		'metaData' => array('code' => '503','message' => 'Gagal Koneksi.'),
 //        		'response' => ['peserta' => null]
 //      		);
	// 		return json_encode($result_error);
	// 	}
	// }

	// function rujukan_rs($no_rujukan='') {
	// 	$CI =& get_instance();    
	// 	$CI->load->model('bpjs/Mbpjs','',TRUE);		
	// 	$bpjs_config = $CI->Mbpjs->get_data_bpjs();	
	// 	$cons_id = $bpjs_config->consid;
	// 	$sec_id = $bpjs_config->secid;		
	// 	$url = $bpjs_config->service_url;									
	// 	$timestamp = time();
	// 	$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
	// 	$encoded_signature = base64_encode($signature);
	// 	$http_header = array(
	// 		'Accept: application/json', 
	// 		'Content-type: application/json',
	// 		'X-cons-id: ' . $cons_id, 
	// 		'X-timestamp: ' . $timestamp,
	// 		'X-signature: ' . $encoded_signature
	// 	);
	// 	$timezone = date_default_timezone_get();
	// 	date_default_timezone_set($timezone);
	// 	$tgl_pelayanan = date('Y-m-d');
	// 	$ch = curl_init($url.'Rujukan/RS/'.$no_rujukan);		
	// 	curl_setopt($ch, CURLOPT_HTTPGET, true);
	// 	curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
	// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// 	$result = curl_exec($ch);
	// 	curl_close($ch);
		
	// 	if ($result) {
	// 		return $result;
	// 	} else {
	// 		$result_error = array(
 //        		'metaData' => array('code' => '503','message' => 'Gagal Koneksi.'),
 //        		'response' => ['peserta' => null]
 //      		);
	// 		return json_encode($result_error);
	// 	}
	// }

	function cari_sep($no_sep='') {		
		$CI =& get_instance();    
		$CI->load->model('bpjs/Mbpjs','',TRUE);		
		$bpjs_config = $CI->Mbpjs->get_data_bpjs();				
		$cons_id = $bpjs_config->consid;
		$sec_id = $bpjs_config->secid;		
		$url = $bpjs_config->service_url;		
		date_default_timezone_set('Asia/Jakarta');							
		$timestamp = time();
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		$http_header = array(
			'Accept: application/json', 
			'Content-type: application/x-www-form-urlencoded',
			'X-cons-id: ' . $cons_id, 
			'X-timestamp: ' . $timestamp,
			'X-signature: ' . $encoded_signature
		);
		$timezone = date_default_timezone_get();
		date_default_timezone_set($timezone);
		$tgl_pelayanan = date('Y-m-d');
		$ch = curl_init($url.'SEP/'.$no_sep);	
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);

		$peserta = json_decode($result);
		if ($peserta) {
			return $result;
		} else {
			$result_error = array(
        		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
        		'response' => ['peserta' => null]
      		);
			return json_encode($result_error);
		}
	}

	// function insert_irj($no_register='') {		
	// 	$CI =& get_instance();    
	// 	$CI->load->model('bpjs/Mbpjs','',TRUE);			
	// 	$bpjs_config = $CI->Mbpjs->get_data_bpjs();	
	// 	$ppk_pelayanan = $bpjs_config->rsid;
	// 	$cons_id = $bpjs_config->consid;
	// 	$sec_id = $bpjs_config->secid;		
	// 	$url = $bpjs_config->service_url;									
	// 	$timestamp = time();
	// 	$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
	// 	$encoded_signature = base64_encode($signature);
	// 	$data_pelayanan = $CI->Mbpjs->show_pelayanan_irj($no_register);				
	// 	$data_peserta = kartu_bpjs($data_pelayanan->no_kartu); 	
	// 	$cek_peserta = json_decode($data_peserta);	

 //    	if($data_peserta == '') {			
	// 		$result_error = array(
	//         		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
	//         		'response' => ['peserta' => null]
	//       	);
	// 		return json_encode($result_error);
	// 	} else {			
	// 		if ($cek_peserta->metaData->code != '200') {
	// 			return $data_peserta;     		
	// 	 	}			
	// 	}		
       	       	     	
 //       	$login_data = $CI->load->get_var("user_info");
	// 	$xuser = $login_data->username;       	       	
 //       	if ($data_pelayanan->id_poli == 'BA00' && $data_pelayanan->alasan_berobat == 'kecelakaan') {
 //       		$laka_lantas = '1';
 //       		$lokasi_laka = $data_pelayanan->lokasi_kecelakaan;
 //       	}
 //       	else {
 //       		$laka_lantas = '0';
 //       		$lokasi_laka = '';
 //       	}

	// 	date_default_timezone_set('Asia/Jakarta');		
	// 	if ($data_pelayanan->no_telp == '' && $data_pelayanan->no_hp != '') {
	// 		$no_telp = $data_pelayanan->no_hp;
	// 	} else if ($data_pelayanan->no_telp != '' && $data_pelayanan->no_hp == '') {
	// 		$no_telp = $data_pelayanan->no_telp;
	// 	} else {
	// 		$no_telp = $data_pelayanan->no_telp;
	// 	}	
	// 	if ($data_pelayanan->catatan == '' || $data_pelayanan->catatan == NULL) {
	// 		$catatan = '';
	// 	} else $catatan = $data_pelayanan->catatan;
		
	// 	$noRujukan='0';
	// 	if ($cek_peserta->response->peserta->provUmum->kdProvider==NULL or $cek_peserta->response->peserta->provUmum->kdProvider=='') {
	// 		$ppkRujukan=$ppk_pelayanan;
	// 	} else $ppkRujukan = $cek_peserta->response->peserta->provUmum->kdProvider;

	// 	switch ($data_pelayanan->cara_kunj) {
	// 		case 'RUJUKAN RS':
	// 			$asalRujukan = '2';				
	// 			if ($data_pelayanan->no_rujukan != NULL && $data_pelayanan->no_rujukan != '') {					
	// 				$result_faskes = rujukan_rs($data_pelayanan->no_rujukan);
	// 				$get_faskes = json_decode($result_faskes);
	// 				if ($get_faskes->metaData->code == '200') {
	// 					$noRujukan=$data_pelayanan->no_rujukan;
	// 					$ppkRujukan=$get_faskes->response->rujukan->provPerujuk->kode;
	// 				}										
	// 			}
	// 			break;			
	// 		default:
	// 			$asalRujukan = '1';
	// 			if ($data_pelayanan->no_rujukan != NULL && $data_pelayanan->no_rujukan != '') {					
	// 				$result_faskes = rujukan_pcare($data_pelayanan->no_rujukan);
	// 				$get_faskes = json_decode($result_faskes);
	// 				if ($get_faskes->metaData->code == '200') {
	// 					$noRujukan=$data_pelayanan->no_rujukan;
	// 					$ppkRujukan=$get_faskes->response->rujukan->provPerujuk->kode;
	// 				}										
	// 			}
	// 			break;
	// 	}			
    	
	// 	$data = array(
	// 	   	'request'=>array(
	// 	   		't_sep'=>array(
	// 	   			'noKartu' => $data_pelayanan->no_kartu,
	// 	   			'tglSep' =>  date('Y-m-d',strtotime($data_pelayanan->tgl_kunjungan)),
	// 	   			'ppkPelayanan' => $ppk_pelayanan,
	// 	   			'jnsPelayanan' => '2',
	// 	   			'klsRawat' => '3',
 //                 	'noMR' => $data_pelayanan->no_cm,
 //                 	'rujukan' => array(
 //                 		'asalRujukan' => $asalRujukan,
 //                 		'tglRujukan' => date('Y-m-d',strtotime($data_pelayanan->tgl_kunjungan)),
 //                 		'noRujukan' => $noRujukan,
 //                 		'ppkRujukan' => $ppkRujukan
 //                 	),
 //                 	'catatan' => $data_pelayanan->catatan,
 //                 	'diagAwal' => $data_pelayanan->diagnosa,
 //                 	'poli' => array(
 //                 		'tujuan' => $data_pelayanan->poli_bpjs,
 //                 		'eksekutif' => '0'
 //                 	),
 //                 	'cob' => array(
 //                 		'cob' => '0'
 //                 	),
 //                 	'jaminan' => array(
 //                 		'lakaLantas' => $laka_lantas,
 //                 		'penjamin' => $data_pelayanan->penjamin_kecelakaan, // ?
 //                 		'lokasiLaka' => $lokasi_laka
 //                 	),
 //                 	'noTelp' => $no_telp,
 //                 	'user' => $xuser		   					   			
	// 	   		)
	// 	   	)
	// 	);
	// 	// print_r(json_encode($data));die(); 
	// 	$datasep = json_encode($data);		
	// 	$http_header = array(
	// 	   'Accept: application/json',
	// 	   'Content-type: application/x-www-form-urlencoded',
	// 	   'X-cons-id: ' . $cons_id,
	// 	   'X-timestamp: ' . $timestamp,
	// 	   'X-signature: ' . $encoded_signature
	// 	);
	// 	$timezone = date_default_timezone_get();
	// 	date_default_timezone_set($timezone);
 //        $ch = curl_init($url . 'SEP/insert');
 //        curl_setopt($ch, CURLOPT_POST, true);
 //        curl_setopt($ch, CURLOPT_POSTFIELDS, $datasep);
 //        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
 //        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 //        $result = curl_exec($ch);
 //        curl_close($ch);       

 //        if ($result == '') {
	// 		$result_error = array(
	//         		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
	//         		'response' => null
	//       	);
	// 		return json_encode($result_error);
	// 	} else {		 	
	// 		$sep = json_decode($result);
	// 		if ($sep->metaData->code == '200') {				
 //          		$data_update = array(
 //           			'no_sep' => $sep->response->sep->noSep
 //              	);
 //           		$CI->Mbpjs->update_sep_irj($no_register,$data_update);
	// 		}
	// 		return $result;
	// 	}
	// }

	function insert_iri($no_ipd='') {		
		$CI =& get_instance();    
		$CI->load->model('bpjs/Mbpjs','',TRUE);			
		$bpjs_config = $CI->Mbpjs->get_data_bpjs();	
		$ppk_pelayanan = $bpjs_config->rsid;
		$cons_id = $bpjs_config->consid;
		$sec_id = $bpjs_config->secid;		
		$url = $bpjs_config->service_url;									
		$timestamp = time();
		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
		$encoded_signature = base64_encode($signature);
		$data_pelayanan = $CI->Mbpjs->show_pelayanan_iri($no_ipd);	

		$data_peserta = kartu_bpjs($data_pelayanan->no_kartu); 	
		$cek_peserta = json_decode($data_peserta);	
		// print_r($data_peserta);die(); 

    	if ($data_peserta == '' || $data_peserta == NULL) {			
			$result_error = array(
	        		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
	        		'response' => ['peserta' => null]
	      	);			
			return json_encode($result_error);
		} else {			
			if ($cek_peserta->metaData->code != '200') {
				return $data_peserta;     		
		 	} 
		}		
       	       	     	
       	$login_data = $CI->load->get_var("user_info");
		$xuser = $login_data->username;       	       	     			

		date_default_timezone_set('Asia/Jakarta');		
		if ($data_pelayanan->no_telp == '' && $data_pelayanan->no_hp != '') {
			$no_telp = $data_pelayanan->no_hp;
		} else if ($data_pelayanan->no_telp != '' && $data_pelayanan->no_hp == '') {
			$no_telp = $data_pelayanan->no_telp;
		} else {
			$no_telp = $data_pelayanan->no_telp;
		}		

		$cob = '0';
		if($cek_peserta->response->peserta->cob->nmAsuransi != null){
			$cob = '1';
		}

		if ($data_pelayanan->catatan == '' || $data_pelayanan->catatan == NULL) {
			$catatan = '';
		} else $catatan = $data_pelayanan->catatan;
		
		$noRujukan='0';
		if ($cek_peserta->response->peserta->provUmum->kdProvider==NULL or $cek_peserta->response->peserta->provUmum->kdProvider=='') {
			$ppkRujukan=$ppk_pelayanan;
		} else $ppkRujukan = $cek_peserta->response->peserta->provUmum->kdProvider;

		switch ($data_pelayanan->id_smf) {
			case 'RUJUKAN RS':
				$asalRujukan = '2';				
				if ($data_pelayanan->nosjp != NULL && $data_pelayanan->nosjp != '') {					
					$result_faskes = rujukan_rs($data_pelayanan->nosjp);
					$get_faskes = json_decode($result_faskes);
					if ($get_faskes->metaData->code == '200') {
						$noRujukan=$data_pelayanan->nosjp;
						$ppkRujukan=$get_faskes->response->rujukan->provPerujuk->kode;
					}										
				}
				break;			
			default:
				$asalRujukan = '1';
				if ($data_pelayanan->nosjp != NULL && $data_pelayanan->nosjp != '') {					
					$result_faskes = rujukan_pcare($data_pelayanan->nosjp);
					$get_faskes = json_decode($result_faskes);
					if ($get_faskes->metaData->code == '200') {
						$noRujukan=$data_pelayanan->nosjp;
						$ppkRujukan=$get_faskes->response->rujukan->provPerujuk->kode;
					}										
				}
				break;
		}
    	
		$data = array(
		   	'request'=>array(
		   		't_sep'=>array(
		   			'noKartu' => $data_pelayanan->no_kartu,
		   			'tglSep' =>  date('Y-m-d',strtotime($data_pelayanan->tgl_masuk)),
		   			'ppkPelayanan' => $ppk_pelayanan,
		   			'jnsPelayanan' => '1',
		   			'klsRawat' => $cek_peserta->response->peserta->hakKelas->kode,
                 	'noMR' => $data_pelayanan->no_cm,
                 	'rujukan' => array(
                 		'asalRujukan' => $asalRujukan,
                 		'tglRujukan' => date('Y-m-d',strtotime($data_pelayanan->tgl_masuk)),
                 		'noRujukan' => $noRujukan,
                 		'ppkRujukan' => $ppkRujukan
                 	),
                 	'catatan' => $catatan,
                 	'diagAwal' => $data_pelayanan->diagmasuk,
                 	'poli' => array(
                 		'tujuan' => '',
                 		'eksekutif' => '0'
                 	),
                 	'cob' => array(
                 		'cob' => $cob
                 	),
                 	'jaminan' => array(
                 		'lakaLantas' => '0',
                 		'penjamin' => '0',
                 		'lokasiLaka' => ''
                 	),
                 	'noTelp' => $no_telp,
                 	'user' => $xuser		   					   			
		   		)
		   	)
		);
		// print_r(json_encode($data));die(); 
		$datasep = json_encode($data);		
		$http_header = array(
		   'Accept: application/json',
		   'Content-type: application/x-www-form-urlencoded',
		   'X-cons-id: ' . $cons_id,
		   'X-timestamp: ' . $timestamp,
		   'X-signature: ' . $encoded_signature
		);
		$timezone = date_default_timezone_get();
		date_default_timezone_set($timezone);
        $ch = curl_init($url . 'SEP/insert');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datasep);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);       

        if ($result == '') {
			$result_error = array(
	        		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
	        		'response' => null
	      	);			
			return json_encode($result_error);
		} else {		 	
			$sep = json_decode($result);
			if ($sep->metaData->code == '200') {				
          		$data_update = array(
           			'no_sep' => $sep->response->sep->noSep
              	);
           		$CI->Mbpjs->update_sep_iri($no_ipd,$data_update);
			}
			return $result;
		}
	}

	// function hapus_sep($no_sep,$jnsPelayanan) {		
	// 	$CI =& get_instance();
	// 	$bpjs_config = $CI->Mbpjs->get_data_bpjs();
	// 	$ppk_pelayanan = $bpjs_config->rsid;
	// 	$cons_id = $bpjs_config->consid;
	// 	$sec_id = $bpjs_config->secid;		
	// 	$url = $bpjs_config->service_url;					
	// 	if($no_sep==''){
	// 		$result_error = array(
 //        		'metaData' => array('code' => '402','message' => 'SEP tidak boleh kosong.'),
 //        		'response' => ['peserta' => null]
 //      		);
	// 		echo json_encode($result_error);		
	// 	}
	// 	else {			
	//         $timezone = date_default_timezone_get();
	// 		date_default_timezone_set('Asia/Jakarta');
	// 		$timestamp = time();  
	// 		$signature = hash_hmac('sha256', $cons_id . '&' . $timestamp, $sec_id, true);
	// 		$encoded_signature = base64_encode($signature);			
	// 		$http_header = array(
	// 			   'Accept: application/json',
	// 			   'Content-type: application/x-www-form-urlencoded',
	// 			   'X-cons-id: ' . $cons_id,
	// 			   'X-timestamp: ' . $timestamp,
	// 			   'X-signature: ' . $encoded_signature
	// 		);
	// 		date_default_timezone_set($timezone);
	// 		$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
	// 		$login_data = $CI->load->get_var("user_info");
	// 		$xuser = $login_data->username;
	// 	  	$data = array(
	// 	   		'request'=>array(
	// 	   		't_sep'=>array(
	// 	   			'noSep' => $no_sep,
	// 	   			'user' => $xuser
	// 	   			)
	// 	   		)
	// 	   	);
 //    	   	$datasep=json_encode($data);				
	// 		$ch = curl_init($url . 'SEP/Delete');
	// 		curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
 //            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
 //            curl_setopt($ch, CURLOPT_POSTFIELDS, $datasep);          
 //            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 //            $result = curl_exec($ch);
 //            curl_close($ch);
 //            if ($result!='') { 
	// 	    	$sep = json_decode($result);
	// 			if ($sep->metaData->code == '200') {
	// 				switch ($jnsPelayanan) {
	// 				    case '1':
	// 				        $CI->Mbpjs->hapussep_iri($no_sep);
	// 				        break;
	// 				    case '2':
	// 				        $CI->Mbpjs->hapussep_irj($no_sep);
	// 				        break;
	// 				}				
	// 			} else {

	// 			}
	// 			echo $result;	
	// 	 	} else {
	// 			$result_error = array(
 //        			'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
 //        			'response' => ['peserta' => null]
 //      			);
	// 			echo json_encode($result_error);					 			
	// 	 	}
	// 	}
	// }

	function pengajuan_irj($no_register='',$keterangan) {		
		$CI =& get_instance();    
		$CI->load->model('bpjs/Mbpjs','',TRUE);			
		$bpjs_config = $CI->Mbpjs->get_data_bpjs();
		$login_data = $CI->load->get_var("user_info");		
		$ppk_pelayanan = $bpjs_config->rsid;									
		$timestamp = time();
		$signature = hash_hmac('sha256', $bpjs_config->consid . '&' . $timestamp, $bpjs_config->secid, true);
		$encoded_signature = base64_encode($signature);
		$data_pelayanan = $CI->Mbpjs->show_pelayanan_irj($no_register);								

    	if ($data_pelayanan == '' || is_null($data_pelayanan)) {			
			$result_error = array(
	        		'metaData' => array('code' => '404','message' => 'Data pelayanan tidak ditemukan.'),
	        		'response' => ['peserta' => null]
	      	);
			return json_encode($result_error);
		}		
    	
		$data = array(
		   	'request'=>array(
		   		't_sep'=>array(
		   			'noKartu' => $data_pelayanan->no_kartu,
		   			'tglSep' =>  date('Y-m-d',strtotime($data_pelayanan->tgl_kunjungan)),		   			
		   			'jnsPelayanan' => '2',		   			
                 	'keterangan' => $keterangan,                 	
                 	'user' => $login_data->username		   					   			
		   		)
		   	)
		);
		
		$data_pengajuan = json_encode($data);		
		$http_header = array(
		   'Accept: application/json',
		   'Content-type: application/x-www-form-urlencoded',
		   'X-cons-id: ' . $bpjs_config->consid,
		   'X-timestamp: ' . $timestamp,
		   'X-signature: ' . $encoded_signature
		);
		$timezone = date_default_timezone_get();
		date_default_timezone_set($timezone);
        $ch = curl_init($bpjs_config->service_url . 'Sep/pengajuanSEP');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_pengajuan);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);       

        if ($result == '' || is_null($result)) {
			$result_error = array(
        		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
        		'response' => null
	      	);
			return json_encode($result_error);
		} else {		 	
			return $result;
		}
	}

	function approval_irj($no_register='',$keterangan) {		
		$CI =& get_instance();    
		$CI->load->model('bpjs/Mbpjs','',TRUE);			
		$bpjs_config = $CI->Mbpjs->get_data_bpjs();
		$login_data = $CI->load->get_var("user_info");		
		$ppk_pelayanan = $bpjs_config->rsid;									
		$timestamp = time();
		$signature = hash_hmac('sha256', $bpjs_config->consid . '&' . $timestamp, $bpjs_config->secid, true);
		$encoded_signature = base64_encode($signature);
		$data_pelayanan = $CI->Mbpjs->show_pelayanan_irj($no_register);								

    	if ($data_pelayanan == '' || is_null($data_pelayanan)) {			
			$result_error = array(
	        		'metaData' => array('code' => '404','message' => 'Data pelayanan tidak ditemukan.'),
	        		'response' => ['peserta' => null]
	      	);
			return json_encode($result_error);
		}		
    	
		$data = array(
		   	'request'=>array(
		   		't_sep'=>array(
		   			'noKartu' => $data_pelayanan->no_kartu,
		   			'tglSep' =>  date('Y-m-d',strtotime($data_pelayanan->tgl_kunjungan)),		   			
		   			'jnsPelayanan' => '2',		   			
                 	'keterangan' => $keterangan,                 	
                 	'user' => $login_data->username		   					   			
		   		)
		   	)
		);
		
		$data_pengajuan = json_encode($data);		
		$http_header = array(
		   'Accept: application/json',
		   'Content-type: application/x-www-form-urlencoded',
		   'X-cons-id: ' . $bpjs_config->consid,
		   'X-timestamp: ' . $timestamp,
		   'X-signature: ' . $encoded_signature
		);
		$timezone = date_default_timezone_get();
		date_default_timezone_set($timezone);
        $ch = curl_init($bpjs_config->service_url . 'Sep/aprovalSEP');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_pengajuan);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);       

        if ($result == '' || is_null($result)) {
			$result_error = array(
        		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
        		'response' => null
	      	);
			return json_encode($result_error);
		} else {		 	
			return $result;
		}
	}

	//////////////////////////////////////// Rawat Inap ////////////////////////////////////////

	function updtglplg($no_register='') {		
		$CI =& get_instance();    
		$CI->load->model('bpjs/Mbpjs','',TRUE);			
		$bpjs_config = $CI->Mbpjs->get_data_bpjs();
		$login_data = $CI->load->get_var("user_info");		
		$ppk_pelayanan = $bpjs_config->rsid;									
		$timestamp = time();
		$signature = hash_hmac('sha256', $bpjs_config->consid . '&' . $timestamp, $bpjs_config->secid, true);
		$encoded_signature = base64_encode($signature);
		$empty_pelayanan = array(
        		'metaData' => array('code' => '404','message' => 'Data pelayanan tidak ditemukan.'),
        		'response' => ['peserta' => null]
      	);
		if (substr($no_register,0,2) == 'RJ') {
			$data_pelayanan = $CI->Mbpjs->show_pelayanan_irj($no_register);
			if ($data_pelayanan == '' || is_null($data_pelayanan)) {							
				return json_encode($empty_pelayanan);
			} else $tgl_pulang = $data_pelayanan->tgl_pulang;
		} else if (substr($no_register,0,2) == 'RI') {
			$data_pelayanan = $CI->Mbpjs->show_pelayanan_iri($no_register);	
			if ($data_pelayanan == '' || is_null($data_pelayanan)) {							
				return json_encode($empty_pelayanan);
			} else $tgl_pulang = $data_pelayanan->tgl_keluar;
		} else {
			return json_encode($empty_pelayanan);
		}										
    	
		$data = array(
			'request'=>array(
				't_sep'=>array(
			   		'noSep' => $data_pelayanan->no_sep,
			   		'tglPulang' => $tgl_pulang,
			   		'user' => $login_data->username	
			   	)
			)
		);
		
		$data_pengajuan = json_encode($data);		
		$http_header = array(
		   'Accept: application/json',
		   'Content-type: application/x-www-form-urlencoded',
		   'X-cons-id: ' . $bpjs_config->consid,
		   'X-timestamp: ' . $timestamp,
		   'X-signature: ' . $encoded_signature
		);
		$timezone = date_default_timezone_get();
		date_default_timezone_set($timezone);
        $ch = curl_init($bpjs_config->service_url . 'Sep/updtglplg');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_pengajuan);        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);         

        if ($result == '' || is_null($result)) {
			$result_error = array(
        		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
        		'response' => null
	      	);
			return json_encode($result_error);
		} else {	
			$check_result = json_decode($result);
			if ($check_result->metaData->code == '200') {				
          		$data_update = array(
           			'tglplg_sep' => 1
              	);
           		$CI->Mbpjs->update_sep_irj($no_register,$data_update);
			}	 	
			return $result;
		}
	}

	function pengajuan_iri($no_ipd='',$keterangan) {		
		$CI =& get_instance();    
		$CI->load->model('bpjs/Mbpjs','',TRUE);			
		$bpjs_config = $CI->Mbpjs->get_data_bpjs();
		$login_data = $CI->load->get_var("user_info");		
		$ppk_pelayanan = $bpjs_config->rsid;									
		$timestamp = time();
		$signature = hash_hmac('sha256', $bpjs_config->consid . '&' . $timestamp, $bpjs_config->secid, true);
		$encoded_signature = base64_encode($signature);
		$data_pelayanan = $CI->Mbpjs->show_pelayanan_iri($no_ipd);								

    	if ($data_pelayanan == '' || is_null($data_pelayanan)) {			
			$result_error = array(
	        		'metaData' => array('code' => '404','message' => 'Data pelayanan tidak ditemukan.'),
	        		'response' => ['peserta' => null]
	      	);
			return json_encode($result_error);
		}		
    	
		$data = array(
		   	'request'=>array(
		   		't_sep'=>array(
		   			'noKartu' => $data_pelayanan->no_kartu,
		   			'tglSep' =>  date('Y-m-d',strtotime($data_pelayanan->tgl_masuk)),		   			
		   			'jnsPelayanan' => '1',		   			
                 	'keterangan' => $keterangan,                 	
                 	'user' => $login_data->username		   					   			
		   		)
		   	)
		);
		
		$data_pengajuan = json_encode($data);		
		$http_header = array(
		   'Accept: application/json',
		   'Content-type: application/x-www-form-urlencoded',
		   'X-cons-id: ' . $bpjs_config->consid,
		   'X-timestamp: ' . $timestamp,
		   'X-signature: ' . $encoded_signature
		);
		$timezone = date_default_timezone_get();
		date_default_timezone_set($timezone);
        $ch = curl_init($bpjs_config->service_url . 'Sep/pengajuanSEP');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_pengajuan);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);       

        if ($result == '' || is_null($result)) {
			$result_error = array(
        		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
        		'response' => null
	      	);
			return json_encode($result_error);
		} else {		 	
			return $result;
		}
	}

	function approval_iri($no_ipd='',$keterangan) {		
		$CI =& get_instance();    
		$CI->load->model('bpjs/Mbpjs','',TRUE);			
		$bpjs_config = $CI->Mbpjs->get_data_bpjs();
		$login_data = $CI->load->get_var("user_info");		
		$ppk_pelayanan = $bpjs_config->rsid;									
		$timestamp = time();
		$signature = hash_hmac('sha256', $bpjs_config->consid . '&' . $timestamp, $bpjs_config->secid, true);
		$encoded_signature = base64_encode($signature);
		$data_pelayanan = $CI->Mbpjs->show_pelayanan_iri($no_ipd);								

    	if ($data_pelayanan == '' || is_null($data_pelayanan)) {			
			$result_error = array(
	        		'metaData' => array('code' => '404','message' => 'Data pelayanan tidak ditemukan.'),
	        		'response' => ['peserta' => null]
	      	);
			return json_encode($result_error);
		}		
    	
		$data = array(
		   	'request'=>array(
		   		't_sep'=>array(
		   			'noKartu' => $data_pelayanan->no_kartu,
		   			'tglSep' =>  date('Y-m-d',strtotime($data_pelayanan->tgl_masuk)),		   			
		   			'jnsPelayanan' => '1',		   			
                 	'keterangan' => $keterangan,                 	
                 	'user' => $login_data->username		   					   			
		   		)
		   	)
		);
		
		$data_pengajuan = json_encode($data);		
		$http_header = array(
		   'Accept: application/json',
		   'Content-type: application/x-www-form-urlencoded',
		   'X-cons-id: ' . $bpjs_config->consid,
		   'X-timestamp: ' . $timestamp,
		   'X-signature: ' . $encoded_signature
		);
		$timezone = date_default_timezone_get();
		date_default_timezone_set($timezone);
        $ch = curl_init($bpjs_config->service_url . 'Sep/aprovalSEP');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_pengajuan);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);       

        if ($result == '' || is_null($result)) {
			$result_error = array(
        		'metaData' => array('code' => '503','message' => 'Koneksi Gagal'),
        		'response' => null
	      	);
			return json_encode($result_error);
		} else {		 	
			return $result;
		}
	}


?>