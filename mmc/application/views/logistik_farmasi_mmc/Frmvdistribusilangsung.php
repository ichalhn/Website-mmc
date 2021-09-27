<?php
$this->load->view('layout/header.php');
?>
    <script type='text/javascript'>
        Date.prototype.yyyymmdd = function() {
            var mm = this.getMonth() + 1; // getMonth() is zero-based
            var dd = this.getDate();

            return [this.getFullYear()+'-',
                (mm>9 ? '' : '0') + mm +'-',
                (dd>9 ? '' : '0') + dd +    '-'
            ].join('');
        };

        var table;
        var ndata = 0;
        $(function() {
            <?php echo $this->session->flashdata('cetak'); ?>
            //var $id_obat = $("#id_obat").select2();

            $('#tgl_amprah').datepicker({
                format: "yyyy-mm-dd",
                endDate: '0',
                autoclose: true,
                todayHighlight: true
            });
            var myDate = new Date();
            $('#tgl_amprah').datepicker('setDate', myDate.yyyymmdd());
            table = $('#example').DataTable();
            $('#btnUbah').css("display", "none");
            $('#detailObat').css("display", "none");
            $( "#vgd_dituju" ).change(function() {
                $('#vgd_dituju').prop('disabled', 'disabled');
                $('#btnUbah').css("display", "");
                $('#detailObat').css("display", "");
                $('#gd_dituju').val( $( "#vgd_dituju" ).val() );
            });

            $( "#btnUbah" ).click(function() {
                $('#vgd_dituju').prop('disabled', '');
                $('#vgd_dituju option[value=""]').prop('selected', 'selected');
                $('#gd_dituju').val("");
                $('#vgd_dituju').focus();
                $('#btnUbah').css("display", "none");
                table.clear().draw();
                $('#detailObat').css("display", "none");
            });

            $('#cari_obat').css('width', '300px');
            $('#cari_obat').autocomplete({
                serviceUrl: '<?php echo site_url();?>farmasi/Frmcdaftar/cari_data_obat_by_gudang',
                onSelect: function (suggestion) {
                    $('#cari_obat').val(''+suggestion.nama);
                    $("#id_obat").val(suggestion.idobat);
                    $('#biaya_obat').val(suggestion.hargabeli);
                    $("#harga_jual").val(suggestion.harga);
                    $("#expire_date").val(suggestion.expire_date);
                    $("#exp_date").val(suggestion.expire_date);
                    $("#batch_no").val(suggestion.batch_no);
                    $("#satuank").val(suggestion.satuank);
                    $('#qty').val('1');
                    //set_total() ;

                    $("#jml").focus();
                },
                appendTo: '#auto-container'
            });

            /*$("#id_obat").change(function(){
                if ($('#id_obat').val() != ''){
                    $.ajax({
                        dataType: "html",
                        data: {id: $('#id_obat').val() },
                        type: "POST",
                        url: "<?php echo site_url(); ?>logistik_farmasi/Frmcamprah/get_satuan_obat",
                        success: function( response ) {
                            $('#satuank').val( response );
                        }
                    });
                    $('#jml').val('1');
                }
            });*/
            $("#exp_date").keyup(function(event){
                if(event.keyCode == 13){
                    $("#btnTambah").click();
                }
            });

            $( "#btnTambah" ).click(function() {
                table.row.add( [
                    $('#id_obat').val(),
                    $("#cari_obat").val(),
                    $('#satuank').val(),
                    $('#jml').val(),
                    $('#exp_date').val(),
                    $('#batch_no').val(),
                    '<center><button type="button" class="btnDel btn btn-primary btn-xs" title="Hapus">Hapus</button></center>'
                ] ).draw(false);
                //$id_obat.val("");
                $("#cari_obat").val('');
                $("#id_obat").val('');
                $('#satuank').val('');
                $('#jml').val('');
                $('#exp_date').val('');
                $('#batch_no').val('');
                $("#cari_obat").focus();
                populateDataObat();
            });
            $('#example tbody').on( 'click', 'button.btnDel', function () {
                table.row( $(this).parents('tr') ).remove().draw();
                populateDataObat();
            } );
            $( "#btnSimpan" ).click(function() {
                if (ndata == 0){

                    alert("Silahkan input data obat");
                    $('#id_obat').focus();

                }else if ($("#minggu").val() == ""){
                    alert("Minggu ke berapa pengajuan ini? Silahkan diisi...");
                    $('#minggu').focus();

                }else{
                    $( "#frmAdd" ).submit();
                }
            });
        });


        function populateDataObat(){
            vjson = table.rows().data();
            ndata = vjson.length;
            var vjson2= [[]];
            jQuery.each( vjson, function( i, val ) {
                vjson2[i] = {
                    "id_obat": vjson[i][0],
                    "satuank":vjson[i][2],
                    "qty_req":vjson[i][3],
                    "qty_acc":vjson[i][3],
                    "expire_date":vjson[i][4],
                    "batch_no":vjson[i][5]
                };
            });
            $('#dataobat').val( JSON.stringify(vjson2) );
        }
        function cetak(id){
            var win = window.open(baseurl+'download/logistik_farmasi/FA_'+id+'.pdf', '_blank');
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
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
                            </div>
                        </div>
                        <hr/>
                    </div>

                    <div class="box-body">
                        <?php echo form_open('logistik_farmasi/FrmCDistribusiLangsung/save',array('id'=>'frmAdd','method'=>'post')); ?>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">Minggu Ke - </p>
                                <div class="col-sm-3">
                                  <select name="minggu" id="minggu" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="1">1. Pertama</option>
                                    <option value="2">2. Kedua</option>
                                    <option value="3">3. Ketiga</option>
                                    <option value="4">4. Keempat</option>
                                    <option value="5">5. Kelima</option>
                                  </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">Tanggal Distribusi</p>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="tgl_amprah" id="tgl_amprah" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label" id="lidgudang">Gudang Asal</p>
                                <div class="col-sm-6">

                                    <select name="gd_asal" id="gd_asal" class="form-control js-example-basic-single" required>
                                        <?php
                                        foreach($select_gudang0 as $row){
                                            echo '<option value="'.$row->id_gudang.'">'.$row->nama_gudang.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-1"></div>
                                <p class="col-sm-3 form-control-label">Gudang Tujuan</p>
                                <div class="col-sm-6">
                                    <select name="vgd_dituju" id="vgd_dituju" class="form-control js-example-basic-single"  required>
                                        <option value="">-Pilih Gudang Tujuan-</option>
                                        <?php
                                        foreach($select_gudang1 as $row){
                                            echo '<option value="'.$row->id_gudang.'">'.$row->nama_gudang.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-default" id="btnUbah">Ubah Gudang</a>
                                </div>
                            </div>
                            <input type="hidden" id="user" name="user" value="<?php echo $user_info->username; ?>"/>
                            <input type="hidden" id="gd_dituju" name="gd_dituju"/>
                        </div>
                        <div class="modal-footer">
                            <div id="detailObat">
                                <br/>
                                <div class="form-group row">
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">Nama Obat</p>
                                        <div class="col-sm-5" id="auto-container">
                                            <input type="search" class="form-control" id="cari_obat" name="cari_obat" placeholder="Pencarian Obat">
                                            <input type="hidden" name="id_obat" id="id_obat">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">Satuan</p>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="satuank" id="satuank" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">Jumlah</p>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" name="jml" id="jml" min=1 >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">Batch No</p>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="batch_no" id="batch_no" placeholder="Wajib diisi dgn No Batch Existing" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label">Exp Date</p>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="exp_date" id="exp_date" placeholder="YYYY-mm-dd">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1"></div>
                                        <p class="col-sm-3 form-control-label"></p>
                                        <div class="col-sm-3">
                                            <a class="btn btn-primary" id="btnTambah">Tambahkan</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">

                                    </div>
                                </div>
                                <br/>
                                <table id="example" class="display" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID Obat</th>
                                        <th>Nama Obat</th>
                                        <th>Satuan</th>
                                        <th>Jumlah Diminta</th>
                                        <th>Exp Date</th>
                                        <th>No Batch</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                </table>
                                <br/><br/>
                            </div>
                            <input type="hidden" name="dataobat" id="dataobat">
                            <a type="button" class="btn btn-success" id="btnSimpan">Simpan</a>
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