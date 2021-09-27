<?php $this->load->view("layout/header"); ?>

<script type="text/javascript">
  var table_irj;

  $(document).ready(function() {
 
    $(document).on("click",".delete_patient",function() {
      var getLink = $(this).attr('href');
      swal({
        title: "Hapus Klaim",
        text: "Yakin akan menghapus data pasien tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Hapus",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
           delete_patient(getLink);
      });
      return false;
    });

    $('#show_pasien').on('hidden.bs.modal', function () {
      document.getElementById("alert-modal-edit").innerHTML = '';
    });
    $('#add_claim').on('hidden.bs.modal', function () {
      document.getElementById("alert-modal-add").innerHTML = '';
    });  

    table_irj = $('#table-irj').DataTable({ 
      "processing": true,
      "serverSide": true,
      "order": [],
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
      "ajax": {
        "url": "<?php echo site_url('ina-cbg/irj/get_klaim')?>",
        "type": "POST",
        "data": function (data) {
          data.status_klaim = $('input[name="status_klaim"]:checked').val();
        }
      },
      "columnDefs": [{ 
        "orderable": false, //set not orderable
        "width": "20%",
        "render": function ( data, type, row ) {
          switch(data) {
              case 'klaim' : return '<p class="text-center"><button type="button" class="btn btn-sm btn-primary text-bold" style="margin-right:3px;" onclick="show_set_klaim(\''+row[6]+'\')"><small>Set</small></button><button type="button" class="btn btn-sm btn-success text-bold" style="margin-right:3px;" onclick="show_pasien(\''+row[6]+'\')"><small>Edit</small></button><a class="delete_patient btn btn-sm btn-danger text-bold" href="'+row[3]+'"><small>Hapus</small></a></p>'; break;
              case 'set_klaim' : return '<p class="text-center"><button type="button" class="btn btn-sm btn-primary text-bold" style="margin-right:3px;" onclick="show_set_klaim(\''+row[6]+'\')" disabled><small>Set</small></button><button type="button" class="btn btn-sm btn-success text-bold" style="margin-right:3px;" onclick="show_pasien(\''+row[6]+'\')"><small>Edit</small></button><a class="delete_patient btn btn-sm btn-danger text-bold" href="'+row[3]+'"><small>Hapus</small></a></p>'; break;              
              case 'grouping' : return '<center><button class="btn btn-sm btn-danger text-bold" onclick="send_grouping(\''+row[6]+'\',\''+row[8]+'\')">Grouping</button></center>'; break;     
              case 'finalisasi' : return '<center><button type="button" class="btn btn-sm btn-success text-bold" onclick="view_per_klaim(\''+row[6]+'\')"><i class="fa fa-check"></i> Sudah Finalisasi</button></center>'; break;                         
              default  : return '<center><button type="button" class="btn btn-sm btn-primary text-bold" onclick="add_claim(\''+row[6]+'\')"><i class="fa fa-id-card-o"></i> Buat Klaim</button></center>';
          }
        },
        "targets": 7 // column index 
      },{ "width": "18%", "targets": 4 },{ "width": "7%", "targets": 1 },{ "width": "7%", "targets": 0 }],
   
    });

    var rad = document.form_filter.status_klaim;
    var prev = null;
    for(var i = 0; i < rad.length; i++) {
        rad[i].onclick = function() {
        //(prev)? console.log(prev.value):null;
          if(this !== prev) {
              prev = this;
          }
          table_irj.ajax.reload();
        };
    }  
      
  });

  function add_claim(no_sep){
    $.ajax({
        type: "GET",
        url: "<?php echo base_url().'ina-cbg/irj/show_pasien/'; ?>"+no_sep,
        dataType: "JSON",
        success: function(data){
          $('#add_kartu').val(data.no_kartu);
          $('#add_sep').val(data.no_sep);
          $('#add_cm').val(data.no_cm);
          $('#add_nama').val(data.nama);
          $('#add_lahir').val(data.tgl_lahir);
          if (data.sex == 'L') {
            $('#add_laki.add_gender').prop('checked', true);
          } else {
            $('#add_perempuan.add_gender').prop('checked', true);
          }
          $('#add_claim').modal('show');
        },
        error:function(event, textStatus, errorThrown) {
            swal("Error","Load data tidak berhasil.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        },
        timeout: 0
    });
  }   

  function show_pasien(no_sep){
    $.ajax({
        type: "GET",
        url: "<?php echo base_url().'ina-cbg/irj/show_pasien/'; ?>"+no_sep,
        dataType: "JSON",
        success: function(data){
          $('#edit_kartu').val(data.no_kartu);
          $('#edit_sep').val(data.no_sep);
          $('#edit_cm').val(data.no_cm);
          $('#edit_nama').val(data.nama);
          $('#edit_lahir').val(data.tgl_lahir);
          if (data.sex == 'L') {
            $('#edit_laki.edit_gender').prop('checked', true);
          } else {
            $('#edit_perempuan.edit_gender').prop('checked', true);
          }          
          $('#show_pasien').modal('show');
        },
        error:function(event, textStatus, errorThrown) {
            swal("Error","Load data tidak berhasil.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        },
        timeout: 0
    });
  } 
  

  function show_set_klaim(no_sep){
    $.ajax({
        type: "GET",
        url: "<?php echo base_url().'ina-cbg/irj/show_setklaim/'; ?>"+no_sep,
        dataType: "json",
        success: function(data){
          var diags = [];
          var diagnosa;
          var procedures = [];
          var procedure;          
          if (data.diagnosa_utama == '') {
              diagnosa = 'Isi terlebih dahulu diagnosa utama';
          } else {
              diags.push(data.diagnosa_utama);
              if (data.diagnosa_utama == '' && data.diagnosa_tambahan == '') {
                diagnosa = ''; 
              } else if ((data.diagnosa_tambahan != '' && data.diagnosa_utama != '') || (data.diagnosa_tambahan == '' && data.diagnosa_utama != '')) {
                $.each(data.diagnosa_tambahan, function(i, item) {
                  diags.push(item);
                })          
                diagnosa = diags.join('#');                          
              }              
          }  

          if (data.procedure_utama == '') {
              procedure = 'Isi terlebih dahulu procedure utama';
          } else {
              procedures.push(data.procedure_utama);
              if (data.procedure_utama == '' && data.procedure_tambahan == '') {
                procedure = ''; 
              } else if ((data.procedure_tambahan != '' && data.procedure_utama != '') || (data.procedure_tambahan == '' && data.procedure_utama != '')) {
                $.each(data.procedure_tambahan, function(i, item) {
                  procedures.push(item);
                })          
                procedure = procedures.join('#');                          
              }              
          }                     
          $('#id_klaim').val(data.id_klaim);
          $('#set_nosep').val(data.no_sep);
          $('#set_nokartu').val(data.no_kartu);
          $('#set_tglmasuk').val(data.tgl_kunjungan);
          $('#set_tglpulang').val(data.tgl_kunjungan);
          $('#set_jnsrawat').val('2'); 
          $('#set_klsrawat').val('3');
          $('#adl_sub_acute').val('');
          $('#adl_chronic').val('');
          $('#icu_indikator').val('');

          $('#icu_los').val(''); // ?
          $('#ventilator_hour').val(''); // ?
          $('#upgrade_class_ind').val(''); // ?
          $('#upgrade_class_class').val(''); // ?
          $('#upgrade_class_los').val(''); // ?
          $('#add_payment_pct').val(''); // ? 
          $('#birth_weight').val(''); // ?
          $('#discharge_status').val(''); // ?
          $('#diagnosa').val(diagnosa);

          $('#procedure').val(procedure);
          $('#tarif_rs').val(''); // ?
          $('#tarif_poli_eks').val(''); // ?
          $('#nama_dokter').val(''); // ?
          $('#kode_tarif').val(''); // ?
          $('#payor_id').val(''); // ?
          $('#payor_cd').val(''); // ?
          $('#cob_cd').val(''); 

          $('#set_klaim').modal('show');
        },
        error:function(event, textStatus, errorThrown) {
            swal("Error","Load data tidak berhasil.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        },
        timeout: 0
    });
  }   

  function insert_klaim(){
    document.getElementById("submit-add-klaim").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'ina-cbg/irj/add_claim'; ?>",
        dataType: "JSON",
        data: $('#form_add').serialize(),
        success: function(data){        
          if (data == '') {
              document.getElementById("alert-modal-edit").innerHTML = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Koneksi dengan aplikasi INA-CBG gagal. Silahkan coba lagi.</div>';
              document.getElementById("submit-edit-klaim").innerHTML = 'Buat Klaim';
          } else if (data.metadata.code == '200') {
          $('#add_claim').modal('hide');  
          swal("Sukses", "Nomor SEP berhasil diklaim.", "success");
          table_irj.ajax.reload();
          document.getElementById("submit-add-klaim").innerHTML = 'Buat Klaim';
          } else {
              document.getElementById("alert-modal-add").innerHTML = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>'+data.metadata.message+'.</div>';
              document.getElementById("submit-add-klaim").innerHTML = 'Buat Klaim';
          }
        },
        error:function(event, textStatus, errorThrown) { 
            swal("Error","Klaim data gagal.", "error");       
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        },
        timeout: 0
    });
  }

  function update_patient(){
    document.getElementById("submit-edit-klaim").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'ina-cbg/irj/update_patient'; ?>",
        dataType: "JSON",
        data: $('#form_edit').serialize(),
        success: function(data){      
          if (data == '') {
              document.getElementById("alert-modal-edit").innerHTML = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Koneksi dengan aplikasi INA-CBG gagal. Silahkan coba lagi.</div>';
              document.getElementById("submit-edit-klaim").innerHTML = 'Simpan';
          } else if (data.metadata.code == '200') {
              $('#show_pasien').modal('hide');  
              swal("Sukses", "Data berhasil disimpan.", "success");
              document.getElementById("submit-edit-klaim").innerHTML = 'Simpan';
          } else {
              document.getElementById("alert-modal-edit").innerHTML = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>'+data.metadata.message+'.</div>';
              document.getElementById("submit-edit-klaim").innerHTML = 'Simpan';
          }
        },
        error:function(event, textStatus, errorThrown) {   
            swal("Error","Update data gagal.", "error");      
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        },
        timeout: 0
    });
  } 

  function delete_patient(nomor_rm){    
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'ina-cbg/irj/delete_patient'; ?>",
        dataType: "JSON",
        data: {'nomor_rm' : nomor_rm,'coder_nik' : '123123123123'},
        success: function(data){  
          if (data == '') {
              swal("Error", "Koneksi dengan aplikasi INA-CBG gagal. Silahkan coba lagi.", "error");
          } else if (data.metadata.code == '200') {
              swal("Sukses", "Data berhasil dihapus.", "success");
          } else {
              swal("Error", data.metadata.message, "error");
          }
        },
        error:function(event, textStatus, errorThrown) {    
            swal("Error","Gagal menghapus data.", "error");     
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        },
        timeout: 0
    });
  } 

  function set_klaim(){
    document.getElementById("submit-set-klaim").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'ina-cbg/irj/set_claim'; ?>",
        dataType: "JSON",
        data: $('#form_set_klaim').serialize(),
        success: function(data){      
          if (data == '') {
              document.getElementById("alert-modal-edit").innerHTML = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Koneksi dengan aplikasi INA-CBG gagal. Silahkan coba lagi.</div>';
              document.getElementById("submit-set-klaim").innerHTML = 'Set Klaim';
          } else if (data.metadata.code == '200') {
          $('#set_klaim').modal('hide');  
          swal("Sukses", "Set Data klaim berhasil.", "success");
          table_irj.ajax.reload();
          document.getElementById("submit-set-klaim").innerHTML = 'Set Klaim';
          } else {
              document.getElementById("alert-modal-set").innerHTML = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>'+data.metadata.message+'.</div>';
              document.getElementById("submit-set-klaim").innerHTML = 'Set Klaim';
          }
        },
        error:function(event, textStatus, errorThrown) {  
            swal("Error", "Set Data klaim gagal.", "error"); 
            document.getElementById("submit-set-klaim").innerHTML = 'Set Klaim';     
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        },
        timeout: 0
    });
  } 

  function send_grouping(nomor_sep,id_setklaim){             
      swal({
        title: "Grouping",
        text: "Grouping data klaim tersebut?",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Submit",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
              $.ajax({
                  type: "POST",
                  url: "<?php echo base_url().'ina-cbg/irj/grouper_stage1'; ?>",
                  dataType: "JSON",
                  data: {"nomor_sep" : nomor_sep,"id_setklaim" : id_setklaim},
                  success: function(data){
                    console.log(data);
                    // if (data == '') {
                    //     swal("Gagal","Koneksi dengan aplikasi INA-CBG gagal. Silahkan coba lagi.", "error");
                    // } else if (data.metadata.code == '200') { 
                    //     table_irj.ajax.reload();
                    //     swal("Sukses", "Data klaim berhasil digrouping.", "success");
                    // } else {
                    //     swal("Gagal",data.metadata.message, "error");
                    // }
                  },
                  error:function(event, textStatus, errorThrown) {   
                      swal("Error","Grouping data klaim gagal.", "error");     
                      console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                  },
                  timeout: 0
              });
      });
      return false;
  }   

  function finalisasi(nomor_sep,id_setklaim,coder_nik){             
      swal({
        title: "Finalisasi",
        text: "Finalisasi data klaim tersebut?",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Finalisasi",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
              $.ajax({
                  type: "POST",
                  url: "<?php echo base_url().'ina-cbg/irj/finalisasi'; ?>",
                  dataType: "JSON",
                  data: {"nomor_sep" : nomor_sep,"id_setklaim" : id_setklaim,"coder_nik" : '123123123123'},
                  success: function(data){
                    if (data == '') {
                        swal("Gagal","Koneksi dengan aplikasi INA-CBG gagal. Silahkan coba lagi.", "error");
                    } else if (data.metadata.code == '200') { 
                        table_irj.ajax.reload();
                        swal("Sukses", "Data berhasil difinalisasi.", "success");
                    } else {
                        swal("Gagal",data.metadata.message, "error");
                    }
                  },
                  error:function(event, textStatus, errorThrown) {   
                      swal("Error","Proses finalisasi gagal.", "error");     
                      console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                  },
                  timeout: 0
              });
      });
      return false;
  }   

