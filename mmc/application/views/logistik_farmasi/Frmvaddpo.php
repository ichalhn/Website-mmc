<?php
  $this->load->view('layout/header.php');
?>
<script src="<?php echo site_url('asset/plugins/jquery-ui.min.js'); ?>"></script>
<style type="text/css">
    .ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight {
        border: 1px solid #dad55e;
        background: #fffa90;
        color: #777620;
        font-weight: normal;
    }
    .ui-widget-content {
        font-size: 15px;
    }
    .ui-widget-content .ui-state-active {
        font-size: 15px;
    }
    .ui-autocomplete-loading {
        background: white url("<?php echo site_url('assets/plugins/jquery/ui-anim_basic_16x16.gif'); ?>") right 10px center no-repeat;
    }
    .ui-autocomplete { max-height: 270px; overflow-y: scroll; overflow-x: scroll;}
</style>
<script type='text/javascript'>
Date.prototype.yyyymmdd = function() {
  var mm = this.getMonth() + 1; // getMonth() is zero-based
  var dd = this.getDate();

  return [this.getFullYear()+'-',
          (mm>9 ? '' : '0') + mm +'-',
          (dd>9 ? '' : '0') + dd +	'-'
         ].join('');
};

var table;
var ndata = 0;
$(function() {
	<?php echo $this->session->flashdata('cetak'); ?>
    document.getElementById("ppn_po").addEventListener("keypress", function (evt) {
        if (evt.which < 48 || evt.which > 57)
        {
            evt.preventDefault();
        }
    });

    //$('#detailObat').css("display", "");
	$('#cari_obat').focus();
    $("#satuanbesar").select2();
    $("#satuankecil").select2();

    $('#tgl_po').datepicker({ dateFormat: 'yy-mm-dd' });

	/*$('#cari_obat').autocomplete({
		serviceUrl: 'echo site_url();?>logistik_farmasi/Frmcpo/cari_data_obat_baru',
		onSelect: function (suggestion) {
			$('#cari_obat').val(''+suggestion.nama);
			$("#id_obat").val(suggestion.idobat);
			//$('#hargak').val(suggestion.hargabeli);
            $('#harga_po').val(suggestion.harga_po);
			$("#harga_po").focus();
		}
	});*/

    $("#cari_obat").autocomplete({
        minLength: 2,
        source : function( request, response ) {
            $.ajax({
                url: '<?php echo site_url('logistik_farmasi/Frmcpo/cari_data_obat_new')?>',
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function (data) {
                    if(!data.length){
                        var result = [{
                            label: 'Data tidak ditemukan',
                            value: response.term
                        }];
                        response(result);
                    } else {
                        response(data);
                    }
                }
            });
        },
        minLength: 1,
        select: function (event, ui) {
            $('#cari_obat').val(ui.item.value);
            $("#id_obat").val(ui.item.idobat);
            $('#harga_po').val(ui.item.harga_po);
            $("#harga_po").focus();
        }
    }).on("focus", function () {
        $(this).autocomplete("search", $(this).val());
    });

	var myDate = new Date(); 
	//$('#tgl_po').datepicker('setDate', myDate.yyyymmdd());
	table = $('#example').DataTable();
	$('#btnUbah').css("display", "none");
	$('#detailObat').css("display", "none");
   	$( "#vsupplier_id" ).change(function() {
		$('#vsupplier_id').prop('disabled', true);
		$('#btnUbah').css("display", "");
		$('#detailObat').css("display", "");
		$('#supplier_id').val( $( "#vsupplier_id" ).val() );
	});
	
   	$( "#btnUbah" ).click(function() {
		$('#vsupplier_id').prop('disabled', false);
		 $('#vsupplier_id option[value=""]').prop('selected', 'selected'); 
		 $('#supplier_id').val("");
		$('#vsupplier_id').focus();
		$('#btnUbah').css("display", "none");
		table.clear().draw();
		$('#detailObat').css("display", "none");
	});
	$( "#no_po" ).change(function() {
		var vno = $("#no_po").val();
		$.ajax({
		  dataType: "json",
		  type: 'POST',
		  data: {id:vno},
		  url: "<?php echo site_url(); ?>logistik_farmasi/Frmcpo/is_exist",
		  success: function( response ) {
			if(response.exist > 0){
				alert("Nomor PO "+vno+" sudah pernah diinputkan pada tanggal "+response.tgl);
				$( "#no_po" ).val('');
				$( "#no_po" ).focus();
			}
		  }
		})
	});
	$("#jml_kemasan").change(function(){
		var jml = $("#jml_kemasan").val();
		var harga = $("#harga_po").val();

		total = parseFloat(harga)/ parseFloat(jml);
		$("#hargak").val(total.toFixed(0));
	});
		
   	$( "#btnTambah" ).click(function() {
		addItems();		
	});

	$("#hargak").keyup(function(event){
	    if(event.keyCode == 13){
	        addItems();
	    }
	});


	$('#example tbody').on( 'click', 'button.btnDel', function () {
		table.row( $(this).parents('tr') ).remove().draw();
		populateDataObat();
	} );

	$('#example tbody').on( 'click', 'button.btnEdit', function () {
	    var row = table.row( $(this).parents('tr') ).data();
        console.log( row );

        $("#cari_obat").focus();
        $('#id_obat').val(row[0]);
        $("#cari_obat").val(row[1]);
        $('#satuanbesar')
            .append('<option selected value="'+row[2]+'">'+row[2]+'</option>');
        $('#satuanbesar').trigger('change');
        $('#harga_po').val(row[3]);
        $('#jml').val(row[4]);
        $('#jml_kemasan').val(row[5]);
        $('#hargak').val(row[6]);
        $('#satuankecil')
            .append('<option selected value="'+row[7]+'">'+row[7]+'</option>');
        $('#satuankecil').trigger('change');
        $('#diskon_persen').val(row[8]);

        table.row( $(this).parents('tr') ).remove().draw();
        populateDataObat();
    });

   	$( "#btnSimpan" ).click(function() {
		if (ndata == 0){
			alert("Silahkan input data obat");
			$('#id_obat').focus();
		}else if($("#ppn_po").val() === ""){
		    swal("Perhatian", "PPN Tidak Boleh Kosong!", "warning");
		    $("#ppn_po").focus();
        }else {
            $("#frmAdd").submit();
        }
		// data = document.getElementById("dataobat").value;
		// alert(data);
	});
});

