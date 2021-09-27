<?php $this->load->view('layout/header.php'); ?>
<script type='text/javascript'>
    //-----------------------------------------------Data Table
    $(document).ready(function () {
        $('#examplee').DataTable();
        $(".select2").select2();
        $(".js-example-basic-single").select2();

        $('#date_picker').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });

        $('#date_picker2').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });

        $('#date_picker3').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
    });

    function lihat_detail(receiving_id) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?php echo base_url('logistik_farmasi/Frmcpembelian/get_data_detail_pembelian')?>",
            data: {
                receiving_id: receiving_id
            },
            success: function (data) {
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
            error: function () {
                alert("error");
            }
        });
    }

    $(document).ready(function () {
        $('#tabel_kwitansi').DataTable();
    });
    //-----------------------------------------------Data Table
    $(document).ready(function () {
        $('#example').DataTable();
    });
    //---------------------------------------------------------

</script>


<section class="content-header">
    <?php echo $this->session->flashdata('success_msg'); ?>
</section>

<?php echo form_open('logistik_farmasi/Frmcpembelian/insert_detail_pembelian'); ?>


<!-- Modal -->


<!-- Modal content-->
<div class="panel-body" style="width:100%">
    <div class="col-md-16">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h4 class="modal-title">Detail Transaksi</h4>
            </div>


            <div class="panel panel-body">

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lpaymethod">Transaksi</p>
                    <div class="col-sm-6">
                        <select class="form-control" name="payment_type" id="payment_type">
                            <option value="" disabled selected>----- Pilih Transaksi -----</option>
                            <option value="cash">Pembelian Cash</option>
                            <option value="credit">Pembelian Credit</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row" hidden>
                    <p class="col-sm-2 form-control-label">Receiving ID</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="receiving_id" id="receiving_id" required
                               disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lidsupplier">Supplier</p>
                    <div class="col-sm-6">
                        <select name="id_supplier" class="form-control select2" style="width:100%"" required="">
                        <option value="" disabled selected>---- Pilih Supplier ----</option>
                        <?php
                        foreach ($select_pemasok as $row) {
                            echo '<option value="' . $row->person_id . '">' . $row->company_name . '</option>';
                        }
                        ?>
                        </select>
                    </div>
                    <div class="col-xs-1" align="right">
                        <div class="input-group">
          <span class="input-group-btn">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Tambah Supplier Baru</button>
          </span>
                        </div><!-- /input-group -->
                    </div><!-- /col-lg-6 -->
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lnofaktur">No Faktur</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="no_faktur" id="no_faktur" required="">
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="ljatuhtempo">Tanggal Faktur </p>
                    <div class="col-sm-2">
                        <input type="text" id="date_picker" class="form-control" placeholder="Tanggal Faktur"
                               name="tgl_faktur" required>
                    </div>
                </div>

                <!--<div class="form-group row">
                  <p class="col-sm-2 form-control-label" id="lpaymethod">Pembayaran</p>
                  <div class="col-sm-6">
                    <select class="form-control" name="payment_type" id="pay_method">
                      <option value="" disabled selected>---- Pilih Metode ----</option>
                      <option value="Terima">Cash</option>
                      <option value="Retur">Credit</option>
                    </select>
                  </div>
                </div>-->

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="ljatuhtempo">Tanggal Kontra Bon </p>
                    <div class="col-sm-2">
                        <input type="text" id="date_picker2" class="form-control" placeholder="Kontra Bon"
                               name="tgl_kontra_bon" required>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="ljatuhtempo">Tanggal Jatuh Tempo </p>
                    <div class="col-sm-2">
                        <input type="text" id="date_picker3" class="form-control" placeholder="Jatuh Tempo"
                               name="jatuh_tempo" required>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">Keterangan</p>
                    <div class="col-sm-6">
                        <textarea type="text" class="form-control" name="comment" id="comment"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lpaymethod">PPN</p>
                    <div class="col-sm-2">
                        <select class="form-control" name="ppn" id="ppn">
                            <option value="" disabled selected>----- Pilih -----</option>
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lpaymethod">Sumber Dana</p>
                    <div class="col-sm-6">
                        <select class="form-control" name="sumber_dana" id="sumber_dana">
                            <option value="" disabled selected>----- Pilih Sumber -----</option>
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

                <input type="hidden" class="form-control" name="jenis_barang" id="jenis_barang" value="">

                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Detail Pembelian</button>
                </div>
            </div>
        </div>
        <table id="example" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No</th>
                <th>RECEIVING ID</th>
                <th>TANGGAL PEMBELIAN</th>
                <th>SUPPLIER</th>
                <th>QTY BARANG</th>
                <th>LIHAT DETAIL</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 1;
            foreach ($data_receiving as $row) {

                $no_faktur = str_replace('/', '-', $row->no_faktur);
                ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $row->receiving_id; ?></td>
                    <td><?php echo $row->receiving_time; ?></td>
                    <td><?php echo $row->company_name; ?></td>
                    <td><?php echo $row->total; ?></td>
                    <td>
                        <!--<button type="button" class="btn btn-primary btn-xs" data-toggle="modal"
                                data-target="#lihatdetail"
                                onclick="lihat_detail('<?php /*echo $row->receiving_id; */?>')">Lihat Detail
                        </button>-->
                        <a href="<?=base_url('logistik_farmasi/frmcpembelian/form_detail_transaksi/'.$no_faktur)?>" class="btn btn-primary btn-xs" target="_blank">
                            <i class="fa fa-edit"></i> Detail/ Ubah
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>


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
                                <input type="text" class="form-control" name="edit_receiving_id"
                                       id="edit_receiving_id" disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Supplier Id</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_supplier_id"
                                       id="edit_supplier_id" disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Employee Id</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_employee_id"
                                       id="edit_employee_id" disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Comment</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_comment" id="edit_comment"
                                       disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Payment Type</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_payment_type"
                                       id="edit_payment_type" disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Total Price</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_total_price"
                                       id="edit_total_price" disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Amount Tendered</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_amount_Tendered"
                                       id="edit_amount_tendered" disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Amount Change</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_amount_change"
                                       id="edit_amount_change" disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Tanggal Kontra Bon</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_tgl_kontra_bon"
                                       id="edit_tgl_kontra_bon" disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Jatuh Tempo</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_jatuh_tempo"
                                       id="edit_jatuh_tempo" disabled="">
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
                                <input type="text" class="form-control" name="edit_no_faktur" id="edit_no_faktur"
                                       disabled="">
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
<?php echo form_close(); ?>

<?php echo form_open('logistik_farmasi/Frmcpembelian/insert_supplier'); ?>

<!-- Modal Insert Supplier -->
<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Supplier Baru</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmsupplier">Nama Supplier</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="nmsupplier" id="nmsupplier" required="">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_accountnumber">Account Number</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="accountnumber" id="accountnumber" required="">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_adress">Alamat</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="adress" id="adress" required="">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_zip_code">Zip Code</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="zip_code" id="zip_code">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_phone">Phone</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="phone" id="phone" required="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Insert Supplier</button>
            </div>
        </div>
    </div>
</div>

<?php echo form_close(); ?>


<?php $this->load->view('layout/footer.php'); ?>