<?php $this->load->view("layout/header"); ?>
<?php $this->load->view("iri/layout/script_addon"); ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>
<div >
	<div >
		
		<!-- Keterangan page -->
		<section class="content-header">
			<h1>PASIEN DALAM PERAWATAN</h1>	
			<h5><?php echo $akses;?></h5>		
		</section>
		<!-- /Keterangan page -->

        <!-- Main content -->
        <!-- <section class="content">
			<div class="row">
				<div class="col-sm-12">
					
				
					<div class="box box-success">
						<br/>
						<div class="box-body">
							<table id="dataTables-example" class="table table-bordered table-striped data-table">
								<thead>
									<tr>
										<th>Tgl. Masuk</th>
										<th>No. Register</th>
										<th>Nama</th>
										<th>Kelas</th>
										<th>No. Bed</th>
										<th>Penjamin</th>
										<th>Dokter Yang Merawat</th>
										<th>LOS</th>
										<th>Total Biaya</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
					
					
				</div>
			</div>
		</section> -->

		<section class="content" style="width:98%;">
				<div class="row">
					<?php echo $this->session->flashdata('pesan');?>
						<div class="panel panel-info">
							<div class="panel-body">
								<br/>
						<div >
						<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example" style="display:block;overflow:auto; responsive-table">
						  <thead>
							<tr>
								<th>No. Register</th>
								<th>No. MedRec</th>
								<th>Nama</th>
                <th>Tentara</th>
								<th>Kamar</th>
								<th>Kelas</th>
								<th>No. Bed</th>
								<th>Tgl. Masuk</th>
								<th>Dokter Yang Merawat</th>
								<th>Bayi</th>
								<th>Cara Bayar</th>
								<th>Aksi</th>
							</tr>
						  </thead>
						  	<tbody>
						  	<?php
							if($list_pasien!=''){
						  	foreach ($list_pasien as $r) { ?>
						  	<tr>
						  		<td><?php echo $r['no_ipd']?></td>
						  		<td><?php echo $r['no_cm']?></td>
						  		<td><?php echo $r['nama']?></td>
                  <td><?php echo $r['tentara']?></td>
						  		<td><?php echo $r['nmruang']?></td>
						  		<td><?php echo $r['kelas']?></td>
						  		<td><?php echo $r['bed']?><br>
						  		<?php if($roleid==1 or $roleid==10 or $roleid==23 or $roleid==22 or $roleid==8){
								?>
										<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onClick="edit_ruangan('<?php echo $r['no_ipd'];?>')">Ganti Ruangan</button>
				                <?php
								} 
								?>
						  		</td>
						  		<td>
					  			<?php 						  		

						  		echo date('d-m-Y',strtotime($r['tglmasukrg']));
						  		?>
						  		</td>
						  		<td><?php echo $r['dokter']?></td>
						  		<td><?php 
						  			if($r['status_bayi'] == 0){
						  				echo "Tidak Punya";
						  			}else{
						  				echo "Punya";
						  			}
						  			?>
						  		</td>
						  		<td><?php if($r['cara_bayar']=='BPJS'){ echo $r['nmkontraktor']; } else echo $r['cara_bayar']; ?></td>
						  		<td>
						  		<a href="<?php echo base_url(); ?>iri/rictindakan/index/<?php echo $r['no_ipd']?>"><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-plusthick"></i> Tindak</button></a>
						  		<a href="<?php echo base_url(); ?>iri/ricreservasi/index/<?php echo $r['no_ipd']?>/1"><button type="button" class="btn btn-default btn-sm"><i class="fa fa-plusthick"></i> Mutasi</button></a>
						  		<a href="<?php echo base_url(); ?>iri/ricstatus/index/<?php echo $r['no_ipd']?>"><button type="button" class="btn btn-warning btn-sm"><i class="fa fa-plusthick"></i> Status</button></a>
						  		<a href="<?php echo base_url(); ?>iri/ricstatus/cetak_sep/<?php echo $r['no_ipd']?>" target="_blank"><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-plusthick"></i> Cetak SEP</button></a>
						  		</td>
						  	</tr>
						  	<?php
						  	}}
						  	?>
							</tbody>
						</table>
            <hr>
            <p>* Keterangan kolom tentara<br>N = No NRP/NIP | S = Status | P = Pangkat | K = Kesatuan</p>

						</div><!-- style overflow -->
					</div><!--- end panel body -->
				</div><!--- end panel -->
				</div><!--- end panel -->
			</section>
		<!-- /Main content -->
		
	</div>
