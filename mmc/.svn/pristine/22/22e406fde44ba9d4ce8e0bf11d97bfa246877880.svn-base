<?php
   defined('BASEPATH') OR exit('No direct script access allowed');

   class Ajax extends CI_Controller {

      public function __construct() {
      	parent::__construct();
      	// if (!$this->session->has_userdata('username')) {
      		// set_status_header(401);
            // echo "Error 401: Unauthorized";
      	// }
      }

      public function data_pasien_by_medrec($no_medrec) {
         $this->load->model('pasien_irj');
         $data_pasien = $this->pasien_irj->cari_by_medrec($no_medrec);
         echo json_encode($data_pasien);
      }

      public function data_pasien_by_bpjs($no_bpjs) {
         $this->load->model('pasien_irj');
         $data_pasien = $this->pasien_irj->cari_by_bpjs($no_bpjs);
         echo json_encode($data_pasien);
      }

      public function data_pasien_by_ktp($no_ktp) {
         $this->load->model('pasien_irj');
         $data_pasien = $this->pasien_irj->cari_by_ktp($no_ktp);
         echo json_encode($data_pasien);
      }

      public function daerah_by_id_desa($id_desa) {
         $this->load->model('daerah');
         $daerah = $this->daerah->cari_by_id_desa($id_desa);
         echo json_encode($daerah);
      }

      public function daerah_by_id_kecamatan($id_kecamatan) {
         $this->load->model('daerah');
         $daerah = $this->daerah->cari_by_id_kecamatan($id_kecamatan);
         echo json_encode($daerah);
      }
      
      public function data_ppk($kd_ppk) {
         $this->load->model('ppk');
         $data_ppk = json_encode($this->ppk->get_data($kd_ppk));
         echo $data_ppk;
      }
      
      
      //Memanggil webservice buat SEP dengan parameter-parameter yang diberikan
      //method: POST
      public function check_no_medrec($no_medrec='') {
         $timezone = date_default_timezone_get();
         date_default_timezone_set('UTC');
         $timestamp = strval(time()-strtotime('1970-01-01 00:00:00')); //cari timestamp
         $signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
         $encoded_signature = base64_encode($signature);
         $http_header = array(
               'Accept: application/json', 
               'Content-type: application/xml',
               'X-cons-id: 1000', //id rumah sakit
               'X-timestamp: ' . $timestamp,
               'X-signature: ' . $encoded_signature
         );
         date_default_timezone_set($timezone);
         //nama variabel sesuai dengan nama di xml
         // $noMR = $this->input->post('no_cm');
         // $noKartu = $this->input->post('no_bpjs');
         // $noRujukan = $this->input->post('no_sjp');
         // $ppkRujukan = $this->input->post('ppk_rujukan');
         // $jnsPelayanan = $this->input->post('pelayanan');
         // $klsRawat = $this->input->post('kelas_pasien');
         // $diagAwal = $this->input->post('nm_diagnosa');
         // $poliTujuan = $this->input->post('nm_poli');
         // $catatan = $this->input->post('catatan');
         // $user = 'Administrator';
         // $ppkPelayanan = '0601R001';
         // $tglSep = date('Y-m-d H:i:s');
         // $tglRujukan = date('Y-m-d H:i:s');
         // $data = '<request><data><t_sep>'.
                        // '<noKartu>' . $noKartu . '</noKartu>'.
                        // '<tglSep>' . $tglSep . '</tglSep>'.
                        // '<tglRujukan>' . $tglRujukan . '</tglRujukan>'.
                        // '<noRujukan>' . $noRujukan . '</noRujukan>'.
                        // '<ppkRujukan>' . $ppkRujukan . '</ppkRujukan>'.
                        // '<ppkPelayanan>' . $ppkPelayanan . '</ppkPelayanan>'.
                        // '<jnsPelayanan>' . $jnsPelayanan . '</jnsPelayanan>'.
                        // '<catatan>' . $catatan . '</catatan>'.
                        // '<diagAwal>' . $diagAwal . '</diagAwal>'.
                        // '<poliTujuan>' . $poliTujuan . '</poliTujuan>'.
                        // '<klsRawat>' . $klsRawat . '</klsRawat>'.
                        // '<user>' . $user . '</user>'.
                        // '<noMR>' . $noMR . '</noMR>'.
                    // '</t_sep></data></request>';
         $ch = curl_init('http://api.asterix.co.id/SepWebRest/peserta/'.$no_medrec);
         curl_setopt($ch, CURLOPT_HTTPGET, true);
         // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $result = curl_exec($ch);//json file
         curl_close($ch);
         $sep = json_decode($result)->response;
         // print_r($sep);
			foreach ($sep as $key => $value){;
				echo "Nama: $value->nama <br/>";
				echo "NIK: $value->nik <br/>";
			};
			
			// foreach($sep->data as $mydata){
				// echo $mydata->nama . "\n";
					// foreach($mydata->values as $values){
						// echo $values->value . "\n";
					// }
			// }
      }
	public function buat_SEP($no_medrec) {
         $timezone = date_default_timezone_get();
         date_default_timezone_set('UTC');
         $timestamp = strval(time()-strtotime('1970-01-01 00:00:00')); //cari timestamp
		 //echo $timestamp."asa";
         $signature = hash_hmac('sha256', '1000' . '&' . $timestamp, '7789', true);
         $encoded_signature = base64_encode($signature);
		 //echo $encoded_signature."asa";
         $http_header = array(
               'Accept: application/json', 
               'Content-type: application/x-www-form-urlencoded',
               'X-cons-id: 1000', //id rumah sakit
               'X-timestamp: ' . $timestamp,
               'X-signature: ' . $encoded_signature
         );
         date_default_timezone_set($timezone);
         // nama variabel sesuai dengan nama di xml
         $noMR = $no_medrec;
         $noKartu = '0001662503141';
         $noRujukan = '1234590000300003';
         $ppkRujukan = '09010100';
         $jnsPelayanan = '1';
         $klsRawat = '02';
         $diagAwal = 'B010';
         $poliTujuan = 'SAR';
         $catatan = 'dari WS';
         $user = 'Administrator';
         $ppkPelayanan = '0901R001';
         $tglSep = date('Y-m-d H:i:s');
         $tglRujukan = date('Y-m-d H:i:s');
		 // echo $tglRujukan;
         $data = '<request>
 <data>
 <t_sep>
 <noKartu>0001662503141</noKartu>
 <tglSep>2016-04-13 00:00:00</tglSep>
 <tglRujukan>2016-04-13 00:00:00</tglRujukan>
 <noRujukan>Tes01</noRujukan>
 <ppkRujukan>0301U049</ppkRujukan>
 <ppkPelayanan>0301R001</ppkPelayanan>
 <jnsPelayanan>2</jnsPelayanan>
 <catatan>Coba SEP Bridging</catatan>
 <diagAwal>H52.0</diagAwal>
 <poliTujuan>MAT</poliTujuan>
 <klsRawat>3</klsRawat>
 <lakaLantas>2</lakaLantas>
 <user>viena</user>
 <noMr>121280</noMr>
 </t_sep>
 </data>
 </request>';
		// print_r($data);
         //$ch = curl_init('http://api.asterix.co.id/SepWebRest/sep/create/');
		 $ch = curl_init('http://dvlp.bpjs-kesehatan.go.id:8081/devWSLokalRest/SEP/sep');
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $result = curl_exec($ch);
         curl_close($ch);
		 echo $result; 
         $sep = json_decode($result)->response;
         echo $sep;
			// foreach ($sep as $key => $value){
				// echo "$key: $value\n";
				// echo "$key: $value->nama\n";
				// echo "$key: $value->nik\n";
			// };
			
			// foreach($sep->data as $mydata){
				// echo $mydata->nama . "\n";
					// foreach($mydata->values as $values){
						// echo $values->value . "\n";
					// }
			// }
      }

      public function new_no_medrec() {
         $this->load->model('pasien_irj');
         $medrec = $this->pasien_irj->get_new_medrec();
         echo $medrec;
      }

      public function new_no_regrj() {
         $this->load->model('r_jalan');
         $noreg = $this->r_jalan->get_new_noreg();
         echo $noreg;
      }
      
      public function new_no_ipd() {
         $this->load->model('pasien_iri');
         $noipd = $this->pasien_iri->get_new_noipd();
         echo $noipd;
      }

      public function foo() {
         echo 'FOO!';
      }

      public function bar() {
         $this->load->view('foobar');
      }
      
      public function baz() {
         $post = $this->input->post();
         var_dump($post);
      }
	  
      public function getSkin() {
        // echo "skin-purple-light";
		echo $this->config->item('skin');
      }
   }
?>
