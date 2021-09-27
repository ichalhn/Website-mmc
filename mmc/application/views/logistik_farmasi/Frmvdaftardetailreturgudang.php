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
    function retur_barang(){
        var total = parseInt($("#edit_quantity_purchased").val()) - parseInt($("#edit_quantity").val())  ;
        $('#edit_stok').val(total);
        $('#edit_stok').maskMoney('mask');
        $('#edit_stok_hide').val(total);
    }
    function lihat_detail(batch_no) {
        $.ajax({
            type:'POST',
            dataType: 'json',
            url:"<?php echo base_url('logistik_farmasi/FrmcreturGudang/edit_data_retur')?>",
            data: {
                batch_no : batch_no
            },
            success: function(data){
                $('#edit_description').val(data[0].description);
                $('#edit_batch_no').val(data[0].batch_no);
                $('#edit_item_id').val(data[0].id_obat);
                $('#edit_quantity_purchased').val(data[0].quantity_purchased);
                $('#edit_quantity').prop('min', 0);
                $('#edit_quantity').prop('max', data[0].quantity_purchased );

            },
            error: function(){
                alert("error");
            }
        });
    }

    function retur_stok(batch_no) {
        $.ajax({
            type:'POST',
            dataType: 'json',
            url:"<?php echo base_url('logistik_farmasi/Frmcretur/edit_stok')?>",
            data: {
                batch_no : batch_no
            },
            success: function(data){
                $('#edit_qty').val(data[0].qty);
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
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>No Batch</th>
                            <th>Quantity</th>
                            <th>Stok</th>
                            <th>Aksi</th>

                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        // print_r($pasien_daftar);
                        $i=1;
                        foreach($retur_barang as $row){

                            ?>
                            <tr>
                                <td><?php echo $i++;?></td>
                                <td><?php echo $row->nm_obat;?></td>
                                <td><?php echo $row->batch_no;?></td>
                                <td><?php echo $row->qty_acc;?></td>
                                <td><?php echo $row->stok;?></td>


                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#lihatdetail" onclick="lihat_detail('<?php echo $row->id_obat;?>')">Retur Barang</button>
                                    <a href="<?php echo site_url('logistik_farmasi/FrmcreturGudang/'); ?>" class="btn btn-danger btn-sm">Kembali</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>

                    <?php echo form_open('logistik_farmasi/FrmcreturGudang/save_retur_gudang');?>
                    <!-- Modal Edit Obat -->
                    <div class="modal fade" id="lihatdetail" role="dialog" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-success">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Detail Retur</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">Nama Barang</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="edit_description" id="edit_description" disabled="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">No Batch</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="edit_batch_no" id="edit_batch_no" readonly>
                                            <input type="hidden" class="form-control" name="edit_item_id" id="edit_item_id">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">Quantity Awal</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="edit_quantity_purchased" id="edit_quantity_purchased" disabled="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label" >Quantity Retur</p>
                                        <div class="col-sm-6">
                                            <input type="number" class="form-control" name="edit_quantity" id="edit_quantity" oninput ="retur_barang(this.value)" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label" >Stok</p>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="edit_stok" id="edit_stok" disabled="">
                                            <input type="hidden" class="form-control" name="edit_stok_hide" id="edit_stok_hide">
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <input type="hidden" class="form-control" name="id_amprah" id="id_amprah" value="<?php echo $id_amprah;?>">
                                    <button type="submit" class="btn btn-primary btn-sm">Retur Barang</button>
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Kembali</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close();?>

                </div>
            </div>
        </div>
</section>
<?php
$this->load->view('layout/footer.php');
?>