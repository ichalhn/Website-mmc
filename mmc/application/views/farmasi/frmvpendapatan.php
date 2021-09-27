<?php $this->load->view("layout/header"); ?>
<?php // include('script_laprdpendapatan.php');	?>

<style>
    hr {
        border-color: #7DBE64 !important;
    }

    thead {
        background: #c4e8b6 !important;
        color: #4B5F43 !important;
        background: -moz-linear-gradient(top, #c4e8b6 0%, #7DBE64 100%) !important;
        background: -webkit-linear-gradient(top, #c4e8b6 0%, #7DBE64 100%) !important;
        background: linear-gradient(to bottom, #c4e8b6 0%, #7DBE64 100%) !important;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#c4e8b6', endColorstr='#7DBE64', GradientType=0) !important;
    }
</style>

<script type='text/javascript'>
    $(document).ready(function () {
        $('#tanggal_laporan').daterangepicker({
            opens: 'left',
            format: 'DD/MM/YYYY',
            startDate: moment(),
            endDate: moment(),
        });
    });
    function download() {
        var startDate = $('#tanggal_laporan').data('daterangepicker').startDate;
        var endDate = $('#tanggal_laporan').data('daterangepicker').endDate;
        startDate = startDate.format('YYYY-MM-DD');
        endDate = endDate.format('YYYY-MM-DD');
        jenis = $('#jenis_bayar').val();
        // date = document.getElementById('reservation');
        // alert(startDate);

        if(jenis != '') {
            swal({
                    title: "Download?",
                    text: "Download Laporan Keuangan Farmasi!",
                    type: "warning",
                    showCancelButton: true,
                    showLoaderOnConfirm: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ya!",
                    cancelButtonText: "Tidak!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        //    $.ajax({
                        // 	type:'POST',
                        // 	dataType: 'json',
                        // 	url:"<?php echo base_url('farmasi/frmclaporan/download_keuangan')?>",
                        // 	data: {
                        // 		tanggal_awal : startDate,
                        // 		tanggal_akhir : endDate
                        // 	},
                        // 	success: function(data){
                        //    swal("Download", "Sukses", "success");
                        // 	},
                        // 	error: function(){
                        // 		alert("error");
                        // 	}
                        // });
                        swal("Download", "Sukses", "success");
                        if(jenis == 'UMUM') {
                            window.open("<?php echo base_url('farmasi/frmclaporan/download_keuangan')?>/" + startDate + "/" + endDate + "/" + jenis);
                        }else{
                            window.open("<?php echo base_url('farmasi/frmclaporan/download_keuangan_new')?>/" + startDate + "/" + endDate + "/" + jenis);
                        }
                    } else {
                        swal("Close", "Tidak Jadi", "error");
                        document.getElementById("ok1").checked = false;
                    }
                }
            );
        }else{
            alert('Mohon Isi Jenis Bayar Terlebih Dahulu');
        }


    }
</script>

<section class="content-header">
    <?php //include('pend_cari.php');	?>


</section>

<section class="content">
    <div class="row">
        <div class="panel panel-default" style="width:97%;margin:0 auto">
            <div class="panel-heading">
                <h4 align="center">Laporan Keuangan Farmasi</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group">
                        <?php echo $message_nodata; ?>
                        <!-- Date range -->
                        <div class="col-lg-4">
                            <select name="jenis_bayar" id="jenis_bayar" class="form-control">
                                <option value="">-- Pilih Jenis Bayar --</option>
                                <option value="BPJS">BPJS</option>
                                <option value="UMUM">PC/ UMUM</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="tanggal_laporan"
                                       name="tanggal_laporan">
                            </div>
                            <!-- /.input group -->
                        </div>

                        <div class="col-lg-2">
							<span class="input-group-btn">
								<!-- <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit">Cari</button> -->
								<button class="btn btn-primary pull-right" type="button"
                                        onclick="download()">Download</button>
							</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</section>
<?php $this->load->view("layout/footer"); ?>
