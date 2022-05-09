<div class="col-sm-12">
    



<div class='card '>
                <div class='card-header py-3'>
                   <h6 class='text-primary'><?= $header?></h6>
                </div>
                <div class='card-block'>
           
                    <form action="<?= base_url('internal/submodul/store')?>" method="post">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Modul</label>
                            <select name="modul" required class="form-control select2" title="Pilih">
                                <option disabled selected ></option>
                                <?php foreach($modul->result_array() as $mod){
                                        echo "<option value='".$this->encrypt->encode($mod['modul_id'],keys())."'>".$mod['modul_name']."</option>";
                                    }?>
                            </select>
                        
                        </div>
                        <div class="col-md-7"></div>
                        <div class="col-md-5 mt-4 form-inline">
                                <input type="number" name="tot" id="tot" value="1" class="form-control mr-2 w-50">
                                                    
                                <button type="submit" class="btn btn-primary w-25" id="sbmTot">TAMBAH</button>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="row" id="tampilInput"></div>
                                                    
                        </div>
                        
                        

                        <div class="col-md-12">  <button type='submit' name='submit' class='btn btn-primary float-right'>SIMPAN</button></div>

                    </div>
                </form>
        </div>

</div>