function addItems(){
    var satuanbesar = $("#satuanbesar").find("option:selected").text();
    var satuankecil = $("#satuankecil").find("option:selected").text();

    if(satuanbesar === "" || satuanbesar === ""){
        swal("Perhatian", "Lengkapi Data!", "warning");
    }else {

        table.row.add([
            $('#id_obat').val(),
            $("#cari_obat").val(),
            satuanbesar,
            $('#harga_po').val(),
            $('#jml').val(),
            $('#jml_kemasan').val(),
            $('#hargak').val(),
            satuankecil,
            $('#diskon_persen').val(),
            '<center><button type="button" class="btnDel btn btn-primary btn-xs" title="Hapus">Hapus</button></center>&nbsp;&nbsp;' +
            '<center><button type="button" class="btnEdit btn btn-primary btn-xs" title="Edit">Edit</button></center>'
        ]).draw(false);

        $('#id_obat').val("");
        $('#cari_obat').val("");
        $('#satuanbesar').val("").trigger("change");
        $('#harga_po').val("");
        $('#jml').val("");
        $('#hargak').val("");
        $('#diskon_persen').val("");
        $('#jml_kemasan').val("");
        $('#satuankecil').val("").trigger("change");
        $('#cari_obat').focus();

        populateDataObat();
    }
}


function populateDataObat(){
	vjson = table.rows().data();
	ndata = vjson.length;
	var vjson2= [[]];
    var total = 0;
	jQuery.each( vjson, function( i, val ) {
        total += vjson[i][4] * vjson[i][3];
		vjson2[i] = {
			"item_id": vjson[i][0], 
			"description":vjson[i][1], 
			"satuank":vjson[i][2],
			"harga_po":vjson[i][3],
			"qty":vjson[i][4],
			"jml_kemasan":vjson[i][5],
			"harga_item":vjson[i][6],
			"satuan_item":vjson[i][7],
			"diskon_persen":vjson[i][8]
		} ;
	});
	$('#dataobat').val( JSON.stringify(vjson2) );
    $("#subtotal_po").text(total.formatMoney(0, ',', '.'));
    $("#subtotal_po2").val(total);
}

