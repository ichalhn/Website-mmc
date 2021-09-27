
         <div class="box-body">
        <div class="form-group row">
           <p class="col-sm-2 form-control-label" id="lidgudang">Pilihan Gudang</p>
             <div class="col-sm-3">
                <!--<select name="id_gudang" class="form-control js-example-basic-single" id="select_gudang">
                </select>-->				
				<select name="select_gudang" id="select_gudang" class="form-control select2">
					<option value="">-Pilih Gudang-</option>
					<?php 
					foreach($select_gudang as $row){
						echo '<option value="'.$row->id_gudang.'">'.$row->nama_gudang.'</option>';
					}
					?>
				</select>
             </div>
        </div>
          <table id="example" class="display" cellspacing="0" width="100%">
              <thead>
              <tr>
                <th>ID Amprah</th>
                <th>Tgl Permintaan</th>
                <th>Kepada</th>
                <th>Oleh</th>
                <th>Username</th>
                <th>No Faktur</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
              </thead>
            </table>
          <?php
            //echo $this->session->flashdata('message_nodata'); 
          ?>  
          </div>            