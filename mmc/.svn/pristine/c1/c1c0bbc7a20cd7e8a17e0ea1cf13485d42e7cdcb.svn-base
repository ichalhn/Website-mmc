<?php
    $this->load->view('layout/header.php');
?>
<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function() {

        //datatables
        table = $('#table').DataTable({ 

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('medrec/chistoripasien/ajax_list')?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            },
            ],

        });

    });


    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax 
    }

</script>


<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body ">
                    <button class="btn btn-primary" onclick="reload_table()">Reload</button>
                    <br><br>

                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Register</th>
                                <th>Nomor CM</th>
                                <th>Nama</th>
                                <th>Data  Rawat</th>
                                <th>Tanggal Kunjungan</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>                        
                </div>
            </div>
        </div>
    </div>
</section>

<?php
	$this->load->view('layout/footer.php');
?>
                        