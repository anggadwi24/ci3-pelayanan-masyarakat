<div class="col-sm-12">
    <div class="card">
        <div class="card-header"><h5 class="card-title"><?= $header ?></h5></div>
        <div class="card-block">
            <form action="<?= base_url('internal/subpelayanan/update') ?>" method="POST">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="">Pelayanan</label>
                        <select name="pelayanan" id="pelayanan" class="form-control" required>
                            <option selected disabled></option>
                            <?php if($record->num_rows() > 0 ){
                                foreach($record->result_array() as $rec){
                                    if($row['subpel_pelayanan_id'] == $rec['pelayanan_id']){
                                        echo "<option value='".encode($rec['pelayanan_id'])."' selected>".$rec['pelayanan_name']."</option>";

                                    }else{
                                        echo "<option value='".encode($rec['pelayanan_id'])."'>".$rec['pelayanan_name']."</option>";

                                    }
                                }
                            }?>
                        </select>
                        
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="">Sub Pelayanan</label>
                        <input type="text" name="subpelayanan" class="form-control" required value="<?= $row['subpel_name'] ?>" placeholder="Nama Sub Pelayanan">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="">Link Sub Pelayanan</label>
                        <input type="text" name="link" class="form-control" required value="<?= $row['subpel_link'] ?>" placeholder="Link Sub Pelayanan">
                    </div>
                    <div class="col-md-12 form-group">
                        <input type="hidden" value="<?= encode($row['subpel_id'])?>" name="id">
                        <button class="btn btn-primary float-right">Simpan</button>
                    </div>
                </div>

            </form>
            
        </div>
    </div>
</div>