<div class="col-md-12">
    <div class="card">
        <div class="card-header"><h5 class="card-title"><?=$header ?></h5></div>
        <div class="card-body">
            <form id="formAct" >
                <div class="row">
                    <div class="col-md-12 mb-4 form-group">
                        <label for="">Pelayanan</label>
                        <select name="pelayanan" id="pelayanan" class="form-control" required>
                            <option selected disabled></option>
                            <?php if($record->num_rows() > 0 ){
                                foreach($record->result_array() as $rec){
                                    echo "<option value='".encode($rec['pelayanan_id'])."'>".$rec['pelayanan_name']."</option>";
                                }
                            }?>
                        </select>
                        
                    </div>
                    <div class="col-md-10 form-group"></div>
                    <div class="col-md-2 form-group">
                        <input type="number" class="form-control" id="tot" value="1">
                    </div>
                   
                    <div class="col-md-12 form-group mt-3">
                        <div class="row" id="thisForm">
                            <div class="col-md-12 form-group formSP">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="">Sub Pelayanan</label>
                                        <input type="text" name="subpelayanan[]" class="form-control"  placeholder="Nama Sub Pelayanan">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="">Link Sub Pelayanan</label>
                                        <input type="text" name="link[]" class="form-control"  placeholder="Link Sub Pelayanan">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 form-group mt-2">
                        <button class="btn btn-primary float-right">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>