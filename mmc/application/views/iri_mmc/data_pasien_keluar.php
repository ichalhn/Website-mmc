
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
		}
	});
});

   function rawat_lagi(no_ipd){
      swal({
         title: "Kembalikan Pasien",
         text: "Benar Akan Memasukkan Pasien Ke ruangan?",
         type: "info",
         showCancelButton: true,
         closeOnConfirm: false,
         showLoaderOnConfirm: true,
      },
      function(){
         location.href = '<?php echo base_url("iri/rickwitansi/balikan_keruangan"); ?>/'+no_ipd;
      });
   }

function update_cara_bayar(val){
	var r = confirm("Anda yakin ingin mengembalikan pasien ?");
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
   var total = "<?php echo $total; ?>";
   //var jasa_perawat = "<?php echo $jasa_perawat; ?>";
   var biaya_daftar = "<?php echo $biaya_daftar; ?>";
	var biaya_awal = $('#total_gabungan').val();
   var biaya_awal_pembulatan = $('#total_gabungan_pembulatan').val();

   //var uang_muka = $('#uang_muka').val();
   var biaya_administrasi = $('#biaya_administrasi').val();
   var dibayar_tunai = $('#dibayar_tunai').val();
   var denda = $('#denda').val();
   var obat = $('#biaya_obat').val();
   //var dibayar_kartu_cc_debit = $('#dibayar_kartu_cc_debit').val();
   //var charge = $('#charge').val();
   //var total_charge = dibayar_kartu_cc_debit * charge / 100;
   var diskon = $('#diskon').val();
   if(biaya_administrasi == ""){
      biaya_administrasi = 0;
   }
   if(dibayar_tunai == ""){
      dibayar_tunai = 0;
   }
   if(obat == ""){
      obat = 0;
   }
   if(denda == ""){
      denda = 0;
   }
   /*if(dibayar_kartu_cc_debit == ""){
      dibayar_kartu_cc_debit = 0;
   }
   if(charge == ""){
      charge = 0;
   }
   if(total_charge == ""){
      total_charge = 0;
   }*/
   if(diskon == ""){
      diskon = 0;
   }

   if(parseInt(obat)!=0){
      if(biaya_administrasi<750000){      
      biaya_administrasi=(parseInt(total)+parseInt(obat))*0.1;
      //alert(biaya_administrasi);
      $('#biaya_administrasitxt').html("Rp. "+biaya_administrasi.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")); 
      $('#biaya_administrasi').text(biaya_administrasi);    
      }else if(biaya_administrasi>750000){
         biaya_administrasi=(parseInt(total)+parseInt(obat))*0.1;  
         $('#biaya_administrasitxt').html("Rp. "+biaya_administrasi.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")); 
         $('#biaya_administrasi').text(biaya_administrasi);          
      }
      biaya_awal=parseInt(total)+parseInt(biaya_administrasi)+parseInt(biaya_daftar)+6000; //parseInt(jasa_perawat)+
   }
   

	var biaya_akhir = parseInt(dibayar_tunai); //+ parseInt(dibayar_kartu_cc_debit) + parseInt(total_charge);
   var total_harga_gabungan = parseInt(biaya_awal) - parseInt(diskon) + parseInt(denda) + parseInt(obat);
   var total_harga_gabungan_pembulatan = parseInt(biaya_awal_pembulatan) - parseInt(diskon) + parseInt(denda) + parseInt(obat);
   
   // var biaya_dibayar = (parseInt(biaya_akhir) + parseInt(biaya_awal));
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
                     <form target="_blank" action="<?php echo site_url('iri/ricstatus/cetak_list_pembayaran_pasien_simple2'); ?>" method="post">
                        <table class="table-sm table-striped" style="font-size:15">
                           <tbody>
                              <tr>
                                 <th>Nama</th>
                                 <td>:&nbsp;</td>
                                 <td><?php echo $data_pasien[0]['nama'];?></td>
                              </tr>
                              <tr>
                                 <th>No. MR</th>
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
                                 <th>Tanggal Kunjungan</th>
                                 <td>:&nbsp;</td>
                                 <td><?php echo date("j F Y", strtotime($data_pasien[0]['tgl_masuk'])); ?></td>
                              </tr>
                              <tr>
                                 <th>Kelas</th>
                                 <td>:&nbsp;</td>
                                 <td><?php echo $data_pasien[0]['kelas'];?></td>
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
       <div class="col-sm-6">
         <div class="panel panel-default">
            <div class="panel-heading" align="center">Pembayaran</div>
            <div class="panel-body">
               <br/>
               <div class="row">
                  <div class="col-sm-12">
                     <form target="_blank" action="<?php echo site_url('iri/ricstatus/cetak_list_pembayaran_pasien/$data_pasien[0]["no_ipd"]/2'); ?>" method="post">
                        <table class="table-sm table-striped" style="font-size:15">
                           <tbody>
                              <tr>
                                 <th>Cara Bayar</th>
                                 <td>:&nbsp;</td>
                                 <td>
                                    <?php echo $data_pasien[0]['carabayar'];?>
                                    <!-- <select name="carabayar" onchange="update_cara_bayar(this.value)">
                                       <?php
                                          foreach ($cara_bayar as $r) { 
                                          	if($r['cara_bayar'] == $data_pasien[0]['carabayar']){ ?>
                                       	<option value="<?php echo $r['cara_bayar'] ;?>" selected><?php echo $r['cara_bayar'] ;?></option>
                                       	<?php
                                          }else{ ?>
                                       	<option value="<?php echo $r['cara_bayar'] ;?>"><?php echo $r['cara_bayar'] ;?></option>
                                       	<?php
                                          }
                                          ?>
                                       <?php
                                          }
                                          ?>
                                       ?> -->
                                 </td>
                              </tr>
                              <tr>
                                 <th></th>
                                 <td>&nbsp;</td>
                                 <td>
                                    <?php echo $data_pasien[0]['nmkontraktor'];?>                             
                                 </td>
                              </tr>
                              <tr>
                                 <th>Jenis Pembayaran</th>
                                 <td>:&nbsp;</td>
                                 <td>
                                    <select name="jenis_pembayaran">
                                       <?php
                                          if($data_pasien[0]['carabayar'] == 'UMUM'){ ?>
                                       <option value="TUNAI" selected>TUNAI</option>
                                       <option value="KREDIT">KREDIT</option>
                                       <?php
                                          }else{ ?>
                                       <option value="TUNAI">TUNAI</option>
                                       <option value="KREDIT" selected>KREDIT</option>
                                       <?php
                                          }
                                          ?>
                                    </select>
                                 </td>
                              </tr>
                              <tr>
                                 <th>Biaya Total</th>
                                 <td>:&nbsp;</td>
                                 <td>Rp. <?php echo number_format($total,0);?></td>
                                 <input type="hidden" value="<?php echo $total;?>" id="biaya_total" name="biaya_total">
                              </tr>
                              <tr>
                                 <th>Biaya Administrasi</th>
                                 <td>:&nbsp;</td>
                                 <td> <div id="biaya_administrasitxt">Rp. <?php echo number_format($biaya_administrasi,0);?></div></td>
                                 <input type="hidden" value="<?php echo $biaya_administrasi;?>" id="biaya_administrasi" name="biaya_administrasi">
                              </tr>
                              
                              <tr>
                                 <th>Biaya Materai</th>
                                 <td>:&nbsp;</td>
                                 <td>Rp. <?php echo number_format(6000,0);?></td>
                                 <input type="hidden" value="6000" id="biaya_materai" name="biaya_materai">
                              </tr>
                              <tr>
                                 <th>Biaya Pendaftaran</th>
                                 <td>:&nbsp;</td>
                                 <td>Rp. <?php echo number_format($biaya_daftar,0);?></td>
                                 <input type="hidden" value="<?php echo $biaya_daftar;?>" id="biaya_daftar" name="biaya_daftar">
                              </tr>                              
                              <tr>
                                 <th>Total Harga Gabungan</th>
                                 <td>:&nbsp;</td>
                                 <td>
                                    <div id="total_harga_gabungan">Rp. <?php echo number_format($grand_total,0);?></div>
                                 </td>
                                 <input type="hidden" value="<?php echo $grand_total;?>" id="total_gabungan">
                                 <input type="hidden" value="<?php echo $grand_total_pembulatan;?>" id="total_gabungan_pembulatan">
                              </tr>
                              <!--<tr>
                                 <th>Jasa Perawat</th>
                                 <td>:&nbsp;</td>
                                 <td>Rp. <?php echo number_format($jasa_perawat,0);?></td>
                                 <input type="hidden" value="<?php echo $jasa_perawat;?>" id="jasa_perawat" name="jasa_perawat">
                              </tr><tr>
                                 <th>Uang Muka Pasien</th>
                                 <td>:&nbsp;</td>
                                 <td><input type="number" name="uang_muka" id="uang_muka" class="form-control" onchange="set_total(this.value)" value="0"></td>
                              </tr>-->
                              <tr>
                                 <th>Biaya Obat</th>
                                 <td>:&nbsp;</td>
                                 <td><input type="number" name="biaya_obat" id="biaya_obat"  class="form-control" onchange="set_total(this.value)" value="0"></td>
                              </tr>
                              <tr>
                                 <th>Dibayar Tunai</th>
                                 <td>:&nbsp;</td>
                                 <td><input type="number" name="dibayar_tunai" id="dibayar_tunai" class="form-control" onchange="set_total(this.value)" value="0"></td>
                              </tr>                              
                              <!--<tr>
                                 <th>Dibayar Kartu Kredit/Debit</th>
                                 <td>:&nbsp;</td>
                                 <td><input type="number" name="dibayar_kartu_cc_debit" id="dibayar_kartu_cc_debit" class="form-control" onchange="set_total(this.value)" value="0"></td>
                              </tr>
                               <tr>
                                 <th>Nomor Kartu Kredit</th>
                                 <td>:&nbsp;</td>
                                 <td><input type="text" name="no_kartu_kredit" id="no_kartu_kredit" class="form-control" onchange="set_total(this.value)" value="0"></td>
                              </tr>
                              <tr>
                                 <th>Charge * (%)</th>
                                 <td>:&nbsp;</td>
                                 <td><input type="number" name="charge" id="charge" class="form-control" onchange="set_total(this.value)" value="0"></td>
                              </tr>
                              <tr>
                                 <th>Nominal Charge</th>
                                 <td>:&nbsp;</td>
                                 <td><input type="number" name="nominal_charge" id="nominal_charge" class="form-control" disabled="true" value="0"></td>
                              </tr>-->
                              
                              <tr>
                                 <th>Potongan</th>
                                 <td>:&nbsp;</td>
                                 <td><input type="number" name="diskon" id="diskon" class="form-control" onchange="set_total(this.value)" value="0"></td>
                              </tr>
                              <tr>
                                 <th>Denda Keterlambatan</th>
                                 <td>:&nbsp;</td>
                                 <td><input type="number" name="denda" id="denda" class="form-control" onchange="set_total(this.value)" value="0"></td>
                              </tr>
                              <tr>
                                 <th></th>
                                 <td></td>
                                 <td><input type="button" value="Kalkukasi Total Harga"></td>
                              </tr>
                              <tr>
                                 <th>Total Dibayar Pasien</th>
                                 <td>:&nbsp;</td>
                                 <td>
                                    <div id="grand_total_show">Rp. 0</div>
                                 </td>
                              </tr>
                              <tr>
                                 <th>Catatan</th>
                                 <td>:&nbsp;</td>
                                 <td>
                                    <!-- <input type="number" name="diskon" id="diskon" class="form-control input-sm"> -->
                                    <textarea rows="4" cols="50" class="form-control input-sm" name="remark" id="remark"></textarea>
                                 </td>
                              </tr>
                              <tr>
                                 <th>Penerima</th>
                                 <td>:&nbsp;</td>
                                 <td><input type="text" name="penerima" id="penerima" class="form-control input-sm" value="<?php echo $data_pasien[0]['nama'];?>" required></td>
                              </tr>
                              <tr>
                                 <th></th>
                                 <td>&nbsp;</td>
                                 <!-- <td><a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $data_pasien[0]['no_ipd'];?>" target="_blank"> <input type="button" class="btn btn-primary btn-sm" id="btn_simpan" value="Cetak Detail Pembayaran"></a></td> -->
                                 <td><input type="submit" class="btn btn-primary btn-sm" id="btn_simpan" value="Cetak Kwitansi"> <a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $data_pasien[0]['no_ipd'].'/1';?>" target="_blank"><input type="button" class="btn btn-primary btn-sm" value="Cetak Faktur"></a></td>
                                 <input type="hidden" value="<?php echo $data_pasien[0]['no_ipd'];?>" name="no_ipd" id="no_ipd">                                 
                              </tr>
                              <tr>
                                 <th colspan="3">* Input biaya TUNAI untuk pasien BPJS 0 rupiah dan potongan sesuai total tagihan</th>                                 
                              </tr>
                              <tr>
                                 <th colspan="3">* Klik cetak faktur pasien untuk Arsip setelah Cetak Kwitansi</th>
                              </tr>
                              <tr>
                                 <th colspan="3">
                                    <button type="button" id="submit" onclick="rawat_lagi('<?php echo $data_pasien[0]['no_ipd'];?>')" class="btn btn-danger">Kembalikan Keruangan</button>
                                 </th>
                              </tr>
                     </form>
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
         		<form action="<?php //echo site_url('iri/rictindakan/update_tindakan_lain'); ?>" method="post">
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

