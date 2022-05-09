
<div class="col-12">
    <div class="card">
        <div class="card-header"><h5 class="card-title"><?=$header ?></h5></div>
        <div class="card-block">
            <form id="formAct">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="">Judul Berita</label>
                        <input type="text" name="judul_berita" class="form-control" required>
                    </div>
                    <div class="col-sm-12 form-group">
                        <label for="">Isi Berita</label>
                        <textarea name="isi_berita" id="editor" class="form-control"  style="height:80px;"></textarea>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="">Category</label>
                        <select class="js-example-basic-multiple col-sm-12" multiple="multiple" name="category[]" >
                            <?php foreach($category->result_array() as $catt){?>
                            <option value="<?=$catt['cat_id']?>"><?=$catt['cat_category']?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="">Tags</label>
                        <select class="js-example-tokenizer col-sm-12" multiple="multiple" name="tags[]">
                            <?php foreach($tags->result_array() as $tag){?>
                            <option value="<?=$tag['tag_seo']?>"><?=$tag['tag_name']?></option>
                            <?php }?>
                                                   
                        </select>                      
                    </div>
                    <div class="col-sm-12 mt-4  form-group">
                       
                            <div class="switch d-inline m-r-10">
                                <input type="checkbox" id="switch-1" name="publish" checked>
                                <label for="switch-1" class="cr"></label>
                            </div>
                            <label>Publish</label>
                            
                        
                        
                                                    
                    </div>
                    <div class="col-sm-12 form-group" id="formPublish">
                        <label for="">Publish On</label>
                        <input type="text" name="publish_on" class="form-control datepicker" id="date-format" value="<?= date('Y-m-d H:i')?>"  >
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="">Foto Header</label>
                        <input type="file" name="file" class="form-control"  accept="image/png,image/jpg,image/jpeg" onchange="loadFile(event)" >
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="">Foto Detail</label>
                         
                        <input name="files[]" id="files" type="file" multiple accept="image/png,image/jpg,image/jpeg" class="form-control" />
                                               
                    </div>
                    
                    <div class="col-md-6 form-group">
                        <div class="row" >
                            <div class="col-md-12">
                                <img src="" id="filePath" class="img-fluid" srcset="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                            <div class="row" id="fileBase"></div>
                    </div>
                    <div class="col-md-12 form-group">
                        <button class="btn btn-primary float-right">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>


var loadFile = function(event) {
    var output = document.getElementById('filePath');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };

</script>