</div>

  <!-- eDIT Modal -->
  <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Ruangan</h4>
        </div>
        <div class="modal-body">
          <form action="#" id="formedit" class="form-horizontal">
            <div class="form-group row">
              <div class="col-sm-1"></div>
              <p class="col-sm-3 form-control-label" id="lbl_nama">No Registrasi</p>
              <div class="col-sm-6">
                <input type="hidden" class="form-control" name="idrgiri" id="idrgiri">
                <input type="hidden" class="form-control" name="no_ipd" id="no_ipd">
                <input type="text" class="form-control" name="edit_no_ipd" id="edit_no_ipd"  disabled="">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-1"></div>
              <p class="col-sm-3 form-control-label" id="lbl_nama">No Medrec</p>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="edit_no_cm" id="edit_no_cm" disabled="">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-1"></div>
              <p class="col-sm-3 form-control-label" id="lbl_nama">Nama Pasien</p>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="edit_nama" id="edit_nama" disabled="">
              </div>
            </div>
            <hr>
            <div class="form-group row">
              <div class="col-sm-1"></div>
              <p class="col-sm-3 form-control-label" id="lbl_nama">Kode Ruang / Bed</p>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="edit_bed" id="edit_bed"  disabled="">
                <input type="hidden" class="form-control" name="bed_asal" id="bed_asal">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-1"></div>
              <p class="col-sm-3 form-control-label" id="lbl_nama">Nama Ruangan</p>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="edit_nmruang" id="edit_nmruang"  disabled="">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-1"></div>
              <p class="col-sm-3 form-control-label" id="lbl_nama">Kelas</p>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="edit_klsiri" id="edit_klsiri"  disabled="">
              </div>
            </div>
            <hr>
            <div class="form-group row">
              <div class="col-sm-1"></div>
              <p class="col-sm-3 form-control-label" id="lbl_nama">Ganti Ruang</p>
              <div class="col-sm-6">
				<select id="ruang" class="form-control" name="ruang" onchange="get_bed(this.value)" required>
				</select>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-1"></div>
              <p class="col-sm-3 form-control-label" id="lbl_nama">Ganti Bed</p>
              <div class="col-sm-6">
				<select class="form-control input-sm" id="bed" name="bed" required>
					
				</select>
              </div>
            </div>
          </div>
        </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" id="btnEdit" onclick="edit()" class="btn btn-primary">Edit Ruangan</button>
        </div>
      </div>
    </div>
  </div>
<script>
	$(document).ready(function() {
		var dataTable = $('#dataTables-example').DataTable( {
			
		});
	});
	$('#calendar-tgl').datepicker();



  function edit_ruangan(no_ipd) {
    $('#edit_no_ipd').val('');
    $('#edit_no_ipd_hide').val('');
    $('#edit_no_cm').val('');
    $('#edit_nama').val('');
    $('#edit_bed').val('');
    $('#edit_nmruang').val('');
    $('#edit_klsiri').val('');
    $('#bed').val('');
    // $('#edit_paket').iCheck('uncheck');
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('iri/ricpasien/get_data_edit_ruangan')?>",
      data: {
        no_ipd: no_ipd
      },
      success: function(data){
        $('#idrgiri').val(data.response[0].idrgiri);
        $('#no_ipd').val(data.response[0].no_ipd);
        $('#edit_no_ipd').val(data.response[0].no_ipd);
        $('#edit_no_cm').val(data.response[0].no_cm);
        $('#edit_nama').val(data.response[0].nama);
        $('#edit_bed').val(data.response[0].bed);
        $('#bed_asal').val(data.response[0].bed);
        $('#edit_nmruang').val(data.response[0].nmruang);
        $('#edit_klsiri').val(data.response[0].klsiri);

        var options, index, select, option;

	    // Get the raw DOM object for the select box
	    select = document.getElementById('ruang');

	    // Clear the old options
	    select.options.length = 0;

	    // Load the new options
	    options = data.options; // Or whatever source information you're working with
	    select.options.add(new Option('Pilih Ruangan', ''));
	    for (index = 0; index < options.length; ++index) {
	      option = options[index];
	      select.options.add(new Option(option.text, option.idrg));
	    }
      },
      error: function(){
        alert("error");
      }
    });
  }



  function get_bed(val){
	$('#bed')
        .find('option')
        .remove()
        .end()
    ;
    $("#bed").append("<option value=''>Loading...</option>");
	$.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>iri/ricmutasi/get_empty_bed_select/",
        data:   {
                    val        : val
                },
    }).done(function(msg) {
    	$('#bed')
            .find('option')
            .remove()
            .end()
        ;
        $("#bed").append(msg);
    });
  }

  function edit()
  {
    $('#btnEdit').text('saving...'); //change button text
    $('#btnEdit').attr('disabled',true); //set button disable 
    var url;

    url = "<?php echo site_url('iri/ricpasien/edit_ruangan')?>";  

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#formedit').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            // $('#editModal').modal('hide');

            $('#btnEdit').text('Edit Ruangan'); //change button text
            $('#btnEdit').attr('disabled',false); //set button enable 

            if(data.sukses){
            	location.reload(true);
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $('#editModal').modal('hide');
            // alert('Error adding / update data');
            $('#btnEdit').text('Edit Ruangan'); //change button text
            $('#btnEdit').attr('disabled',false); //set button enable 

        }
    });
  }

</script>

<?php $this->load->view("layout/footer"); ?>