</script>

<div>
  <div>
    <!-- Main content -->
    <section class="content">
      <div class="row">    
        <div class="col-md-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
             <form id="form-filter" class="form-horizontal" name="form_filter">
              <!-- radio -->
              <div class="form-group col-sm-6">
                <label style="margin-right: 10px;">
                  <input type="radio" name="status_klaim" class="minimal-red" value="1" checked>
                  Klaim Pasien
                </label>
                <label style="margin-right: 10px;">
                  <input type="radio" name="status_klaim" class="minimal-red" value="2">
                  Set Data Klaim
                </label>
                <label>
                  <input type="radio" name="status_klaim" class="minimal-red" value="3">
                  Grouping & Finalisasi
                </label>                
              </div>  
              </form> 
              <div class="table-responsive col-sm-12">         
              <table id="table-irj" class="table table-bordered table-hover" width="100%">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Poli</th>
                  <th>Tgl. Kunjungan</th>
                  <th>No. CM</th>
                  <th>Nama</th>
                  <th>No. Kartu</th>
                  <th>No. SEP</th>
                  <th class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>
                
                </tbody>
              </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->     
    </section>
    <!-- /.content -->
    
  </div>
</div>

  <div class="modal modal-primary fade" id="add_claim" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="add_claim">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Membuat Klaim Baru</h4>
          </div>
          <div class="modal-body">       
            <form class="form-horizontal" id="form_add">         
              <div class="box-body">
                <div id="alert-modal-add"></div>                 
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">No. Kartu</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="add_kartu" name="no_kartu">
                    </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">No. SEP</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="add_sep" name="no_sep">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">No. RM</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="add_cm" name="no_rm">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Nama Pasien</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="add_nama" name="nama">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Tgl. Lahir</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="add_lahir" name="tgl_lahir" name="tgl_lahir">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Gender</label>
                  <div class="col-sm-10">
                    <label class="control-label" style="margin-right: 10px;">
                    <input type="radio" name="gender" class="minimal-red add_gender" id="add_laki" value="1"> Laki-laki
                    </label>
                    <label class="control-label">
                    <input type="radio" name="gender" class="minimal-red add_gender" id="add_perempuan" value="2"> Perempuan
                    </label>
                  </div>
                </div>                                                                

              </div>  <!-- /.box-body -->
            </form>
          </div>  <!-- modal-body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-outline" id="submit-add-klaim" onclick="insert_klaim()">Buat Klaim</button>
          </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <div class="modal modal-success fade" id="show_pasien" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="show_pasien">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="">Edit Data Pasien</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" id="form_edit">
            <div class="box-body">
              <div id="alert-modal-edit"></div>              
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">No. Kartu</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="edit_kartu" name="edit_kartu">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">No. SEP</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="edit_sep" name="edit_sep">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">No. CM</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="edit_cm" name="edit_cm">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Nama Pasien</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="edit_nama" name="edit_nama">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Tgl. Lahir</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="edit_lahir" name="edit_tgllahir">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Gender</label>
                  <div class="col-sm-10">
                    <label class="control-label" style="margin-right: 10px;">
                    <input type="radio" name="edit_gender" class="minimal-red edit_gender" id="edit_laki" value="1" checked> Laki-laki
                    </label>
                    <label class="control-label">
                    <input type="radio" name="edit_gender" class="minimal-red edit_gender" id="edit_perempuan" value="2"> Perempuan
                    </label>
                  </div>
                </div>                                                                
            </div><!-- /.box-body -->
          </form>
        </div> <!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-outline" id="submit-edit-klaim" onclick="update_patient()">Simpan</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <div class="modal modal-primary fade" id="set_klaim" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="set_klaim">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Set/Update Klaim</h4>
        </div>
        <div class="modal-body">
          <form id="form_set_klaim">
            <input type="hidden" id="id_klaim" name="id_klaim">
            <div class="box-body">
              <div id="alert-modal-set"></div>  
          <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                  <label for="set_nosep">No. SEP</label>
                    <input type="text" class="form-control" id="set_nosep" name="set_nosep">
                </div>
                <div class="form-group">
                  <label for="set_nokartu">No. Kartu</label>
                    <input type="text" class="form-control" id="set_nokartu" name="set_nokartu">
                </div>
                <div class="form-group">
                <label>Tanggal Masuk</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="set_tglmasuk" name="set_tglmasuk">
                </div>
                <!-- /.input group -->
              </div>
                <div class="form-group">
                <label>Tanggal Pulang</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="set_tglpulang" name="set_tglpulang">
                </div>
                <!-- /.input group -->
              </div>
                <div class="form-group">
                  <label for="set_jnsrawat">Jenis Rawat</label>
                    <input type="text" class="form-control" id="set_jnsrawat" name="set_jnsrawat">
                </div>  
                <div class="form-group">
                  <label for="set_klsrawat">Kelas Rawat</label>
                    <input type="text" class="form-control" id="set_klsrawat" name="set_klsrawat">
                </div>
                <div class="form-group">
                  <label for="adl_sub_acute">adl sub acute</label>
                    <input type="text" class="form-control" id="adl_sub_acute" name="adl_sub_acute">
                </div>
                <div class="form-group">
                  <label for="adl_chronic">adl chronic</label>
                    <input type="text" class="form-control" id="adl_chronic" name="adl_chronic">
                </div>
                <div class="form-group">
                  <label for="icu_indikator">icu indikator</label>
                    <input type="text" class="form-control" id="icu_indikator" name="icu_indikator">
                </div>                
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-4">
                <div class="form-group">
                  <label for="icu_los">icu los</label>
                    <input type="text" class="form-control" id="icu_los" name="icu_los">
                </div>       
                <div class="form-group">
                  <label for="ventilator_hour">Ventilator Hour</label>
                    <input type="text" class="form-control" id="ventilator_hour" name="ventilator_hour">
                </div>
                <div class="form-group">
                  <label for="upgrade_class_ind">Upgrade Class Ind</label>
                    <input type="text" class="form-control" id="upgrade_class_ind" name="upgrade_class_ind">
                </div>
                <div class="form-group">
                  <label for="upgrade_class_class">Upgared Class Class</label>
                    <input type="text" class="form-control" id="upgrade_class_class" name="upgrade_class_class">
                </div>            
                <div class="form-group">
                  <label for="upgrade_class_los">Upgrade Class Los</label>
                    <input type="text" class="form-control" id="upgrade_class_los" name="upgrade_class_los">
                </div>
                <div class="form-group">
                  <label for="add_payment_pct">Add Payment Pct</label>
                    <input type="text" class="form-control" id="add_payment_pct" name="add_payment_pct">
                </div>              
                <div class="form-group">
                  <label for="birth_weight">Birth Weight</label>
                    <input type="text" class="form-control" id="birth_weight" name="birth_weight">
                </div>
                <div class="form-group">
                  <label for="discharge_status">Discharge Status</label>
                    <input type="text" class="form-control" id="discharge_status" name="discharge_status">
                </div>
                <div class="form-group">
                  <label for="diagnosa">Diagnosa</label>
                    <input type="text" class="form-control" id="diagnosa" name="diagnosa">
                </div> 
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-4">
                <div class="form-group">
                  <label for="procedure">Procedure</label>
                    <input type="text" class="form-control" id="procedure" name="procedure">
                </div>
                <div class="form-group">
                  <label for="tarif_rs">Tarif RS</label>
                    <input type="text" class="form-control" id="tarif_rs" name="tarif_rs">
                </div> 
                <div class="form-group">
                  <label for="tarif_poli_eks">Tarif Poli Eks</label>
                    <input type="text" class="form-control" id="tarif_poli_eks" name="tarif_poli_eks">
                </div> 
                <div class="form-group">
                  <label for="nama_dokter">Nama Dokter</label>
                    <input type="text" class="form-control" id="nama_dokter" name="nama_dokter">
                </div> 
                <div class="form-group">
                  <label for="kode_tarif">Kode Tarif</label>
                    <input type="text" class="form-control" id="kode_tarif" name="kode_tarif">
                </div> 
                <div class="form-group">
                  <label for="payor_id">Payor Id</label>
                    <input type="text" class="form-control" id="payor_id" name="payor_id">
                </div> 
                <div class="form-group">
                  <label for="payor_cd">Payor Cd</label>
                    <input type="text" class="form-control" id="payor_cd" name="payor_cd">
                </div> 
                <div class="form-group">
                  <label for="cob_cd">COB Cd</label>
                  <input type="text" class="form-control" id="cob_cd" name="cob_cd">
                </div> 
                <input type="hidden" class="form-control" id="coder_nik" name="coder_nik" value="123123123123">
              <!-- /.form-group -->
            </div>
            <!-- /.col -->            
          </div>
          <!-- /.row -->                                                                                                                
            </div><!-- /.box-body -->
          </form>
        </div> <!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-outline" id="submit-set-klaim" onclick="set_klaim()">Set Klaim</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->  

<?php $this->load->view("layout/footer"); ?>
