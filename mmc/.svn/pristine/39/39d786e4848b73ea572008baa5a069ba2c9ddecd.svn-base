<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include(dirname(dirname(__FILE__)).'/Tglindo.php');

require_once(APPPATH.'controllers/Secure_area.php');
class Ricpasien extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('iri/rimkelas');
		$this->load->model('iri/rimpasien');
		$this->load->model('iri/rimtindakan');
		$this->load->model('iri/rimcara_bayar');
		$this->load->model('iri/rimpendaftaran');
	}

	public function get_grandtotal_all($no_ipd){


		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		
		
		//list tidakan, mutasi, dll
		$list_tindakan_pasien = $this->rimtindakan->get_list_tindakan_pasien_by_no_ipd($no_ipd);
		$list_mutasi_pasien = $this->rimpasien->get_list_ruang_mutasi_pasien($no_ipd);
		$status_paket = 0;
		$data_paket = $this->rimtindakan->get_paket_tindakan($no_ipd);
		if(($data_paket)){
			$status_paket = 1;
		}
		//print_r($list_mutasi_pasien);exit;
		$list_lab_pasien = $this->rimpasien->get_list_lab_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_radiologi = $this->rimpasien->get_list_radiologi_pasien($no_ipd,$pasien[0]['noregasal']);//belum ada no_register
		$list_resep = $this->rimpasien->get_list_resep_pasien($no_ipd,$pasien[0]['noregasal']);
		$list_tindakan_ird = $this->rimpasien->get_list_tindakan_ird_pasien($pasien[0]['noregasal']);
		$poli_irj = $this->rimpasien->get_list_poli_rj_pasien($pasien[0]['noregasal']);


		$grand_total = 0;
		$subsidi_total = 0;
		//mutasi ruangan pasien
		if(($list_mutasi_pasien)){
			$result = $this->string_table_mutasi_ruangan_simple($list_mutasi_pasien,$pasien,$status_paket);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
		}

		//tindakan
		if(($list_tindakan_pasien)){
			$result = $this->string_table_tindakan_simple($list_tindakan_pasien);
			$grand_total = $grand_total + $result['subtotal'];
			$subsidi = $result['subsidi'];
			$subsidi_total = $subsidi_total + $subsidi;
		}

		//radiologi
		if(($list_radiologi)){
			$result = $this->string_table_radiologi_simple($list_radiologi);
			$grand_total = $grand_total + $result['subtotal'];
			
		}

		//lab
		if(($list_lab_pasien)){
			$result = $this->string_table_lab_simple($list_lab_pasien);
			$grand_total = $grand_total + $result['subtotal'];
		}

		//resep
		if(($list_resep)){
			$result = $this->string_table_resep_simple($list_resep);
			$grand_total = $grand_total + $result['subtotal'];
		}

		//ird
		if(($list_tindakan_ird)){
			$result = $this->string_table_ird_simple($list_tindakan_ird);
			$grand_total = $grand_total + $result['subtotal'];
			
		}

		//irj
		if(($poli_irj) && $pasien[0]['carabayar']!='UMUM'){
			$result = $this->string_table_irj_simple($poli_irj);
			$grand_total = $grand_total + $result['subtotal'];
			
		}

		return $grand_total;
	}

		//modul cetak laporan simple

	private function string_table_mutasi_ruangan_simple($list_mutasi_pasien,$pasien,$status_paket){
		$konten = "";
		$konten= $konten.'
			<tr>
			  <td align="center" >Ruang</td>
			  <td align="center">Kelas</td>
			  <td align="center">Bed</td>
			  <td align="center">Tgl Masuk</td>
			  <td align="center">Tgl Keluar</td>
			  <td align="center">Lama Inap</td>
			  <td align="center">Total Biaya</td>
			</tr>
		';
		$subtotal = 0;
		$diff = 1;
		$lama_inap = 0;
		$total_subsidi = 0;
		$tgl_indo = new Tglindo();

		foreach ($list_mutasi_pasien as $r) {

			$bulan_show = $tgl_indo->bulan(substr($r['tglmasukrg'],6,2));
			$tahun_show = substr($r['tglmasukrg'],0,4);
			$tanggal_show = substr($r['tglmasukrg'],8,2);
			$tgl_masuk_rg = $tanggal_show." ".$bulan_show." ".$tahun_show;

			//$tgl_masuk_rg = date("j F Y", strtotime($r['tglmasukrg']));
			if($r['tglkeluarrg'] != null){
				//$tgl_keluar_rg =  date("j F Y", strtotime($r['tglkeluarrg'])) ;

				$bulan_show = $tgl_indo->bulan(substr($r['tglkeluarrg'],6,2));
				$tahun_show = substr($r['tglkeluarrg'],0,4);
				$tanggal_show = substr($r['tglkeluarrg'],8,2);
				$tgl_keluar_rg = $tanggal_show." ".$bulan_show." ".$tahun_show;

			}else{
				if($pasien[0]['tgl_keluar'] != null){
					//$tgl_keluar_rg = date("j F Y", strtotime($pasien[0]['tgl_keluar'])) ;

					$bulan_show = $tgl_indo->bulan(substr($pasien[0]['tgl_keluar'],6,2));
					$tahun_show = substr($pasien[0]['tgl_keluar'],0,4);
					$tanggal_show = substr($pasien[0]['tgl_keluar'],8,2);
					$tgl_keluar_rg = $tanggal_show." ".$bulan_show." ".$tahun_show;

				}else{
					$tgl_keluar_rg = "-" ;
				}	
			}

			if($r['tglkeluarrg'] != null){
				$start = new DateTime($r['tglmasukrg']);//start
				$end = new DateTime($r['tglkeluarrg']);//end

				$diff = $end->diff($start)->format("%a");
				if($diff == 0){
					$diff = 1;
				}
				$selisih_hari =  $diff." Hari"; 
			}else{
				if($pasien[0]['tgl_keluar'] != NULL){
					$start = new DateTime($r['tglmasukrg']);//start
					$end = new DateTime($pasien[0]['tgl_keluar']);//end

					$diff = $end->diff($start)->format("%a");
					if($diff == 0){
						$diff = 1;
					}
					$selisih_hari =  $diff." Hari";
				}else{
					$start = new DateTime($r['tglmasukrg']);//start
					$end = new DateTime(date("Y-m-d"));//end

					$diff = $end->diff($start)->format("%a");
					if($diff == 0){
						$diff = 1;
					}

					$selisih_hari =  "- Hari";
				}
			}

			//untuk perhitungan subsidi, berdasarkan lama inap
			$lama_inap = $lama_inap + $diff;

			//ambil harga jatah kelas
			// $kelas = $this->rimkelas->get_tarif_ruangan($pasien[0]['jatahklsiri'],$r['idrg']);
			// if(!($kelas)){
			// 	$total_tarif = 0;
			// }else{
			// 	$total_tarif = $kelas[0]['total_tarif'] ;
			// }\
			$total_tarif = $r['harga_jatah_kelas'] ;

			$subsidi_inap_kelas = $diff * $total_tarif ;//harga permalemnya berapa kalo ada jatah kelas
			$total_subsidi = $total_subsidi + $subsidi_inap_kelas;

			//kalo paket 2 hari inep free
			if($status_paket == 1){
				$temp_diff = $diff - 2;//kalo ada paket free 2 hari
				if($temp_diff < 0){
					$temp_diff = 0;
				}
				$total_per_kamar = $r['vtot'] * $temp_diff;
			}else{
				$total_per_kamar = $r['vtot'] * $diff;
			}

			$subtotal = $subtotal + $total_per_kamar;
			$konten = $konten. "
			<tr>
				<td align=\"center\">".$r['nmruang']."</td>
				<td align=\"center\">".$r['kelas']."</td>
				<td align=\"center\">".$r['bed']."</td>
				<td align=\"center\">".$tgl_masuk_rg."</td>
				<td align=\"center\">".$tgl_keluar_rg."</td>
				<td align=\"center\">".$selisih_hari."</td>
				<td align=\"right\">Rp. ".number_format($total_per_kamar,0)."</td>
			</tr>
			";
		}

		$result = array('konten' => $konten,
					'subtotal' => $subtotal,
					'subsidi' => $total_subsidi);
		return $result;
	}

	private function string_table_tindakan_simple($list_tindakan_pasien){
		$konten = "";
		
		$subtotal = 0;

		$subtotal_jth_kelas = 0;
		foreach ($list_tindakan_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'] + $r['tarifalkes'];
			$tumuminap = number_format($r['tumuminap'],0);
			$vtot = number_format($r['vtot'],0);

			$subtotal_jth_kelas = $subtotal_jth_kelas + $r['vtot_jatah_kelas'];
			$harga_satuan_jatah_kelas = number_format($r['harga_satuan_jatah_kelas'],0);
			$vtot_jatah_kelas = number_format($r['vtot_jatah_kelas'],0);
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" >Subtotal Tindakan Rawat Inap</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		$result = array('konten' => $konten,
					'subtotal' => $subtotal,
					'subsidi' => $subtotal_jth_kelas);
		return $result;
	}

	private function string_table_radiologi_simple($list_radiologi){
		$konten = "";
		$subtotal = 0;
		foreach ($list_radiologi as $r) {
			$subtotal = $subtotal + $r['vtot'];
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" align="left">Subtotal Radiologi</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_lab_simple($list_lab_pasien){
		$konten = "";
		$subtotal = 0;
		foreach ($list_lab_pasien as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_lab = number_format($r['biaya_lab'],0);
			$vtot = number_format($r['vtot'],0);
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" align="left">Subtotal Laboratorium</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
	
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_resep_simple($list_resep){
		$konten = "";
		
		$subtotal = 0;
		foreach ($list_resep as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$vtot = number_format($r['vtot'],0) ;
			
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" align="left">Subtotal Obat</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_ird_simple($list_tindakan_ird){
		$konten = "";
		
		$subtotal = 0;
		foreach ($list_tindakan_ird as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_ird = number_format($r['biaya_ird'],0);
			$vtot = number_format($r['vtot'],0);
			
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" align="left">Subtotal Rawat Darurat</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';
		
		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}

	private function string_table_irj_simple($poli_irj){
		$konten = "";
		
		$subtotal = 0;
		foreach ($poli_irj as $r) {
			$subtotal = $subtotal + $r['vtot'];
			$biaya_tindakan = number_format($r['biaya_tindakan'],0);
			$vtot = number_format($r['vtot'],0);
			
		}
		$konten = $konten.'
				<tr>
					<td colspan="6" >Subtotal Rawat Jalan</td>
					<td align="right">Rp. '.number_format($subtotal,0).'</td>
				</tr>
				';

		$result = array('konten' => $konten,
					'subtotal' => $subtotal);
		return $result;
	}
	//end modul cetak laporan simple

	public function index(){
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='';
		$data['pasien']='active';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		//bikin object buat penanggalan
		$data['controller']=$this;
		
		//$data['list_pasien'] = $this->rimpasien->select_pasien_iri_all();

		$data['list_pasien'] = $this->rimpasien->select_pasien_iri_user($this->session->userdata('userid'));
		$data['akses']= $this->rimpasien->select_ruang_user($this->session->userdata('userid'))->akses_ruang;
		/*if($temp!=null){
			foreach ($temp as $r) {
				if($r['no_ipd'] != ""){
				//get total selamaa di ruangan
				//$grand_total = 0;
				//$grand_total = $this->get_grandtotal_all($r['no_ipd']);

				//get status bayi
				$bayi = $this->rimpasien->get_bayi_by_ipd_ibu($r['no_ipd']);
				$status_bayi = 0;
				if(($bayi)){
					$status_bayi = 1;
				}

				$data_pasien[] = array('no_ipd' => $r['no_ipd'], 
					'no_cm' => $r['no_cm'],
					'nama' => $r['nama'],
				'nmruang' => $r['nmruang'],
				'kelas' => $r['kelas'],
				'bed' => $r['bed'],
				'dokter' => $r['dokter'],
				'tglmasukrg' => $r['tglmasukrg'],
				//'status_bayi' => $status_bayi,
				//'grand_total' => $grand_total,
				'cara_bayar' => $r['carabayar'],
				'nmkontraktor' => $r['nmkontraktor']);
				}
			}
		}else $data_pasien='';
		$data['list_pasien'] ='';
		if($data_pasien!=''){
		$data['list_pasien'] = $data_pasien;
		}*/

		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->rimpasien->get_roleid($login_data->userid)->row()->roleid;

		//print_r($data['list_pasien']);exit;
		//$this->load->view('iri/rivlink');
		//$this->load->view('iri/rivheader');
		//$this->load->view('iri/rivmenu', $data);
		//$this->load->view('iri/rivpasien');
		$this->load->view('iri/list_pasien',$data);
		//$this->load->view('iri/rivfooter');
	}
	public function get_pasien_iri(){
		$result=$this->rimpasien->select_pasien_iri_all();
		$totalDataQuery=count($result);
		
		if($totalDataQuery==0){
			$data=Array();
		}
		
		for($i=0;$i<$totalDataQuery;$i++){
			$data[$i]['0']=$result[$i]['tgl_masuk']; // Tanggal Masuk
			$data[$i]['1']=$result[$i]['no_ipd']; // No. Register
			$data[$i]['2']=$result[$i]['nama']; // Nama
			$data[$i]['3']=$result[$i]['kelas']; // Kelas
			$data[$i]['4']=$result[$i]['bed']; // No. Bed
			$data[$i]['5']='-'; // Penjamin
			$data[$i]['6']='-'; // Dokter Yang Merawat
			$data[$i]['7']='-'; // LOS
			$data[$i]['8']='-'; // Total Biaya
		}
		
		$json_data=array(
			"data"=>$data // total data array
		);
		echo json_encode($json_data); // send data as json format
	}

	//keperluan tanggal
	public function obj_tanggal(){
		 $tgl_indo = new Tglindo();
		 return $tgl_indo;
	}

	//kamari
	public function data_pasien_auto() {
		

		// 1. Folder - 2. Nama controller - 3. nama fungsinya - 4. formnya
		$keyword = $this->uri->segment(4);
		$data = $this->rimpasien->select_pasien_like($keyword);
		foreach($data as $row){
			//$coba=strtotime($row['tgl_lahir']);
			//$date=date('d/m/Y', $coba);
			
			$arr['query'] = $keyword;
			$arr['suggestions'][] 	= array(
				'value'				=>$row['no_ipd'].' - '.$row['nama'],
				'no_ipd'			=>$row['no_ipd'],
				'nama'				=>$row['nama']
			);
		}
		echo json_encode($arr);
    }

    public function ubah_cara_bayar($no_ipd){
    	$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='';
		$data['pasien']='active';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
    	//data pasien
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($no_ipd);
		$data['data_pasien'] = $pasien;
		$grand_total = $this->get_grandtotal_all($no_ipd);
		$data['grand_total'] = $grand_total;

		//cara bayar
		$data['cara_bayar']=$this->rimcara_bayar->get_all_cara_bayar();
		
		//get data ppk
		$data['ppk']=$this->rimpendaftaran->get_all_ppk();

		//print_r($data['data_pasien']);exit();
		
		$this->load->view('iri/ubah_cara_bayar',$data);
    }

    public function update_cara_bayar(){
    	$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='';
		$data['pasien']='active';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';
    	
    	$data_pendaftaran['no_ipd']=$this->input->post('noregasal_hidden');
		$pasien = $this->rimtindakan->get_pasien_by_no_ipd($data_pendaftaran['no_ipd']);

    	//get post
    	$data_pendaftaran['carabayar']=$this->input->post('carabayar');

    	if($data_pendaftaran['carabayar']!='UMUM'){		
			$data_pendaftaran['id_kontraktor'] = $this->input->post('id_kontraktor');
		}else{
			$data_pendaftaran['id_kontraktor'] = '';
		}
    	$data_pendaftaran['nosjp']=$this->input->post('nosjp');
    	$data_pendaftaran['diagmasuk']=$this->input->post('diagnosa_id');
    	//$data_pendaftaran['kd_ppk']=$this->input->post('kd_ppk');
    	$data_pendaftaran['no_sep']=$this->input->post('no_sep_hidden');

    	$data_pasien['no_kartu']=$this->input->post('no_bpjs');
    	//print_r($data_pendaftaran);exit();

    	//update ke pasien iri
    	$this->rimpendaftaran->update_pendaftaran_mutasi($data_pendaftaran,$data_pendaftaran['no_ipd']);

    	//updae ke data pasien
		$this->rimpendaftaran->update_data_pasien($data_pasien,$pasien[0]['no_medrec']);

		redirect('iri/rictindakan/index/'.$this->input->post('noregasal_hidden'));
		//$this->load->view('iri/ubah_cara_bayar',$data);
    }

    public function list_pasien_pulang(){
		$data['title'] = '';
		$data['reservasi']='';
		$data['daftar']='';
		$data['pasien']='active';
		$data['mutasi']='';
		$data['status']='';
		$data['resume']='';
		$data['kontrol']='';

		//bikin object buat penanggalan
		$data['controller']=$this;
		
		//$data['list_pasien'] = $this->rimpasien->select_pasien_iri_all();

		$temp = $this->rimpasien->select_pasien_iri_pulang_bpjs();
		

		foreach ($temp as $r) {
			if($r['no_ipd'] != ""){
			//get total selamaa di ruangan
			$grand_total = 0;
			$grand_total = $this->get_grandtotal_all($r['no_ipd']);

			//get status bayi
			$bayi = $this->rimpasien->get_bayi_by_ipd_ibu($r['no_ipd']);
			$status_bayi = 0;
			if(($bayi)){
				$status_bayi = 1;
			}

			$data_pasien[] = array('no_ipd' => $r['no_ipd'], 
				'no_cm' => $r['no_cm'],
				'nama' => $r['nama'],
			'nmruang' => $r['nmruang'],
			'kelas' => $r['kelas'],
			'bed' => $r['bed'],
			'dokter' => $r['dokter'],
			'tglmasukrg' => $r['tglmasukrg'],
			'status_bayi' => $status_bayi,
			'grand_total' => $grand_total,
			'cara_bayar' => $r['carabayar']);
			}
		}
		$data['list_pasien'] = $data_pasien;

		//print_r($data['list_pasien']);exit;
		$this->load->view('iri/rivlink');
		//$this->load->view('iri/rivheader');
		//$this->load->view('iri/rivmenu', $data);
		//$this->load->view('iri/rivpasien');
		$this->load->view('iri/list_pasien_pulang_bpjs',$data);
		//$this->load->view('iri/rivfooter');
	}

	public function get_data_edit_ruangan(){
		$no_ipd=$this->input->post('no_ipd');
		$ruang=$this->rimpasien->get_data_ruangan($no_ipd)->result();
		$kelas = $this->rimpasien->get_all_kelas_with_empty_bed();

		$datajson = array('response' => $ruang, 'options' => $kelas);

		// $data['status_bed'] = $this->rimkelas->get_status_bed($irna_antrian[0]['kelas'],$irna_antrian[0]['idrg']);

		// $data['empty_bed'] = $this->rimkelas->get_all_empty_bed_by_kelas_and_ruang($irna_antrian[0]['kelas'],$irna_antrian[0]['idrg']);

	    echo json_encode($datajson);
	}

	public function get_empty_bed_select(){
		$temp = $this->input->post('val');
		$temp = explode("-", $temp);
		$kelas = $this->rimkelas->get_all_empty_bed_by_kelas_and_ruang($temp[2],$temp[0]);
		$string_option = "";
		foreach ($kelas as $r) {
			$string_option = $string_option.'<option value="'.$r['bed'].' ">'.$r['bed'].'</option>';
		}
		echo $string_option;
	}

	public function edit_ruangan(){
		$idrgiri = $this->input->post('idrgiri');
		$no_ipd = $this->input->post('no_ipd');

		$cek = $this->rimpasien->count_tindakan($no_ipd)->row()->total;
		if((int)$cek>0){
			$data1 = array('sukses' => false);
		}else{
			$data['bed'] = $this->input->post('bed');
			$data1['bed'] = $this->input->post('bed');

			$bed_explode = explode(" ", $data['bed']);
			$data['idrg'] = $bed_explode[0];
			$data1['idrg'] = $bed_explode[0];

			if($bed_explode[1]=='10'){
				$data['kelas'] = 'I';
				$data1['klsiri'] = 'I';
			}else if($bed_explode[1]=='20'){
				$data['kelas'] = 'II';
				$data1['klsiri'] = 'II';
			}else if($bed_explode[1]=='UT'){
				$data['kelas'] = 'UTAMA';
				$data1['klsiri'] = 'UTAMA';
			}else if($bed_explode[1]=='VP'){
				$data['kelas'] = 'VIP';
				$data1['klsiri'] = 'VIP';
			}else if($bed_explode[1]=='VV'){
				$data['kelas'] = 'VVIP';
				$data1['klsiri'] = 'VVIP';
			}else {
				$data['kelas'] = 'III';
				$data1['klsiri'] = 'III';
			}
			$id_tindakan = '1A'.$data['idrg'];
			
			$data['vtot'] = $this->rimpasien->get_vtot_ruangan($id_tindakan,$data['kelas'])->row()->vtot;

	    	//update bed
	    	$bed_asal = $this->input->post('bed_asal');;
	    	$bed_baru = $data['bed'];
			
			$this->rimpasien->update_bed($bed_asal,$bed_baru);
			$this->rimpasien->update_ruangan_ruangiri($data,$idrgiri);
			$this->rimpasien->update_ruangan_pasieniri($data1,$no_ipd);

			$data1 = array('sukses' => true);
		}
		


		//update ruangan raung_iri
		echo json_encode($data1);
		// redirect('master/mctindakan');
		// print_r(json_encode($data));
	}
}
