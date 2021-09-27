<?php
$this->load->view('layout/header.php');
?>
    <style type="text/css">
        .expire_date{z-index:1151 !important;}
        .modal-lg{
            width: 100%;
        }
    </style>
    <script type='text/javascript'>
        var table, tableObat, tableBeli;
        var det_item_id, det_id_po, det_jml_kemasan, det_harga_po, det_satuan_item;
        $(function() {
            $('.datepicker').datepicker({
                format: "yyyy-mm-dd",
                endDate: '0',
                autoclose: true,
                todayHighlight: true
            });

            $('#jatuh_tempo').datepicker({
                format: "yyyy-mm-dd",
                changeMonth: true,
                changeYear: true,
                autoclose: true,
                todayHighlight: true
            });

            table = $('#example').DataTable({
                ajax: "<?php echo site_url(); ?>logistik_farmasi/Frmclaporan/get_hutang_list",
                columns: [
                    { data: "id_po" },
                    { data: "no_po" },
                    { data: "tgl_po" },
                    { data: "company_name" },
                    { data: "sumber_dana" },
                    { data: "user" },
                    { data: "status" },
                    { data: "aksi" }
                ],
                bFilter: true,
                bPaginate: true,
                destroy: true,
                order:  [[ 2, "asc" ],[ 1, "asc" ]]
            });
            tableObat = $('#tableObat').DataTable({
                //ajax: "<?php echo site_url(); ?>logistik_farmasi/Frmcamprah/get_amprah_detail_list",
                columns: [
                    { data: "description" },
                    { data: "satuank" },
                    { data: "qty_po", render: $.fn.dataTable.render.number('.', ',', 0, '') },
                    { data: "hargabeli", render: $.fn.dataTable.render.number('.', ',', 0, '') },
                    { data: "subtotal" },
                    //{ data: "subtotal", render: $.fn.dataTable.render.number('.', ',', 0, '') },
                    { data: "id_po" },
                    { data: "item_id" }
                ],
                columnDefs: [
                    { targets: [ 5 ], visible: false },
                    { targets: [ 6 ], visible: false }
                ],

                bFilter: false,
                bPaginate: false,
                destroy: true,
                order:  [[ 0, "asc" ]]
            });
            tableBeli = $('#tableBeli').DataTable({
                //ajax: "<?php echo site_url(); ?>logistik_farmasi/Frmcamprah/get_amprah_detail_list",

                columns: [
                    { data: "qty_beli" },
                    { data: "jml_kemasan" },
                    { data: "hargabeli_po" },
                    { data: "hargabeli" },
                    { data: "hargajual" },
                    { data: "batch_no" },
                    { data: "diskon_item" },
                    { data: "expire_date" },
                    { data: "subtotal" },
                    { data: "aksi" }
                ],
                columnDefs: [
                    { targets: [ 0 ], orderable: false },
                    { targets: [ 1 ], orderable: false },
                    { targets: [ 2 ], orderable: false },
                    { targets: [ 3 ], orderable: false },
                    { targets: [ 4 ], orderable: false },
                    { targets: [ 5 ], orderable: false },
                    { targets: [ 6 ], orderable: false }
                ],
                bFilter: false,
                bPaginate: false,
                order:   [[ 0, "desc" ]],
                destroy: true
            });

            $('#no_po').autocomplete({
                serviceUrl: '<?php echo site_url();?>logistik_farmasi/Frmcpo/auto_no_po',
                onSelect: function (suggestion) {
                    $.ajax({
                        dataType: "json",
                        data: {id: suggestion.id },
                        type: "POST",
                        url: "<?php echo site_url(); ?>logistik_farmasi/Frmcpo/get_info",
                        success: function( response ) {
                            //alert(JSON.stringify(response));
                            $('#tgl0').val(response.tgl_po);
                            $('#tgl1').val('');
                            $('#tgl1').prop('disabled',true);
                            $('#supplier_id').val(response.supplier_id);
                            $('#supplier_id').prop("disabled", true);
                        }
                    });
                    $('#btnCari').focus();
                }
            });
            $('#btnCari').click(function(){
                refreshPO();
            });

            $('#detailModal').on('shown.bs.modal', function(e) {
                //get data-id attribute of the clicked element
                $("#total_po").text("");
                $("#total_ppn").text("");
                $("#total_po_ppn").text("");

                var id = $(e.relatedTarget).data('id');
                //alert(id);
                var no = $(e.relatedTarget).data('no');
                var open = $(e.relatedTarget).data('open');
                document.getElementById("id_po").value = id;
                $('#sDetailID').html(no);
                tableBeli.clear().draw();
                $.ajax({
                    dataType: "json",
                    type: 'POST',
                    data: {id:id},
                    url: "<?php echo site_url(); ?>logistik_farmasi/Frmcpembelian_po/get_detail_list",
                    success: function( response ) {
                        //alert(response.master[0]['total']);

                        $("#tgl_faktur").val('');
                        $("#no_faktur").val('');
                        $("#jatuh_tempo").val('');
                        $("#cara_bayar").val('');
                        $("#keterangan").val('');
                        $("#materai").val('0');
                        $("#diskon_transaksi").val('0');
                        tableObat.clear().draw();
                        tableObat.rows.add(response.data);
                        tableObat.columns.adjust().draw();

                        $("#subtotal_po").text("Subtotal:   Rp. " + response.subtotal);
                        $("#diskon_po").text("Diskon:   Rp. " + response.diskon_po);
                        $("#total_po").text("Total Pembelian:   Rp. " + response.total);
                        $("#total_ppn").text("Ppn :   Rp. " + response.ppn);
                        $("#total_po_ppn").text("Total Akhir:   Rp. " + response.totalppn);
                    }
                });
                $('#tableObat tbody').on('click', 'tr', function () {
                    var vdata = tableObat.row( this ).data();
                    $('#tableObat tbody tr').removeClass('selected');
                    $(this).addClass('selected');
                    det_item_id = vdata['item_id'];
                    det_id_po = vdata['id_po'];
                    det_jml_kemasan =  vdata['jml_kemasan'];
                    det_harga_po = vdata['hargabeli'];
                    det_satuan_item = vdata['satuan_item'];
                    refreshDetailBeli();
                });
                if(open==1){
                    // $("input[name='bt_selesai']").prop("disabled", "false");
                    document.getElementById("bt_selesai").disabled = false;
                }else{
                    // $("input[name='bt_selesai']").prop("disabled", "true");
                    document.getElementById("bt_selesai").disabled = true;
                }
            });

            $('#btnReset').click(function(){
                $('#tgl1').prop('disabled',false);
                $('#supplier_id').prop("disabled", false);
                $('#no_po').focus();
            });
        });

        $(document).on('click','#btnSimpan', function(event){
            //var vqty, vbatch, vexdate, vmax, vtanggal, vnoFaktur, vCaraBayar, vKeterangan, vhargabeli, vhargajual;
            vbatch = $("#batch_no").val();
            vexdate = $("#expire_date").val();
            vqty = parseInt($("#qty_beli").val());
            vmax = parseInt($("#qty_beli").prop('max'));

            vtanggal = $("#tgl_faktur").val();
            vnoFaktur = $("#no_faktur").val();
            vjatuhTempo = $("#jatuh_tempo").val();
            vCaraBayar = $("#cara_bayar").val();
            vppn = $("#ppn").is(':checked') ? 1 : 0;
            vmaterai = $("#materai").is(':checked') ? 1 : 0;
            vdiskonF = $("#diskon_transaksi").val();

            if(vtanggal == "" || vnoFaktur == "" || vCaraBayar == "" || vjatuhTempo == ""){

                alert("Lengkapi Data Faktur Terlebih Dahulu");
                $("#no_faktur").focus();
                return false;
            }else {
                if (vqty > vmax) {
                    alert("Total jumlah pembelian melebihi jumlah PO ");
                    $("#qty_beli").val('');
                    $("#qty_beli").focus();
                    return false;
                } else {
                    if (((vqty == "") && (vbatch == "")) && (vexdate == "")) {
                        alert("Mohon lengkapi Jumlah Beli, Batch No & Tanggal Expired!");
                        $("#qty_beli").focus();
                    }
                    if ((vqty != "") && (vbatch == "")) {
                        alert("Mohon lengkapi Batch No & Tanggal Expired!");
                        $("#batch_no").focus();
                    }
                    if ((vbatch != "") && (vexdate == "")) {
                        alert("Mohon lengkapi Tanggal Expired!");
                        $("#expire_date").focus();
                    }
                    if (((vqty != "") && (vbatch != "")) && (vexdate != "")) {
                        $.ajax({
                            dataType: "json",
                            type: 'POST',
                            data: {
                                item_id: det_item_id,
                                id_po: det_id_po,
                                batch_no: $('#batch_no').val(),
                                expire_date: $('#expire_date').val(),
                                qty_beli: $('#qty_beli').val(),
                                description: $('#description').val(),
                                satuank: $('#satuank').val(),
                                qty: $('#qty').val(),
                                hargabeli: $('#hargabeli').val(),
                                diskon_item:$("#diskon_item").val(),
                                tgl_faktur:vtanggal,
                                no_faktur:vnoFaktur,
                                jatuh_tempo:vjatuhTempo,
                                ppn:vppn,
                                materai:vmaterai,
                                cara_bayar:vCaraBayar,
                                diskonF:vdiskonF,
                                keterangan: $("#keterangan").val(),
                                hargajual: $("#hargajual").val(),
                                jml_kemasan: $("#jumlahkemasan").val(),
                                harga_po:det_harga_po,
                                satuan_item:det_satuan_item

                            },
                            url: "<?php echo site_url(); ?>logistik_farmasi/Frmcpembelian_po/save_detail_beli",
                            success: function (response) {
                                refreshDetailBeli();
                            }
                        });
                    }
                }
            }
        });

        function editItemBeli(idpo, itemid) {
            qty = parseInt($("#qty_beli_edit").val());
            hargabeli = $("#hargabeli_edit").val();
            hargabeli_po = $("#hargabeli_po_edit").val();
            hargajual = $("#hargajual_edit").val();
            batch = $("#batch_no_edit").val();
            diskon = $("#diskon_item_edit").val();
            exdate = $("#expire_date_edit").val();
            jml_kemasan = $("#jml_kemasan_edit").val();

            swal({
                    title: "Ubah Item Ini?",
                    text: "Mengubah Data ini berarti Mengubah kembali Stok yang Telah Masuk.",
                    type: "error",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    confirmButtonColor: '#F00',
                },
                function(){
                    $.ajax({
                        url: "<?=site_url()?>logistik_farmasi/Frmcpembelian_po/edit_item_beli",
                        type: "POST",
                        dataType: "json",
                        data:{
                            idpo: idpo,
                            itemid: itemid,
                            qty: qty,
                            hargabeli: hargabeli,
                            hargajual: hargajual,
                            batch: batch,
                            diskon: diskon,
                            exdate: exdate,
                            hargabeli_po: hargabeli_po,
                            jml_kemasan: jml_kemasan
                        },
                        success: function (response) {
                            swal({
                                title: "Data Berhasil Diubah!",
                                text: "Akan menghilang dalam 3 detik.",
                                timer: 3000,
                                showConfirmButton: false,
                                showCancelButton: true
                            });

                            refreshDetailBeli();
                        }
                    });
                });
        }

        function deleteItem(idpo, itemid, batch_no) {
            swal({
                    title: "Hapus Item Pembelian?",
                    text: "Menghapus Data ini berarti Menghapus Stok yang Telah Masuk.",
                    type: "error",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    confirmButtonColor: '#F00',
                },
                function(){
                    $.ajax({
                        url: "<?=site_url()?>logistik_farmasi/Frmcpembelian_po/delete_item_beli",
                        type: "POST",
                        dataType: "json",
                        data:{
                            idpo: idpo,
                            itemid: itemid,
                            batch_no: batch_no
                        },
                        success: function (response) {
                            swal({
                                title: "Data Berhasil Dihapus!",
                                text: "Akan menghilang dalam 3 detik.",
                                timer: 3000,
                                showConfirmButton: false,
                                showCancelButton: true
                            });

                            refreshDetailBeli();
                        }
                    });
                });
        }



        function refreshPO(){
            $.ajax({
                url: '<?php echo site_url(); ?>logistik_farmasi/Frmcpo/get_po_list',
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
        function refreshDetailBeli(){
            $.ajax({
                dataType: "json",
                type: 'POST',
                data: { item_id:det_item_id, id_po:det_id_po},
                url: "<?php echo site_url(); ?>logistik_farmasi/Frmcpembelian_po/get_detail_beli",
                success: function( response ) {
                    tableBeli.clear().draw();
                    tableBeli.rows.add(response.data);
                    tableBeli.columns.adjust().draw();

                    $("#subtotal_po").text("Subtotal:   Rp. " + response.subtotal);
                    $("#diskon_po").text("Diskon:   Rp. " + response.diskon_po);
                    $("#total_po").text("Total Pembelian:   Rp. " + response.total);
                    $("#total_ppn").text("Ppn :   Rp. " + response.ppn);
                    $("#total_po_ppn").text("Total Akhir:   Rp. " + response.totalppn);
                }
            });
        }

        function editDetailBeli(itemid, id_po) {
            $.ajax({
                dataType: "json",
                type: 'POST',
                data: { item_id:itemid, id_po:id_po},
                url: "<?php echo site_url(); ?>logistik_farmasi/Frmcpembelian_po/get_detail_beli",
                success: function( response ) {
                    tableBeli.clear().draw();
                    tableBeli.rows.add( [ {
                        'qty_beli': '<input type="number" id="qty_beli_edit" name="qty_beli_edit" style="width:100%" value="'+response.data[0]['qty_beli']+'">',
                        'jml_kemasan': '<p align="right">'+response.data[0]['jml_kemasan']+'</p><input type="hidden" id="jml_kemasan_edit" name="jml_kemasan_edit" value="'+response.data[0]['jml_kemasan']+'">',
                        'hargabeli_po': '<input type="number" id="hargabeli_po_edit" name="hargabeli_po_edit" style="width:100%" min=0 value="'+response.data[0]['hargabeli_po']+'" readonly>',
                        'hargabeli': '<input type="number" id="hargabeli_edit" name="hargabeli_edit" style="width:100%" min=0 value="'+response.data[0]['hargabeli']+'">',
                        'hargajual': '<input type="number" id="hargajual_edit" name="hargajual_edit" style="width:100%" min=0 value="'+response.data[0]['hargajual']+'">',
                        'batch_no': '<input type="text" id="batch_no_edit" name="batch_no_edit" value="'+response.data[0]['batch_no']+'">',
                        'diskon_item': '<input type="text" id="diskon_item_edit" name="diskon_item_edit" value="'+response.data[0]['diskon_item']+'" style="width:100%">',
                        'expire_date': '<input type="text" id="expire_date_edit" name="expire_date_edit" placeholder="yyyy-mm-dd" style="width:100%" value="'+response.data[0]['expire_date']+'">',
                        'subtotal': response.data[0]['subtotal'],
                        'aksi': '<button class="btn btn-xs btn-primary" id="btnSimpanEdit" onclick="editItemBeli('+id_po+', '+itemid+')">Simpan</button>'
                    }] )
                        .draw();

                    /*tableBeli.rows.add(response.data);
                    tableBeli.columns.adjust().draw();*/

                    $("#subtotal_po").text("Subtotal:   Rp. " + response.subtotal);
                    $("#diskon_po").text("Diskon:   Rp. " + response.diskon_po);
                    $("#total_po").text("Total Pembelian:   Rp. " + response.total);
                    $("#total_ppn").text("Ppn :   Rp. " + response.ppn);
                    $("#total_po_ppn").text("Total Akhir:   Rp. " + response.totalppn);
                }
            });
        }

        function export_excel(){
            var d = new Date();
            tglawal = document.getElementById("tgl0").value;
            if(tglawal === ""){
                tglawal = "<?php echo date('Y-m-d');?>"
            }
            tglakhir = document.getElementById("tgl1").value;
            if(tglakhir === ""){
                tglakhir = "<?php echo date('Y-m-d');?>"
            }
            url = "<?php echo base_url('logistik_farmasi/Frmcpembelian_po/export_excel')?>";
            swal({
                    title: "Export To Excel",
                    text: "Benar Akan Export?",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    window.open(url+'/'+tglawal+'/'+tglakhir, "_blank");
                    // alert(url+'/'+tglawal+'/'+tglakhir);
                    swal({
                        title: "Data Excel Berhasil Di download.",
                        text: "Akan menghilang dalam 3 detik.",
                        timer: 3000,
                        showConfirmButton: false,
                        showCancelButton: true
                    });
                });
        }

        function exportExcelPO() {
            var url = "<?php echo base_url('logistik_farmasi/Frmclaporan/download_pembelian_by_po')?>";
            var idpo = $("#id_po").val();

            swal({
                    title: "Export To Excel",
                    text: "Benar Akan Export?",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                },
                function(){
                    window.open(url+'/'+idpo, "_blank");
                    swal({
                        title: "Data Excel Berhasil Di download.",
                        text: "Akan menghilang dalam 3 detik.",
                        timer: 3000,
                        showConfirmButton: false,
                        showCancelButton: true
                    });
                });
        }
    </script>

    <section class="content">
        <div style="background: #e4efe0">
            <div class="inner">
                <div class="container-fluid"><br>
                    <form id="frmCari" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Tanggal Faktur</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control datepicker" name="tgl0" id="tgl0" >
                            </div>
                            <label class="col-sm-1 control-label">s/d</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control datepicker" name="tgl1" id="tgl1" >
                            </div>
                            <div class="col-sm-5">

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Supplier</label>
                            <div class="col-sm-4">
                                <select name="supplier_id" id="supplier_id" class="form-control" style="width:100%" required="">
                                    <option value="" selected>---- Pilih Supplier ----</option>
                                    <?php
                                    foreach($select_pemasok as $row){
                                        echo '<option value="'.$row->person_id.'">'.$row->company_name.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-10">
                                <button type="button" id="btnCari" class="btn btn-success">Cari</button>
                                <button type="reset" id="btnReset" class="btn btn-primary">Reset</button>
                                <button type="button" id="submit" onclick="export_excel()" class="btn btn-danger"><i class="fa fa-print"> &nbsp;Export Excel</i> </button>
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
                                    <th>No Faktur</th>
                                    <th>Tanggal</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Supplier</th>
                                    <th>Nominal</th>
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
                        <h4 class="modal-title">Detail PO No : <span id="sDetailID"></span></h4>
                    </div>
                    <div class="container-fluid"><br>
                        <form id="frmCari" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-sm-2 control-label">Tanggal</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control datepicker" name="tgl_faktur" id="tgl_faktur" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 control-label">No Faktur</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="no_faktur" id="no_faktur" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 control-label">Jatuh Tempo</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="jatuh_tempo" id="jatuh_tempo" required="" placeholder="Tgl Jatuh Tempo">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 control-label">Cara Bayar</label>
                                <div class="col-sm-4">
                                    <select name="cara_bayar" id="cara_bayar" class="form-control" style="width:100%" required="">
                                        <option value="" selected>---- Cara Bayar ----</option>
                                        <option value="cash">Cash</option>
                                        <option value="credit">Credit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 control-label">Keterangan</label>
                                <div class="col-sm-6">
                                    <textarea type="text" class="form-control" name="keterangan" id="keterangan"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">PPN</label>
                                <div class="col-sm-4">
                                    <div class="radio">
                                        <label>
                                            <input name="ppn" id="ppn" value="1" checked="" type="radio">
                                            Ya
                                        </label>
                                        <label>
                                            <input name="ppn" id="ppn" value="0" type="radio">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Materai</label>
                                <div class="col-sm-4">
                                    <div class="radio">
                                        <label>
                                            <input name="materai" id="materai" value="1" type="radio">
                                            Ya
                                        </label>
                                        <label>
                                            <input name="materai" id="materai" value="0" type="radio" checked="">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 control-label">Diskon Transaksi</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="diskon_transaksi" id="diskon_transaksi" required="" value="0">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-body  table-responsive">
                        <table style="border:0;" width="100%">
                            <tr>
                                <td width="100%" valign="top">
                                    <table id="tableObat" class="display" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th><p align="center">Nama Obat</p></th>
                                            <th><p align="center">Satuan</p></th>
                                            <th><p align="center">Jml PO</p></th>
                                            <th><p align="center">Harga Beli</p></th>
                                            <th><p align="center">Subtotal</p></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </td>
                                <td width="2%"></td>
                                <!--<td width="100%" valign="top">-->
                                <!--<table id="tableBeli" class="display" cellspacing="0" width="100%">
                                  <thead>
                                  <tr>
                                    <th>Jml Beli</th>
                                    <th>Harga Beli</th>
                                    <th>Batch No</th>
                                    <th>Expire</th>
                                    <th>Aksi</th>
                                  </tr>
                                  </thead>
                                </table>-->
                                <!--</td>-->
                            </tr>
                        </table>
                        <table id="tableBeli" class="display" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th width="10%"><p align="center">Jml Beli</p></th>
                                <th><p align="center">Jml Kemasan</p></th>
                                <th><p align="center">Harga Beli PO</p></th>
                                <th><div align="center">Harga Beli Item<br/>
                                        <font style="font-size: 10px">*diambil dari<br/>Satuan Kecil PO</font></div></th>
                                <th><p align="center">Harga Jual<br>per Item</p></th>
                                <th><p align="center">Batch No</p></th>
                                <th width="10%"><p align="center">Diskon Item<br>(Rp/ %)</p></th>
                                <th width="10%"><p align="center">Expire</p></th>
                                <th width="10%"><p align="center">Subtotal</p></th>
                                <th><p align="center">Aksi</p></th>
                            </tr>
                            </thead>
                        </table>
                        <br>
                        <div align="right"><span style="font-size: 20px; font-weight: bold" id="subtotal_po"></span></div>
                        <div align="right"><span style="font-size: 20px; font-weight: bold" id="diskon_po"></span></div>
                        <div align="right"><span style="font-size: 20px; font-weight: bold" id="total_po"></span></div>
                        <div align="right"><span style="font-size: 20px; font-weight: bold" id="total_ppn"></span></div>
                        <div align="right"><span style="font-size: 20px; font-weight: bold" id="total_po_ppn"></span></div>
                    </div>
                    <?php echo form_open('logistik_farmasi/Frmcpembelian_po/selesai_po');?>
                    <div class="modal-footer">
                        <input type="hidden" name="id_po" id="id_po">
                        <button class="btn btn-danger" type="button" onclick="exportExcelPO()"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Import Excel</button>
                        <button id="bt_selesai" name="bt_selesai" class="btn btn-primary" type="submit">Selesai</button>
                    </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </section>

<?php
$this->load->view('layout/footer.php');
?>