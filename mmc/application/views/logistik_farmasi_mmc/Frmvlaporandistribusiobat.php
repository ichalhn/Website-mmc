<?php
/**
 * Created by PhpStorm.
 * User: apandhis
 * Date: 01/08/17
 * Time: 16:05
 */
$this->load->view("layout/header");
?>

<style>
    hr {
        border-color:#7DBE64 !important;
    }

    thead {
        background: #c4e8b6 !important;
        color:#4B5F43 !important;
        background: -moz-linear-gradient(top,  #c4e8b6 0%, #7DBE64 100%) !important;
        background: -webkit-linear-gradient(top,  #c4e8b6 0%,#7DBE64 100%) !important;
        background: linear-gradient(to bottom,  #c4e8b6 0%,#7DBE64 100%) !important;
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c4e8b6', endColorstr='#7DBE64',GradientType=0 )!important;
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
    function download(){
        var startDate = $('#tanggal_laporan').data('daterangepicker').startDate;
        var endDate = $('#tanggal_laporan').data('daterangepicker').endDate;
        startDate = startDate.format('YYYY-MM-DD');
        endDate = endDate.format('YYYY-MM-DD');
        var filter = $("#filter").val();
        var nip_serah = $('#nip_menyerahkan').val();
        var nip_terima = $('#nip_menerima').val();
        var nama_serah = $('#nama_menyerahkan').val();
        var nama_terima = $('#nama_menerima').val();
        var gudang = $("#filter").text();

        swal({
                title: "Download?",
                text: "Download Laporan Distribusi Obat!",
                type: "warning",
                showCancelButton: true,
                showLoaderOnConfirm: false,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya!",
                cancelButtonText: "Tidak!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    swal("Download", "Sukses", "success");
                    window.open("<?php echo base_url('logistik_farmasi/Frmclaporan/download_distribusi_obat')?>/"+startDate+"/"+endDate+"/"+filter+"/"+nip_serah+"/"+nip_terima+"/"+nama_serah+"/"+nama_terima);
                } else {
                    swal("Close", "Tidak Jadi", "error");
                    document.getElementById("ok1").checked = false;
                }
            });


    }
</script>

<section class="content-header">
    <?php //include('pend_cari.php');	?>


</section>

<section class="content">
    <div class="row">
        <div class="panel panel-default" style="width:97%;margin:0 auto">
            <div class="panel-body">
                <div class="form-group row">
                    <?php echo $message_nodata; ?>
                </div>
                <div class="form-group row">
                    <p class="col-sm-2 form-control-label">Gudang Distribusi</p>
                    <div class="col-lg-6">
                        <select name="filter" id="filter" class="form-control" style="width:100%" required="">
                            <option value="0" selected="">---- Pilih Semua ----</option>
                            <option value="1">Gudang Besar logistik</option>
                            <option value="2">Gudang Farmasi UMUM/PC</option>
                            <option value="3">Gudang Farmasi BPJS</option>
                            <option value="7">Gudang OK</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-2 form-control-label">Yang Menyerahkan</p>
                    <div class="col-lg-6">
                        <input type="text" id="nama_menyerahkan" name="nama_menyerahkan" class="form-control" placeholder="Nama Yang Menyerahkan">
                        <input type="text" id="nip_menyerahkan" name="nip_menyerahkan" class="form-control" placeholder="NIP Yang Menyerahkan">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-2 form-control-label">Yang Menerima</p>
                    <div class="col-lg-6">
                        <input type="text" id="nama_menerima" name="nama_menerima" class="form-control" placeholder="Nama Yang Menerima">
                        <input type="text" id="nip_menerima" name="nip_menerima" class="form-control" placeholder="NIP Yang Menerima">
                    </div>
                </div>
                <div class="form-group row">
                    <!-- Date range -->
                    <div class="col-lg-10">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="tanggal_laporan" name="tanggal_laporan">
                        </div>
                        <!-- /.input group -->
                    </div>

                    <div class="col-lg-2">
                        <span class="input-group-btn">
                            <!-- <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit">Cari</button> -->
                            <button class="btn btn-primary pull-right" type="button" onclick="download()">Download</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
</section>
<?php $this->load->view("layout/footer"); ?>
