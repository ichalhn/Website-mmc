<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'controllers/Secure_area.php');
class Frmcdaftar extends Secure_area {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('farmasi/Frmmdaftar','',TRUE);
		$this->load->model('farmasi/Frmmkwitansi','',TRUE);
		$this->load->model('logistik_farmasi/Frmmpo','',TRUE);
        $this->load->library('session');
	}

	public function index(){
		$data['title'] = 'Daftar Resep Pasien';
		$date=$this->input->post('tgl');
		if($date==''){
			$date=date('Y-m-d');
		}
		$data['farmasi']=$this->Frmmdaftar->get_daftar_resep_pasien($date)->result();
		$this->load->view('farmasi/frmvdaftarpasien', $data);
	}

	public function list_pengambilan(){
		$data['title'] = 'Daftar Pengambilan Resep Pasien';
		$data['farmasi']=$this->Frmmdaftar->get_pengambilan_resep_pasien()->result();
		$this->load->view('farmasi/frmvpengambilanpasien', $data);
	}

	public function permintaan_obat($no_register='',$tab =''){
		$data['title'] = 'Input Permintaan Obat';
		$data['no_resep'] = '';
		$data['no_register']=$no_register;

		if(substr($no_register, 0,2)=="PL"){
		$data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
		$data['nmdokter']=$this->Frmmdaftar->getnama_dokter_poli($no_register)->row()->nmdokter;
		$data['data_pasien_resep']=$this->Frmmdaftar->get_data_pasien_luar($no_register)->result();
		foreach($data['data_pasien_resep'] as $row){
			$data['nama']=$row->nama;
			$data['kelas_pasien']=$row->kelas;
			$data['no_medrec']=$row->no_medrec;
			$data['no_cm']='-';
			$data['tgl_kun']=$row->tgl_kunjungan;
			$data['cara_bayar']=$row->cara_bayar;
			$data['idrg']=$row->idrg;
			$data['bed']=$row->bed;
			}
		}else{
			$data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
			$data['nmdokter']=$this->Frmmdaftar->getnama_dokter_poli($no_register)->row()->nmdokter;
			$data['data_pasien_resep']=$this->Frmmdaftar->get_data_pasien_resep($no_register)->result();
			foreach($data['data_pasien_resep'] as $row){
				$data['nama']=$row->nama;
				$data['no_medrec']=$row->no_medrec;
				$data['no_cm']=$row->no_cm;
				$data['kelas_pasien']=$row->kelas;
				$data['tgl_kun']=$row->tgl_kunjungan;
				$data['idrg']=$row->idrg;
				$data['bed']=$row->bed;
				$data['cara_bayar']=$row->cara_bayar;
				$data['foto']=$row->foto;
		
			}
			if (substr($no_register, 0,2)=="RD"){
				$data['bed']='Rawat Darurat';
			}
		}

		$data['get_data_markup']=$this->Frmmdaftar->get_data_markup()->result();
		foreach ($data['get_data_markup'] as $row) {
			if($row->id_kebijakan=="MU001"){
				$data['fmarkup']=$row->nilai;
			}
			else if($row->id_kebijakan=="PN001"){
				$data['ppn']=$row->nilai;
			}
			else if($row->id_kebijakan=="TS001"){
				if($data['cara_bayar']=="BPJS"){
					$data['tuslah_racik']= '0';
				}else{
				$data['tuslah_racik']=$row->nilai;
				}
			}else if($row->id_kebijakan=="TS002"){
				if($data['cara_bayar']=="BPJS"){
					$data['tuslah_non']= '0';
				}else{
				$data['tuslah_non']=$row->nilai;
				}
			}
		}
		

		$data['tab_obat'] = 'active';
		$data['tab_racik']  = '';
		if($tab!=''){
			$data['tab_obat'] = '';
			$data['tab_racik'] = 'active';
		}
	

		//$data['tgl_kunjungan']=$this->Frmmdaftar->get_data_pasien_resep($tgl_kunjungan)->result();

		$data['data_tindakan_pasien']=$this->Frmmdaftar->getdata_resep_pasien($no_register)->result();
		$data['data_tindakan_racik']=$this->Frmmdaftar->getdata_resep_racik($no_register)->result(); //list obat racikan
		$data['data_tindakan_racikan']=$this->Frmmdaftar->getdata_resep_racikan($no_register)->result();

		//get obat from role id
	    $login_data = $this->load->get_var("user_info");
	    $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

	    $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
	    $i=1;

	    // foreach ($id_gudang as $row) {
	    //   if($i==1){
	    //     $gd = $this->Frmmdaftar->get_data_resep_by_role($row->id_gudang)->result();
	    //   }else {
	    //     $gd = array_merge($gd, $this->Frmmdaftar->get_data_resep_by_role($row->id_gudang)->result());
	    //   }
	    
	    //   $i++;
	    // }
	    // $data['data_obat'] = $gd;
		// $data['data_obat']=$this->Frmmdaftar->get_data_resep()->result();

		$data['nmkontraktor']=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
		$data['nmdokter']=$this->Frmmdaftar->getnama_dokter_poli($no_register)->row()->nmdokter;
		//$data['tindakan']=$this->Frmmdaftar->getdata_tindakan_pasien($no_register)->result();
		$data['dokter']=$this->Frmmdaftar->getdata_dokter()->result();
		//$data['cara_bayar']=$this->Frmmdaftar->getdata_cara()->result();
		$data['no_rsp']=$this->Frmmdaftar->get_no_resep($no_register)->result();
        $data['margin'] = $this->Frmmdaftar->get_margin_obat($data['cara_bayar'])->result();
		$login_data = $this->load->get_var("user_info");
		$data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

		$userid = $this->session->userid;
	    $group = $this->Frmmpo->getIdGudang($userid);
	    $data['id_gudang'] = $group->id_gudang;
       
		$this->load->view('farmasi/frmvpermintaan',$data);
	}

    public function cek_stok()
	{
		$i=1;
		$no_register=$this->input->post('no_register');
		$idrg=$this->input->post('idrg');		
		$bed=$this->input->post('bed');
		$kelas=$this->input->post('kelas_pasien');
		$nm_dokter=$this->input->post('nm_dokter');
		$qty_obat=$this->Frmmdaftar->cek_qty_obat($no_register)->result();
		foreach($qty_obat as $row){
	        if($i==1){
	        	$stok_obat=$this->Frmmdaftar->cek_stok_obat($row->id_inventory, $row->qty)->result();
	      	}else {
	        	$stok_obat = array_merge($stok_obat, $this->Frmmdaftar->cek_stok_obat($row->id_inventory, $row->qty)->result());
	      	}
	        $i++;
		}
		//---------Sementara diBebaskan Dulu Transaksi------

		if(empty($qty_obat)){//JIKA TIDAK ADA DATA
			//$data = array('status' => 'kosong');
			$data = array('status' => 'success');

			echo json_encode($data);
		} /*else if($stok_obat!=null){
			$nm_obat="";
			$i=1;
			foreach($stok_obat as $row){
				if($i==1){
		        	$nm_obat=$row->nama_obat;
		      	}else {
					$nm_obat=$nm_obat.', '.$row->nama_obat;
		      	}
		        $i++;
			}
			//$data = array('status' => $nm_obat);
			$data = array('status' => 'success');
			echo json_encode($data);

		}*/ else {
			//UPDATE STOK
			foreach($qty_obat as $row){
				$this->Frmmdaftar->update_stok_obat($row->id_inventory, $row->qty);
			}
			//SELESAI RESEP

			$getvtotobat=$this->Frmmdaftar->get_vtot_obat($no_register)->row()->vtot_obat;
			$getrdrj=substr($no_register, 0,2);

			// $this->Frmmdaftar->update_data_header($data['no_resep'], $nm_dokter);
			$this->Frmmdaftar->insert_data_header($no_register,$idrg,$bed,$kelas);
			$no_resep=$this->Frmmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row()->no_resep;

			if($getrdrj=="PL"){
				$this->Frmmdaftar->selesai_daftar_pemeriksaan_PL($no_register,$getvtotobat,$no_resep);
			}
			else if($getrdrj=="RJ"){
				$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotobat,$no_resep);
			}
			/*else if ($getrdrj=="RD"){
				$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRD($no_register,$getvtotobat,$no_resep);
			}
			*/else if ($getrdrj=="RI"){
				// $status_obat=$this->frmmdaftar->getdata_iri($no_register)->row()->status_obat;
				// // foreach($data_iri as $row){
				// // 	$status_obat=$row->status_obat;
				// // }
				// $status_obat = $status_obat + 1;
				$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRI($no_register,$getvtotobat,$no_resep);
				// print_r($this->frmmdaftar->selesai_daftar_pemeriksaan_IRI($no_register,$getvtotobat,$no_resep));
			}
			
			$tot_tuslah= $this->Frmmkwitansi->get_total_tuslah($no_resep)->row()->vtot_tuslah;

			$this->Frmmdaftar->update_data_header($no_resep, $nm_dokter, $tot_tuslah);
			$this->Frmmdaftar->update_racikan_selesai($no_register, $no_resep);

			// echo '<script type="text/javascript">window.open("'.site_url("farmasi/Frmckwitansi/cetak_faktur_kt/$no_resep").'", "_blank");window.focus()</script>';

			$data = array('status' => 'success',
						'no_resep' => $no_resep);

			echo json_encode($data);
		}
	}


	public function force_selesai($no_register){
		$getrdrj=substr($no_register, 0,2);
		$getvtotobat=$this->Frmmdaftar->get_vtot_obat($no_register)->row()->vtot_obat;
			if($getrdrj=="RJ"){
				$this->Frmmdaftar->force_selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotobat);
			}else{
				$this->Frmmdaftar->force_selesai_daftar_pemeriksaan_IRI($no_register,$getvtotobat);
			}

		redirect('farmasi/Frmcdaftar/','refresh');
	}
    public function get_biaya_resep()
	{
		$no_register=$this->input->post('no_register');
		$data=$this->Frmmdaftar->get_vtot_racikan($no_register)->row()->vtot_racikan_obat;
		echo json_encode($data);
	}

    public function get_biaya_tindakan()
	{
		$id_resep=$this->input->post('id_resep');
		$biaya=$this->Frmmdaftar->get_biaya($id_resep)->row()->hargajual;
		echo json_encode($biaya);
	}

	public function get_biaya_kebijakan()
	{
		$id_kebijakan=$this->input->post('id_kebijakan');
		$biaya_markup=$this->Frmmdaftar->get_biaya($id_kebijakan)->row()->nilai;
		echo json_encode($biaya_markup);
	}

	public function get_cara_bayar()
	{
		$no_register=$this->input->post('no_register');
		$cara_bayar=$this->Frmmdaftar->get_cara_bayar($no_register)->row()->cara_bayar;
		echo json_encode($cara_bayar);
	}

	public function get_kontraktor()
	{
		$no_register=$this->input->post('no_register');
		$nmkontraktor=$this->Frmmdaftar->get_kontraktor($no_register)->row()->nmkontraktor;
		echo json_encode($nmkontraktor);
	}

	public function getnama_dokter_poli()
	{
		$no_register=$this->input->post('no_register');
		$nmdokter=$this->Frmmdaftar->getnama_dokter_poli($no_register)->row()->nmdokter;
		echo json_encode($nmdokter);
	}


	
	public function insert_permintaan()
	{
		//$id_pemeriksaan_lab=$this->input->post('id_poli');
		//$data['no_slip']=$this->input->post('no_slip');
		
		$data['no_register']=$this->input->post('no_register');
		$data['no_medrec']=$this->input->post('no_medrec');
		$data['tgl_kunjungan']=$this->input->post('tgl_kun');
		$data['item_obat']=$this->input->post('idtindakan');
		$data['id_inventory']=$this->input->post('id_inventory');

		//radio button bpjs
		/* Proses pemilihan cara bayar yang nantinya akan mempengaruhi Output dari KWITANSI*/
		$data['bpjs']=$this->input->post('bpjs');
		if($this->input->post('id_gudang') != 3){
			$data['cara_bayar']='UMUM';
		}else{
			$data['cara_bayar']='BPJS';
		}

        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);

		$data_tindakan=$this->Frmmdaftar->getitem_obat($data['item_obat'], $group->id_gudang)->result();
		foreach($data_tindakan as $row){
			$data['item_obat']=$row->id_obat;
			$data['nama_obat']=$row->nm_obat;
			$data['Satuan_obat']=$row->satuank;
		}

		$data['idrg']=$this->input->post('idrg');		

		$data['bed']=$this->input->post('bed');
		$data['no_resep']=$this->input->post('no_resep');
		$data['qty']=$this->input->post('qty');
			$sgn1=$this->input->post('sgn1');
			$sgn2=$this->input->post('sgn2');
			$satuan=$this->input->post('satuan');
				if ($sgn1==''){
					$data['Signa']="-";
				} else {
					$data['Signa']=$sgn1." x Sehari ".$sgn2." ".$satuan;
				}
			
		
		$data['kelas']=$this->input->post('kelas_pasien');
		$data['biaya_obat']=$this->input->post('biaya_obat_hide');
		$data['fmarkup']=$this->input->post('fmarkup');
		//$data['vtot']=$this->input->post('vtot_hide');
		$data['ppn']=$this->input->post('margin');
		$total = $this->input->post('vtotakhir_hide');
		if($this->input->post('cara_bayar') == 'UMUM'){
			//Update Margin Tambahan + Pembulatan 100 jika pasien Umum
			$total_akhir = (int) (100 * ceil($total / 100));
		}else{
			$total_akhir = $total;
		}
		$data['vtot']=$total_akhir;

		$data['tuslah']=$this->input->post('tuslah_non');
		$data['xinput']=$this->input->post('xuser');
		

		// if($data['no_resep']!=''){
		// } else {
		// 	$this->Frmmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
		// 	$data['no_resep']=$this->Frmmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_resep;
		// }
		
		$this->Frmmdaftar->insert_permintaan($data);
		
		redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register']);
		//print_r($data);
	}

	public function insert_racikan_selesai()
	{
		//$id_pemeriksaan_lab=$this->input->post('id_poli');
		//$data['no_slip']=$this->input->post('no_slip');
		
		$data['no_register']=$this->input->post('no_register');
		$data['no_medrec']=$this->input->post('no_medrec');
		
		$data['tgl_kunjungan']=$this->input->post('tgl_kun');
		$data['idrg']=$this->input->post('idrg');
		//$data['cara_bayar']=$this->input->post('cara_bayar');
		$data['bed']=$this->input->post('bed');
		// $data['no_resep']=$this->input->post('no_resep');
		$data['qty']=$this->input->post('qty1');

			$sgn1=$this->input->post('sgn1');
			$sgn2=$this->input->post('sgn2');
			$satuan=$this->input->post('satuan');
				if ($sgn1==''){
					$data['Signa']="-";
				} else {
					$data['Signa']=$sgn1." x Sehari ".$sgn2." ".$satuan;
				}
		
		$data['kelas']=$this->input->post('kelas_pasien');
		//$data['biaya_obat']=$this->input->post('biaya_obat_hide');//sum dari db
		$data['fmarkup']=$this->input->post('fmarkup');// dari db
		$data['ppn']=$this->input->post('ppn');
		$data['tuslah']=$this->input->post('tuslah_racik');
		$data['xuser']=$this->input->post('xuser');

		/* Proses pemilihan cara bayar yang nantinya akan mempengaruhi Output dari KWITANSI*/
		$data['bpjs']=$this->input->post('bpjs_racik');
		if($this->input->post('id_gudang_racikan') != 3){
			$data['cara_bayar']='UMUM';
		}else{
			$data['cara_bayar']='BPJS';
		}
		
		$data['vtot']=$this->input->post('vtotakhir_hide_racik');
		$data['nama_obat']=$this->input->post('racikan');
		$data['racikan']='1';
		$data_biaya_racik=$this->Frmmdaftar->getbiaya_obat_racik($data['no_resep'])->result();
		foreach($data_biaya_racik as $row){
			$total = $row->total;
			if($this->input->post('cara_bayar') == 'UMUM'){
				$total_akhir = roundUpToNearestHundred($total);
			}else{
				$total_akhir = $total;
			}
			$data['biaya_obat']=$total_akhir;
		}

		// if($data['no_resep']!=''){
		// } else {
		// 	$this->Frmmdaftar->insert_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas']);
		// 	$data['no_resep']=$this->Frmmdaftar->get_data_header($data['no_register'],$data['idrg'],$data['bed'],$data['kelas'])->row()->no_resep;
		// }

		$this->Frmmdaftar->insert_permintaan($data);
		$id_resep_pasien=$this->Frmmdaftar->get_id_resep($data['no_register'],$data['nama_obat'])->row()->id_resep_pasien;
		$this->Frmmdaftar->update_racikan($data['no_register'], $id_resep_pasien);
		
		redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/'.$data['no_resep']);
		//print_r($data);
	}

		
	public function insert_racikan()
	{
		$data['no_register']=$this->input->post('no_register');
		$data['no_medrec']=$this->input->post('no_medrec');
		
		// $data['item_obat']=$this->input->post('idracikan');
		$data['idrg']=$this->input->post('idrg');
		$data['kelas']=$this->input->post('kelas_pasien');
		$data['bed']=$this->input->post('bed');
		$data['id_inventory']=$this->input->post('idracikan');
		// $data_tindakan=$this->Frmmdaftar->getitem_obat($data['item_obat'])->result();
		// foreach($data_tindakan as $row){
		// 	$data['nama_obat']=$row->nm_obat;
		// 	$data['Satuan_obat']=$row->satuank;
		// }
        $userid = $this->session->userid;
        $group = $this->Frmmpo->getIdGudang($userid);

		$data_tindakan=$this->Frmmdaftar->getitem_obat($data['id_inventory'], $group->id_gudang)->result();
		foreach($data_tindakan as $row){
			$data['item_obat']=$row->id_obat;
			$data['nama_obat']=$row->nm_obat;
			$data['Satuan_obat']=$row->satuank;
		}
		$data['qty']=$this->input->post('qty_racikan');
		$this->Frmmdaftar->insert_racikan($data['id_inventory'],$data['item_obat'],$data['qty'],$data['no_register']);
		// $this->Frmmdaftar->insert_racikan($data['item_obat'],$data['qty'],$data['no_resep']);
		
		redirect('farmasi/Frmcdaftar/permintaan_obat/'.$data['no_register'].'/racik');
			print_r($data);
	}

	public function by_date(){
		$date=$this->input->post('date');
		$data['title'] = 'Farmasi Tanggal '.$date;

		$data['farmasi']=$this->Frmmdaftar->get_daftar_pasien_resep_by_date($date)->result();
		$this->load->view('farmasi/frmvdaftarpasien',$data);
	}

	public function by_no()
	{
		
		$key=$this->input->post('key');
		$data['title'] = 'Farmasi By No Register '.$key;

		$data['farmasi']=$this->Frmmdaftar->get_daftar_pasien_resep_by_no($key)->result();
		$this->load->view('farmasi/frmvdaftarpasien',$data);
	}

	public function cek_harga_obat(){
		$cek_harga=$this->input->post('nama_obat');

		$cek=$this->Frmmdaftar->get_harga_obat($cek_harga)->result();
		$konten="<table class='table table-hover table-bordered table-responsive'>
					<tr>
						<td><b>Nama Obat</b></td>
						<td><b>Satuan Obat</b></td>
						<td><b>Harga Obat</b></td>
					</tr>";
		foreach($cek as $row){
			
			$konten=$konten."<tr>
						<td>$row->nm_obat</td>
						<td>$row->satuank</td>
						<td>$row->hargajual</td>
					</tr>";
		}
		$konten=$konten.'</table>';
		echo $konten;
		//print_r($konten);
	}

	public function selesai_daftar_pemeriksaan($no_register='')
	{
		$no_register=$this->input->post('no_register');
		//$idrg=$this->input->post('idrg');
		$idrg=$this->input->post('unitasal');
		$bed=$this->input->post('bed');
		$kelas=$this->input->post('kelas_pasien');
		//$nm_dokter=$this->input->post('nm_dokter');
		$getvtotobat=$this->Frmmdaftar->get_vtot_obat($no_register)->row()->vtot_obat;
		$getrdrj=substr($no_register, 0,2);
		// $this->Frmmdaftar->update_data_header($data['no_resep'], $nm_dokter);
		$this->Frmmdaftar->insert_data_header($no_register,$idrg,$bed,$kelas);
		$no_resep=$this->Frmmdaftar->get_data_header($no_register,$idrg,$bed,$kelas)->row()->no_resep;

		/*if($getrdrj=="PL"){
			$this->Frmmdaftar->selesai_daftar_pemeriksaan_PL($no_register,$getvtotobat,$no_resep);
		}
		else if($getrdrj=="RJ"){
			$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotobat,$no_resep);
		}
		else if ($getrdrj=="RD"){
			$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRD($no_register,$getvtotobat,$no_resep);
		}
		else if ($getrdrj=="RI"){
			// $status_obat=$this->frmmdaftar->getdata_iri($no_register)->row()->status_obat;
			// // foreach($data_iri as $row){
			// // 	$status_obat=$row->status_obat;
			// // }
			// $status_obat = $status_obat + 1;
			$this->Frmmdaftar->selesai_daftar_pemeriksaan_IRI($no_register,$getvtotobat,$no_resep);
			// print_r($this->frmmdaftar->selesai_daftar_pemeriksaan_IRI($no_register,$getvtotobat,$no_resep));
		}*/

		
		
		$tot_tuslah= $this->Frmmkwitansi->get_total_tuslah($no_resep)->row()->vtot_tuslah;

		$this->Frmmdaftar->update_data_header($no_resep, $nmdokter, $tot_tuslah);
		$this->Frmmdaftar->update_racikan_selesai($no_register, $no_resep);

		if ($this->input->post('diskon_hide')!='') 
		{
			$diskon=$this->input->post('diskon_hide');
			if($this->input->post('totakhir')!=''){
				$totakhir=$this->input->post('totakhir');
			}
			$cookiediskon='document.cookie = "diskon='.$diskon.'";';
		} else $cookiediskon='document.cookie = "diskon=0";';

		echo '<script type="text/javascript">'.$cookiediskon.';window.open("'.site_url("farmasi/Frmckwitansi/cetak_faktur_kt/$no_resep").'", "_blank");window.focus()</script>';
		
		 redirect('farmasi/Frmcdaftar/','refresh');
	}

	public function hapus_data_pemeriksaan($no_register='', $id_resep_pasien='', $no_resep='')
	{
		$id=$this->Frmmdaftar->hapus_data_pemeriksaan($id_resep_pasien);

		redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/'.$no_resep);
		
		//print_r($id);
	}	

	// public function hapus_data_racikan($no_register='', $id_obat_racikan='')
	// {
	// 	$id=$this->Frmmdaftar->hapus_data_racikan($id_obat_racikan);

	// 	redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/resep');
		
	// 	//print_r($id);
	// }	

	public function get_data_edit_obat(){
		$id_resep_pasien=$this->input->post('id_resep_pasien');
		$datajson=$this->Frmmdaftar->get_resep_pasien($id_resep_pasien)->result();
	    echo json_encode($datajson);
	}

	public function hapus_data_obat($no_register='', $id_resep_pasien='', $no_resep='')
	{
		$id=$this->Frmmdaftar->hapus_data_obat($id_resep_pasien);

		redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/'.$no_resep);
		
		//print_r($id);
	}	

	public function hapus_data_obat_racik($no_register='', $id_resep_pasien='', $no_resep='')
	{
		$id=$this->Frmmdaftar->hapus_data_obat($id_resep_pasien);
		$id2=$this->Frmmdaftar->hapus_data_obat_racik($id_resep_pasien);

		redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/'.$no_resep);
		
		//print_r($id);
	}	

	public function hapus_data_racikan($no_register='', $id_obat_racikan='')
	{
		$id=$this->Frmmdaftar->hapus_data_racikan($id_obat_racikan);

		redirect('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/resep');
		
		//print_r($id);
	}	

	public function daftar_pasien_luar()
	{
		$data['nama']=$this->input->post('nama');
		$data['alamat']=$this->input->post('alamat');
		$data['tgl_kunjungan']=date('Y-m-d H:i:s');

		$no_register=$this->Frmmdaftar->get_new_register()->result();
		foreach($no_register as $val){
			$data['no_register']=sprintf("PL%s%06s",$val->year,$val->counter+1);
		}
		$data['obat']='1';
		
		$this->Frmmdaftar->insert_pasien_luar($data);
		
		redirect('farmasi/Frmcdaftar');
		//print_r($data);
	}

	public function selesai_pengambilan(){
		$no_resep=$this->input->post('no_resep');
		$datajson=$this->Frmmdaftar->selesai_pengambilan($no_resep);

		echo json_encode($datajson);

	}

	public function cari_data_obat(){
		// $keyword = $this->uri->segment(4);


		// //get obat from role id
	 //    $login_data = $this->load->get_var("user_info");
	 //    $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

	 //    $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
	 //    $i=1;

	 //    foreach ($id_gudang as $row) {
	 //      if($i==1){
	 //      	$data = $this->db->select('o.`id_obat`, o.`nm_obat`, o.`hargajual`, g.`batch_no`, g.`expire_date`, g.`qty`')
		// 		->from('gudang_inventory g')
		// 		->join('master_obat o', 'o.id_obat = g.id_obat', 'inner')
		// 		->where('g.id_gudang', $row->id_gudang)
		// 		->like('nm_obat',$keyword)->limit(20, 0)->get()->result();
	 //        // $gd = $this->Frmmdaftar->get_data_resep_by_role($row->id_gudang)->result();
	 //      }else {
	 //      	$data1 = $this->db->select('o.`id_obat`, o.`nm_obat`, o.`hargajual`, g.`batch_no`, g.`expire_date`, g.`qty`')
		// 		->from('gudang_inventory g')
		// 		->join('master_obat o', 'o.id_obat = g.id_obat', 'inner')
		// 		->where('g.id_gudang', $row->id_gudang)
		// 		->like('nm_obat',$keyword)->limit(20, 0)->get()->result();
	 //        $data = array_merge($data, $data1);
	 //      }
	    
	 //      $i++;
	 //    }
	    
	    $login_data = $this->load->get_var("user_info");
	    $data['roleid'] = $this->Frmmdaftar->get_roleid($login_data->userid)->row()->roleid;

	    $id_gudang = $this->Frmmdaftar->get_gudangid($login_data->userid)->result();
	    $i=1;

	    foreach ($id_gudang as $row) {
	    	$no_gudang[]=$row->id_gudang;
	    }

	    $userid = $this->session->userid;
	    $group = $this->Frmmpo->getIdGudang($userid);
	    if($group->id_gudang == "8" || $group->id_gudang == "7"){
	    	$ids = "1";
	    }else{
			$ids = join("','",$no_gudang); 
	    }

		$keyword = $this->uri->segment(4);
		$data = $this->db->select('g.`id_inventory`,o.`id_obat`, o.`nm_obat`, o.`hargabeli`, o.`hargajual`, g.`batch_no`, g.`expire_date`, g.`qty`, o.`jenis_obat`')
				->from('gudang_inventory g')
				->join('master_obat o', 'o.id_obat = g.id_obat', 'inner')
				->where('g.id_gudang', $ids)
				->like('nm_obat',$keyword)->limit(20, 0)->get()->result();
		$arr='';
	    if(!empty($data)){
			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=> $row->nm_obat." (".$row->batch_no.",".$row->expire_date.",".$row->qty.",".$row->id_inventory.")",
					'idobat' => $row->id_obat,
					'id_inventory' => $row->id_inventory,
					'nama'	=>$row->nm_obat,
					'harga' => $row->hargajual,
					'hargabeli' => $row->hargabeli,
					'batch_no' => $row->batch_no,
					'expire_date' => $row->expire_date,
					'qty' => $row->qty,
					'jenis_obat' => $row->jenis_obat
				);
			}
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}

	public function cari_data_obat_all(){

		$keyword = $this->uri->segment(4);
		$data = $this->db->select('*')
				->from('master_obat')
				->like('nm_obat',$keyword)->limit(20, 0)->get()->result();
		$arr='';
	    if(!empty($data)){
			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=> $row->nm_obat,
					'idobat' => $row->id_obat,
					'nama'	=>$row->nm_obat,
					'harga' => $row->hargajual,
					'hargabeli' => $row->hargabeli,
					'batch_no' => "",
					'expire_date' => "",
					'qty' => 0,
					'jenis_obat' => $row->jenis_obat
				);
			}
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}

	public function cari_data_obat_by_gudang(){

		$userid = $this->session->userid;
    	$group = $this->Frmmpo->getIdGudang($userid)->id_gudang;

		$keyword = $this->uri->segment(4);
		$data = $this->db->select('g.`id_obat`, o.`nm_obat`, o.`hargajual`, o.`hargabeli`, g.`batch_no`, 
			g.`expire_date`, g.`qty`, o.`jenis_obat`, o.`satuank`')
				->from('gudang_inventory g')
				->join('master_obat o', 'o.id_obat = g.id_obat', 'inner')
				->where('g.`id_gudang`', $group)
				->like('o.`nm_obat`', $keyword)->limit(20, 0)->get()->result();
		$arr='';
	    if(!empty($data)){
			foreach($data as $row)
			{
				$arr['query'] = $keyword;
				$arr['suggestions'][] = array(
					'value'	=> $row->nm_obat." BATCH: ".$row->batch_no." STOK: ".$row->qty,
					'idobat' => $row->id_obat,
					'nama'	=>$row->nm_obat,
					'harga' => $row->hargajual,
					'hargabeli' => $row->hargabeli,
					'batch_no' => $row->batch_no,
					'expire_date' => $row->expire_date,
					'satuank' => $row->satuank,
					'qty' => 0,
					'jenis_obat' => $row->jenis_obat
				);
			}
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}

	public function get_margin_carabayar(){
		$cara_bayar = $this->input->post('carabayar');
		$margin = $this->Frmmdaftar->get_margin_obat($cara_bayar)->result();

		foreach ($margin as $margins){
        ?>
        <input type="radio" name="margin" id="margin" value="<?=$margins->pengali?>" onclick="set_total_akhir(this.value)"
        	<?php
        	if($cara_bayar=='UMUM' && $margins->keterangan=='Umum'){
        		echo "checked";
        	}else if($cara_bayar=='BPJS' && $margins->keterangan=='BPJS'){
        		echo "checked";
        	}
        	?>
        >
            &nbsp;<?=$margins->persentase?> % &nbsp;&nbsp;<?=$margins->keterangan?>&nbsp;&nbsp;&nbsp;&nbsp;
        <?php
        }
	}

	public function get_margin_carabayar_racik(){
		$cara_bayar = $this->input->post('carabayar');
		$margin = $this->Frmmdaftar->get_margin_obat($cara_bayar)->result();

		foreach ($margin as $margins){
        ?>
        <input type="radio" name="margin_racik" id="margin_racik" value="<?=$margins->pengali?>" onclick="set_total_akhir_racik(this.value)"
    	<?php
    	if($cara_bayar=='UMUM' && $margins->keterangan=='Umum'){
    		echo "checked";
    	}else if($cara_bayar=='BPJS' && $margins->keterangan=='BPJS'){
    		echo "checked";
    	}
    	?> >
        &nbsp;<?=$margins->persentase?> % &nbsp;&nbsp;<?=$margins->keterangan?>&nbsp;&nbsp;&nbsp;&nbsp;<br/>
        <?php
        }
	}

	public function roundUpToNearestHundred($n){
	    return (int) (100 * ceil($n / 100));
	}

	public function roundUpToNearestThousand($n){
	    return (int) (1000 * ceil($n / 1000));
	}
}

