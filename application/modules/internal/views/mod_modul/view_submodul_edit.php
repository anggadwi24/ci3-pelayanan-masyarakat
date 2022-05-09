<div class="col-sm-12">
    



<div class='card '>
                <div class='card-header py-3'>
                   <h6 class='text-primary'><?= $header?></h6>
                </div>
                <div class='card-block'>
           
                    <form action="<?= base_url('internal/submodul/update')?>" method="post">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="">Modul</label>
                            <select name="submodul_modul_id" required class="form-control select2" title="Pilih">
                                <option disabled  ></option>
                                <?php foreach($modul->result_array() as $mod){
                                        if($row['submodul_modul_id'] == $mod['modul_id']){
                                            echo "<option value='".encode($mod['modul_id'])."' selected>".$mod['modul_name']."</option>";

                                        }else{
                                            echo "<option value='".encode($mod['modul_id'])."'>".$mod['modul_name']."</option>";

                                        }   
                                    }?>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="">Submodul</label>
                            <input type="text" class="form-control" id="submodul_name" name="submodul_name" placeholder="Submodul" value="<?= $row['submodul_name']?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="">Link</label>
                            <input type="text" class="form-control" id="submodul_link" name="submodul_link" placeholder="Link" value="<?= $row['submodul_link']?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="">Tampil</label>
                            <select name="submodul_publish" id="submodul_publish" class="form-control " required >
                                <option value="y">Tampil</option>
                                <option value="n">Tidak Tampil</option>

                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="hidden" name="id" value="<?= encode($row['submodul_id'])?>">
                            <button class="btn btn-primary float-right">Simpan</button>
                        </div>
                    </div>
                </form>
        </div>

</div>
<script>
    $(document).ready(function(){
        $('#submodul_publish').val('<?= $row['submodul_publish']?>');
    });
</script>