Number.prototype.formatMoney = function(c, d, t){
    var n = this,
        c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};
function cetak(id){
    window.open(baseurl+'download/logistik_farmasi/PO/FP_'+id+'.pdf', '_blank');
	/*var win = window.open(baseurl+'download/logistik_farmasi/PO/FP_'+id+'.pdf', '_blank');
	if (win) {
		//Browser has allowed it to be opened
		win.focus();
	} else {
		//Browser has blocked it
		alert('Please allow popups for this website');
	}*/
}

function setTotakhir() {
    var ppn = parseInt($("#ppn_po").val());
    var subtotal = parseInt($("#subtotal_po2").val());

    var total = ((ppn / 100) + 1) * subtotal;

    $("#total_po").html('<span style="font-size: 24px; font-weight: bold;" id="total_po">'+ total.formatMoney(0, ',', '.') +'</span>');
    $("#total_akhir").val(total);
}

function getNomorPO() {
    var tanggal = $("#tgl_po").val();

    $.ajax({
        dataType: 'json',
        type: 'POST',
        data:{
            tanggal: tanggal
        },
        url: "<?php echo site_url(); ?>logistik_farmasi/Frmcpo/getNomorPOCari",
        success: function (data) {
            //alert(data.data);
            $("#no_po").val(data.data);
        }
    });
}
    
