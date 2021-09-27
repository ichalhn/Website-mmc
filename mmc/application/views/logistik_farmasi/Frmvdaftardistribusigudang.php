<?php
$this->load->view('layout/header.php');
?>
    <html>
<script type='text/javascript'>
    //-----------------------------------------------Data Table
    $(document).ready(function() {
        $('#example').DataTable();
    } );
    //---------------------------------------------------------

    function lihat_detail(receiving_id) {
        $.ajax({
            type:'POST',
            dataType: 'json',
            url:"<?php echo base_url('logistik_farmasi/Frmcpembelian/get_data_detail_pembelian')?>",
            data: {
                receiving_id : receiving_id
            },
            success: function(data){
                $('#edit_receiving_id').val(data[0].receiving_id);
                $('#edit_supplier_id').val(data[0].supplier_id);
                $('#edit_employee_id').val(data[0].employee_id);
                $('#edit_comment').val(data[0].comment);
                $('#edit_payment_type').val(data[0].payment_type);
                $('#edit_total_price').val(data[0].total_price);
                $('#edit_amount_tendered').val(data[0].amount_tendered);
                $('#edit_amount_change').val(data[0].amount_change);
                $('#edit_tgl_kontra_bon').val(data[0].tgl_kontra_bon);
                $('#edit_jatuh_tempo').val(data[0].jatuh_tempo);
                $('#edit_ppn').val(data[0].ppn);
                $('#edit_no_faktur').val(data[0].no_faktur);
            },
            error: function(){
                alert("error");
            }
        });
    }

    $(function() {
        $('#date_picker').datepicker({
            format: "yyyy-mm-dd",
            endDate: '0',
            autoclose: true,
            todayHighlight: true,
        });

    });

    var site = "<?php echo site_url();?>";

</script>
<section class="content-header">
    <?php
    echo $this->session->flashdata('success_msg');
    ?>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID Amprah</th>
                            <th>Tgl Amprah</th>
                            <th>Gudang Peminta</th>
                            <th>Gudang Tujuan</th>
                            <th>User</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        // print_r($pasien_daftar);
                        $i=1;
                        foreach($logistik_farmasi->result() as $row){
                            ?>
                            <tr>
                                <td><?php echo $row->id_amprah;?></td>
                                <td><?php echo $row->tgl_amprah;?></td>
                                <td><?php echo $row->nama_gudang;?></td>
                                <td><?php echo $row->nama_gudang_dituju;?></td>
                                <td><?php echo $row->user;?></td>

                                <td>
                                    <!-- <a type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#lihatdetail" onclick="lihat_detail('<?php echo $row->id_amprah;?>')">Lihat Detail</a> -->
                                    <a href="<?php echo site_url('logistik_farmasi/FrmcreturGudang/retur/'.$row->id_amprah); ?>" class="btn btn-danger btn-sm">Retur Barang</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                    //echo $this->session->flashdata('message_nodata');
                    ?>

                    <!-- Modal Edit Obat -->
                    <div class="modal fade" id="lihatdetail" role="dialog" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-success">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Detail Pembelian</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">Receiving Id</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="edit_receiving_id" id="edit_receiving_id" disabled="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">Supplier Id</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="edit_supplier_id" id="edit_supplier_id" disabled="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">Employee Id</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="edit_employee_id" id="edit_employee_id" disabled="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">Comment</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="edit_comment" id="edit_comment" disabled="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">Payment Type</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="edit_payment_type" id="edit_payment_type" disabled="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">Total Price</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="edit_total_price" id="edit_total_price" disabled="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">Amount Tendered</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="edit_amount_Tendered" id="edit_amount_tendered" disabled="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">Amount Change</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="edit_amount_change" id="edit_amount_change" disabled="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">Tanggal Kontra Bon</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="edit_tgl_kontra_bon" id="edit_tgl_kontra_bon" disabled="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">Jatuh Tempo</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="edit_jatuh_tempo" id="edit_jatuh_tempo" disabled="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">PPN</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="edit_ppn" id="edit_ppn" disabled="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">No Faktur</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="edit_no_faktur" id="edit_no_faktur" disabled="">
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<?php
$this->load->view('layout/footer.php');
?>