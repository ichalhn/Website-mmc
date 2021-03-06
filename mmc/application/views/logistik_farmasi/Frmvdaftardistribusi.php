<?php
$this->load->view('layout/header.php');
?>
    <script type='text/javascript'>
        var table, tableObat, tableAcc;
        var det_id_obat, det_id_amprah;

        var jenis = "<?php echo $jenis_barang;?>";
        if(jenis=='BHP'){
            var urlamprah = "<?php echo site_url(); ?>logistik_farmasi/Frmcamprah/get_amprahbhp_list";
        }else
            var urlamprah = "<?php echo site_url(); ?>logistik_farmasi/Frmcamprah/get_distribusi_from_amprah_list";
        $(function() {
            $('.datepicker').datepicker({
                format: "yyyy-mm-dd",
                endDate: '0',
                autoclose: true,
                todayHighlight: true
            });
            var jenis = "<?php echo $jenis_barang;?>";
            if(jenis=='BHP'){
                var urlamprah = "<?php echo site_url(); ?>logistik_farmasi/Frmcamprah/get_amprahbhp_list";
            }else
                var urlamprah = "<?php echo site_url(); ?>logistik_farmasi/Frmcamprah/get_distribusi_from_amprah_list";
            table = $('#example').DataTable({
                ajax: urlamprah,
                columns: [
                    { data: "id_amprah" },
                    { data: "tgl_amprah" },
                    { data: "gd_dituju" },
                    { data: "gd_asal" },
                    { data: "user" },
                    //{ data: "no_faktur" },
                    { data: "status" },
                    { data: "aksi" }
                ],
                bFilter: true,
                bPaginate: true,
                destroy: true,
                order:  [[ 0, "desc" ]]
            });
            tableObat = $('#tableObat').DataTable({
                //ajax: "<?php echo site_url(); ?>logistik_farmasi/Frmcamprah/get_amprah_detail_list",
                columns: [
                    { data: "id_obat" },
                    { data: "nm_obat" },
                    { data: "satuank" },
                    { data: "qty_req" },
                    { data: "id_amprah" }
                ],
                columnDefs: [
                    { targets: [ 4 ], visible: false }
                ],
                bFilter: false,
                bPaginate: false,
                destroy: true,
                order:  [[ 0, "asc" ]]
            });
            tableAcc = $('#tableAcc').DataTable({
                //ajax: "<?php echo site_url(); ?>logistik_farmasi/Frmcamprah/get_amprah_detail_list",

                columns: [
                    { data: "batch_no" },
                    { data: "qty_acc" },
                    { data: "expire_date" },
                    { data: "aksi" }
                ],
                columnDefs: [
                    { targets: [ 0 ], orderable: false },
                    { targets: [ 1 ], orderable: false },
                    { targets: [ 2 ], orderable: false },
                    { targets: [ 3 ], orderable: false }
                ],
                bFilter: false,
                bPaginate: false,
                order:   [[ 0, "asc" ]],
                destroy: true
            });

            $('#id_amprah').autocomplete({
                serviceUrl: '<?php echo site_url();?>logistik_farmasi/Frmcamprah/auto_id_amprah',
                onSelect: function (suggestion) {
                    $.ajax({
                        dataType: "json",
                        data: {id: suggestion.value },
                        type: "POST",
                        url: "<?php echo site_url(); ?>logistik_farmasi/Frmcamprah/get_info",
                        success: function( response ) {
                            $('#tgl0').val(''+response.tgl_amprah);
                            $('#tgl1').val('');
                            $('#tgl1').prop('disabled',true);
                            $('#gd_asal').val(''+response.gd_asal);
                            $('#gd_asal').prop('disabled',true);
                            $('#gd_dituju').val(''+response.gd_dituju);
                            $('#gd_dituju').prop('disabled',true);
                        }
                    });
                    $('#btnCari').focus();
                }
            });
            $('#btnCari').click(function(){
                refreshAmprah();
            });
            $('#detailModal').on('shown.bs.modal', function(e) {
                //get data-id attribute of the clicked element

                var id = $(e.relatedTarget).data('id');
                $('#sIdAmprah').html(id);
                $('#idamprah_hidden').val(id);
                $.ajax({
                    dataType: "json",
                    type: 'POST',
                    data: {id:id},
                    url: "<?php echo site_url(); ?>logistik_farmasi/Frmcdistribusi/get_detail_list",
                    success: function( response ) {
                        tableObat.clear().draw();
                        tableObat.rows.add(response.data);
                        tableObat.columns.adjust().draw();
                    }
                });
                $('#tableObat tbody').on('click', 'tr', function () {
                    var vdata = tableObat.row( this ).data();
                    $('#tableObat tbody tr').removeClass('selected');
                    $(this).addClass('selected');
                    det_id_obat = vdata['id_obat'];
                    det_id_amprah = vdata['id_amprah'];
                    refreshDetailAcc();
                });
            });
            /*
                $('#btnAcc').click( function() {
                    var vdata = [[]];
                    var idata = -1;
                    var acc;
                    $('#tableObat').find('tr').each(function(i, val) {
                        if (i>0){
                            acc = $("#qty_acc"+i).val();
                            if (acc != ""){
                                idata = idata + 1;
                                var $elements = $(this).find('input, select')
                                var serialized = $elements.serializeArray();
                                vdata[idata] = serialized;
                            }
                        }
                    });

                    $.ajax({
                      dataType: "html",
                      data: {json: vdata },
                      type: "POST",
                      url: "echo site_url(); ?>logistik_farmasi/Frmcdistribusi/alokasi",
                      success: function( response ) {
                        $('#detailModal').modal('hide');
                        refreshAmprah();
                      }
                    });

                    return false;
                } );
            */
            $('#btnReset').click(function(){
                $('#tgl1').prop('disabled',false);
                $('#gd_asal').prop('disabled',false);
                $('#gd_dituju').prop('disabled',false);
                $('#id_amprah').focus();
            });
        });

        function refreshAmprah(){
            $.ajax({
                url: urlamprah, //'<?php echo site_url(); ?>logistik_farmasi/Frmcamprah/get_amprah_list',
                type: 'POST',
                data: $('#frmCari').serialize(),
                dataType: "json",
                success: function (response) {
                    //alert(JSON.stringify(response.data));
                    table.clear().draw();
                    table.rows.add(response.data);
                    table.columns.adjust().draw();
                }
            });
        }
        $(document).on('click','#btnSimpan', function(event){
            var vqty, vbatch, vexdate, vmax;
            vbatch = $("#batch_no").val();
            vexdate = $("#expire_date").val();
            vqty = $("#qty_acc").val();
            vmax = $("#qty_acc").prop('max');
            //if (vqty > vmax){
            //	alert("Total jumlah pembelian "+vqty+" melebihi jumlah diminta Amprah "+vmax);
            //	$("#qty_acc").val('');
            //	$("#qty_acc").focus();
            //}else{
            if ((vqty == "")&&(vbatch == "")){
                alert("Mohon lengkapi Jumlah ACC & Batch No!");
                $("#qty_acc").focus();
            }
            if ((vqty != "")&&(vbatch == "")){
                alert("Mohon lengkapi Batch No !");
                $("#batch_no").focus();
            }
            if ((vqty != "")&&(vbatch != "")){

                var me = $(this);
                event.preventDefault();
                if( me.data('requestRunning') ){
                    return;
                }

                me.data('requestRunning', true);

                $.ajax({
                    dataType: "json",
                    type: 'POST',
                    data: { id_obat:det_id_obat,
                        id_amprah:det_id_amprah,
                        batch_no:$('#batch_no').val(),
                        expire_date:$("#expire_date").val(),
                        qty_acc:$('#qty_acc').val(),
                        id_gudang:$('#id_gudang').val(),
                        id_gudang_tujuan:$('#id_gudang_tujuan').val(),
                        satuank:$('#satuank').val(),
                        qty_req:$('#qty_req').val()
                    },
                    url: "<?php echo site_url(); ?>logistik_farmasi/Frmcdistribusi/save_detail_acc",
                    success: function( response ) {
                        refreshDetailAcc();
                    },
                    complete: function () {
                        me.data('requestRunning', false);
                    }
                });
            }
            //}
        });

        function cetakSBBK() {
            var idamprah = $("#idamprah_hidden").val();

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
                        window.open("<?=base_url('logistik_farmasi/Frmcdistribusi/cetak_sbbk')?>/"+idamprah);
                    } else {
                        swal("Close", "Tidak Jadi", "error");
                        document.getElementById("ok1").checked = false;
                    }
                }
            );
        }

        /*
        function hapusBeli(vid){
            $.ajax({
              dataType: "json",
              type: 'POST',
              data: { id:vid},
              url: " echo site_url(); ?>logistik_farmasi/Frmcpembelian_po/delete_detail_beli",
              success: function( response ) {
                refreshDetailAcc();
              }
            });
        }
        */
        function refreshDetailAcc(){
            $.ajax({
                dataType: "json",
                type: 'POST',
                data: { id_obat:det_id_obat, id_amprah:det_id_amprah},
                url: "<?php echo site_url(); ?>logistik_farmasi/Frmcdistribusi/get_detail_acc",
                success: function( response ) {
                    //alert(response.data[0]["aksi"]);
                    tableAcc.clear().draw();
                    tableAcc.rows.add(response.data);
                    tableAcc.columns.adjust().draw();
                }
            });
        }
    </script>

    <section class="content">
        <div style="background: #e4efe0">
            <div class="inner">
                <div class="container-fluid"><br>
                    <form id="frmCari" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">ID Amprah</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="id_amprah" id="id_amprah" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Tanggal Amprah</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control datepicker" name="tgl0" id="tgl0" >
                            </div>
                            <label class="col-sm-1 control-label">s/d</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control datepicker" name="tgl1" id="tgl1" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Gudang yang Meminta</label>
                            <div class="col-sm-4">
                                <select name="gd_asal" id="gd_asal" class="form-control" style="width:100%" required="">
                                    <option value="" selected>---- Pilih Gudang ----</option>
                                    <?php
                                    foreach($select_gudang0 as $row){
                                        echo '<option value="'.$row->id_gudang.'">'.$row->nama_gudang.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Gudang Tujuan</label>
                            <div class="col-sm-4">
                                <select name="gd_dituju" id="gd_dituju" class="form-control" style="width:100%" required="">
                                    <option value="" selected>---- Pilih Gudang ----</option>
                                    <?php
                                    foreach($select_gudang1 as $row){
                                        echo '<option value="'.$row->id_gudang.'">'.$row->nama_gudang.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-10">
                                <button type="button" id="btnCari" class="btn btn-primary">Cari</button>
                                <button type="reset" id="btnReset" class="btn btn-primary">Reset</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-xs-9" id="alertMsg">
                                <?php echo $this->session->flashdata('alert_msg'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="modal-body">
                            <table id="example" class="display" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>ID Amprah</th>
                                    <th>Tgl Amprah</th>
                                    <th>Gudang Peminta</th>
                                    <th>Gudang Pendistribusi</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Insert-->
        <div class="modal fade" id="detailModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-default modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Detail ID Amprah : <span id="sIdAmprah"></span></h4>
                    </div>
                    <div class="modal-body table-responsive">
                        <table style="border:0;" width="100%">
                            <tr>
                                <td width="45%" valign="top">
                                    <table id="tableObat" class="display" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>ID Obat</th>
                                            <th>Nama Obat</th>
                                            <th>Satuan</th>
                                            <th>Jml Diminta</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </td>
                                <td width="10%"></td>
                                <td width="45%" valign="top">
                                    <table id="tableAcc" class="display" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Batch No</th>
                                            <th>Jml Distribusi</th>
                                            <th>Exp Date</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <!--<button id="btnAcc" class="btn btn-primary pull-right">Simpan</button>-->
                        <input type="hidden" id="idamprah_hidden">
                        <button class="btn btn-danger pull-right" onclick="cetakSBBK()">Cetak SBBK</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->load->view('layout/footer.php');
?>