
<script>
	$('#tgl_pulang').datepicker({
		format: 'yyyy-mm-dd'
	});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_diagnosa_pasien').autocomplete({
		serviceUrl: site+'iri/ricstatus/data_icd_1',
		onSelect: function (suggestion) {
			//$('#no_cm').val(''+suggestion.no_cm);
			$('#diagnosa1').val(''+suggestion.nm_diagnosa);
			$('#id_row_diagnosa').val(''+suggestion.id_icd);
			// $('#nama').val(''+suggestion.nama);
			// $('.tanggal_lahir').val(''+suggestion.tanggal_lahir);
			// if(suggestion.jenis_kelamin=='L'){
			// 	$('#laki_laki').attr('selected', 'selected');
			// 	$('#perempuan').removeAttr('selected', 'selected');
			// }else{
			// 	$('#laki_laki').removeAttr('selected', 'selected');
			// 	$('#perempuan').attr('selected', 'selected');
			// }
			// $('#telp').val(''+suggestion.telp);
			// $('#hp').val(''+suggestion.hp);
			// $('#id_poli').val(''+suggestion.id_poli);
			// $('#poliasal').val(''+suggestion.poliasal);
			// $('#id_dokter').val(''+suggestion.id_dokter);
			// $('#dokter').val(''+suggestion.dokter);
			// $('#diagnosa').val(''+suggestion.diagnosa);
		}
	});
});

function update_cara_bayar(val){
	var r = confirm("Anda yakin ingin merubah cara bayar pasien ?");
	var no_ipd = $('#no_ipd').val();
	if (r == true) {
	   $.ajax({
		    type:'POST',
		    url:'<?php echo base_url("iri/rickwitansi/ubah_cara_bayar/"); ?>',
		    data:{
		    		'carabayar':val,
		    		'no_ipd':no_ipd
		    	},
		    success:function(data){
	    		if(data == '1'){
	    			alert("Cara bayar sukses diubah")
	    		}
		    }
		});
	   return true;
	} else {
	    return false;
	}
}