</script>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
			<div class="row">
			  <div class="col-xs-9" id="alertMsg">	
					<?php echo $this->session->flashdata('alert_msg'); ?>
			  </div>
			  <div class="col-xs-3" align="right">
				<div class="input-group">
				  <span class="input-group-btn">
					<a type="button" class="btn btn-primary pull-right" href="<?php echo site_url('logistik_farmasi/Frmcpo');?>"><i class="fa fa-book"> &nbsp;Monitoring PO</i> </a>
				  </span>
				</div><!-- /input-group --> 
			  </div>
			</div>
		  <hr/>
        </div>
        
        <div class="box-body">
			<?php echo form_open('logistik_farmasi/Frmcpo/save',array('id'=>'frmAdd','method'=>'post')); ?>
            <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Tanggal PO</p>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" name="tgl_po" id="tgl_po" onchange="getNomorPO()" required value="<?=date('Y-m-d')?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nomor PO</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="no_po" id="no_po" required value="<?=$no_po?>">
                    </div>
                  </div>                 
                  <div class="form-group row">
                   <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lsupplier">Jenis Pesanan</p>
                      <div class="col-sm-6">
						  <select class="form-control" name="sumber_dana" id="sumber_dana">
							<option value="" disabled selected>----- Pilih Jenis Pesanan -----</option>
							<option value="BPJS">BPJS</option>
							<option value="Umum">Umum</option>
							<option value="Radiologi">Radiologi</option>
							<option value="Laboratorium">Laboratorium</option>
							<option value="Gigi">Gigi</option>
							<option value="Alkes">Alkes</option>
							<option value="RS">RS</option>
							<!--<option value="Subsidi">Subsidi</option>-->
						  </select>
                      </div>
                  </div>             
                  <div class="form-group row">
                   <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lsupplier">Supplier</p>
                      <div class="col-sm-6">

                      <select name="vsupplier_id" id="vsupplier_id" class="form-control js-example-basic-single" required>
								<option value="" selected>---- Pilih Supplier ----</option>
								<?php
								  foreach($select_pemasok as $row){
									echo '<option value="'.$row->person_id.'">'.$row->company_name.'</option>';
								  }
								?>
                        </select>
                      </div>
                    <div class="col-sm-2">
						<a class="btn btn-default" id="btnUbah">Ubah Pemasok</a>
					</div>
                  </div>
				<input type="hidden" id="user" name="user" value="<?php echo $user_info->username; ?>"/>
				<input type="hidden" id="supplier_id" name="supplier_id"/>
            </div>
			<div class="modal-footer">
				<div id="detailObat">
				<div class="panel-body">
					<br/>
					<div class="form-group row">
						<p class="col-sm-2 form-control-label">Nama Obat</p>
						<div class="col-sm-4">
							<input type="search" class="form-control" id="cari_obat" name="cari_obat" placeholder="Pencarian Obat">
							<input type="hidden" name="id_obat" id="id_obat">
						</div>
					</div>
					<div class="form-group row">
						<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Obat</p>
						<div class="col-sm-2">
							<input type="number" class="form-control" name="harga_po" id="harga_po" >
						</div>
					</div>
					<div class="form-group row">
						<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Jumlah PO</p>
						<div class="col-sm-2">
							<input type="number" class="form-control" name="jml" id="jml" min=1 >
						</div>
					</div>
					<div class="form-group row">
						<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Satuan Besar PO</p>
						<div class="col-sm-3">
							<select id="satuanbesar" class="form-control select2" name="satuanbesar">
								<option value="">-Satuan Besar-</option>
								<?php
								foreach ($obat_satuan as $row) {
									echo "<option value='".$row->id_satuan."'>".$row->nm_satuan."</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Jumlah Kemasan</p>
						<div class="col-sm-2">
							<input type="number" class="form-control" name="jml_kemasan" id="jml_kemasan" min=1 >
						</div>
					</div>
					<div class="form-group row">
						<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Satuan Kemasan (item)</p>
						<div class="col-sm-3">
							<select id="satuankecil" class="form-control select2" name="satuankecil">
								<option value="">-Satuan Kecil-</option>
								<?php
								foreach ($obat_satuan as $row) {
									echo "<option value='".$row->id_satuan."'>".$row->nm_satuan."</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Satuan</p>
						<div class="col-sm-2">
							<input type="text" class="form-control" name="hargak" id="hargak">
						</div>
					</div>
                    
                    <div class="form-group row">
						<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Diskon %</p>
						<div class="col-sm-2">
							<input type="text" class="form-control" name="diskon_persen" id="diskon_persen">
						</div>
					</div>

					<div class="form-group row">
						<div class="col-sm-2">
							<a class="btn btn-primary" id="btnTambah">Tambahkan</a>
						</div>
					</div>
					<br/>
				<table id="example" class="display" cellspacing="0" width="100%">
				  <thead>
				  <tr>
					<th><p align="center">ID Obat</p></th>
					<th><p align="center">Nama Obat</p></th>
					<th><p align="center">Satuan</p></th>
					<th><p align="center">Harga</p></th>
					<th><p align="center">Jumlah PO</p></th>
					<th><p align="center">Jumlah<br>Kemasan</p></th>
					<th><p align="center">Harga<br>Satuan</p></th>
					<th><p align="center">Satuan<br>Kecil</p></th>
					<th><p align="center">Diskon %</p></th>
					<th><p align="center">Aksi</p></th>
				  </tr>
				  </thead>
				</table>
                <br/>
                <div class="form-group row">
                    <p class="col-sm-8 form-control-label"><span style="font-size: 24px; font-weight: bold;">Subtotal </span></p>
                    <div class="col-sm-4">
                        <span style="font-size: 24px; font-weight: bold;" id="subtotal_po"></span>
                        <input type="hidden" id="subtotal_po2" name="subtotal_po2"/>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-8 form-control-label"><span style="font-size: 24px; font-weight: bold;">PPN </span></p>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon">%</span>
                            <input type="text" class="form-control" placeholder="Persen" name="ppn_po" id="ppn_po" required>

                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" onclick="setTotakhir()">Input</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-8 form-control-label"><span style="font-size: 24px; font-weight: bold;">Total </span></p>
                    <div class="col-sm-4" id="total_po">
                        <div id="total_po"></div>
                    </div>
                </div>
				<br/><br/>
                <div class="form-group row">
                    <p class="col-sm-8 form-control-label"></p>
                    <div class="col-sm-4" id="total_po">
                        <button type="button" class="btn btn-success" id="btnSimpan">Simpan</button>
                        <input type="hidden" id="total_akhir" name="total_akhir"/>
                    </div>
                </div>
				</div>
				<input type="hidden" name="dataobat" id="dataobat">

				</div>
				</div>
				<?php echo form_close();?>
        </div>
       </div>
      </div>
     </div>
</section>
<?php
  $this->load->view('layout/footer.php');
?>