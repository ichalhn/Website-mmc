<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Frmmdaftar extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		
		//daftar resep pasien

		function get_daftar_resep_pasien($date){
			return $this->db->query("SELECT * FROM permintaan_obat WHERE LEFT(tgl_kunjungan,10)='$date'");
		}

		function get_resep_pasien($id_resep_pasien){
			return $this->db->query("SELECT * FROM resep_pasien WHERE id_resep_pasien='$id_resep_pasien'");
		}
		

		function get_pengambilan_resep_pasien(){
			return $this->db->query("SELECT no_resep, no_register, (
			IF(LEFT(no_register,2)='PL', (SELECT nama FROM pasien_luar WHERE no_register=resep_pasien.no_register)
			, (SELECT nama FROM data_pasien WHERE no_medrec=resep_pasien.no_medrec)) ) as nama, 
			tgl_kunjungan, kelas, (select idrg from resep_header where no_resep=resep_pasien.no_resep) as idrg,
            (select bed from resep_header where no_resep=resep_pasien.no_resep) as bed, cetak_kwitansi, cara_bayar 
			FROM resep_pasien 
			WHERE ambil_resep='0' AND no_resep IS NOT NULL
			GROUP BY no_resep
			ORDER BY no_resep");
		}

		function get_daftar_pasien_resep_by_date($date){
			return $this->db->query("SELECT * FROM permintaan_obat
										WHERE left(tgl_kunjungan,10)  = '$date' 
										ORDER BY tgl_kunjungan DESC");
		}

		function get_daftar_pasien_resep_by_no($key){
			return $this->db->query("SELECT * FROM permintaan_obat
				WHERE  (permintaan_obat.no_register like '%$key%') 
				ORDER BY tgl_kunjungan ASC");
		}

		function get_data_pasien_luar($no_register){
			return $this->db->query("SELECT * FROM permintaan_obat, pasien_luar WHERE permintaan_obat.no_register=pasien_luar.no_register AND permintaan_obat.no_register='$no_register'");
		}

		function get_data_resep(){
			return $this->db->query("SELECT * FROM master_obat");
		}

		function get_biaya($id_inventory){
			return $this->db->query("SELECT hargajual FROM master_obat as a, gudang_inventory as b WHERE a.id_obat=b.id_obat and b.id_inventory='".$id_inventory."'");
		}

		function get_biaya_markup($kodemarkup){
			return $this->db->query("SELECT markup FROM kebijakan_obat");
		}

		function get_data_pasien_resep($no_register){
			return $this->db->query("SELECT * FROM permintaan_obat, data_pasien WHERE permintaan_obat.no_medrec=data_pasien.no_medrec AND permintaan_obat.no_register='$no_register'");
		}

		function get_data_pasien_iri($no_register){
			return $this->db->query("SELECT * FROM permintaan_obat WHERE no_register='".$no_register."'");
		}

		function get_data_markup(){
			return $this->db->query("SELECT * FROM kebijakan_obat");
		}

		function get_harga_obat($nama_obat){
			return $this->db->query("SELECT nm_obat,hargajual,satuank FROM master_obat WHERE nm_obat like '%$nama_obat%' limit 0,10");
		}



		//function get_daftar_pasien_lab(){
		//	return $this->db->query("SELECT * FROM permintaan_obat, data_pasien WHERE permintaan_obat.no_medrec=data_pasien.no_medrec");
		//}

		function get_data_pasien_pemeriksaan($no_register){
			return $this->db->query("SELECT * FROM permintaan_obat, data_pasien WHERE permintaan_obat.no_medrec=data_pasien.no_medrec 	and resep_pasien.no_register='".$no_register."'");

		}

		//function getjenis_tindakan($id_tindakan){
		//	return $this->db->query("SELECT * FROM jenis_tindakan WHERE idtindakan='".$id_tindakan."' ");
		//}

		// function getitem_obat($id_obat){
		// 	return $this->db->query("SELECT * FROM master_obat WHERE id_obat='".$id_obat."'");
		// }

		function getitem_obat($id_inventory, $idgudang){
			return $this->db->query("SELECT *, (SELECT nm_obat FROM master_obat WHERE id_obat=a.id_obat) as nm_obat, (SELECT satuank FROM master_obat WHERE id_obat=a.id_obat) as satuank 
					FROM gudang_inventory as a WHERE id_obat ='".$id_inventory."' AND id_gudang = ".$idgudang);
		}
	
		function getdata_resep_pasien($no_register){
			return $this->db->query("SELECT * FROM resep_pasien where no_register='".$no_register."' AND no_resep IS NULL");
		}
	
		function getdata_resep_racik($no_register){
			return $this->db->query("SELECT *, (SELECT nm_obat FROM master_obat WHERE id_obat=a.item_obat) as nm_obat 
				FROM obat_racikan AS a where no_register='".$no_register."' AND no_resep IS NULL");
		}

		function getdata_resep_racikan($no_register){
			return $this->db->query("SELECT * FROM obat_racikan, master_obat where obat_racikan.item_obat=master_obat.id_obat AND no_register='".$no_register."' AND id_resep_pasien=''");
		}

		//function getdata_tindakan_pasien($no_register){
		//	return $this->db->query("SELECT * FROM jenis_tindakan_lab");
		//}

		function get_biaya_tindakan($id){
			return $this->db->query("SELECT total_tarif FROM tarif_tindakan WHERE id_tindakan='".$id."'");
		}

		function getdata_dokter(){
			return $this->db->query("SELECT * FROM data_dokter WHERE id_dokter");
		}

		function getdata_cara(){
			return $this->db->query("SELECT * FROM cara_bayar WHERE cara_bayar");
		}

		function getnama_dokter($id_dokter){
			return $this->db->query("SELECT * FROM data_dokter WHERE id_dokter='".$id_dokter."'");
		}

		function getnama_dokter_poli($no_register){
			if(substr($no_register, 0,2)=="RJ"){
				return $this->db->query("SELECT *, (SELECT nm_dokter from data_dokter where id_dokter=daftar_ulang_irj.id_dokter) as nmdokter FROM daftar_ulang_irj,data_dokter 
					where daftar_ulang_irj.no_register='$no_register' AND data_dokter.id_dokter=daftar_ulang_irj.id_dokter");
			} if(substr($no_register, 0,2)=="RI"){
				return $this->db->query("SELECT *, (SELECT nm_dokter from data_dokter where id_dokter=pasien_iri.id_dokter) as nmdokter FROM pasien_iri,data_dokter
					Where pasien_iri.no_ipd='$no_register' AND data_dokter.id_dokter=pasien_iri.id_dokter");
			} if(substr($no_register, 0,2)=="RD"){
				return $this->db->query("SELECT *, (SELECT nm_dokter from data_dokter where id_dokter=irddaftar_ulang.id_dokter) as nmdokter FROM irddaftar_ulang,data_dokter
					Where irddaftar_ulang.no_register='$no_register' AND data_dokter.id_dokter=irddaftar_ulang.id_dokter");
			} else {
				return $this->db->query("SELECT 'UMUM' as nmdokter FROM pasien_luar WHERE  no_register='$no_register'");
			}
		}

		function insert_permintaan($data){
			$this->db->insert('resep_pasien', $data);
			return true;
		}

		function insert_racikan($id_inventory,$item_obat,$qty,$no_register){
			$this->db->query("INSERT INTO obat_racikan (id_inventory,item_obat,qty,no_register) values ('$id_inventory','$item_obat','$qty','$no_register')");
			return true;
		}

		function insert_pasien_luar($data){
			$this->db->insert('pasien_luar', $data);
			return true;
		}

		function selesai_pengambilan($no_resep){
			$this->db->query("UPDATE resep_pasien SET ambil_resep=1 WHERE no_resep='$no_resep'");
			return true;
		}

		function get_new_register(){
			return $this->db->query("SELECT max(right(no_register,6)) as counter, mid(now(),3,2) as year from pasien_luar where mid(no_register,3,2) = (select mid(now(),3,2))");
		}
		
		function getbiaya_obat_racik($no_resep){
			return $this->db->query("SELECT sum(qty*hargajual) as total FROM obat_racikan a, master_obat b WHERE a.item_obat=b.id_obat AND a.no_resep='".$no_resep."' AND a.id_resep_pasien=''");
		}

		function selesai_daftar_pemeriksaan_PL($no_register,$getvtotobat,$no_resep){
			$this->db->query("UPDATE resep_pasien SET no_resep='$no_resep', cetak_faktur='1' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pasien_luar SET obat=0, vtot_obat='$getvtotobat' WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotobat,$no_resep){
			$this->db->query("UPDATE resep_pasien SET no_resep='$no_resep', cetak_faktur='1' WHERE no_register='$no_register' and no_resep is null");
			//Nanti ini di Uncomment aja terus dihapus dbawahnya
			//$this->db->query("UPDATE daftar_ulang_irj SET vtot_obat='$getvtotobat' , status_obat=1 WHERE no_register='$no_register'");
			$this->db->query("UPDATE daftar_ulang_irj SET vtot_obat='$getvtotobat' WHERE no_register='$no_register'");
			return true;
		}

		function force_selesai_daftar_pemeriksaan_IRJ($no_register,$getvtotobat){
			//$this->db->query("UPDATE resep_pasien SET no_resep='$no_resep', cetak_faktur='1' WHERE no_register='$no_register'");
			$this->db->query("UPDATE daftar_ulang_irj SET vtot_obat='$getvtotobat' , status_obat=1 WHERE no_register='$no_register'");
			return true;
		}

		function force_selesai_daftar_pemeriksaan_IRI($no_register,$getvtotobat){
			//$this->db->query("UPDATE resep_pasien SET no_resep='$no_resep', cetak_faktur='1' WHERE no_register='$no_register'");
			$this->db->query("UPDATE pasien_iri SET obat='0', status_obat=status_obat+1, vtot_obat='$getvtotobat' WHERE no_ipd='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRD($no_register,$getvtotobat,$no_resep){
			$this->db->query("UPDATE resep_pasien SET no_resep='$no_resep', cetak_faktur='1' WHERE no_register='$no_register'");
			//$this->db->query("UPDATE irddaftar_ulang SET vtot_obat='$getvtotobat' , status_obat=1 WHERE no_register='$no_register'");
			return true;
		}

		function force_selesai_daftar_pemeriksaan_IRD($no_register,$getvtotobat,$no_resep){
			//$this->db->query("UPDATE resep_pasien SET no_resep='$no_resep', cetak_faktur='1' WHERE no_register='$no_register'");
			$this->db->query("UPDATE irddaftar_ulang SET vtot_obat='$getvtotobat' , status_obat=1 WHERE no_register='$no_register'");
			return true;
		}

		function selesai_daftar_pemeriksaan_IRI($no_register,$getvtotobat,$no_resep){
			$this->db->query("UPDATE resep_pasien SET no_resep=IF(no_resep IS NULL, '$no_resep', no_resep), cetak_faktur='1' WHERE no_register='$no_register'");
			//Nanti ini di UnComment lagi aja kl permintaannya berubah lagi
			//$this->db->query("UPDATE pasien_iri SET obat='0', status_obat=status_obat+1, vtot_obat='$getvtotobat' WHERE no_ipd='$no_register'"); //------> TIDAK JADI Dicomment untuk proses Selesai Manual di Farmasi pasien Rawat Inap
			return true;
		}		

		function get_vtot_obat($no_register){
			return $this->db->query("SELECT SUM(vtot) as vtot_obat FROM resep_pasien WHERE no_register='".$no_register."'");
		}

		function hapus_data_obat($id_resep_pasien){
			$this->db->where('id_resep_pasien', $id_resep_pasien);
       		$this->db->delete('resep_pasien');			
			return true;
		}

		function hapus_data_obat_racik($id_resep_pasien){
			$this->db->where('id_resep_pasien', $id_resep_pasien);
       		$this->db->delete('obat_racikan');			
			return true;
		}

		function hapus_data_racikan($id_obat_racikan){
			$this->db->where('id_obat_racikan', $id_obat_racikan);
       		$this->db->delete('obat_racikan');			
			return true;
		}

		function hapus_data_pemeriksaan($id_resep_pasien){
			$this->db->where('id_resep_pasien', $id_resep_pasien);
       		$this->db->delete('resep_pasien');			
			return true;
		}

		function insert_data_header($no_register,$idrg,$bed,$kelas){
			return $this->db->query("INSERT INTO resep_header (no_resgister, idrg, bed, kelas) VALUES ('$no_register','$idrg','$bed','$kelas')");
		}	

		function update_data_header($no_resep, $nm_dokter, $tot_tuslah){
			return $this->db->query("UPDATE resep_header SET nm_dokter='$nm_dokter', tot_tuslah='$tot_tuslah' WHERE no_resep='$no_resep'");
		}

		function get_data_dokter($no_resep){
			return $this->db->query("SELECT nm_dokter FROM resep_header WHERE no_resep='$no_resep'");
		}	

		function get_data_header($no_resgister,$idrg,$bed,$kelas){
			return $this->db->query("SELECT no_resep FROM resep_header WHERE no_resgister='$no_resgister' AND idrg='$idrg' AND bed='$bed' AND kelas='$kelas'  ORDER BY no_resep DESC LIMIT 1");
		}	

		function get_vtot_racikan($no_register){
			return $this->db->query("SELECT sum(hargajual*qty) as vtot_racikan_obat FROM obat_racikan, master_obat WHERE obat_racikan.item_obat=master_obat.id_obat AND no_register='$no_register' AND id_resep_pasien='0'");
		}	

		function get_id_resep($no_register, $nama_obat){
			return $this->db->query("SELECT id_resep_pasien FROM resep_pasien WHERE no_register='$no_register' AND nama_obat='$nama_obat'LIMIT 1");
		}

		function getdata_iri($no_register){
			return $this->db->query("SELECT status_obat FROM pasien_iri WHERE no_ipd='".$no_register."'");
		}
		

		function get_no_resep($no_register){
			return $this->db->query("SELECT no_resep FROM resep_pasien WHERE  no_register='$no_register' GROUP BY no_resep");
		}

		function get_roleid($userid){
			return $this->db->query("SELECT roleid FROM dyn_role_user WHERE userid = '".$userid."'");
		}

	    function get_gudangid($userid){
	      return $this->db->query("Select id_gudang from dyn_gudang_user where userid = '".$userid."'");
	    }

	    function get_data_resep_by_role($role){
	      return $this->db->query("SELECT * , (SELECT nm_obat FROM master_obat WHERE id_obat=a.id_obat) as nm_obat , (SELECT nama_gudang FROM master_gudang WHERE id_gudang=a.id_gudang) as nama_gudang
	        FROM gudang_inventory as a WHERE a.id_gudang='$role' order by batch_no");
	    }
		

		function get_cara_bayar($no_register){
			if(substr($no_register, 0,2)=="RD"){
				return $this->db->query("SELECT cara_bayar FROM irddaftar_ulang WHERE  no_register='$no_register'");
			}if(substr($no_register, 0,2)=="RJ"){
				return $this->db->query("SELECT cara_bayar FROM daftar_ulang_irj WHERE  no_register='$no_register'");
			}if(substr($no_register, 0,2)=="RI"){
				return $this->db->query("SELECT cara_bayar FROM pasien_iri WHERE  no_register='$no_register'");
			} else {
				return $this->db->query("SELECT 'UMUM' as cara_bayar FROM pasien_luar WHERE  no_register='$no_register'");
			}
		}

		function get_kontraktor($no_register){
			if(substr($no_register, 0,2)=="RD"){
				return $this->db->query("SELECT *,(SELECT nmkontraktor from kontraktor where id_kontraktor=irddaftar_ulang.id_kontraktor) as nmkontraktor 
					FROM irddaftar_ulang,data_pasien 
					where irddaftar_ulang.no_medrec=data_pasien.no_medrec and irddaftar_ulang.no_register='$no_register'");
			}if(substr($no_register, 0,2)=="RJ"){
				return $this->db->query("SELECT *, (SELECT nmkontraktor from kontraktor where id_kontraktor=daftar_ulang_irj.id_kontraktor) as nmkontraktor 
					FROM daftar_ulang_irj,data_pasien 
					where daftar_ulang_irj.no_medrec=data_pasien.no_medrec and daftar_ulang_irj.no_register='$no_register'");
			}if(substr($no_register, 0,2)=="RI"){
				return $this->db->query("SELECT *, (SELECT nmkontraktor from kontraktor where id_kontraktor=pasien_iri.id_kontraktor) as nmkontraktor FROM pasien_iri,data_pasien
					Where pasien_iri.no_cm=data_pasien.no_medrec and pasien_iri.no_ipd='$no_register'");
			} else {
				return $this->db->query("SELECT 'UMUM' as nmkontraktor FROM pasien_luar WHERE  no_register='$no_register'");
			}
		}

		function update_racikan($no_register,$id_resep){
			return $this->db->query("UPDATE obat_racikan SET id_resep_pasien='$id_resep' WHERE no_register='$no_register' AND id_resep_pasien='0'");
		}

		function update_racikan_selesai($no_register,$no_resep){
			return $this->db->query("UPDATE obat_racikan SET no_resep='$no_resep' WHERE no_register='$no_register' AND no_resep is null");
		}

		function selesai_bayar_PL($no_register){
			return $this->db->query("UPDATE pasien_luar SET obat=0 WHERE no_register='$no_register'");
		}

		function selesai_bayar_IRJ($no_register){
			return $this->db->query("UPDATE daftar_ulang_irj SET status_obat=1 WHERE no_register='$no_register'");
		}

		function selesai_bayar_IRI($no_register, $status_obat){
			return $this->db->query("UPDATE pasien_iri SET obat='0' , status_obat='$status_obat' WHERE no_ipd='$no_register'");
		}

		function selesai_bayar_IRD($no_register){
			return $this->db->query("UPDATE irddaftar_ulang SET status_obat=1 WHERE no_register='$no_register'");
		}

		function cek_stok_obat($id_inventory, $qty){
			return $this->db->query("SELECT a.*, b.nm_obat as nama_obat FROM gudang_inventory as a LEFT JOIN master_obat as b ON a.id_obat=b.id_obat WHERE id_inventory='$id_inventory' and qty<'$qty'");
		}

		function cek_qty_obat($no_register){
			return $this->db->query("SELECT id_inventory as id_inventory, qty as qty FROM resep_pasien WHERE no_register='$no_register' and racikan='0' and no_resep is null
					UNION
					SELECT id_inventory as id_inventory, qty as qty FROM obat_racikan WHERE no_register='$no_register' and no_resep is null");
		}

		function update_stok_obat($id_inventory, $qty){
			return $this->db->query("UPDATE gudang_inventory SET qty=qty-'$qty' WHERE id_inventory='$id_inventory'");
		}

		function get_margin_obat($carabayar){
            return $this->db->query("SELECT * FROM margin_obat WHERE cara_bayar = '$carabayar'");
        }

	}
?>