function set_total(val){
	var biaya_awal = $('#total_gabungan').val();
   var biaya_awal_pembulatan = $('#total_gabungan_pembulatan').val();

   var uang_muka = $('#uang_muka').val();
   var biaya_administrasi = $('#biaya_administrasi').val();
   var dibayar_tunai = $('#dibayar_tunai').val();
   var dibayar_kartu_cc_debit = $('#dibayar_kartu_cc_debit').val();
   var charge = $('#charge').val();
   var total_charge = dibayar_kartu_cc_debit * charge / 100;
   var diskon = $('#diskon').val();
   if(biaya_administrasi == ""){
      biaya_administrasi = 0;
   }
   if(dibayar_tunai == ""){
      dibayar_tunai = 0;
   }
   if(dibayar_kartu_cc_debit == ""){
      dibayar_kartu_cc_debit = 0;
   }
   if(charge == ""){
      charge = 0;
   }
   if(total_charge == ""){
      total_charge = 0;
   }
   if(diskon == ""){
      diskon = 0;
   }

	var biaya_akhir = parseInt(dibayar_tunai) + parseInt(dibayar_kartu_cc_debit) + parseInt(total_charge);
   var total_harga_gabungan = parseInt(biaya_awal) - parseInt(diskon);
   var total_harga_gabungan_pembulatan = parseInt(biaya_awal_pembulatan) - parseInt(diskon);
   
   // var biaya_dibayar = (parseInt(biaya_akhir) + parseInt(biaya_awal));
   // alert(biaya_dibayar);
   $('#nominal_charge').val(total_charge);
	$('#grand_total_show').html("Rp. "+biaya_akhir.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   $('#total_harga_gabungan').html("Rp. "+total_harga_gabungan.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   $('#total_harga_gabungan_pembulatan').html("Rp. "+total_harga_gabungan_pembulatan.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
}

</script>


<section class="content-header">
   <div class="row">
      <div class="col-sm-6">
         <div class="panel panel-default">
            <div class="panel-heading" align="center">Data Pasien</div>
            <div class="panel-body">
               <br/>
               <div class="row">
                  <div class="col-sm-3">
                     <div align="center"><img height="100px" class="img-rounded" src="<?php 
                        if($data_pasien[0]['foto']==''){
                           echo site_url("upload/photo/unknown.png");
                        }else{
                           echo site_url("upload/photo/".$data_pasien[0]['foto']);
                        }
                        ?>"></div>
                  </div>
                  <div class="col-sm-9">
                     <form target="_blank" action="<?php echo site_url('iri/ricstatus/cetak_list_pembayaran_pasien_simple'); ?>" method="post">
                        <table class="table-sm table-striped" style="font-size:15">
                           <tbody>
                              <tr>
                                 <th>Nama</th>
                                 <td>:&nbsp;</td>
                                 <td><?php echo $data_pasien[0]['nama'];?></td>
                              </tr>
                              <tr>
                                 <th>No. MedRec</th>
                                 <td>:&nbsp;</td>
                                 <td><?php echo $data_pasien[0]['no_cm'];?></td>
                              </tr>
                              <tr>
                                 <th>No. Register</th>
                                 <td>:&nbsp;</td>
                                 <td><?php echo $data_pasien[0]['no_ipd'];?></td>
                              </tr>
                              <tr>
                                 <th>Umur</th>
                                 <td>:&nbsp;</td>
                                 <td><?php
                                    $interval = date_diff(date_create(), date_create($data_pasien[0]['tgl_lahir']));
                                    echo $interval->format("%Y Tahun, %M Bulan, %d Hari");
                                    ?>
                                 </td>
                              </tr>
                              <tr>
                                 <th>Gol Darah</th>
                                 <td>:&nbsp;</td>
                                 <td><?php echo $data_pasien[0]['goldarah'];?></td>
                              </tr>
                              <tr>
                                 <th>Tanggal Kujungan</th>
                                 <td>:&nbsp;</td>
                                 <td><?php echo date("j F Y", strtotime($data_pasien[0]['tgl_masuk'])); ?></td>
                              </tr>
                              <tr>
                                 <th>Kelas</th>
                                 <td>:&nbsp;</td>
                                 <td><?php echo $data_pasien[0]['kelas'];?></td>
                              </tr>
                              <tr>
                                 <th>Total Pembayaran</th>
                                 <td>:&nbsp;</td>
                                 <td>Rp. <?php echo number_format($grand_total,0);?></td>
                              </tr>
                              <tr>
                                 <th></th>
                                 <td>&nbsp;</td>
                                 <td><a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $data_pasien[0]['no_ipd'];?>" target="_blank"><input type="button" class="btn btn-primary btn-sm" value="Cetak Faktur"></a></td>
                              </tr>
                              <tr>
                                 <th></th>
                                 <td>&nbsp;</td>
                                 <!-- <td><a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $data_pasien[0]['no_ipd'];?>" target="_blank"> <input type="button" class="btn btn-primary btn-sm" id="btn_simpan" value="Cetak Detail Pembayaran"></a></td> -->
                                 <td>
                                 <input type="hidden" value="<?php echo $data_pasien[0]['no_ipd'];?>" name="no_ipd" id="no_ipd">
                              </tr>
                     </tbody>
                     </table>
                  </div>
               </div>
               <br/>
            </div>
         </div>
      </div>
      <!-- <div class="col-sm-6">
         <div class="panel panel-default">
         	<div class="panel-heading" align="center">Pemerikasaan Lanjutan</div>
         	<div class="panel-body">
         	<br/>
         		<form action="<?php echo site_url('iri/rictindakan/update_tindakan_lain'); ?>" method="post">
         			<div class="form-group row">
         				<p class="col-sm-4 form-control-label" id="ket_pulang">Pilih Identitas</p>
         					<div class="col-sm-8">
         						<div class="form-inline">
         							<div class="form-group">
         								<select class="form-control" name="ket_pulang">
         									<option value="">-Pilih Ket Pulang-</option>
         									<option value="PULANG">PULANG</option>
         									<option value="DIPULANGKAN">DIPULANGKAN</option>
         									<option value="MENINGGAL">MENINGGAL</option>
         									<option value="MELARIKAN DIRI">MELARIKAN DIRI</option>
         								</select>
         							</div>
         						</div>
         					</div>
         			</div>
         			<div class="form-group row">
         				<p class="col-sm-4 form-control-label" id="ket_pulang">Diagnosa</p>
         					<div class="col-sm-8">
         						<div class="form-inline">
         							<div class="form-group">
         								<input type="text" value="" class="form-control input-sm auto_diagnosa_pasien" name="diagnosa1" id="diagnosa1" />
         							</div>
         						</div>
         					</div>
         			</div>
         			<div class="form-group row">
         				<div class="col-sm-8">
         					<label class="checkbox-inline">
         						<input type="checkbox" id="lab" name="lab" value="1" <?php if($data_pasien[0]['lab'] == 1){echo "checked='true'" ; }?> > Laboratotium
         					</label>
         					<label class="checkbox-inline">
         						<input type="checkbox" id="rad" name="rad" value="1" <?php if($data_pasien[0]['rad'] == 1){echo "checked='true'" ;}?>> Radiologi
         					</label>
         					<label class="checkbox-inline">
         						<input type="checkbox" id="obat" name="obat" value="1" <?php if($data_pasien[0]['obat'] == 1){echo "checked='true'" ;}?>> Obat
         					</label>
         				</div>
         			</div>
         			
         			<div class="form-inline" align="right">
         				<input type="hidden" class="form-control" value="<?php echo $data_pasien[0]['no_ipd'];?>" name="no_ipd">
         				<input type="hidden" class="form-control" value="" name="id_row_diagnosa" id="id_row_diagnosa">
         				<div class="form-group">
         					<button type="reset" class="btn btn-default btn-sm">Reset</button>
         					<input type="submit" class="btn btn-primary btn-sm" id="btn_simpan" value="Simpan">
         				</div>
         			</div>
         		</form>					</div>
         </div>
         </div> -->
   </div>
</section>

